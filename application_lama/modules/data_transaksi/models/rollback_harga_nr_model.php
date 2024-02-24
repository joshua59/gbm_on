<?php

class rollback_harga_nr_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function data($key = '') {
        $this->db->select('a.IDTRANS,b.NAMA_PEMASOK,a.PERIODE');
        $this->db->from('LOG_ROLLBACK_TRANS_HITUNG_HARGA_NR a');
        $this->db->join('MASTER_PEMASOK b','a.KODE_PEMASOK = b.KODE_PEMASOK','left');
        $this->db->group_by('a.IDTRANS');
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));
        $total = $this->data()->count_all_results();
           
        $record = $this->data()->get();

        $rows = array();

        $no=(($offset-1) * $limit) +1;
       
        foreach ($record->result() as $row) {
            $aksi = '';
            
            $rows[$no] = array(
                'NO' => $no,
                'IDTRANS' => $row->IDTRANS,
                'NAMA_PEMASOK' => $row->NAMA_PEMASOK,
                'PERIODE' => $row->PERIODE,
            );
            $no++;
         }

        return array('total' => $total, 'rows' => $rows);
    }

    public function get_id($data) {

        $this->db->select('*');
        $this->db->from('TRANS_HITUNG_HARGA_NR');
        $this->db->where('KODE_PEMASOK', $key);
        $this->db->order_by('PERIODE','ASC');

        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->BLTH] = $row->BLTH;
            }
            return $option;    
        }
    }
    
    public function options_pemasok($key = '', $default = '--Pilih Pemasok--') {
        $option = array();
        $this->db->from('MASTER_PEMASOK');
        $this->db->order_by('REF_NAMA_TRANS, NAMA_PEMASOK');
        if ($key){
            $this->db->where('ID_PEMASOK',$key);    
        } else {
            if (!empty($default)) {
                $option[''] = $default;
            }            
        }
                
        $list = $this->db->get();
        
        foreach ($list->result() as $row) {
            $option[$row->KODE_PEMASOK] = $row->NAMA_PEMASOK;
        }
        $this->db->close();
        return $option;
    }

    public function options_blth($default = '--Pilih BLTH--', $key,$jenis=0) {

        $this->db->select('*');
        $this->db->from('TRANS_HITUNG_HARGA_NR');
        $this->db->where('KODE_PEMASOK', $key);
        $this->db->order_by('PERIODE','ASC');

        if ($jenis==0){
            return $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->BLTH] = $row->BLTH;
            }
            return $option;    
        }
    }

    public function save_as_new($data) {
        $id_trans = $data['BLTH'];
        $user = $this->session->userdata('user_name');
        $query = "CALL ROLLBACK_HARGA_NR('$id_trans','$user')";
        $sql = $this->db->query($query)->row();
        if($sql->KODE == 1) {
            $ret = TRUE;
        } else {
            $ret = FALSE;
        }
        return $ret;
    }

}
