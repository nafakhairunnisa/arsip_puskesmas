<?php 
include '../koneksi.php';
$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM petugas WHERE petugas_id='$id'");
$d = mysqli_fetch_assoc($data);
$foto = $d['petugas_foto'];
unlink("../gambar/petugas/$foto");
mysqli_query($koneksi, "DELETE FROM petugas WHERE petugas_id='$id'");
header("location:petugas.php");
