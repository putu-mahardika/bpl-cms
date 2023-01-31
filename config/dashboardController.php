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

  if(isset($_GET['getDataChart1'])) {
    $resArrayDataOpenChart1 = getDataOpenChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id);
    $resArrayDataCloseChart1 = getDataCloseChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id);
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
    $resArrayShipmentDataOpenChart3 = getShipmentDataOpenChart3($koneksi, $year, $arrayUser[0], $akses, $s_id);
    $resArrayShipmentDataCloseChart3 = getShipmentDataCloseChart3($koneksi, $year, $arrayUser[0], $akses, $s_id);
    $resArray = [$resArrayShipmentDataOpenChart3, $resArrayShipmentDataCloseChart3, $arrayUser[1]];

  } elseif (isset($_GET['getAccumulateShipmentData'])) { //done
    $resArrayShipmentSalesThisYear = getShipmentSalesThisYear($koneksi, $year, $akses, $s_id);
    $resArrayShipmentSalesThisMonth = getShipmentSalesThisMonth($koneksi, $year, $month, $akses, $s_id);
    $resArray = [$resArrayShipmentSalesThisYear, $resArrayShipmentSalesThisMonth];

  } elseif (isset($_GET['getShipmentSalesSummary'])) {
    $arrayUser = getUser($koneksi);
    $resArrayShipmentSalesSummary = getShipmentSalesSummary($koneksi, $year, $arrayUser, $akses, $s_id);
    $resArray = $resArrayShipmentSalesSummary;
  }

  echo json_encode($resArray);












  function getUser($koneksi) {
    $array = array();
    $arrayId = array();
    $arrayNama = array();
    $tempArray = array();
    $query = "select UserId, nama from master_user where atr1=0";
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

  function getDataOpenChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select month(create_date) as month, count(*) as total from trans_hd where OnClose=0 and atr1=0 AND year(create_date)='".$year."' group by month(create_date)";
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
      $query = "select month(create_date) as month, count(*) as total from trans_hd where OnClose=1 and atr1=0 AND year(create_date)='".$year."' group by month(create_date)";
    } else {
      $query = "select month(create_date) as month, count(*) as total from trans_hd where OnClose=1 and atr1=0 AND year(create_date)='".$year."' AND UserId='".$s_id."' group by month(create_date)";
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

  function getDataOpenChart2($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=0 and b.atr1=0 AND year(a.create_date)='".$year."' GROUP BY month(a.create_date)";
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
      $query = "select month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=1 and b.atr1=0 AND year(a.create_date)='".$year."' GROUP BY month(a.create_date)";
    } else {
      $query = "select month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=1 and b.atr1=0 AND year(a.create_date)='".$year."' AND b.UserId='".$s_id."' GROUP BY month(a.create_date)";
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
      b.OnClose=1 and year(b.DateOnClose)='".$year."'";
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
      b.OnClose=1 and year(b.DateOnClose)='".$year."' and
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
        SUM(a.Total) AS Total,
        COUNT(a.Id) AS Id,
        SUM(b.total_armada) AS totalDetail
      FROM 
        trans_biayaturunan a,
        trans_hd b
      WHERE 
        a.atr1 IS NULL AND
        a.HdId = b.HdId AND
        b.OnClose=1 AND
        YEAR(b.DateOnClose)='".$year."'";
    } else {
      $query = "SELECT
        SUM(a.Total) AS Total,
        COUNT(a.Id) AS Id,
        SUM(b.total_armada) AS totalDetail
      FROM 
        trans_biayaturunan a,
        trans_hd b
      WHERE 
        a.atr1 IS NULL AND
        a.HdId = b.HdId AND
        b.OnClose=1 AND
        b.UserId='".$s_id."'"."AND
        YEAR(b.DateOnClose)='".$year."'"; 
    }

    $fetch = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($fetch);

    return $data;
  }

  function getSalesThisMonth($koneksi, $year, $month, $akses, $s_id) {
    if ($akses == "Admin") {
      $query = "SELECT
        SUM(a.Total) AS Total,
        COUNT(a.Id) AS Id,
        SUM(b.total_armada) AS totalDetail
      FROM 
        trans_biayaturunan a,
        trans_hd b
      WHERE 
        a.atr1 IS NULL AND
        a.HdId = b.HdId AND
        b.OnClose=1 AND
        YEAR(b.DateOnClose)='".$year."'"."AND
        MONTH(b.DateOnClose)='".$month."'";
    } else {
      $query = "SELECT
        SUM(a.Total) AS Total,
        COUNT(a.Id) AS Id,
        SUM(b.total_armada) AS totalDetail
      FROM 
        trans_biayaturunan a,
        trans_hd b
      WHERE 
        a.atr1 IS NULL AND
        a.HdId = b.HdId AND
        b.OnClose=1 AND
        b.UserId='".$s_id."'"."AND
        YEAR(b.DateOnClose)='".$year."'"."AND
        MONTH(b.DateOnClose)='".$month."'"; 
    }

    $fetch = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($fetch);

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






  // =============== AREA SHIPMENT ===================

  function getShipmentDataOpenChart1($koneksi, $year, $arrayMonthLength, $akses, $s_id) {
    $array = array();
    $tempArray = array();
    if ($akses == "Admin") {
      $query = "select month(create_order) as month, count(*) as total from trans_shipment where is_delete=0 and close=0 and year(create_order)='".$year."' group by month(create_order)";
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
      $query = "select month(create_order) as month, count(*) as total from trans_shipment where is_delete=0 and close=1 and year(create_order)='".$year."' group by month(create_order)";
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
    if ($akses == "Admin") {
      // $query = "select month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      // trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=0 and b.atr1=0 AND year(a.create_date)='".$year."' GROUP BY month(a.create_date)";
      $queryShipment = "SELECT 
        ts.UserId,
        month(create_order) as month,
        sum(ts.total_freight) as freight
      from
        trans_shipment ts
      where 
        ts.is_delete=0 and 
        ts.`close`=0 and  
        year(ts.create_order)='".$year."'
      group by 
        ts.UserId,
        month(create_order)";

    } else {
      // $query = "select month(a.create_date) as month, SUM(a.Total) as total FROM trans_biayaturunan a, 
      // trans_hd b WHERE a.HdId=b.HdId AND b.OnClose=0 and b.atr1=0 AND year(a.create_date)='".$year."' AND b.UserId='".$s_id."' GROUP BY month(a.create_date)";
      $queryShipment = "SELECT 
        ts.UserId,
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
        ts.UserId,
        month(create_order)";
    }

    $fetch = mysqli_query($koneksi, $queryShipment);
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

  function getShipmentSalesThisYear($koneksi, $year, $akses, $s_id) {
    if ($akses == "Admin") {
      $queryShipment = "SELECT 
        SUM(total_freight) as total,
        COUNT(*) as count
      FROM
        trans_shipment
      WHERE
        is_delete=0 AND
        close=1 AND
        YEAR(close_date)='".$year."'";

      $queryHandling = "SELECT
        SUM(nominal) as total
      FROM
        trans_shipment ts,
        trans_shipment_handling tsh
      WHERE
        ts.id=tsh.id AND
        ts.is_delete=0 AND
        ts.close=1 AND
        YEAR(close_date)='".$year."'";
    } else {
      $queryShipment = "SELECT 
        SUM(total_freight) as total
      FROM
        trans_shipment
      WHERE
        is_delete=0 AND
        close=1 AND
        UserId = '".$s_id."'"." AND
        YEAR(close_date)='".$year."'";
        
      $queryHandling = "SELECT
        SUM(nominal) as total
      FROM
        trans_shipment ts,
        trans_shipment_handling tsh
      WHERE
        ts.id=tsh.id AND
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
        SUM(total_freight) as total,
        COUNT(*) as count
      FROM
        trans_shipment
      WHERE
        is_delete=0 AND
        close=1 AND
        YEAR(b.DateOnClose)='".$year."'"."AND
        MONTH(b.DateOnClose)='".$month."'"; 

      $queryHandling = "SELECT
        SUM(nominal) as total
      FROM
        trans_shipment ts,
        trans_shipment_handling tsh
      WHERE
        ts.id=tsh.id AND
        ts.is_delete=0 AND
        ts.close=1 AND
        YEAR(b.DateOnClose)='".$year."'"."AND
        MONTH(b.DateOnClose)='".$month."'"; 
    } else {
      $queryShipment = "SELECT 
        SUM(total_freight) as total
      FROM
        trans_shipment
      WHERE
        is_delete=0 AND
        close=1 AND
        UserId = '".$s_id."'"." AND
        YEAR(b.DateOnClose)='".$year."'"."AND
        MONTH(b.DateOnClose)='".$month."'"; 
        
      $queryHandling = "SELECT
        SUM(nominal) as total
      FROM
        trans_shipment ts,
        trans_shipment_handling tsh
      WHERE
        ts.id=tsh.id AND
        ts.is_delete=0 AND
        ts.close=1 AND
        ts.UserId = '".$s_id."'"." AND
        YEAR(b.DateOnClose)='".$year."'"."AND
        MONTH(b.DateOnClose)='".$month."'"; 
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