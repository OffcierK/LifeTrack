<?php
$currentPage = basename($_SERVER['PHP_SELF']);

function isActive($page) {
    global $currentPage;
    return $currentPage === $page ? 'active' : '';
}
?>

<aside class="sidebar">
    <div class="sidebar-top">
        <!-- Logo -->
        <div class="sidebar-logo">
            <img src="assets/img/logo.png" alt="Logo" class="logo-icon">
            <span class="logo-text"></span>
            <button id="toggleSidebar" class="collapse-btn">☰</button>
        </div>

        <!-- Search -->
        <div class="sidebar-search">
            <input type="text" placeholder="Search..." />
        </div>

        <!-- TASKS Section (Collapsible) -->
        <div class="sidebar-section">
            <div class="section-header" data-section="tasks">
                <span class="section-icon">📋</span>
                <span class="section-title">TASKS</span>
                <span class="section-arrow">▼</span>
            </div>
            <div class="section-content active" id="section-tasks">
                <a href="index.php?page=dashboard" 
                   class="menu-item <?= isActive('today') ?>" 
                   data-tooltip="Today">
                    <img src="assets/img/today.png" class="menu-icon" alt="Today">
                    <span>Today</span>
                </a>

                <a href="index.php?page=upcoming" 
                   class="menu-item <?= isActive('upcoming') ?>" 
                   data-tooltip="Upcoming">
                    <img src="assets/img/deadline.png" class="menu-icon" alt="Upcoming">
                    <span>Upcoming</span>
                </a>

                <a href="index.php?page=calendar" 
                   class="menu-item <?= isActive('calendar') ?>" 
                   data-tooltip="Calendar">
                    <img src="assets/img/cld.png" class="menu-icon" alt="Calendar">
                    <span>Calendar</span>
                </a>
            </div>
        </div>

        <!-- LISTS Section (Collapsible) -->
        <div class="sidebar-section">
            <div class="section-header" data-section="lists">
                <span class="section-icon">📁</span>
                <span class="section-title">LISTS</span>
                <span class="section-arrow">▼</span>
            </div>
            <div class="section-content active" id="section-lists">
                <a href="index.php?page=personal" 
                   class="menu-item <?= isActive('personal') ?>" 
                   data-tooltip="Personal">
                    <img src="assets/img/man.png" class="menu-icon" alt="Personal">
                    <span>Personal</span>
                </a>

                <a href="index.php?page=work" 
                   class="menu-item <?= isActive('work') ?>" 
                   data-tooltip="Work">
                    <img src="assets/img/suitcase.png" class="menu-icon" alt="Work">
                    <span>Work</span>
                </a>

                <a href="index.php?page=study" 
                   class="menu-item <?= isActive('study') ?>" 
                   data-tooltip="Study">
                    <img src="assets/img/mortarboard.png" class="menu-icon" alt="Study">
                    <span>Study</span>
                </a>

                <a href="#" class="menu-item add" data-tooltip="Add new list">
                    <span>＋</span>
                    <span>Add new list</span>
                </a>
            </div>
        </div>

        <!-- NOTES Section (Collapsible) -->
        <div class="sidebar-section">
            <div class="section-header" data-section="notes">
                <span class="section-icon">🧠</span>
                <span class="section-title">NOTES</span>
                <span class="section-arrow">▼</span>
            </div>
            <div class="section-content active" id="section-notes">
                <a href="index.php?page=sticky" 
                   class="menu-item <?= isActive('stickywall') ?>" 
                   data-tooltip="Sticky Wall">
                    <img src="assets/img/pin.png" class="menu-icon" alt="Sticky Wall">
                    <span>Sticky Wall</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <div class="sidebar-footer">
        <!-- INSIGHTS Section (Collapsible) -->
        <div class="sidebar-section">
            <div class="section-header" data-section="insights">
                <span class="section-icon">📊</span>
                <span class="section-title">INSIGHTS</span>
                <span class="section-arrow">▼</span>
            </div>
            <div class="section-content active" id="section-insights">
                <a href="index.php?page=reports" 
                   class="menu-item <?= isActive('reports') ?>" 
                   data-tooltip="Reports">
                    <img src="assets/img/report.png" class="menu-icon" alt="Reports">
                    <span>Reports</span>
                </a>
                
                <a href="index.php?page=settings" 
                   class="menu-item <?= isActive('settings') ?>" 
                   data-tooltip="Settings">
                    <img src="assets/img/cogwheel.png" class="menu-icon" alt="Settings">
                    <span>Settings</span>
                </a>
            </div>
    </div>
</aside>