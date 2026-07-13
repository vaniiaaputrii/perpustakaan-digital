<?php
require 'config/koneksi.php';
require 'template/header.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $conn->prepare("SELECT * FROM buku WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if(!$data){
    die("Data tidak ditemukan.");
}
?>

<h2>Edit Buku</h2>

<form action="proses_edit.php" method="POST">

<input type="hidden" name="id"
value="<?= $data['id'] ?>">

<label>Judul</label>
<input type="text"
name="judul"
value="<?= htmlspecialchars($data['judul']) ?>"
required>

<label>Penulis</label>
<input type="text"
name="penulis"
value="<?= htmlspecialchars($data['penulis']) ?>"
required>

<label>Kategori</label>
<input type="text"
name="kategori"
value="<?= htmlspecialchars($data['kategori']) ?>"
required>

<label>Tanggal Terbit</label>
<input type="date"
name="tanggal"
value="<?= $data['tanggal_terbit'] ?>"
required>

<button type="submit" name="update">
Update Data
</button>

</form>

<?php
require 'template/footer.php';
?>