<?php
require_once 'db.php';
require_once 'session.php';

$emailError = '';
$passwordError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = 'SELECT * FROM users  WHERE email = :email';
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


                $auditStmt = $pdo->prepare("
                    INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
                    VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, NOW())
                ");
                $auditStmt->execute([
                    ':actionType' => $actionType,
                    ':affectedTable' => $affectedTable,
                    ':affectedId' => $affectedId,
                    ':details' => $details,
                    ':userId' => $affectedId,

                ]);
            } catch (PDOException $e) {
                error_log("Audit trail error: " . $e->getMessage());
            }

            // Redirect
            if ($user['status'] === 'Inactive') {
                $emailError = "Your account is inactive. Please contact the administrator.";
                header('Location: ../index.php?error=' . urlencode($emailError));
                echo "<script>
                console.log('Your account is inactive. Please contact the administrator.');
                alert('Your account is inactive. Please contact the administrator.');
                </script>";
                exit;
            }

            if ($user['role'] === 'Employee') {
                header('Location: 1/employee/ticket.php');
            } elseif ($user['role'] === 'HR') {
                header('Location: 1/hrRep/order.php');
            } elseif ($user['role'] === 'HR HEAD') { // Corrected duplicate 'HR' role
                header('Location: 1/hrHead/order.php');
            } elseif ($user['role'] === 'Admin') {
                header('Location: 1/hrAdmin/dashboard.php');
            } elseif ($user['role'] === 'Super Admin') {
                header('Location: 1/superAdmin/dashboard.php');
            }
            else {
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
