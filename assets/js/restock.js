var isOpen = "false";
var newwindow=null;
function updateRestock(baseurl, id, resid) {
    
        window.open(baseurl+"index.php/restock/add_restock_second/"+id+"/"+resid, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=500");
  
}

$(document).on('click', '#getR', function(e){
    e.preventDefault();
    var uid = $(this).data('id');    
    var loc= document.getElementById("baseurl").value;
    var redirect1=loc+'/index.php/restock/edit_endpurp';
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
    var redirect=loc+'/index.php/restock/itemlist';
   
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
        var redirect=loc+'/index.php/restock/supplierlist';
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
        var redirect=loc+'/index.php/restock/brandlist';
      //  alert(redirect);
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

    $("#prres").keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/restock/prnolist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'prres='+$(this).val(),
            beforeSend: function(){
                $("#prres").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#suggestion-pr1").show();
                $("#suggestion-pr1").html(data);
                $("#prres").css("background","#FFF");
            }
          });
     });

    $("#reason").keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/restock/reasonlist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'reason='+$(this).val(),
            beforeSend: function(){
                $("#reason").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#suggestion-reason").show();
                $("#suggestion-reason").html(data);
                $("#reason").css("background","#FFF");
            }
          });
     });

    $("#serial").keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/receive/seriallist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'serial='+$(this).val(),
            beforeSend: function(){
                $("#serial").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#suggestion-serial").show();
                $("#suggestion-serial").html(data);
                $("#serial").css("background","#FFF");
            }
          });
     });
});

