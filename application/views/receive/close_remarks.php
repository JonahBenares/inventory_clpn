<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/receive.js"></script>
<style type="text/css">
    body {
    padding-top: 15px;
}
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default shadow">
                <div class="panel-body">
                    <div class="canvas-wrapper">
                        <div class="row" style="padding:0px 10px 0px 10px">
                            <div class="alert bg-danger animated headShake" role="alert">
                                <form>
                                <table>
                                    <tr>
                                        <td><h1 style="color:#fff" ><em class="fa fa-lg fa-warning">&nbsp;</em></h1></td>
                                        <td><h4>  Unable to close this PR. You have pending items to receive. Close anyway?</h4></td>
                                    </tr>
                                </table>                                                              
                            </div>
                            <textarea rows="5" class="form-control" name='remarks' id='remarks' placeholder="Remarks..." required=""></textarea>
                            <center>
                                <br>
                                <button class="btn btn-warning" onclick='closePopup()'> NO</button>
                                <input type='button' class="btn btn-primary" onclick='closePR()' value='YES'>
                            </center> 
                            <input type='hidden' name='prno' id='prno' value="<?php echo $prno; ?>">
                            <input type='hidden' name='recid' id='recid' value="<?php echo $recid; ?>">
                            <input type='hidden' name='baseurl' id='baseurl' value="<?php echo base_url(); ?>">
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        
    function closePR(){
        var prno= document.getElementById("prno").value;
        var recid= document.getElementById("recid").value;
        var remarks= document.getElementById("remarks").value;
        var loc= document.getElementById("baseurl").value;
        var redirect = loc+'index.php/receive/closePR';
        if(remarks==""){
            alert('Remarks must not be empty.');
        } else {
            $.ajax({
                type: "POST",
                url: redirect,
                data: 'prno='+prno+'&remarks='+remarks,
                success: function(output){
                      alert('PR successfully closed.');
                      window.close();
                      window.opener.location.href = loc+"index.php/receive/view_receive/"+recid;
                    
                }
            });
        }
    }
    </script>