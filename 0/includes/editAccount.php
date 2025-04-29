<?php
session_start();
require_once 'db.php'; // Include your database connection file

header("Content-Type: application/json");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the current logged-in user's ID from the session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}
$currentUserId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the POST request
    $id = $_POST['idhidden'] ?? null;
    $employeeID = $_POST['employeeID'] ?? null;
    $employeeName = $_POST['employeeName'] ?? null;
    $email = $_POST['email'] ?? null;
    $role = $_POST['role'] ?? null;
    $department = $_POST['department'] ?? null;

    // Validate input fields
    if (empty($id) || empty($employeeID) || empty($employeeName) || empty($email) || empty($role) || empty($department)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit;
    }

    try {
        // Begin a transaction
        $pdo->beginTransaction();

        // Step 1: Update the `users` table
        $updateStmt = $pdo->prepare("
            UPDATE users 
            SET employee_id = :employeeID, 
                name = :employeeName, 
                email = :email, 
                role = :role, 
                department = :department 
            WHERE id = :id
        ");
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->bindParam(':employeeID', $employeeID, PDO::PARAM_STR);
        $updateStmt->bindParam(':employeeName', $employeeName, PDO::PARAM_STR);
        $updateStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $updateStmt->bindParam(':role', $role, PDO::PARAM_STR);
        $updateStmt->bindParam(':department', $department, PDO::PARAM_STR);

        if (!$updateStmt->execute()) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to update account.']);
            exit;
        }

        // Step 2: Insert into the `audit_trail` table
        $actionType = 'UPDATE'; // Action type
        $affectedTable = 'users'; // The table being updated
        $affectedId = $employeeID; // The new ID of the updated user
        $details = "Updated user details: Name=$employeeName, Email=$email, Role=$role, Department=$department";

        $auditStmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
            VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, NOW())
        ");
        $auditStmt->bindParam(':actionType', $actionType);
        $auditStmt->bindParam(':affectedTable', $affectedTable);
        $auditStmt->bindParam(':affectedId', $affectedId);
        $auditStmt->bindParam(':details', $details);
        $auditStmt->bindParam(':userId', $currentUserId); // Use the logged-in user's ID


        if (!$auditStmt->execute()) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Failed to log audit trail.']);
            exit;
        }

        // Commit the transaction
        $pdo->commit();

        echo json_encode(['success' => true, 'message' => 'Account updated successfully.']);
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}