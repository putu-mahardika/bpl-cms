<?php
//require('vendor/fpdf/fpdf.php');
include '../config/koneksi.php';
require('../vendor/fpdf/mc_table.php');

date_default_timezone_set("Asia/Jakarta");
$datetime = date('d-m-Y H-i-s');


class PDF extends PDF_MC_Table
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('../img/logo-BPL-min.png',10,12,50);
        // Arial bold 12
        $this->SetFont('Arial','B',12);
        // Geser Ke Kanan 35mm
        $this->Cell(53);
        // Judul
        $this->Cell(48,7,'PT BERKAH PERMATA LOGISTIK',0,1,'L');
        $this->Cell(53);
        $this->SetFont('Arial','',10);
        $this->Cell(48,5,'Gedung The Vida Lt.17',0,1,'L');
        $this->Cell(53);
        $this->Cell(48,5,'Jl. Pejuangan No. 817 Kebon Jeruk, Jakarta Barat, DKI Jakarta - 11530',0,1,'L');
        $this->Cell(53);
        $this->Cell(48,5,'Telp : (021) 2977-8141 | Email : adm1.berkahpermatalogistik@gmail.com',0,1,'L');
        $this->Cell(53);
        $this->Cell(48,5,'www.berkahpermatalogistik.com',0,1,'L');
        $this->SetFont('Arial','B',12);
        // Garis Bawah Double
        $this->Cell(190,1,'','B',1,'L');
        $this->Cell(190,1,'','B',0,'L');
        // Line break 5mm
        $this->Ln(5);
    }
    // Page footer
    function Footer()
    {
        // Posisi 15 cm dari bawah
        $this->SetY(-16);
        $this->Cell(190,1,'','B',1,'L');
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(48,5,'printed from www.berkahpermatalogistik.com/management-tracking/tracking.php',0,1,'L');
        $this->Cell(48,3,'by inputting spk number as track number, no authorize sign require.',0,0,'L');
        $this->Cell(0,3,'Page '.$this->PageNo().'/{nb}',0,1,'R');
    }
}

//Membuat file PDF
$pdf = new PDF();

//Alias total halaman dengan default {nb} (berhubungan dengan PageNo())
$pdf->AliasNbPages();

