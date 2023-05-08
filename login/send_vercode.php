<?php
    /*
     * 发送邮箱验证码
     *  @Jason Liu
     */
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once("../classes/PHPMailer/Exception.php");
    require_once("../classes/PHPMailer/PHPMailer.php");
    require_once("../classes/PHPMailer/SMTP.php");

    // 设置文档类型：，utf-8支持中文文档
	header("Content-Type:text/html;charset=utf-8");

    $email = $_POST['email'];   //邮箱
    // echo $_SESSION['codetime'];  //验证码发送时间
    $randStr = str_shuffle('1234567890');  //随机打乱字符
    $code = substr($randStr, 0, 6); //随机验证码

    if(time() - $_SESSION['codetime'] < 60){
        echo json_encode(array('code' => 0, 'msg' => '一分钟只能发送一次验证码！'),JSON_UNESCAPED_UNICODE);
        exit();
    }

    try {
        // 实例化PHPMailer核心类
        $mail = new PHPMailer();

        // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        // $mail->SMTPDebug = 1;

        // 使用smtp鉴权方式发送邮件
        $mail->isSMTP();

        // smtp需要鉴权 这个必须是true
        $mail->SMTPAuth = true;

        // 链接qq域名邮箱的服务器地址
        $mail->Host = 'smtp.qq.com';

        // 设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';

        // 设置ssl连接smtp服务器的远程服务器端口号
        $mail->Port = 465;

        // 设置发送的邮件的编码
        $mail->CharSet = 'UTF-8';

        // 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = 'lib.crayon.vip';

        // smtp登录的账号 QQ邮箱即可
        $mail->Username = '1837972550@qq.com';

        // smtp登录的密码 使用生成的授权码
        $mail->Password = 'ssugxgdyoxtlfdfd';

        // 设置发件人邮箱地址 同登录账号
        $mail->From = '1837972550@qq.com';

        // 设置收件人邮箱地址
        $mail->addAddress($email, '');

        // 邮件正文是否为html编码
        $mail->isHTML(true);

        // 邮件内容
        $mail->Subject = '重置密码';  //邮件主题
        $mail->Body = '<p>【小新图书馆】</p><p>亲爱的读者：您好！</p><p>您正在通过QQ邮箱重置账户密码，请在验证码输入框中输入：<span style="color: #EC6337;font-weight: bold;">'.$code.'</span>，以完成操作。<br><br><span style="color: #999;">注意：为了您的账户安全，请勿泄露此验证码。</span></p><hr><p style="color:#999;">此为系统邮件，请勿回复！<br>时间：' . date('Y-m-d H:i:s').'</p>';  //邮件正文
        $mail->AltBody = '验证码：'.$code; //如果邮件客户端不支持HTML则显示此内容

        // 为该邮件添加附件
        // $mail->addAttachment('./example.pdf');

        // 发送邮件
        $mail->send();
        $_SESSION['reset_code'] = $code;  //把验证码存入session
        $_SESSION['codetime'] = time();  //更新验证码时间
        echo json_encode(array('code' => 200, 'msg' => '验证码已发送！', 'data' => $code),JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        echo json_encode(array('code' => 0, 'msg' => '验证码发送失败，请稍后再试！', 'error' => $mail->ErrorInfo),JSON_UNESCAPED_UNICODE);
    }