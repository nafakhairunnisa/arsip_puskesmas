<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];

    // Lakukan validasi data jika diperlukan

    // Eksekusi query UPDATE
    $query = "UPDATE kamar SET kamar_nama='$nama' WHERE kamar_id='$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Redirect atau lakukan tindakan setelah berhasil memperbarui
        header("location:kamar.php");
        exit();
    } else {
        // Handle kesalahan jika diperlukan
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>
