<?php

require_once '../../0/includes/db.php';

if (!isset($_SESSION['user_id'])) {
    session_start();
}
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo "Error: User not logged in.";
    exit();
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and validate form data
    $employeeId = $_POST['employeeId'] ?? null;
    $leaveType = $_POST['leaveType'] ?? null;
    $startDate = $_POST['startDate'] ?? null;
    $endDate = $_POST['endDate'] ?? null;
    $reason = $_POST['reason'] ?? null;


    // Validate required fields
    if (!$employeeId || !$leaveType || !$startDate || !$endDate || !$reason) {
        echo "Error: All fields are required.";
        exit();
    }

    // Validate date format
    $startDateValid = DateTime::createFromFormat('Y-m-d', $startDate) !== false;
    $endDateValid = DateTime::createFromFormat('Y-m-d', $endDate) !== false;

    if (!$startDateValid || !$endDateValid) {
        echo "Error: Invalid date format.";
        exit();
    }

    // Ensure end date is not earlier than start date
    if (strtotime($endDate) < strtotime($startDate)) {
        echo "Error: End date cannot be earlier than start date.";
        exit();
    }

    // Set default values for status and created_at
    $status = 'Pending';







    try {
        // Begin transaction
        $pdo->beginTransaction();

        // Insert data into the leave_requests table
        $stmt = $pdo->prepare("
            INSERT INTO leave_requests (employee_id, leave_types, start_date, end_date, reason, status, created_at)
            VALUES (:employee_id, :leave_types, :start_date, :end_date, :reason, :status, NOW())
        ");
        $stmt->bindParam(':employee_id', $employeeId, PDO::PARAM_INT);
        $stmt->bindParam(':leave_types', $leaveType, PDO::PARAM_STR);
        $stmt->bindParam(':start_date', $startDate, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $endDate, PDO::PARAM_STR);
        $stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);


        $stmt->execute();

        // Get the ID of the inserted leave request
        $leaveRequestId = $pdo->lastInsertId();





        if (isset($_FILES['leaveAttachment'])) {
            // Check for file size limit (2MB) even if there's an upload error
            if ($_FILES['leaveAttachment']['size'] > 2 * 1024 * 1024) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'File size exceeds the 2 MB limit.'
                ]);
                exit();
            }
            if ($_FILES['leaveAttachment']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../../assets/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true); // Create directory if not exists
                }

                $originalFilename = basename($_FILES['leaveAttachment']['name']);
                $safeFilename = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "_", $originalFilename);
                $targetFilePath = $uploadDir . $safeFilename;
                $relativePath = 'assets/uploads/' . $safeFilename;

                // Move the file to the upload folder
                if (!move_uploaded_file($_FILES['leaveAttachment']['tmp_name'], $targetFilePath)) {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file.']);
                    exit();
                }

                // Insert into the leave_attachments table
                $attachmentStmt = $pdo->prepare("
                    INSERT INTO leave_attachments (leave_request_id, uploaded_by, file_path, file_name, uploaded_at)
                    VALUES (:leave_request_id, :uploaded_by, :file_path, :file_name, NOW())
                ");
                $attachmentStmt->bindParam(':leave_request_id', $leaveRequestId, PDO::PARAM_INT);
                $attachmentStmt->bindParam(':uploaded_by', $userId, PDO::PARAM_INT);
                $attachmentStmt->bindParam(':file_path', $relativePath, PDO::PARAM_STR);
                $attachmentStmt->bindParam(':file_name', $originalFilename, PDO::PARAM_STR);
                $attachmentStmt->execute();
            } else {
                // Show specific upload error code
                echo json_encode([
                    'status' => 'error',
                    'message' => 'File upload error. Code: ' . $_FILES['leaveAttachment']['error']
                ]);
                exit();
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No file was uploaded or the input field name is incorrect.'
            ]);
            exit();
        }





        // Insert data into the audit_trail table
        $actionType = 'INSERT';
        $affectedTable = 'leave_requests';
        $affectedId = $leaveRequestId;
        $details = "Inserted leave request for employee ID $employeeId with leave type $leaveType.";
        $userId = $_SESSION['user_id'] ?? null; // The ID of the logged-in user


        $auditStmt = $pdo->prepare("
        INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp)
        VALUES (:action_type, :affected_table, :affected_id, :details, :user_id, NOW())
    ");
        $auditStmt->bindParam(':action_type', $actionType, PDO::PARAM_STR);
        $auditStmt->bindParam(':affected_table', $affectedTable,  PDO::PARAM_STR);
        $auditStmt->bindParam(':affected_id', $affectedId, PDO::PARAM_INT);
        $auditStmt->bindParam(':details', $details, PDO::PARAM_STR);
        $auditStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        $auditStmt->execute();


        // Insert data into the audit_trail table
        $actionType = 'INSERT';
        $affectedTable = 'leave_attachments';
        $affectedId = $leaveRequestId;
        $details = "Inserted leave attachment approval for employee ID $employeeId with leave type $leaveType.";
        $userId = $_SESSION['user_id'] ?? null; // The ID of the logged-in user


        $auditStmt = $pdo->prepare("
                INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp)
                VALUES (:action_type, :affected_table, :affected_id, :details, :user_id, NOW())
            ");
        $auditStmt->bindParam(':action_type', $actionType, PDO::PARAM_STR);
        $auditStmt->bindParam(':affected_table', $affectedTable,  PDO::PARAM_STR);
        $auditStmt->bindParam(':affected_id', $affectedId, PDO::PARAM_INT);
        $auditStmt->bindParam(':details', $details, PDO::PARAM_STR);
        $auditStmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        $auditStmt->execute();

        // Commit transaction
        $pdo->commit();

        // **REMOVE THE REDIRECT** (no header location)
        // Instead, echo a success message
        echo json_encode(['status' => 'success', 'message' => 'Leave request submitted successfully.']);
        exit();
    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollBack();

        // Log the error for debugging
        error_log("Database Error: " . $e->getMessage());
        // **REMOVE THE REDIRECT** (no header location)
        // Instead, echo an error message
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
        exit();
    }
}
