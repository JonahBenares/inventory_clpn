 <?php $x=1; {?>
 <tr id='item_row<?php echo $list['count']; ?>'> 
     <td style="padding: 0px; width:50px; text-align:center;"><?php echo $x; ?></td> 
    <td style="padding: 0px "><textarea  type = "text" name = "item[]" style = "text-align:center;width:100%;border:1px transparent;"value = "<?php echo $list['item']?>"></textarea></td>
    <td style="padding: 0px; width:50px; "><input type = "text" name = "quantity[]" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['quantity']; ?>"></td>
    <td style="padding: 0px; width:80px;"><input type = "hidden"  name = "unit[]" value="<?php echo $list['unit']; ?>"><input type = "text" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['unit_name']?>" readonly></td>
    <td ><center>
        <a class="btn btn-danger table-remove btn-xs" onclick="remove_item(<?php echo $list['count']; ?>)"><span class=" fa fa-times"></span></a></center>
        
    </td>
</tr>
<?php $x++; } ?>