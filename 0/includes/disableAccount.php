<?php
require_once 'db.php'; // Include your database connection file
session_start();

header("Content-Type: application/json");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Check if the required fields are provided
if (!isset($_POST['idhidden'])) {
    echo json_encode(['success' => false, 'message' => 'Account ID is required.']);
    exit;
}

$accountId = intval($_POST['idhidden']); // Get the account ID from the form
$currentUserId = $_SESSION['user_id']; // The ID of the logged-in user performing the action

try {
    // Begin a transaction
    $pdo->beginTransaction();

    // Step 1: Update the account's status in the `users` table
    $stmt = $pdo->prepare("UPDATE users SET status = 'Inactive' WHERE id = :id");
    $stmt->bindParam(':id', $accountId, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Failed to disable the account.']);
        exit;
    }

    // Step 2: Log the action in the `audit_trail` table
    $actionType = 'DISABLE';
    $affectedTable = 'users';
    $details = "Disabled account with ID $accountId.";


    $auditStmt = $pdo->prepare("
        INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
        VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, NOW())
    ");
    $auditStmt->bindParam(':actionType', $actionType);
    $auditStmt->bindParam(':affectedTable', $affectedTable);
    $auditStmt->bindParam(':affectedId', $accountId, PDO::PARAM_INT);
    $auditStmt->bindParam(':details', $details);
    $auditStmt->bindParam(':userId', $currentUserId, PDO::PARAM_INT);


    if (!$auditStmt->execute()) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Failed to log the action in the audit trail.']);
        exit;
    }

    // Commit the transaction
    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Account disabled successfully.']);
} catch (PDOException $e) {
    // Rollback the transaction on error
    $pdo->rollBack();
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}
