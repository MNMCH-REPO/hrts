<?php
session_start();
require '../../0/includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['message'])) {
    exit();
}

$user_id = $_SESSION['user_id'];
$message = trim($_POST['message']);

if ($message === "") {
    exit();
}

try {
    $stmt = $pdo->prepare("INSERT INTO ticket_responses (user_id, response_text) VALUES (:user_id, :message)");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->execute();
    echo "Message sent successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
