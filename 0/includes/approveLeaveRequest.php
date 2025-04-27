<?php
session_start(); // Start the session
require_once '../../0/includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON payload
    $data = json_decode(file_get_contents('php://input'), true);

    $leaveId = $data['leaveId'];
    $approvedBy = $_SESSION['user_id'];

    // Extract leave type and dates from the request
    $leaveType = $data['leaveType']; // e.g., 'Sick Leave', 'Vacation'
    $startDate = $data['startDate']; // start date (e.g., '2025-04-27')
    $endDate = $data['endDate'];     // end date (e.g., '2025-04-29')

    // Validate input
    if (!$leaveId || !$approvedBy || !$leaveType || !$startDate || !$endDate) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit();
    }

    // Function to calculate the number of days between start and end date
    function calculateDaysBetween($start, $end) {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);
        $diff = $startDate->diff($endDate);
        return $diff->days + 1; // +1 to include both the start and end dates
    }

    // Calculate the requested leave days
    $requestedDays = calculateDaysBetween($startDate, $endDate);

    // Convert leave type to the column name in the database (e.g., "Sick Leave" => "sick_leave_value")
    $leaveColumn = strtolower(str_replace(" ", "_", $leaveType));

    try {
        // Step 1: Approve the leave request (update leave_requests table)
        $stmtLeave = $pdo->prepare("
            UPDATE leave_requests
            SET status = 'Approved', approved_by = :approvedBy, updated_at = NOW()
            WHERE id = :leaveId
        ");
        $stmtLeave->bindParam(':approvedBy', $approvedBy, PDO::PARAM_INT);
        $stmtLeave->bindParam(':leaveId', $leaveId, PDO::PARAM_INT);
        $stmtLeave->execute();

        if ($stmtLeave->rowCount() === 0) {
            echo json_encode(['success' => false, 'message' => 'Leave request not found or already approved.']);
            exit();
        }

        // Step 2: Update the total_balance table (subtract the requested days from the appropriate leave type)
        $stmtTotalUpdate = $pdo->prepare("
            UPDATE total_balance
            SET {$leaveColumn}_value = {$leaveColumn}_value - :requestedDays
            WHERE user_id = :user_id
        ");
        $stmtTotalUpdate->bindParam(':requestedDays', $requestedDays, PDO::PARAM_INT);
        $stmtTotalUpdate->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmtTotalUpdate->execute();

        // Step 3: Insert the calculated leave days into the used_balance table
        $stmtUsedInsert = $pdo->prepare("
            INSERT INTO used_balance (user_id, {$leaveColumn}_value)
            VALUES (:user_id, :requestedDays)
        ");
        $stmtUsedInsert->bindParam(':requestedDays', $requestedDays, PDO::PARAM_INT);
        $stmtUsedInsert->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmtUsedInsert->execute();

        // If all queries are successful
        echo json_encode(['success' => true, 'message' => 'Leave request approved and balances updated successfully.']);

    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
