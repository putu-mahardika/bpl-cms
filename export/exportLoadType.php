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
	<title>Data Load Type - PT Berkah Permata Logistik</title>
</head>
<body>
    <?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Load Type - PT Berkah Permata Logistik.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	?>
 
	<center>
		<h1>Data Load Type - PT Berkah Permata Logistik</h1>
	</center>
	<table border="1">
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>Status Aktif</th>
		</tr>
		<?php 
		// koneksi database
		include '../config/koneksi.php';
		if ($akses == 'Admin') {
			$query = "select * from master_load_type";
		} else {
			$query = "select * from master_load_type where UserId=".$s_id;
		}
		// menampilkan data pegawai
		$data = mysqli_query($koneksi,$query);
		$no = 1;
		while($d = mysqli_fetch_array($data)){
		?>
		<tr>
			<td><?php echo $d['atr1']; ?></td>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td><?php echo $d['aktif'] == 1 ? 'Aktif' : 'Tidak Aktif'; ?></td>
		</tr>
		<?php 
		}
		?>
	</table>
</body>
</html>