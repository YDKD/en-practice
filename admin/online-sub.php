<?php
/*
 * @Descripttion: 
 * @version: 1.0
 * @Author: YDKD
 * @Date: 2019-12-21 17:27:15
 * @LastEditors  : YDKD
 * @LastEditTime : 2019-12-21 17:33:24
 */



// 载入配置文件
require_once '../function.php';



// 判断当前用户是否登录,接收用户信息
en_get_current_user();

function posts_add()
{
    // 定义全局变量
    global $message, $success, $content;
    
    
}


// 判断当前用户提交信息的方式
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    posts_add();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿系统-在线投稿</title>
    <!-- 引入Bootstrap.css -->
    <link rel="stylesheet" href="/static/assets/vendors/boostrap/css/bootstrap.css">
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
            <form class="row" action="/admin/posts" method="post">
               
            </form>
        </div>

        <!-- 底部版权 -->
        <!-- <?php include './inc/footer.php'; ?> -->
    </div>
    <!-- 给当前界面定义一个变量，用于后续点到那个界面做高亮显示 -->
    <?php $current_page = 'subs'; ?>
    <!-- 侧边栏 -->
    <?php include './inc/slidebar.php'; ?>
    <!-- 引入jquery -->
    <script src="/static/assets/vendors/jquery/jquery.js"></script>
    <!-- 注意， 只需要引用 JS，无需引用任何 CSS ！！！-->
    <script src="/static/assets/vendors/wangEditor-3.1.1/release/wangEditor.js"></script>
    <script src="/static/assets/vendors/jquery/popper.min.js"></script>
    <script src="/static/assets/vendors/boostrap/js/bootstrap.min.js"></script>
    <!-- 引入字体的js -->
    <script src="//at.alicdn.com/t/font_1549825_2clf5pue9ge.js"></script>
    <script>
        NProgress.done()
    </script>
</body>

</html>