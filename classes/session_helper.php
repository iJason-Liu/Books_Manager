<?php
    /*
     * Session 辅助函数（兼容 PHP 8.3）
     * @author Jason Liu
     */

    if (!function_exists('session_safe_start')) {
        function session_safe_start() {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }
    }

    if (!function_exists('session_value')) {
        function session_value($key, $default = '') {
            return $_SESSION[$key] ?? $default;
        }
    }

    if (!function_exists('session_is_login')) {
        function session_is_login() {
            return isset($_SESSION['is_login']) && $_SESSION['is_login'] == 2;
        }
    }
