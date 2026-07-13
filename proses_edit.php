<?php

require 'config/koneksi.php';

if(isset($_POST['update'])){

$id=(int)$_POST['id'];

$judul=trim($_POST['judul']);
$penulis=trim($_POST['penulis']);
$kategori=trim($_POST['kategori']);
$harga=$_POST['harga'];
$tanggal=$_POST['tanggal'];

if(
empty($judul) ||
empty($penulis) ||
empty($kategori) ||
empty($harga) ||
empty($tanggal)
){
die("Semua data wajib diisi.");
}

if(!filter_var($harga,FILTER_VALIDATE_FLOAT)){
die("Harga tidak valid.");
}

$stmt=$conn->prepare("
UPDATE buku
SET
judul=?,
penulis=?,
kategori=?,
tanggal_terbit=?
WHERE id=?
");

$stmt->bind_param(
"sssdsi",
$judul,
$penulis,
$kategori,
$tanggal,
$id
);

$stmt->execute();

header("Location:index.php?status=edit");
exit;

}
?>

if($stmt->execute()){
    header("Location: index.php?status=edit");
    exit;
}else{
    header("Location: index.php?status=gagal");
    exit;
}