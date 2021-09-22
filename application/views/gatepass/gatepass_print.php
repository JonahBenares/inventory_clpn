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
    @media print {
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
            border: 1px solid #000;
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
        border: 1px solid #000;
    }   
    input, select{
        width: 100%;
        border: 0px;
    }
</style>

<div class="animated fadeInDown p-t-20" id="printbutton">
    <center>
        <a href=".php" class="btn btn-warning text-white btn-w100 btn-round">Back</a>
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
        <table class="table-bordsered nobor-all" width="100%">
            <tr>
                <td width="8%"><strong><h6 class="nomarg">TO</h6></strong></td>
                <td width="44%"style="border-bottom: 1px solid #999"> <label class="nomarg">: Sample</label></td>
                <td width="5%"></td>
                <td width="13%"><strong><h6 class="nomarg pull-right">Date Issued &nbsp;</h6></strong></td>
                <td width="30%" style="border-bottom: 1px solid #999"> <label class="nomarg">: September 19, 2021</label></td>
            </tr>
            <tr>
                <td><strong><h6 class="nomarg">Company</h6></strong></td>
                <td style="border-bottom: 1px solid #999"> <label class="nomarg">: CENPRI</label></td>
                <td></td>
                <td><strong><h6 class="nomarg pull-right">Date Returned &nbsp;</h6></strong></td>
                <td style="border-bottom: 1px solid #999"> <label class="nomarg">: September 19, 2021</label></td>
            </tr>
            <tr>
                <td><strong><h6 class="nomarg">Destination</h6></strong></td>
                <td style="border-bottom: 1px solid #999"> <label class="nomarg">: Bacolod Sety</label></td>
                <td></td>
                <td><strong><h6 class="nomarg pull-right">MGP No. &nbsp;</h6></strong></td>
                <td style="border-bottom: 1px solid #999"> <label class="nomarg">: 1101-553</label></td>
            </tr>    
             <tr>
                <td><strong><h6 class="nomarg">Vehicle No</h6></strong></td>
                <td style="border-bottom: 1px solid #999"> <label class="nomarg">: AVEW44211</label></td>
                <td></td>
            </tr>
        </table>
        <br>    
        <table width="100%" class="table-bordered">
            <tr>
                <td width="3%" align="center"><strong>#</strong></td>
                <td width="57%" align="center"><strong>Item Description</strong></td>                    
                <td width="5%" align="center"><strong>Qty</strong></td>
                <td width="5%" align="center"><strong>U/M</strong></td>
                <td width="35%" align="center"><strong>Remarks</strong></td>
            </tr>
            <tr>
                <tr>                        
                    <td align="center">1</td>
                    <td align="left">&nbsp; "Titanium" 6x19 Steel Core, IWRC Wire Rope, 12mm dia., Zinc Coated, T/S: 180kg/mm2</td>
                    <td align="center">23</td>
                    <td align="center">Kg</td>
                    <td align="center">Sample</td>
                </tr>
               
                <!-- <tr>
                    <td align="center" colspan='10'><center>No Data Available.</center></td>
                </tr>
              -->
            </tr>
            <tr>
                <td colspan="6"><center>***nothing follows***</center></td>
            </tr>
        </table>
        <br>
        <form method='POST' id='mreqfsign'>            
            <table class="nobor-all" width="100%">
                <tr>
                    <td width="30%">Prepared By:</td>
                    <td width="5%"></td>                    
                    <td width="30%"></td>
                    <td width="5%"></td>
                    <td width="30%"></td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000">
                        <input class="select" type="" name="" value="Glenn Paul">
                    </td>   
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <input id="positionreq" class="select" style="pointer-events:none" value="Warehouse In-charge">
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <br>
            <table class="nobor-all" width="100%">
                <tr>
                    <td width="30%">Noted by:</td>
                    <td width="5%"></td>                    
                    <td width="30%"></td>
                    <td width="5%"></td>
                    <td width="30%"></td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" class="select" name="requested" id="requested" onchange="chooseEmpreq()">
                            <option>Henelene Mae Tantanan</option>
                            <option value = ""></option>
                        </select>
                    </td>
                    <td></td>
                    <td></td>   
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <input id="positionreq" class="select" style="pointer-events:none" value="Area Manager">
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <br>
            <table class="nobor-all" width="100%">
                <tr>
                    <td width="30%">Approved by:</td>
                    <td width="5%"></td>                    
                    <td width="30%"></td>
                    <td width="5%"></td>
                    <td width="30%"></td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" class="select" name="reviewed" id="reviewed" onchange="chooseEmprev()">
                            <option>David Stephany Severenity</option>
                        </select>
                    </td>   
                    <td></td>
                    <td></td>
                    <td></td>
                    <td ></td>
                </tr>
                <tr>
                    <td>
                        <input id="positionrev" class="select" style="pointer-events:none" value="Plant Superintendent">
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
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
                        <input class="select" type="" name="" value="Glenn Paul">
                    </td>   
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" class="select" name="requested" id="requested" onchange="chooseEmpreq()">
                            <option>Henelene Mae Tantanan</option>
                            <option value = ""></option>
                        </select>
                    </td>
                    <td style="border-bottom:1px solid #000"></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" class="select" name="reviewed" id="reviewed" onchange="chooseEmprev()">
                            <option>David Stephany Severenity</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><!-- <input class="select animated headShake" type="" name="" placeholder="Type Designation Here.." > -->
                        
                    </td>
                    <td></td>
                    <!-- <td><center>End-User/Requester</center></td> -->
                    <td>
                        <center><div id='alt' style="font-weight:bold"></div></center>
                        <input id="positionreq" class="select" style="pointer-events:none" value="CPGC Guard">
                    </td>
                    <td></td>
                    <!-- <td><center>O & M Planner</center></td> -->
                    <td>
                        <center><div id='alts' style="font-weight:bold"></div></center>
                        <input id="positionrev" class="select" style="pointer-events:none" value="NPC Guard">
                    </td>
                </tr>
            </table>
        </form> 
    </div>
</page>




<script type="text/javascript">
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
</script>
</html>