<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backorder extends CI_Controller {

  function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');

        date_default_timezone_set("Asia/Manila");
        $this->load->model('super_model');
        $this->dropdown['department'] = $this->super_model->select_all_order_by('department', 'department_name', 'ASC');
        $this->dropdown['purpose'] = $this->super_model->select_all_order_by('purpose', 'purpose_desc', 'ASC');
        $this->dropdown['enduse'] = $this->super_model->select_all_order_by('enduse', 'enduse_name', 'ASC');
        $this->dropdown['employee'] = $this->super_model->select_all_order_by('employees', 'employee_name', 'ASC');
        $this->dropdown['pr_list']=$this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE saved='1' GROUP BY pr_no");
        // $this->dropdown['prno'] = $this->super_model->select_join_where("receive_details","receive_head", "saved='1' AND create_date BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE()","receive_id");
        //$this->dropdown['prno'] = $this->super_model->select_join_where_order("receive_details","receive_head", "saved='1'","receive_id", "receive_date", "DESC");
         if(isset($_SESSION['user_id'])){
        $sessionid= $_SESSION['user_id'];
      
        foreach($this->super_model->get_table_columns("access_rights") AS $col){
            $this->access[$col]=$this->super_model->select_column_where("access_rights",$col, "user_id", $sessionid);
            $this->dropdown[$col]=$this->super_model->select_column_where("access_rights",$col, "user_id", $sessionid);
            
        }
      }
      
         foreach($this->super_model->select_custom_where_group("receive_details", "closed=0", "pr_no") AS $dtls){
            foreach($this->super_model->select_custom_where("receive_head", "receive_id = '$dtls->receive_id'") AS $gt){
               if($gt->saved=='1'){
                    $this->dropdown['prno'][] = $dtls->pr_no;
               }
            }  
        }

       
        function arrayToObject($array){
            if(!is_array($array)) { return $array; }
            $object = new stdClass();
            if (is_array($array) && count($array) > 0) {
                foreach ($array as $name=>$value) {
                    $name = strtolower(trim($name));
                    if (!empty($name)) { $object->$name = arrayToObject($value); }
                }
                return $object;
            } else {
                return false;
            }
        }
    }
     public function get_expected_qty($pr,$item){
        //$expected_qty = $this->super_model->custom_query_single("expected_qty","SELECT ri.expected_qty FROM receive_items ri INNER JOIN receive_details rd ON ri.rd_id = rd.rd_id WHERE rd.pr_no = '$pr' AND ri.item_id='$item' ORDER BY ri_id ASC LIMIT 1");
        $expected_qty = $this->super_model->select_sum_join("expected_qty","receive_items","receive_details", "pr_no = '$pr' AND item_id='$item'","rd_id");
        return $expected_qty;
    }

     public function get_received_qty($pr,$item){
        $received_qty = $this->super_model->select_sum_join("received_qty","receive_items","receive_details", "pr_no = '$pr' AND item_id='$item'","rd_id");
        return $received_qty;
    }

      public function get_rdid($pr,$item){
        $rd_id = $this->super_model->custom_query_single("rd_id","SELECT ri.rd_id FROM receive_items ri INNER JOIN receive_details rd ON ri.rd_id = rd.rd_id WHERE rd.pr_no = '$pr' AND ri.item_id='$item' ORDER BY ri_id DESC LIMIT 1");
        return $rd_id;
    }


    public function back_order(){

        $id=$this->uri->segment(3);
        $data['id']=$id;
      
        $data['supplier']=$this->super_model->select_all_order_by("supplier","supplier_name","ASC");
        $data['brand']=$this->super_model->select_all_order_by("brand","brand_name","ASC");
          foreach($this->super_model->select_row_where("receive_details", "rd_id", $id) AS $rd){
            
               
                 $data['details'][] = array(
                    "receiveid"=>$rd->receive_id,
                    "rdid"=>$rd->rd_id,
                    "prno"=>$rd->pr_no,
                    "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $rd->department_id),
                     "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $rd->purpose_id),
                    "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $rd->enduse_id),
                 );
             
        }

        foreach($this->super_model->select_row_where("receive_items", "rd_id", $id) AS $it){
            
             if($it->expected_qty > $it->received_qty){
                $boqty=$this->backorder_qty($it->ri_id);
                $total_cost=$boqty * $it->item_cost;
                 $data['items'][] = array(
                    "receiveid"=>$it->receive_id,
                    "rdid"=>$it->rd_id,
                    "riid"=>$it->ri_id,
                    "item"=>$this->super_model->select_column_where("items", "item_name", "item_id", $it->item_id),
                    "supplier"=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $it->supplier_id),
                    "brand"=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $it->brand_id),
                    "item_id"=>$it->item_id,
                    "supplier_id"=>$it->supplier_id,
                    "brand_id"=>$it->brand_id,
                    "item_cost"=>$it->item_cost,
                    "total_cost"=>$total_cost,
                    "expected_qty"=>$it->expected_qty,
                    "received_qty"=>$it->received_qty,
                    "quantity"=>$boqty,
                      "catalog_no"=>$it->catalog_no,
                 );
             }
        }

          foreach($this->super_model->custom_query("SELECT DISTINCT pr_no, item_id FROM receive_details rd INNER JOIN receive_head rh ON rh.receive_id = rd.receive_id INNER JOIN receive_items ri ON rd.rd_id = ri.rd_id WHERE saved='1'") AS $prlist){
            
            $expected_qty= $this->get_expected_qty($prlist->pr_no,$prlist->item_id);
            $received_qty= $this->get_received_qty($prlist->pr_no,$prlist->item_id);
            $balance = $expected_qty - $received_qty;
            $rd_id= $this->get_rdid($prlist->pr_no,$prlist->item_id);
            $item=$this->super_model->select_column_where("items", "item_name", "item_id", $prlist->item_id);
            if($balance>$received_qty){
                $data['prback'][] = array(
                    "rdid"=>$rd_id,
                    "pr_no"=>$prlist->pr_no,
                    "item"=>$item,
                    "expected"=>$expected_qty,
                    "received"=>$received_qty
                );
            }
        }

        
        /*$result=array();
        foreach($this->super_model->custom_query("SELECT * FROM receive_items lut WHERE NOT EXISTS (SELECT * FROM receive_items nx WHERE nx.po_no = lut.po_no AND nx.ri_id > lut.ri_id) AND lut.expected_qty > lut.received_qty ORDER BY ri_id DESC") AS $ri){
                 $item=$this->super_model->select_column_where("items", "item_name", "item_id", $ri->item_id);
                 $pr_no=$this->super_model->select_column_where("receive_details", "pr_no", "receive_id", $ri->receive_id);
                 $boqty=$this->backorder_qty($ri->ri_id);
              
                $distinct_pr[] = array(
                    "pono"=>$ri->po_no,
                    "pr_no"=>$pr_no,
                    "rdid"=>$ri->rd_id,
                    "item"=>$item,
                    "expected"=>$boqty,
                    "received"=>$ri->received_qty,
                );
                $distinct_item[] = array(
                    "pono"=>$ri->po_no,
                    "pr_no"=>$pr_no,
                    "rdid"=>$ri->rd_id,
                    "item"=>$item,
                    "expected"=>$boqty,
                    "received"=>$ri->received_qty,
                );
        }
        $distinct_pr[]=array();
        $distinct_item[]=array();
        $tempPR = array_unique(array_column($distinct_pr, 'pr_no'));
        $prlist = array_intersect_key($distinct_pr, $tempPR);
        $tempItem = array_unique(array_column($distinct_item, 'item'));
        $itemlist = array_intersect_key($distinct_item, $tempItem);
        $result = array_merge($prlist, $itemlist);
        foreach(array_unique($result, SORT_REGULAR) AS $ri){
            $data['prback'][]=array(
                "pono"=>$ri['pono'],
                "pr_no"=>$ri['pr_no'],
                "rdid"=>$ri['rdid'],
                "item"=>$ri['item'],
                "expected"=>$ri['expected'],
                "received"=>$ri['received'],
            );
        }*/
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('backorder/back_order',$data);
        $this->load->view('template/footer');
    }

    public function getBrandinformation(){
        $brand = $this->input->post('brand');
        foreach($this->super_model->custom_query("SELECT brand_id, brand_name FROM brand WHERE brand_id='$brand'") AS $brnd){  
            $return = array('brand_id' => $brnd->brand_id,'brand_name' => $brnd->brand_name); 
            echo json_encode($return);   
        }
    }

    
    public function backorder_qty($riid){

        $expectedqty = $this->super_model->select_sum("receive_items", "expected_qty", "ri_id", $riid);
        $recqty = $this->super_model->select_column_where("receive_items", "received_qty", "ri_id", $riid);
        $bo_qty = $expectedqty-$recqty;
        return $bo_qty;
    }

    public function saveBackorder(){
      
        $receive_id= $this->input->post('receive_id');
        $po_no= $this->input->post('po_no');
        $dr_no= $this->input->post('dr_no');
        $rdid= $this->input->post('rdid');
        $si_no= $this->input->post('si_no');
        $userid = $_SESSION['user_id'];
        $year_series=date('Y');
        $year=date('Y-m');
        $now=date('Y-m-d H:i:s');
        //$receivedate=date('Y-m-d');
        $receivedate=$this->input->post('receive_date');
            $rows=$this->super_model->count_custom_where("receive_head","create_date LIKE '$year_series%'");
            if($rows==0){
                 $newrec_no = "MRIF-".$year."-0001";
            } else {
                $maxrecno=$this->super_model->get_max_where("receive_head", "mrecf_no","create_date LIKE '$year_series%'");
                $recno = explode('-',$maxrecno);
                $series = $recno[3]+1;
                $newrec_no = "MRIF-".$year."-".str_pad($series, 4, '0', STR_PAD_LEFT);
                /*if(strlen($series)==1){
                    $newrec_no = "MrecF-".$year."-000".$series;
                } else if(strlen($series)==2){
                     $newrec_no = "MrecF-".$year."-00".$series;
                } else if(strlen($series)==3){
                     $newrec_no = "MrecF-".$year."-0".$series;
                } else if(strlen($series)==4){
                     $newrec_no = "MrecF-".$year."-".$series;
                }*/
            }


        $head_rows = $this->super_model->count_rows("receive_head");
        if($head_rows==0){
            $receiveid=1;
        } else {
            $maxid=$this->super_model->get_max("receive_head", "receive_id");
            $receiveid=$maxid+1;
        }

        foreach($this->super_model->select_row_where("receive_head", "receive_id", $receive_id) AS $hd){
              
            $data = array(
                  'receive_id'=>$receiveid,
                   'pcf'=>$hd->pcf,
                   'create_date'=> $now,
                   'receive_date'=> $receivedate,
                   'mrecf_no'=> $newrec_no,
                   'dr_no'=> $dr_no,
                   'jo_no'=> $hd->jo_no,
                   'po_no'=> $po_no,
                   'si_no'=> $si_no,
                   'user_id'=> $userid,
                   'saved'=>'1'

            );

            $this->super_model->insert_into("receive_head", $data);
        }

           if($rows==0){
                $newrdid=1;
            } else {
                $maxid= $this->super_model->get_max("receive_details", "rd_id");
                $newrdid=$maxid+1;
            }


        foreach($this->super_model->select_row_where("receive_details", "rd_id", $rdid) AS $rd){
       
               $details = array(
                   'rd_id'=>$newrdid,
                   'receive_id'=> $receiveid,
                   'pr_no'=> $rd->pr_no,
                   'enduse_id'=> $rd->enduse_id,
                   'purpose_id'=> $rd->purpose_id,
                   'department_id'=> $rd->department_id,
                   'inspected_by'=> $rd->inspected_by,
                );

        
                $this->super_model->insert_into("receive_details", $details);
        }

         $counter = $this->input->post('count');
        $pono=$this->super_model->select_column_where("receive_head", "po_no", "receive_id", $receive_id);
         //print_r($this->input->post('riid'));
        for($a=0;$a<$counter;$a++){
         
           /* if(empty($this->input->post('brand_id['.$a.']'))){
                $maxid=$this->super_model->get_max("brand", "brand_id");
                $bid=$maxid+1;
                $brand_data = array(
                    'brand_id' => $bid,
                    'brand_name' => $this->input->post('brand['.$a.']')
                );
                $this->super_model->insert_into("brand", $brand_data);
            } else {
                $bid = $this->input->post('brand['.$a.']');
            }*/

            foreach($this->super_model->select_row_where("receive_items", "ri_id", $this->input->post('riid['.$a.']')) AS $rd){
           
                $items = array(
                'rd_id'=>$newrdid,
                'receive_id'=> $receiveid,
                'po_no'=>$po_no,
                'supplier_id'=> $this->input->post('supplier['.$a.']'),
                'item_id'=> $rd->item_id,
                'brand_id'=> $rd->brand_id,
                'catalog_no'=> $rd->catalog_no,
                'serial_id'=>$rd->serial_id,
                'item_cost'=> $this->input->post('item_cost['.$a.']'),
                'expected_qty'=>$this->input->post('expqty['.$a.']'),
                'received_qty'=>$this->input->post('quantity['.$a.']'),
                'remarks'=> $this->input->post('remarks['.$a.']'),
                'inspected_by'=> $rd->inspected_by
            );
            
            $this->super_model->insert_into("receive_items", $items);

            $existingqty = $this->super_model->select_column_custom_where("supplier_items", "quantity", "item_id = '$rd->item_id' AND supplier_id = '$rd->supplier_id' AND catalog_no ='$rd->catalog_no' AND brand_id = '$rd->brand_id'");
            $newqty = $existingqty + $this->input->post('quantity['.$a.']');
            $si = array(
                "quantity"=>$newqty
            );

            $this->super_model->update_custom_where("supplier_items", $si, "item_id = '$rd->item_id' AND supplier_id = '$rd->supplier_id' AND catalog_no ='$rd->catalog_no' AND brand_id = '$rd->brand_id'");
            }
        }

        echo $receiveid;
    }
    /*   $requestid= $this->input->post('request_id');
       $rqid=$this->input->post('rqid');
      
       $quantity=$this->input->post('quantity');
       $userid=$this->input->post('userid');
   
        $remarks = $this->input->post('remarks');
       

       $count = count($quantity);
       
       $year=date('Y-m');
       

       $rows=$this->super_model->count_custom_where("issuance_head","issue_date LIKE '$year%'");

    
        if($rows==0){
             $mifno = "MIF-".$year."-0001";
        } else {
            $maxrecno=$this->super_model->get_max_where("issuance_head", "mif_no","issue_date LIKE '$year%'");
            $recno = explode('-',$maxrecno);
            $series = $recno[3]+1;
            if(strlen($series)==1){
                $mifno = "MIF-".$year."-000".$series;
            } else if(strlen($series)==2){
                 $mifno = "MIF-".$year."-00".$series;
            } else if(strlen($series)==3){
                 $mifno = "MIF-".$year."-0".$series;
            } else if(strlen($series)==4){
                 $mifno = "MIF-".$year."-".$series;
            }
        }

        $date=date('Y-m-d');
        $time=date('H:i:s');
        $create=date('Y-m-d H:i:s');

        $head_rows = $this->super_model->count_rows("issuance_head");
        if($head_rows==0){
            $issueid=1;
        } else {
            $maxid=$this->super_model->get_max("issuance_head", "issuance_id");
            $issueid=$maxid+1;
        }

        foreach($this->super_model->select_row_where("request_head", "request_id", $requestid) AS $req){
          

            $data = array(
                'issuance_id'=>$issueid,
                'mif_no'=>$mifno,
                'request_id'=>$requestid,
                'mreqf_no'=>$req->mreqf_no,
                'issue_date'=>$date,
                'issue_time'=>$time,
                'create_date'=>$create,
                'department_id'=>$req->department_id,
                'purpose_id'=>$req->purpose_id,
                'enduse_id'=>$req->enduse_id,
                'pr_no'=> $pr=$req->pr_no,
                'user_id'=>$userid,
                'saved'=>'1'
                
            );

            $this->super_model->insert_into("issuance_head", $data);
        }



       for($x=0; $x<$count; $x++){

         $itemid=$this->super_model->select_column_where("request_items", "item_id", "rq_id", $rqid[$x]);
         $supplierid=$this->super_model->select_column_where("request_items", "supplier_id", "rq_id", $rqid[$x]);
         $catalogno=$this->super_model->select_column_where("request_items", "catalog_no", "rq_id", $rqid[$x]);
         $brandid=$this->super_model->select_column_where("request_items", "brand_id", "rq_id", $rqid[$x]);
         $pn_no=$this->super_model->select_column_where("request_items", "pn_no", "rq_id", $rqid[$x]);
         $uom=$this->super_model->select_column_where("request_items", "uom", "rq_id", $rqid[$x]);
         
         if($quantity[$x]!='0' && $quantity[$x]!=""){
          
            $details= array(
                'issuance_id'=>$issueid,
                'rq_id'=>$rqid[$x],
                'item_id'=>$itemid,
                'supplier_id'=>$supplierid,
                'catalog_no'=>$catalogno,
                'brand_id'=>$brandid,
                'quantity'=>$quantity[$x],
                'pn_no'=>$pn_no,
                'uom'=>$uom,
                'remarks'=>$remarks[$x],
            );
        
             $this->super_model->insert_into("issuance_details", $details);
        }
       }

       echo $issueid;
    }*/
}
?>

