#!/usr/bin/env bash
#
# Books_Manager 线上安全排查脚本
# 用法:
#   bash scripts/security_audit.sh                          # 默认扫描当前目录
#   bash scripts/security_audit.sh /www/wwwroot/lib.crayon.vip
#   bash scripts/security_audit.sh /path/to/site --days 7   # 仅看近 7 天变更
#   bash scripts/security_audit.sh /path/to/site --remove   # 交互式删除已知后门（谨慎）
#
set -euo pipefail

SITE_ROOT="${1:-$(cd "$(dirname "$0")/.." && pwd)}"
MODE="audit"
DAYS=30

shift || true
while [[ $# -gt 0 ]]; do
    case "$1" in
        --days)   DAYS="$2"; shift 2 ;;
        --remove) MODE="remove"; shift ;;
        *) echo "未知参数: $1"; exit 1 ;;
    esac
done

REPORT_DIR="${SITE_ROOT}/scripts/security_reports"
TIMESTAMP="$(date '+%Y%m%d_%H%M%S')"
REPORT_FILE="${REPORT_DIR}/audit_${TIMESTAMP}.log"

RED='\033[0;31m'
YEL='\033[0;33m'
GRN='\033[0;32m'
NC='\033[0m'

log()  { echo -e "$1" | tee -a "$REPORT_FILE"; }
warn() { log "${YEL}[WARN]${NC} $1"; }
crit() { log "${RED}[CRIT]${NC} $1"; }
ok()   { log "${GRN}[ OK ]${NC} $1"; }

mkdir -p "$REPORT_DIR"

log "=========================================="
log " Books_Manager 安全排查"
log " 站点目录: ${SITE_ROOT}"
log " 报告文件: ${REPORT_FILE}"
log " 时间: $(date '+%Y-%m-%d %H:%M:%S')"
log "=========================================="
log ""

if [[ ! -d "$SITE_ROOT" ]]; then
    crit "站点目录不存在: $SITE_ROOT"
    exit 1
fi

cd "$SITE_ROOT"

# ---------- 1. 已知后门文件名 ----------
log ">>> [1] 扫描已知可疑文件名"
SUSPICIOUS_NAMES=(
    "wp-includes.php"
    "wp-config.php.bak"
    "shell.php"
    "cmd.php"
    "c99.php"
    "r57.php"
    "b374k.php"
    "webshell.php"
    "x.php"
    "1.php"
    "a.php"
    ".user.ini"
)

found_names=0
for name in "${SUSPICIOUS_NAMES[@]}"; do
    while IFS= read -r -d '' f; do
        crit "可疑文件名: $f"
        found_names=$((found_names + 1))
    done < <(find "$SITE_ROOT" -name "$name" -print0 2>/dev/null)
done
[[ $found_names -eq 0 ]] && ok "未发现常见后门文件名"

# ---------- 2. upload 目录中的脚本 ----------
log ""
log ">>> [2] 检查 upload/ 目录是否含可执行脚本"
upload_scripts=0
while IFS= read -r -d '' f; do
    crit "upload 目录发现脚本: $f"
    upload_scripts=$((upload_scripts + 1))
done < <(find "$SITE_ROOT/upload" -type f \( \
    -name "*.php" -o -name "*.phtml" -o -name "*.php3" -o -name "*.php4" -o -name "*.php5" -o -name "*.phar" \
    \) -print0 2>/dev/null)
[[ $upload_scripts -eq 0 ]] && ok "upload/ 目录未发现 PHP 脚本"

# ---------- 3. WebShell 特征码 ----------
log ""
log ">>> [3] 扫描 WebShell 特征（排除 vendor 插件大目录）"
PATTERNS=(
    'FTPSH_OK'
    '\$_REQUEST\s*\[\s*['\''"]cmd['\''"]\s*\]'
    'eval\s*\(\s*\$_'
    'assert\s*\(\s*\$_'
    'base64_decode\s*\(\s*\$_'
    'shell_exec\s*\('
    'passthru\s*\('
    'system\s*\(\s*\$_'
    'popen\s*\(\s*\$_'
    'proc_open\s*\('
    'phpinfo\s*\(\s*\)'
)

scan_dirs=(
    "$SITE_ROOT"
)
exclude_args=(
    --exclude-dir=plugins/phpexcel
    --exclude-dir=plugins/phpqrcode/bindings
    --exclude-dir=skin
    --exclude-dir=.git
    --exclude-dir=scripts/security_reports
)

pattern_hits=0
for pattern in "${PATTERNS[@]}"; do
    while IFS= read -r line; do
        [[ -z "$line" ]] && continue
        crit "特征 [$pattern] => $line"
        pattern_hits=$((pattern_hits + 1))
    done < <(grep -RIn "${exclude_args[@]}" --include="*.php" -E "$pattern" "$SITE_ROOT" 2>/dev/null | \
        grep -v "security_audit.sh" || true)
