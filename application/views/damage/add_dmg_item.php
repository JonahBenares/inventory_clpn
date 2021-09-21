<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/damage.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/damage/damage_list">Damage Items </a></li>
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
									<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-6">
											<label for="subcat" >Sub Category:</label>
											<select class="form-control" name="subcat" id='subcat' onChange="chooseSubcat();">
												<option value='' selected>-Choose Sub Category-</option>
												<?php foreach($subcat as $sub) { ?>
												<option value='<?php echo $sub->subcat_id; ?>'><?php echo $sub->subcat_name; ?></option>
												<?php } ?>
											</select>
											<span id="subcat_msg" class='img-check'></span>
										</div>
										<div class="col-lg-6">
											<label for="category">Category:</label>
											<p class="pname pborder"  name="category" id="category"></p>
										</div>
									</div>
									
									<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-6">
											<label for="item_description">Item Name:</label>
											<input class="form-control"  type="text" name="item_description" id="item_description" autocomplete="off">
											 <span id="item-check"></span>
											 <span id="item_msg" class='img-check'></span>
										</div>
										<div class="col-lg-6">
											<label for="pn">Warehouse:</label>
											<select class="form-control"  name="warehouse" id="warehouse">
												<option value='' selected>-Choose Warehouse-</option>
												<?php foreach($warehouse as $wh) { ?>
												<option value='<?php echo $wh->warehouse_id; ?>'><?php echo $wh->warehouse_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									
									<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-6">
											<label for="pn">PN no:</label>
											<input class="form-control"  type="text" name="pn" id="pn">
											<span id="pn_msg" class='img-check'></span>
										</div>
										<div class="col-lg-6">
											<label for="location">Location:</label>
											<select class="form-control"  name="location" id="location">
												<option value='' selected>-Choose Location-</option>
												<?php foreach($location as $lc) { ?>
												<option value='<?php echo $lc->location_id; ?>'><?php echo $lc->location_name; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-6">
											<label for="unit">Unit:</label>
											<!-- <input class="form-control"  type="text" name="unit" id="unit"> -->
											<select class="form-control" name="unit" id="unit">
												<option value='' selected>-Choose Unit-</option>
												<?php foreach($unit AS $uom) { ?>
												<option value='<?php echo $uom->unit_id; ?>'><?php echo $uom->unit_name;?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-6">
											<label for="bin">Bin:</label>
											<input class="form-control"  type="text" name="bin" id="bin" autocomplete="off">
											<span id="suggestion-bin"></span>
										</div>
									</div>

									<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-6">											
											<label for="group">Group:</label>
											<select class="form-control" name="group" id="group">
												<option value='' selected>-Choose Group-</option>
												<?php foreach($group as $gr) { ?>
												<option value='<?php echo $gr->group_id; ?>'><?php echo $gr->group_name; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-lg-6">
											<label for="location">Rack:</label>
											<!-- <input class="form-control"  name="rack" id="rack">	 -->
											<select class="form-control" name="rack" id="rack">
												<option value='' selected>-Choose Rack-</option>
												<?php foreach($rack as $rack) { ?>
												<option value='<?php echo $rack->rack_id; ?>'><?php echo $rack->rack_name; ?></option>
												<?php } ?>
											</select>											
										</div>
									</div>

									<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-6">
											<label for="pn">Barcode:</label>
											<input class="form-control"  type="text" name="barcode" id="barcode">
										</div>
										<div class="col-lg-6">
											<label for="local_mnl">Local/Manila:</label>
											<select class="form-control" name="local_mnl" id="local_mnl">
												<option value='' selected>-Choose Local/Manila-</option>
                                    			<option value = "1">Local</option>
                                    			<option value = "2">Manila</option>
                                			</select>
										</div>
									</div>
									<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-6">
											<label for="pn">Weight (Kg):</label>
											<input type="text" name="weight" id="weight" class="form-control">
										</div>
										<div class="col-lg-6 ">
											<label for="pn">Quantity:</label>
											<input class="form-control"  type="text" name="quantity" id="quantity">
										</div>
									</div>
									<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-6">
											<label for="supplier">Supplier:</label>
											<select class="form-control" name="supplier" id="supplier">
												<option value='' selected>-Select Supplier-</option>
												<?php foreach($supplier AS $sup){ ?>
												<option value="<?php echo $sup->supplier_id; ?>"><?php echo $sup->supplier_name; ?></option>
												<?php } ?>
											</select>
											<span id="supplier-check" class='img-check'></span>
										</div>
										<div class="col-lg-6">
											<label for="catalog">Catalog No.:</label>
											<input class="form-control"  type="text" name="catalog" id="catalog" >
											<span id="catalog-check" class='img-check'></span>
										</div>
										</div>
										<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-6">
											<label for="brand">Brand:</label>
											<input class="form-control" type="text" name="brand" id="brand">
											<span id="suggestion-brand" ></span>
											<span id="brand-check" class='img-check'></span>
										</div>
										<div class="col-lg-6">
											<label for="item_cost">Unit Cost:</label>
											<input class="form-control"  type="text" name="item_cost" id="item_cost">
										</div>
									</div>
									<div class="row" style="padding: 0px 0px 10px 0px">
										<div class="col-lg-6">
											<label for="serial">Serial Number:</label>
											<input class="form-control" type="text" name="serial" id="serial">
											<input class="form-control" type="hidden" name="serial_id" id="serial_id">
											<span id="suggestion-serial" ></span>
											<span id="serial-check" class='img-check'></span>
											<!-- <input  onclick="addSerial('<?php echo base_url();?>','<?php echo $id;?>')" class="form-control"  type="text" name="serial" id="serials_id" > -->
										</div>
										<div class="col-lg-6">
											<label for="remarks">Remarks:</label>
											<input class="form-control"  type="text" name="remarks" id="remarks">
										</div>
									</div>

									
									<div class="row border-class shadow" >
										<div>
											<div class="col-lg-4">
												<label for="pic1">Picture 1:</label>
												<input class="form-control"  type="file" name="pic1" id="img1" onchange="readPic1(this);">
												<div class="thumbnail">
													<img id="pic1" class="pictures" src="<?php echo base_url() ?>assets/default/default-img.jpg" alt="your image" />
												</div>
												<span id="img1-check" class='img-check'></span>
											</div> 
											<div class="col-lg-4">
												<label for="pic1">Picture 2:</label>
												<input class="form-control"  type="file" name="pic2" id="img2" onchange="readPic2(this);">
												<div class="thumbnail">
													<img id="pic2" class="pictures" src="<?php echo base_url() ?>assets/default/default-img.jpg" alt="your image" />
												</div>
												<span id="img2-check" class='img-check'></span>
											</div>
											<div class="col-lg-4">
												<label for="pic1">Picture 3:</label>
												<input class="form-control"  type="file" name="pic3" id="img3" onchange="readPic3(this);">
												<div class="thumbnail">
													<img id="pic3" class="pictures" src="<?php echo base_url() ?>assets/default/default-img.jpg" alt="your image" />
												</div>
												<span id="img3-check" class='img-check'></span>
											</div>
										</div>
									</div>
									<br>	
									<div class="row" style="padding: 0px 0px 50px 0px">
										<center><div id='alt' style="font-weight:bold"></div></center>
										<div class="col-lg-12"><input type='button' class="btn btn-warning form-control" style="background: #ff5d00" onclick='saveDamageItem()' value='ADD' id="next" name='nextitem'></div>
									</div>
									<input type="hidden" name="category_id" id="category_id">
									<input type="hidden" name="binid" id="binid">
									<input type="hidden" name="pn_format" id="pn_format">
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
		function addSerial(baseurl, id, damageid) {
		  window.open(baseurl+"index.php/damage/add_serial/"+id+"/"+damageid, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100px,left=460px,width=500,height=200");
		}
		function updateBrand(baseurl, id,itemid) {
		  window.open(baseurl+"index.php/damage/update_brand/"+id+"/"+damageid, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100px,left=460px,width=500,height=250");
		}
	</script>