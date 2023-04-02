<?php
    /*
     * session有效时间
     */
    if(isset($_SESSION['expiretime'])) {
        if($_SESSION['expiretime'] < time()) {
            unset($_SESSION['expiretime']);
            echo "<script>alert('会话已超时，请重新登录！');location.href='../login/logout.php'</script>"; //登出
            //header('Location: ../login/logout.php?TIMEOUT'); // 登出
            exit(0);
        } else {
            $_SESSION['expiretime'] = time() + 7200; // 刷新时间戳，增加2小时 7200  1小时 3600  3小时 10800
        }
    }