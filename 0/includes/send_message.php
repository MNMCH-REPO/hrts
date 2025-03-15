<?php
session_start();
require '../../0/includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['message']) || !isset($_POST['ticket_id'])) {
    exit();
}

$user_id = $_SESSION['user_id'];
$message = trim($_POST['message']);
$ticket_id = intval($_POST['ticket_id']); // Ensure ticket_id is an integer

if ($message === "") {
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO ticket_responses (ticket_id, user_id, response_text) 
                           VALUES (:ticket_id, :user_id, :message)");
    $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->execute();
    echo "Message sent successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
