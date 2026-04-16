<?php
/**
 * admin/includes/admin_header.php
 * Admin sidebar + topbar layout shell.
 * Requires: $page_title, $active_nav
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$admin_flash_type    = $_SESSION['flash_type']    ?? null;
$admin_flash_message = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_type'], $_SESSION['flash_message']);

$admin_name  = $_SESSION['admin_name']  ?? 'Admin';
$admin_email = $_SESSION['admin_email'] ?? '';
$initials    = strtoupper(substr($admin_name, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($page_title ?? 'Admin Panel') ?> — Sharma &amp; Associates CRM</title>
  <link rel="stylesheet" href="/assets/css/admin.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='6' fill='%231a2e5a'/%3E%3Ctext x='50%25' y='54%25' dominant-baseline='middle' text-anchor='middle' font-size='16' font-weight='700' fill='%23c9a84c' font-family='Georgia,serif'%3ESA%3C/text%3E%3C/svg%3E">
</head>
<body>

<div class="admin-layout">

  <!-- Mobile overlay -->
  <div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:199;transition:opacity .25s;"
       onclick="this.style.display='none';document.getElementById('adminSidebar').classList.remove('open');"></div>

  <!-- ── Sidebar ──────────────────────────────────────── -->
  <aside class="sidebar" id="adminSidebar" role="navigation" aria-label="Admin navigation">

    <div class="sidebar__brand">
      <div class="sidebar__logo" aria-hidden="true">SA</div>
      <div>
        <p class="sidebar__brand-name">Sharma &amp; Assoc.</p>
        <p class="sidebar__brand-sub">Admin CRM</p>
      </div>
    </div>

    <nav class="sidebar__nav">
      <p class="sidebar__section-label">Main</p>
      <ul>
        <li class="sidebar__item">
          <a href="/admin/dashboard.php"
             class="sidebar__link <?= ($active_nav ?? '') === 'dashboard' ? 'active' : '' ?>">
            <span class="sidebar__icon">📊</span>
            Dashboard
          </a>
        </li>
        <li class="sidebar__item">
          <a href="/admin/inquiries.php"
             class="sidebar__link <?= ($active_nav ?? '') === 'inquiries' ? 'active' : '' ?>">
            <span class="sidebar__icon">📋</span>
            All Inquiries
          </a>
        </li>
      </ul>
      <p class="sidebar__section-label" style="margin-top:1rem;">Quick Filters</p>
      <ul>
        <li class="sidebar__item">
          <a href="/admin/inquiries.php?status=new" class="sidebar__link">
            <span class="sidebar__icon">🆕</span> New Inquiries
          </a>
        </li>
        <li class="sidebar__item">
          <a href="/admin/inquiries.php?status=contacted" class="sidebar__link">
            <span class="sidebar__icon">📞</span> Contacted
          </a>
        </li>
        <li class="sidebar__item">
          <a href="/admin/inquiries.php?status=closed" class="sidebar__link">
            <span class="sidebar__icon">✅</span> Closed
          </a>
        </li>
      </ul>
      <p class="sidebar__section-label" style="margin-top:1rem;">Account</p>
      <ul>
        <li class="sidebar__item">
          <a href="/admin/change_password.php" class="sidebar__link">
            <span class="sidebar__icon">🔒</span> Change Password
          </a>
        </li>
      </ul>
      <p class="sidebar__section-label" style="margin-top:1rem;">Site</p>
      <ul>
        <li class="sidebar__item">
          <a href="/" target="_blank" class="sidebar__link">
            <span class="sidebar__icon">🌐</span> View Public Site
          </a>
        </li>
      </ul>
    </nav>

    <div class="sidebar__footer">
      <div class="sidebar__admin">
        <p class="sidebar__admin-name"><?= htmlspecialchars($admin_name) ?></p>
        <p class="sidebar__admin-role"><?= htmlspecialchars($admin_email) ?></p>
      </div>
      <a href="/admin/logout.php" class="sidebar__logout">
        🚪 Sign Out
      </a>
    </div>

  </aside>

  <!-- ── Main Content ──────────────────────────────────── -->
  <div class="main-content">

    <!-- Topbar -->
    <header class="topbar" role="banner">
      <div class="topbar__left">
        <button class="topbar__toggle" id="sidebarToggle" aria-label="Toggle sidebar" aria-expanded="false">
          <span></span><span></span><span></span>
        </button>
        <nav class="topbar__breadcrumb" aria-label="Breadcrumb">
          <a href="/admin/dashboard.php">Admin</a>
          <span aria-hidden="true"> / </span>
          <span class="topbar__breadcrumb-current"><?= htmlspecialchars($page_title ?? 'Dashboard') ?></span>
        </nav>
      </div>
      <div class="topbar__right">
        <span class="topbar__date" id="topbarDate"></span>
        <div class="topbar__avatar" title="<?= htmlspecialchars($admin_name) ?>"><?= $initials ?></div>
      </div>
    </header>

    <!-- Page content -->
    <main class="page-content" id="mainContent">

      <?php if ($admin_flash_message): ?>
      <div class="admin-flash admin-flash--<?= htmlspecialchars($admin_flash_type) ?>" role="alert">
        <?= $admin_flash_type === 'success' ? '✓' : '✕' ?>
        <?= htmlspecialchars($admin_flash_message) ?>
      </div>
      <?php endif; ?>
