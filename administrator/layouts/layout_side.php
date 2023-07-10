<?php
    /*
     * 后台管理界面 侧边导航布局公共模板
     */
    session_save_path('../../session/');
    session_start();
    include '../../config/conn.php';
    include '../../oauth/session_time.php';
    if ($_SESSION['is_login'] != 2) {
        echo "<script>alert('sorry，您似乎还没有登录！');location.href='../../oauth/login'</script>";
    }

    //获取路径中最后一个斜杠后面的文件名，用来判断当前是在哪一个页面，显示状态layui-this
    $url = basename($_SERVER['REQUEST_URI']);
    /*
     * 查询用户类型id用来判断显示默认权限功能
     * 1001 学生
     * 1002 教师
     * 1003 图书管理员
     * 1004 超级管理员
     * 1005 校外人员
     * 1006 其他
     */
    // 第一级判断，根据身份显示默认的权限功能
    $usertype = $_SESSION['usertype']; //用户登录时的身份
    $check_sql = "select * from user_type where usertype_name='$usertype'";
    $check_res = mysqli_query($db_connect, $check_sql);
    $row = mysqli_fetch_array($check_res);

    /*
     * 查询动态分配权限后显示的功能（0无权限，1有权限）
     * lib_worker       馆员档案
     * reader_list      读者档案
     * reader_kind      读者类型
     * book_kind        图书类型
     * borrowBook       图书借阅 （假如关闭借阅功能，图书中心的借阅点击也会被拒绝）
     * renewBook        图书续借 （不考虑）
     * returnBook       图书归还 （不考虑）
     * record_search    借阅记录查询
     * comment_center   评论中心审批
     * news_notice      新闻公告发布
     * feedBack         用户反馈查询（意见建议）
     * rights_center    权限分配
     */
    // 第二级判断，根据配的权限显示或隐藏功能
    $user_id = $_SESSION['user_id']; //用户id
    $rights_sql = "select * from rights where id='$user_id'";
    $rights_res = mysqli_query($db_connect, $rights_sql);
    $item = mysqli_fetch_array($rights_res);

    mysqli_close($db_connect); //关闭数据库资源
