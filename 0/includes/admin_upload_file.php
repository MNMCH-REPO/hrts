<?php
header('Content-Type: application/json');

function uploadFile($pdo, $ticket_id, $user_id, $file)
{
    $file_path = null;
    $file_name = null;

    try {
        // Check if the ticket exists in the tickets table
        $stmt = $pdo->prepare("
            SELECT id 
            FROM tickets 
            WHERE id = :ticket_id
        ");
        $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            throw new Exception("Invalid ticket_id: No matching ticket found in tickets.");
        }

        // Debugging: Log ticket validation success
        error_log("Ticket ID $ticket_id validated successfully.");

        // Check if a file is provided and valid
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("No valid file uploaded.");
        }

        $uploadDir = '../../assets/uploads/';
        $fileName = basename($file['name']); // Extract the file name
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
        $file_name = $fileName; // Save the file name to the database

        // Debugging: Log file upload success
        error_log("File uploaded successfully to $file_path.");

        // Insert the file into the attachments table
        $stmt = $pdo->prepare("
            INSERT INTO attachments (ticket_id, uploaded_by, file_path, file_name, uploaded_at) 
            VALUES (:ticket_id, :uploaded_by, :file_path, :file_name, NOW())
        ");
        $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $stmt->bindParam(':uploaded_by', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':file_path', $file_path, PDO::PARAM_STR);
        $stmt->bindParam(':file_name', $file_name, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert attachment into database: " . implode(", ", $stmt->errorInfo()));
        }

        // Debugging: Log database insertion success
        error_log("Attachment inserted into database successfully.");

        // ✅ ADDITION: Also insert a message into ticket_responses table
        $response_text = "$file_name";
        $stmt = $pdo->prepare("
    INSERT INTO ticket_responses (ticket_id, user_id, response_text, created_at)
    VALUES (:ticket_id, :user_id, :response_text, NOW())
");
        $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':response_text', $response_text, PDO::PARAM_STR);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert file message into ticket_responses.");
        }
        // ✅ Done

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

try {
    session_start();
    require '../../0/includes/db.php';

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    if (!isset($_POST['ticket_id'])) {
        echo json_encode(['success' => false, 'message' => 'Ticket ID is required.']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $ticket_id = intval($_POST['ticket_id']);

    // Debugging: Log the incoming data
    error_log("User ID: $user_id, Ticket ID: $ticket_id");

    if (!isset($_FILES['file'])) {
        echo json_encode(['success' => false, 'message' => 'No file uploaded.']);
        exit;
    }

    // Debugging: Log file details
    error_log("File Details: " . print_r($_FILES['file'], true));

    // Call the uploadFile function
    $response = uploadFile($pdo, $ticket_id, $user_id, $_FILES['file']);
    echo json_encode($response);
} catch (Exception $e) {
    error_log("Error in admin_upload_file.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An unexpected error occurred.']);
}
