// CLOSE BUTTON
document.querySelector(".close-btn").addEventListener("click", function () {
    if (document.referrer) {
        window.history.back();
    } else {
        window.location.href = "../Views/index.php";
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

    fetch("../Handlers/register.php", {
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

// Login form submission with admin redirect
document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const email = document.getElementById("login_email").value;
    const password = document.getElementById("login_password").value;
    
    console.log("Email being sent:", email);

    fetch("../Handlers/login_functionality.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
    })
    .then(response => {
        console.log("Response status:", response.status);
        return response.json();
    })
    .then(data => {
        console.log("Response from server:", data);
        
        if (data.status === "success") {
            if (data.role === "admin") {
                window.location.href = "../Admin/mainAdminPage.php";
            } else {
                window.location.href = "../index.php";
            }
        } else {
            if (data.code === "EMAIL_NOT_FOUND") {
                alert("Email not found. Please register first.");
                const showRegister = document.getElementById("showRegister");
                if (showRegister) showRegister.click();
            } else if (data.code === "INVALID_PASSWORD") {
                alert("Incorrect password. Please try again.");
                document.getElementById("login_password").value = "";
                document.getElementById("login_password").focus();
            } else if (data.code === "NO_POST_DATA") {
                alert("Connection error. Please try again.");
            } else {
                alert(data.message || "Invalid login details. Please try again.");
            }
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Network error. Please try again.");
    });
});