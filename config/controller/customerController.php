<?php
  include '../koneksi.php';
  date_default_timezone_set("Asia/Jakarta");
	$datetime = date('Y-m-d H:i:s');
	$year = date('Y', strtotime($datetime));
  session_save_path('../../tmp');
	session_start();
  //$s_username = $_SESSION['username'];
  $s_id = $_SESSION['id'];
  $s_name = $_SESSION['nama'];
  $akses = $_SESSION['hak_akses'];

  $custCode = '';
  $salesId = '';

  if (isset($_GET['customerCode'])) {
    $custCode = $_GET['customerCode'];
  }

  if (isset($_GET['salesId'])) {
    $salesId = $_GET['salesId'];
  }

  if (isset($_GET['getSingleCustomerById'])) {
    $query = "SELECT COUNT(*) as count from master_customer WHERE kode_customer='".$custCode."' AND UserId=".$salesId;
    $fetch = mysqli_query($koneksi, $query);
    $result = mysqli_fetch_array($fetch);
    // echo $query;
    echo $result['count'];
  }
?>