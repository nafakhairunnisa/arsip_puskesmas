<?php 
include '../koneksi.php';
session_start();

$id = $_SESSION['id'];

$email  = $_POST['email'];
$nama  = $_POST['nama'];

$rand = rand();

$allowed =  array('gif','png','jpg','jpeg');

$filename = $_FILES['foto']['name'];

if($filename == ""){

	mysqli_query($koneksi, "UPDATE user SET user_nama='$nama', user_email='$email' WHERE user_id='$id'")or die(mysqli_error($koneksi));
	header("location:profil.php?alert=sukses");

}else{

	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	if(in_array($ext,$allowed) ) {

		// hapus file lama
		$lama = mysqli_query($koneksi,"SELECT * FROM user WHERE user_id='$id'");
		$l = mysqli_fetch_assoc($lama);
		$nama_file_lama = $l['user_foto'];
		unlink("../gambar/user/".$nama_file_lama);

		// upload file baru
		move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/user/'.$rand.'_'.$filename);
		$nama_file = $rand.'_'.$filename;
		mysqli_query($koneksi, "UPDATE user SET user_nama='$nama', user_email='$email', user_foto='$nama_file' WHERE user_id='$id'")or die(mysqli_error($koneksi));
		header("location:profil.php?alert=sukses");

	}else{

		header("location:profil.php?alert=gagal");
	}

}

