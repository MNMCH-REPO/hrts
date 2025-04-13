<?php
session_start();
require '../../0/includes/db.php';

header("Content-Type: application/json");

// Check if the user is logged in and required fields are provided
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

if (!isset($_POST['file_path']) || !isset($_POST['ticket_id'])) {
    echo json_encode(['success' => false, 'message' => 'File path and Ticket ID are required.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$file_path = trim($_POST['file_path']);
$ticket_id = intval($_POST['ticket_id']); // Ensure ticket_id is an integer

// Validate the file path
if ($file_path === "") {
    echo json_encode(['success' => false, 'message' => 'File path cannot be empty.']);
    exit;
}

try {
    // Begin a transaction
    $pdo->beginTransaction();

    // Step 1: Insert the attachment into the `attachments` table
    $stmt = $pdo->prepare("
        INSERT INTO attachments (ticket_id, user_id, file_path, uploaded_at) 
        VALUES (:ticket_id, :user_id, :file_path, NOW())
    ");
    $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':file_path', $file_path, PDO::PARAM_STR);
    $stmt->execute();

    // Get the ID of the newly created attachment
    $attachmentId = $pdo->lastInsertId();

    // Step 2: Insert into the `audit_trail` table
    $actionType = 'INSERT'; // Action type
    $affectedTable = 'attachments'; // The table being updated
    $affectedId = $attachmentId; // The ID of the created attachment
    $details = "Added attachment to ticket ID $ticket_id: $file_path";
    $timestamp = date('Y-m-d H:i:s'); // Current timestamp

    $stmt = $pdo->prepare("
        INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
        VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, :timestamp)
    ");
    $stmt->bindParam(':actionType', $actionType);
    $stmt->bindParam(':affectedTable', $affectedTable);
    $stmt->bindParam(':affectedId', $affectedId, PDO::PARAM_INT);
    $stmt->bindParam(':details', $details);
    $stmt->bindParam(':userId', $user_id, PDO::PARAM_INT); // Use the logged-in user's ID
    $stmt->bindParam(':timestamp', $timestamp);
    $stmt->execute();

    // Commit the transaction
    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Attachment uploaded successfully.']);
} catch (PDOException $e) {
    // Rollback the transaction on error
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}