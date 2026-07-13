<?php

require 'config/koneksi.php';

// Casting ID sesuai ketentuan
$id = (int)($_GET['id'] ?? 0);

// Prepared Statement
$stmt = $conn->prepare("DELETE FROM buku WHERE id = ?");
$stmt->bind_param("i", $id);

if($stmt->execute()){
    header("Location: index.php?status=hapus");
} else {
    header("Location: index.php?status=gagal");
}
exit;
?>