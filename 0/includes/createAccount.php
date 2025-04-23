<?php
require_once 'db.php'; // Include your database connection file

function createUser($employeeID, $employeeName, $email, $role, $department)
{
    global $pdo; // Use the PDO instance from db.php

    try {
        // Static password hash
        $passwordHash = '$2y$10$goVTP4El61v39QXFzClRlOwmsf48VELveViYRJ0uW2wcYZ9IlGOja';

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
    session_start(); // Start the session to access the logged-in user's data

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

        // Get the current logged-in user's ID from the session
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'User not logged in.']);
            exit;
        }
        $currentUserId = $_SESSION['user_id'];

        try {
            $pdo->beginTransaction();

            // Call the function to create the user
            $result = createUser($employeeID, $employeeName, $email, $role, $department);

            if ($result['success']) {
                // Step 2: Insert into the `audit_trail` table
                $actionType = 'CREATE'; // Action type
                $affectedTable = 'users'; // The table being updated
                $affectedId = $employeeID; // The ID of the created user
                $details = "Created user: Name=$employeeName, Email=$email, Role=$role, Department=$department";
                $timestamp = date('Y-m-d H:i:s'); // Current timestamp

                $stmt = $pdo->prepare("
                    INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
                    VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, :timestamp)
                ");
                $stmt->bindParam(':actionType', $actionType);
                $stmt->bindParam(':affectedTable', $affectedTable);
                $stmt->bindParam(':affectedId', $affectedId);
                $stmt->bindParam(':details', $details);
                $stmt->bindParam(':userId', $currentUserId); // Use the logged-in user's ID
                $stmt->bindParam(':timestamp', $timestamp);
                $stmt->execute();

                // Commit the transaction
                $pdo->commit();
            } else {
                // Rollback the transaction if user creation failed
                $pdo->rollBack();
                echo json_encode($result);
                exit;
            }

            // Return the result as JSON
            echo json_encode($result);
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $pdo->rollBack();
            error_log("Database error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        // Return an error if any field is missing
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    }
}