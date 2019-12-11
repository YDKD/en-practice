<?php

//载入配置文件信息
require 'config.php';

session_start();
// 封装一个获取当前登录用户信息的函数，如果不存在就跳转到登录页面，此处也是可以直接在每个页面判断是否存在用户信息
function en_get_current_user() {
    // 先判断是否有用户数据存在，
    if(empty($_SESSION['current_login_user'])) {
        //没有传入登录数据，代表没有登录,跳转到登录页面
        header("Location: /admin/login");
        // 退出
        exit();
    }
   // 等到当前的用户信息
   return $_SESSION['current_login_user'];
}


// 封装查询多条数据的函数
function en_fetch_all($sql) {
    // 连接数据库
    $conn  = mysqli_connect(EP_HOST, EP_USER, EP_PASS, EP_NAME);
    //判断是否连接成功
    if(!$conn) {
        exit('连接失败');
    }

     // 设置数据编码
     mysqli_set_charset($conn, 'utf8');

    // 查询
    $query = mysqli_query($conn, $sql);
    // 判读是否查询成功
    if(!$query) {
        exit('查询失败');
    }

    // 得到当前的数据，利用循环操作，把得到的数据放到数组中，最后返回数组
    while($row = mysqli_fetch_assoc($query)) {
        $result[] = $row;
    }

    // 释放内存
    mysqli_free_result($query);
    // 关闭数据库连接
    mysqli_close($conn);

    // 返回得到的数据结果
    return $result;
}

// 封装单条数据查询操作
function en_fetch_one($sql) {
    // 调用多条数据查询操作
    $res = en_fetch_all($sql);
    // 返回第一个查询到的结果，也就是一条数据，因为多条查询操作，传入的数据也可以使一条
    return isset($res) ? $res[0] : null;
}

// 封装一个数据库增删改的函数
function en_excute($sql)
{

    //连接数据库
    $conn = mysqli_connect(EP_HOST, EP_USER, EP_PASS, EP_NAME);
    if(!$conn) {
        exit('连接失败');
    }

    mysqli_set_charset($conn, 'utf8');
    
    //数据库关联
    $query = mysqli_query($conn, $sql);
    if (!$query) {
        //查询失败
        return;
    }

    //获取到受影响的行数
    $affected_rows = mysqli_affected_rows($conn);

    //关闭数据库
    mysqli_close($conn);

    //返回受影响的结果
    return $affected_rows;
}

// 封装一个邮箱验证函数
function verifyEmail($str) {
    $partten = '/[0-9a-zA-Z]+@[0-9a-zA-Z]+\.[0-9a-zA-Z]+$/';
    if(preg_match($partten, $str)) {
        return true;
    } else {
        return false;
    }
}