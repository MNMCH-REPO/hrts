<?php
require_once '../../0/includes/db.php'; // Include your database connection file

session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the POST request
    $ticketId = $_POST['ticketId'] ?? null;
    $status = $_POST['statusEdit'] ?? null;

    // Validate input fields
    if (empty($ticketId) || empty($status)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Validate the status to ensure it's either 'In Progress' or 'Resolved'
    $validStatuses = ['In Progress', 'Resolved'];
    if (!in_array($status, $validStatuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status selected.']);
        exit;
    }

    try {
        // Begin a transaction
        $pdo->beginTransaction();

        // Step 1: Update the ticket status in the `tickets` table
        $stmt = $pdo->prepare("UPDATE tickets 
                               SET status = :status, updated_at = NOW() 
                               WHERE id = :ticketId");

        // Bind parameters
        $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        // Execute the query
        if (!$stmt->execute()) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to update status.']);
            exit;
        }

        // Step 2: Insert into the `audit_trail` table
        $actionType = 'UPDATE'; // Action type
        $affectedTable = 'tickets'; // The table being updated
        $affectedId = $ticketId; // The ID of the updated ticket
        $details = "Updated ticket ID $ticketId status to $status.";
        $userId = $_SESSION['user_id'] ?? null; // The ID of the logged-in user performing the action
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp

        if (!$userId) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
            exit;
        }

        $auditStmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
            VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, :timestamp)
        ");
        $auditStmt->bindParam(':actionType', $actionType);
        $auditStmt->bindParam(':affectedTable', $affectedTable);
        $auditStmt->bindParam(':affectedId', $affectedId, PDO::PARAM_INT);
        $auditStmt->bindParam(':details', $details);
        $auditStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $auditStmt->bindParam(':timestamp', $timestamp);

        if (!$auditStmt->execute()) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to log audit trail.']);
            exit;
        }

        // Commit the transaction
        $pdo->commit();

        echo json_encode(['success' => true, 'message' => 'Status updated and logged successfully.']);
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}