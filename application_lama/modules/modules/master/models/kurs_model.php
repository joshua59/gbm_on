<?php

 /**
* @module KURS
* @author  RAKHMAT WIJAYANTO
* @created at 07 NOVEMBER 2017
* @modified at 07 OKTOBER 2017
*/ 
class kurs_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "KURS"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_KURS' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->from($this->_table1);

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        $this->db->order_by('TGL_KURS DESC');

        return $this->db;
    }

    function check_tanggal($TGL_KURS){
        $query = $this->db->get_where($this->_table1, array('TGL_KURS' => $TGL_KURS));
       
        if ($query->num_rows() > 0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
     }

    public function save_as_new($data) {
        $this->db->trans_begin();
        // $this->db->set_id($this->_table1, 'ID_WILAYAH', 'no_prefix', 3);
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

    public function data_table($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));

        if (!empty($kata_kunci))
            $filter[$this->_table1 . ".TGL_KURS LIKE '%{$kata_kunci}%' or KTBI LIKE '%{$kata_kunci}%' or CD_BY_KURS LIKE '%{$kata_kunci}%' "] = NULL;
        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();

		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_KURS;
            $aksi = '';
            if ($this->laccess->otoritas('edit')) {
                $aksi .= anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            }
            if ($this->laccess->otoritas('delete')) {
                $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
            }
            $rows[$no] = array(
                'ID_KURS' => $no++,
                'TGL_KURS' => $row->TGL_KURS,
                'KTBI' => number_format($row->KTBI,2,",","."),
                'UPDATE_KTBI' => $row->UPDATE_KTBI,
                'CD_BY_KURS' => $row->CD_BY_KURS,
                'aksi' => $aksi
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }

    public function generate_id_kurs() {
        
        $query = $this->db->query('SELECT (MAX(ID_KURS) + 1) as ID_KURS FROM KURS')->row();
        $result = $query->ID_KURS;

        return $result;
    }
	 

}

?>