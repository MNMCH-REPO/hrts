<?php
require_once 'db.php';
session_start();

header('Content-Type: application/json'); // Ensure JSON response

try {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    // Check if the reset button was clicked
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resetValueButton'])) {
        $userId = $_SESSION['user_id'];

        // Reset leave balances for all users
        $pdo->beginTransaction();

        $resetQuery = "UPDATE used_balance SET sl = 0, sil = 0, elc = 0, mil = 0, ml = 0, pl = 0, spl = 0, brl = 0";
        $stmt1 = $pdo->prepare($resetQuery);
        if (!$stmt1->execute()) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to reset leave balances (used_balance).']);
            exit;
        }

        $resetTotalEclQuery = "UPDATE total_balance SET elc = 0";
        $stmt2 = $pdo->prepare($resetTotalEclQuery);
        if (!$stmt2->execute()) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to reset leave balances (total_balance).']);
            exit;
        }

        // Log the action in the `audit_trail` table
        $actionType = 'RESET';
        $affectedTable = 'used_balance';
        $details = 'Reset all leave balances to 0';

        $auditStmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, details, user_id, timestamp)
            VALUES (:actionType, :affectedTable, :details, :userId, NOW())
        ");
        $auditStmt->bindParam(':actionType', $actionType);
        $auditStmt->bindParam(':affectedTable', $affectedTable);
        $auditStmt->bindParam(':details', $details);
        $auditStmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        if (!$auditStmt->execute()) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to log audit trail.']);
            exit;
        }


        // Log the action in the `audit_trail` table
        $actionType = 'RESET';
        $affectedTable = 'total_balance';
        $details = 'Reset all leave balances to 0';

        $auditStmt = $pdo->prepare("
    INSERT INTO audit_trail (action_type, affected_table, details, user_id, timestamp)
    VALUES (:actionType, :affectedTable, :details, :userId, NOW())
");
        $auditStmt->bindParam(':actionType', $actionType);
        $auditStmt->bindParam(':affectedTable', $affectedTable);
        $auditStmt->bindParam(':details', $details);
        $auditStmt->bindParam(':userId', $userId, PDO::PARAM_INT);

        if (!$auditStmt->execute()) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to log audit trail.']);
            exit;
        }



        $pdo->commit();
        echo json_encode(['success' => true, 'message' => 'Leave balances reset successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Unexpected error: ' . $e->getMessage()]);
}
