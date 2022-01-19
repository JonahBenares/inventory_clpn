<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/request.js"></script>
<script src="<?php echo base_url(); ?>assets/js/restock.js"></script>
<script type="text/javascript">
	function val_cpass() {
	    var password = $("#newpass").val();
	    var confirm_password = $("#renewpass").val();
	    if(password != confirm_password) {
	        $("#cpass_msg").show();
	        $("#cpass_msg").html("Confirm password not match!");
	        $("#submit_pass").hide();
	    }
	    else{
	        $("#cpass_msg").hide();
	        $("#submit_pass").show();
	    }
	}
</script>
<body>	

	<!---MODAL-->	
	<div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body" style="padding:50px 50px 30px 50px">
					<form method = "POST" action = "<?php echo base_url(); ?>index.php/masterfile/change_pass">
						<table width="100%">
							<tr>
								<td width="20%"><label>Old Password:</label></td>
								<td width="80%"><input type = "password" name = "oldpass" id="oldpass"  class = "form-control" required><br></td>
							</tr>							
							<tr>
								<td width="20%"><br></td>
								<td width="80%"><br></td>
							</tr>
							<tr>
								<td width="20%"><label>New Password:</label></td>
								<td width="80%"><input type = "password" name = "newpass" id = "newpass" class = "form-control" required><br></td>
							</tr>
							<tr>
								<td width="20%"><label>Retype New Password:</label></td>
								<td width="80%"><input onchange="val_cpass()" type = "password" name = "renewpass" id="renewpass" class = "form-control" required><br></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<div class="alert alert-danger alert-shake" id="cpass_msg" style = "display:none;">
	                                   <center>Confirm Password not Match!</center>
	                                </div>
								</td>
							</tr>
						</table>
					
					<div class="modal-footer">
						<button type="button" id="submit_pass" class="btn btn-default" data-dismiss="modal">Close</button>

						<input type='submit' class="btn btn-warning" value='Proceed '> 
						<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="receiveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Receive</h4>
				</div>
				<div class="modal-body" style="padding:30px 30px 30px 30px">
					<form method="POST" action = "<?php echo base_url();?>index.php/Receive/insert_receive_head">
						<table width="100%">
							<tr>
								<td width="15%"><label>Date:</label></td>
								<td width="85%"><input type = "date" name = "receive_date" class = "form-control" id="e" ><br></td>
							</tr>
							<tr>
								<td width="15%"><label>DR#:</label></td>
								<td width="85%"><input type = "text" name = "dr_no" class = "form-control" autocomplete='off'><br></td>
							</tr>
							<tr>
								<td width="15%"><label>PO#:</label></td>
								<td width="85%"><input type = "text" name = "po_no" class = "form-control" autocomplete='off'><br></td>
							</tr>
							<tr>
								<td width="15%"><label>SI#/OR#:</label></td>
								<td width="85%"><input type = "text" name = "si_no" class = "form-control" autocomplete='off'><br></td>
							</tr>
							<tr>
								<td width="15%"><label>WAYBILL#:</label></td>
								<td width="85%"><input type = "text" name = "waybill_no" class = "form-control" autocomplete='off'><br></td>
							</tr>
							<tr>
								<td><label>PCF:</label></td>
								<td><input type = "checkbox" name = "pcf" value = "1" class = "form-control " style="width:30px"></td>
							</tr>
						</table>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

							<input type='submit' class="btn btn-warning" value='Proceed '> 
							<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="requestModal" role="dialog" aria-labelledby="requestModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Request</h4>
				</div>
				<div class="modal-body" style="padding:30px 20px 30px 20px">
					<form method="POST" action = "<?php echo base_url();?>index.php/Request/insert_request_head">
						<table width="100%">
							<tr>
								<td width="20%"><label>Request Date/Time:</label></td>
								<td width="40%"><input type = "date" name = "request_date" id="d" class = "form-control" ></td>
								<td width="40%"><input type = "text" placeholder="Time" name = "request_time" class = "form-control" value="<?php echo date('H:i'); ?>"></td>
							</tr>
							<tr>
								<td width="20%"><label>Request Type:</label></td>
								<td colspan="2" >
									<select name = "type" class = "form-control type" style="margin:4px">
										<option value="" selected="">-Select Request Type-</option>
										<option value = "JO / PR">JO / PR</option>
										<option value = "Warehouse Stocks">Warehouse Stocks</option>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%" class = "t"><label>JO / PR #:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;padding-left: 4px;" >
									<select name = "prno" id="prno" class = "form-control t select2" onchange="choosePR();" style="margin:4px;width:100%">
										<option value="" selected="">-Select PR-</option>
										<?php 
										$ctpr= count($prno);
										for($q=0;$q<$ctpr;$q++) { ?>
											<option value="<?php echo $prno[$q]; ?>"><?php echo $prno[$q]; ?></option>
										<?php } ?>
									</select></td>
							</tr>
							<tr>
								<td width="20%"><label>Department:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;">
									<select name = "department" class = "form-control" id = "department" style="margin:4px;width:100%">
										<option value="" selected="" >-Select Department-</option>
										<?php foreach($department AS $dept){ ?>
											<option value="<?php echo $dept->department_id; ?>"><?php echo $dept->department_name; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%"><label>Purpose:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;" >
									<select class = "form-control" name="purpose" id = "purpose" style="margin:4px;width:100%">
										<option value="" selected="">-Select Purpose-</option>
										<?php foreach($purpose AS $purp){ ?>
											<option value="<?php echo $purp->purpose_id; ?>"><?php echo $purp->purpose_desc; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%"><label>End-Use:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;" >
									<select name = "enduse" class = "form-control" id = "enduse" style="margin:4px;width:100%">
										<option value="" selected="">-Select End-Use-</option>
										<?php foreach($enduse AS $end){ ?>
											<option value="<?php echo $end->enduse_id; ?>"><?php echo $end->enduse_name; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%"><label>Remarks:</label></td>
								<td colspan="2" ><textarea name = "remarks" class = "form-control" style="margin:4px"></textarea></td>
							</tr>
						</table>
						<div class="modal-footer">
							<div id='alerts' style="font-weight:bold;text-align: center"></div>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type='submit' class="btn btn-warning" id = "proceeds" value='Proceed '> 
							<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
							<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="issueModal" tabindex="-1" role="dialog" aria-labelledby="issueModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Load MReqF No.</h4>
				</div>
				<div class="modal-body" style="padding:30px 20px 30px 20px">
					<table width="100%">
						<tr>
							<td width="30%"><label>Load MReqF No.:</label></td>							
						</tr>
						<tr>
							<td><input type = "type" name = "" class = "form-control" style="margin:4px"></td>
						</tr>
					</table>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<a  class="btn btn-warning" href="<?php echo base_url();?>index.php/issue/load_issue">Proceed</a>							
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="restockModal" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Restock</h4>
				</div>
				<div class="modal-body" style="padding:30px 50px 30px 50px">
					<form id='restockdetails' method = "POST">
						<table width="100%">
							<!-- <tr>
								<td width="26%"><label>PR No. :</label></td>		
								<td>
									<input type = "text" name = "prno" id="prres" class = "form-control" style="margin:4px" autocomplete="off">
								</td>	
							</tr> -->
							<tr>
								<td width="26%"><label>From PR. :</label></td>		
								<td style ="padding-bottom: 5px;padding-left: 4px;">
									<!--<input type = "text" name = "prno" id="prres" class = "form-control" style="margin:4px" autocomplete="off">
									 <span id="suggestion-pr1"></span> -->
									 <select name="prno" id='prres' class="form-control select2" onchange="choosePRSS()" style="margin:4px;width:100%">
										<option value = "">-Choose PR-</option>
										<?php foreach($pr_list AS $pr){ ?>
										<option value = "<?php echo $pr->pr_no;?>"><?php echo $pr->pr_no;?></option>
										<?php } ?>
									</select>
								</td>	
							</tr>
							<tr>
								<td width="20%"><label>Department:</label></td>		
								<td style ="padding-bottom: 5px;">
									<select name="department" id='deptres' class="form-control" style="margin:4px;width:100%">
										<option value = "">-Choose Department-</option>
										<?php foreach($department AS $dep){ ?>
										<option value = "<?php echo $dep->department_id;?>"><?php echo $dep->department_name;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%"><label>Purpose:</label></td>		
								<td style ="padding-bottom: 5px;">
									<select name="purpose" id='purres' class="form-control" style="margin:4px;width:100%">
										<option value = "">-Choose Purpose-</option>
										<?php foreach($purpose AS $pur){ ?>
										<option value = "<?php echo $pur->purpose_id;?>"><?php echo $pur->purpose_desc;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%"><label>End-Use:</label></td>		
								<td style ="padding-bottom: 5px;">
									<select name="enduse" id='endres' class="form-control" style="margin:4px;width:100%">
										<option value = "">-Choose End-Use-</option>
										<?php foreach($enduse AS $end){ ?>
										<option value = "<?php echo $end->enduse_id;?>"><?php echo $end->enduse_name;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><label>Returned By:</label></td>		
								<td style ="padding-bottom: 5px;padding-left: 4px;"><select class="form-control select2" style="margin:4px;width:100%" name="returned" id="returnedres">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $emp){ ?>
										<option value="<?php echo $emp->employee_id; ?>?"><?php echo $emp->employee_name; ?></option>
									<?php } ?>
								</select></td>					
							</tr>
							<tr>
								<td><label>Received By:</label></td>		
								<td style ="padding-bottom: 5px;padding-left: 4px;">
								<select class="form-control select2" style="margin:4px;width:100%" name="received" id="received_byres">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $emp1){ ?>
										<option value="<?php echo $emp1->employee_id; ?>?"><?php echo $emp1->employee_name; ?></option>
									<?php } ?>
								</select></td>					
							</tr>
							<tr>
								<td><label>Acknowledge By:</label></td>		
								<td style ="padding-bottom: 5px;padding-left: 4px;">
								<select class="form-control select2" style="margin:4px;width:100%" name="acknowledge" id="acknowledge_byres">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $emp1){ ?>
										<option value="<?php echo $emp1->employee_id; ?>?"><?php echo $emp1->employee_name; ?></option>
									<?php } ?>
								</select></td>					
							</tr>
							<tr>
								<td><label>Noted By:</label></td>		
								<td style ="padding-bottom: 5px;padding-left: 4px;"><select class="form-control select2" style="margin:4px;width:100%" name="noted_by" id="noted_byres">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $em){ ?>
										<option value="<?php echo $em->employee_id; ?>"><?php echo $em->employee_name; ?></option>
									<?php } ?>
								</select></td>					
							</tr>
							
						</table>
						<div class="modal-footer">
							<div id='alert' style="font-weight:bold;text-align: center"></div>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<!-- <input type='submit' class="btn btn-warning" value='Proceed '>  -->
							<input type="button" class="btn btn-warning" id="proceed" onclick='saveRestock1()' value='Proceed'>
							<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
							<input type="hidden" name="baseurl" id="baseurl1" value="<?php echo base_url(); ?>">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="gatepassModal" role="dialog" aria-labelledby="gatepassModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Gate Pass</h4>
				</div>
				<div class="modal-body" style="padding:30px 20px 30px 20px">
					<form method="POST" action = "<?php echo base_url();?>index.php/Gatepass/insert_gatepass_head">
						<table width="100%">
							<!--<tr>
								<td width="20%"><label>To:</label></td>
								<td colspan="2" >
									<select name = "type" class = "form-control type" style="margin:4px">
										<option value="" selected="">-Select -</option>
									</select>
								</td>
							</tr>-->
							<?php
							$now=date('Y');
        					$year = substr( $now, -2);
        					$rows=$this->super_model->count_custom_where("gatepass_head","date_created LIKE '%$year%'");
        					if($rows==0){
            					$mgp_no= $year."-001";
        					} else {
            					$maxmgpno=$this->super_model->get_max_where("gatepass_head", "mgp_no","date_created LIKE '%$year%'");
            					$mgpno = explode('-',$maxmgpno);
            					$series = $mgpno[1]+1;
            					$mgp_no = $year."-".str_pad($series, 3, "0", STR_PAD_LEFT);

            				}  ?>
							<tr>
								<td width="20%" class = "t"><label>MGP No.:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;padding-left: 4px;" >
									<input type="text" class="form-control" value="<?php echo $mgp_no; ?>" name="mgp_no" readonly>
								</td>
							</tr>
							<!--<tr>
								<td width="20%"><label>To Company:</label></td>
								<td style ="padding-bottom: 5px;padding-left: 4px;"><select class="form-control select2" style="margin:4px;width:100%" name="company" id="to_company">
									<option selected="selected" >-Choose Company-</option>
									<?php foreach($supplier AS $sup){ ?>
										<option value="<?php echo $sup->supplier_id; ?>?"><?php echo $sup->supplier_name; ?></option>
									<?php } ?>
								</select></td>
							</tr>-->
							<tr>
								<td width="20%" class = "t"><label>To Company:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;padding-left: 4px;" >
									<input type="" class="form-control" name="company">
								</td>
							</tr>
							<tr>
								<td width="20%" class = "t"><label>Destination:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;padding-left: 4px;" >
									<input type="" class="form-control" name="destination">
								</td>
							</tr>
							<tr>
								<td width="20%" class = "t"><label>Vehicle No.:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;padding-left: 4px;" >
									<input type="" class="form-control" name="vehicle_no">
								</td>
							</tr>
							<tr>
								<td width="20%" class = "t"><label>Date Issued:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;padding-left: 4px;" >
									<input type="date" class="form-control" name="date_issued">
								</td>
							</tr>
							<!--<tr>
								<td width="20%" class = "t"><label>Date Returned:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;padding-left: 4px;" >
									<input type="date" class="form-control" name="date_returned">
								</td>
							</tr>-->
							<tr>
								<td width="20%" class = "t"><label>Prepared by:</label></td>
								<td style ="padding-bottom: 5px;padding-left: 4px;"><select class="form-control select2" style="margin:4px;width:100%" name="prepared" id="prepared_by">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $emp){ ?>
										<option value="<?php echo $emp->employee_id; ?>?"><?php echo $emp->employee_name; ?></option>
									<?php } ?>
								</select></td>
							</tr><tr>
								<td width="20%" class = "t"><label>Noted by:</label></td>
								<td style ="padding-bottom: 5px;padding-left: 4px;"><select class="form-control select2" style="margin:4px;width:100%" name="noted" id="noted_by">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $emp1){ ?>
										<option value="<?php echo $emp1->employee_id; ?>?"><?php echo $emp1->employee_name; ?></option>
									<?php } ?>
								</select></td>
							</tr><tr>
								<td width="20%" class = "t"><label>Approved by:</label></td>
								<td style ="padding-bottom: 5px;padding-left: 4px;"><select class="form-control select2" style="margin:4px;width:100%" name="approved" id="approve_by">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $emp2){ ?>
										<option value="<?php echo $emp2->employee_id; ?>?"><?php echo $emp2->employee_name; ?></option>
									<?php } ?>
								</select></td>
							</tr>
						</table>
						<div class="modal-footer">
							<div id='alerts' style="font-weight:bold;text-align: center"></div>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type='submit' class="btn btn-warning" id = "proceeds" value='Proceed '>
							<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
							<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>"> 	
							<!--<a href="<?php echo base_url();?>index.php/gatepass/add_gatepass">Proceed</a>-->				
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- MODAL -->

	<!-- TOP NAVBAR -->
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid" >
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>				
				<ul class="nav navbar-top-links navbar-left">
					<a class="navbar-brand" href="#"><span >WAREHOUSE</span>Inventory System</a>
				</ul>
				<ul class="nav navbar-top-links navbar-right">
					<li class="category">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/category_list">
							<span class="fa fa-th-large"></span>
							<span class="tooltiptext shadow">Item Category</span>
						</a>
					</li>
					<li class=" supplier">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/group_list">
							<span class="fa fa-th-list"></span>
							<span class="tooltiptext shadow">Group</span>
						</a>
					</li>
					<li class="uom" >
						<a class="dropdown-toggle count-info " href="<?php echo base_url(); ?>index.php/masterfile/uom_list">
							<span class="fa fa-tag"></span>
							<span class="tooltiptext shadow">UOM</span>
						</a>
					</li>	
					<li class="subcategory" >
						<a class="dropdown-toggle count-info " href="<?php echo base_url(); ?>index.php/masterfile/supplier_list">
							<span class="fa fa-truck"></span>
							<span class="tooltiptext shadow">Supplier</span>
						</a>
					</li>
					<li class="employees">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/department_list">
							<span class="fa fa-building-o"></span>
							<span class="tooltiptext shadow"> Department</span>
						</a>
					</li>

					<li class="purpose">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/purpose_list">
							<span class="fa fa-circle"></span>
							<span class="tooltiptext shadow">Purpose</span>
						</a>
					</li>

					<li class="enduse">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/endUse_list">
							<span class="fa fa-users"></span>
							<span class="tooltiptext shadow">End Use</span>
						</a>
					</li>
					<li class="warehouse">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/warehouse_list">
							<span class="fa fa-home"></span>
							<span class="tooltiptext shadow">Warehouse</span>
						</a>
					</li>
					<li class="location">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/location_list">
							<span class="fa fa-map-marker"></span>
							<span class="tooltiptext shadow">Location</span>
						</a>
					</li>
					<li class="rack" >
						<a class="dropdown-toggle count-info " href="<?php echo base_url(); ?>index.php/masterfile/rack_list">
							<span class="fa fa-tasks"></span>
							<span class="tooltiptext shadow">Rack</span>
						</a>
					</li>
					<li class="department">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/employee_list">
							<span class="fa  fa-user"></span>
							<span class="tooltiptext shadow">Employees</span>
						</a>
					</li>
					<li class="signatories">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/signatory">
							<span class="fa fa-id-badge "></span>
							<span class="tooltiptext shadow">Signatories</span>
						</a>
					</li>
					<li class="brand">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/import_items">
							<span class="fa fa-cloud-upload"></span>
							<span class="tooltiptext shadow">Import Items</span>
						</a>
					</li>
					<?php if($_SESSION['user_id']==5){ ?>
					<li class="user">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/user_reslist">
							<span class="fa fa-user-circle-o"></span>
							<span class="tooltiptext shadow">User Restriction</span>
						</a>
					</li>
					<?php } ?>
					<li class="divider-side" ></li>
					<li class="setting set">
						<a class="dropdown-toggle count-info setting-hover" data-toggle="dropdown" href="#">
							<em class="fa fa-cog"></em>
						</a>
						<ul class="dropdown-menu animated slideInDown" style="top:110%;width:300px;">
							<span class="arrow-bottom"></span>
							<li>
								<div class="">
									<div class="profile-userpic">
										<img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
									</div>
									<div class="profile-usertitle">
										<div class="profile-usertitle-name"><?php echo $_SESSION['fullname'];?></div>
										<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
									</div>
								</div>
							</li>
							<li class="divider"></li>
							<a href="#" class="setting-name"><em class="fa fa-user">&nbsp;</em> Account</a>
							<li class="divider"></li>
							<a href="#"  data-toggle="modal" data-target="#changePass" class="setting-name"><em class="fa fa-key">&nbsp;</em> Change Password</a>
							<li class="divider"></li>
							<a href="<?php echo base_url(); ?>index.php/masterfile/user_logout" class="setting-name"><em class="fa fa-power-off">&nbsp;</em> Logout</a>
							<br>	
						</ul>						
					</li>
				</ul>				
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<!-- --TOP NAVBAR--- -->
	
	<!-- --SIDE NAVBAR--- -->
	<div id="sidebar-collapse " class="col-sm-3 col-lg-2 sidebar shadow">
		<div class="banner" >
			<center>
			<div style="position:relative;" >
				<img class=""  src="<?php echo base_url(); ?>assets/default/logo/cenpri_logo.png" width="100%" height="auto" style="margin-top: 5px" >
			</div></center>
			<div class="moving-obj" style="z-index: 999; position: relative;top:-5px">			
				<span class="fa fa-tasks padding-obj"></span>		
				<span class="infinite-shake fa fa-archive padding-obj"></span>			
				<span class="fa fa-archive padding-obj"></span>
				<span class="fa fa-truck font-truck padding-obj"></span>
			</div>
		</div>
		<ul class="nav menu">
			<li ><a href="<?php echo base_url(); ?>index.php/masterfile/home"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
			<li ><a href="<?php echo base_url(); ?>index.php/masterfile/reminder_list"><em class="fa fa-bell">&nbsp;</em> Reminder</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/items/item_list"><em class="fa fa-calendar">&nbsp;</em> Item List</a></li>
			
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-receiving">
					<span class="fa fa-sign-in">&nbsp;</span> Receive 
					<span data-toggle="collapse" href="#sub-receiving" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-receiving">
					<?php if($receive_add == 1){ ?>
					<li>
						<a class=""  data-toggle="modal" data-target="#receiveModal" >
							<span class="fa fa-arrow-right">&nbsp;</span> Add New
						</a>
					</li>
					<?php } ?>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/receive/receive_list">
							<span class="fa fa-arrow-right">&nbsp;</span> View List
						</a>
					</li>
				</ul>
			</li>
			
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-request">
					<span class="fa fa-pencil-square-o">&nbsp;</span> Request 
					<span data-toggle="collapse" href="#sub-request" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-request">
					<?php if($request_add == 1){ ?>
					<li>
						<a  data-toggle="modal" data-target="#requestModal" >
							<span class="fa fa-arrow-right">&nbsp;</span> Add New
						</a>
					</li>
					<?php } ?>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/request/request_list">
							<span class="fa fa-arrow-right">&nbsp;</span> View List
						</a>
					</li>
				</ul>
			</li>	
				
			<!-- <li><a href="<?php echo base_url(); ?>index.php/issue/load_issue"><em class="fa fa-share-square-o">&nbsp;</em> Issue</a></li> -->
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-issue">
					<span class="fa fa-share-square-o">&nbsp;</span> Issue 
					<span data-toggle="collapse" href="#sub-issue" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-issue">
					<?php if($issue_add == 1){ ?>
					<li>
						<a href="<?php echo base_url(); ?>index.php/issue/load_issue" >
							<span class="fa fa-arrow-right">&nbsp;</span> Load MRef No.
						</a>
					</li>
					<?php } ?>
					<li>
						<a class=""  href="<?php echo base_url(); ?>index.php/issue/view_issue">
							<span class="fa fa-arrow-right">&nbsp;</span> View List
						</a>
					</li>
				</ul>
			</li>	

			<li class="parent ">
				<a data-toggle="collapse" href="#sub-restock">
					<span class="fa fa-archive">&nbsp;</span> Restock 
					<span data-toggle="collapse" href="#sub-restock" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-restock">
					<?php if($restock_add == 1){ ?>
					<li>
						<a class=""  data-toggle="modal" data-target="#restockModal">
							<span class="fa fa-arrow-right">&nbsp;</span> Add New
						</a>
					</li>
					<?php } ?>
					<li>
						<a class=""  href="<?php echo base_url(); ?>index.php/restock/restock_list">
							<span class="fa fa-arrow-right">&nbsp;</span> View List
						</a>
					</li>
				</ul>
			</li>	
			<?php if($receive_add == 1){ ?>
			<li><a href="<?php echo base_url(); ?>index.php/backorder/back_order"><em class="fa fa-retweet">&nbsp;</em> Back Order</a></li>	
			<?php } ?>

			<li class="parent ">
				<a data-toggle="collapse" href="#sub-gatepass">
					<span class="fa fa-ticket">&nbsp;</span> Gate Pass 
					<span data-toggle="collapse" href="#sub-gatepass" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-gatepass">
					<li>
						<a class="" data-toggle="modal" data-target="#gatepassModal" >
							<span class="fa fa-arrow-right">&nbsp;</span> Add New
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/gatepass/gatepass_list">
							<span class="fa fa-arrow-right">&nbsp;</span> Material Gatepass List
						</a>
					</li>
					<li class="parent ">
						<a data-toggle="collapse" href="#gatepass-sub">
							<span data-toggle="collapse" href="#gatepass-sub" class="icon">
								<em class="fa fa-plus"></em>
							</span>&nbsp;Gatepass Items List 							
						</a>
						<ul class="children collapse" id="gatepass-sub">
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/gatepass/all_gatepass_items" >
									<span class="fa fa-arrow-right">&nbsp;</span> Overall
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/gatepass/completed_gatepass_items" >
									<span class="fa fa-arrow-right">&nbsp;</span> Completed
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/gatepass/incomplete_gatepass_items" >
									<span class="fa fa-arrow-right">&nbsp;</span> Incomplete
								</a>
							</li>
						</ul>
					</li>	
				</ul>
			</li>


			<li class="parent ">
				<a data-toggle="collapse" href="#sub-item-1">
					<em class="fa fa-navicon">&nbsp;</em> Report 
					<span data-toggle="collapse" href="#sub-item-1" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li class="parent ">
						<a data-toggle="collapse" href="#subsub-item-4">
							<span data-toggle="collapse" href="#subsub-item-4" class="icon">
								<em class="fa fa-plus"></em>
							</span>&nbsp;PR <small>Report</small>							
						</a>
						<ul class="children collapse" id="subsub-item-4">
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/all_pr_report" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> Overall
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/pr_report" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> Receive
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/pr_report_issue" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> Issue
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/pr_report_restock">
									<span class="fa fa-arrow-right">&nbsp;</span> Restock
								</a>
							</li>
						</ul>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/item_report">
							<span class="fa fa-arrow-right">&nbsp;</span> Item PR
						</a>
					</li>
					<li class="parent ">
						<a data-toggle="collapse" href="#subsub-item-1">
							<span data-toggle="collapse" href="#subsub-item-1" class="icon">
								<em class="fa fa-plus"></em>
							</span>&nbsp;Inventory 							
						</a>
						<ul class="children collapse" id="subsub-item-1">
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/aging_report" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> Aging
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/for_accounting" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> For Accounting
								</a>
							</li>
							<li>
								<a style="padding-left:60px;height: 80px" href="<?php echo base_url(); ?>index.php/reports/for_accounting_monthly" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> For Accounting <br> &nbsp;(Range of Date)
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/inventory_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Per Item
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/range_date">
									<span class="fa fa-arrow-right">&nbsp;</span> Range of Date
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/received_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Received
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/issued_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Issued
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/restock_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Restock
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/excess_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Excess
								</a>
							</li>
						</ul>
					</li>			
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/stock_card_new">
							<span class="fa fa-arrow-right">&nbsp;</span> Stock Card
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/borrowing_report">
							<span class="fa fa-arrow-right">&nbsp;</span> Borrowing Report
						</a>
					</li>
				</ul>
			</li>		
		</ul>
		<br>
	</div>
	<!-- --SIDE NAVBAR--- -->
