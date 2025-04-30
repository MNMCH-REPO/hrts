<?php
require 'db.php'; // Ensure you have a database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usedBalanceId'])) {
    try {
        // Start a transaction
        $pdo->beginTransaction();

        // Insert into leave_requests table
        $insertLeaveRequestQuery = "
            INSERT INTO leave_requests (
                employee_id, 
                leave_types, 
                start_date, 
                end_date, 
                reason, 
                status, 
                created_at, 
                approved_by, 
                updated_at
            ) VALUES (
                :employee_id, 
                :leave_types, 
                NOW(), 
                NOW(), 
                :reason, 
                'Approved', 
                NOW(), 
                :approved_by, 
                NOW()
            )
        ";
        $stmt = $pdo->prepare($insertLeaveRequestQuery);
        $stmt->execute([
            ':employee_id' => $_SESSION['user_id'], // Assuming the current user's ID is stored in the session
            ':leave_types' => 'AWOL', // Leave type is AWOL
            ':reason' => 'Marked as AWOL', // Default reason
            ':approved_by' => $_SESSION['user_id'], // Assuming the current user is the approver
        ]);

        // Update the awol column in the used_balance table
        $updateAWOLQuery = "
            UPDATE used_balance 
            SET awol = awol + 1 
            WHERE id = :used_balance_id
        ";
        $stmt = $pdo->prepare($updateAWOLQuery);
        $stmt->execute([
            ':used_balance_id' => $_POST['usedBalanceId'], // The used balance ID from the modal
        ]);

        // Commit the transaction
        $pdo->commit();

        echo "<script>alert('AWOL marked successfully and leave request created.');</script>";
    } catch (PDOException $e) {
        // Rollback the transaction in case of an error
        $pdo->rollBack();
        die("Database error: " . $e->getMessage());
    }
}
