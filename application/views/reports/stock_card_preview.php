<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Print Stock Card</title>
</head>
<style type="text/css">
    .nomarg{
        margin:0px;
    }
    tr>td.dashed, 
    tr>th.dashed {
        border-right: 2px dashed #000!important;
    }
    body{
        font-size: 11px!important;
        color: #000!important;
        font-weight: 600;
    }
    .text-red{
        color: red;
        -webkit-print-color-adjust: exact;
    }
    .text-white{
        color: white!important;
        -webkit-print-color-adjust: exact;
    }
    .text-blue{
        color: blue;
        -webkit-print-color-adjust: exact;
    }
    .font13{
            font-size: 13px;
        } 
    .font12{
        font-size: 12px;
    }
    .font11{
        font-size: 11px;
    }
    .font10{
        font-size: 10px;
    }
    .font9{
        font-size: 9px;
    }
    .font8{
        font-size: 8px;
    }
    @media print{
        .text-red{
            color: red;
            -webkit-print-color-adjust: exact;
        }
        .text-blue{
            color: blue;
            -webkit-print-color-adjust: exact;            
        }
        #print-btn{
            display: none;
        }
        .font13{
            font-size: 13px!important;
        }     
        .font12{
            font-size: 12px!important;
        }
        .font11{
            font-size: 11px!important;
        }
        .font10{
            font-size: 10px!important;
        }
        .font9{
            font-size: 9px!important;
        }
        .font8{
            font-size: 8px!important;
        }
        .table-bordered>tbody>tr>td, 
        .table-bordered>tbody>tr>th, 
        .table-bordered>tfoot>tr>td, 
        .table-bordered>tfoot>tr>th, 
        .table-bordered>thead>tr>td, 
        .table-bordered>thead>tr>th {
        border: 1px solid #fff!important;
    }
    }
    p{
        color: #000
    }
    .padl5{
        padding-left: 2px;
    }
    .padr5{
        padding-right:2px;
    }
    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
        border: 1px solid #fff;
    }
