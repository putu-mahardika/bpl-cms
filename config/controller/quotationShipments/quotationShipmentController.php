<?php
    include '../../koneksi.php';
    date_default_timezone_set("Asia/Jakarta");
    $datetime = date('Y-m-d H:i:s');
    $year = date('Y', strtotime($datetime));
    session_save_path('../../../tmp');
    session_start();
    //$s_username = $_SESSION['username'];
    $s_id = $_SESSION['id'];
    $s_name = $_SESSION['nama'];
    $akses = $_SESSION['hak_akses'];

    function getCustomers($koneksi, $s_id)
    {
        $query = "SELECT * FROM master_customer where UserId = '{$s_id}' ";
        
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }
        
        $customers = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $customers[] = $row;
        }
        
        return $customers;
    }

    function getVendors($koneksi)
    {
        $query = "SELECT * FROM master_vendor where type = 'ALL' or type = 'Shipment'";
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }
        
        $vendors = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $vendors[] = $row;
        }

        
        return $vendors;
    }

    function getSales($koneksi)
    {
        $query = "SELECT * FROM master_user where isSales = 1 or isVMShipment = 1 or isVMTrucking = 1";
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }
        
        $sales = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $sales[] = $row;
        }

        
        return $sales;
    }

    function getVm($koneksi)
    {
        $query = "SELECT * FROM master_user where isVMShipment = 1 or isVMTrucking = 1";
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }
        
        $vm = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $vm[] = $row;
        }

        
        return $vm;
    }

    function getShipmentTerms($koneksi)
    {
        $query = "SELECT * FROM master_shipment_terms where aktif=1";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }

        $shipmentTerms = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $shipmentTerms[] = $row;
        }

        return $shipmentTerms;
    }

    function getShipmentContainers($koneksi)
    {
        $query = "SELECT * FROM master_unit where aktif=1 order by atr1 asc";
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }
        
        $shipmentContainers = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $shipmentContainers[] = $row;
        }
        
        return $shipmentContainers;
    }

    function getShipmentLoadTypes($koneksi)
    {
        $query = "SELECT * FROM master_load_type where aktif=1 order by atr1 asc";
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }
        
        $shipmentLoadTypes = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $shipmentLoadTypes[] = $row;
        }
        
        return $shipmentLoadTypes;
    }

    function getCountries($koneksi)
    {
        $query = "SELECT * FROM master_negara";
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }
        
        $countries = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $countries[] = $row;
        }
        
        return $countries;
    }

    function getHdQuoShipments($koneksi)
    {
        session_save_path('../../../tmp');
        session_start();
        //$s_username = $_SESSION['username'];
        $s_id = $_SESSION['id'];
        $akses = $_SESSION['hak_akses'];
        $year = $_GET['tahun'];

        if ($akses == 'Admin' || $akses == 'VmShipment' || $akses == 'VmTrucking') {
            $query = "SELECT 
                    hqs.*,
                    DATE_FORMAT(hqs.created_at, '%d-%m-%Y %H:%i:%s') as `created_at`,
                    DATE_FORMAT(hqs.updated_at, '%d-%m-%Y %H:%i:%s') as `updated_at`,
                    DATE_FORMAT(hqs.request_cancel_date, '%d-%m-%Y %H:%i:%s') as `request_cancel_date`,
                    DATE_FORMAT(hqs.currency_date, '%Y-%m-%d') as `currency_date`,
                    CASE
                        WHEN hqs.customer_id IS NULL THEN hqs.customer_name_temp ELSE mc.nama
                    END AS `customer_name`,
                    CASE
                        WHEN hqs.customer_id IS NULL THEN hqs.pic_phone_temp ELSE mc.telp
                    END AS `customer_phone`,
                    hqs.pic_name_temp as `pic_name_temp`,
                    hqs.pic_phone_temp as `pic_phone_temp`,
                    mqs.id as `status_id`,
                    mqs.name as `status`,
                    mqs.color as `status_color`,
                    mn_o.Nama as `origin_country_name`,
                    mn_d.Nama as `destination_country_name`,
                    mu.id as `master_unit_id`,
                    CASE
                        WHEN mu.nama IS NULL THEN '-' ELSE mu.nama
                    END AS `master_unit_name`,
                    musr.UserId as `sales_id`,
                    CASE
                        WHEN musr.nama IS NULL THEN '-' ELSE musr.nama
                    END AS `sales_name`,
                    mvm.UserId as `vm_id`,
                    CASE
                        WHEN mvm.nama IS NULL THEN '-' ELSE mvm.nama
                    END AS `vm_name`
                FROM hd_quo_shipments as hqs
                LEFT JOIN master_quo_status as mqs ON hqs.quo_status_id = mqs.id
                LEFT JOIN master_negara as mn_o ON hqs.origin_country_id = mn_o.id
                LEFT JOIN master_negara as mn_d ON hqs.destination_country_id = mn_d.id
                LEFT JOIN master_customer as mc on hqs.customer_id = mc.CustId
                LEFT JOIN master_unit as mu on hqs.master_unit_id = mu.id
                LEFT JOIN master_user as musr on hqs.sales_id = musr.UserId
                LEFT JOIN master_user as mvm on hqs.vm_id = mvm.UserId
                LEFT JOIN master_shipment_terms as mst on hqs.shipment_terms_id = mst.id
                LEFT JOIN master_load_type as mlt on hqs.shipment_load_type_id = mlt.id
                WHERE YEAR(hqs.created_at) = '{$year}'
                ORDER BY hqs.updated_at DESC;
            ";
        } else {
            $query = "SELECT 
                    hqs.*,
                    DATE_FORMAT(hqs.created_at, '%d-%m-%Y %H:%i:%s') as `created_at`,
                    DATE_FORMAT(hqs.updated_at, '%d-%m-%Y %H:%i:%s') as `updated_at`,
                    DATE_FORMAT(hqs.request_cancel_date, '%d-%m-%Y %H:%i:%s') as `request_cancel_date`,
                    DATE_FORMAT(hqs.currency_date, '%Y-%m-%d') as `currency_date`,
                    CASE
                        WHEN hqs.customer_id IS NULL THEN hqs.customer_name_temp ELSE mc.nama
                    END AS `customer_name`,
                    CASE
                        WHEN hqs.customer_id IS NULL THEN hqs.pic_name_temp ELSE mc.telp
                    END AS `customer_phone`,
                    hqs.pic_name_temp as `pic_name_temp`,
                    hqs.pic_phone_temp as `pic_phone_temp`,
                    mqs.id as `status_id`,
                    mqs.name as `status`,
                    mqs.color as `status_color`,
                    mn_o.Nama as `origin_country_name`,
                    mn_d.Nama as `destination_country_name`,
                    mu.id as `master_unit_id`,
                    CASE
                        WHEN mu.nama IS NULL THEN '-' ELSE mu.nama
                    END AS `master_unit_name`,
                    musr.UserId as `sales_id`,
                    CASE
                        WHEN musr.nama IS NULL THEN '-' ELSE musr.nama
                    END AS `sales_name`,
                    mvm.UserId as `vm_id`,
                    CASE
                        WHEN mvm.nama IS NULL THEN '-' ELSE mvm.nama
                    END AS `vm_name`
                FROM hd_quo_shipments as hqs
                LEFT JOIN master_quo_status as mqs ON hqs.quo_status_id = mqs.id
                LEFT JOIN master_negara as mn_o ON hqs.origin_country_id = mn_o.id
                LEFT JOIN master_negara as mn_d ON hqs.destination_country_id = mn_d.id
                LEFT JOIN master_customer as mc on hqs.customer_id = mc.CustId
                LEFT JOIN master_unit as mu on hqs.master_unit_id = mu.id
                LEFT JOIN master_user as musr on hqs.sales_id = musr.UserId
                LEFT JOIN master_user as mvm on hqs.vm_id = mvm.UserId
                LEFT JOIN master_shipment_terms as mst on hqs.shipment_terms_id = mst.id
                LEFT JOIN master_load_type as mlt on hqs.shipment_load_type_id = mlt.id
                WHERE YEAR(hqs.created_at) = '{$year}' AND hqs.sales_id = '".$s_id."'
                ORDER BY hqs.updated_at DESC;
            ";
        }

        // print_r($query);die();

        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        foreach ($data as $key => $value) {
            $data[$key]['nomor_po'] = '-';
            $data[$key]['qty'] = '-';
        }
        
        echo json_encode($data);
    }

    function getHdQuoShipmentDetails($koneksi)
    {
        $id = $_GET['id'];

        $query = "SELECT 
                hqs.*,
                DATE_FORMAT(hqs.created_at, '%d-%m-%Y %H:%i:%s') as `created_at`,
                DATE_FORMAT(hqs.updated_at, '%d-%m-%Y %H:%i:%s') as `updated_at`,
                DATE_FORMAT(hqs.request_cancel_date, '%d-%m-%Y %H:%i:%s') as `request_cancel_date`,
                DATE_FORMAT(hqs.currency_date, '%Y-%m-%d') as `currency_date`,
                CASE
                    WHEN hqs.customer_id IS NULL THEN hqs.customer_name_temp ELSE mc.nama
                END AS `customer_name`,
                CASE
                    WHEN hqs.customer_id IS NULL THEN hqs.pic_name_temp ELSE mc.telp
                END AS `customer_phone`,
                hqs.pic_name_temp as `pic_name_temp`,
                hqs.pic_phone_temp as `pic_phone_temp`,
                mqs.id as `status_id`,
                mqs.name as `status`,
                mqs.color as `status_color`,
                mn_o.Nama as `origin_country_name`,
                mn_d.Nama as `destination_country_name`,
                mu.id as `master_unit_id`,
                mu.nama as `master_unit_name`,
                musr.UserId as `sales_id`,
                musr.nama as `sales_name`,
                mvm.UserId as `vm_id`,
                mvm.nama as `vm_name`,
                mst.id as `shipment_terms_id`,
                mst.nama as `shipment_terms_name`,
                mlt.id as `shipment_load_type_id`,
                mlt.nama as `shipment_load_type_name`
            FROM hd_quo_shipments as hqs
            LEFT JOIN master_quo_status as mqs ON hqs.quo_status_id = mqs.id
            LEFT JOIN master_negara as mn_o ON hqs.origin_country_id = mn_o.id
            LEFT JOIN master_negara as mn_d ON hqs.destination_country_id = mn_d.id
            LEFT JOIN master_customer as mc on hqs.customer_id = mc.CustId
            LEFT JOIN master_unit as mu on hqs.master_unit_id = mu.id
            LEFT JOIN master_user as musr on hqs.sales_id = musr.UserId
            LEFT JOIN master_user as mvm on hqs.vm_id = mvm.UserId
            LEFT JOIN master_shipment_terms as mst on hqs.shipment_terms_id = mst.id
            LEFT JOIN master_load_type as mlt on hqs.shipment_load_type_id = mlt.id
            WHERE hqs.id = $id;
        ";

        // print_r($query);die();
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data = $row;
        }

        $dataDtlQuoShipment = getDtlQuoShipment($koneksi, $id);
        $data['dtl_quo_shipment'] = $dataDtlQuoShipment;
        $dataDtlQuoShipmentHandlingCosts = getDtlQuoShipmentHandlingCosts($koneksi, $id);
        $data['dtl_quo_shipment_handling_costs'] = $dataDtlQuoShipmentHandlingCosts;

        echo json_encode($data);
    }

    function getHdQuoShipmentsPrint($koneksi)
    {
        $id = $_GET['id'];

        $query = "SELECT 
                hqs.*,
                DATE_FORMAT(hqs.created_at, '%d-%m-%Y %H:%i:%s') as `created_at`,
                DATE_FORMAT(hqs.updated_at, '%d-%m-%Y %H:%i:%s') as `updated_at`,
                DATE_FORMAT(hqs.request_cancel_date, '%d-%m-%Y %H:%i:%s') as `request_cancel_date`,
                DATE_FORMAT(hqs.currency_date, '%Y-%m-%d') as `currency_date`,
                CASE
                    WHEN hqs.customer_id IS NULL THEN hqs.customer_name_temp ELSE mc.nama
                END AS `customer_name`,
                CASE
                    WHEN hqs.customer_id IS NULL THEN hqs.pic_name_temp ELSE mc.telp
                END AS `customer_phone`,
                hqs.pic_name_temp as `pic_name_temp`,
                hqs.pic_phone_temp as `pic_phone_temp`,
                mqs.id as `status_id`,
                mqs.name as `status`,
                mqs.color as `status_color`,
                mn_o.Nama as `origin_country_name`,
                mn_d.Nama as `destination_country_name`,
                mu.id as `master_unit_id`,
                mu.nama as `master_unit_name`,
                musr.UserId as `sales_id`,
                musr.nama as `sales_name`,
                mvm.UserId as `vm_id`,
                mvm.nama as `vm_name`,
                mst.id as `shipment_terms_id`,
                mst.nama as `shipment_terms_name`,
                mlt.id as `shipment_load_type_id`,
                mlt.nama as `shipment_load_type_name`
            FROM hd_quo_shipments as hqs
            LEFT JOIN master_quo_status as mqs ON hqs.quo_status_id = mqs.id
            LEFT JOIN master_negara as mn_o ON hqs.origin_country_id = mn_o.id
            LEFT JOIN master_negara as mn_d ON hqs.destination_country_id = mn_d.id
            LEFT JOIN master_customer as mc on hqs.customer_id = mc.CustId
            LEFT JOIN master_unit as mu on hqs.master_unit_id = mu.id
            LEFT JOIN master_user as musr on hqs.sales_id = musr.UserId
            LEFT JOIN master_user as mvm on hqs.vm_id = mvm.UserId
            LEFT JOIN master_shipment_terms as mst on hqs.shipment_terms_id = mst.id
            LEFT JOIN master_load_type as mlt on hqs.shipment_load_type_id = mlt.id
            WHERE hqs.id = $id;
        ";

        // print_r($query);die();
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data = $row;
        }

        $dataDtlQuoShipment = getDtlQuoShipment($koneksi, $id);
        $data['dtl_quo_shipment'] = $dataDtlQuoShipment;
        $dataDtlQuoShipmentHandlingCosts = getDtlQuoShipmentHandlingCosts($koneksi, $id);
        $data['dtl_quo_shipment_handling_costs'] = $dataDtlQuoShipmentHandlingCosts;

        foreach ($dataDtlQuoShipmentHandlingCosts as $key => $value) {
            $data['total_handling_unit'] += $value['unit_price'];
            $data['total_handling_price'] += $value['total_price'];
        }

        return $data;
    }

    function getQuotationLog($koneksi, $id)
    {
        $query = "SELECT 
                ql.*,
                DATE_FORMAT(ql.created_date, '%d-%m-%Y %H:%i:%s') as `created_at`,
                DATE_FORMAT(ql.update_at, '%d-%m-%Y %H:%i:%s') as `updated_at`
            FROM quotation_log as ql
            WHERE ql.IdQuoShipment = $id
            ORDER BY ql.update_at DESC
            LIMIT 20;
        ";
        
        // print_r($query);die();
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    function getDtlQuoShipment($koneksi, $id)
    {
        $query = "SELECT 
                dqs.*,
                DATE_FORMAT(dqs.created_at, '%d-%m-%Y %H:%i:%s') as `created_at`,
                DATE_FORMAT(dqs.updated_at, '%d-%m-%Y %H:%i:%s') as `updated_at`,
                mv.nama as `vendor_name`
            FROM dtl_quo_shipment as dqs
            LEFT JOIN master_vendor as mv ON mv.Id = dqs.vendor_id
            WHERE dqs.hd_quotation_id = $id;
        ";
        
        // print_r($query);die();
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    function getDtlQuoShipmentHandlingCosts($koneksi, $id)
    {
        $query = "SELECT 
                dqshc.*,
                DATE_FORMAT(dqshc.created_at, '%d-%m-%Y %H:%i:%s') as `created_at`,
                DATE_FORMAT(dqshc.updated_at, '%d-%m-%Y %H:%i:%s') as `updated_at`,
                mvm.UserId as `vm_id`,
                mvm.nama as `vm_name`,
                msl.UserId as `sales_id`,
                msl.nama as `sales_name`
            FROM dtl_quo_shipment_handling_costs as dqshc
            LEFT JOIN master_user as msl ON msl.UserId = dqshc.sales_id
            LEFT JOIN master_user as mvm ON mvm.UserId = dqshc.vm_id
            WHERE dqshc.hd_quotation_id = $id;
        ";
        
        // print_r($query);die();
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }

        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    function getCheckCustomerCode($koneksi)
    {
        $sales_id = $_GET['sales_id'];
        $customer_code = $_GET['customer_code'];

        $query = "SELECT * FROM master_customer where kode_customer = '$customer_code' AND UserId = '$sales_id'";
        // print_r($query);die();
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            return json_encode(['status' => 500, 'message' => 'Failed']);
        }
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data = $row;
        }

        if (empty($data)) {
            return json_encode(['status' => 200, 'data' => null, 'message' => 'Kode Customer tidak ditemukan']);
        } else {
            return json_encode(['status' => 200, 'data' => $data, 'message' => 'Success']);
        }
    }

    function createHdQuoShipmentsSales($koneksi)
    {
        session_save_path('../../../tmp');
        session_start();

        $last_updated_by_id = $_SESSION['id'];
        $last_updated_by_name = $_SESSION['nama'];
        $sales_id = $_POST['sales_id'];
        $vm_id = $_POST['vm_id'];
        $handling_name_1 = $_POST['handling_name_1'];
        $handling_qty_1 = $_POST['handling_qty_1'];
        $handling_unit_cost_1 = $_POST['handling_unit_cost_1'];
        $handling_total_cost_1 = $_POST['handling_total_cost_1'];
        $handling_name_next = $_POST['handling_name_next'];
        $handling_qty_next = $_POST['handling_qty_next'];
        $handling_unit_cost_next = $_POST['handling_unit_cost_next'];
        $handling_total_cost_next = $_POST['handling_total_cost_next'];
        $vendor_data = $_POST['vendor_data'];
        
        $lastInsertedId = createHdQuoShipments($koneksi, $last_updated_by_id, $last_updated_by_name);

        if (count($vendor_data) > 0) {
            foreach ($vendor_data as $key => $value) {
                if ($value['vendor_id'] != NULL) {
                    createDtlQuoShipment(
                        $koneksi, 
                        $lastInsertedId, 
                        $value['vendor_id'], 
                        $value['costing_first_price'] ?? 0, 
                        $value['costing_next_price'] ?? 0, 
                        $value['costing_total_price'] ?? 0, 
                        $value['budgeting_first_price'] ?? 0, 
                        $value['budgeting_next_price'] ?? 0, 
                        $value['budgeting_total_price'] ?? 0, 
                        $value['pricing_first_price'] ?? 0, 
                        $value['pricing_next_price'] ?? 0, 
                        $value['pricing_total_price'] ?? 0, 
                        $last_updated_by_id
                    );
                }
            }
        }

        if ($handling_qty_1 > 0) {
            createDtlQuoShipmentHandlingCostsSales(
                $koneksi, 
                $lastInsertedId, 
                $sales_id, 
                $vm_id, 
                1, 
                $handling_name_1, 
                $handling_qty_1, 
                $handling_unit_cost_1, 
                $handling_total_cost_1, 
                $last_updated_by_id, 
                $last_updated_by_name
            );
        }
        if ($handling_qty_next > 0) {
            createDtlQuoShipmentHandlingCostsSales(
                $koneksi, 
                $lastInsertedId, 
                $sales_id, 
                $vm_id, 
                2, 
                $handling_name_next, 
                $handling_qty_next, 
                $handling_unit_cost_next, 
                $handling_total_cost_next, 
                $last_updated_by_id, 
                $last_updated_by_name
            );
        }

        return json_encode(['status' => 200, 'data' => $lastInsertedId, 'message' => 'Success']);
    }

    function createHdQuoShipmentsAdmin($koneksi)
    {
        session_save_path('../../../tmp');
        session_start();

        $last_updated_by_id = $_SESSION['id'];
        $last_updated_by_name = $_SESSION['nama'];
        $sales_id = $_POST['sales_id'];
        $vm_id = $_POST['vm_id'];
        $handling_name_1 = $_POST['handling_name_1'];
        $handling_qty_1 = $_POST['handling_qty_1'];
        $handling_unit_cost_1 = $_POST['handling_unit_cost_1'] ?? 0;
        $handling_total_cost_1 = $_POST['handling_total_cost_1'] ?? 0;
        $handling_unit_budgeting_1 = $_POST['handling_unit_budgeting_1'] ?? 0;
        $handling_total_budgeting_1 = $_POST['handling_total_budgeting_1'] ?? 0;
        $handling_unit_price_1 = $_POST['handling_unit_price_1'] ?? 0;
        $handling_total_price_1 = $_POST['handling_total_price_1'] ?? 0;
        $handling_name_next = $_POST['handling_name_next'];
        $handling_qty_next = $_POST['handling_qty_next'];
        $handling_unit_cost_next = $_POST['handling_unit_cost_next'] ?? 0;
        $handling_total_cost_next = $_POST['handling_total_cost_next'] ?? 0;
        $handling_unit_budgeting_next = $_POST['handling_unit_budgeting_next'] ?? 0;
        $handling_total_budgeting_next = $_POST['handling_total_budgeting_next'] ?? 0;
        $handling_unit_price_next = $_POST['handling_unit_price_next'] ?? 0;
        $handling_total_price_next = $_POST['handling_total_price_next'] ?? 0;
        $vendor_data = $_POST['vendor_data'];

        $lastInsertedId = createHdQuoShipments($koneksi, $last_updated_by_id, $last_updated_by_name);

        if (count($vendor_data) > 0) {
            foreach ($vendor_data as $key => $value) {
                if ($value['vendor_id'] != NULL) {
                    createDtlQuoShipment(
                        $koneksi, 
                        $lastInsertedId, 
                        $value['vendor_id'], 
                        $value['costing_first_price'] ?? 0, 
                        $value['costing_next_price'] ?? 0, 
                        $value['costing_total_price'] ?? 0, 
                        $value['budgeting_first_price'] ?? 0, 
                        $value['budgeting_next_price'] ?? 0, 
                        $value['budgeting_total_price'] ?? 0, 
                        $value['pricing_first_price'] ?? 0, 
                        $value['pricing_next_price'] ?? 0, 
                        $value['pricing_total_price'] ?? 0, 
                        $last_updated_by_id
                    );
                }
            }
        }

        if ($handling_qty_1 > 0) {
            createDtlQuoShipmentHandlingCostsAdmin(
                $koneksi, 
                $lastInsertedId, 
                $sales_id, 
                $vm_id, 
                1, 
                $handling_name_1, 
                $handling_qty_1, 
                $handling_unit_cost_1, 
                $handling_total_cost_1, 
                $handling_unit_budgeting_1, 
                $handling_total_budgeting_1, 
                $handling_unit_price_1, 
                $handling_total_price_1, 
                $last_updated_by_id, 
                $last_updated_by_name
            );
        }
        if ($handling_qty_next > 0) {
            createDtlQuoShipmentHandlingCostsAdmin(
                $koneksi, 
                $lastInsertedId, 
                $sales_id, 
                $vm_id, 
                2, 
                $handling_name_next, 
                $handling_qty_next, 
                $handling_unit_cost_next, 
                $handling_total_cost_next, 
                $handling_unit_budgeting_next, 
                $handling_total_budgeting_next, 
                $handling_unit_price_next, 
                $handling_total_price_next, 
                $last_updated_by_id, 
                $last_updated_by_name
            );
        }

        return json_encode(['status' => 200, 'data' => $lastInsertedId, 'message' => 'Success']);
    }

    function createHdQuoShipments($koneksi, $last_updated_by_id, $last_updated_by_name)
    {
        $customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;
        $sales_id = $_POST['sales_id'];
        $total_container = $_POST['total_container'];
        $item_description = $_POST['item_description'];
        $vm_id = $_POST['vm_id'];
        $quo_status_id = $_POST['quo_status_id'];
        $customer_name_temp = $_POST['customer_name_temp'];
        $customer_address_temp = $_POST['customer_address_temp'];
        $customer_terms_payment_temp = $_POST['customer_terms_payment_temp'];
        $pic_name_temp = $_POST['pic_name_temp'];
        $pic_phone_temp = $_POST['pic_phone_temp'];
        $master_unit_id = $_POST['master_unit_id'];
        $shipment_terms_id = $_POST['shipment_terms_id'];
        $shipment_load_type_id = $_POST['shipment_load_type_id'];
        $note = $_POST['note'];
        $is_need_trucking = $_POST['is_need_trucking'];
        $link_trans_trucking_id = $_POST['link_trans_trucking_id'];
        $link_trans_shipment_id = $_POST['link_trans_shipment_id'];
        $origin_country_id = $_POST['origin_country_id'];
        $destination_country_id = $_POST['destination_country_id'];
        $pickup_note = $_POST['pickup_note'];
        $destination_note = $_POST['destination_note'];
        $freight_cost = isset($_POST['freight_cost']) ? $_POST['freight_cost'] : null;
        $currency_rate = isset($_POST['currency_rate']) ? $_POST['currency_rate'] : null;
        $selected_quo_vendor_id = isset($_POST['selected_quo_vendor_id']) ? $_POST['selected_quo_vendor_id'] : null;

        $query = "INSERT INTO `hd_quo_shipments`
            (
                `customer_id`,
                `sales_id`,
                `total_container`,
                `item_description`,
                `vm_id`,
                `quo_status_id`,
                `customer_name_temp`,
                `customer_address_temp`,
                `customer_terms_payment_temp`,
                `pic_name_temp`,
                `pic_phone_temp`,
                `master_unit_id`,
                `shipment_terms_id`,
                `shipment_load_type_id`,
                `note`,
                `is_need_trucking`,
                `link_trans_trucking_id`,
                `link_trans_shipment_id`,
                `origin_country_id`,
                `destination_country_id`,
                `pickup_note`,
                `destination_note`,
                `selected_quo_vendor_id`,
                `freight_cost`,
                `currency_date`,
                `currency_rate`,
                `request_cancel_date`,
                `rejected_request_date`,
                `approved_request_date`,
                `reason_request_cancel`,
                `deleted_at`,
                `created_at`,
                `updated_at`,
                `print_quo_date`,
                `create_po_date`,
                `cancel_date`,
                `from_no_quotation`,
                `from_quotation_id`,
                `is_active`,
                `is_deleted`,
                `last_updated_by_id`,
                `last_updated_by_name`
            ) VALUES (
                " . ($customer_id ? "'$customer_id'" : "NULL") . ", -- customer_id
                " . ($sales_id ? "'$sales_id'" : "NULL") . ", -- sales_id
                " . ($total_container ? "'$total_container'" : 0) . ", -- total_container
                " . ($item_description ? "'$item_description'" : "NULL") . ", -- item_description
                " . ($vm_id ? "'$vm_id'" : "NULL") . ", -- vm_id
                " . ($quo_status_id ? "'$quo_status_id'" : "NULL") . ", -- quo_status_id
                " . ($customer_name_temp ? "'$customer_name_temp'" : "NULL") . ", -- customer_name_temp
                " . ($customer_address_temp ? "'$customer_address_temp'" : "NULL") . ", -- customer_address_temp
                " . ($customer_terms_payment_temp ? "'$customer_terms_payment_temp'" : 0) . ", -- customer_terms_payment_temp
                " . ($pic_name_temp ? "'$pic_name_temp'" : "NULL") . ", -- pic_name_temp
                " . ($pic_phone_temp ? "'$pic_phone_temp'" : "NULL") . ", -- pic_phone_temp
                " . ($master_unit_id ? "'$master_unit_id'" : "NULL") . ", -- master_unit_id
                " . ($shipment_terms_id ? "'$shipment_terms_id'" : "NULL") . ", -- shipment_terms_id
                " . ($shipment_load_type_id ? "'$shipment_load_type_id'" : "NULL") . ", -- shipment_load_type_id
                " . ($note ? "'$note'" : "NULL") . ", -- note
                " . ($is_need_trucking ? "'$is_need_trucking'" : "NULL") . ", -- is_need_trucking
                " . ($link_trans_trucking_id ? "'$link_trans_trucking_id'" : "NULL") . ", -- link_trans_trucking_id
                " . ($link_trans_shipment_id ? "'$link_trans_shipment_id'" : "NULL") . ", -- link_trans_shipment_id
                " . ($origin_country_id ? "'$origin_country_id'" : "NULL") . ", -- origin_country_id
                " . ($destination_country_id ? "'$destination_country_id'" : "NULL") . ", -- destination_country_id
                " . ($pickup_note ? "'$pickup_note'" : "NULL") . ", -- pickup_note
                " . ($destination_note ? "'$destination_note'" : "NULL") . ", -- destination_note
                " . ($selected_quo_vendor_id ? "'$selected_quo_vendor_id'" : "NULL") . ", -- selected_quo_vendor_id
                " . ($freight_cost ? "'$freight_cost'" : 0) . ", -- freight_cost
                NULL, -- currency_date
                " . ($currency_rate ? "'$currency_rate'" : 0) . ", -- currency_rate
                NULL, -- request_cancel_date
                NULL, -- rejected_cancel_date
                NULL, -- approved_cancel_date
                NULL, -- reason_request_cancel
                NULL, -- deleted_at
                '" . date('Y-m-d H:i:s') . "', -- created_at
                '" . date('Y-m-d H:i:s') . "', -- updated_at
                NULL, -- print_quo_date
                NULL, -- create_po_date
                NULL, -- cancel_date
                NULL, -- from_no_quotation
                NULL, -- from_quotation_id
                1, -- is_active
                0, -- is_deleted
                " . $last_updated_by_id . ", -- last_updated_by_id
                '" . $last_updated_by_name . "' -- last_updated_by_name
            );";

        // echo $query;die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            $lastInsertedId = $koneksi->insert_id;
        }

        return $lastInsertedId;
    }

    function createDtlQuoShipment($koneksi, $id, $vendor_id, $costing_first_price, $costing_next_price, $costing_total_price, $budgeting_first_price, $budgeting_next_price, $budgeting_total_price, $pricing_first_price, $pricing_next_price, $pricing_total_price, $last_updated_by_id)
    {
        $queryDtlQuoShipment = "INSERT INTO `dtl_quo_shipment`
            (
            `hd_quotation_id`,
            `vendor_id`,
            `costing_first_price`,
            `costing_next_price`,
            `costing_total_price`,
            `budgeting_first_price`,
            `budgeting_next_price`,
            `budgeting_total_price`,
            `pricing_first_price`,
            `pricing_next_price`,
            `pricing_total_price`,
            `last_updated_by_id`
            ) VALUES (
                '$id', 
                '{$vendor_id}', 
                " . ($costing_first_price ? $costing_first_price : 0) . ", 
                " . ($costing_next_price ? $costing_next_price : 0) . ", 
                " . ($costing_total_price ? $costing_total_price : 0) . ", 
                " . ($budgeting_first_price ? $budgeting_first_price : 0) . ", 
                " . ($budgeting_next_price ? $budgeting_next_price : 0) . ", 
                " . ($budgeting_total_price ? $budgeting_total_price : 0) . ", 
                " . ($pricing_first_price ? $pricing_first_price : 0) . ", 
                " . ($pricing_next_price ? $pricing_next_price : 0) . ", 
                " . ($pricing_total_price ? $pricing_total_price : 0) . ", 
                '{$last_updated_by_id}'
            )";

        // print_r($queryDtlQuoShipment);die();

        $resultDtlQuoShipment = mysqli_query($koneksi, $queryDtlQuoShipment);

        if (!$resultDtlQuoShipment) {
            die("Query failed: " . mysqli_error($koneksi));
        }
    }

    function createDtlQuoShipmentHandlingCostsSales(
        $koneksi, 
        $id, 
        $sales_id, 
        $vm_id, 
        $handling_turunan, 
        $handling_description, 
        $quantity, 
        $unit_price, 
        $total_price, 
        $last_updated_by_id, 
        $last_updated_by_name
    )
    {
        $query = "INSERT INTO `dtl_quo_shipment_handling_costs`
            (
                `hd_quotation_id`,
                `created_at`,
                `updated_at`,
                `sales_id`,
                `vm_id`,
                `handling_turunan`,
                `handling_description`,
                `quantity`,
                `unit_price`,
                `total_price`,
                `last_updated_prices_at`,
                `last_updated_by_id`,
                `last_updated_by_name`
            ) VALUES (
                " . $id . ", -- hd_quotation_id
                '" . date('Y-m-d H:i:s') . "', -- created_at
                '" . date('Y-m-d H:i:s') . "', -- updated_at
                " . ($sales_id ? "'$sales_id'" : "NULL") . ", -- sales_id
                " . ($vm_id ? "'$vm_id'" : "NULL") . ", -- vm_id
                " . ($handling_turunan ? "'$handling_turunan'" : "NULL") . ", -- handling_turunan
                " . ($handling_description ? "'$handling_description'" : "NULL") . ", -- handling_description
                " . ($quantity ? "'$quantity'" : "NULL") . ", -- quantity
                " . ($unit_price ? "'$unit_price'" : "NULL") . ", -- unit_price
                " . ($total_price ? "'$total_price'" : "NULL") . ", -- total_price
                '" . date('Y-m-d H:i:s') . "', -- last_updated_prices_at
                " . $last_updated_by_id . ", -- last_updated_by_id
                '" . $last_updated_by_name . "' -- last_updated_by_name
            );";

        // echo $query;die();
        
        mysqli_query($koneksi, $query);
    }

    function createDtlQuoShipmentHandlingCostsVM(
        $koneksi, 
        $id, 
        $sales_id, 
        $vm_id, 
        $handling_turunan, 
        $handling_description, 
        $quantity, 
        $unit_cost, 
        $total_cost, 
        $last_updated_by_id, 
        $last_updated_by_name
    )
    {
        $query = "INSERT INTO `dtl_quo_shipment_handling_costs`
            (
                `hd_quotation_id`,
                `created_at`,
                `updated_at`,
                `sales_id`,
                `vm_id`,
                `handling_turunan`,
                `handling_description`,
                `quantity`,
                `unit_cost`,
                `total_cost`,
                `last_updated_cost_at`,
                `last_updated_by_id`,
                `last_updated_by_name`
            ) VALUES (
                " . $id . ", -- hd_quotation_id
                '" . date('Y-m-d H:i:s') . "', -- created_at
                '" . date('Y-m-d H:i:s') . "', -- updated_at
                " . ($sales_id ? "'$sales_id'" : "NULL") . ", -- sales_id
                " . ($vm_id ? "'$vm_id'" : "NULL") . ", -- vm_id
                " . ($handling_turunan ? "'$handling_turunan'" : "NULL") . ", -- handling_turunan
                " . ($handling_description ? "'$handling_description'" : "NULL") . ", -- handling_description
                " . ($quantity ? "'$quantity'" : "NULL") . ", -- quantity
                " . ($unit_cost ? "'$unit_cost'" : "NULL") . ", -- unit_cost
                " . ($total_cost ? "'$total_cost'" : "NULL") . ", -- total_cost
                '" . date('Y-m-d H:i:s') . "', -- last_updated_cost_at
                " . $last_updated_by_id . ", -- last_updated_by_id
                '" . $last_updated_by_name . "' -- last_updated_by_name
            );";

        // echo $query;die();
        
        mysqli_query($koneksi, $query);
    }

    function createDtlQuoShipmentHandlingCostsAdmin(
        $koneksi, 
        $id, 
        $sales_id, 
        $vm_id, 
        $handling_turunan, 
        $handling_description, 
        $quantity, 
        $unit_cost, 
        $total_cost, 
        $unit_budgeting, 
        $total_budgeting, 
        $unit_price, 
        $total_price, 
        $last_updated_by_id, 
        $last_updated_by_name
    )
    {
        $query = "INSERT INTO `dtl_quo_shipment_handling_costs`
            (
                `hd_quotation_id`,
                `created_at`,
                `updated_at`,
                `sales_id`,
                `vm_id`,
                `handling_turunan`,
                `handling_description`,
                `quantity`,
                `unit_cost`,
                `total_cost`,
                `unit_budgeting`,
                `total_budgeting`,
                `unit_price`,
                `total_price`,
                `last_updated_cost_at`,
                `last_updated_budgeting_at`,
                `last_updated_prices_at`,
                `last_updated_by_id`,
                `last_updated_by_name`
            ) VALUES (
                " . $id . ",
                '" . date('Y-m-d H:i:s') . "',
                '" . date('Y-m-d H:i:s') . "',
                " . ($sales_id ? "'$sales_id'" : "NULL") . ",
                " . ($vm_id ? "'$vm_id'" : "NULL") . ",
                " . ($handling_turunan ? "'$handling_turunan'" : "NULL") . ",
                " . ($handling_description ? "'$handling_description'" : "NULL") . ",
                " . ($quantity ? "'$quantity'" : 0) . ",
                " . ($unit_cost ? "'$unit_cost'" : 0) . ",
                " . ($total_cost ? "'$total_cost'" : 0) . ",
                " . ($unit_budgeting ? "'$unit_budgeting'" : 0) . ",
                " . ($total_budgeting ? "'$total_budgeting'" : 0) . ",
                " . ($unit_price ? "'$unit_price'" : 0) . ",
                " . ($total_price ? "'$total_price'" : 0) . ",
                '" . date('Y-m-d H:i:s') . "',
                '" . date('Y-m-d H:i:s') . "',
                '" . date('Y-m-d H:i:s') . "',
                " . $last_updated_by_id . ",
                '" . $last_updated_by_name . "'
            );";

        // echo $query;die();
        
        mysqli_query($koneksi, $query);
    }

    function createRequestCancelLog($koneksi, $status, $note, $userId, $hdQuotationId)
    {
        $state = 'S';
        $stmt = $koneksi->prepare("CALL sp_manage_request_cancel_quotation(?, ?, ?, ?, ?)");
    
        if (!$stmt) {
            die("Preparation failed: " . $koneksi->error);
        }

        $stmt->bind_param("ssssi", $state, $status, $note, $userId, $hdQuotationId);

        if (!$stmt->execute()) {
            die("Stored procedure execution failed: " . $stmt->error);
        }

        $stmt->close();

        return json_encode(['status' => 200, 'message' => 'Success']);
    }

    function updateFormHdQuoShipmentsSales($koneksi)
    {
        session_save_path('../../../tmp');
        session_start();

        $id = $_POST['id'];
        $sales_id = $_POST['sales_id'];
        $quo_status_id = $_POST['quo_status_id'];
        $vm_id = $_POST['vm_id'];
        $handling_id_1 = $_POST['handling_id_1'];
        $handling_name_1 = $_POST['handling_name_1'];
        $handling_qty_1 = $_POST['handling_qty_1'];
        $handling_unit_price_1 = isset($_POST['handling_unit_price_1']) ? $_POST['handling_unit_price_1'] : 0;
        $handling_total_price_1 = isset($_POST['handling_total_price_1']) ? $_POST['handling_total_price_1'] : 0;
        $handling_id_next = $_POST['handling_id_next'];
        $handling_name_next = $_POST['handling_name_next'];
        $handling_qty_next = $_POST['handling_qty_next'];
        $handling_unit_price_next = isset($_POST['handling_unit_price_next']) ? $_POST['handling_unit_price_next'] : 0;
        $handling_total_price_next = isset($_POST['handling_total_price_next']) ? $_POST['handling_total_price_next'] : 0;
        $last_updated_by_id = $_SESSION['id'];
        $last_updated_by_name = $_SESSION['nama'];
        $vendor_data = $_POST['vendor_data'];
        // print_r($_POST);die();

        $query = "UPDATE `hd_quo_shipments` SET 
                `quo_status_id` = '{$quo_status_id}', 
                `vm_id` = '{$vm_id}', 
                `updated_at` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name'
            WHERE `id` = $id;";
        // print_r($query);die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            $lastInsertedId = $koneksi->insert_id;
        }

        foreach ($vendor_data as $key => $value) {
            if ($value['dtl_quo_shipment_id'] != NULL) {
                updateDtlQuoShipment(
                    $koneksi, 
                    $value['dtl_quo_shipment_id'], 
                    $value['vendor_id'], 
                    $value['costing_first_price'] ?? 0, 
                    $value['costing_next_price'] ?? 0, 
                    $value['costing_total_price'] ?? 0, 
                    $value['budgeting_first_price'] ?? 0, 
                    $value['budgeting_next_price'] ?? 0, 
                    $value['budgeting_total_price'] ?? 0, 
                    $value['pricing_first_price'] ?? 0, 
                    $value['pricing_next_price'] ?? 0, 
                    $value['pricing_total_price'] ?? 0, 
                    $last_updated_by_id
                );
            } else {
                if ($value['vendor_id'] != NULL) {
                    createDtlQuoShipment(
                        $koneksi, 
                        $id, 
                        $value['vendor_id'], 
                        $value['costing_first_price'] ?? 0, 
                        $value['costing_next_price'] ?? 0, 
                        $value['costing_total_price'] ?? 0, 
                        $value['budgeting_first_price'] ?? 0, 
                        $value['budgeting_next_price'] ?? 0, 
                        $value['budgeting_total_price'] ?? 0, 
                        $value['pricing_first_price'] ?? 0, 
                        $value['pricing_next_price'] ?? 0, 
                        $value['pricing_total_price'] ?? 0, 
                        $last_updated_by_id
                    );
                }
            }
        }

        if ($handling_qty_1 > 0) {
            if ($handling_id_1 == null) {
                createDtlQuoShipmentHandlingCostsSales(
                    $koneksi, 
                    $id, 
                    $sales_id, 
                    $vm_id, 
                    1, 
                    $handling_name_1, 
                    $handling_qty_1, 
                    $handling_unit_price_1, 
                    $handling_total_price_1, 
                    $last_updated_by_id, 
                    $last_updated_by_name
                );
            } else {
                updateDtlQuoShipmentHandlingCostsSales(
                    $koneksi, 
                    $handling_id_1, 
                    $handling_name_1, 
                    $handling_qty_1,  
                    $handling_unit_price_1,
                    $handling_total_price_1, 
                    $last_updated_by_id, 
                    $last_updated_by_name
                );
            }
        }
        if ($handling_qty_next > 0) {
            if ($handling_id_next == null) {
                createDtlQuoShipmentHandlingCostsSales(
                    $koneksi, 
                    $id, 
                    $sales_id, 
                    $vm_id, 
                    2, 
                    $handling_name_next, 
                    $handling_qty_next, 
                    $handling_unit_price_next, 
                    $handling_total_price_next, 
                    $last_updated_by_id, 
                    $last_updated_by_name
                );
            } else {
                updateDtlQuoShipmentHandlingCostsSales(
                    $koneksi, 
                    $handling_id_next, 
                    $handling_name_next, 
                    $handling_qty_next,
                    $handling_unit_price_next, 
                    $handling_total_price_next, 
                    $last_updated_by_id, 
                    $last_updated_by_name
                );
            }
        }

        return json_encode(['status' => 200, 'data' => $lastInsertedId, 'message' => 'Success']);
    }

    function updateFormHdQuoShipmentsVM($koneksi)
    {
        session_save_path('../../../tmp');
        session_start();

        $id = $_POST['id'];
        $sales_id = $_POST['sales_id'];
        $quo_status_id = $_POST['quo_status_id'];
        $vm_id = $_POST['vm_id'];
        $handling_id_1 = $_POST['handling_id_1'];
        $handling_name_1 = $_POST['handling_name_1'];
        $handling_qty_1 = $_POST['handling_qty_1'];
        $handling_unit_cost_1 = $_POST['handling_unit_cost_1'];
        $handling_total_cost_1 = $_POST['handling_total_cost_1'];
        $handling_id_next = $_POST['handling_id_next'];
        $handling_name_next = $_POST['handling_name_next'];
        $handling_qty_next = $_POST['handling_qty_next'];
        $handling_unit_cost_next = $_POST['handling_unit_cost_next'];
        $handling_total_cost_next = $_POST['handling_total_cost_next'];
        $last_updated_by_id = $_SESSION['id'];
        $last_updated_by_name = $_SESSION['nama'];
        $vendor_data = $_POST['vendor_data'];
        $selected_quo_vendor_id = $_POST['selected_quo_vendor_id'];

        if ($_POST['selected_quo_vendor_id'] != null) {
            $quo_status_id = 10;
        }
        // print_r($_POST);die();

        $query = "UPDATE `hd_quo_shipments` SET 
                `quo_status_id` = '{$quo_status_id}', 
                `vm_id` = '{$vm_id}', 
                `updated_at` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name',
                `selected_quo_vendor_id` = '$selected_quo_vendor_id'
            WHERE `id` = $id;";
        // print_r($query);die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            $lastInsertedId = $koneksi->insert_id;
        }

        foreach ($vendor_data as $key => $value) {
            if ($value['dtl_quo_shipment_id'] != NULL) {
                updateDtlQuoShipment(
                    $koneksi, 
                    $value['dtl_quo_shipment_id'], 
                    $value['vendor_id'], 
                    $value['costing_first_price'] ?? 0, 
                    $value['costing_next_price'] ?? 0, 
                    $value['costing_total_price'] ?? 0, 
                    $value['budgeting_first_price'] ?? 0, 
                    $value['budgeting_next_price'] ?? 0, 
                    $value['budgeting_total_price'] ?? 0, 
                    $value['pricing_first_price'] ?? 0, 
                    $value['pricing_next_price'] ?? 0, 
                    $value['pricing_total_price'] ?? 0, 
                    $last_updated_by_id
                );
            } else {
                if ($value['vendor_id'] != NULL) {
                    createDtlQuoShipment(
                        $koneksi, 
                        $id, 
                        $value['vendor_id'], 
                        $value['costing_first_price'] ?? 0, 
                        $value['costing_next_price'] ?? 0, 
                        $value['costing_total_price'] ?? 0, 
                        $value['budgeting_first_price'] ?? 0, 
                        $value['budgeting_next_price'] ?? 0, 
                        $value['budgeting_total_price'] ?? 0, 
                        $value['pricing_first_price'] ?? 0, 
                        $value['pricing_next_price'] ?? 0, 
                        $value['pricing_total_price'] ?? 0, 
                        $last_updated_by_id
                    );
                }
            }
        }

        if ($handling_qty_1 > 0) {
            if ($handling_id_1 == null) {
                createDtlQuoShipmentHandlingCostsVM(
                    $koneksi, 
                    $id, 
                    $sales_id, 
                    $vm_id, 
                    1, 
                    $handling_name_1, 
                    $handling_qty_1, 
                    $handling_unit_cost_1, 
                    $handling_total_cost_1, 
                    $last_updated_by_id, 
                    $last_updated_by_name
                );
            } else {
                updateDtlQuoShipmentHandlingCostsVM(
                    $koneksi, 
                    $handling_id_1, 
                    $handling_name_1, 
                    $handling_qty_1,  
                    $handling_unit_cost_1,
                    $handling_total_cost_1, 
                    $last_updated_by_id, 
                    $last_updated_by_name
                );
            }
        }
        if ($handling_qty_next > 0) {
            if ($handling_id_next == null) {
                createDtlQuoShipmentHandlingCostsVM(
                    $koneksi, 
                    $id, 
                    $sales_id, 
                    $vm_id, 
                    2, 
                    $handling_name_next, 
                    $handling_qty_next, 
                    $handling_unit_cost_next, 
                    $handling_total_cost_next, 
                    $last_updated_by_id, 
                    $last_updated_by_name
                );
            } else {
                updateDtlQuoShipmentHandlingCostsVM(
                    $koneksi, 
                    $handling_id_next, 
                    $handling_name_next, 
                    $handling_qty_next,
                    $handling_unit_cost_next, 
                    $handling_total_cost_next, 
                    $last_updated_by_id, 
                    $last_updated_by_name
                );
            }
        }

        return json_encode(['status' => 200, 'data' => $lastInsertedId, 'message' => 'Success']);
    }

    function updateFormHdQuoShipmentsAdmin($koneksi)
    {
        session_save_path('../../../tmp');
        session_start();

        $id = $_POST['id'];
        $freight_cost = $_POST['freight_cost'];
        $currency_date = $_POST['currency_date'];
        $currency_rate = $_POST['currency_rate'];
        $handling_id_1 = $_POST['handling_id_1'];
        $handling_name_1 = $_POST['handling_name_1'];
        $handling_qty_1 = $_POST['handling_qty_1'];
        $handling_unit_cost_1 = $_POST['handling_unit_cost_1'];
        $handling_total_cost_1 = $_POST['handling_total_cost_1'];
        $handling_unit_budgeting_1 = isset($_POST['handling_unit_budgeting_1']) ? $_POST['handling_unit_budgeting_1'] : 0;
        $handling_total_budgeting_1 = isset($_POST['handling_total_budgeting_1']) ? $_POST['handling_total_budgeting_1'] : 0;
        $handling_unit_price_1 = isset($_POST['handling_unit_price_1']) ? $_POST['handling_unit_price_1'] : 0;
        $handling_total_price_1 = isset($_POST['handling_total_price_1']) ? $_POST['handling_total_price_1'] : 0;
        $handling_id_next = $_POST['handling_id_next'];
        $handling_name_next = $_POST['handling_name_next'];
        $handling_qty_next = $_POST['handling_qty_next'];
        $handling_unit_cost_next = $_POST['handling_unit_cost_next'];
        $handling_total_cost_next = $_POST['handling_total_cost_next'];
        $handling_unit_budgeting_next = isset($_POST['handling_unit_budgeting_next']) ? $_POST['handling_unit_budgeting_next'] : 0;
        $handling_total_budgeting_next = isset($_POST['handling_total_budgeting_next']) ? $_POST['handling_total_budgeting_next'] : 0;
        $handling_unit_price_next = isset($_POST['handling_unit_price_next']) ? $_POST['handling_unit_price_next'] : 0;
        $handling_total_price_next = isset($_POST['handling_total_price_next']) ? $_POST['handling_total_price_next'] : 0;
        $vendor_data = $_POST['vendor_data'];
        $selected_quo_vendor_id = $_POST['selected_quo_vendor_id'];
        $last_updated_by_id = $_SESSION['id'];
        $last_updated_by_name = $_SESSION['nama'];
        $quo_status_id = $_POST['quo_status_id'];
        if ($_POST['selected_quo_vendor_costing'] > 0) {
            $quo_status_id = 6;
        }
        if ($_POST['selected_quo_vendor_budgeting'] > 0) {
            $quo_status_id = 7;
        }
        if ($_POST['selected_quo_vendor_pricing'] > 0) {
            $quo_status_id = 8;
        }
        if ($_POST['selected_quo_vendor_id'] != null) {
            $quo_status_id = 10;
        }
        // print_r($_POST);die();

        $query = "UPDATE `hd_quo_shipments` SET 
                `quo_status_id` = $quo_status_id, 
                `freight_cost` = " . ($freight_cost ? "'$freight_cost'" : "NULL") . ",
                `currency_date` = " . ($currency_date ? "'$currency_date'" : "NULL") . ",
                `currency_rate` = " . ($currency_rate ? "'$currency_rate'" : "NULL") . ",
                `updated_at` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name',
                `selected_quo_vendor_id` = '$selected_quo_vendor_id'
            WHERE `id` = $id;";
        // print_r($query);die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            $lastInsertedId = $koneksi->insert_id;
        }

        foreach ($vendor_data as $key => $value) {
            updateDtlQuoShipment(
                $koneksi, 
                $value['dtl_quo_shipment_id'], 
                $value['vendor_id'], 
                $value['costing_first_price'], 
                $value['costing_next_price'], 
                $value['costing_total_price'], 
                $value['budgeting_first_price'], 
                $value['budgeting_next_price'], 
                $value['budgeting_total_price'], 
                $value['pricing_first_price'], 
                $value['pricing_next_price'], 
                $value['pricing_total_price'], 
                $last_updated_by_id
            );
        }

        if ($handling_qty_1 > 0) {
            updateDtlQuoShipmentHandlingCostsAdmin(
                $koneksi, 
                $handling_id_1, 
                $handling_name_1, 
                $handling_qty_1, 
                $handling_unit_cost_1, 
                $handling_total_cost_1, 
                $handling_unit_budgeting_1, 
                $handling_total_budgeting_1, 
                $handling_unit_price_1, 
                $handling_total_price_1, 
                $last_updated_by_id, 
                $last_updated_by_name
            );
        }
        if ($handling_qty_next > 0) {
            updateDtlQuoShipmentHandlingCostsAdmin(
                $koneksi, 
                $handling_id_next, 
                $handling_name_next, 
                $handling_qty_next, 
                $handling_unit_cost_next, 
                $handling_total_cost_next,
                $handling_unit_budgeting_next, 
                $handling_total_budgeting_next, 
                $handling_unit_price_next, 
                $handling_total_price_next,  
                $last_updated_by_id, 
                $last_updated_by_name
            );
        }

        return json_encode(['status' => 200, 'data' => $lastInsertedId, 'message' => 'Success']);
    }

    function updateDtlQuoShipment($koneksi, $id, $vendor_id, $costing_first_price, $costing_next_price, $costing_total_price, $budgeting_first_price, $budgeting_next_price, $budgeting_total_price, $pricing_first_price, $pricing_next_price, $pricing_total_price, $last_updated_by_id)
    {
        $queryDtlQuoShipment = "UPDATE `dtl_quo_shipment` SET 
                `vendor_id` = $vendor_id, 
                `costing_first_price` = $costing_first_price,
                `costing_next_price` = $costing_next_price,
                `costing_total_price` = $costing_total_price,
                `budgeting_first_price` = $budgeting_first_price,
                `budgeting_next_price` = $budgeting_next_price,
                `budgeting_total_price` = $budgeting_total_price,
                `pricing_first_price` = $pricing_first_price,
                `pricing_next_price` = $pricing_next_price,
                `pricing_total_price` = $pricing_total_price,
                `last_updated_by_id` = '$last_updated_by_id'
            WHERE `id` = $id;";
        // print_r($queryDtlQuoShipment);die();

        $resultDtlQuoShipment = mysqli_query($koneksi, $queryDtlQuoShipment);

        if (!$resultDtlQuoShipment) {
            die("Query failed: " . mysqli_error($koneksi));
        }
    }

    function updateDtlQuoShipmentHandlingCostsAdmin(
        $koneksi, 
        $id, 
        $handling_description, 
        $quantity, 
        $unit_cost, 
        $total_cost, 
        $unit_budgeting, 
        $total_budgeting, 
        $unit_price, 
        $total_price, 
        $last_updated_by_id, 
        $last_updated_by_name
    )
    {
        $queryDtlQuoShipment = queryUpdateDtlQuoHandlingCostsAdmin($id, $handling_description, $quantity, $unit_cost, $total_cost, $unit_budgeting, $total_budgeting, $unit_price, $total_price, $last_updated_by_id, $last_updated_by_name);
        // print_r($queryDtlQuoShipment);die();

        $resultDtlQuoShipment = mysqli_query($koneksi, $queryDtlQuoShipment);

        if (!$resultDtlQuoShipment) {
            die("Query failed: " . mysqli_error($koneksi));
        }
    }

    function queryUpdateDtlQuoHandlingCostsAdmin(
        $id, 
        $handling_description, 
        $quantity, 
        $unit_cost, 
        $total_cost, 
        $unit_budgeting, 
        $total_budgeting, 
        $unit_price, 
        $total_price, 
        $last_updated_by_id, 
        $last_updated_by_name
    )
    {
        return "UPDATE `dtl_quo_shipment_handling_costs` SET 
                `handling_description` = '$handling_description',
                `quantity` = $quantity,
                `unit_cost` = $unit_cost,
                `total_cost` = $total_cost,
                `unit_budgeting` = $unit_budgeting,
                `total_budgeting` = $total_budgeting,
                `unit_price` = $unit_price,
                `total_price` = $total_price,
                `last_updated_budgeting_at` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_prices_at` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name'
            WHERE `id` = $id;";
    }

    function updateDtlQuoShipmentHandlingCostsSales(
        $koneksi, 
        $id, 
        $handling_description, 
        $quantity,
        $unit_price, 
        $total_price, 
        $last_updated_by_id, 
        $last_updated_by_name
    )
    {
        $queryDtlQuoShipment = queryUpdateDtlQuoHandlingCostsSales($id, $handling_description, $quantity, $unit_price, $total_price, $last_updated_by_id, $last_updated_by_name);
        // print_r($queryDtlQuoShipment);die();

        $resultDtlQuoShipment = mysqli_query($koneksi, $queryDtlQuoShipment);

        if (!$resultDtlQuoShipment) {
            die("Query failed: " . mysqli_error($koneksi));
        }
    }

    function queryUpdateDtlQuoHandlingCostsSales(
        $id, 
        $handling_description, 
        $quantity,
        $unit_price, 
        $total_price, 
        $last_updated_by_id, 
        $last_updated_by_name
    )
    {
        return "UPDATE `dtl_quo_shipment_handling_costs` SET 
                `handling_description` = '$handling_description',
                `quantity` = $quantity,
                `unit_price` = $unit_price,
                `total_price` = $total_price,
                `last_updated_prices_at` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name'
            WHERE `id` = $id;";
    }

    function updateDtlQuoShipmentHandlingCostsVM(
        $koneksi, 
        $id, 
        $handling_description, 
        $quantity,
        $unit_cost, 
        $total_cost, 
        $last_updated_by_id, 
        $last_updated_by_name
    )
    {
        $queryDtlQuoShipment = queryUpdateDtlQuoHandlingCostsVM($id, $handling_description, $quantity, $unit_cost, $total_cost, $last_updated_by_id, $last_updated_by_name);
        // print_r($queryDtlQuoShipment);die();

        $resultDtlQuoShipment = mysqli_query($koneksi, $queryDtlQuoShipment);

        if (!$resultDtlQuoShipment) {
            die("Query failed: " . mysqli_error($koneksi));
        }
    }

    function queryUpdateDtlQuoHandlingCostsVM(
        $id, 
        $handling_description, 
        $quantity,
        $unit_cost, 
        $total_cost, 
        $last_updated_by_id, 
        $last_updated_by_name
    )
    {
        return "UPDATE `dtl_quo_shipment_handling_costs` SET 
                `handling_description` = '$handling_description',
                `quantity` = $quantity,
                `unit_cost` = $unit_cost,
                `total_cost` = $total_cost,
                `last_updated_cost_at` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name'
            WHERE `id` = $id;";
    }

    function updateBudgetingQuotationDetailShipment($koneksi, $hdQuotationId)
    {
        $stmt = $koneksi->prepare("CALL update_budgeting_quotation_detail_shipment(?)");
        $stmt->bind_param("i", $hdQuotationId);

        if (!$stmt->execute()) {
            die("Stored procedure execution failed: " . $stmt->error);
        }

        $stmt->close();

        return json_encode(['status' => 200, 'message' => 'Success']);
    }

    function updateHdQuoShipmentsReqCancel($koneksi, $hdQuotationId)
    {
        session_save_path('../../../tmp');
        session_start();

        $id = $_POST['id'];
        $reason_request_cancel = $_POST['reason_request_cancel'];
        $last_updated_by_id = $_SESSION['id'];
        $last_updated_by_name = $_SESSION['nama'];
        // print_r($_POST);die();

        $query = "UPDATE `hd_quo_shipments` SET 
                `quo_status_id` = 12, 
                `updated_at` = '" . date('Y-m-d H:i:s') . "',
                `request_cancel_date` = '" . date('Y-m-d H:i:s') . "',
                `reason_request_cancel` = '$reason_request_cancel',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name'
            WHERE `id` = $id;";
        // print_r($query);die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            createRequestCancelLog($koneksi, 'Q', $reason_request_cancel, $last_updated_by_id, $id);
            return json_encode(['status' => 200, 'message' => 'Success']);
        } else {
            return json_encode(['status' => 500, 'message' => 'Failed']);

        }

    }

    function updateHdQuoShipmentsSales($koneksi, $hdQuotationId)
    {
        session_save_path('../../../tmp');
        session_start();

        $id = $_POST['id'];
        $sales_id = $_POST['sales_id'];
        $last_updated_by_id = $_SESSION['id'];
        $last_updated_by_name = $_SESSION['nama'];
        // print_r($_POST);die();

        $query = "UPDATE `hd_quo_shipments` SET 
                `sales_id` = '$sales_id', 
                `updated_at` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name'
            WHERE `id` = $id;";
        // print_r($query);die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            return json_encode(['status' => 200, 'message' => 'Success']);
        } else {
            return json_encode(['status' => 500, 'message' => 'Failed']);

        }

    }

    function updateHdQuoShipmentsVM($koneksi, $hdQuotationId)
    {
        session_save_path('../../../tmp');
        session_start();

        $id = $_POST['id'];
        $vm_id = $_POST['vm_id'];
        $last_updated_by_id = $_SESSION['id'];
        $last_updated_by_name = $_SESSION['nama'];
        // print_r($_POST);die();

        $query = "UPDATE `hd_quo_shipments` SET 
                `vm_id` = '{$vm_id}', 
                `updated_at` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name'
            WHERE `id` = $id;";
        // print_r($query);die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            return json_encode(['status' => 200, 'message' => 'Success']);
        } else {
            return json_encode(['status' => 500, 'message' => 'Failed']);

        }

    }

    function updateHdQuoShipmentsApproveCancel($koneksi, $hdQuotationId)
    {
        session_save_path('../../../tmp');
        session_start();

        $id = $_POST['id'];
        $last_updated_by_id = $_SESSION['id'];
        $last_updated_by_name = $_SESSION['nama'];
        // print_r($_POST);die();

        $query = "UPDATE `hd_quo_shipments` SET 
                `quo_status_id` = 13, 
                `updated_at` = '" . date('Y-m-d H:i:s') . "',
                `approved_request_date` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name'
            WHERE `id` = $id;";
        // print_r($query);die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            createRequestCancelLog($koneksi, 'A', '-', $last_updated_by_id, $id);
            return json_encode(['status' => 200, 'message' => 'Success']);
        } else {
            return json_encode(['status' => 500, 'message' => 'Failed']);

        }

    }

    function updateHdQuoShipmentsRejectCancel($koneksi, $hdQuotationId)
    {
        session_save_path('../../../tmp');
        session_start();

        $id = $_POST['id'];
        $last_updated_by_id = $_SESSION['id'];
        $last_updated_by_name = $_SESSION['nama'];
        // print_r($_POST);die();

        $query = "UPDATE `hd_quo_shipments` SET 
                `quo_status_id` = 9, 
                `updated_at` = '" . date('Y-m-d H:i:s') . "',
                `approved_request_date` = '" . date('Y-m-d H:i:s') . "',
                `last_updated_by_id` = '$last_updated_by_id',
                `last_updated_by_name` = '$last_updated_by_name'
            WHERE `id` = $id;";
        // print_r($query);die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            createRequestCancelLog($koneksi, 'R', '-', $last_updated_by_id, $id);
            return json_encode(['status' => 200, 'message' => 'Success']);
        } else {
            return json_encode(['status' => 500, 'message' => 'Failed']);

        }

    }

    switch ($_POST['method']) {
        case 'createHdQuoShipmentsSales':
            $resp = createHdQuoShipmentsSales($koneksi);
            echo $resp;
            break;
        case 'createHdQuoShipmentsAdmin':
            $resp = createHdQuoShipmentsAdmin($koneksi);
            echo $resp;
            break;
        case 'updateFormHdQuoShipmentsSales':
            $resp = updateFormHdQuoShipmentsSales($koneksi);
            echo $resp;
            break;
        case 'updateFormHdQuoShipmentsVM':
            $resp = updateFormHdQuoShipmentsVM($koneksi);
            echo $resp;
            break;
        case 'updateFormHdQuoShipmentsAdmin':
            $resp = updateFormHdQuoShipmentsAdmin($koneksi);
            echo $resp;
            break;
        case 'updateBudgetingQuotationDetailShipment':
            $resp = updateBudgetingQuotationDetailShipment($koneksi, $_POST['hdQuotationId']);
            echo $resp;
            break;
        case 'updateHdQuoShipmentsReqCancel':
            $resp = updateHdQuoShipmentsReqCancel($koneksi, $_POST['id']);
            echo $resp;
            break;
        case 'updateHdQuoShipmentsSales':
            $resp = updateHdQuoShipmentsSales($koneksi, $_POST['id']);
            echo $resp;
            break;
        case 'updateHdQuoShipmentsVM':
            $resp = updateHdQuoShipmentsVM($koneksi, $_POST['id']);
            echo $resp;
            break;
        case 'updateHdQuoShipmentsApproveCancel':
            $resp = updateHdQuoShipmentsApproveCancel($koneksi, $_POST['id']);
            echo $resp;
            break;
        case 'updateHdQuoShipmentsRejectCancel':
            $resp = updateHdQuoShipmentsRejectCancel($koneksi, $_POST['id']);
            echo $resp;
            break;
    }
    switch ($_GET['method']) {
        case 'getHdQuoShipments':
            $resp = getHdQuoShipments($koneksi);
            echo $resp;
            break;
        case 'getHdQuoShipmentDetails':
            $resp = getHdQuoShipmentDetails($koneksi);
            echo $resp;
            break;
        case 'getCheckCustomerCode':
            $resp = getCheckCustomerCode($koneksi);
            echo $resp;
            break;
    }
?>
