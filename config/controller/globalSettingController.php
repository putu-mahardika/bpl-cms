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

    function getData($koneksi, $code)
    {
        $query = "SELECT * FROM global_setting where Code = '$code'";
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
        $code = $_POST['code'];
        $val = $_POST['val'];
        $description = $_POST['description'];
        $query = "INSERT INTO `global_setting` (
                `Code`,
                `val`,
                `description`,
                `create_date`,
                `last_update`
            ) VALUES (
                '" . $code . "',
                '" . $val . "',
                '" . $description . "',
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
