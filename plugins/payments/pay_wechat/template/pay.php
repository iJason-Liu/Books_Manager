<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>微信扫一扫支付</title>

	<style type='text/css'>
		body{text-align: center;}
		.main{margin-right:auto;margin-left:auto;margin-top:120px}
	</style>
</head>
<body>
	<div class="main">
		请使用微信扫一扫进行支付，二维码只在五分中内有效果
		<p><img src="<?php echo $sendData['code_img_url'];?>"></p>
	</div>
</body>
</html>