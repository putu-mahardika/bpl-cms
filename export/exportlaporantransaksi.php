<?php
	include '../config/koneksi.php';
		
	$start = $_GET['start'];
	$end = $_GET['end'];
	$start0 = date('d-M-Y', strtotime($start));
	$end0 = date('d-M-Y', strtotime($end));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pergerakan Truck - PT Berkah Permata Logistik</title>
</head>
<body>
    <?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Laporan Pergerakan Truck - PT Berkah Permata Logistik.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	?>
 
	<center>
		<h1>Laporan Detail Pergerakan Truck - PT Berkah Permata Logistik</h1>

			<p style="font-size:13pt;"><b>Periode : </b><?php echo $start0?> - <?php echo $end0?></p>
		
	</center>
	<table border="1">
		<tr>
			<th>No</th>
			<th>Tgl Detail Pergerakan</th>
			<th>No SPK</th>
			<th>Tgl SPK</th>
			<th>No SPK Turunan</th>
			<th>No PO</th>
            <th>Customer</th>
			<th>NPWP</th>
            <th>Kota Asal</th>
            <th>Kota Tujuan</th>
            <th>Jenis Armada</th>
            <th>Nopol</th>
            <th>Keterangan</th>
            <th>Status</th>
			<th>Status On Close</th>
			<th>User</th>
		</tr>
		<?php 
		// koneksi database
		$query = "select * from trans_detail where atr1=0 and create_date between '$start 00:00:00' and '$end 23:59:59'";

		// menampilkan data pegawai
		$data = mysqli_query($koneksi,$query);
		$no = 1;
		while($d = mysqli_fetch_array($data)){
			$hdid = $d['HdId'];
			$turunan = $d['turunan'];
			$nospk = $d['NoSPK'];
			//$custid = $d['CustId'];
			//$query1 = "select nama from master_customer where CustId=$custid";
			//$data1 = mysqli_query($koneksi, $query1);
			//$d1 = mysqli_fetch_array($data1);
			$keterangan = $d['keterangan_kirim'];
            $keterangan = str_replace("%%","<br style='mso-data-placement:same-cell;' />", $keterangan);
		?>
		<tr>
			<td style="vertical-align: top;"><?php echo $no++; ?></td>
			<?php
			$tgl = date('d-M-Y H:i:s', strtotime($d['create_date']));
			?>
			<td style="vertical-align: top;"><?php echo $tgl?></td>
			<td style="vertical-align: top;"><?php echo $nospk?></td>
			
			<?php
			$query_hd = "select * from trans_hd where HdId=$hdid";
			$fetch_hd = mysqli_query($koneksi, $query_hd);
			$d_hd = mysqli_fetch_array($fetch_hd);
			?>
			<td style="vertical-align: top;"><?php echo $d_hd['tgl_spk']?></td>
			<?php if($turunan == 0){?>
			<td style="vertical-align: top;"><?php echo $nospk?></td>
			<?php }else{?>
			<td style="vertical-align: top;"><?php echo $nospk?>-<?php echo $turunan?></td>
			<?php } ?>
			<td style="vertical-align: top;"><?php echo $d_hd['NoPO']?></td>
			<?php
			$query_c = "select * from master_customer where CustId=$d_hd[CustId]";
			$fetch_c = mysqli_query($koneksi, $query_c);
			$d_c = mysqli_fetch_array($fetch_c);
			?>
			<td style="vertical-align: top;"><?php echo $d_c['nama']?></td>
			<td style="vertical-align: top;"><?php echo $d_c['npwp']?></td>
			<td style="vertical-align: top;"><?php echo $d_hd['kota_kirim']?></td>
			<td style="vertical-align: top;"><?php echo $d_hd['kota_tujuan']?></td>
			<td style="vertical-align: top;"><?php echo $d['jenis_armada']?></td>
			<td style="vertical-align: top;"><?php echo $d['nopol']?></td>
			<td style="vertical-align: top;"><?php echo $keterangan?></td>
			<?php
			$query_s = "select status from master_status where stsId=$d[StsId]";
			$fetch_s = mysqli_query($koneksi, $query_s);
			$d_s = mysqli_fetch_array($fetch_s);
			?>
			<td style="vertical-align: top;"><?php echo $d_s['status']?></td>
			<?php if($d['OnClose' == 0]){?>
				<td style="vertical-align: top;">OPEN</td>
			<?php }else{?>
				<td style="vertical-align: top;">CLOSE</td>
			<?php }?>
			<?php
			$query_u = "select nama from master_user where UserId=$d[UserId]";
			$fetch_u = mysqli_query($koneksi, $query_u);
			$d_u = mysqli_fetch_array($fetch_u);
			?>
			<td style="vertical-align: top;"><?php echo $d_u['nama']?></td>
		</tr>
		<?php 
		}
		?>
	</table>
</body>
</html>