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
    <a href="index.php?page=dashboard"
    class="menu-item <?= isActive('today') ?>">
    <img src="assets/img/today.png" class="menu-icon">
    <span>Today</span>
    </a>

    <a href="index.php?page=upcoming"
    class="menu-item <?= isActive('upcoming') ?>">
    <img src="assets/img/deadline.png" class="menu-icon">
    <span>Upcoming</span>
    </a>

    <a href="index.php?page=calendar"
    class="menu-item <?= isActive('calendar') ?>">
    <img src="assets/img/cld.png" class="menu-icon">
    <span>Calendar</span>
    </a>

    <a href="index.php?page=sticky"
    class="menu-item <?= isActive('stickywall') ?>">
    <img src="assets/img/pin.png" class="menu-icon">
    <span>Sticky Wall</span>
    </a>


</div>

<div class="sidebar-section">
    <p class="section-title">LISTS</p>
    <a href="index.php?page=personal"
    class="menu-item <?= isActive('personal') ?>">
    <img src="assets/img/man.png" class="menu-icon">
    <span>Personal</span>
    </a>


    <a href="index.php?page=work"
    class="menu-item <?= isActive('work') ?>">
    <img src="assets/img/suitcase.png" class="menu-icon">
    <span>Work</span>
    </a>


    <a href="index.php?page=study"
    class="menu-item <?= isActive('study') ?>">
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