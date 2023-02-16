<?php
  include 'koneksi.php';
  date_default_timezone_set("Asia/Jakarta");
	$datetime = date('Y-m-d H:i:s');
  if(isset($_GET['tahun'])) {
    $year = $_GET['tahun'];
  } else {
    $year = date('Y', strtotime($datetime));
  }
  
  if(isset($_GET['bulan'])) {
    $month = $_GET['bulan'];
  } else {
    $month = date('m', strtotime($datetime));
  }
  session_save_path('../tmp');
  session_start();
  //$s_username = $_SESSION['username'];
  $s_id = $_SESSION['id'];
  $akses = $_SESSION['hak_akses'];

  $arrayMonth = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 
    'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ];
  $arrayMonthLength = count($arrayMonth);
  $resArray = array();

  // ========== TRUCKING ===========
  if(isset($_GET['getDataChart1'])) {
    $resArrayDataOpenChart1 = getNewDataOpenChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArrayDataCloseChart1 = getNewDataCloseChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArray = [$resArrayDataOpenChart1, $resArrayDataCloseChart1, $arrayMonth];

  } elseif (isset($_GET['getDataChart2'])) {
    $resArrayDataOpenChart2 = getDataOpenChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArrayDataCloseChart2 = getDataCloseChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArray = [$resArrayDataOpenChart2, $resArrayDataCloseChart2, $arrayMonth];

  } elseif (isset($_GET['getDataChart3'])) {
    $arrayUser = getUser($koneksi);
    $arrayUserLength = count($arrayUser);
    $resArrayDataOpenChart3 = getDataOpenChart3($koneksi, $year, $arrayUser[0], $akses, $s_id);
    $resArrayDataCloseChart3 = getDataCloseChart3($koneksi, $year, $arrayUser[0], $akses, $s_id);
    $resArray = [$resArrayDataOpenChart3, $resArrayDataCloseChart3, $arrayUser[1]];
  
  } elseif (isset($_GET['getAccumulateData'])) {
    $resArraySalesThisYear = getSalesThisYear($koneksi, $year, $akses, $s_id);
    $resArraySalesThisMonth = getSalesThisMonth($koneksi, $year, $month, $akses, $s_id);
    $resArray = [$resArraySalesThisYear, $resArraySalesThisMonth];
  
  } elseif (isset($_GET['getSalesSummary'])) {
    $arrayUser = getUser($koneksi);
    $resArraySalesSummary = getSalesSummary($koneksi, $year, $arrayUser, $akses, $s_id);
    $resArray = $resArraySalesSummary;


  // ========== SHIPMENT ==========
  } elseif (isset($_GET['getShipmentDataChart1'])) {
    $resArrayShipmentDataOpenChart1 = getShipmentDataOpenChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArrayShipmentDataCloseChart1 = getShipmentDataCloseChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArray = [$resArrayShipmentDataOpenChart1, $resArrayShipmentDataCloseChart1, $arrayMonth];

  } elseif (isset($_GET['getShipmentDataChart2'])) {
    $resArrayShipmentDataOpenChart2 = getShipmentDataOpenChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArrayShipmentDataCloseChart2 = getShipmentDataCloseChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArray = [$resArrayShipmentDataOpenChart2, $resArrayShipmentDataCloseChart2, $arrayMonth];

  } elseif (isset($_GET['getShipmentDataChart3'])) {
    $arrayUser = getUser($koneksi);
    $arrayUserLength = count($arrayUser);
    $arrayUserOpenShipment = getUserOpenShipment($koneksi, $year);
    $arrayUserCloseShipment = getUserCloseShipment($koneksi, $year);
    $resArrayShipmentDataOpenChart3 = getShipmentDataOpenChart3($koneksi, $year, $arrayUser[0], $arrayUserOpenShipment, $akses, $s_id);
    $resArrayShipmentDataCloseChart3 = getShipmentDataCloseChart3($koneksi, $year, $arrayUser[0], $arrayUserCloseShipment, $akses, $s_id);
    $resArray = [$resArrayShipmentDataOpenChart3, $resArrayShipmentDataCloseChart3, $arrayUser[1]];

  } elseif (isset($_GET['getAccumulateShipmentData'])) { //done
    $resArrayShipmentSalesThisYear = getShipmentSalesThisYear($koneksi, $year, $akses, $s_id);
    $resArrayShipmentSalesThisMonth = getShipmentSalesThisMonth($koneksi, $year, $month, $akses, $s_id);
    $resArray = [$resArrayShipmentSalesThisYear, $resArrayShipmentSalesThisMonth];

  } elseif (isset($_GET['getShipmentSalesSummary'])) {
    $arrayUser = getUser($koneksi);
    $arrayUserLength = count($arrayUser);
    $arrayUserCloseShipment = getUserCloseShipment($koneksi, $year);
    $resArrayShipmentDataCloseChart3 = getShipmentDataCloseChart3($koneksi, $year, $arrayUser[0], $arrayUserCloseShipment, $akses, $s_id);
    $resArrayCountDataCloseChart3 = getCountShipmentDataCloseChart3($koneksi, $arrayUser[0], $year, $akses);
    $resArrayShipmentSalesSummary = combineShipmentDataClose($arrayUser, $resArrayShipmentDataCloseChart3, $resArrayCountDataCloseChart3);
    $resArray = $resArrayShipmentSalesSummary;
  

  // ========== ALL ==========
  // } elseif (isset($_GET['getAllDataChart1'])) {

  } elseif (isset($_GET['getAllDataChart2'])) {
    $resArrayDataOpenChart2 = getDataOpenChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArrayDataCloseChart2 = getDataCloseChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id);

    $resArrayShipmentDataOpenChart2 = getShipmentDataOpenChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArrayShipmentDataCloseChart2 = getShipmentDataCloseChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id);

    $resArrayAllDataOpenChart2 = sumDataChart($resArrayDataOpenChart2, $resArrayShipmentDataOpenChart2);
    $resArrayAllDataCloseChart2 = sumDataChart($resArrayDataCloseChart2, $resArrayShipmentDataCloseChart2);
    
    $resArray = [$resArrayAllDataOpenChart2, $resArrayAllDataCloseChart2, $arrayMonth];

  } elseif (isset($_GET['getAllDataChart3'])) {
    $arrayUser = getUser($koneksi);
    $arrayUserLength = count($arrayUser);
    $resArrayDataOpenChart3 = getDataOpenChart3($koneksi, $year, $arrayUser[0], $akses, $s_id);
    $resArrayDataCloseChart3 = getDataCloseChart3($koneksi, $year, $arrayUser[0], $akses, $s_id);

    $arrayUserOpenShipment = getUserOpenShipment($koneksi, $year);
    $arrayUserCloseShipment = getUserCloseShipment($koneksi, $year);
    $resArrayShipmentDataOpenChart3 = getShipmentDataOpenChart3($koneksi, $year, $arrayUser[0], $arrayUserOpenShipment, $akses, $s_id);
    $resArrayShipmentDataCloseChart3 = getShipmentDataCloseChart3($koneksi, $year, $arrayUser[0], $arrayUserCloseShipment, $akses, $s_id);

    $resArrayAllDataOpenChart3 = sumDataChart($resArrayDataOpenChart3, $resArrayShipmentDataOpenChart3);
    $resArrayAllDataCloseChart3 = sumDataChart($resArrayDataCloseChart3, $resArrayShipmentDataCloseChart3);

    $resArray = [$resArrayAllDataOpenChart3, $resArrayAllDataCloseChart3, $arrayUser[1]];
  }

  echo json_encode($resArray);





  

  function combineShipmentDataClose($arrUser, $arrDataBiaya, $arrCount) {
    $totalUser = count($arrUser[0]);
    $arrUsername = $arrUser[1];
    $array = array();

    for ($i=0; $i < $totalUser; $i++) { 
      $array[$i] = [
        'Nama' => $arrUsername[$i],
        'Total' => $arrDataBiaya[$i],
        'Count' => $arrCount[$i]
      ];
    }

    return $array;
  }

  function getCountShipmentDataCloseChart3($koneksi, $arrayUserId, $year, $akses) {
    $arrayUserLength = count($arrayUserId);
    $array = array();
    $arrayTemp = array();
    if ($akses == "Admin") {
      $query = "select
        ts.UserId,
        count(*) as total
      from 
        trans_shipment ts,
        master_user mu 
      where 
        ts.UserId=mu.UserId and 
        mu.atr1=0 and
        ts.`close`=1 and 
        year(ts.close_date)='".$year."'
      group by 
        ts.UserId";
      $fetch = mysqli_query($koneksi, $query);
      while($row = $fetch->fetch_assoc()) {
        $arrayTemp[] = $row;
      }

      for ($i=0; $i < $arrayUserLength; $i++) { 
        $array[$i] = 0;
        foreach ($arrayTemp as $data) {
          if($data['UserId'] == $arrayUserId[$i]) {
            $array[$i] += (double)$data['total'];
          }
        }
      }
    }

    return $array;
  }

  function sumDataChart($truckingData, $shipmentData) {
    $data = array();
    for ($i=0; $i < count($truckingData); $i++) { 
      $data[$i] = (float)$truckingData[$i]+(float)$shipmentData[$i];
    }

    return $data;
  }

  function getUser($koneksi) {
    $array = array();
    $arrayId = array();
    $arrayNama = array();
    $tempArray = array();
    $query = "select UserId, nama from master_user where atr1=0";
    // $query = "select UserId, nama from master_user";
    $fetch = mysqli_query($koneksi, $query);
    // echo $fetch;
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    foreach ($tempArray as $data) {
      $arrayId[] = $data['UserId'];
      $arrayNama[] = $data['nama'];
    }

    $array = [$arrayId, $arrayNama];

    return $array;
  }

  function getUserOpenShipment($koneksi, $year) {
    $arrayId = array();
    $arrayUserId = array();
    $tempArray = array();
    $array = array();
    $query = "SELECT
      ts.UserId,
      ts.id 
    from
      trans_shipment ts
    where 
      ts.is_delete = 0 and 
      ts.`close` = 0 and 
      year(ts.create_order) = '".$year."'
    order by
      ts.UserId ";

    $fetch = mysqli_query($koneksi, $query);
    // echo $fetch;
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    // foreach ($tempArray as $data) {
    //   $array[]['id'] = $data['id'];
    //   $array[]['UserId'] = $data['UserId'];
    // }

    // $array = [$arrayId, $arrayUserId];

    return $tempArray;

  }

  function getUserCloseShipment($koneksi, $year) {
    $array = array();
    $query = "SELECT
      ts.UserId,
      ts.id 
    from
      trans_shipment ts
    where 
      ts.is_delete = 0 and 
      ts.`close` = 1 and 
      year(ts.create_order) = '".$year."'
    order by
      ts.UserId ";

    $fetch = mysqli_query($koneksi, $query);
    // echo $fetch;
    while($row = $fetch->fetch_assoc()) {
      $array[] = $row;
    }

    return $array;

  }

  function getDataOpenChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select month(a.create_date) as month, count(*) as total from trans_hd a, master_user b where a.OnClose=0 and a.atr1=0 and a.UserId=b.UserId and b.atr1=0 AND year(a.create_date)='".$year."' group by month(a.create_date)";
    } else {
      $query = "select month(create_date) as month, count(*) as total from trans_hd where OnClose=0 and atr1=0 AND year(create_date)='".$year."' AND UserId='".$s_id."' group by month(create_date)";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i+1) {
          $array[$i] = $data['total'];
        }
      }
    }

    return $array;

  }

  function getDataCloseChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select month(a.DateOnClose) as month, count(*) as total from trans_hd a, master_user b where a.OnClose=1 and a.atr1=0 and a.UserId=b.UserId and b.atr1=0 AND year(a.DateOnClose)='".$year."' group by month(a.DateOnClose)";
    } else {
      $query = "select month(DateOnClose) as month, count(*) as total from trans_hd where OnClose=1 and atr1=0 AND year(DateOnClose)='".$year."' AND UserId='".$s_id."' group by month(DateOnClose)";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i+1) {
          $array[$i] = $data['total'];
        }
      }
    }

    return $array;
  }

  function getNewDataOpenChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == 'Admin') {
      $query = "select 
        month(a.tgl_spk) as month
      from 
        trans_hd a,
        master_user b,
        trans_detail c
      where
        a.HdId=c.HdId and
        a.OnClose=0 and
        a.atr1=0 and
        a.UserId=b.UserId and
        b.atr1=0 and
        year(a.tgl_spk)='".$year."'
      group by 
        month(a.tgl_spk),
        a.NoSPK,
        c.turunan ";
    } else {
      $query = "select 
        month(a.tgl_spk) as month
      from 
        trans_hd a,
        master_user b,
        trans_detail c
      where
        a.HdId=c.HdId and
        a.OnClose=0 and
        a.atr1=0 and
        a.UserId=b.UserId and
        b.atr1=0 and
        year(a.tgl_spk)='".$year."' and
        a.UserId='".$s_id."'
      group by 
        month(a.tgl_spk),
        a.NoSPK,
        c.turunan ";
    }

    $fetch = mysqli_query($koneksi, $query);
    // $data = mysqli_fetch_array($fetch);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row['month'];
    }

    $datas = array_count_values($tempArray);

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($datas as $key=>$data) {
        if($key == $i+1) {
          $array[$i] = $data;
        }
      }
    }

    return $array;
  }

  function getNewDataCloseChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == 'Admin') {
      $query = "select 
        month(a.tgl_spk) as month
      from 
        trans_hd a,
        master_user b,
        trans_detail c
      where
        a.HdId=c.HdId and
        a.OnClose=1 and
        a.atr1=0 and
        a.UserId=b.UserId and
        b.atr1=0 and
        year(a.tgl_spk)='".$year."'
      group by 
        month(a.tgl_spk),
        a.NoSPK,
        c.turunan ";
    } else {
      $query = "select 
        month(a.tgl_spk) as month
      from 
        trans_hd a,
        master_user b,
        trans_detail c
      where
        a.HdId=c.HdId and
        a.OnClose=1 and
        a.atr1=0 and
        a.UserId=b.UserId and
        b.atr1=0 and
        year(a.tgl_spk)='".$year."' and
        a.UserId='".$s_id."'
      group by 
        month(a.tgl_spk),
        a.NoSPK,
        c.turunan ";
    }

    $fetch = mysqli_query($koneksi, $query);
    // $data = mysqli_fetch_array($fetch);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row['month'];
    }

    $datas = array_count_values($tempArray);

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($datas as $key=>$data) {
        if($key == $i+1) {
          $array[$i] = $data;
        }
      }
    }

    return $array;
  }

  function getDataOpenChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b, master_user c WHERE b.UserId=c.UserId and c.atr1=0 and a.HdId=b.HdId AND b.OnClose=0 and b.atr1=0 AND year(a.create_date)='".$year."' GROUP BY month(a.create_date)";
    } else {
      $query = "select month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=0 and b.atr1=0 AND year(a.create_date)='".$year."' AND b.UserId='".$s_id."' GROUP BY month(a.create_date)";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i+1) {
          $array[$i] = $data['total'];
        }
      }
    }

    return $array;
  }

  function getDataCloseChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select month(b.tgl_spk) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b, master_user c WHERE b.UserId=c.UserId and c.atr1=0 and a.HdId=b.HdId AND b.OnClose=1 and b.atr1=0 AND year(b.tgl_spk)='".$year."' GROUP BY month(b.tgl_spk)";
    } else {
      $query = "select month(b.tgl_spk) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=1 and b.atr1=0 AND year(b.tgl_spk)='".$year."' AND b.UserId='".$s_id."' GROUP BY month(b.tgl_spk)";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i+1) {
          $array[$i] = $data['total'];
        }
      }
    }

    return $array;
  }

  function getDataOpenChart3($koneksi, $year, $arrayUserId, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    $arrayUserLength = count($arrayUserId);
    if ($akses == "Admin") {
      $query = "SELECT 
      b.HdId,
      b.UserId,
      case when b.HdId not in (select HdId from trans_biayaturunan) then '0' else e.Total end as totalBiaya
    FROM
      trans_hd b,
      trans_biayaturunan e
    WHERE
      b.atr1=0 and
      e.HdId = b.HdId and
      b.OnClose=0 and year(b.create_date)='".$year."'";
    } else {
      $query = "SELECT 
      b.HdId,
      b.UserId,
      case when b.HdId not in (select HdId from trans_biayaturunan) then '0' else e.Total end as totalBiaya
    FROM
      trans_hd b,
      trans_biayaturunan e
    WHERE
      b.atr1=0 and
      e.HdId = b.HdId and
      b.OnClose=0 and 
      b.UserId='".$s_id."' and 
      year(b.create_date)='".$year."'";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayUserLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['UserId'] == $arrayUserId[$i]) {
          $array[$i] += (double)$data['totalBiaya'];
        }
      }
    }

    return $array;
  }

  function getDataCloseChart3($koneksi, $year, $arrayUserId, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    $arrayUserLength = count($arrayUserId);
    if ($akses == "Admin") {
      $query = "SELECT 
      b.HdId,
      b.UserId,
      case when b.HdId not in (select HdId from trans_biayaturunan) then '0' else e.Total end as totalBiaya
    FROM
      trans_hd b,
      trans_biayaturunan e
    WHERE
      b.atr1=0 and
      e.HdId = b.HdId and
      b.OnClose=1 and year(b.tgl_spk)='".$year."'";
    } else {
      $query = "SELECT 
      b.HdId,
      b.UserId,
      case when b.HdId not in (select HdId from trans_biayaturunan) then '0' else e.Total end as totalBiaya
    FROM
      trans_hd b,
      trans_biayaturunan e
    WHERE
      b.atr1=0 and
      e.HdId = b.HdId and
      b.OnClose=1 and year(b.tgl_spk)='".$year."' and
      a.UserId='".$s_id."'";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayUserLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['UserId'] == $arrayUserId[$i]) {
          $array[$i] += (double)$data['totalBiaya'];
        }
      }
    }

    return $array;
  }

  function getSalesThisYear($koneksi, $year, $akses, $s_id) {
    if ($akses == "Admin") {
      $query = "SELECT
        SUM(a.Total) AS Total
      FROM 
        trans_biayaturunan a,
        trans_hd b,
        master_user c
      WHERE 
        a.atr1 IS NULL AND
        a.HdId = b.HdId AND
        b.UserId = c.UserId AND
        c.atr1 = 0 AND
        b.atr1 = 0 and
        b.OnClose=1 AND
        YEAR(b.tgl_spk)='".$year."'";

      // $queryGetTotalArmada = "SELECT 
      //   sum(a.total_armada) as total
      // FROM 
      //   trans_hd a,
      //   master_user b
      // where 
      //   a.UserId = b.UserId and
      //   a.OnClose=1 and
      //   b.atr1=0 and
      //   YEAR(a.tgl_spk)='".$year."'"." AND
      //   a.atr1=0";

      $queryGetTotalArmada = "SELECT 
         a.HdId,
         c.DtlId,
         c.NoSPK,
         c.turunan
        FROM 
          trans_hd a,
          master_user b,
          trans_detail c
        where 
          a.HdId = c.HdId and
          a.UserId = b.UserId and
          b.atr1=0 and
          a.OnClose=1 and
          -- YEAR(a.tgl_spk)='2023' AND
          YEAR(a.tgl_spk)='".$year."'"." AND
          a.atr1=0
      GROUP BY c.NoSPK, c.turunan 
      order by c.DtlId desc";

    } else {
      $query = "SELECT
        SUM(a.Total) AS Total
      FROM 
        trans_biayaturunan a,
        trans_hd b
      WHERE 
        a.atr1 IS NULL AND
        a.HdId = b.HdId AND
        b.OnClose=1 AND
        b.UserId='".$s_id."'"." AND
        YEAR(b.tgl_spk)='".$year."'"; 

      // $queryGetTotalArmada = "SELECT 
      //   sum(total_armada) as total
      // FROM 
      //   trans_hd
      // where 
      //   UserId='".$s_id."'"." AND
      //   YEAR(tgl_spk)='".$year."'"." AND
      //   atr1=0";

        $queryGetTotalArmada = "SELECT 
         a.HdId,
         c.DtlId
         c.NoSPK,
         c.turunan,
        FROM 
          trans_hd a,
          master_user b,
          trans_detail c
        where 
          a.HdId = c.HdId and
          a.UserId = b.UserId and
          b.atr1=0 and
          a.OnClose=1 and
          -- YEAR(a.tgl_spk)='2023' AND
          a.UserId='".$s_id."'"." AND
          YEAR(a.tgl_spk)='".$year."'"." AND
          a.atr1=0
      GROUP BY c.NoSPK, c.turunan 
      order by c.DtlId desc";
    }
    $fetch = mysqli_query($koneksi, $query);
    $dataTotalBiaya = mysqli_fetch_array($fetch);
    
    $fetchTotalArmada = mysqli_query($koneksi, $queryGetTotalArmada);
    // $dataTotalArmada = mysqli_fetch_array($fetchTotalArmada);
    
    $tempArray = array();
    while($row = $fetchTotalArmada->fetch_assoc()) {
      $tempArray[] = $row;
    }

    $data = ["Total" => $dataTotalBiaya['Total'], "totalDetail" => count($tempArray)];

    return $data;
  }

  function getSalesThisMonth($koneksi, $year, $month, $akses, $s_id) {
    if ($akses == "Admin") {
      $query = "SELECT
        SUM(a.Total) AS Total
      FROM 
        trans_biayaturunan a,
        trans_hd b,
        master_user c
      WHERE 
        b.UserId = c.UserId and
        c.atr1=0 and
        a.atr1 IS NULL AND
        a.HdId = b.HdId AND
        b.OnClose=1 AND
        b.atr1=0 and
        YEAR(b.tgl_spk)='".$year."'"." AND
        MONTH(b.tgl_spk)='".$month."'";
      
      // $queryGetTotalArmada = "SELECT 
      //   sum(total_armada) as total
      // FROM 
      //   trans_hd
      // where 
      //   atr1=0 and
      //   YEAR(tgl_spk)='".$year."'"." AND
      //   MONTH(tgl_spk)='".$month."'";

      $queryGetTotalArmada = "SELECT 
        a.HdId,
        c.DtlId
        c.NoSPK,
        c.turunan,
      FROM 
        trans_hd a,
        master_user b,
        trans_detail c
      where 
        a.atr1=0 and
        a.HdId = c.HdId and
        a.UserId = b.UserId and
        b.atr1=0 and
        a.OnClose=1 and
        -- YEAR(a.tgl_spk)='2023' AND
        -- month(a.tgl_spk)='01' AND
        YEAR(a.tgl_spk)='".$year."'"." AND
        MONTH(a.tgl_spk)='".$month."'"." AND
        a.atr1=0
      GROUP BY c.NoSPK, c.turunan 
      order by c.DtlId desc";

    } else {
      $query = "SELECT
        SUM(a.Total) AS Total
      FROM 
        trans_biayaturunan a,
        trans_hd b
      WHERE 
        b.atr1=0 and
        a.atr1 IS NULL AND
        a.HdId = b.HdId AND
        b.OnClose=1 AND
        b.UserId='".$s_id."'"."AND
        YEAR(b.tgl_spk)='".$year."'"."AND
        MONTH(b.tgl_spk)='".$month."'"; 

      // $queryGetTotalArmada = "SELECT 
      //   sum(total_armada) as total
      // FROM 
      //   trans_hd
      // where 
      //   UserId='".$s_id."'"." AND
      //   atr1=0 and
      //   YEAR(tgl_spk)='".$year."'"." AND
      //   MONTH(tgl_spk)='".$month."'";

      $queryGetTotalArmada = "SELECT 
        a.HdId,
        c.DtlId
        c.NoSPK,
        c.turunan,
      FROM 
        trans_hd a,
        master_user b,
        trans_detail c
      where 
        a.atr1=0 and
        a.UserId='".$s_id."'"." AND
        a.HdId = c.HdId and
        a.UserId = b.UserId and
        b.atr1=0 and
        a.OnClose=1 and
        -- YEAR(a.tgl_spk)='2023' AND
        YEAR(a.tgl_spk)='".$year."'"." AND
        MONTH(a.tgl_spk)='".$month."'"." AND
        a.atr1=0
      GROUP BY c.NoSPK, c.turunan 
      order by c.DtlId desc";
    }

    $fetch = mysqli_query($koneksi, $query);
    $dataTotalBiaya = mysqli_fetch_array($fetch);
    
    $fetchTotalArmada = mysqli_query($koneksi, $queryGetTotalArmada);
    // $dataTotalArmada = mysqli_fetch_array($fetchTotalArmada);

    $tempArray = array();
    while($row = $fetchTotalArmada->fetch_assoc()) {
      $tempArray[] = $row;
    }

    $data = ["Total" => $dataTotalBiaya['Total'], "totalDetail" => count($tempArray)];
    return $data;
  }

  function getSalesSummary($koneksi, $year, $arrayUser, $akses, $s_id) {
    $arrayUserLength = count($arrayUser[0]);
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "SELECT 
        SUM(a.Total) as Total,
        COUNT(a.Id) as Jumlah,
        c.UserId
      FROM
        trans_biayaturunan a,
        trans_hd c 
      WHERE 
        c.atr1=0 and
        -- a.UserId = c.UserId AND 
        a.HdId = c.HdId AND
        c.OnClose = 1 AND
        a.atr1 IS NULL AND 
        -- c.UserId = 17 AND
        YEAR(c.tgl_spk) = '$year'
      GROUP BY 
        c.UserId";
    } else {
      $query = "SELECT 
        SUM(a.Total) as Total,
        COUNT(a.Id) as Jumlah,
        c.UserId
      FROM
        trans_biayaturunan a,
        trans_hd c 
      WHERE 
        -- a.UserId = c.UserId AND 
        a.HdId = c.HdId AND
        c.OnClose = 1 AND
        a.atr1 IS NULL AND 
        c.UserId = '".$s_id."'"."AND
        YEAR(c.tgl_spk) = '$year'
      GROUP BY 
        c.UserId";
    }

    $fetch = mysqli_query($koneksi, $query);
    // $datas = mysqli_fetch_assoc($fetch);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayUserLength; $i++) { 
      $array[$i]['Nama'] = '';
      $array[$i]['Total'] = 0;
      $array[$i]['Rit'] = 0;
      foreach ($tempArray as $data) {
        if($data['UserId'] == $arrayUser[0][$i]) {
          $array[$i]['Total'] = (double)$data['Total'];
          $array[$i]['Rit'] = (double)$data['Jumlah'];
        }
      }
      $array[$i]['Nama'] = $arrayUser[1][$i];
    }

    return $array;
  }






  // =============== AREA SHIPMENT ===================

  function getShipmentDataOpenChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select month(a.create_order) as month, count(*) as total from trans_shipment a, master_user b where a.is_delete=0 and a.close=0 and a.UserId=b.UserId and b.atr1=0 and year(a.create_order)='".$year."' group by month(a.create_order)";
    } else {
      $query = "select month(create_order) as month, count(*) as total from trans_shipment where is_delete=0 and close=0 and year(create_order)='".$year."' AND UserId='".$s_id."' group by month(create_order)";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i+1) {
          $array[$i] = $data['total'];
        }
      }
    }
    return $array;
  }

  function getShipmentDataCloseChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select month(a.create_order) as month, count(*) as total from trans_shipment a, master_user b where a.UserId=b.UserId and b.atr1=0 and a.is_delete=0 and a.close=1 and year(a.create_order)='".$year."' group by month(a.create_order)";
    } else {
      $query = "select month(create_order) as month, count(*) as total from trans_shipment where is_delete=0 and close=1 and year(create_order)='".$year."' AND UserId='".$s_id."' group by month(create_order)";
    }

    $fetch = mysqli_query($koneksi, $query);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i+1) {
          $array[$i] = $data['total'];
        }
      }
    }
    return $array;
  }

  function getShipmentDataOpenChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    $tempHandlingArray = array();
    if ($akses == "Admin") {
      $queryGetTotalShipment = "SELECT 
        month(ts.create_order) as month,
        sum(ts.total_freight) as freight
      from
        trans_shipment ts,
        master_user mu
      where 
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.is_delete=0 and 
        ts.`close`=0 and  
        year(ts.create_order)='".$year."'
      group by
        month(ts.create_order)";

      $queryGetTotalHandling = "SELECT
        month(ts.create_order) as month,
        sum(tsh.nominal) as nominal 
      from
        trans_shipment ts,
        trans_shipment_handling tsh,
        master_user mu
      where 
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.id = tsh.id_shipment and 
        ts.is_delete=0 and 
        ts.`close`=0 and  
        year(ts.create_order)='".$year."'
      group by 
        month(ts.create_order)";

    } else {
      $queryGetTotalShipment = "SELECT 
        month(create_order) as month,
        sum(ts.total_freight) as freight
      from
        trans_shipment ts
      where 
        ts.is_delete=0 and 
        ts.`close`=0 and  
        ts.UserId = '".$s_id."'"."AND  
        year(ts.create_order)='".$year."'
      group by
        month(create_order)";

      $queryGetTotalHandling = "SELECT
        month(ts.create_order) as month,
        sum(tsh.nominal) as nominal 
      from
        trans_shipment ts,
        trans_shipment_handling tsh 
      where 
        ts.id = tsh.id_shipment and 
        ts.is_delete=0 and 
        ts.`close`=0 and  
        ts.UserId = '".$s_id."'"."AND  
        year(ts.create_order)='".$year."'
      group by 
          month(ts.create_order)";
      
    }

    $fetch = mysqli_query($koneksi, $queryGetTotalShipment);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    $fetch = mysqli_query($koneksi, $queryGetTotalHandling);
    while($row = $fetch->fetch_assoc()) {
      $tempHandlingArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i+1) {
          $array[$i] = (float)$data['freight'];
        }
      }
      foreach ($tempHandlingArray as $data) {
        if($data['month'] == $i+1) {
          $array[$i] += (float)$data['nominal'];
        }
      }
    }

    return $array;
  }

  function getShipmentDataCloseChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    $tempHandlingArray = array();
    if ($akses == "Admin") {
      $queryGetTotalShipment = "SELECT 
        month(create_order) as month,
        sum(ts.total_freight) as freight
      from
        trans_shipment ts,
        master_user mu
      where 
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.is_delete=0 and 
        ts.`close`=1 and  
        year(ts.create_order)='".$year."'
      group by
        month(create_order)";

      $queryGetTotalHandling = "SELECT
        month(ts.create_order) as month,
        sum(tsh.nominal) as nominal 
      from
        trans_shipment ts,
        trans_shipment_handling tsh,
        master_user mu
      where 
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.id = tsh.id_shipment and 
        ts.is_delete=0 and 
        ts.`close`=1 and  
        year(ts.create_order)='".$year."'
      group by 
        month(ts.create_order)";

    } else {
      $queryGetTotalShipment = "SELECT 
        month(create_order) as month,
        sum(ts.total_freight) as freight
      from
        trans_shipment ts
      where 
        ts.is_delete=0 and 
        ts.`close`=0 and  
        ts.UserId = '".$s_id."'"."AND  
        year(ts.create_order)='".$year."'
      group by
        month(create_order)";

      $queryGetTotalHandling = "SELECT
        month(ts.create_order) as month,
        sum(tsh.nominal) as nominal 
      from
        trans_shipment ts,
        trans_shipment_handling tsh 
      where 
        ts.id = tsh.id_shipment and 
        ts.is_delete=0 and 
        ts.`close`=0 and  
        ts.UserId = '".$s_id."'"."AND  
        year(ts.create_order)='".$year."'
      group by 
          month(ts.create_order)";
      
    }

    $fetch = mysqli_query($koneksi, $queryGetTotalShipment);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    $fetch = mysqli_query($koneksi, $queryGetTotalHandling);
    while($row = $fetch->fetch_assoc()) {
      $tempHandlingArray[] = $row;
    }

    for ($i=0; $i < $arrayMonthLength; $i++) { 
      $array[$i] = 0;
      foreach ($tempArray as $data) {
        if($data['month'] == $i+1) {
          $array[$i] = (float)$data['freight'];
        }
      }
      foreach ($tempHandlingArray as $data) {
        if($data['month'] == $i+1) {
          $array[$i] += (float)$data['nominal'];
        }
      }
    }

    return $array;
  }

  function getShipmentDataOpenChart3($koneksi, $year, $arrayUserId, $arrayUserShipment, $akses, $s_id) {
    $array = array();
    $tempArrayFreight = array();
    $tempArrayHandling = array();

    $arrayUserLength = count($arrayUserId);
    if ($akses == "Admin") {
      $queryTotalFreight = "SELECT
        ts.id,
        ts.total_freight 
      from 
        trans_shipment ts,
        master_user mu
      where 
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.is_delete = 0 and 
        ts.`close` = 0 and 
        year(ts.create_order) = '".$year."'";

      $queryTotalHandling = "SELECT
        ts.id,
        sum(tsh.nominal) as nominal
      from 
        trans_shipment ts, 
        trans_shipment_handling tsh,
        master_user mu
      where 
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.id = tsh.id_shipment and 
        ts.is_delete = 0 and 
        ts.`close` = 0 and 
        year(ts.create_order) = '".$year."'
      group by 
        ts.id";
    }

    $fetch = mysqli_query($koneksi, $queryTotalFreight);
    while($row = $fetch->fetch_assoc()) {
      $tempArrayFreight[] = $row;
    }

    $fetch = mysqli_query($koneksi, $queryTotalHandling);
    while($row = $fetch->fetch_assoc()) {
      $tempArrayHandling[] = $row;
    }

    // return $arrayUserId;
    for ($i=0; $i < $arrayUserLength; $i++) { 
      $array[$i] = 0;
      foreach($arrayUserShipment as $userShipment) {
        if($userShipment['UserId'] == $arrayUserId[$i]) {
          foreach($tempArrayFreight as $arrayFreight) {
            if($arrayFreight['id'] == $userShipment['id']) {
              $array[$i] += (double)$arrayFreight['total_freight'];
            }
          }

          foreach($tempArrayHandling as $arrayHandling) {
            if($arrayHandling['id'] == $userShipment['id']) {
              $array[$i] += (double)$arrayHandling['nominal'];
            }
          }
        }
      }
    }

    return $array;
  }

  function getShipmentDataCloseChart3($koneksi, $year, $arrayUserId, $arrayUserShipment, $akses, $s_id) {
    $array = array();
    $tempArrayFreight = array();
    $tempArrayHandling = array();

    $arrayUserLength = count($arrayUserId);
    if ($akses == "Admin") {
      $queryTotalFreight = "SELECT
        ts.id,
        ts.total_freight 
      from 
        trans_shipment ts,
        master_user mu
      where 
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.is_delete = 0 and 
        ts.`close` = 1 and 
        year(ts.create_order) = '".$year."'";

      $queryTotalHandling = "SELECT
        ts.id,
        sum(tsh.nominal) as nominal
      from 
        trans_shipment ts, 
        trans_shipment_handling tsh,
        master_user mu
      where 
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.id = tsh.id_shipment and 
        ts.is_delete = 0 and 
        ts.`close` = 1 and 
        year(ts.create_order) = '".$year."'
      group by 
        ts.id";
    }

    $fetch = mysqli_query($koneksi, $queryTotalFreight);
    while($row = $fetch->fetch_assoc()) {
      $tempArrayFreight[] = $row;
    }

    $fetch = mysqli_query($koneksi, $queryTotalHandling);
    while($row = $fetch->fetch_assoc()) {
      $tempArrayHandling[] = $row;
    }

    for ($i=0; $i < $arrayUserLength; $i++) { 
      $array[$i] = 0;
      // return $arrayUserShipment;
      foreach($arrayUserShipment as $userShipment) {
        // return $userShipment['id'];
        if($userShipment['UserId'] == $arrayUserId[$i]) {
          foreach($tempArrayFreight as $arrayFreight) {
            if($arrayFreight['id'] == $userShipment['id']) {
              $array[$i] += (double)$arrayFreight['total_freight'];
            }
          }

          foreach($tempArrayHandling as $arrayHandling) {
            if($arrayHandling['id'] == $userShipment['id']) {
              $array[$i] += (double)$arrayHandling['nominal'];
            }
          }
        }
      }
    }

    return $array;
  }

  function getShipmentSalesThisYear($koneksi, $year, $akses, $s_id) {
    if ($akses == "Admin") {
      $queryShipment = "SELECT 
        SUM(ts.total_freight) as total,
        COUNT(*) as count
      FROM
        trans_shipment ts,
        master_user mu
      WHERE
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.is_delete=0 AND
        ts.`close`=1 AND
        YEAR(ts.close_date)='".$year."'";

      $queryHandling = "SELECT
        SUM(nominal) as total
      FROM
        trans_shipment ts,
        trans_shipment_handling tsh,
        master_user mu
      WHERE
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.id=tsh.id_shipment AND
        ts.is_delete=0 AND
        ts.close=1 AND
        YEAR(close_date)='".$year."'";
    } else {
      $queryShipment = "SELECT 
        SUM(total_freight) as total,
        COUNT(*) as count
      FROM
        trans_shipment
      WHERE
        is_delete=0 AND
        `close`=1 AND
        UserId = '".$s_id."'"." AND
        YEAR(close_date)='".$year."'";
        
      $queryHandling = "SELECT
        SUM(nominal) as total
      FROM
        trans_shipment ts,
        trans_shipment_handling tsh
      WHERE
        ts.id=tsh.id_shipment AND
        ts.is_delete=0 AND
        ts.close=1 AND
        ts.UserId = '".$s_id."'"." AND
        YEAR(close_date)='".$year."'"; 
    }

    $fetchShipment = mysqli_query($koneksi, $queryShipment);
    $dataShipment = mysqli_fetch_array($fetchShipment);

    $fetchHandling = mysqli_query($koneksi, $queryHandling);
    $dataHandling = mysqli_fetch_array($fetchHandling);

    $totalShipment = is_null($dataShipment['total']) ? 0 : (float)$dataShipment['total'];
    $totalHandling = is_null($dataHandling['total']) ? 0 : (float)$dataHandling['total'];

    $grandTotal = $totalShipment + $totalHandling;

    $data = [$grandTotal, $dataShipment['count']];

    return $data;
  }

  function getShipmentSalesThisMonth($koneksi, $year, $month, $akses, $s_id) {
    if ($akses == "Admin") {
      $queryShipment = "SELECT 
        SUM(ts.total_freight) as total,
        COUNT(*) as count
      FROM
        trans_shipment ts,
        master_user mu
      WHERE
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.is_delete=0 AND
        `close`=1 AND
        YEAR(ts.close_date)='".$year."'"." AND
        MONTH(ts.close_date)='".$month."'"; 

      $queryHandling = "SELECT
        SUM(tsh.nominal) as total
      FROM
        trans_shipment ts,
        trans_shipment_handling tsh,
        master_user mu
      WHERE
        ts.UserId=mu.UserId and
        mu.atr1=0 and
        ts.id=tsh.id_shipment AND
        ts.is_delete=0 AND
        ts.close=1 AND
        YEAR(ts.close_date)='".$year."'"." AND
        MONTH(ts.close_date)='".$month."'"; 
    } else {
      $queryShipment = "SELECT 
        SUM(total_freight) as total,
        COUNT(*) as count
      FROM
        trans_shipment
      WHERE
        is_delete=0 AND
        `close`=1 AND
        UserId = '".$s_id."'"." AND
        YEAR(close_date)='".$year."'"."AND
        MONTH(close_date)='".$month."'"; 
        
      $queryHandling = "SELECT
        SUM(tsh.nominal) as total
      FROM
        trans_shipment ts,
        trans_shipment_handling tsh
      WHERE
        ts.id=tsh.id AND
        ts.is_delete=0 AND
        ts.close=1 AND
        ts.UserId = '".$s_id."'"." AND
        YEAR(ts.close_date)='".$year."'"."AND
        MONTH(ts.close_date)='".$month."'"; 
    }

    $fetchShipment = mysqli_query($koneksi, $queryShipment);
    $dataShipment = mysqli_fetch_array($fetchShipment);

    $fetchHandling = mysqli_query($koneksi, $queryHandling);
    $dataHandling = mysqli_fetch_array($fetchHandling);

    $totalShipment = is_null($dataShipment['total']) ? 0 : (float)$dataShipment['total'];
    $totalHandling = is_null($dataHandling['total']) ? 0 : (float)$dataHandling['total'];

    $grandTotal = $totalShipment + $totalHandling;

    $data = [$grandTotal, $dataShipment['count']];

    return $data;
  }

  function getShipmentSalesSummary($koneksi, $year, $arrayUser, $akses, $s_id) {
    $arrayUserLength = count($arrayUser[0]);
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "SELECT 
        SUM(a.Total) as Total,
        COUNT(a.Id) as Jumlah,
        c.UserId
      FROM
        trans_biayaturunan a,
        trans_hd c 
      WHERE 
        -- a.UserId = c.UserId AND 
        a.HdId = c.HdId AND
        c.OnClose = 1 AND
        a.atr1 IS NULL AND 
        -- c.UserId = 17 AND
        YEAR(c.DateOnClose) = '2023'
      GROUP BY 
        c.UserId";
    } else {
      $query = "SELECT 
        SUM(a.Total) as Total,
        COUNT(a.Id) as Jumlah,
        c.UserId
      FROM
        trans_biayaturunan a,
        trans_hd c 
      WHERE 
        -- a.UserId = c.UserId AND 
        a.HdId = c.HdId AND
        c.OnClose = 1 AND
        a.atr1 IS NULL AND 
        c.UserId = '".$s_id."'"."AND
        YEAR(c.DateOnClose) = '$year'
      GROUP BY 
        c.UserId";
    }

    $fetch = mysqli_query($koneksi, $query);
    // $datas = mysqli_fetch_assoc($fetch);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }

    for ($i=0; $i < $arrayUserLength; $i++) { 
      $array[$i]['Nama'] = '';
      $array[$i]['Total'] = 0;
      $array[$i]['Rit'] = 0;
      foreach ($tempArray as $data) {
        if($data['UserId'] == $arrayUser[0][$i]) {
          $array[$i]['Total'] = (double)$data['Total'];
          $array[$i]['Rit'] = (double)$data['Jumlah'];
        }
      }
      $array[$i]['Nama'] = $arrayUser[1][$i];
    }

    return $array;
  }
?>