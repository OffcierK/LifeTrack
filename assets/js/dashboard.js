/* ===================== SIDEBAR TOGGLE ===================== */
const sidebar = document.querySelector('.sidebar');
const app = document.querySelector('.app');
const toggleBtn = document.getElementById('toggleSidebar');

if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        app.classList.toggle('collapsed');
        
        // Đổi icon của nút
        if (sidebar.classList.contains('collapsed')) {
            localStorage.setItem('sidebarState', 'collapsed');
            toggleBtn.textContent = '→';
        } else {
            localStorage.setItem('sidebarState', 'expanded');
            toggleBtn.textContent = '☰';
        }
    });

    // Khôi phục trạng thái khi load trang
    if (localStorage.getItem('sidebarState') === 'collapsed') {
        sidebar.classList.add('collapsed');
        app.classList.add('collapsed');
        toggleBtn.textContent = '→';
    }
}

/* ===== VIEW SWITCH ===== */
const menuItems = document.querySelectorAll(".menu-item[data-view]");
const views = document.querySelectorAll(".view");

menuItems.forEach(item => {
    item.addEventListener("click", () => {
        // active menu
        menuItems.forEach(i => i.classList.remove("active"));
        item.classList.add("active");

        // show view
        const viewName = item.dataset.view;
        views.forEach(v => v.classList.remove("active"));
        const targetView = document.getElementById(`view-${viewName}`);
        if (targetView) {
            targetView.classList.add("active");
        }
    });
});