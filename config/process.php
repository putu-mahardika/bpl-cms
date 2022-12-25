<?php

    include 'koneksi.php';
    include 'detailBiayaTurunan.php';
    date_default_timezone_set("Asia/Jakarta");
	$datetime = date('Y-m-d H:i:s');
	$year = date('Y', strtotime($datetime));
    session_save_path('../tmp');
	session_start();
    //$s_username = $_SESSION['username'];
    $s_id = $_SESSION['id'];
    $akses = $_SESSION['hak_akses'];

    $u_query = 'select * from master_user';
    $s_query = 'select * from master_status';
    $k_query = 'select * from master_kota';
    $c_query = 'select * from master_customer';
	$t_query = 'select * from trans_hd where atr1=0';

    $fetch_u = mysqli_query($koneksi,$u_query);
    $fetch_s = mysqli_query($koneksi,$s_query);
    $fetch_k = mysqli_query($koneksi,$k_query);
    $fetch_c = mysqli_query($koneksi,$c_query);
	$fetch_t = mysqli_query($koneksi,$t_query);

    //edit password =====================================================================

    if(isset($_POST['editPassword'])){
		$acak = "abc";
		$lama = $_POST['l_pass'];
		$k_lama = $_POST['k_pass'];
		$baru = $_POST['b_pass'];
		$password = md5($acak . md5($baru) . $acak);

		$query = "update master_user set password='$password' where UserId='$s_id'";
		$result = mysqli_query($koneksi, $query);
		if($result){
			if($akses == "Admin"){
				header("location:../view/admin/editPassword.php");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
			} else {
				header("location:../view/user/editPassword.php");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
			}
		} else {
			if($akses == "Admin"){
				header("location:../view/admin/editPassword.php");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
			} else {
				header("location:../view/user/editPassword.php");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
			}
		}
	}	

    //user
    //input user =====================================================================
	elseif (isset($_POST['inputUser'])){
        $acak = "abc";
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password1 = md5($acak . md5($password) . $acak);
        $nama = $_POST['nama'];
        $isAdmin = $_POST['isAdmin'];
        $aktif = $_POST['aktif'];

		if($isAdmin == "Ya"){
			$isAdmin1 = 1;
		} else {
			$isAdmin1 = 0;
		}

		if($aktif == "Ya"){
			$aktif1 = 1;
		} else {
			$aktif1 = 0;
		}

        while($data = mysqli_fetch_array($fetch_u)){
            if($username == $data['username']){
                $i=1;
            }
        }
        if($i != 1){
            $query = "insert into master_user values(null, '$username', '$password1', '$nama', '$datetime', '$datetime', '$aktif1', '$isAdmin1', '0', '', '')";
            $result = mysqli_query($koneksi, $query);
            if ($result) {
                header("location:../view/admin/user.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
            } else {
                header("location:../view/admin/user.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        } else {
            header("location:../view/admin/inputUser.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Username sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }
    }

    //edit user ======================================================================
    elseif (isset($_POST['editUser'])) {
        $id = $_POST['id'];
        $acak = "abc";
        $username = $_POST['username'];
        $password = $_POST['password'];
        $nama = $_POST['nama'];
        $isAdmin = $_POST['isAdmin'];
        $aktif = $_POST['aktif'];
        // echo $password;

        while($data = mysqli_fetch_array($fetch_u)){
            if($username == $data['username'] && $id != $data['UserId']){
                $i=1;
            } elseif($username == $data['username'] && $id == $data['UserId']){
                $i=0;
                break;
            }
        }
        if($i != 1){
            if ($password != NULL) {
                $password1 = md5($acak . md5($password) . $acak);
                $query = "update master_user set username='$username', password='$password1', nama='$nama', isAdmin='$isAdmin', last_update='$datetime', aktif='$aktif' where UserId='$id'";
            } else {
                $query = "update master_user set username='$username', nama='$nama', isAdmin='$isAdmin', last_update='$datetime', aktif='$aktif' where UserId='$id'";
            }
            $result = mysqli_query($koneksi, $query);
            if ($result) {
                header("location:../view/admin/user.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            } else {
                header("location:../view/admin/user.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }  
        } else {
            header("location:../view/admin/editUser.php?id=$id");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Username sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }
    }

    //delete user ====================================================================
    elseif (isset($_GET['UserId'])) {
        $id = $_GET['UserId'];

        $query = "delete from master_user where UserId='$id'";
        $result = mysqli_query($koneksi, $query);
        if ($result) {
            header("location:../view/admin/user.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        } else {
            header("location:../view/admin/user.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        }
    }

    //status
    //input status ===================================================================
    elseif (isset($_POST['inputStatus'])) {
        $no = $_POST['no'];
        $status = $_POST['status'];
        $keterangan = $_POST['keterangan'];
        $aktif = $_POST['aktif'];

		if($aktif == "Ya"){
			$aktif1 = 1;
		} else {
			$aktif1 = 0;
		}

        //$querymax = "select max(atr1) as max from master_status";
        //$fetchmax = mysqli_query($koneksi, $querymax);
        //$datamax = mysqli_fetch_array($fetchmax);
        //echo $datamax['max']
        
        while($data = mysqli_fetch_array($fetch_s)){
            if($status == $data['status'] || $no == $data['atr1']){
                $j=1;
            }
        }

        if($j != 1){
            $query = "insert into master_status values(null, '$status', '$keterangan', '$aktif1', '$datetime', '$datetime', '$s_id', '$no', '', '')";
            $result = mysqli_query($koneksi, $query);
            if ($result) {
                header("location:../view/admin/status.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
             } else {
                header("location:../view/admin/status.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        } else {
            header("location:../view/admin/inputStatus.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }
    }

    //edit status ====================================================================
    elseif (isset($_POST['editStatus'])) {
        $id = $_POST['id'];
        $no = $_POST['no'];
        $status = $_POST['status'];
        $keterangan = $_POST['keterangan'];
        $aktif = $_POST['aktif'];
        while($data = mysqli_fetch_array($fetch_s)){
            if($status == $data['status'] && $id != $data['stsId']){
                $j=1;
            } elseif($status == $data['status'] && $id == $data['stsId']){
                $j=0;
                break;
            }
        }

        if($j != 1) {
            $query = "update master_status set status='$status', keterangan='$keterangan', aktif='$aktif', last_update='$datetime', UserId='$s_id', atr1='$no' where stsId='$id'";
            $result = mysqli_query($koneksi, $query);
            if ($result) {
                header("location:../view/admin/status.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            } else {
                header("location:../view/admin/status.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        } else {
            header("location:../view/admin/editStatus.php?id=$id");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }
    }

    //delete status ==================================================================
    elseif (isset($_GET['StsId'])) {
        $id = $_GET['StsId'];

        $query = "delete from master_status where stsId='$id'";
        $result = mysqli_query($koneksi, $query);
        if ($result) {
            header("location:../view/admin/status.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        } else {
            header("location:../view/admin/status.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        }
    }

    //kota
    //input kota ===================================================================
    elseif (isset($_POST['inputKota'])) {
        // $kode = strtoupper($_POST['kode']);
        $nama = $_POST['namaKota'];
        // $keterangan = $_POST['keterangan'];
        $aktif = $_POST['aktif'];
        $kode = strtoupper(substr($nama, 0, 3).time());

		if($aktif == "Ya"){
			$aktif1 = 1;
		} else {
			$aktif1 = 0;
		}

        //$querymax = "select max(atr1) as max from master_status";
        //$fetchmax = mysqli_query($koneksi, $querymax);
        //$datamax = mysqli_fetch_array($fetchmax);
        //echo $datamax['max']
        
        while($data = mysqli_fetch_array($fetch_k)){
            if(strtolower($kode) == strtolower($data['Kode']) && strtolower($nama) == strtolower($data['Nama'])){
                $j=1;
            }
        }

        if($j != 1){
            $query = "insert into master_kota (Id, Kode, Nama, last_update, create_date, aktif, Attribute1, Attribute2) values(null, '$kode', '$nama', '$datetime', '$datetime', '$aktif1', NULL, NULL)";
            $result = mysqli_query($koneksi, $query);
            if ($result) {
                header("location:../view/admin/kota.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
             } else {
                header("location:../view/admin/kota.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        } else {
            header("location:../view/admin/inputKota.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Kota sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }
    }

    //edit kota ====================================================================
    elseif (isset($_POST['editKota'])) {
        $id = $_POST['id'];
        // $kode = $_POST['kode'];
        $nama = $_POST['namaKota'];
        // $keterangan = $_POST['keterangan'];
        $aktif = $_POST['aktif'];
        // print_r([$id, $kode, $nama, $aktif]);
        $j=0;
        while($data = mysqli_fetch_array($fetch_k)){
            if(strtolower($nama) == strtolower($data['Nama']) && strtolower($id != $data['Id'])){
                $j=1;
            } 
            // elseif(strtolower($id == $data['Id'])){
            //     $j=0;
            //     break;
            // }
        }

        if($j != 1) {
            $query = "update master_kota set Kode='$kode', Nama='$nama', last_update='$datetime', aktif='$aktif' where Id=$id";
            $result = mysqli_query($koneksi, $query);
            if ($result) {
                header("location:../view/admin/kota.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            } else {
                header("location:../view/admin/kota.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        } else {
            header("location:../view/admin/editKota.php?id=$id");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Status sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }
    }

    //delete kota ==================================================================
    elseif (isset($_GET['Id'])) {
        $id = $_GET['Id'];

        $query = "delete from master_kota where Id='$id'";
        $result = mysqli_query($koneksi, $query);
        if ($result) {
            header("location:../view/admin/kota.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        } else {
            header("location:../view/admin/kota.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        }
    }


    //customer
    //input customer =================================================================
    elseif (isset($_POST['inputCustomer'])) {
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
        $bidang = $_POST['bidang'];
        $npwp = $_POST['npwp'];
        $alamat = $_POST['alamat'];
        $telp = $_POST['telp'];
        $email = $_POST['email'];
        $pic = $_POST['pic'];
        $pic_telp = $_POST['pic_telp'];
        $pic_email = $_POST['pic_email'];
        $keterangan = $_POST['keterangan'];
        $aktif = $_POST['aktif'];

		if($aktif == "Ya"){
			$aktif1 = 1;
		} else {
			$aktif1 = 0;
		}

        while($data = mysqli_fetch_array($fetch_c)){
            if($npwp == $data['npwp'] || $telp == $data['telp'] || $email == $data['email']){
                $k=1;
            }
        }

        if($k != 1){
            $query = "insert into master_customer values (null, '$kode', '$npwp', '$nama', '$alamat', '$telp', '$email', '$bidang', '$pic', '$pic_telp', '$pic_email', '$keterangan', '$datetime', '$datetime', '$s_id', '$aktif1', '', '', '')";
            $result = mysqli_query($koneksi, $query);
            if ($result) {
                if($akses == 'Admin'){
                    header("location:../view/admin/customer.php");
                    $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
                } else {
                    header("location:../view/user/customer.php");
                    $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
                }
            } else {
                if($akses == 'Admin'){
                    header("location:../view/admin/customer.php");
                    $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
                } else {
                    header("location:../view/user/customer.php");
                    $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
                }
            }
        } else {
            if($akses == 'Admin'){
                header("location:../view/admin/inputCustomer.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Customer sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
            } else {
                header("location:../view/user/inputCustomer.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Customer sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
            }
        }
    }

    //edit customer ==================================================================
    elseif (isset($_POST['editCustomer'])) {
        $id = $_POST['id'];
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
        $bidang = $_POST['bidang'];
        $npwp = $_POST['npwp'];
        $alamat = $_POST['alamat'];
        $telp = $_POST['telp'];
        $email = $_POST['email'];
        $pic = $_POST['pic'];
        $pic_telp = $_POST['pic_telp'];
        $pic_email = $_POST['pic_email'];
        $sales = $_POST['sales'];
        $keterangan = $_POST['keterangan'];
        $aktif = $_POST['aktif'];

        while($data = mysqli_fetch_array($fetch_s)){
            if($npwp == $data['npwp'] && $id != $data['CustId'] && $nama == $data['nama']){
                $k=1;
            } elseif($npwp == $data['npwp'] && $id == $data['CustId'] && $nama == $data['nama']){
                $k=0;
                break;
            }
        }

        if($k != 1){
            $query = "update master_customer set kode_customer='$kode', nama='$nama', bidang_usaha='$bidang', npwp='$npwp', alamat='$alamat', telp='$telp', email='$email', PIC='$pic', PIC_telp='$pic_telp', PIC_email='$pic_email', keterangan='$keterangan', aktif='$aktif', last_update='$datetime', UserId='$sales' where CustId='$id'";
            $result = mysqli_query($koneksi, $query);
            if ($result) {
                header("location:../view/admin/customer.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            } else {
                header("location:../view/admin/customer.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        } else {
            header("location:../view/admin/editCustomer.php?id=$id");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Customer sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }
    }

    //delete customer ================================================================
    elseif (isset($_GET['CustId'])) {
        $id = $_GET['CustId'];

        $query = "delete from master_customer where CustId='$id'";
        $result = mysqli_query($koneksi, $query);
        if ($result) {
            header("location:../view/admin/customer.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        } else {
            header("location:../view/admin/customer.php");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        }
    }

	//PO
	//input PO ========================================================================
	elseif (isset($_POST['inputTransaksi'])){
		$cust = $_POST['customer'];
		$nopo = $_POST['nopo'];
		$tglpo = $_POST['tglpo'];
		$nospk = $_POST['nospk'];
		$tglspk = $_POST['tglspk'];
		$armada = $_POST['armada'];
		$status = $_POST['status'];
		$kotaAsalId = $_POST['kotaAsal'];
        $detailKotaAsal = $_POST['detailKotaAsal'];
		$kotaTujuanId = $_POST['kotaTujuan'];
        $detailKotaTujuan = $_POST['detailKotaTujuan'];
		$barang = $_POST['barang'];
		$keterangan = $_POST['keterangan'];
        //$tglclose = '0000-00-00 00:00:00';
        $save = array("$cust", "$nopo", "$tglpo", "$nospk", "$tglspk", "$armada", "$kotaAsalId", "$detailKotaAsal", "$kotaTujuanId", "$detailKotaTujuan", "$barang", "$keterangan");
        $keterangan = str_replace(["\r\n", "\n", "\r"],"%%", $keterangan);

		$tglpo0 = str_replace('/', '-', $tglpo);
        $tglspk0 = str_replace('/', '-', $tglspk);
        $tglpo1 = date('Y-m-d', strtotime($tglpo0));
        $tglspk1 = date('Y-m-d', strtotime($tglspk0));

		if ($status == 'OPEN') {
			$status = 0;
			$tglclose = 'null';
		} else {
			$status = 1;
			$tglclose = '$datetime';
        }
        $x= " ";
        if (strstr($nospk, $x)){
            $nospk = str_replace($x, "", $nospk);
        }
        $t=0;
		while($data = mysqli_fetch_array($fetch_t)){
            if($nospk == $data['NoSPK']){
                $t=1;
            }
        }

		//echo $tglpo;
		//echo $tglspk;
		//echo $tglpo1;
		//echo $tglspk1;

		if ($t != 1) {
			$query = "insert into trans_hd values (null, '$cust', '$s_id', '$datetime', '$nopo', '$tglpo1', '$nospk', '$tglspk1', '$armada', '$kotaAsalId', '$detailKotaAsal', '$kotaTujuanId', '$detailKotaTujuan', '$barang', '$keterangan', '$status', $tglclose, '$datetime', null, null, '0', '', '')";
            $result = mysqli_query($koneksi, $query);
            //create biaya turunan ================================================================
            // $resultCreateBiayaTurunan = createBiayaTurunan($nospk, $datetime, $s_id, $koneksi);
            
            // $queryGetHdId = "select HdId from trans_hd where NoSPK='$nospk'";
            // $fetchGetHdId = mysqli_query($koneksi, $queryGetHdId);
            // $arrayGetHdId = mysqli_fetch_array($fetchGetHdId);
            // $getHdId = $arrayGetHdId['HdId'];
            
            // $cekBiayaTurunan = true;
            // for ($i=1; $i <= $armada; $i++) { 
            //     $resultCreateBiayaTurunan = createBiayaTurunan($nospk, $i, $getHdId, $datetime, $s_id, $koneksi);
            //     if (!$resultCreateBiayaTurunan) {
            //         $cekBiayaTurunan = false;
            //     }
            // }


			if ($result) {
                $save = [];
                if($akses == 'Admin'){
                    header("location:../view/admin/transaksi.php?tahun=$year");
                    $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
                } else {
                    header("location:../view/user/transaksi.php?tahun=$year");
                    $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
                }
            } else {
                if($akses == 'Admin'){
					header("location:../view/admin/transaksi.php?tahun=$year");
                    $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
                } else {
					header("location:../view/user/transaksi.php?tahun=$year");
                    $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
                }
            }
		} else {
            if($akses == 'Admin'){
                //header("location:../view/admin/transaksi.php?tahun=$year");
                header("location:../view/admin/inputTransaksi.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">No SPK sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
                $_SESSION['id_pesan1'] = $save;
            } else {
                //header("location:../view/user/transaksi.php?tahun=$year");
                header("location:../view/user/inputTransaksi.php");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">No SPK sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';               
                $_SESSION['id_pesan1'] = $save;
            }
        }
	}

	//edit PO  ========================================================================
	elseif (isset($_POST['editTransaksi'])){
		$id = $_POST['id'];
		$cust = $_POST['customer'];
		$nopo = $_POST['nopo'];
		$tglpo = $_POST['tglpo'];
		$nospk = $_POST['nospk'];
		$tglspk = $_POST['tglspk'];
		$armada = $_POST['armada'];
        $armadaOld = $_POST['armada_old'];
		$status = $_POST['status'];

        if($status == "OPEN"){
			$status1 = 0;
		}else{
			$status1 = 1;
		}

        $kotaAsalId = $_POST['kotaAsal'];
        $detailKotaAsal = $_POST['detailKotaAsal'];
		$kotaTujuanId = $_POST['kotaTujuan'];
        $detailKotaTujuan = $_POST['detailKotaTujuan'];
		$barang = $_POST['barang'];
		$keterangan = $_POST['keterangan'];
        $tglclose = '0000-00-00 00:00:00';
        
        $keterangan = str_replace(["\r\n", "\n", "\r"],"%%", $keterangan);

        $tglpo0 = str_replace('/', '-', $tglpo);
        $tglspk0 = str_replace('/', '-', $tglspk);
		$tglpo1 = date('Y-m-d', strtotime($tglpo0));
        $tglspk1 = date('Y-m-d', strtotime($tglspk0));
        $x= " ";
        if (strstr($nospk, $x)){
            $nospk = str_replace($x, "", $nospk);
        }
		while($data = mysqli_fetch_array($fetch_t)){
            if($nospk == $data['NoSPK'] && $id != $data['HdId']){
                $t=1;
            } elseif($nospk == $data['NoSPK'] && $id == $data['HdId']) {
				$t=0;
				break;
			}
        }

		if ($t != 1) {
            if($akses == 'Admin'){
                $query = "update trans_hd set NoPO='$nopo', tgl_po='$tglpo1', NoSPK='$nospk', tgl_spk='$tglspk1', total_armada='$armada', kota_kirim_id='$kotaAsalId', kota_kirim='$detailKotaAsal', kota_tujuan_id='$kotaTujuanId', kota_tujuan='$detailKotaTujuan', Barang='$barang', keterangan='$keterangan', OnClose='$status1', last_update='$datetime' where HdId='$id'";
                $query1 = "update trans_detail set NoSPK='$nospk', last_update='$datetime' where HdId='$id'";
            }else{
                $query = "update trans_hd set NoPO='$nopo', tgl_po='$tglpo1', NoSPK='$nospk', tgl_spk='$tglspk1', total_armada='$armada', kota_kirim_id='$kotaAsalId', kota_kirim='$detailKotaAsal', kota_tujuan_id='$kotaTujuanId', kota_tujuan='$detailKotaTujuan', Barang='$barang', keterangan='$keterangan', OnClose='$status1', last_update='$datetime', UserId='$s_id' where HdId='$id'";
                $query1 = "update trans_detail set NoSPK='$nospk', last_update='$datetime', UserId='$s_id' where HdId='$id'";
            }
            $result = mysqli_query($koneksi, $query); 
            $result1 = mysqli_query($koneksi, $query1);   
            
            $diffArmada = $armada-$armadaOld;
            $cekBiayaTurunan = true;

            if ($diffArmada > 0) {
                for ($i=1; $i <= $diffArmada; $i++) { 
                    $addTurunan = $armadaOld+$i;
                    $resultCreateBiayaTurunan = createBiayaTurunan($nospk, $addTurunan, $id, $datetime, $s_id, $koneksi);
                    if (!$resultCreateBiayaTurunan) {
                        $cekBiayaTurunan = false;
                    }
                }
            } elseif ($diffArmada < 0) {
                for ($i=0; $i < -$diffArmada; $i++) { 
                    $minTurunan = $armadaOld-$i;
                    $resultDeleteBiayaTurunan = deleteBiayaTurunan($koneksi, $nospk, $minTurunan);
                    if (!$resultDeleteBiayaTurunan) {
                        $cekBiayaTurunan = false;
                    }
                }
            }

			if ($result && $result1 && $cekBiayaTurunan) {
                if($akses == 'Admin'){
                    header("location:../view/admin/transaksi.php?tahun=$year");
                    $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
                } else {
                    header("location:../view/user/transaksi.php?tahun=$year");
                    $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
                }
            } else {
                if($akses == 'Admin'){
                    header("location:../view/admin/editTransaksi.php?id=$id");
                    $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
                } else {
                    header("location:../view/user/editTransaksi.php?id=$id");
                    $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
                }
            }
		} else {
            if($akses == 'Admin'){
                header("location:../view/admin/editTransaksi.php?id=$id");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">No SPK sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
            } else {
                header("location:../view/user/editTransaksi.php?id=$id");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">No SPK sudah ada !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';               
            }
        }
	}

	//delete PO =======================================================================
	elseif (isset($_GET['HdId'])) {
        $id = $_GET['HdId'];

        $query = "delete from trans_hd where HdId='$id'";
        $result = mysqli_query($koneksi, $query);

        $queryTurunan = "delete from trans_detail where HdId='$id'";
        $result = mysqli_query($koneksi, $queryTurunan);

        $queryBiaya = "delete from trans_biayaturunan where HdId='$id'";
        $result = mysqli_query($koneksi, $queryBiaya);

        if ($result) {
			if($akses == "Admin"){
				header("location:../view/admin/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
			} else {
			    header("location:../view/user/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
			}
        } else {
			if($akses == "Admin"){
				header("location:../view/admin/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
			} else {
				header("location:../view/user/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
			}				
        }
    }

	//cancel PO =======================================================================
	elseif(isset($_GET['cancelId'])){
        $hdid = $_GET['cancelId'];

        $query = mysqli_query($koneksi, "select * from trans_hd where HdId='$hdid'");

        while($data=mysqli_fetch_array($query)){
            $armada = $data['total_armada'];
            $nospk = $data['NoSPK'];
        }

        $query1 = mysqli_query($koneksi, "update trans_hd set OnClose=1, DateOnClose='$datetime', last_update='$datetime', closedById='$s_id', cancel_date='$datetime', atr1=1 where HdId=$hdid");
        $query2 = mysqli_query($koneksi, "select count(*) as jumlah from trans_detail where HdId='$hdid'");
        $data2 = mysqli_fetch_array($query2);

        if($data2['jumlah'] > 0){
            for($i=1;$i<=$armada;$i++){
                $query3 = mysqli_query($koneksi, "update trans_detail set atr1=1, last_update='$datetime' where HdId=$hdid and turunan='$i'");
            }
        }

        // print_r([$query1, $query3]);

        if($query1 == 1 && $query3 == 1){
            if($akses == "Admin"){
                header("location:../view/admin/transaksi.php?tahun=$year");
				// $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dibatalkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
            }else{
                header("location:../view/user/transaksi.php?tahun=$year");
				// $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dibatalkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
            }
        }else{
            if($akses == "Admin"){
                header("location:../view/admin/transaksi.php?tahun=$year");
				// $_SESSION['pesan'] = '<p><div class="alert alert-success">Data gagal dibatalkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
            }else{
                header("location:../view/user/transaksi.php?tahun=$year");
				// $_SESSION['pesan'] = '<p><div class="alert alert-success">Data gagal dibatalkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
            }
        }
    }

	//close PO ========================================================================
    elseif(isset($_GET['closeId'])){
        $hdid = $_GET['closeId'];

        $query = mysqli_query($koneksi, "select * from trans_hd where HdId=$hdid");
        while($data=mysqli_fetch_array($query)){
            $armada = $data['total_armada'];
            $nospk = $data['NoSPK'];
        }

        $query1 = mysqli_query($koneksi, "update trans_hd set OnClose=1, DateOnClose='$datetime', last_update='$datetime', closedById='$s_id' where NoSPK='$nospk'");

        if($query1){
            if($akses == "Admin"){
                header("location:../view/admin/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditutup !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
            }else{
                header("location:../view/user/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diditutup !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
            }
        }else{
            if($akses == "Admin"){
                header("location:../view/admin/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data gagal ditutup !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
            }else{
                header("location:../view/user/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data gagal ditutup !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
            }
        }
    }

	//Transaksi
	//input transaksi =================================================================
	elseif (isset($_POST['inputDetail'])){
		$hdid = $_POST['hdid'];
    	$spk = $_POST['nospk'];
		$turunan = $_POST['turunan'];
		$status = $_POST['status'];
		$jenis = $_POST['jenis'];
        $nopol = $_POST['nopol'];
        $tgl1 = $_POST['tgl'];
        $tgl2 = str_replace('/','-', $tgl1);
		$waktu = $_POST['waktu'];
        $tgl = date('Y-m-d H:i:s', strtotime("$tgl2 $waktu"));
		$onclose = $_POST['onclose'];
        $keterangan = $_POST['keterangan'];
        $keterangan1 = str_replace(["\r\n", "\n", "\r"],"%%", $keterangan);

        $querycek = "select count(*) as countSPKTurunan from trans_biayaturunan where NoSPK='$spk' and Turunan='$turunan'";
        $fetchquerycek = mysqli_query($koneksi, $querycek);
        $arrayquerycek = mysqli_fetch_array($fetchquerycek);
        
        if ($arrayquerycek['countSPKTurunan'] < 1) {
            createBiayaTurunan($spk, $turunan, $hdid, $datetime, $s_id, $koneksi);
        }


        if ($onclose == 1) {
    		$query = "insert into trans_detail values (null, '$hdid', '$spk', '$turunan', '$status', '$tgl', '$keterangan1', '$jenis', '$nopol', '', '$onclose', '$datetime', '$datetime', '$s_id', '0', '', '')";
        } else {
            $query = "insert into trans_detail values (null, '$hdid', '$spk', '$turunan', '$status', '$tgl', '$keterangan1', '$jenis', '$nopol', '', '$onclose', '$datetime', '$datetime', '$s_id', '0', '', '')";
        }
		$result = mysqli_query($koneksi, $query);
		// $result = mysqli_query($koneksi, "insert into trans_detail values (null, '$hdid', '$spk', '$turunan', '$status', '$tgl', '$keterangan1', '$jenis', '$nopol', '', '$onclose', '$datetime', '$datetime', '$s_id', null, '0', '', '')");

        // echo $result;

        if ($result) {
            if($akses == 'Admin'){
                header("location:../view/admin/editTransaksi.php?id=$hdid");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            } else {
                header("location:../view/user/editTransaksi.php?id=$hdid");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        } else {
            if($akses == 'Admin'){
                header("location:../view/admin/editTransaksi.php?id=$hdid");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            } else {
                header("location:../view/user/editTransaksi.php?id=$hdid");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        }
	}

	//edit transaksi ==================================================================
	elseif(isset($_POST['editDetail'])) {
		$dtlid = $_POST['dtlid'];
		$hdid = $_POST['hdid'];
		$spk = $_POST['spk'];
		//$spk_temp = explode('-', $spk);
		//$spk1 = $spk_temp[0];
		//$turunan = $spk_temp[1];
		$status = $_POST['status'];
		$jenis = $_POST['jenis'];
        $nopol = $_POST['nopol'];
        $tgl1 = $_POST['tgl'];
        $tgl2 = str_replace('/','-', $tgl1);
		$waktu = $_POST['waktu'];
        $tgl = date("Y-m-d H:i:s", strtotime("$tgl2 $waktu"));
		$keterangan = $_POST['keterangan'];
        $onclose = $_POST['onclose'];
        
        $keterangan1 = str_replace(["\r\n", "\n", "\r"],"%%", $keterangan);

        //echo $tgl;
	
        if($akses == 'Admin'){
            $query = "update trans_detail set StsId='$status', jenis_armada='$jenis', nopol='$nopol', datetime_status='$tgl', keterangan_kirim='$keterangan1', OnClose='$onclose', last_update='$datetime' where DtlId='$dtlid'";
        }else{
            $query = "update trans_detail set StsId='$status', jenis_armada='$jenis', nopol='$nopol', datetime_status='$tgl', keterangan_kirim='$keterangan1', OnClose='$onclose', last_update='$datetime', UserId='$s_id' where DtlId='$dtlid'";
        }

		$result = mysqli_query($koneksi, $query);
		if ($result) {
            if($akses == 'Admin'){
                header("location:../view/admin/editTransaksi.php?id=$hdid");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            } else {
                header("location:../view/user/editTransaksi.php?id=$hdid");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        } else {
            if($akses == 'Admin'){
				header("location:../view/admin/editTransaksi.php?id=$hdid");
				$_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            } else {
                header("location:../view/user/editTransaksi.php?id=$hdid");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        }
	}

	//delete transaksi ================================================================
	elseif (isset($_GET['DtlId'])) {
        $id = $_GET['DtlId'];

        $queryGetDetail = "select * from trans_detail where DtlId='$id'";
        $fetchQueryGetDetail = mysqli_query($koneksi, $queryGetDetail);
        $arrayQueryGetDetail = mysqli_fetch_array($fetchQueryGetDetail);

        $nospkToDelete = $arrayQueryGetDetail['NoSPK'];
        $turunanToDelete = $arrayQueryGetDetail['turunan'];

        $querycekToDelete = "select count(*) as countBiayaTurunan from trans_biayaturunan where NoSPK='$nospkToDelete' and Turunan='$turunanToDelete'";
        $fetchquerycekToDelete = mysqli_query($koneksi, $querycekToDelete);
        $arrayquerycekToDelete = mysqli_fetch_array($fetchquerycekToDelete);

        if ($arrayquerycekToDelete['countBiayaTurunan'] > 0) {
            $resDeleteBiaya = deleteBiayaTurunan($koneksi, $nospkToDelete, $turunanToDelete);
        } else {
            $resDeleteBiaya = true;
        }

        $query = "delete from trans_detail where DtlId='$id'";
        $result = mysqli_query($koneksi, $query);

        if ($result && $resDeleteBiaya) {
			if($akses == "Admin"){
				header("location:../view/admin/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
			} else {
    			header("location:../view/user/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
			}
        } else {
			if($akses == "Admin"){
				header("location:../view/admin/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
			} else {
				header("location:../view/user/transaksi.php?tahun=$year");
				$_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal dihapus !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
			}				
        }
    }

    //ganti user ================================================================
    elseif(isset($_POST['gantiUser'])){
        $hdid = $_POST['hdid'];
        $user = $_POST['user'];
        $userbaru = $_POST['userBaru'];
        $keterangan = $_POST['keterangan'];

        $keterangan1 = str_replace(["\r\n", "\n", "\r"],"%%", $keterangan);
		
		//echo $hdid;
		//echo $user;
		//echo $userbaru;
		//echo $keterangan;

        $query = "insert into log values (null, '$datetime', '$hdid', '$user', '$userbaru', '$keterangan1')";
        //echo $query;
        $result = mysqli_query($koneksi, $query);

        $query1 = "update trans_hd set UserId='$userbaru' where HdId='$hdid'";
        $result1 = mysqli_query($koneksi, $query1);

        $query2 = "update trans_detail set UserId='$userbaru' where HdId='$hdid'";
        $result2 = mysqli_query($koneksi, $query2);

        if($result){
            header("location:../view/admin/editTransaksi.php?id=$hdid");
            $_SESSION['pesan'] = '<p><div class="alert alert-success">User berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }else{
            header("location:../view/admin/editTransaksi.php?id=$hdid");
            $_SESSION['pesan'] = '<p><div class="alert alert-warning">User gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        }
    } 

    //get Biaya Turunan ================================================================
    elseif(isset($_GET['biayaTurunanId'])){
        $id = $_GET['biayaTurunanId'];
        // echo $id;
        $result = getBiayaTurunan($koneksi, $id);

        echo $result;
    }


    //edit Biaya Turunan ================================================================
    elseif(isset($_POST['editBiayaTurunan'])){
        $hdid = $_POST['biayaTurunanHdid'];
        $request = [
            'Id' => $_POST['biayaTurunanId'],
            'NoSPK' => $_POST['biayaTurunanSPK'],
            'Turunan' => $_POST['biayaTurunanTurunan'],
            'Biaya_transport' => $_POST['biayaTransport'],
            'Biaya_inap' => $_POST['biayaInap'],
            'Biaya_lain' => $_POST['biayaLain']
        ];
        // echo json_encode($request);
        $result = editBiayaTurunan($datetime, $s_id, $koneksi, $request);

        if ($result) {
            if($akses == 'Admin'){
                header("location:../view/admin/editTransaksi.php?id=$hdid");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data Biaya Turunan berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            } else {
                header("location:../view/user/editTransaksi.php?id=$hdid");
                $_SESSION['pesan'] = '<p><div class="alert alert-success">Data Biaya Turunan berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        } else {
            if($akses == 'Admin'){
				header("location:../view/admin/editTransaksi.php?id=$hdid");
				$_SESSION['pesan'] = '<p><div class="alert alert-warning">Data Biaya Turunan gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            } else {
                header("location:../view/user/editTransaksi.php?id=$hdid");
                $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data Biaya Turunan gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
            }
        }
    }
?>