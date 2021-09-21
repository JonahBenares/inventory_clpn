<?php
class item_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function select_item($table, $where){
    
        $this->db->select('item_name');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $count=$query->num_rows();
        echo $count;
      
    }

    public function select_bin($table, $where){
    
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $count=$query->num_rows();

        if(!empty($count)) {
            echo "<ul id='name-type'>";

            if(!empty($count)){
                foreach($query->result() as $result){ ?>
                    <li onClick="selectBin('<?php echo $result->bin_name; ?>', <?php echo $result->bin_id; ?>);"><?php echo $result->bin_name; ?></li>
               <?php }
               
            }
             echo "</ul>";
        }
    }

     public function select_brand($table, $where){
    
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $count=$query->num_rows();

        if(!empty($count)) {
            echo "<ul id='name-type'>";

            if(!empty($count)){
                foreach($query->result() as $result){ ?>
                    <li onClick="selectBrand('<?php echo $result->brand_name; ?>', <?php echo $result->brand_id; ?>);"><?php echo $result->brand_name; ?></li>
               <?php }
               
            }
             echo "</ul>";
        }
    }

    public function select_serial($table, $where){
    
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $count=$query->num_rows();

        if(!empty($count)) {
            echo "<ul id='name-type'>";

            if(!empty($count)){
                foreach($query->result() as $result){ ?>
                    <li onClick="selectSerial('<?php echo $result->serial_no; ?>', <?php echo $result->serial_id; ?>);"><?php echo $result->serial_no; ?></li>
               <?php }
               
            }
             echo "</ul>";
        }
    }

    function search($keyword)
    {
        $this->db->like('items',$keyword);
        $query = $this->db->get();
        return $query->result();
    }


} ?>