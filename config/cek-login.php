<?php
	date_default_timezone_set("Asia/Jakarta");
	$datetime = date('Y');;

	session_save_path('../tmp');
	//Starting the session
	session_start();		

	include 'koneksi.php';
	// print_r($session);

	
	//proses Login
	if (isset($_POST['doLogin'])) {
		$acak = "abc";
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password1 = md5($acak . md5($password) . $acak);
		$query = "select * from master_user where username='$username' and password='$password1'";
		$fetch = mysqli_query($koneksi, $query);
		$cek = mysqli_num_rows($fetch);	
		
		if ($cek > 0) {
			$data = mysqli_fetch_assoc($fetch);

			if($data['aktif'] == '1'){

				if ($data['isAdmin'] == '1') {
					$_SESSION['nama'] = $data['nama'];
					$_SESSION['hak_akses'] = "Admin";
					$_SESSION['id'] = $data['UserId'];
					// print_r([$session, $_SESSION]);
					//$sql = mysqli_query($koneksi, $query1);
					// print_r($_SESSION);
					header("location:../view/admin/dashboard-admin.php?tahun=$datetime");
					exit();
				} 
				elseif ($data['isSales'] == '1') {
					$_SESSION['nama'] = $data['nama'];
					$_SESSION['id'] = $data['UserId'];
					$_SESSION['hak_akses'] = "User";
					//$sql = mysqli_query($koneksi, $query1);
					//header("location:../views/user/dashboard.php");
					header("location:../view/user/dashboard.php?tahun=$datetime");
					exit();
				}
				elseif ($data['isVmTrucking'] == '1') {
					$_SESSION['nama'] = $data['nama'];
					$_SESSION['id'] = $data['UserId'];
					$_SESSION['hak_akses'] = "VmTrucking";
					header("location:../view/vm/dashboard.php?tahun=$datetime");
				}
				elseif ($data['isVMShipment'] == '1') {
					$_SESSION['nama'] = $data['nama'];
					$_SESSION['id'] = $data['UserId'];
					$_SESSION['hak_akses'] = "VmShipment";
					header("location:../view/vm/dashboard.php?tahun=$datetime");
				} else {
					header("location:../index.php?pesan=gagal");
				}
			} else {
				header("location:../index.php?pesan=inactive");
			}
		} else {
			header("location:../index.php?pesan=gagal");
		}
	}
?> 