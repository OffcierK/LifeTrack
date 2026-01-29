<?php
require_once "auth.php";
require_once "config/db.php"; // nhớ có DB

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

<div class="app">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            📊 <span>LifeTrack</span>
        </div>

        <nav class="sidebar-menu">
            <a class="active">🏠 Dashboard</a>
            <a>✅ Todo</a>
            <a>💸 Expenses</a>
            <a>🎯 Goals</a>
            <a>🔥 Motivation</a>
            <a>📈 Reports</a>
            <a>⚙️ Settings</a>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="main">

        <!-- HEADER -->
        <header class="topbar">
            <h2>Good morning 👋</h2>
            <div class="top-actions">
                <span>🌙</span>
                <span>🔔</span>
                <span>👤</span>
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

</body>
</html>

