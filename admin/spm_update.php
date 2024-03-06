<?php
include '../koneksi.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define current month and year
    $currentMonth = isset($_POST['bulan']) ? $_POST['bulan'] : '';
    $currentYear = isset($_POST['tahun']) ? $_POST['tahun'] : '';

    // Check if current month and year are set
    if (empty($currentMonth) || empty($currentYear)) {
        die("Error: Current month or year is not set.");
    }

    // Loop through the posted data and update or insert into the database
    foreach ($_POST as $key => $value) {
        // Check if the key starts with the expected prefixes
        if (strpos($key, 'absolut_tahunan_') === 0 || strpos($key, 'absolut_bulanan_') === 0) {
            $indikator_id = str_replace(['absolut_tahunan_', 'absolut_bulanan_'], '', $key);

            // Retrieve the posted values
            $absolut_tahunan = isset($_POST["absolut_tahunan_$indikator_id"]) ? $_POST["absolut_tahunan_$indikator_id"] : 0;
            $absolut_bulanan = isset($_POST["absolut_bulanan_$indikator_id"]) ? $_POST["absolut_bulanan_$indikator_id"] : 0;

            // Calculate percentage
            $persentase = ($absolut_tahunan != 0) ? (($absolut_bulanan / $absolut_tahunan) * 100) : 0;

            /// Check if the data already exists in the database
            $check_query = mysqli_prepare($koneksi, "SELECT * FROM spm
            WHERE indikator_id = ? AND jpelayanan_id = ?
            AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = ?)
            AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)");

            if (!$check_query) {
            die("Query preparation failed: " . mysqli_error($koneksi));
            }

            mysqli_stmt_bind_param($check_query, "iss", $indikator_id, $currentMonth, $currentYear);
            mysqli_stmt_execute($check_query);
            $check_result = mysqli_stmt_get_result($check_query);

            // If data exists, perform update
            if ($check_result) {
                if (mysqli_num_rows($check_result) > 0) {
                    $update_query = mysqli_prepare($koneksi, "UPDATE spm
                        SET absolut_tahunan = ?, absolut_bulanan = ?, persentase = ?
                        WHERE indikator_id = ? AND jpelayanan_id = ?
                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = ?)
                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)");
                    mysqli_stmt_bind_param($update_query, "ddiiss", $absolut_tahunan, $absolut_bulanan, $persentase, $indikator_id, $currentMonth, $currentYear);
                    mysqli_stmt_execute($update_query);
                    mysqli_stmt_close($update_query);
                    echo "Update successful!";
                } else { // If data does not exist, perform insert
                    $insert_query = mysqli_prepare($koneksi, "INSERT INTO spm (indikator_id, jpelayanan_id, bulan_id, tahun_id, absolut_tahunan, absolut_bulanan, persentase)
                        VALUES (?, 1, (SELECT bulan_id FROM bulan WHERE bulan_nama = ?), (SELECT tahun_id FROM tahun WHERE tahun_angka = ?), ?, ?, ?)");
                    mysqli_stmt_bind_param($insert_query, "issddd", $indikator_id, $currentMonth, $currentYear, $absolut_tahunan, $absolut_bulanan, $persentase);
                    mysqli_stmt_execute($insert_query);
                    mysqli_stmt_close($insert_query);
                    echo "Insert successful!";
                }
            } else {
                die("Error in executing statement: " . mysqli_error($koneksi));
            }
            
            mysqli_stmt_close($check_query);
        }
    }

    // Redirect after successful update or insert
    header("location:index.php");
    exit();
}
?>
