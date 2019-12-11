<?php

//载入配置文件
require '../config.php';

//给用户创建一个箱子，会在COOKIE生成一个SESSION,用于后续判断用户
session_start();

// 接收并校验数据
// 持久化
// 响应
function login()
{

    //定义全局错误变量和成功变量
    global $message;
    // global $success;

    if (empty($_POST['email'])) {
        $message = '邮箱为空';
        return;
    }
    if (empty($_POST['password'])) {
        $message = '密码为空';
        return;
    }

    //邮箱密码都进行输入，可以进行数据校验
    //接收客户端传过来的数据
    $email = $_POST['email'];
    $password = $_POST['password'];

    //连接数据库进行数据校验
    $conn = mysqli_connect(EP_HOST, EP_USER, EP_PASS, EP_NAME);
    if (!$conn) {
        exit('<h1>连接数据库失败</h1>');
    }
    // 设置数据编码
    mysqli_set_charset($conn, 'utf8');
    
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' limit 1;");
    if (!$query) {
        $message = '登录失败，请重试';
        return;
    }

    //获取当前用户关联信息组
    $user = mysqli_fetch_assoc($query);
    if (!$user) {
        $message = '您还不是会员，请注册！';
        return;
    }
    if ($user['password'] != sha1($password)) {
        $message = '您还不是会员，请注册！';
        return;
    }

    //到此就是所有信息都已经匹配成功了
    //存一个登录标识,把得到的用户信息给SESSION这个箱子
    $_SESSION['current_login_user'] = $user;

    //一切都成功了，跳转到index
    header('Location: /admin/');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    login();
}

// 此处做退出功能，因为我在navr的退出的a链接，给了一个get传值，有action
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'logout') {
    unset($_SESSION['current_login_user']);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿系统-登录界面</title>
    <!-- 引入Bootstrap.css -->
    <link rel="stylesheet" href="/static/assets/vendors/boostrap/css/bootstrap.css">
    <!-- 引入动画css -->
    <link rel="stylesheet" href="/static/assets/vendors/animate/animate.css">
    <!-- 引入主题css -->
    <link rel="stylesheet" href="/static/assets/css/admin.css">
    <!-- 引入背景的css -->
    <link rel="stylesheet" href="/static/assets/css/bg.css">
    <!-- 引入网站ico -->
    <link rel="icon" href="/static/uploads/favicon.ico" type="image/x-icon" />
</head>

<body>
    <div class="container-login">
        <h2>投稿系统</h2>
    </div>
    <div class="login">

        <!-- autocomplete="off"是关闭浏览器自动完成输入，保证用户的隐私 -->
        <form class="login-wrap<?php echo isset($message) ? ' shake animated' : '' ?>" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">
            <!-- 用户头像 -->
            <img class="avatar" src="/static/assets/img/default.png" alt="">
            <!-- 错误消息显示区域，用bootstrap的弹窗功能完成 -->

            <?php if (isset($message)) : ?>
                <div class="alert alert-danger">
                    <strong>错误！</strong><?php echo $message; ?>
                </div>
            <?php endif ?>

            <div class="form-group">
                <label for="email" class="sr-only">邮箱</label>
                <input id="email" name="email" type="email" class="form-control" placeholder="邮箱" autofocus value="<?php echo empty($_POST['email']) ? '' : $_POST['email'] ?>">
            </div>
            <div class="form-group">
                <label for="password" class="sr-only">密码</label>
                <input id="password" name="password" type="password" class="form-control" placeholder="密码">
            </div>
            <button class="btn btn-primary btn-block" href="index.html">登 录</button>
        </form>
        <div class="sign-up">
            <span>没有账号？ <strong><a href="sign-up" class="blue-text">现在注册!</a></strong></span>
        </div>

        <!-- copyright -->
        <?php include './inc/footer.php'; ?>
        <!-- //copyright -->

    </div>
    <!-- canvas背景 -->
    <div class="stars"></div>
    <!-- 引入jquery -->
    <script src="/static/assets/vendors/jquery/jquery.js"></script>
    <!-- 引入canvas背景 -->
    <script src="/static/assets/vendors/canvas/bg.js"></script>

    <script>
        // 用一个回调函数，在DOM全部加载完毕之后，在执行
        // 简写为 $(document).ready(function())
        $(function() {
            // 目标： 用户输入完成自己的邮箱之后，在我们预设好之前的区域显示出自己的头像
            // 时机： 邮箱输入框失去了文本焦点，并且我们能够拿到其中的值
            // 事情： 把拿到的邮箱中的地址所对应的头像地址，加到Img元素上去

            // 写一个邮箱的正则表达式
            var emailFormat = /[0-9a-zA-Z]+@[0-9a-zA-Z]+\.[0-9a-zA-Z]+$/;

            $('#email').on('blur', function() {
                //获取当前文本框中的值
                $value = $(this).val();

                //test方法是js用来检测一个字符串是否匹配某个模式
                //判断文本框是否为空和是否为邮箱合法地址
                if (!$value || !emailFormat.test($value)) return;

                // 因为客户端JS无法直接操作数据库，只能通过AJAX的方式请求，告诉服务器的某个接口，通过这个接口来获取到客户端头像的地址

                $.get('/admin/api/avatar.php', {
                    email: $value
                }, function(res) {
                    //希望这个 res 对应的是头像的地址

                    if (!res) return;
                    // 展示到img元素上
                    $('.avatar').fadeOut(function() {
                        $(this).on('load', function() {
                            // 图片完全加载成功之后 注意“加载是指图片在后台已经拿到了，处理好了，不是马上就显示出来”
                            $(this).fadeIn()
                        }).attr('src', res)
                    })
                })
            })
        })
    </script>
</body>

</html>