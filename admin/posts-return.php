<?php

// 载入配置文件
require_once '../function.php';

// 判断当前用户是否登录
$current_user = en_get_current_user();
// 获取用户邮箱
$email = $current_user['email'];
// 获取用户级别
$level = $current_user['level'];
// 目标：获取posts中的数据，并展示出来
$current_posts = en_fetch_all("SELECT * FROM posts WHERE `status` = 'return';");
$current_return_posts = en_fetch_all("SELECT * FROM posts WHERE email = '{$email}' AND `status` = 'return';");




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿系统-退回文章</title>
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
            <div class="row posts">
                <div class="col-sm-12">
                    <div class="page-action">
                        <!-- show when multiple checked -->
                        <a id="btn_delete" class="btn btn-danger btn-sm" href="/admin/spe-delete" style="display: none; margin-bottom: 8px;">批量删除</a>
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <!-- <th class="text-center" width="40"><input type="checkbox"></th> -->
                                <th>用户邮箱</th>
                                <th>文章标题</th>
                                <th>文章分类</th>
                                <th>创建时间</th>
                                <th>文章状态</th>
                                <!-- <th class="text-center" width="100">操作</th> -->
                            </tr>
                        </thead>
                        <tbody class="user-spe text-center">
                            <?php if (($level == 1 || $level == 2) && is_array($current_posts)) : ?>
                                <?php foreach ($current_posts as $item) : ?>
                                    <tr class="con">
                                        <td><?php echo $item['email']; ?></td>
                                        <td><?php echo $item['title']; ?></td>
                                        <td><?php echo posts_category($item['category_id']); ?></td>
                                        <td><?php echo $item['created']; ?></td>
                                        <td><?php echo posts_status($item['status']); ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php elseif (is_array($current_return_posts)) : ?>
                                <?php foreach ($current_return_posts as $item) : ?>
                                    <tr class="con">
                                        <td><?php echo $item['email']; ?></td>
                                        <td><?php echo $item['title']; ?></td>
                                        <td><?php echo posts_category($item['category_id']); ?></td>
                                        <td><?php echo $item['created']; ?></td>
                                        <td><?php echo posts_status($item['status']); ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr class="con">
                                    <td>无</td>
                                    <td>无</td>
                                    <td>无</td>
                                    <td>无</td>
                                    <td>无</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 底部版权 -->
        <!-- <?php include './inc/footer.php'; ?> -->
    </div>
    <!-- 给当前界面定义一个变量，用于后续点到那个界面做高亮显示 -->
    <?php $current_page = 'posts-return'; ?>
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