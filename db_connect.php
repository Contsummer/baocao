<?php
$host = "sql311.byethost22.com";
$username = "b22_37917747";
$password = "123456quan";
$dbname = "b22_37917747_banhoa";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
