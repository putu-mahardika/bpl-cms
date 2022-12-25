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

  if (isset($_GET['reportTransaksi'])) {
    $startspk = $_GET['start'];
    $endspk = $_GET['end'];
    $start0 = str_replace('/', '-', $startspk);
    $end0 = str_replace('/', '-', $endspk);
    $start = date('Y-m-d', strtotime($start0));
    $end = date('Y-m-d', strtotime($end0));
    if($akses == "Admin") {
      $query = "SELECT
      b.create_date,
      b.HdId,
      a.NoSPK,
      a.tgl_spk,
      a.NoPO,
      b.jenis_armada,
      b.nopol,
      b.keterangan_kirim,
      IF (b.OnClose=0, 'OPEN', 'CLOSE') AS StatusTurunan,
      IF (a.OnClose=0, 'OPEN', 'CLOSE') AS StatusPO,
      concat(a.NoSPK, '-', b.turunan) as SPKTurunan,
      CASE 
        WHEN a.kota_kirim_id IS NULL THEN '-' ELSE c.nama
      END AS kotaAsal,
      a.kota_kirim,
      CASE 
        WHEN a.kota_tujuan_id IS NULL THEN '-' ELSE d.nama
      END AS kotaTujuan,
      a.kota_tujuan,
      e.nama as namaUser,
      h.nama as namaCustomer,
      h.npwp,
      f.status as statusTurunan,
      CASE 
      WHEN b.NoSPK NOT IN (select NoSPK from trans_biayaturunan) or (SELECT COUNT(*) from trans_biayaturunan) = 0 then '0' 
      ELSE g.Total
      END AS totalBiaya
      FROM 
        trans_detail b
        left join trans_hd a on b.HdId = a.HdId 
        left join master_kota c on a.kota_kirim_id = c.Id or a.kota_kirim_id is NULL
        left join master_kota d on a.kota_tujuan_id = d.Id or a.kota_tujuan_id is NULL
        left join master_user e on b.UserId = e.UserId
        left join master_status f on b.StsId = f.stsId
        left join trans_biayaturunan g on b.NoSPK = g.NoSPK AND b.turunan = g.Turunan
        left join master_customer h on a.CustId = h.CustId
      WHERE 
        b.atr1 = 0 AND
        b.create_date BETWEEN '".$start." 00:00:00' AND '".$end." 23:59:59'";
    } else {
      $query = "SELECT
      b.create_date,
      b.HdId,
      a.NoSPK,
      a.tgl_spk,
      a.NoPO,
      b.jenis_armada,
      b.nopol,
      b.keterangan_kirim,
      IF (b.OnClose=0, 'OPEN', 'CLOSE') AS StatusTurunan,
      IF (a.OnClose=0, 'OPEN', 'CLOSE') AS StatusPO,
      concat(a.NoSPK, '-', b.turunan) as SPKTurunan,
      CASE 
        WHEN a.kota_kirim_id IS NULL THEN '-' ELSE c.nama
      END AS kotaAsal,
      a.kota_kirim,
      CASE 
        WHEN a.kota_tujuan_id IS NULL THEN '-' ELSE d.nama
      END AS kotaTujuan,
      a.kota_tujuan,
      e.nama as namaUser,
      h.nama as namaCustomer,
      h.npwp,
      f.status as statusTurunan,
      CASE 
      WHEN b.NoSPK NOT IN (select NoSPK from trans_biayaturunan) or (SELECT COUNT(*) from trans_biayaturunan) = 0 then '0' 
      ELSE g.Total
      END AS totalBiaya
      FROM 
        trans_detail b
        left join trans_hd a on b.HdId = a.HdId 
        left join master_kota c on a.kota_kirim_id = c.Id or a.kota_kirim_id is NULL
        left join master_kota d on a.kota_tujuan_id = d.Id or a.kota_tujuan_id is NULL
        left join master_user e on b.UserId = e.UserId
        left join master_status f on b.StsId = f.stsId
        left join trans_biayaturunan g on b.NoSPK = g.NoSPK AND b.turunan = g.Turunan
        left join master_customer h on a.CustId = h.CustId
      WHERE 
      b.atr1 = 0 AND
      b.create_date BETWEEN '".$start." 00:00:00' AND '".$end." 23:59:59' AND
      b.UserId = ".$s_id;
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