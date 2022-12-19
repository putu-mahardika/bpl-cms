<?php
	date_default_timezone_set("Asia/Jakarta");
	$datetime = date('Y-m-d H:i:s');
	
	include 'konek.php';
		session_save_path('../tmp');
    session_start();
	
	//$s_username = $_SESSION['username'];
	//$query1 = "insert into log values ('$datetime', '$s_username', 'Logout sistem')";
	//$sql = mysqli_query($koneksi, $query1);
	
    session_unset();
    session_destroy();
    header("location:../index.php?pesan=logout");
?> 