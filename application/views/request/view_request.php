<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/request.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/request/request_list">Request </a></li>
			<li class="active"> View Details</li>
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
						<table width="100%">
							<?php 
							foreach($head AS $h){
								$saved=$h->saved;
							}
							foreach($req as $r){ ?>
							<tr>
								<td ><p class="nomarg">Department:</p></td>
								<td ><label class="labelStyle"><?php echo $r['department'];?></label></td>
								<td ><p class="nomarg pull-right">MReqf No:</p></td>
								<td colspan="3"><label class="labelStyle">&nbsp<?php echo $r['mreqf'];?></label></td>
								<td width="15%">
									<div class="pull-right">
										<?php if($saved=='0'){ ?>
										<a href="<?php echo base_url(); ?>index.php/request/add_request/<?php echo $r['requestid'];?>" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></a>
										<?php } ?>
										<a href="<?php echo base_url(); ?>index.php/request/mreqf/<?php echo $r['requestid'];?>" class="btn btn-warning btn-sm" target = "_blank"><span class="fa fa-print"></span> Print</a>
									</div>
								</td>
							</tr>
							<tr>
								<td width="10%"><p class="nomarg">Purpose:</p></td>
								<td width="30%"> <h5 class="nomarg"><?php echo $r['purpose'];?></h5></td>
								<td width="10%"><p class="nomarg pull-right">Date:</p></td>
								<td width="10%"><h5 class="nomarg">&nbsp<?php echo $r['date'];?></h5></td>
								<td width="4%"><p class="nomarg">Time:</p></td>
								<td > <h5 class="nomarg"><?php echo $r['time'];?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">End Use:</p></td>
								<td> <h5 class="nomarg"><?php echo $r['enduse'];?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">PR / JO #:</p></td>
								<td> <h5 class="nomarg"><?php echo $r['prno'];?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">Type:</p></td>
								<td> <h5 class="nomarg"><?php echo $r['type'];?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">Remarks:</p></td>
								<td> <h5 class="nomarg"><?php echo $r['remarks'];?></h5></td>
							</tr>
							<?php } ?>
						</table>
						<hr>
						
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-bordered table-hover">
									<tr>
										<th style='text-align: center;'>Qty</th>
										<th style='text-align: center;'>Unit Cost</th>
										<th style='text-align: center;'>Total Cost</th>
										<th style='text-align: center;'>UOM</th>
										<th style='text-align: center;'>Part No.</th>
										<th style='text-align: center;'>Item Description</th>
										<!-- <th style='text-align: center;'>Inv. Balance</th> -->
									</tr>
									<tbody id="item_body">

										<?php 
										if(!empty($req_itm)){
											foreach($req_itm as $req){ ?>
										<tr>
											<td><?php echo $req['qty'];?></td>
											<td><?php echo $req['unit_cost'];?></td>
											<td><?php echo $req['total_cost'];?></td>
											<td><?php echo $req['uom'];?></td>
											<td><?php echo $req['pn'];?></td>
											<td><?php echo $req['item'];?></td>
											<!-- <td><?php echo number_format($req['invqty'],2);?></td> -->
										</tr>
										<?php } } else { ?>
										<tr>
											<td align="center" colspan='9'><center>No Data Available.</center></td>
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
