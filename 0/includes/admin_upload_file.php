<?php
header("Content-Type: application/json");

function uploadFile($pdo, $type, $id, $user_id, $file)
{
    $file_path = null;
    $file_name = null;
    try {
        // Check file size (2 MB = 2 * 1024 * 1024 bytes)
        if ($file['size'] > 2 * 1024 * 1024) {
            throw new Exception("File size exceeds the 2 MB limit.");
        }

        // Check if the file is a video (based on MIME type)
        $allowedVideoMimeTypes = ['video/mp4', 'video/avi', 'video/mpeg', 'video/quicktime'];
        if (in_array($file['type'], $allowedVideoMimeTypes)) {
            throw new Exception("Video files are not allowed.");
        }
        // Validate the type and ID
        if ($type === 'ticket') {
            $stmt = $pdo->prepare("
                SELECT tr.id 
                FROM ticket_responses tr
                INNER JOIN tickets t ON tr.ticket_id = t.id
                WHERE t.id = :id
            ");
        } elseif ($type === 'leave') {
            $stmt = $pdo->prepare("
                SELECT lr.id 
                FROM leave_responses lr
                INNER JOIN leave_requests l ON lr.leave_id = l.id
                WHERE l.id = :id
            ");
        } else {
            throw new Exception("Invalid type provided. Must be 'ticket' or 'leave'.");
        }

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            throw new Exception("Invalid ID: No matching record found for the provided type and ID.");
        }

        // Check if a file is provided and valid
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("No valid file uploaded.");
        }

        $uploadDir = '../../assets/uploads/';
        $fileName = basename($file['name']); // Add timestamp to avoid conflicts
        $targetFilePath = $uploadDir . $fileName;

        // Ensure the upload directory exists and is writable
        if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
            throw new Exception("Upload directory does not exist or is not writable.");
        }

        // Move the uploaded file to the uploads directory
        if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            throw new Exception("Failed to save the uploaded file.");
        }

        $file_path = 'assets/uploads/' . $fileName; // Save relative path to the database

        // Insert the file into the appropriate table
        if ($type === 'ticket') {
            $stmt = $pdo->prepare("
                INSERT INTO attachments (ticket_id, uploaded_by, file_path, file_name, uploaded_at) 
                VALUES (:id, :uploaded_by, :file_path, :file_name, NOW())
            ");
        } elseif ($type === 'leave') {
            $stmt = $pdo->prepare("
                INSERT INTO leave_attachments (leave_request_id, uploaded_by, file_path, file_name, uploaded_at) 
                VALUES (:id, :uploaded_by, :file_path, :file_name, NOW())
            ");
        }

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':uploaded_by', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':file_path', $file_path, PDO::PARAM_STR);
        $stmt->bindParam(':file_name', $fileName, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert attachment into database: " . implode(", ", $stmt->errorInfo()));
        }

        // Log the attachment in the audit trail
        $attachmentId = $pdo->lastInsertId();
        $actionType = 'INSERT';
        $affectedTable = $type === 'ticket' ? 'attachments' : 'leave_attachments';
        $details = "Added attachment to $type ID $id: $file_path";

        $stmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
            VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, NOW())
        ");
        $stmt->bindParam(':actionType', $actionType);
        $stmt->bindParam(':affectedTable', $affectedTable);
        $stmt->bindParam(':affectedId', $attachmentId, PDO::PARAM_INT);
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':userId', $user_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert audit trail for attachment: " . implode(", ", $stmt->errorInfo()));
        }

        // Return success response
        return [
            'success' => true,
            'message' => 'File uploaded successfully.',
            'file_path' => $file_path,
            'file_name' => $file_name
        ];
    } catch (Exception $e) {
        // Log the error and return failure response
        error_log("Error in uploadFile: " . $e->getMessage());
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}

// Main script logic
try {
    session_start();
    require 'db.php';

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    if (!isset($_POST['type']) || !isset($_POST['id'])) {
        echo json_encode(['success' => false, 'message' => 'Type and ID are required.']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $type = $_POST['type']; // 'ticket' or 'leave'
    $id = intval($_POST['id']);

    if (!isset($_FILES['file'])) {
        echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
        exit;
    }

    // Call the uploadFile function
    $response = uploadFile($pdo, $type, $id, $user_id, $_FILES['file']);
    echo json_encode($response);
} catch (Exception $e) {
    error_log("Error in admin_upload_file.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An unexpected error occurred.']);
}
