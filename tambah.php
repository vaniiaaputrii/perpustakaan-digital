<?php
require 'config/koneksi.php';
require 'template/header.php';

if(isset($_POST['simpan'])){

    $judul = trim($_POST['judul']);
    $penulis = trim($_POST['penulis']);
    $kategori = trim($_POST['kategori']);
    $harga = trim($_POST['harga']);
    $tanggal = $_POST['tanggal'];

    // Validasi
    if(
        empty($judul) ||
        empty($penulis) ||
        empty($kategori) ||
        empty($harga) ||
        empty($tanggal)
    ){
        echo "<div class='alert danger'>Semua data wajib diisi.</div>";
    }

    elseif(!filter_var($harga, FILTER_VALIDATE_INT)){
        echo "<div class='alert danger'>Harga harus berupa angka.</div>";
    }

    else{

        $stmt = $conn->prepare("INSERT INTO buku(judul,penulis,kategori,harga,tanggal_terbit)
                                VALUES(?,?,?,?,?)");

        $stmt->bind_param(
            "sssis",
            $judul,
            $penulis,
            $kategori,
            $harga,
            $tanggal
        );

        if($stmt->execute()){
            header("Location:index.php?status=tambah");
            exit;
        }else{
            echo "<div class='alert danger'>Data gagal ditambahkan.</div>";
        }

    }

}
?>

<h2>Tambah Buku</h2>

<form method="POST">

    <label>Judul Buku</label>
    <input
        type="text"
        name="judul"
        required
    >

    <label>Penulis</label>
    <input
        type="text"
        name="penulis"
        required
    >

    <label>Kategori</label>
    <select name="kategori" required>

        <option value="">-- Pilih Kategori --</option>

        <option>Novel</option>
        <option>Teknologi</option>
        <option>Motivasi</option>
        <option>Pendidikan</option>

    </select>

    <label>Tanggal Terbit</label>
    <input
        type="date"
        name="tanggal"
        required
    >

    <button type="submit" name="simpan">
        Simpan
    </button>

</form>

<?php
require 'template/footer.php';
?>