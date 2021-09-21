<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<link href="<?php echo base_url(); ?>assets/Styles/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script>
    $('.select2').select2();
    
    function choosePRmodal(){
        var loc= document.getElementById("baseurl").value;
        var redirect = loc+'index.php/issue/getPRmodal';
        var prno = document.getElementById("prno").value;
        $.ajax({
                type: 'POST',
                url: redirect,
                data: 'prno='+prno,
                dataType: 'json',
                beforeSend: function(){
                    document.getElementById('alt').innerHTML='<b>Please wait, Loading Data...</b>'; 
                    $("#save").hide();
                },
                success: function(response){
                   document.getElementById("department").value  = response.dept;
                   document.getElementById("purpose").value  = response.pur;
                   document.getElementById("enduse").value  = response.end;
                   document.getElementById('alt').innerHTML='';
                   $('#save').show();
               }
        }); 
    }
</script>
<div class="container">
    <div class="card" style="background: #fff; padding: 30px 20px;box-shadow: 1px 1px 1px 1px #eaeaea; border-radius: 10px  ">
        <h4 style="margin-top: 0px"><span class="fa fa-pencil"></span> Edit PR Number </h4>
        <div class="card-body">
        	<form method='POST' action="<?php echo base_url(); ?>index.php/issue/updatePRIssuance">
            <div class="form-group">
                <select class='select2' name='pr_no' id = "prno" onchange="choosePRmodal();">
                	<option></option>
                	<?php 
                
                	foreach($pr_list AS $pr){ ?>
                		<option value='<?php echo $pr->pr_no; ?>'><?php echo $pr->pr_no; ?></option>
                	<?php } ?>
                </select>
            </div>
            <input type='hidden' name='issuance_id' value="<?php echo $issue_id; ?>">
            <input type='hidden' name='request_id' value="<?php echo $request_id; ?>">
            <input type='hidden' name='baseurl' id ="baseurl" value="<?php echo base_url(); ?>">
            <input type='hidden' name='department' id="department">
            <input type='hidden' name='purpose' id="purpose">
            <input type='hidden' name='enduse' id="enduse">
            <div id='alt' style="font-weight:bold;text-align: center"></div>
            <input type="submit" class="btn btn-primary" id ="save" style="width: 100%" name="edit_pr" value="Save">
        </div>
    	</form>
    </div>
</div>
<div style="margin-bottom: 10px "></div>