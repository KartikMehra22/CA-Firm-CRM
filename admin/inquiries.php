<?php
require_once __DIR__ . '/../includes/auth_guard.php';

$page_title = 'All Inquiries';
$active_nav = 'inquiries';

// Read filters from query string
$search  = trim($_GET['search'] ?? '');
$status  = $_GET['status']  ?? '';
$page    = max(1, (int)($_GET['page'] ?? 1));
$per_page = 15;
$offset  = ($page - 1) * $per_page;

// Make sure status is a valid value before using it in a query
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

    // Get total count for pagination
    $count_stmt = $pdo->prepare('SELECT COUNT(*) FROM inquiries' . $sql_where);
    $count_stmt->execute($params);
    $total_rows  = (int)$count_stmt->fetchColumn();
    $total_pages = (int)ceil($total_rows / $per_page);

    // Now get the actual rows for this page
    $params[':limit']  = $per_page;
    $params[':offset'] = $offset;
    $stmt = $pdo->prepare(
        'SELECT id, full_name, email, mobile, city, service, status, created_at
         FROM inquiries'
        . $sql_where
        . ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset'
    );

    // LIMIT and OFFSET must be bound as integers or MySQL complains
    foreach ($params as $key => $val) {
        $type = ($key === ':limit' || $key === ':offset') ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stmt->bindValue($key, $val, $type);
    }
    $stmt->execute();
    $rows = $stmt->fetchAll();

} catch (PDOException $e) {
    error_log('[CA-Firm CRM] Inquiries list error: ' . $e->getMessage());
    $rows        = [];
    $total_rows  = 0;
    $total_pages = 1;
}

// Builds query string for pagination links, keeping existing filters intact
function build_qs(array $overrides = []): string
{
    global $search, $status, $page;
    $base   = array_filter(['search' => $search, 'status' => $status, 'page' => $page]);
    $merged = array_merge($base, $overrides);
    return $merged ? '?' . http_build_query($merged) : '';
}

require_once __DIR__ . '/includes/admin_header.php';
?>

<div class="page-header">
  <h1 class="page-title">All Inquiries</h1>
  <p class="page-subtitle">
    <?= $total_rows ?> <?= $total_rows === 1 ? 'inquiry' : 'inquiries' ?> found
    <?= $status ? '· filtered by <strong>' . htmlspecialchars(ucfirst($status)) . '</strong>' : '' ?>
    <?= $search ? '· searching for <strong>"' . htmlspecialchars($search) . '"</strong>' : '' ?>
  </p>
</div>

<div class="card" style="margin-bottom:1.5rem;">
  <div class="card__body" style="padding:1rem 1.5rem;">
    <form method="GET" action="/admin/inquiries.php" id="filterForm">
      <div class="filters">

        <input
          type="text"
          name="search"
          id="searchInput"
          class="filter-input filter-input--search"
          placeholder="Search name, email, mobile…"
          value="<?= htmlspecialchars($search) ?>"
          autocomplete="off"
        >

        <!-- Status dropdown auto-submits the form on change -->
        <select name="status" id="statusFilter" class="filter-input" onchange="document.getElementById('filterForm').submit()">
          <option value=""          <?= $status === ''          ? 'selected' : '' ?>>All Status</option>
          <option value="new"       <?= $status === 'new'       ? 'selected' : '' ?>>New</option>
          <option value="contacted" <?= $status === 'contacted' ? 'selected' : '' ?>>Contacted</option>
          <option value="closed"    <?= $status === 'closed'    ? 'selected' : '' ?>>Closed</option>
        </select>

        <button type="submit" class="filter-btn filter-btn--primary" id="searchBtn">Search</button>

        <?php if ($search !== '' || $status !== ''): ?>
        <a href="/admin/inquiries.php" class="filter-btn filter-btn--ghost" style="text-decoration:none;text-align:center;">Clear</a>
        <?php endif; ?>

      </div>
    </form>
  </div>
</div>

