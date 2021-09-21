<td  style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr><td align="center"><?php echo $t['qty'];?></td></tr>
												<tr><td align="center">28</td></tr>
											</table>
										</td>
										<td style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr><td align="center"><?php echo $t['unit_cost'];?></td></tr>
												<tr><td align="center">28</td></tr>
											</table>
										</td>
										<?php 
											if($diff >= 1 && $diff<=30){
										?>
										<td style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr>
													<td align="center" style="padding:3px">
														<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo $t['unit_x'];?></b></button>
													</td>
												</tr>
												<tr>
													<td align="center" style="padding:3px">
														<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo $t['qty'];?></b></button></td>
												</tr>
											</table>											
										</td>
										<?php } else { ?>
										<td align="center" style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="center">&nbsp;</td>
												</tr>
											</table>	
										</td>
										<?php } ?>
										<?php if($diff >= 31 && $diff<=60){ ?>
										<td style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr>
													<td align="center" style="padding:3px">
														<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo $t['unit_x'];?></b></button>
													</td>
												</tr>
												<tr>
													<td align="center" style="padding:3px">
														<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"></b></button></td>
												</tr>
											</table>											
										</td>
										<?php } else { ?>
										<td align="center" style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="center">&nbsp;</td>
												</tr>
											</table>	
										</td>
										<?php } ?>
										<?php if($diff >= 61 && $diff <=90){ ?>
										<td style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr>
													<td align="center" style="padding:3px">
														<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo $t['unit_x'];?></b></button>
													</td>
												</tr>
												<tr>
													<td align="center" style="padding:3px">
														<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"></b></button></td>
												</tr>
											</table>											
										</td>
										<?php } else{ ?>
										<td align="center" style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="center">&nbsp;</td>
												</tr>
											</table>	
										</td>
										<?php } ?>
										<?php if($diff >= 91 && $diff<=120){ ?>
										<td style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr>
													<td align="center" style="padding:3px">
														<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo $t['unit_x'];?></b></button>
													</td>
												</tr>
												<tr>
													<td align="center" style="padding:3px">
														<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"></b></button></td>
												</tr>
											</table>											
										</td>
										<?php } else { ?>
										<td align="center" style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="center">&nbsp;</td>
												</tr>
											</table>	
										</td>
										<?php } ?>
										<?php if($diff>120){ ?>
										<td style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr>
													<td align="center" style="padding:3px">
														<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"><?php echo $t['unit_x'];?></b></button>
													</td>
												</tr>
												<tr>
													<td align="center" style="padding:3px">
														<button class="btn btn-warning btn-sm" disabled=""><b style="letter-spacing: 1px;color:black!important"></b></button></td>
												</tr>
											</table>											
										</td>
										<?php } else { ?>
										<td align="center" style="padding:0px">
											<table class="table-bordered table table-hover" style="margin: 0px">
												<tr>
													<td align="center">&nbsp;</td>
												</tr>
												<tr>
													<td align="center">&nbsp;</td>
												</tr>
											</table>	
										</td>
										<?php } ?>
									</tr>
									<?php } ?>
									<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								</tbody>
							</table>
							<?php } else { ?>
								<div class="pull-right ">
									<!-- <a href="" class="btn btn-info">Export to Excel</a> -->
									<a href = "<?php echo base_url(); ?>index.php/reports/export_aging_range/<?php echo $days; ?>" class = "btn btn-info">Export to Excel</a>
								</div>
								<br>
								<hr>
								<br>
								<table class="table table-hover table-bordered" id="item_table" >
								<thead>
									<tr>
										<td width="20%">Item Name</td>
										<td width="20%">Brand</td>
										<td width="20%">Supplier</td>
										<td width="20%">Catalog Number</td>
										<td width="20%"><center><?php echo $days; ?></center></td>
									</tr>
								</thead>
								<tbody>
									<?php foreach($aging as $t){ 
										$diff = dateDifference($now,$t['date']); 
										$start_diff=$days-29;
										if($days!='121'){
											if($diff>= $start_diff && $diff <= $days) { ?>
										<tr>
										<td width="20%"><?php echo $t['item']; ?></td>
										<td width="20%"><?php echo $t['brand']; ?></td>
										<td width="20%"><?php echo $t['supplier']; ?></td>
										<td width="20%"><?php echo $t['catalog_no']; ?></td>
										<td width="20%"><center><?php echo $t['qty']; ?></center></td>
										</tr>
										<?php } 
										} else {
											if($diff>= $days) { ?>
										<tr>
										<td width="20%"><?php echo $t['item']; ?></td>
										<td width="20%"><?php echo $t['brand']; ?></td>
										<td width="20%"><?php echo $t['supplier']; ?></td>
										<td width="20%"><?php echo $t['catalog_no']; ?></td>
										<td width="20%"><center><?php echo $t['qty']; ?></center></td>
										</tr>
								<?php } } } ?>
								