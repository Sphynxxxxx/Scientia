<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles3.css">
</head>
<body>
    <div class="container">
        <h1>Welcome Astronomer!</h1>

        <!-- Login Section -->
        <div class="login-box" id="loginBox">
            <div class="user-icon">
                <i class="fa-solid fa-user"></i>
            </div>
            <h2>Log In</h2>
            <form action="login.php" method="POST">
                <input type="email" name="email" placeholder="E-MAIL" required>
                <input type="password" name="password" placeholder="PASSWORD" required>
                <button type="submit">LOG IN</button>
            </form>
            <div class="options">
                <label><input type="checkbox"> Remember Me</label>
                <a href="#">Forgot password?</a>
            </div>
            <p>Don't have an account? <a href="#" id="showSignup">Sign Up</a></p>
        </div>

        <!-- Signup Section -->
        <div class="signup-box hidden" id="signupBox">
            <div class="user-icon">
                <i class="fa-solid fa-user-plus"></i>
            </div>
            <h2>Sign Up</h2>
            <form action="register.php" method="POST">
                <input type="text" name="full_name" placeholder="Full Name" required>
                <input type="text" name="location" placeholder="Location" required>
                <input type="number" name="contact" placeholder="Contact" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">SIGN UP</button>
            </form>
                <p>Already have an account? <a href="#" id="showLogin">Log In</a></p>
        
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
