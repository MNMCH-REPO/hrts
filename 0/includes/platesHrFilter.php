<?php
try {
    require '../../0/includes/db.php';

    $currentUserId = $_SESSION['user_id'] ?? null; // Get the current user ID from session

    // Initialize status count array
    $statusCounts = [
        'Open' => 0,
        'In Progress' => 0,
        'Resolved' => 0
    ];

    if ($currentUserId) {
        // Fetch counts for ticket statuses where the user is assigned or submitted the ticket
        $sql = "SELECT status, COUNT(*) AS count FROM tickets 
                WHERE status IN ('Open', 'In Progress', 'Resolved') 
                AND (assigned_to = :userId OR employee_id = :userId)
                GROUP BY status";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $currentUserId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Populate the statusCounts array with actual counts
        foreach ($results as $row) {
            $statusCounts[$row['status']] = $row['count'];
        }
    }

    echo "<script>console.log('Status Counts:', " . json_encode($statusCounts) . ");</script>";


    if ($currentUserId) {
        // Fetch total number of tickets assigned to or submitted by the user
        $countSql = "SELECT COUNT(*) FROM tickets WHERE assigned_to = :userId OR employee_id = :userId";
        $stmt = $pdo->prepare($countSql);
        $stmt->bindParam(':userId', $currentUserId, PDO::PARAM_INT);
        $stmt->execute();
        $totalRecords = $stmt->fetchColumn();


        // Fetch paginated tickets assigned to or submitted by the user
        $sql = "SELECT 
                    t.id, 
                    e.name AS employee_name, 
                    e.department AS employee_department,  -- Fetch the department of the ticket submitter
                    t.subject, 
                    t.description, 
                    t.status, 
                    t.priority, 
                    c.name AS category_name, 
                    a.name AS assigned_to_name, 
                    a.department AS assigned_department, -- Fix department selection
                    t.created_at, 
                    t.start_at,
                    t.updated_at 
                FROM tickets t


            LEFT JOIN users e ON t.employee_id = e.id  -- Ticket submitter
            LEFT JOIN users a ON t.assigned_to = a.id  -- Assigned user
            LEFT JOIN categories c ON t.category_id = c.id
            WHERE t.assigned_to = :userId OR t.employee_id = :userId
            ORDER BY t.created_at DESC";
           


        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userId', $currentUserId, PDO::PARAM_INT);
        $stmt->execute();
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // If no user is logged in, set empty values
        $tickets = [];
        $totalRecords = 0;
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Output the tickets in JSON format for debugging in console
echo "<script>console.log('Tickets:', " . json_encode($tickets) . ");</script>";
echo "<script>console.log('Total Records:', " . json_encode($totalRecords) . ");</script>";



