<header class="topbar">
    <div class="topbar-left">
        <h1 class="greeting">
            <span class="greeting-icon">👋</span>
            <span class="greeting-text">Good morning</span>
        </h1>
        <p class="greeting-subtitle">Let's make today productive!</p>
    </div>
    
    <div class="top-actions">
        <!-- Search (optional) -->
        <!-- <button class="topbar-icon" title="Search">
            <img src="assets/img/search.png" class="icon-img" alt="Search">
        </button> -->

        <!-- Dark mode toggle -->
        <button id="toggleTheme" class="topbar-icon" title="Toggle theme">
            <img src="assets/img/night-mode.png" class="icon-img" alt="Theme">
        </button>

        <!-- Notifications -->
        <button id="openUserPanelBell" class="topbar-icon notification-btn" title="Notifications">
            <img src="assets/img/bell.png" class="icon-img" alt="Notifications">
            <span class="notification-badge">3</span>
        </button>

        <!-- User avatar -->
        <button id="openUserPanelAvatar" class="topbar-icon avatar-btn" title="Profile">
            <img src="assets/img/profile.png" class="icon-img" alt="Profile">
        </button>
    </div>
</header>

<script>
// Dynamic greeting based on time
(function() {
    const hour = new Date().getHours();
    const greetingText = document.querySelector('.greeting-text');
    const greetingIcon = document.querySelector('.greeting-icon');
    
    if (hour >= 5 && hour < 12) {
        greetingText.textContent = 'Good morning';
        greetingIcon.textContent = '☀️';
    } else if (hour >= 12 && hour < 17) {
        greetingText.textContent = 'Good afternoon';
        greetingIcon.textContent = '🌤️';
    } else if (hour >= 17 && hour < 22) {
        greetingText.textContent = 'Good evening';
        greetingIcon.textContent = '🌆';
    } else {
        greetingText.textContent = 'Good night';
        greetingIcon.textContent = '🌙';
    }
})();
</script>
