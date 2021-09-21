<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>

<style type="text/css">
	#name-item{
		width: 94%!important;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active"> PR Report (Receive)</li>
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
					<div class="panel-body">
						<div class="canvas-wrapper">
							<form method="POST" action ="<?php echo base_url();?>index.php/reports/generatePr">
								<div class="col-lg-3"> <h5 class="pull-right">Enter PR:</h5> </div>
								<div class="col-lg-5">
									<!-- <input type="text" name="pr" id="pr" class="form-control" autocomplete='off'>
									<span id="suggestion-pr"></span> -->
									<select name="pr" id='pr' class="form-control select2" onchange="choosePRS()" style="margin:4px;width:100%">
										<option value = "">-Choose PR-</option>
										<?php foreach($pr_rep AS $prs){ ?>
										<option value = "<?php echo $prs->pr_no;?>"><?php echo $prs->pr_no;?></option>
										<?php } ?>
									</select>
								</div>
								<div id='alrt' style="font-weight:bold"></div>
								<div class="col-lg-4"><input type="submit" class="btn btn-warning" id ="submit" name="search_pr" Value="Find"></div>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								<input type="hidden" name="prid" id="prid">
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php if(!empty($head) && !empty($details)){ ?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading" >
					<button class="btn btn-md btn-primary pull-right " onclick="printDiv('printableArea')">Print</button>
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div id="printableArea">
							<?php foreach($head AS $h){ ?>	
							<div style="padding:10px; margin-bottom: 20px;border-radius: 10px;box-shadow: 0px 0px 5px 2px #b9b9b9;border: 1px solid #b9b9b9">
								<table width="100%">
									<tr>
										<td width="10%"><p class="nomarg">Date:</p></td>
										<td width="20%" colspan="3"><?php echo date('F j, Y',strtotime($h['recdate']));?><h5 class="nomarg"></h5></td>

										 <td width = "5%">
											  <?php if($h['closed'] == '0'){ ?>
											<a class="btn btn-gold" title="close PR"><span class="fa fa-unlock"></span></a>
											<?php } else { ?>
											<a class="btn disabled btn-gold" title="PR CLOSED"><span class="fa fa-lock"></span></a>
											<?php } ?>	  
										</td> 
									</tr>
									<tr>
										<td width="10%"><p class="nomarg">DR #:</p></td>
										<td width="20%"> <h5 class="nomarg"><?php echo $h['drno'];?></h5></td>
										<td width="10%"><p class="nomarg">PR/JO #:</p></td>
										<td > <h5 class="nomarg labelStyle"><?php echo $h['prno'];?></h5></td>
									</tr>
									<tr>
										<td><p class="nomarg">SI #:</p></td>
										<td> <h5 class="nomarg"><?php echo $h['sino'];?></h5></td>
										<td ><p class="nomarg">Department:</p></td>
										<td ><h5 class="nomarg"><?php echo $h['department']; ?></h5></td>
									</tr>
									<tr>
										<td><p class="nomarg">PO #:</p></td>
										<td> <h5 class="nomarg"><?php echo $h['pono'];?></h5></td>
										<td><p class="nomarg">End Use:</p></td>
										<td> <h5 class="nomarg"><?php echo $h['enduse'];?></h5></td>
									</tr>
									<tr>
										<td><p class="nomarg">PCF #:</p></td>
										<td> <h5 class="nomarg"><?php echo $h['pcf'];?></h5></td>
										<td ><p class="nomarg">Purpose:</p></td>
										<td > <h5 class="nomarg"><?php echo $h['purpose'];?></h5></td>
									</tr>
								</table>
								<br>
								<div class="row">
									<div class="col-lg-12">
										<table width="100%" class="table table-bordered " >
												<tr >
													<th class="tr-bottom" width="5%"><center>Item No.</center></th>
													<th class="tr-bottom" width="15%"><center>Supplier</center></th>
													<th class="tr-bottom" width="15%"><center>Description</center></th>

													<th class="tr-bottom" width="10%"><center>Brand</center></th>
													<th class="tr-bottom" width="5%"><center>Cat. No.</center></th>
													<th class="tr-bottom" width="5%"><center>Ser. No.</center></th>
													<th class="tr-bottom" width="5%"><center>Unit Cost</center></th>

													<th class="tr-bottom" width="10%"><center>Expected Qty</center></th>
													<th class="tr-bottom" width="10%"><center>Delivered / Received</center></th>
													<th class="tr-bottom" width="5%"><center>UOM</center></th>
													<th class="tr-bottom" width="20%"><center>Remarks</center></th>
													<th class="tr-bottom" width="10%"><center>Inspected By</center></th>
												</tr>
												<tr>
													<?php 
														if(!empty($items)){
															$itemno = 1;
															foreach($items AS $i){ 
																if($i['recid']==$h['recid']){
													?>
													<td><center><?php echo $itemno; ?></center></td>
													<td><?php echo $i['supplier']; ?></td>
													<td><?php echo $i['item']; ?></td>
													<td><?php echo $i['brand']; ?></td>
													<td><?php echo $i['catalog_no']; ?></td>
													<td><?php echo $i['serial']; ?></td>
													<td><?php echo $i['unit_cost']; ?></td>
													<td><center><?php echo $i['expqty']; ?></center></td>
													<td><center><?php echo $i['recqty']; ?></center></td>
													<td><center><?php echo $i['unit']; ?></center></td>
													<td><?php echo $i['remarks']; ?></td>
													<td><center><?php echo $i['inspected']; ?></center></td>
												</tr>
												<?php $itemno++; } } }
											?>									
										</table>
									</div>
								</div>
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
	</div>
	<?php } ?>



	