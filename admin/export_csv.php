<?php
require_once __DIR__ . '/../includes/auth_guard.php';

// Exports filtered inquiries to a properly formatted CSV file.
// Respects the same search + status filters as the inquiries list page.

$search = trim($_GET['search'] ?? '');
$status = $_GET['status'] ?? '';

$allowed_statuses = ['', 'new', 'contacted', 'closed'];
if (!in_array($status, $allowed_statuses, true)) {
    $status = '';
}

try {
    $pdo = require __DIR__ . '/../config/db.php';

    $where  = [];
    $params = [];

    if ($search !== '') {
        $where[]           = '(full_name LIKE :search OR email LIKE :search OR mobile LIKE :search)';
        $params[':search'] = '%' . $search . '%';
    }
    if ($status !== '') {
        $where[]           = 'status = :status';
        $params[':status'] = $status;
    }

    $sql_where = $where ? ' WHERE ' . implode(' AND ', $where) : '';

    $stmt = $pdo->prepare(
        'SELECT id, full_name, email, mobile, city, service, message, status, created_at
         FROM inquiries' . $sql_where . ' ORDER BY created_at DESC'
    );
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log('[CA-Firm CRM] CSV export error: ' . $e->getMessage());
    die('Export failed. Please try again.');
}

// Build a meaningful filename e.g. inquiries_new_2026-04-16.csv
$suffix   = $status ? '_' . $status : '_all';
$filename = 'inquiries' . $suffix . '_' . date('Y-m-d') . '.csv';

// Tell the browser this is a file download
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Add BOM so Excel opens it with correct UTF-8 encoding (important for Indian names)
echo "\xEF\xBB\xBF";

$out = fopen('php://output', 'w');

// Header row
fputcsv($out, ['ID', 'Full Name', 'Email', 'Mobile', 'City', 'Service', 'Message', 'Status', 'Received On']);

foreach ($rows as $row) {
    fputcsv($out, [
        $row['id'],
        $row['full_name'],
        $row['email'],
        $row['mobile'],
        $row['city'],
        $row['service'],
        $row['message'],
        ucfirst($row['status']),
        date('d M Y h:i A', strtotime($row['created_at'])),
    ]);
}

fclose($out);
exit;
