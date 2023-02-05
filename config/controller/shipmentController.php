<?php
  include '../koneksi.php';
  date_default_timezone_set("Asia/Jakarta");
	$datetime = date('Y-m-d H:i:s');
  $date = date('Y-m-d');
	$year = date('Y', strtotime($datetime));
  session_save_path('../../tmp');
	session_start();
  //$s_username = $_SESSION['username'];
  $s_id = $_SESSION['id'];
  $akses = $_SESSION['hak_akses'];

  $master_query = "select * from trans_shipment where is_delete=0";
  $fetch_master_query = mysqli_query($koneksi, $master_query);

  // ============= tambah status shipment ===============
  if (isset($_POST['inputShipment'])) {
    // print_r($_POST);
    $kodeShipment = $_POST['kodeShipment'];
    $customer = $_POST['customer'];
    $pib = $_POST['pib'];
    $billLanding = $_POST['billLanding'];

    $shipmentTerm = $_POST['shipmentTerm'];
    $loadType = $_POST['loadType'];
    $qty = (double)$_POST['qty'];
    $unit = $_POST['unit'];

    $biayaFreight = (double)$_POST['biayaFreight'];
    $kurs = (double)$_POST['kurs'];
    $tglKurs = $_POST['tglKurs'];
    if ($tglKurs == '' || is_null($tglKurs)) {
      $tglKurs = null;
    } else {
      $tglKurs = str_replace('/', '-', $tglKurs);
      $tglKurs = date('Y-m-d', strtotime($tglKurs));
    }
    $totalFreight = $biayaFreight * $kurs;

    $namaBiayaHandling = $_POST['namaBiayaHandling'];
    $biayaHandling = $_POST['biayaHandling'];
    $sumBiayaHandling = array_sum($biayaHandling);

    $save = [$datetime, $kodeShipment, $s_id, $customer, $pib, $billLanding, $shipmentTerm, $loadType, $qty, $unit, $biayaFreight, $totalFreight, $tglKurs, $kurs, $namaBiayaHandling, $biayaHandling, $sumBiayaHandling];
    $j=0;

    while($data = mysqli_fetch_array($fetch_master_query)){
      if(strtolower($kodeShipment) == strtolower($data['shipment_order'])) {
        $j=1;
      }
      elseif (strtolower($pib) == strtolower($data['pib'])) {
        $j=2;
      }
      elseif (strtolower($billLanding) == strtolower($data['shipment_order'])) {
        $j=3;
      }
    }

    if (!array_key_exists('customer',$_POST)) {
      $j=4;
    } 
    elseif (!array_key_exists('shipmentTerm',$_POST)) {
      $j=5;
    }
    elseif (!array_key_exists('loadType',$_POST)) {
      $j=6;
    }
    elseif (!array_key_exists('unit',$_POST)) {
      $j=7;
    }
    elseif (is_null($_POST['kodeShipment'])) {
      $j=8;
    }
    elseif (!is_null($_POST['tglKurs'])) {
      if (date('Y-m-d') < $tglKurs) {
        $j=9;
      }
    }




    foreach ($namaBiayaHandling as $x) {
      echo $x;
    }

    echo mysqli_query($koneksi, "select lastval()");
    if($j == 0){
      if (is_null($tglKurs)) {
        $query = "insert into trans_shipment values (null, '$datetime', '$kodeShipment', '$s_id', '$customer', null, '$pib', '$billLanding', '$shipmentTerm', '$loadType', '$qty', '$unit', '1', '$biayaFreight', '$totalFreight', null, '$kurs', '0', null, '0' , null, null, '$datetime', null, null, null)";
      } else {
        $query = "insert into trans_shipment values (null, '$datetime', '$kodeShipment', '$s_id', '$customer', null, '$pib', '$billLanding', '$shipmentTerm', '$loadType', '$qty', '$unit', '1', '$biayaFreight', '$totalFreight', '$tglKurs', '$kurs', '0', null, '0' , null, null, '$datetime', null, null, null)";
      }
      $result = mysqli_query($koneksi, $query);
      
      if($result) {
        $lastInsertedId = $koneksi->insert_id;
        for ($i=0; $i < count($namaBiayaHandling); $i++) { 
          echo $biayaHandling[$i];
          if($biayaHandling[$i] != '' || $namaBiayaHandling[$i] != '') {
            $namaBiayaHandlingTemp = $namaBiayaHandling[$i];
            $biayaHandlingTemp = $biayaHandling[$i];
            $queryShipmentHandling = "insert into trans_shipment_handling values (null, '$lastInsertedId', '$datetime', '$namaBiayaHandlingTemp', '$biayaHandlingTemp', null, null, null)";
            $resultx = mysqli_query($koneksi, $queryShipmentHandling);
          }
          // echo $queryShipmentHandling;
        }
      }
          

      if ($result) {
        if ($akses == 'Admin') {
          $save = [];
          header("location:../../view/admin/shipment.php?tahun=".$year);
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        } else {
          $save = [];
          header("location:../../view/user/shipment.php?tahun=".$year);
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';		
        }
          // echo 'aaa';
       } else {
        if ($akses == 'Admin') {
          header("location:../../view/admin/inputShipment.php?tahun=".$year);
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
          $_SESSION['id_pesan1'] = $save;			
        } else {
          header("location:../../view/user/inputShipment.php?tahun=".$year);
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
          $_SESSION['id_pesan1'] = $save;
        }
          // echo 'bbb';
      }
    } 
    elseif ($j==1) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment Order Sudah Ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      } else {
        header("location:../../view/user/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment Order Sudah Ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      }
    }
    elseif ($j==2) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Pemberitahuan Impor Barang (PIB) sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      } else {
        header("location:../../view/user/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Pemberitahuan Impor Barang (PIB) sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      }
    }
    elseif ($j==3) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Bill of Landing (BL) sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      } else {
        header("location:../../view/user/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Bill of Landing (BL) sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      }
    }
    elseif ($j==4) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Customer Wajib Diisi !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      } else {
        header("location:../../view/user/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Customer Wajib Diisi !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      }
    }
    elseif ($j==5) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment Term Wajib Diisi !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      } else {
        header("location:../../view/user/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment Term Wajib Diisi !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      }
    }
    elseif ($j==6) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Load Type Wajib Diisi !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      } else {
        header("location:../../view/user/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Load Type Wajib Diisi !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      }
    }
    elseif ($j==7) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Load Type Wajib Diisi !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      } else {
        header("location:../../view/user/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Load Type Wajib Diisi !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      }
    }
    elseif ($j==8) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Kode Shipment Wajib Diisi !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      } else {
        header("location:../../view/user/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Kode Shipment Wajib Diisi !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      }
    }
    elseif ($j==9) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Tanggal tidak boleh lebih besar dari hari ini !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      } else {
        header("location:../../view/user/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Tanggal tidak boleh lebih besar dari hari ini !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      }
    }
    else {
      if ($akses == 'Admin') {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      } else {
        header("location:../../view/user/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
      }
    }


  // ============= edit shipment ===============
  
  } elseif (isset($_POST['editShipment'])) {
    $id = $_POST['shipmentId'];
    // echo $id;
    $kodeShipment = $_POST['kodeShipment'];
    $customer = $_POST['customer'];
    $pib = $_POST['pib'];
    $billLanding = $_POST['billLanding'];

    $shipmentTerm = $_POST['shipmentTerm'];
    $loadType = $_POST['loadType'];
    $qty = (double)$_POST['qty'];
    $unit = $_POST['unit'];

    $biayaFreight = (double)$_POST['biayaFreight'];
    $kurs = (double)$_POST['kurs'];
    $tglKurs = $_POST['tglKurs'];
    $tglKurs = str_replace('/', '-', $tglKurs);
    $tglKurs = date('Y-m-d', strtotime($tglKurs));
    $totalFreight = $biayaFreight * $kurs;

    $biayaHandlingId = $_POST['biayaHandlingId'];
    $namaBiayaHandling = $_POST['namaBiayaHandling'];
    $biayaHandling = $_POST['biayaHandling'];
    $sumBiayaHandling = array_sum($biayaHandling);

    $j=0;

    while($data = mysqli_fetch_array($fetch_master_query)){
      if(strtolower($kodeShipment) == strtolower($data['shipment_order']) && $data['id'] != $id) {
        $j=1;
      }
      elseif (strtolower($pib) == strtolower($data['pib']) && $data['id'] != $id) {
        $j=2;
      }
      elseif (strtolower($billLanding) == strtolower($data['bl']) && $data['id'] != $id) {
        $j=3;
      }
    }

    if($j == 0){
      // $query = "insert into trans_shipment values (null, '$datetime', '$kodeShipment', '$s_id', '$customer', null, '$pib', '$billLanding', '$shipmentTerm', '$loadType', '$qty', '$unit', '1', '$biayaFreight', '$totalFreight', '$tglKurs', '$kurs', '0', null, '0' , null, null, '$datetime', null, null, null)";
      $query = "update trans_shipment set shipment_order='$kodeShipment', UserId='$s_id', pib='$pib', bl='$billLanding', id_shipment_term='$shipmentTerm', id_shipment_load_type='$loadType', quantity='$qty', unit='$unit', freight='$biayaFreight', total_freight='$totalFreight', kurs_date='$tglKurs', nilai_kurs='$kurs', last_update='$datetime' where id='$id'";
      // printf($query);
      $result = mysqli_query($koneksi, $query);
      
      if ($result) {
        // $lastInsertedId = $koneksi->insert_id;
        for ($i=0; $i < count($biayaHandlingId); $i++) { 
          // echo ($biayaHandlingId[$i] == ' ' ? 'true' : 'false');
          if ($biayaHandlingId[$i] != '') {
            if ($biayaHandling[$i] != '' || $namaBiayaHandling[$i] != '') {
              $biayaHandlingIdTemp = $biayaHandlingId[$i];
              $namaBiayaHandlingTemp = $namaBiayaHandling[$i];
              $biayaHandlingTemp = $biayaHandling[$i];
              // $queryShipmentHandling = "insert into trans_shipment_handling values (null, '$lastInsertedId', '$datetime', '$namaBiayaHandlingTemp', '$biayaHandlingTemp', null, null, null)";
              $queryShipmentHandling = "update trans_shipment_handling set keterangan_biaya='$namaBiayaHandlingTemp', nominal='$biayaHandlingTemp' where id='$biayaHandlingIdTemp'";
              $resultx = mysqli_query($koneksi, $queryShipmentHandling);
            }  
          } else {
            if ($biayaHandling[$i] != '' || $namaBiayaHandling[$i] != '') {
              $namaBiayaHandlingTemp = $namaBiayaHandling[$i];
              $biayaHandlingTemp = $biayaHandling[$i];
              $queryShipmentHandling = "insert into trans_shipment_handling values (null, '$id', '$datetime', '$namaBiayaHandlingTemp', '$biayaHandlingTemp', null, null, null)";
              $resultx = mysqli_query($koneksi, $queryShipmentHandling);
            }
          }
          // echo $queryShipmentHandling;
        }
      }
          

      if ($result) {
        if ($akses == 'Admin') {
          header("location:../../view/admin/shipment.php?tahun=".$year);
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        } else {
          header("location:../../view/user/shipment.php?tahun=".$year);
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }
          // echo 'aaa';
       } else {
        if ($akses == 'Admin') {
          header("location:../../view/admin/editShipment.php?id=$id");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
        } else {
          header("location:../../view/user/editShipment.php?id=$id");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }
          // echo 'bbb';
      }
    }
    elseif ($j==1) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/editShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Kode Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      } else {
        header("location:../../view/user/editShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Kode Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      }
    }
    elseif ($j==2) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/editShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Pemberitahuan Impor Barang (PIB) sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      } else {
        header("location:../../view/user/editShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Pemberitahuan Impor Barang (PIB) sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      }
    }
    elseif ($j==3) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/editShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Bill of Landing (BL) sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      } else {
        header("location:../../view/user/editShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Bill of Landing (BL) sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      }
    }
    else {
      if ($akses == 'Admin') {
        header("location:../../view/admin/editShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      } else {
        header("location:../../view/user/editShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      }
    }
    

  // ============= ganti status shipment ===============

  } elseif (isset($_POST['changeStatusShipment'])) {
    // echo $_POST['statusId'];
    $id = $_POST['id'];
    $statusId = $_POST['statusId'];

    $query = "update trans_shipment set id_status_shipment='$statusId' where id='$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      if ($akses == 'Admin') {
        header("location:../../view/admin/detailShipment.php?id='$id'");
        $_SESSION['pesan'] = '<p><div class="alert alert-success">Status berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      } else {
        header("location:../../view/user/detailShipment.php?id='$id'");
        $_SESSION['pesan'] = '<p><div class="alert alert-success">Status berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      }
    } else {
      if ($akses = 'Admin') {
        header("location:../../view/admin/detailShipment.php?id='$id'");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      } else {
        header("location:../../view/user/detailShipment.php?id='$id'");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      }
      // $_SESSION['id_pesan1'] = $save;			
    }

  // ============= generate trucking shipment ===============
  
  } elseif (isset($_POST['inputGenerateTrucking'])) {
    $id = $_POST['id'];
    $count = $_POST['count'];

    $queryShipment = "select * from trans_shipment where id='$id'";
    $fetchShipment = mysqli_query($koneksi, $queryShipment);
    $dataShipment = mysqli_fetch_array($fetchShipment);

    $custId = $dataShipment['CustId'];
    // echo $id;
		for ($i=0; $i < $count; $i++) { 
      $query = "insert into trans_hd values (null, '$custId', '$s_id', '$datetime', null, null, null, null, null, null, null, null, null, null, null, '0', null, '$datetime', null, null, '$id', '$datetime', '0', '', '')";
      // printf($query);
      $result = mysqli_query($koneksi, $query);
    }

    if ($result) {
      if($akses == 'Admin'){
          header("location:../../view/admin/detailShipment.php?id=$id");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Trucking berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
      } else {
          header("location:../../view/user/detailShipment.php?id=$id");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Trucking berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
      }
    } else {
      if($akses == 'Admin'){
        header("location:../../view/admin/detailShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Trucking gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      } else {
        header("location:../../view/user/detailShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Trucking gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      }
    }

  // ============= input last kurs shipment ===============
  
  } elseif (isset($_POST['inputLastKursShipment'])) {
    $id = $_POST['id'];
    // echo $id;
    $lastKurs = $_POST['lastKurs'];

    $queryGetShipment = "select freight from trans_shipment where id=".$id;
    $fetchGetShipment = mysqli_query($koneksi, $queryGetShipment);
    $dataGetShipment = mysqli_fetch_array($fetchGetShipment);

    $freight = $dataGetShipment['freight'];
    $totalFreight = (double)$lastKurs * (double)$freight;

    $query = "update trans_shipment set id_status_shipment=3, close=1, close_date='$datetime', closed_by='$s_id', total_freight='$totalFreight', nilai_kurs='$lastKurs', kurs_date='$date', last_update='$datetime' where id='$id'";
    // echo $query;
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      if($akses == 'Admin'){
          header("location:../../view/admin/detailShipment.php?id=$id");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Status berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
      } else {
          header("location:../../view/user/detailShipment.php?id=$id");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Status berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
      }
    } else {
      if($akses == 'Admin'){
        header("location:../../view/admin/detailShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      } else {
        header("location:../../view/user/detailShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      }
    }
  

  // ============= drop shipment ===============
  } elseif (isset($_POST['dropShipment'])) {
    $id = $_POST['id'];

    $queryTransShipment = "update trans_shipment set is_delete=1, deleted_date='$datetime', last_update='$datetime' where id='$id'";
    // echo $queryTransShipment;
    $resultTransShipment = mysqli_query($koneksi, $queryTransShipment);

    if ($resultTransShipment) {
      $queryTransHd = "update trans_hd set cancel_date='$datetime', atr1=1 where id_shipment='$id'";
      $resultTransHd = mysqli_query($koneksi, $queryTransHd);

      if ($resultTransHd) {
        if($akses == 'Admin'){
          header("location:../../view/admin/shipment.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Shipment berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
        } else {
          header("location:../../view/user/shipment");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Shipment berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
        }
      } else {
        $queryTransShipment = "update trans_shipment set is_delete=0, deleted_date=null, last_update=null where id='$id'";
        $resultTransShipment = mysqli_query($koneksi, $queryTransShipment);

        if($akses == 'Admin'){
          header("location:../../view/admin/detailShipment.php?id=$id");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
        } else {
          header("location:../../view/user/detailShipment.php?id=$id");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
        }
      }
    } else {
      if($akses == 'Admin'){
        header("location:../../view/admin/detailShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
      } else {
        header("location:../../view/user/detailShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
      }
    }

  // ============= ganti user shipment ===============
  } elseif (isset($_POST['editUserShipment'])) {
    $shipmentId = $_POST['shipmentId'];
    $oldUserId = $_POST['userLama'];
    $newUserId = $_POST['userBaru'];
    $keterangan = str_replace(["\r\n", "\n", "\r"],"%%", $_POST['keterangan']);
    $status = 0;

    $dataArrayTrucking = array();
    $queryGetTrucking = "select * from trans_hd th where th.id_shipment=$shipmentId";
    $fetchGetTrucking = mysqli_query($koneksi, $queryGetTrucking);
    while ($data = mysqli_fetch_array($fetchGetTrucking)) {
      $dataArrayTrucking[] = array(
        'id' => $data['HdId'],
        'id_shipment' => $data['id_shipment']
      );
    }


    $queryUpdateShipment = "update trans_shipment set UserId='$newUserId' where id='$shipmentId'";
    $resultUpdateShipment = mysqli_query($koneksi, $queryUpdateShipment);

    if ($resultUpdateShipment) {
      $status = 1;
      $queryLogShipment = "insert into log values (null, '$datetime', '$shipmentId', null, '$oldUserId', '$newUserId', '$keterangan')";
      $resultLogShipment = mysqli_query($koneksi, $queryLogShipment);
      
      if (count($dataArrayTrucking) > 0) {
        foreach ($dataArrayTrucking as $key=>$data) {
          $truckingId = $data['id'];
          $queryLogTrucking = "insert into log values (null, '$datetime', '$shipmentId', '$truckingId', '$oldUserId', '$newUserId', '$keterangan')";
          $resultLogTrucking = mysqli_query($koneksi, $queryLogTrucking);
        }
      }
    } else {
      $status = 0;
    }

    if($status == 1){
      header("location:../../view/admin/editShipment.php?id=$shipmentId");
      $_SESSION['pesan'] = '<p><div class="alert alert-success">User berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }else{
      header("location:../../view/admin/editShipment.php?id=$shipmentId");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">User gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }

    


  // ============= report shipment ===============

  } elseif (isset($_GET['reportShipment'])) {
    $startspk = $_GET['start'];
    $endspk = $_GET['end'];
    $start0 = str_replace('/', '-', $startspk);
    $end0 = str_replace('/', '-', $endspk);
    $start = date('Y-m-d', strtotime($start0));
    $end = date('Y-m-d', strtotime($end0));

    $array = array();
    $arrayTempShipment = array();
    $arrayTempHandling = array();

    if($akses == "Admin") {
      $queryShipment = "select
        ts.id,
        ts.create_order as create_order,
        ts.shipment_order as kode_shipment,
        mc.nama as customer,
        mu.nama as sales,
        ts.pib as pib,
        ts.bl as bl,
        mst.nama as shipment_term,
        mlt.nama as load_type,
        ts.quantity as qty,
        mu2.nama as unit,
        mss.nama as status,
        ts.freight as freight,
        ts.total_freight as total_freight
      from 
        trans_shipment ts,
        master_customer mc,
        master_user mu,
        master_unit mu2,
        master_load_type mlt,
        master_shipment_terms mst,
        master_status_shipment mss
      where 
        mu.atr1=0 and
        mc.CustId = ts.CustId and 
        mu.UserId = ts.UserId and 
        mu2.id = ts.unit and
        mlt.id = ts.id_shipment_load_type and 
        mst.id = ts.id_shipment_term and 
        mss.id = ts.id_status_shipment and 
        ts.is_delete=0 and
        ts.create_order between '".$start." 00:00:00' and '".$end." 23:59:59'";

      $queryHandling = "select 
        tsh.id_shipment,
        sum(tsh.nominal) as totalHandling
      from 
        trans_shipment_handling tsh,
        trans_shipment ts 
      where 
        tsh.id_shipment = ts.id and 
        ts.create_order between '".$start." 00:00:00' and '".$end." 23:59:59' 
      group by
        tsh.id_shipment ";

    } else {

      $queryShipment = "select
        ts.id,
        ts.create_order as create_order,
        ts.shipment_order as kode_shipment,
        mc.nama as customer,
        mu.nama as sales,
        ts.pib as pib,
        ts.bl as bl,
        mst.nama as shipment_term,
        mlt.nama as load_type,
        ts.quantity as qty,
        mu2.nama as unit,
        mss.nama as status,
        ts.freight as freight,
        ts.total_freight as total_freight
      from 
        trans_shipment ts,
        master_customer mc,
        master_user mu,
        master_unit mu2,
        master_load_type mlt,
        master_shipment_terms mst,
        master_status_shipment mss
      where 
        mc.CustId = ts.CustId and 
        mu.UserId = ts.UserId and 
        mu2.id = ts.unit and
        mlt.id = ts.id_shipment_load_type and 
        mst.id = ts.id_shipment_term and 
        mss.id = ts.id_status_shipment and 
        ts.is_delete=0 and
        ts.UserId = '".$s_id."' and
        ts.create_order between '".$start." 00:00:00' and '".$end." 23:59:59'";

      $queryHandling = "select 
        tsh.id_shipment,
        sum(tsh.nominal) as totalHandling
      from 
        trans_shipment_handling tsh,
        trans_shipment ts 
      where 
        tsh.id_shipment = ts.id and 
        ts.create_order between '".$start." 00:00:00' and '".$end." 23:59:59' 
      group by
        tsh.id_shipment ";
    }

    $fetchShipment = mysqli_query($koneksi,$queryShipment);
    while($row = mysqli_fetch_assoc($fetchShipment))
    {
      $arrayTempShipment[] = $row;
    }

    $fetchHandling = mysqli_query($koneksi,$queryHandling);
    while($row = mysqli_fetch_assoc($fetchHandling))
    {
      $arrayTempHandling[] = $row;
    }

    $array = $arrayTempShipment;

    $arrayIdTemp = 0;

    foreach ($array as $key => &$data) {
      $temp = 0;
      foreach ($arrayTempHandling as $key1 => &$dataHandling) {
        if ($data['id'] == $dataHandling['id_shipment']) {
          $temp = $dataHandling['totalHandling'];
          break;
        }
      }
      $data['totalHandling'] = $temp;
    }

    $data = json_encode($array);
    echo $data;
  }
?>