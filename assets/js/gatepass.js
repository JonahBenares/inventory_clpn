function add_item(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/gatepass/getitem';


    var itemid =$('#item_id').val();
    var itemname =$('#item_name').val();
    var unit =$('#unit').val();
    var quantity =parseFloat($('#quantity').val());
    
    var item =$('#item').val();
    var i = item.replace(/&/gi,"and");
    var i = i.replace(/#/gi,"");
    var itm = i.replace(/"/gi,"");
    var maxqty = parseFloat(document.getElementById("maxqty").value);
    if(itemid==''){
         alert('Item must not be empty. Please choose/click from the suggested item list.');
    } else if(quantity==''){
         alert('Quantity must not be empty.');
    } else {
          var rowCount = $('#item_body tr').length;
          count=rowCount+1;
          $.ajax({
                type: "POST",
                url:redirect,
                data: "itemid="+itemid+"&itemname="+itemname+"&unit="+unit+"&quantity="+quantity+"&item="+item+"&count="+count,
                beforeSend: function(){
                    document.getElementById('alrt').innerHTML='<b>Please wait, Loading Data...</b>'; 
                    $("#submit").hide(); 
                    $('#savebutton').hide();
                },
                success: function(html){
                    $('#item_body').append(html);
                    $('#itemtable').show();
                    $('#savebutton').show();
                    $('#submit').hide();
                    $('#alrt').hide();

                    $('.select2-selection__rendered').empty();
                    document.getElementById("item_id").value = '';
                    document.getElementById("item_name").value = '';
                    document.getElementById("unit").value = '';
                    document.getElementById("quantity").value = '';
                    document.getElementById("item").value = '';
                    document.getElementById("counter").value = count;
                }
           });
    }
          
}

function saveGatepass(){
    var req = $("#gatepassfrm").serialize();
    var loc= document.getElementById("baseurl").value;
    var conf = confirm('Are you sure you want to save this record?');
    if(conf==true){
        var redirect = loc+'index.php/gatepass/insertGatepass';
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
                    alert("Gatepass successfully Added!");
                    location.reload();
                    window.open(loc+'index.php/gatepass/gatepass_print/'+output, '_blank');
                }
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