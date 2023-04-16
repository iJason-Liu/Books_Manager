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


    //获取登录用户的归属地和运营商
    function Go($url){
        $ch = curl_init();  //随机生成IP
        $ip = rand(0,255).'.'.rand(0,255).'.'.rand(0,255).'.'.rand(0,255) ;   // 百度 蜘蛛
        $timeout = 15;curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_TIMEOUT,0);  //伪造百度 蜘蛛IP
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('X-FORWARDED-FOR:'.$ip.'','CLIENT-IP:'.$ip.'')); //伪造百度 蜘蛛头部
        curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $content = curl_exec($ch);
        curl_close($ch);  //关闭一打开的会话
        return $content;
    }
    function getip($ip){
        $url = 'https://whois.pconline.com.cn/ipJson.jsp?ip='.$ip.'&json=true';
        $body= Go($url);
        $body = iconv("GB2312","UTF-8//IGNORE",$body);
        $body = json_decode($body,true);
        $address = $body['addr'];
        return $address;
    }

