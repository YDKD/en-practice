<?php

// 载入配置文件
require_once '../function.php';

// 判断当前用户是否登录
en_get_current_user();

function reset_pass()
{
    // 表单验证三步， 
    // 接收并数据
    // 持久化
    // 响应

    // 定义全局变量
    global $message, $success;
    // 判断信息
    if (empty($_POST['mpass'])) {
        $message = '原始密码不能为空';
        return;
    }

    if (empty($_POST['newpass'])) {
        $message = '新密码不能为空';
        return;
    }

    if (empty($_POST['confirm'])) {
        $message = '确认密码不能为空';
        return;
    }

    // 拿到当前用户的信息
    $current_user = en_get_current_user();

    // 拿到当前用户的id值
    $id = $current_user['id'];

    // 拿到原始用户的密码,但是原始密码进行了加密的，要注意
    $original_pass = $current_user['password'];
    echo $current_user['password'];
    //判断当前用户提交的原始密码正确
    if (sha1($_POST['mpass']) != $original_pass) {
        $message = '原始密码输入错误';
        return;
    }
    // 判断表单提交的数据两次密码是否一致
    if ($_POST['newpass'] != $_POST['confirm']) {
        $message = '两次密码输入不一致';
        return;
    }

    // 到此，表单验证结束，接收用户传来的数据，不要忘记数据加密
    $result = $_POST['newpass'];
    $newpass = sha1($result);

    // 更新数据
    $row = en_excute("UPDATE users SET `password` = '{$newpass}' WHERE id = '{$id}';");
    // 更新用户信息
    update_session($id);
    $success = $row > 0;
    $message = $row > 0 ? '密码修改成功' : '密码修改失败';
}

// 判断当前用户提交信息的方式
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    reset_pass();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿系统-修改密码</title>
    <!-- 引入Bootstrap.css -->
    <link rel="stylesheet" href="/static/assets/vendors/boostrap/css/bootstrap.css">
    <!-- 引入动画css -->
    <link rel="stylesheet" href="/static/assets/vendors/animate/animate.css">
    <!-- 引入进度条css -->
    <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
    <!-- 引入字体图标 -->
    <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.min.css" <!-- 引入主题css -->
    <link rel="stylesheet" href="/static/assets/css/admin.css">
    <!-- 引入网站ico -->
    <link rel="icon" href="/static/uploads/favicon.ico" type="image/x-icon" />
    <!-- 引入进度条显示js -->
    <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
    <!-- 引入jquery -->
    <script src="/static/assets/vendors/jquery/jquery.js"></script>
    <!-- 引入pintuer.js的框架验证 -->
    <script src="/static/assets/vendors/pintuer/pintuer.js"></script>
</head>

<body>
    <script>
        NProgress.start()
    </script>
    <div class="main">
        <!-- 导航栏 -->
        <?php include 'inc/navbar.php' ?>
        <!-- 中间显示区 -->
        <div class="container-fluid">
            <div class="reset">
                <div class="res-head">
                    <strong>
                        <svg class="icon" aria-hidden="true" style="margin-right: 4px;">
                            <use xlink:href="#icon-xiugaimima1"></use>
                        </svg>修改会员密码
                    </strong>
                </div>
                <div class="res-content">
                    <form action="/admin/reset-pass" method="post">
                        <!-- 错误信息展示 -->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">

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

                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <label id="username" class="col-sm-2 control-label">当前账号:</label>
                                <div class="field">
                                    <span><?php echo $current_user['email']; ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group put clearfix">
                            <div class="row">
                                <label id="username" class="col-sm-2 control-label">原始密码:</label>
                                <div class="field col-sm-10">
                                    <input type="password" class="form-control" id="mpass" name="mpass" size="50" placeholder="请输入原始密码" data-validate="required:请输入原始密码" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group put clearfix">
                            <div class="row">
                                <label id="username" class="col-sm-2 control-label">新密码:</label>
                                <div class="field col-sm-10">
                                    <input type="password" class="form-control" id="newpass" name="newpass" size="50" placeholder="请输入新密码" data-validate="required:请输入新密码,length#>=5:新密码不能小于5位" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group put clearfix">
                            <div class="row">
                                <label id="username" class="col-sm-2 control-label">确认密码:</label>
                                <div class="field col-sm-10">
                                    <input type="password" class="form-control" id="confirm" name="confirm" size="50" placeholder="请再次输入新密码" data-validate="required:请再次输入新密码,repeat#newpass:两次输入的密码不一致" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group put update">
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    <button class="btn btn-primary">提交</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 底部版权 -->
        <!-- <?php include './inc/footer.php'; ?> -->
    </div>
    <!-- 给当前界面定义一个变量，用于后续点到那个界面做高亮显示 -->
    <?php $current_page = 'reset-pass'; ?>
    <!-- 侧边栏 -->
    <?php include './inc/slidebar.php'; ?>

    <script src="/static/assets/vendors/jquery/popper.min.js"></script>
    <script src="/static/assets/vendors/boostrap/js/bootstrap.min.js"></script>
    <!-- 引入字体的js -->
    <script src="//at.alicdn.com/t/font_1549825_2clf5pue9ge.js"></script>
    <script>
        NProgress.done()
    </script>
</body>

</html>