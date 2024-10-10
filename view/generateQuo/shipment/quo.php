<?php 
    include '../../../config/koneksi.php';
    date_default_timezone_set("Asia/Jakarta");
    $datetime = date('Y-m-d H:i:s');
    $year = date('Y', strtotime($datetime));
    session_save_path('../../../tmp');
    session_start();
    include '../../../config/controller/quotationShipments/quotationShipmentController.php';
    //$s_username = $_SESSION['username'];
    $s_id = $_SESSION['id'];
    $s_name = $_SESSION['nama'];
    $akses = $_SESSION['hak_akses'];
    $id = $_GET['id'];

    $data = getHdQuoShipmentsPrint($koneksi);

    // print_r($data);die();
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
    <div class="container">
        <div class="header">
            <h1>PT Berkah Permata Logistik</h1>
            <p><strong>Phone:</strong> (021) 2230 4172 | <strong>Email:</strong> sales@berkahpermatalogistik.com</p>
            <p>Jl. Green Lake City Boulevard No.35, RT 004/RW 007, Gondrong, Cipondoh, Tangerang 15147</p>
            <hr/>
        </div>

        <div class="quotation-details">
            <div class="quotation-info">
                <p><strong>Quotation:</strong> <?php echo $data['no_quotation'] ?></p>
                <p><strong>Date:</strong> <?php echo $data['created_at'] ?></p>
            </div>
            <div class="client-info">
                <p>Kepada Yth,</p>
                <p><?php echo $data['pic_name_temp'] ?></p>
                <p><?php echo $data['customer_name'] ?></p>
            </div>
        </div>

        <div class="message">
            <p>Bersama Surat ini, kami lampirkan penawaran harga terbaik untuk Transportasi pengangkutan darat maupun laut:</p>
        </div>

        <!-- Shipment Details Table -->
        <div class="trip-section">
            <p><strong>Shipment Details</strong></p>
            <table>
                <thead>
                    <tr>
                        <th>Jumlah Container</th>
                        <th>Jenis Kontainer</th>
                        <th>Shipment Terms</th>
                        <th>Load Type</th>
                        <th>Origin Country</th>
                        <th>Destination Country</th>
                        <th>Biaya Penanganan</th>
                        <th>Total Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $data['total_container'] ?></td>
                        <td><?php echo $data['master_unit_name'] ?></td>
                        <td><?php echo $data['shipment_terms_name'] ?></td>
                        <td><?php echo $data['shipment_load_type_name'] ?></td>
                        <td><?php echo $data['origin_country_name'] ?></td>
                        <td><?php echo $data['destination_country_name'] ?></td>
                        <td><?php echo number_format($data['total_handling_unit'], 0, ',', '.') ?></td>
                        <td><?php echo number_format($data['total_handling_price'], 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Jenis Barang Bawaan dan Keterangan -->
        <div class="notes">
            <p><strong>Jenis Barang Bawaan:</strong> <?php echo $data['item_description'] ?></p>
            <p><strong>Keterangan:</strong> <?php echo $data['note'] ?></p>
            <hr/>
        </div>

        <div class="note-section">
            <ol>
                <li>Pembayaran atas tagihan selambat-lambatnya <?php echo $data['customer_terms_payment_temp'] ?> hari dari diterimanya dokumen lengkap (Invoice, Faktur Pajak dan Surat Jalan).</li>
                <li>Harga tidak termasuk Biaya LSM, PPN 11%, PPH, Asuransi, Biaya Bongkar, dan Biaya Muat.</li>
                <li>Pemilik barang wajib mengasuransikan barang yang akan dikirim.</li>
                <li>PT Berkah Permata Logistik berhak menolak untuk memuat barang yang tidak memenuhi standar kendaraan, keselamatan maupun medan jalan yang akan dilalui dalam proses mobilisasi.</li>
                <li>Pembatalan yang dilakukan setelah armada keluar dari garasi, maka akan dikenakan biaya pembatalan sebesar 50% dari harga armada.</li>
                <li>Mobil yang telah tiba, wajib dibongkar maksimal 1 x 24 Jam. Setelah melewati 1 x 24 Jam maka akan dikenakan biaya inap per harinya:
                    <ul>
                        <li>Hari inap 40% dari biaya pengiriman</li>
                        <li>Hari inap 50% dari biaya pengiriman</li>
                        <li>Hari inap 70% dari biaya pengiriman</li>
                        <li>Hari inap dan seterusnya 100% dari biaya pengiriman</li>
                    </ul>
                </li>
            </ol>
            <p>Besar harapan kami untuk bisa bekerjasama dengan perusahaan Bapak/Ibu. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        </div>

        <div class="signature">
            <p>Best Regards,</p>
            <p><strong><?php echo $data['sales_name'] ?></strong></p>
        </div>
    </div>
</body>
</html>
