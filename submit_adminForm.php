<?php

session_start();
require_once 'database.php';
require_once 'functions.php'; 

// // Check if the request method was a post method or not.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    // If page was visited directly (GET request), stop program.
    die("Invalid request");
}

// Verify CSRF token
if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
    die("Invalid CSRF token");
}

// Remove any spaces before and after the user name and password and store them in variables. 
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Get all from our phi_admin table where the username is equal to the username passed in. 
$stmt = $pdo->prepare("SELECT * FROM phi_admin WHERE username = ?");
$stmt->execute([$username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Verify that the user exists and that the password entered matches. 
if ($admin && password_verify($password, $admin['password_hash'])) {
    // Login success
    $_SESSION['loggedIn'] = true;
    $_SESSION['admin_username'] = $username;
    header("Location: admin_dashboard.php");
    exit;
} else {
    // Login failed
    echo "<p>Invalid username or password.</p>";
}

?>