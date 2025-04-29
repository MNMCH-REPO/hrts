<?php

try {
    require 'db.php';
    session_start(); // Ensure session is started to access `$_SESSION`

    // Check if the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the user ID and leave balances from the POST data
        $userId = isset($_POST['userId']) ? (int)$_POST['userId'] : 0;
        $sickLeave = isset($_POST['sl']) ? (int)$_POST['sl'] : 0;
        $serviceIncentiveLeave = isset($_POST['sil']) ? (int)$_POST['sil'] : 0;
        $earnedLeaveCredit = isset($_POST['elc']) ? (int)$_POST['elc'] : 0;
        $managementLeave = isset($_POST['mil']) ? (int)$_POST['mil'] : 0;
        $maternityLeave = isset($_POST['ml']) ? (int)$_POST['ml'] : 0;
        $paternityLeave = isset($_POST['pl']) ? (int)$_POST['pl'] : 0;
        $soloParentLeave = isset($_POST['spl']) ? (int)$_POST['spl'] : 0;
        $leaveWithoutPay = isset($_POST['lwop']) ? (int)$_POST['lwop'] : 0;
        $bereavementLeave = isset($_POST['brl']) ? (int)$_POST['brl'] : 0;

        if ($userId > 0) {
            // Update the leave balances for the user
            $updateSql = "
                UPDATE total_balance
                SET 
                    sl = :sl,
                    sil = :sil,
                    elc = :elc,
                    mil = :mil,
                    ml = :ml,
                    pl = :pl,
                    spl = :spl,
                    lwop = :lwop,
                    brl = :brl
                WHERE user_id = :user_id
            ";
            $stmt = $pdo->prepare($updateSql);
            $stmt->bindParam(':sl', $sickLeave, PDO::PARAM_INT);
            $stmt->bindParam(':sil', $serviceIncentiveLeave, PDO::PARAM_INT);
            $stmt->bindParam(':elc', $earnedLeaveCredit, PDO::PARAM_INT);
            $stmt->bindParam(':mil', $managementLeave, PDO::PARAM_INT);
            $stmt->bindParam(':ml', $maternityLeave, PDO::PARAM_INT);
            $stmt->bindParam(':pl', $paternityLeave, PDO::PARAM_INT);
            $stmt->bindParam(':spl', $soloParentLeave, PDO::PARAM_INT);
            $stmt->bindParam(':lwop', $leaveWithoutPay, PDO::PARAM_INT);
            $stmt->bindParam(':brl', $bereavementLeave, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                // Log the action in the `audit_trail` table
                $loggedInUserId = $_SESSION['user_id'] ?? null; // The ID of the logged-in user
                if (!$loggedInUserId) {
                    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
                    exit;
                }

                $actionType = 'UPDATE'; // Action type for updating leave balances
                $affectedTable = 'total_balance'; // The table being updated
                $affectedId = $userId; // The ID of the affected user
                $details = sprintf(
                    "Updated leave balances for user ID %d: SL=%d, SIL=%d, ELC=%d, MIL=%d, ML=%d, PL=%d, SPL=%d, LWOP=%d, BRL=%d",
                    $userId,
                    $sickLeave,
                    $serviceIncentiveLeave,
                    $earnedLeaveCredit,
                    $managementLeave,
                    $maternityLeave,
                    $paternityLeave,
                    $soloParentLeave,
                    $leaveWithoutPay,
                    $bereavementLeave
                );
            

                $auditStmt = $pdo->prepare("
                    INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
                    VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, NOW())
                ");
                $auditStmt->bindParam(':actionType', $actionType);
                $auditStmt->bindParam(':affectedTable', $affectedTable);
                $auditStmt->bindParam(':affectedId', $affectedId, PDO::PARAM_INT);
                $auditStmt->bindParam(':details', $details);
                $auditStmt->bindParam(':userId', $loggedInUserId, PDO::PARAM_INT);

                if ($auditStmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Leave balances updated and audit trail logged successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Leave balances updated, but failed to log audit trail.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update leave balances.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid user ID.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
}