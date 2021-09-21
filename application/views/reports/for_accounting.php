<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>
<style type="text/css">
	#name-item{
		width: 50%!important;
	}
	.arrow-top2{
	    content: "";
	    position: absolute;
	    top: -10%;
	    left: 10%;
	    transform: rotate(180deg);
	    margin-left: -5px;
	    border-width: 5px;
	    border-style: solid;
	    border-color: #e66513 transparent transparent transparent;
	}
	.table_sty1{
		padding-right:15px;
		padding-left:15px;
	}
	.table-sty2{
		padding: 0px 15px;
		text-align: center;
		font-weight: 600;
	}
	.table-sty3{
		padding: 0px 100px;
		text-align: center;
		font-weight: 600;
	}

	.table-sty4{
		padding: 0px 40px;
		text-align: center;
		font-weight: 600;
	}
	.color_back{
		background: yellow;
	}
	td{padding: 0px 18px!important}

</style>
<?php
	function dateDifference($date_1 , $date_2){
		$datetime2 = date_create($date_2);
		$datetime1 = date_create($date_1 );
		$interval = date_diff($datetime2, $datetime1);
		return $interval->format('%R%a');
	}
	$now = date('Y-m-d');
?>
<div class="col-lg-12 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active"> Accounting Report</li>
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
						<div class="row" style="padding: 20px">
							<label>From:<input type="date" class="form-control" name="from_date" id="from_date"></label>
							<label>Category:
								<select name="category" class="form-control" id="category" onChange="chooseCategory();">
												<option value = "" selected="">-Category-</option>
												<?php foreach($category AS $cat){ ?>
													<option value="<?php echo $cat->cat_id; ?>"><?php echo $cat->cat_name; ?></option>
												<?php } ?>
											</select>
							</label>
							<label>Sub Category:
							<select name="subcat" class="form-control btn-block" id="subcat">
												
							</select></label>
							<button class='btn btn-primary' name='generateAccounting' onclick="generateAccounting()">Generate Report</button>
							<?php if(!empty($from)){ ?>
							<a href = "<?php echo base_url();?>index.php/reports/export_foraccounting/<?php echo $from;?>/<?php echo $cat1;?>/<?php echo $subcat1;?>" class = "btn btn-primary pull-right">Export to Excel</a>
							<div>
								<table class=" table-bordered" width="100%" id="scrollexample" style="font-size: 12px">
									<thead>
									<tr>
										<td class="table-sty2" rowspan="3" align="center">#</td>
										<td class="table-sty3" rowspan="3" width="40%" align="center">Part Number </td>
										<td class="table-sty3" rowspan="3" align="center">Item Description</td>
										<td class="table-sty2" rowspan="3" align="center">Beginning Balance</td>
										<td class="table-sty2" rowspan="3" align="center">UOM</td>
										<td class="table-sty2" colspan="7" align="center">MATERIAL RECEIVED</td>
										<td class="table-sty4 color_back" rowspan="3" align="center">Total Received (in)</td>
										<td class="table-sty2" colspan="7" align="center">MATERIAL ISSUED</td>
										<td class="table-sty4 color_back" rowspan="3" align="center">Total Issued (out)</td>
										<td class="table-sty2" colspan="7" align="center">MATERIAL RESTOCK</td>
										<td class="table-sty4 color_back" rowspan="3" align="center">Total Restock (in)</td>
										<td class="table-sty2" rowspan="3" align="center">Ending Inventory as of (Date)</td>
									</tr>
									<tr>
									  <?php while(strtotime($from) <= strtotime($to)) { ?>	
										<td class="table-sty2"><?php echo date('m/d', strtotime($from)); ?></td>
										
									<?php
										$from = date ("Y-m-d", strtotime("+1 day", strtotime($from)));
									 } 

									  while(strtotime($from2) <= strtotime($to)) { ?>	
										<td class="table-sty2"><?php echo date('m/d', strtotime($from2)); ?></td>
										
									<?php
									$from2 = date ("Y-m-d", strtotime("+1 day", strtotime($from2)));
									 } 
									   while(strtotime($from5) <= strtotime($to)) { ?>	
										<td class="table-sty2"><?php echo date('m/d', strtotime($from5)); ?></td>
										
									<?php
									$from5 = date ("Y-m-d", strtotime("+1 day", strtotime($from5)));
									 } ?>
									
									</tr>
									<tr>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>

										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>

										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
										<td class="table-sty2">Qty</td>
									</tr>
									</thead>
									<tbody>
										<?php
										$num=1;
										foreach($items AS $it) { ?>
										<tr>
											<td class="table_sty1"><?php echo $num; ?></td>
											<td class="table_sty1"><?php echo $it['pn']; ?></td>
											<td class="table_sty1"><?php echo $it['item_name']; ?></td>
											<td class="table_sty1"><center><strong><?php echo $it['beginning']; ?></strong></center></td>
											<td class="table_sty1"><?php echo $it['unit']; ?></td>
											
											<?php 
											$x=1;
											while(strtotime($from3) <= strtotime($to)) { 

												$date_rec = date('Y-m-d', strtotime($from3));

											 ?>	
											<td class="table_sty1"><?php 
											echo $it['rec_qty'.$x];
											//echo $it['qty']; ?></td>
										
											<?php 
												$from3 = date ("Y-m-d", strtotime("+1 day", strtotime($from3)));
												$x++;
											 } 
											 $from3=date ("Y-m-d", strtotime("-7 day", strtotime($from3)));
											 ?>

											<td class="table_sty1 color_back"><center><strong><?php echo $it['total_received']; ?></strong></center></td>

											<?php 
											$y=1;
											while(strtotime($from4) <= strtotime($to)) { ?>	
											<td class="table_sty1"><?php echo $it['iss_qty'.$y]; ?></td>
										
											<?php
												$from4 = date ("Y-m-d", strtotime("+1 day", strtotime($from4)));
												$y++;
											 } $from4=date ("Y-m-d", strtotime("-7 day", strtotime($from4))); ?>
											<td class="table_sty1 color_back"><center><strong><?php echo $it['total_issued']; ?></strong></center></td>

											<?php 
											$y=1;
											while(strtotime($from6) <= strtotime($to)) { ?>	
											<td class="table_sty1"><?php echo $it['res_qty'.$y]; ?></td>
										
											<?php
												$from6 = date ("Y-m-d", strtotime("+1 day", strtotime($from6)));
												$y++;
											 } $from6=date ("Y-m-d", strtotime("-7 day", strtotime($from6))); ?>
											 <td class="table_sty1 color_back"><center><strong><?php echo $it['total_restocked']; ?></strong></center></td>
											<td class="table_sty1"><center><strong><?php echo $it['ending']; ?></strong></center></td>


										</tr>
										<?php 
										$num++;
									} ?>
									</tbody>
								</table>
							</div>
							<?php } ?>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready(function() {
		    $('#scrollexample').DataTable( {
		        "scrollY": 300,
		        "scrollX": true,
		        "lengthMenu": [[-1, 50, 25, 10], ["All", 50, 25, 10]],

		    } );
		} );
		$(document).ready(function () {
		  $('#dtHorizontalExample').DataTable({
		    "scrollX": true
		  });
		  $('.dataTables_length').addClass('bs-select');
		});

		function generateAccounting(){
			 var from= document.getElementById("from_date").value;

			 var cat= document.getElementById("category").value;
			 if(cat!=''){
			 	cat=cat;
			 } else {
			 	cat='null';
			 }
			 var subcat= document.getElementById("subcat").value;
			 if(subcat!=''){
			 	subcat=subcat;
			 } else {
			 	subcat='null';
			 }
			// var to= document.getElementById("to_date").value;
			 window.location.href='<?php echo base_url(); ?>index.php/reports/for_accounting/'+from+'/'+cat+'/'+subcat;
		}
	</script>