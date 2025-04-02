<?php
require_once '../../0/includes/db.php'; // Include your database connection file

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
        // Prepare the SQL query to update the ticket
        $stmt = $pdo->prepare("UPDATE tickets 
                               SET priority = :priority, 
                                   assigned_to = :assignTo,
                                   status = 'In Progress'
                               WHERE id = :ticketId");

        // Bind parameters
        $stmt->bindParam(':ticketId', $ticketId, PDO::PARAM_INT);
        $stmt->bindParam(':priority', $priority, PDO::PARAM_STR);
        $stmt->bindParam(':assignTo', $assignTo, PDO::PARAM_INT);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Ticket updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update ticket.']);
        }
    } catch (PDOException $e) {
        // Log the error for debugging
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>