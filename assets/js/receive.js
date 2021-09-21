    
    var isOpen = "false";
    var newwindow=null;
function openAddNewPR(baseurl, id) {

if (isOpen == "false") {
        isOpen = "true"; 
	    window.open(baseurl+"index.php/receive/add_receive_second/"+id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");
    } else {
        newwindow.location.href = url;
        newwindow.focus();
    }
}

function updateReceivePR(baseurl, id, rdid) {
        window.open(baseurl+"index.php/receive/add_receive_second/"+id+"/"+rdid, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=500");
}


$(document).on('click', '#getEP1', function(e){
    e.preventDefault();
    var uid = $(this).data('id');    
    var loc= document.getElementById("baseurl").value;
    var rec_id= document.getElementById("rec").value;
    var redirect1=loc+'/index.php/receive/edit_endpurp';
    $.ajax({
          url: redirect1,
          type: 'POST',
          data: 'id='+uid+'&recid='+rec_id,
        beforeSend:function(){
            $("#ep").html('Please wait ...');
        },
        success:function(data){
           $("#ep").html(data);
        },
    })
});

$(document).ready(function(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/receive/itemlist';
    var rdid= document.getElementById("rdid").value;
    if(rdid==0){
	   $('#savebutton').hide();
    } else {
        $('#savebutton').show();
    }
	/*$('#itemtable').hide();*/
	$("#item").keyup(function(){
	      $.ajax({
	        type: "POST",
	        url: redirect,
	        data:'item='+$(this).val(),
	        beforeSend: function(){
	            $("#item").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
	        },
	        success: function(data){
	            $("#suggestion-item").show();
	            $("#suggestion-item").html(data);
	            $("#item").css("background","#FFF");
	        }
	      });
	 });

	$("#supplier").keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/receive/supplierlist';
	      $.ajax({
	        type: "POST",
	        url: redirect,
	        data:'supplier='+$(this).val(),
	        beforeSend: function(){
	            $("#supplier").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
	        },
	        success: function(data){
	            $("#suggestion-supplier").show();
	            $("#suggestion-supplier").html(data);
	            $("#supplier").css("background","#FFF");
	        }
	      });
	 });

    $("#brand").keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/receive/brandlist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'brand='+$(this).val(),
            beforeSend: function(){
                $("#brand").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#suggestion-brand").show();
                $("#suggestion-brand").html(data);
                $("#brand").css("background","#FFF");
            }
          });
     });


    /*$("#purpose").keyup(function(){
        document.getElementById("purpose_id").value = "";
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/receive/purposelist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'purpose='+$(this).val(),
            beforeSend: function(){
                $("#purpose").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#suggestion-purpose").show();
                $("#suggestion-purpose").html(data);
                $("#purpose").css("background","#FFF");
            }
          });
     });*/

     $("#serial").keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var item =$('#item').val();
        var brand =$('#brand').val();
         var counter =$('#item_body tr').length;
         var brandl = [];
            for(var x = 1; x<=counter; x++){
                var bl =$('#brandlist_'+x).val();
                brandl.push(bl);
            }

        var iteml = [];
            for(var x = 1; x<=counter; x++){
                var il =$('#itemlist_'+x).val();
                iteml.push(il);
            }
         
         var seriall = [];
            for(var x = 1; x<=counter; x++){
                var sl =$('#seriallist_'+x).val();
                seriall.push(sl);
            }

        var redirect=loc+'/index.php/receive/seriallist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'serial='+$(this).val()+'&item='+item+'&brand='+brand+'&brandl='+brandl+'&iteml='+iteml+'&seriall='+seriall,
            beforeSend: function(){
                $("#serial").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                if(data!='error'){
                    $("#suggestion-serial").show();
                    $("#suggestion-serial").html(data);
                    $("#serial").css("background","#FFF");
                   document.getElementById("additem").style.pointerEvents="auto";
                   document.getElementById("additem").style.cursor="pointer";
                } else {
                    alert('Warning: Serial number with the same item and brand is already existing.');
                    document.getElementById("additem").style.pointerEvents="none";
                    document.getElementById("additem").style.cursor="default";
                }
                
            }
          });
     });

     $("#prno").keyup(function(){

        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/receive/prnolist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'prno='+$(this).val(),
            beforeSend: function(){
                $("#prno").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){


                $("#suggestion-prno").show();
                $("#suggestion-prno").html(data);
                $("#prno").css("background","#FFF");
            }
          });
     });
});

function selectItem(id,val,unit,original_pn) {
    $("#item_id").val(id);
    $("#item").val(val);
    $("#unit").val(unit);
    $("#original_pn1").val(original_pn);
    $("#suggestion-item").hide();
}

function selectSupplier(id, val) {
    $("#supplier_id").val(id);
    $("#supplier").val(val);
    $("#suggestion-supplier").hide();
}

