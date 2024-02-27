<?php
include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$login = mysqli_query($koneksi, "SELECT * FROM admin WHERE admin_username='$username'");
$data = mysqli_fetch_assoc($login);

if ($data) {
    if (password_verify($password, $data['admin_password'])) {
        session_start();
        $_SESSION['id'] = $data['admin_id'];
        $_SESSION['nama'] = $data['admin_nama'];
        $_SESSION['username'] = $data['admin_username'];
        $_SESSION['status'] = "admin_login";
        header("location:admin/");
        exit;
    } else {
        header("location:admin_login.php?alert=gagal");
        exit;
    }
} else {
    header("location:admin_login.php?alert=gagal");
    exit;
}
?>
