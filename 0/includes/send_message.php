<?php
$dsn = 'mysql:host=localhost;dbname=sampleconvo;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = trim($_POST['message']);
    $sender = "You"; // Change this dynamically if needed
    $receiver = "Other"; // Placeholder; modify as required

    if (!empty($message)) {
        $query = "INSERT INTO ticket_responses (ticket_id, user_id, response_text, created_at) 
          VALUES (:ticket_id, :user_id, :response_text, NOW())";

        $stmt = $pdo->prepare($query);
        $stmt->execute([
            ':sender' => $sender,
            ':receiver' => $receiver,
            ':message' => $message
        ]);

        echo "Message Sent!";
    } else {
        echo "Message cannot be empty!";
    }
}
?>
