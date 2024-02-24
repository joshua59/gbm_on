<?php

/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class parameter_analisa_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "MASTER_PARAMETER"; 
    private $_table2 = "MASTER_PARAMETER_NILAI"; 

    private function _key($key) { 
        if (!is_array($key)) {
            $key = array('ID_PARAMETER' => $key);
        }
        return $key;
    }

    public function data($data) {
        
        $this->db->select("*");
        $this->db->from($this->_table1);
        $this->db->where('IS_AKTIF',1);
        if($data['p_idparam'] != '') {
            $this->db->where('ID_PARAMETER',$data['p_idparam']);
        }
        if($data['p_cari'] != '') {
            $this->db->like('PARAMETER_ANALISA', $data['p_cari']);
        }

        $ret = $this->db->get();
        
        $this->db->close();
        return $ret;
    }

    public function data_edit($id) {
        
        $this->db->select("*");
        $this->db->from($this->_table1);
        $this->db->where('ID_PARAMETER',$id);

        $ret = $this->db->get()->row();
        
        $this->db->close();
        return $ret;
    }

    public function get_detail($id) {
        $this->db->select("*");
        $this->db->from($this->_table2);
        $this->db->where('ID_PARAMETER',$id);
        $this->db->where('IS_AKTIF',1);

        $ret = $this->db->get()->result_array();
        
        $this->db->close();
        return $ret;
    }

    public function data_edit_detail($id) {
        
        $this->db->select("*");
        $this->db->from($this->_table2);
        $this->db->where('ID_NILAI',$id);

        $ret = $this->db->get()->row();
        
        $this->db->close();
        return $ret;
    }

    public function options_parameter($default = '--Pilih Parameter Analisa--', $key = 'all') {
        $option = array();
        $this->db->select('*');
        $this->db->from($this->_table1);  
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

    public function options_parameter_edit($default = '-- Pilih Parameter Analisa --', $key = 'all') {
        $option = array();
        $this->db->select('*');
        $this->db->from('MASTER_PARAMETER');
        $this->db->where('TIPE',2);
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
    
    public function save($data,$tipe) {
        $this->db->trans_begin();
        $this->db->insert($this->_table1, $data);
        if($tipe == 1) {
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            } else {
                $this->db->trans_commit();
                $last_id = $this->db->insert_id();
                return TRUE;
            }
        } else {
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            } else {
                $id = $this->db->insert_id();
                $this->db->trans_commit();
                return $id;
            }
            
        }
        
    }

    public function edit($data, $id) {
        $this->db->trans_begin();

        $this->db->where('ID_PARAMETER',$id);
        $this->db->update($this->_table1, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function edit_detail($data, $id) {
        $this->db->trans_begin();

        $this->db->where('ID_NILAI',$id);
        $this->db->update($this->_table2, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete($id) {
        $this->db->trans_begin();
        $data = array('IS_AKTIF' => 2);
        $this->db->where('ID_PARAMETER',$id);
        $this->db->update($this->_table1, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function delete_detail($id) {
        $this->db->trans_begin();
        $data = array('IS_AKTIF' => 2);
        $this->db->where('ID_NILAI',$id);
        $this->db->update($this->_table2, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function insert_batch($id,$nama_nilai,$status) {

        $array = array();
        $data = [];
        foreach ($nama_nilai as $key => $value) {
           $data['ID_PARAMETER'] = $id;
           $data['NAMA_NILAI'] = $value;
           $data['STATUS'] = $status[$key];
           $data['CD_BY'] = $this->session->userdata('user_name');
           $data['CD_DATE'] = date('Y-m-d H:i:s');

           $array[] = $data;
        }
        $this->db->trans_begin();
        $this->db->insert_batch($this->_table2, $array);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }

    }
}
