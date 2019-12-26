<?php
/*
 * @Descripttion: 
 * @version: 1.0
 * @Author: YDKD
 * @Date: 2019-12-21 17:27:15
 * @LastEditors  : YDKD
 * @LastEditTime : 2019-12-26 16:04:33
 */


// 设置时区
date_default_timezone_set('PRC');
// 载入配置文件
require_once '../function.php';



// 判断当前用户是否登录,接收用户信息
en_get_current_user();

// 设置时区
date_default_timezone_set('PRC');

function posts_add()
{
    // 定义全局变量
    global $message, $success;

    // 表单校验
    if(empty($_POST['title'])) {
        $message = '表单标题为空';
        return;
    }
    if($_POST['category'] == 1) {
        $message = '请选择文章分类';
        return;
    }
    
    // 接收表单和文件数据
    $title = $_POST['title'];
    $email = $_POST['email'];
    $category = $_POST['category'];
    $created = $_POST['created'];
    $status = $_POST['status'];
    $upfile = $_FILES['file'];

    var_dump($upfile);
    // 判断用户是否选择了文件
    if(empty($upfile['tmp_name'])) {
        $message = '请选择上传文件';
        return;
    }

    // 校验文件大小
    if($upfile['size'] > 100 * 1024 * 1024) {
        $message = '上传文件过大';
        return;
    }
    if($upfile['size'] < 1 * 1024 ){
        $message = '上传文件过小';
        return;
    }

    // 上传成功，接收文件
    $target = '../static/uploads/posts/' . $upfile['name'];
    if (!move_uploaded_file($upfile['tmp_name'], $target)) {
        $message = '文件上传失败';
        return;
    }
    // 数据库更新 
    $row = en_excute("INSERT INTO posts VALUES(NULL, '{$email}','{$title}',  {$category}, '{$created}', '{$status}')");

    $success = $row > 0;
    $message = $row <= 0 ? "投稿失败" : "投稿成功";
    

}


// 判断当前用户提交信息的方式
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    posts_add();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿系统-在线投稿</title>
    <!-- 引入Bootstrap.css -->
    <link rel="stylesheet" href="/static/assets/vendors/boostrap/css/bootstrap.css">
    <!-- 引入进度条css -->
    <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
    <!-- 引入字体图标 -->
    <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.min.css" /><!-- 引入主题css -->
    <!-- 引入animate -->
    <link rel="stylesheet" href="/static/assets/vendors/animate/animate.css">
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
                <h3>投稿信息</h3>
            </div>
            <form action="/admin/online-sub" class="message" id="online-post" method="POST" enctype="multipart/form-data">
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
                <div class="form-group get">
                    <div class="row">
                        <label class="col-sm-4 control-label">标题</label>
                        <div class="field col-sm-6">
                            <input type="txt" class="form-control" name="title" size="50" value="<?php echo empty($_POST['title'])  ? '' : $_POST['title']; ?>" placeholder="请输入文章标题" data-validate="required:请输入文章标题" />
                        </div>
                    </div>
                </div>
                <div class="form-group get">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="email">投稿人邮箱</label>
                        <div class="field col-sm-6">
                            <input id="email" type="email" class="form-control" name="email" size="50" value="<?php echo $current_user['email'] ?>" readonly />
                        </div>
                    </div>
                </div>
                <div class="form-group get">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="category">文章分类</label>
                        <div class="field col-sm-6">
                            <select id="category" class="form-control" name="category">
                                <option value="1">未分类</option>
                                <option value="2">生活</option>
                                <option value="3">科技</option>
                                <option value="4">娱乐</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group get">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="created">投稿时间</label>
                        <div class="field col-sm-6">
                            <input id="created" type="text" class="form-control" name="created" size="50" value="<?php echo date('Y年m月d日 H:i:s', time())?>" readonly />
                        </div>
                    </div>
                </div>
                <div class="form-group get">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="status">稿件状态</label>
                        <div class="field col-sm-6">
                            <select id="status" class="form-control" name="status">
                                <option value="wait">待审核</option>
                                <option value="draft">草稿</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group get">
                    <div class="row">
                        <label class="col-sm-4 control-label" for="created">上传附件</label>
                        <div class="field col-sm-4" id="input-file">
                            <span>点击上传，或将文件拖拽到此处</span>
                            <input id="file" type="file" class="form-control" name="file" size="50" />
                        </div>
                        <p style="margin-left: 40px;" id="file_content"></p>
                    </div>
                </div>
                <div class="form-group put update">
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-2">
                            <button class="btn btn-primary">提交</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- 底部版权 -->
        <!-- <?php include './inc/footer.php'; ?> -->
    </div>
    <!-- 给当前界面定义一个变量，用于后续点到那个界面做高亮显示 -->
    <?php $current_page = 'subs'; ?>
    <!-- 侧边栏 -->
    <?php include './inc/slidebar.php'; ?>

    <script src="/static/assets/vendors/jquery/popper.min.js"></script>
    <script src="/static/assets/vendors/boostrap/js/bootstrap.min.js"></script>
    <!-- 引入字体的js -->
    <script src="//at.alicdn.com/t/font_1549825_q6rpi5buccq.js"></script>
    <script>
        NProgress.done()
    </script>
    <script>
        $('#file').on('change', function() {
            // 设置支持上传的文件的类型
            var tmp = ['txt', 'docx', 'doc'];

            // 获取文件的路径
            var file = $(this).val();
            // 将路径按照 . 拆分
            $file_url = file.split('.');
            // 获取文件后缀
            $houzhui = $file_url[1];
            $before = $file_url[0];
            // 获取文件名
            $filename = getFileName($before);
            // 获取文件名函数
            function getFileName(o) {
                var pos = o.lastIndexOf("\\");
                return o.substring(pos + 1);
            }

            // 判断所传文件类型是否支持
            var value = $.inArray($houzhui, tmp);
            if (value != -1) {
                $('#file_content').text($filename)
                $('#file_content').attr('style', 'margin-left: 40px; font-size: 16px')
            } else {
                $('#file_content').attr({
                    'style': 'color: red; margin-left: 40px; font-size: 16px',
                    'class': 'shake animated'
                })
                $('#file_content').text('上传失败，文件类型不支持')
            }
        })
    </script>
</body>

</html>