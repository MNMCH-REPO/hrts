<?php
require_once 'db.php'; // Include the database connection file
session_start(); // Start the session to access user data

if (isset($_SESSION['user_id'])) {
    try {
        // Log the sign-out action in the `audit_trail` table
        $actionType = 'LOGOUT'; // Action type
        $affectedTable = 'users'; // The table being affected
        $affectedId = $_SESSION['user_id']; // The ID of the logged-in user
        $details = "User ID {$_SESSION['user_id']} logged out successfully.";
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp

        $auditStmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
            VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, :timestamp)
        ");
        $auditStmt->bindParam(':actionType', $actionType);
        $auditStmt->bindParam(':affectedTable', $affectedTable);
        $auditStmt->bindParam(':affectedId', $affectedId, PDO::PARAM_INT);
        $auditStmt->bindParam(':details', $details);
        $auditStmt->bindParam(':userId', $affectedId, PDO::PARAM_INT); // Use the logged-in user's ID
        $auditStmt->bindParam(':timestamp', $timestamp);
        $auditStmt->execute();
    } catch (PDOException $e) {
        // Log the error for debugging
        error_log("Audit trail error: " . $e->getMessage());
    }
}

// Destroy the session
session_unset();
session_destroy();

// Redirect to the login page
header('Location: ../../index.php');
exit;
?>