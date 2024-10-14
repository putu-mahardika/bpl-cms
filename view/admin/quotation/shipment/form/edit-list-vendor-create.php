<tr>
    <td class="px-2 text-nowrap align-middle" style="font-size: 14px; width: 50px !important">
        <div class="custom-control custom-radio" style="padding-left: 2rem">
            <input type="radio" class="custom-control-input selected_quo_vendor_id" name="selected_quo_vendor_id" id="selected_quo_vendor_id" disabled>
            <label class="custom-control-label" for="selected_quo_vendor_id"></label>
        </div>
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; min-width: 250px !important">
        <input type="hidden" class="form-control text-right dtl_quo_shipment_id" value="<?php echo $val['id'] ?>">
        <select name="vendor_id" class="form-control vendor_id">
            <?php foreach ($vendors as $valVendor) { ?>
                <option value="<?php echo $valVendor['Id'] ?>" <?php if ($valVendor['Id'] == $val['vendor_id']) { ?> selected <?php } ?>><?php echo $valVendor['nama'] ?></option>
            <?php } ?>
        </select>
    </td>
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right costing_first_price inputmask_currency" placeholder="0">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right costing_next_price inputmask_currency" placeholder="0">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right costing_total_price inputmask_currency" disabled placeholder="0">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right budgeting_first_price inputmask_currency" placeholder="0">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right budgeting_next_price inputmask_currency" placeholder="0">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right budgeting_total_price inputmask_currency" disabled placeholder="0">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right pricing_first_price inputmask_currency" placeholder="0">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right pricing_next_price inputmask_currency" placeholder="0">
    </td>
    <td class="px-2 text-nowrap" style="font-size: 14px; width: 180px !important">
        <input type="text" class="form-control text-right pricing_total_price inputmask_currency" disabled placeholder="0">
    </td>
</tr>