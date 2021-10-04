$(document).ready(function(){
    $("#submit").click(function(){
      var loc= document.getElementById("baseurl").value;
      var redirect=loc+'/index.php/gatepass/insertimage';
      var frm = new FormData();
      image = document.getElementById('image');
      frm.append('image', image.files[0]);
      item = document.getElementById('item').value;
      frm.append('item', item);
      gatepassid = document.getElementById('gatepassid').value;
      frm.append('gatepassid', gatepassid);
      $.ajax({
      method:'POST',
      url: redirect,
      data:frm,
      cache:false,
      contentType: false,
      processData: false,
      beforeSend: function(){
          $('#alrt').show();
          document.getElementById('alrt').innerHTML='<b>Please wait, Loading Data...</b>'; 
          $("#submit").hide(); 
          $('#savebutton').hide();
      },
      success:function(output){
        $('#submit').show();
        $('#alrt').hide();
      }
      });
    });
});

function add_item(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/gatepass/getitem';

    var item =$('#item').val();
    var unit =$('#unit').val();
    var quantity =parseFloat($('#quantity').val());
    var remarks =$('#remarks').val();
    var image = $('#image').val();
    /*var image = document.getElementById("image").files[0].name;*/
    var i = item.replace(/&/gi,"and");
    var i = i.replace(/#/gi,"");
    var itm = i.replace(/"/gi,"");
    //var maxqty = parseFloat(document.getElementById("maxqty").value);
    if(item==''){
         alert('Item must not be empty. Please choose/click from the suggested item list.');
    } else if(quantity==''){
         alert('Quantity must not be empty.');
    } else {
          var rowCount = $('#item_body tr').length;
          count=rowCount+1;
          $.ajax({
                type: "POST",
                url:redirect,
                data: "item="+item+"&unit="+unit+"&quantity="+quantity+"&remarks="+remarks+"&image="+image+"&count="+count,
                beforeSend: function(){
                    document.getElementById('alrt').innerHTML='<b>Please wait, Loading Data...</b>'; 
                    $("#submit").hide(); 
                    $('#savebutton').hide();
                },
                success: function(html){
                    $('#item_body').append(html);
                    $('#itemtable').show();
                    $('#savebutton').show();
                    $('#submit').show();
                    $('#alrt').hide();
                    var img = document.getElementById("image").value;
                    if(img!=''){
                    var oFReader = new FileReader();
                        oFReader.readAsDataURL(document.getElementById("image").files[0]);
                        oFReader.onload = function (oFREvent) {
                            document.getElementById("images"+count).src = oFREvent.target.result;
                        };
                    }

                    $('.select2-selection__rendered').empty();
                    document.getElementById("item").value = '';
                    document.getElementById("unit").value = '';
                    document.getElementById("quantity").value = '';
                    document.getElementById("remarks").value = '';
                    //document.getElementById("image").value = '';
                    document.getElementById("counter").value = count;
                }
           });
    }
          
}

function saveGatepass(){
    var pass = $("#gatepassfrm").serialize();
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
            data: pass,
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


function readImage(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#image')
                  .attr('src', e.target.result);
          };
        var size = input.files[0].size;
        if(size >= 6000000){
          $("#img1-check").show();
          $("#img1-check").html("Warning: Image too big. Upload images less than 5mb.");
          $('input[type="button"]').attr('disabled','disabled');
          //$("#img3").attr('disabled','disabled');
        } else {
           $("#img1-check").hide();
           $('input[type="button"]').removeAttr('disabled');
           //$("#img3").removeAttr('disabled');
        }

          reader.readAsDataURL(input.files[0]);
      }
    }