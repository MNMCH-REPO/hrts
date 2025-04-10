<?php

require '../../0/includes/db.php';

try {
    // Pagination settings
    $limit = 10; // Number of records per page
    $pageUser = isset($_GET['userPage']) && is_numeric($_GET['userPage']) ? (int)$_GET['userPage'] : 1;
    $offset = ($pageUser - 1) * $limit;

    // Fetch total number of users
    $countSql = "SELECT COUNT(*) FROM users";
    $stmt = $pdo->query($countSql);
    $totalRecords = $stmt->fetchColumn();
    $totalPages = ceil($totalRecords / $limit);

    // Fetch paginated users
    $sql = "SELECT * FROM users
            ORDER BY id ASC
            LIMIT :limit OFFSET :offset"; // Pagination

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}


try {
    // Query for top 5 departments with the most tickets
    $topDepartmentsSql = "
        SELECT 
            u.department AS department, 
            COUNT(t.id) AS totalDepartmentCounts
        FROM tickets t
        LEFT JOIN users u ON t.employee_id = u.id
        GROUP BY u.department
        ORDER BY totalDepartmentCounts DESC
        LIMIT 5
    ";

    $stmt = $pdo->query($topDepartmentsSql);
    $totalDepartments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate the total number of tickets for the top 5 departments
    $totalTickets = array_sum(array_column($totalDepartments, 'totalDepartmentCounts'));



} catch (PDOException $e) {
    die("Database connection failed while fetching top departments: " . $e->getMessage());
}




try {
    // Query for top 5 categories with the most tickets
    $topCategoriesSql = "
        SELECT 
            c.name AS category, 
            COUNT(t.id) AS totalCategoryCounts
        FROM tickets t
        LEFT JOIN categories c ON t.category_id = c.id
        GROUP BY c.name
        ORDER BY totalCategoryCounts DESC
        LIMIT 5
    ";

    $stmt = $pdo->query($topCategoriesSql);
    $totalCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate the total number of tickets for the top 5 categories
    $totalCategory = array_sum(array_column($totalCategories, 'totalCategoryCounts'));

} catch (PDOException $e) {
    die("Database connection failed while fetching top categories: " . $e->getMessage());
}



try {
    // Query for top 10 longest orders
    $longestOrdersSql = "
        SELECT 
            t.id AS ticket_id,
            c.name AS category,
            t.description AS order_details,
            TIMESTAMPDIFF(SECOND, t.start_at, t.updated_at) AS duration_seconds,
            t.start_at,
            t.updated_at
        FROM tickets t
        LEFT JOIN categories c ON t.category_id = c.id
        WHERE t.start_at IS NOT NULL AND t.updated_at IS NOT NULL
        ORDER BY duration_seconds DESC
        LIMIT 10
    ";

    $stmt = $pdo->query($longestOrdersSql);
    $longestOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed while fetching longest orders: " . $e->getMessage());
}



?>