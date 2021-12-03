<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/item.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/gatepass.js"></script>
<style type="text/css">
	.label-info {
    background-color: #5bc0de;
		}


		
	#gatepass_datatable_2{
		display: none;
	}


	@media print{
		#gatepass_datatable{
	    	display: none;
	    }
	    #btn-print{
    		display: none;
    	}	    
	    #gatepass_datatable_2{
	    	display: block;
	    }
	}
	   

	.gatepassdate{
		margin-bottom: 0px;
		margin-top: 5px
		}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#">
			<em class="fa fa-home"></em>
		</a></li>
		<li class="active">Gatepass Items</li>
	</ol>
</div><!--/.row-->
<div class="row">
	<div class="col-lg-12">
		<br>
	</div>
</div><!--/.row-->
<!-- Modal -->		
<div id="loader">
  	<figure class="one"></figure>
  	<figure class="two">loading</figure>
</div>
<di id="itemslist" style="display: none">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading">
					Gatepass Items
					<div  id="btn-print" class="pull-right">
						<button class="btn btn-success" data-toggle="modal" data-target="#GatepassFilter" ><span class="fa fa-filter"> </span> Filter</button>
						<!--<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#search">
							<span class="fa fa-search"></span>
						</a>-->
						<button id="printReport" class="btn btn-info " onclick="printDiv('printableArea')">
							<span  class="fa fa-print"></span>
						</button>	
						<a class="clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#gatepassModal">
							<span class="fa fa-plus"></span></span>
						</a>
					</div>
				</div>
				<div class="panel-body">
					<div id="" class="canvas-wrapper">
						<div class="row" style="padding:0px 10px 0px 10px">
							<!--<?php 
								if(!empty($_POST)){
								
									?>
									
									<div class='alert alert-warning alert-shake'>
										<center>
											<strong>Filters applied:</strong> <?php echo  $filter; ?>.
											<a href='<?php echo base_url(); ?>index.php/gatepass/gatepass_list' class='remove_filter alert-link'>Remove Filters</a>. 
										</center>
									</div>
							<?php  }?>-->
						</div>
						<div style="overflow-x: scroll;">
						<table class="tabledate table-bordered table-hover" id="gatepass_datatable" width="100%" style="font-size: 15px">
							<thead>
								<tr>
									<!--<td width="1%" align="center">#</td>-->
									<td width="15%" align="center"><strong>Date Issued</strong></td>
									<td width="10%" align="center"><strong>Item Description</strong></td>
									<td width="29%" align="center"><strong>U/M</strong></td>
									<td width="15%" align="center"><strong>Quantity</strong></td>
									<td width="15%" align="center"><strong>Remarks</strong></td>
									<td width="15%" align="center"><strong>Type</strong></td>
									<td width="15%" align="center"><strong>MGP No</strong></td>
									<td width="15%" align="center"><strong>Destination</strong></td>
									<td width="15%" align="center"><strong>Returned History</strong></td>
									<td width="15%" align="center"><strong>Status</strong></td>
									<!--<td width="15%" align="center"><strong>Date Returned</strong></td>-->
									<!--<td width="1%" 	align="center" id="btn-print"><strong><span class="fa fa-bars"></span></strong></td>-->
								</tr>
							
							</thead>
							<tbody>
								<?php foreach($gatepass_items as $gp_itms){ ?>
								<tr>
									<!--<td align="center"><?php echo $x; ?></td>-->
									<td align="center"><?php echo $gp_itms['date_issued'];?></td>
									<td align="center"><?php echo $gp_itms['item_name'];?></td>
									<td align="center"><?php echo $gp_itms['unit'];?></td>
									<td align="center"><?php echo $gp_itms['quantity'];?></td>
									<td align="center"><?php echo $gp_itms['remarks'];?></td>
									<td align="center"><?php echo $gp_itms['type'];?></td>
									<td align="center"><?php echo $gp_itms['mgp_no'];?></td>
									<td align="center"><?php echo $gp_itms['destination'];?></td>
									<?php if($gp_itms['type']=='Non-Returnable'){ ?>
									<td><center><?php echo $gp_itms['type'];?></center></td>
									<?php } ?>
									<?php if($gp_itms['type']=='Returnable'){ ?>
									<td><center>
										<a class="btn btn-warning btn-xs" data-toggle="modal" data-target="#returnhistory" title="View History" alt='View History'><span class="fa fa-eye"></span></a>
										<a class="btn-xs btn-warning btn"  data-toggle="modal" data-target="#multipleret" id="clickDate"><span class="fa fa-plus"></span></a></center></td>
									<?php } ?>
									<?php if($gp_itms['type']=='Non-Returnable'){ ?>
									<td><center><?php echo $gp_itms['type'];?></center></td>
									<?php } ?>
									<?php if($gp_itms['type']=='Returnable'){ ?>
									<td align="center"></td>
									<?php } ?>
									<!--<td align="center"><?php echo $gp['date_issued'];?></td>-->
									<!--<td align="center" id="btn-print">

										<a  href="<?php echo base_url();?>index.php/gatepass/view_gatepass/<?php echo $gp['gatepassid'];?>" class="btn btn-warning btn-xs" title="VIEW" alt='VIEW'><span class="fa fa-eye"></span></a>

									</td>-->
								</tr>
								<?php } ?>
							</tbody>
						</table>


						<!-- ----------------------- table for Printing ------------------------ -->

						<div id="printableArea" class="canvas-wrapper">
							<table class="table-bordered table-hover" id="gatepass_datatable_2" width="100%" style="font-size: 15px">
								<thead>
									<tr>
									<td width="10%" align="center"><strong>Date Issued</strong></td>
									<td width="15%" align="center"><strong>Item Description</strong></td>
									<td width="5%" align="center"><strong>U/M</strong></td>
									<td width="5%" align="center"><strong>Quantity</strong></td>
									<td width="15%" align="center"><strong>Remarks</strong></td>
									<td width="20%" align="center"><strong>Type</strong></td>
									<td width="20%" align="center"><strong>MGP No</strong></td>
									<td width="15%" align="center"><strong>Destination</strong></td>
									<td width="20%" align="center"><strong>Returned History</strong></td>
									<td width="20%" align="center"><strong>Status</strong></td>
									</tr>
								
								</thead>
								<tbody>
									<?php foreach($gatepass_items as $gp_itms){ ?>
									<tr>
									<td align="center"><?php echo $gp_itms['date_issued'];?></td>
									<td align="center"><?php echo $gp_itms['item_name'];?></td>
									<td align="center"><?php echo $gp_itms['unit'];?></td>
									<td align="center"><?php echo $gp_itms['quantity'];?></td>
									<td align="center"><?php echo $gp_itms['remarks'];?></td>
									<td align="center"><?php echo $gp_itms['type'];?></td>
									<td align="center"><?php echo $gp_itms['mgp_no'];?></td>
									<td align="center"><?php echo $gp_itms['destination'];?></td>
									<?php if($gp_itms['type']=='Non-Returnable'){ ?>
									<td><center><?php echo $gp_itms['type'];?></center></td>
									<?php } ?>
									<?php if($gp_itms['type']=='Returnable'){ ?>
									<td><center>
									<?php } ?>
									<?php if($gp_itms['type']=='Non-Returnable'){ ?>
									<td><center><?php echo $gp_itms['type'];?></center></td>
									<?php } ?>
									<?php if($gp_itms['type']=='Returnable'){ ?>
									<td align="center"></td>
									<?php } ?>
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
	<!---MO-D-A-L-->
	<!--<div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog" role="document">
			<div class="modal-content modbod">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Search</h4>
				</div>
				<form method="POST" action = "<?php echo base_url(); ?>index.php/receive/search_receive" role="search">
					<div class="modal-body">

						<table style="width:100%">
							<tr>
								<td class="td-sclass"><label for="rdate">Receive Date:</label></td>
								<td class="td-sclass">
									<input type="date" name="rdate" class="form-control">
								</td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="dr">DR No.:</label></td>
								<td class="td-sclass">
									<input type="text" name="dr" class="form-control">
								</td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="po">PO No.:</label></td>
								<td class="td-sclass">
									<input type="text" name="po" class="form-control">
								</td>
							</tr>
							 <tr>
								<td class="td-sclass"><label for="jo">JO No.:</label></td>
								<td class="td-sclass">
									<input type="text" name="jo" class="form-control">
								</td>
							</tr> 
							<tr>
								<td class="td-sclass"><label for="si">SI No.:</label></td>
								<td class="td-sclass">
									<input type="text" name="si" class="form-control">
								</td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="pr">PR No.:</label></td>
								<td class="td-sclass">
									<input type="text" name="pr" class="form-control">
								</td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="enduse">End Use:</label></td>
								<td class="td-sclass">
									<select name="enduse" class="form-control">
										<option value='' selected>-Choose End Use-</option>
										<?php 
											foreach($enduse AS $end){
										?>
										<option value = "<?php echo $end->enduse_id;?>"><?php echo $end->enduse_name;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="purpose">Purpose:</label></td>
								<td class="td-sclass">
									<select name="purpose" class="form-control">
										<option value='' selected>-Choose Purpose-</option>
										<?php 
											foreach($purpose AS $pur){
										?>
										<option value = "<?php echo $pur->purpose_id?>"><?php echo $pur->purpose_desc?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
						</table>					
					</div>
					<div class="modal-footer">
						<input type="submit" name="searchbtn" class="search-btn btn btn-default shadow" value="Search">
					</div>
					<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
				</form>
			</div>
		</div>
	</div>-->
	<div class="modal fade" id="returnhistory" tabindex="-1" role="dialog" aria-labelledby="returnhistory">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Date Returned History</h4>
				</div>
				<div class="modal-body" style="padding:30px 20px 30px 20px">
					<table class="table table-bordered" width="100%">
						<tr>
							<td width="70%"><label>Date Returned</label></td>							
							<td><label>Qty</label></td>							
						</tr>
						<tr>
							<td>10-10-21</td>
							<td>100</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="multipleret" tabindex="-1" role="dialog" aria-labelledby="multipleret">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Date Returned</h4>
				</div>
				<form method="POST" action="<?php echo base_url(); ?>index.php/gatepass/add_date_returned">
					<div class="modal-body" style="padding:30px 20px 30px 20px">
						<table width="100%">
							<tr>
								<td width="23%"><label>Date Returned:</label></td>							
								<td width="77%"><input type="date" class="form-control" name=""></td>							
							</tr>
							<tr>
								<td colspan="2"><br></td>
							</tr>
							<tr>
								<td><label>Qty:</label></td>							
								<td><input type="number" class="form-control" name=""></td>							
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info btn-block">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="GatepassFilter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Filter</h4>
				</div>
				<form method="POST" action = "<?php echo base_url();?>index.php/gatepass/filter_gatepass_items">
					<div class="modal-body">
						<div class = "row">
							<div class = "col-lg-6">
								<p class="gatepassdate">From:</p>
								<input type = "date" name = "from" class = "form-control bor-radius">
							</div>
							<div class = "col-lg-6">
								<p class="gatepassdate">To:</p>
								<input type = "date" name = "to" class = "form-control bor-radius">
							</div>
						</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info btn-block"><span class="fa fa-filter"></span> Filter</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal_delete_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="alert alert-danger">
				<center>
				  	<h2 class="alert-link"><strong><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> DANGER!</strong></h2>
				  	<hr>
				  	Are you sure you want to delete this?
				  	<br>
				  	<br>					  	
				  	<a href="#" class="btn btn-default " data-dismiss="modal">NO</a>&nbsp<a href="#" class="btn btn-danger">YES</a>.
			  	</center>
			</div>
		</div>
	</div>
