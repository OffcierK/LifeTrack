<?php
session_start();
require_once "config/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']); // checkbox

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error = "Email chưa đăng ký";
    } else {
        if (password_verify($password, $user['password'])) {

            // ✅ SESSION LOGIN
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            // ✅ REMEMBER ME
            if ($remember) {
                $token = bin2hex(random_bytes(32));

                $update = $conn->prepare(
                    "UPDATE users SET remember_token = :token WHERE id = :id"
                );
                $update->execute([
                    'token' => $token,
                    'id' => $user['id']
                ]);

                setcookie(
                    "remember_token",
                    $token,
                    time() + (86400 * 30), // 30 ngày
                    "/",
                    "",
                    false,
                    true // HttpOnly
                );
            }

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Sai mật khẩu";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>LifeTrack - Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="bg-brand">
    LifeTrack
</div>

<div class="auth-container">
    <div class="logo">📊</div>
    <h2>LifeTrack Login</h2>

    <?php if (!empty($error)) : ?>
        <div class="message error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>
        <div class="remember">
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Remember me</label>
        </div>



        <button type="submit">Login</button>
    </form>

    <div class="auth-links">
        <p>
            Chưa có tài khoản?
            <a href="register.php">Đăng ký</a>
        </p>
        <p>
            <a href="forgetpass.php">Quên mật khẩu?</a>
        </p>
    </div>
    
</div>
<footer class="auth-footer">
    © 2026 LifeTrack • Track your habits • Expenses • Goals
</footer>


</body>
</html>
