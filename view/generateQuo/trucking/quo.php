<?php 
    include '../../../config/koneksi.php';
    date_default_timezone_set("Asia/Jakarta");
    $datetime = date('Y-m-d H:i:s');
    $year = date('Y', strtotime($datetime));
    session_save_path('../../../tmp');
    session_start();
    //$s_username = $_SESSION['username'];
    $s_id = $_SESSION['id'];
    $s_name = $_SESSION['nama'];
    $akses = $_SESSION['hak_akses'];
    $noQuo = $_GET['quo'];

    $queryTemplate = "SELECT val FROM `global_setting` WHERE Code='TQUO'";
    $fetchTemplate = mysqli_query($koneksi, $queryTemplate);
    $dataTemplate = mysqli_fetch_array($fetchTemplate);
    $template = $dataTemplate['val']; 

    $query = "SELECT * FROM `vw_quotation_trucking` WHERE NoQuotation='".$noQuo."';";
    $fetch = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($fetch);

    $template = str_replace('{{ quotation_number }}', $data['NoQuotation'], $template);
    $template = str_replace('{{ quotation_date }}', (date("d-m-Y", strtotime($data['create_date']))), $template);
    $template = str_replace('{{ client_name }}', $data['Company_Pic'], $template);
    $template = str_replace('{{ client_company }}', $data['nama'], $template);
    $template = str_replace('{{ keterangan }}', $data['note'], $template);
    $template = str_replace('{{ total_armada }}', $data['TotalArmada'], $template);
    $template = str_replace('{{ total_berat }}', $data['Weight'], $template);
    $template = str_replace('{{ harga }}', $data['PricingFirstPrice'], $template);
    $template = str_replace('{{ total_harga }}', $data['PricingTotalPrice'], $template);

    $table = '';
    if ($data['TripType'] == 'singleTrip') {
        $table = '<div class="trip-section">
            <p><strong>Single Trip</strong></p>
            <table>
                <thead>
                    <tr>
                        <th>Jenis Kendaraan</th>
                        <th>Pickup</th>
                        <th>Destination</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$data['Jenis_kendaraan'].'</td>
                        <td>'.$data['pickup_city'].'</td>
                        <td>'.$data['delivery_city_1'].'</td>
                    </tr>
                </tbody>
            </table>
        </div>';
    } elseif ($data['TripType'] == 'multiTrip') {
        $table = '<div class="trip-section">
            <p><strong>Multi Trip</strong></p>
            <table>
                <thead>
                    <tr>
                        <th>Jenis Kendaraan</th>
                        <th>Pickup</th>
                        <th>Destination 1</th>
                        <th>Destination 2</th>
                        <th>Destination 3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$data['Jenis_kendaraan'].'</td>
                        <td>'.$data['pickup_city'].'</td>
                        <td>'.$data['delivery_city_1'].'</td>
                        <td>'.$data['delivery_city_2'].'</td>
                        <td>'.$data['delivery_city_3'].'</td>
                    </tr>
                </tbody>
            </table>
        </div>';
    } else {
        $table = '<div class="trip-section">
            <p><strong>KGM/CBM Trip</strong></p>
            <table>
                <thead>
                    <tr>
                        <th>Jenis Kendaraan</th>
                        <th>Pickup</th>
                        <th>Destination</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'.$data['Jenis_kendaraan'].'</td>
                        <td>'.$data['pickup_city'].'</td>
                        <td>'.$data['delivery_city_1'].'</td>
                    </tr>
                </tbody>
            </table>
        </div>';
    }
    $template = str_replace('{{ TripType }}', $table, $template);

    // print_r($data);

    echo $template;
?>

