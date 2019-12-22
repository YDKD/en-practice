<?php
//首先载入配置文件
require_once '../function.php';

//先判断是否登录了，再进行后续
en_get_current_user();

function personal()
{
    // 定义全局变量
    global $message, $success, $bio;

    // 获取当前登录用户信息
    $current_user = en_get_current_user();

    //接收用户ID，为了后续的更新操作
    $id = $current_user['id'];

    // 头像更改
    // 接收文件传过来的数据
    // if(empty($_FILES['avatar'])) {
    //     $message = '请正确提交文件';
    //     return;
    // }

    // 默认是存在头像的，所以如果需要修改头像，直接接收头像地址
    $avatar_source = $_FILES['avatar'];
    // 判断用户是否选择了文件
    if($avatar_source === UPLOAD_ERR_OK) {
        $message = '请选择头像地址';
        return;
    }
    
    $houzhui = pathinfo($avatar_source['name']);
    // 上传成功，接收文件
    $target = '../static/uploads/' . uniqid() . '.' . $houzhui['extension'];
    if(!move_uploaded_file($avatar_source['tmp_name'], $target)) {
        $message = '头像更新失败';
        return;
    }

    $result = substr($target, 2);

    //接收用户传过来的级别和简介
    $bio =  empty($_POST['bio']) ? $current_user['bio'] : $_POST['bio'];

    $row = en_excute("UPDATE users SET  bio = '{$bio}', avatar = '{$result}' WHERE id = '{$id}'; ");

    // 更新用户信息因为我的混编中的，始终拿到的是初始的session中的值，必须进行更新，把更新后的信息同步到session中，才可以在界面更新新。
    update_session($id);
    
    $success = $row > 0;
    $message = $row <= 0 ? '更新失败' : '更新成功';

   
}

// 首先判断当前用户提交的数据方式
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    personal();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿系统-个人中心</title>
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
            <div class="page-title text-center">
                <h3>我的个人资料</h3>
            </div>
            <form action="/admin/personal" class="message" method="POST" enctype="multipart/form-data">
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
                        <label class="col-sm-3 control-label">头像</label>
                        <div class="col-sm-6">
                            <label class="form-image">
                                <input id="avatar" type="file" name="avatar">
                                <img src="<?php echo $current_user['avatar']; ?>" width="150" height="150">
                                <i class="mask fa fa-upload"></i>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="level" class="col-sm-3 control-label">级别</label>
                        <div class="col-sm-6">
                            <input id="level" class="form-control" name="level" type="type" value="<?php echo $current_user['nickname']; ?>" placeholder="level" readonly>
                            <p class="help-block">当前级别不允许修改</p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <label for="email" class="col-sm-3 control-label">邮箱</label>
                        <div class="col-sm-6">
                            <input id="email" class="form-control" name="email" type="type" value="<?php echo $current_user['email']; ?>" placeholder="邮箱" readonly>
                            <p class="help-block">登录邮箱不允许修改</p>
                        </div>
                    </div>
                </div>
                <div class="form-group put">
                    <div class="row">
                        <label for="bio" class="col-sm-3 control-label">简介</label>
                        <div class="col-sm-6 field">
                            <textarea id="bio" class="form-control" data-validate="required:简介不能为空" cols="30" rows="6" name="bio" placeholder="<?php echo $_SESSION['bio']; ?>"><?php echo empty($_POST['bio']) ? '' : $_POST['bio']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group update">
                    <div class="row">
                        <div class="col-sm-3 control-label"></div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-primary">更新</button>
                            <a class="pas" href="reset-pass">修改密码</a>
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

    
    <script src="/static/assets/vendors/jquery/popper.min.js"></script>
    <script src="/static/assets/vendors/boostrap/js/bootstrap.min.js"></script>
    <!-- 引入字体的js -->
    <script src="/static/assets/vendors/font/iconfont.js"></script>
    <script>
        NProgress.done()
    </script>
</body>

</html>