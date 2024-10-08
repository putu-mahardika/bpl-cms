<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard-admin.php?tahun=<?php echo $datetime ?>">
        <div class="sidebar-brand-icon">
            <img src="<?php echo $base_url; ?>/img/logo-BPL-white-min.png" style="height:130px;">
        </div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="dashboard-admin.php?tahun=<?php echo $datetime ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Master
    </div>
    <li class="nav-item">
        <a class="nav-link" href="user.php">
            <i class="fas fa-fw fa-users"></i>
            <span>User Pengguna</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
            aria-controls="collapseForm">
            <i class="fas fa-fw fa-database"></i>
            <span>Database</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Customer</h6> -->
                <a class="collapse-item" href="customer.php">List Customer</a>
                <a class="collapse-item" href="vendor.php">List Vendor</a>
                <a class="collapse-item" href="kota.php">List Kota</a>
                <a class="collapse-item" href="negara.php">List Negara</a>
                <a class="collapse-item" href="unit.php">List Unit</a>
                <a class="collapse-item" href="jenisKendaraan.php">List Jenis Kendaraan</a>
                <a class="collapse-item" href="loadType.php">List Load Type</a>
                <a class="collapse-item" href="status.php">List Status Trucking</a>
                <a class="collapse-item" href="statusShipment.php">List Status Shipment</a>
                <a class="collapse-item" href="shipmentTerms.php">List Shipment Terms</a>
<a class="collapse-item" href="globalSetting.php">List Global Settings</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Transaksi
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseQuoTrucking" aria-expanded="true"
            aria-controls="collapseQuoTrucking">
            <i class="fas fa-fw fa-table"></i>
            <span>Quotation</span>
        </a>
        <div id="collapseQuoTrucking" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Quo Trucking</h6>
                <a class="collapse-item" href="quotation/trucking/index.php">List Quo Trucking</a>
                <h6 class="collapse-header">Quo Shipment</h6>
                <a class="collapse-item" href="quotation/shipment/index.php">List Quo Shipment</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="shipment.php?tahun=<?php echo $datetime ?>">
            <i class="fas fa-fw fa-ship"></i>
            <span>Shipment</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="transaksi.php?tahun=<?php echo $datetime ?>">
            <i class="fas fa-fw fa-truck"></i>
            <span>Pergerakan Truck</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Laporan
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportTruck" aria-expanded="true"
            aria-controls="collapseReportTruck">
            <i class="fas fa-fw fa-table"></i>
            <span>Laporan Trucking</span>
        </a>
        <div id="collapseReportTruck" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Laporan Trucking</h6>
                <a class="collapse-item" href="laporanbarang.php">Laporan Detail</a>
                <a class="collapse-item" href="laporanbarangbiaya.php">Laporan Biaya</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="laporanShipment.php">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Laporan Shipment</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Bantuan
    </div>

    <li class="nav-item">
        <a class="nav-link" href="http://www.berkahpermatalogistik.com/Howto/index.htm" target="_blank">
            <i class="fas fa-fw fa-question"></i>
            <span>Bantuan</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <!--<div class="version" id="version-ruangadmin"></div>-->
    <li class="nav-item">
        <a class="nav-link" type="button" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>
</ul>