<?php
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $persentase = $_POST['persentase'];

    $query = "UPDATE indikator_spm SET persentase='$persentase' WHERE indikator_id='$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("location:index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($koneksi);
    }
}
?>
