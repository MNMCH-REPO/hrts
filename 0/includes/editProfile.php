<?php
require_once '../../0/includes/db.php'; // Include your database connection file
session_start(); // Start the session to access user data
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}
function editUser($id, $employeeName, $email, $role, $department) {
    global $pdo; // Use the PDO instance from db.php

    try {
        // Begin a transaction
        $pdo->beginTransaction();

        // Prepare the SQL query to update the user
        $sql = "UPDATE users 
                SET name = :employeeName, email = :email, role = :role, department = :department 
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':employeeName', $employeeName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':department', $department, PDO::PARAM_STR);

        // Execute the query
        if (!$stmt->execute()) {
            $pdo->rollBack();
            return ['success' => false, 'message' => 'Failed to update account.'];
        }

        // Log the action in the `audit_trail` table
        $actionType = 'UPDATE'; // Action type
        $affectedTable = 'users'; // The table being updated
        $affectedId = $id; // The ID of the updated user
        $details = "Updated user details: Name=$employeeName, Email=$email, Role=$role, Department=$department";
        $userId = $_SESSION['user_id'] ?? null; // The ID of the logged-in user performing the action
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp

        if (!$userId) {
            $pdo->rollBack();
            return ['success' => false, 'message' => 'User not logged in.'];
        }

        $auditStmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
            VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, :timestamp)
        ");
        $auditStmt->bindParam(':actionType', $actionType);
        $auditStmt->bindParam(':affectedTable', $affectedTable);
        $auditStmt->bindParam(':affectedId', $affectedId, PDO::PARAM_INT);
        $auditStmt->bindParam(':details', $details);
        $auditStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $auditStmt->bindParam(':timestamp', $timestamp);

        if (!$auditStmt->execute()) {
            $pdo->rollBack();
            return ['success' => false, 'message' => 'Failed to log audit trail.'];
        }

        // Commit the transaction
        $pdo->commit();

        return ['success' => true, 'message' => 'Account updated successfully.'];
    } catch (PDOException $e) {
        $pdo->rollBack();
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

// Handle the AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are set
    if (
        isset($_POST['id']) && isset($_POST['employeeName']) &&
        isset($_POST['email']) && isset($_POST['role']) && isset($_POST['department'])
    ) {
        $id = $_POST['id'];
        $employeeName = $_POST['employeeName'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $department = $_POST['department'];

        // Call the function to edit the user
        $result = editUser($id, $employeeName, $email, $role, $department);

        // Return the result as JSON
        echo json_encode($result);
    } else {
        // Return an error if any field is missing
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
}
