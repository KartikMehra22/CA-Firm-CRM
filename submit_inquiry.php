<?php
/**
 * submit_inquiry.php
 * Handles the public inquiry form POST.
 * Validates input server-side, stores via PDO prepared statement.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

/* ── Helpers ──────────────────────────────────────────────── */
function redirect_with_flash(string $url, string $type, string $message): void
{
    $_SESSION['flash_type']    = $type;
    $_SESSION['flash_message'] = $message;
    header('Location: ' . $url);
    exit;
}

function sanitise(string $value): string
{
    return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
}

/* ── Collect & Sanitise Input ─────────────────────────────── */
$full_name = sanitise($_POST['full_name'] ?? '');
$email     = trim($_POST['email'] ?? '');
$mobile    = trim($_POST['mobile'] ?? '');
$city      = sanitise($_POST['city'] ?? '');
$service   = sanitise($_POST['service'] ?? '');
$message   = sanitise($_POST['message'] ?? '');

/* ── Server-side Validation ───────────────────────────────── */
$errors = [];

if ($full_name === '' || mb_strlen($full_name) < 2) {
    $errors[] = 'Full name must be at least 2 characters.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please provide a valid email address.';
}
if (!preg_match('/^[6-9]\d{9}$/', $mobile)) {
    $errors[] = 'Please provide a valid 10-digit Indian mobile number.';
}
if ($city === '') {
    $errors[] = 'City is required.';
}

$allowed_services = [
    'Income Tax Filing',
    'GST Registration & Returns',
    'Company Registration',
    'Audit & Assurance',
    'Business Advisory',
    'Tax Planning & Advisory',
    'Other',
];
if (!in_array($service, $allowed_services, true)) {
    $errors[] = 'Please select a valid service.';
}
if ($message === '' || mb_strlen($message) < 10) {
    $errors[] = 'Message must be at least 10 characters.';
}

if (!empty($errors)) {
    redirect_with_flash('/#contact', 'error', implode(' ', $errors));
}

/* ── Database Insert ──────────────────────────────────────── */
try {
    $pdo = require __DIR__ . '/config/db.php';

    $stmt = $pdo->prepare(
        'INSERT INTO inquiries (full_name, email, mobile, city, service, message, status)
         VALUES (:full_name, :email, :mobile, :city, :service, :message, :status)'
    );
    $stmt->execute([
        ':full_name' => $full_name,
        ':email'     => $email,
        ':mobile'    => $mobile,
        ':city'      => $city,
        ':service'   => $service,
        ':message'   => $message,
        ':status'    => 'new',
    ]);

    redirect_with_flash(
        '/#contact',
        'success',
        '✓ Thank you, ' . htmlspecialchars($full_name) . '! We have received your inquiry and will contact you within 24 hours.'
    );

} catch (PDOException $e) {
    // Log the real error; never expose it to the user
    error_log('[CA-Firm CRM] DB Error: ' . $e->getMessage());
    redirect_with_flash('/#contact', 'error', 'Something went wrong on our end. Please try again or call us directly.');
}
