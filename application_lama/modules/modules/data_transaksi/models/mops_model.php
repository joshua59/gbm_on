
<?php

 /**
* @module KURS
* @author  RAKHMAT WIJAYANTO
* @created at 07 NOVEMBER 2017
* @modified at 07 OKTOBER 2017
*/ 
class mops_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "MOPS_EXCEL"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_MOPS' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->from($this->_table1);

        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        if ($_POST['STATUS'] !='') {
            $this->db->where("STATUS",$_POST['STATUS']);
        }
        if ($_POST['TGL_DARI'] !='') {
            $this->db->where("TGL_MOPS >= '".$_POST['TGL_DARI']."' ");
        }
        if ($_POST['TGL_SAMPAI'] !='') {
            $this->db->where("TGL_MOPS <= '".$_POST['TGL_SAMPAI']."' ");
        }

        $this->db->order_by('TGL_MOPS DESC');

        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));

        if (!empty($kata_kunci))
            $filter[$this->_table1 . ".NOMINAL LIKE '%{$kata_kunci}%' or JUAL LIKE '%{$kata_kunci}%' or KTBI LIKE '%{$kata_kunci}%' "] = NULL;
        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_MOPS;
            if ($this->laccess->otoritas('edit')) {
            $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            }

            if ($row->STATUS){
                $is_hitung = '<i style="color:green" class="icon-ok"></i>';  
                $aksi = '';  
            } else {
                $is_hitung = '';
            }
            
            $rows[$no] = array(
                'NO' => $no++,
                'TGL_MOPS' => $row->TGL_MOPS,
                'LOWHSD_MOPS' => number_format($row->LOWHSD_MOPS,2,",","."),
                'MIDHSD_MOPS' => number_format($row->MIDHSD_MOPS,2,",","."),
                'LOWMFO_MOPS' => number_format($row->LOWMFO_MOPS,2,",","."),
                'MIDMFO_MOPS' => number_format($row->MIDMFO_MOPS,2,",","."),
                'LOWMFOLSFO_MOPS' => number_format($row->LOWMFOLSFO_MOPS,2,",","."),
                'MIDMFOLSFO_MOPS' => number_format($row->MIDMFOLSFO_MOPS,2,",","."),
                'STATUS' => $is_hitung,
                'aksi' => $aksi

            );
        }

        return array('total' => $total, 'rows' => $rows);
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

    public function insert_batch($data) {
        $this->db->trans_begin();
        $this->db->insert_batch($this->_table1, $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
        
    }

    public function check_tanggal($TGL_MOPS){
        $query = $this->db->get_where($this->_table1, array('TGL_MOPS' => $TGL_MOPS));
       
        if ($query->num_rows() > 0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function check_tanggal_mops($tgk_dari, $tgl_sampai){
        $q = "SELECT count(*) AS ADA FROM MOPS_EXCEL WHERE STATUS = 1 AND TGL_MOPS BETWEEN '$tgk_dari' AND '$tgl_sampai' ";
        
        $query = $this->db->query($q)->row()->ADA;
        $this->db->close();
        return $query;
    }

    public function delete_per_tgl($tgk_dari, $tgl_sampai){
        $q = "DELETE FROM MOPS_EXCEL WHERE STATUS = 0 AND TGL_MOPS BETWEEN '$tgk_dari' AND '$tgl_sampai' ";
        
        $query = $this->db->query($q);
        $this->db->close();
        return $query;
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

    public function get_data($key = '') {
        $this->db->from($this->_table1);

        if ($key['STATUS'] !='') {
            $this->db->where("STATUS",$key['STATUS']);
        }
        if ($key['TGL_DARI'] !='') {
            $this->db->where("TGL_MOPS >= '".$key['TGL_DARI']."' ");
        }
        if ($key['TGL_SAMPAI'] !='') {
            $this->db->where("TGL_MOPS <= '".$key['TGL_SAMPAI']."' ");
        }

        $this->db->order_by('TGL_MOPS DESC');

        return $this->db;
    }


}

?>