<?php
    /*
     * 用户登录页面
     */
    include '../config/conn.php';
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $username = $_GET['username'];
    // echo $username;

    //输出URL中无后缀的路径
    // $filname = basename($_SERVER['REQUEST_URI'],'.php');
    // $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    // $path = dirname($url);
    // echo $path.'/'.$filname;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>读者登录</title>
        <link rel="shortcut icon" href="../skin/images/favicon.png" />
		<meta http-equiv="pragma" content="no-cache">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="stylesheet" href="../skin/live2d/css/live2d.css" />
		
		<script type="text/javascript">
			// 验证码刷新
			function code(){
				let code = document.getElementById('img_yzm');
				code.src='./code.php?v='+Date.now();   //刷新  防止缓存
			}
		</script>
		
		<style>
			#main{
				border: 1px solid #429488;
				background-color: aliceblue;
				margin: 12% auto;
				padding: 20px;
				width: 360px;
				opacity: .95;
				border-radius: 7px;
			}
			.tab{
				text-align: center;
				/*width: 100%;*/
                padding-left: 18px;
				height: 250px;
				border-spacing: 6px;
			}
			.btn{
				width: 100px;
				height: 32px;
				background-color: #429488;
				border-radius: 3px;
				cursor: pointer;
				color: white;
				font-size: 16px;
				border: none;
                margin: 10px 0 0 12px;
			}
			.yzm{
				text-indent: 2px;
				height: 27px;
				width: 105px;
			}
			.img_yzm{
				width: 100px;
				height: 30px;
				line-height: 35px;
				vertical-align: middle;
				cursor: pointer;
			}
			.sel{
				width: 120px;
				height: 27px;
				cursor: pointer;
				margin-left: -100px;
			}
		</style>
	</head>
	<body style="background: url('../skin/images/bg.png') top center no-repeat;background-size:cover;">
		<div id="main">
			<form action="./login_check" method="post">
				<table class="tab" cellspacing="0">
					<tr style="height: 50px;">
						<th colspan="2"><font size="5" color="#429488">读者登录</font></th>
					</tr>
					<tr>
						<td><label>账 号：</label></td>
						<td>
							<input type="text" id="account" name="account" placeholder="请输入借阅卡号或账号" required style="width: 210px;height: 27px" value="<?php echo $username ?>" />
						</td>
					</tr>
					<tr>
						<td>密 码：</td>
						<td><input type="password" id="userpwd" name="password" placeholder="请输入密码" required style="width: 210px;height: 27px" value="" /></td>
					</tr>
					<tr>
						<td>身 份：</td>
						<td>
							<select class="sel" name="usertype" size="1">
							<?php
								$sql1 = "select * from user_type";
								$result = mysqli_query($db_connect,$sql1);
								while($row = mysqli_fetch_array($result)) {
                                    echo "<option value=" . $row['usertype_name'] . ">" . $row['usertype_name'] . "</option>";
                                }
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>验证码：</td>
						<td>
							<input class="yzm" name="yzm" type="text" required size="4" maxlength="4" placeholder="请输入验证码" />
							<img src="./code.php" border="0" id="img_yzm" class="img_yzm" title="点击刷新验证码" onclick="code()" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="reset" name="reset" value="重 置" class="btn"/>
							<input type="submit" name="submit" value="登 录" class="btn"/>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<hr />
							<!--<a href="../register/register"><font size="2" color="darkcyan">没有账号？去注册</font></a>-->
							<a title="返回首页" href="../index"><font size="2" color="darkcyan">返回首页</font></a>
						</td>
					</tr>
				</table>	
			</form>
		</div>
		
		<div id="landlord">
    		<div class="message" style="opacity:0"></div>
    		<canvas id="live2d" width="280" height="250" class="live2d"></canvas>
   			 <div class="hide-button">隐藏</div>
		</div>
		<script type="text/javascript" src="../skin/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript">
		    let message_Path = '../skin/live2d/'
		    let home_Path = 'https://lib.crayon.vip/'
		</script>
		<script type="text/javascript" src="../skin/live2d/js/live2d.js"></script>
		<script type="text/javascript" src="../skin/live2d/js/message.js"></script>
		<script type="text/javascript">
   			 loadlive2d("live2d", "../skin/live2d/model/Pio/model.json");
		</script>
		
		<script type="text/javascript">
			//生成小雪花
			(function($) {
				$.fn.snow = function(options) {
					var $flake = $('<div id="snowbox" />').css({
							'position': 'absolute',
							'z-index': '999',
							'top': '-50px'
						}).html('&#10052;'),
						documentHeight = $(document).height(),
						documentWidth = $(document).width(),
						defaults = {
							minSize: 10,
							maxSize: 20,
							newOn: 1000,
							flakeColor: "white" /* 自定义雪花颜色，默认是浅蓝色 */
						},
						options = $.extend({}, defaults, options);
					let interval = setInterval(function() {
						let startPositionLeft = Math.random() * documentWidth - 100,
							startOpacity = 0.5 + Math.random(),
							sizeFlake = options.minSize + Math.random() * options.maxSize,
							endPositionTop = documentHeight - 200,
							endPositionLeft = startPositionLeft - 500 + Math.random() * 500,
							durationFall = documentHeight * 10 + Math.random() * 5000;
						$flake.clone().appendTo('body').css({
							left: startPositionLeft,
							opacity: startOpacity,
							'font-size': sizeFlake,
							color: options.flakeColor
						}).animate({
							top: endPositionTop,
							left: endPositionLeft,
							opacity: 0.2
						}, durationFall, 'linear', function() {
							$(this).remove()
						});
					}, options.newOn);
				};
			})(jQuery);
			$(function() {
				$.fn.snow({
					minSize: 5,
					/* 雪花最小尺寸 */
					maxSize: 35,
					/* 雪花最大尺寸 */
					newOn: 260 /* 雪花密集程度，数字越小越密集 */
				});
			});
		</script>
		
		<script type="text/javascript">
			//鼠标点击出现爱心特效
			(function(window, document, undefined) {
				let hearts = [];
				window.requestAnimationFrame = (function() {
					return window.requestAnimationFrame ||
						window.webkitRequestAnimationFrame ||
						window.mozRequestAnimationFrame ||
						window.oRequestAnimationFrame ||
						window.msRequestAnimationFrame ||
						function(callback) {
							setTimeout(callback, 1000 / 60);
						}
				})();
				init();

				function init() {
					css(".heart{width: 10px;height: 10px;position: fixed;background: #f00;transform: rotate(45deg);-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);}.heart:after,.heart:before{content: '';width: inherit;height: inherit;background: inherit;border-radius: 50%;-webkit-border-radius: 50%;-moz-border-radius: 50%;position: absolute;}.heart:after{top: -5px;}.heart:before{left: -5px;}");
					attachEvent();
					gameloop();
				}

				function gameloop() {
					for(let i = 0; i < hearts.length; i++) {
						if(hearts[i].alpha <= 0) {
							document.body.removeChild(hearts[i].el);
							hearts.splice(i, 1);
							continue;
						}
						hearts[i].y--;
						hearts[i].scale += 0.004;
						hearts[i].alpha -= 0.013;
						hearts[i].el.style.cssText = "left:" + hearts[i].x + "px;top:" + hearts[i].y + "px;opacity:" + hearts[i].alpha + ";transform:scale(" + hearts[i].scale + "," + hearts[i].scale + ") rotate(45deg);background:" + hearts[i].color;
					}
					requestAnimationFrame(gameloop);
				}

				function attachEvent() {
					let old = typeof window.οnclick === "function" && window.onclick;
					window.onclick = function(event) {
						old && old();
						createHeart(event);
					}
				}

				function createHeart(event) {
					let d = document.createElement("div");
					d.className = "heart";
					hearts.push({
						el: d,
						x: event.clientX - 5,
						y: event.clientY - 5,
						scale: 1,
						alpha: 1,
						color: randomColor()
					});
					document.body.appendChild(d);
				}

				function css(css) {
					let style = document.createElement("style");
					style.type = "text/css";
					try {
						style.appendChild(document.createTextNode(css));
					} catch(ex) {
						style.styleSheet.cssText = css;
					}
					document.getElementsByTagName('head')[0].appendChild(style);
				}

				function randomColor() {
					return "rgb(" + (~~(Math.random() * 255)) + "," + (~~(Math.random() * 255)) + "," + (~~(Math.random() * 255)) + ")";
				}
			})(window, document);
		</script>
	</body>
</html>
