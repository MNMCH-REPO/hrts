<?php
require_once '../../0/includes/db.php'; // Include your database connection file

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

    try {
        // Prepare the SQL query to update the user
        $stmt = $pdo->prepare("UPDATE users 
                               SET employee_id = :employeeID, 
                                   name = :employeeName, 
                                   email = :email, 
                                   role = :role, 
                                   department = :department 
                               WHERE id = :id");

        // Bind parameters
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':employeeID', $employeeID, PDO::PARAM_STR);
        $stmt->bindParam(':employeeName', $employeeName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':department', $department, PDO::PARAM_STR);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Account updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update account.']);
        }
    } catch (PDOException $e) {
        // Log the error for debugging
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>