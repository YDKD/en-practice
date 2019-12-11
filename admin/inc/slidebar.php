<?php

//先判断当前的界面传值是否存在
$current_page = isset($current_page) ? $current_page : '';

?>
<aside>
        <ul class="nav">
            <li <?php echo $current_page == 'index' ? 'class="active"' : ''; ?> >
                <a href="/admin/index">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-basic-information"></use>
                    </svg>
                    基本信息
                </a>
            </li>
            <li class="">
                <a href="#person-manger" class="collapsed" data-toggle="collapse">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-renyuanguanli"></use>
                    </svg>
                    人员管理
                </a>
                <ul id="person-manger" class="collapse">
                    <li><a href="#l">专家管理</a></li>
                    <li><a href="#">作者管理</a></li>
                </ul>
            </li>
            <li class="">
            <a href="#manger-posts" class="collapsed" data-toggle="collapse">
                    <svg class="icon" aria-hidden="true">
                        <use xlink:href="#icon-gaojian"></use>
                    </svg>
                    稿件管理
                </a>
                <ul id="manger-posts" class="collapse">
                    <li><a href="#">删除稿件</a></li>
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
                    <li><a href="#">修改密码</a></li>
                </ul>
            </li>
        </ul>
    </aside>