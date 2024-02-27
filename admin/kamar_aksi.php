<?php 
include '../koneksi.php';
$nama  = $_POST['nama'];

mysqli_query($koneksi, "INSERT INTO kamar VALUES (NULL,'$nama')");
header("location:kamar.php");
?>