<?php
require_once "config/db.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // 1. validate password
    if (strlen($password) < 8) {
        $error = "Mật khẩu phải có ít nhất 8 ký tự";
    } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/\d/', $password)) {
        $error = "Mật khẩu phải có chữ và số";
    } elseif ($password !== $confirm) {
        $error = "Mật khẩu xác nhận không khớp";
    }

    // 2. check email
    if (!$error) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        if ($stmt->fetch()) {
            $error = "Email đã tồn tại";
        }
    }

    // 3. insert DB
    if (!$error) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (email, password, created_at)
             VALUES (:email, :password, GETDATE())"
        );
        $stmt->execute([
            'email' => $email,
            'password' => $hashedPassword
        ]);

        $success = "Đăng ký thành công!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Register - LifeTrack</title>
    <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<div class="auth-container">
    <h2>LifeTrack Register</h2>
    <?php if ($error): ?>
    <p class="auth-error"><?= $error ?></p>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const btn = document.getElementById("registerBtn");
            btn.classList.remove("loading");
            btn.disabled = false;
        });
    </script>
    <?php endif; ?>

    <?php if ($success): ?>
    <p class="auth-success"><?= $success ?></p>
    <script>
        setTimeout(() => {
            window.location.href = "index.php";
        }, 2000); // 2 giây
    </script>
    <?php endif; ?>


    <form method="post">
        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>

        <label>Password</label>
        <input 
            type="password" 
            name="password" 
            id="password"
            placeholder="Enter your password" 
            minlength="8"
            required
        >

        <div class="password-strength">
        <div id="strength-bar"></div>
        </div>

        <div class="password-meta">
        <small id="strength-text"></small>
        <small class="hint-1">Ít nhất 8 ký tự</small>
        </div>

        <p id="passwordHint" class="hint"></p>

        <label>Confirm Password</label>
        <input
            type="password"
            name="confirm_password"
            id="confirmPassword"
            placeholder="Confirm password"
            required
        >
        <p id="confirmHint" class="hint"></p>
        <button type="submit" id="registerBtn">
        <span class="btn-text">Create Account</span>
        <span class="btn-loading">Creating...</span>
        </button>

    </form>

    <div class="auth-links">
        <p>Đã có tài khoản? <a href="index.php">Đăng nhập</a></p>
    </div>
</div>

<footer class="auth-footer">
    © 2026 LifeTrack • Track your habits • expenses • goals
</footer>
<script src="assets/js/main.js"></script>
</body>
</html>
