<?php
session_start();
require '../../0/includes/db.php';

if (!isset($_SESSION['user_id'])) {
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->query("SELECT ticket_responses.*, users.role FROM ticket_responses 
                         JOIN users ON ticket_responses.user_id = users.id 
                         ORDER BY ticket_responses.created_at ASC");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $message = htmlspecialchars($row['response_text']);
        $sender_id = $row['user_id'];
        $role = $row['role'];

        // Determine message alignment based on role
        $class = ($sender_id == $user_id) ? "sent" : "received";

        echo "<div class='message $class'>$message</div>";
    }
} catch (PDOException $e) {
    echo "Error loading messages: " . $e->getMessage();
}
?>
