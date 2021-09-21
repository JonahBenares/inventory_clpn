<?php
	$ci =& get_instance();
?>
<style type="text/css">
	p {
	    margin: 0 0 1px;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/damage/damage_list">Damage Items </a></li>
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
				<div class="panel-heading panel-heading-danger" style="height:20px">
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="col-lg-12">
							<div style="padding: 5px 30px 20px 30px">
								<?php foreach($details AS $det) { ?>
								<table width="100%">
									<tr>
										<td colspan="2" width="95%">
											<h1 class="pname2" style="margin:0;margin-bottom:20px" ><?php echo $det['category'];?></h1> 
										</td>										
										<td style="padding: 0px" width="5%">
											<a href="<?php echo base_url(); ?>index.php/damage/update_dmg_item/<?php echo $det['damage_id']; ?>" class="btn btn-info" title="Update">
												<span class="fa fa-pencil"></span>
											</a>
										</td>
									</tr>
									<!-- <tr>
										<td width="17%"><strong style="font-size: 16px"><center>Available Quantity</center></strong>
											<a href="<?php echo base_url(); ?>index.php/reports/inventory_report" style="padding:1px 10px;margin-bottom: 10px; margin-top:1px;width:100%" class="btn btn-primary animated rubberBand ">
												<p style="color:#fff;font-size:20px">0000</p>
											</a> 
										</td>
										<td>
											<a class=" disabled btn btn-danger animated fadeInDown" style="margin: 22px 20px 10px">
												<span class="fa fa-chain-broken"></span> Damaged
											</a>											
										</td>
										<td></td>
									</tr>
									<tr>
										<td width="17%"><strong>Min Order Quantity:</strong></td>
										<td ><h4>022</h4></td>
										<td></td>
									</tr> -->
								</table>
								<table style="width:100%">
									<tr>
										<td width="15%"><strong>Description:</strong></td>
										<td width="41%"><p class="main_cat"><?php echo $det['item_description'];?></p></td>
										<td width="12%"><strong>Quantity:</strong></td>
										<td width="32%"><p><?php echo $det['quantity'];?></p></td>
									</tr>
									<tr>
										<td ><strong>Sub Category:</strong></td>
										<td ><p><?php echo $det['subcategory'];?></p></td>
										<td ><strong>Unit Cost:</strong></td>
										<td ><p><?php echo $det['item_cost'];?></p></td>
									</tr>
									<tr>
										<td ><strong>Part Number:</strong></td>
										<td ><p><?php echo $det['original_pn'];?></p></td>
										<td ><strong>UOM:</strong></td>
										<td ><p><?php echo $det['unit'];?></p></td>
									</tr>
									<tr>
										<td ><strong>Serial Number:</strong></td>
										<td ><p><?php echo $det['serial'];?></p></td>
										<td ><strong>Catalog No:</strong></td>
										<td ><p><?php echo $det['catalog'];?></p></td>
									</tr>
									<tr>
										<td ><strong>Brand:</strong></td>
										<td ><p><?php echo $det['brand'];?></p></td>
										<td ><strong>Local/Manila:</strong></td>
										<td ><p></p><?php echo $det['local_mnl'] == '1' ? 'Local' : 'Manila' ;?></td>
									</tr>									
								</table>
								<hr>
								<table style="width:100%">
									<tr>
										<td width="15%"><strong>Supplier:</strong></td>
										<td width="41%"><p class="main_cat"><?php echo $det['supplier'];?></p></td>
										<td><strong>Warehouse:</strong></td>
										<td><p><?php echo $det['warehouse'];?></p></td>
									</tr>
									<tr>
										<td ><strong>Location:</strong></td>
										<td ><p><?php echo $det['location'];?></p></td>
										<td ><strong>Group:</strong></td>
										<td ><p><?php echo $det['group'];?></p></td>
									</tr>
									<tr>
										<td ><strong>Bin:</strong></td>
										<td ><p><?php echo $det['bin'];?></p></td>
										<td ><strong>Rack:</strong></td>
										<td ><p><?php echo $det['rack'];?></p></td>
									</tr>
									<tr>
										<td ><strong>Barcode:</strong></td>
										<td ><p><?php echo $det['barcode'];?></p></td>
										<td ><strong>Weight:</strong></td>
										<td ><p><?php echo $det['weight'];?></p></td>
									</tr>								
								</table>
								<hr>
								<table style="width:100%">
									<tr>
										<td width="15%"><strong>Remarks:</strong></td>
									</tr>
									<tr>
										<td width="41%"><p class="main_cat"><?php echo $det['remarks'];?></p></td>
									</tr>
								</table>
								<!-- <h3>Cross Reference</h3> -->
								<!-- <table class="table table-hover table-bordered" style="text-align: center" >
									<thead>
										<tr>
											<th style="text-align: center" width="30%">Supplier</th>
											<th style="text-align: center" width="15%">Catalog No.</th>
											<th style="text-align: center" width="30%">Brand</th>
											<th style="text-align: center" width="30%">Serial No.</th>
											<th style="text-align: center" width="5%">Average Cost per Supplier</th>
											<th style="text-align: center" width="5%">Qty</th>
											<th style="text-align: center" width="10%">Last Item received</th>
											<th style="text-align: center" width="5%"><span class="fa fa-list-alt"></span></th>
										</tr>
									</thead>
									<tbody>
										<tbody>
											<?php 
											
												if(!empty($supplier)){
												$columns = array_column($supplier, 'date');
                                            	$a = array_multisort($columns, SORT_DESC, $supplier);
												foreach($supplier AS $sup){ 
											?>
											<tr>
												<td><?php echo $sup['supplier'];?></td>
												<td><?php echo $sup['catalog_no'];?></td>
												<td><?php echo $sup['brand'];?></td>
												<td><?php echo substr($sup['serial'],0,-2);?></td>
												<td><?php echo $sup['item_cost'];?></td>
												<td><?php echo $sup['quantity'];?></td>
												<td><?php echo $sup['date'];?></td>
												<td>
													<?php 

													if(empty($sup['item_id'])){
														$item='null';
													} else {
														$item= $sup['item_id'];
													}

													if(empty($sup['supplier_id'])){
														$supplier='null';
													} else {
														$supplier= $sup['supplier_id'];
													}

													if(empty($sup['catalog_no'])){
														$cat='null';
													} else {
														$cat= rawurlencode($ci->slash_replace($sup['catalog_no']));
														//$cat= str_replace(" ", "_", $sup['catalog_no']);
													}

													if(empty($sup['brand_id'])){
														$brand='null';
													} else {
														$brand= $sup['brand_id'];
													}
													?>
													<a href="<?php echo base_url(); ?>index.php/reports/stock_card_new/<?php echo $item; ?>/<?php echo $supplier;?>/<?php echo $cat;?>/<?php echo $brand;?>" target = "_blank" class="btn btn-primary" title="STOCK CARD"><span class="fa fa-list-alt"></span></a>
												</td>
											</tr>
											<?php }  
											} else { ?>
												<tr>
												<td colspan='7'><center>No data available.</center></td>
												</tr>
											<?php } ?>
										</tbody>
								</table> -->
								<hr>
								<h3>Pictures</h3>
								<table style="width:100%">
									<tr>
										<td width="33.33333333%" style="padding:10px">
											<div class="thumbnail" style="padding:10px">
												<img id="pic1" class="pictures" src="<?php if(!empty($det['picture1'])) { 
													echo base_url(); ?>uploads/<?php echo $det['picture1']; 
												 } else { echo base_url(); ?>assets/default/default-img.jpg <?php } ?>" alt="your image" />
											</div>
										</td>
										<td width="33.33333333%" style="padding:10px">
											<div class="thumbnail" style="padding:10px">
												<img id="pic1" class="pictures" src="<?php if(!empty($det['picture2'])) { 
													echo base_url(); ?>uploads/<?php echo $det['picture2']; 
												 } else { echo base_url(); ?>assets/default/default-img.jpg <?php } ?>" alt="your image" />
											</div>
										</td>
										<td width="33.33333333%" style="padding:10px">
											<div class="thumbnail" style="padding:10px">
												<img id="pic1" class="pictures" src="<?php if(!empty($det['picture3'])) { 
													echo base_url(); ?>uploads/<?php echo $det['picture3']; 
												 } else { echo base_url(); ?>assets/default/default-img.jpg<?php } ?>" alt="your image" />
											</div>
										</td>
									</tr>
								</table>
								<hr>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	