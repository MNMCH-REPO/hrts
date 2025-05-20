<?php
require_once 'db.php'; // Include your database connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User is not logged in.']);
        exit;
    }

    $userId = $_SESSION['user_id'];
    $oldPassword = $_POST['oldPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Validate input fields
    if (empty($newPassword) || empty($confirmPassword)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Validate new password and confirmation
    if ($newPassword !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'New passwords do not match.']);
        exit;
    }

    // Check if the password is at least 8 characters long and alphanumeric
    if (strlen($newPassword) < 8 || !preg_match('/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]+$/', $newPassword)) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 8 characters long, alphanumeric, and may include special characters.']);
        exit;
    }

    try {
        // Fetch the current password hash from the database
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($oldPassword, $user['password'])) {
            // Hash the new password
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
            $updateStmt->bindParam(':password', $newPasswordHash, PDO::PARAM_STR);
            $updateStmt->bindParam(':id', $userId, PDO::PARAM_INT);

            if ($updateStmt->execute()) {
                // Log the password change action in the `audit_trail` table
                $actionType = 'PASSWORD_CHANGE'; // Action type
                $affectedTable = 'users'; // The table being affected
                $affectedId = $userId; // The ID of the user whose password was changed
                $details = "User ID $userId changed their password.";


                $auditStmt = $pdo->prepare("
                    INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
                    VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, NOW())
                ");
                $auditStmt->bindParam(':actionType', $actionType);
                $auditStmt->bindParam(':affectedTable', $affectedTable);
                $auditStmt->bindParam(':affectedId', $affectedId, PDO::PARAM_INT);
                $auditStmt->bindParam(':details', $details);
                $auditStmt->bindParam(':userId', $userId, PDO::PARAM_INT);

                $auditStmt->execute();

                echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update password.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Old password is incorrect.']);
        }
    } catch (PDOException $e) {
        // Log the error for debugging (do not expose sensitive details to the user)
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An unexpected error occurred. Please try again later.']);
    }
}