function selectBrand(id, val) {
    $("#brand_id").val(id);
    $("#brand").val(val);
    $("#suggestion-brand").hide();
}

function selectSerial(id, val) {
    $("#serial_id").val(id);
    $("#serial").val(val);
    $("#suggestion-serial").hide();
}

/*function selectPurpose(id, val) {
    $("#purpose_id").val(id);
    $("#purpose").val(val);
    $("#suggestion-purpose").hide();
}*/

function selectPRNO(valu,dept,enduse,purposeid,inspected_by) {
 
 
    $("#prno").val(valu);
    $("#department").val(dept);



    $("#enduse").val(enduse);
    $("#purpose").val(purposeid);
    $("#inspected").val(inspected_by);

 //   $("#purpose").val(purpose1);
  
   /* $("#purpose_id").val(purposeid);*/
   
    $("#department").css({"pointer-events": "none"});
    $("#enduse").css({"pointer-events": "none"});
    $("#purpose").css({"pointer-events": "none"});
    /*$("#purpose").attr('disabled','disabled');*/
    $("#suggestion-prno").hide();
}



function add_item(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/receive/getitem';

	var supplier =$('#supplier').val();
    var supplierid =$('#supplier_id').val();
	var suppliername =$('#supplier_name').val();
    var itemid =$('#item_id').val();
	var itemname =$('#item_name').val();
    var brand =$('#brand').val();
    var brandname =$('#brand_name').val();
    var brandid =$('#brand_id').val();
    var serial =$('#serial').val();
    var serialid =$('#serial_id').val();
    var unitcost =$('#unit_cost').val();
    var catno =$('#catalog_no').val();
    var unit =$('#unit').val();
    var expqty =parseFloat($('#exp_qty').val());
    var recqty =parseFloat($('#rec_qty').val());
    var remarks =$('#remarks').val();
    var shipping_fee =parseFloat($('#shipping_fee').val());
    var currency =$('#currency').val();
    //var expiration_date =$('#expiration_date').val();
    if ($("input:radio[name=local_mnl]:checked").val() == '1') {
        var local_mnl = '1';
    } 
    else if($("input:radio[name=local_mnl]:checked").val() == '2'){
        var local_mnl = '2';
    }

   
    if ($("input:radio[name=local_mnl]:checked").val() == '1') {
        var local_mnl = '1';
    } 
    else if($("input:radio[name=local_mnl]:checked").val() == '2'){
        var local_mnl = '2';
    }

    var item =$('#item').val();
    var i = item.replace(/&/gi,"and");
    var i = i.replace(/#/gi,"");
    var itm = i.replace(/"/gi,"");
    if(supplierid==''){
         alert('Supplier must not be empty. Please choose/click from the suggested supplier list.');
    } else if(itemid==''){
         alert('Item must not be empty. Please choose/click from the suggested item list.');
    }else if(unitcost==''){
         alert('Unit Cost must not be empty.');
    }else if(recqty==''){
         alert('Delivered/Received quantity must not be empty.');
    }else {
    	  var rowCount = $('#item_body tr').length;
    	  count=rowCount+1;
    	  $.ajax({
    	 		type: "POST",
    	 		url:redirect,
    	 		data: "supplier="+supplier+"&supplierid="+supplierid+"&suppliername="+suppliername+"&itemname="+itemname+"&itemid="+itemid+"&brand="+brand+"&brandid="+brandid+"&brandname="+brandname+"&serial="+serial+"&serialid="+serialid+"&unitcost="+unitcost+"&catno="+catno+"&unit="+unit+"&expqty="+expqty+"&recqty="+recqty+"&remarks="+remarks+"&item="+item+"&count="+count+"&local_mnl="+local_mnl+"&shipping_fee="+shipping_fee+"&currency="+currency,
              /*  beforeSend: function(){
                    document.getElementById('alerto').innerHTML='<b>Please wait, Loading Data...</b>'; 
                    $("#additem").hide(); 
                },*/
                success: function(html){
                    //alert(html);
                	$('#item_body').append(html);
                	$('#savebutton').show();
                    $('#itemtable').show();
                    $('#additem').show();
                	$('#alerto').hide();
                    //var lth_supplier = document.getElementById("supplier").options.length;
                    //var lth_item = document.getElementById("item").options.length;
                    //var lth_brand = document.getElementById("brand").options.length;
                    //var lgth = parseInt(lth_supplier)-1;
                    //var lgth_item = parseInt(lth_item)-1;
                    //var lgth_brand = parseInt(lth_brand)-1;
                    //document.getElementById("supplier").options.length=lgth;
                    //document.getElementById("item").options.length=lgth_item;
                    //document.getElementById("brand").options.length=lgth_brand;
                    $('.select2-selection__rendered').empty(); 
                	document.getElementById("supplier").value = '';
                    document.getElementById("supplier_id").value = '';
                    document.getElementById("supplier_name").value = '';
                    document.getElementById("item_id").value = '';
                    document.getElementById("unit").value = '';
                    //document.getElementById("expiration_date").value = '';
                    document.getElementById("shipping_fee").value = '';
                    document.getElementById("currency").value = '';
                    document.getElementById("exp_qty").value = '';
                    document.getElementById("rec_qty").value = '';
                    document.getElementById("remarks").value = '';
                    document.getElementById("item").value = '';
                    document.getElementById("item_name").value = '';
                    document.getElementById("brand").value = '';
                    document.getElementById("brand_id").value = '';
                    document.getElementById("brand_name").value = '';
                    document.getElementById("serial").value = '';
                    document.getElementById("serial_id").value = '';
                    document.getElementById("catalog_no").value = '';
                    document.getElementById("unit_cost").value = '';
                    document.getElementById("counter").value = count;
                }
           });
    }
          
}

function remove_item(i){
    $('#item_row'+i).remove();
    var rowCount = $('#item_body tr').length;
    if(rowCount==0){
    	$('#savebutton').hide();
    	$('#itemtable').hide();
    } else {
    	$('#savebutton').show();
    	$('#itemtable').show();
    }
     
}

function isNumberKey(txt, evt){
   var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 46) {
        //Check if the text already contains the . character
        if (txt.value.indexOf('.') === -1) {
            return true;
        } else {
            return false;
        }
    } else {
        if (charCode > 31
             && (charCode < 48 || charCode > 57))
            return false;
    }
    return true;
}



 function savereceive_PR(){

     var prdata = $("#PRform").serialize();
   
    var prno = document.getElementById('prno').value;
    var department = document.getElementById('department').value;
    var enduse = document.getElementById('enduse').value;
    var purpose = document.getElementById('purpose').value;
    var inspected = document.getElementById('inspected').value;
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/insertReceivePR';
    if(prno==""){
        alert('Please fill out PR number.');
    } else if (department==""){ 
        alert('Please fill out Department.');
    } else if (enduse==""){ 
        alert('Please fill out Enduse.');
    } else if (purpose==""){ 
        alert('Please fill out Purpose.');
    } else if (inspected==""){ 
        alert('Please fill out Inspected By.');
    }else {
         $.ajax({
                type: "POST",
                url: redirect,
                data: prdata,
                beforeSend: function(){
                    document.getElementById('alt').innerHTML='<b>Please wait, Saving Data...</b>'; 
                    $("#savebutton").hide(); 
                },
                success: function(output){
                    alert('PR successfully added.');
                    window.close();
                    window.opener.location.href=loc+'index.php/receive/add_receive_first/'+output;       
                    //alert(output);

                }
          });
    }
     
}

function deleteReceiveDetails(rdid,receiveid,baseurl){
    var redirect = baseurl+'index.php/receive/deleteRecDetails';
    var result = confirm("Are you sure you want to delete received PR?");
    if (result) {
          $.ajax({
                type: "POST",
                url: redirect,
                data: 'rdid='+rdid,
                success: function(output){
                    alert('PR successfully deleted.');
                    location.reload();
                }
          });
    }
}

function removerecitem(riid,baseurl){
    var redirect = baseurl+'index.php/receive/deleteRecItem';
    var result = confirm("Are you sure you want to delete this item?");
    if (result) {
        $.ajax({
                type: "POST",
                url: redirect,
                data: 'riid='+riid,
                success: function(output){
                    alert('Item successfully deleted.');
                    location.reload();
                }
          });
    }
}

function SaveReceive(receiveID,baseurl){
     var redirect = baseurl+'index.php/receive/saveReceive';
     var result = confirm("Are you sure you want to save DR?");
     if(result){
         $.ajax({
                type: "POST",
                url: redirect,
                data: 'receiveID='+receiveID,
                beforeSend: function(){
                    document.getElementById('alt').innerHTML='<b>Please wait, Saving Data...</b>'; 
                    $("#savebutton").hide(); 
                },
                success: function(output){
                     //alert(output);
                    alert('DR successfully saved.');
                    location.reload();
                    
                }
          });
     }
}

function printMRF(){
    var sign = $("#mrfsign").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/printMRF';
     $.ajax({
            type: "POST",
            url: redirect,
            data: sign,
            success: function(output){
                if(output=='success'){
                    window.print();
                }
                //alert(output);
                
            }
    });
}

function update_prcmrk(id,baseurl) {
    var myWindow = window.open(baseurl+"index.php/receive/update_prc_mrk/"+id, "", "top=100,left=450,width=500,height=350");
}

function update_head(id,baseurl) {
    var myWindow = window.open(baseurl+"index.php/receive/update_headr/"+id, "", "top=100,left=450,width=550,height=400");
}



function closePopup(){
    window.close();
}

function chooseItem(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/getIteminformation';
    var item = document.getElementById("item").value;
    var suppid = document.getElementById("supplier_id").value;
    document.getElementById('alerto').innerHTML='<b>Please wait, Loading data...</b>'; 
    $('#additem').hide();
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'item='+item,
        dataType: 'json',
        success: function(response){
            $("#item_id").val(response.item_id);
            $("#item_name").val(response.item_name);
            $("#unit").val(response.unit);
            $("#original_pn1").val(response.pn);
            if(response.item_id !== '' && suppid=== ''){
                document.getElementById('alerto').innerHTML='Please fill out Supplier. If already chosen, please wait...';
            }
            if(response.item_id !== '' && suppid!== ''){
              document.getElementById('alerto').innerHTML=''; 
                $('#additem').show();
            }
        }
    }); 
}

