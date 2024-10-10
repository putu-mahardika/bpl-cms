<div class="card-body">
    <div class="row mb-5">
        <div class="col-md-12 d-flex justify-content-between align-items-center mb-5">
            <h5 class="font-weight-bold">Perubahan Data User</h5>
            <a href="javascript:;" class="d-none">
                <i class="fas fa-edit mr-2 text-gray-600"></i>
            </a>
        </div>
        <div class="col-md-12 mb-3">
            <label for="oldSales">Sales Lama</label>
            <input type="text" class="form-control" id="old_sales" name="old_sales" placeholder="John Doe" disabled>
        </div>
        <div class="col-md-12 mb-3">
            <label for="new_sales">Sales Baru</label>
            <select name="new_sales" id="new_sales" class="form-control" onchange="setSelectNewSales()" disabled>
                <?php foreach ($sales as $key => $value) { ?>
                    <option value="<?php echo $value['UserId'] ?>"><?php echo $value['nama'] ?></option>
                <?php }?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="old_vm">VM Shipment</label>
            <input type="hidden" class="form-control" id="old_vm_id" name="old_vm_id" disabled>
            <input type="text" class="form-control" id="old_vm" name="old_vm" placeholder="John Doe" disabled>
        </div>
        <div class="col-md-12 mb-3">
            <label for="new_vm">VM Baru</label>
            <select name="new_vm" id="new_vm" class="form-control" onchange="setSelectNewVM()" disabled>
                <?php foreach ($vm as $key => $value) { ?>
                    <option value="<?php echo $value['UserId'] ?>"><?php echo $value['nama'] ?></option>
                <?php }?>
            </select>
        </div>
        <div class="col-md-12 mb-3">
            <label for="newSales">Keterangan</label>
            <textarea name="" id="" class="form-control" rows="5" placeholder="Keterangan..." disabled></textarea>
        </div>
        <div class="col-md-12 mb-3">
            <label for="admin_name">Admin</label>
            <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="Jane Doe" disabled value="<?php echo $_SESSION['hak_akses'] == 'Admin' ? $_SESSION['nama'] : '-' ?>">
        </div>
    </div>
</div>