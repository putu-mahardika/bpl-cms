<div class="row mt-5">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">List Vendor</h5>
        <button class="btn btn-primary" onclick="addRow()"><i class="fas fa-plus"></i></button>
    </div>
    <div class="col-md-12 mb-3">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-costing" type="button" role="tab" aria-controls="pills-costing" aria-selected="true">
                    Costing
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-budgeting-tab">
                    Budgeting
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-pricing-tab">
                    Pricing
                </button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="row">
                <div class="col-md-6">
                    <label for="">Costing 1ST</label>
                    <div class="input-group">
                        <input type="text" class="form-control text-right inputmask_currency" id="apply_costing_first" placeholder="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="">Costing Next</label>
                    <div class="input-group">
                        <input type="text" class="form-control text-right inputmask_currency" id="apply_costing_next" placeholder="0">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" onclick="calcApplyAllCosting()">
                                Apply All
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="tab-pane fade show active" id="pills-costing" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="table-responsive">
                <table class="table align-items-center table-bordered" id="table_list_vendor">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-nowrap px-3" style="font-size: 14px;">Vendor</th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">1ST</th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Next</th>
                            <th class="text-nowrap px-3" style="font-size: 14px; width: 150px !important">Total</th>
                            <?php if (count($dataDtlQuoShipment) < 1) { ?>
                                <th class="text-nowrap" style="font-size: 14px;">&nbsp;</th>
                            <?php }?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($dataDtlQuoShipment) > 0) { ?>
                            <?php foreach ($dataDtlQuoShipment as $key => $value) { ?>
                                <tr>
                                    <td class="px-3">
                                        <select name="vendor_id" class="form-control vendor_id">
                                            <?php foreach ($vendors as $val) { ?>
                                                <option value="<?php echo $val['Id'] ?>" <?php if ($val['Id'] == $value['vendor_id']) { ?> selected <?php } ?>><?php echo $val['nama'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td class="px-3">
                                        <input type="hidden" class="form-control text-right dtl_quo_shipment_id inputmask_currency" placeholder="0" value="<?php echo $value['id'] ?>">
                                        <input type="text" class="form-control text-right costing_first_price inputmask_currency" placeholder="0" value="<?php echo $value['costing_first_price'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right costing_next_price inputmask_currency" placeholder="0" value="<?php echo $value['costing_next_price'] ?>">
                                    </td>
                                    <td class="px-3">
                                        <input type="text" class="form-control text-right costing_total_price inputmask_currency" placeholder="0" value="<?php echo $value['costing_total_price'] ?>" disabled>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else {?>
                            <tr>
                                <td class="px-3">
                                    <select name="vendor_id" class="form-control vendor_id">
                                        <?php foreach ($vendors as $val) { ?>
                                            <option value="<?php echo $val['Id'] ?>"><?php echo $val['nama'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="px-3">
                                    <input type="text" class="form-control text-right costing_first_price inputmask_currency" placeholder="0">
                                </td>
                                <td class="px-3">
                                    <input type="text" class="form-control text-right costing_next_price inputmask_currency" placeholder="0">
                                </td>
                                <td class="px-3">
                                    <input type="text" class="form-control text-right costing_total_price inputmask_currency" placeholder="0" disabled>
                                </td>
                                <td class="text-center"><button type="button" class="btn btn-danger remove-row" onclick="removeRow()"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>