function chooseSupplier(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/getSupplierinformation';
    var supplier = document.getElementById("supplier").value;
     var itid = document.getElementById("item_id").value;
    // $("#additem").hide(); 
   // document.getElementById('alerto').innerHTML='<b>Please wait, Loading data...</b>'; 
   //  $("#additem").hide(); 
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'supplier='+supplier,
        dataType: 'json',
        success: function(response){
            $("#supplier_id").val(response.supplier_id);
            $("#supplier_name").val(response.supplier_name);
           //if(response.supplier_id !== '' && itid!== ''){
                document.getElementById('alerto').innerHTML='';
                $('#additem').show();
            //} 
        }
    }); 
}

function chooseBrand(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/getBrandinformation';
    var brand = document.getElementById("brand").value;
    //document.getElementById('alerto').innerHTML='<b>Please wait, Loading data...</b>'; 
   // $("#additem").hide(); 
  /* setTimeout(function() {
        document.getElementById('alerto').innerHTML=''; 
        $("#additem").show(); 
    },5000);*/
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'brand='+brand,
        dataType: 'json',
        success: function(response){
            $("#brand_id").val(response.brand_id);
            $("#brand_name").val(response.brand_name);
           // $("#additem").show(); 
        }
    }); 
}

function addBrand() {
   var brand = document.getElementById("brand");
   var brandname = document.getElementById("brandname").value;
   var option = document.createElement("OPTION");
   option.innerHTML = document.getElementById("brandname").value;
   option.value = document.getElementById("brandname").value;
   brand.options.add(option);
   /*var loc= document.getElementById("baseurl1").value;
   var redirect = loc+'index.php/receive/insertbrand';
   $.ajax({
        type: "POST",
        url: redirect,
        data: 'brandname='+brandname,
        success: function(output){
            $('#brand').selectmenu('refresh', true);
            document.getElementById("brandname").value = '';
        }
    });*/
}

