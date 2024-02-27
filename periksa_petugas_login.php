<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

session_start();

// Periksa apakah semua input tersedia
if(isset($_POST['username'], $_POST['password'], $_POST['kamar'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $kamar = isset($_POST["kamar"])? mysqli_real_escape_string($koneksi, $_POST['kamar']) : "petugas_login.php? altert=gagal";

    // Query SQL untuk memeriksa kredensial pengguna
    $loginQuery = "SELECT * FROM petugas WHERE petugas_username=? AND kamar_id=(SELECT kamar_id FROM kamar WHERE kamar_nama=?)";
    $login = mysqli_prepare($koneksi, $loginQuery);
    mysqli_stmt_bind_param($login, "ss", $username, $kamar);
    mysqli_stmt_execute($login);

    $result = mysqli_stmt_get_result($login);

    // Jika ada hasil dari query
    if(mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        
        // Periksa kata sandi menggunakan password_verify
        if(password_verify($password, $data['petugas_password'])) {
            $_SESSION['id'] = $data['petugas_id'];
            $_SESSION['nama'] = $data['petugas_nama'];
            $_SESSION['username'] = $data['petugas_username'];
            $_SESSION['status'] = $kamar.'_login'; // Mengasumsikan kamar_nama adalah unik
            
            // Redirect sesuai dengan kamar
           header("location:".$kamar."/");
            }
        } else {
            header("location:petugas_login.php?alert=gagal");
            exit;
        }
    } else {
        header("location:petugas_login.php?alert=gagal");
        exit;
    }

?>
