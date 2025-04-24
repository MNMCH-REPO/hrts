<?php
require '../../0/includes/db.php';

// Query to count "Open" tickets
$openTickets = "
                        SELECT COUNT(id) AS open_tickets 
                        FROM tickets 
                        WHERE status = 'Open'
                    ";

$stmtOpen = $pdo->prepare($openTickets);
$stmtOpen->execute();
$openTickets = $stmtOpen->fetchAll(PDO::FETCH_ASSOC);

// Query to count "In Progress" tickets
$inprogressTickets = "
    SELECT COUNT(id) AS inprogress_tickets 
    FROM tickets 
    WHERE status = 'In Progress' 
      AND assigned_to IS NOT NULL
";
$stmtInProgress = $pdo->prepare($inprogressTickets);
$stmtInProgress->execute();
$inprogressTickets = $stmtInProgress->fetchAll(PDO::FETCH_ASSOC);

// Query to count resolved tickets and identify the user who declined them
$resolvedTickets = "
                SELECT COUNT(id) AS resolved_tickets 
                FROM tickets 
                WHERE status = 'Resolved' 
                  AND assigned_to IS NOT NULL";
$stmtResolved = $pdo->prepare($resolvedTickets);
$stmtResolved->execute();
$resolvedTickets = $stmtResolved->fetchAll(PDO::FETCH_ASSOC);

// Query to count rejected tickets and identify the user who declined them
$queryRejected = "
    SELECT at.user_id, u.name AS user_name, COUNT(t.id) AS rejected_count
    FROM audit_trail at
    JOIN tickets t ON at.affected_id = t.id
    JOIN users u ON at.user_id = u.id
    WHERE at.action_type = 'DECLINE' AND t.status = 'Open' AND t.assigned_to IS NULL
    GROUP BY at.user_id, u.name
";
$stmtRejected = $pdo->prepare($queryRejected);
$stmtRejected->execute();
$rejectedTickets = $stmtRejected->fetchAll(PDO::FETCH_ASSOC);

// Query to count "Total" tickets
$totalTickets = "
    SELECT COUNT(id) AS total_tickets 
    FROM tickets 
    
";

$stmtTotalTickets = $pdo->prepare($totalTickets);
$stmtTotalTickets->execute();
$totalTickets = $stmtTotalTickets->fetchAll(PDO::FETCH_ASSOC);



// Fetch paginated tickets
$ticketsQuery = "SELECT 
t.id, 
e.name AS employee_name, 
 e.department AS assigned_department, 
t.subject, 
t.description, 
t.status, 
t.priority, 
c.name AS category_name, 
a.name AS assigned_to_name, 
t.created_at,
t.start_at,
t.updated_at 
FROM tickets t
LEFT JOIN users e ON t.employee_id = e.id
LEFT JOIN users a ON t.assigned_to = a.id
LEFT JOIN categories c ON t.category_id = c.id
ORDER BY t.created_at DESC";


$stmt = $pdo->prepare($ticketsQuery);

$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Query to fetch top HR employees with the most resolved tickets
$query = "SELECT u.id AS user_id, u.name AS employee_name, COUNT(t.id) AS resolved_count
          FROM users u
          JOIN tickets t ON t.assigned_to = u.id
          WHERE t.status = 'Resolved' AND u.role = 'HR'
          GROUP BY u.id, u.name
          ORDER BY resolved_count DESC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$topResolvedAccounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
