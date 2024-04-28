<?php
require 'info_db_connect.php'; // 连接到数据库

$search = trim(htmlspecialchars($_GET['search'])); // 获取搜索关键词

if ($search === '张健') {
    header('Location: view/zj.html');
    exit;
}

$search = '%' . $search . '%'; // Prepare the search term for SQL LIKE statement

$results = []; // Initialize $results as an empty array

// Prepare the queries
$query_province = $pdo->prepare("
    SELECT contents.*, LEFT(contents.body, 20) as content, provinces.province 
    FROM contents 
    JOIN provinces ON contents.province_id = provinces.id 
    WHERE provinces.province LIKE :search
");

$query_city = $pdo->prepare("
    SELECT contents.*, LEFT(contents.body, 20) as content, provinces.province, cities.city 
    FROM contents 
    JOIN cities ON contents.city_id = cities.id 
    JOIN provinces ON cities.provinceid = provinces.provinceid
    WHERE cities.city LIKE :search
");

$query_country = $pdo->prepare("
    SELECT contents.*, LEFT(contents.body, 20) as content, provinces.province, cities.city, countries.country 
    FROM contents 
    JOIN countries ON contents.country_id = countries.id 
    JOIN cities ON countries.cityid = cities.cityid 
    JOIN provinces ON cities.provinceid = provinces.provinceid
    WHERE countries.country LIKE :search
");

// Execute the queries in order
$query_province->execute(['search' => $search]);
if ($query_province->rowCount() > 0) {
    $results = $query_province->fetchAll();
} else {
    $query_city->execute(['search' => $search]);
    if ($query_city->rowCount() > 0) {
        $results = $query_city->fetchAll();
    } else {
        $query_country->execute(['search' => $search]);
        if ($query_country->rowCount() > 0) {
            $results = $query_country->fetchAll();
        }
    }
}

// Now $results contains the search results

// Now $results contains the search results
require './view/search.html';