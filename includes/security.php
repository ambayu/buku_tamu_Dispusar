<?php

/**
 * Security Functions - PHP 5.3+ Compatible
 * CSRF Protection, Session Management, Input Validation
 */

// Prevent direct access
if (!defined('SECURE_ACCESS')) {
    die('Direct access not permitted');
}

// Load polyfills for PHP < 5.5
require_once __DIR__ . '/polyfills.php';

/**
 * Initialize secure session - PHP 5.4+ compatible
 */
function initSecureSession()
{
    // Check if session is already started
    $session_started = false;
    if (function_exists('session_status')) {
        $session_started = (session_status() === PHP_SESSION_ACTIVE);
    } else {
        // PHP 5.3 compatibility
        $session_started = isset($_SESSION);
    }

    // Session configuration - MUST be set BEFORE session_start()
    if (!$session_started) {
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);

        // cookie_samesite only available in PHP 7.3+, skip for PHP 5
        if (version_compare(PHP_VERSION, '7.3.0', '>=')) {
            ini_set('session.cookie_samesite', 'Strict');
        }
    }

    // Start session if not already started
    if (!$session_started) {
        session_start();
    }

    // Regenerate session ID on first access or timeout
    if (!isset($_SESSION['initiated'])) {
        session_regenerate_id(true);
        $_SESSION['initiated'] = true;
        $_SESSION['created_at'] = time();
        $_SESSION['last_activity'] = time();
    }

    // Session timeout check (1 hour)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_LIFETIME)) {
        session_unset();
        session_destroy();
        session_start();
        session_regenerate_id(true);
        return false;
    }

    $_SESSION['last_activity'] = time();

    // Regenerate session ID periodically (every 30 minutes)
    if (!isset($_SESSION['created_at'])) {
        $_SESSION['created_at'] = time();
    } else if (time() - $_SESSION['created_at'] > 1800) {
        session_regenerate_id(true);
        $_SESSION['created_at'] = time();
    }

    return true;
}

/**
 * Generate CSRF Token
 * @return string CSRF token
 */
function generateCSRFToken()
{
    if (empty($_SESSION[CSRF_TOKEN_NAME])) {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_NAME];
}

/**
 * Verify CSRF Token
 * @param string $token Token to verify
 * @return bool True if valid, false otherwise
 */
function verifyCSRFToken($token)
{
    if (!isset($_SESSION[CSRF_TOKEN_NAME])) {
        return false;
    }
    return hash_equals($_SESSION[CSRF_TOKEN_NAME], $token);
}

/**
 * Get CSRF Token Input Field (HTML)
 * @return string HTML input field
 */
function getCSRFField()
{
    $token = generateCSRFToken();
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($token, ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Validate CSRF Token from POST
 * @return bool True if valid, false otherwise
 */
function validateCSRF()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
            return false;
        }
    }
    return true;
}

/**
 * Sanitize input string
 * @param string $data Input data
 * @return string Sanitized data
 */
function sanitizeInput($data)
{
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email
 * @param string $email Email to validate
 * @return bool True if valid
 */
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate username (alphanumeric, underscore, 5-20 chars)
 * @param string $username Username to validate
 * @return bool True if valid
 */
function validateUsername($username)
{
    return preg_match('/^[a-zA-Z0-9_]{5,20}$/', $username);
}

/**
 * Validate password strength (min 8 chars)
 * @param string $password Password to validate
 * @return bool True if valid
 */
function validatePassword($password)
{
    return strlen($password) >= 8;
}

/**
 * Hash password securely
 * @param string $password Plain text password
 * @return string Hashed password
 */
function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
}

/**
 * Verify password
 * @param string $password Plain text password
 * @param string $hash Hashed password
 * @return bool True if match
 */
function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

/**
 * Redirect to URL
 * @param string $url URL to redirect to
 */
function redirect($url)
{
    header("Location: $url");
    exit;
}

/**
 * Check if user is logged in
 * @return bool True if logged in
 */
function isLoggedIn()
{
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
}

/**
 * Check if admin is logged in
 * @return bool True if admin logged in
 */
function isAdminLoggedIn()
{
    return isset($_SESSION['adminname']) && !empty($_SESSION['adminname']);
}

/**
 * Require login (redirect if not logged in)
 * @param string $redirectUrl URL to redirect to if not logged in
 */
function requireLogin($redirectUrl = 'index.php')
{
    if (!isLoggedIn()) {
        redirect($redirectUrl);
    }
}

/**
 * Require admin login (redirect if not logged in)
 * @param string $redirectUrl URL to redirect to if not admin
 */
function requireAdminLogin($redirectUrl = 'loginadmin.php')
{
    if (!isAdminLoggedIn()) {
        redirect($redirectUrl);
    }
}

/**
 * Clean output for XSS prevention
 * @param string $data Data to output
 * @return string Clean data
 */
function cleanOutput($data)
{
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Validate integer
 * @param mixed $value Value to validate
 * @return int|false Integer value or false
 */
function validateInt($value)
{
    return filter_var($value, FILTER_VALIDATE_INT);
}

/**
 * Rate limiting check (simple implementation)
 * @param string $identifier User identifier (IP, username, etc)
 * @param int $maxAttempts Maximum attempts allowed
 * @param int $timeWindow Time window in seconds
 * @return bool True if allowed, false if rate limited
 */
function checkRateLimit($identifier, $maxAttempts = 5, $timeWindow = 300)
{
    $key = 'rate_limit_' . md5($identifier);

    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = array(
            'attempts' => 1,
            'first_attempt' => time()
        );
        return true;
    }

    $data = $_SESSION[$key];

    // Reset if time window has passed
    if (time() - $data['first_attempt'] > $timeWindow) {
        $_SESSION[$key] = array(
            'attempts' => 1,
            'first_attempt' => time()
        );
        return true;
    }

    // Check if exceeded max attempts
    if ($data['attempts'] >= $maxAttempts) {
        return false;
    }

    // Increment attempts
    $_SESSION[$key]['attempts']++;
    return true;
}

/**
 * Log security event
 * @param string $message Message to log
 * @param array $context Additional context
 */
function logSecurityEvent($message, $context = array())
{
    $logMessage = date('Y-m-d H:i:s') . " - " . $message;
    if (!empty($context)) {
        $logMessage .= " - Context: " . json_encode($context);
    }
    error_log($logMessage);
}
