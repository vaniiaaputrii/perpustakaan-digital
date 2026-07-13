<?php
require 'config/koneksi.php';
require 'template/header.php';

// Casting ID ke integer (sesuai ketentuan)
$id = (int)($_GET['id'] ?? 0);

// Prepared Statement
$stmt = $conn->prepare("SELECT * FROM buku WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "<h3>Data tidak ditemukan.</h3>";
    require 'template/footer.php';
    exit;
}
?>

<h2>Detail Buku</h2>

<table>
    <tr>
        <th width="30%">Judul</th>
        <td><?= htmlspecialchars($data['judul']) ?></td>
    </tr>

    <tr>
        <th>Penulis</th>
        <td><?= htmlspecialchars($data['penulis']) ?></td>
    </tr>

    <tr>
        <th>Kategori</th>
        <td><?= htmlspecialchars($data['kategori']) ?></td>
    </tr>

    <tr>
        <th>Tanggal Terbit</th>
        <td><?= date('d-m-Y', strtotime($data['tanggal_terbit'])) ?></td>
    </tr>

    <tr>
        <th>Dibuat</th>
        <td><?= date('d-m-Y H:i', strtotime($data['created_at'])) ?></td>
    </tr>
</table>

<br>

<a href="index.php" class="btn detail">← Kembali</a>

<?php
require 'template/footer.php';
?>