<?php

/**
 * @module User Management
 * @author  CF
 */
class list_user_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_USER' => $key);
        }
        return $key;
    }

    private function _key2($key) { //unit ID
        if (!is_array($key)) {
            $key = array('USERNAME' => $key);
        }
        return $key;
    }

    public function getDataUser($data) {
        $regional = $data['regional'];
        $levelId  = $data['level'];
        $cari     = $this->laccess->ai($data['cari']);

        $sql      = "call lap_rekap_user(
                '$regional',
                '$levelId',
                '$cari'
            )";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function get_table($key = '') {
        $this->db->select("(CASE 
                            WHEN LEVEL_USER = 'R' THEN r.NAMA_REGIONAL
                            WHEN LEVEL_USER = '1' THEN m1.LEVEL1
                            WHEN LEVEL_USER = '2' THEN m2.LEVEL2
                            WHEN LEVEL_USER = '3' THEN m3.LEVEL3
                            ELSE 'PUSAT'
                        END ) AS NAMA_UNIT,usr.KD_USER, usr.USERNAME, usr.NAMA_USER, usr.EMAIL_USER, rl.ROLES_NAMA, usr.LEVEL_USER,usr.ISAKTIF_USER AS STATUS_USER");
        $this->db->from('M_USER' . ' usr');
        $this->db->join('MASTER_LEVEL3' . ' m3', 'm3.STORE_SLOC = usr.KODE_LEVEL', 'left');
        $this->db->join('MASTER_LEVEL2' . ' m2', 'm2.PLANT = m3.PLANT OR m2.PLANT = usr.KODE_LEVEL', 'left');
        $this->db->join('MASTER_LEVEL1' . ' m1', 'm1.COCODE = m2.COCODE OR m1.COCODE = usr.KODE_LEVEL', 'left');
        $this->db->join('MASTER_REGIONAL' . ' r', 'r.ID_REGIONAL = m1.ID_REGIONAL OR r.ID_REGIONAL = usr.KODE_LEVEL', 'left');
        $this->db->join('ROLES' . ' rl', 'rl.ROLES_ID = usr.ROLES_ID', 'left');

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));
        
        $this->db->order_by('usr.USERNAME', 'ASC');

        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci  = $this->input->post('kata_kunci');
        $ID_REGIONAL = $this->input->post('ID_REGIONAL');
        $COCODE      = $this->input->post('COCODE');
        $PLANT       = $this->input->post('PLANT');
        $STORE_SLOC  = $this->input->post('STORE_SLOC');
        // $SLOC        = $this->input->post('SLOC');
        
        if (!empty($kata_kunci)) {
            $filter["(usr.USERNAME LIKE '%{$kata_kunci}%' OR usr.NAMA_USER LIKE '%{$kata_kunci}%' )"] = NULL;
        }

        if (!empty($ID_REGIONAL)) {
            $filter["r.ID_REGIONAL"] = $ID_REGIONAL;
        }

        if (!empty($COCODE)) {
            $filter["m1.COCODE"] = $COCODE;
        }

        if (!empty($PLANT)) {
            $filter["m2.PLANT"] = $PLANT;
        }

        if (!empty($STORE_SLOC)) {
            $filter["m3.STORE_SLOC"] = $STORE_SLOC;
        }

        // if (!empty($SLOC)) {
        //     $filter["m4.SLOC"] = $SLOC;
        // }
        
        // $total = $this->data($filter)->count_all_results(); 
        $total = $this->get_table($filter)->get();
        $total = $total->num_rows();
    
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->get_table($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();
        $num = 1;
        foreach ($record->result() as $row) {
            $rows[$num] = array(
                'NO' => $no,
                'NAMA_UNIT' =>  $row->NAMA_UNIT,
                'KD_USER' => $row->KD_USER,
                'USERNAME' => $row->USERNAME,
                'NAMA_USER' => $row->NAMA_USER,
                'EMAIL_USER' => $row->EMAIL_USER,
                'ROLES_NAMA' => $row->ROLES_NAMA,
                'LEVEL_USER' => $row->LEVEL_USER,
                'STATUS_USER' => !empty($row->STATUS_USER) ? hgenerator::status_user($row->STATUS_USER) : 'Tidak Aktif',
            );

			$num++;
            $no++;
			// }
		}
		return array('total' => $total, 'rows' => $rows);
    }	 

    public function options_reg($default = '--Pilih Regional--', $key = 'all') {
        $option = array();
        
        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }   
        $list = $this->db->get(); 
        
        if (!empty($default)) {
            $option[''] = $default;
        }
        
        foreach ($list->result() as $row) {
            $option[$row->ID_REGIONAL] = $row->NAMA_REGIONAL;
        }
        $this->db->close();
        return $option;
    }
    
    public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
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
                $option[$row->COCODE] = $row->LEVEL1;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }
    
    public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL2');
        $this->db->where('IS_AKTIF_LVL2','1');
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
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
                $option[$row->PLANT] = $row->LEVEL2;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }
    
    public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL3');
        $this->db->where('IS_AKTIF_LVL3','1');
        if ($key != 'all'){
            $this->db->where('PLANT',$key);
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
                $option[$row->STORE_SLOC] = $row->LEVEL3;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }
    
    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL4');
        $this->db->where('IS_AKTIF_LVL4','1');
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
