<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "db_arsip_2";

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi Gagal: " . $koneksi->connect_error);
}

// Set karakter set untuk koneksi
$koneksi->set_charset("utf8");

?>
