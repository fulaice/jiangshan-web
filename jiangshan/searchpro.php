<?php
require 'info_db_connect.php'; // 连接到数据库

$search = trim(htmlspecialchars($_GET['search'])); // 获取搜索关键词

    // SELECT contents.*, LEFT(contents.body, 20) as content, provinces.province 
    // FROM contents 
    // JOIN provinces ON contents.province_id = provinces.id 
    // WHERE provinces.province LIKE :search
// 使用 JOIN 语句联接 "contents" 表和 "province" 表，并使用 LIKE 语句搜索匹配的省份名称
$stmt = $pdo->prepare("
    SELECT contents.*, LEFT(contents.body, 20) as content, provinces.province 
    FROM contents 
    JOIN provinces ON contents.province_id = provinces.id 
    WHERE provinces.province LIKE :search
");
$stmt->execute(['search' => "%$search%"]);

$results = $stmt->fetchAll();

// // 在这里，你可以处理和显示搜索结果
// foreach ($results as $row) {
//     echo 'ID: ' . $row['id'] . '<br>';
//     echo 'Province: ' . $row['province'] . '<br>';
//     // 在这里，你可以添加更多的列
//     echo '<hr>'; // 添加一个分隔线
// }
require './view/search.html';