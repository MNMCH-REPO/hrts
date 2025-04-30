<?php

try {
    require 'db.php';

    // Assuming the userId is passed through the query string or POST method
    $userId = isset($_GET['userId']) ? (int)$_GET['userId'] : 0;

    if ($userId > 0) {
        // Fetch the leave balances for the user
        $leaveBalancesSql = "
            SELECT 
                users.name, 
                users.department, 
                total_balance.sl AS sick_leave, 
                total_balance.sil AS service_incentive_leave, 
                total_balance.elc AS earned_leave_credit, 
                total_balance.mil AS management_initiated_leaave, 
                total_balance.ml AS maternity_leave, 
                total_balance.pl AS paternity_leave, 
                total_balance.spl AS solo_parent_leave, 
                total_balance.lwop AS leave_without_pay,
                total_balance.brl AS bereavement_leave,
                total_balance.awol AS absent_without_leave
            FROM total_balance 
            LEFT JOIN users ON users.id = total_balance.user_id 
            WHERE total_balance.user_id = :user_id
        ";
        $stmt = $pdo->prepare($leaveBalancesSql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $leaveBalances = $stmt->fetch(PDO::FETCH_ASSOC); // Assuming one row per user

        if ($leaveBalances) {
            // Respond with both user details and leave balances
            echo json_encode([
                'success' => true,
                'leaveBalances' => [
                    'name' => $leaveBalances['name'],
                    'department' => $leaveBalances['department'],
                    'sl' => $leaveBalances['sick_leave'],
                    'sil' => $leaveBalances['service_incentive_leave'],
                    'elc' => $leaveBalances['earned_leave_credit'],
                    'mil' => $leaveBalances['management_initiated_leaave'],
                    'ml' => $leaveBalances['maternity_leave'],
                    'pl' => $leaveBalances['paternity_leave'],
                    'spl' => $leaveBalances['solo_parent_leave'],
                    'lwop' => $leaveBalances['leave_without_pay'],
                    'brl' => $leaveBalances['bereavement_leave'],
                    'awol' => $leaveBalances['absent_without_leave']

                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'User or leave balance not found.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
}