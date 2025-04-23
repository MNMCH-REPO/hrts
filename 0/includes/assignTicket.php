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
    $priority = $_POST['priority'] ?? null;
    $assignTo = $_POST['assignTo'] ?? null;

    // Validate input fields
    if (empty($ticketId) || empty($priority) || empty($assignTo)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    try {
        // Step 1: Validate the `assignTo` ID against the `users` table
        $userStmt = $pdo->prepare("SELECT name FROM users WHERE id = :assignTo");
        $userStmt->bindParam(':assignTo', $assignTo, PDO::PARAM_INT);
        $userStmt->execute();
        $assignedUser = $userStmt->fetch(PDO::FETCH_ASSOC);

        if (!$assignedUser) {
            echo json_encode(['success' => false, 'message' => 'Assigned user not found.']);
            exit;
        }

        $assignedToName = $assignedUser['name']; // Get the user's name for logging or response

        // Begin a transaction
        $pdo->beginTransaction();

        // Step 2: Update the ticket in the `tickets` table
        $stmt = $pdo->prepare("UPDATE tickets 
                               SET priority = :priority, 
                                   assigned_to = :assignTo
                               WHERE id = :ticketId");

        // Bind parameters
        $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->bindParam(':priority', $priority, PDO::PARAM_STR);
        $stmt->bindParam(':assignTo', $assignTo, PDO::PARAM_INT);

        // Execute the query
        if (!$stmt->execute()) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to update ticket.']);
            exit;
        }

        // Step 3: Insert into the `audit_trail` table
        $actionType = 'ASSIGN'; // Action type
        $affectedTable = 'tickets'; // The table being updated
        $affectedId = $ticketId; // The ID of the updated ticket
        $details = "Assigned ticket ID $ticketId to user $assignedToName (ID: $assignTo) with priority $priority.";
        $userId = $_SESSION['user_id']; // The ID of the logged-in user performing the action
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp

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

        // Return the success response with the assigned user's name
        echo json_encode([
            'success' => true,
            'message' => 'Ticket updated and logged successfully.',
            'assignedToName' => $assignedToName,
            'assignedToId' => $assignTo
        ]);
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}