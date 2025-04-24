<?php
session_start();
require_once '../0/includes/db.php'; // Ensure this returns $pdo for PDO

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employeeId'];
    $employee_name = $_POST['employeeName'];
    $department = $_POST['department'];
    $leave_type = $_POST['leaveType'];
    $start_date = $_POST['startDate'];
    $end_date = $_POST['endDate'];
    $reason = $_POST['reason'];

    try {
        $query = "INSERT INTO leave_requests (employee_id, employee_name, department, leave_type, start_date, end_date, reason)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            $employee_id,
            $employee_name,
            $department,
            $leave_type,
            $start_date,
            $end_date,
            $reason
        ]);

        echo "Leave request submitted successfully.";
        // Optional: Redirect if needed
        // header("Location: success-page.php");
        // exit;

    } catch (PDOException $e) {
        echo "Error submitting leave request: " . $e->getMessage();
    }
}
?>
