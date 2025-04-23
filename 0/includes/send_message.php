<?php
require 'session.php';
require 'db.php';

header("Content-Type: application/json");

// Check if the user is logged in and required fields are provided
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

if (!isset($_POST['message']) || !isset($_POST['ticket_id'])) {
    echo json_encode(['success' => false, 'message' => 'Message and Ticket ID are required.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$message = trim(string: $_POST['message']);
$ticket_id = intval($_POST['ticket_id']); // Ensure ticket_id is an integer

// Validate the message content
if ($message === "") {
    echo json_encode(value: ['success' => false, 'message' => 'Message cannot be empty.']);
    exit;
}

try {
    // Begin a transaction
    $pdo->beginTransaction();

    // Step 1: Insert the message into the `ticket_responses` table
    $stmt = $pdo->prepare("
        INSERT INTO ticket_responses (ticket_id, user_id, response_text, created_at) 
        VALUES (:ticket_id, :user_id, :message, NOW())
    ");
    $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->execute();

    // Get the ID of the newly created response
    $responseId = $pdo->lastInsertId();

    // Step 2: Insert into the `audit_trail` table
    $actionType = 'INSERT'; // Action type
    $affectedTable = 'ticket_responses'; // The table being updated
    $affectedId = $responseId; // The ID of the created response
    $details = "Added response to ticket ID $ticket_id: $message";
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

    echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
} catch (PDOException $e) {
    // Rollback the transaction on error
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}