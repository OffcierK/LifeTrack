/* =====================================================
   LIFETRACK - SIDEBAR JAVASCRIPT (REWRITTEN)
   Last updated: 2026-01-31
===================================================== */

/* ===================== SIDEBAR TOGGLE ===================== */
const sidebar = document.querySelector('.sidebar');
const app = document.querySelector('.app');
const toggleBtn = document.getElementById('toggleSidebar');

if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
        // CHỈ toggle class 'collapsed' trên .app (không toggle trên sidebar)
        app.classList.toggle('collapsed');
        
        // Đổi icon của nút
        if (app.classList.contains('collapsed')) {
            localStorage.setItem('sidebarState', 'collapsed');
            toggleBtn.textContent = '→';
            
            // KHI THU GỌN: Đóng tất cả mega menus
            document.querySelectorAll('.section-content').forEach(section => {
                section.classList.remove('active');
                
                // Reset arrow
                const sectionId = section.id.replace('section-', '');
                const arrow = document.querySelector(`[data-section="${sectionId}"] .section-arrow`);
                if (arrow) arrow.style.transform = 'rotate(-90deg)';
                
                // Save state
                localStorage.setItem(`section-${sectionId}`, 'false');
            });
        } else {
            localStorage.setItem('sidebarState', 'expanded');
            toggleBtn.textContent = '☰';
        }
    });

    // Khôi phục trạng thái khi load trang
    if (localStorage.getItem('sidebarState') === 'collapsed') {
        app.classList.add('collapsed');
        toggleBtn.textContent = '→';
    }
}

/* ===================== COLLAPSIBLE SECTIONS ===================== */
document.addEventListener('DOMContentLoaded', () => {
    const sectionHeaders = document.querySelectorAll('.section-header');
    
    sectionHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const sectionId = header.dataset.section;
            const content = document.getElementById(`section-${sectionId}`);
            const arrow = header.querySelector('.section-arrow');
            
            // CASE 1: Nếu sidebar đang COLLAPSED
            if (app.classList.contains('collapsed')) {
                // Bước 1: Mở sidebar ra
                app.classList.remove('collapsed');
                localStorage.setItem('sidebarState', 'expanded');
                if (toggleBtn) toggleBtn.textContent = '☰';
                
                // Bước 2: Đợi animation xong rồi mở section (KHÔNG toggle)
                setTimeout(() => {
                    // Chỉ mở nếu đang đóng
                    if (!content.classList.contains('active')) {
                        content.classList.add('active');
                        arrow.style.transform = 'rotate(0deg)';
                        localStorage.setItem(`section-${sectionId}`, 'true');
                    }
                    // Nếu đã mở rồi thì giữ nguyên
                }, 300);
            } 
            // CASE 2: Nếu sidebar đã MỞ rồi - toggle bình thường
            else {
                content.classList.toggle('active');
                
                if (content.classList.contains('active')) {
                    arrow.style.transform = 'rotate(0deg)';
                    localStorage.setItem(`section-${sectionId}`, 'true');
                } else {
                    arrow.style.transform = 'rotate(-90deg)';
                    localStorage.setItem(`section-${sectionId}`, 'false');
                }
            }
        });
    });
    
    // Khôi phục trạng thái các section khi load trang
    sectionHeaders.forEach(header => {
        const sectionId = header.dataset.section;
        const savedState = localStorage.getItem(`section-${sectionId}`);
        
        if (savedState === 'false') {
            const content = document.getElementById(`section-${sectionId}`);
            const arrow = header.querySelector('.section-arrow');
            content.classList.remove('active');
            arrow.style.transform = 'rotate(-90deg)';
        }
    });
});

/* ===================== AUTO-EXPAND WHEN CLICKING MENU ITEMS ===================== */
document.addEventListener('DOMContentLoaded', () => {
    const menuItems = document.querySelectorAll('.menu-item');
    
    menuItems.forEach(item => {
        item.addEventListener('click', (e) => {
            // CASE: Nếu sidebar đang COLLAPSED
            if (app.classList.contains('collapsed')) {
                // Ngăn navigation ngay lập tức
                e.preventDefault();
                e.stopPropagation();
                
                // Tìm section chứa menu item này
                const parentSection = item.closest('.section-content');
                
                if (parentSection) {
                    // Bước 1: Mở sidebar
                    app.classList.remove('collapsed');
                    localStorage.setItem('sidebarState', 'expanded');
                    if (toggleBtn) toggleBtn.textContent = '☰';
                    
                    // Bước 2: Đảm bảo section được mở
                    const sectionId = parentSection.id.replace('section-', '');
                    const arrow = document.querySelector(`[data-section="${sectionId}"] .section-arrow`);
                    
                    if (!parentSection.classList.contains('active')) {
                        parentSection.classList.add('active');
                        if (arrow) arrow.style.transform = 'rotate(0deg)';
                        localStorage.setItem(`section-${sectionId}`, 'true');
                    }
                    
                    // Bước 3: Đợi animation xong rồi navigate
                    setTimeout(() => {
                        const href = item.getAttribute('href');
                        if (href && href !== '#') {
                            window.location.href = href;
                        }
                    }, 350);
                }
                
                return false;
            }
            // Nếu sidebar đã mở rồi thì để nó navigate bình thường
        });
    });
});

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