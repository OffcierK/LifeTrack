<?php
require_once "auth.php";
require_once "config/db.php";



$page = $_GET['page'] ?? 'dashboard';

$routes = [
  // TASKS
  'dashboard' => 'pages/tasks/dashboard.php',
  'upcoming'  => 'pages/tasks/upcoming.php',
  'calendar'  => 'pages/tasks/calendar.php',
  'sticky'    => 'pages/tasks/stickywall.php',

  // LISTS
  'personal'  => 'pages/lists/personal.php',
  'work'      => 'pages/lists/work.php',
  'study'     => 'pages/lists/study.php',
];


// chống truy cập file bậy
if (!array_key_exists($page, $routes)) {
    $page = 'dashboard';
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>LifeTrack</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<div class="app">
    <?php include "partials/sidebar.php"; ?>

    <main class="main">
        <?php include "partials/topbar.php"; ?>
        <?php include $routes[$page]; ?>
    </main>
</div>

<?php include "partials/user-panel.php"; ?>

<script src="assets/js/user-panel.js"></script>
<script src="assets/js/darkmode.js"></script>
<script src="assets/js/dashboard.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
