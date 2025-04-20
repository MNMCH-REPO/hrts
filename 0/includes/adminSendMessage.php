<?php
session_start();
require '../../0/includes/db.php';

header("Content-Type: application/json");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}



$user_id = $_SESSION['user_id'];

// Check if the request is for sending a message
if (isset($_POST['message']) && isset($_POST['ticket_id'])) {
    $message = trim($_POST['message']);
    $ticket_id = intval($_POST['ticket_id']); // Ensure ticket_id is an integer

    // Validate the message content
    if ($message === "") {
        echo json_encode(['success' => false, 'message' => 'Message cannot be empty.']);
        exit;
    }

    try {
        // Begin a transaction
        $pdo->beginTransaction();

        // Step 1: Insert the message into the `ticket_responses` table
        $stmt = $pdo->prepare("
            INSERT INTO ticket_responses (ticket_id, user_id, response_text, created_at) 
            VALUES (:ticket_id, :user_id, :message, NOW())
        ");
        $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->execute();

        // Get the ID of the newly created response
        $responseId = $pdo->lastInsertId();

        // Step 2: Insert into the `audit_trail` table
        $actionType = 'INSERT'; // Action type
        $affectedTable = 'ticket_responses'; // The table being updated
        $details = "Added response to ticket ID $ticket_id: $message";
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp

        $stmt = $pdo->prepare("
            INSERT INTO audit_trail (action_type, affected_table, affected_id, details, user_id, timestamp) 
            VALUES (:actionType, :affectedTable, :affectedId, :details, :userId, :timestamp)
        ");
        $stmt->bindParam(':actionType', $actionType);
        $stmt->bindParam(':affectedTable', $affectedTable);
        $stmt->bindParam(':affectedId', $responseId, PDO::PARAM_INT);
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':userId', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':timestamp', $timestamp);
        $stmt->execute();

        // Commit the transaction
        $pdo->commit();

        echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// Check if the request is for uploading a file
if (isset($_POST['ticket_id']) && isset($_FILES['file'])) {
    $ticket_id = intval($_POST['ticket_id']);
    $file = $_FILES['file'];

    try {
        // Validate that the ticket response exists
        $stmt = $pdo->prepare("SELECT id FROM ticket_responses WHERE ticket_id = :ticket_id");
        $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the corresponding ticket response ID
        $response = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$response) {
            throw new Exception("Invalid ticket ID: No matching ticket response found.");
        }

        $ticket_response_id = $response['id']; // Use the ticket response ID

        // Check if a file is provided and valid
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("No valid file uploaded.");
        }

        $uploadDir = '../../assets/uploads/';
        $fileName = time() . '_' . basename($file['name']); // Add timestamp to avoid conflicts
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

        // Insert the file into the attachments table
        $stmt = $pdo->prepare("
            INSERT INTO attachments (ticket_id, uploaded_by, file_path, file_name, uploaded_at) 
            VALUES (:ticket_id, :uploaded_by, :file_path, :file_name, NOW())
        ");
        $stmt->bindParam(':ticket_id', $ticket_response_id, PDO::PARAM_INT); // Use the ticket response ID
        $stmt->bindParam(':uploaded_by', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':file_path', $file_path, PDO::PARAM_STR);
        $stmt->bindParam(':file_name', $fileName, PDO::PARAM_STR);
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'File uploaded successfully.', 'file_path' => $file_path]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// If no valid request type is provided
echo json_encode(['success' => false, 'message' => 'Invalid request.']);