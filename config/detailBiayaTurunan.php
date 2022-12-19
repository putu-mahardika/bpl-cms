<?php 
  function getBiayaTurunan($koneksi, $id) {
    $array = array();
    $query = "select * from trans_biayaturunan where Id='$id'";
    $result = mysqli_query($koneksi, $query);

    while($row = $result->fetch_assoc()) {
      $array[] = $row;
    }

    return json_encode($array);
  } 

  function createBiayaTurunan($nospk, $turunan, $hdid, $datetime, $s_id, $koneksi) {
    // $cek = true;
    // for ($i=0; $i < $armada; $i++) { 
    //   $query = "insert into trans_biayaturunan values (null, '$nospk', '$i', 0, 0, 0, '$datetime', '$datetime', '$s_id', null, null, null)";
    //   $result = mysqli_query($koneksi, $query);
    //   if(!$result) {
    //     $cek = false;
    //   }
    // }

    // return $cek;

    $query = "insert into trans_biayaturunan values (null, '$hdid', '$nospk', '$turunan', 0, 0, 0, 0, '$datetime', '$datetime', '$s_id', null, null, null)";
    $result = mysqli_query($koneksi, $query);

    return $result;
  }

  function editBiayaTurunan($datetime, $s_id, $koneksi, $request) {
    $total = $request['Biaya_transport']+$request['Biaya_inap']+$request['Biaya_lain'];
    $query = "update trans_biayaturunan set NoSPK='$request[NoSPK]', Biaya_transport='$request[Biaya_transport]', Biaya_inap='$request[Biaya_inap]', Biaya_lain='$request[Biaya_lain]', Total='$total', last_update='$datetime', UserId='$s_id' where Id='$request[Id]'";
    $result = mysqli_query($koneksi, $query);

    return $result;
  }

  function deleteBiayaTurunan($koneksi, $spk, $turunan) {
    $query = "delete from trans_biayaturunan where NoSPK='$spk' and Turunan='$turunan'";
    $result = mysqli_query($koneksi, $query);

    return $result;
  }
?>