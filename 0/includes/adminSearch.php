<?php
require_once 'db.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filterColumn = isset($_GET['filterColumn']) ? trim($_GET['filterColumn']) : '';
$filterValue = isset($_GET['filterValue']) ? trim($_GET['filterValue']) : '';

try {
    // Base query
    $query = "
        SELECT 
            t.id, 
            u.name AS employee_name, 
            t.subject, 
            t.description, 
            t.status, 
            t.priority, 
            c.name AS category_name, 
            u2.name AS assigned_to_name, 
            t.created_at, 
            t.updated_at 
        FROM tickets t
        LEFT JOIN users u ON t.employee_id = u.id
        LEFT JOIN users u2 ON t.assigned_to = u2.id
        LEFT JOIN categories c ON t.category_id = c.id
        WHERE 1=1
    ";

    // Add search condition
    if (!empty($search)) {
        $query .= " AND (
            t.subject LIKE :search OR 
            t.description LIKE :search OR 
            t.status LIKE :search OR 
            t.priority LIKE :search OR 
            c.name LIKE :search OR 
            u.name LIKE :search OR 
            u2.name LIKE :search
        )";
    }

    // Add filter condition
    if (!empty($filterColumn) && !empty($filterValue)) {
        $query .= " AND $filterColumn = :filterValue";
    }

    $stmt = $pdo->prepare($query);

    // Bind parameters
    if (!empty($search)) {
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    }
    if (!empty($filterColumn) && !empty($filterValue)) {
        $stmt->bindParam(':filterValue', $filterValue, PDO::PARAM_STR);
    }

    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($tickets);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}