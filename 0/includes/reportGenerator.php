<?php
    
    require '../../0/vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    // if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['downloadReport'])) {
    //     $startDate = $_POST['startDate'] ?? date('Y-m-d');
    //     $endDate = $_POST['endDate'] ?? date('Y-m-d');
    //     $filePath = generateStandardReport($pdo, $startDate, $endDate);
    //     if (file_exists($filePath)) {
    //         header('Content-Description: File Transfer');
    //         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //         header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    //         header('Expires: 0');
    //         header('Cache-Control: must-revalidate');
    //         header('Pragma: public');
    //         header('Content-Length: ' . filesize($filePath));
    //         ob_clean();
    //         flush();
    //         readfile($filePath);
    //     }
    // }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['downloadReport'])) {
        $startDate = $_POST['startDate'] ?? date('Y-m-d');
        $endDate = $_POST['endDate'] ?? date('Y-m-d');
        generateAndDownloadReport($pdo, $startDate, $endDate);
    }

    function generateStandardReport($pdo, $startDate, $endDate) {
        $stmt = $pdo->prepare("
        SELECT 
            u.department,
            u.name AS user_name,
            t.id AS ticket_id,
            t.subject,
            c.name AS category,
            t.description,
            t.assigned_to,
            t.created_at,
            t.updated_at
        FROM tickets t
        JOIN users u ON t.employee_id = u.id
        JOIN categories c ON t.category_id = c.id
        WHERE t.created_at BETWEEN :startDate AND :endDate
        ORDER BY u.department, u.name
    ");
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Standard Report');
    $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
    $header = ['Users', 'Ticket ID', 'Subject', 'Category', 'Description', 'Assigned To', 'Created At', 'Updated At'];
    $currentRow = 1;
    $currentDepartment = null;
    foreach ($tickets as $ticket) {
        if ($currentDepartment !== $ticket['department']) {
            if ($currentDepartment !== null) {
                $currentRow++;
            }
            $sheet->setCellValue("A{$currentRow}", ucwords(strtolower($ticket['department'])));
            $sheet->getStyle("A{$currentRow}")->getFont()->setBold(true);
            $currentRow++;
            $sheet->fromArray($header, null, "A{$currentRow}");
            $sheet->getStyle("A{$currentRow}:H{$currentRow}")->getFont()->setBold(true);
            $currentRow++;
            $currentDepartment = $ticket['department'];
        }
        $sheet->setCellValue("A{$currentRow}", ucwords(strtolower($ticket['user_name'])));
        $sheet->setCellValue("B{$currentRow}", $ticket['ticket_id']);
        $sheet->setCellValue("C{$currentRow}", ucwords(strtolower($ticket['subject'])));
        $sheet->setCellValue("D{$currentRow}", ucwords(strtolower($ticket['category'])));
        $sheet->setCellValue("E{$currentRow}", $ticket['description']);
        $sheet->setCellValue("F{$currentRow}", $ticket['assigned_to']);
        $sheet->setCellValue("G{$currentRow}", $ticket['created_at']);
        $sheet->setCellValue("H{$currentRow}", $ticket['updated_at']);
        $currentRow++;
    }
    foreach (range('A', 'H') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }
    $timestamp = date('m-d-y_H-i-s');
    $fileName = "report_{$timestamp}.xlsx";
    $filePath = "../../assets/reports/{$fileName}";
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);
    return $filePath;
    }
    function generateAndDownloadReport($pdo, $startDate, $endDate) {
        $stmt = $pdo->prepare("
            SELECT 
                u.department,
                u.name AS user_name,
                t.id AS ticket_id,
                t.subject,
                c.name AS category,
                t.description,
                t.assigned_to,
                t.created_at,
                t.updated_at
            FROM tickets t
            JOIN users u ON t.employee_id = u.id
            JOIN categories c ON t.category_id = c.id
            WHERE t.created_at BETWEEN :startDate AND :endDate
            ORDER BY u.department, u.name
        ");
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Standard Report');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
    
        $header = ['Users', 'Ticket ID', 'Subject', 'Category', 'Description', 'Assigned To', 'Created At', 'Updated At'];
        $currentRow = 1;
        $currentDepartment = null;
    
        foreach ($tickets as $ticket) {
            if ($currentDepartment !== $ticket['department']) {
                if ($currentDepartment !== null) {
                    $currentRow++;
                }
                $sheet->setCellValue("A{$currentRow}", ucwords(strtolower($ticket['department'])));
                $sheet->getStyle("A{$currentRow}")->getFont()->setBold(true);
                $currentRow++;
                $sheet->fromArray($header, null, "A{$currentRow}");
                $sheet->getStyle("A{$currentRow}:H{$currentRow}")->getFont()->setBold(true);
                $currentRow++;
                $currentDepartment = $ticket['department'];
            }
            $sheet->setCellValue("A{$currentRow}", ucwords(strtolower($ticket['user_name'])));
            $sheet->setCellValue("B{$currentRow}", $ticket['ticket_id']);
            $sheet->setCellValue("C{$currentRow}", ucwords(strtolower($ticket['subject'])));
            $sheet->setCellValue("D{$currentRow}", ucwords(strtolower($ticket['category'])));
            $sheet->setCellValue("E{$currentRow}", $ticket['description']);
            $sheet->setCellValue("F{$currentRow}", $ticket['assigned_to']);
            $sheet->setCellValue("G{$currentRow}", $ticket['created_at']);
            $sheet->setCellValue("H{$currentRow}", $ticket['updated_at']);
            $currentRow++;
        }
    
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        $timestamp = date('m-d-y-His');
        $fileName = "report_{$timestamp}.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        ob_clean();
        flush();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }