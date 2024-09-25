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

  $master_query = "select * from master_vendor";
  $fetch_master_query = mysqli_query($koneksi, $master_query);

  if (isset($_GET['allData'])) {
    $query = "select * from master_vendor where isActive=1 and isDelete=0";
    $result = mysqli_query($koneksi, $query);

    $vendor = [];

    while($row = $result->fetch_assoc()) {
      $vendor[] = $row;
    }

    echo json_encode($vendor);
    // echo $query;
  }

  else if (isset($_GET['allDataTrucking'])) {
    $query = "select * from master_vendor where isActive=1 and isDelete=0 and delivery_type in ('All', 'Trucking')";
    $result = mysqli_query($koneksi, $query);

    $vendor = [];

    while($row = $result->fetch_assoc()) {
      $vendor[] = $row;
    }

    echo json_encode($vendor);
    // echo $query;
  }


  // ============= tambah vendor ===============
  else if (isset($_POST['inputVendor'])) {
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $npwp = $_POST['npwp'];
    $pic = $_POST['pic'];
    $picTelp = $_POST['pic_telp'];
    $tipe = $_POST['tipe'];
    $tipePengiriman = $_POST['tipe_pengiriman'];
    $document = $_POST['dokumen'];
    $note = $_POST['keterangan'];

    if($_POST['aktif'] == "Ya"){
			$isActive = 1;
		} else {
			$isActive = 0;
		}

    $j=0;

    while($data = mysqli_fetch_array($fetch_master_query)){
      if(strtolower($kode) == strtolower($data['kode'])){
        $j=1;
        break;
      }
      elseif (strtolower($nama) == strtolower($data['nama'])) {
        $j=2;
        break;
      }
    }

    if($j == 0){
      $query = "insert into master_vendor values(null, '$kode', '$nama', '$alamat', '$npwp', '$note', '$tipe', '$pic', '$picTelp', '$tipePengiriman', '$document', '$isActive', '$datetime', '$datetime', 0, null)";
      echo $query;
      $result = mysqli_query($koneksi, $query);
      if ($result) {
          // echo 'aaa';
          header("location:../../view/admin/vendor.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
       } else {
          // echo 'bbb';
          header("location:../../view/admin/vendor.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      }
    }
    elseif ($j == 1) {
      header("location:../../view/admin/inputVendor.php");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Kode Vendor sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
    elseif ($j == 2) {
      header("location:../../view/admin/inputVendor.php");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Nama Vendor sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
    else {
      // echo 'ccc';
      header("location:../../view/admin/inputVendor.php");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Vendor sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }

  } 

  // ============= edit vendor =================
  else if (isset($_POST['editVendor'])) {
    $id = $_POST['id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $npwp = $_POST['npwp'];
    $pic = $_POST['pic'];
    $picTelp = $_POST['pic_telp'];
    $tipe = $_POST['tipe'];
    $tipePengiriman = $_POST['tipe_pengiriman'];
    $document = $_POST['dokumen'];
    $note = $_POST['keterangan'];

    if($_POST['aktif']){
			$isActive = 1;
		} else {
			$isActive = 0;
		}
    $j = 0;

    while($data = mysqli_fetch_array($fetch_master_query)){
      if((strtolower($kode) == strtolower($data['kode']) || strtolower($nama) == strtolower($data['nama'])) && $id != $data['Id']){
        $j=1;
        break;
      } elseif((strtolower($kode) == strtolower($data['kode']) || strtolower($nama) == strtolower($data['nama'])) && $id == $data['Id']){
        $j=0;
        break;
      }
    }

    // echo $_POST['aktif'];
    // echo $isActive;

    if($j != 1) {
      $query = "update master_vendor set kode='$kode', nama='$nama', alamat='$alamat', npwp='$npwp', type='$tipe', delivery_type='$tipePengiriman', pic='$pic', pic_telp='$picTelp', link='$document', note='$note', isActive='$isActive', last_update='$datetime' where id='$id'";
      // echo $query;
      $result = mysqli_query($koneksi, $query);
      if ($result) {
          header("location:../../view/admin/vendor.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      } else {
          header("location:../../view/admin/vendor.php");
          $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
      }
    } else {
        header("location:../../view/admin/editVendor.php?id=$id");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Vendor sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
    }
  }

  // ============= delete vendor =================
  elseif (isset($_GET['Id'])) {
    $id = $_GET['Id'];

    $query = "update from master_vendor set isDelete=1, delete_at='$datetime' where Id='$id'";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        header("location:../view/admin/vendor.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
    } else {
        header("location:../view/admin/vendor.php");
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
    }
  }
?>