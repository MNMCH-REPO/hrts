<?php
require_once '../../0/includes/db.php'; // Ensure this file initializes the global $pdo variable

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
                'query' => "UPDATE tickets SET status = 'In Progress', created_at = NOW() WHERE id = :id",
                'message' => 'Ticket status updated to "In Progress".',
            ],
            'decline' => [
                'query' => "UPDATE tickets SET assigned_to = NULL WHERE id = :id",
                'message' => 'Ticket assignment removed.',
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