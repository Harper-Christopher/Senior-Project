<?php 

// Starting a session to store an access the CSRF token securely.
session_start();

// Access functions.php file to get functions needed.
require_once 'functions.php';

// Call function to generate CSRF token if one doesn't exist.
generateCsrfToken();

?>

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Precision Home Inspections">
    <meta name="author" content="Christopher Harper">
    <title>Login | Precision Home Inspections</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/small.css">
    <link rel="stylesheet" href="css/medium.css">
    <link rel="stylesheet" href="css/large.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="adminBody">
    <div class="headerNav">
    <header class="head">
        <a href="index.html"> 
            <img class="logo" src="image/logo.jpg"
                alt="Precision Home Inspections Logo">
        </a>
        <h1 class="motto">Proudly Serving Utah's Wasatch Front.</h1>
    </header>

    <nav>
        <ul class="navigation">
            <li><span class="menu"></span><a href="#" class="menu-icon navOption2" id="menu-icon" onclick="toggleMenu()"><span></span></a></li>
            <li><span><a href="index.html" class="navOption">Home</a></span></li>
            <li><a href="about.html" class="navOption">About</a></li>
            <li><a href="services.html" class="navOption">Services</a></li>
            <li><a href="reviews.php" class="navOption">Reviews</a></li>
            <li><a href="contact.html" class="navOption">Contact</a></li>
            <li><a href="admin_login.php" class="active navOption">Login</a></li>
        </ul>
    </nav>
    </div>


    <div class="adminLogin_container">
        
    <form class="loginForm" action="submit_adminForm.php" method="POST"> 
            <h1>User Login</h1>

            <label for="username">User Name <span class="requiredStar">*</span></label>
            <input type="text" id="username" name="username" placeholder="Username" required>

            <label>
            <input type="text" id="last_name" name="last_name" class="milo">
            </label>

            <label for="password">Password <span class="requiredStar">*</span></label>
            <input type="password" id="password" name="password" placeholder="Password" required>

            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

            <button type="submit">Login</button>
        </form>

    </div>

</body>
<script src="js/main.js"></script>
</html>