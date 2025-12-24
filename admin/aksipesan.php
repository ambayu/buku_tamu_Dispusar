<?php
require_once __DIR__ . '/../includes/init.php';

// Validate CSRF token
if (!validateCSRF()) {
    logSecurityEvent('CSRF token validation failed in aksipesan.php');
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
        "DELETE FROM tb_pesanbuku WHERE id = ?",
        "i",
        [$id]
    );

    if ($result) {
        logSecurityEvent('Data deleted from tb_pesanbuku', ['id' => $id, 'admin' => $_SESSION['adminname']]);
    }

    redirect('adminpesan.php');
} else {
    logSecurityEvent('Invalid delete attempt in aksipesan.php', ['aksi' => $aksi, 'id' => $id]);
    redirect('adminpesan.php');
}
