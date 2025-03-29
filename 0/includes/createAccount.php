<?php
require_once '../../0/includes/db.php'; // Include your database connection file

function createUser($employeeID, $employeeName, $email, $role, $department) {
    global $pdo; // Use the PDO instance from db.php

    try {
        // Static password hash
        $passwordHash = '$2y$10$eOEwFtX3DdSczFsOIZCIoOZuPUtse8agtfwKxeKoWrj1XgyAkuhQW';

        // Prepare the SQL query
        $sql = "INSERT INTO users (id, name, email, password, role, department, created_at) 
                VALUES (:employeeID, :employeeName, :email, :password, :role, :department, NOW())";

        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':employeeID', $employeeID, PDO::PARAM_STR);
        $stmt->bindParam(':employeeName', $employeeName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR); // Bind the password hash
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':department', $department, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'User created successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to create user.'];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

// Handle the AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are set
    if (
        isset($_POST['employeeID']) && isset($_POST['employeeName']) &&
        isset($_POST['email']) && isset($_POST['role']) && isset($_POST['department'])
    ) {
        $employeeID = $_POST['employeeID'];
        $employeeName = $_POST['employeeName'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $department = $_POST['department'];

        // Call the function to create the user
        $result = createUser($employeeID, $employeeName, $email, $role, $department);

        // Return the result as JSON
        echo json_encode($result);
    } else {
        // Return an error if any field is missing
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
}
?>