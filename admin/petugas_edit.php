<?php include 'header.php'; ?>

<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="breadcome-heading">
                                <h4 style="margin-bottom: 0px">Edit Petugas</h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <ul class="breadcome-menu" style="padding-top: 0px">
                                <li><a href="#">Home</a> <span class="bread-slash">/</span></li>
                                <li><span class="bread-blod">Petugas</span></li>
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
                    <h3 class="panel-title">Edit Petugas</h3>
                </div>
                <div class="panel-body">

                    <div class="pull-right">            
                        <a href="petugas.php" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                    <br>
                    <br>

                    <?php 
                    $id = $_GET['id'];              
                    $data_petugas = mysqli_query($koneksi, "SELECT * FROM petugas WHERE petugas_id='$id'");
                    while($d_petugas = mysqli_fetch_array($data_petugas)){
                        ?>

                        <form method="post" action="petugas_update.php" enctype="multipart/form-data">

                            <div class="form-group">
                                <label>Nama</label>
                                <input type="hidden" name="id" value="<?php echo $d_petugas['petugas_id']; ?>">
                                <input type="text" class="form-control" name="nama" required="required" value="<?php echo $d_petugas['petugas_nama']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" required="required" value="<?php echo $d_petugas['petugas_username']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                                <small>Kosongkan jika tidak ingin mengubah password.</small>
                            </div>
                            <div class="form-group">
                                <label>Program</label>
                                <select class="form-control" name="kamar" required="required">
                                        <?php
                                            $data_kamar = mysqli_query($koneksi, "SELECT * FROM kamar");
                                            while ($d_kamar = mysqli_fetch_array($data_kamar)) {
                                                $selected = ($d_kamar['kamar_id'] == $d_petugas['kamar_id']) ? 'selected' : '';
                                        ?>
                                                <option value="<?php echo $d_kamar['kamar_id']; ?>" <?php echo $selected; ?>><?php echo $d_kamar['kamar_nama']; ?></option>
                                        <?php
                                            }
                                        ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="foto">
                                <small>Kosongkan jika tidak ingin mengubah foto.</small>
                            </div>

                            <div class="form-group">
                                <label></label>
                                <input type="submit" class="btn btn-primary" value="Simpan">
                            </div>

                        </form>

                        <?php 
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>


</div>


<?php include 'footer.php'; ?>