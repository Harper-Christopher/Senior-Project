<?php 

// Get all approved reviews from the database
function getApprovedReviews(PDO $pdo): array {
    // Taking the php object created in the database prepare the SQL select and then execute it. 
    $stmt = $pdo->prepare("SELECT name, rating, comment, created_at FROM reviews WHERE approved = 1 ORDER BY created_at DESC");
    $stmt->execute();

    // Get everything in the database and return it back to the page. 
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get all unapproved reviews from the database 
function getUnapprovedReviews(PDO $pdo): array {
    // Taking the php object created in the database prepare the SQL select and then execute it. 
    $stmt = $pdo->prepare("SELECT id, name, rating, comment, created_at FROM reviews WHERE approved = 0 ORDER BY created_at DESC");
    $stmt->execute();

    // Get everything in the database and return it back to the page.  
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get the average rating for all the reviews in the database
function averageRating(PDO $pdo): array {
    // Taking the php object created in the database prepare the SQL select and then execute it.
    $stmt = $pdo->prepare("SELECT AVG(rating) AS average, COUNT(*) AS count FROM reviews WHERE approved = 1");
    $stmt->execute();

    // Get everything in the database to use.
    $averageReview = $stmt->fetch(PDO::FETCH_ASSOC);

    return ['average' => $averageReview['average'] !== null ? (float)$averageReview['average'] : 0,
            'count' => (int)$averageReview['count']];
}

// Submit a new review 
function submitReview(PDO $pdo, array $postData) {
    // (HONEYPOT / SPAM BOT TRAP) If input last_name isn't empty, exit program and display error message.
    if (!empty($_POST["last_name"])) {
        // Stop program if the hidden field is filled in
        die("An error has occured!");
    }

    // (Validate and Sanitize Form input submission)
    $name = htmlspecialchars(trim($_POST["name"])); // Removes tags and whitespace
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); // Cleans email 
    $rating = (INT) $_POST["rating"]; // (INT) to change to integer instead of text to prevent injection
    $comment = htmlspecialchars(trim($_POST["comment"])); // Removes tags and whitespace

    // Check to see if fields are empty. 
    if (empty($name) || empty($email) || empty($rating) || empty($comment)) {
        // Stop program if a field was left empty.
        die("Please fill in all required fields.");
    }

    // Using placeholders (?) to prevent SQL injection
    $stmt = $pdo->prepare("
        INSERT INTO reviews (name, email, rating, comment, created_at)
        VALUES (?, ?, ?, ?, NOW())
    ");

    // 'execute()' fills in placeholders with user data safely
    $stmt->execute([$name, $email, $rating, $comment]);

    // Provide a confirmation that a review was successfully submited.
    header("Location: review_thankYou.html");
    exit;
}

// Generate CSRF token if missing 
function generateCsrfToken(): void {
    // Generate a CSRF (Cross-Site Request Forgery) token if one doesn't exist 
    if (empty($_SESSION['csrf_token'])) {
        // bin2hex(random_bytes(32)) generates a random 64-character string impossible to guess.
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

// Verify CSRF token sent from our form matches the one stored in the session.
function verifyCsrfToken(?string $token): bool {
    // If the session token doesn't exist or the provided token is not a string, verification fails.
    if(!isset($_SESSION['csrf_token']) || !is_string($token)) {
        return false;
    }
    // Compare the session token and the provided token. Hash_equals() helps prevent timing attacks. 
    return hash_equals($_SESSION['csrf_token'], $token);
}

// Approve a review by collecting the review ID and updating the database based on the ID. 
function approveReview(PDO $pdo, int $review_id): bool {
    $stmt = $pdo->prepare("UPDATE reviews SET approved = 1 WHERE id = ?");
    return $stmt->execute([$review_id]);
}

// Delete a review by collecting the review ID and updating the database based on the ID.
function deleteReview(PDO $pdo, int $review_id): bool {
    $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
    return $stmt->execute([$review_id]);
}

?>