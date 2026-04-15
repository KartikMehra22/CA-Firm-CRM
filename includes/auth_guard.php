<?php
// Simple auth check — if no admin session exists, kick them to the login page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['admin_id'])) {
    $_SESSION['flash_type']    = 'error';
    $_SESSION['flash_message'] = 'Please log in to access the admin panel.';
    header('Location: /admin/login.php');
    exit;
}
