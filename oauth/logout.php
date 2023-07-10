<?php
    //用户退出登录，注销session
    //1、开启session
    session_start();
    
    //2、清空session信息
    $_SESSION = array();
    
    //3、清除客户端sessionid
    if(isset($_COOKIE[session_name()])){
        setCookie(session_name(),'',time()-3600,'/');
    }

    //4、彻底销毁session
    session_destroy();

    header('content-type:text/html;charset=uft-8');
    //5、重定向页面
    header('location:../oauth/login');
