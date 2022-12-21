<?php
	session_save_path('../tmp');
	session_start();
	//$s_username = $_SESSION['username'];
	$s_id = $_SESSION['id'];
	$akses = $_SESSION['hak_akses'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Data Customer - PT Berkah Permata Logistik</title>
</head>
<body>
    <?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Customer - PT Berkah Permata Logistik.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	?>
 
	<center>
		<h1>Data Customer - PT Berkah Permata Logistik</h1>
	</center>
	<table border="1">
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>NPWP</th>
			<th>Alamat</th>
			<th>Telp</th>
			<th>E-mail</th>
			<th>Bidang Usaha</th>
			<th>PIC</th>
			<th>PIC Telp</th>
			<th>PIC e-mail</th>
			<th>Keterangan</th>
		</tr>
		<?php 
		// koneksi database
		include '../config/koneksi.php';
		if ($akses == 'Admin') {
			$query = "select * from master_customer";
		} else {
			$query = "select * from master_customer where UserId=".$s_id;
		}
		// menampilkan data pegawai
		$data = mysqli_query($koneksi,$query);
		$no = 1;
		while($d = mysqli_fetch_array($data)){
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $d['kode_customer']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td><?php echo $d['npwp']; ?></td>
			<td><?php echo $d['alamat']; ?></td>
			<td><?php echo $d['telp']; ?></td>
			<td><?php echo $d['email']; ?></td>
			<td><?php echo $d['bidang_usaha']; ?></td>
			<td><?php echo $d['PIC']; ?></td>
			<td><?php echo $d['PIC_telp']; ?></td>
			<td><?php echo $d['PIC_email']; ?></td>
			<td><?php echo $d['keterangan']; ?></td>
		</tr>
		<?php 
		}
		?>
	</table>
</body>
</html>