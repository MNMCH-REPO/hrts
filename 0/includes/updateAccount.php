<?php
require_once 'db.php'; // Include your database connection file

header('Content-Type: application/json'); // Ensure the response is JSON

session_start(); // Start the session to access the logged-in user's data

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['idhidden']; // Hidden field for the original ID
    $employeeID = $_POST['employeeID']; // New ID
    $employeeName = $_POST['employeeName'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $department = $_POST['department'];

    // Get the current logged-in user's ID from the session
    $currentUserId = $_SESSION['user_id']; // Replace 'user_id' with the correct session key for your system

    try {
        $pdo->beginTransaction();

        // Step 1: Update the `users` table
        $stmt = $pdo->prepare("
            UPDATE users 
            SET id = :newEmployeeID, 
                name = :employeeName, 
                email = :email, 
                role = :role, 
                department = :department 
            WHERE id = :oldEmployeeID
        ");
        $stmt->bindParam(':newEmployeeID', $employeeID);
        $stmt->bindParam(':oldEmployeeID', $id);
        $stmt->bindParam(':employeeName', $employeeName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':department', $department);
        $stmt->execute();

        // Step 2: Insert into the `audit_trail` table
        $actionType = 'UPDATE'; // Action type
        $affectedTable = 'users'; // The table being updated
        $affectedId = $employeeID; // The new ID of the updated user
        $details = "Updated user details: Name=$employeeName, Email=$email, Role=$role, Department=$department";
    

        $stmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
            VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, NOW())
        ");
        $stmt->bindParam(':actionType', $actionType);
        $stmt->bindParam(':affectedTable', $affectedTable);
        $stmt->bindParam(':affectedId', $affectedId);
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':userId', $currentUserId); // Use the logged-in user's ID

        $stmt->execute();

        // Commit the transaction
        $pdo->commit();

        echo json_encode(['success' => true, 'message' => 'Account and related records updated successfully.']);
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}