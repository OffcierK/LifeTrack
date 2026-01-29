<?php
require_once "auth.php";

if (!isset($currentUser)) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="auth-container">
    <h2>👤 Hồ sơ người dùng</h2>

    <p><strong>Email:</strong> <?= htmlspecialchars($currentUser['email']) ?></p>
    <p><strong>Ngày tạo:</strong> <?= $currentUser['created_at'] ?></p>

    <a href="dashboard.php">← Quay lại Dashboard</a>
</div>

</body>
</html>
