<?php
require_once "config/db.php";

$error = "";
$success = "";

// 1. Lấy token từ URL
$token = $_GET['token'] ?? '';

if (!$token) {
    die("Link không hợp lệ");
}

// 2. Kiểm tra token + hạn
$stmt = $conn->prepare("
    SELECT id, reset_expires 
    FROM users 
    WHERE reset_token = :token
");
$stmt->execute(['token' => $token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Link không hợp lệ hoặc đã được sử dụng");
}

if (strtotime($user['reset_expires']) < time()) {
    die("Link đã hết hạn");
}

// 3. Xử lý submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = trim($_POST["password"]);
    $confirm  = trim($_POST["confirm"]);

    if (strlen($password) < 8) {
        $error = "Mật khẩu phải có ít nhất 8 ký tự";
    } elseif ($password !== $confirm) {
        $error = "Mật khẩu xác nhận không khớp";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $update = $conn->prepare("
            UPDATE users 
            SET password = :password,
                reset_token = NULL,
                reset_expires = NULL
            WHERE id = :id
        ");
        $update->execute([
            'password' => $hashed,
            'id' => $user['id']
        ]);

        $success = "Đổi mật khẩu thành công! <a href='index.php'>Đăng nhập</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - LifeTrack</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="auth-container">
    <h2>Đặt lại mật khẩu</h2>

    <?php if (!empty($error)): ?>
        <div class="auth-error"><?= $error ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="auth-success"><?= $success ?></div>
    <?php else: ?>
        <form method="post">
            <div class="form-group">
                <label>Mật khẩu mới</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu mới" required>
            </div>

            <div class="form-group">
                <label>Xác nhận mật khẩu</label>
                <input type="password" name="confirm" placeholder="Nhập lại mật khẩu" required>
            </div>

            <button type="submit">Đổi mật khẩu</button>
        </form>
    <?php endif; ?>

    <div class="auth-links">
        <a href="index.php">← Quay lại đăng nhập</a>
    </div>
</div>

<footer class="auth-footer">
    © 2026 LifeTrack • Track your habits • Expenses • Goals
</footer>

</body>
</html>
