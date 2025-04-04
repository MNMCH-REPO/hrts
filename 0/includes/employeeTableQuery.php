<?php
try {
    require '../../0/includes/db.php';

    $userId = $_SESSION['user_id']; // Logged-in user's ID

    // Fetch ticket counts grouped by status for the logged-in user
    $statusCounts = [
        'Open' => 0,
        'In Progress' => 0,
        'Resolved' => 0
    ];

    $statusSql = "SELECT status, COUNT(*) AS count 
                  FROM tickets 
                  WHERE employee_id = :user_id 
                  GROUP BY status";
    $stmt = $pdo->prepare($statusSql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $statusResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($statusResults as $row) {
        $statusCounts[$row['status']] = $row['count'];
    }

    // Pagination settings
    $limit = 10; // Number of records per page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Fetch total number of tickets for the logged-in user
    $countSql = "SELECT COUNT(*) FROM tickets WHERE employee_id = :user_id";
    $stmt = $pdo->prepare($countSql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $totalRecords = $stmt->fetchColumn();
    $totalPages = ceil($totalRecords / $limit);

    // Fetch paginated tickets for the logged-in user
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
            WHERE t.employee_id = :user_id
            LIMIT :limit OFFSET :offset"; // Pagination

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debugging: Output the tickets and pagination info (optional)
    // echo "<pre>";
    // print_r($tickets);
    // echo "Total Records: $totalRecords, Total Pages: $totalPages";
    // echo "</pre>";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>