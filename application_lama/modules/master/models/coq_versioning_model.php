<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class coq_versioning_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "MASTER_VCOQ"; 
    private $_table2 = "M_JNS_BHN_BKR"; 
    private $_table3 = "M_GROUP_JNS_BBM"; 

    private function _key($key) { 
        if (!is_array($key)) {
            $key = array('ID_VERSION' => $key);
        }
        return $key;
    }

    public function data($data) {
        
        $p_jnsbbm = $data['p_jnsbbm'];
        $p_tglawal = $data['p_tglawal'];
        $p_tglakhir = $data['p_tglakhir'];
        $p_cari = $data['p_cari'];
        $sql = "CALL lap_coq_version('$p_jnsbbm','$p_tglawal','$p_tglakhir','$p_cari')";
        $query = $this->db->query($sql);
        $this->db->close();
        return $query;
    }

    public function export_data($data) {
        
        $p_jnsbbm = $data['p_jnsbbm'];
        $p_tglawal = $data['p_tglawal'];
        $p_tglakhir = $data['p_tglakhir'];
        $p_cari = $data['p_cari'];
        $sql = "CALL lap_coq_version('$p_jnsbbm','$p_tglawal','$p_tglakhir','$p_cari')";
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result_array();
    }

    public function data_edit($id) {
        
        $sql = "SELECT 
                CASE WHEN ID_JNS_BHN_BKR = 004
                THEN KODE_JNS_BHN_BKR ELSE ID_JNS_BHN_BKR END ID_JNS_BHN_BKR,
                NO_VERSION,TGL_VERSION,DITETAPKAN,PIC,STATUS
                FROM MASTER_VCOQ 
                WHERE ID_VERSION = $id";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function save_as_new($data) {
        $this->db->trans_begin();
        $this->db->insert($this->_table1, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function save($data, $key) {
        $this->db->trans_begin();

        $this->db->update($this->_table1, $data, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete($key) {
        $this->db->trans_begin();

        $this->db->delete($this->_table1, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
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
        return $option;
    }

    public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->COCODE] = $row->LEVEL1;
            }
            return $option;    
        }
    }

    public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL2');
        $this->db->where('IS_AKTIF_LVL2','1');
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->PLANT] = $row->LEVEL2;
            }
            return $option;    
        }
    }

    public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL3');
        $this->db->where('IS_AKTIF_LVL3','1');
        if ($key != 'all'){
            $this->db->where('PLANT',$key);
        }    
        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->STORE_SLOC] = $row->LEVEL3;
            }
            return $option;    
        }
    }

    public function options_jenis_bahan_bakar($default = '-- Pilih Jenis Bahan Bakar --'){

        $option = array();
        $query = $this->db->query("
            SELECT * FROM (
                SELECT ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR FROM M_JNS_BHN_BKR
                WHERE ID_JNS_BHN_BKR NOT IN (004,005,003)
                UNION ALL
                SELECT KODE_JNS_BHN_BKR AS ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR FROM M_GROUP_JNS_BBM
            ) A 
            ORDER BY A.NAMA_JNS_BHN_BKR ASC
            
        ");
        $option[''] = $default;
        $list = $query->result();
        foreach ($list as $key) {
           $option[$key->ID_JNS_BHN_BKR] = $key->NAMA_JNS_BHN_BKR;
        }
        return $option;
    }

    public function cek_no_version($value) {
        $this->db->from($this->_table1);
        $this->db->where('NO_VERSION', $value);
        $num = $this->db->count_all_results();
        if ($num == 0) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
}
