<?php
$host = 'localhost'; // 数据库主机
$db   = 'CITYINFO'; // 数据库名
$user = 'root'; // 数据库用户名
$pass = '030414'; // 数据库密码
$charset = 'utf8mb4'; // 字符集

$dsn = "mysql:host=$host; dbname=$db; charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>