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
            $_SESSION['role'] = $user['role']; // Store user role in session
            $_SESSION['name'] = $user['name']; // Store user name in session
            $_SESSION['email'] = $user['email']; // Store user email in session
            $_SESSION['department'] = $user['department']; // Store user department in session



            // Redirect based on role
            if ($user['role'] === 'Employee') {
                header('Location: ../1/employee/ticket.php');
            } elseif ($user['role'] === 'HR') {
                header('Location: ../../1/hrRep/order.php');
            } elseif ($user['role'] === 'Admin') {
                header('Location: ../../1/hrAdmin/dashboard.php');
            
            } else {
                header('Location: ../index.php'); // Default fallback
            }
            exit;
        } else {
            echo '
            <script>
                errorMessage = "Incorrect Username or Password";
            </script>
            ';
        }
    }
