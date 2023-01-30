<?php
  include '../koneksi.php';
  date_default_timezone_set("Asia/Jakarta");
	$datetime = date('Y-m-d H:i:s');
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

    $namaBiayaHandling = $_POST['namaBiayaHandling'];
    $biayaHandling = $_POST['biayaHandling'];
    $sumBiayaHandling = array_sum($biayaHandling);

    $j=0;

    while($data = mysqli_fetch_array($fetch_master_query)){
      if(strtolower($kodeShipment) == strtolower($data['kode_order']) || strtolower($kodeShipment) == strtolower($data['shipment_order'])) {
          $j=1;
      }
    }
    $save = [$datetime, $kodeShipment, $s_id, $customer, $pib, $billLanding, $shipmentTerm, $loadType, $qty, $unit, $biayaFreight, $totalFreight, $tglKurs, $kurs, $namaBiayaHandling, $biayaHandling, $sumBiayaHandling];

    // foreach ($namaBiayaHandling as $x) {
    //   echo $x;
    // }

    // echo mysqli_query($koneksi, "select lastval()");
    if($j != 1){
      $query = "insert into trans_shipment values (null, '$datetime', '$kodeShipment', '$s_id', '$customer', null, '$pib', '$billLanding', '$shipmentTerm', '$loadType', '$qty', '$unit', '1', '$biayaFreight', '$totalFreight', '$tglKurs', '$kurs', '0', null, '0' , null, null, '$datetime', null, null, null)";
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
          // echo 'aaa';
          $save = [];
          header("location:../../view/admin/shipment.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
       } else {
          // echo 'bbb';
          header("location:../../view/admin/shipment.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
          $_SESSION['id_pesan1'] = $save;			
      }
    } else {
        header("location:../../view/admin/inputShipment.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
    }
  } elseif (isset($_POST['editShipment'])) {
    // print_r($_POST['shipmentId'] == ' ' ? 'true' : 'false');
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
      if((strtolower($kodeShipment) == strtolower($data['kode_order']) || strtolower($kodeShipment) == strtolower($data['shipment_order'])) && $data['id'] != $id) {
          $j=1;
      }
    }

    if($j != 1){
      // $query = "insert into trans_shipment values (null, '$datetime', '$kodeShipment', '$s_id', '$customer', null, '$pib', '$billLanding', '$shipmentTerm', '$loadType', '$qty', '$unit', '1', '$biayaFreight', '$totalFreight', '$tglKurs', '$kurs', '0', null, '0' , null, null, '$datetime', null, null, null)";
      $query = "update trans_shipment set shipment_order='$kodeShipment', UserId='$s_id', pib='$pib', bl='$billLanding', id_shipment_term='$shipmentTerm', id_shipment_load_type='$loadType', quantity='$qty', unit='$unit', freight='$biayaFreight', total_freight='$totalFreight', kurs_date='$tglKurs', nilai_kurs='$kurs', last_update='$datetime' where id='$id'";
      // printf($query);
      $result = mysqli_query($koneksi, $query);
      
      if ($result) {
        // $lastInsertedId = $koneksi->insert_id;
        for ($i=0; $i < count($biayaHandlingId); $i++) { 
          // echo ($biayaHandlingId[$i] == ' ' ? 'true' : 'false');
          if ($biayaHandlingId[$i] != ' ') {
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
          // echo 'aaa';
          $save = [];
          header("location:../../view/admin/shipment.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
       } else {
          // echo 'bbb';
          header("location:../../view/admin/editShipment.php?id=$id");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
          $_SESSION['id_pesan1'] = $save;			
      }
    } else {
        header("location:../../view/admin/editShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        $_SESSION['id_pesan1'] = $save;
    }
  } elseif (isset($_POST['changeStatusShipment'])) {
    // echo $_POST['statusId'];
    $id = $_POST['id'];
    $statusId = $_POST['statusId'];

    $query = "update trans_shipment set id_status_shipment='$statusId' where id='$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
      // header("location:../../view/admin/detailShipment.php?id='$id'");
      $_SESSION['pesan'] = '<p><div class="alert alert-success">Status berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
    } else {
      // header("location:../../view/admin/detailShipment.php?id='$id'");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      // $_SESSION['id_pesan1'] = $save;			
    }
    
  } elseif (isset($_POST['inputGenerateTrucking'])) {
    $id = $_POST['id'];
    $count = $_POST['count'];
    // echo $id;
		for ($i=0; $i < $count; $i++) { 
      $query = "insert into trans_hd values (null, null, '$s_id', '$datetime', null, null, null, null, null, null, null, null, null, null, null, '0', null, '$datetime', null, null, '$id', '$datetime', '0', '', '')";
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
  }
?>