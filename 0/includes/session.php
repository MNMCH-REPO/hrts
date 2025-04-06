<?php
date_default_timezone_set('Asia/Manila');
ini_set('session.gc_maxlifetime', 3600); // 1 hour
session_set_cookie_params(3600); // 1 hour

session_set_cookie_params([
    'lifetime' => 3600, // 1 hour
    'path' => '/',
    'domain' => '', // Set to your domain
    'secure' => true, // Only send cookies over HTTPS
    'httponly' => true, // Only accessible through the HTTP protocol
    'samesite' => 'Strict' // Prevent CSRF attacks
]);

// Start the session
session_start();

// Regenerate session ID every hour
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} elseif (time() - $_SESSION['CREATED'] > 3600) {
    // Session started more than 1 hour ago
    session_regenerate_id(true);    // Change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // Update creation time
    // session_unset();            // Clear session variables
    // session_destroy();          // Destroy the session
    // header("Location: ../../index.php"); // Redirect to login page
    // exit();
}


if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    

    try {
        // Fetch the latest user data from the database
        $stmt = $pdo->prepare("SELECT name, email, role, department FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Update session variables with the latest data
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['department'] = $user['department'];

            // Create an associative array for JavaScript
            $userData = [
                "User ID" => $userId,
                "Name" => $user['name'],
                "Role" => $user['role'],
                "Email" => $user['email'],
                "Department" => $user['department']
            ];

            // Convert the array to a JSON object and output it for JavaScript
            echo '<script>';
            echo 'const userData = ' . json_encode($userData, JSON_PRETTY_PRINT) . ';';
            echo 'console.log(userData);';
            echo '</script>';
        } else {
            // Handle case where user is not found in the database
            echo '<script>console.error("User not found in the database.");</script>';
        }
    } catch (PDOException $e) {
        echo '<script>console.error("Database error: ' . $e->getMessage() . '");</script>';
    }
} else {
    echo '<script>console.error("User is not logged in.");</script>';
}
?>