<?php

try {
    require 'db.php';

    // Pagination settings
    $limit = 10; // Number of records per page
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Fetch total number of users
    $countSql = "SELECT COUNT(*) FROM users";
    $stmt = $pdo->query($countSql);
    $totalRecords = $stmt->fetchColumn();
    $totalPages = ceil($totalRecords / $limit);

    // Fetch paginated users from the database
    $sql = "SELECT id, name, email, role, department, status, created_at 
            FROM users 
            LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
