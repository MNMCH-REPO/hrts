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
        $reportType = $_POST['reportType'] ?? 'standard';
    
        if ($reportType === 'standard') {
            generateStandardReportOnServer($pdo, $startDate, $endDate);
            downloadStandardReport($pdo, $startDate, $endDate);
        } elseif ($reportType === 'employee') {
            $employeeName = $_POST['employeeName'] ?? '';
            generateEmployeeReportOnServer($pdo, $startDate, $endDate, $employeeName);
            generateEmployeeReport($pdo, $startDate, $endDate, $employeeName);
        } elseif ($reportType === 'department') {
            $departmentName = $_POST['departmentName'] ?? '';
            generateDepartmentReportOnServer($pdo, $startDate, $endDate, $departmentName);
            generateDepartmentReport($pdo, $startDate, $endDate, $departmentName);
        }
    }

    function generateStandardReportOnServer($pdo, $startDate, $endDate) {
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
    function downloadStandardReport($pdo, $startDate, $endDate) {
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

    function generateEmployeeReport($pdo, $startDate, $endDate, $employeeName) {
        $stmt = $pdo->prepare("
            SELECT 
                t.id AS ticket_id,
                t.subject,
                t.description,
                t.status,
                t.priority,
                u2.name AS assigned_to,
                t.created_at,
                t.start_at,
                t.updated_at
            FROM tickets t
            JOIN users u1 ON t.employee_id = u1.id
            LEFT JOIN users u2 ON t.assigned_to = u2.id
            WHERE u1.name = :employeeName
            AND t.created_at BETWEEN :startDate AND :endDate
            ORDER BY t.created_at ASC
        ");
        $stmt->bindParam(':employeeName', $employeeName);
        $stmt->bindParam(':startDate', $startDate);
        $stmt->bindParam(':endDate', $endDate);
        $stmt->execute();
        $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $priorityCounts = [
            'High' => 0,
            'Medium' => 0,
            'Low' => 0
        ];
        foreach ($tickets as $ticket) {
            $priorityCounts[$ticket['priority']]++;
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
        $sheet->setTitle('Employee Report');
        $sheet->setCellValue('A1', 'Employee Name:');
        $sheet->setCellValue('B1', ucwords(strtolower($employeeName)));
        $sheet->setCellValue('A2', 'Date Range:');
        $sheet->setCellValue('B2', (strtotime($startDate) && strtotime($endDate)) ? date('M d, Y', strtotime($startDate)) . ' - ' . date('M d, Y', strtotime($endDate)) : 'N/A');    
        $sheet->setCellValue('A4', 'Total Tickets:');
        $sheet->setCellValue('B4', count($tickets));
        $sheet->setCellValue('A5', 'High Priority:');
        $sheet->setCellValue('B5', $priorityCounts['High']);
        $sheet->setCellValue('A6', 'Medium Priority:');
        $sheet->setCellValue('B6', $priorityCounts['Medium']);
        $sheet->setCellValue('A7', 'Low Priority:');
        $sheet->setCellValue('B7', $priorityCounts['Low']);
        $header = ['ID', 'Subject', 'Description', 'Status', 'Priority', 'Assigned To', 'Created At', 'Start At', 'Updated At'];
        $sheet->fromArray($header, null, 'A9');
        $sheet->getStyle('A9:I9')->getFont()->setBold(true);
        $sheet->getStyle('A9:I9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFCCCCCC');
        $sheet->getStyle('A9:I9')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $currentRow = 10;
        foreach ($tickets as $ticket) {
            $sheet->setCellValue("A{$currentRow}", $ticket['ticket_id']);
            $sheet->setCellValue("B{$currentRow}", $ticket['subject']);
            $sheet->setCellValue("C{$currentRow}", $ticket['description']);
            $sheet->setCellValue("D{$currentRow}", $ticket['status']);
            $sheet->setCellValue("E{$currentRow}", $ticket['priority']);
            $sheet->setCellValue("F{$currentRow}", ucwords(strtolower($ticket['assigned_to'] ?? 'Unassigned')));
            $sheet->setCellValue("G{$currentRow}", date('M d, Y | h:i A', strtotime($ticket['created_at'])));
            $sheet->setCellValue("H{$currentRow}", $ticket['start_at'] ? date('M d, Y | h:i A', strtotime($ticket['start_at'])) : 'N/A');
            $sheet->setCellValue("I{$currentRow}", $ticket['updated_at'] ? date('M d, Y | h:i A', strtotime($ticket['updated_at'])) : 'N/A');
            $sheet->getStyle("A{$currentRow}:I{$currentRow}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $currentRow++;
        }
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
        $timestamp = date('m-d-y_H-i-s');
        $fileName = "employee_report_{$timestamp}.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');
        ob_clean();
        flush();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

function generateEmployeeReportOnServer($pdo, $startDate, $endDate, $employeeName) {
    $stmt = $pdo->prepare("
        SELECT 
            t.id AS ticket_id,
            t.subject,
            t.description,
            t.status,
            t.priority,
            u2.name AS assigned_to,
            t.created_at,
            t.start_at,
            t.updated_at
        FROM tickets t
        JOIN users u1 ON t.employee_id = u1.id
        LEFT JOIN users u2 ON t.assigned_to = u2.id
        WHERE u1.name = :employeeName
        AND t.created_at BETWEEN :startDate AND :endDate
        ORDER BY t.created_at ASC
    ");
    $stmt->bindParam(':employeeName', $employeeName);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $priorityCounts = [
        'High' => 0,
        'Medium' => 0,
        'Low' => 0
    ];
    foreach ($tickets as $ticket) {
        $priorityCounts[$ticket['priority']]++;
    }
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
    $sheet->setTitle('Employee Report');
    $sheet->setCellValue('A1', 'Employee Name:');
    $sheet->setCellValue('B1', ucwords(strtolower($employeeName)));
    $sheet->setCellValue('A2', 'Date Range:');
    $sheet->setCellValue('B2', (strtotime($startDate) && strtotime($endDate)) ? date('M d, Y', strtotime($startDate)) . ' - ' . date('M d, Y', strtotime($endDate)) : 'N/A');
    $sheet->setCellValue('A4', 'Total Tickets:');
    $sheet->setCellValue('B4', count($tickets));
    $sheet->setCellValue('A5', 'High Priority:');
    $sheet->setCellValue('B5', $priorityCounts['High']);
    $sheet->setCellValue('A6', 'Medium Priority:');
    $sheet->setCellValue('B6', $priorityCounts['Medium']);
    $sheet->setCellValue('A7', 'Low Priority:');
    $sheet->setCellValue('B7', $priorityCounts['Low']);
    $header = ['ID', 'Subject', 'Description', 'Status', 'Priority', 'Assigned To', 'Created At', 'Start At', 'Updated At'];
    $sheet->fromArray($header, null, 'A9');
    $sheet->getStyle('A9:I9')->getFont()->setBold(true);
    $sheet->getStyle('A9:I9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFCCCCCC');
    $sheet->getStyle('A9:I9')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $currentRow = 10;
    foreach ($tickets as $ticket) {
        $sheet->setCellValue("A{$currentRow}", $ticket['ticket_id']);
        $sheet->setCellValue("B{$currentRow}", $ticket['subject']);
        $sheet->setCellValue("C{$currentRow}", $ticket['description']);
        $sheet->setCellValue("D{$currentRow}", $ticket['status']);
        $sheet->setCellValue("E{$currentRow}", $ticket['priority']);
        $sheet->setCellValue("F{$currentRow}", ucwords(strtolower($ticket['assigned_to'] ?? 'Unassigned')));
        $sheet->setCellValue("G{$currentRow}", date('M d, Y | h:i A', strtotime($ticket['created_at'])));
        $sheet->setCellValue("H{$currentRow}", $ticket['start_at'] ? date('M d, Y | h:i A', strtotime($ticket['start_at'])) : 'N/A');
        $sheet->setCellValue("I{$currentRow}", $ticket['updated_at'] ? date('M d, Y | h:i A', strtotime($ticket['updated_at'])) : 'N/A');
        $sheet->getStyle("A{$currentRow}:I{$currentRow}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $currentRow++;
    }
    foreach (range('A', 'I') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
        $timestamp = date('m-d-y_H-i-s');
        $fileName = "employee_report_{$timestamp}.xlsx";
        $filePath = "../../assets/reports/{$fileName}";
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
        return $filePath;
    }
}

function generateDepartmentReport($pdo, $startDate, $endDate, $departmentName) {
    $stmt = $pdo->prepare("
        SELECT 
            t.id AS ticket_id,
            u.name AS employee_name,
            t.subject,
            t.description,
            t.priority,
            u2.name AS assigned_to,
            t.created_at,
            t.start_at,
            t.updated_at
        FROM tickets t
        JOIN users u ON t.employee_id = u.id
        LEFT JOIN users u2 ON t.assigned_to = u2.id
        WHERE u.department = :departmentName
        AND t.created_at BETWEEN :startDate AND :endDate
        ORDER BY t.created_at ASC
    ");
    $stmt->bindParam(':departmentName', $departmentName);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $priorityCounts = [
        'High' => 0,
        'Medium' => 0,
        'Low' => 0
    ];
    $userTicketCounts = [];
    foreach ($tickets as $ticket) {
        $priorityCounts[$ticket['priority']]++;
        $userTicketCounts[$ticket['employee_name']] = ($userTicketCounts[$ticket['employee_name']] ?? 0) + 1;
    }
    $userWithMostTickets = !empty($userTicketCounts) ? array_search(max($userTicketCounts), $userTicketCounts) : 'N/A';
    $userWithLeastTickets = !empty($userTicketCounts) ? array_search(min($userTicketCounts), $userTicketCounts) : 'N/A';
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
    $sheet->setTitle('Department Report');
    $sheet->setCellValue('A1', 'Department Name:');
    $sheet->setCellValue('B1', ucwords(strtolower($departmentName)));
    $sheet->setCellValue('A2', 'Date Range:');
    $sheet->setCellValue('B2', (strtotime($startDate) && strtotime($endDate)) ? date('M d, Y', strtotime($startDate)) . ' - ' . date('M d, Y', strtotime($endDate)) : 'N/A');
    $sheet->setCellValue('A4', 'Total Tickets:');
    $sheet->setCellValue('B4', count($tickets));
    $sheet->setCellValue('A5', 'High Priority:');
    $sheet->setCellValue('B5', $priorityCounts['High']);
    $sheet->setCellValue('A6', 'Medium Priority:');
    $sheet->setCellValue('B6', $priorityCounts['Medium']);
    $sheet->setCellValue('A7', 'Low Priority:');
    $sheet->setCellValue('B7', $priorityCounts['Low']);
    $sheet->setCellValue('A8', 'User with Most Tickets:');
    $sheet->setCellValue('B8', $userWithMostTickets);
    $sheet->setCellValue('A9', 'User with Least Tickets:');
    $sheet->setCellValue('B9', $userWithLeastTickets);
    $header = ['ID', 'Employee Name', 'Subject', 'Description', 'Priority', 'Assigned To', 'Created At', 'Start At', 'Updated At'];
    $sheet->fromArray($header, null, 'A11');
    $sheet->getStyle('A11:I11')->getFont()->setBold(true);
    $sheet->getStyle('A11:I11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFCCCCCC');
    $sheet->getStyle('A11:I11')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $currentRow = 12;
    foreach ($tickets as $ticket) {
        $sheet->setCellValue("A{$currentRow}", $ticket['ticket_id']);
        $sheet->setCellValue("B{$currentRow}", ucwords(strtolower($ticket['employee_name'])));
        $sheet->setCellValue("C{$currentRow}", $ticket['subject']);
        $sheet->setCellValue("D{$currentRow}", $ticket['description']);
        $sheet->setCellValue("E{$currentRow}", $ticket['priority']);
        $sheet->setCellValue("F{$currentRow}", ucwords(strtolower($ticket['assigned_to'] ?? 'Unassigned')));
        $sheet->setCellValue("G{$currentRow}", date('M d, Y | h:i A', strtotime($ticket['created_at'])));
        $sheet->setCellValue("H{$currentRow}", $ticket['start_at'] ? date('M d, Y | h:i A', strtotime($ticket['start_at'])) : 'N/A');
        $sheet->setCellValue("I{$currentRow}", $ticket['updated_at'] ? date('M d, Y | h:i A', strtotime($ticket['updated_at'])) : 'N/A');
        $sheet->getStyle("A{$currentRow}:I{$currentRow}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $currentRow++;
    }
    foreach (range('A', 'I') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }
    $timestamp = date('m-d-y_H-i-s');
    $fileName = "department_report_{$timestamp}.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    ob_clean();
    flush();
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;
}
    
function generateDepartmentReportOnServer($pdo, $startDate, $endDate, $departmentName) {
    $stmt = $pdo->prepare("
        SELECT 
            t.id AS ticket_id,
            u.name AS employee_name,
            t.subject,
            t.description,
            t.priority,
            u2.name AS assigned_to,
            t.created_at,
            t.start_at,
            t.updated_at
        FROM tickets t
        JOIN users u ON t.employee_id = u.id
        LEFT JOIN users u2 ON t.assigned_to = u2.id
        WHERE u.department = :departmentName
        AND t.created_at BETWEEN :startDate AND :endDate
        ORDER BY t.created_at ASC
    ");
    $stmt->bindParam(':departmentName', $departmentName);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    $stmt->execute();
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $priorityCounts = [
        'High' => 0,
        'Medium' => 0,
        'Low' => 0
    ];
    $userTicketCounts = [];
    foreach ($tickets as $ticket) {
        $priorityCounts[$ticket['priority']]++;
        $userTicketCounts[$ticket['employee_name']] = ($userTicketCounts[$ticket['employee_name']] ?? 0) + 1;
    }
    $userWithMostTickets = !empty($userTicketCounts) ? array_search(max($userTicketCounts), $userTicketCounts) : 'N/A';
    $userWithLeastTickets = !empty($userTicketCounts) ? array_search(min($userTicketCounts), $userTicketCounts) : 'N/A';
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
    $sheet->setTitle('Department Report');
    $sheet->setCellValue('A1', 'Department Name:');
    $sheet->setCellValue('B1', ucwords(strtolower($departmentName)));
    $sheet->setCellValue('A2', 'Date Range:');
    $sheet->setCellValue('B2', (strtotime($startDate) && strtotime($endDate)) ? date('M d, Y', strtotime($startDate)) . ' - ' . date('M d, Y', strtotime($endDate)) : 'N/A');
    $sheet->setCellValue('A4', 'Total Tickets:');
    $sheet->setCellValue('B4', count($tickets));
    $sheet->setCellValue('A5', 'High Priority:');
    $sheet->setCellValue('B5', $priorityCounts['High']);
    $sheet->setCellValue('A6', 'Medium Priority:');
    $sheet->setCellValue('B6', $priorityCounts['Medium']);
    $sheet->setCellValue('A7', 'Low Priority:');
    $sheet->setCellValue('B7', $priorityCounts['Low']);
    $sheet->setCellValue('A8', 'User with Most Tickets:');
    $sheet->setCellValue('B8', $userWithMostTickets);
    $sheet->setCellValue('A9', 'User with Least Tickets:');
    $sheet->setCellValue('B9', $userWithLeastTickets);
    $header = ['ID', 'Employee Name', 'Subject', 'Description', 'Priority', 'Assigned To', 'Created At', 'Start At', 'Updated At'];
    $sheet->fromArray($header, null, 'A11');
    $sheet->getStyle('A11:I11')->getFont()->setBold(true);
    $sheet->getStyle('A11:I11')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('FFCCCCCC');
    $sheet->getStyle('A11:I11')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $currentRow = 12;
    foreach ($tickets as $ticket) {
        $sheet->setCellValue("A{$currentRow}", $ticket['ticket_id']);
        $sheet->setCellValue("B{$currentRow}", ucwords(strtolower($ticket['employee_name'])));
        $sheet->setCellValue("C{$currentRow}", $ticket['subject']);
        $sheet->setCellValue("D{$currentRow}", $ticket['description']);
        $sheet->setCellValue("E{$currentRow}", $ticket['priority']);
        $sheet->setCellValue("F{$currentRow}", ucwords(strtolower($ticket['assigned_to'] ?? 'Unassigned')));
        $sheet->setCellValue("G{$currentRow}", date('M d, Y | h:i A', strtotime($ticket['created_at'])));
        $sheet->setCellValue("H{$currentRow}", $ticket['start_at'] ? date('M d, Y | h:i A', strtotime($ticket['start_at'])) : 'N/A');
        $sheet->setCellValue("I{$currentRow}", $ticket['updated_at'] ? date('M d, Y | h:i A', strtotime($ticket['updated_at'])) : 'N/A');
        $sheet->getStyle("A{$currentRow}:I{$currentRow}")->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $currentRow++;
    }
    foreach (range('A', 'I') as $column) {
        $sheet->getColumnDimension($column)->setAutoSize(true);
    }
    $timestamp = date('m-d-y_H-i-s');
    $fileName = "department_report_{$timestamp}.xlsx";
    $filePath = "../../assets/reports/{$fileName}";
    $writer = new Xlsx($spreadsheet);
    $writer->save($filePath);
    return $filePath;
}