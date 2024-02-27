<?php 
include '../koneksi.php';
$id  = $_POST['id'];
$nama  = $_POST['nama'];
$username = $_POST['username'];
$pwd = $_POST['password'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$kamar_id = $_POST['kamar'];

// cek gambar
$rand = rand();
$allowed =  array('gif','png','jpg','jpeg');
$filename = $_FILES['foto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if($pwd=="" && $filename==""){
	mysqli_query($koneksi, "UPDATE petugas SET petugas_nama='$nama', petugas_username='$username', kamar_id='$kamar_id' WHERE petugas_id='$id'");
	header("location:petugas.php");
}elseif($pwd==""){
	if(!in_array($ext,$allowed) ) {
		header("location:petugas.php?alert=gagal");
	}else{
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/petugas/'.$rand.'_'.$filename);
		$x = $rand.'_'.$filename;
		mysqli_query($koneksi, "UPDATE petugas SET petugas_nama='$nama', petugas_username='$username', petugas_foto='$x', kamar_id='$kamar_id' WHERE petugas_id='$id'");		
		header("location:petugas.php?alert=berhasil");
	}
}elseif($filename==""){
	mysqli_query($koneksi, "UPDATE petugas SET petugas_nama='$nama', petugas_username='$username', petugas_password='$password', kamar_id='$kamar_id' WHERE petugas_id='$id'");
	header("location:petugas.php");
}

