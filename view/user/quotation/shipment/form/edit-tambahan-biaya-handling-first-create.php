<tr>
    <td class="px-2">
        <input type="hidden" class="form-control" id="handling_id_1" name="handling_id_1" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['id'] ?>">
        <input type="text" class="form-control" id="handling_name_1" name="handling_name_1" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['handling_description'] ?>">
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" id="handling_qty_1" name="handling_qty_1" placeholder="0">
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_cost_1" name="handling_unit_cost_1" placeholder="0" value="<?php echo $val['unit_cost'] ?>">
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" id="handling_total_cost_1" name="handling_total_cost_1" placeholder="0" disabled value="<?php echo $val['total_cost'] ?>">
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_budgeting_1" name="handling_unit_budgeting_1" placeholder="0" value="<?php echo $val['unit_budgeting'] ?>" disabled>
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" id="handling_total_budgeting_1" name="handling_total_budgeting_1" placeholder="0" value="<?php echo $val['total_budgeting'] ?>" disabled>
    </td>
</tr>