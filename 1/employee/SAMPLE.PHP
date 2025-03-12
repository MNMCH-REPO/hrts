<?php
session_start(); // Start session to access user ID

require '../../0/includes/db.php'; // Include database connection (using PDO)

require '../../0/includes/accessControl.php'; // Include session functions

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../0/includes/index.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user ID

try {
    // Prepare and execute query using PDO
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If user not found, redirect
    if (!$user) {
        header('Location: ../../0/includes/index.php');
        exit();
    }
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>smaple convo</title>
</head>

<body>

    <h1>This is a smaple conversation</h1>



    <?php

    // Check if the user is an employee
    if ($user['role'] === 'Employee') {
        echo '<p>Welcome, </p>' . $user['role'] ;
        echo $users_id;
        echo $user['role'];
    } else {
        echo '<p>Access denied. You are not an employee.</p>';
    }


    ?>










</body>

</html>