<?php

session_start();
require_once '../../0/includes/db.php'; // Include your database connection file

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $leaveId = $_POST['leaveId'] ?? null;
    $approvedBy = $_SESSION['user_id'] ?? null;

    if (!$leaveId || !$approvedBy) {
        echo json_encode(['success' => false, 'message' => 'Invalid input or user not logged in.']);
        exit;
    }

    try {
        // Update the leave_requests table
        $stmt = $pdo->prepare("
            UPDATE leave_requests
            SET status = 'Approved', 
                approved_by = :approve_by, 
                updated_at = NOW()
            WHERE id = :leave_id
        ");
        $stmt->bindParam(':approve_by', $approvedBy, PDO::PARAM_INT);
        $stmt->bindParam(':leave_id', $leaveId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Log the action in the `audit_trail` table
            $userId = $_SESSION['user_id'] ?? null; // The ID of the logged-in user
            if (!$userId) {
                echo json_encode(['success' => false, 'message' => 'User not logged in.']);
                exit;
            }

            $actionType = 'APPROVE'; // Action type
            $affectedTable = 'leave_requests'; // The table being updated
            $affectedId = $leaveId; // The ID of the affected leave request
            $details = sprintf('Approved leave request ID %d.', $leaveId); // Action details
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

            echo json_encode(['success' => true, 'message' => 'Leave request approved successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to approve leave request.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}