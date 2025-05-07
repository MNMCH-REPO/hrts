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
    $stmt = $pdo->prepare("UPDATE leave_requests SET status = 'Rejected', approved_by = :approved_by, updated_at = NOW() WHERE id = :leave_id");
    $stmt->bindParam(':leave_id', $leaveId, PDO::PARAM_INT);
    $stmt->bindParam(':approved_by', $approvedBy, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Log the action in the audit_trail table
        $actionType = 'REJECT LEAVE REQUEST'; // Action type
        $affectedTable = 'leave_requests'; // The table being affected
        $details = "Rejected leave request for Leave ID $leaveId.";
        $adminId = $approvedBy; // Assuming the admin performing the action is the same as `approved_by`

        $auditStmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
            VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, NOW())
        ");
        $auditStmt->bindParam(':actionType', $actionType);
        $auditStmt->bindParam(':affectedTable', $affectedTable);
        $auditStmt->bindParam(':affectedId', $leaveId, PDO::PARAM_INT);
        $auditStmt->bindParam(':details', $details);
        $auditStmt->bindParam(':userId', $adminId, PDO::PARAM_INT);

        if ($auditStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Leave request rejected successfully and action logged.']);
        } else {
            $errorInfo = $auditStmt->errorInfo();
            echo json_encode(['success' => false, 'message' => 'Leave rejected but failed to log action: ' . $errorInfo[2]]);
        }
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['success' => false, 'message' => 'SQL Error: ' . $errorInfo[2]]);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}