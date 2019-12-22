<?php
session_start();
if(empty($_GET['source'])) {
    exit('缺少必要的参数值');
}
$result = $_GET['source'];
$rand = $_GET['rand'];
$_SESSION['result'] = $result;
$_SESSION['rand'] = $rand;
header('/admin/login.php');