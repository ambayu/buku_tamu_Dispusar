<?php

/**
 * Database Configuration File - PHP 5.3+ Compatible
 * Menggunakan .env file untuk keamanan credentials
 */

// Load environment variables from .env file
require_once __DIR__ . '/env_loader.php';
loadEnv(__DIR__ . '/../.env');

// Database Buku Tamu
if (!defined('DB_HOST')) define('DB_HOST', env('DB_HOST', 'localhost'));
if (!defined('DB_USER')) define('DB_USER', env('DB_USER', 'root'));
if (!defined('DB_PASS')) define('DB_PASS', env('DB_PASS', ''));
if (!defined('DB_NAME')) define('DB_NAME', env('DB_NAME', 'simc8935_bukutamu'));

// Database SKM
if (!defined('DB_HOST_SKM')) define('DB_HOST_SKM', env('DB_HOST_SKM', 'localhost'));
if (!defined('DB_USER_SKM')) define('DB_USER_SKM', env('DB_USER_SKM', 'root'));
if (!defined('DB_PASS_SKM')) define('DB_PASS_SKM', env('DB_PASS_SKM', ''));
if (!defined('DB_NAME_SKM')) define('DB_NAME_SKM', env('DB_NAME_SKM', 'simc8935_skm'));

// Database Perpustakaan
if (!defined('DB_HOST_PERPUS')) define('DB_HOST_PERPUS', env('DB_HOST_PERPUS', 'localhost'));
if (!defined('DB_USER_PERPUS')) define('DB_USER_PERPUS', env('DB_USER_PERPUS', 'root'));
if (!defined('DB_PASS_PERPUS')) define('DB_PASS_PERPUS', env('DB_PASS_PERPUS', ''));
if (!defined('DB_NAME_PERPUS')) define('DB_NAME_PERPUS', env('DB_NAME_PERPUS', 'simc8935_perpustakaan'));

// Security Settings
if (!defined('CSRF_TOKEN_NAME')) define('CSRF_TOKEN_NAME', env('CSRF_TOKEN_NAME', 'csrf_token'));
if (!defined('SESSION_LIFETIME')) define('SESSION_LIFETIME', env('SESSION_LIFETIME', 3600)); // 1 hour

// Environment
if (!defined('APP_ENV')) define('APP_ENV', env('APP_ENV', 'development'));

// Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', (APP_ENV === 'development') ? 1 : 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../error_log');
