<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>文件上传</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../css/layui.css"/>
</head>
<body>
    <form action="../upload/uploadFile.php" method="post" enctype="multipart/form-data">
        <label for="file">请选择上传的文件：</label>
        <input type="file" name="file" id="file"/>
        <br>
        <button type="submit" name="submit" class="layui-btn layui-btn-sm layui-btn-primary">提交</button>
    </form>
</body>
</html>