<!DOCTYPE html>
<html>
<head>
	<title>Data Vendor - PT Berkah Permata Logistik</title>
</head>
<body>
    <?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Vendor - PT Berkah Permata Logistik.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	?>
 
	<center>
		<h1>Data Vendor - PT Berkah Permata Logistik</h1>
	</center>
	<table border="1">
		<tr>
			<th>No</th>
			<th>Kode</th>
			<th>Nama</th>
			<th>Alamat</th>
			<th>NPWP</th>
			<th>PIC</th>
			<th>Telp PIC</th>
			<th>Tipe</th>
			<th>Tipe Pengiriman</th>
			<th>Tgl Terdaftar</th>
			<th>Keterangan</th>
			<th>Link</th>
			<th>Status</th>
		</tr>
		<?php 
		// koneksi database
        include '../config/koneksi.php';
        $query = "select * from master_vendor";
		// menampilkan data pegawai
		$data = mysqli_query($koneksi,$query);
		$no = 1;
		while($d = mysqli_fetch_array($data)){
		?>
		<tr>
			<td><?php echo $no++; ?></td>
			<td><?php echo $d['kode']; ?></td>
			<td><?php echo $d['nama']; ?></td>
			<td><?php echo $d['alamat'];?></td>
			<td><?php echo $d['npwp'];?></td>
			<td><?php echo $d['pic'];?></td>
			<td><?php echo $d['pic_telp'];?></td>
			<td><?php echo $d['type'];?></td>
			<td><?php echo $d['delivery_type'];?></td>
			<td><?php echo $d['create_date'];?></td>
			<td><?php echo $d['note'];?></td>
			<td><?php echo $d['link'];?></td>
			<?php if ($d['isActive'] == 1) { ?>
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