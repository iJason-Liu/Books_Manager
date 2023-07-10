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
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
		<link rel="stylesheet" href="../skin/live2d/css/live2d.css" />
        <link rel="stylesheet" href="../skin/css/layui.min.css">
        <link rel="stylesheet" href="../skin/css/modules/layer/layer.css">
		<style>
            *{
                margin: 0;
                padding: 0;
            }

			.main{
				background-color: #fff;
				position: absolute;
                top: 50%;
                left: 50%;
                margin-top: -330px;
                margin-left: -260px;
				width: 450px;
                height: 620px;
				border-radius: 5px;
                padding: 20px;
                box-shadow: 0 0 15px 0 rgba(0,33,79,0.11);
			}

			.layui-btn{
				width: 100%;
                height: 45px;
                line-height: 45px;
                font-size: 17px;
			}

			.img_yzm{
				cursor: pointer;
                border-radius: 2px;
			}

            .layui-tab-title li{
                font-size: 17px;
            }

            .layui-tab-content{
                padding: 0 20px;
            }

            .layui-form-pane .layui-form-label{
                padding: 0;
                width: 64px;
                line-height: 38px;
            }

            .layui-form-pane .layui-input-block{
                margin-left: 64px;
            }
            
            .forgot{
                cursor: pointer;
            }

            #reset_pwd{
                display: none;
                padding: 0 30px;
            }

            .send_code{
                position: absolute;
                right: 15px;
                top: 10px;
                color: #429488;
                cursor: pointer;
            }

            .layui-form-item .layui-input-inline{
                margin-right: 0;
            }
		</style>
	</head>
	<body style="background: #f8f8f8;">
		<div class="main">
            <div style="height: 120px;line-height: 110px;text-align: center;">
                <a href="/">
                    <img width="230" height="50" src="../skin/images/logo.png">
                </a>
            </div>
            <div class="layui-tab layui-tab-brief" lay-filter="login">
                <ul class="layui-tab-title">
                    <li class="layui-this" lay-id="account">账号</li>
                    <li lay-id="admin">管理员</li>
                    <li lay-id="register" style="float: right;">注册</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <form class="layui-form layui-form-pane" lay-filter="form_account" style="margin: 30px 0 0 0;">
                            <div class="layui-form-item">
                                <label class="layui-form-label"><i class="layui-icon layui-icon-username"></i></label>
                                <div class="layui-input-block">
                                    <input type="text" name="account" placeholder="请输入借阅卡号或账号" value="<?php echo $username ?>" class="layui-input account" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>
                                <div class="layui-input-block">
                                    <input type="password" name="password" placeholder="请输入密码" class="layui-input password" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><i class="layui-icon layui-icon-group"></i></label>
                                <div class="layui-input-inline">
                                    <select name="usertype">
                                        <?php
                                            $sql1 = "select * from user_type";
                                            $result = mysqli_query($db_connect,$sql1);
                                            while($row = mysqli_fetch_array($result)) {
                                                if($row['usertype_name'] == '图书管理员' || $row['usertype_name'] == '超级管理员'){
                                                    continue;
                                                }
                                                echo "<option value=" . $row['usertype_name'] . ">" . $row['usertype_name'] . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><i class="layui-icon layui-icon-vercode"></i></label>
                                <div class="layui-input-block">
                                    <input type="text" style="width: 61%;float: left;margin-right: 2%;" name="yzm" maxlength="6" placeholder="请输入验证码" class="layui-input account_yzm" />
                                    <img src="./code.php" width="35%" height="38" class="img_yzm account_yzm" title="点击刷新验证码"/>
                                </div>
                            </div>
                            <div class="layui-form-item" style="margin-top: 35px;">
                                <button type="button" class="layui-btn" name="submit" id="submit" lay-submit value="登录">登 录</button>
                            </div>
                        </form>
                        <div style="float: right;margin-bottom: 15px;"><span class="forgot">忘记密码？</span></div>
                        <hr>
                        <div style="text-align: center;margin-top: 30px;"><a href="/"><i class="layui-icon layui-icon-home"></i> 返回首页</a></div>
                    </div>
                    <div class="layui-tab-item">
                        <form class="layui-form layui-form-pane" lay-filter="form_admin" style="margin: 30px 0 0 0;">
                            <div class="layui-form-item">
                                <label class="layui-form-label"><i class="layui-icon layui-icon-username"></i></label>
                                <div class="layui-input-block">
                                    <input type="text" name="account" placeholder="请输入工号或账号" value="<?php echo $username ?>" class="layui-input admin" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>
                                <div class="layui-input-block">
                                    <input type="password" name="password" placeholder="请输入密码" class="layui-input password1" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><i class="layui-icon layui-icon-group"></i></label>
                                <div class="layui-input-inline">
                                    <select name="usertype">
                                        <option value="图书管理员">图书管理员</option>
                                        <option value="超级管理员">超级管理员</option>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"><i class="layui-icon layui-icon-vercode"></i></label>
                                <div class="layui-input-block">
                                    <input type="text" style="width: 61%;float: left;margin-right: 2%;" name="yzm" maxlength="6" placeholder="请输入验证码" class="layui-input admin_yzm" />
                                    <img src="./code.php" width="35%" height="38" class="img_yzm admin_yzm" title="点击刷新验证码" />
                                </div>
                            </div>
                            <div class="layui-form-item" style="margin-top: 35px;">
                                <button type="button" class="layui-btn" name="submit" id="admin" lay-submit value="登录">登 录</button>
                            </div>
                        </form>
                        <div style="float: right;margin-bottom: 15px;"><span class="forgot">忘记密码？</span></div>
                        <hr>
                        <div style="text-align: center;margin-top: 30px;"><a href="/"><i class="layui-icon layui-icon-home"></i> 返回首页</a></div>
                    </div>
                    <div class="layui-tab-item">
                         <div style="margin: 20px 0 0 0;">注册暂未开放！</div>
                        <!--<form class="layui-form layui-form-pane" lay-filter="form_register" style="margin: 30px 0 0 0;">-->
                        <!--    <div class="layui-form-item">-->
                        <!--        <label class="layui-form-label"><i class="layui-icon layui-icon-username"></i></label>-->
                        <!--        <div class="layui-input-block">-->
                        <!--            <input type="text" name="name" placeholder="请输入姓名" value="" class="layui-input name" />-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="layui-form-item">-->
                        <!--         <label class="layui-form-label"><i class="layui-icon layui-icon-cellphone"></i></label>-->
                        <!--        <div class="layui-input-block">-->
                        <!--            <input type="tel" name="mobile" placeholder="请输入联系电话" class="layui-input mobile">-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="layui-form-item">-->
                        <!--        <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>-->
                        <!--        <div class="layui-input-block">-->
                        <!--            <input type="password" name="password" placeholder="请输入密码" class="layui-input password2" />-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="layui-form-item">-->
                        <!--        <label class="layui-form-label"><i class="layui-icon layui-icon-male"></i></label>-->
                        <!--        <div class="layui-input-inline">-->
                        <!--            <input type='radio' name='sex' value='男' title='男' checked>-->
                        <!--            <input type='radio' name='sex' value='女' title='女'>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="layui-form-item">-->
                        <!--        <label class="layui-form-label"><i class="layui-icon layui-icon-group"></i></label>-->
                        <!--        <div class="layui-input-inline">-->
                        <!--            <select name="usertype">-->
                        <!--            --><?php
                        //                 $sql1 = "select * from user_type";
                        //                 $result = mysqli_query($db_connect,$sql1);
                        //                 while($row = mysqli_fetch_array($result)) {
                        //                     if($row['usertype_name'] == '图书管理员' || $row['usertype_name'] == '超级管理员'){
                        //                         continue;
                        //                     }
                        //                     echo "<option value=" . $row['usertype_name'] . ">" . $row['usertype_name'] . "</option>";
                        //                 }
                        //             ?>
                        <!--            </select>-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="layui-form-item">-->
                        <!--        <label class="layui-form-label"><i class="layui-icon layui-icon-vercode"></i></label>-->
                        <!--        <div class="layui-input-block">-->
                        <!--            <input type="text" style="width: 61%;float: left;margin-right: 2%;" name="yzm" maxlength="6" placeholder="请输入验证码" class="layui-input register_yzm" />-->
                        <!--            <img src="./code.php" width="35%" height="38" class="img_yzm register_yzm" title="点击刷新验证码" />-->
                        <!--        </div>-->
                        <!--    </div>-->
                        <!--    <div class="layui-form-item" style="margin-top: 35px;">-->
                        <!--        <button type="button" class="layui-btn" name="submit" id="register" lay-submit value="注册">注 册</button>-->
                        <!--    </div>-->
                        <!--</form>-->
                        <!--<hr>-->
                        <!--<div style="text-align: center;margin-top: 10px;"><a href="/"><i class="layui-icon layui-icon-home"></i> 返回首页</a></div>-->
                    </div>
                </div>
            </div>
		</div>

        <div id="reset_pwd">
            <form class="layui-form layui-form-pane" lay-filter="form_reset" style="margin: 30px 0 0 0;">
                <div class="layui-form-item">
                    <label class="layui-form-label"><i class="layui-icon layui-icon-username"></i></label>
                    <div class="layui-input-block">
                        <input type="text" name="account" placeholder="请输入账号" class="layui-input acc" />
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><i class="layui-icon layui-icon-email"></i></label>
                    <div class="layui-input-block">
                        <input type="email" name="email" id="email" placeholder="请输入邮箱" class="layui-input" />
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><i class="layui-icon layui-icon-vercode"></i></label>
                    <div class="layui-input-block">
                        <input type="text" name="email_yzm" maxlength="6" placeholder="请输入邮箱验证码" class="layui-input email_yzm" />
                        <span class="send_code">发送验证码</span>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>
                    <div class="layui-input-block">
                        <input type="password" name="pwd" id="pwd" placeholder="请输入新密码" lay-verType="tips" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label"><i class="layui-icon layui-icon-password"></i></label>
                    <div class="layui-input-block">
                        <input type="password" name="pwd2" id="pwd2" placeholder="请再次输入密码"  lay-verType="tips" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item" style="margin-top: 45px;">
                    <button type="button" class="layui-btn" name="reset" id="reset" lay-submit value="重置密码">重置密码</button>
                </div>
            </form>
        </div>
		
		<div id="landlord">
    		<div class="message" style="opacity:0"></div>
    		<canvas id="live2d" width="280" height="250" class="live2d"></canvas>
   			<div class="hide-button">隐藏</div>
		</div>
		<script type="text/javascript" src="../skin/js/jquery-3.3.1.min.js"></script>
		<script type="text/javascript" src="../skin/js/layui.min.js"></script>
        <script type="text/javascript">
            layui.use(['layer', 'form', 'element'], function() {
                let $ = layui.jquery
                ,layer = layui.layer
                ,form = layui.form
                ,element = layui.element;

                // 获取图书详情页传过来的参数
                function getUrl(paras){
                    let returl = new Object();
                    if (paras.indexOf("?") != -1) {
                        let queryString = paras.substr(1);
                        let queryParams = queryString.split("&");
                        for (let i = 0; i < queryParams.length; i++) {
                            let [key, value] = queryParams[i].split("=");
                            returl [key] = decodeURI(value);
                            //值需要使用 decodeURI() 函数对通过 escape() 或 url 编码过的字符串进行解码
                        }
                    }
                    return returl;
                }
                //调用方法
                let paras = window.location.search;   //search获得地址中的参数
                let returl = getUrl(paras);
                let idx = returl['index'];  //类型  1图书详情
                let book_id = returl['book_id'];  //对应图书id
                console.log(idx);

                //Hash地址的定位，tab切换
                let lay_id = location.hash.replace(/^#/, '');
                element.tabChange('type', lay_id);
                element.on('tab(login)', function(elem){
                    location.hash = $(this).attr('lay-id');
                    // 切换tab更新验证码
                    $('.admin_yzm').attr('src', './code.php?v='+Date.now());   //刷新  防止缓存
                    $('.account_yzm').attr('src', './code.php?v='+Date.now());   //刷新  防止缓存
                    $('.register_yzm').attr('src', './code.php?v='+Date.now());   //刷新  防止缓存
                })

                // 点击验证码刷新 账号/管理员/注册
                $('.account_yzm').on('click', function (){
                    $('.account_yzm').attr('src', './code.php?v='+Date.now());   //刷新  防止缓存
                })
                $('.admin_yzm').on('click', function (){
                    $('.admin_yzm').attr('src', './code.php?v='+Date.now());   //刷新  防止缓存
                })
                $('.register_yzm').on('click', function (){
                    $('.register_yzm').attr('src', './code.php?v='+Date.now());   //刷新  防止缓存
                })

                // 账号登录
                $('#submit').on('click',function (){
                    let data = form.val('form_account'); //获取表格中的所有数据 携带name属性
                    // console.log(data);
                    if(data.account == ''){
                        layer.tips('请输入借阅卡号或账号！', '.account',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('.account').focus();
                        return false;
                    }
                    if(data.password == ''){
                        layer.tips('请输入密码！', '.password',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('.password').focus();
                        return false;
                    }
                    if(data.yzm == ''){
                        layer.tips('请输入验证码！', '.account_yzm',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('.account_yzm').focus();
                        return false;
                    }
                    let index = layer.load(3,{
                        shade: .2,
                        content: 'loading'
                    })
                    $.ajax({
                        url: './login_check',
                        type: 'POST',
                        data: JSON.stringify(data),
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            layer.close(index);
                            if (res.code === 200) {
                                layer.msg(res.msg, {
                                    icon: 6,
                                    shade: .2,
                                    time: 2000
                                }, function () {
                                    if(idx == 1){
                                        location.href = '../views/book_detail?id='+book_id;
                                    }else{
                                        location.href = '../administrator/index';
                                    }
                                })
                            } else {
                                layer.msg(res.msg, {
                                    icon: 5,
                                    shade: .2,
                                    time: 2000
                                })
                            }
                        }
                    })
                })

                // 管理员登录
                $('#admin').on('click',function (){
                    let data = form.val('form_admin'); //获取表格中的所有数据 携带name属性
                    // console.log(data);
                    if(data.account == ''){
                        layer.tips('请输入工号或账号！', '.admin',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('.admin').focus();
                        return false;
                    }
                    if(data.password == ''){
                        layer.tips('请输入密码！', '.password1',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('.password1').focus();
                        return false;
                    }
                    if(data.yzm == ''){
                        layer.tips('请输入验证码！', '.admin_yzm',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('.admin_yzm').focus();
                        return false;
                    }
                    let index = layer.load(3,{
                        shade: .2,
                        content: 'loading'
                    })
                    $.ajax({
                        url: './login_check',
                        type: 'POST',
                        data: JSON.stringify(data),
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            layer.close(index);
                            if (res.code === 200) {
                                layer.msg(res.msg, {
                                    icon: 6,
                                    shade: .2,
                                    time: 2000
                                }, function () {
                                    if(idx == 1){
                                        location.href = '../views/book_detail?id='+book_id;
                                    }else{
                                        location.href = '../administrator/index';
                                    }
                                })
                            } else {
                                layer.msg(res.msg, {
                                    icon: 5,
                                    shade: .2,
                                    time: 2000
                                })
                            }
                        }
                    })
                })

                // 用户注册，实现注册成功即登录成功
                $('#register').on('click',function (){
                    let data = form.val('form_register'); //获取表格中的所有数据 携带name属性
                    // console.log(data);
                    let reg = /^(?=.*[A-Za-z])(?=.*\d)[\S]{6,12}$/; //密码正则
                    let reg2 = /^(13[0-9]|14[01456879]|15[0-35-9]|16[2567]|17[0-8]|18[0-9]|19[0-35-9])\d{8}$/; //电话号码正则
                    if(data.name == ''){
                        layer.tips('请输入姓名！', '.name',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('.name').focus();
                        return false;
                    }
                    if(!reg2.test(data.mobile)){
                        layer.tips('手机号码输入不正确！', '.mobile',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('.mobile').focus();
                        return false;
                    }
                    if(!reg.test(data.password)){
                        layer.tips('密码必须6至12位，包含字母数字且不能包含空格！', '.password2',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('.password2').focus();
                        return false;
                    }
                    if(data.yzm == ''){
                        layer.tips('请输入验证码！', '.register_yzm',{
                            tips: [1,'#666'],
                            time: 2000
                        })
                        $('.register_yzm').focus();
                        return false;
                    }
                    let index = layer.load(3,{
                        shade: .2,
                        content: 'loading'
                    })
                    $.ajax({
                        url: './register_check',
                        type: 'POST',
                        data: JSON.stringify(data),
                        dataType: 'json',
                        success: function (res) {
                            // console.log(res);
                            layer.close(index);
                            if (res.code === 200) {
                                //显示自动关闭倒计秒数
                                layer.alert(res.msg, {
                                    btn: [],
                                    // offset: '20px',
                                    time: 5 * 1000,
                                    success: function(layero, index){
                                        let timeNum = this.time/1000
                                            , setText = function(start){
                                                layer.title((start ? timeNum : --timeNum) + ' 秒后跳转', index);
                                            };
                                        setText(!0);
                                        this.timer = setInterval(setText, 1000);
                                        if(timeNum <= 0){
                                            clearInterval(this.timer);
                                        }
                                    },
                                    end: function(){
                                        clearInterval(this.timer);
                                        //跳转后台首页
                                        location.href = '../administrator/index';
                                    }
                                })
                            } else {
                                layer.msg(res.msg, {
                                    icon: 5,
                                    shade: .2,
                                    time: 2000
                                })
                            }
                        }
                    })
                })

                // 忘记密码
                $('.forgot').on('click', function (){
                    layer.open({
                        title: '<i class="layui-icon layui-icon-refresh"></i> 重置密码',
                        type: 1,
                        area: ['430px', '470px'],
                        // offset: ['12.8%', '32%'],
                        skin: 'layui-layer-molv',
                        move: false,
                        // scrollbar: false,
                        content: $('#reset_pwd')
                    })
                })

                // 发送验证码
                $('.send_code').on('click', function (){
                    let data = form.val('form_reset'); //获取表格中的所有数据 携带name属性
                    // let mail_reg = /^[1-9][0-9]{4,}@qq.com$/;  //QQ邮箱正则
                    //邮箱正则 只允许英文字母、数字、下划线、英文句号、以及中划线组成
                    let mail_reg = /^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(.[a-zA-Z0-9_-]+)+$/;
                    // let time = Date.now();  //发送验证码的时间
                    if(data.email === ''){
                        layer.tips('邮箱不能为空！', '#email',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('#email').focus();
                    }else if(!mail_reg.test(data.email)){
                        layer.tips('邮箱格式错误！', '#email',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('#email').focus();
                    }else{
                        $.ajax({
                            url: './send_vercode',
                            type: 'POST',
                            data: {
                                email: data.email,
                                // time: time
                            },
                            dataType: 'json',
                            success: function (res) {
                                // console.log(res);
                                if(res.code === 200){
                                    layer.msg(res.msg,{
                                        time: 2000
                                    });
                                }else{
                                    layer.msg(res.msg,{
                                        time: 2000
                                    });
                                    console.log(res.error);
                                }
                            }
                        })
                    }
                })

                // 重置密码
                $('#reset').on('click', function (){
                    let data = form.val('form_reset'); //获取表格中的所有数据 携带name属性
                    // console.log(data);
                    let pwd_reg = /^(?=.*[A-Za-z])(?=.*\d)[\S]{6,12}$/; //密码正则
                    if(data.account == ''){
                        layer.tips('账号不能为空！', '.acc',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('.acc').focus();
                    }else if(data.email == ''){
                        layer.tips('邮箱不能为空！', '#email',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('#email').focus();
                    }else if(!pwd_reg.test(data.pwd)){
                        layer.tips('密码必须6至12位，包含字母数字，不能包含空格！', '#pwd',{
                            tips: [3,'#666'],
                            time: 2000
                        })
                        $('#pwd').focus();
                    }else if(data.pwd != data.pwd2){
                        layer.msg('两次密码输入不一致！',{
                            time: 2000
                        })
                    }else if(data.email_yzm == ''){
                        layer.msg('验证码不能为空！',{
                            time: 2000
                        });
                        $('.email_yzm').focus();
                    }else{
                        $.ajax({
                            url: './forgot_pwd',
                            type: 'POST',
                            data: JSON.stringify(data),
                            dataType: 'json',
                            success: function (res) {
                                // console.log(res);
                                if(res.code === 200){
                                    layer.msg(res.msg,{
                                        time: 2000
                                    }, function (){
                                        layer.closeAll('page');
                                        location.reload();
                                    })
                                }else if(res.code === 400){
                                    layer.msg(res.msg,{
                                        time: 2000
                                    })
                                }else{
                                    layer.msg(res.msg,{
                                        time: 2000
                                    }, function (){
                                        layer.closeAll('page');
                                        location.reload();
                                    })
                                }
                            }
                        })
                    }
                })
            })
        </script>
		<script type="text/javascript">
		    let message_Path = '../skin/live2d/'
		    let home_Path = 'https://lib.crayon.vip/skin/live2d/'
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
