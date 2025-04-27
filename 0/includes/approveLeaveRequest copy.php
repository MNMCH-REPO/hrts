<?php
session_start(); // Start the session
require_once '../../0/includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON payload
    $data = json_decode(file_get_contents('php://input'), true);

    $leaveId = $data['leaveId'];
    $approvedBy = $_SESSION['user_id'];

    // Debugging: Log the received data
    error_log("Received leaveId: " . json_encode($data['leaveId']));
    error_log("Session user_id (approvedBy): " . $_SESSION['user_id']);

    // Validate input
    if (!$leaveId || !$approvedBy) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit();
    }

    try {
        // Update the leave request status to "Approved"
        $stmt = $pdo->prepare("
            UPDATE leave_requests
            SET status = 'Approved', approved_by = :approvedBy, updated_at = NOW()
            WHERE id = :leaveId
        ");
        $stmt->bindParam(':approvedBy', $approvedBy, PDO::PARAM_INT);
        $stmt->bindParam(':leaveId', $leaveId, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Leave request approved successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Leave request not found or already approved.']);
        }
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}