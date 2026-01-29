<?php
require_once "config/db.php";
require_once "vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);

    // kiểm tra email
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error = "Email không tồn tại trong hệ thống";
    } else {
        // tạo token
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", time() + 900); // 15 phút

        // lưu token vào users
        $update = $conn->prepare("
            UPDATE users 
            SET reset_token = :token, reset_expires = :expires
            WHERE id = :id
        ");
        $update->execute([
            'token' => $token,
            'expires' => $expires,
            'id' => $user['id']
        ]);

        // gửi email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mydepzaivjppr0@gmail.com';
        $mail->Password   = 'greb mtls kfbv gqzc';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';


        $mail->setFrom('YOUR_EMAIL@gmail.com', 'LifeTrack');
        $mail->addAddress($email);

        $resetLink = "http://localhost/lifetrack/reset_password.php?token=$token";

        $mail->isHTML(true);
        $mail->Subject = "Reset mật khẩu LifeTrack";
        $mail->Body = "
            <p>Bạn đã yêu cầu đặt lại mật khẩu.</p>
            <p><a href='$resetLink'>Nhấn vào đây để đặt lại mật khẩu</a></p>
            <p>Link sẽ hết hạn sau 15 phút.</p>
        ";

        $mail->send();
        $success = "Đã gửi email đặt lại mật khẩu. Vui lòng kiểm tra inbox.";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu - LifeTrack</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="auth-container">
    <h2>Quên mật khẩu</h2>
    <p style="text-align:center; font-size:14px; color:#666; margin-bottom:15px;">
        Nhập email để nhận link đặt lại mật khẩu
    </p>

    <?php if ($error): ?>
        <div class="auth-error"><?= $error ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="auth-success"><?= $success ?></div>
    <?php else: ?>
        <form method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <button type="submit">Gửi link reset</button>
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
