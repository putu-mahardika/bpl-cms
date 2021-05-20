<?php

include "koneksi.php";



$t_id = $_POST['hdid'];



$query = "select * from trans_hd where HdId=".$t_id;

$fetch = mysqli_query($koneksi, $query);



//$response = "<table border='0' width='100%'>";

while($data = mysqli_fetch_array($fetch)){

	$query1 = "select * from master_customer where CustId='$data[CustId]'";

    $fetch1 = mysqli_query($koneksi, $query1);

    $data1 = mysqli_fetch_array($fetch1);

	

    $tgl = date("d-M-Y H:i:s", strtotime($data['create_date']));

    $nopo = $data['NoPO'];

    //$tglpo = $data['tgl_po'];

    $tglpo = date("d-M-Y", strtotime($data['tgl_po']));

    $nospk = $data['NoSPK'];

    //$tglspk = $data['tgl_spk'];

    $tglspk = date("d-M-Y", strtotime($data['tgl_spk']));

    $armada = $data['total_armada'];

    $kirim = $data['kota_kirim'];

    $tujuan = $data['kota_tujuan'];

    $barang = $data['Barang'];

    $keterangan = $data['keterangan'];

    $keterangan = str_replace("%%",PHP_EOL, $keterangan);

    $onclose = $data['OnClose'];

    $dateonclose = date("d-M-Y H:i:s", strtotime($data['DateOnClose']));

    $cancel = $data['atr1'];
    
    $userid = $data['UserId'];



    $query2 = mysqli_query($koneksi, "select count(*) as jumlah from trans_detail where NoSPK='$nospk'");

    $data0 = mysqli_fetch_array($query2);

    $query4 = mysqli_query($koneksi, "select nama from master_user where UserId='$userid'");
    $data4 = mysqli_fetch_array($query4);



    $response = "<label><b>Tgl : </b>".$tgl."</label><br>";

    $response .= "<label><b>Customer : </b>".$data1['nama']."</label><br>";
    $response .= "<label><b>NPWP : </b>".$data1['npwp']."</label><br>";

    if($cancel!=1){

        $response .= "<div class='row'><div class='col-sm-6'><label><b>No PO : </b>".$nopo."</label></div>";

        $response .= "<div class='col-sm-6'><label><b>Tgl PO : </b>".$tglpo."</label></div></div>";

        $response .= "<div class='row'><div class='col-sm-6'><label><b>No SPK : </b>".$nospk."</label></div>";

        $response .= "<div class='col-sm-6'><label><b>Tgl SPK : </b>".$tglspk."</label></div></div>";

    }else{

        $response .= "<div class='row'><div class='col-sm-6'><label><b>No PO : </b>".$nopo."</label> <label style='color:red;'>(Canceled)</label></div>";

        $response .= "<div class='col-sm-6'><label><b>Tgl PO : </b>".$tglpo."</label></div></div>";

        $response .= "<div class='row'><div class='col-sm-6'><label><b>No SPK : </b>".$nospk."</label> <label style='color:red;'>(Canceled)</label></div>";

        $response .= "<div class='col-sm-6'><label><b>Tgl SPK : </b>".$tglspk."</label></div></div>";

    }

    $response .= "<div class='row'><div class='col-sm-6'><label><b>Kota Asal : </b>".$kirim."</label></div>";

    $response .= "<div class='col-sm-6'><label><b>Kota Tujuan : </b>".$tujuan."</label></div></div>";

    $response .= "<label><b>Barang : </b>".$barang."</label><br>";

    $response .= "<label><b>Jumlah Armada : </b>".$armada."</label><br>";

    $response .= "<div class='row'><div style='padding-left:12px;width:105px'><label><b>Keterangan : </b></label></div><div style='width:auto;white-space:pre'><label>".$keterangan."</label></div></div>";


    if($onclose == 1){

        $response .= "<div class='row'><div class='col-sm-6'><label><b>On Close : </b><span class='badge badge-success'>Close</span></label></div>";

        $response .= "<div class='col-sm-6'><label><b>Tgl On Close : </b>".$dateonclose."</label></div>";

    } else {

        $response .= "<div class='row'><div class='col-sm-6'><label><b>On Close : </b><span class='badge badge-info'>Open</span></label></div>";

        $response .= "<div class='col-sm-6'><label><b>Tgl On Close : </b> - </label></div>";

    }

    $response .= "<div class='col-sm-6'><label><b>User : </b>".$data4['nama']."</label></div></div>";

    $response .= "<br>";

    if($data0['jumlah'] != 0){

        if($armada==1){

            $response .= "<label><b>No SPK Turunan :</b> ".$nospk."</label>";

			$response .= "<table class='table align-items-center table-flush table-hover' id='dataTableHover'>";

            $response .= "<thead class='thead-light'><tr>";

            $response .= "<th style='padding-left:8px;'>Tgl</th>

                            <th style='padding-left:8px;'>Jenis Kendaraan</th>

                            <th style='padding-left:8px;'>Nopol/Nama Kendaraan</th>

                            <th style='padding-left:8px;'>Status</th>

                            <th style='padding-left:8px;'>Keterangan Pengiriman</th>";

            $response .= "</tr></thead>";

            $response .= "<tbody>";



            $query3 = mysqli_query($koneksi, "select * from trans_detail where DtlId in (select max(DtlId) from trans_detail where NoSPK='$nospk')");

            while($data1=mysqli_fetch_array($query3)){

                $td_tgl = date("d-M-Y H:i:s", strtotime($data1['create_date']));

                $td_jenis = $data1['jenis_armada'];

                $td_nopol = $data1['nopol'];

                $td_keterangan = $data1['keterangan_kirim'];

                $td_keterangan = str_replace("%%",PHP_EOL, $td_keterangan);

                $td1_status = $data1['StsId'];

                $td_turunan = $data1['turunan'];

                $query4 = mysqli_query($koneksi, "select status from master_status where stsId='$td1_status'");

                $fetch2 = mysqli_fetch_array($query4);

                $td_status = $fetch2['status'];

                //if($i == $td_turunan){

					$response .= "<tr><td>".$td_tgl."</td>

                                <td>".$td_jenis."</td>

                                <td>".$td_nopol."</td>

                                <td>".$td_status."</td>

                                <td style='white-space:pre'>".$td_keterangan."</td></tr>";

                //}

            }

            $response .= "</tbody>";

            $response .= "</table>";

        }else{

            for($i=1;$i<=$armada;$i++){

                $response .= "<label><b>No SPK Turunan :</b> ".$nospk."-".$i."</label>";

                $response .= "<table class='table align-items-center table-flush table-hover' id='dataTableHover'>";

                $response .= "<thead class='thead-light'><tr>";

                $response .= "<th style='padding-left:8px;'>Tgl</th>

                                <th style='padding-left:8px;'>Jenis Kendaraan</th>

                                <th style='padding-left:8px;'>Nopol/Nama Kendaraan</th>

                                <th style='padding-left:8px;'>Status</th>

                                <th style='padding-left:8px;'>Keterangan Pengiriman</th>";

                $response .= "</tr></thead>";

                $response .= "<tbody>";



                $query3 = mysqli_query($koneksi, "select * from trans_detail where DtlId in (select max(DtlId) from trans_detail where NoSPK='$nospk' and turunan='$i')");

                while($data1=mysqli_fetch_array($query3)){

                    $td_tgl = date("d-M-Y H:i:s", strtotime($data1['create_date']));

                    $td_jenis = $data1['jenis_armada'];

                    $td_nopol = $data1['nopol'];

                    $td_keterangan = $data1['keterangan_kirim'];

                    $td_keterangan = str_replace("%%",PHP_EOL, $td_keterangan);

                    $td1_status = $data1['StsId'];

                    $td_turunan = $data1['turunan'];



                    $query4 = mysqli_query($koneksi, "select status from master_status where stsId='$td1_status'");

                    $fetch2 = mysqli_fetch_array($query4);

                    $td_status = $fetch2['status'];

                    if($i == $td_turunan){

                    $response .= "<tr><td>".$td_tgl."</td>

                                    <td>".$td_jenis."</td>

                                    <td>".$td_nopol."</td>

                                    <td>".$td_status."</td>

                                    <td style='white-space:pre'>".$td_keterangan."</td></tr>";

                    }

                }

                $response .= "</tbody>";

                $response .= "</table>";

                $response .= "<br>";

            }

        }

    }else{

		if($armada==1){

			$response .= "<label><b>No SPK Turunan :</b> ".$nospk."</label>";

			$response .= "<table class='table align-items-center table-flush table-hover' id='dataTableHover'>";

            $response .= "<thead class='thead-light'><tr>";

            $response .= "<th style='padding-left:8px;'>Tgl</th>

                            <th style='padding-left:8px;'>Jenis Kendaraan</th>

                            <th style='padding-left:8px;'>Nopol/Nama Kendaraan</th>

                            <th style='padding-left:8px;'>Status</th>

                            <th style='padding-left:8px;'>Keterangan Pengiriman</th>";

            $response .= "</tr></thead>";

            $response .= "<tbody>";

			$response .= "</tbody>";

            $response .= "</table>";

		} else {

			for($i=1;$i<=$armada;$i++){

                $response .= "<label><b>No SPK Turunan :</b> ".$nospk."-".$i."</label>";

                $response .= "<table class='table align-items-center table-flush table-hover' id='dataTableHover'>";

                $response .= "<thead class='thead-light'><tr>";

                $response .= "<th style='padding-left:8px;'>Tgl</th>

                                <th style='padding-left:8px;'>Jenis Kendaraan</th>

                                <th style='padding-left:8px;'>Nopol/Nama Kendaraan</th>

                                <th style='padding-left:8px;'>Status</th>

                                <th style='padding-left:8px;'>Keterangan Pengiriman</th>";

                $response .= "</tr></thead>";

                $response .= "<tbody>";

				$response .= "</tbody>";

                $response .= "</table>";

                $response .= "<br>";

			}

		}

	}

    



    echo $response;



    exit;

}



?>