		<div class="col-sm-12">
				<p class="back-link">Warehouse Inventory System || <a href="http://www.cenpripower.com">CENPRI</a></p>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
	</div>
	<link href="<?php echo base_url(); ?>assets/Styles/select2.min.css" rel="stylesheet" />
	<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
	<script>
	    $('.select2').select2();
	</script>
	<link href="<?php echo base_url(); ?>assets/Styles/select3.min.css" rel="stylesheet" />
	<script src="<?php echo base_url(); ?>assets/js/select3.min.js"></script>
	<script>
	    $('.select3').select3();
	</script>
	<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chart.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chart-data.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/easypiechart.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/easypiechart-data.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
	<script>
		window.onload = function () {
			var	myVar;
			myVar	=setTimeout(showPage,2000);					
					
			/*var chart1 = document.getElementById("line-chart").getContext("2d");
			window.myLine = new Chart(chart1).Line(lineChartData, {
			responsive: true,
			scaleLineColor: "rgba(0,0,0,.2)",
			scaleGridLineColor: "rgba(0,0,0,.05)",
			scaleFontColor: "#c5c7cc"
			});*/
		};

		function showPage() {
			document.getElementById("loader").style.display = "none";
			document.getElementById("itemslist").style.display = "block";
			
		}

		$(document).ready(function() {
    $('#example').DataTable( {
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    } );
} );

		$(document).ready( function () {
		    $('#item_table').DataTable({
		    	"aaSorting": [[ 0, "asc" ]],
		    	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		    	"pageLength": 25
		    });
		    $('#aging_table').DataTable({
		    	// "aaSorting": [ [ 1, "asc" ]],
		    	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		    	"pageLength": 50
		    });
		    $('#aging_table2').DataTable({
		    	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		    	"pageLength": 25
		    });
		    
		    $('#received').DataTable({
		    	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		    	 "aaSorting": [[ 0, "desc" ] ]
		    });
		    $('#request_datatable').DataTable({
		    	"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
		    	"aaSorting": [[ 0, "desc" ], [ 1, "desc" ]]
		    });
		} );
		function confirmationDelete(anchor){
	        var conf = confirm('Are you sure you want to delete this record?');
	        if(conf)
	        window.location=anchor.attr("href");
    	}
	</script>
	<script type="text/javascript">
		$(document).ready(function () {    
	        $("#submitButton").click(function (e) {  
	            if (($("#file").val() == "")) { 
	                alert("You must not leave the field empty!");  
	            }
	            else {  
	            	$('#loda').modal('show');
					document.getElementById("loading").style.display = "block";
	                $.ajax({  
	                    type: "POST",   
	                    dataType: "json",  
	                    success: function (msg) {  
	                        setTimeout(function () {
				                $('#loading').html('<?php echo base_url();?>index.php/masterfile/import_items');
				            }, 2000);  
	                    },  
	                });  
	            }   
	        });  
	    });
	    $(document).ready(function () {    
	        $("#submit").click(function (e) {  
	            if (($("#file1").val() == "")) { 
	                alert("You must not leave the field empty!");  
	            }
	            else {  
	            	$('#loads').modal('show');
					document.getElementById("loading").style.display = "block";
	                $.ajax({  
	                    type: "POST",   
	                    dataType: "json",  
	                    success: function (msg) {  
	                        setTimeout(function () {
				                $('#loading').html('<?php echo base_url();?>index.php/masterfile/import_items');
				            }, 2000);  
	                    },  
	                });  
	            }   
	        });  
	    });
	    
	</script>
	<script>
		document.getElementById('e').value = new Date().toISOString().substring(0, 10);
		document.getElementById('d').value = new Date().toISOString().substring(0, 10);
	</script>
	<!-- <script type="text/javascript">
		$(document).ready(function(){
	        $('.type').change(function(){
	            if($('.type option:selected').val() ==  'JO / PR' ){
	                $('.t').show();
	                //$('#prno').removeAttr('disabled');
	            }
	            else{
	                $('.t').slideUp();
	              // $('#prno').attr('disabled','disabled');
	              document.getElementById('prno').value = '';
	            }
	        });
	    });
	</script> -->
	<script type="text/javascript">
		function printDiv(divName) {
	     var printContents = document.getElementById(divName).innerHTML;
	     var originalContents = document.body.innerHTML;
	     document.body.innerHTML = printContents;
	     window.print();
	     document.body.innerHTML = originalContents;
	}

	function printDiv2(divName) {
	     var printContents = document.getElementById(divName).innerHTML;
	     var originalContents = document.body.innerHTML;
	     document.body.innerHTML = printContents;
	     window.print();
	     document.body.innerHTML = originalContents;
	}
	</script>
</body>
</html>