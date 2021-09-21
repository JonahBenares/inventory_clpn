<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>
<style type="text/css">
	    #name-item li {width: 50%}
</style>	
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active"> Inventory Report</li>
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
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateReport">
								<table width="100%">
									<tr>
										<td width="15%">Search Item:</td>
										<td>
											<!-- <input type="text" name="item" id="item" class="form-control" autocomplete='off'>
											<span id="suggestion-item"></span> -->
											<select name="item" id='item' class="form-control select2" onchange="chooseItem()">
												<option value = ""></option>
												<?php foreach($item_list AS $itm){ ?>
												<option value = "<?php echo $itm->item_id;?>"><?php echo $itm->original_pn." - ".$itm->item_name;?></option>
												<?php } ?>
											</select>
										</td>
										<td align="center"><div id='alrt' style="font-weight:bold"></div></td>
										<td>
											<input type="submit" name="search_inventory" id="submit" value='Generate Report' class="btn btn-warning" >
										</td>
									</tr>
								</table>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								<input type="hidden" name="item_id" id="item_id">
								<input type="hidden" name="original_pn" id="original_pn">
							</form>
							<br>
							<div id="printableArea">
								<p class="pname"><?php echo $itemdesc;
								if(!empty($items)){ ?>			
									<button id="printReport" class="btn btn-lg btn-primary pull-right " onclick="printDiv('printableArea')">
										<span  class="fa fa-print"></span>
									</button>					
									<a href="" class="btn btn-info pull-right">Overall Quantity: <span style="font-size: 25px" class="badge animated rubberBand "><?php echo $totalbal; ?></span></a>
									
								<?php } ?>								
								</p>
								<table class="table table-hover table-bordered">
									<thead>
										<tr>
											<td align="center"><strong>Supplier</strong></td>
											<td align="center"><strong>Brand</strong></td>
											<td align="center"><strong>Cat No.</strong></td>
											<td align="center"><strong>Qty Received</strong></td>
											<td align="center"><strong>Qty Issued</strong></td>
											
											<td align="center"><strong>Balance</strong></td>
										</tr>
									</thead>
									<tbody>
										<?php 
										if(!empty($items)){
											foreach($items AS $it){ ?>
										<tr>
											<td align="center"><strong><?php echo $it['supplier']; ?></strong></td>
											<td align="center"><strong><?php echo $it['brand']; ?></strong></td>
											<td align="center"><strong><?php echo $it['catalog']; ?></strong></td>
											<td align="center">
												<strong>
												<h4 style="margin:0px">
													<span class="label label-warning"><?php echo $it['received_qty']; ?></span>
												</h4>
												</strong>
											</td>
											<td align="center">
												<strong>
													<h4 style="margin:0px">
														<span class="label label-warning"><?php echo $it['issued_qty']; ?></span>
													</h4>
												</strong>
											</td>
											
											<td align="center"  style="background-color: #ffdea1; font-weight: bold"><?php echo $it['balance']; ?></td>
										</tr>
										<?php }
										} ?>
									</tbody>
								</table>
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
	<script type="text/javascript"></script>