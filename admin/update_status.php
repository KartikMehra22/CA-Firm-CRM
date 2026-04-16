<?php
require_once __DIR__ . '/../includes/auth_guard.php';

// handles the inline status change from the inquiries table
// just a quick POST handler — validates, updates, and redirects back

$id     = (int)($_POST['id']     ?? 0);
$status = trim($_POST['status']  ?? '');

// where to send them back (preserve their filters)
$back = $_POST['back'] ?? '/admin/inquiries.php';

$allowed = ['new', 'contacted', 'closed'];

if ($id <= 0 || !in_array($status, $allowed, true)) {
    $_SESSION['flash_type']    = 'error';
    $_SESSION['flash_message'] = 'Invalid request.';
    header('Location: ' . $back);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/inquiries.php');
    exit;
}

try {
    $pdo = require __DIR__ . '/../config/db.php';

    $stmt = $pdo->prepare('UPDATE inquiries SET status = :status WHERE id = :id');
    $stmt->execute([':status' => $status, ':id' => $id]);

    $_SESSION['flash_type']    = 'success';
    $_SESSION['flash_message'] = 'Status updated to "' . ucfirst($status) . '".';

} catch (PDOException $e) {
    error_log('[CA-Firm CRM] Status update error: ' . $e->getMessage());
    $_SESSION['flash_type']    = 'error';
    $_SESSION['flash_message'] = 'Could not update status. Try again.';
}

header('Location: ' . $back);
exit;
