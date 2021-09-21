<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/restock.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/restock/restock">Receive </a></li>
			<li class="active"> Delivery Receipt</li>
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
						<?php 
							foreach($restock as $res){
						?>
						<div class="pull-right" style="padding-bottom: 10px">
							<?php if($res['saved']==0){ ?>
							<a href="<?php echo base_url(); ?>index.php/restock/add_restock_first/<?php echo $rhead_id;?>" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span> Update</a>
							<?php } ?>
							<a href="<?php echo base_url(); ?>index.php/restock/mrsf/<?php echo $rhead_id;?>" class="btn btn-warning btn-sm" target = "_blank"><span class="fa fa-print"></span> Print</a>
						</div>	
						<table style="border-top: 1px solid #dedede" width="100%">	
							<tr>
								<td colspan="5"><br></td>
							</tr>
							<tr>
								<td width="1%"><p class="nomarg"><strong>Date:</strong></p></td>
								<td width="20%"><label class="labelStyle"><?php echo date('F j, Y',strtotime($res['date'])); ?></label></td>
								<td width="5%"></td>
								<!-- <td><a onclick="" class="btn btn-info btn-sm"><span class="fa fa-pencil"></span></a></td> -->
							</tr>
							<tr>
								<td><p class="nomarg"><strong>From PR:</strong></p></td>
								<td><h5 class="nomarg"><?php echo $res['from_pr'];?></h5></td>
								<td width="5%"></td>
							</tr>
							<tr>
								<td><p class="nomarg"><strong>Department:</strong></p></td>
								<td><h5 class="nomarg"><?php echo $res['department'];?></h5></td>
								<td width="5%"></td>
							</tr>
							<tr>
								<td><p class="nomarg"><strong>End-Use #:</strong></p></td>
								<td><h5 class="nomarg"><?php echo $res['enduse'];?></h5></td>
								<td width="5%"></td>
							</tr>
							<tr>
								<td><p class="nomarg"><strong>Purpose:</strong></p></td>
								<td> <h5 class="nomarg"><?php echo $res['purpose'];?></h5></td>
								<td width="5%"></td>
							</tr>
						</table>
						<?php if(!empty($details)){  ?>
						<div class="col-lg-12">
							<div class="row border-class shadow">
								<div style="padding:0px 15px">
									<table width="100%" class="table table-bordered " style="font-size: 15px">
									<tr >
											<th class="tr-bottom" width="5%"><center>Item No.</center></th>
											<th class="tr-bottom" width="15%"><center>Quantity</center></th>
											<th class="tr-bottom" width="15%"><center>Item Description</center></th>
											<th class="tr-bottom" width="5%"><center>Supplier</center></th>
											<th class="tr-bottom" width="5%"><center>Brand</center></th>
											<th class="tr-bottom" width="10%"><center>Catalog No.</center></th>
											<th class="tr-bottom" width="10%"><center>Serial No.</center></th>
											<th class="tr-bottom" width="5%"><center>Reason</center></th>
											<th class="tr-bottom" width="20%"><center>Remarks</center></th>
										</tr>
										<?php 
											$x = 1;
											foreach($details as $det){
												if($res['rhead_id'] == $det['rhead_id']) {
										?>
										<tr>
											<td><center><?php echo $x;?></center></td>
											<td><?php echo $det['qty'];?></td>
											<td><?php echo $det['item'];?></td>
											<td><?php echo $det['supplier'];?></td>
											<td><center><?php echo $det['brand'];?></center></td>
											<td><center><?php echo $det['catalog_no'];?></center></td>
											<td><center><?php echo $det['serial'];?></center></td>
											<td><?php echo $det['reason'];?></td>
											<td><?php echo $det['remarks'];?></td>
										</tr>
										<?php  } $x++; }  ?>
									</table>
								</div>
							</div>
							<hr>
							<?php if($saved==0){ ?>
							<button onclick="SaveRes('<?php echo $rhead_id; ?>','<?php echo base_url(); ?>')" class="btn btn-warning" style="width:100%;background: #ff5d00">Save</button>
							</div>
							<?php } } }?>
					</div>
				</div>
			</div>
		</div>
	</div>
