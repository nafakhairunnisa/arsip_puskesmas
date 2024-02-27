<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kamar_id = $_POST['kamar'];

    // Lakukan validasi data jika diperlukan

    // Eksekusi query UPDATE
    $query = "UPDATE kategori SET kategori_nama='$nama', kamar_id=$kamar_id WHERE kategori_id='$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Redirect atau lakukan tindakan setelah berhasil memperbarui
        header("location:kategori.php");
        exit();
    } else {
        // Handle kesalahan jika diperlukan
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>
