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
        @media print {
            body { font-size: 10pt }
          }
          @media screen {
            body { font-size: 13px }
          }
          @media screen, print {
            body { line-height: 1.2 }
          }
        body{
            font-family:  Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;/*(Arial, Helvetica, sans-serif;)*/
        }
        small{ 
            margin-left:5px;
            font-size: 13px;
        }
        h6{
            margin:0px;
            font-weight: ;
        }
        tbody{
            padding: 20px!important;
        }
        .table-bordered>tbody>tr>td, 
        .table-bordered>tbody>tr>th, 
        .table-bordered>tfoot>tr>td, 
        .table-bordered>tfoot>tr>th, 
        .table-bordered>thead>tr>td, 
        .table-bordered>thead>tr>th {
            border: 1px solid #000!important;
        }
        .table-condensed>tbody>tr>td, 
        .table-condensed>tbody>tr>th, 
        .table-condensed>tfoot>tr>td, 
        .table-condensed>tfoot>tr>th, 
        .table-condensed>thead>tr>td, 
        .table-condensed>thead>tr>th {
            padding: 0px!important;
        }
        .table-bordered1 {
            border: 2px solid #444!important;
        }
        .logo-sty{
            margin-top: 10px;
            width:15%;
        }
        .company-name{
            margin:1px 0px 1px 0px;
            font-size:30px;
        }
        .name-sheet{
            margin:5px 0px 5px 0px;
        }
        .table-main{
            border:2px solid black;
            border-bottom:0px solid black;
        }
        .table-secondary{
            border:1px solid #999;
        }
        .paded-20{
            padding:20px;
        }
        .paded-top-10{
            padding-top:10px;
        }
        .paded-top-20{
            padding-top:20px;
        }
        .paded-top-30{
            padding-top:30px;
        }
        .undline-tab{
            border-bottom:1px solid black;
        }
        .marg-under{
            margin-bottom:10px;
        }
        .xs-small {
            font-size: 60%;
        }
        td{
            font-size: 1vmax
        }
        .borderrside{
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        .borderb{
            border-bottom:1px solid black; 
        }
        @media print(){
            #head{
                font-size: 5px!important;
            }
        }
        #head{
                font-size: 10px;
            }
        .select {
           text-align-last: center;
           text-align: center;
           -ms-text-align-last: center;
           -moz-text-align-last: center;
            padding: 5px 0px!important;
            width:100%;
            border:0px;
            background:none;
            text-align:center;
            -webkit-appearance: none;
        }
         #print1{
            position: relative;
            margin: 4% 4% 10px 35%;            
        }
        #print{
            width: 50%;
        }
        @media print{
            #print1 {
                display: none;
            }
            .nomarg{
                font-size: 12px!important;
            }
        }
        .shadow{
            box-shadow: 0px 2px 1px 1px #dadada;
        }
