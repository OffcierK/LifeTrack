<?php
session_start();
require_once "config/db.php";

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare(
        "UPDATE users SET remember_token = NULL WHERE id = ?"
    );
    $stmt->execute([$_SESSION['user_id']]);
}

setcookie("remember_token", "", time() - 3600, "/");
session_destroy();

header("Location: login.php");
exit;
