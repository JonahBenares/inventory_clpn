$(document).ready(function(){
	$("#display_mreqf").hide();

    var loc= document.getElementById("baseurl").value;

    var redirect=loc+'index.php/issue/mreqflist';

	$("#mreqf").keyup(function(){

	      $.ajax({
	        type: "POST",
	        url: redirect,
	        data:'mreqf='+$(this).val(),
	        beforeSend: function(){
	            $("#mreqf").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
	        },
	        success: function(data){

	            $("#suggestion-mreqf").show();
	            $("#suggestion-mreqf").html(data);
	            $("#mreqf").css("background","#FFF");
	        }
	      });
	 });

    $(".iss_qty").change(function(){
        var iss= parseInt($(this).val());
        var rem_qty = parseInt($(this).attr('data-id')); 
       
        if(iss>rem_qty){
            alert('Error: Issued quantity is greater than remaining quantity of item.');
             $('input[type="button"]').attr('disabled','disabled');
        } else {
             $('input[type="button"]').removeAttr('disabled');
        }
    });

});

$(document).on('click', '#getEP', function(e){
    e.preventDefault();
    var uid = $(this).data('id');    
    var loc= document.getElementById("baseurl").value;
    var redirect1=loc+'/index.php/issue/edit_endpurp';
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


function isNumberKey(evt){
  var charCode = (evt.which) ? evt.which : event.keyCode;
    var number = evt.value.split('.');
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

function selectMreqF(no,id) {
    $("#mreqf").val(no);
    $("#request_id").val(id);
    $("#suggestion-mreqf").hide();
}

function loadIssuance(){
	var id= document.getElementById("request_id").value;	
	var loc= document.getElementById("baseurl").value;
	window.location.href = loc+'index.php/issue/load_issue/'+id;

}

function loadBackOrder(){
	var id= document.getElementById("mreqf").value;	
	var loc= document.getElementById("baseurl").value;
	window.location.href = loc+'index.php/backorder/back_order/'+id;

}



function saveIssue(){
	var reqid= document.getElementById("request_id").value;

	var issuedata = $("#issueform").serialize();
	var loc= document.getElementById("baseurl").value;
	var redirect = loc+'index.php/issue/saveIssuance';

      	  $.ajax({
	        type: "POST",
	        url: redirect,
	        data: issuedata,
            beforeSend: function(){
                document.getElementById('alt').innerHTML='<b>Please wait, Saving Data...</b>'; 
                $("#savebutton").hide(); 
            },
	        success: function(output){
                //alert(output);
	        	window.location.href = loc+'index.php/issue/view_issue';
	        	window.open( loc+'index.php/issue/mif/'+output,'_blank');
	         
	        }
	      });
      
}

function saveBackorder(){
	
	var issuedata = $("#issueform").serialize();
	var loc= document.getElementById("baseurl").value;
	var redirect = loc+'index.php/backorder/saveBackorder';

      	  $.ajax({
	        type: "POST",
	        url: redirect,
	        data: issuedata,
            beforeSend: function(){
                document.getElementById('alt').innerHTML='<b>Please wait, Saving Data...</b>'; 
                $("#savebutton").hide(); 
            },
	        success: function(output){
            $('#savebutton').hide();
            $('#alt').hide();
	        //window.location.href = loc+'index.php/receive/view_';
	        window.open( loc+'index.php/receive/mrf/'+output,'_blank');
	         
	        }
	      });
      
}

function reprintIssue(issueid){
	var loc= document.getElementById("baseurl").value;

	window.open( loc+'index.php/issue/mif/'+issueid,'_blank');
	         
	    
      
}


function printMIF(){
    var sign = $("#mifsign").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/issue/printMIF';
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


function printGP(){
    var sign = $("#gpsign").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/issue/printGP';
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

function chooseMreqf(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/issue/getMreqfinformation';
    var mreqf = document.getElementById("mreqf").value;
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'mreqf='+mreqf,
        dataType: 'json',
        beforeSend: function(){
            document.getElementById('alrt').innerHTML='<b>Please wait, Loading data...</b>'; 
             $("#saveissuance").hide();
        },
        success: function(response){
            $("#mreqf").val(response.mreqf);
            $("#request_id").val(response.request_id);
             document.getElementById('alrt').innerHTML='';
             $("#saveissuance").show();

        }
    }); 
}

function changePrice(count){
  //alert(count);
   var cost = document.getElementById("item_cost"+count).value;
   var qty = document.getElementById("quantity"+count).value;
   var item_total = parseFloat(cost) * parseFloat(qty);
    document.getElementById("total_cost").innerHTML  =item_total;
}

function changeQty(count){
  //alert(count);
   var cost = document.getElementById("item_cost"+count).value;
   var qty = document.getElementById("quantity"+count).value;
   var item_total = parseFloat(cost) * parseFloat(qty);
    document.getElementById("total_cost").innerHTML  =item_total;
}

function chooseEmprel(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/issue/getEmprel';
    var released = document.getElementById("released").value;
    document.getElementById('alt').innerHTML='<b>Please wait, Loading data...</b>'; 
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'employee_id='+released,
        dataType: 'json',
        success: function(response){
            $("#alt").hide();
            $("#position").val(response.position);
        }
    }); 
}

function chooseEmprec(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/issue/getEmprec';
    var received = document.getElementById("received").value;
    document.getElementById('alts').innerHTML='<b>Please wait, Loading data...</b>'; 
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'employee_id='+received,
        dataType: 'json',
        success: function(response){
            $("#alts").hide();
            $("#positionrec").val(response.position);
        }
    }); 
}

function chooseEmpnoted(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/issue/getEmpnoted';
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

function chooseBrand(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/backorder/getBrandinformation';
    var brand = document.getElementById("brand").value;
    var brand_id = document.getElementById("brand_id").value;
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'brand='+brand,
        dataType: 'json',
        success: function(response){
            $("#brand_id").val(response.brand_id);
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
}