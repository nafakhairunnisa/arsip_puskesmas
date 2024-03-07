<?php
include 'koneksi.php';

// Define current month and year
$currentMonth = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$currentYear = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Retrieve data using prepared statements to prevent SQL injection
$spm_query = mysqli_prepare($koneksi, "SELECT spm.absolut_tahunan, spm.absolut_bulanan, spm.persentase,
                                        jenis_pelayanan.jpelayanan_nama, indikator_spm.indikator_nama
                                        FROM spm
                                        INNER JOIN jenis_pelayanan ON spm.jpelayanan_id = jenis_pelayanan.jpelayanan_id
                                        INNER JOIN indikator_spm ON spm.indikator_id = indikator_spm.indikator_id
                                        WHERE spm.bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = ?)
                                        AND spm.tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        ORDER BY spm.indikator_id ASC");

if (!$spm_query) {
    die("Query preparation failed: " . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($spm_query, "ss", $currentMonth, $currentYear);
if (mysqli_stmt_execute($spm_query)) {
    $spm_result = mysqli_stmt_get_result($spm_query);
} else {
    die("Error in executing statement: " . mysqli_error($koneksi));
}

mysqli_stmt_close($spm_query);

// Start output buffering
ob_start();
?>

<p align="center" class="panel-title">SPM - Bulan <?php echo $currentMonth; ?> Tahun <?php echo $currentYear; ?></p>

<table id="table" class="table table-bordered table-striped table-hover table-datatable">
    <thead>
        <tr>
            <th width="1%" rowspan="2">No</th>
            <th rowspan="2">Jenis Pelayanan</th>
            <th rowspan="2">Indikator</th>
            <th class="text-center" colspan="2">Target</th>
            <th class="text-center" colspan="2"><?php echo $currentMonth; ?></th>
        </tr>
        <tr>
            <th>Absolut</th>
            <th>%</th>
            <th>Absolut</th>
            <th>%</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $counter = 1;
        while ($row = mysqli_fetch_assoc($spm_result)) :
        ?>
            <tr>
                <td><?php echo $counter++; ?></td>
                <td><?php echo $row['jpelayanan_nama']; ?></td>
                <td><?php echo $row['indikator_nama']; ?></td>
                <td><?php echo $row['absolut_tahunan']; ?></td>
                <td><?php echo $row['persentase']; ?></td>
                <td><?php echo $row['absolut_bulanan']; ?></td>
                <td><?php echo $row['persentase']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
    $content = ob_get_clean();
    require_once(dirname(__FILE__).'./html2pdf/html2pdf.class.php');
    try
    {
       $html2pdf = new HTML2PDF('P', 'A4', 'en',  array(8, 8, 8, 8));
       $html2pdf->pdf->SetDisplayMode('fullpage');
       $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
       $html2pdf->Output('spm-bulanan.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>