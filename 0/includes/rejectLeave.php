<?php
require_once 'db.php'; // Include your database connection file

header('Content-Type: application/json');

try {
    // Get the JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (empty($input['leave_id']) || empty($input['approved_by'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit;
    }

    $leaveId = $input['leave_id'];
    $approvedBy = $input['approved_by'];


    // Update the leave_requests table
    $stmt = $pdo->prepare("UPDATE leave_requests SET status = 'Rejected', approved_by = :approved_by WHERE id = :leave_id");
    $stmt->bindParam(':leave_id', $leaveId, PDO::PARAM_INT);
    $stmt->bindParam(':approved_by', $approvedBy, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Leave request rejected successfully.']);
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['success' => false, 'message' => 'SQL Error: ' . $errorInfo[2]]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}