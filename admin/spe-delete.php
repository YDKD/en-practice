<?php
// 载入配置文件
require_once '../function.php';

if (empty($_GET['id'])) {
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
        en_excute("DELETE FROM users WHERE id = '{$item}'; ");
    }
}
header("Location: /admin/users-spe");
