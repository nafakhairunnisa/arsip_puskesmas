<?php
include 'header.php';
include '../koneksi.php';

// Get distinct months from your table
$monthsResult = mysqli_query($koneksi, "SELECT DISTINCT bulan_nama FROM bulan ORDER BY bulan_id ASC");
$months = mysqli_fetch_all($monthsResult, MYSQLI_ASSOC);

$currentMonth = isset($_GET['bulan']) ? $_GET['bulan'] : (isset($months[0]['bulan_nama']) ? $months[0]['bulan_nama'] : '');

// Get distinct years from your table
$yearsResult = mysqli_query($koneksi, "SELECT DISTINCT tahun FROM spm ORDER BY tahun DESC");
$years = mysqli_fetch_all($yearsResult, MYSQLI_ASSOC);

$currentYear = isset($_GET['tahun']) ? $_GET['tahun'] : (isset($years[0]['tahun']) ? $years[0]['tahun'] : date('Y')); // Set default to current year

$data_spm = mysqli_query($koneksi, "SELECT * FROM spm
                                INNER JOIN jenis_pelayanan ON spm.jpelayanan_id = jenis_pelayanan.jpelayanan_id
                                INNER JOIN indikator_spm ON spm.indikator_id = indikator_spm.indikator_id
                                WHERE spm.bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                AND spm.tahun = $currentYear
                                ORDER BY spm.indikator_id ASC");

// Pagination logic
$itemsPerPage = 10; // Adjust as needed
$totalItems = mysqli_num_rows($data_spm);
$totalPages = ceil($totalItems / $itemsPerPage);

$currentMonthPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($currentMonthPage - 1) * $itemsPerPage;

$data_spm = mysqli_query($koneksi, "SELECT * FROM spm
                                INNER JOIN jenis_pelayanan ON spm.jpelayanan_id = jenis_pelayanan.jpelayanan_id
                                INNER JOIN indikator_spm ON spm.indikator_id = indikator_spm.indikator_id
                                WHERE spm.bulan_id = (SELECT bulan_id FROM bulan WHERE bulan_nama = '$currentMonth')
                                AND spm.tahun = $currentYear
                                ORDER BY spm.indikator_id ASC
                                LIMIT $offset, $itemsPerPage");
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
        <div class="col-lg-6">
            <div class="panel panel">

                <div class="panel-heading">
                    <h3 class="panel-title">Edit SPM - Bulan <?php echo $currentMonth; ?> Tahun <?php echo $currentYear; ?></h3>
                </div>
                <div class="panel-body">
                    <div class="pull-left">
                        <div class="form-group">
                            <label>Bulan</label>
                            <select class="form-control" name="bulan" onchange="location = this.value;">
                                <?php
                                foreach ($months as $monthOption) {
                                    $selected = ($monthOption['bulan_nama'] == $currentMonth) ? 'selected' : '';
                                    echo "<option value='?bulan={$monthOption['bulan_nama']}&tahun=$currentYear' $selected>{$monthOption['bulan_nama']}</option>";
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
                                    $selected = ($yearOption['tahun'] == $currentYear) ? 'selected' : '';
                                    echo "<option value='?bulan=$currentMonth&tahun={$yearOption['tahun']}' $selected>{$yearOption['tahun']}</option>";
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
                <form method="post" action="spm_update.php">

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
                            // $no = 1;
                            $data_spm = mysqli_query($koneksi, "SELECT * FROM indikator_spm
                                        INNER JOIN jenis_pelayanan ON indikator_spm.jpelayanan_id = jenis_pelayanan.jpelayanan_id
                                        -- INNER JOIN spm ON indikator_spm.indikator_id = spm.indikator_id
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
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 1) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>    
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 2 -->
                            <tr>
                                <td rowspan="7">2</td>
                                <td rowspan="7">Pelayanan Kesehatan Ibu Bersalin</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 2) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 3 -->
                            <tr>
                                <td rowspan="7">3</td>
                                <td rowspan="7">Pelayanan Kesehatan Bayi Baru Lahir</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 3) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 4 -->
                            <tr>
                                <td rowspan="7">4</td>
                                <td rowspan="7">Pelayanan Kesehatan Balita</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 4) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 5 -->
                            <tr>
                                <td rowspan="6">5</td>
                                <td rowspan="6">Pelayanan Kesehatan pada Usia Pendidikan Dasar</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 5) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 6 -->
                            <tr>
                                <td rowspan="4">6</td>
                                <td rowspan="4">Pelayanan Kesehatan pada Usia Produktif</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 6) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 7 -->
                            <tr>
                                <td rowspan="3">7</td>
                                <td rowspan="3">Pelayanan Kesehatan pada Usia Lanjut</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 7) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 8 -->
                            <tr>
                                <td rowspan="3">8</td>
                                <td rowspan="3">Pelayanan Kesehatan Penderita Hipertensi</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 8) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 9 -->
                            <tr>
                                <td rowspan="3">9</td>
                                <td rowspan="3">Pelayanan Kesehatan Penderita Diabetes Melitus</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 9) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 10 -->
                            <tr>
                                <td rowspan="4">10</td>
                                <td rowspan="4">Pelayanan Kesehatan Orang Dengan Gangguan Jiwa Berat</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 10) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 11 -->
                            <tr>
                                <td rowspan="8">11</td>
                                <td rowspan="8">Pelayanan Kesehatan orang dengan Tuberkulosis (TB)</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 11) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>

                            <!-- Baris untuk nomor dan nama pelayanan 12 -->
                            <tr>
                                <td rowspan="7">12</td>
                                <td rowspan="7">Pelayanan Kesehatan orang dengan Risiko Terinfeksi HIV</td>
                            </tr>
                            <?php mysqli_data_seek($data_spm, 0); ?>
                            <?php while($p = mysqli_fetch_array($data_spm)) : ?>
                                <?php if ($p['jpelayanan_id'] == 12) : ?>
                                    <tr>
                                        <td><?php echo $p['indikator_nama']?></td>
                                        <td><input type="text" class="form-control" name="absolut_<?php echo $p['indikator_id']; ?>" required="required" value="<?php echo $p['absolut_tahunan']; ?>"></td>
                                        <td><?php echo $p['persentase_fix'] ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endwhile; ?>


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