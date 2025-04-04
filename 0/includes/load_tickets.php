<?php
require '../../0/includes/db.php';

try {
    // Fetch all tickets with employee and assigned user names
    $stmt = $pdo->prepare("
        SELECT 
            tickets.id, 
            employee.name AS employee_name, 
            assigned.name AS assigned_name, 
            tickets.status, 
            tickets.created_at 
        FROM tickets 
        LEFT JOIN users AS employee ON tickets.employee_id = employee.id 
        LEFT JOIN users AS assigned ON tickets.assigned_to = assigned.id 
        ORDER BY tickets.created_at DESC
    ");
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $ticketId = htmlspecialchars($row['id']);
        $employeeName = htmlspecialchars($row['employee_name'] ?? 'N/A'); // Handle null values
        $assignedName = htmlspecialchars($row['assigned_name'] ?? 'N/A'); // Handle null values
        $status = htmlspecialchars($row['status']);
        $createdAt = htmlspecialchars(date("F j, Y", strtotime($row['created_at'])));

        echo "
            <div class='ticket-card' data-id='$ticketId'>
                <div class='ticket-info'>
                    <h3>Ticket ID: $ticketId</h3>
                    <p><strong>Employee: $employeeName</strong></p>
                    <p><strong>Assigned To: $assignedName</strong></p>
                    <p>Status: $status</p>
                    <p>Created At: $createdAt</p>
                </div>
            </div>
        ";
    }
} catch (PDOException $e) {
    echo "Error loading tickets: " . $e->getMessage();
}
?>