<?php
    $stmt = $pdo->prepare("SELECT id, name FROM users");
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '<script>';
    echo 'const employees = [';
    foreach ($employees as $employee) {
        echo '{ id: ' . $employee['id'] . ', name: "' . ucwords(strtolower($employee['name'])) . '" },';
    }
    echo '];';
    echo '</script>';