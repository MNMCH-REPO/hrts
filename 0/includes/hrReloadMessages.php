<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['ticket_id'])) {
    exit('Invalid request.');
}

$user_id = $_SESSION['user_id'];
$ticket_id = intval($_GET['ticket_id']); // Ensure it's an integer

try {
    // Check if the ticket belongs to the logged-in user
    $checkStmt = $pdo->prepare("
    SELECT 
        t.id, 
        t.employee_id, -- ID of the user who submitted the ticket
        t.assigned_to, -- ID of the user assigned to the ticket
        u_assigned.name AS assigned_name, -- Name of the user assigned to the ticket
        u_creator.name AS creator_name   -- Name of the user who submitted the ticket
    FROM tickets t
    LEFT JOIN users u_assigned ON t.assigned_to = u_assigned.id -- Join to get the assigned user's name
    LEFT JOIN users u_creator ON t.employee_id = u_creator.id  -- Join to get the creator's name
    WHERE t.id = :ticket_id AND (t.assigned_to = :user_id OR t.employee_id = :user_id)
");
$checkStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
$checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$checkStmt->execute();
$ticketInfo = $checkStmt->fetch(PDO::FETCH_ASSOC);


    if (!$ticketInfo) {
        // Debug output for access issues
        echo "Debugging Info:<br>";
        echo "Ticket ID: " . htmlspecialchars($ticket_id) . "<br>";
        echo "User ID: " . htmlspecialchars($user_id) . "<br>";

        $debugStmt = $pdo->prepare("SELECT * FROM tickets WHERE id = :ticket_id");
        $debugStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $debugStmt->execute();
        $debugResult = $debugStmt->fetch(PDO::FETCH_ASSOC);

        if (!$debugResult) {
            exit("No ticket found with this ID.");
        } else {
            exit("Ticket exists, but you do not have access. Your ID: " . $user_id . ", Ticket Employee ID: " . $debugResult['employee_id']);
        }
    }
    if ($ticketInfo) {
        if ($ticketInfo['assigned_name'] && $user_id == $ticketInfo['employee_id']) {
            // Current user submitted the ticket, display the name of the assigned user
            $displayName = htmlspecialchars($ticketInfo['assigned_name']);
        } elseif ($ticketInfo['creator_name'] && $user_id == $ticketInfo['assigned_to']) {
            // Current user is assigned to the ticket, display the name of the creator
            $displayName = htmlspecialchars($ticketInfo['creator_name']);
        } else {
            $displayName = "Unknown"; // Fallback in case of unexpected data
        }
    } else {
        exit("You do not have access to this ticket.");
    }

    
    // Get the assigned user's name
     $assignedName = htmlspecialchars($ticketInfo['assigned_name']); // Get assigned user's name    

    // Fetch messages for the selected ticket
    $stmt = $pdo->prepare("
        SELECT ticket_responses.*, users.role 
        FROM ticket_responses 
        JOIN users ON ticket_responses.user_id = users.id 
        WHERE ticket_responses.ticket_id = :ticket_id 
        ORDER BY ticket_responses.created_at ASC
        LIMIT 50
    ");
    $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '<style>
    .convo-assigned {
        text-transform: uppercase; /* Converts text to all uppercase */
        font-size: small; /* Makes it smaller */
        font-weight: bold; /* Ensures visibility */
        text-align: center; /* Centers the text */
        letter-spacing: 1px; /* Adds spacing for clarity */
        margin-top: 20px; /* Adds spacing from the top */
    }

    .assigned-name {
        font-size: 1.8rem; /* H3 equivalent size */
        font-weight: bold; /* Makes it stand out */
        text-align: center; /* Centers the text */
        display: block; /* Ensures it behaves as a block element */
        margin-top: 5px; /* Small space below the label */
    }
</style>';



    echo '<h5 class="convo-assigned">You are now having a conversation with:</h5>';
    echo '<h3 class="assigned-name">' . $displayName . '</h3>';


    if (!$messages) {
        echo "<p>No messages yet.</p>";
    } else {
        foreach ($messages as $row) {
            $message = htmlspecialchars($row['response_text']);
            $sender_id = $row['user_id'];
            $role = $row['role'];

            // Determine message alignment
            $class = ($sender_id == $user_id) ? "sent" : "received";

            echo "<div class='message $class'>$message</div>";
        }
    }
} catch (PDOException $e) {
    echo "Error loading messages: " . $e->getMessage();
}
