<?php

session_start();
// Access database to get review data.
require_once 'database.php';
// Access functions file to use functions.
require_once 'functions.php';

// Check if the request method was a post method or not.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method");
}

// Verify CSRF token using function.
verifyCsrfToken($_POST['csrf_token']);

// Get review ID number to store and pass the variable to function approveReview.
$review_id = (int) $_POST['review_id'];

// Call function with review ID number to approve and then return to admin_dashboard page. 
approveReview($pdo, $review_id);
header("Location: admin_dashboard.php");
exit;

?>