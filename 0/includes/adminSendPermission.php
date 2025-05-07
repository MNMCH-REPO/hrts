<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || (!isset($_GET['ticket_id']) && !isset($_GET['leave_id']))) {
    echo json_encode(['canReply' => false, 'error' => 'Missing session or ID']);
    exit;
}

$user_id = $_SESSION['user_id'];
$roleUser = $_SESSION['role']; // Get the role of the logged-in user
$ticket_id = isset($_GET['ticket_id']) ? intval($_GET['ticket_id']) : null;
$leave_id = isset($_GET['leave_id']) ? intval($_GET['leave_id']) : null;

try {
    $canReply = false;

    // Ticket permission check
    if ($ticket_id !== null && $ticket_id > 0) {
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
            // Debug logging
            error_log("Ticket Check: user_id=$user_id, role=$roleUser, ticket=" . json_encode($ticket));

            if (
                $ticket['employee_id'] == $user_id || 
                $ticket['assigned_to'] == $user_id || 
                $roleUser === 'Admin'
            ) {
                $canReply = true;
            }
        } else {
            error_log("Ticket not found for ID: $ticket_id");
        }
    }

    // Leave request permission check
    if ($leave_id !== null && $leave_id > 0) {
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
            // Debug logging
            error_log("Leave Check: user_id=$user_id, role=$roleUser, leave=" . json_encode($leave));

            if (
                $leave['employee_id'] == $user_id || 
                $leave['assigned_to'] == $user_id || 
                $roleUser === 'Admin'
            ) {
                $canReply = true;
            }
        } else {
            error_log("Leave request not found for ID: $leave_id");
        }
    }

    echo json_encode([
        'canReply' => $canReply,
        'employee_id' => $ticket['employee_id'] ?? null,
        'assigned_to' => $ticket['assigned_to'] ?? null,
        'current_user_id' => $user_id,
        'role' => $roleUser
    ]);
    
} catch (PDOException $e) {
    error_log("PDO Error: " . $e->getMessage());
    echo json_encode(['canReply' => false, 'error' => 'Database error']);
}
