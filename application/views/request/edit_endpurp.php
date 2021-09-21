<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<link href="<?php echo base_url(); ?>assets/Styles/select3.min.css" rel="stylesheet" />
	<?php foreach($request_list AS $list){ ?>
<div class="form-group">
	<p style="margin: 0px">PR No</p>
	<select class = "form-control select3" id = "pr_no" name = 'pr_no'>
		<option value = "">--Select PR No--</option>
		<?php foreach($pr AS $p){ ?>
		<option value = "<?php echo $p->pr_no?>" <?php echo (($list['pr_no'] == $p->pr_no) ? ' selected' : '');?>><?php echo $p->pr_no?></option>
		<?php } ?>
	</select>
</div>
<div class="form-group">
	<p style="margin: 0px">Department</p>
	<select class = "form-control" id = "department" name = 'department'>
		<option value = "">--Select Department--</option>
		<?php foreach($dept AS $dep){ ?>
		<option value = "<?php echo $dep->department_id?>" <?php echo (($list['department_id'] == $dep->department_id) ? ' selected' : '');?>><?php echo $dep->department_name?></option>
		<?php } ?>
	</select>
</div>
<div class="form-group">
	<p style="margin: 0px">Purpose</p>
	<select class = "form-control" id = "purpose" name = 'purpose'>
		<option value = "">--Select Purpose--</option>
		<?php foreach($purp AS $p){ ?>
		<option value = "<?php echo $p->purpose_id?>" <?php echo (($list['purpose_id'] == $p->purpose_id) ? ' selected' : '');?>><?php echo $p->purpose_desc?></option>
		<?php } ?>
	</select>
</div>
<div class="form-group">
	<input class="form-control" name = "request_id" type = "hidden" value = "<?php echo $id;?>"/>
	<p style="margin: 0px">Enduse</p>
	<select class = "form-control" id = "enduse" name = 'enduse'>	
		<option value = "">--Select Enduse--</option>
		<?php foreach($end AS $e){ ?>
		<option value = "<?php echo $e->enduse_id?>" <?php echo (($list['enduse_id'] == $e->enduse_id) ? ' selected' : '');?>><?php echo $e->enduse_name?></option>
		<?php } ?>
	</select>
</div>
<?php } ?>
<script src="<?php echo base_url(); ?>assets/js/select3.min.js"></script>
<script>
    $('.select3').select3();
</script>