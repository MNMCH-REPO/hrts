<?php
require_once '../../0/includes/db.php'; // Ensure this file initializes the global $pdo variable
session_start(); // Start the session to access user data
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $pdo;

    // Get the JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    $action = $input['action'] ?? null;
    $ticketId = $input['ticketId'] ?? null;

    // Debugging: Log the input data
    error_log("Action: " . $action);
    error_log("Ticket ID: " . $ticketId);

    if (!$action || !$ticketId) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit;
    }

    try {
        // Define the actions in an associative array
        $actions = [
            'confirm' => [
                'query' => "UPDATE tickets SET status = 'In Progress', start_at = NOW() WHERE id = :id",
                'message' => 'Ticket status updated to "In Progress".',
                'details' => 'Confirmed ticket ID %d and updated status to "In Progress".',
            ],
            'decline' => [
                'query' => "UPDATE tickets SET status = 'Open', assigned_to = NULL WHERE id = :id",
                'message' => 'Ticket assignment removed.',
                'details' => 'Declined ticket ID %d and removed assignment.',
            ],
        ];

        if (!array_key_exists($action, $actions)) {
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            exit;
        }

        // Execute the query based on the action
        $stmt = $pdo->prepare($actions[$action]['query']);
        $stmt->bindParam(':id', $ticketId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Log the action in the `audit_trail` table
            $userId = $_SESSION['user_id'] ?? null; // The ID of the logged-in user
            if (!$userId) {
                echo json_encode(['success' => false, 'message' => 'User not logged in.']);
                exit;
            }

            $actionType = strtoupper($action); // Action type (e.g., CONFIRM or DECLINE)
            $affectedTable = 'tickets'; // The table being updated
            $affectedId = $ticketId; // The ID of the affected ticket
            $details = sprintf($actions[$action]['details'], $ticketId); // Action details
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
                echo json_encode(['success' => false, 'message' => 'Failed to log audit trail.']);
                exit;
            }

            // Debugging: Log successful execution
            error_log("Query executed successfully for Ticket ID: " . $ticketId);
            echo json_encode(['success' => true, 'message' => $actions[$action]['message']]);
        } else {
            // Debugging: Log failed execution
            error_log("Query failed for Ticket ID: " . $ticketId);
            echo json_encode(['success' => false, 'message' => 'Failed to update the ticket.']);
        }
    } catch (PDOException $e) {
        // Debugging: Log database error
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
?>