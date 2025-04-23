<?php
require 'session.php';
require "db.php"; // Ensure correct database connection

header("Content-Type: application/json");

// Get the current logged-in user's ID from the session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}
$currentUserId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $employeeId = $_POST['employeeId'] ?? null;
        $employeeName = trim($_POST['employeeName'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $description = trim($_POST['description'] ?? '');

        // Validate required fields
        if (!$employeeId || empty($employeeName) || empty($subject) || empty($department) || empty($category) || empty($description)) {
            echo json_encode(["success" => false, "message" => "All fields are required."]);
            exit();
        }

        // Establish a PDO connection
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        // Check if employee ID exists and validate both name and department
        $stmt = $pdo->prepare("SELECT name, department FROM users WHERE id = :employee_id");
        $stmt->execute([':employee_id' => $employeeId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo json_encode(["success" => false, "message" => "Invalid Employee ID."]);
            exit();
        }

        if ($user['name'] !== $employeeName) {
            echo json_encode(["success" => false, "message" => "Employee Name does not match our records."]);
            exit();
        }

        if ($user['department'] !== $department) {
            echo json_encode(["success" => false, "message" => "Selected department does not match your registered department."]);
            exit();
        }

        // Begin a transaction
        $pdo->beginTransaction();

        // Insert the ticket into the `tickets` table
        $stmt = $pdo->prepare("
            INSERT INTO tickets (employee_id, subject, category_id, description, created_at) 
            VALUES (:employee_id, :subject, :category_id, :description, NOW())
        ");
        $stmt->execute([
            ':employee_id' => $employeeId,
            ':subject' => $subject,
            ':category_id' => $category, // Category ID from the dropdown
            ':description' => $description
        ]);

        // Get the ID of the newly created ticket
        $ticketId = $pdo->lastInsertId();

        // Prepare audit trail details
        $actionType = "CREATE";
        $affectedTable = 'tickets';
        $affectedId = $ticketId; // The ID of the created ticket
        $details = "Created ticket: Subject=$subject, Category=$category, Description=$description";
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp

        // Insert into the `audit_trail` table
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

        echo json_encode(["success" => true, "message" => "Ticket submitted successfully."]);
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}