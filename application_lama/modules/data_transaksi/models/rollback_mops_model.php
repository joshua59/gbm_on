<?php

class rollback_mops_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function data($key = '') {
        $this->db->select('*');
        $this->db->from('MOPS_EXCEL');
        $this->db->where('status',0);

        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));
        $total = $this->data()->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);   
        $record = $this->data()->get();

        $rows = array();

        $no=(($offset-1) * $limit) +1;
       
        foreach ($record->result() as $row) {
            $aksi = '';
            
            $rows[$no] = array(
                'NO' => $no,
                'LOWHSD_MOPS' => !empty($row->LOWHSD_MOPS) ? $row->LOWHSD_MOPS : '-'  , 
                'MIDHSD_MOPS' => !empty($row->MIDHSD_MOPS) ? $row->MIDHSD_MOPS : '-'  , 
                'LOWMFO_MOPS' => !empty($row->LOWMFO_MOPS) ? $row->LOWMFO_MOPS : '-'  , 
                'MIDMFO_MOPS' => !empty($row->MIDMFO_MOPS) ? $row->MIDMFO_MOPS : '-'  , 
                'TGL_MOPS' => $row->TGL_MOPS
            );
            $no++;
         }

        return array('total' => $total, 'rows' => $rows);
    }

    public function save_as_new($data) {
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $user = $this->session->userdata('user_name');
        $query = "CALL rollback_mops('$tgl_awal','$tgl_akhir','$user')";

        $sql = $this->db->query($query)->row();
        
        return $sql;
    }

}
