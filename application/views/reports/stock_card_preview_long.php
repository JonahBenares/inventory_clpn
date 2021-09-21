    <!DOCTYPE html>
<head>
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/receive.js"></script>
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
        font-size: 12px!important;
    }
    .text-red{
        color: red;
        -webkit-print-color-adjust: exact;
    }
    .text-white{
        color: #000;
        -webkit-print-color-adjust: exact;
    }
    .text-blue{
        color: blue;
        -webkit-print-color-adjust: exact;
    }
    .font9{
        font-size: 11px;
    }
    .table-bordered>tbody>tr>td, 
    .table-bordered>tbody>tr>th, 
    .table-bordered>tfoot>tr>td, 
    .table-bordered>tfoot>tr>th, 
    .table-bordered>thead>tr>td, 
    .table-bordered>thead>tr>th {
        border: 1px solid #fff!important;
    }
    @media print{
        .table-bordered>tbody>tr>td, 
        .table-bordered>tbody>tr>th, 
        .table-bordered>tfoot>tr>td, 
        .table-bordered>tfoot>tr>th, 
        .table-bordered>thead>tr>td, 
        .table-bordered>thead>tr>th {
            border: 1px solid #fff!important;
        }
        .text-white{
            color: #fff!important;
            -webkit-print-color-adjust: exact;
        }
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
        .font9{
            font-size: 9px;
        }
    }
    p{
        color: #000
    }
    .padding-left{
        padding-left: 5px!important;
    }

</style>
<body style="padding-top:0px">    
    <div>
        <table class="table-bordsered" width="100%" >
            <tr class="hidden-tr">
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>                
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
            </tr>
            <tr>                
                <td colspan="10" align="center" style="padding-right: 65px">
                    <table class="table-bordered" width="100%" style="border:2px solid #fff;">
                        <tr>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>                
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td> 
                        </tr>
                        <tr>                            
                            <td width="5%" colspan="11" align="center"><h2 class="nomarg" style="color:#fff0!important"><b style="color:#fff0!important">CENPRI STOCK CARD</b></h2><small id="prntd" >Printed By: admin admin | 2019-10-20 | 10:10 am</small></td>
                        </tr>
                        <tr>
                            <td colspan="1" align="right"><p class="nomarg text-white" style="height: 50px">Item Desc:</p></td>
                            <td colspan="10" class="text-red"><p class="nomarg padding-left">Sorbent Boom, Economical SPC, 8" x 10" ENV810 (Economy Boom w/Blue Sleeve, Lint Free, 4/Bale, Absorbency Capacity: 65ga)<br><br></p></td>
                            <!-- <td colspan="10" class="text-red"><p class="nomarg"><br><br><br></p></td> -->
                            
                        </tr>
                        <tr>
                            <td colspan="1" align="right" class="text-white">Location:</td>
                            <td colspan="3" class="text-red padding-left">WHR 1</td>
                            <td align="right" class="text-white">Rack:</td>
                            <td colspan="3" class="text-red padding-left"> Rack 1</td>
                            <td align="right" class="text-white">Ord Qty:</td>
                            <td colspan="2" class="text-red padding-left"> 9999</td>
                        </tr>
                        <tr>
                            <td colspan="1" align="right" class="text-white">Brand:</td>
                            <td colspan="10" class="text-red padding-left"> Xbatalyon Lenove ArriesX2499</td>
                        </tr>
                        <tr>
                            <td colspan="1" align="right" class="text-white">Orig PN:</td>
                            <td colspan="3" class="text-red padding-left">PAHS-AEW-DS</td>
                            <td align="right" class="text-white">Cost:</td>
                            <td colspan="3" class="text-red padding-left">32 COUNTS</td>
                            <td align="right" class="text-white">U/M:</td>
                            <td colspan="2" class="text-red padding-left">KG</td>                           
                        </tr>
                        <tr>
                            <td colspan="1" align="right" class="text-white">Cat PN:</td>
                            <td colspan="3" class="text-red"></td>
                            <td align="right" class="text-white">BarCode:</td>
                            <td colspan="3" class="text-red"></td>
                            <td align="right" class="text-white">Model:</td>
                            <td colspan="2" class="text-red"></td>                           
                        </tr>
                        <tr>
                            <td align="center" colspan="1" rowspan="2" class="text-white">Date</td>
                            <td align="center" colspan="3" class="text-white">Received</td>
                            <td align="center" colspan="3" class="text-white">Issued</td>
                            <td align="center" colspan="3" class="text-white">Restock</td>
                            <td align="center" rowspan="2" class="text-white">Balance</td>
                        </tr>
                        <tr>
                            <td align="center" class="text-white">Qty</td>
                            <td align="center" colspan="2" class="text-white">MRF No.</td>
                            <td align="center" class="text-white">Qty</td>
                            <td align="center" colspan="2" class="text-white">MIF No.</td>
                            <td align="center" class="text-white">Qty</td>
                            <td align="center" colspan="2" class="text-white">MRWF No.</td>
                        </tr> 
                        <tr>
                            <td align="center" class="font9">9999-99-99</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MrecF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MIF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MRWF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td> 
                        </tr>   
                        <tr>
                            <td align="center" class="font9">9999-99-99</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MrecF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MIF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MRWF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td> 
                        </tr>  
                        <tr>
                            <td align="center" class="font9">9999-99-99</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MrecF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MIF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MRWF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td> 
                        </tr>  
                        <tr>
                            <td align="center" class="font9">9999-99-99</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MrecF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MIF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MRWF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td> 
                        </tr>  
                        <tr>
                            <td align="center" class="font9">9999-99-99</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MrecF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MIF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MRWF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td> 
                        </tr>  
                        <tr>
                            <td align="center" class="font9">9999-99-99</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MrecF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MIF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MRWF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td> 
                        </tr>  
                        <tr>
                            <td align="center" class="font9">9999-99-99</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MrecF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MIF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td>
                            <td align="center" colspan="2" class="font9">MRWF-2019-99-9999</td>
                            <td align="center" class="font9">99999</td> 
                        </tr>                    
                        
                    </table>
                </td>
                <td colspan="2" align="center">
                    <div class="btn-group" style="position: fixed;top:10px" id="print-btn">
                    <button class="btn btn-primary" onclick="window.print()">Print <u><b>Stock Card</b></u></button>
                    <a class="btn btn-warning" target="_blank" id="print-btn1" href = "<?php echo base_url(); ?>index.php/reports/sc_prev_blank_long"> Print <u><b>Blank</b></u> Stock Card</a>
                </td>
            </tr>
        </table>

</body>
</html>