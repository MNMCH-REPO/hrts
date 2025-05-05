<?php
require_once 'db.php';

$leaveId = $_GET['leave_id'] ?? null;

if (!$leaveId || !is_numeric($leaveId)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid leave ID']);
    exit;
}

$stmt = $pdo->prepare("SELECT file_path FROM leave_attachments WHERE leave_request_id = :leaveId");
$stmt->execute(['leaveId' => $leaveId]);
$attachment = $stmt->fetch();

if ($attachment) {
    echo json_encode(['status' => 'success', 'path' => $attachment['file_path']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No attachment found.']);
}

