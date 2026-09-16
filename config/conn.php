<?php
    /*
     * 连接数据库
     */
    if (!function_exists('get_db_connect')) {
        function get_db_connect() {
            static $db_connect = null;
            if ($db_connect instanceof mysqli) {
                if (@mysqli_ping($db_connect)) {
                    return $db_connect;
                }
                $db_connect = null;
            }
            mysqli_report(MYSQLI_REPORT_OFF);
            require __DIR__ . '/config.php';
            $db_connect = mysqli_connect($servername, $dbusername, $dbpassword);
            if (!$db_connect) {
                die('数据库服务连接失败！');
            }
            if (!mysqli_select_db($db_connect, $dbname)) {
                die('数据库选择失败！');
            }
            mysqli_query($db_connect, "SET NAMES 'UTF8'");
            return $db_connect;
        }
    }

    if (!isset($db_connect)) {
        $db_connect = get_db_connect();
    }
