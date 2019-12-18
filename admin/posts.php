<?php

// 载入配置文件
require_once '../function.php';



// 判断当前用户是否登录,接收用户信息
en_get_current_user();

function posts_add()
{
    // 定义全局变量
    global $message, $success, $content;
    // 那到用户信息
    $currnet_user = en_get_current_user();
    if (empty($_POST['title'])) {
        $message = '标题不能为空';
        return;
    }
    if (empty($_POST['content'])) {
        $message = '内容不能为空';
        return;
    }
    if (empty($_POST['category'])) {
        $message = '请选择分类';
        return;
    }
    if (empty($_POST['created'])) {
        $message = '请选择创建时间';
        return;
    }

    // 接收变量
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $created = $_POST['created'];
    $status = $_POST['status'];
    // 加密文本内容
    $re_content = sha1($content);
    // 接收用户的邮箱
    $email = $currnet_user['email'];
    // 存储数据
    $row = en_excute("INSERT INTO posts VALUES(NULL, '{$email}','{$title}', '{$re_content}', {$category}, '{$created}', '{$status}')");
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>投稿系统-修改密码</title>
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
                <div class="col-md-9">
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
                        <label for="title">标题</label>
                        <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题" value="<?php echo empty($_POST['title'])  ? '' : $_POST['title']; ?>">
                    </div>
                    <div class="form-group">
                        <div id="div1">
                            <?php echo isset($content) ? $content : ''; ?>
                        </div>
                        <textarea id="text1" style="width:100%; height:200px; display: none;" name="content"></textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="category">所属分类</label>
                        <select id="category" class="form-control" name="category">
                            <option value="1">未分类</option>
                            <option value="2">生活</option>
                            <option value="3">科技</option>
                            <option value="4">娱乐</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="created">发布时间</label>
                        <input id="created" class="form-control" name="created" type="datetime-local">
                    </div>
                    <div class="form-group">
                        <label for="status">状态</label>
                        <select id="status" class="form-control" name="status">
                            <option value="wait" selected='selected'>待审核</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">保存</button>
                    </div>
                </div>
            </form>


        </div>

        <!-- 底部版权 -->
        <!-- <?php include './inc/footer.php'; ?> -->
    </div>
    <!-- 给当前界面定义一个变量，用于后续点到那个界面做高亮显示 -->
    <?php $current_page = 'posts'; ?>
    <!-- 侧边栏 -->
    <?php include './inc/slidebar.php'; ?>
    <!-- 引入jquery -->
    <script src="/static/assets/vendors/jquery/jquery.js"></script>
    <!-- 注意， 只需要引用 JS，无需引用任何 CSS ！！！-->
    <script src="/static/assets/vendors/wangEditor-3.1.1/release/wangEditor.js"></script>
    <script type="text/javascript">
        var E = window.wangEditor
        var editor = new E('#div1')
        var $text1 = $('#text1')
        editor.customConfig.onchange = function(html) {
            // 监控变化，同步更新到 textarea
            $text1.val(html)
        }
        editor.create()
        // 初始化 textarea 的值
        $text1.val(editor.txt.html())
    </script>
    <script src="/static/assets/vendors/jquery/popper.min.js"></script>
    <script src="/static/assets/vendors/boostrap/js/bootstrap.min.js"></script>
    <!-- 引入字体的js -->
    <script src="//at.alicdn.com/t/font_1549825_2clf5pue9ge.js"></script>
    <script>
        NProgress.done()
    </script>
</body>

</html>