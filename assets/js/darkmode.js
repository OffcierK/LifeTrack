const toggleThemeBtn = document.getElementById("toggleTheme");
const themeIcon = toggleThemeBtn.querySelector("img");

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
    themeIcon.src = "assets/img/sun.png";
}

toggleThemeBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark");

    if (document.body.classList.contains("dark")) {
        localStorage.setItem("theme", "dark");
        themeIcon.src = "assets/img/sun.png";
    } else {
        localStorage.setItem("theme", "light");
        themeIcon.src = "assets/img/night-mode.png";
    }
});
