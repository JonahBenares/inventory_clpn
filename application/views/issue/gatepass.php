<!DOCTYPE html>
<head>
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/issue.js"></script>
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
            width:95%;
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
            h6.nomarg{
                font-size: 10px!important;
            }
            .main-tab{
                font-size: 12px;
                padding: 2px;
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
                    <img src="<?php echo base_url(); ?>assets/default/logo_cenpri.png" width="100%" height="auto">
                </td>
                <td style="padding:10px;border-bottom: 2px solid #000;"  width="35%" >
                    <p id="head" style="margin: 0px"> <strong>CENTRAL NEGROS POWER RELIABILITY INC.</strong></p>
                    <p id="head" style="margin: 0px">Purok San Jose, Brgy. Calumangan, Bago City</p>
                    <p id="head" style="margin: 0px">Tel. No. 476-7382</p>
                </td> -->
                <td style="padding:10px;border-bottom: 2px solid #000;border-left: 2px solid #000" width="50%" align="center">
                    <h5><strong>MATERIAL GATE PASS</strong></h5>
                </td>
            </tr>
        </table>
        <?php
        foreach($heads as $det){ 
         $employee = $det->gp_employee;  
         $gp_requested= $det->gp_requested;
         $gp_recommend= $det->gp_recommending;
         $gp_noted= $det->gp_noted;
         $gp_approved= $det->gp_approved;
         $gp_inspected= $det->gp_inspected;
         }  

        ?>
         <form method='POST' id='gpsign'>

        <div class="col-lg-12" style="margin:10px 0px 10px">
            <table width="100%">                
                <tr>
                    <td width="15%"><h6 class="nomarg">Employee/Contractor</h6></td>
                    <td width="35%" style="border-bottom: 1px solid #999; " > <span>:</span>
                    <select type="text" class="select" name="gp_employee" id='gp_employee'>
                        <option></option>
                        <?php foreach($employees AS $rel){ ?>
                        <option value="<?php echo $rel['empid']; ?>"<?php echo (($rel['empid'] == $employee) ?  ' selected' : ''); ?>><?php echo $rel['empname'];?></option>
                        <?php } ?>
                    </select></td>
            <?php foreach($issuance_details as $d){ ?>
                    <td width="7%"></td>
                    <td width="18%"><h6 class="nomarg pull-right">Material Gate Pass No. &nbsp</h6></td>
                    <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $d['gpno']; ?></label></td>
                       <input type='hidden' name='gpno' id='gpno' value="<?php echo $d['gpno']; ?>">
                </tr>
                <tr>
                    <td width="15%"><h6 class="nomarg">PR No.</h6></td>
                    <td width="35%" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $d['prno']; ?></label></td>
                    <td width="7%"></td>
                    <td width="18%"><h6 class="nomarg pull-right">MIF No.</h6></td>
                    <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $d['mif']; ?></label></td>
                </tr> 
                <tr>
                    <td><h6 class="nomarg">Department</h6></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $d['department']; ?></label></td>
                    <td></td>
                    <td><h6 class="nomarg pull-right">Date &nbsp</h6></td>
                    <td width="10%" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo date('d-M-y'); ?></label></td>
                    <td width="10%" ><h6 class="nomarg pull-right">Time &nbsp</h6></td>
                    <td width="10%"  style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo date('H:i'); ?></label></td>
                </tr>
                <tr></tr>
                <tr>
                    <td><h6 class="nomarg">Purpose</h6></td>
                    <td colspan="7" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $d['purpose']; ?></label></td>
                </tr>     
            
            </table>
        </div>
        <div class="col-lg-12">
            <table width="100%" class="table-bordered">
                <tr>
                    <td width="1%" align="center"><strong>#</strong></td>
                    <td width="5%" align="center"><strong>Qty</strong></td>
                    <td width="5%" align="center"><strong>U/M</strong></td>
                    <td width="10%" align="center"><strong>Part No./SN</strong></td>
                    <td width="60%" align="left"><strong>&nbsp;Item Description</strong></td>  
                </tr>
                <tr>
                     <?php  $x =1; if(!empty($issue_itm)){foreach ($issue_itm as $isu) {?>
                    <tr>
                        <td class="main-tab" align="center" style="padding:0px 10px"><?php echo $x;?></td>
                        <td class="main-tab" align="center"><?php echo $isu['qty']?></td>
                        <td class="main-tab" align="center"><?php echo $isu['uom']?></td>
                        <td class="main-tab" align="center"><?php echo $isu['pn']?></td>
                        <td class="main-tab" align="left">&nbsp;<?php echo $isu['item']?></td>
                    </tr>
                     <?php $x++; }} else {?>
                    <tr>
                        <td align="center" colspan='5'><center>No Data Available.</center></td>
                    </tr>
                    <?php }?>
                </tr>
                <tr>
                    <td colspan="5"><center>***Nothing Follows***</center></td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="10%">Remarks:</td>
                    <td style="border-bottom: 1px solid #999"><?php echo $d['remarks']?></td>
                </tr>
            </table>
            <br>
 <?php } ?>        
           
            

            <table width="100%">
                <tr>
                    <td width="30%">Prepared by:</td>
                    <td width="5%"></td>                    
                    <td width="30%">Requested by:</td>
                    <td width="5%"></td>
                    <td width="30%">Recommending Approval:</td>
                </tr>
                <tr>
                     <?php foreach($username AS $us) ?> 
                    <td style="border-bottom:1px solid #000">
                         <input class="select" type="" name="gp_prepared" id="gp_prepared" value="<?php echo $us['user'];?>">
                    </td>     
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" class="select" name="gp_requested" id='gp_requested'>
                            <option></option>
                            <?php foreach($requested_emp AS $req){ ?>
                            <option value="<?php echo $req['empid']; ?>"<?php echo (($req['empid'] == $gp_requested) ?  ' selected' : ''); ?>><?php echo $req['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" class="select" name="gp_recommend" id="gp_recommend">
                            <option></option>
                            <?php foreach($requested_emp AS $req){ ?>
                            <option value="<?php echo $req['empid']; ?>"<?php echo (($req['empid'] == $gp_recommend) ?  ' selected' : ''); ?>><?php echo $req['empname'];?></option>
                            <?php } ?>
                        </select>
                     
                    </td>           
                </tr>
                <tr>
                    <td><center>Warehouse Personnel</center></td>
                    <td></td>
                    <td><center>End User/Requester</center></td>
                    <td></td>
                    <td><center>Site Purchasing/Logistics Officer</center></td>
                                  
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="30%">Noted by:</td>
                    <td width="5%"></td>                    
                    <td width="30%">Approved by:</td>
                    <td width="5%"></td>
                    <td width="30%">Inspected by:</td>
                </tr>
                <tr>
                    <!-- <?php foreach($username AS $us) ?> -->
                    <td style="border-bottom:1px solid #000">
                          <select type="text" class="select" name="gp_noted" id="gp_noted">
                            <option></option>
                            <?php foreach($noted_emp AS $rel){ ?>
                            <option value = "<?php echo $rel['empid'];?>"<?php echo (($rel['empid'] == $gp_noted) ?  ' selected' : ''); ?>><?php echo $rel['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>     
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" class="select" name="gp_approved" id="gp_approved">
                            <option></option>
                            <?php foreach($approved_emp AS $rel){ ?>
                            <option value = "<?php echo $rel['empid'];?>"<?php echo (($rel['empid'] == $gp_approved) ?  ' selected' : ''); ?>><?php echo $rel['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <textarea class="select" rows="2" style="word-wrap:break-word;" name='gp_inspected' id='gp_inspected'><?php echo (!empty($gp_inspected) ? $gp_inspected : ''); ?></textarea>
                        
                    </td>           
                </tr>
                <tr>
                    <td><center>Warehouse In Charge</center></td>
                    <td></td>
                    <td><center>Plant Manager/Director</center></td>
                    <td></td>
                    <td><center>Security Guard on Duty</center></td>
                                  
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
                </tr>
                <tr>
                    <td style="font-size:9px">Warehouse Form: Material Gate Pass (Effective June 2018)</td>
                    <td style="font-size:9px" align="right">*Prepare 4 copies: End-user, Warehouse, Logistics, and Guard</td>
                </tr>
            </table> 
            <div style="border-bottom: 1px solid #e8e8e8;width: 100%">&nbsp</div>          
            <div class="print" id="print1">        
                <input class="btn btn-warning btn-md " id="print" type="button" value="Print" onclick="printGP()" /><br>
                <h5>After Clicking this Button. <br>Configure your <strong>Margin</strong> into <i>none</i></h5>
                <p>____________________________________________________</p>
                <li>Click <a><span class="fa fa-plus"></span> More Settings</a> at the right side of the screen</li>
                <li>Click and Choose<a> None from Margins </a> </li>
                <select class="form-control " style="width: 100px">
                    <option>none</option>
                </select>

            </div>
             <input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
            <input type='hidden' name='issueid' id='issueid' value="<?php echo $id; ?>" >
            </form> 
        </div>
        


           
    </div>
</body>
</html>