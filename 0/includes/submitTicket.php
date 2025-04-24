<?php
// session_start();
// require "db.php"; // Ensure correct database connection

// header("Content-Type: application/json");

// // Get the current logged-in user's ID from the session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}
$currentUserId = $_SESSION['user_id'];
$stmt = $pdo->prepare("select * from leave_balances where id = :id");
$stmt->execute([':id' => $currentUserId]);
$leaveBalance = $stmt->fetch(PDO::FETCH_ASSOC);
echo 'const leaveBalances = {
        "Sick Leave": '.$leaveBalance[''].',
        "Service Incentive Leave": 3,
        "Earned Leave Credit": 2,
        "Vacation": 10,
        "Emergency Leave": 1
    };
';


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submitTicketBtn'])) {
        $employeeId = $_POST['employeeId'] ?? null;
        $employeeName = trim($_POST['employeeName'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $description = trim($_POST['description'] ?? '');

        // Establish a PDO connection
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->beginTransaction();

        // Insert the ticket into the `tickets` table
        $stmt = $pdo->prepare("
            INSERT INTO tickets (employee_id, subject, category_id, description, created_at) 
            VALUES (:employee_id, :subject, :category_id, :description, NOW())
        ");
        $stmt->execute([
            ':employee_id' => $employeeId,
            ':subject' => $subject,
            ':category_id' => $category, // Category ID from the dropdown
            ':description' => $description
        ]);

        // Get the ID of the newly created ticket
        $ticketId = $pdo->lastInsertId();

        // Prepare audit trail details
        $actionType = "CREATE";
        $affectedTable = 'tickets';
        $affectedId = $ticketId; // The ID of the created ticket
        $details = "Created ticket: Subject=$subject, Category=$category, Description=$description";
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
}
elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submitLeaveBtn'])) {
    try {
        $employeeId = $_POST['employeeId'] ?? null;
        $employeeName = trim($_POST['employeeName'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $leaveType = trim($_POST['leaveType'] ?? '');
        $startDate = trim($_POST['startDate'] ?? '');
        $endDate = trim($_POST['endDate'] ?? '');
        $reason = trim($_POST['reason'] ?? '');
    
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->beginTransaction();
    
        // Insert the leave request into the `leave_requests` table
        $stmt = $pdo->prepare("
            INSERT INTO leave_requests (employee_id, leave_type, start_date, end_date, created_at) 
            VALUES (:employee_id, :leave_type, :start_date, :end_date, NOW())
        ");
        $stmt->execute([
            ':employee_id' => $employeeId,
            ':leave_type' => $leaveType,
            ':start_date' => $startDate,
            ':end_date' => $endDate
        ]);
    
        // Get the ID of the newly created leave request
        $leaveRequestId = $pdo->lastInsertId();
    
        // Prepare audit trail details
        $actionType = "CREATE";
        $affectedTable = 'leave_requests';
        $affectedId = $leaveRequestId;
        $details = "Created leave request: Type=$leaveType, Start=$startDate, End=$endDate, Reason=$reason";
        $timestamp = date('Y-m-d H:i:s');
    
        // Insert into the `audit_trail` table
        $stmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
            VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, :timestamp)
        ");
        $stmt->bindParam(':actionType', $actionType);
        $stmt->bindParam(':affectedTable', $affectedTable);
        $stmt->bindParam(':affectedId', $affectedId);
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':userId', $currentUserId);
        $stmt->bindParam(':timestamp', $timestamp);
        $stmt->execute();
    
        $pdo->commit();
        echo json_encode(["success" => true, "message" => "Leave request submitted successfully."]);
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(["success" => false, "message" => "An unexpected error occurred: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}