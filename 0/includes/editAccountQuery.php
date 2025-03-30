<?php
require_once '../../0/includes/db.php'; // Include your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    error_log("Received ID: " . $id); // Debugging log

    try {
        // Prepare the SQL query to fetch user data
        $stmt = $pdo->prepare("SELECT id, name, email, role, department FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        error_log("Received ID: " . $id); // Log the received ID

        if ($user) {
            error_log("User Found: " . print_r($user, true)); // Log fetched user
            echo json_encode(['success' => true, 'data' => $user]);
        } else {
            error_log("User not found.");
            echo json_encode(['success' => false, 'message' => 'User not found.']);
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage()); // Log the error
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
