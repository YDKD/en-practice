/*
 * @Descripttion: 
 * @version: 
 * @Author: sueRimn
 * @Date: 2019-12-18 15:53:34
 * @LastEditors  : sueRimn
 * @LastEditTime : 2019-12-18 15:54:34
 */
<?php
require_once '../function.php';

if(empty($_GET['id'])) {
    exit();
}

// 接收id值
$id = $_GET['id'];

// 把得到的数据按照逗号格式分开
$hello = explode(',', $id);
foreach ($hello as $item) {
    // 判断得到的数据是否为数值类型
    if (is_numeric($item)) {
        // 删除ID所对应的值
        en_excute("DELETE FROM posts WHERE id = '{$item}'; ");
    }
}
header("Location: /admin/posts-all");
