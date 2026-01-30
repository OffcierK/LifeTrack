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

        <aside class="sidebar">

        <div class="sidebar-top">
            <!-- MỚI -->
        <div class="sidebar-logo">
            <img src="assets/img/logo.png" alt="Logo" class="logo-icon">
            <span class="logo-text"></span>
            <button id="toggleSidebar" class="collapse-btn">☰</button>
        </div>


        <div class="sidebar-search">
            <input type="text" placeholder="Search..." />
        </div>

        <div class="sidebar-section">
    <p class="section-title">TASKS</p>
    <a class="menu-item active" data-view="today" data-tooltip="Today">
        📅 <span>Today</span>
    </a>
    <a class="menu-item" data-tooltip="Upcoming">
    <img src="assets/img/deadline.png" alt="Upcoming" class="menu-icon">
    <span>Upcoming</span>
    <a class="menu-item" data-tooltip="Calendar">
    <img src="assets/img/cld.png" alt="Calendar" class="menu-icon">
    <span>Calendar</span>
    </a>
    <a class="menu-item" data-tooltip="Sticky Wall">
    <img src="assets/img/pin.png" alt="Sticky Wall" class="menu-icon">
    <span>Sticky Wall</span>
    </a>
</div>

<div class="sidebar-section">
    <p class="section-title">LISTS</p>
    <a class="menu-item" data-tooltip="Personal">
    <img src="assets/img/man.png" alt="Personal" class="menu-icon">
    <span>Personal</span>
    </a>
    <a class="menu-item" data-tooltip="Work">
    <img src="assets/img/suitcase.png" alt="Work" class="menu-icon">
    <span>Work</span>
    </a>
    <a class="menu-item" data-tooltip="Study">
    <img src="assets/img/mortarboard.png" alt="Study" class="menu-icon">
    <span>Study</span>
    </a>
    <a class="menu-item add" data-tooltip="Add new list">
        ＋ <span>Add new list</span>
    </a>
</div>

<!-- FOOTER -->
<div class="sidebar-footer">
    <a class="menu-item" data-tooltip="Reports">
    <img src="assets/img/report.png" alt="Reports" class="menu-icon">
    <span>Reports</span>
    </a>
    <a class="menu-item" data-tooltip="Settings">
    <img src="assets/img/cogwheel.png" alt="Settings" class="menu-icon">
    <span>Settings</span>
    </a>
</div>

</aside>


    <!-- MAIN -->
    <main class="main">

        <!-- HEADER -->
        <header class="topbar">
            <h2>Good morning 👋</h2>
            <div class="top-actions">
                <span>🌙</span>
                <img id="openUserPanel" src="assets/img/bell.png" alt="User" style="cursor:pointer; width: 40x; height: 40px; object-fit: contain; vertical-align: middle;">
                <img id="openUserPanel" src="assets/img/profile.png" alt="User" style="cursor:pointer; width: 45px; height: 45px; object-fit: contain; vertical-align: middle;">
            </div>
        </header>

        <!-- STATS -->
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
const userPanel = document.getElementById("userPanel");
const openBtn = document.getElementById("openUserPanel");
const closeBtn = document.getElementById("closeUserPanel");

openBtn.addEventListener("click", () => {
    userPanel.classList.add("show");
});

closeBtn.addEventListener("click", () => {
    userPanel.classList.remove("show");
});
/* =====================
   DARK MODE TOGGLE
===================== */

</script>
<script>
const toggleThemeBtn = document.getElementById("toggleTheme");

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
    toggleThemeBtn.innerText = "☀️ Light mode";
}

toggleThemeBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
        toggleThemeBtn.innerText = "☀️ Light mode";
    } else {
        localStorage.setItem("theme", "light");
        toggleThemeBtn.innerText = "🌙 Dark mode";
    }
});
</script>

<script src="assets/js/dashboard.js"></script>

</body>
</html>

