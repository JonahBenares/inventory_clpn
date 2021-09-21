<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/receive.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/Styles/bootstrap-select.min.css" />
<style type="text/css">
	body{
		padding:0px;
	}
	#item-check{	
	color:red;
	font-style: italic;
	}
	.img-check{	
		color:red;
		font-style: italic;
	}
	.remove_filter{
		color:red; 
		font-size:10px; 
		font-style:italic;
	}

	#name-item{
	        float:left;
	        list-style:none;
	        margin-top:-3px;
	        padding:0;
	        width:93%;
	        position: absolute;
	        z-index:100;
	    }
	#name-item li:hover {
	    cursor: pointer;
	    font-weight: bold;
	    color: black;
	    text-transform: uppercase;
	    background-position: right center;      
	    box-shadow: 0px 1px 20px 0px #ff8900
	}
	#name-item li {
	    padding:5px 10px 5px 10px;
	    background-image: linear-gradient(to right, #fbb39e 10%, #fff1c4 50%, #fbb39e 100%);
	    border-bottom: #a88748 2px solid;
	    border-radius: 5px;
	    transition: 0.5s;   
	    background-size: 200% auto;
	}

</style>

<div class="col-sm-12 col-md-12 col-lg-12 main">
	<div class="row">
		<div class="col-lg-12">
			<br>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading">
					Add New PR/JO
					<div class="pull-right">
						<a class="animated pulse infinite clickable btn-info btn shadow"  href="<?php echo base_url(); ?>index.php/items/add_item_first" target='_blank'>
							<span class="fa fa-plus"></span> Add New Item
						</a>
						<a class="animated pulse infinite btn clickable btn-success shadow"  data-toggle="modal" data-target="#PRModal" style="border:1px solid #75c700">
							<span class="fa fa-plus"></span> Add New PR/JO #
						</a>
						<a class="animated pulse infinite  clickable btn btn-warning shadow"  data-toggle="modal" data-target="#myModal" style="border:1px solid #d68a00">
							<span class="fa fa-plus"></span> Add New Brand
						</a>
					</div>
				</div>
				<div class="panel-body">
					<form id='PRform'>
					<div class="canvas-wrapper">
						<div class="row">
							<?php if(!isset($rdid)) { ?>
							<div class="col-lg-2 col-lg-offset-1">
								<h5>
									PR/JO#: 
									<select name="prno" id='prno' class="form-control select3" data-live-search="true" onchange="choosePRrec()">
										<option value = ""></option>
										<?php foreach($pr_list AS $pr){ ?>
										<option value = "<?php echo $pr->pr_no;?>"><?php echo $pr->pr_no;?></option>
										<?php } ?>
									</select>
								</h5>
								
								<!-- <h5>PR/JO#: <input type="text" name="prno" id='prno' class="form-control" autocomplete="off">
									<span id="suggestion-prno"></span></h5> -->
							</div>
							<div class="col-lg-2">
								<h5>Department: 

									<select name="department" id='department' class="form-control">
										<option value = ""></option>
										<?php foreach($department AS $dep){ ?>
										<option value = "<?php echo $dep->department_id;?>"><?php echo $dep->department_name;?></option>
										<?php } ?>
									</select>
								</h5>
							</div>


							<div class="col-lg-2">
								<h5>End-Use: 
									<select name="enduse" id='enduse' class="form-control">
										<option value = ""></option>
										<?php foreach($enduse AS $end){ ?>
										<option value = "<?php echo $end->enduse_id;?>"><?php echo $end->enduse_name;?></option>
										<?php } ?>
									</select>
								</h5>
							</div>	

								<div class="col-lg-2">
								<h5>Purpose: 
									<select name="purpose" id='purpose' class="form-control">
										<option value = ""></option>
										<?php foreach($purpose AS $pur){ ?>
										<option value = "<?php echo $pur->purpose_id;?>"><?php echo $pur->purpose_desc;?></option>
										<?php } ?>
									</select>

							
								</h5>
							</div>	
							
							<div class="col-lg-2">
									<h5>Inspected By:
									<select class="form-control" name='inspected' id='inspected'>
										<option value = ''></option>
										<?php foreach($employee AS $emp){ ?>
										<option value = "<?php echo $emp['empid'];?>"><?php echo $emp['empname'];?></option>
										<?php } ?>
									</select>
									</h5>
								</div>	
						
							<input type="hidden" name="rdid" id='rdid' value='0'>
							<?php } else { 
								foreach($details AS $det) { ?>

								<div class="col-lg-2 col-lg-offset-1">
									<h5>PR#:
										<!-- <input type="text" name="prno" id='prno' value='<?php echo $det['prno']; ?>' class="form-control"> -->
										<select name="prno" id='prno' class="form-control select3" onchange="choosePRrec()">
											<option value = ""></option>
											<?php foreach($pr_list AS $prs){ ?>
											<option value = "<?php echo $prs->pr_no;?>" <?php echo (($det['prno'] == $prs->pr_no) ? ' selected' : ''); ?>><?php echo $prs->pr_no;?></option>
											<?php } ?>
										</select>
									</h5>
									<!--<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#PRModal">
										<span class="fa fa-plus"></span>
									</a>-->
								</div>
								<div class="col-lg-2">
									<h5>Department: 
										<select name="department" id='department' class="form-control">
											<option value = ""></option>
											<?php foreach($department AS $dep){ ?>
											<option value = "<?php echo $dep->department_id;?>" <?php echo (($det['department_id'] == $dep->department_id) ? ' selected' : '');?>><?php echo $dep->department_name;?></option>
											<?php } ?>
										</select>
									</h5>
								</div>	
								<div class="col-lg-2">
									<h5>End-Use: 
									<select name="enduse" id='enduse' class="form-control">
										<option value = ""></option>
										<?php foreach($enduse AS $end){ ?>
										<option value = "<?php echo $end->enduse_id;?>" <?php echo (($det['enduse_id'] == $end->enduse_id) ? ' selected' : '');?>><?php echo $end->enduse_name;?></option>
										<?php } ?>
									</select>
									</h5>
								</div>	
								<div class="col-lg-2">
									<h5>Purpose: 
									<select name="purpose" id="purpose" class="form-control">
										<option value = ""></option>
										<?php foreach($purpose AS $pur){ ?>
										<option value = "<?php echo $pur->purpose_id;?>" <?php echo (($det['purpose_id'] == $pur->purpose_id) ? ' selected' : '');?>><?php echo $pur->purpose_desc;?></option>
										<?php } ?>
									</select>
									</h5>
								</div>	
								<div class="col-lg-2">
									<h5>Inspected By:
									<select name="inspected" id="inspected" class="form-control">
										<option value = ""></option>
										<?php foreach($employee AS $emp){ ?>
										<option value = "<?php echo $emp['empid'];?>" <?php echo (($det['inspected'] == $emp['empid']) ? ' selected' : '');?>><?php echo $emp['empname'];?></option>
										<?php } ?>
									</select>
									</h5>
								</div>
								<input type="hidden" name="rdid" id='rdid' value='<?php echo $rdid; ?>'>
							<?php 
								}
							} ?>
							
						</div>
					
						<div style="background-color: #fbecd0; padding: 15px;border-radius: 10px; box-shadow: inset 0px 0px 5px 1px #c7c4c4;">
							<div class="row" >
								<div class="col-lg-6">
									<p style="margin:0px" for="">Item Description:</p>
									<!-- <textarea name = "item" id = "item" class="form-control" rows="1" autocomplete="off"></textarea>
									 <span id="suggestion-item"></span> -->
									<select name="item" id='item' class="form-control select2" onchange="chooseItem()">
										<option value = ""></option>
										<?php foreach($items AS $itm){ ?>
										<option value = "<?php echo $itm->item_id;?>"><?php echo $itm->original_pn." - ".$itm->item_name;?></option>
										<?php } ?>
									</select>
									 <input type='hidden' name='item_id' id='item_id'>
									 <input type='hidden' name='item_name' id='item_name'>
									 <input type='hidden' name='original_pn' id='original_pn1'>
									 <input type='hidden' name='unit' id='unit'>
								</div>
														
								<div class="col-lg-2">
									<p  style="margin:0px" for="">Brand:</p>
									<!-- <input type class="form-control" name='brand' id='brand' autocomplete="off">
									<span id="suggestion-brand"></span> -->
									<select name="brand" id='brand' class="form-control select2" onchange="chooseBrand()">
										<option value = ""></option>
										<?php foreach($brand AS $brnd){ ?>
										<option value = "<?php echo $brnd->brand_id;?>"><?php echo $brnd->brand_name;?></option>
										<?php } ?>
									</select>
									
									<input type='hidden' name='brand_id' id='brand_id'>
									<input type='hidden' name='brand_name' id='brand_name'>
								</div>	
								<div class="col-lg-2">
									<p style="margin:0px" for="">Catalog No.:</p>
									<input type="text" name="catalog_no" id="catalog_no" class="form-control">
								</div>
								<div class="col-lg-2">
									<p style="margin:0px" for="">Serial No. :</p>
									<input type="text" name="serial" id="serial" class="form-control" autocomplete="off">
									<span id="suggestion-serial"></span>
									<input type='hidden' name='serial_id' id='serial_id'>
								</div>													
							</div>
							<div class="row" >
							<div class="col-lg-6">
									<p style="margin:0px" for="">Supplier:</p>
									<!-- <input class="form-control" name="supplier" id="supplier" autocomplete="off">
									<span id="suggestion-supplier"></span> -->
									<select name="supplier" id='supplier' class="form-control select2" onchange="chooseSupplier()">
										<option value = ""></option>
										<?php foreach($supplier AS $sup){ ?>
										<option value = "<?php echo $sup->supplier_id;?>"><?php echo $sup->supplier_name;?></option>
										<?php } ?>
									</select>
									<input type='hidden' name='supplier_name' id='supplier_name'>
									<input type='hidden' name='supplier_id' id='supplier_id'>
								</div>		
								<div class="col-lg-2">
									<p style="margin:0px" for="">Net Cost/U:</p>
									<input type="text" name="unit_cost" id="unit_cost" class="form-control">
								</div>		
								<div class="col-lg-2">
									<p style="margin:0px"  for="">Expected Qty:</p>
									<input class="form-control" name='exp_qty' id='exp_qty' onkeypress="return isNumberKey(this, event)" >
								</div>
								<div class="col-lg-2">
									<p  style="margin:0px" for="">Delivered/ Received:</p>
									<input class="form-control" name='rec_qty' id='rec_qty' onkeypress="return isNumberKey(this, event)" >
								</div>															
							</div>
							<div class="row">
								<div class="col-lg-4">
									<p  style="margin:0px" for=""><br>Remarks:</p>
									<textarea class="form-control" rows="1" name='remarks' id='remarks'></textarea>
								</div>
								<div class="col-lg-2">
									<p style="margin:0px"  for="">Shipping/U & Other Related Cost:</p>
									<input class="form-control" name='shipping_fee' id='shipping_fee' onkeypress="return isNumberKey(this, event)" >
								</div>
								<!--<div class="col-lg-2">
									<p style="margin:0px"  for=""><br>Expiry</p>
									<input class="form-control" type="date" name='expiration_date' id='expiration_date' >
								</div>-->
								<div class="col-lg-2">
									<p style="margin:0px"  for=""><br>Currency:</p>
									<input class="form-control" name='currency' id='currency' >
								</div>
								<div class="col-lg-1">
									<br>
									<!-- <p  style="margin:0px" for="">Local:</p>
									<input type = "radio" name='local_mnl' id='local_mnl' value = "1">
									<p style="margin:0px" for="">Manila:</p>
									<input type = "radio" name='local_mnl1' id='local_mnl' value = "2"> -->
									<!-- <input type="radio" name="local_mnl" value="1" id = "local_mnl">Local
									<input type="radio" name="local_mnl1" value="2" id = "local_mnl1">Manila -->
									<input type="radio" name="local_mnl" id = 'local' value="1"> Local<br>
  									<input type="radio" name="local_mnl" id = 'manila' value="2"> Manila<br>
								</div>
								
								<!-- <div class="col-lg-2">
									<p style="margin:0px" for="">Inspected By:</p>
									<select class="form-control" name='inspected' id='inspected'>
										<option value = ''></option>
										<?php foreach($employee AS $emp){ ?>
										<option value = "<?php echo $emp['empid'];?>"><?php echo $emp['empname'];?></option>
										<?php } ?>
									</select>
								</div>	
								 -->
								<div class="col-lg-1">
									<br>
									<div id='alerto' style="font-weight:bold"></div>
									<a class="btn btn-primary btn-outlined btn-md" id='additem' style="margin-top:5px; " onclick='add_item()'><span class="fa fa-plus"></span></a>
								</div>
							</div>	
						</div>
						<br>
						<div style="overflow-y: scroll;">
							<table style="width: 3000px;">
								<tr>
									<td>
										<table  class="table table-bordered " style="font-size: 12px">
											<tr>
												<th class="tr-bottom" style="width: 5px;"><center>Item No.</center></th>
												<th class="tr-bottom" style="width: 140px;"><center>Supplier</center></th>
												<th class="tr-bottom" style="width: 140px;"><center>Description</center></th>
												<th class="tr-bottom" style="width: 80px;"><center>Brand</center></th>
												<th class="tr-bottom" style="width: 60px;"><center>Cat No.</center></th>
												<th class="tr-bottom" style="width: 50px;"><center>Serial No.</center></th>
												<th class="tr-bottom" style="width: 40px;"><center>Net Cost/U</center></th>
												<th class="tr-bottom" style="width: 100px;"><center>Shipping/U & Other Related Cost</center></th>
												<th class="tr-bottom" style="width: 100px;"><center>Total Unit NET Cost</center></th>
												<th class="tr-bottom" style="width: 40px;"><center>Expected Qty</center></th>
												<th class="tr-bottom" style="width: 40px;"><center>Delivered / Received</center></th>
												<th class="tr-bottom" style="width: 40px;"><center>UOM</center></th>
												<th class="tr-bottom" style="width: 40px;"><center>Total Net Cost</center></th>
												<th class="tr-bottom" style="width: 40px;"><center>Remarks</center></th>
												<th class="tr-bottom" style="width: 40px;"><center>Local/Manila</center></th>
												<!--<th class="tr-bottom" style="width: 40px;"><center>Expiry</center></th>-->
												<th class="tr-bottom" style="width: 5px;"><center>Action</center></th>
											</tr>
											<?php 
											if(isset($rdid)){
												$count= count($receive_items); 
												?>
												<tbody id="item_body">
												<?php if($count==0) { ?>
													<tr><td colspan='14'><center>No items added.</center></td></tr>
												<?php } else { 
													$x=1;
													foreach($receive_items AS $ri) { ?>
													<tr>
														<td><center><?php echo $x; ?></center></td>
														<td><center><?php echo $ri['supplier']; ?></center></td>
														<td><center><?php echo $ri['item']; ?></center></td>
														<td><center><?php echo $ri['brand']; ?></center></td>
														<td><center><?php echo $ri['catalog_no']; ?></center></td>
														<td><center><?php echo $ri['serial']; ?></center></td>
														<td><center><?php echo $ri['unit_cost']; ?></center></td>
														<td><center><?php echo $ri['shipping_fee']; ?></center></td>
														<td><center><?php echo $ri['total']; ?></center></td>
														<td><center><?php echo $ri['expqty']; ?></center></td>
														<td><center><?php echo $ri['recqty']; ?></center></td>
														<td><center><?php echo $ri['unit']; ?></center></td>
														<td><center><?php echo $ri['total_net_cost']; ?></center></td>
														<td><center><?php echo $ri['remarks']; ?></center></td>
														<td><center><?php echo $ri['local_mnl']; ?></center></td>
														<!--<td><center><?php echo $ri['expiration_date']; ?></center></td>-->
														<td><center>Expiry</center></td>
														<td><center> <a class="btn btn-danger table-remove btn-xs" onclick="removerecitem('<?php echo $ri['riid']; ?>','<?php echo base_url(); ?>')"><span class=" fa fa-times"></span></a></center></td>
													</tr>
												<?php $x++; } 
													}	 ?>
												
												</tbody>
											<?php
											} else { ?>
												<tbody id="item_body"></tbody>
											<?php } ?>										
										</table>
									</td>
								</tr>
							</table>
						</div>
						<center><div id='alt' style="font-weight:bold"></div></center>
						<input type='hidden' name='receiveid' id='receiveid' value='<?php echo $receiveid; ?>'>
						<input type='hidden' name='counter' id='counter'>
						<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
						<input type='button' class="btn btn-md btn-warning" id='savebutton' onclick='savereceive_PR()' style="width:100%;background: #ff5d00" value='Save'>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add New Brand</h4>
				</div>
				<div class="modal-body">
					<form method="POST">
						<label>Brand Name</label>
						<input type = "text" name = "brandname" id="brandname" class = "form-control option">
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type="hidden" name="baseurl1" id="baseurl1" value="<?php echo base_url(); ?>">
							<input type="button" id = "btnAdd"  class="btn btn-warning" value = "Add" onclick = "addBrand()" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="PRModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add New PR No.</h4>
				</div>
				<div class="modal-body">
					<form method="POST">
						<label>PR No.</label>
						<input type = "text" name = "pr_no" id="pr_no" class = "form-control option">
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type="hidden" name="baseurl2" id="baseurl2" value="<?php echo base_url(); ?>">
							<input type="button" id = "btnAddPR"  class="btn btn-warning" value = "Add" onclick = "addPR()" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
	$('#btnAdd').click(function() {
	    $('#myModal').modal('hide');
	});
	$('#btnAddPR').click(function() {
	    $('#PRModal').modal('hide');
	});

	$( document ).ready(function() {
		/*var itemid = $('#item_id').val();
		var supid = $('#supplier_id').val();
		 if (itemid === '' && supid === '') {*/
		 	document.getElementById('alerto').innerHTML='<b>Fill out Item and Supplier first.</b>'; 
		 	$('#additem').hide();
		// } 
	});

</script>

	