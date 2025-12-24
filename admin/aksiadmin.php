<?php
require_once __DIR__ . '/../includes/init.php';

// Validate CSRF token
if (!validateCSRF()) {
    logSecurityEvent('CSRF token validation failed in aksiadmin.php');
    die('Invalid request');
}

// Check admin authentication
requireAdminLogin();

// Sanitize and validate inputs
$aksi = isset($_GET['aksi']) ? sanitizeInput($_GET['aksi']) : '';
$id = isset($_GET['id']) ? validateInt($_GET['id']) : false;

if ($aksi == "hapus" && $id !== false) {
    // Use prepared statement
    $db2 = getDB2();
    $result = $db2->execute(
        "DELETE FROM tb_login WHERE id = ?",
        "i",
        [$id]
    );

    if ($result) {
        logSecurityEvent('Admin deleted from tb_login', ['id' => $id, 'admin' => $_SESSION['adminname']]);
    }

    redirect('adminleader.php');
} else {
    logSecurityEvent('Invalid delete attempt in aksiadmin.php', ['aksi' => $aksi, 'id' => $id]);
    redirect('adminleader.php');
}
