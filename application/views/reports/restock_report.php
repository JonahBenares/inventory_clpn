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
			<li class="active"> Restock Report</li>
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
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateRestock">
								<table width="100%" style="font-size: 12px">
									<tr>
										<td width="10%">Search Item:</td>
										<td width="30%">
											From:
											<input type="date" class="form-control" name="from">
										</td>
										<td width="30%">
											To:
											<input type="date" class="form-control" name="to">
										</td>										
										<td width="30%">
											<br>
											<select name="item" class="form-control select2" >
												<option value="" selected="">-Item-</option>
												<?php foreach($item AS $it){ ?>
													<option value="<?php echo $it->item_id; ?>"><?php echo $it->item_name; ?></option>
												<?php } ?>
											</select>
										</td>										
									</tr>
									<tr>
										<td></td>
										<td>
											<br>
											<select name="category" class="form-control" id="category" onChange="chooseCategory();">
												<option value="" selected="">-Category-</option>
												<?php foreach($category AS $cat){ ?>
													<option value="<?php echo $cat->cat_id; ?>"><?php echo $cat->cat_name; ?></option>
												<?php } ?>
											</select>
										</td>
										<td width="">
											<br>
											<select name="subcat" class="form-control" id="subcat" style="width: 100%">
											
											</select>
										</td>
										<td>
											<br>
											<select name="enduse" class="form-control select2">
												<option value="" selected="">-Enduse-</option>
												<?php foreach($enduse AS $e){ ?>
													<option value="<?php echo $e->enduse_id; ?>"><?php echo $e->enduse_name; ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<br>
											<select name="pr_no" class="form-control select2">
												<option value="" selected="">-PR Number-</option>
													<?php foreach($pr_restock_list AS $pr){ ?>
													<option value="<?php echo $pr->pr_no; ?>"><?php echo $pr->pr_no; ?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<br>
											<select name="purpose" class="form-control select2 ">
												<option value="" selected="">-Purpose-</option>
													<?php foreach($purpose AS $p){ ?>
													<option value="<?php echo $p->purpose_id; ?>"><?php echo $p->purpose_desc; ?></option>
												<?php } ?>

											</select>
										</td>
										<td>
											<br>
											<input type="submit" name="search_inventory" value='Generate' class="btn btn-warning btn-block" >
										</td>
									</tr>		
								</table>
							</form>
							<br>
							<?php if(!empty($restock)){ ?>
							<a href = "<?php echo base_url(); ?>index.php/reports/export_restock/<?php echo $from;?>/<?php echo $to;?>/<?php echo $catt1;?>/<?php echo $subcat2;?>/<?php echo $item1;?>/<?php echo $enduse1;?>/<?php echo $purpose1;?>/<?php echo $pr_no1;?>" class = "btn btn-primary pull-right">Export to Excel</a>
							<a href="<?php echo base_url(); ?>index.php/reports/restock_report_print/<?php echo $from;?>/<?php echo $to;?>/<?php echo $catt1;?>/<?php echo $subcat2;?>/<?php echo $item1;?>/<?php echo $enduse1;?>/<?php echo $purpose1;?>/<?php echo $pr_no1;?>" class="btn btn-info pull-right "><span  class="fa fa-print"></span></a>
							<br>
							<div id="printableArea">
								<p class="pname"><?php echo $c; ?> - <small class="main_cat"><?php echo $s; ?></small></p>
								<div style="overflow-x: scroll;padding-bottom: 20px ">
								<table class="table-bordered table-hover table" id="received" style="font-size: 12px;width: 150%">
									<thead>
										<tr>
											<td width="" align="center"><strong>Restock Date</strong></td>
											<td width="" align="center"><strong>PR#.</strong></td>
											<td width="" align="center"><strong>Item Part No.</strong></td>
											<td width="" align="center"><strong>Item Description</strong></td>
											<td width="" align="center"><strong>Total Qty Restocked</strong></td>
											<td width="" align="center"><strong>UoM</strong></td>
											<td width="" align="center"><strong>Unit Cost</strong></td>
											<td width="" align="center"><strong>Total Cost</strong></td>
											<td width="" align="center"><strong>Supplier</strong></td>
											<td width="" align="center"><strong>Department</strong></td>
											<td width="30%" align="center"><strong>End-Use</strong></td>
											<td width="" align="center"><strong>Purpose</strong></td>
											<td  align="center"><strong>Reason</strong></td>
											<td  align="center"><strong>Remarks</strong></td>
										</tr>
									</thead>
									<tbody>
										<?php foreach($restock as $rec){ ?>
										<tr>
											<td align="center"><?php echo date('d-M-Y',strtotime($rec['res_date']));?></td>
											<td align="center"><?php echo $rec['pr']?></td>
											<td align="center"><?php echo $rec['pn']?></td>
											<td align="center"><?php echo $rec['item']?></td>
											<td align="center"><?php echo $rec['qty']?></td>
											<td align="center"><?php echo $rec['unit']?></td>
											<td align="center"><?php echo $rec['unit_cost']?></td>
											<td align="center"><?php echo number_format($rec['total_cost'],2); ?></td>
											<td align="center"><?php echo $rec['supplier']?></td>
											<td align="center"><?php echo $rec['department']?></td>
											<td align="center"><?php echo $rec['enduse']?></td>
											<td align="center"><?php echo $rec['purpose']?></td>
											<td align="center"><?php echo $rec['reason']?></td>
											<td align="center"><?php echo $rec['remarks']?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<table width="100%" id="prntby">
					                <tr>
					                    <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
					                </tr>
					            </table> 
							</div>
							<?php } ?>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
