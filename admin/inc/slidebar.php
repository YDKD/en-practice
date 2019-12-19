<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: sueRimn
 * @Date: 2019-12-05 22:52:39
 * @LastEditors  : sueRimn
 * @LastEditTime : 2019-12-19 14:11:35
 */

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
            <!-- 创建人员数组 -->
            <?php $personals = array('users_spe', 'users_author', 'personal-add'); ?>
            <?php $per_level = array(2, 3); ?>
            <li <?php echo in_array($current_page, $personals) ? 'class="active"' : '' ?> <?php echo in_array($level, $per_level) ? 'id="hidden"' : ''; ?> >
                <a href="#person-manger" <?php echo in_array($current_page, $personals) ? '' : 'class="collapsed"'; ?> data-toggle="collapse">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-renyuanguanli"></use>
                    </svg>
                    人员管理
                </a>
                <ul id="person-manger" class="collapse<?php echo in_array($current_page, $personals) ? ' show' : ''; ?>">
                    <li <?php echo $current_page=='users_spe' ? 'class="active"' : ''; ?>><a href="/admin/users-spe">专家管理</a></li>
                    <li <?php echo $current_page=='users_author' ? 'class="active"' : ''; ?>><a href="/admin/users-author">作者管理</a></li>
                    <li <?php echo $current_page=='personal-add' ? 'class="active"' : ''; ?>><a href="/admin/personal-add">人员添加</a></li>
                </ul>
            </li>
            <!-- 创建文章数组 -->
            <?php $en_posts = array('posts-all', 'posts-pass', 'posts-return', 'posts-wait'); ?>
            <li <?php echo isset($author_hidden) ? "id = $author_hidden" : ''; ?>  <?php echo in_array($current_page, $en_posts) ? 'class="active"' : '' ?>>
                <a href="#manger-posts" <?php echo in_array($current_page, $en_posts) ? '' : 'class="collapsed"'; ?> data-toggle="collapse">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-gaojian"></use>
                    </svg>
                    稿件管理
                </a>
                <ul id="manger-posts" class="collapse<?php echo in_array($current_page, $en_posts) ? ' show' : ''; ?>">
                    <li <?php echo in_array($level, $per_level) ? 'id="hidden"' : ''; ?> <?php echo $current_page=='posts-all' ? 'class="active"' : ''; ?>><a href="/admin/posts-all">全部稿件</a></li>
                    <li <?php echo $current_page=='posts-wait' ? 'class="active"' : ''; ?>><a href="/admin/posts-wait">待审稿件</a></li>
                    <li <?php echo $current_page=='posts-pass' ? 'class="active"' : ''; ?>><a href="/admin/posts-pass">已审稿件</a></li>
                    <li <?php echo $current_page=='posts-return' ? 'class="active"' : ''; ?>><a href="/admin/posts-return">已退稿件</a></li>
                </ul>
            </li>
            <li <?php echo $current_page == 'reset-pass' ? 'class="active"' : ''; ?>>
                <a href="#system-manger" <?php echo $current_page == 'reset-pass' ? 'class="collapsed"' : ''; ?> data-toggle="collapse">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-shezhi"></use>
                    </svg>
                    系统管理
                </a>
                <ul id="system-manger" class="collapse<?php echo $current_page == 'reset-pass' ? ' show' : ''; ?>">
                    <li <?php echo $current_page=='reset-pass' ? 'class="active"' : ''; ?>><a href="/admin/reset-pass">修改密码</a></li>
                </ul>
            </li>
        </ul>
    </aside>