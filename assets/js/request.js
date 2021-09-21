function choosePR(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getPR';
    var prno = document.getElementById("prno").value;
    document.getElementById('alerts').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#proceeds").hide(); 
    setTimeout(function() {
        document.getElementById('alerts').innerHTML=''; 
        $("#proceeds").show(); 
    },5000);
    $.ajax({
            type: 'POST',
            url: redirect,
            data: 'prno='+prno,
            dataType: 'json',
            success: function(response){
               document.getElementById("department").value  = response.dept;
               document.getElementById("purpose").value  = response.pur;
               document.getElementById("enduse").value  = response.end;
           }
    }); 
}

$(document).on('click', '#getEP', function(e){
    e.preventDefault();
    var uid = $(this).data('id');    
    var loc= document.getElementById("baseurl").value;
    var redirect1=loc+'/index.php/request/edit_endpurp';
    $.ajax({
          url: redirect1,
          type: 'POST',
          data: 'id='+uid,
        beforeSend:function(){
            $("#ep").html('Please wait ..');
        },
        success:function(data){
           $("#ep").html(data);
        },
    })
});

$(document).ready(function(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/request/itemlist';
 	
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

});


function selectItem(id,val,unit,original_pn,qty) {
    $("#item_id").val(id);
    $("#item").val(val);
    $("#unit").val(unit);
    $("#original_pn").val(original_pn);
    $("#invqty").val(qty);
   
     crossreferencing();
     balancePRItem();
     $("#suggestion-item").hide();
}

function crossreferencing(prno){
    var itemid= document.getElementById("item_id").value;
    
     var loc= document.getElementById("baseurl").value;
    var redirectcr=loc+'/index.php/request/crossreflist';
    if(itemid!=""){
         $.ajax({
            type: "POST",
            url: redirectcr,
            data:'item='+itemid+'&prno='+prno,
            success: function(data){
                $("#crossreference_list").html(data);
            }
          });
    } 
}

function balancePRItem(){
    var itemid= document.getElementById("item_id").value;
    var pr= document.getElementById("reqpr").value;
    var loc= document.getElementById("baseurl").value;
    var redirectcr=loc+'/index.php/request/checkpritem';
    if(itemid!=""){
         $.ajax({
            type: "POST",
            url: redirectcr,
            data:'item='+itemid+'&pr='+pr,
            success: function(output){
                //console.log(output);
                alert("Available Balance for this PR and Item: " + output);
                document.getElementById("maxqty").value = output;
            }
          });
    } 
}



function isNumberKey(evt){
   var charCode = (evt.which) ? evt.which : event.keyCode;
    var number = el.value.split('.');
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    //just one dot (thanks ddlab)
    if(number.length>1 && charCode == 46){
         return false;
    }
    //get the carat position
    var caratPos = getSelectionStart(el);
    var dotPos = el.value.indexOf(".");
    if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
        return false;
    }
    return true;
}

//thanks: http://javascript.nwbox.com/cursor_position/
function getSelectionStart(o) {
    if (o.createTextRange) {
        var r = document.selection.createRange().duplicate()
        r.moveEnd('character', o.value.length)
        if (r.text == '') return o.value.length
        return o.value.lastIndexOf(r.text)
    } else return o.selectionStart
}


