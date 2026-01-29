const passwordInput = document.getElementById("password");
const confirmInput = document.getElementById("confirmPassword");
const registerBtn = document.getElementById("registerBtn");

const strengthBar = document.getElementById("strength-bar");
const strengthText = document.getElementById("strength-text");

const passwordHint = document.getElementById("passwordHint");
const confirmHint = document.getElementById("confirmHint");

function checkPasswordStrength(password) {
    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    strengthBar.className = "";
    strengthText.textContent = "";

    if (password.length === 0) {
        strengthBar.style.width = "0%";
        return;
    }

    if (strength <= 1) {
        strengthBar.style.width = "25%";
        strengthBar.classList.add("strength-weak");
        strengthText.textContent = "Yếu";
    } else if (strength === 2) {
        strengthBar.style.width = "50%";
        strengthBar.classList.add("strength-medium");
        strengthText.textContent = "Trung bình";
    } else if (strength === 3) {
        strengthBar.style.width = "75%";
        strengthBar.classList.add("strength-medium");
        strengthText.textContent = "Khá";
    } else {
        strengthBar.style.width = "100%";
        strengthBar.classList.add("strength-strong");
        strengthText.textContent = "Mạnh";
    }

    return strength >= 2; // đủ mạnh để đăng ký
}

function validateForm() {
    const password = passwordInput.value;
    const confirm = confirmInput.value;

    const strongEnough = checkPasswordStrength(password);
    const match = confirm.length > 0 && password === confirm;

    // password hint
    if (password.length === 0) {
        passwordHint.textContent = "";
    } else if (strongEnough) {
        passwordHint.textContent = "Mật khẩu hợp lệ ✔";
        passwordHint.className = "hint ok";
    } else {
        passwordHint.textContent = "Mật khẩu chưa đủ mạnh";
        passwordHint.className = "hint error";
    }

    // confirm hint
    if (confirm.length === 0) {
        confirmHint.textContent = "";
    } else if (match) {
        confirmHint.textContent = "";
        confirmHint.className = "hint ok";
    } else {
        confirmHint.textContent = "Mật khẩu không khớp";
        confirmHint.className = "hint error";
    }

    registerBtn.disabled = !(strongEnough && match);
}

// 🔥 GẮN 1 NƠI DUY NHẤT
passwordInput.addEventListener("input", validateForm);
confirmInput.addEventListener("input", validateForm);

const form = document.querySelector("form");

form.addEventListener("submit", () => {
    registerBtn.classList.add("loading");
    registerBtn.disabled = true;
});
