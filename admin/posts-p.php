<?php
/*
 * @Descripttion: 文章通过操作
 * @version: 
 * @Author: sueRimn
 * @Date: 2019-12-19 10:13:05
 * @LastEditors  : YDKD
 * @LastEditTime : 2019-12-26 15:29:01
 */
// 载入配置文件
require_once '../function.php';

// 接收id值
$id = $_GET['id'];

// 把得到的数据按照逗号格式分开
$hello = explode(',', $id);
foreach ($hello as $item) {
    // 判断得到的数据是否为数值类型
    if (is_numeric($item)) {
        // 删除ID所对应的值
        en_excute("UPDATE posts SET `status` = 'pass' WHERE id = '{$id}'; ");
    }
}
header("Location: /admin/posts-wait");

