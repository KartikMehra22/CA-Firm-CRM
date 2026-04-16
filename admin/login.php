<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Redirect to dashboard if already logged in
if (!empty($_SESSION['admin_id'])) {
  header('Location: /admin/dashboard.php');
  exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $email = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');

  if ($email === '' || $password === '') {
    $error = 'Please enter both email and password.';
  } else {
    try {
      $pdo = require __DIR__ . '/../config/db.php';

      // Look up the admin by email — only need one row
      $stmt = $pdo->prepare(
        'SELECT id, name, email, password FROM admins WHERE email = :email LIMIT 1'
      );
      $stmt->execute([':email' => $email]);
      $admin = $stmt->fetch();

      if ($admin && password_verify($password, $admin['password'])) {
        // Regenerate session ID on login to prevent session fixation attacks
        session_regenerate_id(true);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['admin_email'] = $admin['email'];

        header('Location: /admin/dashboard.php');
        exit;
      } else {
        $error = 'Invalid email or password. Please try again.';
      }

    } catch (PDOException $e) {
      error_log('[CA-Firm CRM] Login error: ' . $e->getMessage());
      $error = 'Something went wrong. Please try again.';
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login — Sharma &amp; Associates CRM</title>
  <link rel="stylesheet" href="/assets/css/admin.css">
  <link rel="icon" type="image/svg+xml"
    href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='6' fill='%231a2e5a'/%3E%3Ctext x='50%25' y='54%25' dominant-baseline='middle' text-anchor='middle' font-size='16' font-weight='700' fill='%23c9a84c' font-family='Georgia,serif'%3ESA%3C/text%3E%3C/svg%3E">
</head>

<body>

  <div class="login-page">
    <div class="login-card">

      <div class="login-logo">
        <div class="login-logo__icon" aria-hidden="true">SA</div>
        <div>
          <p class="login-logo__name">Sharma &amp; Associates</p>
          <p class="login-logo__sub">Admin Panel</p>
        </div>
      </div>

      <h1 class="login-title">Sign In</h1>
      <p class="login-sub">Enter your credentials to access the CRM dashboard.</p>

      <?php if ($error !== ''): ?>
        <div class="admin-flash admin-flash--error" role="alert">
          <i data-lucide="x-circle"></i> <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form class="login-form" method="POST" action="/admin/login.php" novalidate>

        <div class="form-group">
          <label class="form-label" for="login_email">Email Address</label>
          <input type="email" id="login_email" name="email" class="form-control" placeholder="admin@cafirm.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="username" required autofocus>
        </div>

        <div class="form-group">
          <label class="form-label" for="login_password">Password</label>
          <input type="password" id="login_password" name="password" class="form-control" placeholder="••••••••"
            autocomplete="current-password" required>
        </div>

        <button type="submit" class="login-btn" id="loginBtn">
          <i data-lucide="lock"></i> Sign In to Dashboard
        </button>

      </form>

      <p style="margin-top:1.5rem;text-align:center;font-size:.8rem;color:#9aaacb;">
        <a href="/" style="color:#c9a84c;"><i data-lucide="arrow-left"></i> Back to Public Site</a>
      </p>

    </div>
  </div>

  <script src="/assets/js/main.js"></script>
</body>

</html>