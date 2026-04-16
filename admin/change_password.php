<?php
require_once __DIR__ . '/../includes/auth_guard.php';

$page_title = 'Change Password';
$active_nav = '';

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $current  = trim($_POST['current_password']  ?? '');
    $new_pass = trim($_POST['new_password']       ?? '');
    $confirm  = trim($_POST['confirm_password']   ?? '');

    if ($current === '' || $new_pass === '' || $confirm === '') {
        $error = 'All fields are required.';
    } elseif (strlen($new_pass) < 8) {
        $error = 'New password must be at least 8 characters.';
    } elseif ($new_pass !== $confirm) {
        $error = 'New passwords do not match.';
    } else {
        try {
            $pdo = require __DIR__ . '/../config/db.php';

            // Fetch the current hash from DB
            $stmt = $pdo->prepare('SELECT password FROM admins WHERE id = :id LIMIT 1');
            $stmt->execute([':id' => $_SESSION['admin_id']]);
            $admin = $stmt->fetch();

            if (!$admin || !password_verify($current, $admin['password'])) {
                $error = 'Current password is incorrect.';
            } else {
                // Hash the new password and save it
                $new_hash = password_hash($new_pass, PASSWORD_BCRYPT);
                $upd = $pdo->prepare('UPDATE admins SET password = :password WHERE id = :id');
                $upd->execute([':password' => $new_hash, ':id' => $_SESSION['admin_id']]);

                $success = 'Password changed successfully.';
            }

        } catch (PDOException $e) {
            error_log('[CA-Firm CRM] Change password error: ' . $e->getMessage());
            $error = 'Something went wrong. Please try again.';
        }
    }
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="page-header">
  <h1 class="page-title">Change Password</h1>
  <p class="page-subtitle">Update your admin account password.</p>
</div>

<?php if ($error): ?>
<div class="admin-flash admin-flash--error" role="alert">✕ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if ($success): ?>
<div class="admin-flash admin-flash--success" role="alert">✓ <?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<div class="card" style="max-width:520px;">
  <div class="card__header">
    <h2 class="card__title">Update Password</h2>
  </div>
  <div class="card__body">
    <form method="POST" action="/admin/change_password.php" novalidate>
      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label" for="current_password">Current Password <span style="color:#ef5350">*</span></label>
        <input type="password" id="current_password" name="current_password"
               class="form-control" placeholder="Enter current password" required autocomplete="current-password">
      </div>

      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label" for="new_password">New Password <span style="color:#ef5350">*</span></label>
        <input type="password" id="new_password" name="new_password"
               class="form-control" placeholder="Min. 8 characters" required autocomplete="new-password">
      </div>

      <div class="form-group" style="margin-bottom:1rem;">
        <label class="form-label" for="confirm_password">Confirm New Password <span style="color:#ef5350">*</span></label>
        <input type="password" id="confirm_password" name="confirm_password"
               class="form-control" placeholder="Repeat new password" required autocomplete="new-password">
      </div>

      <div class="form-footer">
        <a href="/admin/dashboard.php" class="btn-form btn-form--secondary" style="text-decoration:none;">Cancel</a>
        <button type="submit" class="btn-form btn-form--primary" id="changePassBtn">🔒 Update Password</button>
      </div>
    </form>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
