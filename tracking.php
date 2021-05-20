<?php
    include 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <!--<link href="img/logo/logo.png" rel="icon">-->
        <title>Tracking - PT Berkah Permata Logistik</title>
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/ruang-admin.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    <head>
    <body>
        <!--<div class="justify-content-center" style="text-align:center;">
            <a class="navbar-brand" href="#">
                <img src="img/logo-BPL-min.png" width="150">
            </a>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light">     
            <button class="navbar-toggler mx-auto" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation" style="width:60%">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav mx-auto">
                    <a class="nav-item nav-link" href="http://www.berkahpermatalogistik.com/"><b>Home</b></a>
                    <a class="nav-item nav-link" href="http://www.berkahpermatalogistik.com/produk-jasa/"><b>Produk & Jasa</b></a>
                    <a class="nav-item nav-link" href="http://www.berkahpermatalogistik.com/tentang-kami/"><b>Tentang Kami</b></a>
                    <a class="nav-item nav-link" href="http://www.berkahpermatalogistik.com/kontak/"><b>Kontak</b></a>
                    <a class="nav-item nav-link active" href="#" style="color:#2ea3f2"><b>Tracking</b></a>
                </div>
            </div>
        </nav>-->
        

        <?php if(isset($_POST['track'])){
            $spk0 = $_POST['spk'];
            $spk = $spk0;
            $spk = strtoupper($spk);
            $x= " ";
            if (strstr($spk, $x)){
                $spk = str_replace($x, "", $spk);
            }

            $x = ";";
            if (strstr($spk, $x)){
                $spk = explode(';', $spk);
                $countspk = count($spk);
                if($countspk > 10){
                    $countspk = 10;
                }
            }else{
                $spk=$spk;
                $countspk=1;
            }
        ?>
        <div class="container" style="margin-top:40px;">
            <div class="row justify-content-center">
                <!--<div class="col-md-2">
                adasd
                </div>-->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <!--<div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><b>LACAK PENGIRIMAN</b></h1>
                            </div>-->
                            <h5><b>Masukkan No SPK (up to 10 SPK) : </b></h5>
                            <form method="post" action="tracking.php">
                                <div class="form-group">
                                    <textarea class="form-control" name="spk" id="spk" required></textarea>
                                    <p><i>*Gunakan ; (titik koma) tanpa spasi sebagai pemisah NoSPK</i></p>
                                </div>
                                <input type="submit" name="track" id="track" class="btn btn-primary btn-block" value="C A R I">
                            </form>
                        </div>
                    </div>
                </div>
                <!--</div>
                <div class="col-md-2">
                ada
                </div>-->
            </div>
        </div>
        <div class="container" style="margin-top:40px;">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="text-center">
                        <h1 class="h2 text-gray-900 mb-4"><b>HASIL PENCARIAN</b></h1>
                        <form method="post" action="export/laporan.php" target="_blank">
                            <textarea style="display:none" class="form-control" name="spk" id="spk"><?php echo $spk0?></textarea>
                            <button type="submit" class="btn btn-primary btn-icon-split" style="justify-content:left;margin-bottom:20px;" name="print">
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                                <span class="text">Print</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php if($countspk == 1){
                $query0 = mysqli_query($koneksi, "select count(HdId) as jumlah from trans_hd where NoSPK='$spk' and atr1=0");
                $data0 = mysqli_fetch_array($query0);
                
                if($data0['jumlah'] != 0){

                $query = "select * from trans_hd where NoSPK='$spk' and atr1=0";
                //echo $query;
                $fetch = mysqli_query($koneksi, $query);
                while($data=mysqli_fetch_array($fetch)){
                    $nospk = $data['NoSPK'];
                    $armada = $data['total_armada'];
            ?>
            <div class="row justify-content-center">        
                <div class="col-md-9">
                    <div class="card">
                        
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <label class="h5 text-primary"><b>No. SPK : <?php echo $nospk?></b></label>
                            <!--<a class="btn btn-info btn-lg " target="_blank" href="../../export/exportcustomer.php"><i class="fas fa-print"></i></a>-->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php 
                                        $tgl = date("d-M-Y H:i:s", strtotime($data['create_date']));
                                    ?>
                                    <label><b>Tanggal : </b> <?php echo $tgl?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                        $query_c = "select nama from master_customer where CustId='$data[CustId]'";
                                        $fetch_c = mysqli_query($koneksi, $query_c);
                                        $data_c = mysqli_fetch_array($fetch_c)
                                    ?>
                                    <label><b>Customer : </b> <?php echo $data_c['nama']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>No. PO : </b> <?php echo $data['NoPO']?></label>
                                </div>
                                <div class="col-md-6">
                                    <?php 
                                        $tglpo = date("d-M-Y", strtotime($data['tgl_po']));
                                    ?>
                                    <label><b>Tgl. PO : </b> <?php echo $tglpo?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>No. SPK : </b> <?php echo $nospk?></label>
                                </div>
                                <div class="col-md-6">
                                    <?php 
                                        $tglspk = date("d-M-Y", strtotime($data['tgl_spk']));
                                    ?>
                                    <label><b>Tgl. SPK : </b> <?php echo $tglspk?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Kota Asal : </b> <?php echo $data['kota_kirim']?></label>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Kota Tujuan : </b> <?php echo $data['kota_tujuan']?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Barang : </b> <?php echo $data['Barang']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Jumlah Armada : </b> <?php echo $armada?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div style="padding-left:12px;width:105px">
                                    <label ><b>Keterangan : </b></label><br> 
                                </div>
                                <div style="width:auto;">
                                    <?php
                                        $keterangan = $data['keterangan'];
                                        $keterangan = str_replace("%%",PHP_EOL, $keterangan);
                                    ?>
                                    <label style="white-space:pre"><?php echo $keterangan?></label>
                                </div>
                            </div>
                            <?php if($data['OnClose'] == 1){?>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>On Close : </b> <span class='badge badge-success'>Close</span></label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                        $tglclose = date("d-M-Y", strtotime($data['DateOnClose']));
                                    ?>
                                    <label><b>Tgl On Close : </b> <?php echo $tglclose?></label> 
                                </div>
                            </div>
                            <?php }else{ ?>
                                <div class="row">
                                <div class="col-md-6">
                                    <label><b>On Close : </b> <span class='badge badge-info'>Open</span></label>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Tgl On Close : </b> -</label> 
                                </div>
                            </div>
                            <?php } ?>
                            <!--<div class="row">
                                <div class="col-md-6">
                                    <?php
                                        $query_u = "select nama from master_user where UserId='$data[UserId]'";
                                        $fetch_u = mysqli_query($koneksi, $query_u);
                                        $data_u = mysqli_fetch_array($fetch_u)
                                    ?>
                                    <label><b>User : </b> <?php echo $data_u['nama']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>-->

                            <?php for($i=1;$i<=$armada;$i++){?>

                            <div class="" id="btn-1-<?php echo $i?>-1">
                            <button type="button" class="btn btn-primary btn-icon-split btn-block buka" style="justify-content:left;margin-bottom:20px;" onclick="view(<?php echo $i?>, 1)">
                                <span class="icon text-white-50">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                                <span class="text">No. SPK Turunan : <?php echo $nospk?>-<?php echo $i?></span>
                            </button>
                            </div>
                            <div class="hidden" id="btn-1-<?php echo $i?>-2">
                            <button type="button" class="btn btn-primary btn-icon-split btn-block tutup" style="justify-content:left;margin-bottom:20px;" onclick="tutup(<?php echo $i?>, 1)">
                                <span class="icon text-white-50">
                                    <i class="fas fa-angle-up"></i>
                                </span>
                                <span class="text">No. SPK Turunan : <?php echo $nospk?>-<?php echo $i?></span>
                            </button>
                            </div>

                            <?php
                                $query_dtl = "select * from trans_detail where NoSPK='$nospk' and turunan='$i' order by DtlId desc";
                                $fetch_dtl = mysqli_query($koneksi, $query_dtl);
                            ?>

                            <div class="col-md-12 hidden table-responsive" style="margin:30px 0 30px 0" id="body-1-<?php echo $i?>">
                                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                    <thead class="thead-light">
                                        <th>Tgl</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Nopol/Nama Kendaraan</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </thead>
                                    <tbody>
                                        <?php while($data_dtl=mysqli_fetch_array($fetch_dtl)){ 
                                            $query_dtl_s = "select status from master_status where stsId=$data_dtl[StsId]";
                                            $fetch_dtl_s = mysqli_query($koneksi, $query_dtl_s);
                                            $data_dtl_s = mysqli_fetch_array($fetch_dtl_s);
                                        ?>
                                        <tr>
                                        <?php
                                            $tgldtl = date("d-M-Y H:i:s", strtotime($data_dtl['datetime_status']));
                                        ?>
                                            <td><?php echo $tgldtl?></td>
                                            <td><?php echo $data_dtl['jenis_armada']?></td>
                                            <td><?php echo $data_dtl['nopol']?></td>
                                            <td><?php echo $data_dtl_s['status']?></td>
                                            <?php
                                                $keterangan_dtl = $data_dtl['keterangan_kirim'];
                                                $keterangan_dtl = str_replace("%%",PHP_EOL, $keterangan_dtl);
                                            ?>
                                            <td style="white-space:pre"><?php echo $keterangan_dtl ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin:30px 0 30px 0"></div>
            <?php } } else {?>
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <label class="h5 text-primary"><b>No. SPK : <?php echo $spk?></b></label>
                            <!--<a class="btn btn-info btn-lg " target="_blank" href="../../export/exportcustomer.php"><i class="fas fa-print"></i></a>-->
                        </div>
                        <div class="card-body text-center">
                            <p><i>Maaf Data Tidak Ditemukan</i></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } 
            }else{
            for($a=0;$a<$countspk;$a++){
                $query0 = mysqli_query($koneksi, "select count(HdId) as jumlah from trans_hd where NoSPK='$spk[$a]' and atr1=0");
                $data0 = mysqli_fetch_array($query0);
                
                if($data0['jumlah'] != 0){
                $query = "select * from trans_hd where NoSPK='$spk[$a]' and atr1=0";
                //echo $a;
                //echo $query;
                //echo $countspk;
                $fetch = mysqli_query($koneksi, $query);
                while($data=mysqli_fetch_array($fetch)){
                    $nospk = $data['NoSPK'];
                    $armada = $data['total_armada'];
            ?>
            <div class="row justify-content-center">        
                <div class="col-md-9">
                    <div class="card">               
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <label class="h5 text-primary"><b>No. SPK : <?php echo $nospk?></b></label>
                            <!--<a class="btn btn-info btn-lg " target="_blank" href="../../export/exportcustomer.php"><i class="fas fa-print"></i></a>-->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php 
                                        $tgl = date("d-M-Y H:i:s", strtotime($data['create_date']));
                                    ?>
                                    <label><b>Tanggal : </b> <?php echo $tgl?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                        $query_c = "select nama from master_customer where CustId='$data[CustId]'";
                                        $fetch_c = mysqli_query($koneksi, $query_c);
                                        $data_c = mysqli_fetch_array($fetch_c)
                                    ?>
                                    <label><b>Customer : </b> <?php echo $data_c['nama']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>No. PO : </b> <?php echo $data['NoPO']?></label>
                                </div>
                                <div class="col-md-6">
                                    <?php 
                                        $tglpo = date("d-M-Y", strtotime($data['tgl_po']));
                                    ?>
                                    <label><b>Tgl. PO : </b> <?php echo $tglpo?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>No. SPK : </b> <?php echo $nospk?></label>
                                </div>
                                <div class="col-md-6">
                                    <?php 
                                        $tglspk = date("d-M-Y", strtotime($data['tgl_spk']));
                                    ?>
                                    <label><b>Tgl. SPK : </b> <?php echo $tglspk?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Kota Asal : </b> <?php echo $data['kota_kirim']?></label>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Kota Tujuan : </b> <?php echo $data['kota_tujuan']?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Barang : </b> <?php echo $data['Barang']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Jumlah Armada : </b> <?php echo $armada?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div style="padding-left:12px;width:105px">
                                    <label ><b>Keterangan : </b></label><br> 
                                </div>
                                <div style="width:auto;">
                                    <?php
                                        $keterangan = $data['keterangan'];
                                        $keterangan = str_replace("%%",PHP_EOL, $keterangan);
                                    ?>
                                    <label style="white-space:pre"><?php echo $keterangan?></label>
                                </div>
                            </div>
                            <?php if($data['OnClose'] == 1){?>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>On Close : </b> <span class='badge badge-success'>Close</span></label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                        $tglclose = date("d-M-Y", strtotime($data['DateOnClose']));
                                    ?>
                                    <label><b>Tgl On Close : </b> <?php echo $tglclose?></label> 
                                </div>
                            </div>
                            <?php }else{ ?>
                                <div class="row">
                                <div class="col-md-6">
                                    <label><b>On Close : </b> <span class='badge badge-info'>Open</span></label>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Tgl On Close : </b> -</label> 
                                </div>
                            </div>
                            <?php } ?>
                            <!--<div class="row">
                                <div class="col-md-6">
                                    <?php
                                        $query_u = "select nama from master_user where UserId='$data[UserId]'";
                                        $fetch_u = mysqli_query($koneksi, $query_u);
                                        $data_u = mysqli_fetch_array($fetch_u)
                                    ?>
                                    <label><b>User : </b> <?php echo $data_u['nama']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>-->

                            <?php for($i=1;$i<=$armada;$i++){?>

                            <div class="" id="btn-<?php echo $a+1?>-<?php echo $i?>-1">
                            <button type="button" class="btn btn-primary btn-icon-split btn-block buka" style="justify-content:left;margin-bottom:20px;" onclick="view(<?php echo $i?>, <?php echo $a+1?>)">
                                <span class="icon text-white-50">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                                <span class="text">No. SPK Turunan : <?php echo $nospk?>-<?php echo $i?></span>
                            </button>
                            </div>
                            <div class="hidden" id="btn-<?php echo $a+1?>-<?php echo $i?>-2">
                            <button type="button" class="btn btn-primary btn-icon-split btn-block tutup" style="justify-content:left;margin-bottom:20px;" onclick="tutup(<?php echo $i?>, <?php echo $a+1?>)">
                                <span class="icon text-white-50">
                                    <i class="fas fa-angle-up"></i>
                                </span>
                                <span class="text">No. SPK Turunan : <?php echo $nospk?>-<?php echo $i?></span>
                            </button>
                            </div>

                            <?php
                                $query_dtl = "select * from trans_detail where NoSPK='$nospk' and turunan='$i' order by DtlId desc";
                                $fetch_dtl = mysqli_query($koneksi, $query_dtl);
                            ?>

                            <div class="col-md-12 hidden table-responsive" style="margin:30px 0 30px 0" id="body-<?php echo $a+1?>-<?php echo $i?>">
                                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                    <thead class="thead-light">
                                        <th>Tgl</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Nopol/Nama Kendaraan</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </thead>
                                    <tbody>
                                        <?php while($data_dtl=mysqli_fetch_array($fetch_dtl)){ 
                                            $query_dtl_s = "select status from master_status where stsId=$data_dtl[StsId]";
                                            $fetch_dtl_s = mysqli_query($koneksi, $query_dtl_s);
                                            $data_dtl_s = mysqli_fetch_array($fetch_dtl_s);
                                        ?>
                                        <tr>
                                        <?php
                                            $tgldtl = date("d-M-Y H:i:s", strtotime($data_dtl['datetime_status']));
                                        ?>
                                            <td><?php echo $tgldtl?></td>
                                            <td><?php echo $data_dtl['jenis_armada']?></td>
                                            <td><?php echo $data_dtl['nopol']?></td>
                                            <td><?php echo $data_dtl_s['status']?></td>
                                            <?php
                                                $keterangan_dtl = $data_dtl['keterangan_kirim'];
                                                $keterangan_dtl = str_replace("%%",PHP_EOL, $keterangan_dtl);
                                            ?>
                                            <td style="white-space:pre"><?php echo $keterangan_dtl ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin:30px 0 30px 0"></div>
            <?php } } else { ?>
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <label class="h5 text-primary"><b>No. SPK : <?php echo $spk[$a]?></b></label>
                            <!--<a class="btn btn-info btn-lg " target="_blank" href="../../export/exportcustomer.php"><i class="fas fa-print"></i></a>-->
                        </div>
                        <div class="card-body text-center">
                            <p><i>Maaf Data Tidak Ditemukan</i></p>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin:30px 0 30px 0"></div>
            <?php } } }?>
        </div>
        <?php }elseif(isset($_GET['spk'])){
            $spk0 = $_GET['spk'];
            $spk = $spk0;
            $spk = strtoupper($spk);
            $x= " ";
            if (strstr($spk, $x)){
                $spk = str_replace($x, "", $spk);
            }

            $x = ";";
            if (strstr($spk, $x)){
                $spk = explode(';', $spk);
                $countspk = count($spk);
                if($countspk > 10){
                    $countspk = 10;
                }
            }else{
                $spk=$spk;
                $countspk=1;
            }
        ?>
        <div class="container" style="margin-top:40px;">
            <div class="row justify-content-center">
                <!--<div class="col-md-2">
                adasd
                </div>-->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <!--<div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><b>LACAK PENGIRIMAN</b></h1>
                            </div>-->
                            <h5><b>Masukkan No SPK (up to 10 SPK) : </b></h5>
                            <form method="post" action="tracking.php">
                                <div class="form-group">
                                    <textarea class="form-control" name="spk" id="spk" required></textarea>
                                    <p><i>*Gunakan ; (titik koma) tanpa spasi sebagai pemisah NoSPK</i></p>
                                </div>
                                <input type="submit" name="track" id="track" class="btn btn-primary btn-block" value="C A R I">
                            </form>
                        </div>
                    </div>
                </div>
                <!--</div>
                <div class="col-md-2">
                ada
                </div>-->
            </div>
        </div>
        <div class="container" style="margin-top:40px;">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="text-center">
                        <h1 class="h2 text-gray-900 mb-4"><b>HASIL PENCARIAN</b></h1>
                        <form method="post" action="export/laporan.php" target="_blank">
                            <textarea style="display:none" class="form-control" name="spk" id="spk"><?php echo $spk0?></textarea>
                            <button type="submit" class="btn btn-primary btn-icon-split" style="justify-content:left;margin-bottom:20px;" name="print">
                                <span class="icon text-white-50">
                                    <i class="fas fa-print"></i>
                                </span>
                                <span class="text">Print</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php if($countspk == 1){
                $query0 = mysqli_query($koneksi, "select count(HdId) as jumlah from trans_hd where NoSPK='$spk' and atr1=0");
                $data0 = mysqli_fetch_array($query0);
                
                if($data0['jumlah'] != 0){

                $query = "select * from trans_hd where NoSPK='$spk' and atr1=0";
                //echo $query;
                $fetch = mysqli_query($koneksi, $query);
                while($data=mysqli_fetch_array($fetch)){
                    $nospk = $data['NoSPK'];
                    $armada = $data['total_armada'];
            ?>
            <div class="row justify-content-center">        
                <div class="col-md-9">
                    <div class="card">
                        
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <label class="h5 text-primary"><b>No. SPK : <?php echo $nospk?></b></label>
                            <!--<a class="btn btn-info btn-lg " target="_blank" href="../../export/exportcustomer.php"><i class="fas fa-print"></i></a>-->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php 
                                        $tgl = date("d-M-Y H:i:s", strtotime($data['create_date']));
                                    ?>
                                    <label><b>Tanggal : </b> <?php echo $tgl?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                        $query_c = "select nama from master_customer where CustId='$data[CustId]'";
                                        $fetch_c = mysqli_query($koneksi, $query_c);
                                        $data_c = mysqli_fetch_array($fetch_c)
                                    ?>
                                    <label><b>Customer : </b> <?php echo $data_c['nama']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>No. PO : </b> <?php echo $data['NoPO']?></label>
                                </div>
                                <div class="col-md-6">
                                    <?php 
                                        $tglpo = date("d-M-Y", strtotime($data['tgl_po']));
                                    ?>
                                    <label><b>Tgl. PO : </b> <?php echo $tglpo?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>No. SPK : </b> <?php echo $nospk?></label>
                                </div>
                                <div class="col-md-6">
                                    <?php 
                                        $tglspk = date("d-M-Y", strtotime($data['tgl_spk']));
                                    ?>
                                    <label><b>Tgl. SPK : </b> <?php echo $tglspk?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Kota Asal : </b> <?php echo $data['kota_kirim']?></label>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Kota Tujuan : </b> <?php echo $data['kota_tujuan']?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Barang : </b> <?php echo $data['Barang']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Jumlah Armada : </b> <?php echo $armada?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div style="padding-left:12px;width:105px">
                                    <label ><b>Keterangan : </b></label><br> 
                                </div>
                                <div style="width:auto;">
                                    <?php
                                        $keterangan = $data['keterangan'];
                                        $keterangan = str_replace("%%",PHP_EOL, $keterangan);
                                    ?>
                                    <label style="white-space:pre"><?php echo $keterangan?></label>
                                </div>
                            </div>
                            <?php if($data['OnClose'] == 1){?>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>On Close : </b> <span class='badge badge-success'>Close</span></label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                        $tglclose = date("d-M-Y", strtotime($data['DateOnClose']));
                                    ?>
                                    <label><b>Tgl On Close : </b> <?php echo $tglclose?></label> 
                                </div>
                            </div>
                            <?php }else{ ?>
                                <div class="row">
                                <div class="col-md-6">
                                    <label><b>On Close : </b> <span class='badge badge-info'>Open</span></label>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Tgl On Close : </b> -</label> 
                                </div>
                            </div>
                            <?php } ?>
                            <!--<div class="row">
                                <div class="col-md-6">
                                    <?php
                                        $query_u = "select nama from master_user where UserId='$data[UserId]'";
                                        $fetch_u = mysqli_query($koneksi, $query_u);
                                        $data_u = mysqli_fetch_array($fetch_u)
                                    ?>
                                    <label><b>User : </b> <?php echo $data_u['nama']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>-->

                            <?php for($i=1;$i<=$armada;$i++){?>

                            <div class="" id="btn-1-<?php echo $i?>-1">
                            <button type="button" class="btn btn-primary btn-icon-split btn-block buka" style="justify-content:left;margin-bottom:20px;" onclick="view(<?php echo $i?>, 1)">
                                <span class="icon text-white-50">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                                <span class="text">No. SPK Turunan : <?php echo $nospk?>-<?php echo $i?></span>
                            </button>
                            </div>
                            <div class="hidden" id="btn-1-<?php echo $i?>-2">
                            <button type="button" class="btn btn-primary btn-icon-split btn-block tutup" style="justify-content:left;margin-bottom:20px;" onclick="tutup(<?php echo $i?>, 1)">
                                <span class="icon text-white-50">
                                    <i class="fas fa-angle-up"></i>
                                </span>
                                <span class="text">No. SPK Turunan : <?php echo $nospk?>-<?php echo $i?></span>
                            </button>
                            </div>

                            <?php
                                $query_dtl = "select * from trans_detail where NoSPK='$nospk' and turunan='$i' order by DtlId desc";
                                $fetch_dtl = mysqli_query($koneksi, $query_dtl);
                            ?>

                            <div class="col-md-12 hidden table-responsive" style="margin:30px 0 30px 0" id="body-1-<?php echo $i?>">
                                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                    <thead class="thead-light">
                                        <th>Tgl</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Nopol/Nama Kendaraan</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </thead>
                                    <tbody>
                                        <?php while($data_dtl=mysqli_fetch_array($fetch_dtl)){ 
                                            $query_dtl_s = "select status from master_status where stsId=$data_dtl[StsId]";
                                            $fetch_dtl_s = mysqli_query($koneksi, $query_dtl_s);
                                            $data_dtl_s = mysqli_fetch_array($fetch_dtl_s);
                                        ?>
                                        <tr>
                                        <?php
                                            $tgldtl = date("d-M-Y H:i:s", strtotime($data_dtl['datetime_status']));
                                        ?>
                                            <td><?php echo $tgldtl?></td>
                                            <td><?php echo $data_dtl['jenis_armada']?></td>
                                            <td><?php echo $data_dtl['nopol']?></td>
                                            <td><?php echo $data_dtl_s['status']?></td>
                                            <?php
                                                $keterangan_dtl = $data_dtl['keterangan_kirim'];
                                                $keterangan_dtl = str_replace("%%",PHP_EOL, $keterangan_dtl);
                                            ?>
                                            <td style="white-space:pre"><?php echo $keterangan_dtl ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin:30px 0 30px 0"></div>
            <?php } } else {?>
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <label class="h5 text-primary"><b>No. SPK : <?php echo $spk?></b></label>
                            <!--<a class="btn btn-info btn-lg " target="_blank" href="../../export/exportcustomer.php"><i class="fas fa-print"></i></a>-->
                        </div>
                        <div class="card-body text-center">
                            <p><i>Maaf Data Tidak Ditemukan</i></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php } 
            }else{
            for($a=0;$a<$countspk;$a++){
                $query0 = mysqli_query($koneksi, "select count(HdId) as jumlah from trans_hd where NoSPK='$spk[$a]' and atr1=0");
                $data0 = mysqli_fetch_array($query0);
                
                if($data0['jumlah'] != 0){
                $query = "select * from trans_hd where NoSPK='$spk[$a]' and atr1=0";
                //echo $a;
                //echo $query;
                //echo $countspk;
                $fetch = mysqli_query($koneksi, $query);
                while($data=mysqli_fetch_array($fetch)){
                    $nospk = $data['NoSPK'];
                    $armada = $data['total_armada'];
            ?>
            <div class="row justify-content-center">        
                <div class="col-md-9">
                    <div class="card">               
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <label class="h5 text-primary"><b>No. SPK : <?php echo $nospk?></b></label>
                            <!--<a class="btn btn-info btn-lg " target="_blank" href="../../export/exportcustomer.php"><i class="fas fa-print"></i></a>-->
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php 
                                        $tgl = date("d-M-Y H:i:s", strtotime($data['create_date']));
                                    ?>
                                    <label><b>Tanggal : </b> <?php echo $tgl?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                        $query_c = "select nama from master_customer where CustId='$data[CustId]'";
                                        $fetch_c = mysqli_query($koneksi, $query_c);
                                        $data_c = mysqli_fetch_array($fetch_c)
                                    ?>
                                    <label><b>Customer : </b> <?php echo $data_c['nama']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>No. PO : </b> <?php echo $data['NoPO']?></label>
                                </div>
                                <div class="col-md-6">
                                    <?php 
                                        $tglpo = date("d-M-Y", strtotime($data['tgl_po']));
                                    ?>
                                    <label><b>Tgl. PO : </b> <?php echo $tglpo?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>No. SPK : </b> <?php echo $nospk?></label>
                                </div>
                                <div class="col-md-6">
                                    <?php 
                                        $tglspk = date("d-M-Y", strtotime($data['tgl_spk']));
                                    ?>
                                    <label><b>Tgl. SPK : </b> <?php echo $tglspk?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Kota Asal : </b> <?php echo $data['kota_kirim']?></label>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Kota Tujuan : </b> <?php echo $data['kota_tujuan']?></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Barang : </b> <?php echo $data['Barang']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>Jumlah Armada : </b> <?php echo $armada?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>
                            <div class="row">
                                <div style="padding-left:12px;width:105px">
                                    <label ><b>Keterangan : </b></label><br> 
                                </div>
                                <div style="width:auto;">
                                    <?php
                                        $keterangan = $data['keterangan'];
                                        $keterangan = str_replace("%%",PHP_EOL, $keterangan);
                                    ?>
                                    <label style="white-space:pre"><?php echo $keterangan?></label>
                                </div>
                            </div>
                            <?php if($data['OnClose'] == 1){?>
                            <div class="row">
                                <div class="col-md-6">
                                    <label><b>On Close : </b> <span class='badge badge-success'>Close</span></label>
                                </div>
                                <div class="col-md-6">
                                    <?php
                                        $tglclose = date("d-M-Y", strtotime($data['DateOnClose']));
                                    ?>
                                    <label><b>Tgl On Close : </b> <?php echo $tglclose?></label> 
                                </div>
                            </div>
                            <?php }else{ ?>
                                <div class="row">
                                <div class="col-md-6">
                                    <label><b>On Close : </b> <span class='badge badge-info'>Open</span></label>
                                </div>
                                <div class="col-md-6">
                                    <label><b>Tgl On Close : </b> -</label> 
                                </div>
                            </div>
                            <?php } ?>
                            <!--<div class="row">
                                <div class="col-md-6">
                                    <?php
                                        $query_u = "select nama from master_user where UserId='$data[UserId]'";
                                        $fetch_u = mysqli_query($koneksi, $query_u);
                                        $data_u = mysqli_fetch_array($fetch_u)
                                    ?>
                                    <label><b>User : </b> <?php echo $data_u['nama']?></label>
                                </div>
                                <div class="col-md-6">  
                                </div>
                            </div>-->

                            <?php for($i=1;$i<=$armada;$i++){?>

                            <div class="" id="btn-<?php echo $a+1?>-<?php echo $i?>-1">
                            <button type="button" class="btn btn-primary btn-icon-split btn-block buka" style="justify-content:left;margin-bottom:20px;" onclick="view(<?php echo $i?>, <?php echo $a+1?>)">
                                <span class="icon text-white-50">
                                    <i class="fas fa-angle-down"></i>
                                </span>
                                <span class="text">No. SPK Turunan : <?php echo $nospk?>-<?php echo $i?></span>
                            </button>
                            </div>
                            <div class="hidden" id="btn-<?php echo $a+1?>-<?php echo $i?>-2">
                            <button type="button" class="btn btn-primary btn-icon-split btn-block tutup" style="justify-content:left;margin-bottom:20px;" onclick="tutup(<?php echo $i?>, <?php echo $a+1?>)">
                                <span class="icon text-white-50">
                                    <i class="fas fa-angle-up"></i>
                                </span>
                                <span class="text">No. SPK Turunan : <?php echo $nospk?>-<?php echo $i?></span>
                            </button>
                            </div>

                            <?php
                                $query_dtl = "select * from trans_detail where NoSPK='$nospk' and turunan='$i' order by DtlId desc";
                                $fetch_dtl = mysqli_query($koneksi, $query_dtl);
                            ?>

                            <div class="col-md-12 hidden table-responsive" style="margin:30px 0 30px 0" id="body-<?php echo $a+1?>-<?php echo $i?>">
                                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                    <thead class="thead-light">
                                        <th>Tgl</th>
                                        <th>Jenis Kendaraan</th>
                                        <th>Nopol/Nama Kendaraan</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </thead>
                                    <tbody>
                                        <?php while($data_dtl=mysqli_fetch_array($fetch_dtl)){ 
                                            $query_dtl_s = "select status from master_status where stsId=$data_dtl[StsId]";
                                            $fetch_dtl_s = mysqli_query($koneksi, $query_dtl_s);
                                            $data_dtl_s = mysqli_fetch_array($fetch_dtl_s);
                                        ?>
                                        <tr>
                                        <?php
                                            $tgldtl = date("d-M-Y H:i:s", strtotime($data_dtl['datetime_status']));
                                        ?>
                                            <td><?php echo $tgldtl?></td>
                                            <td><?php echo $data_dtl['jenis_armada']?></td>
                                            <td><?php echo $data_dtl['nopol']?></td>
                                            <td><?php echo $data_dtl_s['status']?></td>
                                            <?php
                                                $keterangan_dtl = $data_dtl['keterangan_kirim'];
                                                $keterangan_dtl = str_replace("%%",PHP_EOL, $keterangan_dtl);
                                            ?>
                                            <td style="white-space:pre"><?php echo $keterangan_dtl ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin:30px 0 30px 0"></div>
            <?php } } else { ?>
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <label class="h5 text-primary"><b>No. SPK : <?php echo $spk[$a]?></b></label>
                            <!--<a class="btn btn-info btn-lg " target="_blank" href="../../export/exportcustomer.php"><i class="fas fa-print"></i></a>-->
                        </div>
                        <div class="card-body text-center">
                            <p><i>Maaf Data Tidak Ditemukan</i></p>
                        </div>
                    </div>
                </div>
            </div>
            <div style="margin:30px 0 30px 0"></div>
            <?php } } }?>
        </div>
        <?php }else{?>
            <div class="container" style="margin-top:40px;">
            <div class="row justify-content-center">
                <!--<div class="col-md-2">
                adasd
                </div>-->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <!--<div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4"><b>LACAK PENGIRIMAN</b></h1>
                            </div>-->
                            <h5><b>Masukkan No SPK (up to 10 SPK) : </b></h5>
                            <form method="post" action="tracking.php">
                                <div class="form-group">
                                    <textarea class="form-control" name="spk" id="spk" required></textarea>
                                    <p><i>*Gunakan ; (titik koma) tanpa spasi sebagai pemisah NoSPK</i></p>
                                </div>
                                <input type="submit" name="track" id="track" class="btn btn-primary btn-block" value="C A R I">
                            </form>
                        </div>
                    </div>
                </div>
                <!--</div>
                <div class="col-md-2">
                ada
                </div>-->
            </div>
        </div>
        <?php }?>

        <script src="vendor/jquery/jquery.min.js"></script>

        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <script src="js/ruang-admin.min.js"></script>

        <script src="vendor/chart.js/Chart.min.js"></script>

        <script src="js/demo/chart-area-demo.js"></script>

        <script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

        <script src="vendor/clock-picker/clockpicker.js"></script>

        <script src="vendor/select2/dist/js/select2.min.js"></script>

        <script>
            function view(x, y){
                //var id = $(this).data("id");
                var id = x;
                var page = y;
                //document.write(id);
                var a = document.getElementById("btn-"+page+"-"+id+"-1");
                var b = document.getElementById("btn-"+page+"-"+id+"-2");
                var c = document.getElementById("body-"+page+"-"+id);
                a.classList.add("hidden");
                b.classList.remove("hidden");
                c.classList.remove("hidden");
            };

            function tutup(x, y){
                //var id = $(this).data("id");
                var id = x;
                var page = y;
                var a = document.getElementById("btn-"+page+"-"+id+"-1");
                var b = document.getElementById("btn-"+page+"-"+id+"-2");
                var c = document.getElementById("body-"+page+"-"+id);
                a.classList.remove("hidden");
                b.classList.add("hidden");
                c.classList.add("hidden");
            };
        </script>
        <!--<script>
            var input =  document.getElementById('spk');
            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementById("track").click();
                }
            });
        </script>-->
    </body>
</html>