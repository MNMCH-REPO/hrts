<?php
    $stmt = $pdo->prepare("SELECT DISTINCT department FROM users");
    $stmt->execute();
    $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '<script>';
    echo 'const departments = [';
    foreach ($departments as $department) {
        echo '"' . ucwords(strtolower($department['department'])) . '",';
    }
    echo '];';
    echo '</script>';