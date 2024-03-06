<?php
include 'header.php';
include '../koneksi.php';

// Get distinct months from your table
$monthsResult = mysqli_query($koneksi, "SELECT bulan_id, bulan_nama FROM bulan ORDER BY bulan_id ASC");
$months = mysqli_fetch_all($monthsResult, MYSQLI_ASSOC);

$currentMonth = isset($_GET['bulan']) ? $_GET['bulan'] : (isset($months[0]['bulan_nama']) ? $months[0]['bulan_nama'] : '');

// Get distinct years from your table
$yearsResult = mysqli_query($koneksi, "SELECT DISTINCT tahun_id, tahun_angka FROM tahun ORDER BY tahun_angka ASC");
$years = mysqli_fetch_all($yearsResult, MYSQLI_ASSOC);

$currentYear = isset($_GET['tahun']) ? $_GET['tahun'] : (isset($years[0]['tahun']) ? $years[0]['tahun'] : date('Y')); // Set default to current year

// Retrieve data using prepared statements to prevent SQL injection
$data_spm_query = "SELECT * FROM spm
                    INNER JOIN jenis_pelayanan ON spm.jpelayanan_id = jenis_pelayanan.jpelayanan_id
                    INNER JOIN indikator_spm ON spm.indikator_id = indikator_spm.indikator_id
                    WHERE spm.bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = ?)
                    AND spm.tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                    ORDER BY spm.indikator_id ASC";

$data_spm_stmt = mysqli_prepare($koneksi, $data_spm_query);
mysqli_stmt_bind_param($data_spm_stmt, "si", $currentMonth, $currentYear);
mysqli_stmt_execute($data_spm_stmt);
$data_spm_result = mysqli_stmt_get_result($data_spm_stmt);

// Pagination logic
$itemsPerPage = 10; // Adjust as needed
$totalItems = mysqli_num_rows($data_spm_result);
$totalPages = ceil($totalItems / $itemsPerPage);

$currentMonthPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($currentMonthPage - 1) * $itemsPerPage;

