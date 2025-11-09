<?php

// https://github.com/vlucas/phpdotenv (Way to store sensitive data / credentials outside of your code)

// Load environment variables (for database credentials)
require_once __DIR__ . '/vendor/autoload.php';  // Load composer which will make the Dotenv class available
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // Creates instance so variables in .env can't be overwritten accidently
$dotenv->load();  // Loads variables from .env file into the $_ENV superglobals

// Using environment variables that aren't hard-coded credentials for others to see
$host = $_ENV['DB_HOST'];   // Uses superglobal $_ENV to get database hostname from .env and creates variable $host
$db   = $_ENV['DB_NAME'];   // Uses superglobal $_ENV to get database name from .env and creates variable $db
$user = $_ENV['DB_USER'];   // Uses superglobal $_ENV to get database user from .env and creates variable $user
$pass = $_ENV['DB_PASS'];   // Uses superglobal $_ENV to get database password from .env and creates variable $pass

// Create secure connection using PDO (PHP Data Objects)
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Will stop execution when an error occurs within the database
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Setting default way to fetch data which will be an associative array
        PDO::ATTR_EMULATE_PREPARES => false,  // Enforces native prepared statements and doesn't accept emulated prepared statements. (SQL Injection)
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());  // Safe error output
}

?>