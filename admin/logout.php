<?php
/**
 * admin/logout.php
 * Destroys the admin session and redirects to login.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session data
$_SESSION = [];

// Destroy session cookie
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

session_destroy();

// Set flash on a fresh session for the login page
session_start();
$_SESSION['flash_type']    = 'success';
$_SESSION['flash_message'] = 'You have been signed out successfully.';

header('Location: /admin/login.php');
exit;
