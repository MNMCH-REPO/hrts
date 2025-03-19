<?php
$dsn = 'mysql:host=srv1632.hstgr.io;dbname=u643738716_mnmch_hrts_db;charset=utf8';
$username = 'u643738716_root';
$password = 'MNMCH&db00';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Insert users without specifying 'id', so it auto-increments
$sql = 'INSERT INTO `users` (`name`, `email`, `password`, `role`, `department`, `created_at`) VALUES
("prince", "prince@gmail.com", "$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.", "Employee", "IT Department", NOW()),
("malik", "malik@gmail.com", "$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.", "HR", "Billing Department", NOW()),
("alice", "alice@gmail.com", "$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.", "Employee", "IT Department", NOW()),
("bob", "bob@gmail.com", "$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.", "Employee", "HR Department", NOW()),
("carol", "carol@gmail.com", "$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.", "HR", "Billing Department", NOW()),
("dave", "dave@gmail.com", "$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.", "Employee", "ER Department", NOW()),
("eva", "eva@gmail.com", "$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.", "Employee", "IT Department", NOW()),
("frank", "frank@gmail.com", "$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.", "HR", "HR Department", NOW()),
("grace", "grace@gmail.com", "$2y$10$vEC5lEMMf.nkav7OMpSRGOZ8k719bVtycRuMzBoQFhQfNxFyPkpp.", "Employee", "Billing Department", NOW())';

$stmt = $pdo->prepare($sql);
$stmt->execute();

echo "Users inserted successfully!<br>";



echo "Categories inserted successfully!<br>";

echo "Response inserted successfully!<br>";
?>
