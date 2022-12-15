<?php
  include 'koneksi.php';
  date_default_timezone_set("Asia/Jakarta");
	$datetime = date('Y-m-d H:i:s');
	$year = date('Y', strtotime($datetime));
  session_save_path('../tmp');
  session_start();
  //$s_username = $_SESSION['username'];
  $s_id = $_SESSION['id'];
  $akses = $_SESSION['hak_akses'];

  $arrayMonth = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 
    'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ];
  $arrayMonthLength = count($arrayMonth);
  $resArray = array();

  if(isset($_GET['getDataChart1'])) {
    $resArrayDataOpenChart1 = getDataOpenChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArrayDataCloseChart1 = getDataCloseChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArray = [$resArrayDataOpenChart1, $resArrayDataCloseChart1, $arrayMonth];

  } elseif (isset($_GET['getDataChart2'])) {
    $resArrayDataOpenChart2 = getDataOpenChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArrayDataCloseChart2 = getDataCloseChart2($koneksi, $year, $arrayMonthLength, $akse, $s_ids);
    $resArray = [$resArrayDataOpenChart2, $resArrayDataCloseChart2, $arrayMonth];

  } elseif (isset($_GET['getDataChart3'])) {
    $arrayUser = getUser($koneksi);
    $arrayUserLength = count($arrayUser);
    $resArrayDataOpenChart3 = getDataOpenChart3($koneksi, $year, $arrayUser[0], $akses, $s_id);
    $resArrayDataCloseChart3 = getDataCloseChart3($koneksi, $year, $arrayUser[0], $akses, $s_id);
    $resArray = [$resArrayDataOpenChart2, $resArrayDataCloseChart2, $arrayUser[1]];
  }

  return json_encode($resArray);












  function getUser($koneksi) {
    $array = array();
    $arrayId = array();
    $arrayNama = array();
    $tempArray = array();
    $query = "select UserId, nama from master_user where atr=0";
    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    foreach ($tempArray as $data) {
      $arrayId[] = $data['UserId'];
      $arrayNama[] = $data['nama'];
    }

    $array = [$arrayId, $arrayNama];

    return $array;
  }

  function getDataOpenChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "month(create_date) as month, count(*) as total from trans_hd where OnClose=0 AND year(create_date)='".$year."'";
    } else {
      $query = "month(create_date) as month, count(*) as total from trans_hd where OnClose=0 AND year(create_date)='".$year."' AND UserId='".$s_id."'";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i) {
          $array[$i] = $data['total'];
        }
      }
    }

    return $array;

  }

  function getDatCloseChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "month(create_date) as month, count(*) as total from trans_hd where OnClose=1 AND year(create_date)='".$year."'";
    } else {
      $query = "month(create_date) as month, count(*) as total from trans_hd where OnClose=1 AND year(create_date)='".$year."' AND UserId='".$s_id."'";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i) {
          $array[$i] = $data['total'];
        }
      }
    }

    return $array;
  }

  function getDataOpenChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select a.hdid, month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=0 AND year(a.create_date)='".$year."' GROUP BY month(a.create_date)";
    } else {
      $query = "select a.hdid, month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=0 AND year(a.create_date)='".$year."' AND b.UserId='".$s_id."' GROUP BY month(a.create_date)";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i) {
          $array[$i] = $data['total'];
        }
      }
    }

    return $array;
  }

  function getDataCloseChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select a.hdid, month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=1 AND year(a.create_date)='".$year."' GROUP BY month(a.create_date)";
    } else {
      $query = "select a.hdid, month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=1 AND year(a.create_date)='".$year."' AND b.UserId='".$s_id."' GROUP BY month(a.create_date)";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i) {
          $array[$i] = $data['total'];
        }
      }
    }

    return $array;
  }

  function getDataOpenChart3($koneksi, $year, $arrayUserId, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    $arrayUserLength = count($arrayUserId);
    if ($akses == "Admin") {
      $query = "select a.HdId, a.UserId, c.nama as namaUser, sum(b.Total) as total from trans_hd a, trans_biayaturunan b, master_user c
      where a.OnClose=0 and year(a.create_date)='".$year."' and a.UserId=c.UserId";
    } else {
      $query = "select a.HdId, a.UserId, c.nama as namaUser, sum(b.Total) as total from trans_hd a, trans_biayaturunan b, master_user c
      where a.OnClose=0 and year(a.create_date)='".$year."' and a.UserId=c.UserId and a.UserId='".$s_id."'";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayUserLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['UserId'] == $arrayUserId[$i]) {
          $array[$i] = $data['total'];
        }
      }
    }

    return $array;
  }

  function getDataCloseChart3($koneksi, $year, $arrayUserId, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    $arrayUserLength = count($arrayUserId);
    if ($akses == "Admin") {
      $query = "select a.HdId, a.UserId, c.nama as namaUser, sum(b.Total) as total from trans_hd a, trans_biayaturunan b, master_user c
      where a.OnClose=1 and year(a.create_date)='".$year."' and a.UserId=c.UserId";
    } else {
      $query = "select a.HdId, a.UserId, c.nama as namaUser, sum(b.Total) as total from trans_hd a, trans_biayaturunan b, master_user c
      where a.OnClose=1 and year(a.create_date)='".$year."' and a.UserId=c.UserId and a.UserId='".$s_id."'";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayUserLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['UserId'] == $arrayUserId[$i]) {
          $array[$i] = $data['total'];
        }
      }
    }

    return $array;
  }

?>