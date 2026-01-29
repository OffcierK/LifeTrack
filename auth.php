<?php
session_start();
require_once "config/db.php";

/* 1️⃣ Nếu đã login bằng session */
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* 2️⃣ Nếu chưa có session → check remember me */
elseif (isset($_COOKIE['remember_token'])) {
    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE remember_token = ?"
    );
    $stmt->execute([$_COOKIE['remember_token']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $currentUser = $user;
    }
}
