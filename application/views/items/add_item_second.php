<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/item.js"></script>
<!-- <style type="text/css">
	.arrow-top{
	    content: "";
	    position: absolute;
	    top: -6%;
	    left: 93%;
	    transform: rotate(180deg);
	    margin-left: -5px;
	    border-width: 5px;
	    border-style: solid;
	    border-color: #e66513 transparent transparent transparent;
	}
	.arrow-top2{
	    content: "";
	    position: absolute;
	    top: -14%;
	    left: 7%;
	    transform: rotate(180deg);
	    margin-left: -5px;
	    border-width: 5px;
	    border-style: solid;
	    border-color: #e66513 transparent transparent transparent;
	}
	ul.arrow:before{
		content: "";
	    top: -6%;
	    left: 7%;
	    position: absolute;
	    -ms-transform: rotate(180deg); /* IE 9 */
	    -webkit-transform: rotate(20deg); /* Safari 3-8 */
	    transform: rotate(180deg);
	    margin-left: -5px;
	    border-width: 5px;
	    border-style: solid;
	    border-color: #e66513 transparent transparent transparent;
	}
</style> -->
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/items/item_list">Items </a></li>
			<li class="active"> Add New</li>
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
						<div style="padding: 20px 50px 20px 50px">
							<div class="col-lg-12">
								<form>
									<?php 
									
									foreach($item AS $it){ ?>
									<p class="pname pborder-bottom"  name="category"><?php echo strtoupper($it->item_name); ?></p><input type="hidden" name="item_id" id="item_id" value="<?php echo $it->item_id; ?>">
									<?php } ?>
									<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-3">
											<label for="supplier">Supplier:</label>
											<select class="form-control" name="supplier" id="supplier">
												<option value='' selected>-Select Supplier-</option>
												<?php foreach($supplier AS $sup){ ?>
												<option value="<?php echo $sup->supplier_id; ?>"><?php echo $sup->supplier_name; ?></option>
												<?php } ?>
											</select>
											<span id="supplier-check" class='img-check'></span>
										</div>
										<div class="col-lg-3">
											<label for="catalog">Catalog No.:</label>
											<input class="form-control"  type="text" name="catalog" id="catalog" >
											<span id="catalog-check" class='img-check'></span>
										</div>
										<div class="col-lg-3">
											<label for="brand">Brand:</label>
											<input class="form-control" type="text" name="brand" id="brand">
											<span id="suggestion-brand" ></span>
											<span id="brand-check" class='img-check'></span>
										</div>
										
										
										<div class="col-lg-2">
											<label for="ucost">Unit Cost:</label>
											<input class="form-control"  type="text" name="ucost" id="ucost">
										</div>
										<div class="col-lg-1">
											<label for="add_btn" style="color:white"> _____</label>
											<input type='button' class="btn btn-warning btn-md" name="add_btn"  value='Add' id='add_item' onclick='check_supplier_item()'>
										</div>
									</div>
									<hr>
									
									<div class="row">
										<table class="table table-hover table-bordered">
											<thead>
												<tr>
													<th><span class="fa fa-reorder"></span></th>
													<th>Supplier</th>
													<th>Catalog No.</th>
													<th>Brand</th>
													<th>Serial</th>
													<th>Unit Cost</th>
													<th>Quantity</th>
													<!-- <th><center><span class="fa fa-times"></span></center></th> -->
													<!-- <th><center><span class="fa fa-pencil"></span></center></th> -->
												</tr>
											</thead>
											<tbody>
											<?php
											$count=count($supplier_item);
											if($count!=0){ 
											 foreach($supplier_item as $si){ ?>
												<tr>
													<td align="center">
														<li class="dropdown" style="list-style:none;margin:0px;height:10px" title="Serial Number">
															<a onclick="addSerial('<?php echo base_url();?>','<?php echo $si['si_id'];?>','<?php echo $id;?>')" class="dropdown-toggle count-info" data-toggle="dropdown" href="#" style="padding-left: 0px!important">
																<h4 style="margin:0px">
																	<span class="fa fa-reorder"></span>
																</h4>
															</a>
															<!-- <ul class="dropdown-menu dropdown-alerts animated fadeInUp arrow" style="top:20px;border:1px solid #e66614;left: -15px;width:300px">
															
																<li style="padding:10px">																	
																	<table class="table table-hover table-bordered" style="margin:0px">
																		<tr>
																			
																		</tr>
																		<?php// foreach($serial AS $ser){ ?>
																		<tr><td><?php //echo $ser['serial']; ?></td></tr>
																		<?php// } ?>

																	</table>
																</li>
															</ul>  -->
														</li>
													</td>
													<td><?php echo $si['supplier']; ?></td>
													<td><?php echo $si['catalog']; ?></td>
													<td><?php echo $si['brand']; ?></td>
													<td><?php echo substr($si['serial'],0,-2); ?></td>
													<td><?php echo $si['item_cost']; ?></td>
													<td><?php echo $si['quantity']; ?></td>
													<!-- <td><center><a href="<?php echo base_url(); ?>index.php/items/delete_supp_item/<?php echo $si['si_id'] ."/". $id; ?>" onclick="return confirm('Are you sure you want to delete this item?')" style="color:red;" title='Delete'><span class="fa fa-times"></span></a></center></td> -->
													<!--<td><center>
														<a href="javascript:void(0)" onclick="updateBrand('<?php //echo base_url();?>','<?php //echo $si['si_id'] ?>','<?php //echo $id;?>')" >
															<!--<span class="fa fa-pencil"></span>
														</a>
													</center></td>-->
												</tr>												
											<?php }
											} else { ?>
												<tr>
													<td colspan='8'>There are no added items yet.</td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
									
									<hr>	
									<div class="row" style="padding: 0px 0px 50px 0px">
										<div class="col-lg-12"><a href="../item_list" class="btn btn-warning form-control" style="background: #ff5d00">DONE</a></div>
										
									</div>
									<input type="hidden" name="brandid" id="brandid">
									<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function addSerial(baseurl, id, itemid) {
		  window.open(baseurl+"index.php/items/add_serial/"+id+"/"+itemid, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100px,left=460px,width=500,height=200");
		}
		function updateBrand(baseurl, id,itemid) {
		  window.open(baseurl+"index.php/items/update_brand/"+id+"/"+itemid, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100px,left=460px,width=500,height=250");
		}
	</script>

	