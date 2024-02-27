<?php 
include '../koneksi.php';

// Pastikan parameter id adalah angka
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Persiapkan statement
$stmt = mysqli_prepare($koneksi, "DELETE FROM kamar WHERE kamar_id = ?");

// Bind parameter
mysqli_stmt_bind_param($stmt, "i", $id);

// Eksekusi statement
mysqli_stmt_execute($stmt);

// Tutup statement
mysqli_stmt_close($stmt);

// Redirect ke halaman kamar.php setelah menghapus
header("location:kamar.php");
?>