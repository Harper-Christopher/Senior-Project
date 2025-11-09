<?php

// Starting a session to store an access the CSRF token securely.
session_start();

// Connect to our database.php file once 
require_once __DIR__ . '/database.php';
// Connect to our functions.php file once
require_once __DIR__ . '/functions.php';

// Generate a CSRF (Cross-Site Request Forgery) token if one doesn't exist 
generateCsrfToken();

// Get everything in the database and put it in the variable $reviews.  
$reviews = getUnapprovedReviews($pdo);

?>

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Precision Home Inspections">
    <meta name="author" content="Christopher Harper">
    <title>Admin Dashboard | Precision Home Inspections</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/small.css">
    <link rel="stylesheet" href="css/medium.css">
    <link rel="stylesheet" href="css/large.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="adminBody">

    <div class="headerNav">
    <header class="head">
        <a href="#"> 
            <img class="logo" src="image/logo.jpg"
                alt="Precision Home Inspections Logo">
        </a>
        <h1 class="motto">Proudly Serving Utah's Wasatch Front.</h1>

      </header>

    <nav>
        <ul class="navigation">
            <li><span class="menu"></span><a href="#" class="menu-icon navOption2" id="menu-icon" onclick="toggleMenu()"><span></span></a></li>
            <li><span><a href="#" class="active navOption">Home</a></span></li>
            <li><a href="#" class="navOption">About</a></li>
            <li><a href="#" class="navOption">Services</a></li>
            <li><a href="#" class="navOption">Reviews</a></li>
            <li><a href="#" class="navOption">Contact</a></li>
        </ul>
    </nav>
    </div>

  <h1>Admin Dashboard — Pending Reviews</h1>

  <div class="adminDashboard">
<?php if (!empty($reviews)):?>
    <?php foreach ($reviews as $row): ?>
        <div class="review_card">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p class="rating"><?php echo str_repeat("⭐", (int)$row['rating']); // emojipedia.org/star ?></p>
            <p><?php echo nl2br(htmlspecialchars_decode($row['comment'])); // Keep line break  format and change special characters to HTML?></p>
            <small>Submitted on <?php echo date("F j, Y", strtotime($row['created_at'])); // Used date format for F(full month) j(day without 0's) Y(4 digit year)?></small>
            <div class="adminActions">
                <form action="approve_review.php" method="POST">
                <input type="hidden" name="review_id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" class="adminApprove"><i class="fa-solid fa-check"></i> Approve</button>
                </form>
                <form action="delete_review.php" method="POST">
                <input type="hidden" name="review_id" value="<?php echo $row['id'] ?>">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <button type="submit" class="adminDelete"><i class="fa-solid fa-trash"></i> Delete</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No reviews to approve. Please check back later.</p>
<?php endif; ?>
    

  </div>
          <a href="logout.php" class="admin_logout">Logout</a>
</body>
</html>
