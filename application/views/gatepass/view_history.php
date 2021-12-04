<table class="table table-bordered" width="100%">
	<tr>
		<td align="center"><label>Date Returned</label></td>							
		<td align="center"><label>Qty</label></td>							
	</tr>
	<?php foreach($returned as $gp_itms){ ?>
	<tr>
		<td align="center"><?php echo $gp_itms->date_returned;?></td>
		<td align="center"><?php echo $gp_itms->qty;?></td>
	</tr>
	<?php } ?>
</table>