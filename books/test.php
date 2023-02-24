<?php
include '../config/conn.php';
// 设置文档类型：，utf-8支持中文文档
header("Content-Type:text/html;charset=utf-8");

//执行sql语句的查询语句
$sql1 = "select * from books";
$result = mysqli_query($db_connect, $sql1);
class booksData
    {
        public $id = "";  //图书编号
        public $name = ""; //图书名称
        public $price = ""; //图书价格
        public $author = ""; //作者
        public $publisher = ""; //出版社
        public $number = "";  //库存
        public $type = "";  //图书类型
        public $mark = "";  //图书介绍
    }
    $row = mysqli_fetch_all($result);
    echo json_encode($row, JSON_UNESCAPED_UNICODE);
// while ($row = mysqli_fetch_assoc($result)) {
//     //创建图书实例
//     $data = new booksData();
//     $data->id = $row["book_id"];
//     $data->name = $row["book_name"];
//     $data->price = $row["price"];
//     $data->author = $row["author"];
//     $data->publisher = $row["publisher"];
//     $data->number = $row["number"];
//     $data->type = $row["book_type"];
//     $data->mark = $row["mark"];
 
//     $array[] = json_encode($data, JSON_UNESCAPED_UNICODE);
//     var_dump($array);
// }

mysqli_close($db_connect); //关闭数据库资源
