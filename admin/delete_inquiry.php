<?php
/**
 * admin/delete_inquiry.php
 * Shows a confirmation page, then deletes the inquiry on POST.
 */
require_once __DIR__ . '/../includes/auth_guard.php';

$id = (int)($_GET['id'] ?? 0);

if ($id <= 0) {
    header('Location: /admin/inquiries.php');
    exit;
}

try {
    $pdo = require __DIR__ . '/../config/db.php';

    // Fetch for display in confirmation
    $stmt = $pdo->prepare(
        'SELECT id, full_name, email, service, created_at FROM inquiries WHERE id = :id LIMIT 1'
    );
    $stmt->execute([':id' => $id]);
    $inquiry = $stmt->fetch();

    if (!$inquiry) {
        $_SESSION['flash_type']    = 'error';
        $_SESSION['flash_message'] = 'Inquiry not found.';
        header('Location: /admin/inquiries.php');
        exit;
    }

} catch (PDOException $e) {
    error_log('[CA-Firm CRM] Delete fetch error: ' . $e->getMessage());
    header('Location: /admin/inquiries.php');
    exit;
}

/* ── Handle confirmed delete ──────────────────────────────── */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    try {
        $del = $pdo->prepare('DELETE FROM inquiries WHERE id = :id');
        $del->execute([':id' => $id]);

        $_SESSION['flash_type']    = 'success';
        $_SESSION['flash_message'] = 'Inquiry #' . $id . ' (' . $inquiry['full_name'] . ') has been permanently deleted.';
        header('Location: /admin/inquiries.php');
        exit;

    } catch (PDOException $e) {
        error_log('[CA-Firm CRM] Delete error: ' . $e->getMessage());
        $_SESSION['flash_type']    = 'error';
        $_SESSION['flash_message'] = 'Could not delete the inquiry. Please try again.';
        header('Location: /admin/inquiries.php');
        exit;
    }
}

$page_title = 'Delete Inquiry';
$active_nav = 'inquiries';
require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="confirm-page">
  <div class="confirm-card">
    <div class="confirm-card__icon" aria-hidden="true" role="img">⚠️</div>
    <h1 class="confirm-card__title">Delete Inquiry?</h1>
    <p class="confirm-card__desc">
      You are about to permanently delete the inquiry from<br>
      <strong><?= htmlspecialchars($inquiry['full_name']) ?></strong>
      (<em><?= htmlspecialchars($inquiry['email']) ?></em>)<br>
      regarding <strong><?= htmlspecialchars($inquiry['service']) ?></strong>.<br><br>
      <span style="color:#c62828;font-weight:600;">This action cannot be undone.</span>
    </p>

    <div class="confirm-actions">
      <a href="/admin/inquiries.php" class="btn-form btn-form--secondary" style="text-decoration:none;">
        Cancel
      </a>
      <form method="POST" action="/admin/delete_inquiry.php?id=<?= $id ?>" style="display:inline;">
        <button type="submit" name="confirm_delete" value="1" class="btn-form btn-form--danger" id="confirmDeleteBtn">
          🗑️ Yes, Delete It
        </button>
      </form>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
