<?php
require_once __DIR__ . '/../includes/init.php';

// Validate CSRF token
if (!validateCSRF()) {
    logSecurityEvent('CSRF token validation failed in aksiskm.php');
    die('Invalid request');
}

// Check admin authentication
requireAdminLogin();

// Sanitize and validate inputs
$aksi = isset($_GET['aksi']) ? sanitizeInput($_GET['aksi']) : '';
$id = isset($_GET['id']) ? validateInt($_GET['id']) : false;

if ($aksi == "hapus" && $id !== false) {
    // Use prepared statement
    $db1 = getDB1();
    $result = $db1->execute(
        "DELETE FROM tb_isian WHERE id = ?",
        "i",
        [$id]
    );

    if ($result) {
        logSecurityEvent('Data deleted from tb_isian', ['id' => $id, 'admin' => $_SESSION['adminname']]);
    }

    redirect('adminskm.php');
} else {
    logSecurityEvent('Invalid delete attempt in aksiskm.php', ['aksi' => $aksi, 'id' => $id]);
    redirect('adminskm.php');
}
