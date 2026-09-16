<?php
    /*
     * 验证码
     */
	session_save_path('../session/');
	if (ob_get_level() > 0) {
	    ob_end_flush();
	}
	session_start();
	header("Content-Type: image/png");

	$img_width = 90;
	$img_height = 22;

	$new_number = '';
	for($i = 0; $i < 4; $i++){
		$new_number .= dechex(random_int(0, 15));
	}

	$_SESSION["check_yzm"] = $new_number;
	$number_img = imagecreate($img_width, $img_height);
	imagecolorallocate($number_img, 211, 229, 217);

	for($i = 0; $i < strlen($_SESSION["check_yzm"]); $i++){
		$font = random_int(4, 6);
		$x = (int)(random_int(1, 8) + $img_width * $i / 4);
		$y = (int)random_int(1, (int)($img_height / 4));
		$color = imagecolorallocate($number_img, random_int(0, 120), random_int(10, 200), random_int(200, 210));
		imagestring($number_img, $font, $x, $y, $_SESSION["check_yzm"][$i], $color);
	}

    for($i = 0; $i < 450; $i++){
        $point_color = imagecolorallocate($number_img, random_int(60, 200), random_int(60, 200), random_int(60, 200));
        imagesetpixel($number_img, random_int(0, 149), random_int(0, 49), $point_color);
    }

    for($i = 0; $i < 6; $i++){
        $line_color = imagecolorallocate($number_img, random_int(60, 200), random_int(60, 200), random_int(60, 200));
        imageline($number_img, random_int(0, 149), random_int(0, 49), random_int(0, 149), random_int(0, 49), $line_color);
    }

	imagepng($number_img);
	imagedestroy($number_img);
