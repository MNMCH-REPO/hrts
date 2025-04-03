<?php
session_start();
require '../../0/includes/db.php';

if (!isset($_SESSION['user_id'])) {
    exit('Invalid request.');
}

$user_id = $_SESSION['user_id'];

// Fetch user role
try {
    $roleStmt = $pdo->prepare("SELECT role FROM users WHERE id = :user_id");
    $roleStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $roleStmt->execute();
    $userRole = $roleStmt->fetchColumn();
} catch (PDOException $e) {
    exit("Error fetching role: " . $e->getMessage());
}

// If Admin, fetch all tickets; else, fetch only user's tickets
try {
    if ($userRole === 'Admin') {
        // Admin sees all tickets
        $stmt = $pdo->prepare("
            SELECT t.id, u.name AS assigned_name, t.employee_id 
            FROM tickets t
            LEFT JOIN users u ON t.assigned_to = u.id
            ORDER BY t.id DESC
        ");
        $stmt->execute();
    } else {
        // Regular user sees only their tickets
        $stmt = $pdo->prepare("
            SELECT t.id, u.name AS assigned_name, t.employee_id 
            FROM tickets t
            LEFT JOIN users u ON t.assigned_to = u.id
            WHERE t.employee_id = :user_id
            ORDER BY t.id DESC
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<style>
        .ticket {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            background: #f1f1f1;
            cursor: pointer;
        }
        .ticket:hover {
            background: #ddd;
        }
        .convo-header {
            text-transform: uppercase;
            font-size: small;
            font-weight: bold;
            text-align: center;
            letter-spacing: 1px;
            margin-top: 20px;
        }
    </style>';

    echo '<h5 class="convo-header">Available Tickets</h5>';

    if (!$tickets) {
        echo "<p>No tickets found.</p>";
    } else {
        foreach ($tickets as $ticket) {
            $ticketId = $ticket['id'];
            $assignedName = htmlspecialchars($ticket['assigned_name']);
            echo "<div class='ticket' onclick='loadMessages($ticketId)'>Ticket #$ticketId - Assigned to: $assignedName</div>";
        }
    }
} catch (PDOException $e) {
    echo "Error loading tickets: " . $e->getMessage();
}
?>
