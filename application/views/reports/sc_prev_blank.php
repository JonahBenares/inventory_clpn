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
</style>
<body style="padding-top:0px">    
    <div>
        <table class="table-bordesred" width="100%" >
            <tr class="hidden-tr">
                <td style="width: 33.33%"></td>
                <td style="width: 33.33%"></td>
                <td style="width: 33.33%"></td>
            </tr>
            <tr>                
                <td colspan="1" align="center" style="padding-right: 15px">
                    <table class="table-bordered" width="100%" style="border:2px solid #000;">
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
                                    <h3 class="nomarg"><b>CENPRI STOCK CARD</b></h3>
                                    <small style="color:#ffffff00!important">printed by: admin admin admin | 2019-01-10 | 20:20am</small>
                                </center>
                            </td>
                        </tr>  
                        <tr>
                            <td colspan="1" class="padr5" align="right"><p style="height: 40px">Item Desc:</p></td>
                            <td colspan="7" class="padl5"><p style="height: 40px"></p></td>
                        </tr>  
                        <tr>
                            <td colspan="1" class="padr5" align="right">Location:</td>
                            <td colspan="2" class="padl5"></td>
                            <td colspan="1" class="padr5" align="right">Rack:</td>
                            <td colspan="2" class="padl5"></td>
                            <td colspan="1" class="padr5" align="right">Ord Qty:</td>
                            <td colspan="1" class="padl5"></td>                            
                        </tr> 
                        <tr>
                            <td colspan="1" class="padr5" align="right">Brand:</td>     
                            <td colspan="7" class="padl5"></td>                            
                        </tr> 
                        <tr>
                            <td colspan="1" class="padr5" align="right">Orig PN:</td>
                            <td colspan="2" class="padl5"></td>
                            <td colspan="1" class="padr5" align="right">Cost:</td>
                            <td colspan="2" class="padl5"></td>      
                            <td colspan="1" class="padr5" align="right">U/M:</td>
                            <td colspan="1" class="padl5"></td>                      
                        </tr> 
                        <tr>
                            <td colspan="1" class="padr5" align="right">Cat PN:</td>
                            <td colspan="2" class="padl5"></td>
                            <td colspan="1" class="padr5" align="right">BarCode:</td>
                            <td colspan="2" class="padl5"></td>    
                            <td colspan="1" class="padr5" align="right">Model:</td>
                            <td colspan="1" class="padl5"></td>                         
                        </tr> 
                        <tr>
                            <td colspan="8" class="padr5" align="right"><br></td>                    
                        </tr> 
                        <tr>
                            <td colspan="2" align="center">Date</td>
                            <td colspan="2" align="center">Ref</td>
                            <td align="center">Received</td>                        
                            <td align="center">Issued</td>                        
                            <td align="center">Restock</td>                        
                            <td align="center">Balance</td>                        
                        </tr> 
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>
                        <tr>
                            <td class="font13" colspan="2" align="center"><br></td>
                            <td class="font10" colspan="2" align="center"></td>
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                            <td class="font13" align="center"></td>                        
                        </tr>                        
                    </table>
                </td>                
                <td colspan="2">

                    <div class="btn-group" id="print-btn" style="position: fixed;top:10px">
                        <button  class="btn btn-primary" onclick="window.print()">Print <u><b>BLANK Stock Card</b></u></button>
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
                    </div>
                </td>
            </tr>
        </table>

</body>
</html>