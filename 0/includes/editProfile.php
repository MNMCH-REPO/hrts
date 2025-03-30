<?php
require_once '../../0/includes/db.php'; // Include your database connection file

function editUser($id, $employeeName, $email, $role, $department) {
    global $pdo; // Use the PDO instance from db.php

    try {
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
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Account updated successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to update account.'];
        }
    } catch (PDOException $e) {
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
?>