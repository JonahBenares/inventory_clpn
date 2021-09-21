<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>
<style type="text/css">
	#name-item{
		width: 50%!important;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active"> Borrowing Report</li>
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
							<div id="printableArea">
								<table class="table table-hover table-bordered">
									<thead>
										<tr>	
											<td style="width:" align="center"><strong>Product Name</strong></td>
												<td style="width:50px" align="center"><strong>Remaining Days</strong></td>
												<td style="width:50px" align="center"><strong>Expiration Date</strong></td>
												<td style="width:50px" align="center"><strong>Remaining Qty</strong></td>
												<td style="width:50px" align="center"><strong>UOM</strong></td>
												<td style="width:150px" align="center"><strong>PN/ Catalog Number</strong></td>
												<td style="width:150px" align="center"><strong>Brand</strong></td>
												<td style="width:100px" align="center"><strong>Serial No.</strong></td>
												<td style="width:100px" align="center"><strong>PR No.</strong></td>
												<td style="width:150px" align="center"><strong>Location</strong></td>
												<td style="width:150px" align="center"><strong>Rack</strong></td>
												<td style="width:150px" align="center"><strong>Bin</strong></td>
												<td style="width:100px" align="center"><strong>Receive Date</strong></td>
										</tr>
									</thead>
									<tbody>
										<?php 
											foreach($expiry AS $e){ 
												if($e['remaining_qty']!=0){
														?>
										<tr>
											<td align="center"><?php echo $e['item_name']; ?></td>
												<td align="center" <?php echo (($e['remaining_days']<=0) ? " style='color:red;font-weight:900'" : " "); ?>><?php echo $e['remaining_days'] . " day/s"; ?></td>
												<td align="center"><?php echo $e['expiration_date']; ?></td>
												<td align="center"><?php echo $e['remaining_qty']; ?></td>
												<td align="center"><?php echo $e['unit']; ?></td>
												<td align="center"><?php echo $e['catalog_no']; ?></td>
												<td align="center"><?php echo $e['brand']; ?></td>
												<td align="center"><?php echo $e['serial_no']; ?></td>
												<td align="center"><?php echo $e['pr_no']; ?></td>
												<td align="center"><?php echo $e['location']; ?></td>
												<td align="center"><?php echo $e['rack']; ?></td>
												<td align="center"><?php echo $e['bin']; ?></td>
												<td align="center"><?php echo $e['receive_date']; ?></td>								
										</tr>
										<?php } }?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">   
     	$(window).load(function() {
	      	var printContents = document.getElementById('printableArea').innerHTML;
	     	var originalContents = document.body.innerHTML;
	     	document.body.innerHTML = printContents;
	      	window.print();
	    });
	</script>