<?php
session_start();
require_once '../0/includes/db.php'; // Ensure this returns $pdo for PDO

header("Content-Type: application/json");

// Get the current logged-in user's ID from the session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}
$currentUserId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $employeeId = $_POST['employeeId'] ?? null;
        $employeeName = trim($_POST['employeeName'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $leaveType = trim($_POST['leaveType'] ?? '');
        $startDate = trim($_POST['startDate'] ?? '');
        $endDate = trim($_POST['endDate'] ?? '');
        $reason = trim($_POST['reason'] ?? '');

        // Validate required fields
        if (!$employeeId || empty($employeeName) || empty($department) || empty($leaveType) || empty($startDate) || empty($endDate) || empty($reason)) {
            echo json_encode(["success" => false, "message" => "All fields are required."]);
            exit();
        }

        // Establish a PDO connection
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        // Check if employee ID exists and validate both name and department
        $stmt = $pdo->prepare("SELECT name, department FROM users WHERE id = :employee_id");
        $stmt->execute([':employee_id' => $employeeId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo json_encode(["success" => false, "message" => "Invalid Employee ID."]);
            exit();
        }

        if ($user['name'] !== $employeeName) {
            echo json_encode(["success" => false, "message" => "Employee Name does not match our records."]);
            exit();
        }

        if ($user['department'] !== $department) {
            echo json_encode(["success" => false, "message" => "Selected department does not match your registered department."]);
            exit();
        }

        // Begin a transaction
        $pdo->beginTransaction();

        // Insert the leave request into the `leave_requests` table
        $stmt = $pdo->prepare("
            INSERT INTO leave_requests (employee_id, employee_name, department, leave_type, start_date, end_date, reason, created_at) 
            VALUES (:employee_id, :employee_name, :department, :leave_type, :start_date, :end_date, :reason, NOW())
        ");
        $stmt->execute([
            ':employee_id' => $employeeId,
            ':employee_name' => $employeeName,
            ':department' => $department,
            ':leave_type' => $leaveType,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':reason' => $reason
        ]);

        // Get the ID of the newly created leave request
        $leaveRequestId = $pdo->lastInsertId();

        // Prepare audit trail details
        $actionType = "CREATE";
        $affectedTable = 'leave_requests';
        $affectedId = $leaveRequestId; // The ID of the created leave request
        $details = "Created leave request: Type=$leaveType, Start=$startDate, End=$endDate, Reason=$reason";
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp

        // Insert into the `audit_trail` table
        $stmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
            VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, :timestamp)
        ");
        $stmt->bindParam(':actionType', $actionType);
        $stmt->bindParam(':affectedTable', $affectedTable);
        $stmt->bindParam(':affectedId', $affectedId);
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':userId', $currentUserId); // Use the logged-in user's ID
        $stmt->bindParam(':timestamp', $timestamp);
        $stmt->execute();

        // Commit the transaction
        $pdo->commit();

        echo json_encode(["success" => true, "message" => "Leave request submitted successfully."]);
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}