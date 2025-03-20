<?php
$servername = 'srv1632.hstgr.io';  // Host
$username = 'u643738716_root';     // Username
$password = 'MNMCH&db00';          // Password
$database = 'u643738716_mnmch_hrts_db';  // Database name

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("SET FOREIGN_KEY_CHECKS = 0;");

// Your INSERT query
$sql = "INSERT INTO `tickets` (`employee_id`, `subject`, `description`, `status`, `priority`, `category_id`, `assigned_to`, `created_at`, `updated_at`) VALUES 
(1, 'Issue with IT support', 'The employee cannot access their work computer.', 'Open', 'High', 1, NULL, '2025-03-12 04:00:00', '2025-03-12 04:00:00'),
(2, 'HR issue regarding leaves', 'The employee has trouble applying for leaves.', 'Open', 'Medium', 2, 3, '2025-03-12 04:05:00', '2025-03-20 01:50:19'),
(3, 'Billing discrepancy', 'There is a mismatch in the billing statement for last month.', 'Open', 'High', 3, NULL, '2025-03-12 04:10:00', '2025-03-12 04:10:00'),
(4, 'Employee Relations concern', 'The employee raised an issue with a colleague.', 'Open', 'Medium', 4, NULL, '2025-03-12 04:15:00', '2025-03-12 04:15:00'),
(5, 'Technical issue with the software', 'The employee is unable to run the latest software update.', 'Open', 'High', 5, NULL, '2025-03-12 04:20:00', '2025-03-12 04:20:00'),
(6, 'Payroll error', 'The payroll for last month was incorrect.', 'Open', 'High', 6, NULL, '2025-03-12 04:25:00', '2025-03-12 04:25:00'),
(7, 'Leave Management problem', 'The employee cannot view their leave balance correctly.', 'Open', 'Low', 7, NULL, '2025-03-12 04:30:00', '2025-03-12 04:30:00'),
(8, 'Office Equipment malfunction', 'The printer is not working in the office.', 'Open', 'Low', 8, NULL, '2025-03-12 04:35:00', '2025-03-12 04:35:00'),
(9, 'Training request', 'The employee needs a training session on new software.', 'Open', 'Medium', 9, NULL, '2025-03-12 04:40:00', '2025-03-12 04:40:00'),
(10, 'Health and Safety concern', 'There is a potential safety issue in the office building.', 'Open', 'High', 10, NULL, '2025-03-12 04:45:00', '2025-03-12 04:45:00');";

$conn->query($sql);

$conn->query("SET FOREIGN_KEY_CHECKS = 1;");

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "New records inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the connection
$conn->close();
?>
