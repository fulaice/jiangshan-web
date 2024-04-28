<?php
//用于登录界面数据库连接
//设置字符集
header('Content-type:text/html; charset=utf8');

//数据库连接信息
$servername = "localhost";
$username = "root";
$password = "030414";

//连接数据库
$con = mysqli_connect("localhost", "root", "030414", "CITYINFO");

if (mysqli_connect_errno())
{
    echo "连接 MySQL 失败: " . mysqli_connect_error();
}

// //创建连接
// $con = new mysqli($servername, $username, $password);
// //检测连接
// if ($con->connect_error) {
//     die("连接失败: " . $con->connect_error);
// }
// echo "连接成功";


