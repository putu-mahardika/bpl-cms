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


  $master_query = "select * from master_status_shipment";
  $fetch_master_query = mysqli_query($koneksi, $master_query);

  // ============= tambah status shipment ===============
  if (isset($_POST['inputStatusShipment'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    // $isActive = $_POST['aktif'];
    $no = $_POST['no'];

    if($_POST['aktif'] == "Ya"){
			$isActive = 1;
		} else {
			$isActive = 0;
		}

    $j=0;

    while($data = mysqli_fetch_array($fetch_master_query)){
      if(strtolower($kode) == strtolower($data['kode'])){
        $j=1;
        // header("location:../../view/admin/inputStatusShipment.php");
        // $_SESSION['pesan'] = '<p><div class="alert alert-warning">Kode Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        break;
      }
      elseif (strtolower($nama) == strtolower($data['nama'])) {
        $j=2;
        // header("location:../../view/admin/inputStatusShipment.php");
        // $_SESSION['pesan'] = '<p><div class="alert alert-warning">Nama Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        break;
      }
      elseif ($no == $data['atr1']) {
        $j=3;
        // header("location:../../view/admin/inputStatusShipment.php");
        // $_SESSION['pesan'] = '<p><div class="alert alert-warning">Nomor Urutan Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        break;
      }
    }

    if($j == 0){
      $query = "insert into master_status_shipment values(null, '$kode', '$nama', '$isActive', '$datetime', '$datetime', '$s_id', '$no', '', '')";
      $result = mysqli_query($koneksi, $query);
      if ($result) {
          // echo 'aaa';
          header("location:../../view/admin/statusShipment.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
       } else {
          // echo 'bbb';
          header("location:../../view/admin/statusShipment.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      }
    } 
    elseif ($j == 1) {
      header("location:../../view/admin/inputStatusShipment.php");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Kode Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
    elseif ($j == 2) {
      header("location:../../view/admin/inputStatusShipment.php");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Nama Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
    elseif ($j == 3) {
      header("location:../../view/admin/inputStatusShipment.php");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Nomor Urutan Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
    else {
      // echo 'ccc';
      header("location:../../view/admin/inputStatusShipment.php");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }

  } 

  // ============= edit status shipment =================
  else if (isset($_POST['editStatusShipment'])) {
    $id = $_POST['id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $no = $_POST['no'];

    if($_POST['aktif']){
			$isActive = 1;
		} else {
			$isActive = 0;
		}

    $j=0;

    // while($data = mysqli_fetch_array($fetch_master_query)){
    //   if((strtolower($kode) == strtolower($data['kode']) || strtolower($nama) == strtolower($data['nama']) || $no == $data['no'] ) && $id != $data['id']){
    //       $j=1;
    //       break;
    //   } elseif((strtolower($kode) == strtolower($data['kode']) || strtolower($nama) == strtolower($data['nama']) || $no == $data['no'] ) && $id == $data['id']){
    //       $j=0;
    //       break;
    //   }
    // }

    while($data = mysqli_fetch_array($fetch_master_query)){
      if(strtolower($kode) == strtolower($data['kode']) && $id != $data['id']){
        $j=1;
        // header("location:../../view/admin/inputStatusShipment.php?id=$id");
        // $_SESSION['pesan'] = '<p><div class="alert alert-warning">KodeStatus Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        break;
      }
      elseif (strtolower($nama) == strtolower($data['nama']) && $id != $data['id']) {
        $j=2;
        break;
        // header("location:../../view/admin/inputStatusShipment.php?id=$id");
        // $_SESSION['pesan'] = '<p><div class="alert alert-warning">Nama Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      }
      elseif ($no == $data['atr1'] && $id != $data['id']) {
        $j=3;
        break;
        // header("location:../../view/admin/inputStatusShipment.php?id=$id");
        // $_SESSION['pesan'] = '<p><div class="alert alert-warning">Nomor Urutan Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      }
    }

    // echo $_POST['aktif'];
    // echo $isActive;

    if($j == 0) {
      $query = "update master_status_shipment set kode='$kode', nama='$nama', aktif='$isActive', last_update='$datetime', UserId='$s_id', atr1='$no' where id='$id'";
      $result = mysqli_query($koneksi, $query);
      if ($result) {
          header("location:../../view/admin/statusShipment.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      } else {
          header("location:../../view/admin/statusShipment.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      }
      
    } 
    elseif ($j==1) {
      header("location:../../view/admin/editStatusShipment.php?id=$id");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">KodeStatus Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
    elseif ($j==2) {
      header("location:../../view/admin/editStatusShipment.php?id=$id");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Nama Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
    elseif ($j==3) {
      header("location:../../view/admin/editStatusShipment.php?id=$id");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Nomor Urutan Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
    else {
        header("location:../../view/admin/editStatusShipment.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status Shipment sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
  }
?>