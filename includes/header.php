<?php
// Start session if not already started — needed for flash messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Grab flash message from session and clear it so it only shows once
$flash_type    = $_SESSION['flash_type']    ?? null;
$flash_message = $_SESSION['flash_message'] ?? null;
unset($_SESSION['flash_type'], $_SESSION['flash_message']);

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Sharma & Associates – Trusted CA and Tax Consultancy firm. Expert services in Income Tax, GST, Audit and Business Advisory.">
  <title><?= $page_title ?? 'Sharma &amp; Associates | CA &amp; Tax Consultants' ?></title>
  <!-- Fonts & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='6' fill='%231a2e5a'/%3E%3Ctext x='50%25' y='54%25' dominant-baseline='middle' text-anchor='middle' font-size='16' font-weight='700' fill='%23c9a84c' font-family='Georgia,serif'%3ESA%3C/text%3E%3C/svg%3E">
</head>
<body>

<?php if ($flash_message): ?>
<div class="flash flash--<?= htmlspecialchars($flash_type) ?>" role="alert" id="flashMsg">
  <span class="flash__icon"><?= $flash_type === 'success' ? '✓' : '✕' ?></span>
  <span><?= htmlspecialchars($flash_message) ?></span>
  <button class="flash__close" aria-label="Close">×</button>
</div>
<?php endif; ?>

<nav class="navbar" role="navigation" aria-label="Main navigation">
  <div class="container navbar__inner">
    <a href="/" class="navbar__brand" aria-label="Sharma & Associates — Home">
      <div class="navbar__logo-icon" aria-hidden="true">SA</div>
      <div class="navbar__brand-text">
        <span class="navbar__brand-name">Sharma &amp; Associates</span>
        <span class="navbar__brand-tagline">Chartered Accountants</span>
      </div>
    </a>

    <!-- Nav links — toggle class 'open' via JS for mobile -->
    <ul class="navbar__nav" id="navMenu" role="list">
      <li><a href="/#home"          class="navbar__link">Home</a></li>
      <li><a href="/#services"      class="navbar__link">Services</a></li>
      <li><a href="/#about"         class="navbar__link">About Us</a></li>
      <li><a href="/#testimonials"  class="navbar__link">Testimonials</a></li>
      <li><a href="/#contact"       class="navbar__link navbar__cta">Get Consultation</a></li>
    </ul>

    <!-- Hamburger button for mobile, toggled via main.js -->
    <button class="navbar__toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navMenu">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>
