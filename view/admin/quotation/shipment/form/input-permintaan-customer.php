<div class="row mt-5">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">Permintaan Customer</h5>
    </div>
    <div class="col-md-12 mb-3">
        <div class="table-responsive">
            <table class="table align-items-center table-bordered" id="dataTableInfoMuatan">
                <thead class="thead-light">
                    <tr>
                        <th class="text-nowrap px-3" style="font-size: 14px; width: 130px !important">Country Origin</th>
                        <th class="text-nowrap px-3" style="font-size: 14px; width: 130px !important">Country Destination</th>
                        <th class="text-nowrap px-3" style="font-size: 14px">Keterangan Pickup</th>
                        <th class="text-nowrap px-3" style="font-size: 14px">Keterangan Destination</th>
                    </tr>
                </thead>
                <tbody>
                    <td class="px-3">
                        <select name="" id="origin_country_id" class="form-control select2">
                            <?php foreach ($countries as $val) { ?>
                                <option value="<?php echo $val['Id'] ?>"><?php echo $val['Nama'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="px-3">
                        <select name="" id="destination_country_id" class="form-control select2">
                            <?php foreach ($countries as $val) { ?>
                                <option value="<?php echo $val['Id'] ?>"><?php echo $val['Nama'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="px-3">
                        <input type="text" class="form-control" id="pickup_note" name="pickup_note" placeholder="Masukkan keterangan pickup...">
                    </td>
                    <td class="px-3">
                        <input type="text" class="form-control" id="destination_note" name="destination_note" placeholder="Masukkan keterangan destination...">
                    </td>
                </tbody>
            </table>
        </div>
    </div>
</div>