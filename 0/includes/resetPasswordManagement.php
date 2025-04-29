<?php
require_once 'db.php'; // Include your database connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
        exit;
    }

    // Get the user ID of the account to reset
    $accountId = $_POST['idhidden'] ?? null;

    // Validate input
    if (empty($accountId)) {
        echo json_encode(['success' => false, 'message' => 'Account ID is required.']);
        exit;
    }

    try {
        // Set the password to a blank password (hashed)
        $blankPasswordHash = password_hash('', PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', $blankPasswordHash, PDO::PARAM_STR);
        $stmt->bindParam(':id', $accountId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Log the password reset action in the `audit_trail` table
            $actionType = 'PASSWORD_RESET'; // Action type
            $affectedTable = 'users'; // The table being affected
            $affectedId = $accountId; // The ID of the user whose password was reset
            $details = "Password for User ID $accountId was reset to a blank password.";
            $adminId = $_SESSION['user_id']; // The ID of the admin performing the reset


            $auditStmt = $pdo->prepare("
                INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
                VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, NOW())
            ");
            $auditStmt->bindParam(':actionType', $actionType);
            $auditStmt->bindParam(':affectedTable', $affectedTable);
            $auditStmt->bindParam(':affectedId', $affectedId, PDO::PARAM_INT);
            $auditStmt->bindParam(':details', $details);
            $auditStmt->bindParam(':userId', $adminId, PDO::PARAM_INT);

            $auditStmt->execute();

            echo json_encode(['success' => true, 'message' => 'Password reset successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to reset password.']);
        }
    } catch (PDOException $e) {
        // Log the error for debugging (do not expose sensitive details to the user)
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An unexpected error occurred. Please try again later.']);
    }
}
