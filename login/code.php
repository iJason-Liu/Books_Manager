<?php
    /*
     * 验证码
     */
	session_save_path('../session/'); //保存session
	ob_end_flush();  // 清理缓存
	session_start();   //启动session
	header("Content-Type: image/png");
	//设置图片对象大小
	$img_width=90;    
	$img_height=22;
	
	//生成随机数
	srand(microtime()*100000);
	for($i=0; $i<4; $i++){
		$new_number .= dechex(rand(0,15));
	}
	
	$_SESSION["check_auth"]=$new_number;   //把验证码写入session中
	$number_img = imagecreate($img_width, $img_height);
	imagecolorallocate($number_img, 255, 200, 73);   //图片背景色
	
	for($i=0; $i<strlen($_SESSION["check_auth"]); $i++){
		$font = mt_rand(4, 6);   //随机字体大小
		$x = mt_rand(1, 8) + $img_width * $i / 4;   //x轴随机位置
		$y = mt_rand(1, $img_height / 4);           //y轴随机位置
		//设置字体颜色随机
		$color = imagecolorallocate($number_img, mt_rand(0,120), mt_rand(10,200), mt_rand(200,210));
		//将随机字符一次填充进图片
		imagestring($number_img, $font, $x, $y, $_SESSION["check_auth"][$i], $color);
	}
	//创建干扰点
    for($i=0;$i<450;$i++){
        $point_color = imagecolorallocate($number_img,rand(60,200),rand(60,200),rand(60,200));
        imagesetpixel($number_img,rand(0,149),rand(0,49),$point_color);
    }
    //创建干扰线
    for($i=0;$i<6;$i++){
        $line_color = imagecolorallocate($number_img,rand(60,200),rand(60,200),rand(60,200));
        imageline($number_img,rand(0,149),rand(0,49),rand(0,149),rand(0,49),$line_color);
    }
	
	imagepng($number_img);   //以png格式输出
	imagedestroy($number_img);    //销毁图片
	
?>