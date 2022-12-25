<!DOCTYPE html>
<html>
<head>
	<title>Data Transaksi - PT Berkah Permata Logistik</title>
</head>
<body>
    <?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Transaksi Pergerakan Truk - PT Berkah Permata Logistik.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	?>
 
	<center>
		<h1>Data Transaksi Pergerakan Truck - PT Berkah Permata Logistik</h1>
	</center>
	<table border="1">
		<tr>
			<th>No</th>
			<th>Tgl</th>
			<th>No PO</th>
			<th>Tgl PO</th>
			<th>No SPK</th>
			<th>Tgl SPK</th>
            <th>Nama Customer</th>
			<th>NPWP</th>
            <th>Asal</th>
            <th>Tujuan</th>
            <th>Barang</th>
            <th>Jumlah Armada</th>
            <th>Keterangan</th>
            <th>On Close</th>
            <th>Tgl On Close</th>
			<th>User Saat Ini</th>
			<th>User Sebelumnya</th>
			<th>Tgl Perubahan</th>
			<th>keterangan perubahan</th>
		</tr>
		<?php 
		// koneksi database
        include '../config/koneksi.php';
        $query = "select * from trans_hd where atr1=0";
		// menampilkan data pegawai
		$data = mysqli_query($koneksi,$query);
		$no = 1;
		while($d = mysqli_fetch_array($data)){
			$hdid = $d['HdId'];
			$querylog_count = mysqli_query($koneksi, "select count(Id) as jumlah from log where HdId=$hdid");
			$log_count0 = mysqli_fetch_array($querylog_count);
			$log_count = $log_count0['jumlah'];
			$querylog = "select * from log where Id in (select max(Id) from log where HdId=$hdid)";
			$fetchlog = mysqli_query($koneksi, $querylog);
			$d_log = mysqli_fetch_array($fetchlog);
			//$log_count = count($d_log);
			
			if($log_count != 0){
				$userlama = $d_log['UserIdLama'];
				$query_u0 = "select nama from master_user where UserId=$userlama";
				$fetch_u0 = mysqli_query($koneksi, $query_u0);
				$d_u0 = mysqli_fetch_array($fetch_u0);
			}
			
			$custid = $d['CustId'];
			$query1 = "select * from master_customer where CustId=$custid";
			$data1 = mysqli_query($koneksi, $query1);
			$d1 = mysqli_fetch_array($data1);

			$userid = $d['UserId'];
			$query_u = "select nama from master_user where UserId=$userid";
			$fetch_u = mysqli_query($koneksi, $query_u);
			$d_u = mysqli_fetch_array($fetch_u);

			if($d['atr1'] == 0){
				$keterangan1 = $d['keterangan'];
				$keterangan = str_replace("%%","<br style='mso-data-placement:same-cell;' />", $keterangan1);
				

		?>
		<tr>
			<td style="vertical-align: top;"><?php echo $no++; ?></td>
			<td style="vertical-align: top;"><?php echo $d['create_date']; ?></td>
			<td style="vertical-align: top;"><?php echo $d['NoPO']; ?></td>
			<td style="vertical-align: top;"><?php echo $d['tgl_po']; ?></td>
            <td style="vertical-align: top;"><?php echo $d['NoSPK']; ?></td>
            <td style="vertical-align: top;"><?php echo $d['tgl_spk']; ?></td>
            <td style="vertical-align: top;"><?php echo $d1['nama']; ?></td>
			<td style="vertical-align: top;"><?php echo $d1['npwp']; ?></td>
            <td style="vertical-align: top;"><?php echo $d['kota_kirim']; ?></td>
            <td style="vertical-align: top;"><?php echo $d['kota_tujuan']; ?></td>
            <td style="vertical-align: top;"><?php echo $d['Barang']; ?></td>
            <td style="vertical-align: top;"><?php echo $d['total_armada']; ?></td>
            <td style="vertical-align: top;white-space:pre"><?php echo $keterangan?></td>
			<?php if($d['OnClose'] == 0){ ?>
				<td style="vertical-align: top;">OPEN</td>
				<td style="vertical-align: top;"></td>
			<?php } else { ?>
				<td style="vertical-align: top;">Close</td>
				<?php
					$tgl = date('d/m/Y', strtotime($d['DateOnClose']));
				?>
				<td style="vertical-align: top;"><?php echo $tgl?></td>
			<?php } ?>
			<td style="vertical-align: top;"><?php echo $d_u['nama']; ?></td>
			<?php 
			if($log_count != 0){
				$keterangan_log0 = $d_log['keterangan'];
				$keterangan_log = str_replace("%%","<br style='mso-data-placement:same-cell;' />", $keterangan_log0);
			?>
			<td style="vertical-align: top;"><?php echo $d_u0['nama']; ?></td>
			<td style="vertical-align: top;"><?php echo $d_log['create_date']; ?></td>
			<td style="vertical-align: top;white-space:pre"><?php echo $keterangan_log?></td>
			<?php }else{?>
			<td></td>
			<td></td>
			<td></td>
			<?php } ?>
		</tr>
		<?php 
			} else {
				continue;
			}
		}
		?>
	</table>
</body>
</html>