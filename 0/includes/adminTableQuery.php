<?php
try {
    require '../../0/includes/db.php';
    require 'platesCount.php';

    // Pagination settings
    $limit = 10; // Number of records per page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Fetch total number of tickets
    $countSql = "SELECT COUNT(*) FROM tickets";
    $stmt = $pdo->query($countSql);
    $totalRecords = $stmt->fetchColumn();
    $totalPages = ceil($totalRecords / $limit);

    // Fetch paginated tickets
    $sql = "SELECT 
                t.id, 
                e.name AS employee_name, 
                t.subject, 
                t.description, 
                t.status, 
                t.priority, 
                c.name AS category_name, 
                a.name AS assigned_to_name, 
                t.created_at, 
                t.updated_at 
            FROM tickets t
            LEFT JOIN users e ON t.employee_id = e.id
            LEFT JOIN users a ON t.assigned_to = a.id
            LEFT JOIN categories c ON t.category_id = c.id
            LIMIT :limit OFFSET :offset"; // Pagination

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


try {
    // Query to fetch id and name from users table
    $stmt = $pdo->prepare("SELECT id, name FROM users ORDER BY name ASC");
    $stmt->execute();

    // Fetch all rows
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database errors
    error_log("Database error: " . $e->getMessage());
    $users = [];
}


try {
    // Query to fetch all distinct statuses from tickets
    $stmt = $pdo->prepare("SELECT DISTINCT status FROM tickets ORDER BY status ASC");
    $stmt->execute();
    // Fetch all rows
    $ticketStatus = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get the current status of the ticket (replace with your actual ticket ID query)
    $ticketID = 'editticketID'; // Replace this with the actual ticket ID
    $stmt = $pdo->prepare("SELECT status FROM tickets WHERE id = :ticketID");
    $stmt->bindParam(':ticketID', $ticketID, PDO::PARAM_INT);
    $stmt->execute();
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set the current status to 'In Progress' if not found
    $currentStatus = $ticket ? $ticket['status'] : 'In Progress';
} catch (PDOException $e) {
    // Handle database errors
    error_log("Database error: " . $e->getMessage());
    $ticketStatus = [];
    $currentStatus = 'In Progress';  // Default value on error
}
