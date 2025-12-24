<?php
require_once __DIR__ . '/../includes/init.php';

// Validate CSRF token
if (!validateCSRF()) {
    logSecurityEvent('CSRF token validation failed in aksi.php');
    die('Invalid request');
}

// Check admin authentication
requireAdminLogin();

// Sanitize and validate inputs
$aksi = isset($_GET['aksi']) ? sanitizeInput($_GET['aksi']) : '';
$id = isset($_GET['id']) ? validateInt($_GET['id']) : false;

if ($aksi == "hapus" && $id !== false) {
    // Use prepared statement
    $db = getDB();
    $result = $db->execute(
        "DELETE FROM tb_kunjungan WHERE id = ?",
        "i",
        [$id]
    );

    if ($result) {
        logSecurityEvent('Data deleted from tb_kunjungan', ['id' => $id, 'admin' => $_SESSION['adminname']]);
    }

    redirect('admin.php');
} else {
    logSecurityEvent('Invalid delete attempt in aksi.php', ['aksi' => $aksi, 'id' => $id]);
    redirect('admin.php');
}
