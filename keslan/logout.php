<?php 
session_start();
session_destroy();

header("location:../petugas_login.php?alert=logout");
?>