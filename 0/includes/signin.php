<?php
require_once 'db.php';
require_once 'session.php';

$emailError = '';
$passwordError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user['password'])) {
            // Start session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['department'] = $user['department'];

            // Audit Trail
            try {
                $actionType = 'LOGIN';
                $affectedTable = 'users';
                $affectedId = $user['id'];
                $details = "User ID {$user['id']} logged in successfully.";
                $timestamp = date('Y-m-d H:i:s');

                $auditStmt = $pdo->prepare("
                    INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
                    VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, :timestamp)
                ");
                $auditStmt->execute([
                    ':actionType' => $actionType,
                    ':affectedTable' => $affectedTable,
                    ':affectedId' => $affectedId,
                    ':details' => $details,
                    ':userId' => $affectedId,
                    ':timestamp' => $timestamp,
                ]);
            } catch (PDOException $e) {
                error_log("Audit trail error: " . $e->getMessage());
            }

            // Redirect
            if ($user['role'] === 'Employee') {
                header('Location: ../1/employee/ticket.php');
            } elseif ($user['role'] === 'HR') {
                header('Location: ../../1/hrRep/order.php');
            } elseif ($user['role'] === 'Admin') {
                header('Location: ../../1/hrAdmin/dashboard.php');
            } else {
                header('Location: ../index.php');
            }
            exit;
        } else {
            $passwordError = "Incorrect password";
        }
    } else {
        $emailError = "Incorrect email";
    }
}
