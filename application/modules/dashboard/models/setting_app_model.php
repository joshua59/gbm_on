<?php
/**
 * @module dashboard
 * @author  CF
 * @created at 17 November 2017
 * @modified at 17 November 2017
 */
class setting_app_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "SETTING_APP"; //nama table setelah mom_
    private $_table2 = "FAQ"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->from($this->_table2);

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        return $this->db;
    }

    public function data_upload(){
        $this->db->from('SETTING_APP');

        $rest = $this->db->get()->row();
        $this->db->close();
        return $rest;
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

    public function save_as_new_faq($data) {
        $this->db->trans_begin();
        $this->db->insert($this->_table2, $data);

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

    public function save_faq($data, $key) {
        $this->db->trans_begin();

        $this->db->update($this->_table2, $data, $this->_key($key));

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

    public function delete_faq($key) {
        $this->db->trans_begin();

        $this->db->delete($this->_table2, $this->_key($key));

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
            $filter["JUDUL LIKE '%{$kata_kunci}%' OR KETERANGAN LIKE '%{$kata_kunci}%'" ] = NULL;
            $total = $this->data($filter)->count_all_results();
            $this->db->limit($limit, ($offset * $limit) - $limit);
            $record = $this->data($filter)->get();

            $rows = array();

            $no=(($offset-1) * $limit) +1;
           
            foreach ($record->result() as $row) {
                $id = $row->ID;
                $aksi = '';
                // if ($this->laccess->otoritas('edit')) {
                    $aksi .= anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
                // }
                // if ($this->laccess->otoritas('delete')) {
                    $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
                // }
                $rows[$no] = array(
                    'NO' => $no,
                    'JUDUL' => $row->JUDUL,
                    'KETERANGAN' => $row->KETERANGAN,
                    'URUTAN' => $row->URUTAN,
                    'aksi' => $aksi
                );
                $no++;
             }

        return array('total' => $total, 'rows' => $rows);
    }

    public function get_faq() {
        $cari = $this->laccess->ai($this->input->post('kata_kunci'));

        $this->db->from($this->_table2);
        $this->db->where("JUDUL like '%$cari%' OR KETERANGAN like '%$cari%'");
        $this->db->order_by('URUTAN ASC');

        $query = $this->db->get();
        $this->db->close();
        return $query->result();  
    }

    public function get_max() {
        $sql = "SELECT MAX(URUTAN)+1 AS URUTAN FROM FAQ";
        $result = $this->db->query($sql)->row();
        return $result;  
    }
}

/* End of file master_level1_model.php */
/* Location: ./application/modules/unit/models/master_level1_model.php */