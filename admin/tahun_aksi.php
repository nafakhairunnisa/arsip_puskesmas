<?php 
include '../koneksi.php';
$nama  = $_POST['tahun'];

mysqli_query($koneksi, "INSERT INTO tahun VALUES (NULL,'$nama')");
header("location:index.php");
?>