<?php
require './init_login.php';//验证是否有登录
if (!empty($_POST)){//用户提交了表单
    //获取表单中输入的数据
    $data = array();//用于存储表单中输入的数据的数组
    $data['title']=trim(htmlspecialchars($_POST['title']));//存储书名
    $data['author']=trim(htmlspecialchars($_POST['author']));//存储作者名
    $data['province_id']=trim(htmlspecialchars($_POST['province']));//存储省份ID
    $data['city']=trim(htmlspecialchars($_POST['city']));//存储城市
    $data['country']=trim(htmlspecialchars($_POST['country']));//存储县区
    $data['body']=trim(htmlspecialchars($_POST['body']));//存储简介

    // 检查省份字段是否已填写
    if (empty($data['province_id'])) {
        $_SESSION['error'] = "省份是必填字段";
        $_SESSION['data'] = $data;
        require './error_page.php';
        exit;
    }

    //连接数据库
    require 'info_db_connect.php';

    // 检查城市是否存在
    $stmt = $pdo->prepare("SELECT id FROM cities WHERE city = :city");
    $stmt->execute(['city' => $data['city']]);
    $city_id = $stmt->fetchColumn();
    if ($city_id === false) {
        $_SESSION['error'] = "城市名称无法匹配，请重新填写";
        $_SESSION['data'] = $data;
        require './error_page.php';
        exit;
    }

    // 检查县区是否存在
    $stmt = $pdo->prepare("SELECT id FROM countries WHERE country = :country");
    $stmt->execute(['country' => $data['country']]);
    $country_id = $stmt->fetchColumn();
    if ($county_id === false) {
        $_SESSION['error'] = "县区名称无法匹配，请重新填写";
        $_SESSION['data'] = $data;
        require './error_page.php';
        exit;
    }

    // 使用 ID 插入数据
    $sql='insert into contents(title,author,province_id,city_id,country_id,body) values(:title,:author,:province_id,:city_id,:country_id,:body)';
    $stmt=$pdo->prepare($sql);//预编译sql语句
    $stmt->execute([
        'title' => $data['title'],
        'author' => $data['author'],
        'province_id' => $data['province_id'],
        'city_id' => $city_id,
        'country_id' => $country_id,
        'body' => $data['body'],
    ]);//执行插入数据的sql语句

    // 清除 $_SESSION['data']
    unset($_SESSION['data']);

    header('Location:./index.php');//重定向到主页面
}
require './view/add.html';
?>