function choosePRrec(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/getPRinformation';
    var prno = document.getElementById("prno").value;
    document.getElementById('alerto').innerHTML='<b>Please wait, Loading data...</b>'; 
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
        success: function(response){
            $("#prno").val(response.pr_no);
            $("#department").val(response.department_id);
            $("#enduse").val(response.enduse_id);
            $("#purpose").val(response.purpose_id);
            $("#inspected").val(response.inspected_by);
        }
    }); 
}

function addPR() {
   var prno = document.getElementById("prno");
   var pr_no = document.getElementById("pr_no").value;
   var option = document.createElement("OPTION");
   option.innerHTML = document.getElementById("pr_no").value;
   option.value = document.getElementById("pr_no").value;
   prno.options.add(option);
}

function chooseEmprec(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/getEmpinfo';
    var received = document.getElementById("received").value;
    document.getElementById('alt').innerHTML='<b>Please wait, Loading data...</b>'; 
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'employee_id='+received,
        dataType: 'json',
        success: function(response){
            $("#alt").hide();
            $("#position").val(response.position);
        }
    }); 
}

function chooseEmpack(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/getEmpack';
    var acknowledged = document.getElementById("acknowledged").value;
    document.getElementById('alts').innerHTML='<b>Please wait, Loading data...</b>'; 
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'employee_id='+acknowledged,
        dataType: 'json',
        success: function(response){
            $("#alts").hide();
            $("#positionack").val(response.position);
        }
    }); 
}

function chooseEmpnoted(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/getEmpnoted';
    var noted = document.getElementById("noted").value;
    document.getElementById('altss').innerHTML='<b>Please wait, Loading data...</b>'; 
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'employee_id='+noted,
        dataType: 'json',
        success: function(response){
            $("#altss").hide();
            $("#positionnoted").val(response.position);
        }
    }); 
}

