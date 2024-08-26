<?php
  include '../koneksi.php';
  date_default_timezone_set("Asia/Jakarta");
	$datetime = date('Y-m-d H:i:s');
	$year = date('Y', strtotime($datetime));
  session_save_path('../../tmp');
	session_start();
  //$s_username = $_SESSION['username'];
  $s_id = $_SESSION['id'];
  $akses = $_SESSION['hak_akses'];

  if (isset($_GET['getAllQuo'])) {
    $array = array();
    $tempArray = array();
    $query = "SELECT
        mqt.*,
        mc.nama AS CustomerName,
        mu.nama AS SalesName,
        mu1.nama AS VmName,
        mk.Nama AS VehicleName, 
        CASE 
          WHEN mqt.quoDetailVendorId IS NULL THEN mqt.PICNameTemp ELSE mc.PIC
        END AS Pic,
        CASE 
          WHEN mqt.quoDetailVendorId IS NULL THEN mqt.PICPhoneTemp ELSE mc.PIC_telp
        END AS PicPhone,
        CASE 
          WHEN mqt.quoDetailVendorId IS NULL THEN NULL ELSE qdt.CostingFirstPrice + qdt.CostingNextPrice
        END AS TotalCosting,
        CASE 
          WHEN mqt.quoDetailVendorId IS NULL THEN NULL ELSE qdt.BudgetingFirstPrice + qdt.BudgetingNextPrice
        END AS TotalBudgeting,
        CASE 
          WHEN mqt.quoDetailVendorId IS NULL THEN NULL ELSE qdt.PricingFirstPrice + qdt.PricingNextPrice
        END AS TotalPricing,
        CASE 
          WHEN mqt.quoDetailVendorId IS NULL THEN NULL ELSE mv.nama
        END AS VendorName,
        mqst.name AS StatusName
    FROM
      master_quotation_trucking mqt
        LEFT JOIN quotation_detail_trucking qdt on mqt.quoDetailVendorId = qdt.Id
        LEFT JOIN master_vendor mv on qdt.IdVendor = mv.Id
        LEFT JOIN master_quo_status mqst on mqt.IdQuoStatus = mqst.Id
        LEFT JOIN master_customer mc on mqt.IdCustomer = mc.CustId
        LEFT JOIN master_user mu on mqt.IdSales = mu.UserId
        LEFT JOIN master_user mu1 on mqt.IdVM = mu1.UserId
        LEFT JOIN master_kendaraan mk on mqt.IdKendaraan = mk.Id
    WHERE
      mqt.IsDelete = 0;";
    $fetch = mysqli_query($koneksi, $query);
    // $datas = mysqli_fetch_array($fetch);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }
    foreach ($tempArray as $i=>$data) {
      $array[$i]['noQuotation'] = $data['NoQuotation'];
      $array[$i]['createDate'] = $data['create_date'];
      $array[$i]['po'] = null;
      $array[$i]['customer'] = $data['CustomerName'];
      $array[$i]['pic'] = $data['Pic'];
      $array[$i]['picPhone'] = $data['PicPhone'];
      $array[$i]['salesName'] = $data['SalesName'];
      $array[$i]['itemType'] = $data['ItemType'];
      $array[$i]['weight'] = $data['Weight'];
      $array[$i]['totalArmada'] = $data['TotalArmada'];
      $array[$i]['vendorName'] = $data['VendorName'];
      $array[$i]['totalCosting'] = $data['TotalCosting'];
      $array[$i]['totalBudgeting'] = $data['TotalBudgeting'];
      $array[$i]['totalPricing'] = $data['TotalPricing'];
      $array[$i]['tripType'] = $data['TripType'];
      $array[$i]['budgetingDate'] = $data['budgeting_date'];
      $array[$i]['vmName'] = $data['VmName'];
      $array[$i]['status'] = $data['StatusName'];
      $array[$i]['id'] = $data['Id'];
      // print_r($data);
    }

    // for ($i=0; $i < $arrayUserLength; $i++) { 
    //   $array[$i]['Nama'] = '';
    //   $array[$i]['Total'] = 0;
    //   $array[$i]['Rit'] = 0;
    //   foreach ($tempArray as $data) {
    //     if($data['UserId'] == $arrayUser[0][$i]) {
    //       $array[$i]['Total'] = (double)$data['Total'];
    //       $array[$i]['Rit'] = (double)$data['Jumlah'];
    //     }
    //   }
    //   $array[$i]['Nama'] = $arrayUser[1][$i];
    // }
    // echo $datas[1];
    // print_r($array);
    echo json_encode($array);
  }
?>