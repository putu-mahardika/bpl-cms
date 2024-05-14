<?php
  include '../../config/koneksi.php';

  $array = array();
  $query = 'select * from master_user order by create_date desc';
  $result = mysqli_query($koneksi, $query);

  while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $array[] = $row;
  }
  mysqli_close($koneksi);
  echo json_encode($array);
?>