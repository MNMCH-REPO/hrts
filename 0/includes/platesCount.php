<?php
try {
    require '../../0/includes/db.php';

    // Initialize status count array
    $statusCounts = [
        'Open' => 0,
        'In Progress' => 0,
        'Resolved' => 0
    ];

    // Initialize role count array
    $roleCounts = [
        'HR' => 0,
        'Employee' => 0
    ];

    // Fetch counts for ticket statuses
    $sql = "SELECT status, COUNT(*) AS count FROM tickets WHERE status IN ('Open', 'In Progress', 'Resolved') GROUP BY status";
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Populate the statusCounts array with actual counts
    foreach ($results as $row) {
        $statusCounts[$row['status']] = $row['count'];
    }

    // Fetch counts for roles (HR and Employee)
    $sqlUsers = "SELECT role, COUNT(*) AS count FROM users WHERE role IN ('HR', 'Employee') GROUP BY role";
    $stmtUsers = $pdo->query($sqlUsers);
    $resultsUsers = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

    // Populate the roleCounts array with actual counts
    foreach ($resultsUsers as $row) {
        $roleCounts[$row['role']] = $row['count'];
    }

    // Output JSON-encoded data for debugging in console
    echo "<script>console.log('Status Counts:', " . json_encode($statusCounts) . ");</script>";
    echo "<script>console.log('Role Counts:', " . json_encode($roleCounts) . ");</script>";

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>