done
[[ $pattern_hits -eq 0 ]] && ok "业务目录未发现典型 WebShell 特征"

# ---------- 4. 近期变更的 PHP 文件 ----------
log ""
log ">>> [4] 近 ${DAYS} 天内修改过的 PHP 文件"
recent_count=0
while IFS= read -r f; do
    warn "近期变更: $f ($(stat -f '%Sm' -t '%Y-%m-%d %H:%M' "$f" 2>/dev/null || stat -c '%y' "$f" 2>/dev/null | cut -d'.' -f1))"
    recent_count=$((recent_count + 1))
done < <(find "$SITE_ROOT" -name "*.php" -mtime "-${DAYS}" \
    ! -path "*/plugins/phpexcel/*" \
    ! -path "*/scripts/security_reports/*" \
    2>/dev/null | head -50)
[[ $recent_count -eq 0 ]] && ok "近 ${DAYS} 天无异常 PHP 变更（或 find 权限不足）"

# ---------- 5. 敏感目录 Web 暴露 ----------
log ""
log ">>> [5] 检查敏感路径是否可被 Web 直接访问（需 Nginx/Apache 配合）"
SENSITIVE_PATHS=(
    "config/config.php"
    "session"
    "library.sql"
    ".git"
    "plugins/phpqrcode/index.php"
)
for p in "${SENSITIVE_PATHS[@]}"; do
    if [[ -e "$SITE_ROOT/$p" ]]; then
        warn "存在敏感路径，请确认 Web 不可直接访问: /$p"
    fi
done

# ---------- 6. 上传接口加固检查 ----------
log ""
log ">>> [6] 检查上传接口是否已加固"
check_file() {
    local f="$1"
    local key="$2"
    if [[ -f "$f" ]] && grep -q "$key" "$f" 2>/dev/null; then
        ok "已加固: $f"
    else
        crit "未加固或缺少校验: $f"
    fi
}
check_file "$SITE_ROOT/classes/upload_helper.php" "upload_save_image"
check_file "$SITE_ROOT/controllers/books_center/upload_bookCover.php" "upload_require_auth"
check_file "$SITE_ROOT/controllers/comment/upload_cover.php" "upload_require_auth"
check_file "$SITE_ROOT/controllers/comment/upload_img.php" "upload_require_auth"
check_file "$SITE_ROOT/classes/import_Excel.php" "upload_save_excel"
check_file "$SITE_ROOT/upload/.htaccess" "php_flag engine off"

# ---------- 7. 访问日志快速检索（可选） ----------
log ""
log ">>> [7] Nginx 访问日志检索（如存在）"
LOG_CANDIDATES=(
    "/www/wwwlogs/lib.crayon.vip.log"
    "/var/log/nginx/access.log"
    "/www/server/nginx/logs/access.log"
)
for logfile in "${LOG_CANDIDATES[@]}"; do
    if [[ -f "$logfile" && -r "$logfile" ]]; then
        ok "发现日志: $logfile"
        log "    --- 上传接口访问记录（最近 20 条）---"
        grep -E "upload_bookCover|upload_cover|upload_img|import_Excel|wp-includes|\.php\?cmd=" "$logfile" 2>/dev/null | tail -20 | tee -a "$REPORT_FILE" || log "    （无匹配）"
        break
    fi
done

# ---------- 8. 交互式清理 ----------
log ""
log ">>> [8] 清理建议"
if [[ "$MODE" == "remove" ]]; then
    crit "即将进入交互式删除模式，仅删除 upload/ 内 PHP 及根目录 wp-includes.php"
    read -r -p "确认继续? [y/N] " ans
    if [[ "$ans" == "y" || "$ans" == "Y" ]]; then
        while IFS= read -r -d '' f; do
            echo "删除: $f"
            rm -f "$f"
        done < <(find "$SITE_ROOT/upload" -type f \( -name "*.php" -o -name "*.phtml" -o -name "*.phar" \) -print0 2>/dev/null)
        for name in wp-includes.php shell.php cmd.php; do
            find "$SITE_ROOT" -maxdepth 3 -name "$name" -exec rm -fv {} \; 2>/dev/null || true
        done
        ok "清理完成，请重新运行本脚本验证"
    else
        warn "已取消清理"
    fi
else
    log "如需自动清理 upload/ 内 PHP 脚本，执行:"
    log "  bash scripts/security_audit.sh ${SITE_ROOT} --remove"
fi

log ""
log "=========================================="
log " 排查完成。请将报告提供给运维/开发进一步分析。"
log "=========================================="
