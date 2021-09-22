<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/request.js"></script>
<link href="<?php echo base_url(); ?>assets/Styles/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/request/request_list">Gatepass </a></li>
			<li class="active"> Add Gatepass</li>
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
					<form id='gatepassfrm' method = "POST">
						<div class="canvas-wrapper">
							<table width="100%" >
								<tr>
									<td width="10%" ><p class="nomarg">To:</p></td>
									<td width="40%" ><label class="labelStyle">Sample R. Lorem Ipsum</label></td>
									<td width="15%" ><p class="nomarg pull-right">Date Issued:</p></td>
									<td width="50%" colspan="3"><label class="labelStyle">&nbsp; September 19, 2021</label></td>
									<td width="5%" ><a href="<?php echo base_url();?>index.php/gatepass/gatepass_print" class="btn btn-warning btn-sm"><span class="fa fa-print"></span> Print</a></td>
								</tr>
								<tr>
									<td><p class="nomarg">Company: </p></td>
									<td><h5 class="nomarg">Central Negros Power Reliability Inc</h5></td>
									<td><p class="nomarg pull-right">Date Returned:</p></td>
									<td><h5 class="nomarg">&nbsp; September 19, 2021</h5></td>
								</tr>
								<tr>
									<td><p class="nomarg">Destination: </p></td>
									<td><h5 class="nomarg">Bacolod Sety</h5></td>
									<td><p class="nomarg pull-right">MGP No.:</p></td>
									<td><h5 class="nomarg">&nbsp; September 19, 2021</h5></td>
								</tr>
								<tr>
									<td><p class="nomarg">Vehicle No:</p></td>
									<td> <h5 class="nomarg">AVE20199</h5></td>
								</tr>
							</table>
							<hr>
							<div class="row">
								<div class="col-lg-4">							
									<p>
										<select name="item" id='item' class="form-control select2" onchange="chooseItem()">
											<option value = ""> -- Select Item Description -- </option>
											
										</select>
									</p>
								</div>
								<div class="col-lg-2">
									<p>				
										<input placeholder="Quantity" type="text" name="borrowfrom" id="borrowfrom" class="form-control" >
									</p>
								</div>
								<div class="col-lg-2">
									<p>				
										<input placeholder="UOM" type="text" name="borrowfrom" id="borrowfrom" class="form-control" >
									</p>
								</div>
								<div class="col-lg-3">
									<p>				
										<textarea placeholder="Remarks" type="text" name="borrowfrom" id="borrowfrom" class="form-control" rows="1" ></textarea> 
									</p>
								</div>
								<div class="col-lg-1">
									<div id='alrt' style="font-weight:bold"></div>
									<p>				
										<a type="button" onclick='add_item()' class="btn btn-warning btn-md" id = "submit"><span class="fa fa-plus"></span></a>
									</p>
								</div>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
							</div>
							<div class="row">
								<div class="col-lg-12">
									<table class="table table-bordered table-hover">
										<tr>
											<th width="2%" style='text-align: center;'>#</th>
											<th width="48%">Item Description</th>
											<th width="10%" style='text-align: center;'>Qty</th>
											<th width="10%" style='text-align: center;'>UOM</th>
											<th width="25%" style='text-align: center;'>Remarks</th>
											<th width="5%" style='text-align: center;' width="1%">Action</th>
										</tr>
										<tbody id="item_body">
											<tr>
												<td><center>1</center></td>
												<td>"Titanium" 6x19 Steel Core, IWRC Wire Rope, 12mm dia., Zinc Coated, T/S: 180kg/mm2</td>
												<td><center>23</center></td>
												<td><center>Kg</center></td>
												<td><center>Kg</center></td>
												<td><center><a href="" class="btn btn-danger btn-xs"><span class="fa fa-times"></span></a></center></td>
											</tr>
										</tbody>
									</table>
									<center><div id='alt' style="font-weight:bold"></div></center>
									<input type='button' class="btn btn-md btn-warning" id='savebutton' onclick='saveRequest()' style="width:100%;background: #ff5d00" value='Save and Print'>
									<a href="<?php echo base_url();?>index.php/gatepass/gatepass_print">Print</a>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<script>
    $('.select2').select2();
</script>