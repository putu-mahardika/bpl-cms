<?php
  include 'config/koneksi.php';
  // $query = "select * from trans_detail where atr1=0";
  $query = "SELECT 
  a.create_date,
  a.HdId,
  b.NoSPK,
  b.tgl_spk,
  a.turunan, 
  b.NoPO,
  f.nama as namaCustomer,
  f.npwp,
  b.kota_kirim_id,
  b.kota_kirim,
  b.kota_tujuan_id,
  b.kota_tujuan,
  a.jenis_armada,
  a.nopol,
  a.keterangan_kirim,
  g.status,
  IF (a.OnClose=0, 'OPEN', 'CLOSE') AS StatusTurunan,
  IF (b.OnClose=0, 'OPEN', 'CLOSE') AS StatusPO,
  h.nama as namaUser,
  concat(b.NoSPK, '-', a.turunan) as SPKTurunan,
  CASE WHEN b.kota_kirim_id IS NULL then '-' ELSE c.Nama END AS kotaAsal,
  CASE WHEN b.kota_tujuan_id IS NULL then '-' ELSE d.Nama END AS kotaTujuan,
  case when a.NoSPK not in (select NoSPK from trans_biayaturunan) then '0' else e.Total end as totalBiaya
FROM
  trans_detail a,
  trans_hd b,
  (select * from master_kota) AS c,
  (select * from master_kota) AS d,
  trans_biayaturunan e,
  master_customer f,
  master_status g,
  master_user h
