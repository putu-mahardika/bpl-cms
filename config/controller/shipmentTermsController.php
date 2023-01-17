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


  $master_query = "select * from master_shipment_terms";
  $fetch_master_query = mysqli_query($koneksi, $master_query);

  // ============= tambah status shipment ===============
  if (isset($_POST['inputShipmentTerms'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    // $isActive = $_POST['aktif'];
    $no = $_POST['no'];

    if($_POST['aktif'] == "Ya"){
			$isActive = 1;
		} else {
			$isActive = 0;
		}

    while($data = mysqli_fetch_array($fetch_master_query)){
      if(strtolower($kode) == strtolower($data['kode']) || strtolower($nama) == strtolower($data['nama']) || $no == $data['atr1']){
          $j=1;
      }
    }

    if($j != 1){
      $query = "insert into master_shipment_terms values(null, '$kode', '$nama', '$isActive', '$datetime', '$datetime', '$s_id', '$no', '', '')";
      $result = mysqli_query($koneksi, $query);
      if ($result) {
          // echo 'aaa';
          header("location:../../view/admin/shipmentTerms.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
       } else {
          // echo 'bbb';
          header("location:../../view/admin/shipmentTerms.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      }
    } else {
        // echo 'ccc';
        header("location:../../view/admin/inputShipmentTerms.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }

  } 

  // ============= edit status shipment =================
  else if (isset($_POST['editShipmentTerms'])) {
    $id = $_POST['id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $no = $_POST['no'];

    if($_POST['aktif']){
			$isActive = 1;
		} else {
			$isActive = 0;
		}

    while($data = mysqli_fetch_array($fetch_master_query)){
      if((strtolower($kode) == strtolower($data['kode']) || strtolower($nama) == strtolower($data['nama']) || $no == $data['no'] ) && $id != $data['id']){
          $j=1;
      } elseif((strtolower($kode) == strtolower($data['kode']) || strtolower($nama) == strtolower($data['nama']) || $no == $data['no'] ) && $id == $data['id']){
          $j=0;
          break;
      }
    }

    // echo $_POST['aktif'];
    // echo $isActive;

    if($j != 1) {
      $query = "update master_shipment_terms set kode='$kode', nama='$nama', aktif='$isActive', last_update='$datetime', UserId='$s_id', atr1='$no' where id='$id'";
      $result = mysqli_query($koneksi, $query);
      if ($result) {
          header("location:../../view/admin/shipmentTerms.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      } else {
          header("location:../../view/admin/shipmentTerms.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      }
    } else {
        header("location:../../view/admin/editShipmentTerms.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
  }
?>