<?php
require_once __DIR__ . '/../includes/auth_guard.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
  header('Location: /admin/inquiries.php');
  exit;
}

$error = '';
$inquiry = null;

try {
  $pdo = require __DIR__ . '/../config/db.php';

  $stmt = $pdo->prepare(
    'SELECT id, full_name, email, mobile, city, service, message, status, created_at
         FROM inquiries WHERE id = :id LIMIT 1'
  );
  $stmt->execute([':id' => $id]);
  $inquiry = $stmt->fetch();

  if (!$inquiry) {
    $_SESSION['flash_type'] = 'error';
    $_SESSION['flash_message'] = 'Inquiry not found.';
    header('Location: /admin/inquiries.php');
    exit;
  }

} catch (PDOException $e) {
  error_log('[CA-Firm CRM] Edit fetch error: ' . $e->getMessage());
  header('Location: /admin/inquiries.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $full_name = trim($_POST['full_name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $mobile = trim($_POST['mobile'] ?? '');
  $city = trim($_POST['city'] ?? '');
  $service = trim($_POST['service'] ?? '');
  $message = trim($_POST['message'] ?? '');
  $status = trim($_POST['status'] ?? '');

  // Whitelist valid options to avoid random values getting into the DB
  $allowed_statuses = ['new', 'contacted', 'closed'];
  $allowed_services = [
    'Income Tax Filing',
    'GST Registration & Returns',
    'Company Registration',
    'Audit & Assurance',
    'Business Advisory',
    'Tax Planning & Advisory',
    'Other',
  ];

  $errors = [];
  if (mb_strlen($full_name) < 2)
    $errors[] = 'Full name is required.';
  if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors[] = 'Valid email is required.';
  if (!preg_match('/^[6-9]\d{9}$/', $mobile))
    $errors[] = 'Valid 10-digit mobile required.';
  if ($city === '')
    $errors[] = 'City is required.';
  if (!in_array($service, $allowed_services, true))
    $errors[] = 'Select a valid service.';
  if ($message === '')
    $errors[] = 'Message is required.';
  if (!in_array($status, $allowed_statuses, true))
    $errors[] = 'Select a valid status.';

  if (empty($errors)) {
    try {
      $upd = $pdo->prepare(
        'UPDATE inquiries
                 SET full_name = :full_name,
                     email     = :email,
                     mobile    = :mobile,
                     city      = :city,
                     service   = :service,
                     message   = :message,
                     status    = :status
                 WHERE id = :id'
      );
      $upd->execute([
        ':full_name' => $full_name,
        ':email' => $email,
        ':mobile' => $mobile,
        ':city' => $city,
        ':service' => $service,
        ':message' => $message,
        ':status' => $status,
        ':id' => $id,
      ]);

      $_SESSION['flash_type'] = 'success';
      $_SESSION['flash_message'] = 'Inquiry #' . $id . ' updated successfully.';
      header('Location: /admin/inquiries.php');
      exit;

    } catch (PDOException $e) {
      error_log('[CA-Firm CRM] Edit update error: ' . $e->getMessage());
      $error = 'Could not save changes. Please try again.';
    }
  } else {
    $error = implode(' ', $errors);
    // Patch the $inquiry array with what was submitted so the form re-populates
    $inquiry = array_merge($inquiry, compact('full_name', 'email', 'mobile', 'city', 'service', 'message', 'status'));
  }
}

$page_title = 'Edit Inquiry #' . $id;
$active_nav = 'inquiries';
require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="page-header"
  style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:.75rem;">
  <div>
    <h1 class="page-title">Inquiry #<?= $id ?></h1>
    <p class="page-subtitle">
      Received <?= date('d M Y, h:i A', strtotime($inquiry['created_at'])) ?>
      &nbsp;·&nbsp;
      <span class="badge badge--<?= $inquiry['status'] ?>" style="font-size:.8rem;">
        <?= ucfirst($inquiry['status']) ?>
      </span>
    </p>
  </div>
  <a href="/admin/inquiries.php" class="filter-btn filter-btn--ghost" style="text-decoration:none;"><i data-lucide="arrow-left"></i> Back to List</a>
</div>

<?php if ($error): ?>
  <div class="admin-flash admin-flash--error" role="alert"><i data-lucide="alert-circle"></i> <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
  <div class="card__header">
    <h2 class="card__title">Edit Inquiry Details</h2>
  </div>
  <div class="card__body">
    <form method="POST" action="/admin/edit_inquiry.php?id=<?= $id ?>" novalidate>
      <div class="form-grid-2">

        <div class="form-group">
          <label class="form-label" for="edit_full_name">Full Name <span style="color:#ef5350">*</span></label>
          <input type="text" id="edit_full_name" name="full_name" class="form-control"
            value="<?= htmlspecialchars($inquiry['full_name']) ?>" required maxlength="255">
        </div>

        <div class="form-group">
          <label class="form-label" for="edit_email">Email Address <span style="color:#ef5350">*</span></label>
          <input type="email" id="edit_email" name="email" class="form-control"
            value="<?= htmlspecialchars($inquiry['email']) ?>" required maxlength="255">
        </div>

        <div class="form-group">
          <label class="form-label" for="edit_mobile">Mobile Number <span style="color:#ef5350">*</span></label>
          <input type="tel" id="edit_mobile" name="mobile" class="form-control"
            value="<?= htmlspecialchars($inquiry['mobile']) ?>" pattern="[6-9][0-9]{9}" required maxlength="10">
        </div>

        <div class="form-group">
          <label class="form-label" for="edit_city">City <span style="color:#ef5350">*</span></label>
          <input type="text" id="edit_city" name="city" class="form-control"
            value="<?= htmlspecialchars($inquiry['city']) ?>" required maxlength="100">
        </div>

        <div class="form-group">
          <label class="form-label" for="edit_service">Service <span style="color:#ef5350">*</span></label>
          <select id="edit_service" name="service" class="form-control" required>
            <?php
            $services = [
              'Income Tax Filing',
              'GST Registration & Returns',
              'Company Registration',
              'Audit & Assurance',
              'Business Advisory',
              'Tax Planning & Advisory',
              'Other'
            ];
            foreach ($services as $svc):
              ?>
              <option value="<?= htmlspecialchars($svc) ?>" <?= $inquiry['service'] === $svc ? 'selected' : '' ?>>
                <?= htmlspecialchars($svc) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label" for="edit_status">Status <span style="color:#ef5350">*</span></label>
          <select id="edit_status" name="status" class="form-control" required>
            <option value="new" <?= $inquiry['status'] === 'new' ? 'selected' : '' ?>>New</option>
            <option value="contacted" <?= $inquiry['status'] === 'contacted' ? 'selected' : '' ?>>Contacted</option>
            <option value="closed" <?= $inquiry['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
          </select>
        </div>

        <div class="form-group form-group--full">
          <label class="form-label" for="edit_message">Message <span style="color:#ef5350">*</span></label>
          <textarea id="edit_message" name="message" class="form-control" rows="5" required
            maxlength="2000"><?= htmlspecialchars($inquiry['message']) ?></textarea>
        </div>

      </div>

      <div class="form-footer">
        <a href="/admin/delete_inquiry.php?id=<?= $id ?>" class="btn-form btn-form--danger"
          style="text-decoration:none;"><i data-lucide="trash-2"></i> Delete Inquiry</a>
        <a href="/admin/inquiries.php" class="btn-form btn-form--secondary" style="text-decoration:none;">Cancel</a>
        <button type="submit" class="btn-form btn-form--primary" id="saveBtn"><i data-lucide="save"></i> Save Changes</button>
      </div>

    </form>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>