<?php

if (!isset($_SESSION['user_id'])) {
    session_start();
}
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Error: User not logged in.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON body
    $employeeId = $_POST['employeeLeaveUserId'] ?? null;

    // Validate required fields
    if (!$employeeId) {
        echo json_encode(['success' => false, 'message' => 'Error: Employee ID is required.']);
        exit();
    }

    try {
        // Check if the employee is already marked as AWOL for the same day
        $checkAWOLStmt = $pdo->prepare("
            SELECT COUNT(*) 
            FROM leave_requests 
            WHERE employee_id = :employee_id 
              AND leave_types = 'AWOL' 
              AND DATE(created_at) = CURDATE()
              AND DATE(updated_at) = CURDATE()
        ");
        $checkAWOLStmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);
        $checkAWOLStmt->execute();
        $alreadyMarkedAWOL = $checkAWOLStmt->fetchColumn();

        if ($alreadyMarkedAWOL > 0) {
           
        } else {
           
        }
    } catch (Exception $e) {
       
    }
}