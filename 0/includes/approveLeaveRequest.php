<?php
session_start();
require_once 'db.php'; // Ensure the database connection is included

// // Suppress warnings and log errors
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);
// ini_set('error_log', __DIR__ . '/error_log.txt');
// error_reporting(E_ALL);

header('Content-Type: application/json'); // Ensure the response is JSON

try {
    // Read the raw POST body
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate incoming data
    if (!isset($data['leaveId'], $data['approvedBy'], $data['leaveType'], $data['startDate'], $data['endDate'])) {
        echo json_encode(['success' => false, 'message' => 'Incomplete data.']);
        exit;
    }

    $leaveId = intval($data['leaveId']);
    $approvedBy = intval($data['approvedBy']);
    $leaveTypeRaw = $data['leaveType'];
    $startDate = $data['startDate'];
    $endDate = $data['endDate'];

    // Map frontend leave type to database column
    $leaveTypeColumnMap = [
        "Sick Leave" => "sl",
        "Service Incentive Leave" => "sil",
        "Earned Leave Credit" => "elc",
        "Management Initiated Leave" => "mil",
        "Maternity Leave" => "ml",
        "Paternity Leave" => "pl",
        "Solo Parent Leave" => "spl",
        "Bereavement Leave" => "brl",
        "Leave Without Pay" => "lwop",
    ];

    $leaveTypeColumn = $leaveTypeColumnMap[$leaveTypeRaw] ?? null;

    if (!$leaveTypeColumn) {
        echo json_encode(['success' => false, 'message' => 'Invalid leave type.']);
        exit;
    }

    // Calculate leave days (inclusive of start and end dates)
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $interval = $start->diff($end);
    $leaveDays = $interval->days + 1;

    $pdo->beginTransaction();

    // 1. Approve the leave
    $updateLeaveSql = "UPDATE leave_requests SET status = 'Approved', approved_by = :approvedBy, updated_at = NOW() WHERE id = :leaveId";
    $stmt = $pdo->prepare($updateLeaveSql);
    $stmt->execute([
        ':approvedBy' => $approvedBy,
        ':leaveId' => $leaveId,
    ]);

    // 2. Get the employee_id from leave_requests
    $fetchEmployeeSql = "SELECT employee_id FROM leave_requests WHERE id = :leaveId";
    $stmt = $pdo->prepare($fetchEmployeeSql);
    $stmt->execute([':leaveId' => $leaveId]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$employee) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Employee not found.']);
        exit;
    }

    $employeeId = $employee['employee_id'];

    // 3. Check if the employee has a record in used_balance
    $checkBalanceSql = "SELECT * FROM used_balance WHERE user_id = :employeeId";
    $stmt = $pdo->prepare($checkBalanceSql);
    $stmt->execute([':employeeId' => $employeeId]);
    $usedBalance = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usedBalance) {
        // Record exists, update it
        $currentValue = (int)($usedBalance[$leaveTypeColumn] ?? 0);
        $newValue = $currentValue + $leaveDays;

        $updateUsedSql = "UPDATE used_balance SET {$leaveTypeColumn} = :newValue WHERE user_id = :employeeId";
        $stmt = $pdo->prepare($updateUsedSql);
        $stmt->execute([
            ':newValue' => $newValue,
            ':employeeId' => $employeeId
        ]);
    } else {
        // No record yet, insert a new one
        $insertUsedSql = "INSERT INTO used_balance (user_id, {$leaveTypeColumn}) VALUES (:employeeId, :leaveDays)";
        $stmt = $pdo->prepare($insertUsedSql);
        $stmt->execute([
            ':employeeId' => $employeeId,
            ':leaveDays' => $leaveDays
        ]);
    }


    // Step 4: Insert into the `audit_trail` table
    $actionType = 'APPROVE_LEAVE'; // Action type
    $affectedTable = 'leave_requests'; // The table being updated
    $affectedId = $leaveId; // The ID of the approved leave request
    $details = "Approved leave request ID $leaveId for employee ID $employeeId. Leave type: $leaveTypeRaw, Start date: $startDate, End date: $endDate, Days: $leaveDays.";
    $userId = $_SESSION['user_id']; // The ID of the logged-in user performing the action

    $auditStmt = $pdo->prepare("
    INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
    VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, NOW())
");
    $auditStmt->bindParam(':actionType', $actionType);
    $auditStmt->bindParam(':affectedTable', $affectedTable);
    $auditStmt->bindParam(':affectedId', $affectedId, PDO::PARAM_INT);
    $auditStmt->bindParam(':details', $details);
    $auditStmt->bindParam(':userId', $userId, PDO::PARAM_INT);

    if (!$auditStmt->execute()) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Failed to log audit trail.']);
        exit;
    }

    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Leave approved and balance updated.']);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log('Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
