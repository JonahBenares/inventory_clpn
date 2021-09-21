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
			<li class="active"> Aging Report</li>
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
						<div class="col-lg-12">
							<div class="col-lg-3">
								<form method = "POST">
									<select class="form-control animated rubberBand" onchange="get_age()" id = "age">
										<option value = "">--Select Range of Age--</option>
										<option value = "60">1-60</option>
										<option value = "120">61-120</option>
										<option value = "180">121-180</option>
										<option value = "360">181-360</option>
										<option value = "361">360+</option>
									</select>
								</form>
							</div>
							<?php if(!empty($days)){ ?>
							<div class = "col-lg-4" style = "top:8px">	
								<strong>Range of Age:</strong> <?php echo  $days; ?>
								<a href='<?php echo base_url(); ?>index.php/reports/aging_report' class=' label label-sm label-danger' style ="margin-left:10px">Remove Filter</a>
							</div>
							<?php } ?> 
							<?php if(empty($days)){ ?>
							<div class="pull-right ">
								<a href = "<?php echo base_url(); ?>index.php/reports/export_aging" class = "btn btn-info">Export to Excel</a>
							</div>
							<br>
							<hr>
							<div id="printableArea">
								<button id="printReport" class="btn btn-md btn-primary pull-left " title="Change Show Entries to 'All' then click Print button" onclick="printDiv('printableArea')">Print</button>
								<button class="btn btn-warning btn-lg animated headShake pull-right" style="margin-bottom: 10px">
									TOTAL: <b><?php echo number_format(array_sum($total),2); ?></b></button>
								<br>
								<?php if(empty($days)){ ?>
									<table class="table table-hover table-bordered" id="aging_table" >
										<thead>
											<tr>
												<td align="center">#</td>
												<td >Item Name</td>
												<td align="center">Date Received</td>									
												<td align="center">Qty</td>									
												<td align="center">Unit Price</td>									
												<td align="center">0-60</td>
												<td align="center">61-120</td>
												<td align="center">121-180</td>
												<td align="center">181-360</td>
												<td align="center">360 +</td>
											</tr>
										</thead>
										<tbody>
											<?php foreach($item_info as $in){ ?>
											<tr>
												<td align="center" style="padding:0px"><?php echo $in['item']; ?></td>
												<td style="padding:0px">
													<li class="dropdown" style="list-style:none;margin:0px;width:100%">
														<a class="btn btn-default btn-sm " style="width:450px;text-align: left;font-size: 13px; font-weight: 700;white-space: normal!important" data-toggle="dropdown" href="#">
															<?php echo $in['item_desc']. ", " .  $in['supplier_name'];?>														
														</a>
														<ul class="dropdown-menu dropdown-alerts animated fadeInDown" style="width:500px;top:35px;border:1px solid #e66614;left:0px;">
															<span class="arrow-top2"></span>
															<li style="padding:5px">	
																<table class="table table-hover table-bordered" style="margin:0px">	
																	<tr>
																		<td width="20%" class="pad-t-4"><strong>Brand:</strong></td>
																		<td class="pad-t-4">
																			<label style="color:#555;font-weight: 600"><?php echo $in['brand_name']?></label >
																		</td>
																	</tr>
																	<tr>
																		<td class="pad-t-4"><strong>Supplier:</strong></td>
																		<td class="pad-t-4">
																			<label style="color:#555;font-weight: 600"><?php echo $in['supplier_name']?></label >
																		</td>
																	</tr>
																	<tr>
																		<td class="pad-t-4"><strong>Catalog No:</strong></td>
																		<td class="pad-t-4">
																			<label style="color:#555;font-weight: 600"><?php echo $in['catalog_no']?></label >
																		</td>
																	</tr>
																</table>
															</li>
														</ul>
													</li>	
												</td>
												<td align="left" style="padding:0px">
													<table class="table-bordered table table-hover" style="margin: 0px">
													<?php foreach($info AS $i){ 
														if($i['qty']!=0){
															if($in['item'] == $i['item'] && $in['supplier'] == $i['supplier'] && $in['brand'] == $i['brand'] && $in['catalog_no'] == $i['catalog_no']) { ?>
															<tr>
																<td align="center"><?php echo $i['receive_date'];?></td>
															</tr>
															<?php } 
															} 
														}?>
													</table>
												</td>
												<td align="left" style="padding:0px">
													<table class="table-bordered table table-hover" style="margin: 0px">
														<?php foreach($info AS $i){ 
															if($i['qty']!=0){
													if($in['item'] == $i['item'] && $in['supplier'] == $i['supplier'] && $in['brand'] == $i['brand'] && $in['catalog_no'] == $i['catalog_no']) { ?>
														<tr>
															<td align="center"><?php echo $i['qty'];?></td>
														</tr>
														<?php } } }?>
													</table>
												</td>
												<td align="left" style="padding:0px">
													<table class="table-bordered table table-hover" style="margin: 0px">
													<?php foreach($info AS $i){ 
														if($i['qty']!=0){
													if($in['item'] == $i['item'] && $in['supplier'] == $i['supplier'] && $in['brand'] == $i['brand'] && $in['catalog_no'] == $i['catalog_no']) { ?>
														<tr>
															<td align="center"><?php echo $i['unit_cost'];?></td>
														</tr>
														<?php } } } ?>
													</table>
												</td>
												<td style="padding:0px;background:#d2ffde">
													<table class="table-bordered table table-hover" style="margin: 0px">
														<?php 
															foreach($info AS $i){ 
																if($i['qty']!=0){
															$diff = dateDifference($now,$i['receive_date']);
															if($in['item'] == $i['item'] && $in['supplier'] == $i['supplier'] && $in['brand'] == $i['brand'] && $in['catalog_no'] == $i['catalog_no']) { 
																if($diff >= 0 && $diff<=60){
														?>
														<tr>
															<td align="center" style="padding:3px;background:#d2ffde">
																<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo number_format($i['unit_x'],2);?></b></button>
															</td>
														</tr>
														<?php } else { ?>
														<tr>
															<td align="center" style="background:#d2ffde">&nbsp;<br></td>
														</tr>	
														<?php } } } }?>
													</table>											
												</td>
												<td style="padding:0px;background:#fcffd2">
													<table class="table-bordered table table-hover" style="margin: 0px">
														<?php 
															foreach($info AS $i){ 
																if($i['qty']!=0){
															$diff = dateDifference($now,$i['receive_date']);
															if($in['item'] == $i['item'] && $in['supplier'] == $i['supplier'] && $in['brand'] == $i['brand'] && $in['catalog_no'] == $i['catalog_no']) { 
																if($diff >= 61 && $diff<=120){
														?>
														<tr>
															<td align="center" style="padding:3px;background:#fcffd2">
																<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo number_format($i['unit_x'],2);?></b></button>
															</td>
														</tr>
														<?php } else { ?> 
														<tr>
															<td align="center" style="background:#fcffd2">&nbsp;<br></td>
														</tr>	
														<?php } } } }?>
													</table>											
												</td>
												<td style="padding:0px;background:#ffe7d2">
													<table class="table-bordered table table-hover" style="margin: 0px">
														<?php 
															foreach($info AS $i){ 
																 if($i['qty']!=0){
															$diff = dateDifference($now,$i['receive_date']);
															if($in['item'] == $i['item'] && $in['supplier'] == $i['supplier'] && $in['brand'] == $i['brand'] && $in['catalog_no'] == $i['catalog_no']) { 
																if($diff >= 121 && $diff <=180){
														?>
														<tr>
															<td align="center" style="padding:3px;background:#ffe7d2">
																<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo number_format($i['unit_x'],2);?></b></button>
															</td>
														</tr>
														<?php } else { ?>
														<tr>
															<td align="center" style="background:#ffe7d2">&nbsp;<br></td>
														</tr>			
														<?php } } } }?>
													</table>											
												</td>
												<td style="padding:0px;background: #ffd4d2">
													<table class="table-bordered table table-hover" style="margin: 0px">
														<?php 
															foreach($info AS $i){ 
																if($i['qty']!=0){
															$diff = dateDifference($now,$i['receive_date']);
															if($in['item'] == $i['item'] && $in['supplier'] == $i['supplier'] && $in['brand'] == $i['brand'] && $in['catalog_no'] == $i['catalog_no']) { 
																if($diff >= 181 && $diff<=360){
														?>
														<tr>
															<td align="center" style="padding:3px;background: #ffd4d2">
																<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo number_format($i['unit_x'],2);?></b></button>
															</td>
														</tr>
														<?php } else { ?>
														<tr>
															<td align="center" style="background: #ffd4d2">&nbsp;<br></td>
														</tr>
														<?php } } } } ?>
													</table>											
												</td>
												<td style="padding:0px;background: #decac9">
													<table class="table-bordered table table-hover" style="margin: 0px">
														<?php 
															foreach($info AS $i){ 
																if($i['qty']!=0){
															$diff = dateDifference($now,$i['receive_date']);
															if($in['item'] == $i['item'] && $in['supplier'] == $i['supplier'] && $in['brand'] == $i['brand'] && $in['catalog_no'] == $i['catalog_no']) { 
																if($diff>360){
														?>
														<tr>
															<td align="center" style="padding:3px;background: #decac9">
																<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo number_format($i['unit_x'],2);?></b></button>
															</td>
														</tr>
														<?php } else { ?>
														<tr>
															<td align="center" style="background: #decac9">&nbsp;<br></td>
														</tr>	
														<?php } } } } ?>
													</table>											
												</td>
											</tr>
											<?php } } ?>
										</tbody>
										<tfoot>
											<tr>
												<td align="center">#</td>
												<td >Item Name</td>
												<td align="center">Date Received</td>									
												<td align="center">Qty</td>									
												<td align="center">Unit Price</td>									
												<td align="center">1-60</td>
												<td align="center">61-120</td>
												<td align="center">121-180</td>
												<td align="center">181-360</td>
												<td align="center">360 +</td>
											</tr>
										</tfoot>
									</table>			
							</div>				
							<?php } else { ?>
								<div class="pull-right ">
									<a href = "<?php echo base_url(); ?>index.php/reports/export_aging_range/<?php echo $days; ?>" class = "btn btn-info">Export to Excel</a>
								</div>
								<br>
								<hr>
								<button id="printReport" class="btn btn-md btn-primary pull-left " title="Change Show Entries to 'All' then click Print button" onclick="printDiv2('printableArea2')">Print</button>
								<div id="printableArea2">
									<button class="btn btn-warning btn-lg animated headShake pull-right">TOTAL: <b><?php echo number_format(array_sum($total2),2); ?></b></button>
									<br>
									<table class="table table-hover table-bordered" id="aging_table2" >
										<thead>
											<tr>
												<td width="20%">Item Name</td>
												<td width="20%">Brand</td>
												<td width="20%">Supplier</td>
												<td width="20%">Catalog Number</td>
												<td width="20%">Received Date</td>
												<td width="20%">Quantity</td>
												<td width="20%">Unit Cost</td>
												<td width="20%"><center><?php echo $days . " days"; ?></center></td>
											</tr>
										</thead>
										<tbody>
											<?php foreach($info as $t){ 
												$diff = dateDifference($now,$t['receive_date']); 
												$start_diff=$days-59;
												if($days!='361'){
													//echo $diff .">=" . $start_diff ." && " . $diff . "<= ".$days."<br>";
													if($diff>= $start_diff && $diff <= $days) { 
														if($t['qty']!=0){ ?>
												<tr>
												<td width="20%"><?php echo $t['item']; ?></td>
												<td width="20%"><?php echo $t['brand']; ?></td>
												<td width="20%"><?php echo $t['supplier']; ?></td>
												<td width="20%"><?php echo $t['catalog_no']; ?></td>
												<td width="20%"><?php echo $t['receive_date']; ?></td>
												<td width="20%"><?php echo $t['qty']; ?></td>
												<td width="20%"><?php echo $t['unit_cost']; ?></td>
												
												<td width="20%"><center><?php echo number_format($t['unit_x'],2); ?></center></td>
												</tr>
												<?php } 
													}
												} else {
													if($diff>= $days) { 
														if($t['qty']!=0){?>
												<tr>
													<td width="20%"><?php echo $t['item']; ?></td>
													<td width="20%"><?php echo $t['brand']; ?></td>
													<td width="20%"><?php echo $t['supplier']; ?></td>
													<td width="20%"><?php echo $t['catalog_no']; ?></td>
													<td width="20%"><?php echo $t['qty']; ?></td>
													<td width="20%"><?php echo $t['unit_cost']; ?></td>
													<td width="20%"><center><?php echo number_format($t['unit_x'],2); ?></center></td>
												</tr>
											<?php } } } } ?>
										</tbody>
									</table>
								</div>
							<?php } ?>	
							<table width="100%" id="prntby">
				                <tr>
				                    <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
				                </tr>
				            </table> 						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
        function get_age(){
            var age = $('#age').val();
            var loc= document.getElementById("baseurl").value;
            window.location.href = loc+"index.php/reports/aging_report/"+age;
        }
    </script>