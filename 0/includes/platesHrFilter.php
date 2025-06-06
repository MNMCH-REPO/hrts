<?php
try {
    require 'db.php';

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
        echo "<script>
                const statusCounts = " . json_encode($statusCounts) . ";
            </script>";


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


// Assuming you have these variables from your session
$userRole = $_SESSION['role']; // Example: "Employee" or "Admin"
$userId = $_SESSION['user_id']; // The current logged-in user's ID

try {
    if ($userRole === 'Employee') {
        // Employee can only see their own leave requests
        $stmt = $pdo->prepare("
            SELECT 
                lr.id, 
                lr.employee_id,
                u.name AS name,
                u.department AS department, 
                lr.leave_types, 
                lr.start_date, 
                lr.end_date, 
                lr.reason, 
                lr.status, 
                lr.created_at, 
                approver.name AS approved_by_name,
                lr.updated_at
            FROM leave_requests lr
            LEFT JOIN users u ON lr.employee_id = u.id
            LEFT JOIN users approver ON lr.approved_by = approver.id
            WHERE lr.employee_id = :user_id
            ORDER BY lr.created_at DESC
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    } else {
        // Admin, Manager, etc. can see all leave requests
        $stmt = $pdo->prepare("
            SELECT 
                lr.id, 
                lr.employee_id,
                u.name AS name,
                u.department AS department, 
                lr.leave_types, 
                lr.start_date, 
                lr.end_date, 
                lr.reason, 
                lr.status, 
                lr.created_at, 
                approver.name AS approved_by_name,
                lr.updated_at
            FROM leave_requests lr
            LEFT JOIN users u ON lr.employee_id = u.id
            LEFT JOIN users approver ON lr.approved_by = approver.id
            ORDER BY lr.created_at DESC
        ");
    }
    $stmt->execute();

    $leave_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    $leave_requests = [];
}


$userRole = $_SESSION['role']; // Example: "Employee" or "Admin"
$userId = $_SESSION['user_id']; // The current logged-in user's ID

try {
    if ($userRole === 'Employee') {
        // Only count the logged-in employee's own leave requests
        $stmt = $pdo->prepare("
            SELECT status, COUNT(*) AS count
            FROM leave_requests
            WHERE status IN ('Pending', 'Approved', 'Rejected')
            AND employee_id = :user_id
            GROUP BY status
        ");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    } else {
        // Admin/Manager: count all leave requests
        $stmt = $pdo->prepare("
            SELECT status, COUNT(*) AS count
            FROM leave_requests
            WHERE status IN ('Pending', 'Approved', 'Rejected')
            GROUP BY status
        ");
    }
    
    $stmt->execute();

    $leaveCountsStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Convert the results into an associative array for easier access
    $statusCountsArray = [];
    foreach ($leaveCountsStatus as $row) {
        $statusCountsArray[$row['status']] = $row['count'];
    }

    // Example: Access counts
    $pendingCount = $statusCountsArray['Pending'] ?? 0;
    $approvedCount = $statusCountsArray['Approved'] ?? 0;
    $rejectedCount = $statusCountsArray['Rejected'] ?? 0;

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    $pendingCount = $approvedCount = $rejectedCount = 0;
}
