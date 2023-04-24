<?php
    /*
     * 后台管理界面 侧边导航布局公共模板
     */
    // session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../login/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../login/login.php'</script>";
    }

    $url = basename($_SERVER['REQUEST_URI']);  //获取路径中最后一个斜杠后面的文件名
    /*
     * 查询用户类型id用来判断显示功能
     * 1001学生
     * 1002教师
     * 1003图书管理员
     * 1004超级管理员
     */
    $usertype = $_SESSION['usertype']; //用户登录时的身份
    $check_sql = "select type_id from user_type where usertype_name='$usertype'";
    $res = mysqli_query($db_connect, $check_sql);

    mysqli_close($db_connect); //关闭数据库资源
?>
        <!--side 左侧布局-->
        <?php
            while ($row = mysqli_fetch_array($res)) {
                $type_id = $row['type_id'];
        ?>
            <div class = "layui-side layui-bg-black">
                <div class = "layui-side-scroll">
                    <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                    <ul class = "layui-nav layui-nav-tree">
                        <li class = "layui-nav-item <?php if($url=='user_Info.php'||$url=='update_pwd.php'||$url=='account_del.php')echo 'layui-nav-itemed'; ?>">
                            <a class = "" href = "javascript:;"><i class = "layui-icon layui-icon-username"></i>&nbsp;&nbsp;个人中心</a>
                            <dl class = "layui-nav-child">
                                <!-- 包含注销功能(方便用户删除关于自己的信息)，删库数据 身份证，邮箱，电话，姓名，性别，学号  显示用户名（只读） -->
                                <?php
                                    if($url == 'user_Info.php'){
                                        $active =  'layui-this';
                                    }
                                    if ($type_id != 1004) {
                                        echo "<dd class=".$active."><a href='../user_center/user_Info.php'><i class='layui-icon layui-icon-username'></i>&nbsp;&nbsp;我的信息</a></dd>";
                                    }
                                ?>
                                <dd class="<?php if($url=='update_pwd.php')echo 'layui-this'; ?>"><a href = "../user_center/update_pwd.php"><i class = "layui-icon layui-icon-password"></i>&nbsp;&nbsp;修改密码</a></dd>
                                <dd class="<?php if($url=='account_del.php')echo 'layui-this'; ?>"><a href = "../user_center/account_del.php"><i class = "layui-icon layui-icon-logout"></i>&nbsp;&nbsp;账号注销</a></dd>
                            </dl>
                        </li>

                        <!-- 判断身份为超级管理员时显示 -->
                        <li class = "layui-nav-item
                        <?php
                            if ($type_id == 1004)echo "show"; else echo "hide";
                            if($url=='worker_list.php')echo ' layui-nav-itemed';
                        ?>">
                            <a href = "javascript:;"><i class = "layui-icon layui-icon-user"></i>&nbsp;&nbsp;馆员中心</a>
                            <dl class = "layui-nav-child">
                                <dd class="<?php if($url=='worker_list.php')echo 'layui-this'; ?>"><a href = "../lib_worker/worker_list.php"><i class = "layui-icon layui-icon-group"></i>&nbsp;&nbsp;馆员档案</a></dd>
                            </dl>
                        </li>

                        <!-- 学生、教师不显示 -->
                        <li class = "layui-nav-item
                        <?php
                            if ($type_id == 1003 || $type_id == 1004)echo "show"; else echo "hide";
                            if($url=='reader_list.php'||$url=='reader_kind.php')echo ' layui-nav-itemed';
                        ?>">
                            <a href = "javascript:;"><i class = "layui-icon layui-icon-user"></i>&nbsp;&nbsp;读者中心</a>
                            <dl class = "layui-nav-child">
                                <dd class="<?php if($url=='reader_list.php')echo 'layui-this'; ?>"><a href = "../reader/reader_list.php"><i class = "layui-icon layui-icon-group"></i>&nbsp;&nbsp;读者档案</a></dd>
                                <dd class="<?php if($url=='reader_kind.php')echo 'layui-this'; ?>"><a href = "../reader/reader_kind.php"><i class = "layui-icon layui-icon-cols"></i>&nbsp;&nbsp;&nbsp;读者类型</a></dd>
                            </dl>
                        </li>

                        <li class = "layui-nav-item <?php if($url=='book_list.php'||$url=='book_search.php'||$url=='rank_book.php'||$url=='book_kind.php'||$url=='book_stack.php')echo 'layui-nav-itemed'; ?>">
                            <a href = "javascript:;"><i class = "layui-icon layui-icon-read"></i>&nbsp;&nbsp;图书管理</a>
                            <dl class = "layui-nav-child">
                                <!-- 图书查询包含id、书名、ISBN、类别、作者、出版社、图书价格、数量、是否借出状态、书本介绍、添加日期、图书封面、更新日期、存放位置 -->
                                <dd class="<?php if($url=='book_list.php')echo 'layui-this'; ?>"><a href = "../books_center/book_list.php"><i class = "layui-icon layui-icon-read"></i>&nbsp;&nbsp;馆藏图书</a></dd>
                                <dd class="<?php if($url=='book_search.php')echo 'layui-this'; ?>"><a href = "../books_center/book_search.php"><i class = "layui-icon layui-icon-search"></i>&nbsp;&nbsp;图书查询</a></dd>
                                <!-- 图书点击量，借阅次数 -->
                                <dd class="<?php if($url=='rank_book.php')echo 'layui-this'; ?>"><a href = "../books_center/rank_book.php"><i class = "layui-icon layui-icon-praise"></i>&nbsp;&nbsp;人气图书</a></dd>
                                <?php
                                    if($url == 'book_kind.php'){
                                        $active1 =  'layui-this';
                                    }
                                    if ($type_id == 1003 || $type_id == 1004) {
                                        echo "<dd class=".$active1."><a href='../books_center/book_kind.php'><i class='layui-icon layui-icon-form'></i>&nbsp;&nbsp;图书类别</a></dd>";
                                    }
                                ?>
                                <!-- 包含查询，书库名，编号，位置 -->
                                <dd class="<?php if($url=='book_stack.php')echo 'layui-this'; ?>"><a href = "../books_center/book_stack.php"><i class = "layui-icon layui-icon-diamond"></i>&nbsp;&nbsp;书库信息</a></dd>
                            </dl>
                        </li>
                        <li class = "layui-nav-item <?php if($url=='borrowBook.php'||$url=='renewBook.php'||$url=='returnBook.php'||$url=='record_search.php')echo 'layui-nav-itemed'; ?>">
                            <a href = "javascript:;"><i class = "layui-icon layui-icon-template-1"></i>&nbsp;&nbsp;流通管理</a>
                            <dl class = "layui-nav-child">
                                <dd class="<?php if($url=='borrowBook.php')echo 'layui-this'; ?>"><a href = "../books_circulation/borrowBook.php"><i class = "layui-icon layui-icon-release"></i>&nbsp;&nbsp;图书借阅</a></dd>
                                <!-- 续借操作，每次完成续借时间推迟7天  -->
                                <dd class="<?php if($url=='renewBook.php')echo 'layui-this'; ?>"><a href = "../books_circulation/renewBook.php"><i class = "layui-icon layui-icon-refresh"></i>&nbsp;&nbsp;图书续借</a></dd>
                                <dd class="<?php if($url=='returnBook.php')echo 'layui-this'; ?>"><a href = "../books_circulation/returnBook.php"><i class = "layui-icon layui-icon-prev-circle"></i>&nbsp;&nbsp;图书归还</a></dd>
                                <?php
                                    if($url == 'record_search.php'){
                                        $active2 =  'layui-this';
                                    }
                                    if ($type_id == 1003 || $type_id == 1004) {
                                        echo "<dd class=".$active2."><a href='../books_circulation/record_search.php'><i class='layui-icon layui-icon-search'></i>&nbsp;&nbsp;记录查询</a></dd>";
                                    }
                                ?>
                                <dd><a href = "javascript:;"><i class = "layui-icon layui-icon-edit"></i>&nbsp;&nbsp;丢失登记</a></dd>
                            </dl>
                        </li>

                        <!-- 评论只允许管理员和超级管理员查看 -->
                        <li class = "layui-nav-item
                        <?php
                            if ($type_id == 1003 || $type_id == 1004)echo "show"; else echo "hide";
                            if($url=='comment_center.php'||$url=='comment_control.php'||$url=='news_notice.php')echo ' layui-nav-itemed';
                        ?>">
                            <a href = "javascript:;"><i class = "layui-icon layui-icon-dialogue"></i>&nbsp;&nbsp;评论管理</a>
                            <dl class = "layui-nav-child">
                                <dd class="<?php if($url=='comment_center.php')echo 'layui-this'; ?>"><a href = "../comment/comment_center.php"><i class = "layui-icon layui-icon-reply-fill"></i>&nbsp;&nbsp;评论中心</a></dd>
                                <dd class="<?php if($url=='comment_control.php')echo 'layui-this'; ?>"><a href = "../comment/comment_control.php"><i class = "layui-icon layui-icon-set-fill"></i>&nbsp;&nbsp;评论风控</a></dd>
                                <dd class="<?php if($url=='news_notice.php')echo 'layui-this'; ?>"><a href = '../comment/news_notice.php'><i class = 'layui-icon layui-icon-speaker'></i>&nbsp;&nbsp;新闻公告</a></dd>
                            </dl>
                        </li>

                        <!-- 仅超级管理员显示权限管理 -->
                        <li class = "layui-nav-item <?php if($url=='rights_center.php'||$url=='feedBack.php'||$url=='sysInfo.php')echo 'layui-nav-itemed'; ?>">
                            <a href = "javascript:;"><i class = "layui-icon layui-icon-console"></i>&nbsp;&nbsp;系统维护</a>
                            <dl class = "layui-nav-child">
                                <?php
                                    if($url == 'rights_center.php'){
                                        $active3 =  'layui-this';
                                    }
                                    if ($type_id == 1004) {
                                        echo "<dd class=".$active3."><a href='../system/rights_center.php'><i class='layui-icon layui-icon-tabs'></i>&nbsp;&nbsp;权限管理</a></dd>";
                                    }
                                ?>
                                <dd class="<?php if($url=='feedBack.php')echo 'layui-this'; ?>"><a href = '../system/feedBack.php'><i class = 'layui-icon layui-icon-survey'></i>&nbsp;&nbsp;意见反馈</a></dd>
                                <dd class="<?php if($url=='sysInfo.php')echo 'layui-this'; ?>"><a href = "../system/sysInfo.php"><i class = "layui-icon layui-icon-about"></i>&nbsp;&nbsp;系统信息</a></dd>
                            </dl>
                        </li>

                        <li class = "layui-nav-item
                        <?php
                            if ($type_id == 1004)echo "show"; else echo "hide";
                        ?>">
                            <a href = "javascript:;"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;调试链接</a>
                            <dl class = "layui-nav-child">
                                <dd><a href = "http://swz.crayon.vip/" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;书丸子官网PC</a></dd>
                                <dd><a href = "http://m.swz.crayon.vip/" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;书丸子官网WAP</a></dd>
                                <dd><a href = "http://43.139.94.135:1011/" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;服务器root</a></dd>
                                <dd><a href = "http://chat.crayon.vip" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;WebScoketChat</a></dd>
                            </dl>
                        </li>
                        <li class = "layui-nav-item"><a href = "https://ymck.me" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;友情链接</a></li>
                        <li class = "layui-nav-item"><a href = "https://ruancang.net" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;友情链接</a></li>
                        <li class = "layui-nav-item"><a href = "https://www.qijishow.com" target = "_blank"><i class = "layui-icon layui-icon-util"></i>&nbsp;&nbsp;小工具</a></li>
                        <li class = "layui-nav-item"><a href = "javascript:;" id = "aircondition"><i class = "layui-icon layui-icon-util"></i>&nbsp;&nbsp;便携小空调</a></li>
                    </ul>
                </div>
            </div>
        <?php
            }
        ?>