$data_spm_query .= " LIMIT $offset, $itemsPerPage";
$data_spm_result = mysqli_query($koneksi, $data_spm_query);
?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Edit SPM</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu" style="padding-top: 0px">
                                <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                <li><span class="bread-blod">SPM</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">


    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel">

                <div class="panel-heading">
                    <h3 class="panel-title">Edit SPM - Bulan <?php echo $currentMonth; ?> Tahun <?php echo $currentYear; ?></h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="spm_update.php">
                        <div class="pull-left">
                            <div class="form-group">
                                <label>Bulan</label>
                                <select class="form-control" name="bulan" onchange="location = this.value;">
                                    <?php
                                    foreach ($months as $monthOption) {
                                        $bulan_id = $monthOption['bulan_id'];
                                        $selected = ($monthOption['bulan_nama'] == $currentMonth) ? 'selected' : '';
                                        echo "<option value='?bulan={$monthOption['bulan_nama']}&bulan_id=$bulan_id&tahun=$currentYear' $selected>{$monthOption['bulan_nama']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <div class="pull-left" style="margin-left: 10px;">
                            <div class="form-group">
                                <label>Tahun</label>
                                <select class="form-control" name="tahun" onchange="location = this.value;">
                                    <?php
                                    foreach ($years as $yearOption) {
                                        $tahun_id = $yearOption['tahun_id'];
                                        $selected = ($yearOption['tahun_angka'] == $currentYear) ? 'selected' : '';
                                        echo "<option value='?bulan=$currentMonth&tahun={$yearOption['tahun_angka']}&tahun_id=$tahun_id' $selected>{$yearOption['tahun_angka']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>



                        <div class="pull-right">            
                            <a href="index.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
                        <br>
                        <br>
                        <br>
                    

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
                                $data_spm = mysqli_query($koneksi, "SELECT * FROM indikator_spm
                                            INNER JOIN jenis_pelayanan ON indikator_spm.jpelayanan_id = jenis_pelayanan.jpelayanan_id
                                            ORDER BY indikator_id ASC");

                                if (!$data_spm) {
                                    die("Query error: " . mysqli_error($koneksi));
                                }
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 1 -->
                                <tr>
                                    <td rowspan="6">1</td>
                                    <td rowspan="6">Pelayanan Kesehatan Ibu Hamil</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 1) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>


                                <!-- Baris untuk nomor dan nama pelayanan 2 -->
                                <tr>
                                    <td rowspan="7">2</td>
                                    <td rowspan="7">Pelayanan Kesehatan Ibu Bersalin</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 2) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 3 -->
                                <tr>
                                    <td rowspan="7">3</td>
                                    <td rowspan="7">Pelayanan Kesehatan Bayi Baru Lahir</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 3) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 4 -->
                                <tr>
                                    <td rowspan="7">4</td>
                                    <td rowspan="7">Pelayanan Kesehatan Balita</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 4) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 5 -->
                                <tr>
                                    <td rowspan="6">5</td>
                                    <td rowspan="6">Pelayanan Kesehatan pada Usia Pendidikan Dasar</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 5) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 6 -->
                                <tr>
                                    <td rowspan="4">6</td>
                                    <td rowspan="4">Pelayanan Kesehatan pada Usia Produktif</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 6) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 7 -->
                                <tr>
                                    <td rowspan="3">7</td>
                                    <td rowspan="3">Pelayanan Kesehatan pada Usia Lanjut</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 7) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 8 -->
                                <tr>
                                    <td rowspan="3">8</td>
                                    <td rowspan="3">Pelayanan Kesehatan Penderita Hipertensi</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 8) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 9 -->
                                <tr>
                                    <td rowspan="3">9</td>
                                    <td rowspan="3">Pelayanan Kesehatan Penderita Diabetes Melitus</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 9) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 10 -->
                                <tr>
                                    <td rowspan="4">10</td>
                                    <td rowspan="4">Pelayanan Kesehatan Orang Dengan Gangguan Jiwa Berat</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 10) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 11 -->
                                <tr>
                                    <td rowspan="8">11</td>
                                    <td rowspan="8">Pelayanan Rehabilitasi Medik</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 11) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>

                                <!-- Baris untuk nomor dan nama pelayanan 12 -->
                                <tr>
                                    <td rowspan="7">12</td>
                                    <td rowspan="7">Pelayanan Rehabilitasi Non-Medik</td>
                                </tr>
                                <?php mysqli_data_seek($data_spm, 0); ?>
                                <?php 
                                while($p = mysqli_fetch_array($data_spm)) :
                                    if ($p['jpelayanan_id'] == 12) :
                                        $spm_query = mysqli_prepare($koneksi, "SELECT * FROM spm
                                        WHERE indikator_id = ? AND jpelayanan_id = ?
                                        AND bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                        AND tahun_id = (SELECT tahun_id FROM tahun WHERE tahun_angka = ?)
                                        
                                                    ");
                                        if ($spm_query === false) {
                                            die("Error in preparing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        mysqli_stmt_bind_param($spm_query, "iii", $p['indikator_id'], $p['jpelayanan_id'], $currentYear);
                                        if (mysqli_stmt_execute($spm_query)) {
                                            $spm_result = mysqli_stmt_get_result($spm_query);
                                            // Continue with fetching data...
                                        } else {
                                            die("Error in executing statement: " . mysqli_error($koneksi));
                                        }
                                        
                                        
                                        // Check if the result set is empty
                                        if(mysqli_num_rows($spm_result) > 0) {
                                            $spm_data = mysqli_fetch_array($spm_result);
                                        } else {
                                            // Set default values if the result set is empty
                                            $spm_data = array('absolut_tahunan' => 0, 'absolut_bulanan' => 0, 'persentase' => 0);
                                        }
                                        
                                        mysqli_stmt_close($spm_query);
                                ?>
                                        <tr>
                                            <td><?php echo $p['indikator_nama']?></td>
                                            <td><input type="text" class="form-control" name="absolut_tahunan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_tahunan'] ?? 0 ?>"></td>
                                            <td><?php echo $p['persentase_fix'] ?>%</td>
                                            <td><input type="text" class="form-control" name="absolut_bulanan_<?php echo $p['indikator_id'] . '_' . $p['jpelayanan_id']; ?>" required="required" value="<?php echo $spm_data['absolut_bulanan'] ?? 0 ?>"></td>
                                            <td><?php echo $spm_data['persentase'] ?? 0 ?>%</td>
                                        </tr>
                                <?php 
                                    endif;
                                endwhile;
                                ?>



                            </tbody>
                        </table>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Simpan">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


</div>


<?php include 'footer.php'; ?>