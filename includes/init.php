<?php

/**
 * Initialize file - Load all required configurations and includes
 * PHP 5.3+ Compatible
 */

// Define secure access constant
define('SECURE_ACCESS', true);

// Start output buffering
ob_start();

// Set timezone
date_default_timezone_set("Asia/Jakarta");

// Load configuration (in parent directory)
require_once dirname(__DIR__) . '/config/config.php';

// Load database class
require_once dirname(__DIR__) . '/config/database.php';

// Load security functions
require_once __DIR__ . '/security.php';

// Initialize secure session
initSecureSession();

// Initialize database connections
try {
    $db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $koneksi = $db->getConnection();
} catch (Exception $e) {
    error_log("Failed to initialize bukutamu database: " . $e->getMessage());
    die("Koneksi database gagal.");
}

try {
    $db1 = new Database(DB_HOST_SKM, DB_USER_SKM, DB_PASS_SKM, DB_NAME_SKM);
    $koneksi1 = $db1->getConnection();
} catch (Exception $e) {
    error_log("Failed to initialize SKM database: " . $e->getMessage());
    die("Koneksi database gagal.");
}

try {
    $db2 = new Database(DB_HOST_PERPUS, DB_USER_PERPUS, DB_PASS_PERPUS, DB_NAME_PERPUS);
    $koneksi2 = $db2->getConnection();
} catch (Exception $e) {
    error_log("Failed to initialize perpustakaan database: " . $e->getMessage());
    die("Koneksi database gagal.");
}

// Helper function to get database object
function getDB()
{
    global $db;
    return $db;
}

function getDB1()
{
    global $db1;
    return $db1;
}

function getDB2()
{
    global $db2;
    return $db2;
}
