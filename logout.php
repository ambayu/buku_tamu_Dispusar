<?php
require_once __DIR__ . '/includes/init.php';

// Log the logout event
if (isAdminLoggedIn()) {
    logSecurityEvent('Admin logged out', ['username' => $_SESSION['username'] ?? 'unknown']);
} elseif (isLoggedIn()) {
    logSecurityEvent('User logged out', ['username' => $_SESSION['user'] ?? 'unknown']);
}

// Destroy session securely
session_unset();
session_destroy();

// Clear session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Redirect to appropriate page
if (isset($_GET['admin'])) {
    redirect("loginadmin.php");
} else {
    // Redirect to home or login page
    if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'admin') !== false) {
        redirect("loginadmin.php");
    } else {
        redirect("index.php" . (isset($_GET['tempat']) ? "?tempat=" . validateInt($_GET['tempat']) : ""));
    }
}
