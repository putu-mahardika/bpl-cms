<?php
    include 'koneksi.php';

    $query = "select OnClose from trans_detail where DtlId in (select max(DtlId) from trans_detail where NoSPK='8898907971' and turunan='2')";
    $fetch = mysqli_query($koneksi, $query);
    while($data = mysqli_fetch_array($fetch)){
        echo $data['OnClose'];
    }
?>