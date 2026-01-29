<?php
$server = "OFFICERK";        // tên SQL Server
$database = "LifeTrack";
$username = "sa";
$password = "123456"; // sửa lại

try {
    $conn = new PDO(
        "sqlsrv:Server=$server;Database=$database",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối DB: " . $e->getMessage());
}
