<?php
    include "config.php";
    $db_connect=mysqli_connect($servername,$dbusername,$dbpassword) or die('数据库服务连接失败！');
    mysqli_select_db($db_connect,$dbname);
    mysqli_query($db_connect,"SET NAMES 'UTF8'");
?>