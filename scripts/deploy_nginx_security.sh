#!/usr/bin/env bash
#
# 宝塔 Nginx 安全配置指引（直接粘贴，不用 include）
# 用法: bash scripts/deploy_nginx_security.sh
#
set -euo pipefail

SITE_ROOT="$(cd "$(dirname "$0")/.." && pwd)"
NGINX_REF="${SITE_ROOT}/nginx.htaccess"

echo "站点目录: ${SITE_ROOT}"
echo ""
echo "=== 宝塔配置步骤（无需 include 外部 conf）==="
echo ""
echo "1. 打开：宝塔 → 网站 → lib.crayon.vip → 设置 → 配置文件"
echo ""
echo "2. 打开项目中的 nginx.htaccess，复制「安全规则」整段"
echo "   文件路径: ${NGINX_REF}"
echo ""
echo "3. 粘贴到 server { } 内（root 指令下方即可）"
echo "   若已有 location ~ \.php\$，合并 upload 拦截规则，避免重复定义"
echo ""
echo "4. 确认 fastcgi_pass 与 PHP 版本一致（当前建议 PHP 8.3）："
echo "   fastcgi_pass unix:/tmp/php-cgi-83.sock;"
echo ""
echo "5. 保存后测试并重载："
echo "   nginx -t && nginx -s reload"
echo ""
echo "6. 验证："
echo "   curl -I https://lib.crayon.vip/config/config.php    # 期望 403"
echo "   curl -I https://lib.crayon.vip/upload/bookCover/x.php # 期望 403"
echo ""
