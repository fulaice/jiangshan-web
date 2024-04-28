<?php
//用于退出登录
session_start();
//删除session
unset($_SESSION['username']);
//跳转登录界面
header('location:login.php');