</style>
<!-- <body style="padding-top:20px">
    <div class="container">
        <table class = "table-main " style = "width:100%">
            <tr>
                <td style="padding:10px;border-bottom: 2px solid #000" width="15%">
                    <center><img src="<?php echo base_url(); ?>assets/default/logo_cenpri.png" width="45%" height="45%"></center>
                </td>
                <td style="padding:10px;border-bottom: 2px solid #000;"  width="35%" >
                    <p id="head" style="margin: 0px"> <strong>CENTRAL NEGROS POWER RELIABILITY INC.</strong></p>
                    <p id="head" style="margin: 0px">Purok San Jose, Brgy. Calumangan, Bago City</p>
                    <p id="head" style="margin: 0px">Tel. No. 476-7382</p>
                </td> -->
                <td style="padding:10px;border-bottom: 2px solid #000;border-left: 2px solid #000" width="50%" align="center">
                    <h5><strong>MATERIAL GATEPASS</strong></h5>
                </td>
            </tr>
        </table>
        <div class="col-lg-12" style="margin:10px 0px 10px">
            <table width="100%">
                <tr>
                    <td width="10%"><strong><h6 class="nomarg">TO</h6></strong></td>
                    <td width="40%"style="border-bottom: 1px solid #999"> <label class="nomarg">: Sample</label></td>
                    <td width="7%"></td>
                    <td width="10%"><strong><h6 class="nomarg pull-right">Date Issued &nbsp;</h6></strong></td>
                    <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">: September 19, 2021</label></td>
                </tr>
                <tr>
                    <td><strong><h6 class="nomarg">Company</h6></strong></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: CENPRI</label></td>
                    <td></td>
                    <td><strong><h6 class="nomarg pull-right">Date Returned &nbsp;</h6></strong></td>
                    <td width="10%" style="border-bottom: 1px solid #999"> <label class="nomarg">: September 19, 2021</label></td>
                </tr>
                <tr>
                    <td><strong><h6 class="nomarg">Destination</h6></strong></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: Bacolod Sety</label></td>
                    <td></td>
                </tr>    
                 <tr>
                    <td><strong><h6 class="nomarg">Vehicle No</h6></strong></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: AVEW44211</label></td>
                    <td></td>
                </tr>
            </table>
            
        </div>
        <div class="col-lg-12">
            <table width="100%" class="table-bordered">
                <tr>
                    <td width="3%" align="center"><strong>#</strong></td>
                    <td width="87%" align="center"><strong>Item Description</strong></td>                    
                    <td width="5%" align="center"><strong>Qty</strong></td>
                    <td width="5%" align="center"><strong>U/M</strong></td>
                </tr>
                <tr>
                    <tr>                        
                        <td align="center">1</td>
                        <td align="left">&nbsp; "Titanium" 6x19 Steel Core, IWRC Wire Rope, 12mm dia., Zinc Coated, T/S: 180kg/mm2</td>
                        <td align="center">23</td>
                        <td align="center">Kg</td>
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
            <!-- <table width="100%">
                <tr>
                    <td width="10%">Remarks:</td>
                    <td style="border-bottom: 1px solid #999">
                        <?php echo $r['remarks']?>
                    </td>
                </tr>
            </table> -->
            <br>
            <form method='POST' id='mreqfsign'>            
                <table width="100%">
                    <tr>
                        <td width="30%">Prepared By:</td>
                        <td width="5%"></td>                    
                        <td width="30%">Noted by:</td>
                        <td width="5%"></td>
                        <td width="30%">Approved by:</td>
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
                        <td></td>
                        <td style="border-bottom:1px solid #000">
                            <select type="text" class="select" name="reviewed" id="reviewed" onchange="chooseEmprev()">
                                <option>David Stephany Severenity</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><!-- <input class="select animated headShake" type="" name="" placeholder="Type Designation Here.." > -->
                            <input id="positionreq" class="select" style="pointer-events:none" value="Warehouse In-charge">
                        </td>
                        <td></td>
                        <!-- <td><center>End-User/Requester</center></td> -->
                        <td>
                            <center><div id='alt' style="font-weight:bold"></div></center>
                            <input id="positionreq" class="select" style="pointer-events:none" value="Area Manager">
                        </td>
                        <td></td>
                        <!-- <td><center>O & M Planner</center></td> -->
                        <td>
                            <center><div id='alts' style="font-weight:bold"></div></center>
                            <input id="positionrev" class="select" style="pointer-events:none" value="Plant Superintendent">
                        </td>
                    </tr>
                </table>
                <br>
                <table width="100%">
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

                <br>
                <table width="100%">
                    <tr>                 
                        <td style="font-size:12px">Printed By: <?php echo 'Employee Name'.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
                    </tr>
                </table>
                <div style="border-bottom: 1px solid #e8e8e8;width: 100%">&nbsp</div>        
                <div class="print" id="print1">        
                    <input class="btn btn-warning btn-md " id="print" type="button" value="Print" onclick="printMReqF()" /><br>
                    <h5>After Clicking this Button. <br>Configure your <strong>Margin</strong> into <i>none</i></h5>
                    <p>____________________________________________________</p>
                    <li>Click <a><span class="fa fa-plus"></span> More Settings</a> at the right side of the screen</li>
                    <li>Click and Choose<a> None from Margins </a> </li>
                    <select class="form-control " style="width: 100px">
                        <option>none</option>
                    </select>
                </div>
            </div>    
         <!--    <input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
            <input type='hidden' name='mreqfid' id='mreqfid' value="<?php echo $id; ?>" > -->
            </form>           
    </div>
</body>
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