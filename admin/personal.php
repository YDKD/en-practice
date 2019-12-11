<?php
//首先载入配置文件
require '../function.php';

//先判断是否登录了，再进行后续
en_get_current_user();

//拿到登录用户的数据
$current_user = en_get_current_user();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿系统-首页</title>
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
            <div class="page-title text-center">
                <h3>我的个人资料</h3>
            </div>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" class="message">
                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-3 control-label">头像</label>
                        <div class="col-sm-6">
                            <label class="form-image">
                                <input id="avatar" type="file">
                                <img src="<?php echo $current_user['avatar']; ?>">
                                <i class="mask fa fa-upload"></i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="level" class="col-sm-3 control-label">级别</label>
                        <div class="col-sm-6">
                            <input id="level" class="form-control" name="level" type="type" value="管理员" placeholder="level" readonly>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="email" class="col-sm-3 control-label">邮箱</label>
                        <div class="col-sm-6">
                            <input id="email" class="form-control" name="email" type="type" value="w@zce.me" placeholder="邮箱" readonly>
                            <p class="help-block">登录邮箱不允许修改</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="nickname" class="col-sm-3 control-label">昵称</label>
                        <div class="col-sm-6">
                            <input id="nickname" class="form-control" name="nickname" type="type" value="YDKD" placeholder="昵称">
                            <p class="help-block">限制在 2-16 个字符</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="bio" class="col-sm-3 control-label">简介</label>
                        <div class="col-sm-6">
                            <textarea id="bio" class="form-control" placeholder="Bio" cols="30" rows="6">Practice Perfect！</textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group update">
                    <div class="row">
                        <div class="col-sm-3 control-label"></div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary">更新</button>
                            <a class="pas" href="password-reset.html">修改密码</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- 底部版权 -->
        <!-- <?php include './inc/footer.php'; ?> -->
    </div>
    <!-- 给当前界面定义一个变量，用于后续点到那个界面做高亮显示 -->
    <?php $current_page = 'personal'; ?>
    <!-- 侧边栏 -->
    <?php include './inc/slidebar.php'; ?>

    <!-- 引入jquery -->
    <script src="/static/assets/vendors/jquery/jquery.js"></script>
    <script src="/static/assets/vendors/jquery/popper.min.js"></script>
    <script src="/static/assets/vendors/boostrap/js/bootstrap.min.js"></script>
    <!-- 引入字体的js -->
    <script src="/static/assets/vendors/font/iconfont.js"></script>
    <script>
        NProgress.done()
    </script>
</body>

</html>