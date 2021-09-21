<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/restock.js"></script>
<style type="text/css">
	.label-info {
    	background-color: #5bc0de;
	}
	#name-item{
		width:36%!important;
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
	    box-shadow: 0px 1px 20px 0px #ff8900;
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
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#">
			<em class="fa fa-home"></em>
		</a></li>
		<li class="active">
			<a href="<?php echo base_url(); ?>index.php/restock/restock_list">
				Restock
			</a>
		</li>
		<li class="active">Add Restock</li>
	</ol>
</div><!--/.row-->
<div class="row">
	<div class="col-lg-12">
		<br>
	</div>
</div><!--/.row-->
<!-- Modal -->		
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading" style="height: 10px">
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="row" style="padding:0px 250px 0px 250px">
							<form id='restockdetails' method = "POST">
								<table width="100%">
									<tr>
										<td style="text-align: center;border-bottom: 1px solid #eaeaea" colspan="2"><h4><strong>Add Restock</strong></h4></td>
									</tr>
									<tr>
										<td width="26%"><label>PR No. :</label></td>		
										<td>
											<!-- <input type = "text" name = "prno" id="pr" class = "form-control" style="margin:4px" autocomplete="off">
											<span id="suggestion-pr"></span> -->
											<select name="prno" id='pr' class="form-control select2" onchange="choosePRres()" style="margin:4px;width:100%">
												<option value = "">-Choose PR-</option>
												<?php foreach($pr_list AS $prs){ ?>
												<option value = "<?php echo $prs->pr_no;?>"><?php echo $prs->pr_no;?></option>
												<?php } ?>
											</select>
										</td>	
									</tr>
									<tr>
										<td width="20%"><label>Department:</label></td>		
										<td>
											<select name="department" id='dept' class="form-control" style="margin:4px">
												<option value = "">-Choose Department-</option>
												<?php foreach($department AS $dep){ ?>
												<option value = "<?php echo $dep->department_id;?>"><?php echo $dep->department_name;?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td width="20%"><label>Purpose:</label></td>		
										<td>
											<select name="purpose" id='pur' class="form-control" style="margin:4px">
												<option value = "">-Choose Purpose-</option>
												<?php foreach($purpose AS $pur){ ?>
												<option value = "<?php echo $pur->purpose_id;?>"><?php echo $pur->purpose_desc;?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td width="20%"><label>End-Use:</label></td>		
										<td>
											<select name="enduse" id='end' class="form-control" style="margin:4px">
												<option value = "">-Choose End-Use-</option>
												<?php foreach($enduse AS $end){ ?>
												<option value = "<?php echo $end->enduse_id;?>"><?php echo $end->enduse_name;?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td width="20%"><label>Serial No. :</label></td>		
										<td><input type = "text" name = "serial" id="serial" class = "form-control" style="margin:4px"></td>
									</tr>
									<tr>
										<td><label>Item Desc:</label></td>		
										<td><input type = "text" name = "item" id="item" class = "form-control" style="margin:4px" autocomplete="off">
										<span id="suggestion-item"></span></td>					
									</tr>
									<tr>
										<td><label>Supplier:</label></td>		
										<td><input type = "text" name = "supplier" id="supplier" class = "form-control" style="margin:4px"><span id="suggestion-supplier"></span></td>					
									</tr>
									<tr>
										<td><label>Brand:</label></td>		
										<td><input type = "text" name = "brand" id="brand" class = "form-control" style="margin:4px"><span id="suggestion-brand"></span></td>					
									</tr>
									<tr>
										<td><label>Catalog No.:</label></td>		
										<td><input type = "text" name = "catalog_no" id="catalog_no" class = "form-control" style="margin:4px"></td>					
									</tr>
									<tr>
										<td><label>Quantity:</label></td>		
										<td><input type = "text" name = "quantity" id="quantity" class = "form-control" style="margin:4px"></td>					
									</tr>
									<tr>
										<td><label>Reason:</label></td>		
										<td>
											<textarea name = "reason" id="reason" class = "form-control" style="margin:4px"></textarea>
											<span id="suggestion-reason"></span></td>	
										</td>					
									</tr>
									<tr>
										<td><label>Remarks:</label></td>		
										<td>
											<textarea name = "remarks" id="remarks" class = "form-control" style="margin:4px"></textarea>
										</td>					
									</tr>
									<tr>
										<td><label>Returned By:</label></td>		
										<td><select class="form-control" style="margin:4px" name="returned" id="returned">
											<option selected="selected" >-Choose Employee-</option>
											<?php foreach($employee AS $emp){ ?>}
												<option value="<?php echo $emp->employee_id; ?>?"><?php echo $emp->employee_name; ?></option>
											<?php } ?>
										</select></td>					
									</tr>
									<tr>
										<td><label>Received By:</label></td>		
										<td>
										<select class="form-control" style="margin:4px" name="received" id="received_by">
											<option selected="selected" >-Choose Employee-</option>
											<?php foreach($employee AS $emp1){ ?>}
												<option value="<?php echo $emp1->employee_id; ?>?"><?php echo $emp1->employee_name; ?></option>
											<?php } ?>
										</select></td>					
									</tr>
									<tr>
										<td><label>Acknowledge By:</label></td>		
										<td>
										<select class="form-control" style="margin:4px" name="acknowledge" id="acknowledge_by">
											<option selected="selected" >-Choose Employee-</option>
											<?php foreach($employee AS $emp1){ ?>}
												<option value="<?php echo $emp1->employee_id; ?>?"><?php echo $emp1->employee_name; ?></option>
											<?php } ?>
										</select></td>					
									</tr>
									<tr>
										<td><label>Noted By:</label></td>		
										<td><select class="form-control" style="margin:4px" name="noted_by" id="noted_by">
											<option selected="selected" >-Choose Employee-</option>
											<?php foreach($employee AS $em){ ?>}
												<option value="<?php echo $em->employee_id; ?>"><?php echo $em->employee_name; ?></option>
											<?php } ?>
										</select></td>					
									</tr>
									<tr>
										<td colspan="2" align="center"><input type="button" class="btn btn-warning btn-block" id = "sub" name="" value="Submit" style="width:100%;margin:4px" onclick='saveRestock()'><div id='alertss' style="font-weight:bold"></div></td>
									</tr>
									
									<input type = "hidden" name = "item_id" id="item_id" class = "form-control" style="margin:4px">
									<input type = "hidden" name = "supplier_id" id="supplier_id" class = "form-control" style="margin:4px">
									<input type = "hidden" name = "brand_id" id="brand_id" class = "form-control" style="margin:4px">
									<!-- <input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>"> -->
									<input type="hidden" name="userid" id="userid" value="<?php echo $_SESSION['user_id']; ?>">
								</table>
							</form>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>