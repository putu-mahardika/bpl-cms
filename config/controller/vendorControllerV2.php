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

    function getData($koneksi)
    {
        $query = "SELECT * FROM master_vendor  where isActive=1 and isDelete=0";
        $result = mysqli_query($koneksi, $query);
        
        if (!$result) {
            die("Query failed: " . mysqli_error($koneksi));
        }
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data = $row;
        }
        
        return $data;
    }

    function createData($koneksi)
    {
        $kode = $_POST['kode'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $npwp = $_POST['npwp'];
        $pic = $_POST['pic'];
        $pic_telp = $_POST['pic_telp'];
        $type = $_POST['type'];
        $delivery_type = $_POST['delivery_type'];
        $link = $_POST['link'];
        $note = $_POST['note'];

        $query = "INSERT INTO `master_vendor` (
                `kode`,
                `nama`,
                `alamat`,
                `npwp`,
                `pic`,
                `pic_telp`,
                `type`,
                `delivery_type`,
                `link`,
                `note`,
                `create_date`,
                `last_update`
            ) VALUES (
                '" . $kode . "',
                '" . $nama . "',
                '" . $alamat . "',
                '" . $npwp . "',
                '" . $pic . "',
                '" . $pic_telp . "',
                '" . $type . "',
                '" . $delivery_type . "',
                '" . $link . "',
                '" . $note . "',
                '" . date('Y-m-d H:i:s') . "',
                '" . date('Y-m-d H:i:s') . "'
            );";

        // echo $query;die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            $lastInsertedId = $koneksi->insert_id;
            return json_encode(['status' => 200, 'data' => $lastInsertedId, 'message' => 'Success']);
        } else {
            return json_encode(['status' => 500, 'data' => null, 'message' => 'Failed']);
        }

    }

    function updateData($koneksi, $code)
    {
        session_save_path('../../../tmp');
        session_start();

        $code = $_POST['code'];
        $val = $_POST['val'];
        $description = $_POST['description'];
        $query = "UPDATE `global_setting` SET 
                `val` = '{$val}',
                `description` = '{$description}'
            WHERE `Code` = '{$code}';";
        // print_r($query);die();
        
        $result = mysqli_query($koneksi, $query);
        
        if($result) {
            $lastInsertedId = $koneksi->insert_id;
            return json_encode(['status' => 200, 'data' => $lastInsertedId, 'message' => 'Success']);
        } else {
            return json_encode(['status' => 500, 'data' => null, 'message' => 'Failed']);
        }

    }

    switch ($_POST['method']) {
        case 'createData':
            $resp = createData($koneksi);
            echo $resp;
            break;
        case 'updateData':
            $resp = updateData($koneksi, $code);
            echo $resp;
            break;
    }
?>
