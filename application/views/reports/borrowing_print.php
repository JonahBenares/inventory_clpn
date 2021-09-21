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
											<td align="center"><strong>MReqF#</strong></td>
											<td width="14%" align="center"><strong>Item Description</strong></td>
											<td width="14%" align="center"><strong>Supplier</strong></td>
											<td width="14%" align="center"><strong>Brand</strong></td>
											<td width="14%" align="center"><strong>Remarks</strong></td>
											<td align="center"><strong>Original PR</strong></td>
											<td align="center"><strong>Borrowed From PR</strong></td>
											<td align="center"><strong>Qty</strong></td>
										</tr>
									</thead>
									<tbody>
										<?php foreach($list AS $li){ ?>
										<tr>
											<td align="center"><?php echo $li['mreqf_no']; ?></td>
											<td align="center"><?php echo $li['item']; ?></td>
											<td align="center"><?php echo $li['supplier']; ?></td>
											<td align="center"><?php echo $li['brand']; ?></td>
											<td align="center"><?php echo $li['remarks']; ?></td>
											<td align="center"><?php echo $li['original_pr']; ?></td>
											<td align="center"><?php echo $li['borrowfrom']; ?></td>
											<td align="center"><?php echo $li['quantity']; ?></td>								
										</tr>
										<?php } ?>
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