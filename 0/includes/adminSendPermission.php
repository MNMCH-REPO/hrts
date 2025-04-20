<?php
session_start();
require '../../0/includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['ticket_id'])) {
    echo json_encode(['canReply' => false]);
    exit;
}

$user_id = $_SESSION['user_id'];
$roleUser = $_SESSION['role']; // Get the role of the logged-in user
$ticket_id = intval($_GET['ticket_id']); // Ensure it's an integer

try {
    // Check if the user is allowed to reply to the ticket
    $stmt = $pdo->prepare("
        SELECT 
            t.employee_id, 
            t.assigned_to
        FROM tickets t
        WHERE t.id = :ticket_id
    ");
    $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt->execute();
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ticket) {
        echo json_encode(['canReply' => false]);
        exit;
    }

    // Corrected logic for Admin role
    if (
        $roleUser === 'Admin' && 
        $ticket['employee_id'] != $user_id && 
        $ticket['assigned_to'] != $user_id
    ) {
        // Admin cannot reply if not related to the ticket
        echo json_encode(['canReply' => false]);
    } else {
        // User can reply (either related to the ticket or not an Admin)
        echo json_encode(['canReply' => true]);
    }
} catch (PDOException $e) {
    echo json_encode(['canReply' => false, 'error' => $e->getMessage()]);
}