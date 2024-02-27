<?php 
include '../koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');

$id = isset($_POST['id']) ? $_POST['id'] : null;
$nama = $_POST['nama'];

$rand = rand();
$filename = $_FILES['file']['name'];

$kategori = $_POST['kategori'];
$keterangan = $_POST['keterangan'];

if ($filename == "") {
    mysqli_query($koneksi, "UPDATE arsip SET arsip_nama='$nama', arsip_kategori='$kategori', arsip_keterangan='$keterangan' WHERE arsip_id='$id'") or die(mysqli_error($koneksi));
    header("location:arsip.php");
} else {
    $jenis = pathinfo($filename, PATHINFO_EXTENSION);

    if ($jenis == "php") {
        header("location:arsip.php?alert=gagal");
        exit();
    } else {
        $lama = mysqli_query($koneksi, "SELECT * FROM arsip WHERE arsip_id='$id'");
        $l = mysqli_fetch_assoc($lama);
        $nama_file_lama = $l['arsip_file'];
        unlink("../arsip/" . $nama_file_lama);

        move_uploaded_file($_FILES['file']['tmp_name'], '../arsip/' . $rand . '_' . $filename);
        $nama_file = $rand . '_' . $filename;

        mysqli_query($koneksi, "UPDATE arsip SET arsip_nama='$nama', arsip_jenis='$jenis', arsip_kategori='$kategori', arsip_keterangan='$keterangan', arsip_file='$nama_file' WHERE arsip_id='$id'") or die(mysqli_error($koneksi));
        header("location:arsip.php?alert=sukses");
    }
}
?>
