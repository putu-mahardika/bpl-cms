<div class="row mt-5">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">List Vendor</h5>
        <button class="btn btn-primary" onclick="addRow()"><i class="fas fa-plus"></i></button>
    </div>
    <div class="col-md-12 mb-3">
        <ul class="nav nav-tabs mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-costing-tab" data-toggle="pill" data-target="#pills-costing" type="button" role="tab" aria-controls="pills-costing" aria-selected="true">
                    Costing
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-budgeting-tab" data-toggle="pill" data-target="#pills-budgeting" type="button" role="tab" aria-controls="pills-budgeting" aria-selected="true">
                    Budgeting
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-pricing-tab" data-toggle="pill" data-target="#pills-pricing" type="button" role="tab" aria-controls="pills-pricing" aria-selected="true">
                    Pricing
                </button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-costing" role="tabpanel" aria-labelledby="pills-costing-tab">
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
            <div class="tab-pane fade" id="pills-budgeting" role="tabpanel" aria-labelledby="pills-budgeting-tab">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Budgeting 1ST</label>
                        <div class="input-group">
                            <input type="text" class="form-control text-right inputmask_currency" id="apply_budgeting_first" placeholder="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">Budgeting Next</label>
                        <div class="input-group">
                            <input type="text" class="form-control text-right inputmask_currency" id="apply_budgeting_next" placeholder="0">
                            <button class="btn btn-primary" style="height: 42px;" type="button" onclick="calcApplyAllBudgeting()">
                                Apply All
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-pricing" role="tabpanel" aria-labelledby="pills-pricing-tab">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Pricing 1ST</label>
                        <div class="input-group">
                            <input type="text" class="form-control text-right inputmask_currency" id="apply_pricing_first" placeholder="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="">Pricing Next</label>
                        <div class="input-group">
                            <input type="text" class="form-control text-right inputmask_currency" id="apply_pricing_next" placeholder="0">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" onclick="calcApplyAllPricing()">
                                    Apply All
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered" style="width: 1800px" id="table_list_vendor">
                <thead class="thead-light">
                    <tr>
                        <th class="text-nowrap px-3 text-center" rowspan="2" style="font-size: 14px;">&nbsp;</th>
                        <th class="text-nowrap px-3 text-center align-middle" rowspan="2" style="font-size: 14px;">Vendor</th>
                        <th class="text-nowrap px-3 text-center" colspan="3" style="font-size: 14px;">Costing</th>
                        <th class="text-nowrap px-3 text-center" colspan="3" style="font-size: 14px;">Budgeting</th>
                        <th class="text-nowrap px-3 text-center" colspan="3" style="font-size: 14px;">Pricing</th>
                        <th class="text-nowrap px-3 text-center" rowspan="2" style="font-size: 14px;">&nbsp;</th>
                    </tr>
                    <tr>
                        <th class="text-nowrap px-3" style="font-size: 14px;">1ST</th>
                        <th class="text-nowrap px-3" style="font-size: 14px;">Next</th>
                        <th class="text-nowrap px-3" style="font-size: 14px;">Total</th>
                        <th class="text-nowrap px-3" style="font-size: 14px;">1ST</th>
                        <th class="text-nowrap px-3" style="font-size: 14px;">Next</th>
                        <th class="text-nowrap px-3" style="font-size: 14px;">Total</th>
                        <th class="text-nowrap px-3" style="font-size: 14px;">1ST</th>
                        <th class="text-nowrap px-3" style="font-size: 14px;">Next</th>
                        <th class="text-nowrap px-3" style="font-size: 14px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-3 text-nowrap align-middle" style="font-size: 14px; width: 50px !important">
                            <div class="custom-control custom-checkbox" style="padding-left: 2rem">
                                <input type="checkbox" class="custom-control-input checked_vendor" id="customCheck" <?php if($totalPricing == 0) {?> disabled <?php }?>>
                                <label class="custom-control-label" for="customCheck"></label>
                            </div>
                        </td>
                        <td class="px-3 text-nowrap" style="font-size: 14px; min-width: 250px !important">
                            <input type="hidden" class="form-control text-right dtl_quo_shipment_id" value="<?php echo $val['id'] ?>">
                            <select name="vendor_id" class="form-control vendor_id">
                                <?php foreach ($vendors as $valVendor) { ?>
                                    <option value="<?php echo $valVendor['Id'] ?>"><?php echo $valVendor['nama'] ?></option>
                                <?php } ?>
                            </select>
                        </td>
                        </td>
                        <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                            <input type="text" class="form-control text-right costing_first_price inputmask_currency" placeholder="0">
                        </td>
                        <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                            <input type="text" class="form-control text-right costing_next_price inputmask_currency" placeholder="0">
                        </td>
                        <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                            <input type="text" class="form-control text-right costing_total_price inputmask_currency" disabled placeholder="0">
                        </td>
                        <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                            <input type="text" class="form-control text-right budgeting_first_price inputmask_currency" placeholder="0">
                        </td>
                        <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                            <input type="text" class="form-control text-right budgeting_next_price inputmask_currency" placeholder="0">
                        </td>
                        <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                            <input type="text" class="form-control text-right budgeting_total_price inputmask_currency" disabled placeholder="0">
                        </td>
                        <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                            <input type="text" class="form-control text-right pricing_first_price inputmask_currency" placeholder="0">
                        </td>
                        <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                            <input type="text" class="form-control text-right pricing_next_price inputmask_currency" placeholder="0">
                        </td>
                        <td class="px-3 text-nowrap" style="font-size: 14px; width: 180px !important">
                            <input type="text" class="form-control text-right pricing_total_price inputmask_currency" disabled placeholder="0">
                        </td>
                        <td class="text-center"><button type="button" class="btn btn-danger remove-row" onclick="removeRow()"><i class="fas fa-trash"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>