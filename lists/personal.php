<?php
require_once "../auth.php";
require_once "../config/db.php";
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Personal List • LifeTrack</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>

<div class="app">
    <?php include "../partials/sidebar.php"; ?>

    <main class="main">
        <?php include "../partials/topbar.php"; ?>

        <section class="content">
            <div class="card">
                <h3>👤 Personal Tasks</h3>
                <p>Các task cá nhân.</p>
            </div>
        </section>
    </main>
</div>

<?php include "../partials/user-panel.php"; ?>
<script src="assets/js/user-panel.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/dashboard.js"></script>
<script src="assets/js/darkmode.js"></script>
</body>
</html>
