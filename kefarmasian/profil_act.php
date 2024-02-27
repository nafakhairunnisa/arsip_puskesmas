<?php 
include '../koneksi.php';
session_start();

$id = $_SESSION['id'];

$username  = $_POST['username'];
$nama  = $_POST['nama'];

$rand = rand();

$allowed = array('gif', 'png', 'jpg', 'jpeg');

$filename = $_FILES['foto']['name'];

if ($filename == "") {
    mysqli_query($koneksi, "update petugas set petugas_nama='$nama', petugas_username='$username' where petugas_id='$id'") or die(mysqli_error($koneksi));
    header("location:profil.php?alert=sukses");
} else {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

    if (in_array($ext, $allowed)) {

        // hapus file lama
        $lama = mysqli_query($koneksi, "select * from petugas where petugas_id='$id'");
        $l = mysqli_fetch_assoc($lama);
        $nama_file_lama = $l['petugas_foto'];
        unlink("../gambar/petugas/" . $nama_file_lama);

        // upload file baru
        $target_path = '../gambar/petugas/' . $rand . '_' . $filename;
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_path);

        // Update database dengan nama file yang baru
        $nama_file = $rand . '_' . $filename;
        mysqli_query($koneksi, "update petugas set petugas_nama='$nama', petugas_username='$username', petugas_foto='$nama_file' where petugas_id='$id'") or die(mysqli_error($koneksi));
        header("location:profil.php?alert=sukses");
    } else {
        header("location:profil.php?alert=gagal");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* CSS untuk menyesuaikan ukuran foto dengan lebar bingkai */
        .foto-container {
            max-width: 100%; /* Menyesuaikan dengan lebar bingkai atau container */
            height: auto; /* Otomatis menyesuaikan tinggi sesuai proporsi */
        }
    </style>
    <title>Profil Page</title>
</head>
<body>
    <!-- Konten HTML Anda di sini -->

    <!-- Contoh penggunaan CSS untuk menyesuaikan ukuran foto -->
    <?php
    $foto_path = "../gambar/petugas/" . $nama_file;
    echo "<img src='$foto_path' alt='Foto Profil' class='foto-container'>";
    ?>

    <!-- Konten HTML Anda di sini -->
</body>
</html>
