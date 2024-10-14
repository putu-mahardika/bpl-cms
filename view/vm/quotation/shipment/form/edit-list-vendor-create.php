<tr>
    <td class="px-0 text-nowrap align-middle" style="font-size: 14px; width: 50px !important">
        <div class="custom-control custom-radio" style="padding-left: 2.5rem">
            <input type="radio" class="custom-control-input selected_quo_vendor_id" name="selected_quo_vendor_id" id="selected_quo_vendor_id<?php echo $key ?>" value="<?php echo $val['vendor_id'] ?>" <?php if ($totalPricing == 0) { ?> disabled <?php } ?>>
            <label class="custom-control-label" for="selected_quo_vendor_id<?php echo $key ?>"></label>
        </div>
    </td>
    <td class="px-2" style="width: 200px">
        <select name="vendor_id" class="form-control vendor_id">
            <?php foreach ($vendors as $val) { ?>
                <option value="<?php echo $val['Id'] ?>"><?php echo $val['nama'] ?></option>
            <?php } ?>
        </select>
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right costing_first_price inputmask_currency" placeholder="0">
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right costing_next_price inputmask_currency" placeholder="0">
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right costing_total_price inputmask_currency" placeholder="0" disabled>
    </td>
    <td class="text-center"><button type="button" class="btn btn-danger remove-row" onclick="removeRow()"><i class="fas fa-trash"></i></button></td>
</tr>