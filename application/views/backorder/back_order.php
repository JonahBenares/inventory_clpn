<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/issue.js"></script>
<style type="text/css">
	#name-item{
		width:57%!important;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li>Back Order</li>
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
						<table width="100%" >
							<tr>
								<td width="20%"><label class="pull-right">Choose PR No.:</label></td>
								<td width="60%">
									<select name="mreqf" id="mreqf" class = "form-control select2" >
										<option value='' selected></option>
										<?php 

										foreach($prback AS $pb){  
											if($pb['received']!=0){ ?>
											<option value="<?php echo $pb['rdid']; ?>"><?php echo $pb['pr_no']." - ".$pb['item']; ?></option>
										<?php } 
									 } ?>
									</select>
								<td><input type='submit' class="btn btn-warning" value="Load" onclick="loadBackOrder()"></td>					
							</tr>
						</table>
						<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
						<hr>
						<form id='issueform'>
						<?php 
						if(!empty($id)){ 

						foreach($details AS $hd) {
						?>
						<table width="100%">
							<tr>
								<td ><p class="nomarg">Date:</p></td>
								<td ><input type="date" name="receive_date" id="receive_date" value="<?php echo date('Y-m-d'); ?>"></td>
								<td><p class="nomarg">SI/OR No.:</p></td>
								<td> <input type="text" name="si_no" id="si_no"></td>
								<td >
									<a class="animated pulse infinite  clickable btn btn-warning shadow pull-right"  data-toggle="modal" data-target="#myModal" style="border:1px solid #d68a00">
										<span class="fa fa-plus"></span> Add New Brand
									</a>
								</td>
							</tr>
							<tr>
								<td ><p class="nomarg">Department:</p></td>
								<td ><label class="labelStyle"><?php echo $hd['department']; ?></label></td>
								
							</tr>
							<tr>
								<td width="10%"><p class="nomarg">Purpose:</p></td>
								<td width="30%"> <h5 class="nomarg"><?php echo $hd['purpose']; ?></h5></td>
								
								<td width="15%">
								</td>
							</tr>
							<tr>
								<td><p class="nomarg">End Use:</p></td>
								<td> <h5 class="nomarg"><?php echo $hd['enduse']; ?></h5></td>
								
							</tr>
							<tr>
								<td><p class="nomarg">JO / PR #:</p></td>
								<td> <h5 class="nomarg"><?php echo $hd['prno']; ?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">PO No.:</p></td>
								<td> <input type="text" name="po_no" id="po_no"></td>
							</tr>
							<tr>
								<td><p class="nomarg">DR No.:</p></td>
								<td><input type="text" name="dr_no" id="dr_no"></td>
							</tr>
						</table>
						<input type="hidden" name="receive_id" id="receive_id" value="<?php echo $hd['receiveid']; ?>">
						 <input type='hidden' name='rdid' id='rdid' value="<?php echo $hd['rdid']; ?>">
						<?php } ?>
						<hr>
						
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-bordered table-hover">
									<tr>
										<th style='text-align: center;'>Receive Qty</th>
										<th style='text-align: center;'>Back Order Qty </th>
										<th style='text-align: center;'>Unit Price</th>
										<th style='text-align: center;'>Cat No.</th>
										<th style='text-align: center;'>Supplier</th>
										<th style='text-align: center;'>Item Description</th>
										<th style='text-align: center;'>Brand</th>
										<th style='text-align: center;'>Total Cost</th>
										<th style='text-align: center;'>Remarks</th>
									</tr>
									<tbody id="item_body">
										<?php 
										$ct=0;
										if(!empty($items)){
										foreach($items AS $it) {
										if($it['quantity']!=0){ ?>
										<tr>
											
											<td>
												<input type='number' name='quantity[]' id="quantity<?php echo $ct; ?>" value="<?php echo $it['quantity']; ?>" style='width:50px' max="<?php echo $it['quantity']; ?>" onkeyup="changeQty(<?php echo $ct; ?>)">
											</td>
											<td><center><?php echo $it['quantity']; ?></center></td>
											<td>
												<input type='text' name='item_cost[]' id="item_cost<?php echo $ct; ?>" value="<?php echo $it['item_cost']; ?>" style='width:90px' onkeyup="changePrice(<?php echo $ct; ?>)">
											</td>
											<td><?php echo $it['catalog_no']; ?></td>
											<td>
												<?php //echo $it['supplier']; ?>
												<select name ="supplier[]" class="form-control select2" style='width:280px'>
													<option>--Select Supplier--</option>
													<?php foreach($supplier AS $s){ ?>
													<option value="<?php echo $s->supplier_id; ?>" <?php echo ($s->supplier_id==$it['supplier_id']) ? 'selected' : ''?>><?php echo $s->supplier_name; ?></option>
													<?php } ?>
												</select>
											</td>
											<td><?php echo $it['item']; ?></td>
											<td>
												<?php //echo $it['brand']; ?>
												<select name ="brand[]" id='brand' class="form-control select2" style='width:120px' onchange="chooseBrand()">
													<option>--Select Supplier--</option>
													<?php foreach($brand AS $b){ ?>
													<option value="<?php echo $b->brand_id; ?>" <?php echo ($b->brand_id==$it['brand_id']) ? 'selected' : ''?>><?php echo $b->brand_name; ?></option>
													<?php } ?>
												</select>
												<input type='hidden' name='brand_id' id='brand_id'>
											</td>
											<td align="center"><span id="total_cost"><?php echo number_format($it['total_cost'],2); ?></span></td>
											<td><textarea name='remarks[]' id='remarks[]'></textarea>
											</td>
											
										</tr>
										<input type='hidden' name='expqty[]' value="<?php echo $it['quantity']; ?>" style='width:50px' max="<?php echo $it['quantity']; ?>">
										 <input type='hidden' name='riid[]' value="<?php echo $it['riid']; ?>">
										<!--<input type='hidden' name='uom[]' value="<?php echo $it['uom']; ?>">
										<input type='hidden' name='itemid[]' value="<?php echo $it['item_id']; ?>">
										<input type='hidden' name='supplierid[]' value="<?php echo $it['supplier_id']; ?>">
										<input type='hidden' name='brandid[]' value="<?php echo $it['brand_id']; ?>">
										<input type='hidden' name='pn_no[]' value="<?php echo $it['pn_no']; ?>">
										<input type='hidden' name='catalog_no[]' value="<?php echo $it['catalog_no']; ?>">  -->
										<?php 
										$ct++;
										}
									} 
									?>
									</tbody>
								</table>
								<center><div id='alt' style="font-weight:bold"></div></center>
								<input type="hidden" name="count" id="count" value="<?php echo $ct; ?>">
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								<input type="hidden" name="userid" id="userid" value="<?php echo $_SESSION['user_id']; ?>">
								<input type='button' class="btn btn-md btn-warning"  onclick='saveBackorder()' style="width:100%;background: #ff5d00" value='Save and Print' id ="savebutton">
								
							</div>

						</div>
						<?php }
					}
						 ?>
					</form>
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
			</div>
		</div>
	</div>
<script type="text/javascript">
	$('#btnAdd').click(function() {
	    $('#myModal').modal('hide');
	});
</script>