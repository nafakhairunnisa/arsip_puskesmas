<?php 
include '../koneksi.php';
$id = $_GET['id'];

// hapus file lama
$lama = mysqli_query($koneksi,"SELECT * FROM arsip WHERE arsip_id='$id'");
$l = mysqli_fetch_assoc($lama);
$nama_file_lama = $l['arsip_file'];
unlink("../arsip/".$nama_file_lama);

mysqli_query($koneksi, "DELETE FROM arsip WHERE arsip_id='$id'");
header("location:arsip.php");
