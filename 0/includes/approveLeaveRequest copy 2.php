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
        "Birthday Leave" => "bl",
        "Maternity Leave" => "ml",
        "Paternity Leave" => "pl",
        "Solo Parent Leave" => "spl",
        "Bereavement Leave" => "brl",
        "Special Leave" => "s",
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

    // 4. Update total_balance (subtract leave days)
    $fetchTotalSql = "SELECT {$leaveTypeColumn} FROM total_balance WHERE user_id = :employeeId";
    $stmt = $pdo->prepare($fetchTotalSql);
    $stmt->execute([':employeeId' => $employeeId]);
    $totalBalance = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($totalBalance) {
        $currentTotal = (int)($totalBalance[$leaveTypeColumn] ?? 0);
        $newTotal = max($currentTotal - $leaveDays, 0); // Prevent negative balance

        $updateTotalSql = "UPDATE total_balance SET {$leaveTypeColumn} = :newTotal WHERE user_id = :employeeId";
        $stmt = $pdo->prepare($updateTotalSql);
        $stmt->execute([
            ':newTotal' => $newTotal,
            ':employeeId' => $employeeId
        ]);
    } else {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Total balance record not found.']);
        exit;
    }
    

    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Leave approved and balance updated.']);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log('Error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}