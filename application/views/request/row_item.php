 
 <tr id='item_row<?php echo $list['count']; ?>'>  
    <td style="padding: 0px; width:50px; "><input type = "text" name = "quantity[]" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['quantity']; ?>" readonly></td>
    <td style="padding: 0px; width:80px;"><input type = "hidden"  name = "unit[]" value="<?php echo $list['unit']; ?>"><input type = "text" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['unit_name']?>" readonly></td>
     <td style="padding: 0px "><input type = "text" name = "original_pn[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['original_pn']; ?>" readonly></td>
    <td style="padding: 0px "><textarea  rows="3" type = "text" name = "item[]" style = "text-align:center;width:100%;border:1px transparent;" readonly><?php echo $list['item']; ?></textarea></td>
   <td style="padding: 0px "><textarea  rows="3" type = "text" name = "crossref[]" style = "text-align:center;width:100%;border:1px transparent;" readonly><?php echo $list['supplier'] . " - " . $list['catalog_no'] . " - " . $list['brand']; ?></textarea></td>
    <td style="padding: 0px; width:100px; "><input type = "text" name = "unitcost[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['unit_cost']; ?>" readonly></td>
     <td style="padding: 0px; width:100px; "><input type = "text" name = "totalcost[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['total_cost']; ?>" readonly></td>
    <td style="padding: 0px; width:100px; "><input type = "text" name = "invqty[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['invqty']; ?>" readonly></td>
    <td style="padding: 0px; width:100px; "><input type = "text" name = "borrow[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['borrow']; ?>" readonly></td>
    <td ><center>
        <a class="btn btn-danger table-remove btn-xs" onclick="remove_item(<?php echo $list['count']; ?>)"><span class=" fa fa-times"></span></a></center>
        
    </td>
    <input type="hidden" name="item_id[]" value="<?php echo $list['itemid']; ?>">
    <input type="hidden" name="siid[]" value="<?php echo $list['siid']; ?>">
    <input type="hidden" name="supplier_id[]" value="<?php echo $list['supplier_id']; ?>">
    <input type="hidden" name="catalog_no[]" value="<?php echo $list['catalog_no']; ?>">
    <input type="hidden" name="brand_id[]" value="<?php echo $list['brand_id']; ?>">
</tr>