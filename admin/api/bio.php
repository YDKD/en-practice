<?php

require_once '../../function.php';

if (empty($_GET['action'])) {
    exit('缺少必要的参数值');
}
$id = $_GET['action'];

// 2、连接数据库，查询头像地址
$conn = mysqli_connect(EP_HOST, EP_USER, EP_PASS, EP_NAME);

if (!$conn) {
    exit('连接数据库失败');
}
mysqli_set_charset($conn, 'utf8');
$res = mysqli_query($conn, "SELECT bio FROM users WHERE id = '{$id}' limit 1;");

if (!$res) {
    exit('查询失败');
}

// 获取关联数组
$row = mysqli_fetch_assoc($res);

// 3、输出头像地址

$_SESSION['bio'] = $row['bio'];
header('Location: /admin/personal');
