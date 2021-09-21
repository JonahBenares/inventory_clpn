<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/receive.js"></script>
<link href="<?php echo base_url(); ?>assets/Styles/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script>
    $('.select2').select2();
</script>

<?php foreach($details AS $d){ ?>
<div class="row">
	<div class="form-group">
		<div class='col-md-10'>
			<p style="margin: 0px">PR No.</p>
			<select class = "form-control select2" id = "prno1" name = 'pr_no'  onchange="choosePRrec1()">
			<option value = "">--Select PR No--</option>
			<?php foreach($pr_list AS $pr){ ?>
			<option value = "<?php echo $pr->pr_no?>" <?php echo (($d['pr_no'] == $pr->pr_no) ? ' selected' : '');?>><?php echo $pr->pr_no?></option>
			<?php } ?>
			</select>
		</div>
		<div class='col-md-2' style="padding-top: 20px">
			<a class="animated pulse infinite btn clickable btn-success shadow"  data-toggle="modal" data-target="#PRModal" style="border:1px solid #75c700">
				<span class="fa fa-plus"></span>
			</a>
		</div>
	</div>
</div>
<div class="form-group">
	<p style="margin: 0px">Department</p>
	<select class = "form-control" id = "department1" name = 'department'>
		<option value = "">--Select Department--</option>
		<?php foreach($dept AS $dep){ ?>
		<option value = "<?php echo $dep->department_id?>" <?php echo (($d['department_id'] == $dep->department_id) ? ' selected' : '');?>><?php echo $dep->department_name?></option>
		<?php } ?>
	</select>
</div>
<div class="form-group">
	<p style="margin: 0px">Purpose</p>
	<select class = "form-control" id = "purpose1" name = 'purpose'>
		<option value = "">--Select Purpose--</option>
		<?php foreach($purp AS $p){ ?>
		<option value = "<?php echo $p->purpose_id?>" <?php echo (($d['purpose_id'] == $p->purpose_id) ? ' selected' : '');?>><?php echo $p->purpose_desc?></option>
		<?php } ?>
	</select>
</div>
<div class="form-group">
	<input class="form-control" name = "rd_id" type = "hidden" value = "<?php echo $id;?>"/>
	<input class="form-control" name = "rec_id" type = "hidden" value = "<?php echo $rec_id;?>"/>
	<p style="margin: 0px">Enduse</p>
	<select class = "form-control" id = "enduse1" name = 'enduse'>	
		<option value = "">--Select Enduse--</option>
		<?php foreach($end AS $e){ ?>
		<option value = "<?php echo $e->enduse_id?>" <?php echo (($d['enduse_id'] == $e->enduse_id) ? ' selected' : '');?>><?php echo $e->enduse_name?></option>
		<?php } ?>
	</select>
</div>
<div id='alerto1' style="font-weight:bold"></div>
<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
<?php } ?>
<script type="text/javascript">
	function choosePRrec1(){
	    var loc= document.getElementById("baseurl").value;
	    var redirect = loc+'index.php/receive/getPRinformation';
	    var prno = document.getElementById("prno1").value;
	    /*document.getElementById('alerto1').innerHTML='<b>Please wait, Loading data...</b>'; */
	   /* $("#additem").hide(); 
	    setTimeout(function() {
	        document.getElementById('alerto').innerHTML=''; 
	        $("#additem").show(); 
	    },5000);*/
	    $.ajax({
	        type: 'POST',
	        url: redirect,
	        data: 'prno='+prno,
	        dataType: 'json',
	        beforeSend: function(){
                document.getElementById('alerto1').innerHTML='<b>Please wait, Loading data...</b>'; 
            },
	        success: function(response){
	        	document.getElementById('alerto1').innerHTML=''; 
	            $("#prno1").val(response.pr_no);
	            $("#department1").val(response.department_id);
	            $("#enduse1").val(response.enduse_id);
	            $("#purpose1").val(response.purpose_id);
	        }
	    }); 
	}

	function addPR1() {
	   var prno = document.getElementById("prno1");
	   var pr_no = document.getElementById("pr_no").value;
	   var option = document.createElement("OPTION");
	   option.innerHTML = document.getElementById("pr_no").value;
	   option.value = document.getElementById("pr_no").value;
	   prno.options.add(option);
	}
	
</script>