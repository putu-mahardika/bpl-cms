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
      f.status as statusTurunan
      -- CASE 
      -- WHEN b.NoSPK NOT IN (select NoSPK from trans_biayaturunan) or (SELECT COUNT(*) from trans_biayaturunan) = 0 then '0' 
      -- ELSE g.Total
      -- END AS totalBiaya
      FROM 
        trans_detail b
        left join trans_hd a on b.HdId = a.HdId 
        left join master_kota c on a.kota_kirim_id = c.Id or a.kota_kirim_id is NULL
        left join master_kota d on a.kota_tujuan_id = d.Id or a.kota_tujuan_id is NULL
        left join master_user e on b.UserId = e.UserId
        left join master_status f on b.StsId = f.stsId
        -- left join trans_biayaturunan g on b.NoSPK = g.NoSPK AND b.turunan = g.Turunan
        left join master_customer h on a.CustId = h.CustId
      WHERE 
        b.atr1 = 0 AND
        a.tgl_spk BETWEEN "."'".$start."'"." AND "."'".$end."'";
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
      f.status as statusTurunan
      -- CASE 
      -- WHEN b.NoSPK NOT IN (select NoSPK from trans_biayaturunan) or (SELECT COUNT(*) from trans_biayaturunan) = 0 then '0' 
      -- ELSE g.Total
      -- END AS totalBiaya
      FROM 
        trans_detail b
        left join trans_hd a on b.HdId = a.HdId 
        left join master_kota c on a.kota_kirim_id = c.Id or a.kota_kirim_id is NULL
        left join master_kota d on a.kota_tujuan_id = d.Id or a.kota_tujuan_id is NULL
        left join master_user e on b.UserId = e.UserId
        left join master_status f on b.StsId = f.stsId
        -- left join trans_biayaturunan g on b.NoSPK = g.NoSPK AND b.turunan = g.Turunan
        left join master_customer h on a.CustId = h.CustId
      WHERE 
      b.atr1 = 0 AND
      -- b.create_date BETWEEN "."'".$start." 00:00:00'"." AND "."'".$end." 23:59:59'"." AND
      a.tgl_spk BETWEEN "."'".$start."'"." AND "."'".$end."'"." AND
      b.UserId = '".$s_id."'";
    }
    
    $fetch = mysqli_query($koneksi,$query);
    while($row =mysqli_fetch_assoc($fetch))
    {
      $emparray[] = $row;
    }
  } 

  elseif (isset($_GET['reportBiayaTransaksi'])) {
    $startspk = $_GET['start'];
    $endspk = $_GET['end'];
    $start0 = str_replace('/', '-', $startspk);
    $end0 = str_replace('/', '-', $endspk);
    $start = date('Y-m-d', strtotime($start0));
    $end = date('Y-m-d', strtotime($end0));
    if($akses == "Admin") {
      $query = "SELECT 
      td.create_date,
      td.HdId,
      td.NoSPK,
      th.tgl_spk,
      th.NoPO,
      td.jenis_armada,
      td.nopol,
      td.keterangan_kirim,
      MAX(td.DtlId) AS request_id,
      if (td.OnClose=0, 'OPEN', 'CLOSE') as StatusTurunan,
      if (th.OnClose=0, 'OPEN', 'CLOSE') as statusPO,
      concat(th.NoSPK, '-', td.turunan) as SPKTurunan,
      CASE 
          WHEN th.kota_kirim_id IS NULL THEN '-' ELSE mk1.nama
        END AS kotaAsal,
        th.kota_kirim,
        CASE 
          WHEN th.kota_tujuan_id IS NULL THEN '-' ELSE mk2.nama
        END AS kotaTujuan,
      CASE 
          WHEN td.NoSPK NOT IN (select NoSPK from trans_biayaturunan) or (SELECT COUNT(*) from trans_biayaturunan) = 0 then '0' 
        ELSE tb.Total
        END AS totalBiaya,
        th.kota_tujuan,
        mu.nama as namaUser,
        mc.nama as namaCustomer,
        mc.npwp
    FROM 
      trans_detail td
      left join trans_hd th on td.HdId = th.HdId
      left join master_user mu on td.UserId =mu.UserId 
      left join trans_biayaturunan tb on td.NoSPK = tb.NoSPK and td.turunan = tb.Turunan  
      left join master_kota mk1 on th.kota_kirim_id = mk1.Id or th.kota_kirim_id is NULL
        left join master_kota mk2 on th.kota_tujuan_id = mk2.Id or th.kota_tujuan_id is null
        left join master_customer mc on th.CustId = mc.CustId	
    where
      td.HdId = th.HdId and 
      mu.UserId =th.UserId and 
      -- mu.atr1 = 0 and
      th.tgl_spk BETWEEN "."'".$start."'"." AND "."'".$end."'"." AND
      td.NoSPK = tb.NoSPK
    GROUP BY td.NoSPK, td.turunan 
    order by td.DtlId desc";
    } else {
      $query = "SELECT 
      td.create_date,
      td.HdId,
      td.NoSPK,
      th.tgl_spk,
      th.NoPO,
      td.jenis_armada,
      td.nopol,
      td.keterangan_kirim,
      MAX(td.DtlId) AS request_id,
      if (td.OnClose=0, 'OPEN', 'CLOSE') as StatusTurunan,
      if (th.OnClose=0, 'OPEN', 'CLOSE') as statusPO,
      concat(th.NoSPK, '-', td.turunan) as SPKTurunan,
      CASE 
          WHEN th.kota_kirim_id IS NULL THEN '-' ELSE mk1.nama
        END AS kotaAsal,
        th.kota_kirim,
        CASE 
          WHEN th.kota_tujuan_id IS NULL THEN '-' ELSE mk2.nama
        END AS kotaTujuan,
      CASE 
          WHEN td.NoSPK NOT IN (select NoSPK from trans_biayaturunan) or (SELECT COUNT(*) from trans_biayaturunan) = 0 then '0' 
        ELSE tb.Total
        END AS totalBiaya,
        th.kota_tujuan,
        mu.nama as namaUser,
        mc.nama as namaCustomer,
        mc.npwp
    FROM 
      trans_detail td
      left join trans_hd th on td.HdId = th.HdId
      left join master_user mu on td.UserId =mu.UserId 
      left join trans_biayaturunan tb on td.NoSPK = tb.NoSPK and td.turunan = tb.Turunan  
      left join master_kota mk1 on th.kota_kirim_id = mk1.Id or th.kota_kirim_id is NULL
        left join master_kota mk2 on th.kota_tujuan_id = mk2.Id or th.kota_tujuan_id is null
        left join master_customer mc on th.CustId = mc.CustId	
    where
      td.HdId = th.HdId and 
      mu.UserId =th.UserId and 
      -- mu.atr1 = 0 and
      td.NoSPK = tb.NoSPK and
      th.tgl_spk BETWEEN "."'".$start."'"." AND "."'".$end."'"." AND
      td.UserId = $s_id
      GROUP BY td.NoSPK, td.turunan 
      order by td.DtlId desc";
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