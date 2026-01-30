<?php
require_once "auth.php";
require_once "config/db.php"; // nhớ có DB
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT email, created_at FROM users WHERE id = ?");
$stmt->execute([$userId]);
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $conn->query("SELECT TOP 1 * FROM motivations ORDER BY NEWID()");
$motivation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>LifeTrack Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <!-- SIDEBAR -->
        <div class="app">
        <?php include "partials/sidebar.php"; ?>

        <main class="main">
            <?php include "partials/topbar.php"; ?>

            <!-- phần stats + content GIỮ NGUYÊN -->
             <section class="stats">
            <div class="card">✅ Tasks<br><strong>5 / 8</strong></div>
            <div class="card">🔥 Streak<br><strong>12 days</strong></div>
            <div class="card">💸 Expense<br><strong>$120</strong></div>
            <div class="card">🎯 Goals<br><strong>70%</strong></div>
        </section>

        <!-- CONTENT -->
        <section class="content">
            <div class="view active" id="view-today">
    <!-- CONTENT TODAY -->
            <div class="card">📅 Task hôm nay</div>
        </div>

        <div class="view" id="view-upcoming">
            <!-- CONTENT UPCOMING -->
            <div class="card">⏳ Task sắp tới</div>
        </div>

            <div class="card big">
                <h3>🔥 Motivation of the Day</h3>
                <p class="quote">
                    <?= htmlspecialchars($motivation['content']) ?>
                </p>

            </div>

            <div class="card">
                <h3>🎯 Today’s Focus</h3>
                <p>Finish one important task.</p>
            </div>

            <div class="card">
                <h3>🧠 Message to Yourself</h3>
                <p>You promised yourself you would not quit.</p>
            </div>

        </section>

        </main>
        </div>


    <!-- USER PANEL -->
        <div class="user-panel" id="userPanel">

            <div class="user-panel-header">
                <h3>👤 User Profile</h3>
                <span class="close-btn" id="closeUserPanel">✕</span>
            </div>

            <div class="user-panel-content">

                <div class="user-info">
                    <p class="label">Email</p>
                    <p class="value">
                        <?= htmlspecialchars($currentUser['email']) ?>
                    </p>
                </div>

                <div class="user-info">
                    <p class="label">Joined</p>
                    <p class="value">
                        <?= date("d/m/Y", strtotime($currentUser['created_at'])) ?>
                    </p>
                </div>

                <div class="user-info">
                    <p class="label">Status</p>
                    <p class="value status active">Active</p>
                </div>

                <hr>

                <!-- Chuẩn bị sẵn cho tương lai -->
                <button class="panel-btn" id="toggleTheme">
                🌙 Dark mode
                </button>

                <button class="panel-btn disabled">🔒 Change password</button>

                <a href="logout.php" class="logout-btn">Logout</a>

            </div>
    </div>

</div>

            <footer class="auth-footer">
                © 2026 LifeTrack • Track your habits • Expenses • Goals
            </footer>
<script>
/* =====================
   USER PANEL TOGGLE
===================== */
document.addEventListener("DOMContentLoaded", () => {
    const panel = document.getElementById("userPanel");
    const bell = document.getElementById("openUserPanelBell");
    const avatar = document.getElementById("openUserPanelAvatar");
    const closeBtn = document.getElementById("closeUserPanel");

    if (!panel) return;

    bell?.addEventListener("click", () => {
        panel.classList.add("show");
    });

    avatar?.addEventListener("click", () => {
        panel.classList.add("show");
    });

    closeBtn?.addEventListener("click", () => {
        panel.classList.remove("show");
    });
});

/* =====================
   DARK MODE TOGGLE
===================== */

</script>
<script>
const toggleThemeBtn = document.getElementById("toggleTheme");
const themeIcon = toggleThemeBtn.querySelector("img");

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
    themeIcon.src = "assets/img/sun.png";
}

toggleThemeBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
        themeIcon.src = "assets/img/sun.png";
    } else {
        localStorage.setItem("theme", "light");
        themeIcon.src = "assets/img/night-mode.png";
    }
});

</script>

<script src="assets/js/dashboard.js"></script>

</body>
</html>

