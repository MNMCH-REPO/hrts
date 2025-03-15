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
// if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
//     die("Invalid ticket ID.");
// }

// $sql = 'SELECT id FROM tickets';
// $stmt = $pdo->prepare($sql);
// $stmt->execute();
// $ticket = $stmt->fetch();
// $count = $ticket['id'];
// echo $count;


$sql =  'INSERT INTO ticket_responses (ticket_id, user_id, response_text, created_at) 
        VALUES (:ticket_id, :user_id, :response_text, NOW())';

$ticket_id = 5;
$user_id = 2;
$response_text = "heloo";

$stmt = $pdo->prepare($sql);
$stmt->execute(params: [
    'ticket_id' => 5,
    'user_id' => 2,
    'response_text' => "heloo"
]);

echo "Response inserted successfully!";




// $sql = 'insert into categories (name) values (:name)';
// $name = 'Paycheck';
// $stmt = $pdo->prepare($sql);
// $stmt->execute(['name' => $name]);


//  $sql = 'INSERT INTO tickets (employee_id, subject, description, status, priority, category_id, assigned_to, created_at, updated_at) 
//      VALUES (:employee_id, :subject, :description, :status, :priority, :category_id, :assigned_to, NOW(), NOW())';

//  $employee_id = 2;
//  $subject = "System Issue";
//  $description = "The system is experiencing slow performance.";
//  $status = "Open";
//  $priority = "Low";
//  $category_id = 1;  
//  $assigned_to = 3;

//  $stmt = $pdo->prepare(query: $sql);
//  $stmt->execute(params: [
//      'employee_id' => $employee_id,
//      'subject' => $subject,
//      'description' => $description,
//      'status' => $status,
//      'priority' => $priority,
//      'category_id' => $category_id,
//      'assigned_to' => $assigned_to
//  ]);





// #if successful, redirect to login page(
// if ($stmt->rowCount() > 0) {
//     echo  "Ticket inserted successfully!";
// }
// #if not, echo error message
// else {
//     echo 'Error inserting user';
// }
// header('Location: 1/employee/SAMPLE.php');
