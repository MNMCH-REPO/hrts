<?php
session_start();
require '../../0/includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['ticket_id'])) {
    exit('Invalid request.');
}

$user_id = $_SESSION['user_id'];
$roleUser = $_SESSION['role']; // Get the role of the logged-in user
$ticket_id = intval($_GET['ticket_id']); // Ensure it's an integer

try {
    // Check if the ticket exists and if the user has access
    if ($roleUser === 'Admin' || $roleUser === 'Super Admin') {
        // Admins can view all tickets
        $checkStmt = $pdo->prepare("
            SELECT 
                t.id, 
                t.employee_id, 
                t.assigned_to, 
                u_assigned.name AS assigned_name, 
                u_creator.name AS creator_name
            FROM tickets t
            LEFT JOIN users u_assigned ON t.assigned_to = u_assigned.id
            LEFT JOIN users u_creator ON t.employee_id = u_creator.id
            WHERE t.id = :ticket_id
        ");
        $checkStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    } else {
        // Non-admin users can only view tickets they are assigned to or created
        $checkStmt = $pdo->prepare("
            SELECT 
                t.id, 
                t.employee_id, 
                t.assigned_to, 
                u_assigned.name AS assigned_name, 
                u_creator.name AS creator_name
            FROM tickets t
            LEFT JOIN users u_assigned ON t.assigned_to = u_assigned.id
            LEFT JOIN users u_creator ON t.employee_id = u_creator.id
            WHERE t.id = :ticket_id AND (t.assigned_to = :user_id OR t.employee_id = :user_id)
        ");
        $checkStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    }

    $checkStmt->execute();
    $ticketInfo = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$ticketInfo) {
        exit("No ticket found or access denied.");
    }

    // Determine the display name
    if ($ticketInfo['assigned_name'] && $user_id == $ticketInfo['employee_id']) {
        $displayName = htmlspecialchars($ticketInfo['assigned_name']);
    } elseif ($ticketInfo['creator_name'] && $user_id == $ticketInfo['assigned_to']) {
        $displayName = htmlspecialchars($ticketInfo['creator_name']);
    } elseif ($roleUser === 'Admin') {
        $displayName = $ticketInfo['assigned_name']
            ? htmlspecialchars($ticketInfo['assigned_name'])
            : "No Assigned yet";
    } else {
        $displayName = "Unknown";
    }

    // Fetch messages for the selected ticket
    $stmt = $pdo->prepare("
        SELECT 
            ticket_responses.response_text, 
            ticket_responses.created_at, 
            users.name AS sender_name, 
            ticket_responses.user_id
        FROM ticket_responses
        JOIN users ON ticket_responses.user_id = users.id
        WHERE ticket_responses.ticket_id = :ticket_id
        ORDER BY ticket_responses.created_at ASC
    ");
    $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch attachments for the selected ticket
    $attachmentStmt = $pdo->prepare("
        SELECT 
            attachments.file_name, 
            attachments.file_path, 
            attachments.uploaded_at, 
            users.name AS uploaded_by_name
        FROM attachments
        JOIN users ON attachments.uploaded_by = users.id
        WHERE attachments.ticket_id = :ticket_id
        ORDER BY attachments.uploaded_at ASC
    ");
    $attachmentStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $attachmentStmt->execute();
    $attachments = $attachmentStmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the conversation header
    echo '<style>
    .convo-assigned {
        text-transform: uppercase;
        font-size: small;
        font-weight: bold;
        text-align: center;
        letter-spacing: 1px;
        margin-top: 20px;
    }

    .assigned-name {
        font-size: 1.8rem;
        font-weight: bold;
        text-align: center;
        display: block;
        margin-top: 5px;
    }


            .attachment {
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .attachment-image {
    max-width: 300px; /* Limit the width to 300px */
    height: auto; /* Maintain aspect ratio */
    border-radius: 5px; /* Add rounded corners */
    margin-top: 10px; /* Add spacing above the image */
}
</style>';

    echo '<h5 class="convo-assigned">You are now having a conversation with:</h5>';
    echo '<h3 class="assigned-name">' . $displayName . '</h3>';

    // Display messages
    if (!$messages && !$attachments) {
        
        echo '<div class="no-messages">No messages or attachments yet.</div>';
    } else {
        foreach ($messages as $row) {
            $message = htmlspecialchars($row['response_text']);
            $sender_name = htmlspecialchars($row['sender_name']);
            $created_at = date('F j, Y - h:i A', strtotime($row['created_at']));
            $class = ($row['user_id'] == $user_id) ? "sent" : "received";

            // Skip plain text messages if they are associated with a file
            $isFileMessage = false;
            foreach ($attachments as $attachment) {
                if ($attachment['uploaded_at'] === $row['created_at'] && $attachment['uploaded_by_name'] === $sender_name) {
                    $isFileMessage = true;
                    break;
                }
            }

            if ($isFileMessage) {
                continue; // Skip this plain text message
            }

            echo "<div class='message $class'>";
            echo "<p><strong>$sender_name:</strong> <br> $message</p>";
            echo "<small>Sent on: $created_at</small>";
            echo "</div>";
        }

      
        // Display attachments
        foreach ($attachments as $attachment) {
            $file_name = htmlspecialchars($attachment['file_name']);
            $file_path = htmlspecialchars($attachment['file_path']);
            $uploaded_by = htmlspecialchars($attachment['uploaded_by_name']);
            $uploaded_at = date('F j, Y - h:i A', strtotime($attachment['uploaded_at']));

            echo "<div class='attachment'>";

            echo "<p><strong>Uploaded by:</strong> $uploaded_by</p>";
            // Check if the file is an image
            $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];


            if (in_array($file_extension, $image_extensions)) {
                // Render the image with view and download options
                echo "<img src='/$file_path' alt='$file_name' class='attachment-image'>";
                echo "<p><button class='btnWarning' onclick=\"openImageModal('/$file_path', '$file_name')\">
            <img src='../../assets/images/icons/view.png' alt='View' >
          </button></p>";
                echo "<p><button class='btnWarning' onclick=\"handleFileAction('/$file_path', 'download')\">
            <img src='../../assets/images/icons/downloads.png' alt='Download' >
          </button></p>";
            } else {
                // Provide view and download options for non-image files
                echo "<p><strong>File:</strong> $file_name</p>";
                echo "<p><button class='btnWarning' onclick=\"openImageModal('/$file_path', '$file_name')\">
            <img src='../../assets/images/icons/view.png' alt='View' >
          </button></p>";
                echo "<p><button class='btnWarning' onclick=\"handleFileAction('/$file_path', 'download')\">
            <img src='../../assets/images/icons/downloads.png' alt='Download' >
          </button></p>";
            }

            echo "<small>Uploaded on: $uploaded_at</small>";
            echo "</div>";
        }
    }
} catch (PDOException $e) {
    echo "Error loading messages: " . $e->getMessage();
}
