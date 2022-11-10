<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>数字图书馆中心</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <style>
            *{
                margin: 0;
                padding: 0;
            }
            header{
                height: 35px;
                line-height: 35px;
                padding: 0 10px;
                background: #696969;
                color: #ffffff;
            }
            header a{
                text-decoration: none;
                color: #ffffff;
            }
            .top_right{
                float: right;
            }
        </style>
    </head>
    <body>
       <header>
           <span>欢迎访问数字图书馆！</span>
           <div class='top_right'>
               <a href='login/login.php'>登录 </a> | <a href='register/register.php'> 注册</a>
           </div>
       </header>
       <nav>
            <ul>
               <li>首页</li>
               <li>
                   <ul>
                       <li>二级</li>
                       <li>二级</li>
                   </ul>
               </li>
            </ul>
       </nav>
    </body>
</html>