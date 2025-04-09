<?php
require_once 'db.php';
require_once 'session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = 'SELECT * FROM users WHERE email = :email';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Start the session and store user details
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role']; // Store user role in session
        $_SESSION['name'] = $user['name']; // Store user name in session
        $_SESSION['email'] = $user['email']; // Store user email in session
        $_SESSION['department'] = $user['department']; // Store user department in session

        try {
            // Log the sign-in action in the `audit_trail` table
            $actionType = 'LOGIN'; // Action type
            $affectedTable = 'users'; // The table being affected
            $affectedId = $user['id']; // The ID of the logged-in user
            $details = "User ID {$user['id']} logged in successfully.";
            $timestamp = date('Y-m-d H:i:s'); // Current timestamp

            $auditStmt = $pdo->prepare("
                INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
                VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, :timestamp)
            ");
            $auditStmt->bindParam(':actionType', $actionType);
            $auditStmt->bindParam(':affectedTable', $affectedTable);
            $auditStmt->bindParam(':affectedId', $affectedId, PDO::PARAM_INT);
            $auditStmt->bindParam(':details', $details);
            $auditStmt->bindParam(':userId', $affectedId, PDO::PARAM_INT); // Use the logged-in user's ID
            $auditStmt->bindParam(':timestamp', $timestamp);
            $auditStmt->execute();
        } catch (PDOException $e) {
            // Log the error for debugging
            error_log("Audit trail error: " . $e->getMessage());
        }

        // Redirect based on role
        if ($user['role'] === 'Employee') {
            header('Location: ../1/employee/ticket.php');
        } elseif ($user['role'] === 'HR') {
            header('Location: ../../1/hrRep/order.php');
        } elseif ($user['role'] === 'Admin') {
            header('Location: ../../1/hrAdmin/dashboard.php');
        } else {
            header('Location: ../index.php'); // Default fallback
        }
        exit;
    } else {
        echo '
        <script>
            errorMessage = "Incorrect Username or Password";
        </script>
        ';
    }
}