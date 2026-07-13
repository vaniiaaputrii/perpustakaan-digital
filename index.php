<?php
require 'config/koneksi.php';
require 'template/header.php';

// Notifikasi
if(isset($_GET['status'])){

    if($_GET['status']=="tambah"){
        echo "<div class='alert success'>✅ Data berhasil ditambahkan.</div>";
    }

    if($_GET['status']=="edit"){
        echo "<div class='alert info'>✏️ Data berhasil diubah.</div>";
    }

    if($_GET['status']=="hapus"){
        echo "<div class='alert danger'>🗑️ Data berhasil dihapus.</div>";
    }

    if($_GET['status']=="gagal"){
        echo "<div class='alert danger'>❌ Terjadi kesalahan.</div>";
    }
}

// Query pencarian
$cari = $_GET['cari'] ?? '';

if($cari != ''){

    $stmt = $conn->prepare("SELECT * FROM buku
                            WHERE judul LIKE ?
                            OR penulis LIKE ?
                            ORDER BY id DESC");

    $keyword = "%".$cari."%";

    $stmt->bind_param("ss", $keyword, $keyword);

}else{

    $stmt = $conn->prepare("SELECT * FROM buku ORDER BY id DESC");

}

$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Daftar Buku</h2>

<form method="GET" class="search-box">

    <input
        type="text"
        name="cari"
        placeholder="🔍 Cari judul atau penulis..."
        value="<?= htmlspecialchars($cari) ?>"
    >

    <button type="submit">Cari</button>

    <a href="index.php" class="btn detail">Reset</a>

</form>

<a href="tambah.php" class="btn tambah">
    + Tambah Buku
</a>

<br><br>

<table>

<tr>
    <th>No</th>
    <th>Judul</th>
    <th>Penulis</th>
    <th>Kategori</th>
    <th>Tanggal Terbit</th>
    <th>Aksi</th>
</tr>

<?php

$no = 1;

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

?>

<tr>

<td><?= $no++ ?></td>

<td><?= htmlspecialchars($row['judul']) ?></td>

<td><?= htmlspecialchars($row['penulis']) ?></td>

<td><?= htmlspecialchars($row['kategori']) ?></td>

<td><?= date('d-m-Y', strtotime($row['tanggal_terbit'])) ?></td>

<td>

<a class="btn detail"
href="detail.php?id=<?= $row['id'] ?>">Detail</a>

<a class="btn edit"
href="edit.php?id=<?= $row['id'] ?>">Edit</a>

<a class="btn hapus"
href="hapus.php?id=<?= $row['id'] ?>"
onclick="return confirm('Yakin ingin menghapus data ini?')">
Hapus
</a>

</td>

</tr>

<?php
}

}else{
?>

<tr>
    <td colspan="7">
        Tidak ada data yang ditemukan.
    </td>
</tr>

<?php
}
?>

</table>

<?php
require 'template/footer.php';
?>

<?php
$total = $conn->query("SELECT COUNT(*) AS total FROM buku");
$jumlah = $total->fetch_assoc();
?>

<div class="dashboard">
    <div class="card">
        <h3>Total Buku</h3>
        <h1><?= $jumlah['total']; ?></h1>
    </div>
</div>