WHERE
  a.HdId = b.HdId and
  a.atr1=0 and
  a.create_date between '2022-10-01 00:00:00' and '2022-10-31 23:59:59' and
  a.StsId = g.stsId and
  b.CustId = f.CustId and
  a.UserId = h.UserId and
  (b.kota_kirim_id = c.Id OR b.kota_kirim_id IS NULL) and
  (b.kota_tujuan_id = d.Id OR b.kota_tujuan_id IS NULL) and
  (a.NoSPK = e.NoSPK OR a.NoSPK NOT IN(SELECT NoSPK from trans_biayaturunan)) and
  (a.turunan = e.Turunan OR a.turunan NOT IN(SELECT Turunan from trans_biayaturunan))";
  $fetch = mysqli_query($koneksi,$query);
  // $data = json_encode(mysqli_fetch_assoc($fetch), JSON_HEX_TAG);
  $emparray = array();
  while($row =mysqli_fetch_assoc($fetch))
  {
    $emparray[] = $row;
  }
  $data = json_encode($emparray, JSON_HEX_TAG);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  
    <!-- DevExtreme theme -->
    <link rel="stylesheet" href="https://cdn3.devexpress.com/jslib/22.1.6/css/dx.light.css">

    <!-- DevExtreme library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.12.1/polyfill.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/3.8.0/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <script type="text/javascript" src="https://cdn3.devexpress.com/jslib/22.1.6/js/dx.all.js"></script>
    <style>
      #gridContainer {
        max-height: 800px;
      }

      .options {
        margin-top: 20px;
        padding: 20px;
        background-color: rgba(191, 191, 191, 0.15);
        position: relative;
      }

      .caption {
        font-size: 18px;
        font-weight: 500;
      }

      .option-container {
        display: flex;
        margin: 0 auto;
        justify-content: space-between;
      }

      .option {
        margin-top: 10px;
        display: flex;
        align-items: center;
      }

      .option-caption {
        white-space: nowrap;
        margin: 0 8px;
      }
    </style>
  </head>
  <body class="dx-viewport">
    <div class="demo-container">
      <div id="data-grid-demo">
        <div id="gridContainer"></div>
      </div>
    </div>
    <script>
      var xxx = <?php echo $data ?>;
      console.log('xxx', xxx);
      $(() => {
        var borderStylePattern = { style: 'thin', color: { argb: 'FF7E7E7E' } };
        const dataGrid = $('#gridContainer').dxDataGrid({
          // dataSource: generateData(100000),
          dataSource: <?php echo $data; ?>,
          // keyExpr: 'id',
          showBorders: true,
          showRowLines: true,
          showColumnLines: true,
          filterRow: {
            visible: true,
            applyFilter: 'auto',
          },
          searchPanel: {
            visible: true,
            width: 240,
            placeholder: 'Search...',
          },
          headerFilter: {
            visible: true,
          },
          columnChooser: {
            enabled: true,
            mode: 'select',
          },
          columnAutoWidth: true,
          export: {
            enabled: true,
          },
          onExporting(e) {
            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet('CountriesPopulation');

            DevExpress.excelExporter.exportDataGrid({
              component: e.component,
              worksheet,
              topLeftCell: { row: 5, column: 1 },
              customizeCell: function(options) {
                const { gridCell, excelCell } = options;

                // if(gridCell.rowType === 'group' || gridCell.rowType === 'totalFooter' || gridCell.rowType === 'groupFooter') {
                //   specialRowIndexes.push(excelCell.fullAddress.row);
                // }
              }
            }).then(function(dataGridRange) {
              // See border - https://github.com/exceljs/exceljs#borders for more details
              setBorders(e.component, worksheet, dataGridRange);
              return Promise.resolve();
            }).then((cellRange) => {
              // header
              const headerRow = worksheet.getRow(2);
              headerRow.height = 30;
              worksheet.mergeCells(2, 1, 2, 19);

              headerRow.getCell(1).value = 'Laporan Detail Pergerakan Barang - PT Berkah Permata Logistik';
              headerRow.getCell(1).font = { name: 'Segoe UI Light', size: 20 };
              headerRow.getCell(1).alignment = { horizontal: 'center' };
              
              const subHeaderRow = worksheet.getRow(3);
              subHeaderRow.height = 24;
              worksheet.mergeCells(3, 1, 3, 19);

              subHeaderRow.getCell(1).value = 'Periode : 01-10-2022 - 31-10-2022';
              subHeaderRow.getCell(1).font = { name: 'Segoe UI Light', size: 14 };
              subHeaderRow.getCell(1).alignment = { horizontal: 'center' };

            }).then(() => {
              workbook.xlsx.writeBuffer().then((buffer) => {
                saveAs(new Blob([buffer], { type: 'application/octet-stream' }), 'Laporan Pergerakan Barang - PT Berkah Permata Logistik.xlsx');
              });
            });
            e.cancel = true;
          },
          columns: [
            {
              caption: 'Tgl Detail Pergerakan',
              dataField: 'create_date',
            },
            {
              caption: 'No. SPK',
              dataField: 'NoSPK'
            },
            {
              caption: 'Tgl SPK',
              dataField: 'tgl_spk'
            },
            {
              caption: 'No. SPK Turunan',
              dataField: 'SPKTurunan'
            },
            {
              caption: 'No. PO',
              dataField: 'NoPO'
            },
            {
              caption: 'Customer',
              dataField: 'namaCustomer'
            },
            {
              caption: 'NPWP',
              dataField: 'npwp'
            },
            {
              caption: 'Kota Asal',
              dataField: 'kotaAsal'
            },
            {
              caption: 'Detail Kota Asal',
              dataField: 'kota_kirim'
            },
            {
              caption: 'Kota Tujuan',
              dataField: 'kotaTujuan'
            },
            {
              caption: 'Detail Kota Tujuan',
              dataField: 'kota_tujuan'
            },
            {
              caption: 'Jenis Armada',
              dataField: 'jenis_armada'
            },
            {
              caption: 'Nopol',
              dataField: 'nopol'
            },
            {
              caption: 'Keterangan',
              dataField: 'keterangan_kirim'
            },
            {
              caption: 'Status',
              dataField: 'status'
            },
            {
              caption: 'Status OnClose SPK Turunan',
              dataField: 'StatusTurunan'
            },
            {
              caption: 'Total Biaya',
              dataField: 'totalBiaya'
            },
            {
              caption: 'Status OnClose PO',
              dataField: 'StatusPO'
            },
            {
              caption: 'Sales',
              dataField: 'namaUser'
            },
            {
              caption: 'Id',
              dataField: 'Id',
              allowExporting: false
            }
          ],
          scrolling: {
            rowRenderingMode: 'virtual',
          },
          paging: {
            pageSize: 10,
          },
          pager: {
            visible: true,
            allowedPageSizes: [5, 10, 'all'],
            showPageSizeSelector: true,
            showInfo: true,
            showNavigationButtons: true,
          },
        }).dxDataGrid('instance');

        function setBorders(dataGrid, worksheet, cellsRange) {
          const { showRowLines, showColumnLines, showBorders } = dataGrid.option();
          // rowLines
          // console.log(cellsRange);
          // if(showRowLines) {
            for(let i = cellsRange.from.row; i < cellsRange.to.row; i++) {
              for(let j = cellsRange.from.column; j <= cellsRange.to.column; j++) {
                setBorderCell(worksheet, i, j, { bottom: borderStylePattern });
              }
            }
          // }
          // if(showColumnLines) {
              // columnLines
              for(let i = cellsRange.from.row; i <= cellsRange.to.row; i++) {
                for(let j = cellsRange.from.column; j < cellsRange.to.column; j++) {
                  setBorderCell(worksheet, i, j, { right: borderStylePattern }); 
                }
              }
          // }
          // if(showBorders) {
            // borders
            // top
            for(let i = cellsRange.from.column; i <= cellsRange.to.column; i++) {
              setBorderCell(worksheet, cellsRange.from.row, i, { top: borderStylePattern });
            }
            // left
            for(let i = cellsRange.from.row; i <= cellsRange.to.row; i++) {
              setBorderCell(worksheet, i, cellsRange.from.column, { left: borderStylePattern });
            }
  
            // right
            for(let i = cellsRange.from.row; i <= cellsRange.to.row; i++) {
              setBorderCell(worksheet, i, cellsRange.to.column, { right: borderStylePattern });
            }
            // bottom
            for(let i = cellsRange.from.column; i <= cellsRange.to.column; i++) {
              setBorderCell(worksheet, cellsRange.to.row, i, { bottom: borderStylePattern });
            }
          // }
        }

        function setBorderCell(worksheet, row, column, borderValue) {
          const excelCell = worksheet.getCell(row, column);

          if(!excelCell.border) {
            excelCell.border = {};
          }

          Object.assign(excelCell.border, borderValue);
        }
      });

    </script>
  </body>
</html>