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
			<li class="active"> Issued Report</li>
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
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateIssue">
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
											<select name="item" class="form-control select2">
												<option value = "" selected="">-Item-</option>
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
												<option value = "" selected="">-Category-</option>
												<?php foreach($category AS $cat){ ?>
													<option value="<?php echo $cat->cat_id; ?>"><?php echo $cat->cat_name; ?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<br>
											<select name="subcat" class="form-control btn-block" id="subcat">
												
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
													<?php foreach($pr_issue_list AS $pr){ ?>
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
							<?php if(!empty($issue)){ ?>
							<a href = "<?php echo base_url(); ?>index.php/reports/export_issue/<?php echo $from;?>/<?php echo $to;?>/<?php echo $catt;?>/<?php echo $subcat1;?>/<?php echo $item1;?>/<?php echo $enduse1;?>/<?php echo $purpose1;?>/<?php echo $pr_no1;?>" class = "btn btn-primary pull-right">Export to Excel</a>
							<button id="printReport" class="btn btn-info pull-right " onclick="printDiv('printableArea')">
									<span  class="fa fa-print"></span>
							</button>
							<br>
							<div id="printableArea">
								<p class="pname"><?php echo $c; ?> - <small class="main_cat"><?php echo $s; ?></small></p><!-- 
								<?php echo "Total Cost w/ PR: " . number_format(array_sum($pr_cost),2) . "<br>"; 
								echo "Total Cost of WH Stocks: " . number_format(array_sum($wh_cost),2) . "<br>";
								echo "Total Number of Items w/ PR w/o Cost: " . number_format($wh_wo_cost) . "<br>";
								echo "Total Number of Items from WH Stocks w/o Cost: " . number_format($pr_wo_cost) . "<br>";?> -->

								<table width="100%" class="table-bordered">
									<tr>
										<td width="">Total Cost w/ PR:</td>
										<td width="20%" align="right" style="background: #fff4e2;font-weight: 450"><?php echo number_format(array_sum($pr_cost),2)?></td>
										<td width="4%"><br></td>
										<td width="">Total Number of Items w/ PR w/o Cost:</td>
										<td width="20%" align="right" style="background: #fff4e2;font-weight: 450"><?php echo number_format($wh_wo_cost) ?></td>
									</tr>
									<tr>
										
										<td>Total Cost of WH Stocks:</td>
										<td align="right" style="background: #fff4e2;font-weight: 450"><?php echo number_format(array_sum($wh_cost),2) ?></td>
										<td></td>
										<td>Total Number of Items from WH Stocks w/o Cost:</td>
										<td align="right" style="background: #fff4e2;font-weight: 450"><?php echo number_format($pr_wo_cost) ?></td>
									</tr>
								</table>
								<br>
								<div style="overflow-x: scroll;padding-bottom: 20px ">
									<table class="table table-hover table-bordered" id="received" style="font-size: 12px">
										<thead>
											<tr>
												<td align="center"><strong>Issue Date</strong></td>
												<td align="center"><strong>PO No.</strong></td>
												<td align="center"><strong>PR No.</strong></td>
												<td align="center"><strong>MIF No.</strong></td>
												<td align="center"><strong>Item Part No.</strong></td>
												<td align="center"><strong>Item Description</strong></td>
												<td align="center"><strong>Total Qty Issued</strong></td>
												<td align="center"><strong>UoM</strong></td>
												<td align="center"><strong>Unit Cost</strong></td>
												<td align="center"><strong>Total Cost</strong></td>
												<td align="center"><strong>Supplier</strong></td>
												<td align="center"><strong>Department</strong></td>
												<td align="center"><strong>Purpose</strong></td>
												<td align="center"><strong>End Use</strong></td>
												<td style="width:2%" align="center"><strong>Freq</strong></td>
											</tr>
										</thead>
										<tbody>
											<?php foreach($issue AS $is){ ?>
											<tr>
												<td align="center"><?php echo  date('Y-m-d',strtotime($is['issue_date']));?></td>
												<td align="center"><?php echo $is['po_no']?></td>
												<td align="center"><?php echo (($is['type'] == 'JO / PR') ? $is['pr'] :  $is['type']); ?></td>
												<td align="center"><?php echo $is['mif_no']?></td>
												<td align="center"><?php echo $is['pn'];?></td>
												<td align="center"><?php echo $is['item'];?></td>
												<td align="center"><?php echo $is['issqty'];?></td>
												<td align="center"><?php echo $is['unit'];?></td>
												<td align="center"><?php echo $is['unit_cost'];?></td>
												<td align="center"><?php echo number_format($is['total_cost'],2);?></td>
												<td align="center"><?php echo $is['supplier'];?></td>
												<td align="center"><?php echo $is['department'];?></td>
												<td align="center"><?php echo $is['purpose'];?></td>
												<td align="center"><?php echo $is['enduse'];?></td>
												<td align="center"><?php ?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
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

