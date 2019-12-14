<?php

// 主线任务，根据登录的不同级别，侧边栏的功能显示不同
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

?>
    <aside>
        <ul class="nav">
            <li <?php echo $current_page == 'index' ? 'class="active"' : ''; ?>>
                <a href="/admin/index">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-basic-information"></use>
                    </svg>
                    基本信息
                </a>
            </li>
            <?php $personals = array('users_spe', 'users_author'); ?>
            <?php $per_level = array(2, 3); ?>
            <li <?php echo in_array($current_page, $personals) ? 'class="active"' : '' ?> <?php echo in_array($level, $per_level) ? 'id="hidden"' : ''; ?> >
                <a href="#person-manger" <?php echo in_array($current_page, $personals) ? '' : 'class="collapsed"'; ?> data-toggle="collapse">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-renyuanguanli"></use>
                    </svg>
                    人员管理
                </a>
                <ul id="person-manger" class="collapse<?php echo in_array($current_page, $personals) ? ' show' : ''; ?>">
                    <li><a href="/admin/users-spe">专家管理</a></li>
                    <li><a href="/admin/users-author">作者管理</a></li>
                </ul>
            </li>
            <li <?php echo isset($author_hidden) ? $author_hidden : ''; ?> >
                <a href="#manger-posts" class="collapsed" data-toggle="collapse">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-gaojian"></use>
                    </svg>
                    稿件管理
                </a>
                <ul id="manger-posts" class="collapse">
                    <li <?php echo in_array($level, $per_level) ? 'id="hidden"' : ''; ?>><a href="#">已除稿件</a></li>
                    <li><a href="#">待审稿件</a></li>
                    <li><a href="#">已审稿件</a></li>
                    <li><a href="#">已退稿件</a></li>
                </ul>
            </li>
            <li class="">
                <a href="#system-manger" class="collapsed" data-toggle="collapse">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-shezhi"></use>
                    </svg>
                    系统管理
                </a>
                <ul id="system-manger" class="collapse">
                    <li><a href="/admin/reset-pass">修改密码</a></li>
                </ul>
            </li>
        </ul>
    </aside>