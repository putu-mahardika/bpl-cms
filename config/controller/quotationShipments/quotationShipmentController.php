<?php
    include '../../koneksi.php';
    date_default_timezone_set("Asia/Jakarta");
    $datetime = date('Y-m-d H:i:s');
    $year = date('Y', strtotime($datetime));
    session_save_path('../../../../tmp');
    session_start();
    //$s_username = $_SESSION['username'];
    $s_id = $_SESSION['id'];
    $s_name = $_SESSION['nama'];
    $akses = $_SESSION['hak_akses'];

    function getCustomers($koneksi, $s_id)
    {
        $query = "SELECT * FROM master_customer where UserId = '.$s_id.' ";
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
        $query = "SELECT 
                hqs.*,
                DATE_FORMAT(hqs.created_at, '%d-%m-%Y %H:%i:%s') as `created_at`,
                CASE
                    WHEN hqs.customer_id IS NULL THEN hqs.customer_name_temp ELSE mc.nama
                END AS `customer_name`,
                hqs.pic_name_temp as `pic_name_temp`,
                hqs.pic_phone_temp as `pic_phone_temp`,
                mqs.name as `status`,
                mqs.color as `status_color`,
                mn_o.Nama as `origin_country_name`,
                mu.nama as `jenis_container`
            FROM hd_quo_shipments as hqs
            LEFT JOIN master_quo_status as mqs ON hqs.quo_status_id = mqs.id
            LEFT JOIN master_negara as mn_o ON hqs.origin_country_id = mn_o.id
            LEFT JOIN master_customer mc on hqs.customer_id = mc.CustId
            LEFT JOIN master_unit mu on hqs.master_unit_id = mu.id
        ";
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
                CASE
                    WHEN hqs.customer_id IS NULL THEN hqs.customer_name_temp ELSE mc.nama
                END AS `customer_name`,
                hqs.pic_name_temp as `pic_name_temp`,
                hqs.pic_phone_temp as `pic_phone_temp`,
                mqs.name as `status`,
                mqs.color as `status_color`,
                mn_o.Nama as `origin_country_name`,
                mn_d.Nama as `destination_country_name`,
                mu.id as `master_unit_id`,
                mu.nama as `master_unit_name`,
                musr.UserId as `sales_id`,
                musr.nama as `sales_name`,
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

        echo json_encode($data);
    }

    function createHdQuoShipments($koneksi)
    {
        $customer_id = isset($_POST['customer_id']) ? $_POST['customer_id'] : null;
        $sales_id = $_POST['sales_id'];
        $total_container = $_POST['total_container'];
        $item_description = $_POST['item_description'];
        $vm_id = $_POST['vm_id'];
        $quo_status_id = $_POST['quo_status_id'];
        $customer_name_temp = $_POST['customer_name_temp'];
        $customer_address_temp = $_POST['customer_address_temp'];
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
                NULL, -- selected_quo_vendor_id
                NULL, -- freight_cost
                NULL, -- currency_date
                NULL, -- currency_rate
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
                NULL, -- last_updated_by_id
                NULL  -- last_updated_by_name
            );";

        // echo $query;die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            $lastInsertedId = $koneksi->insert_id;
        }

        return json_encode(['status' => 200, 'data' => $lastInsertedId, 'message' => 'Success']);
    }

    function updateHdQuoShipments($koneksi)
    {
        $id = $_POST['id'];
        // print_r($_POST);die();

        $query = "UPDATE `hd_quo_shipments` SET `quo_status_id` = 2 WHERE `id` = $id;";
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            $lastInsertedId = $koneksi->insert_id;
        }

        $queryArray = array();

        foreach ($_POST['vendor_data'] as $key => $value) {
            array_push($queryArray, "('$id', '{$value['vendor_id']}', '{$value['vendor_price_1st']}', '{$value['vendor_price_next']}', '{$value['vendor_price_total']}')");
        }

        $queryDtlQuoShipment = "INSERT INTO `dtl_quo_shipment`
            (
            `hd_quotation_id`,
            `vendor_id`,
            `costing_first_price`,
            `costing_next_price`,
            `costing_total_price`
            ) VALUES";
        // print_r($queryDtlQuoShipment);die();

        $queryDtlQuoShipment .= implode(', ', $queryArray);

        $resultDtlQuoShipment = mysqli_query($koneksi, $queryDtlQuoShipment);


        if (!$resultDtlQuoShipment) {
            die("Query failed: " . mysqli_error($koneksi));
        }

        return json_encode(['status' => 200, 'data' => $lastInsertedId, 'message' => 'Success']);
    }
    switch ($_POST['method']) {
        case 'createHdQuoShipments':
            $resp = createHdQuoShipments($koneksi);
            echo $resp;
            break;
        case 'updateHdQuoShipments':
            $resp = updateHdQuoShipments($koneksi);
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
    }
?>
