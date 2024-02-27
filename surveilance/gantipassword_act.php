<?php 
include '../koneksi.php';
session_start();
$id = $_SESSION['id'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

mysqli_query($koneksi, "UPDATE petugas SET petugas_password='$password' WHERE petugas_id='$id'")or die(mysqli_error($koneksi));

header("location:gantipassword.php?alert=sukses");