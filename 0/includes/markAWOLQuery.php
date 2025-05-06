<?php

require 'db.php';
if (!isset($_SESSION['user_id'])) {
    session_start();
}
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Error: User not logged in.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = $_POST['employeeLeaveUserId'] ?? null;
    $approvedBy = $_POST['approvedBy'] ?? null;

    // Validate required fields
    if (!$employeeId || !$approvedBy) {
        echo json_encode(['success' => false, 'message' => 'Error: All fields are required.']);
        exit();
    }

    $status = 'Approved';
    $reason = 'AWOL';





    try {

                // Step 0: Check for existing AWOL record for today
                $awolCheckSql = "
                SELECT COUNT(*) as count
                FROM leave_requests
                WHERE employee_id = :employee_id
                AND leave_types = 'AWOL'
                AND reason = 'AWOL'
                AND DATE(start_date) = CURDATE()
                AND DATE(end_date) = CURDATE()
                ";
                $checkStmt = $pdo->prepare($awolCheckSql);
                $checkStmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);
                $checkStmt->execute();
                $awolCheck = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
                if ($awolCheck['count'] > 0) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'This employee has already been marked as AWOL today.'
                    ]);
                    exit();
                }
    
        // Begin transaction
        $pdo->beginTransaction();

        // Step 1: Insert data into the leave_requests table
        $stmt = $pdo->prepare("
            INSERT INTO leave_requests (employee_id, leave_types, start_date, end_date, reason, status, created_at, approved_by, updated_at)
            VALUES (:employee_id, 'AWOL', NOW(), NOW(), :reason, :status, NOW(), :approved_by, NOW())
        ");
        $stmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);
        $stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':approved_by', $approvedBy, PDO::PARAM_INT);

        $stmt->execute();

        // Step 2: Check if a record exists in the used_balance table
        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM used_balance WHERE user_id = :employee_id");
        $checkStmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);
        $checkStmt->execute();
        $recordExists = $checkStmt->fetchColumn();

        if (!$recordExists) {
            // Step 3: Insert a new record into the used_balance table if none exists
            try {
                $insertStmt = $pdo->prepare("INSERT INTO used_balance (user_id, awol) VALUES (:employee_id, 1)");
                $insertStmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);
                $insertStmt->execute();
                error_log("Inserted new record into used_balance for employeeId: $employeeId");
            } catch (Exception $e) {
                throw new Exception("Failed to insert into used_balance: " . $e->getMessage());
            }
        } else {
            // Step 4: Update the AWOL count in the used_balance table
            try {
                $updateStmt = $pdo->prepare("UPDATE used_balance SET awol = awol + 1 WHERE user_id = :employee_id");
                $updateStmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);
                $updateStmt->execute();
                error_log("Updated AWOL count in used_balance for employeeId: $employeeId");
            } catch (Exception $e) {
                throw new Exception("Failed to update used_balance: " . $e->getMessage());
            }
        }

        // Commit the transaction
        $pdo->commit();

        echo json_encode(['success' => true, 'message' => 'Marked as AWOL successfully.']);
    } catch (Exception $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        error_log("Error in markAWOLQuery.php: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}
