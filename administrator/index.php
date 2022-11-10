<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
?>
<html>
	<head>
		<title>后台首页</title>
		<style>
            body{
                padding: 0;
                margin: 0;
            }
			#box1 {
				border: 1px solid lightseagreen;
				color: black;
				background-color: lightseagreen;
                height: 60px;
            }
            #left {
                float: left;
                height: 60px;
                line-height: 60px;
                margin-left: 10px;
            }
            #right {
                float: right;
                height: 60px;
                line-height: 60px;
                margin-right: 10px;
            }
            #left a {
                text-decoration: none;
            }
            a:hover {
                color: lightseagreen;
            }
            .foot {
                width: 100%;
                color: black;
                background-color: lightseagreen;
                height: 75px;
                line-height: 37.5px;
                text-align: center;
                position: relative;
                bottom: -5px;
            }
            .foot a{
                text-decoration: none;
            }
		</style>
	</head>
	<body>
		<div id='box1'>
			<div id='left'>
				<a href='../administrator/index.php' style='text-decoration: none;'>
					<font size='5' color='black'>Library</font>
				</a>&nbsp;&nbsp;
				<a href='../administrator/index.php' style='text-decoration: none;'>
					<font size='3' color='black'>首页</font>
				</a>&nbsp;&nbsp;
				<a href='../books/books_list.php' style='text-decoration: none;'>
					<font size='3' color='black'>图书列表</font>
				</a>&nbsp;&nbsp;
				<a href='#' style='text-decoration: none;'>
					<font size='3' color='black'>开发指南</font>
				</a>&nbsp;&nbsp;
				<a href='#' style='text-decoration: none;'>
					<font size='3' color='black'>关于</font>
				</a>&nbsp;&nbsp;
			</div>
			<div id='right'>
				<?php
                    if($_SESSION['is_flag']!=2){
                        echo "<script>alert('您没有权限访问！');location.href='../login/login.php'</script>";
                    }else{
                        echo "您好！".$_SESSION['user'];
                    }
                ?>
				<a href='../login/logout.php' style='text-decoration: none;align:right'>
					<font size='3' color='black'>| 注销</font>
				</a>
			</div>
		</div>

        <!-- <div class='foot'>
            <a href='#'>
                <font size='3' color='black'>加入我们 | </font>
            </a>&nbsp;&nbsp;
            <a href='#'>
                <font size='3' color='black'> 联系我们 | </font>
            </a>&nbsp;&nbsp;
            <a href='#'>
                <font size='3' color='black'> 服务协议 | </font>
            </a>&nbsp;&nbsp;
            <a href='#'>
                <font size='3' color='black'> 法律信息 | </font>
            </a>&nbsp;&nbsp;
            <a href='#'>
                <font size='3' color='black'> 隐私政策</font>
            </a>&nbsp;&nbsp;<br/>
            <b>
                数字图书馆 &nbsp;&nbsp; 版权所有Copyright 2000-2021， All Rights Reserved
                &nbsp;&nbsp;云ICP备20001011--Jason L.i.u
            </b>
        </div> -->

		<script type='text/javascript' src='https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js'></script>
	</body>
</html>
