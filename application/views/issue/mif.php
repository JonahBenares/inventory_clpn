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
            #print1, #editbtn  {
                display: none;
            }
            .nomarg{
                font-size: 12px!important;
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
                    <center><img src="<?php echo base_url(); ?>assets/default/logo_cenpri.png" width="45%" height="45%"></center>
                </td>
                <td style="padding:10px;border-bottom: 2px solid #000;"  width="35%" >
                    <p id="head" style="margin: 0px"> <strong>CENTRAL NEGROS POWER RELIABILITY INC.</strong></p>
                    <p id="head" style="margin: 0px">Purok San Jose, Brgy. Calumangan, Bago City</p>
                    <p id="head" style="margin: 0px">Tel. No. 476-7382</p>
                </td> -->
                <td style="padding:10px;border-bottom: 2px solid #000;border-left: 2px solid #000" width="50%" align="center">
                    <h5><strong>MATERIAL ISSUANCE FORM</strong></h5>
                </td>
            </tr>
        </table>
        <div class="col-lg-12" style="margin:10px 0px 10px">
            <table width="100%">
                <?php 

              foreach($heads as $h){ 
                            
                    $released= $h->released_by;
                    $received= $h->received_by;
                    $noted= $h->noted_by;
                    $issuance_id = $h->issuance_id;
                    $request_id = $h->request_id;
                }?>
                <?php foreach($issuance_details as $det){ ?>
                <tr>
                    <td width="10%"><h6 class="nomarg">JO / PR #</h6></td>
                    <td width="40%" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo (($det['type'] == 'JO / PR') ? $det['prno'] : $det['type']); ?></label>
                        <?php 
                        if($access['issue_edit']==1){
                        if(empty($det['prno']) && $det['type'] != 'Warehouse Stocks'){ ?>
                        <a onclick="editmodal(<?php echo $issuance_id; ?>,<?php echo $request_id; ?>)" class="btn btn-xs btn-primary pull-right" id="editbtn" ><span class="fa fa-pencil"></span></a>
                        <?php }
                        } ?>
                    </td>
                    <td width="7%"></td>
                    <td width="10%"><h6 class="nomarg pull-right">MIF No. &nbsp</h6></td>
                    <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['milf']?></label></td>
                </tr>
                <tr>
                    <td><h6 class="nomarg">Department</h6></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['department']?></label></td>
                    <td></td>
                    <td width="10%"><h6 class="nomarg pull-right">MReqF No. &nbsp</h6></td>
                    <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['mreqf']?></label></td>
                </tr>
                <tr>
                    <td><h6 class="nomarg">Purpose</h6></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['purpose']?></label></td>
                    <td></td>

                    <td><h6 class="nomarg pull-right">Date &nbsp</h6></td>
                    <td width="10%" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['date']?></label></td>
                    <td width="10%" ><h6 class="nomarg pull-right">Time &nbsp</h6></td>
                    <td width="10%"  style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['time']?></label></td>
                </tr>
                <tr>
                    <td><h6 class="nomarg">End Use</h6></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['enduse']?></label></td>
                    <td></td>
                </tr>                
            </table>
        </div>
        <div class="col-lg-12">
            <table width="100%" class="table-bordered">
                <tr>
                    <td width="1%" align="center"><strong>#</strong></td>
                    <td width="5%" align="center"><strong>Qty</strong></td>
                    <td width="5%" align="center"><strong>U/M</strong></td>
                    <td width="10%" align="center"><strong>Part No.</strong></td>
                    <td width="30%" align="center"><strong>Item Description</strong></td>                    
                    <td width="10%" align="center"><strong>Brand</strong></td>
                    <td width="10%" align="center"><strong>Serial No.</strong></td>
                    <td width="10%" align="center"><strong>Notes</strong></td>
                    <td width="5%" align="center"><strong>Unit Cost</strong></td>
                    <td width="5%" align="center"><strong>Total Cost</strong></td>
                    <td width="10%" align="center"><strong>Inv. Balance</strong></td>
                </tr>
                <tr>
                    <?php  $x =1; if(!empty($issue_itm)){foreach ($issue_itm as $isu) {?>
                    <tr>
                        <td class="main-tab" align="center"><?php echo $x;?></td>
                        <td class="main-tab" align="center"><?php echo $isu['qty']?></td>
                        <td class="main-tab" align="center"><?php echo $isu['uom']?></td>
                        <td class="main-tab" align="center"><?php echo $isu['pn']?></td>
                        <td class="main-tab" align="left">&nbsp;<?php echo $isu['item']?></td>
                        <td class="main-tab" align="center"><?php echo $isu['brand']?></td>
                        <td class="main-tab" align="center"><?php echo $isu['serial']?></td>
                        <td class="main-tab" align="center"><?php echo $isu['remarks']?></td>
                        <td class="main-tab" align="center"><?php echo $isu['unit_cost']?></td>
                        <td class="main-tab" align="center"><?php echo number_format($isu['total_cost'],2);?></td>
                        <td class="main-tab" align="center"><?php echo $isu['balance']?></td>
                    </tr>
                    <?php $x++; }} else {?>
                    <tr>
                        <td align="center" colspan='9'><center>No Data Available.</center></td>
                    </tr>
                    <?php }?>
                </tr>
                <tr>
                    <td colspan="11"><center>***nothing follows***</center></td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="10%">Remarks:</td>
                    <td style="border-bottom: 1px solid #999"><?php echo $det['remarks']?></td>
                </tr>
            </table>
            <?php } ?>
            <br>

            <form method='POST' id='mifsign'>
            

            <table width="100%">
                <tr>
                    <td width="10%"></td>
                    <td width="26%">Prepared by:</td>
                    <td width="10%"></td>
                    <td width="26%">Released by:</td>
                    <td width="10%"></td>
                </tr>
                <tr>
                    <td></td>
                    <?php 
                  
                    foreach($username AS $us) ?>
                    <td style="border-bottom:1px solid #000">
                        <input class="select" type="" name="" value="<?php echo $us['user'];?>">
                    </td> 
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" class="select" name="released" id="released" onchange="chooseEmprel()">
                            <option></option>
                            <?php /*foreach($employees AS $emp){ */ foreach($released_emp AS $rel){ ?>
                            <option value="<?php echo $rel['empid']; ?>"<?php echo (($rel['empid'] == $released) ?  ' selected' : ''); ?>><?php echo $rel['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><!-- <input class="select animated headShake" type="" name="" placeholder="Type Designation Here.." > -->
                        <select class="select" type="text" name='received'>
                            <option value = "">Select Your Designation Here..</option>
                            <option value = "">Accounting Staff</option>
                            <option value = "">Asset and Warehouse Manager</option>
                            <option value = "">Parts Inventory Assistant</option>
                            <option value = "">Projects and Asset Management Assistant</option>
                            <option value = "">Warehouse Assistant</option>
                            <option value = "">Warehouse Supervisor</option>
                        </select>
                    </td>
                    <td></td>
                   <!--  <td><center>Warehouse Personnel</center></td> -->
                    <td>
                        <center><div id='alt' style="font-weight:bold"></div></center>
                        <input id="position" class="select" style="pointer-events:none" value="<?php echo $us['positionrel'];?>">
                    </td>
                    <td></td>
                </tr>
            </table> 
            <table width="100%">
                <tr>
                    <td width="10%"></td>
                    <td width="26%">Received by:</td>
                    <td width="10%"></td>
                    <td width="26%">Noted by:</td>
                    <td width="10%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" class="select" name="received" id="received" onchange="chooseEmprec()">
                            <option></option>
                            <?php foreach($received_emp AS $rel){ ?>
                            <option value="<?php echo $rel['empid']; ?>"<?php echo (($rel['empid'] == $received) ?  ' selected' : ''); ?>><?php echo $rel['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>                    
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" class="select" name="noted" id="noted" onchange="chooseEmpnoted()">
                            <option></option>
                            <?php foreach($noted_emp AS $rel){ ?>
                            <option value = "<?php echo $rel['empid'];?>"<?php echo (($rel['empid'] == $noted) ?  ' selected' : ''); ?>><?php echo $rel['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>                    
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                   <!--  <td><center>End User/ Requester</center></td> -->
                    <td>
                        <center><div id='alts' style="font-weight:bold"></div></center>
                        <input id="positionrec" class="select" style="pointer-events:none" value="<?php echo $us['positionrec'];?>">
                    </td>
                    <td></td>
                    <!-- <td><center>Warehouse In-Charge</center></td> -->
                    <td>
                        <center><div id='altss' style="font-weight:bold"></div></center>
                        <input id="positionnoted" class="select" style="pointer-events:none" value="<?php echo $us['positionnote'];?>">
                    </td>
                    <td></td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
                </tr>
            </table> 
            <div style="border-bottom: 1px solid #e8e8e8;width: 100%">&nbsp</div>          
            <div class="print" id="print1">        
                <input class="btn btn-warning btn-md " id="print" type="button" value="Print" onclick="printMIF()" /><br>
                <div style="margin-top: 2px">
                    <a class="btn btn-primary btn-md" id="printgpass" href="<?php echo base_url(); ?>index.php/issue/gatepass/<?php echo $id; ?>" style="width: 50%">Print Gate Pass</a>
                </div>
                <br>
                <h5>After Clicking this Button. <br>Configure your <strong>Margin</strong> into <i>none</i></h5>
                <p>____________________________________________________</p>
                <li>Click <a><span class="fa fa-plus"></span> More Settings</a> at the right side of the screen</li>
                <li>Click and Choose<a> None from Margins </a> </li>
                <select class="form-control " style="width: 100px">
                    <option>none</option>
                </select>

            </div>
            <input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
            <input type='hidden' name='mifid' id='mifid' value="<?php echo $id; ?>" >
            </form> 
        </div>
        


           
    </div>
</body>
<script type="text/javascript">
    function editmodal(issuance_id,request_id) {
        window.open("<?php echo base_url();?>index.php/issue/editmodal/"+issuance_id+"/"+request_id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=120,left=460,width=400,height=400");
    }    
</script>
</html>