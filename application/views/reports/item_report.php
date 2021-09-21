<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>
<style type="text/css">
	    #name-item li {width: 50%}
</style>	
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active">Item Report</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<br>
		</div>
	</div><!--/.row-->

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading" style="height:20px">
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="col-lg-12">
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateItemReport">
								<table width="100%">
									<tr>
										<td width="15%"><p class="pull-right">Search Item:</p></td>
										<td>
											<!-- <input type="text" name="item" id="item" class="form-control" autocomplete='off'>
											<span id="suggestion-item"></span> -->
											<select name="item" id='item' class="form-control select2" onchange="chooseItem()">
												<option value = ""></option>
												<?php foreach($item_list AS $itm){ ?>
												<option value = "<?php echo $itm->item_id;?>"><?php echo $itm->original_pn." - ".$itm->item_name;?></option>
												<?php } ?>
											</select>
											<input type="hidden" name="item_id" id="item_id">
										</td>
										<td align="center"><div id='alrt' style="font-weight:bold"></div></td>
										<td>
											<input type="submit" name="search_inventory" id ="submit" value='Generate Report' class="btn btn-warning" >
										</td>
									</tr>
								</table>
							</form>
							<br>
							<div id="printableArea">
								<p class="pname"><?php echo $itemdesc; ?> <button id="printReport" class="btn btn-md btn-primary pull-right " onclick="printDiv('printableArea')">Print</button></p>
								<?php if(!empty($list)){ ?>
								<table class="table table-hover table-bordered">
									<thead>
										<tr>
											<td align="center"><strong>PR No.</strong></td>
											<td align="center"><strong>Enduse</strong></td>
											<td align="center"><strong>Received Qty</strong></td>
											<td align="center"><strong>Issued Qty</strong></td>
											<td align="center"><strong>Initial Balance</strong></td>
											<td align="center"><strong>Restock Qty</strong></td>
											<td align="center"><strong>Excess Qty</strong></td>
											<td align="center"><strong>Final Balance</strong></td>
											<!-- <td align="center"><strong>Restock Qty</strong></td>
											<td align="center"><strong>Balance</strong></td> -->
										</tr>
									</thead>
									<tbody>		
									<?php 
									
									foreach($list AS $li){ ?>							
										<tr>
											<td align="center"><strong><?php echo $li['prno']; ?></strong></td>
											<td align="center"><strong><?php echo $li['enduse']; ?></strong></td>
											<td align="center"><strong><?php echo $li['recqty']; ?></strong></td>	
											<td align="center"><strong><?php echo $li['issueqty']; ?></strong></td>		
											<td align="center"><strong><?php echo abs($li['in_balance']); ?></strong></td>		
											<td align="center"><strong><?php echo $li['restockqty']; ?></strong></td>
											<td align="center"><strong><?php echo $li['excessqty']; ?></strong></td>		
											<td align="center"><strong><?php echo $li['final_balance']; ?></strong></td>
											<!-- <td align="center"><strong><?php echo $li['restockqty']; ?></strong></td>		
											<td align="center"><strong><?php echo $li['total']; ?></strong></td> -->						
										</tr>
									<?php 
									} ?>
									</tbody>
								</table>
								<?php } ?>
								<table width="100%" id="prntby">
					                <tr>
					                    <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
					                </tr>
					            </table> 
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript"></script>