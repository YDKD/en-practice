<?php
require_once '../function.php';

$current_user = en_get_current_user();
?>
<nav class="navbar">
    <div class="logo flash animated">
        <h1>
            <img src="<?php echo $current_user['avatar']; ?>" alt="" height="50px">
            <a href="/admin/index">投稿系统</a>
        </h1>
    </div>
    <div class="per-message text-center">
        <h1>Welcome<?php echo $current_user['nickname']; ?></h1>
    </div>
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a href="/admin/api/bio?action=<?php echo $current_user['id']; ?>">
                <svg class="icon" aria-hidden="true">
                    <use xlink:href="#icon-gerenzhongxin-xuanzhong"></use>
                </svg>
                个人中心
            </a>
        </li>
        <li>
            <a href="/admin/login.php?action=logout">
                <svg class="icon" aria-hidden="true">
                    <use xlink:href="#icon-tuichu"></use>
                </svg>
                退出
            </a>
        </li>
    </ul>
</nav>