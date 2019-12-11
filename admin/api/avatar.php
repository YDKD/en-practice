<?php

// 载入配置文件
require_once '../../config.php';

// 1、接收传过来的邮箱地址
if(empty($_GET['email'])) {
    exit('缺少必要的参数值');
}
$email = $_GET['email'];

// 2、连接数据库，查询头像地址
$conn = mysqli_connect(EP_HOST, EP_USER, EP_PASS, EP_NAME);

if(!$conn) {
    exit('连接数据库失败');
}

$res = mysqli_query($conn, "SELECT avatar FROM users WHERE email = '{$email}' limit 1;");

if(!$res) {
    exit('查询失败');
}

// 获取关联数组
$row = mysqli_fetch_assoc($res);

// 3、输出头像地址

echo $row['avatar'];