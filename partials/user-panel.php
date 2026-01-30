<div class="user-panel" id="userPanel">

    <div class="user-panel-header">
        <h3>👤 User Profile</h3>
        <span class="close-btn" id="closeUserPanel">✕</span>
    </div>

    <div class="user-panel-content">

        <div class="user-info">
            <p class="label">Email</p>
            <p class="value">
                <?= htmlspecialchars($currentUser['email'] ?? '') ?>
            </p>
        </div>

        <div class="user-info">
            <p class="label">Joined</p>
            <p class="value">
                <?= isset($currentUser['created_at']) 
                    ? date("d/m/Y", strtotime($currentUser['created_at'])) 
                    : '' ?>
            </p>
        </div>

        <div class="user-info">
            <p class="label">Status</p>
            <p class="value status active">Active</p>
        </div>

        <hr>

        <button class="panel-btn" id="toggleTheme">🌙 Dark mode</button>
        <button class="panel-btn disabled">🔒 Change password</button>

        <a href="logout.php" class="logout-btn">Logout</a>

    </div>
</div>
<script src="assets/js/main.js"></script>
