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
            <input type="text" class="form-control" id="oldSales" name="oldSales" placeholder="John Doe" disabled value="<?php echo $_SESSION['nama'] ?>">
        </div>
        <div class="col-md-12 mb-3">
            <label for="newSales">Sales Baru</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">Pilih Sales</option>
                <option value="">Jane Doe</option>
            </select>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary w-100 py-2" disabled>Simpan</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="oldSales">VM Shipment</label>
            <input type="text" class="form-control" id="oldSales" name="oldSales" placeholder="John Doe" disabled value="-">
        </div>
        <div class="col-md-12 mb-3">
            <label for="newSales">VM Baru</label>
            <select name="" id="" class="form-control" disabled>
                <option value="">Pilih Sales</option>
                <option value="">Jane Doe</option>
            </select>
        </div>
        <div class="col-md-12 mb-3">
            <label for="newSales">Keterangan</label>
            <textarea name="" id="" class="form-control" rows="5" placeholder="Keterangan..." disabled></textarea>
        </div>
        <div class="col-md-12 mb-3">
            <label for="oldSales">Admin</label>
            <input type="text" class="form-control" id="oldSales" name="oldSales" placeholder="Jane Doe" disabled value="-">
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary w-100 py-2" disabled>Simpan</button>
        </div>
    </div>
</div>