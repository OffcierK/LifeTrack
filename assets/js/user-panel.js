
/* =====================
   USER PANEL TOGGLE
===================== */
document.addEventListener("DOMContentLoaded", () => {
    const panel = document.getElementById("userPanel");
    const bell = document.getElementById("openUserPanelBell");
    const avatar = document.getElementById("openUserPanelAvatar");
    const closeBtn = document.getElementById("closeUserPanel");

    if (!panel) return;

    bell?.addEventListener("click", () => {
        panel.classList.add("show");
    });

    avatar?.addEventListener("click", () => {
        panel.classList.add("show");
    });

    closeBtn?.addEventListener("click", () => {
        panel.classList.remove("show");
    });
});

/* =====================
   DARK MODE TOGGLE
===================== */
