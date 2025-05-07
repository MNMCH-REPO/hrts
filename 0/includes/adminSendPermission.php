<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || (!isset($_GET['ticket_id']) && !isset($_GET['leave_id']))) {
    echo json_encode(['canReply' => false]);
    exit;
}

$user_id = $_SESSION['user_id'];
$roleUser = $_SESSION['role']; // Get the role of the logged-in user
$ticket_id = isset($_GET['ticket_id']) ? intval($_GET['ticket_id']) : null; // Ensure it's an integer
$leave_id = isset($_GET['leave_id']) ? intval($_GET['leave_id']) : null; // Ensure it's an integer

try {
    $canReply = false;

    // Check if the user is allowed to reply to the ticket
    if ($ticket_id) {
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

        if ($ticket) {
            if ($ticket['employee_id'] == $user_id || $ticket['assigned_to'] == $user_id) {
                $canReply = true;
            } elseif ($roleUser === 'Admin') {
                $canReply = true; // Admins can reply to any ticket
            }
        }
    }

    // Check if the user is allowed to reply to the leave request
    if ($leave_id) {
        $leaveStmt = $pdo->prepare("
            SELECT 
                l.employee_id, 
                l.approved_by AS assigned_to
            FROM leave_requests l
            WHERE l.id = :leave_id
        ");
        $leaveStmt->bindParam(':leave_id', $leave_id, PDO::PARAM_INT);
        $leaveStmt->execute();
        $leave = $leaveStmt->fetch(PDO::FETCH_ASSOC);

        if ($leave) {
            if ($leave['employee_id'] == $user_id || $leave['assigned_to'] == $user_id) {
                $canReply = true;
            } elseif ($roleUser === 'Admin') {
                $canReply = true; // Admins can reply to any leave request
            }
        }
    }

    echo json_encode(['canReply' => $canReply]);
} catch (PDOException $e) {
    echo json_encode(['canReply' => false, 'error' => $e->getMessage()]);
}