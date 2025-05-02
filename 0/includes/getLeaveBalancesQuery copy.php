<?php

try {
    require 'db.php';

    $userId = isset($_GET['userId']) ? (int)$_GET['userId'] : 0;

    if ($userId > 0) {
        $sql = "
            SELECT 
                u.id AS users_id,
                u.name, 
                u.department, 
                tb.sl AS sick_leave, 
                tb.sil AS service_incentive_leave, 
                tb.elc AS earned_leave_credit, 
                tb.mil AS management_initiated_leave, 
                tb.ml AS maternity_leave, 
                tb.pl AS paternity_leave, 
                tb.spl AS solo_parent_leave, 
                tb.lwop AS leave_without_pay,
                tb.brl AS bereavement_leave,
                tb.awol AS absent_without_leave,
                ub.id AS used_balance_id,
                ub.user_id AS user_balance_id,
                SUM(ub.awol) AS total_awol
            FROM total_balance tb
            LEFT JOIN users u ON u.id = tb.user_id
            LEFT JOIN used_balance ub ON ub.user_id = tb.user_id
            WHERE tb.user_id = :user_id
            GROUP BY tb.user_id
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $leaveBalances = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($leaveBalances) {
            echo json_encode([
                'success' => true,
                'leaveBalances' => [
                    'name' => $leaveBalances['name'],
                    'department' => $leaveBalances['department'],
                    'sl' => $leaveBalances['sick_leave'],
                    'sil' => $leaveBalances['service_incentive_leave'],
                    'elc' => $leaveBalances['earned_leave_credit'],
                    'mil' => $leaveBalances['management_initiated_leave'],
                    'ml' => $leaveBalances['maternity_leave'],
                    'pl' => $leaveBalances['paternity_leave'],
                    'spl' => $leaveBalances['solo_parent_leave'],
                    'lwop' => $leaveBalances['leave_without_pay'],
                    'brl' => $leaveBalances['bereavement_leave'],
                    'awol' => $leaveBalances['absent_without_leave'],
                    'totalAWOL' => $leaveBalances['total_awol'] ?? 0,
                    'userId' => $leaveBalances['users_id'],
                    'user_id' => $leaveBalances['user_balance_id'],
                    'usedBalanceId' => $leaveBalances['used_balance_id'],

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
