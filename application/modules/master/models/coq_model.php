<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class coq_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "MASTER_COQ"; 
    private $_table2 = "M_JNS_BHN_BKR"; 
    private $_table3 = "M_GROUP_JNS_BBM"; 

    private function _key($key) { 
        if (!is_array($key)) {
            $key = array('ID_MCOQ' => $key);
        }
        return $key;
    }

    public function data($data) {
        
        $p_jnsbbm = $data['p_jnsbbm'];
        $p_ref_lv1 = $data['p_ref_lv1'];
        $p_ref_lv2 = $data['p_ref_lv2'];
        $p_tgl = $data['p_tgl'];
        $p_tglakhir = $data['p_tglakhir'];
        $p_cari = $data['p_cari'];
        
        $sql = "CALL lap_mcoq('$p_jnsbbm','$p_ref_lv1','$p_ref_lv2','$p_tgl','$p_tglakhir','$p_cari')";
        $query = $this->db->query($sql);
        $this->db->close();
        return $query;
    }

    public function data_edit($id) {
        
        $sql = "SELECT * FROM MASTER_COQ WHERE ID_MCOQ = $id";

        $query = $this->db->query($sql);
        $this->db->close();
        return $query->row();
    }

    public function export_data($data) {
        $p_jnsbbm = $data['p_jnsbbm'];
        $p_ref_lv1 = $data['p_ref_lv1'];
        $p_ref_lv2 = $data['p_ref_lv2'];
        $p_tgl = $data['p_tgl'];
        $p_tglakhir = $data['p_tglakhir'];
        $p_cari = $data['p_cari'];

        $sql = "CALL lap_mcoq('$p_jnsbbm','$p_ref_lv1','$p_ref_lv2','$p_tgl','$p_tglakhir','$p_cari')";
        $query = $this->db->query($sql)->result_array();
        return $query;
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

    public function options_ref_lv1($default = '--Pilih Referensi --', $key = 'all') {
        $option = array();
        $this->db->select('DITETAPKAN');
        $this->db->from('MASTER_VCOQ');  
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->DITETAPKAN] = $row->DITETAPKAN;
        }
        $this->db->close();
        return $option;
    }

    public function options_ref_lv2($default = '--Pilih Nomor Referensi--', $key = 'all') {
        $option = array();
        $this->db->select('NO_VERSION');
        $this->db->from('MASTER_VCOQ');  
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->NO_VERSION] = $row->NO_VERSION;
        }
        $this->db->close();
        return $option;
    }

    public function options_satuan() {
        $this->db->select('*');
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','SATUAN');
        $this->db->order_by('VALUE_SETTING','ASC');
        $list = $this->db->get(); 
        return $list->result_array();
    }

    public function options_satuan_edit($default = '--Pilih Nomor Referensi--', $key = 'all') {
        $option = array();
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','SATUAN');
        $this->db->order_by('VALUE_SETTING','ASC');
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        $this->db->close();
        return $option;
    }

    public function options_parameter() {
        $this->db->select('*');
        $this->db->from('MASTER_PARAMETER');
        $this->db->order_by('ID_PARAMETER','ASC');
        $list = $this->db->get(); 
        return $list->result_array();
    }

    public function options_parameter_edit($default = '-- Pilih Parameter Analisa --', $key = 'all') {
        $option = array();
        $this->db->select('*');
        $this->db->from('MASTER_PARAMETER');
        $this->db->order_by('ID_PARAMETER','ASC');
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_PARAMETER] = $row->PARAMETER_ANALISA;
        }
        $this->db->close();
        return $option;
    }

    public function options_version($default = '--Pilih Nomor Referensi--', $key = 'all') {
        $option = array();
        $this->db->select('*');
        $this->db->from('MASTER_VCOQ');  
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_VERSION] = $row->NO_VERSION;
        }
        $this->db->close();
        return $option;
    }

    public function get_detail_version($id) {
        $list = $this->db->query("
            SELECT A.DITETAPKAN,A.TGL_VERSION,
            CASE WHEN A.ID_JNS_BHN_BKR != 004 THEN B.NAMA_JNS_BHN_BKR ELSE C.NAMA_JNS_BHN_BKR END AS NAMA_BBM,
            A.ID_JNS_BHN_BKR,A.KODE_JNS_BHN_BKR
            FROM MASTER_VCOQ A
            LEFT JOIN M_JNS_BHN_BKR B ON A.ID_JNS_BHN_BKR = B.ID_JNS_BHN_BKR
            LEFT JOIN M_GROUP_JNS_BBM C ON A.KODE_JNS_BHN_BKR = C.KODE_JNS_BHN_BKR
            WHERE A.ID_VERSION = $id
        ");
        return $list->result();
    }

    public function save($data) {
        $this->db->trans_begin();
        $this->db->insert_batch('MASTER_COQ', $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function edit($data, $id) {
        $this->db->trans_begin();

        $this->db->where('ID_MCOQ',$id);
        $this->db->update($this->_table1, $data);

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
        $this->db->where($this->_key($key));
        $this->db->update($this->_table1,array('IS_AKTIF' => 0));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
}
