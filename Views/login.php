<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athenos - Login/Register</title>
    <link rel="stylesheet" href="../CSS/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Georgia:wght@400;700&display=swap" rel="stylesheet">
    <script src="../JS/login.js" defer></script>
</head>
<body>
    <div class="container">

        <div class="image-section"></div>

        <div class="reservation-panel">

            <div class="close-btn">×</div>

            <h1 id="formTitle">LOGIN</h1>

            <form id="loginForm" class="form active">
                <div class="form-grid">
                    <input type="email" id="login_email" placeholder="Email Address" required>
                    <input type="password" id="login_password" placeholder="Password" required>
                </div>

                <button type="submit">LOGIN <span>→</span></button>

                <p class="switch-text">
                    Don't have an account?
                    <span id="showRegister">Register</span>
                </p>
            </form>

            <form id="registerForm" class="form">
                <div class="form-grid">
                    <input type="text" id="reg_name" placeholder="First Name" required>
                    <input type="text" id="reg_last_name" placeholder="Last Name" required>
                    <input type="email" id="reg_email" placeholder="Email Address" required>
                    <input type="password" id="reg_password" placeholder="Password (min. 6 characters)" required>
                    <input type="password" id="reg_confirm_pass" placeholder="Confirm Password" required>
                </div>

                <button type="submit">REGISTER <span>→</span></button>

                <p id="registerMessage" class="register-message"></p>

                <p class="switch-text">
                    Already have an account?
                    <span id="showLogin">Login</span>
                </p>
            </form>

        </div>
    </div>
</body>
</html>