<?php
$dsn = 'mysql:host=localhost;dbname=mnmch_hrts_db;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit; 
}

// Fetch messages ordered by datetime
$query = "SELECT user_id AS sender, response_text AS message, created_at AS dateTime 
          FROM ticket_responses 
          ORDER BY created_at ASC";

$stmt = $pdo->prepare($query);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display messages
foreach ($messages as $msg) {
    $class = ($msg['sender'] == 'You') ? 'sent' : 'received';
    echo "<div class='message $class'><strong>{$msg['sender']}:</strong> {$msg['message']} <br><small>{$msg['dateTime']}</small></div>";
}
?>
