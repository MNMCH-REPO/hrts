<?php

require '../../0/includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resetValueButton'])) {
    try {
        // Update query to reset the values for all users
        $resetQuery = "
            UPDATE used_balance
            SET sick_leave_value = 0,
                service_incentive_leave_value = 0,
                earned_leave_credit_value = 0,
                vacation_value = 0,
                emergency_leave_value = 0
        ";

        $stmt = $pdo->prepare($resetQuery);
        $stmt->execute();

       
        echo '<script>alert("Leave Requests Values Reset Successfully");</script>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