<div class="card">
  <div class="card__header">
    <h2 class="card__title">Inquiry List</h2>
    <div style="display:flex;align-items:center;gap:.75rem;flex-wrap:wrap;">
      <span style="font-size:.8rem;color:var(--muted);">Showing <?= count($rows) ?> of <?= $total_rows ?></span>
      <a href="/admin/export_csv.php<?= $search || $status ? '?' . http_build_query(array_filter(['search'=>$search,'status'=>$status])) : '' ?>"
         class="filter-btn filter-btn--primary"
         style="text-decoration:none;display:flex;align-items:center;gap:.4rem;"
         title="Download current results as CSV">
        <i data-lucide="download"></i> Export CSV
      </a>
    </div>
  </div>

  <?php if (empty($rows)): ?>
  <div class="empty-state">
    <div class="empty-state__icon"><i data-lucide="search"></i></div>
    <p class="empty-state__title">No matching inquiries</p>
    <p class="empty-state__desc">Try adjusting your search or filter.</p>
  </div>
  <?php else: ?>
  <div class="table-wrap">
    <table class="table" aria-label="Inquiries list">
      <thead>
        <tr>
          <th>#</th>
          <th>Client</th>
          <th>Mobile</th>
          <th>City</th>
          <th>Service</th>
          <th>Status</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
        <tr>
          <td style="color:var(--muted);font-size:.8rem;"><?= (int)$row['id'] ?></td>
          <td>
            <strong style="display:block;"><?= htmlspecialchars($row['full_name']) ?></strong>
            <small style="color:var(--muted)"><?= htmlspecialchars($row['email']) ?></small>
          </td>
          <td style="white-space:nowrap"><?= htmlspecialchars($row['mobile']) ?></td>
          <td><?= htmlspecialchars($row['city']) ?></td>
          <td style="max-width:160px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="<?= htmlspecialchars($row['service']) ?>">
            <?= htmlspecialchars($row['service']) ?>
          </td>
          <td>
            <!-- Inline status change — no need to open the edit page just to update status -->
            <form method="POST" action="/admin/update_status.php" style="margin:0;">
              <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
              <input type="hidden" name="back" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
              <select name="status" class="filter-input" style="padding:.3rem .6rem;font-size:.78rem;cursor:pointer;"
                      onchange="this.form.submit()" title="Change status">
                <option value="new"       <?= $row['status']==='new'       ? 'selected':'' ?>>New</option>
                <option value="contacted" <?= $row['status']==='contacted' ? 'selected':'' ?>>Contacted</option>
                <option value="closed"    <?= $row['status']==='closed'    ? 'selected':'' ?>>Closed</option>
              </select>
            </form>
          </td>
          <td style="white-space:nowrap;font-size:.82rem;color:var(--muted)">
            <?= date('d M Y', strtotime($row['created_at'])) ?><br>
            <small><?= date('h:i A', strtotime($row['created_at'])) ?></small>
          </td>
          <td>
            <div class="action-btns">
              <a href="/admin/edit_inquiry.php?id=<?= (int)$row['id'] ?>"
                 class="btn-icon btn-icon--edit" title="Edit" aria-label="Edit inquiry <?= (int)$row['id'] ?>"><i data-lucide="pencil"></i></a>
              <a href="/admin/delete_inquiry.php?id=<?= (int)$row['id'] ?>"
                 class="btn-icon btn-icon--delete" title="Delete" aria-label="Delete inquiry <?= (int)$row['id'] ?>"><i data-lucide="trash-2"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <?php if ($total_pages > 1): ?>
  <div style="display:flex;justify-content:center;align-items:center;gap:.5rem;padding:1.25rem 1.5rem;border-top:1px solid var(--grey-200);flex-wrap:wrap;">
    <?php if ($page > 1): ?>
    <a href="<?= build_qs(['page' => $page - 1]) ?>" class="filter-btn filter-btn--ghost" style="text-decoration:none;"><i data-lucide="arrow-left"></i> Prev</a>
    <?php endif; ?>

    <?php for ($p = max(1, $page - 2); $p <= min($total_pages, $page + 2); $p++): ?>
    <a href="<?= build_qs(['page' => $p]) ?>"
       class="filter-btn <?= $p === $page ? 'filter-btn--primary' : 'filter-btn--ghost' ?>"
       style="text-decoration:none;min-width:36px;text-align:center;"
       <?= $p === $page ? 'aria-current="page"' : '' ?>>
       <?= $p ?>
    </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
    <a href="<?= build_qs(['page' => $page + 1]) ?>" class="filter-btn filter-btn--ghost" style="text-decoration:none;">Next <i data-lucide="arrow-right"></i></a>
    <?php endif; ?>
  </div>
  <?php endif; ?>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
