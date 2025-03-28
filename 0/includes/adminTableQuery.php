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




?>
