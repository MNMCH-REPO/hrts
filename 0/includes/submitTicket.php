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

//fetch leave balances
$stmt = $pdo->prepare("
    SELECT sick_leave_value, service_incentive_leave_value, earned_leave_credit_value, vacation_value, emergency_leave_value 
    FROM used_balance 
    WHERE user_id = :user_id
");
$stmt->bindParam(':user_id', $currentUserId, PDO::PARAM_INT);
$stmt->execute();
$usedBalances = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $pdo->prepare("
    SELECT sick_leave_value, service_incentive_leave_value, earned_leave_credit_value, vacation_value, emergency_leave_value 
    FROM total_balance 
    WHERE user_id = :user_id
");
$stmt->bindParam(':user_id', $currentUserId, PDO::PARAM_INT);
$stmt->execute();
$totalBalances = $stmt->fetch(PDO::FETCH_ASSOC);
echo '<script>';
echo 'const usedLeaveBalances = {';
echo '"Sick Leave": ' . ($usedBalances['sick_leave_value'] ?? 0) . ',';
echo '"Service Incentive Leave": ' . ($usedBalances['service_incentive_leave_value'] ?? 0) . ',';
echo '"Earned Leave Credit": ' . ($usedBalances['earned_leave_credit_value'] ?? 0) . ',';
echo '"Vacation": ' . ($usedBalances['vacation_value'] ?? 0) . ',';
echo '"Emergency Leave": ' . ($usedBalances['emergency_leave_value'] ?? 0);
echo '};';
echo 'const maxLeaveBalances = {';
echo '"Sick Leave": ' . ($totalBalances['sick_leave_value'] ?? 0) . ',';
echo '"Service Incentive Leave": ' . ($totalBalances['service_incentive_leave_value'] ?? 0) . ',';
echo '"Earned Leave Credit": ' . ($totalBalances['earned_leave_credit_value'] ?? 0) . ',';
echo '"Vacation": ' . ($totalBalances['vacation_value'] ?? 0) . ',';
echo '"Emergency Leave": ' . ($totalBalances['emergency_leave_value'] ?? 0);
echo '};';
echo '</script>';
//up to here ---------------------------------------------------------------------------------------------------


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
    //     echo json_encode(["success" => true, "message" => "Leave request submitted successfully."]);
    // } catch (PDOException $e) {
    //     $pdo->rollBack();
    //     echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    // } catch (Exception $e) {
    //     $pdo->rollBack();
    //     echo json_encode(["success" => false, "message" => "An unexpected error occurred: " . $e->getMessage()]);
    // }
else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}