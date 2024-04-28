<?php
// 内容详情页
require 'init_login.php';       // 判断是否登录
require 'info_db_connect.php';  // 连接数据库

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;  // 获取 get 传参 id 值
$data = array('id' => $id);                     // 将 id 值放到 data 数组中

$sql = 'SELECT id, title, author, province_id, created_at, updated_at, body FROM contents WHERE id=:id';
$stmt = $pdo->prepare($sql); // 对于查询语句进行编译 PDOStatement 对象
if (!$stmt->execute($data)) { // 执行查询语句
    exit('查询失败' . implode(' ', $stmt->errorInfo())); // 输出查询失败原因
}
$data = $stmt->fetch(PDO::FETCH_ASSOC); // 将查询结果存储在数组 data 中
if (empty($data)) {
    echo ('编号不存在');
}

// 查询省份名称
$province_id = $data['province_id'];
$province_data = array('id' => $province_id);
$sql = 'SELECT province FROM provinces WHERE id=:id';
$stmt = $pdo->prepare($sql);
if (!$stmt->execute($province_data)) {
    exit('查询省份失败' . implode(' ', $stmt->errorInfo()));
}
$province = $stmt->fetch(PDO::FETCH_ASSOC);
$data['province_name'] = $province['province']; // 将省份名称添加到 data 数组中

require './view/show.html';