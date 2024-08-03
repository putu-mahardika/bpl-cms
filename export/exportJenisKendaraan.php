<!DOCTYPE html>
<html>
<head>
	<title>Data Customer - PT Berkah Permata Logistik</title>
</head>
<body>
    <?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Jenis Kendaraan - PT Berkah Permata Logistik.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	?>
 
	<center>
		<h1>Data Jenis Kendaraan - PT Berkah Permata Logistik</h1>
	</center>
	<table border="1">
		<tr>
			<th>No</th>
			<!-- <th>Kode</th> -->
			<th>Nama</th>
			<th>Status</th>
		</tr>
		<?php 
		// koneksi database
        include '../config/koneksi.php';
        $query = "select * from master_kendaraan";
		// menampilkan data pegawai
		$data = mysqli_query($koneksi,$query);
		$no = 1;
		while($d = mysqli_fetch_array($data)){
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<!-- <td><?php echo $d['Kode']; ?></td> -->
			<td><?php echo $d['Nama']; ?></td>
			<?php if ($d['IsActive'] == 1) { ?>
				<td>AKTIF</td>
			<?php } else { ?>
				<td>TIDAK AKTIF</td>
			<?php } ?>
		</tr>
		<?php 
		}
		?>
	</table>
</body>
</html>