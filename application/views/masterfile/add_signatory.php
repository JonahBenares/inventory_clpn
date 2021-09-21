<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script  type="text/javascript">
	function toggle_note(source) {
        checkboxes_note = document.getElementsByClassName('note');
        for(var i=0, n=checkboxes_note.length;i<n;i++) {
            checkboxes_note[i].checked = source.checked;
        }
    }
    function toggle_ins(source) {
    	checkboxes_ins = document.getElementsByClassName('ins');
    	for(var i=0, n=checkboxes_ins.length;i<n;i++) {
            checkboxes_ins[i].checked = source.checked;
        }
    }

    function toggle_del(source) {
    	checkboxes_del = document.getElementsByClassName('del');
		for(var i=0, n=checkboxes_del.length;i<n;i++) {
            checkboxes_del[i].checked = source.checked;
        }
    }

    function toggle_rev(source) {
    	checkboxes_rev = document.getElementsByClassName('rev');
		for(var i=0, n=checkboxes_rev.length;i<n;i++) {
            checkboxes_rev[i].checked = source.checked;
        }
    }

    function toggle_rec(source) {
    	checkboxes_rec = document.getElementsByClassName('rec');
		for(var i=0, n=checkboxes_rec.length;i<n;i++) {
            checkboxes_rec[i].checked = source.checked;
        }
    }

    function toggle_rel(source) {
    	checkboxes_rel = document.getElementsByClassName('rel');
		for(var i=0, n=checkboxes_rel.length;i<n;i++) {
            checkboxes_rel[i].checked = source.checked;
        }
    }

    function toggle_req(source) {
    	checkboxes_req = document.getElementsByClassName('req');
		for(var i=0, n=checkboxes_req.length;i<n;i++) {
            checkboxes_req[i].checked = source.checked;
        }
    }

    function toggle_app(source) {
    	checkboxes_app = document.getElementsByClassName('app');
		for(var i=0, n=checkboxes_app.length;i<n;i++) {
            checkboxes_app[i].checked = source.checked;
        }
    }

    function toggle_ack(source) {
    	checkboxes_ack = document.getElementsByClassName('ack');
		for(var i=0, n=checkboxes_ack.length;i<n;i++) {
            checkboxes_ack[i].checked = source.checked;
        }
    }

    $(document).ready(function() {
	    $("#checkAll").click(function () {
		    $('#checkNote').not(this).prop('checked', this.checked);
		});
		$("#checkAll").click(function () {
		    $('#checkIns').not(this).prop('checked', this.checked);
		});
		$("#checkAll").click(function () {
		    $('#checkdel').not(this).prop('checked', this.checked);
		});
		$("#checkAll").click(function () {
		    $('#checkrev').not(this).prop('checked', this.checked);
		});
		$("#checkAll").click(function () {
		    $('#checkrec').not(this).prop('checked', this.checked);
		});
		$("#checkAll").click(function () {
		    $('#checkIns').not(this).prop('checked', this.checked);
		});
		$("#checkAll").click(function () {
		    $('#checkrel').not(this).prop('checked', this.checked);
		});
		$("#checkAll").click(function () {
		    $('#checkreq').not(this).prop('checked', this.checked);
		});
		$("#checkAll").click(function () {
		    $('#checkapp').not(this).prop('checked', this.checked);
		});
		$("#checkAll").click(function () {
		    $('#checkack').not(this).prop('checked', this.checked);
		});
	});
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/masterfile/signatory">Signatory</a></li>
			<li class="active">Update Signatory</li>
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
				<div class="panel-heading">
					Update Signatories
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<form method = "POST" action = "<?php echo base_url(); ?>index.php/masterfile/insert_signatory">
							<table class="table table-bordered table-hover">
								<thead>
									<tr style="font-size: 13px" >
										<th style="text-align: center;" width="30%">Employee Name</th>
										<th style="text-align: center;">Noted By</th>
										<th style="text-align: center;">Inspected By</th>
										<th style="text-align: center;">Delivered By</th>
										<th style="text-align: center;">Reviewed By</th>
										<th style="text-align: center;">Received By</th>
										<th style="text-align: center;">Released By</th>
										<th style="text-align: center;">Requested By</th>
										<th style="text-align: center;">Approved By</th>
										<th style="text-align: center;">Acknowleged By</th>
										<th width="5%"></th>


									</tr>
								</thead>
								<tbody>
									<tr style="background-color: #ffe08e4a">
										<td align="right"></td>
										<td align="center"><input style="height: 20px" type="checkbox" onClick="toggle_note(this)" name="halo" class="form-control note" ><span class="fa fa-caret-down"></span></td>
										<td align="center"><input style="height: 20px" type="checkbox" onClick="toggle_ins(this)" name="halo" class="form-control ins" ><span class="fa fa-caret-down"></span></td>
										<td align="center"><input style="height: 20px" type="checkbox" onClick="toggle_del(this)" name="halo" class="form-control del" ><span class="fa fa-caret-down"></span></td>
										<td align="center"><input style="height: 20px" type="checkbox" onClick="toggle_rev(this)" name="halo" class="form-control rev" ><span class="fa fa-caret-down"></span></td>
										<td align="center"><input style="height: 20px" type="checkbox" onClick="toggle_rec(this)" name="halo" class="form-control rec" ><span class="fa fa-caret-down"></span></td>
										<td align="center"><input style="height: 20px" type="checkbox" onClick="toggle_rel(this)" name="halo" class="form-control rel" ><span class="fa fa-caret-down"></span></td>
										<td align="center"><input style="height: 20px" type="checkbox" onClick="toggle_req(this)" name="halo" class="form-control req" ><span class="fa fa-caret-down"></span></td>
										<td align="center"><input style="height: 20px" type="checkbox" onClick="toggle_app(this)" name="halo" class="form-control app" ><span class="fa fa-caret-down"></span></td>
										<td align="center"><input style="height: 20px" type="checkbox" onClick="toggle_ack(this)" name="halo" class="form-control ack" ><span class="fa fa-caret-down"></span></td>
										<td style="background-color: #ffe08e7a"></td>
									</tr>
									<?php 
										$count=1;
										foreach($employee as $emp){ 
									?>
									<tr>
										<td><input type = "hidden" name = "employee_id<?php echo $count?>" value = "<?php echo $emp['employeeid'];?>"<?php echo set_checkbox('employee_id', $emp['employeeid']); ?>> <?php echo $emp['employee'];?></td>
										<?php if($emp['noted'] == '0'){ ?>
										<td><input style="height: 20px" type="checkbox" name="noted<?php echo $count?>" value = "1" class="form-control note chkChild" id="checkNote"></td>
										<?php } else{ ?>
										<td><input style="height: 20px" type="checkbox" name="noted<?php echo $count?>" value = "1" <?php echo ((strpos($emp['noted'], "1") !== false) ? ' checked' : '');?> class="form-control note" id="checkNote" ></td>
										<?php } ?>
										<?php if($emp['inspected'] == '0'){  ?>
										<td><input style="height: 20px" type="checkbox" name="inspected<?php echo $count?>" value = "1" class="form-control ins" id="checkIns"></td>
										<?php } else{ ?>
										<td><input style="height: 20px" type="checkbox" name="inspected<?php echo $count?>" value = "1" <?php echo ((strpos($emp['inspected'], "1") !== false) ? ' checked' : '');?> class="form-control ins" id="checkIns"></td>
										<?php }?>
										<?php if($emp['delivered'] == '0'){ ?>
										<td><input style="height: 20px" type="checkbox" name="delivered<?php echo $count?>" value = "1" class="form-control del" id="checkdel"></td>
										<?php } else { ?>
										<td><input style="height: 20px" type="checkbox" name="delivered<?php echo $count?>" value = "1" <?php echo ((strpos($emp['delivered'], "1") !== false) ? ' checked' : '');?> class="form-control del" id="checkdel"></td>
										<?php } ?>
										<?php if($emp['reviewed'] == '0'){ ?>
										<td><input style="height: 20px" type="checkbox" name="reviewed<?php echo $count?>" value = "1" class="form-control rev" id="checkrev"></td>
										<?php } else{ ?>
										<td><input style="height: 20px" type="checkbox" name="reviewed<?php echo $count?>" value = "1" <?php echo ((strpos($emp['reviewed'], "1") !== false) ? ' checked' : '');?>  class="form-control rev" id="checkrev"></td>
										<?php } ?>
										<?php if($emp['received'] == '0') { ?>
										<td><input style="height: 20px" type="checkbox" name="received<?php echo $count?>" value = "1" class="form-control rec" id="checkrec"></td>
										<?php } else { ?>
										<td><input style="height: 20px" type="checkbox" name="received<?php echo $count?>" value = "1" <?php echo ((strpos($emp['received'], "1") !== false) ? ' checked' : '');?> class="form-control rec" id="checkrec"></td>
										<?php } ?>
										<?php if($emp['released'] == '0'){ ?>
										<td><input style="height: 20px" type="checkbox" name="released<?php echo $count?>" value = "1" class="form-control rel" id="checkrel"></td>
										<?php } else { ?>
										<td><input style="height: 20px" type="checkbox" name="released<?php echo $count?>" value = "1"<?php echo ((strpos($emp['released'], "1") !== false) ? ' checked' : '');?> class="form-control rel" id="checkrel"></td>
										<?php } ?>
										<?php if($emp['requested'] == '0'){ ?>
										<td><input style="height: 20px" type="checkbox" name="requested<?php echo $count?>" value = "1" class="form-control req" id="checkreq"></td>
										<?php } else{ ?>
										<td><input style="height: 20px" type="checkbox" name="requested<?php echo $count?>" value = "1"<?php echo ((strpos($emp['requested'], "1") !== false) ? ' checked' : '');?>  class="form-control req" id="checkreq"></td>
										<?php } ?>
										<?php if($emp['approved'] == '0'){ ?>
										<td><input style="height: 20px" type="checkbox" name="approved<?php echo $count?>" value = "1" class="form-control app" id="checkapp"></td>
										<?php } else { ?>
										<td><input style="height: 20px" type="checkbox" name="approved<?php echo $count?>" value = "1"<?php echo ((strpos($emp['approved'], "1") !== false) ? ' checked' : '');?>  class="form-control app" id="checkapp"></td>
										<?php } ?>
										<?php if($emp['acknowledged'] == '0'){ ?>
										<td><input style="height: 20px" type="checkbox" name="acknowledged<?php echo $count?>" value = "1" class="form-control ack" id="checkack"></td>
										<?php } else{ ?>
										<td><input style="height: 20px" type="checkbox" name="acknowledged<?php echo $count?>" value = "1"<?php echo ((strpos($emp['acknowledged'], "1") !== false) ? ' checked' : '');?> class="form-control ack" id="checkack"></td>
										<?php }?>
										<td style="background-color: #ffe08e7a">
											<div class="col-md-1" style="padding:0px">											
												<span class="fa fa-caret-left"></span>
											</div>
											<div class="col-md-11" style="padding:0px">
												<input style="height: 20px" type="checkbox" id="checkAll" name="halo" class="form-control chkParent" >
											</div>
										</td>
									</tr>
									<?php $count++; }?>
								</tbody>
								<input type='hidden' name='count' value='<?php echo $count; ?>'>
							</table>
							<button type="submit" class="btn btn-warning btn-md" style="width:100%">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>