function add_item(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/request/getitem';


    var itemid =$('#item_id').val();
	var itemname =$('#item_name').val();
    var borrowfrom =$('#borrowfrom').val();
    var original_pn =$('#original_pn').val();
    var unit =$('#unit').val();
    /*var invqty =$('#invqty').val();*/
    var quantity =parseFloat($('#quantity').val());
    var invqty =parseFloat($('#invqty').val());
    var unit_cost =$('#unit_cost').val();
    var siid =$('#siid').val();
    
    var item =$('#item').val();
    var i = item.replace(/&/gi,"and");
    var i = i.replace(/#/gi,"");
    var itm = i.replace(/"/gi,"");
    /*var getmax = parseInt(document.getElementById("getmax").value);*/
    var maxqty = parseFloat(document.getElementById("maxqty").value);
     //alert(quantity);
    //alert(maxqty);
    if(itemid==''){
         alert('Item must not be empty. Please choose/click from the suggested item list.');
    } else if(siid==''){
         alert('Cross Reference must not be empty.');
    } else if(quantity==''){
         alert('Quantity must not be empty.');
    }else if(quantity>invqty){
         alert('Cannot request more than existing quantity!');
    } else {
    	  var rowCount = $('#item_body tr').length;
    	  count=rowCount+1;
    	  $.ajax({
    	 		type: "POST",
    	 		url:redirect,
    	 		data: "itemid="+itemid+"&itemname="+itemname+"&siid="+siid+"&original_pn="+original_pn+"&unit="+unit+"&cost="+unit_cost+"&quantity="+quantity+"&item="+item+"&count="+count+"&borrow="+borrowfrom,
                beforeSend: function(){
                    document.getElementById('alrt').innerHTML='<b>Please wait, Loading Data...</b>'; 
                    $("#submit").hide(); 
                    $('#savebutton').hide();
                },
                success: function(html){
                    $('#siid')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="whatever">Please choose item.</option>')
                        .val('whatever')
                    ;

                	$('#item_body').append(html);
                	$('#itemtable').show();
                    $('#savebutton').show();
                    $('#submit').hide();
                	$('#alrt').hide();

                    $('.select2-selection__rendered').empty();
                    document.getElementById("item_id").value = '';
                	document.getElementById("item_name").value = '';
                    document.getElementById("original_pn").value = '';
                    document.getElementById("unit").value = '';
                    document.getElementById("unit_cost").value = '';
                    document.getElementById("invqty").value = '';
                    document.getElementById("quantity").value = '';
                    document.getElementById("item").value = '';
                    document.getElementById("siid").value = '';
                    document.getElementById("borrowfrom").value = '';
                    document.getElementById("counter").value = count;
                }
           });
    }
          
}

function saveRequest(){
    var req = $("#Requestfrm").serialize();
    var loc= document.getElementById("baseurl").value;
    var conf = confirm('Are you sure you want to save this record?');
    if(conf==true){
        var redirect = loc+'index.php/request/insertRequest';
    }else {
        var redirect = '';
    }
     $.ajax({
            type: "POST",
            url: redirect,
            data: req,
            beforeSend: function(){
                document.getElementById('alt').innerHTML='<b>Please wait, Saving Data...</b>'; 
                $("#savebutton").hide(); 
            },
            success: function(output){
                if(conf==true){
                    alert("Request successfully Added!");
                    /*window.location = loc+'index.php/request/mreqf/'+output;*/
                    location.reload();
                    window.open(loc+'index.php/request/mreqf/'+output, '_blank');
                }
               //alert(output);
            }
      });
}

function remove_item(i){
    $('#item_row'+i).remove();
    var rowCount = $('#item_body tr').length;
    if(rowCount==0){
    	$('#savebutton').hide();
    } else {
    	$('#savebutton').show();
    }
     
}


function printMReqF(){
    var sign = $("#mreqfsign").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/printMReqF';
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

function getUnitCost(prno,itemid){
   
    var siid= document.getElementById("siid").value;
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getSIDetails';
    //var redirect = loc+'index.php/request/getReceiveCost';
     $.ajax({
            type: "POST",
            url: redirect,
            data: 'prno='+prno+'&itemid='+itemid+'&siid='+siid,
            beforeSend: function(){
                document.getElementById('alrt').innerHTML='<b>Please wait, Loading data...</b>'; 
                $("#submit").hide(); 
            },
            success: function(output){
                document.getElementById("unit_cost").value = output;
                if(output != ''){
                    $("#submit").show(); 
                    $('#alrt').hide();
                }
                
            }
    });
}

/*function getMaxqty(){
    var siid= document.getElementById("siid").value;
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getMaxqty';
     $.ajax({
            type: "POST",
            url: redirect,
            data: 'siid='+siid,
            success: function(output){
                document.getElementById("maxqty").value = output;
            }
    });
}*/

$(document).ready(function(){
    $("#quantity").keyup(function(){
        var x = document.getElementById("quantity").value;
        $('input[name="getmax"]').val(x);
    });
});

function chooseItem(prno){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getIteminformation';
    var item = document.getElementById("item").value;
    document.getElementById('alrt').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#submit").hide(); 
    setTimeout(function() {
        document.getElementById('alrt').innerHTML=''; 
        /*$("#submit").show(); */
    },5000);
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'item='+item,
        dataType: 'json',
        success: function(response){
            $("#item_id").val(response.item_id);
            $("#item_name").val(response.item_name);
            $("#unit").val(response.unit);
            $("#original_pn").val(response.pn);
            $("#invqty").val(response.recqty);
            balancePRItem();
            crossreferencing(prno);
            
        }
    }); 
}

function chooseEmpreq(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getEmpreq';
    var requested = document.getElementById("requested").value;
    document.getElementById('alt').innerHTML='<b>Please wait, Loading data...</b>'; 
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'employee_id='+requested,
        dataType: 'json',
        success: function(response){
            $("#alt").hide();
            $("#positionreq").val(response.position);
        }
    }); 
}

function chooseEmprev(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getEmprev';
    var reviewed = document.getElementById("reviewed").value;
    document.getElementById('alts').innerHTML='<b>Please wait, Loading data...</b>'; 
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'employee_id='+reviewed,
        dataType: 'json',
        success: function(response){
            $("#alts").hide();
            $("#positionrev").val(response.position);
        }
    }); 
}

function chooseEmpapp(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getEmpapp';
    var approved = document.getElementById("approved").value;
    document.getElementById('altss').innerHTML='<b>Please wait, Loading data...</b>'; 
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'employee_id='+approved,
        dataType: 'json',
        success: function(response){
            $("#altss").hide();
            $("#positionapp").val(response.position);
        }
    }); 
}

function chooseEmpnoted(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getEmpnoted';
    var noted = document.getElementById("noted").value;
    document.getElementById('altsss').innerHTML='<b>Please wait, Loading data...</b>'; 
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'employee_id='+noted,
        dataType: 'json',
        success: function(response){
            $("#altsss").hide();
            $("#positionnoted").val(response.position);
        }
    }); 
}