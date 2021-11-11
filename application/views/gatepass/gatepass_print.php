<!DOCTYPE html>
<head>
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/request.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
        <!-- Core CSS - Include with every page -->
        <!-- <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/main-style.css" rel="stylesheet" /> -->
</head>



<style type="text/css">
    body {
        background: rgb(204,204,204); 
        color: #000;
        font-family: sans-serif, Arial;
        padding-top: 10px;
    }
    h1,h2,h3,h4,h5,h6{color: #000}
    page {
        background: white;
        display: block;
        margin: 0 auto;
        margin-bottom: 0.5cm;
        box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
    }
    page[size="A4"] {  
        width: 21cm;
        height: 29.7cm; 
    }
    page[size="A4"][layout="landscape"] {
        width: 29.7cm;
        height: 21cm;  
    }
    page[size="A3"] {
        width: 29.7cm;
        height: 42cm;
    }
    page[size="A3"][layout="landscape"] {
        width: 42cm;
        height: 29.7cm;  
    }
    page[size="A5"] {
        width: 14.8cm;
        height: 21cm;
    }
    page[size="A5"][layout="landscape"] {
        width: 21cm;
        height: 14.8cm;  
    }
    .thumbnail{
        border: 1px solid #fff;
    }
    @media print {
        .thumbnail{
            border: 1px solid #fff;
        }
        #img1{
            display: none;
        }
        .col-lg-6 {
            width: 50%;
        }
        .thumbnail {
            display: block;
            padding: 4px;
            margin-bottom: 20px;
            line-height: 1.42857143;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            -webkit-transition: border .2s ease-in-out;
            -o-transition: border .2s ease-in-out;
            transition: border .2s ease-in-out;
        }
        .row {
            margin-right: -15px;
            margin-left: -15px;
        }
        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9 {
            float: left;
        }
        .col-lg-4 {
            width: 33.33333333%;
        }
        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }
        body, page {
            margin: 0;
            box-shadow: 0;
        }
        /*table td{ border:1px solid #fff!important; }*/
        .bor-btm{border-bottom:1px solid #000!important;}
        .bor-all{
            border: 1px solid #000;
        }
        #printbutton, #br, #br1{display: none}
        table{border:1px solid #000!important;}
        .backback{background:#d2cdc9}
        td{
            padding: 3px
        }
        .bor-btm{
        border-bottom:1px solid #000;
        }
        .bor-right{
            border-right:1px solid #000;
        }
        .nobor-right{
            border-right:0px solid #000!important;
        }
        .bor-left{
            border-left:1px solid #000;
        }
        .bor-top{
            border-top:1px solid #000;
        }
        .nobor-top{
            border-top:0px solid #fff!important;
        }
        .bor-all{
            border: 1px solid #000;
        }
        .nobor-all{
            border: 0px solid #fff!important;
        }
        table td{
            font-size: 13px;
        }
        td{
            padding: 2px
        }
        .font-12{
            font-size: 12px!important;
        }
       /* table{border:1px solid #000!important;}*/
        .btn-w100{
            width: 100px
        }
        .btn-round{
            border-radius: 20px
        }
        .backback{background:#d2cdc9}
        
        .table-bordered>tbody>tr>td, 
        .table-bordered>tbody>tr>th, 
        .table-bordered>tfoot>tr>td, 
        .table-bordered>tfoot>tr>th, 
        .table-bordered>thead>tr>td, 
        .table-bordered>thead>tr>th 
        {
            border: 1px solid #000!important;
        }   
        input, select{
            width: 100%;
            border: 0px;
        }

    }

    
    /*.table-bordered, td {
        border: 1px solid #000!important;
    } */
    .bor-btm{
        border-bottom:1px solid #000;
    }
    .bor-right{
        border-right:1px solid #000;
    }
    .nobor-right{
        border-right:0px solid #000!important;
    }
    .bor-left{
        border-left:1px solid #000;
    }
    .bor-top{
        border-top:1px solid #000;
    }
    .nobor-top{
        border-top:0px solid #fff!important;
    }
    .bor-all{
        border: 1px solid #000;
    }
    .nobor-all{
        border: 0px solid #000!important;
    }
    table td{
        font-size: 13px;
    }
    td{
        padding: 2px
    }
    .font-12{
        font-size: 12px!important;
    }
   /* table{border:1px solid #000!important;}*/
    .btn-w100{
        width: 100px
    }
    .btn-round{
        border-radius: 20px
    }
    .backback{background:#d2cdc9}
    
    .table-bordered>tbody>tr>td, 
    .table-bordered>tbody>tr>th, 
    .table-bordered>tfoot>tr>td, 
    .table-bordered>tfoot>tr>th, 
    .table-bordered>thead>tr>td, 
    .table-bordered>thead>tr>th 
    {
        border: 1px solid #000;
    }   
    input, select{
        width: 100%;
        border: 0px;
    }
</style>

<div class="animated fadeInDown p-t-20" id="printbutton">
    <center>
        <a href="<?php echo base_url();?>index.php/gatepass/gatepass_list" class="btn btn-warning text-white btn-w100 btn-round">Back</a>
        <!-- <a href='update_emp.php?id=<?php echo $id; ?>' class="btn btn-primary btn-w100 btn-round">Update</a>  -->
        <a href="" class="btn btn-success btn-w100 btn-round" onclick="window.print()">Print</a>
        <!-- <button class="btn btn-danger btn-fill"onclick="printDiv('printableArea')" style="margin-bottom:5px;width:80px;"></span> Print</button><br> -->
    </center>
    <br>
</div>
<page size="A4">
    <div class="p-t-20 m-l-20 m-r-20">
        <table class="nobor-all" width="100%">
            <tr>
                <td align="center">
                    <br>
                    <h4><b>CALAPAN POWER GENERATION CORP.</b></h4> 
                    <h5>CDPP Bldg., NPC Compound, Simaron, Sta Isabel, Calapan City</h5> <br>
                    <br>
                    <h4><b>MATERIALS GATE PASS</b></h4>
                </td>
            </tr>
        </table>
            <?php 
                foreach($heads as $det){             
                    $prepared= $det->prepared_by;
                    $approved= $det->approved_by;
                    $noted= $det->noted_by;
            }?>
            <?php foreach($pass as $p){ ?>
        <table class="table-bordsered nobor-all" width="100%">
            <tr>
                <td width="10%"><strong><h6 class="nomarg">To Company</h6></strong></td>
                <td width="42%"style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $p['company'];?></label></td>
                <td width="5%"></td>
                <td width="13%"><strong><h6 class="nomarg pull-right">Date Issued &nbsp;</h6></strong></td>
                <td width="30%" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo date('F d, Y', strtotime($p['date_issued']));?></label></td>
            </tr>
            <tr>
                <td><strong><h6 class="nomarg">Destination</h6></strong></td>
                <td style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $p['destination'];?></label></td>
                <td></td>
                <td><strong><h6 class="nomarg pull-right">MGP No. &nbsp;</h6></strong></td>
                <td style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $p['mgp_no'];?></label></td>
            </tr>
            <tr>
                <td><strong><h6 class="nomarg">Vehicle No</h6></strong></td>
                <td style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $p['vehicle_no'];?></label></td>
                <td></td>
                <td><strong></strong></td>
                <td> </label></td>
            </tr>    
        </table>
        <br>    
        <table width="100%" class="table-bordered">
            <tr>
                <td width="3%" align="center"><strong>#</strong></td>
                <td width="50%" align="center"><strong>Item Description</strong></td>                    
                <td width="7%" align="center"><strong>Qty</strong></td>
                <td width="5%" align="center"><strong>U/M</strong></td>
                <td width="10%" align="center"><strong>Date Returned</strong></td>
                <td width="30%" align="center"><strong>Remarks</strong></td>
            </tr>
            <tr>
                    <?php 
                    $x =1;
                    if(!empty($gatepass_itm)){
                        foreach($gatepass_itm as $pi){ 
                    ?>
                <tr>                        
                    <td align="center"><?php echo $x; ?></td>
                    <td align="left">&nbsp; <?php echo $pi['item'];?></td>
                    <td align="center"><?php echo $pi['quantity'];?></td>
                    <td align="center"><?php echo $pi['unit'];?></td>
                    <?php if($pi['status']=='Non-Returnable'){ ?>
                    <td align="center"><?php echo $pi['status'];?></td>
                    <?php } ?>
                    <?php if($pi['status']=='Returnable'){ ?>
                    <td align="center"><?php echo $pi['date_returned'];?></td>
                    <?php } ?>
                    <td align="center"><?php echo $pi['remarks'];?></td>
                </tr>
                    <?php $x++; } } else { ?>
                    <tr>
                        <td align="center" colspan='10'><center>No Data Available.</center></td>
                    </tr>
                    <?php } ?>
            </tr>
            <tr>
                <td colspan="6"><center>***nothing follows***</center></td>
            </tr>
        </table>
        <?php }?>
        <br>
        <form method='POST' id='GatepassSign'>     
            <div class="row">
                <div class="col-lg-6">
                    <br>
                    <br>
                    <table class="nobor-all" width="100%"> <!--  -->
                        <tr>
                            <td width="30%">Prepared By:</td>
                            <td width="5%"></td>                    
                            
                        </tr>
                        <?php foreach($signs AS $us) ?>
                        <tr>
                            <td style="border-bottom:1px solid #000">
                                <input id="" class="select" style="pointer-events:none" value="<?php echo $us['prepared'];?>">
                            </td>   
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input id="" class="select" style="pointer-events:none" value="Warehouse In-charge">
                            </td>
                            <td></td>                   
                        </tr>
                        <tr>
                            <td><br><br><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width="30%">Noted by:</td>
                            <td></td>   
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #000">
                                <input id="" class="select" style="pointer-events:none" value="<?php echo $us['noted'];?>">
                            </td> 
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input id="" class="select" style="pointer-events:none" value="<?php echo $us['posnoted'];?>">
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><br><br><br></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td width="30%">Approved by:</td>
                            <td></td>           
                        </tr>
                        <tr>
                            <td style="border-bottom:1px solid #000">
                                <input id="" class="select" style="pointer-events:none" value="<?php echo $us['approved'];?>">
                            </td> 
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <input id="" class="select" style="pointer-events:none" value="<?php echo $us['posapproved'];?>">
                            </td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <?php 
            if(!empty($gatepass_itm)){
                foreach($gatepass_itm as $pis){ 
                    if($pis['rows']==1){
        ?>
                <div class="col-lg-6">
                    <?php if($pis['image']!=''){ ?>
                    <!-- <input class="form-control"  type="file" name="pic1" id="img1" onchange="readPic1(this);"> -->
                    <div class="thumbnail">
                        <img class="pictures" src="<?php if(!empty($pis['image'])) { 
                 echo base_url(); ?>uploads/<?php echo $pis['image']; 
                    } else { echo base_url(); ?>assets/default/default-img.jpg<?php } ?>" alt="Your image" width="200%" height="200%" />
                    </div>
                    <?php } ?>
                </div>
            <?php } } }?>
            
            <br>
            <br>
            <table class="nobor-all" width="100%">
                <tr>
                    <td width="30%">Received By:</td>
                    <td width="5%"></td>                    
                    <td width="30%">Verified by:</td>
                    <td width="5%"></td>
                    <td width="30%"></td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000">
                        <input class="select" type="" name="" value="">
                    </td>     
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <input class="select" type="" name="" value="">
                    </td>  
                    <td style="border-bottom:1px solid #000"></td>
                    <td style="border-bottom:1px solid #000">
                        <input class="select" type="" name="" value="">
                    </td>  
                </tr>
                <tr>
                    <td><!-- <input class="select animated headShake" type="" name="" placeholder="Type Designation Here.." > -->
                        
                    </td>
                    <td></td>
                    <!-- <td><center>End-User/Requester</center></td> -->
                    <td>
                        <center><div style="font-weight:bold"></div></center>
                        <input class="select" style="pointer-events:none" value="CPGC Guard">
                    </td>
                    <td></td>
                    <!-- <td><center>O & M Planner</center></td> -->
                    <td>
                        <center><div style="font-weight:bold"></div></center>
                        <input class="select" style="pointer-events:none" value="NPC Guard">
                    </td>
                </tr>
            </table>
            <?php ?>
        <!--<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
        <input type='hidden' name='passid' id='passid' value="<?php echo $id; ?>" >-->
        </form> 
    </div>
    </div>
</page>
<page size="A4">
    <div class="p-t-20 m-l-20 m-r-20">
        <div class="row">
            <?php 
                if(!empty($gatepass_itm)){
                    foreach($gatepass_itm as $pi){ 
                        if($pi['rows']>1){
            ?>
            <div class="col-lg-4">
                <?php if($pi['image']!=''){ ?>
                <div style="padding:10px">
                    <img class="pictures" src="<?php if(!empty($pi['image'])) { 
                     echo base_url(); ?>uploads/<?php echo $pi['image']; 
                        } else { echo base_url(); ?>assets/default/default-img.jpg<?php } ?>" alt="your image" width="200%" height="200%" />
                </div>
                <center><p><?php echo $pi['item'];?></p></center>
                <?php } ?>
            </div>
            <?php } } } ?>
        </div>         
    </div>
</page>

<!--<script type="text/javascript">
function printMReqF(){
    var sign = $("#GatepassSign").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/gatepass/printGatepass';
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
</script>-->
</html>