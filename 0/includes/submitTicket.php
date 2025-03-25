<?php
session_start();
require "../../0/includes/db.php"; // Ensure correct database connection

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $employeeId = $_POST['employeeId'] ?? null;
        $employeeName = trim($_POST['employeeName'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $department = trim($_POST['department'] ?? '');
        $category = trim($_POST['category'] ?? '');
        $description = trim($_POST['description'] ?? '');

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

        // Insert the ticket if all validations pass
        // $stmt = $pdo->prepare("INSERT INTO tickets (employee_id, subject, department, category, description, created_at) 
        //                        VALUES (:employee_id, :subject, :department, :category, :description, NOW())");

        // $stmt->execute([
        //     ':employee_id' => $employeeId,
        //     ':subject' => $subject,
        //     ':department' => $department,
        //     ':category' => $category,
        //     ':description' => $description
        // ]);

        $categoryId = $_POST['category'] ?? null;
        $stmt = $pdo->prepare("INSERT INTO tickets (employee_id, subject, category_id, description, created_at) 
        VALUES (:employee_id, :subject, :category_id, :description, NOW())");

        $stmt->execute([
            ':employee_id' => $employeeId,
            ':subject' => $subject,
           
            ':category_id' => $categoryId,  // Category ID from the dropdown
            ':description' => $description
        ]);




        echo json_encode(["success" => true, "message" => "Ticket submitted successfully."]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
