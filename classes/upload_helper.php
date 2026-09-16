<?php
    /*
     * 文件上传安全校验
     * @author Jason Liu
     */

    /**
     * 校验登录状态与权限，未通过则直接输出 JSON 并退出
     */
    function upload_require_auth($right_key = null) {
        session_save_path(dirname(__DIR__) . '/session/');
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] != 2) {
            upload_json_response(array('code' => 403, 'msg' => '您暂无权限操作！'));
        }
        if ($right_key !== null) {
            include dirname(__DIR__) . '/config/conn.php';
            include __DIR__ . '/check_rights.php';
            if (!isset($item[$right_key]) || $item[$right_key] == 0) {
                upload_json_response(array('code' => 403, 'msg' => '您暂无权限操作！'));
            }
        }
    }

    function upload_json_response($data) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * 获取站点根 URL，用于拼接上传文件的访问地址
     */
    function upload_site_url() {
        if (empty($GLOBALS['site_url'])) {
            include dirname(__DIR__) . '/config/config.php';
        }
        return rtrim($GLOBALS['site_url'], '/');
    }

    /**
     * 校验并保存图片上传
     * @return array|false 成功返回 url/href/src 等信息，失败返回 false
     */
    function upload_save_image($file, $subdir) {
        if (!isset($file) || !is_array($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return false;
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        if ($file['size'] <= 0 || $file['size'] > 2 * 1024 * 1024) {
            return false;
        }

        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp');
        $original_name = basename($file['name']);
        $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_ext, true)) {
            return false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        $allowed_mime = array(
            'image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'image/x-ms-bmp'
        );
        if (!in_array($mime, $allowed_mime, true)) {
            return false;
        }

        $image_info = @getimagesize($file['tmp_name']);
        if ($image_info === false) {
            return false;
        }

        $upload_root = dirname(__DIR__) . '/upload/' . trim($subdir, '/') . '/';
        if (!is_dir($upload_root)) {
            mkdir($upload_root, 0755, true);
        }

        $safe_name = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $absolute_path = $upload_root . $safe_name;
        $relative_path = '../../upload/' . trim($subdir, '/') . '/' . $safe_name;

        if (!move_uploaded_file($file['tmp_name'], $absolute_path)) {
            return false;
        }

        $public_path = 'upload/' . trim($subdir, '/') . '/' . $safe_name;
        return array(
            'filepath' => $relative_path,
            'src' => $public_path,
            'href' => upload_site_url() . '/' . $public_path,
        );
    }

    /**
     * 校验并保存 Excel 上传
     * @return array|false
     */
    function upload_save_excel($file) {
        if (!isset($file) || !is_array($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        if ($file['size'] <= 0 || $file['size'] > 10 * 1024 * 1024) {
            return false;
        }

        $allowed_ext = array('xls', 'xlsx', 'csv');
        $original_name = basename($file['name']);
        $ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_ext, true)) {
            return false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        $allowed_mime = array(
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/csv',
            'text/plain',
            'application/csv',
            'application/octet-stream'
        );
        if (!in_array($mime, $allowed_mime, true)) {
            if ($ext === 'xlsx' && $mime === 'application/zip') {
                // 部分环境下 xlsx 会被识别为 zip
            } else {
                return false;
            }
        }

        $upload_root = dirname(__DIR__) . '/upload/excel/';
        if (!is_dir($upload_root)) {
            mkdir($upload_root, 0755, true);
        }

        $safe_name = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $absolute_path = $upload_root . $safe_name;
        $relative_path = '../upload/excel/' . $safe_name;

        if (!move_uploaded_file($file['tmp_name'], $absolute_path)) {
            return false;
        }

        return array(
            'absolute_path' => $absolute_path,
            'relative_path' => $relative_path,
        );
    }
