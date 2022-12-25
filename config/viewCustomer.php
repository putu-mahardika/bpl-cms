<?php
session_save_path('../tmp');
session_start();
include "koneksi.php";

$c_id = $_POST['custid'];

$idLoggedUser = $_SESSION['id'];

// $query = "select * from master_customer where CustId=".$c_id;
$query = "select a.*, b.nama as namaUser from master_customer a, master_user b where a.UserId = b.UserId and CustId=".$c_id;
$fetch = mysqli_query($koneksi, $query);

//$response = "<table border='0' width='100%'>";
while($data = mysqli_fetch_array($fetch)){
    $id = $data['CustId'];
    $kode = $data['kode_customer'];
    $npwp = $data['npwp'];
    $nama = $data['nama'];
    $alamat = $data['alamat'];
    $telp = $data['telp'];
    $bidang = $data['bidang_usaha'];
    $email = $data['email'];
    $pic = $data['PIC'];
    $pic_telp = $data['PIC_telp'];
    $pic_email = $data['PIC_email'];
    $keterangan = $data['keterangan'];
    $aktif = $data['aktif'];
    $idUser = $data['UserId'];
    $namaUser = $data['namaUser'];
    $createDate = $data['create_date'];

    $response = "<label><b>Kode : </b>".$kode."</label><br>";
    $response .= "<label><b>NPWP : </b>".$npwp."</label><br>";
    $response .= "<label><b>Nama : </b>".$nama."</label><br>";
    $response .= "<label><b>Alamat : </b>".$alamat."</label><br>";
    $response .= "<label><b>Telp : </b>".$telp."</label><br>";
    $response .= "<label><b>Bidang Usaha : </b>".$bidang."</label><br>";
    $response .= "<label><b>Email : </b>".$email."</label><br>";
    $response .= "<label><b>PIC : </b>".$pic."</label><br>";
    $response .= "<label><b>Telp PIC : </b>".$pic_telp."</label><br>";
    $response .= "<label><b>E-mail PIC : </b>".$pic_email."</label><br>";
    if ($idLoggedUser != $idUser) {
        $response .= "<label><b>Sales : </b>".$namaUser."</label><br>";
    }
    $response .= "<label><b>Create Date : </b>".$createDate."</label><br>";
    $response .= "<label><b>Keterangan : </b>".$keterangan."</label><br>";
    if($aktif == 1){
        $response .= "<label><b>Aktif : </b><span class='badge badge-success'>Aktif</span></label>";
    } else {
        $response .= "<label><b>Aktif : </b><span class='badge badge-danger'>Tidak Aktif</span></label>";
    }

    echo $response;

    exit;
}

?>