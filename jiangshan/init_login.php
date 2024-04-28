<?php
//验证是否有登录，无登录则跳转登录界面
//启动session
session_start();
if (!isset($_SESSION['username'])){
    header('Location:login.php');
    exit;
}