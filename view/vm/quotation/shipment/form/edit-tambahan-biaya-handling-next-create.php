<tr>
    <td class="px-2">
        <input type="hidden" class="form-control" id="handling_id_next" name="handling_id_next" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['id'] ?>">
        <input type="text" class="form-control" id="handling_name_next" name="handling_name_next" placeholder="Masukkan nama biaya handling..." value="<?php echo $val['handling_description'] ?>">
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" id="handling_qty_next" name="handling_qty_next" placeholder="0">
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_cost_next" name="handling_unit_cost_next" placeholder="0" value="<?php echo $val['unit_cost'] ?>">
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" id="handling_total_cost_next" name="handling_total_cost_next" placeholder="0" disabled value="<?php echo $val['total_cost'] ?>">
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" id="handling_unit_budgeting_next" name="handling_unit_budgeting_next" placeholder="0" value="<?php echo $val['unit_budgeting'] ?>" disabled>
    </td>
    <td class="px-2">
        <input type="text" class="form-control text-right inputmask_currency" id="handling_total_budgeting_next" name="handling_total_budgeting_next" placeholder="0" value="<?php echo $val['total_budgeting'] ?>" disabled>
    </td>
</tr>