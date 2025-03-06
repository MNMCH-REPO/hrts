<?php
    require_once 'db.php';
    require_once 'session.php';
        
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: 1/employee/ticket.php');
            exit;
        } else {
            //echo a js variable herre called errorMessage
            echo '
            <script>
                errorMessage = "Incorrect Username or Password"
            </script>
            ';
        }
    }