</style>
<body style="padding-top:0px">    
    <div>
        <table class="table-bordered" width="100%" >
            <tr class="hidden-tr">
                <td style="width: 33.33%"></td>
                <td style="width: 33.33%"></td>
                <td style="width: 33.33%"></td>
            </tr>
            <tr>                
                <td colspan="1" align="center" style="padding-right: 15px">
                    <table class="table-bordered" width="100%" style="border:2px solid #fff;">
                        <tr>
                            <td width="12%"></td>
                            <td width="12%"></td>
                            <td width="12%"></td>
                            <td width="12%"></td>
                            <td width="12%"></td>
                            <td width="12%"></td>
                            <td width="12%"></td>
                            <td width="12%"></td>
                        </tr>   
                        <tr>
                            <td colspan="8">
                                <center>
                                    <h3 class="nomarg text-white"><b style="color:#ffffff00!important">CENPRI STOCK CARD</b></h3>
                                    <small id="psrntby">printed by: admin admin admin | 2019-01-10 | 20:20am</small>
                                </center>
                            </td>
                        </tr> 
                        <?php foreach($item AS $i){ ?>
                        <tr>
                            <td colspan="1" class="padr5 " align="right"><p class="text-white" style="height: 40px">Item Desc:</p></td>
                            <td colspan="7" class="padl5"><p style="height: 40px"><?php echo $i['item'];?></p></td>
                        </tr>  
                        <tr>
                            <td colspan="1" class="padr5 text-white" align="right">Location:</td>
                            <td colspan="2" class="padl5"><?php echo $i['location'];?></td>
                            <td colspan="1" class="padr5 text-white" align="right">Rack:</td>
                            <td colspan="2" class="padl5"><?php echo $i['rack'];?></td>
                            <td colspan="1" class="padr5 text-white" align="right">Ord Qty:</td>
                            <td colspan="1" class="padl5"><?php echo $i['min_qty'];?></td>                            
                        </tr> 
                        <tr>
                            <td colspan="1" class="padr5 text-white" align="right">Brand:</td>     
                            <td colspan="7" class="padl5"><?php echo $i['brand'];?></td>                            
                        </tr> 
                        <tr>
                            <td colspan="1" class="padr5 text-white" align="right">Orig PN:</td>
                            <td colspan="2" class="padl5"><?php echo $i['pn'];?></td>
                            <td colspan="1" class="padr5 text-white" align="right">Cost:</td>
                            <td colspan="2" class="padl5"><?php echo $i['cost'];?></td>      
                            <td colspan="1" class="padr5 text-white" align="right">U/M:</td>
                            <td colspan="1" class="padl5"><?php echo $i['unit'];?></td>                      
                        </tr> 
                        <tr>
                            <td colspan="1" class="padr5 text-white" align="right">Cat PN:</td>
                            <td colspan="2" class="padl5"><?php echo $i['cat_no'];?></td>
                            <td colspan="1" class="padr5 text-white" align="right">BarCode:</td>
                            <td colspan="2" class="padl5"><?php echo $i['barcode'];?></td>    
                            <td colspan="1" class="padr5 text-white" align="right">Model:</td>
                            <td colspan="1" class="padl5"></td>                         
                        </tr> 
                        <?php } ?>
                        <tr>
                            <td colspan="8" class="padr5" align="right"><br></td>                    
                        </tr> 
                        <tr>
                            <td colspan="2" align="center" class="text-white">Date</td>
                            <td colspan="2" align="center" class="text-white">Ref</td>
                            <td align="center" class="text-white">Received</td>                        
                            <td align="center" class="text-white">Issued</td>                        
                            <td align="center" class="text-white">Restock</td>                        
                            <td align="center" class="text-white">Balance</td>                        
                        </tr> 
                        <?php 
                            foreach($rec_itm AS $r){
                        ?>
                        <tr>
                            <td class="font13" colspan="2" align="center"><?php echo $r['date'];?></td>
                            <td class="font10" colspan="2" align="center"><?php echo $r['ref'];?></td>
                            <td class="font13" align="center">9<?php echo $r['receive_qty']; ?></td>                        
                            <td class="font13" align="center">9<?php echo $r['issueqty']; ?></td>                        
                            <td class="font13" align="center">9<?php echo $r['restockqty'];?></td>                        
                            <td class="font13" align="center">9<?php echo $r['balance'];?></td>                        
                        </tr>
                        <?php } ?> 
                        <!-- <tr>
                            <td class="font8" colspan="1" align="center">2019-09-19</td>
                            <td class="font8" colspan="3" align="center">MreqF-2019-03-0071</td>
                            <td class="font8" align="center">99</td>                        
                            <td class="font8" align="center">99</td>                        
                            <td class="font8" align="center">999</td>                        
                            <td class="font8" align="center">999</td>                        
                        </tr>  -->
                    </table>
                </td>
                
                <td colspan="2" >
                    <div class="btn-group" style="position: fixed;top:10px" id="print-btn">
                    <button class="btn btn-primary" onclick="window.print()">Print <u><b>Stock Card</b></u></button>
                    <a class="btn btn-warning" target="_blank" id="print-btn1" href = "<?php echo base_url(); ?>index.php/reports/sc_prev_blank"> Print <u><b>Blank</b></u> Stock Card</a>
                    <br>
                        <br>
                        <br>
                        <h4>Note</h4>
                        <hr class="nomarg">
                        <p>When printing Stock Card make sure the following options are set
                            <br>
                            <br>Browser : Chrome
                            <br>Layout : Landscape
                            <br>Paper Size: A4
                            <br>Margin : Custom (top: 0.11" , right:0.40",  bottom: 0.11", left: 0.11")
                            <br>Scale: 81
                        </p>
                </td>
            </tr>
        </table>

</body>
</html>