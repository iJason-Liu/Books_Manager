<?php
    /*
     * @brief  获取客户端ip地址
     * 当服务器在内网时获取的就是内网ip
     * 服务器在外网获取的则是外网ip，公网
     *
     * 获取客户端浏览的上一个页面的url地址：$_SERVER['HTTP_REFERER'];
     * 获取用户登录时的时间戳：$_SERVER['REQUEST_TIME'];
     */
    $realip = null;
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipArray = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach($ipArray as $rs) {
            $rs = trim($rs);
            if($rs != 'unknown') {
                $realip = $rs;
                break;
            }
        }
    } else if(isset($_SERVER['HTTP_CLIENT_IP'])) {
        $realip = $_SERVER['HTTP_CLIENT_IP'];
    } else {
        $realip = $_SERVER['REMOTE_ADDR'];
    }

    preg_match("/[\d\.]{7,15}/", $realip, $match);
    $realip = !empty($match[0]) ? $match[0] : '0.0.0.0';
    // echo $realip;
    return $realip;

