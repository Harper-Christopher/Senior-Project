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
$reviews = getApprovedReviews($pdo);

// Get the average review rating from the database.
$avgRating = averageRating($pdo);

$overallRating = $avgRating['average'];
$totalReviews = $avgRating['count'];

?>

<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Precision Home Inspections">
    <meta name="author" content="Christopher Harper">
    <title>Reviews | Precision Home Inspections</title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/small.css">
    <link rel="stylesheet" href="css/medium.css">
    <link rel="stylesheet" href="css/large.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
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
            <li><a href="reviews.php" class="active navOption">Reviews</a></li>
            <li><a href="contact.html" class="navOption">Contact</a></li>
        </ul>
    </nav>
    </div>

    <div class="reviewContainer">
    <img class="reviewImage" src="image/ReviewForm.jpg" alt="Image of a kitchen.">
    <div class="reviewContent">
    <h2>Customer Reviews</h2>
    <form class="reviewForm" action="submit_reviewForm.php" method="POST"> 
            <h1>Submit a Review</h1>

            <label for="name">Full Name <span class="requiredStar">*</span></label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>

            <label>
            <input type="text" id="last_name" name="last_name" class="milo">
            </label>

            <label for="email">Email Address <span class="requiredStar">*</span></label>
            <input type="email" id="email" name="email" placeholder="youremail@email.com" required>

            <label for="rating">Review Rating <span class="requiredStar">*</span></label>
            <select id="rating" name="rating" required>
                <option value="" disabled selected>Select a Review Rating</option>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Fair</option>
                <option value="1">1 - Poor</option>
            </select>

            <label for="comment">Review Comments <span class="requiredStar">*</span></label>
            <textarea id="comment" name="comment" placeholder="Enter your comments here..." required></textarea>

            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <button type="submit">Submit Review</button>
        </form>
    </div>  
    </div>

    <h2 class="reviews_h2">What My Customers Say</h2>

    <div class="averageRating">
        <span class="rating"><?php echo str_repeat("⭐", (int)$overallRating); ?></span><br>
        <span class="averageReview"><?php echo $overallRating; ?> out of 5<br></span>
        <span class="totalReviews">(Based on <?php echo $totalReviews; ?> reviews)</span>
    </div>

    <a class="homeAdvisorLink" href="http://www.homeadvisor.com/rated.PrecisionHome.33173632.html">Click here to See more reviews on Home Advisor</a>

    <div class="current_reviews">
    <?php if (!empty($reviews)):?>
        <?php foreach ($reviews as $row): ?>
            <div class="review_card">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p class="rating"><?php echo str_repeat("⭐", (int)$row['rating']); // emojipedia.org/star ?></p>
                <p><?php echo nl2br(htmlspecialchars_decode($row['comment'])); ?></p>
                <small>Posted on <?php echo date("F j, Y", strtotime($row['created_at'])); ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No reviews yet. Be the first to leave one!</p>
    <?php endif; ?>
    </div>

    <button class="loadMore" id="loadMoreReviews">Load More</button>

    <footer class="homeFooter">
        <div class="footerContainer">
        <div class="footerAbout">
            <h3>Precision Home Inspections</h3>
            <p>Proudly serving Utah's Wasatch Front with honest, thorough, and reliable home inspections.</p>
        </div>


        <div class="footerContact">
            <p>Email: <a href="gary@phi-ut.com">gary@phi-ut.com</a></p>
            <p>Phone: (801) 608-7580</p>
            <p>Hours: Mon–Sat, 8am–6pm</p>
        </div>


        <div class="footerSocial">
            <a href="https://www.facebook.com/PrecisionHomeInspectionsUT/" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.linkedin.com/in/gary-elkins-451723b/" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        </div>
        </div>


        <div class="footerBottom">
            <p>&copy; <span id="currentYear"></span> | Precision Home Inspections.</p>
        </div>
    </footer>

    <script src="js/main.js"></script>

</body>
</html>