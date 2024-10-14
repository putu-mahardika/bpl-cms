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
    $template = str_replace('{{ quotation_number }}', $data['NoQuotation'] ?? '-', $template);
    $template = str_replace('{{ quotation_date }}', $data['create_date'] ? (date("d-m-Y", strtotime($data['create_date']))) : '-', $template);
    $template = str_replace('{{ client_name }}', $data['Company_Pic'] ?? '-', $template);
    $template = str_replace('{{ client_company }}', $data['Company_Name'] ?? '-', $template);
    $template = str_replace('{{ keterangan }}', $data['note'] ?? '-', $template);
    $template = str_replace('{{ total_armada }}', $data['TotalArmada'] ?? '0', $template);
    $template = str_replace('{{ total_berat }}', $data['Weight'] ?? '0', $template);
    $template = str_replace('{{ harga }}', $data['PricingFirstPrice'] ? number_format($data['PricingFirstPrice'],2,",",".") : '0', $template);
    $template = str_replace('{{ total_harga }}', $data['PricingTotalPrice'] ? number_format($data['PricingTotalPrice'],2,",",".") : '0', $template);
    $template = str_replace('{{ sales_name }}', $data['sales_name'] ?? '-', $template);
    $template = str_replace('{{ terms_payment }}', $data['TermsPayamnet'] ?? '0', $template);

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

    // echo $template;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* CSS tambahan untuk merapikan tabel agar muat dalam satu layar */
        .container {
            max-width: 1000px; /* Lebar maksimal diperbesar */
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            font-size: 13px; /* Ukuran font sedikit diperkecil agar lebih muat */
        }
        th, td {
            padding: 8px; /* Padding dikurangi untuk menjaga jarak */
            text-align: center; /* Teks rata tengah untuk tampilan yang lebih simetris */
        }
        th {
            background-color: #f8f8f8;
            font-weight: bold;
        }
        .notes {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php echo $template ?>
</body>
</html>

