<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Wipe everything from the session
$_SESSION = [];

// Also kill the session cookie in the browser
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

session_destroy();

// Start a fresh session just to carry the flash message to the login page
session_start();
$_SESSION['flash_type']    = 'success';
$_SESSION['flash_message'] = 'You have been signed out successfully.';

header('Location: /admin/login.php');
exit;
