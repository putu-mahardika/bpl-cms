<tr>
    <td class="px-2 text-nowrap align-middle" style="font-size: 14px; width: 50px !important">
        <div class="custom-control custom-radio" style="padding-left: 2rem">
            <input type="radio" class="custom-control-input selected_quo_vendor_id" name="selected_quo_vendor_id" id="selected_quo_vendor_id<?php echo $key ?>" <?php if ($totalPricing == 0) { ?> disabled <?php } ?> <?php if ($data['selected_quo_vendor_id'] == $value['vendor_id']) { ?>checked<?php } ?>>
            <label class="custom-control-label"></label>
        </div>
    </td>
    <td class="px-2">
        <select name="vendor_id" class="form-control vendor_id" disabled>
            <?php foreach ($vendors as $val) { ?>
                <option value="<?php echo $val['Id'] ?>" <?php if ($val['Id'] == $value['vendor_id']) { ?>selected<?php } ?>><?php echo $val['nama'] ?></option>
            <?php } ?>
        </select>
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right budgeting_first_price inputmask_currency" placeholder="0" value="<?php echo $value['budgeting_first_price'] ?>" disabled>
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right budgeting_next_price inputmask_currency" placeholder="0" value="<?php echo $value['budgeting_next_price'] ?>" disabled>
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right budgeting_total_price inputmask_currency" disabled placeholder="0" value="<?php echo $value['budgeting_total_price'] ?>" disabled>
    </td>
</tr>