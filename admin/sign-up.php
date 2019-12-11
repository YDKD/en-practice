<?php

//载入配置文件
require '../function.php';


function sign_up()
{
    // 接受并校验数据
    // 持久化
    // 做出响应

    //定义全局变量用于存放错误信息
    global $message;
    global $success;
    // 通过定义一个数组，判断用户提交过来中是否含有这三个参数值，即每个参数值对应了一个角色，来判断用户是否选择了角色进行注册。
    $per_array = array(1, 2, 3);
    if (!(in_array($_POST['person'], $per_array))) {
        $message = '请输入你注册的角色';
        return;
    }

    if (empty($_POST['email'])) {
        $message = '请输入注册邮箱';
        return;
    }

    if (empty($_POST['password'])) {
        $message = '请输入您的注册密码';
        return;
    }

    // 在接收信息之前，需要判断邮箱输入是否合法
    if (!(verifyEmail($_POST['email']))) {
        $message = '邮箱输入不合法';
        return;
    }
    // 信息全部填好，用变量接收，方便后续操作
    $person_level = $_POST['person'];
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    // 此处根据person_level，不同的角色对其昵称和头像地址做出了判断
    $nickname = '管理员';
    $status = 'actived';
    $avatar = '/static/assets/img/admin.jpg';
    switch ($person_level) {
        case "1":
            $nickname = '管理员';
            $avatar = '/static/uploads/admin.jpg';
            break;
        case "2":
            $nickname = '专家';
            $avatar = '/static/uploads/specialist.jpg';
            break;
        case "3":
            $nickname = '作者';
            $avatar = '/static/uploads/author.png';
            break;
    }

    //当客户端提交过来完整的表单信息就应该进行数据校验
    //连接数据库进行数据库存储
    // 插入数据
    $row = en_excute("INSERT INTO users VALUES (NULL,'{$person_level}', '{$email}', '{$password}','{$nickname}', NULL, '{$avatar}', '{$status}');");
    $success = $row > 0;
    $message = $row <= 0 ? "注册失败" : "注册成功";
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    sign_up();
}

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>投稿系统-注册界面</title>
        <!-- 引入Bootstrap.css -->
        <link rel="stylesheet" href="/static/assets/vendors/boostrap/css/bootstrap.css">
        <!-- 引入主题css -->
        <link rel="stylesheet" href="/static/assets/css/admin.css">
        <!-- 引入animate -->
        <link rel="stylesheet" href="/static/assets/vendors/animate/animate.css">
        <!-- 引入背景的css -->
        <link rel="stylesheet" href="/static/assets/css/bg.css">
        <!-- 引入网站ico -->
        <link rel="icon" href="/static/uploads/favicon.ico" type="image/x-icon" />
    </head>

    <body>
        <div class="container-sign">
            <h2>投稿系统</h2>
        </div>
        <div class="sign">

            <!-- autocomplete="off"是关闭浏览器自动完成输入，保证用户的隐私 -->
            <form class="sign-wrap<?php echo isset($message) ? ' tada animated' : '' ?>" action="/admin/sign-up" method="post" autocomplete="off">

                <?php if (isset($message)) : ?>
                    <?php if ($success) : ?>
                        <div class="alert alert-success">
                            <strong>成功！</strong><?php echo $message; ?>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-danger">
                            <strong>错误！</strong><?php echo $message; ?>
                        </div>
                    <?php endif ?>
                <?php endif ?>

                <div class="form-group">
                    <select class="custom-select my-1 mr-sm-2" id="person" name="person">
                        <option selected>身份选择</option>
                        <option value="1">管理员</option>
                        <option value="2">专家</option>
                        <option value="3">作者</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email" class="sr-only">邮箱</label>
                    <input id="email" name="email" type="email" class="form-control" placeholder="邮箱" autofocus value="">
                </div>
                <div class="form-group">
                    <label for="password" class="sr-only">密码</label>
                    <input id="password" name="password" type="password" class="form-control" placeholder="密码">
                </div>
                <button class="btn btn-primary btn-block" href="index.html">注 册</button>
            </form>
            <div class="sign-up">
                <span>注册完成 <strong><a href="login" class="blue-text">去登陆!</a></strong></span>
            </div>
            <!-- copyright -->
            <div class="footer text-center">
                <p>地址：四川省成都市高兴西区百叶路1号 邮编：611731 | 开发者：YDKD</p>
                <p>Copyright &copy; 2019 YDKD版权所有 | 非经营性网站备案编号：蜀ICP备19013726号</p>
                <p><a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=51012402000372"><i></i>川公安网备 51012402000372号</a></p>
            </div>
            <!-- //copyright -->
        </div>
        <div class="stars"></div>
        <!-- 引入jquery -->
        <script src="/static/assets/vendors/jquery/jquery.js"></script>
        <!-- 引入popper -->
        <script src="/static/assets/vendors/jquery/popper.min.js"></script>
        <!-- 引入Bootstrap -->
        <script src="/static/assets/vendors/boostrap/js/bootstrap.min.js"></script>
        <!-- 引入canvas背景 -->
        <script src="/static/assets/vendors/canvas/bg.js"></script>
    </body>

    </html>