function selectItem(id,val) {
    $("#item_id").val(id);
    $("#item").val(val);
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

function selectReason(val) {
    $("#reason").val(val);
    $("#suggestion-reason").hide();
}

function selectSerial(id, val) {
    $("#serial_id").val(id);
    $("#serial").val(val);
    $("#suggestion-serial").hide();
}

function selectPrRestock(val,enduse,purpose,dept) {
    $("#prres").val(val);
    $("#deptres").val(dept);
    $("#endres").val(enduse);
    $("#purres").val(purpose);
    $("#deptres").css({"pointer-events": "none"});
    $("#endres").css({"pointer-events": "none"});
    $("#purres").css({"pointer-events": "none"});
    $("#suggestion-pr1").hide();
}


/*function saveRestock(){
    var itemid= document.getElementById("item_id").value;
    var received= document.getElementById("received_by").value;
    var restockdata = $("#restockdetails").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/restock/insertrestock';
    if(itemid==""){
        alert("Please choose item from the auto-suggested list.")
    } else if(received==""){
        alert("Received by must not be empty.")
    }else {
         $.ajax({
            type: "POST",
            url: redirect,
            data:restockdata,
            success: function(output){
                if(output==output){
                    alert('Restock Successful!');
                    window.location.href = loc+'index.php/restock/mrsf/'+output;
                }
            }
          });
    }
}*/

function saveRestock1(){
    var received= document.getElementById("received_byres").value;
    var restockdata1 = $("#restockdetails").serialize();
    var loc= document.getElementById("baseurl1").value;
    var redirect=loc+'/index.php/restock/insert_restock_head';
    if(received==""){
        alert("Received by must not be empty.")
    }else {
         $.ajax({
            type: "POST",
            url: redirect,
            data:restockdata1,
            success: function(output){
                //alert(output);
                alert('Restock Successfully!');
                window.location = loc+'index.php/restock/add_restock_first/'+output;
            }
          });
    }
}

function openAddNewPR(baseurl,id) {
    if (isOpen == "false") {
        isOpen = "true"; 
        window.open(baseurl+"index.php/restock/add_restock_second/"+id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");
    } else {
        newwindow.location.href = url;
        newwindow.focus();
    }
}

function saveRestock(){
    var prdata = $("#Restock").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/restock/insertrestock_Item';
    $.ajax({
        type: "POST",
        url: redirect,
        data: prdata,
        beforeSend: function(){
            document.getElementById('alt').innerHTML='<b>Please wait, Saving Data...</b>'; 
            $("#savebutton").hide(); 
        },
        success: function(output){
            alert('successfully added.');
            window.close();
            window.opener.location.href=loc+'index.php/restock/add_restock_first/'+output;
           //alert(output);
        }
    });
}

function SaveRes(restockID,baseurl){
     var redirect = baseurl+'index.php/restock/saveRestock';
     var result = confirm("Are you sure you want to save Restock?");
     if(result){
         $.ajax({
                type: "POST",
                url: redirect,
                data: 'restockID='+restockID,
                beforeSend: function(){
                    document.getElementById('alt').innerHTML='<b>Please wait, Saving Data...</b>'; 
                    $("#savebutton").hide(); 
                },
                success: function(output){
                    alert('Restock successfully saved.');
                    location.reload();
                }
          });
     }
}

function add_item(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/restock/getitem';

    var supplier =$('#supplier').val();
    var supplierid =$('#supplier_id').val();
    var suppliername =$('#supplier_name').val();
    var itemid =$('#item_id').val();
    var itemname =$('#item_name').val();
    var brand =$('#brand').val();
    var brandid =$('#brand_id').val();
    var brandname =$('#brand_name').val();
    var serial =$('#serial').val();
    var serialid =$('#serial_id').val();
    var catno =$('#catalog_no').val();
    var reason =$('#reason').val();
    var remarks =$('#remarks').val();
    var quantity =parseFloat($('#quantity').val());
    /*var inspected =$('#inspected').val();*/
  
    var item =$('#item').val();
    var i = item.replace(/&/gi,"and");
    var i = i.replace(/#/gi,"");
    var itm = i.replace(/"/gi,"");
    if(supplierid==''){
         alert('Supplier must not be empty. Please choose/click from the suggested supplier list.');
    } else if(itemid==''){
         alert('Item must not be empty. Please choose/click from the suggested item list.');
    } else {
          var rowCount = $('#item_body tr').length;
          count=rowCount+1;
          $.ajax({
                type: "POST",
                url:redirect,
                data: "supplier="+supplier+"&suppliername="+suppliername+"&supplierid="+supplierid+"&itemname="+itemname+"&itemid="+itemid+"&brand="+brand+"&brandid="+brandid+"&brandname="+brandname+"&serial="+serial+"&serialid="+serialid+"&catno="+catno+"&reason="+reason+"&remarks="+remarks+"&item="+item+"&count="+count+"&quantity="+quantity,
                beforeSend: function(){
                    document.getElementById('alrt').innerHTML='<b>Please wait, Loading Data...</b>'; 
                    $("#additm").hide(); 
                },
                success: function(html){
                    //alert(html);
                    $('#item_body').append(html);
                    $('#savebutton').show();
                    $('#itemtable').show();
                    $('#additm').show();
                    $('#alrt').hide();
                    var lth_supplier = document.getElementById("supplier").options.length;
                    var lth_item = document.getElementById("item").options.length;
                    var lth_brand = document.getElementById("brand").options.length;
                    var lth_reason = document.getElementById("reason").options.length;
                    var lgth = parseInt(lth_supplier)-1;
                    var lgth_item = parseInt(lth_item)-1;
                    var lgth_brand = parseInt(lth_brand)-1;
                    var lgth_reason = parseInt(lth_reason)-1;
                    document.getElementById("supplier").options.length=lgth;
                    document.getElementById("item").options.length=lgth_item;
                    document.getElementById("brand").options.length=lgth_brand;
                    document.getElementById("reason").options.length=lgth_reason;
                    document.getElementById("supplier").value = '';
                    document.getElementById("supplier_id").value = '';
                    document.getElementById("item_id").value = '';
                    document.getElementById("reason").value = '';
                    document.getElementById("remarks").value = '';
                    document.getElementById("item").value = '';
                    document.getElementById("brand").value = '';
                    document.getElementById("brand_id").value = '';
                    document.getElementById("brand_name").value = '';
                    document.getElementById("serial").value = '';
                    document.getElementById("serial_id").value = '';
                    document.getElementById("catalog_no").value = '';
                    document.getElementById("counter").value = count;
                    document.getElementById("quantity").value = '';
                   
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

function chooseItem(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/restock/getIteminformation';
    var item = document.getElementById("item").value;
    document.getElementById('alrt').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#additm").hide(); 
    setTimeout(function() {
        document.getElementById('alrt').innerHTML=''; 
        $("#additm").show(); 
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
            $("#original_pn1").val(response.pn);
        }
    }); 
}

function chooseSupplier(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/restock/getSupplierinformation';
    var supplier = document.getElementById("supplier").value;
    document.getElementById('alrt').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#additm").hide(); 
    setTimeout(function() {
        document.getElementById('alrt').innerHTML=''; 
        $("#additm").show(); 
    },5000);
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'supplier='+supplier,
        dataType: 'json',
        success: function(response){
            $("#supplier_id").val(response.supplier_id);
            $("#supplier_name").val(response.supplier_name);
        }
    }); 
}

function choosePRSS(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/restock/getPRinformation';
    var prno = document.getElementById("prres").value;
    document.getElementById('alert').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#proceed").hide(); 
    setTimeout(function() {
        document.getElementById('alert').innerHTML=''; 
        $("#proceed").show(); 
    },5000);
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'prno='+prno,
        dataType: 'json',
        success: function(response){
            $("#prres").val(response.pr_no);
            $("#endres").val(response.enduse);
            $("#deptres").val(response.department);
            $("#purres").val(response.purpose);
        }
    }); 
}

function choosePRres(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/restock/getPRinformation';
    var prno = document.getElementById("pr").value;
    document.getElementById('alertss').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#sub").hide(); 
    setTimeout(function() {
        document.getElementById('alertss').innerHTML=''; 
        $("#sub").show(); 
    },5000);
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'prno='+prno,
        dataType: 'json',
        success: function(response){
            $("#pr").val(response.pr_no);
            $("#end").val(response.enduse);
            $("#dept").val(response.department);
            $("#pur").val(response.purpose);
        }
    }); 
}

function chooseBrand(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/restock/getBrandinformation';
    var brand = document.getElementById("brand").value;
    document.getElementById('alrt').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#additm").hide(); 
    setTimeout(function() {
        document.getElementById('alrt').innerHTML=''; 
        $("#additm").show(); 
    },5000);
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'brand='+brand,
        dataType: 'json',
        success: function(response){
            $("#brand_id").val(response.brand_id);
            $("#brand_name").val(response.brand_name);
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

function addReason() {
   var reason = document.getElementById("reason");
   var reasonname = document.getElementById("reasonname").value;
   var option = document.createElement("OPTION");
   option.innerHTML = document.getElementById("reasonname").value;
   option.value = document.getElementById("reasonname").value;
   reason.options.add(option);
}
