// CLOSE BUTTON
document.querySelector(".close-btn").addEventListener("click", function () {
    if (document.referrer) {
        window.history.back();
    } else {
        window.location.href = "index.html";
    }
});

const loginForm = document.getElementById("loginForm");
const registerForm = document.getElementById("registerForm");

const showRegister = document.getElementById("showRegister");
const showLogin = document.getElementById("showLogin");
const formTitle = document.getElementById("formTitle");

// switch to register
showRegister.addEventListener("click", () => {
    loginForm.classList.remove("active");
    registerForm.classList.add("active");
    formTitle.textContent = "REGISTER";
});

// switch back to login
showLogin.addEventListener("click", () => {
    registerForm.classList.remove("active");
    loginForm.classList.add("active");
    formTitle.textContent = "LOGIN";
});


//Register form submission

document.getElementById("registerForm").addEventListener("submit", function(e){
    e.preventDefault();

    const name = document.getElementById("reg_name").value;
    const surname = document.getElementById("reg_last_name").value;
    const email = document.getElementById("reg_email").value;
    const password = document.getElementById("reg_password").value;
    const confirmPassword = document.getElementById("reg_confirm_pass").value;

    const message = document.getElementById("registerMessage");

    // password check
    if(password !== confirmPassword){
        message.innerText = "Passwords do not match";
        message.style.color = "red";
        return;
    }

    if(password.length < 6){
        message.innerText = "Password must be at least 6 characters";
        message.style.color = "red";
        return;
    }

    fetch("register.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `name=${encodeURIComponent(name)}&surname=${encodeURIComponent(surname)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&confirmPassword=${encodeURIComponent(confirmPassword)}`
    })
    .then(response => response.text())
    .then(data => {
        message.innerText = data;
        message.style.color = "green";
    })
    .catch(error => console.error("Error:", error));
});