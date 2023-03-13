<?php
    session_save_path('../session/');
    session_start();
    include '../config/conn.php';
    if ($_SESSION['is_flag'] != 2) {
        echo "<script>alert('对不起，您没有权限操作！');location.href='../login/login.php'</script>";
    }
    // 设置文档类型：，utf-8支持中文文档
    header("Content-Type:text/html;charset=utf-8");
    $id = $_GET['id'];
    //执行sql语句的查询语句
    $sql1 = "select * from book_list where book_id=$id";
    $result = mysqli_query($db_connect, $sql1);

    mysqli_close($db_connect); //关闭数据库资源
?>
<!DOCTYPE html>
<html>

<head>
    <title>图书详情信息</title>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="https://ymck.me/wp-content/uploads/2022/12/head-removebg-preview-1-1.png" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<!--    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="../css/layui.css">
    <script type="text/javascript" src="../js/layui.simple.js"></script>
    <style>
        td {
            height: 60px
        }
        .tab{
            margin: 20px auto;
        }
        textarea {
            font-size: 16px;
            resize:none;
            padding: 4px;
            text-overflow: ellipsis;
        }
    </style>
</head>

<body style='background: url(../images/bg3.jpg) top center no-repeat; background-size:cover'>
    <h1 align='center' style='margin-top:10px'>图书详细信息</h1>
    <hr>
    <form action='../books/update_books.php?id=<?php echo $id; ?>' method='post'>
        <table class="tab">
            <?php
            while ($row = mysqli_fetch_array($result)) {
            ?>
                <tr>
                    <th style='width:120px'>书本名称:</th>
                    <td>
                        <?php
                        echo $row["book_name"];
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>书本价格:</th>
                    <td>
                        <?php
                        echo $row["price"];
                        ?>元
                    </td>
                </tr>
                <tr>
                    <th>书本作者:</th>
                    <td>
                        <?php
                        echo $row["author"];
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>出 版 社:</th>
                    <td>
                        <?php
                        echo $row["publisher"];
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>图书类别:</th>
                    <td>
                        <?php
                        echo $row["book_type"];
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>库 存:</th>
                    <td>
                        <?php
                        echo $row["number"];
                        ?>本
                    </td>
                </tr>
                <tr style='height:145px'>
                    <th>书本介绍:</th>
                    <td>
                        <textarea rows='8' cols='40' readonly><?php echo $row["mark"]; ?></textarea>
                    </td>
                </tr>
<!--                        <tr>-->
<!--                            <td colspan='2' align='center'>-->
<!--                                <input type='submit' value='修 改' class="layui-btn layui-btn-radius" />-->
<!--                                <input type='button' value='返 回' onclick='window.location.href="../books/books_list.php"' class="layui-btn layui-btn-radius" />-->
<!--                            </td>-->
<!--                        </tr>-->
            <?php
            }
            ?>
        </table>
    </form>
</body>

</html>