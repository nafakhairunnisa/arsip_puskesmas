<?php 
include '../koneksi.php';
$nama  = $_POST['nama'];
$kamar = $_POST['kamar'];

mysqli_query($koneksi, "INSERT INTO kategori VALUES (NULL,'$nama','$kamar')");
header("location:kategori.php");