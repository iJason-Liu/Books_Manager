<?php
    session_save_path(__DIR__ . '/../../session/');
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/../../config/conn.php';
    $db_connect = get_db_connect();

    if (!function_exists('circulation_reader_sql')) {
        function circulation_reader_sql($usertype, $id) {
            if ($usertype == '学生') {
                return "select * from student where cardNo = '$id'";
            }
            if ($usertype == '教师') {
                return "select * from teacher where cardNo = '$id'";
            }
            if ($usertype == '图书管理员') {
                return "select * from lib_worker where id = '$id'";
            }
            if ($usertype == '超级管理员') {
                return "select * from super_admin where id = '$id'";
            }
            if ($usertype != '') {
                return "select * from other_user where id = '$id'";
            }
            return '';
        }
    }

    if (!function_exists('circulation_fetch_reader')) {
        function circulation_fetch_reader($db_connect, $usertype, $id) {
            $sql = circulation_reader_sql($usertype, $id);
            if ($sql === '') {
                return null;
            }
            $res = mysqli_query($db_connect, $sql);
            if (!$res) {
                return null;
            }
            $row = mysqli_fetch_array($res);
            return is_array($row) ? $row : null;
        }
    }
