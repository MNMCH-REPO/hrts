<?php
try {
    require '../../0/includes/db.php';

    // Initialize status count array
    $statusCounts = [
        'Open' => 0,
        'In Progress' => 0,
        'Resolved' => 0
    ];

    // Fetch counts for each status
    $sql = "SELECT status, COUNT(*) AS count FROM tickets WHERE status IN ('Open', 'In Progress', 'Resolved') GROUP BY status";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Populate the array with actual counts
    foreach ($results as $row) {
        $statusCounts[$row['status']] = $row['count'];
    }

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>