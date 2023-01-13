<?php 
  include 'koneksi.php';
  date_default_timezone_set("Asia/Jakarta");
  $datetime = date('Y-m-d H:i:s');
  if(isset($_GET['tahun'])) {
    $year = $_GET['tahun'];
  } else {
    $year = date('Y', strtotime($datetime));
  } 
  session_save_path('../tmp');
  session_start();
  //$s_username = $_SESSION['username'];
  $s_id = $_SESSION['id'];
  $akses = $_SESSION['hak_akses'];

  $emparray = array();

  if (isset($_GET['reportTransaksitemp'])) {
    // $startspk = $_GET['start'];
    // $endspk = $_GET['end'];
    // $start0 = str_replace('/', '-', $startspk);
    // $end0 = str_replace('/', '-', $endspk);
    // $start = date('Y-m-d', strtotime($start0));
    // $end = date('Y-m-d', strtotime($end0));
    if($akses == "Admin") {
      $query = "select 
      a.create_date as TglTransaksi,
      c.nama as Sales,
      a.NoSPK as NoSPK,
      a.tgl_spk as TglSPK,
      a.NoPO as NoPO,
      a.tgl_po as TglPO,
      h.nama as NamaCustomer,
      a.total_armada as TotalArmada,
      CASE 
        WHEN a.kota_kirim_id IS NULL THEN '-' ELSE e.nama
      END AS kotaAsal,
      a.kota_kirim as DetailKotaAsal,
      CASE 
        WHEN a.kota_tujuan_id IS NULL THEN '-' ELSE d.nama
      END AS kotaTujuan,
      a.kota_tujuan as DetailKotaTujuan,
      a.Barang as Barang,
      IF (a.OnClose=0, 'OPEN', 'CLOSE') AS StatusPO,
      IF (a.OnClose=0, '-', a.DateOnClose) as TglClose,
      IF (a.OnClose=0, '-', f.nama) as ClosedBy,
      IF (sum(b.Total) IS NULL, '0', sum(b.Total)) AS TotalBiaya
    from 
      trans_hd a
      left join trans_biayaturunan b on a.HdId = b.HdId
      left join master_user c on a.UserId = c.UserId
      left join master_kota d on a.kota_tujuan_id = d.Id or a.kota_tujuan_id is NULL
      left join master_kota e on a.kota_tujuan_id = e.Id or a.kota_tujuan_id is NULL
      left join master_user f on a.closedById = f.UserId or a.closedById is NULL
      left join master_customer h on a.CustId = h.CustId
    where
      a.create_date between '2022-12-01 00:00:00' and '2023-01-13 23:59:59'
    GROUP BY
      a.HdId";
    }
    
    $fetch = mysqli_query($koneksi,$query);
    while($row =mysqli_fetch_assoc($fetch))
    {
      $emparray[] = $row;
    }
  } 
  $data = json_encode($emparray);
  echo $data;
?>