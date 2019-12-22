<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: sueRimn
 * @Date: 2019-12-19 14:10:23
 * @LastEditors  : sueRimn
 * @LastEditTime : 2019-12-19 14:16:43
 */

// 载入配置文件
require_once '../function.php';

// 判断当前用户是否登录
en_get_current_user();

function personal_add()
{
    // 定义全局变量
    global $message, $success;

    if (empty($_POST['person'])) {
        $message = '请进行身份选择';
        return;
    }
    // 在接收信息之前，需要判断邮箱输入是否合法
    if (!(verifyEmail($_POST['email']))) {
        $message = '邮箱输入不合法';
        return;
    }
    if (empty($_POST['password'])) {
        $message = '请输入新增用户的密码';
        return;
    }

    // 校验完毕，接收数据
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

    // 数据库存储
    $row = en_excute("INSERT INTO users VALUES (NULL,'{$person_level}', '{$email}', '{$password}','{$nickname}', NULL, '{$avatar}', '{$status}');");
    $success = $row > 0;
    $message = $row <= 0 ? "注册失败" : "注册成功";
}

// 目标：拿到表单的数据提交给后台
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    personal_add();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿系统-人员添加</title>
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
                            <use xlink:href="#icon-renyuantianjia"></use>
                        </svg>人员添加
                    </strong>
                </div>
                <div class="res-content">
                    <form action="/admin/personal-add" method="post" class="per container">
                        <!-- 错误信息展示 -->
                        <div class="form-group">
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
                        <div class="form-group ">
                            <div class="row">
                                <button class="btn btn-primary">提交</button>
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
    <?php $current_page = 'personal-add'; ?>
    <!-- 侧边栏 -->
    <?php include './inc/slidebar.php'; ?>

    <script src="/static/assets/vendors/jquery/popper.min.js"></script>
    <script src="/static/assets/vendors/boostrap/js/bootstrap.min.js"></script>
    <!-- 引入字体的js -->
    <script src="//at.alicdn.com/t/font_1549825_h0ah2pwp0db.js"></script>
    <script>
        NProgress.done()
    </script>
</body>

</html>