<?php
  include '../koneksi.php';
  date_default_timezone_set("Asia/Jakarta");
	$datetime = date('Y-m-d H:i:s');
	$year = date('Y', strtotime($datetime));
  session_save_path('../../tmp');
	session_start();
  //$s_username = $_SESSION['username'];
  $s_id = $_SESSION['id'];
  $s_name = $_SESSION['nama'];
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
  else if (isset($_POST['inputQuoTrucking'])) {
    // print_r($_POST);
    $customerId = null;
    $customerNameTemp = null;
    $customerAddressTemp = null;
    $customerPicTemp = null;
    $customerPicPhoneTemp = null;
    $totalArmada = 0;
    $itemType = null;
    $weight = 0;
    $note = null;
    $tripType = null;
    $selectedTab = null;
    $deliveryType = null;
    $kendaraanId= null;
    $qty = 0;
    $kotaAsalId= null;
    $kotaTujuanId1 = null;
    $kotaTujuanId2 = null;
    $kotaTujuanId3 = null;
    $detailKotaAsal = null;
    $detailKotaTujuan = null;

    if (isset($_POST['customer'])) {
      $customerId = $_POST['customer'];
    } else {
      $customerNameTemp = $_POST['customerNameTemp'];
      $customerAddressTemp = $_POST['customerAddressTemp'];
      $customerPicTemp = $_POST['customerPicTemp'];
      $customerPicPhoneTemp = $_POST['customerPicPhoneTemp'];
    }
    
    $kendaraanId = $_POST['kendaraan'];
    $kotaAsalId = $_POST['kotaAsal'];
    $note = $_POST['keterangan'];
    $weight = $_POST['weight'];
    $itemType = $_POST['itemType'];
    $totalArmada = $_POST['totalArmada'];
    $selectedTab = $_POST['selectedTab'];

    if ($_POST['selectedTab'] == 1) {
      $kotaTujuanId1 = $_POST['kotaTujuan1'];
      $kotaTujuanId2 = $_POST['kotaTujuan2'];
      $kotaTujuanId3 = $_POST['kotaTujuan3'];
      $detailKotaAsal = $_POST['detailKotaAsal1'];
      $detailKotaTujuan = $_POST['detailKotaTujuan1'];
      $tripType = 'multiTrip';
      $query = "INSERT INTO `master_quotation_trucking`
      (`Id`, `NoQuotation`, `IdCustomer`, `IdSales`, `ItemType`, `Weight`, `TotalArmada`, `TripType`, `IdVM`, `IdQuoStatus`, `CustomerNameTemp`, `CustomerAddressTemp`, `PICNameTemp`, `PICPhoneTemp`, `create_date`, `update_at`, `IsActive`, `IsDelete`, `delete_at`, `budgeting_date`, `quoDetailVendorId`, `deliveryTypeName`, `IdKendaraan`, `IdPickupCity`, `PickupNote`, `DestinationNote`, `LastUpdatedById`, `LastUpdatedByName`, `IdDestinationCity1`, `IdDestinationCity2`, `IdDestinationCity3`, `IdDestinationCity4`, `IdDestinationCity5`, `IdDestinationCity6`)
      VALUES
      (NULL, NULL, '$customerId', '$s_id', '$itemType', '$weight', '$totalArmada', '$tripType', NULL, '0', NULL, NULL, NULL, NULL, '2024-09-02 09:37:43.000000', '2024-09-02 09:37:43.000000', '1', '0', NULL, NULL, NULL, NULL, '$kendaraanId', '$kotaAsalId', '$detailKotaAsal', '$detailKotaTujuan', '$s_id', '$s_name', '$kotaTujuanId1', '$kotaTujuanId2', '$kotaTujuanId3', NULL, NULL, NULL);";
      $save = [
        $customerId, //0
        $customerNameTemp, //1
        $customerAddressTemp,  //2
        $customerPicTemp,  //3
        $customerPicPhoneTemp,  //4
        $totalArmada,  //5
        $itemType,  //6
        $weight,  //7
        $note,  //8
        $tripType,  //9
        $kendaraanId, //10
        $qty, //11
        $kotaAsalId,  //12
        $kotaTujuanId1,  //13
        $kotaTujuanId2,  //14
        $kotaTujuanId3,  //15
        $detailKotaAsal,  //16
        $detailKotaTujuan,  //17
        $selectedTab,
        $deliveryType
      ];  
    } elseif ($_POST['selectedTab'] == 2) {
      $kotaTujuanId1 = $_POST['kotaTujuan1'];
      $qty = $_POST['qty'];
      $detailKotaAsal = $_POST['detailKotaAsal2'];
      $detailKotaTujuan = $_POST['detailKotaTujuan2'];
      $tripType = $_POST['tripType'];
      $deliveryType = $_POST['tipePengiriman'];
      $query = "INSERT INTO `master_quotation_trucking`
      (`Id`, `NoQuotation`, `IdCustomer`, `IdSales`, `ItemType`, `Weight`, `TotalArmada`, `TripType`, `IdVM`, `IdQuoStatus`, `CustomerNameTemp`, `CustomerAddressTemp`, `PICNameTemp`, `PICPhoneTemp`, `create_date`, `update_at`, `IsActive`, `IsDelete`, `delete_at`, `budgeting_date`, `quoDetailVendorId`, `deliveryTypeName`, `IdKendaraan`, `IdPickupCity`, `PickupNote`, `DestinationNote`, `LastUpdatedById`, `LastUpdatedByName`, `IdDestinationCity1`, `IdDestinationCity2`, `IdDestinationCity3`, `IdDestinationCity4`, `IdDestinationCity5`, `IdDestinationCity6`)
      VALUES
      (NULL, NULL, '$customerId', '$s_id', '$itemType', '$weight', '$totalArmada', '$tripType', NULL, '0', NULL, NULL, NULL, NULL, '2024-09-02 09:37:43.000000', '2024-09-02 09:37:43.000000', '1', '0', NULL, NULL, NULL, '$deliveryType' '$kendaraanId', '$kotaAsalId', '$detailKotaAsal', '$detailKotaTujuan', '$s_id', '$s_name', '$kotaTujuanId1', NULL, NULL, NULL, NULL, NULL);";
      $save = [
        $customerId,
        $customerNameTemp,
        $customerAddressTemp,
        $customerPicTemp,
        $customerPicPhoneTemp,
        $totalArmada,
        $itemType,
        $weight,
        $note,
        $tripType,
        $kendaraanId,
        $qty,
        $kotaAsalId,
        $kotaTujuanId1,
        $kotaTujuanId2,
        $kotaTujuanId3,
        $detailKotaAsal,
        $detailKotaTujuan,
        $selectedTab,
        $deliveryType
      ];
    } else {
      $kotaTujuanId1 = $_POST['kotaTujuan1'];
      $detailKotaAsal = $_POST['detailKotaAsal0'];
      $detailKotaTujuan = $_POST['detailKotaTujuan0'];
      $tripType = 'singleTrip';
      $query = "INSERT INTO `master_quotation_trucking`
      (`Id`, `NoQuotation`, `IdCustomer`, `IdSales`, `ItemType`, `Weight`, `TotalArmada`, `TripType`, `IdVM`, `IdQuoStatus`, `CustomerNameTemp`, `CustomerAddressTemp`, `PICNameTemp`, `PICPhoneTemp`, `create_date`, `update_at`, `IsActive`, `IsDelete`, `delete_at`, `budgeting_date`, `quoDetailVendorId`, `deliveryTypeName`, `IdKendaraan`, `IdPickupCity`, `PickupNote`, `DestinationNote`, `LastUpdatedById`, `LastUpdatedByName`, `IdDestinationCity1`, `IdDestinationCity2`, `IdDestinationCity3`, `IdDestinationCity4`, `IdDestinationCity5`, `IdDestinationCity6`)
      VALUES
      (NULL, NULL, '$customerId', '$s_id', '$itemType', '$weight', '$totalArmada', '$tripType', NULL, '0', NULL, NULL, NULL, NULL, '2024-09-02 09:37:43.000000', '2024-09-02 09:37:43.000000', '1', '0', NULL, NULL, NULL, NULL, '$kendaraanId', '$kotaAsalId', '$detailKotaAsal', '$detailKotaTujuan', '$s_id', '$s_name', '$kotaTujuanId1', NULL, NULL, NULL, NULL, NULL);";
      $save = [
        $customerId,
        $customerNameTemp,
        $customerAddressTemp,
        $customerPicTemp,
        $customerPicPhoneTemp,
        $totalArmada,
        $itemType,
        $weight,
        $note,
        $tripType,
        $kendaraanId,
        $qty,
        $kotaAsalId,
        $kotaTujuanId1,
        $kotaTujuanId2,
        $kotaTujuanId3,
        $detailKotaAsal,
        $detailKotaTujuan,
        $selectedTab,
        $deliveryType
      ];
    }

    // $save = [
    //   $customerId,
    //   $customerNameTemp,
    //   $customerAddressTemp,
    //   $customerPicTemp,
    //   $customerPicPhoneTemp,
    //   $totalArmada,
    //   $itemType,
    //   $weight,
    //   $note,
    //   $tripType,
    //   $kondaraanId,
    //   $qty,
    //   $kotaAsalId,
    //   $kotaTujuanId1,
    //   $kotaTujuanId2,
    //   $kotaTujuanId3,
    //   $detailKotaAsal,
    //   $detailKotaTujuan
    // ];
    // print_r($save);

    // $query = "INSERT INTO `master_quotation_trucking`
    //   (`Id`, `NoQuotation`, `IdCustomer`, `IdSales`, `ItemType`, `Weight`, `TotalArmada`, `TripType`, `IdVM`, `IdQuoStatus`, `CustomerNameTemp`, `CustomerAddressTemp`, `PICNameTemp`, `PICPhoneTemp`, `create_date`, `update_at`, `IsActive`, `IsDelete`, `delete_at`, `budgeting_date`, `quoDetailVendorId`, `IdKendaraan`, `IdPickupCity`, `PickupNote`, `DestinationNote`, `LastUpdatedById`, `LastUpdatedByName`, `IdDestinationCity1`, `IdDestinationCity2`, `IdDestinationCity3`, `IdDestinationCity4`, `IdDestinationCity5`, `IdDestinationCity6`)
    //   VALUES
    //   (NULL, NULL, '$customerId', '$s_id', '$itemType', '$weight', '$totalArmada', '$tripType', NULL, '0', NULL, NULL, NULL, NULL, '2024-09-02 09:37:43.000000', '2024-09-02 09:37:43.000000', '1', '0', NULL, NULL, NULL, NULL, '$kendaraanId', '$kotaAsalId', '$detailKotaAsal, '$detailKotaTujuan', '$s_id', '$s_name', '$kotaTujuanId1', $kotaTujuanId2, $kotaTujuanId3, NULL, NULL, NULL);";
    // echo $query;
    // $result = mysqli_query($koneksi, $query);
    // echo $result;
    // if ($result) {
    //   header("location:../../view/admin/quotation/trucking/index.php");
    //   $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
    // } else {
      header("location:../../view/admin/quotation/trucking/form/input.php");
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
      $_SESSION['id_pesan1'] = $save;
    // }
  }
?>