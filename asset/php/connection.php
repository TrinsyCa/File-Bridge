<?php
$host = "localhost";
$dbname = "file_bridge";
$charset = "utf8";
$root = "root";
$password = "";
$port = 3307;

try {
    $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=$charset", $root, $password);
} catch (PDOException $error) {
    echo "Veritabanı hatası: " . $error->getMessage();
    exit;
}