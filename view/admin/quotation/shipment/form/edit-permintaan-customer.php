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
                        <input type="hidden" class="form-control" id="origin_country_id" name="origin_country_id" placeholder="Masukkan origin country..." disabled>
                        <input type="text" class="form-control" id="origin_country_name" name="origin_country_name" placeholder="Masukkan origin country..." disabled>
                    </td>
                    <td class="px-3">
                        <input type="hidden" class="form-control" id="destination_country_id" name="destination_country_id" placeholder="Masukkan destination country..." disabled>
                        <input type="text" class="form-control" id="destination_country_name" name="destination_country_name" placeholder="Masukkan destination country..." disabled>
                    </td>
                    <td class="px-3">
                        <input type="text" class="form-control" id="pickup_note" name="pickup_note" placeholder="Masukkan keterangan pickup..." disabled>
                    </td>
                    <td class="px-3">
                        <input type="text" class="form-control" id="destination_note" name="destination_note" placeholder="Masukkan keterangan destination..." disabled>
                    </td>
                </tbody>
            </table>
        </div>
    </div>
</div>