?>
        <!--side 左侧布局-->
        <div class = "layui-side layui-bg-black">
            <div class = "layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class = "layui-nav layui-nav-tree">
                    <li class = "layui-nav-item <?php if($url=='user_Info'||$url=='update_pwd'||$url=='account_del')echo 'layui-nav-itemed'; ?>">
                        <a class = "" href = "javascript:;"><i class = "layui-icon layui-icon-username"></i>&nbsp;&nbsp;个人中心</a>
                        <dl class = "layui-nav-child">
                            <!-- 包含注销功能(方便用户删除关于自己的信息)，删库数据 身份证，邮箱，电话，姓名，性别，学号  显示用户名（只读） -->
                            <?php
                                if($url == 'user_Info') $a = 'layui-this';
                                if ($row['type_id'] != 1004) {
                                    echo "<dd class=".$a."><a href='../user_center/user_Info'><i class='layui-icon layui-icon-username'></i>&nbsp;&nbsp;我的信息</a></dd>";
                                }
                            ?>
                            <dd class="<?php if($url=='update_pwd')echo 'layui-this'; ?>"><a href = "../user_center/update_pwd"><i class = "layui-icon layui-icon-password"></i>&nbsp;&nbsp;修改密码</a></dd>
                            <dd class="<?php if($url=='account_del')echo 'layui-this'; ?>"><a href = "../user_center/account_del"><i class = "layui-icon layui-icon-logout"></i>&nbsp;&nbsp;账号注销</a></dd>
                        </dl>
                    </li>

                    <!-- 超级管理员时显示 -->
                    <li class = "layui-nav-item
                    <?php
                        if ($item['lib_worker'] == 1)echo "layui-show"; else echo "layui-hide";
                        if($url=='worker_list')echo ' layui-nav-itemed';
                    ?>">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-user"></i>&nbsp;&nbsp;馆员中心</a>
                        <dl class = "layui-nav-child">
                            <dd class="<?php if($url=='worker_list')echo 'layui-this'; ?>"><a href = "../lib_worker/worker_list"><i class = "layui-icon layui-icon-group"></i>&nbsp;&nbsp;馆员档案</a></dd>
                        </dl>
                    </li>

                    <!-- 学生、教师不显示 -->
                    <li class = "layui-nav-item
                    <?php
                        if ($item['reader_list'] == 1 || $item['reader_kind'] == 1)echo "layui-show"; else echo "layui-hide";
                        if($url=='reader_list'||$url=='reader_kind')echo ' layui-nav-itemed';
                    ?>">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-user"></i>&nbsp;&nbsp;读者中心</a>
                        <dl class = "layui-nav-child">
                            <?php
                                if ($item['reader_list'] == 1){
                                    if($url=='reader_list') $b = 'layui-this';
                                    echo "<dd class=".$b."><a href = '../reader/reader_list'><i class = 'layui-icon layui-icon-group'></i>&nbsp;&nbsp;读者档案</a></dd>";
                                }
                                if($item['reader_kind'] == 1){
                                    if($url=='reader_kind') $c = 'layui-this';
                                    echo "<dd class=".$c."><a href = '../reader/reader_kind'><i class = 'layui-icon layui-icon-cols'></i>&nbsp;&nbsp;&nbsp;读者类型</a></dd>";
                                }
                            ?>
                        </dl>
                    </li>

                    <li class = "layui-nav-item <?php if($url=='book_list'||$url=='book_search'||$url=='rank_book'||$url=='book_kind'||$url=='book_stack')echo 'layui-nav-itemed'; ?>">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-read"></i>&nbsp;&nbsp;图书管理</a>
                        <dl class = "layui-nav-child">
                            <!-- 图书查询包含id、书名、ISBN、类别、作者、出版社、图书价格、数量、是否借出状态、书本介绍、添加日期、图书封面、更新日期、存放位置 -->
                            <dd class="<?php if($url=='book_list')echo 'layui-this'; ?>"><a href = "../books_center/book_list"><i class = "layui-icon layui-icon-read"></i>&nbsp;&nbsp;馆藏图书</a></dd>
                            <dd class="<?php if($url=='book_search')echo 'layui-this'; ?>"><a href = "../books_center/book_search"><i class = "layui-icon layui-icon-search"></i>&nbsp;&nbsp;图书查询</a></dd>
                            <!-- 图书点击量，借阅次数 -->
                            <dd class="<?php if($url=='rank_book')echo 'layui-this'; ?>"><a href = "../books_center/rank_book"><i class = "layui-icon layui-icon-praise"></i>&nbsp;&nbsp;人气图书</a></dd>
                            <?php
                                if($url == 'book_kind') $d = 'layui-this';
                                if ($item['book_kind'] == 1) {
                                    echo "<dd class=".$d."><a href='../books_center/book_kind'><i class='layui-icon layui-icon-form'></i>&nbsp;&nbsp;图书类别</a></dd>";
                                }
                            ?>
                            <!-- 包含查询，书库名，编号，位置 -->
                            <dd class="<?php if($url=='book_stack')echo 'layui-this'; ?>"><a href = "../books_center/book_stack"><i class = "layui-icon layui-icon-diamond"></i>&nbsp;&nbsp;书库信息</a></dd>
                        </dl>
                    </li>
                    <li class = "layui-nav-item <?php if($url=='borrowBook'||$url=='renewBook'||$url=='returnBook'||$url=='record_search')echo 'layui-nav-itemed'; ?>">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-template-1"></i>&nbsp;&nbsp;流通管理</a>
                        <dl class = "layui-nav-child">
                            <?php
                                if($url == 'borrowBook') $e = 'layui-this';
                                if ($item['borrowBook'] == 1) {
                                    echo "<dd class=".$e."><a href='../books_circulation/borrowBook'><i class='layui-icon layui-icon-release'></i>&nbsp;&nbsp;图书借阅</a></dd>";
                                }
                            ?>
                            <!-- 续借操作，每次完成续借时间推迟7天  -->
                            <dd class="<?php if($url=='renewBook')echo 'layui-this'; ?>"><a href = "../books_circulation/renewBook"><i class = "layui-icon layui-icon-refresh"></i>&nbsp;&nbsp;图书续借</a></dd>
                            <dd class="<?php if($url=='returnBook')echo 'layui-this'; ?>"><a href = "../books_circulation/returnBook"><i class = "layui-icon layui-icon-prev-circle"></i>&nbsp;&nbsp;图书归还</a></dd>
                            <?php
                                if($url == 'record_search') $f = 'layui-this';
                                if ($item['record_search'] == 1) {
                                    echo "<dd class=".$f."><a href='../books_circulation/record_search'><i class='layui-icon layui-icon-search'></i>&nbsp;&nbsp;记录查询</a></dd>";
                                }
                            ?>
                            <!--<dd><a href = "javascript:;"><i class = "layui-icon layui-icon-edit"></i>&nbsp;&nbsp;丢失登记</a></dd>-->
                        </dl>
                    </li>

                    <!-- 评论只允许管理员和超级管理员查看 -->
                    <li class = "layui-nav-item
                    <?php
                        if ($item['comment_center'] == 1 || $item['comment_control'] == 1 || $item['news_notice'] == 1)echo "layui-show"; else echo "layui-hide";
                        if($url=='comment_center'||$url=='comment_control'||$url=='news_notice')echo ' layui-nav-itemed';
                    ?>">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-dialogue"></i>&nbsp;&nbsp;评论管理</a>
                        <dl class = "layui-nav-child">
                            <?php
                                if ($item['comment_center'] == 1){
                                    if($url=='comment_center') $g = 'layui-this';
                                    echo "<dd class=".$g."><a href = '../comment/comment_center'><i class = 'layui-icon layui-icon-reply-fill'></i>&nbsp;&nbsp;评论中心</a></dd>";
                                }
                                if($item['news_notice'] == 1){
                                    if($url=='news_notice') $h = 'layui-this';
                                    echo "<dd class=".$h."><a href = '../comment/news_notice'><i class = 'layui-icon layui-icon-speaker'></i>&nbsp;&nbsp;新闻公告</a></dd>";
                                }
                            ?>
                            <!--<dd class="--><?php //if($url=='comment_control')echo 'layui-this'; ?><!--"><a href = "../comment/comment_control"><i class = "layui-icon layui-icon-set-fill"></i>&nbsp;&nbsp;评论风控</a></dd>-->
                        </dl>
                    </li>

                    <!-- 仅超级管理员显示权限管理 -->
                    <li class = "layui-nav-item <?php if($url=='rights_center'||$url=='feedBack'||$url=='sysInfo')echo 'layui-nav-itemed'; ?>">
                        <a href = "javascript:;"><i class = "layui-icon layui-icon-console"></i>&nbsp;&nbsp;关于系统</a>
                        <dl class = "layui-nav-child">
                            <?php
                                if ($item['rights_center'] == 1) {
                                    if($url == 'rights_center') $i = 'layui-this';
                                    echo "<dd class=".$i."><a href='../system/rights_center'><i class='layui-icon layui-icon-tabs'></i>&nbsp;&nbsp;权限管理</a></dd>";
                                }
                                if ($item['feedBack'] == 1) {
                                    if($url == 'feedBack') $j = 'layui-this';
                                    echo "<dd class=".$j."><a href='../system/feedBack'><i class='layui-icon layui-icon-survey'></i>&nbsp;&nbsp;意见反馈</a></dd>";
                                }
                            ?>
                            <dd class="<?php if($url=='sysInfo')echo 'layui-this'; ?>"><a href = "../system/sysInfo"><i class = "layui-icon layui-icon-about"></i>&nbsp;&nbsp;系统信息</a></dd>
                        </dl>
                    </li>

                    <!--<li class = "layui-nav-item-->
                    <?php
                    //     if ($row['type_id'] == 1004)echo "layui-show"; else echo "layui-hide";
                    // ?><!--">-->
                    <!--    <a href = "javascript:;"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;调试链接</a>-->
                    <!--    <dl class = "layui-nav-child">-->
                    <!--        <dd><a href = "http://swz.crayon.vip/" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;书丸子官网PC</a></dd>-->
                    <!--        <dd><a href = "http://m.swz.crayon.vip/" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;书丸子官网WAP</a></dd>-->
                    <!--        <dd><a href = "http://43.139.94.135:1011/" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;服务器root</a></dd>-->
                    <!--        <dd><a href = "http://chat.crayon.vip" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;WebScoketChat</a></dd>-->
                    <!--    </dl>-->
                    <!--</li>-->
                    <li class = "layui-nav-item"><a href = "https://ymck.me" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;友情链接</a></li>
                    <li class = "layui-nav-item"><a href = "https://ruancang.net" target = "_blank"><i class = "layui-icon layui-icon-link"></i>&nbsp;&nbsp;友情链接</a></li>
                    <li class = "layui-nav-item"><a href = "https://www.qijishow.com" target = "_blank"><i class = "layui-icon layui-icon-util"></i>&nbsp;&nbsp;小工具</a></li>
                    <li class = "layui-nav-item"><a href = "javascript:;" id = "aircondition"><i class = "layui-icon layui-icon-util"></i>&nbsp;&nbsp;便携小空调</a></li>
                </ul>
            </div>
        </div>
