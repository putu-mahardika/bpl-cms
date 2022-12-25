<?php

include "koneksi.php";



$td_id = $_POST['dtlid'];



$query = "select * from trans_detail where DtlId=".$td_id;

$fetch = mysqli_query($koneksi, $query);



//$response = "<table border='0' width='100%'>";

while($data = mysqli_fetch_array($fetch)){

	$hdid = $data['HdId'];

    $query_c = "select a.nama from master_customer as a inner join trans_hd as b on b.HdId='$hdid' and b.CustId=a.CustId";

	$query_s = "select status from master_status where stsid='$data[StsId]'";

	$query_t = "select total_armada from trans_hd where HdId='$hdid'";

	

	$fetch_c = mysqli_query($koneksi, $query_c);

	$fetch_s = mysqli_query($koneksi, $query_s);

	$fetch_t = mysqli_query($koneksi, $query_t);

	

	$data_c = mysqli_fetch_array($fetch_c);

	$data_s = mysqli_fetch_array($fetch_s);

	$data_t = mysqli_fetch_array($fetch_t);

	

	$tgl = date("d-M-Y H:i", strtotime($data['datetime_status']));

	$nospk = $data['NoSPK'];

	$turunan = $data['turunan'];

	$customer = $data_c['nama'];

	$jenis = $data['jenis_armada'];

	$nopol = $data['nopol'];

	$keterangan = $data['keterangan_kirim'];
	$keterangan = str_replace("%%",PHP_EOL, $keterangan);

	$status = $data_s['status'];

	$onclose = $data['OnClose'];

	$armada = $data_t['total_armada']; 



    $response = "<label><b>Tgl : </b>".$tgl."</label><br>";

	if($armada == 1){

		$response .= "<label><b>No SPK Turunan : </b>".$nospk."</label><br>";

	} else {

		$response .= "<label><b>No SPK Turunan : </b>".$nospk."-".$turunan."</label><br>";

	}

    $response .= "<label><b>Nama Customer : </b>".$customer."</label><br>";

    $response .= "<label><b>Jenis Kendaraan : </b>".$jenis."</label><br>";

    $response .= "<label><b>Nopol/Nama Kendaraan : </b>".$nopol."</label><br>";

    $response .= "<div class='row'><div style='padding-left:12px;width:190px'><label><b>Keterangan Pengiriman : </b></label></div><div style='width:auto;white-space:pre'><label>".$keterangan."</label></div></div>";

    $response .= "<label><b>Status Pengiriman : </b>".$status."</label><br>";

    if($onclose == 1){

        $response .= "<label><b>On Close : </b><span class='badge badge-success'>Close</span></label>";

    } else {

        $response .= "<label><b>On Close : </b><span class='badge badge-danger'>Open</span></label>";

    }



    echo $response;



    exit;

}



?>