//code ambil data dari db
if(isset($_POST['print'])){
    //$spk = $_POST['spk'];
    //$spk = '1234;123;1234';
    $spk0 = $_POST['spk'];
    $spk = $spk0;
    $spk = strtoupper($spk);
    $x= " ";
    if (strstr($spk, $x)){
        $spk = str_replace($x, "", $spk);
    }
    
    $x = ";";
    if (strstr($spk, $x)){
        $spk = explode(';', $spk);
        $countspk = count($spk);
        if($countspk > 10){
            $countspk = 10;
        }
    }else{
        $spk=$spk;
        $countspk=1;
    } 

    if($countspk == 1){
        $query0 = mysqli_query($koneksi, "select count(HdId) as jumlah from trans_hd where NoSPK='$spk' and atr1=0");
        $data0 = mysqli_fetch_array($query0);
        if($data0['jumlah'] != 0){
            $query = "select * from trans_hd where NoSPK='$spk' and atr1=0";
            $fetch = mysqli_query($koneksi, $query);
            while($data=mysqli_fetch_array($fetch)){
                $nospk = $data['NoSPK'];
                $armada = $data['total_armada'];

                $pdf->AddPage();
                //$pdf->SetFont('Times','B',16);
                //$pdf->Cell(0,10,'TRANSAKSI',0,1,'C');
                //noSPK
                $pdf->SetFont('Times','B',13);
                $pdf->Cell(0,10,"No. SPK : $nospk",0,1,'L');
                $pdf->Ln(2);
                //tgl transaksi
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(25,7,'Tanggal ',0,0,'L');
                $pdf->SetFont('Times','',12);
                $tgl = date("d F Y H:i", strtotime($data['create_date']));
                $pdf->Cell(0,7,": $tgl",0,1,'L');
                //nama customer
                $query_c = "select nama from master_customer where CustId='$data[CustId]'";
                $fetch_c = mysqli_query($koneksi, $query_c);
                $data_c = mysqli_fetch_array($fetch_c);

                $pdf->SetFont('Times','B',12);
                $pdf->Cell(25,7,'Customer ',0,0,'L');
                $pdf->SetFont('Times','',12);
                $pdf->Cell(0,7,": $data_c[nama]",0,1,'L');
                //noPO
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(25,7,'No PO ',0,0,'L');
                $pdf->SetFont('Times','',12);
                $pdf->Cell(70,7,": $data[NoPO]",0,0,'L');
                //tglPO
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(25,7,'Tgl PO ',0,0,'L');
                $pdf->SetFont('Times','',12);
                $tglpo = date("d F Y", strtotime($data['tgl_po']));
                $pdf->Cell(0,7,": $tglpo",0,1,'L');
                //noSPK
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(25,7,'No SPK ',0,0,'L');
                $pdf->SetFont('Times','',12);
                $pdf->Cell(70,7,": $data[NoSPK]",0,0,'L');
                //tglSPK
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(25,7,'Tgl SPK ',0,0,'L');
                $pdf->SetFont('Times','',12);
                $tglspk = date("d F Y", strtotime($data['tgl_spk']));
                $pdf->Cell(0,7,": $tglspk",0,1,'L');
                //kota asal
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(25,7,'Kota Asal ',0,0,'L');
                $pdf->SetFont('Times','',12);
                $pdf->Cell(70,7,": $data[kota_kirim]",0,0,'L');
                //kota tujuan
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(25,7,'Kota Tujuan ',0,0,'L');
                $pdf->SetFont('Times','',12);
                $pdf->Cell(0,7,": $data[kota_tujuan]",0,1,'L');
                //jml armada
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(32,7,'Jumlah Armada ',0,0,'L');
                $pdf->SetFont('Times','',12);
                $pdf->Cell(0,7,": $armada",0,1,'L');
                //keterangan
                $pdf->SetFont('Times','B',12);
                $pdf->Cell(25,7,'Keterangan ',0,0,'L');
                $pdf->SetFont('Times','',12);
                $keterangan = $data['keterangan'];
                $keterangan = str_replace("%%","\n", $keterangan);
                $pdf->Multicell(0,7,": $keterangan");
                //onclose
                if($data['OnClose'] != 0){
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Status ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Cell(70,7,': Close',0,0,'L');
                    //tgl onclose
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Tgl Close ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $tglclose = date("d F Y", strtotime($data['DateOnClose']));
                    $pdf->Cell(0,7,": $tglclose",0,1,'L');
                }else{
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Status ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Cell(70,7,': Open',0,0,'L');
                    //tgl onclose
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Tgl Close ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Cell(0,7,': -',0,1,'L');
                }

                //spasi
                $pdf->Ln(3);
                $pdf->Cell(190,1,'','B',1,'L');
                $pdf->Ln(3);

                for($i=1;$i<=$armada;$i++){
                    //spk turunan
                    $pdf->SetFont('Times','B',13);
                    $pdf->Cell(40,7,'No. SPK Turunan ',0,0,'L');
                    $pdf->SetFont('Times','',13);
                    $pdf->Cell(0,7,": $nospk-$i",0,1,'L');

                    //tabel spk turunan
                    $query_dtl = "select * from trans_detail where NoSPK='$nospk' and turunan='$i' order by DtlId desc";
                    $fetch_dtl = mysqli_query($koneksi, $query_dtl);
                    
                    $pdf->SetFont('Times','B',12);
                    $pdf->SetWidths(array(30,35,35,30,60));
                    $pdf->Row1(array("Tgl", "Jenis\nKendaraan", "Nopol/\nNama Kendaraan", "Status", "Keterangan"));
                    $pdf->SetFont('Times','',11);
                    while($data_dtl=mysqli_fetch_array($fetch_dtl)){
                        $query_dtl_s = "select status from master_status where stsId=$data_dtl[StsId]";
                        $fetch_dtl_s = mysqli_query($koneksi, $query_dtl_s);
                        $data_dtl_s = mysqli_fetch_array($fetch_dtl_s);
                        $keterangan_dtl = $data_dtl['keterangan_kirim'];
                        $keterangan_dtl = str_replace("%%","\n", $keterangan_dtl);
                        $tgldtl = date("d-M-Y H:i", strtotime($data_dtl['create_date']));
                        $pdf->Row(array("$tgldtl", "$data_dtl[jenis_armada]", "$data_dtl[nopol]", "$data_dtl_s[status]", "$keterangan_dtl"));
                    }
                    $pdf->Ln(5);
                } 
            }
        } else {
            $pdf->AddPage();
            $pdf->SetFont('Times','B',16);
            $pdf->Cell(0,10,'TRANSAKSI',0,1,'C');
            //noSPK
            $pdf->SetFont('Times','B',13);
            $pdf->Cell(0,10,"No. SPK : $spk",0,1,'L');
            $pdf->Ln(20);
            $pdf->SetFont('Times','I',12);
            $pdf->Cell(0,7,'Maaf Data Tidak Ditemukan',0,0,'C');
        }
        $pdf->Output("BPL.TRACK.$datetime.pdf", "I");
    } else {
        for($a=0;$a<$countspk;$a++){
            
            $query0 = mysqli_query($koneksi, "select count(HdId) as jumlah from trans_hd where NoSPK='$spk[$a]' and atr1=0");
            $data0 = mysqli_fetch_array($query0);
            if($data0['jumlah'] != 0){
                $query = "select * from trans_hd where NoSPK='$spk[$a]' and atr1=0";
                $fetch = mysqli_query($koneksi, $query);
                while($data=mysqli_fetch_array($fetch)){
                    $nospk = $data['NoSPK'];
                    $armada = $data['total_armada'];

                    $pdf->AddPage();
                    //$pdf->SetFont('Times','B',16);
                    //$pdf->Cell(0,10,'TRANSAKSI',0,1,'C');
                    //noSPK
                    $pdf->SetFont('Times','B',13);
                    $pdf->Cell(0,10,"No. SPK : $nospk",0,1,'L');
                    $pdf->Ln(2);
                    //tgl transaksi
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Tanggal ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $tgl = date("d F Y H:i", strtotime($data['create_date']));
                    $pdf->Cell(0,7,": $tgl",0,1,'L');
                    //nama customer
                    $query_c = "select nama from master_customer where CustId='$data[CustId]'";
                    $fetch_c = mysqli_query($koneksi, $query_c);
                    $data_c = mysqli_fetch_array($fetch_c);
        
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Customer ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Cell(0,7,": $data_c[nama]",0,1,'L');
                    //noPO
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'No PO ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Cell(70,7,": $data[NoPO]",0,0,'L');
                    //tglPO
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Tgl PO ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $tglpo = date("d F Y", strtotime($data['tgl_po']));
                    $pdf->Cell(0,7,": $tglpo",0,1,'L');
                    //noSPK
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'No SPK ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Cell(70,7,": $data[NoSPK]",0,0,'L');
                    //tglSPK
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Tgl SPK ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $tglspk = date("d F Y", strtotime($data['tgl_spk']));
                    $pdf->Cell(0,7,": $tglspk",0,1,'L');
                    //kota asal
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Kota Asal ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Cell(70,7,": $data[kota_kirim]",0,0,'L');
                    //kota tujuan
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Kota Tujuan ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Cell(0,7,": $data[kota_tujuan]",0,1,'L');
                    //jml armada
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(32,7,'Jumlah Armada ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $pdf->Cell(0,7,": $armada",0,1,'L');
                    //keterangan
                    $pdf->SetFont('Times','B',12);
                    $pdf->Cell(25,7,'Keterangan ',0,0,'L');
                    $pdf->SetFont('Times','',12);
                    $keterangan = $data['keterangan'];
                    $keterangan = str_replace("%%","\n", $keterangan);
                    $pdf->Multicell(0,7,": $keterangan");
                    //onclose
                    if($data['OnClose'] != 0){
                        $pdf->SetFont('Times','B',12);
                        $pdf->Cell(25,7,'Status ',0,0,'L');
                        $pdf->SetFont('Times','',12);
                        $pdf->Cell(70,7,': Close',0,0,'L');
                        //tgl onclose
                        $pdf->SetFont('Times','B',12);
                        $pdf->Cell(25,7,'Tgl Close ',0,0,'L');
                        $pdf->SetFont('Times','',12);
                        $tglclose = date("d F Y", strtotime($data['DateOnClose']));
                        $pdf->Cell(0,7,": $tglclose",0,1,'L');
                    }else{
                        $pdf->SetFont('Times','B',12);
                        $pdf->Cell(25,7,'Status ',0,0,'L');
                        $pdf->SetFont('Times','',12);
                        $pdf->Cell(70,7,': Open',0,0,'L');
                        //tgl onclose
                        $pdf->SetFont('Times','B',12);
                        $pdf->Cell(25,7,'Tgl Close ',0,0,'L');
                        $pdf->SetFont('Times','',12);
                        $pdf->Cell(0,7,': -',0,1,'L');
                    }
                    //spasi
                    $pdf->Ln(3);
                    $pdf->Cell(190,1,'','B',1,'L');
                    $pdf->Ln(3);

                    for($i=1;$i<=$armada;$i++){
                        //spk turunan
                        $pdf->SetFont('Times','B',13);
                        $pdf->Cell(40,7,'No. SPK Turunan ',0,0,'L');
                        $pdf->SetFont('Times','',13);
                        $pdf->Cell(0,7,": $nospk-$i",0,1,'L');

                        //tabel spk turunan
                        $query_dtl = "select * from trans_detail where NoSPK='$nospk' and turunan='$i' order by DtlId desc";
                        $fetch_dtl = mysqli_query($koneksi, $query_dtl);
                        
                        $pdf->SetFont('Times','B',12);
                        $pdf->SetWidths(array(30,35,35,30,60));
                        $pdf->Row1(array("Tgl", "Jenis\nKendaraan", "Nopol/\nNama Kendaraan", "Status", "Keterangan"));
                        $pdf->SetFont('Times','',11);
                        while($data_dtl=mysqli_fetch_array($fetch_dtl)){
                            $query_dtl_s = "select status from master_status where stsId=$data_dtl[StsId]";
                            $fetch_dtl_s = mysqli_query($koneksi, $query_dtl_s);
                            $data_dtl_s = mysqli_fetch_array($fetch_dtl_s);
                            $keterangan_dtl = $data_dtl['keterangan_kirim'];
                            $keterangan_dtl = str_replace("%%","\n", $keterangan_dtl);
                            $tgldtl = date("d-M-Y H:i", strtotime($data_dtl['create_date']));
                            $pdf->Row(array("$tgldtl", "$data_dtl[jenis_armada]", "$data_dtl[nopol]", "$data_dtl_s[status]", "$keterangan_dtl"));
                        }
                        $pdf->Ln(5);
                    }      
                }  
            } else {
                $pdf->AddPage();
                $pdf->SetFont('Times','B',16);
                $pdf->Cell(0,10,'TRANSAKSI',0,1,'C');
                //noSPK
                $pdf->SetFont('Times','B',13);
                $pdf->Cell(0,10,"No. SPK : $spk[$a]",0,1,'L');
                $pdf->Ln(20);
                $pdf->SetFont('Times','I',12);
                $pdf->Cell(0,7,'Maaf Data Tidak Ditemukan',0,0,'C');
            }     
        }
        $pdf->Output("BPL.TRACK.$datetime.pdf", "I");
    }
}
?>