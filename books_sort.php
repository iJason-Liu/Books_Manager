<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>图书分类中心</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <script src="js/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://heerey525.github.io/layui-v2.4.3/layui-v2.4.5/css/layui.css" />
        <link rel="stylesheet" type="text/css" href="css/index.css" />
        <link rel="stylesheet" href="css/swiper-bundle.min.css">
        <style>
            * {
                margin: 0;
                padding: 0;
            }
            .logo {
                height: 80px;
                width: 200px;
                padding-top: 5px;
            }
            .layui-nav * {
                font-size: 16px !important;
            }
        </style>
    </head>
    <body>
        <nav class="layui-header hc-header">
            <div class="layui-main">
                <a class="hc-logo" href="index.html"> <img alt="logo" class="logo" src="images/logo.png" />
                </a>
                <ul class="layui-nav">
                    <li class="layui-nav-item hc-hide-sm"> <a href="index.html">首页</a> </li>
                    <li class="layui-nav-item hc-hide-sm layui-this"> <a href="books_sort.php?id=1">冒险类</a> </li>
                    <li class="layui-nav-item hc-hide-sm "> <a href="books_sort.php?id=2">文学类</a> </li>
                    <li class="layui-nav-item hc-hide-sm "> <a href="books_sort.php?id=3">励志类</a> </li>
                    <li class="layui-nav-item hc-hide-sm "> <a href="books_sort.php?id=4">历史类</a> </li>
                    <li class="layui-nav-item hc-show-sm"> <a href="javascript:;">更多</a>
                        <dl class="layui-nav-child">
                            <dd class=""><a href="books_sort.php?id=5">玄幻类</a></dd>
                            <dd class=""><a href="books_sort.php?id=6">悬疑类</a></dd>
                            <dd class=""><a href="books_sort.php?id=7">政治类</a></dd>
                            <dd class=""><a href="books_sort.php?id=8">经济类</a></dd>
                            <dd class=""><a href="books_sort.php?id=9">军事类</a></dd>
                            <dd class=""><a href="books_sort.php?id=10">著作类</a></dd>
                        </dl>
                    </li>
                </ul>

            </div>
        </nav>
        <script type="text/javascript" src="https://www.layuicdn.com/layui/layui.js"></script>
    </body>
</html>