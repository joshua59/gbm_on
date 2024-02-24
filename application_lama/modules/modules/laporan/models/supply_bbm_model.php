<?php

class supply_bbm_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function get_data($data)
    {
        $vlevelid = $data['vlevelid'];
        $vlevel = $data['vlevel'];
        $cari = $data['cari'];
        $sql = "CALL DATA_SUPPLY_PEMBANGKIT('$vlevel','$vlevelid','$cari');";

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL4');
        $this->db->where('IS_AKTIF_LVL4','1');
        $this->db->order_by('LEVEL4');
        if ($key != 'all'){
            $this->db->where('STORE_SLOC',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->SLOC] = $row->LEVEL4;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }
}