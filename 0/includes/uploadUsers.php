<?php
require_once 'db.php'; // Include your database connection file
require '../vendor/autoload.php'; // Include PhpSpreadsheet library

use PhpOffice\PhpSpreadsheet\IOFactory;
header('Content-Type: application/json'); // Ensure the response is JSON


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['excelFile']['tmp_name'];
        $fileName = $_FILES['excelFile']['name'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

        // Validate file type
        $allowedExtensions = ['xls', 'xlsx'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            echo json_encode(['success' => false, 'message' => 'Invalid file type. Only Excel files are allowed.']);
            exit;
        }

        try {
            // Load the Excel file
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            // Validate the header row
            $header = $rows[0];
            $expectedColumns = ['id', 'name', 'email', 'password', 'role', 'department'];
            if (array_diff($expectedColumns, $header)) {
                echo json_encode(['success' => false, 'message' => 'Invalid file format.']);
                exit;
            }

            // Remove the header row
            array_shift($rows);

            $pdo->beginTransaction();

            foreach ($rows as $row) {
                $employeeID = $row[0];
                $employeeName = $row[1];
                $email = $row[2];
                $password = password_hash($row[3], PASSWORD_BCRYPT); // Hash the password
                $role = $row[4];
                $department = $row[5];

                // Insert user into the database
                $sql = "INSERT INTO users (id, name, email, password, role, department, created_at) 
                        VALUES (:employeeID, :employeeName, :email, :password, :role, :department, NOW())";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':employeeID', $employeeID, PDO::PARAM_STR);
                $stmt->bindParam(':employeeName', $employeeName, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
                $stmt->bindParam(':role', $role, PDO::PARAM_STR);
                $stmt->bindParam(':department', $department, PDO::PARAM_STR);
                $stmt->execute();

                // Insert default balances
                // Insert default balances
                $balanceSql1 = "
    INSERT INTO total_balance (user_id, sl, sil, elc, mil, ml, pl, awol, spl, lwop, brl) 
    VALUES (:employeeID, 5, 5, 1, 5, 0, 0, 5, 5, 0, 0)
";
                $balanceStmt1 = $pdo->prepare($balanceSql1);
                $balanceStmt1->bindParam(':employeeID', $employeeID, PDO::PARAM_STR);
                $balanceStmt1->execute();

                $balanceSql2 = "
    INSERT INTO used_balance (user_id, sl, sil, elc, mil, ml, pl, awol, spl, lwop, brl) 
    VALUES (:employeeID, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
";
                $balanceStmt2 = $pdo->prepare($balanceSql2);
                $balanceStmt2->bindParam(':employeeID', $employeeID, PDO::PARAM_STR);
                $balanceStmt2->execute();
            }

            $pdo->commit();
            echo json_encode(['success' => true, 'message' => 'Users uploaded successfully.']);
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Error: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Error processing the file: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded or an error occurred.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
