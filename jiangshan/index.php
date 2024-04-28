<?php
//主页
require 'init_login.php';       //验证是否有登录
require 'info_db_connect.php';  //连接数据库

//查询语句，从读取内容标题 发布者 地区 发布时间 修改时间 内容摘要（正文的前50位）
$sql='SELECT id, title, author, province_id, created_at, updated_at, LEFT(body,20) as content FROM contents order by id desc';

//执行查询语句,查询结果集存储在对象$stmt中
$stmt = $pdo->query($sql);  

//从stmt中取出查询结果，并保存在$data中
$data=$stmt->fetchAll(PDO::FETCH_ASSOC);

// 获取省份名称
foreach ($data as $key => $value) {
    $sql = 'SELECT province FROM provinces WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $value['province_id']]);
    $province = $stmt->fetch(PDO::FETCH_ASSOC);
    $data[$key]['province_name'] = $province['province'];
}

require './view/index.html';
?>