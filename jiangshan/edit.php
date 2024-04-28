<?php
// 用于编辑内容
require './init_login.php'; // 验证是否有登录
require 'info_db_connect.php'; // 连接数据库
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0; // 获取 get 传参 id 值
$data = array('id' => $id); // 将 id 值放到 data 数组中

$sql = 'SELECT id, title, author, province_id, city_id, country_id, body FROM contents WHERE id=:id'; // :id 占位符
$stmt = $pdo->prepare($sql); // 对于查询语句进行编译 PDOStatement 对象
if (!$stmt->execute($data)) { // 执行查询语句
    exit('查询失败' . implode(' ', $stmt->errorInfo())); // 输出查询失败原因
}
$data = $stmt->fetch(PDO::FETCH_ASSOC); // 将查询结果存储在数组 data 中
if (empty($data)) {
    echo ('没有找到对应的内容');
} else {
    $data['province'] = idToprovince($data['province_id']);
    $data['city'] = idTocity($data['city_id']);
    $data['country'] = idTocountry($data['country_id']);
}

// 数据修改
if (!empty($_POST)) {
    $id = $data['id']; // 保存 id 的值
    $data = array(); // 用于存储表单中输入的数据的数组
    $data['id'] = $id; // 将 id 值放到 data 数组中
    $data['title'] = isset($_POST['title']) ? trim(htmlspecialchars($_POST['title'])) : '';
    $data['author'] = isset($_POST['author']) ? trim(htmlspecialchars($_POST['author'])) : '';
    $data['province_id'] = isset($_POST['province']) ? provinceToId(trim(htmlspecialchars($_POST['province']))) : 0; // 默认值为0
    $data['city_id'] = isset($_POST['city']) ? cityToId(trim(htmlspecialchars($_POST['city']))) : 0; // 默认值为0
    $data['country_id'] = isset($_POST['country']) ? countryToId(trim(htmlspecialchars($_POST['country']))) : 0; // 默认值为0
    $data['body'] = isset($_POST['body']) ? trim(htmlspecialchars($_POST['body'])) : '';

    // 将数据写入到数据库中（update）
    $sql = 'UPDATE contents SET title=:title, author=:author, province_id=:province_id, city_id=:city_id, country_id=:country_id, body=:body WHERE id=:id';
    $stmt = $pdo->prepare($sql); // 预编译 sql 语句
    $stmt->execute($data); // 执行插入数据的 sql 语句

    // 重新获取数据
    $sql = 'SELECT id, title, author, province_id, city_id, country_id, body FROM contents WHERE id=:id'; // :id 占位符
    $stmt = $pdo->prepare($sql); // 对于查询语句进行编译 PDOStatement 对象
    $data = array('id' => $id); // 重新设置 data 数组，包含 id
    $stmt->execute($data); // 执行查询语句
    $data = $stmt->fetch(PDO::FETCH_ASSOC); // 将查询结果存储在数组 data 中
    $data['province'] = idToprovince($data['province_id']);
    $data['city'] = idTocity($data['city_id']);
    $data['country'] = idTocountry($data['country_id']);
}

//编写一个idToprovince函数，将id转换为省份名
function idToprovince($id)
{
    require 'info_db_connect.php'; // 连接数据库
    $sql = 'SELECT province FROM provinces WHERE id=:id'; // :id 占位符
    $stmt = $pdo->prepare($sql); // 对于查询语句进行编译 PDOStatement 对象
    $stmt->execute(array('id' => $id)); // 执行查询语句
    $data = $stmt->fetch(PDO::FETCH_ASSOC); // 将查询结果存储在数组 data 中
    return isset($data['province']) ? $data['province'] : '';
}

//编写一个idTocity函数，将id转换为城市名
function idTocity($id)
{
    require 'info_db_connect.php'; // 连接数据库
    $sql = 'SELECT city FROM cities WHERE id=:id'; // :id 占位符
    $stmt = $pdo->prepare($sql); // 对于查询语句进行编译 PDOStatement 对象
    $stmt->execute(array('id' => $id)); // 执行查询语句
    $data = $stmt->fetch(PDO::FETCH_ASSOC); // 将查询结果存储在数组 data 中
    return isset($data['city']) ? $data['city'] : '';
}

//编写一个idTocountry函数，将id转换为县区名
function idTocountry($id)
{
    require 'info_db_connect.php'; // 连接数据库
    $sql = 'SELECT country FROM countries WHERE id=:id'; // :id 占位符
    $stmt = $pdo->prepare($sql); // 对于查询语句进行编译 PDOStatement 对象
    $stmt->execute(array('id' => $id)); // 执行查询语句
    $data = $stmt->fetch(PDO::FETCH_ASSOC); // 将查询结果存储在数组 data 中
    return isset($data['country']) ? $data['country'] : '';
}

//编写一个provinceToId函数，将省份名转换为id
function provinceToId($province)
{
    require 'info_db_connect.php'; // 连接数据库
    $sql = 'SELECT id FROM provinces WHERE province=:province'; // :province 占位符
    $stmt = $pdo->prepare($sql); // 对于查询语句进行编译 PDOStatement 对象
    $stmt->execute(array('province' => $province)); // 执行查询语句
    $data = $stmt->fetch(PDO::FETCH_ASSOC); // 将查询结果存储在数组 data 中
    return isset($data['id']) ? $data['id'] : 0;
}

//编写一个cityToId函数，将城市名转换为id
function cityToId($city)
{
    require 'info_db_connect.php'; // 连接数据库
    $sql = 'SELECT id FROM cities WHERE city=:city'; // :city 占位符
    $stmt = $pdo->prepare($sql); // 对于查询语句进行编译 PDOStatement 对象
    $stmt->execute(array('city' => $city)); // 执行查询语句
    $data = $stmt->fetch(PDO::FETCH_ASSOC); // 将查询结果存储在数组 data 中
    return isset($data['id']) ? $data['id'] : 0;
}

//编写一个countryToId函数，将县区名转换为id
function countryToId($country)
{
    require 'info_db_connect.php'; // 连接数据库
    $sql = 'SELECT id FROM countries WHERE country=:country'; // :country 占位符
    $stmt = $pdo->prepare($sql); // 对于查询语句进行编译 PDOStatement 对象
    $stmt->execute(array('country' => $country)); // 执行查询语句
    $data = $stmt->fetch(PDO::FETCH_ASSOC); // 将查询结果存储在数组 data 中
    return isset($data['id']) ? $data['id'] : 0;
}

require './view/edit.html';