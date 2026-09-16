<?php
    /*
     * 数据库基本配置
     */
    /********** 访问IP **********/
    $servername = 'localhost';
    /********** 数据库用户名 **********/
    $dbusername = 'root';
    /********** 数据库密码 **********/
    $dbpassword = 'root';
    /********** 数据库名 **********/
    $dbname = 'library';
    /********** 站点访问地址（用于拼接上传文件 URL） **********/
    $site_url = 'https://lib.crayon.vip';
    /********** 调试模式：生产环境请设为 false **********/
    $app_debug = false;

    if (php_sapi_name() !== 'cli') {
        if (empty($app_debug)) {
            ini_set('display_errors', '0');
            ini_set('display_startup_errors', '0');
        }
        error_reporting(E_ALL);
        ini_set('log_errors', '1');
    }
