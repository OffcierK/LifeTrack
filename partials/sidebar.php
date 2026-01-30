<?php
$currentPage = basename($_SERVER['PHP_SELF']);

function isActive($page) {
    global $currentPage;
    return $currentPage === $page ? 'active' : '';
}
?>



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
    <a href="dashboard.php" class="menu-item <?= isActive('dashboard.php') ?>">
    📅 <span>Today</span>
    </a>

    <a href="upcoming.php" class="menu-item <?= isActive('upcoming.php') ?>">
    <img src="assets/img/deadline.png" class="menu-icon">
    <span>Upcoming</span>
    </a>
    <a href="calendar.php" class="menu-item <?= isActive('calendar.php') ?>">
    <img src="assets/img/cld.png" class="menu-icon">
    <span>Calendar</span>
    </a>
    <a href="stickywall.php" class="menu-item <?= isActive('stickywall.php') ?>">
    <img src="assets/img/pin.png" class="menu-icon">
    <span>Sticky Wall</span>
    </a>

</div>

<div class="sidebar-section">
    <p class="section-title">LISTS</p>
    <a href="lists/personal.php" class="menu-item <?= isActive('personal.php') ?>">
    <img src="assets/img/man.png" class="menu-icon">
    <span>Personal</span>
    </a>

    <a href="lists/work.php" class="menu-item <?= isActive('work.php') ?>">
    <img src="assets/img/suitcase.png" class="menu-icon">
    <span>Work</span>
    </a>

    <a href="lists/study.php" class="menu-item <?= isActive('study.php') ?>">
    <img src="assets/img/mortarboard.png" class="menu-icon">
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