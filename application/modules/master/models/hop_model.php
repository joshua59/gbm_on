<?php
/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class hop_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "MASTER_HOP"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->from($this->_table1);

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        // $this->db->order_by('URUTAN', 'ASC');

        return $this->db;
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

    // public function delete($key) {
    //     $this->db->trans_begin();

    //     $this->db->delete($this->_table1, $this->_key($key));

    //     if ($this->db->trans_status() === FALSE) {
    //         $this->db->trans_rollback();
    //         return FALSE;
    //     } else {
    //         $this->db->trans_commit();
    //         return TRUE;
    //     }
    // }

    public function data_table($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));

        if (!empty($kata_kunci))
        $filter[$this->_table1 . ".BASIC_HOP LIKE '%{$kata_kunci}%'"] = NULL;
        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID;
            $aksi ='';
            
            if ($this->laccess->otoritas('view')) {
                $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-original-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/add_view/' . $id)));
            }

            if ($this->laccess->otoritas('edit')) {
                $aksi .= anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            }

            $rows[$no] = array(
                'NO' => $no,
                'DASAR_HOP' => $row->BASIC_HOP,
                'MERAH' => $row->FROM_DAY_RED,
                'KUNING' => $row->FROM_DAY_YELLOW,
                'HIJAU' => $row->FROM_DAY_GREEN,
                'BIRU' => $row->FROM_DAY_BLUE,
                // 'HIJAU' => $row->FROM_DAY_GREEN . $row->PARAM_GREEN . $row->TO_DAY_GREEN,
                'TGL_BERLAKU' => $row->EFFECTIVE_DATE,
                'KETERANGAN' => $row->DESCRIPTION,
                'aksi' => $aksi
            );
            $no++;
        }

        return array('total' => $total, 'rows' => $rows);
    }

    // public function get_max() {
    //     $sql = "SELECT MAX(URUTAN)+1 AS URUTAN FROM BERITA";
    //     $result = $this->db->query($sql)->row();
    //     return $result;  
    // }

}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */