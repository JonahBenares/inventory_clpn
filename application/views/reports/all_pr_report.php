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
			<li class="active">All PR Report</li>
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
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateAllPRReport">
								<table width="100%">
									<tr>
										<td width="15%"><p class="pull-right">Search PR:</p></td>
										<td width="60%">
											<!-- <input type="text" name="pr" id="pr" class="form-control" autocomplete='off'>
											<span id="suggestion-pr"></span> -->
											<select name="pr" id='pr' class="form-control select2" onchange="choosePRS()" style="margin:4px;width:100%">
												<option value = "">-Choose PR-</option>
												<?php foreach($pr_rep AS $prs){ ?>
												<option value = "<?php echo $prs->pr_no;?>"><?php echo $prs->pr_no;?></option>
												<?php } ?>
											</select>
											<br>
											<input type="hidden" name="prid" id="prid">
										</td>
										<td align="center"><div id='alrt' style="font-weight:bold"></div></td>
										<td>
											<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
											<input type="submit" name="search_inventory" id="submit" value='Generate Report' class="btn btn-warning" >
										</td>
									</tr>
								</table>
							</form>
							<br>
							<?php 


							if(!empty($list)){ ?>
							<div id="printableArea">
								<p class="pname"><?php echo $pr_disp; ?><button id="printReport" class="btn btn-md btn-primary pull-right " onclick="printDiv('printableArea')">Print</button></p>
								<p class="nomarg"><strong>End-Use: <?php echo $enduse; ?></strong></p>
								<p ><strong>Purpose: <?php echo $purpose; ?></strong> </p>
								<table class="table table-hover table-bordered">
									<thead>
										<tr>
											<td align="center"><strong>Item</strong></td>
											<td align="center"><strong>Received Qty</strong></td>
											<td align="center"><strong>Issued Qty</strong></td>
											<td align="center"><strong>Initial Balance</strong></td>
											<td align="center"><strong>Restock Qty</strong></td>
											<td align="center"><strong>Excess Qty</strong></td>
											<td align="center"><strong>Final Balance</strong></td>
											<td align="center"><strong>Action</strong></td>
										</tr>
									</thead>
									<tbody>		
									<?php 
									
									foreach($list AS $li){ 
										$ex_total  = $li['restockqty'] +  $li['excessqty'];
										//echo $li['in_balance'] . "=".$ex_total;
										?>							
										<tr>
											<td align="center"><strong><?php echo $li['item']; ?></strong></td>
											<td align="center"><strong><?php echo $li['recqty']; ?></strong></td>	
											<td align="center"><strong><?php echo $li['issueqty']; ?></strong></td>	
											<td align="center"><strong><?php echo abs($li['in_balance']); ?></strong></td>		
											<td align="center"><strong><?php echo $li['restockqty']; ?></strong></td>
											<td align="center"><strong><?php echo $li['excessqty']; ?></strong></td>		
											<td align="center"><strong><?php echo $li['final_balance']; ?></strong></td>			
											<td align="center">
											<?php if($li['excessqty']==0 && $li['restockqty']==0 && $li['in_balance']!=0 || ($li['in_balance'] > $ex_total)){ ?>
												<a href="<?php echo base_url(); ?>index.php/reports/tagexcess/<?php echo $pr; ?>/<?php echo $li['item_id']; ?>/<?php echo $li['in_balance']; ?>" class="btn btn-md btn-danger" onclick="return confirm('Are you sure you want to tag as excess?')">Tag as Excess</a>
											<?php } ?></td>
											
										</tr>
									<?php } ?>
									</tbody>
								</table>
								<table width="100%" id="prntby">
					                <tr>
					                    <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
					                </tr>
					            </table> 
							</div>
						<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>