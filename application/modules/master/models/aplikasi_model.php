<?php
/**
 * @module MASTER
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class aplikasi_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "APLIKASI"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_VERSI' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->select('*');
        $this->db->from($this->_table1);

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        $this->db->order_by('NAMA_VERSI', 'ASC');

        return $this->db;
    }

    function check_nama($id_co){
        $query = $this->db->get_where($this->_table1, array('NAMA_VERSI' => $id_co));
       
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
            $filter["NAMA_VERSI LIKE '%{$kata_kunci}%' OR KET LIKE '%{$kata_kunci}%' OR PIC LIKE '%{$kata_kunci}%'" ] = NULL;
            $total = $this->data($filter)->count_all_results();
            $this->db->limit($limit, ($offset * $limit) - $limit);
            $record = $this->data($filter)->get();

            $rows = array();

            $no=(($offset-1) * $limit) +1;
           
            foreach ($record->result() as $row) {
                $id = $row->ID_VERSI;
                $aksi = '';
                if ($this->laccess->otoritas('edit')) {
                    $aksi .= anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
                }
                if ($this->laccess->otoritas('delete')) {
                    $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
                }
                $rows[$no] = array(
                    'NO' => $no,
                    'NAMA_VERSI' => $row->NAMA_VERSI,
                    'KET' => $row->KET,
                    'PIC' => $row->PIC,
                    'TANGGAL' => $row->TANGGAL,
                    'aksi' => $aksi
                );
                $no++;
             }

        return array('total' => $total, 'rows' => $rows);
    }
}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */