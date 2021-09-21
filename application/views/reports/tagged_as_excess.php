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
			<li class="active">Tagged as Excess</li>
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
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateTagExcess">
								<table width="100%">
									<tr>
										<td width="15%"><p class="pull-right">Search PR:</p></td>
										<td width="60%">
											<select name="pr" id='pr' class="form-control select2" onchange="choosePRSS()" style="margin:4px;width:100%">
												<option value = "">-Choose PR-</option>
												<?php foreach($tag_pr AS $prss){ ?>
												<option value = "<?php echo $prss->from_pr;?>"><?php echo $prss->from_pr;?></option>
												<?php } ?>
											</select>
											<br>
											<input type="hidden" name="prid" id="prid">
										</td>
										<td align="center"><div id='alrt' style="font-weight:bold"></div></td>
										<td>
											<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
											<input type="submit" name="search_tagexcess" id="submit" value='Generate Report' class="btn btn-warning" >
										</td>
									</tr>
								</table>
							</form>
							<br>
							<?php 
							if(!empty($list)){ ?>
							<div id="printableArea">
								<p class="pname"><?php echo $pr; ?><button id="printReport" class="btn btn-md btn-primary pull-right " onclick="printDiv('printableArea')">Print</button></p>
								<p class="nomarg"><strong>End-Use: <?php echo $enduse; ?></strong></p>
								<p ><strong>Purpose: <?php echo $purpose; ?></strong> </p>
								<table class="table table-hover table-bordered">
									<thead>
										<tr>
											<td align="center"><strong>PO No</strong></td>
											<td align="center"><strong>Item</strong></td>
											<td align="center"><strong>Excess Qty</strong></td>
											<td align="center"><strong>Date Tagged</strong></td>
											<td align="center"><strong>Personnel</strong></td>
										</tr>
									</thead>
									<tbody>	
									<?php 
									foreach($list AS $li){ ?>							
										<tr>
											<td align="center"><strong><?php echo $li['po_no']; ?></td>
											<td align="center"><strong><?php echo $li['item']; ?></td>
											<td align="center"><strong><strong><?php echo $li['excessqty']; ?></strong></td>		
											<td align="center"><strong><strong><?php echo $li['date_tagged']; ?></strong></td>			
											<td align="center"><strong><?php echo $li['tagged_by']; ?></td>
											
										</tr>
										<?php } ?>
									</tbody>
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