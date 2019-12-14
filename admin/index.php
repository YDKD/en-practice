<?php
//首先载入配置文件
require_once '../function.php';

//先判断是否登录了，再进行后续
en_get_current_user();

// 主线任务，根据登录的不同级别，chart.js的显示不同
// 实现，我把需要隐藏的用户级别放到一个数组中，根据拿到的用户级别的数据和数组中进行比较，若存在，则进行隐藏

//先判断当前的界面传值是否存在
$current_page = isset($current_page) ? $current_page : '';

// 获取当前用户信息
$current_user = en_get_current_user();

// 获取当前用户级别
$level = $current_user['level'];

// 根据用户级别设置不同属性
switch ($level) {
    case '2':
        $spe_hidden = 'hidden';
        break;
    case '3':
        $author_hidden = 'hidden';
        break;
}

// 获取当前的管理员，专家和作者的人数
$admin = en_fetch_one("SELECT COUNT(LEVEL) AS num FROM users WHERE `level` = 1;")['num'];

$specialist = en_fetch_one("SELECT COUNT(LEVEL) AS num FROM users WHERE `level` = 2;")['num'];

$author = en_fetch_one("SELECT COUNT(LEVEL) AS num FROM users WHERE `level` = 3;")['num'];

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
        <!-- 顶部nav -->
        <?php include 'inc/navbar.php' ?>
        <!-- 中间显示区 -->
        <div class="container-fluid text-center">
            <!-- 基本介绍 -->
            <div class="con-one">
                <h1>写最好的文章，做最好的自己</h1>
                <p>Thoughts, stories and ideas.</p>
                <a href="/admin/posts" class="btn btn-secondary btn-lg">写文章</a>
            </div>
            <?php $per_level = array(2, 3); ?>
            <!-- 信息概览 -->
            <div class="row" <?php echo isset($author_hidden) ? 'id ="hidden"' : '';  ?> >
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">系统稿件统计:</h3>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>10</strong>个待审稿件</li>
                            <li class="list-group-item"><strong>6</strong>个已审稿件</li>
                            <li class="list-group-item"><strong>5</strong>个已退稿件</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <canvas id="chart"></canvas>
                </div>
            </div>
           
            <div class="row people" <?php echo in_array($level, $per_level) ? 'id="hidden"' : ''; ?>>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">系统人员统计:</h3>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item"><strong><?php echo $admin; ?></strong>个管理员</li>
                            <li class="list-group-item"><strong><?php echo $specialist; ?></strong>个专家</li>
                            <li class="list-group-item"><strong><?php echo $author; ?></strong>个作者</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <canvas id="chart2"></canvas>
                </div>
            </div>
        </div>

        <!-- 底部版权 -->
        <?php $current_page = 'index'; ?>
        <!-- <?php include './inc/footer.php'; ?> -->
    </div>
    <!-- 给当前界面定义一个变量，用于后续点到那个界面做高亮显示 -->
    <?php $current_page = 'index'; ?>
    <!-- 侧边栏 -->
    <?php include './inc/slidebar.php'; ?>

    <!-- 引入jquery -->
    <script src="/static/assets/vendors/jquery/jquery.js"></script>
    <script src="/static/assets/vendors/jquery/popper.min.js"></script>
    <script src="/static/assets/vendors/boostrap/js/bootstrap.min.js"></script>
    <!-- 引入字体的js -->
    <script src="/static/assets/vendors/font/iconfont.js"></script>
    <!-- 引入chart.js -->
    <script src="/static/assets/vendors/chart/Chart.js"></script>
    <script>
        var ctx = document.getElementById('chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [10, 20, 30],
                    backgroundColor: [
                        '#6610f2',
                        '#ffc107',
                        '#007bff'
                    ]
                }],

                labels: [
                    '待审稿件',
                    '已审稿件',
                    '已退稿件'
                ]
            }

        });
        var ctx = document.getElementById('chart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [<?php echo $admin; ?>, <?php echo $specialist; ?>, <?php echo $author; ?>],
                    backgroundColor: [
                        '#20c997',
                        '#dc3545',
                        '#343a40'
                    ]
                }],

                labels: [
                    '管理员',
                    '专家',
                    '作者'
                ]
            }

        });
    </script>
    <script>NProgress.done()</script>
</body>

</html>