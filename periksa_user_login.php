<?php 
// menghubungkan dengan koneksi
include 'koneksi.php';

// menangkap data yang dikirim dari form
$email = $_POST['email'];
$password_input = $_POST['password'];

// $login = mysqli_query($koneksi, "SELECT * FROM user WHERE user_email='$email' AND user_password='$password'");
// Query untuk mendapatkan data pengguna berdasarkan email
$login = mysqli_prepare($koneksi, "SELECT user_id, user_nama, user_email, user_password, verify_status FROM user WHERE user_email=?");
mysqli_stmt_bind_param($login, "s", $email);
mysqli_stmt_execute($login);

// Mengambil hasil query
mysqli_stmt_store_result($login);

// Mengecek jumlah baris hasil query
$cek = mysqli_stmt_num_rows($login);
// $cek = mysqli_num_rows($login);

if ($cek > 0) {
    // Mengambil data pengguna
    mysqli_stmt_bind_result($login, $user_id, $user_nama, $user_email, $hashed_password, $verify_status);
    mysqli_stmt_fetch($login);

    // Memeriksa password menggunakan password_verify
    if (password_verify($password_input, $hashed_password)) {
        if ($verify_status == 1) {
            session_start();
            $_SESSION['id'] = $user_id;
            $_SESSION['nama'] = $user_nama;
            $_SESSION['email'] = $user_email;
            $_SESSION['status'] = "user_login";

            header("location:user/");
        } else {
            header("location:user_login.php?alert=verify");
        }
    } else {
        header("location:user_login.php?alert=gagal");
    }
} else {
    header("location:user_login.php?alert=gagal");
}

mysqli_stmt_close($login);
mysqli_close($koneksi);

// if($cek > 0){
// 	session_start();
// 	$data = mysqli_fetch_assoc($login);
// 	$_SESSION['id'] = $data['user_id'];
// 	$_SESSION['nama'] = $data['user_nama'];
// 	$_SESSION['email'] = $data['user_email'];
// 	$_SESSION['status'] = "user_login";

// 	header("location:user/");
// }else{
// 	header("location:user_login.php?alert=gagal");
// }
?>
