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
    $tahun = $_GET['year'];
    $array = array();
    $tempArray = array();
    $query = "SELECT
        mqt.*,
        mu.nama AS SalesName,
        mu1.nama AS VmName,
        mk.Nama AS VehicleName, 
        CASE
          WHEN mqt.IdCustomer IS NULL OR mqt.IdCustomer = '0' THEN mqt.CustomerNameTemp ELSE mc.nama
        END AS CustomerName,
        CASE 
          WHEN mqt.IdCustomer IS NULL OR mqt.IdCustomer = '0' THEN mqt.PICNameTemp ELSE mc.PIC
        END AS Pic,
        CASE 
          WHEN mqt.IdCustomer IS NULL OR mqt.IdCustomer = '0' THEN mqt.PICPhoneTemp ELSE mc.PIC_telp
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
        mqst.name AS StatusName,
        mqst.color AS StatusColor
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
      mqt.IsDelete = 0 and
      mqt.create_date between '".$tahun."-01-01 00:00:00' and '".$tahun."-12-31 23:59:59'
    ORDER BY 
      mqt.update_at desc";
    $fetch = mysqli_query($koneksi, $query);
    // $datas = mysqli_fetch_array($fetch);
    while($row = $fetch->fetch_assoc()) {
      $tempArray[] = $row;
    }
    foreach ($tempArray as $i=>$data) {
      $array[$i]['noQuotation'] = $data['NoQuotation'];
      $array[$i]['createDate'] = $data['create_date'];
      $array[$i]['lastUpdate'] = $data['update_at'];
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
      $array[$i]['statusColor'] = $data['StatusColor'];
      $array[$i]['hasShipmentQuo'] = $data['hd_shipment_quotation_id'] ? true : false;
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
    print_r($_POST);
    $customerId = null;
    $customerNameTemp = null;
    $customerAddressTemp = null;
    $customerPicTemp = null;
    $customerPicPhoneTemp = null;
    $customerPaymentTermsTemp = null;
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
      $customerPaymentTermsTemp = $_POST['customerPaymentTermsTemp'];
    }
    
    $kendaraanId = isset($_POST['kendaraan']) && $_POST['kendaraan'] !== '' ? printf("'".$_POST['kendaraan']."'") : 'null';
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
      (`Id`, `NoQuotation`, `IdCustomer`, `IdSales`, `ItemType`, `Weight`, `note`, `qty`, `TotalArmada`, `TripType`, `IdVM`, `IdQuoStatus`, `CustomerNameTemp`, `CustomerAddressTemp`, `PICNameTemp`, `PICPhoneTemp`, `CustomerTermsPaymentTemp`, `create_date`, `update_at`, `IsActive`, `IsDelete`, `delete_at`, `budgeting_date`, `quoDetailVendorId`, `deliveryTypeName`, `IdKendaraan`, `IdPickupCity`, `PickupNote`, `DestinationNote`, `LastUpdatedById`, `LastUpdatedByName`, `IdDestinationCity1`, `IdDestinationCity2`, `IdDestinationCity3`, `IdDestinationCity4`, `IdDestinationCity5`, `IdDestinationCity6`)
      VALUES
      (NULL, NULL, '$customerId', '$s_id', '$itemType', '$weight', '$note', '$qty', '$totalArmada', '$tripType', NULL, '1', '$customerNameTemp', '$customerAddressTemp', '$customerPicTemp', '$customerPicPhoneTemp', '$customerPaymentTermsTemp', '$datetime', '$datetime', '1', '0', NULL, NULL, NULL, NULL, $kendaraanId, '$kotaAsalId', '$detailKotaAsal', '$detailKotaTujuan', '$s_id', '$s_name', '$kotaTujuanId1', '$kotaTujuanId2', '$kotaTujuanId3', NULL, NULL, NULL);";
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
        $selectedTab, //18
        $deliveryType,  //19
        $customerPaymentTermsTemp //20
      ];  
    } elseif ($_POST['selectedTab'] == 2) {
      $kotaTujuanId1 = $_POST['kotaTujuan1'];
      $qty = $_POST['qty'];
      $detailKotaAsal = $_POST['detailKotaAsal2'];
      $detailKotaTujuan = $_POST['detailKotaTujuan2'];
      $tripType = $_POST['deliveryType'];
      $deliveryType = $_POST['deliveryType'];
      $query = "INSERT INTO `master_quotation_trucking`
      (`Id`, `NoQuotation`, `IdCustomer`, `IdSales`, `ItemType`, `Weight`, `note`, `qty`, `TotalArmada`, `TripType`, `IdVM`, `IdQuoStatus`, `CustomerNameTemp`, `CustomerAddressTemp`, `PICNameTemp`, `PICPhoneTemp`, `create_date`, `update_at`, `IsActive`, `IsDelete`, `delete_at`, `budgeting_date`, `quoDetailVendorId`, `deliveryTypeName`, `IdKendaraan`, `IdPickupCity`, `PickupNote`, `DestinationNote`, `LastUpdatedById`, `LastUpdatedByName`, `IdDestinationCity1`, `IdDestinationCity2`, `IdDestinationCity3`, `IdDestinationCity4`, `IdDestinationCity5`, `IdDestinationCity6`)
      VALUES
      (NULL, NULL, '$customerId', '$s_id', '$itemType', '$weight', '$note', '$qty', '$totalArmada', '$tripType', NULL, '1', '$customerNameTemp', '$customerAddressTemp', '$customerPicTemp', '$customerPicPhoneTemp', '$datetime', '$datetime', '1', '0', NULL, NULL, NULL, '$deliveryType', $kendaraanId, '$kotaAsalId', '$detailKotaAsal', '$detailKotaTujuan', '$s_id', '$s_name', '$kotaTujuanId1', NULL, NULL, NULL, NULL, NULL);";
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
        $deliveryType,
        $customerPaymentTermsTemp
      ];
    } else {
      $kotaTujuanId1 = $_POST['kotaTujuan1'];
      $detailKotaAsal = $_POST['detailKotaAsal0'];
      $detailKotaTujuan = $_POST['detailKotaTujuan0'];
      $tripType = 'singleTrip';
      $query = "INSERT INTO `master_quotation_trucking`
      (`Id`, `NoQuotation`, `IdCustomer`, `IdSales`, `ItemType`, `Weight`, `note`, `qty`, `TotalArmada`, `TripType`, `IdVM`, `IdQuoStatus`, `CustomerNameTemp`, `CustomerAddressTemp`, `PICNameTemp`, `PICPhoneTemp`, `create_date`, `update_at`, `IsActive`, `IsDelete`, `delete_at`, `budgeting_date`, `quoDetailVendorId`, `deliveryTypeName`, `IdKendaraan`, `IdPickupCity`, `PickupNote`, `DestinationNote`, `LastUpdatedById`, `LastUpdatedByName`, `IdDestinationCity1`, `IdDestinationCity2`, `IdDestinationCity3`, `IdDestinationCity4`, `IdDestinationCity5`, `IdDestinationCity6`)
      VALUES
      (NULL, NULL, '$customerId', '$s_id', '$itemType', '$weight', '$note', '$qty', '$totalArmada', '$tripType', NULL, '1', '$customerNameTemp', '$customerAddressTemp', '$customerPicTemp', '$customerPicPhoneTemp', '$datetime', '$datetime', '1', '0', NULL, NULL, NULL, NULL, $kendaraanId, '$kotaAsalId', '$detailKotaAsal', '$detailKotaTujuan', '$s_id', '$s_name', '$kotaTujuanId1', NULL, NULL, NULL, NULL, NULL);";
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
        $deliveryType,
        $customerPaymentTermsTemp
      ];
    }
    // print_r($save);
    echo $query;
    $result = mysqli_query($koneksi, $query);
    // echo $result;
    if ($result) {
      $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';		
      if ($akses == 'User') {
        header("location:../../view/user/quotation/trucking/index.php?tahun=$year");
      } elseif ($akses == 'Admin') {
        header("location:../../view/admin/quotation/trucking/index.php?tahun=$year");
      } else {
        header("location:../../view/vm/quotation/trucking/index.php?tahun=$year");	
      }
    } else {
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal ditambahkan !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';			
      $_SESSION['id_pesan1'] = $save;
      if ($akses == 'User') {
        header("location:../../view/user/quotation/trucking/form/input.php");
      } elseif ($akses == 'Admin') {
        header("location:../../view/admin/quotation/trucking/form/input.php");
      } else {
        header("location:../../view/vm/quotation/trucking/form/input.php");
      }
    }
  }

  elseif (isset($_POST['editQuoTruckingAdmin'])) {
    // print_r($_POST);
    $customerId = isset($_POST['customer']) ? $_POST['customer'] : 'null';
    $customerNameTemp = isset($_POST['customerTempName']) && $_POST['customerTempName'] !== '' ? "'" . $_POST['customerTempName'] . "'" : 'null';
    $customerAddressTemp = isset($_POST['customerAddressTemp']) && $_POST['customerAddressTemp'] !== '' ? "'" . $_POST['customerAddressTemp'] . "'" : 'null';
    $customerPicTemp = isset($_POST['customerPicTemp']) && $_POST['customerPicTemp'] !== '' ? "'" . $_POST['customerPicTemp'] . "'" : 'null';
    $customerPicPhoneTemp = isset($_POST['customerPicPhoneTemp']) && $_POST['customerPicPhoneTemp'] !== '' ? "'".$_POST['customerPicPhoneTemp']."'" : 'null';
    $customerPaymentTermsTemp = isset($_POST['customerPaymentTermsTemp']) && $_POST['customerPaymentTermsTemp'] !== '' ? "'".$_POST['customerPaymentTermsTemp']."'" : 'null';
    $totalArmada = isset($_POST['totalArmada']) ? $_POST['totalArmada'] : 0;
    $itemType = isset($_POST['itemType']) ? "'" . $_POST['itemType'] . "'" : 'null';
    $weight = isset($_POST['weight']) ? $_POST['weight'] : 0;
    $note = isset($_POST['keterangan']) ? "'".$_POST['keterangan']."'" : 'null';
    $tripType = 'null';
    $selectedTab = isset($_POST['selectedTab']) ? $_POST['selectedTab'] : 0;
    $deliveryType = 'null';
    $kendaraanId= isset($_POST['kendaraan']) ? $_POST['kendaraan'] : 'null';
    $qty = isset($_POST['qty']) ? $_POST['qty'] : 0;
    $kotaAsalId = isset($_POST['kotaAsal']) ? $_POST['kotaAsal'] : 'null';
    $kotaTujuanId1 = isset($_POST['kotaTujuan1']) ? $_POST['kotaTujuan1'] : 'null';
    $kotaTujuanId2 = isset($_POST['kotaTujuan2']) && $_POST['kotaTujuan2'] !== "" ? $_POST['kotaTujuan2'] : 'null';
    $kotaTujuanId3 = isset($_POST['kotaTujuan3']) && $_POST['kotaTujuan3'] !== "" ? $_POST['kotaTujuan3'] : 'null';
    $detailKotaAsal = isset($_POST['detailKotaAsal0']) ? "'".$_POST['detailKotaAsal0']."'" : 'null';
    $detailKotaTujuan = isset($_POST['detailKotaTujuan0']) ? "'".$_POST['detailKotaTujuan0']."'" : 'null';
    $vendor = isset($_POST['vendor']) ? $_POST['vendor'] : [];
    $idDetailQuo = isset($_POST['idDetailQuo']) ? $_POST['idDetailQuo'] : [];
    $costingFirst = isset($_POST['costingFirst']) ? $_POST['costingFirst'] : [];
    $costingNext = isset($_POST['costingNext']) ? $_POST['costingNext'] : [];
    $costingTotal = isset($_POST['costingTotal']) ? $_POST['costingTotal'] : [];
    $budgetingFirst = isset($_POST['budgetingFirst']) ? $_POST['budgetingFirst'] : [];
    $budgetingNext = isset($_POST['budgetingNext']) ? $_POST['budgetingNext'] : [];
    $budgetingTotal = isset($_POST['budgetingTotal']) ? $_POST['budgetingTotal'] : [];
    $pricingFirst = isset($_POST['pricingFirst']) ? $_POST['pricingFirst'] : [];
    $pricingNext = isset($_POST['pricingNext']) ? $_POST['pricingNext'] : [];
    $pricingTotal = isset($_POST['pricingTotal']) ? $_POST['pricingTotal'] : [];
    $counter = isset($_POST['counterTableVendor']) ? $_POST['counterTableVendor'] : 0;
    $quoId = isset($_POST['quoTruckingId']) ? $_POST['quoTruckingId'] : 'null';
    $statusId = isset($_POST['statusId']) ? $_POST['statusId'] : 'null';
    $vmId = isset($_POST['vmIdOld']) ? $_POST['vmIdOld'] : 'null';
    $selectedVendor = isset($_POST['checkboxVendor']) ? $_POST['checkboxVendor'] : 'null';

    $note = str_replace(["\r\n", "\n", "\r"],"%%", $note);
    $detailKotaAsal = str_replace(["\r\n", "\n", "\r"],"%%", $detailKotaAsal);
    $detailKotaTujuan = str_replace(["\r\n", "\n", "\r"],"%%", $detailKotaTujuan);


    if ($selectedTab == 1) {
      $tripType = 'multiTrip';
    } elseif ($selectedTab == 2) {
      $tripType = $_POST['deliveryType'];
      $deliveryType = $_POST['deliveryType'];
    } else {
      $tripType = 'singleTrip';
    }

    // print_r($_POST['checkboxVendor']);
    try {
      if ($selectedTab == 1) {
        $query = "UPDATE master_quotation_trucking SET
          IdCustomer=$customerId,
          CustomerNameTemp=$customerNameTemp,
          CustomerAddressTemp=$customerAddressTemp,
          PICNameTemp=$customerPicTemp,
          PICPhoneTemp=$customerPicPhoneTemp,
          CustomerTermsPaymentTemp='$customerPaymentTermsTemp',
          TotalArmada='$totalArmada',
          ItemType=$itemType,
          Weight='$weight',
          note=$note,
          IdKendaraan=$kendaraanId,
          IdPickupCity=$kotaAsalId,
          PickupNote=$detailKotaAsal,
          DestinationNote=$detailKotaTujuan,
          IdDestinationCity1=$kotaTujuanId1,
          IdDestinationCity2=$kotaTujuanId2,
          IdDestinationCity3=$kotaTujuanId3,
          LastUpdatedById='$s_id',
          LastUpdatedByName='$s_name',
          deliveryTypeName=NULL,
          update_at='$datetime',
          quoDetailVendorId='$selectedVendor',
          WHERE Id=$quoId
        ";
      } elseif ($selectedTab == 2) {
        $query = "UPDATE master_quotation_trucking SET
          IdCustomer=$customerId,
          CustomerNameTemp=$customerNameTemp,
          CustomerAddressTemp=$customerAddressTemp,
          PICNameTemp=$customerPicTemp,
          PICPhoneTemp=$customerPicPhoneTemp,
          CustomerTermsPaymentTemp='$customerPaymentTermsTemp',
          TotalArmada='$totalArmada',
          ItemType=$itemType,
          Weight='$weight',
          note=$note,
          IdKendaraan=NULL,
          IdPickupCity=$kotaAsalId,
          PickupNote=$detailKotaAsal,
          DestinationNote=$detailKotaTujuan,
          IdDestinationCity1=$kotaTujuanId1,
          IdDestinationCity2=NULL,
          IdDestinationCity3=NULL,
          LastUpdatedById='$s_id',
          LastUpdatedByName='$s_name',
          deliveryTypeName='$deliveryType',
          update_at='$datetime',
          quoDetailVendorId=$selectedVendor
          WHERE Id=$quoId
        ";
      } else {
        $query = "UPDATE master_quotation_trucking SET
          IdCustomer=$customerId,
          CustomerNameTemp=$customerNameTemp,
          CustomerAddressTemp=$customerAddressTemp,
          PICNameTemp=$customerPicTemp,
          PICPhoneTemp=$customerPicPhoneTemp,
          CustomerTermsPaymentTemp='$customerPaymentTermsTemp',
          TotalArmada='$totalArmada',
          ItemType=$itemType,
          Weight='$weight',
          note=$note,
          IdKendaraan=$kendaraanId,
          IdPickupCity=$kotaAsalId,
          PickupNote=$detailKotaAsal,
          DestinationNote=$detailKotaTujuan,
          IdDestinationCity1=$kotaTujuanId1,
          IdDestinationCity2=NULL,
          IdDestinationCity3=NULL,
          LastUpdatedById='$s_id',
          LastUpdatedByName='$s_name',
          deliveryTypeName=NULL,
          update_at='$datetime',
          quoDetailVendorId=$selectedVendor
          WHERE Id=$quoId
        ";
      }

      // echo $query;
      $result = mysqli_query($koneksi, $query);
      if ($result) {
        // header("location:../../view/admin/quotation/trucking/index.php");
        if ($statusId == 1) {
          $statusId = insertDetailQuo($vendor, $costingFirst, $costingNext, $costingTotal, $quoId, $s_id, $koneksi);
          $vmId = $s_id;
          $queryd = "UPDATE master_quotation_trucking SET IdVM='$vmId', IdQuoStatus='$statusId', CostingDate='$datetime' WHERE Id=$quoId";
          mysqli_query($koneksi, $queryd);
        } elseif ($selectedVendor != 'null') {
          $statusId = 10;
          $queryd = "UPDATE master_quotation_trucking SET IdVM='$vmId', IdQuoStatus='$statusId' WHERE Id=$quoId";
          mysqli_query($koneksi, $queryd);
        } else {
          $statusId = updateDetailQuo($vendor, $statusId, $idDetailQuo, $costingFirst, $costingNext, $costingTotal, $budgetingFirst, $budgetingNext, $budgetingTotal, $pricingFirst, $pricingNext, $pricingTotal, $quoId, $s_id, $koneksi);
          $queryd = "UPDATE master_quotation_trucking SET IdVM='$vmId', IdQuoStatus='$statusId' WHERE Id=$quoId";
          mysqli_query($koneksi, $queryd);
          if ($budgetingTotal > 0) {
            $queryd = "UPDATE master_quotation_trucking SET budgeting_date='$datetime' WHERE Id=$quoId AND budgeting_date IS NULL OR budgeting_date=''";
            mysqli_query($koneksi, $queryd);
          }
        }
        // insertDetailQuo($vendor, $costingFirst, $costingNext, $costingTotal, $quoId, $s_id, $koneksi);

        $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        if ($akses == 'User') {
          header("location:../../view/user/quotation/trucking/form/edit.php?id=$quoId");
        } elseif ($akses == 'Admin') {
          header("location:../../view/admin/quotation/trucking/form/edit.php?id=$quoId");
        } else {
          header("location:../../view/vm/quotation/trucking/form/edit.php?id=$quoId");
        }
      } else {
        $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';				
        if ($akses == 'User') {
          header("location:../../view/user/quotation/trucking/form/edit.php?id=$quoId");
        } elseif ($akses == 'Admin') {
          header("location:../../view/admin/quotation/trucking/form/edit.php?id=$quoId");
        } else {
          header("location:../../view/vm/quotation/trucking/form/edit.php?id=$quoId");
        }
      }
    } catch (\Throwable $th) {
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
      if ($akses == 'User') {
        header("location:../../view/user/quotation/trucking/form/edit.php?id=$quoId");
      } elseif ($akses == 'Admin') {
        header("location:../../view/admin/quotation/trucking/form/edit.php?id=$quoId");
      } else {
        header("location:../../view/vm/quotation/trucking/form/edit.php?id=$quoId");
      }
    }

  }


  elseif (isset($_POST['generateTrucking'])) {
    $customerCode = $_POST['customerCode'];
    $customerQuery = "SELECT CustId FROM master_customer WHERE kode_customer='$customerCode' LIMIT 1";
    $fetchCustomer = mysqli_query($koneksi, $customerQuery);
    $dataCustomer = mysqli_fetch_assoc($fetchCustomer);
    $customerId = $dataCustomer['CustId'];

    $poNumber = $_POST['poNumber'];
    $poDate = $_POST['poDate'];
    $spkNumber = $_POST['spkNumber'];
    $spkDate = $_POST['spkDate'];
    $totalArmada = $_POST['totalArmada'];
    $originCity = $_POST['originCity'];
    $destinationCity = $_POST['destinationCity'];
    $originCityDesc = $_POST['originCityDesc'];
    $destinationCityDesc = $_POST['destinationCityDesc'];
    $item = $_POST['item'];
    $idQuo = $_POST['idQuo'];

    $tglpo0 = str_replace('/', '-', $poDate);
    $tglspk0 = str_replace('/', '-', $spkDate);
    $tglpo1 = date('Y-m-d', strtotime($tglpo0));
    $tglspk1 = date('Y-m-d', strtotime($tglspk0));

    $query = "INSERT INTO trans_hd (`CustId`, `UserId`, `NoPO`, `tgl_po`, `NoSPK`, `tgl_spk`, `total_armada`, `kota_kirim_id`, `kota_kirim`, `kota_tujuan_id`, `kota_tujuan`, `Barang`, `OnClose`, `create_date`, `last_update`, `IdQuotation`)
    VALUES ('$customerId', '$s_id', '$poNumber', '$tglpo1', '$spkNumber', '$tglspk1', '$totalArmada', '$originCity', '$originCityDesc', '$destinationCity', '$destinationCityDesc', '$item', 0, '$datetime', '$datetime', '$idQuo')";

    echo $query;
    $result = mysqli_query($koneksi, $query);
    if ($result) {
      $queryQuo = "UPDATE master_quotation_trucking SET IdQuoStatus=14 WHERE Id='$idQuo'";
      $resultQuo = mysqli_query($koneksi, $queryQuo);
      if ($resultQuo) {
        $_SESSION['pesan'] = '<p><div class="alert alert-success">Data berhasil diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';
        if ($akses == 'User') {
          header("location:../../view/user/quotation/trucking/form/edit.php?id=$idQuo");
        } else {
          header("location:../../view/admin/quotation/trucking/form/edit.php?id=$idQuo");
        }
      }
    } else {
      $_SESSION['pesan'] = '<p><div class="alert alert-warning">Data gagal diubah !<a class="close" data-dismiss="alert" href="#">x</a></div></p>';	
      if ($akses == 'User') {
        header("location:../../view/admin/quotation/trucking/form/edit.php?id=$idQuo");
      } else {
        header("location:../../view/admin/quotation/trucking/form/edit.php?id=$idQuo");
      }
    }
  }
  elseif (isset($_POST['updateBudgetingQuotationDetailTrucking'])) {
    $resp = updateBudgetingQuotationDetailTrucking($koneksi, $_POST['hdQuotationId']);
    echo $resp;
  }
  elseif ($_POST['method'] == 'updateHdQuoTruckingReqCancel') {
    $resp = updateHdQuoTruckingReqCancel($koneksi, $_POST['id']);
    echo $resp;
  }
  elseif ($_POST['method'] == 'updateHdQuoTruckingApproveCancel') {
    $resp = updateHdQuoTruckingApproveCancel($koneksi, $_POST['id']);
    echo $resp;
  }
  elseif ($_POST['method'] == 'updateHdQuoTruckingRejectCancel') {
    $resp = updateHdQuoTruckingRejectCancel($koneksi, $_POST['id']);
    echo $resp;
  }

  function insertDetailQuo ($vendor, $costingFirst, $costingNext, $costingTotal, $quoId, $s_id, $koneksi) {
    $newStatus = 5;
    if (count($vendor) > 0) {
      $queryArray = array();
      $queryValues = '';
      // echo count($vendor);
      // print_r($vendor);
      foreach ($vendor as $key => $data) {
        array_push($queryArray, "('$quoId', '$data', '$costingFirst[$key]', '$costingNext[$key]', fn_sum_calculation('$quoId', '$costingFirst[$key]', '$costingNext[$key]', FALSE), '$s_id')");
      }
      $queryValues = implode(', ', $queryArray);
      $query = "INSERT INTO quotation_detail_trucking (`IdQuotation`, `IdVendor`, `CostingFirstPrice`, `CostingNextPrice`, `CostingTotalPrice`, `LastUpdatedById`) VALUES $queryValues;";
      printf($query);
      $result = mysqli_query($koneksi, $query);
      $newStatus = 2;
      return $newStatus;
    } else {
      return $newStatus;
    }
  }

  function updateDetailQuo ($vendor, $statusId, $idDetailQuo, $costingFirst, $costingNext, $costingTotal, $budgetingFirst, $budgetingNext, $budgetingTotal, $pricingFirst, $pricingNext, $pricingTotal, $quoId, $s_id, $koneksi) {
    print_r($vendor);
    $newStatus = $statusId;
    if (count($vendor) > 0) {
      $statusTemp = null;
      foreach ($vendor as $key => $data) {
        $statusTempTemp = null;
        $queryCheck = "SELECT * FROM quotation_detail_trucking WHERE Id='$idDetailQuo[$key]' LIMIT 1";
        $fetchCheck = mysqli_query($koneksi, $queryCheck);
        $dataCheck = mysqli_fetch_assoc($fetchCheck);
        // print_r($dataCheck);
        
        $arrayCheck = [];
        if ($dataCheck['CostingFirstPrice'] !== $costingFirst[$key] || $dataCheck['CostingNextPrice'] !== $costingNext[$key]) {
          array_push($arrayCheck, 'a');
        }
        if ($dataCheck['BudgetingFirstPrice'] !== $budgetingFirst[$key] || $dataCheck['BudgetingNextPrice'] !== $budgetingNext[$key]) {
          array_push($arrayCheck, 'b');
        }
        if ($dataCheck['PricingFirstPrice'] !== $pricingFirst[$key] || $dataCheck['PricingNextPrice'] !== $pricingNext[$key]) {
          array_push($arrayCheck, 'c');
        }
        print_r($arrayCheck);
        if (count($arrayCheck) == 1 && $statusTemp !== 5) {
          if ($arrayCheck[0] == 'a') {
            $statusTempTemp = 6;
          } elseif ($arrayCheck[0] == 'b') {
            $statusTempTemp = 7;
          } elseif ($arrayCheck[0] == 'c') {
            $statusTempTemp = 8;
          }

          if ($statusTemp == null) {
            $statusTemp = $statusTempTemp;
          } elseif ($statusTemp && $statusTemp !== $statusTempTemp) {
            $statusTemp = 5;
          }
        } elseif (count($arrayCheck) > 1) {
          $statusTempTemp = 5;
        } else {
          $statusTempTemp = $statusId;
        }
        echo $statusTempTemp;

        echo $statusTemp;


        $query = "UPDATE quotation_detail_trucking SET IdVendor='$data', CostingFirstPrice='$costingFirst[$key]', CostingNextPrice='$costingNext[$key]', CostingTotalPrice=fn_sum_calculation('$quoId', '$costingFirst[$key]', '$costingNext[$key]', FALSE), BudgetingFirstPrice='$budgetingFirst[$key]', BudgetingNextPrice='$budgetingNext[$key]', BudgetingTotalPrice='$budgetingTotal[$key]', PricingFirstPrice='$pricingFirst[$key]', PricingNextPrice='$pricingNext[$key]', PricingTotalPrice=fn_sum_calculation('$quoId', '$pricingFirst[$key]', '$pricingNext[$key]', FALSE), LastUpdatedById='$s_id' WHERE Id='$idDetailQuo[$key]'";
        echo $query;
        // print_r($query);
        $result = mysqli_query($koneksi, $query);
        
      }
      $newStatus = $statusTemp;
      // echo $newStatus;
    }
    return $newStatus;
  }

  function updateBudgetingQuotationDetailTrucking($koneksi, $hdQuotationId){
    $stmt = $koneksi->prepare("CALL update_budgeting_quotation_detail_trucking(?)");
    $stmt->bind_param("i", $hdQuotationId);
    if (!$stmt->execute()) {
      die("Stored procedure execution failed: " . $stmt->error);
    }
    // $stmt->close();
    // return json_encode(['status' => 200, 'message' => 'Success']);
    return json_encode(['status' => 200, 'message' => 'Success']);
  }

  function updateHdQuoTruckingReqCancel($koneksi, $hdQuotationId)
  {
    $id = $hdQuotationId;
    $reason_request_cancel = $_POST['reason_request_cancel'];
    $last_updated_by_id = $_SESSION['id'];
    $last_updated_by_name = $_SESSION['nama'];
    // print_r($_POST);die();

    $query = "UPDATE `master_quotation_trucking` SET 
          `IdQuoStatus` = 12, 
          `update_at` = '" . date('Y-m-d H:i:s') . "',
          `requestCancelDate` = '" . date('Y-m-d H:i:s') . "',
          `reason_request_cancel` = '$reason_request_cancel',
          `LastUpdatedById` = '$last_updated_by_id',
          `LastUpdatedByName` = '$last_updated_by_name'
      WHERE `id` = $id;";
      // print_r($query);
      // print_r($query);die();
      
      $result = mysqli_query($koneksi, $query);
      // return json_encode(['query' => $query]);
    
    if($result) {
      return json_encode(['status' => 200, 'message' => 'Success']);
    } else {
      return json_encode(['status' => 500, 'message' => 'Failed']);
    }
  }

  function updateHdQuoTruckingApproveCancel($koneksi, $hdQuotationId)
  {
    $id = $hdQuotationId;
    $last_updated_by_id = $_SESSION['id'];
    $last_updated_by_name = $_SESSION['nama'];
    // print_r($_POST);die();

    $query = "UPDATE `master_quotation_trucking` SET 
        `IdQuoStatus` = 13, 
        `update_at` = '" . date('Y-m-d H:i:s') . "',
        `approved_request_date` = '" . date('Y-m-d H:i:s') . "',
        `LastUpdatedById` = '$last_updated_by_id',
        `LastUpdatedByName` = '$last_updated_by_name'
    WHERE `id` = $id;";
    // print_r($query);die();
    
    $result = mysqli_query($koneksi, $query);
    
    if($result) {
      return json_encode(['status' => 200, 'message' => 'Success']);
    } else {
      return json_encode(['status' => 500, 'message' => 'Failed']);
    }
  }

  function updateHdQuoTruckingRejectCancel($koneksi, $hdQuotationId)
  {
    $id = $hdQuotationId;
    $last_updated_by_id = $_SESSION['id'];
    $last_updated_by_name = $_SESSION['nama'];
    // print_r($_POST);die();

    $query = "UPDATE `master_quotation_trucking` SET 
          `IdQuoStatus` = 9, 
          `update_at` = '" . date('Y-m-d H:i:s') . "',
          `rejectedRequestDate` = '" . date('Y-m-d H:i:s') . "',
          `LastUpdatedById` = '$last_updated_by_id',
          `LastUpdatedByName` = '$last_updated_by_name'
      WHERE `id` = $id;";
    // print_r($query);die();
    
    $result = mysqli_query($koneksi, $query);
    
    if($result) {
      return json_encode(['status' => 200, 'message' => 'Success']);
    } else {
      return json_encode(['status' => 500, 'message' => 'Failed']);
    }
  }
?>