<?php 
// https://www.youtube.com/watch?v=Y9yE98etanU // Guide for processing forms through php

// ******Testing locally****** 
// Folder (Command Prompt) = C:\Users\chris\Desktop\Senior Project
// Start (Command Prompt) = php -S localhost:8000
// View (Browser) = http://localhost:8000
// Stop (Command Prompt) = ctrl + c

// Start session for CSRF protection and session-based security tokens
session_start();

// Connect to database connection and shared functions
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/functions.php';

// Check if the request method was a post method or not.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    
    // If page was visited directly (GET request), stop program.
    die("Invalid Request Method");
}

// Verify CSRF Token
verifyCsrfToken($_POST['csrf_token']);

// Submit Review
submitReview($pdo, $_POST);

?>