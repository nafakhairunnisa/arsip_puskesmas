<?php
session_start();
include 'koneksi.php';

?>

<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Registrasi | Sistem Informasi Arsip Digital</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Play:400,700" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/owl.theme.css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/morrisjs/morris.css">
    <link rel="stylesheet" href="assets/css/scrollbar/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="assets/css/metisMenu/metisMenu.min.css">
    <link rel="stylesheet" href="assets/css/metisMenu/metisMenu-vertical.css">
    <link rel="stylesheet" href="assets/css/calendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assets/css/calendar/fullcalendar.print.min.css">
    <link rel="stylesheet" href="assets/css/form/all-type-forms.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <script src="assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <div class="error-pagewrap">
        <div class="error-page-int">
            <div class="text-center m-b-md custom-login">
                <h3>SISTEM INFORMASI</h3>
                <h4>ARSIP DIGITAL</h4>

                <br>

                <p>Silahkan isi form berikut untuk membuat akun baru.</p>

            </div>
            <div class="content-error">
                <?php
                    if(isset($_GET['alert'])){
                        if($_GET['alert'] == "gagal"){
                            echo "<div class='alert alert-danger'>Email Sudah Terdaftar</div>";
                        }else if($_GET['alert'] == "sukses"){
                            echo "<div class='alert alert-success'>Registrasi berhasil! Silakan cek email untuk verifikasi akun.</div>";
                        }
                    }
                ?>
                <div class="hpanel">
                    <div class="panel-body">

                        <br>
                        <br>
                        <center>
                            <h4>REGISTRASI USER</h4>    
                        </center>
                        <br>
                        <br>

                        <form action="proses_register.php" method="POST" id="loginForm">
                            <div class="form-group">
                                <label class="control-label" for="">Nama</label>
                                <input type="text" placeholder="Nama Lengkap" title="Nama Lengkap" required="required" autocomplete="off" name="name" id="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="email">Email</label>
                                <input type="email" placeholder="Alamat Email" title="Email" required="required" autocomplete="off" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="Password" required="required" autocomplete="off" name="password" id="password" class="form-control">
                            </div>

                            <input type="submit" name="register_btn" class="btn btn-success btn-block loginbtn" value="Register">
                        </form>

                        <br>

                    </div>
                </div>
                <br>
                <a href="user_login.php">Kembali</a>
                <br>
            </div>
            <div class="text-center login-footer">
                <p class="text-muted">Copyright © <?php echo date('Y') ?>. All rights reserved. Sistem Informasi Arsip Digital (SIAD)</p>
            </div>
        </div>   
    </div>
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery-price-slider.js"></script>
    <script src="assets/js/jquery.meanmenu.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/jquery.sticky.js"></script>
    <script src="assets/js/jquery.scrollUp.min.js"></script>
    <script src="assets/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="assets/js/scrollbar/mCustomScrollbar-active.js"></script>
    <script src="assets/js/metisMenu/metisMenu.min.js"></script>
    <script src="assets/js/metisMenu/metisMenu-active.js"></script>
    <script src="assets/js/tab.js"></script>
    <script src="assets/js/icheck/icheck.min.js"></script>
    <script src="assets/js/icheck/icheck-active.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
	<body class="hold-transition login-page" style="background: linear-gradient(to bottom, #9563DE, #ffffff);
no-repeat center center fixed; background-size: cover;
 -webkit-background-size: cover; 
 -moz-background-size: cover; -o-background-size: cover;">
</body>
</html>