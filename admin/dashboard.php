<?php
require_once __DIR__ . '/../includes/auth_guard.php';

$page_title = 'Dashboard';
$active_nav = 'dashboard';

try {
    $pdo = require __DIR__ . '/../config/db.php';

    // Pull all counts in one query rather than running 4 separate ones
    $stmt = $pdo->query(
        "SELECT
            COUNT(*)                      AS total,
            SUM(status = 'new')           AS new_count,
            SUM(status = 'contacted')     AS contacted_count,
            SUM(status = 'closed')        AS closed_count
         FROM inquiries"
    );
    $stats = $stmt->fetch();

    // Just the 5 most recent for the quick-view table
    $recent_stmt = $pdo->query(
        "SELECT id, full_name, email, mobile, city, service, status, created_at
         FROM inquiries
         ORDER BY created_at DESC
         LIMIT 5"
    );
    $recent = $recent_stmt->fetchAll();

} catch (PDOException $e) {
    error_log('[CA-Firm CRM] Dashboard error: ' . $e->getMessage());
    $stats  = ['total' => 0, 'new_count' => 0, 'contacted_count' => 0, 'closed_count' => 0];
    $recent = [];
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="page-header">
  <h1 class="page-title">Dashboard</h1>
  <p class="page-subtitle">Overview of all client inquiries — <?= date('l, d F Y') ?></p>
</div>

<div class="stats-grid">

  <div class="stat-card stat-card--total" role="region" aria-label="Total inquiries">
    <div class="stat-card__icon" aria-hidden="true">📋</div>
    <div>
      <p class="stat-card__num"><?= (int)$stats['total'] ?></p>
      <p class="stat-card__label">Total Inquiries</p>
    </div>
  </div>

  <div class="stat-card stat-card--new" role="region" aria-label="New inquiries">
    <div class="stat-card__icon" aria-hidden="true">🆕</div>
    <div>
      <p class="stat-card__num"><?= (int)$stats['new_count'] ?></p>
      <p class="stat-card__label">New</p>
    </div>
  </div>

  <div class="stat-card stat-card--contacted" role="region" aria-label="Contacted inquiries">
    <div class="stat-card__icon" aria-hidden="true">📞</div>
    <div>
      <p class="stat-card__num"><?= (int)$stats['contacted_count'] ?></p>
      <p class="stat-card__label">Contacted</p>
    </div>
  </div>

  <div class="stat-card stat-card--closed" role="region" aria-label="Closed inquiries">
    <div class="stat-card__icon" aria-hidden="true">✅</div>
    <div>
      <p class="stat-card__num"><?= (int)$stats['closed_count'] ?></p>
      <p class="stat-card__label">Closed</p>
    </div>
  </div>

</div>

<div class="card">
  <div class="card__header">
    <h2 class="card__title">Recent Inquiries</h2>
    <a href="/admin/inquiries.php" class="filter-btn filter-btn--primary" style="text-decoration:none;">View All →</a>
  </div>

  <?php if (empty($recent)): ?>
  <div class="empty-state">
    <div class="empty-state__icon">📭</div>
    <p class="empty-state__title">No inquiries yet</p>
    <p class="empty-state__desc">Once clients submit the contact form, inquiries will appear here.</p>
  </div>
  <?php else: ?>
  <div class="table-wrap">
    <table class="table" aria-label="Recent inquiries">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Service</th>
          <th>City</th>
          <th>Status</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($recent as $row): ?>
        <tr>
          <td style="color:var(--muted);font-size:.8rem;">#<?= (int)$row['id'] ?></td>
          <td>
            <strong><?= htmlspecialchars($row['full_name']) ?></strong><br>
            <small style="color:var(--muted)"><?= htmlspecialchars($row['email']) ?></small>
          </td>
          <td><?= htmlspecialchars($row['service']) ?></td>
          <td><?= htmlspecialchars($row['city']) ?></td>
          <td>
            <span class="badge badge--<?= $row['status'] ?>">
              <?= ucfirst($row['status']) ?>
            </span>
          </td>
          <td style="color:var(--muted);white-space:nowrap;font-size:.82rem;">
            <?= date('d M Y', strtotime($row['created_at'])) ?>
          </td>
          <td>
            <div class="action-btns">
              <a href="/admin/edit_inquiry.php?id=<?= (int)$row['id'] ?>" class="btn-icon btn-icon--edit" title="Edit" aria-label="Edit inquiry <?= (int)$row['id'] ?>">✏️</a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
