<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['ticket_id'])) {
    exit('Invalid request.');
}

$user_id = $_SESSION['user_id'];
$roleUser = $_SESSION['role'];
$ticket_id = intval($_GET['ticket_id']);
// echo $_GET['ticket_type'];
if ($_GET['ticket_type'] == 'leave') {
    $type = 'leave';
} else {
    $type = 'ticket';
}

try {
    // Admins can view all tickets
    if ($type == 'ticket') {
        if ($roleUser === 'Admin' || $roleUser === 'Super Admin') {
            $checkStmt = $pdo->prepare("
                SELECT 
                    t.id, 
                    t.employee_id, 
                    t.assigned_to, 
                    t.category_id,
                    u_assigned.name AS assigned_name, 
                    u_creator.name AS creator_name,
                    c.id AS categories_id,
                    c.name AS category_name
                FROM tickets t
                LEFT JOIN users u_assigned ON t.assigned_to = u_assigned.id
                LEFT JOIN users u_creator ON t.employee_id = u_creator.id
                LEFT JOIN categories c ON t.category_id = c.id
                WHERE t.id = :ticket_id
            ");
            $checkStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        } else {
            $checkStmt = $pdo->prepare("
                SELECT 
                    t.id, 
                    t.employee_id, 
                    t.assigned_to,
                    t.category_id,
                    u_assigned.name AS assigned_name, 
                    u_creator.name AS creator_name,
                    c.id AS categories_id,
                    c.name AS category_name
                FROM tickets t
                LEFT JOIN users u_assigned ON t.assigned_to = u_assigned.id
                LEFT JOIN users u_creator ON t.employee_id = u_creator.id
                LEFT JOIN categories c ON t.category_id = c.id
                WHERE t.id = :ticket_id AND (t.assigned_to = :user_id OR t.employee_id = :user_id)
            ");
            $checkStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            $checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        }
    } else {
        if ($roleUser === 'Admin' || $roleUser === 'Super Admin') {
            $checkStmt = $pdo->prepare("
                SELECT 
                    lr.id, 
                    lr.employee_id,
                    lr.approved_by as assigned_to,
                    lr.leave_types,
                    u_assigned.name AS assigned_name, 
                    u_creator.name AS creator_name
                FROM leave_requests lr
                LEFT JOIN users u_assigned ON lr.approved_by = u_assigned.id
                LEFT JOIN users u_creator ON lr.employee_id = u_creator.id
                WHERE lr.id = :ticket_id
            ");
            $checkStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        } else {
            $checkStmt = $pdo->prepare("
                SELECT 
                    lr.id, 
                    lr.employee_id,
                    lr.approved_by as assigned_to,
                    lr.leave_types AS category_name,
                    u_assigned.name AS assigned_name, 
                    u_creator.name AS creator_name
                FROM leave_requests lr
                LEFT JOIN users u_assigned ON lr.approved_by = u_assigned.id
                LEFT JOIN users u_creator ON lr.employee_id = u_creator.id
                WHERE lr.id = :ticket_id AND (lr.assigned_to = :user_id OR lr.employee_id = :user_id)
            ");
            $checkStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            $checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        }
    }


    $checkStmt->execute();
    $ticketInfo = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$ticketInfo) {
        exit("No ticket found or access denied.");
    }

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

    // Fetch messages from either ticket_responses or leave_responses
    if ($type === 'leave') {
        $stmt = $pdo->prepare("
            SELECT 
                leave_responses.response_text_leave AS response_text, 
                leave_responses.created_at, 
                users.name AS sender_name, 
                leave_responses.user_id
            FROM leave_responses
            JOIN users ON leave_responses.user_id = users.id
            WHERE leave_responses.leave_id = :ticket_id
            ORDER BY leave_responses.created_at ASC
        ");
    } else {
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
    }
    $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch attachments from either attachments or leave_attachments
    if ($type === 'leave') {
        $attachmentStmt = $pdo->prepare("
            SELECT 
                leave_attachments.file_name, 
                leave_attachments.file_path, 
                leave_attachments.uploaded_at AS created_at,
                users.name AS uploaded_by_name
            FROM leave_attachments
            JOIN users ON leave_attachments.uploaded_by = users.id
            WHERE leave_attachments.leave_request_id = :ticket_id
            ORDER BY leave_attachments.uploaded_at ASC
        ");
    } else {
        $attachmentStmt = $pdo->prepare("
            SELECT 
                attachments.file_name, 
                attachments.file_path, 
                attachments.uploaded_at AS created_at,
                users.name AS uploaded_by_name
            FROM attachments
            JOIN users ON attachments.uploaded_by = users.id
            WHERE attachments.ticket_id = :ticket_id
            ORDER BY attachments.uploaded_at ASC
        ");
    }
    $attachmentStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $attachmentStmt->execute();
    $attachments = $attachmentStmt->fetchAll(PDO::FETCH_ASSOC);

    // Output UI and messages
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
            max-width: 300px;
            height: auto;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>';




    if ($type === 'ticket') {
        echo '<h5 class="convo-assigned">TICKET CONCERN</h5>';
        echo '<h5 class="convo-assigned">Category: ' . htmlspecialchars($ticketInfo['category_name'] ?? 'N/A') . '</h5>';
        echo '<h3 class="assigned-name">' . $displayName . '</h3>';
    } elseif ($type === 'leave') {
        echo '<h5 class="convo-assigned">LEAVE REQUEST</h5>';
        echo '<h5 class="convo-assigned">Leave Type: ' . htmlspecialchars($ticketInfo['category_name'] ?? 'N/A') . '</h5>';

        echo '<h3 class="assigned-name">' . $displayName . '</h3>';
    }


    if (!$messages && !$attachments) {
        echo '<div class="no-messages">No messages or attachments yet.</div>';
    } else {

        // Ensure $messages and $attachments are arrays
        $messages = is_array($messages) ? $messages : [];
        $attachments = is_array($attachments) ? $attachments : [];

        // Add a type field and validate keys

        foreach ($messages as &$message) {
            if (!is_array($message)) continue; // Skip invalid items
            $message['type'] = 'message';
            $message['created_at'] = !empty($message['created_at']) ? $message['created_at'] : null; // Validate created_at
            $message['user_id'] = $message['user_id'] ?? null; // Default to null
        }

        foreach ($attachments as &$attachment) {
            if (!is_array($attachment)) continue; // Skip invalid items
            $attachment['type'] = 'attachment';
            $attachment['created_at'] = !empty($attachment['created_at']) ? $attachment['created_at'] : null; // Validate created_at
            $attachment['user_id'] = $attachment['user_id'] ?? null; // Default to null
        }
}

// Merge and validate $conversation

// Initialize an empty conversation array
$conversation = [];

// Combine and validate $messages and $attachments
$dataSources = [$messages, $attachments];
foreach ($dataSources as $dataSource) {
    foreach ($dataSource as $item) {
        if (is_array($item) && isset($item['created_at'])) {
            $conversation[] = $item; // Add valid items
        }
    }
}

// Sort the conversation by created_at
$createdAtTimestamps = array_map(function ($item) {
    return isset($item['created_at']) ? strtotime($item['created_at']) : 0; // Convert created_at to timestamps
}, $conversation);

array_multisort($createdAtTimestamps, SORT_ASC, $conversation);

// Render the conversation
foreach ($conversation as $item) {
    if (!is_array($item)) continue; // Skip invalid items
    $created_at = isset($item['created_at']) && strtotime($item['created_at']) 
        ? date('F j, Y - h:i A', strtotime($item['created_at'])) 
        : 'Unknown Date'; // Fallback to 'Unknown Date' if invalid
    $class = ($item['user_id'] == $user_id) ? "sent" : "received";

    if ($item['type'] === 'message') {
        // Check if the response_text matches any file_name in the attachments
        $isDuplicate = false;
        foreach ($attachments as $attachment) {
            if ($attachment['file_name'] === $item['response_text']) {
                $isDuplicate = true;
                break;
            }
        }

        // Render the message only if it's not a duplicate
        if (!$isDuplicate) {
            $message = htmlspecialchars($item['response_text']);
            $sender_name = htmlspecialchars($item['sender_name']);
            echo "<div class='message $class'>";
            echo "<p><strong>$sender_name:</strong> <br> $message</p>";
            echo "<small>Sent on: $created_at</small>";
            echo "</div>";
        }
    } elseif ($item['type'] === 'attachment') {
        // Render attachment
        $file_name = htmlspecialchars($item['file_name']);
        $file_path = 'hrts/' . htmlspecialchars($item['file_path']);
        $uploaded_by = htmlspecialchars($item['uploaded_by_name']);

        echo "<div class='attachment $class'>";
        echo "<p><strong>Uploaded by:</strong> $uploaded_by</p>";

        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];

        if (in_array($file_extension, $image_extensions)) {
            echo "<img src='/$file_path' alt='$file_name' class='attachment-image'>";
            echo "<p><button class='btnWarning' onclick=\"openImageModal('/$file_path', '$file_name')\">
                <img src='../../assets/images/icons/view.png' alt='View'>
            </button></p>";
            echo "<p><button class='btnWarning' onclick=\"handleFileAction('/$file_path', 'download')\">
                <img src='../../assets/images/icons/downloads.png' alt='Download'>
            </button></p>";
        } else {
            echo "<p><strong>File:</strong> $file_name</p>";
            echo "<p><button class='btnWarning' onclick=\"handleFileAction('/$file_path', 'download')\">
                <img src='../../assets/images/icons/downloads.png' alt='Download'>
            </button></p>";
        }

        echo "<small>Uploaded on: $created_at</small>";
        echo "</div>";
    }
}
} catch (Exception $e) {
    echo "Error loading messages: " . $e->getMessage();
}
