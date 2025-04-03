<?php
session_start();
require '../../0/includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['ticket_id'])) {
    exit('Invalid request.');
}

$user_id = $_SESSION['user_id'];
$ticket_id = intval($_GET['ticket_id']); // Ensure it's an integer

try {
    // Check if the ticket belongs to the logged-in user
    $checkStmt = $pdo->prepare("
        SELECT t.id, u.name AS assigned_name 
        FROM tickets t 
        JOIN users u ON t.assigned_to = u.id
        WHERE t.id = :ticket_id AND t.assigned_to = :user_id
    ");
    $checkStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $checkStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $checkStmt->execute();
    $ticketInfo = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$ticketInfo) {
        echo "Debugging Info:<br>";
        echo "Ticket ID: " . htmlspecialchars($ticket_id) . "<br>";
        echo "User ID: " . htmlspecialchars($user_id) . "<br>";
    
        // Run a manual test query to see if the ticket exists
        $debugStmt = $pdo->prepare("SELECT * FROM tickets WHERE id = :ticket_id");
        $debugStmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
        $debugStmt->execute();
        $debugResult = $debugStmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$debugResult) {
            exit("No ticket found with this ID.");
        } else {
            exit("Ticket exists, but not assigned to you. Your ID: " . $user_id . ", Ticket Employee ID: " . $debugResult['employee_id']);
        }
    }

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
    echo '<h3 class="assigned-name">' . htmlspecialchars($assignedName) . '</h3>';
    

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





?>