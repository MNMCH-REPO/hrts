<?php
    function getRelativePath() {
        $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $slashCount = substr_count($urlPath, '/');
        return str_repeat('../', $slashCount - 1);
    }

    $userId = $_SESSION['user_id'];
    $sql = 'SELECT * FROM users WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $userId]);
    $user = $stmt->fetch();
    if (!in_array($user['role'], ['Employee', 'HR', 'Admin', 'SuperAdmin'])) {

        unset($_SESSION['user_id']);
        session_destroy();
        header('Location: ' . getRelativePath() . 'index.php');
        exit;
    }