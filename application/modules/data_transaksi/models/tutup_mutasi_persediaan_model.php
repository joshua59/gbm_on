<?php


/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */
class tutup_mutasi_persediaan_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "TUTUP_MUTASI"; //nama table setelah mom_
    private $_table2 = "TUTUP_MUTASI_LOG";
    private $_table3 = "BUKA_MUTASI";
    private $_table4 = "BUKA_MUTASI_LOG";

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('ID_MUTASI' => $key);
        }
        return $key;
    }
    private function _key_buka($key_buka) { //unit ID
        if (!is_array($key_buka)) {
            $key_buka = array('ID_BUKA_MUTASI' => $key_buka);
        }
        return $key_buka;
    }

    public function data($key = '') {
        $this->db->select('a.*, b.NAME_SETTING');
        $this->db->from($this->_table1.' a');
        $this->db->join('DATA_SETTING b', 'b.VALUE_SETTING = a.STATUS','left');
        $this->db->where('b.KEY_SETTING','STATUS_MUTASI');
        
        if (!empty($key) || is_array($key))
            $this->db->where_condition($this->_key($key));

        $this->db->order_by('BLTH DESC');

        $rest = $this->db;
        $this->db->close();
        return $rest;

    }

    public function data_buka($key_buka = '') {
        $this->db->select('A.*, R.ID_REGIONAL, R.NAMA_REGIONAL, M1.COCODE, M1.LEVEL1, M2.LEVEL2  ');
        $this->db->from($this->_table3. ' A');
        $this->db->join('MASTER_LEVEL2 M2', 'M2.PLANT = A.PLANT','left');
        $this->db->join('MASTER_LEVEL1 M1', 'M1.COCODE = M2.COCODE','left');
        $this->db->join('MASTER_REGIONAL R', 'R.ID_REGIONAL = M1.ID_REGIONAL','left');

        if ($_POST['ID_REGIONAL'] !='') {
            $this->db->where("R.ID_REGIONAL",$_POST['ID_REGIONAL']);   
        }
        if ($_POST['COCODE'] !='') {
            $this->db->where("M1.COCODE",$_POST['COCODE']);   
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("M2.PLANT",$_POST['PLANT']);   
        }
        
        if (!empty($key_buka) || is_array($key_buka))
        $this->db->where_condition($this->_key_buka($key_buka));

        $this->db->order_by('BLTH DESC');
        
        $rest = $this->db;
        $this->db->close();
        return $rest;
    }

    public function save_as_new($data) {
        $this->db->trans_begin();
        $this->db->set_id($this->_table1, 'ID_MUTASI', 'no_prefix', 5);
        $this->db->insert($this->_table1, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }

    public function save_as_new_log($data) {
        $this->db->trans_begin();
        $this->db->set_id($this->_table2, 'ID_MUTASI_LOG', 'no_prefix', 5);
        $this->db->insert($this->_table2, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }

    public function save($data, $key) {
        $this->db->trans_begin();

        $this->db->update($this->_table1, $data, $this->_key($key));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }

    public function save_as_new_buka($data) {
        $this->db->trans_begin();
        $this->db->insert($this->_table3, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }

    public function save_as_new_buka_log($data) {
        $this->db->trans_begin();
        $this->db->set_id($this->_table4, 'ID_BUKA_MUTASI_LOG', 'no_prefix', 10);
        $this->db->insert($this->_table4, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }

    public function save_buka($data, $key_buka) {
        $this->db->trans_begin();

        $this->db->update($this->_table3, $data, $this->_key_buka($key_buka));

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $rest = FALSE;
        } else {
            $this->db->trans_commit();
            $rest = TRUE;
        }
        $this->db->close();
        return $rest;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        $kata_kunci = ''; //$this->laccess->ai($this->input->post('kata_kunci'));
        if (!empty($kata_kunci)){
            $filter[ "A.TGL_TUTUP LIKE '%{$kata_kunci}%'"] = NULL;
        }

        $total = $this->data($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_MUTASI;

            if ($this->laccess->otoritas('edit')) {
            $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            }

            $rows[$id] = array(
                'ID_MUTASI' => $no++,
                'TGL_TUTUP' => $row->TGL_TUTUP,
                'BLTH'=> $row->BLTH,
                'NAME_SETTING'=> $row->NAME_SETTING,
                'aksi' => $aksi
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }

    public function data_table_buka($module = '', $limit = 20, $offset = 1) {
		$filter = array();
        
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));
        if (!empty($kata_kunci)){
            $filter["(M2.LEVEL2 LIKE '%{$kata_kunci}%' OR M1.LEVEL1 LIKE '%{$kata_kunci}%')"]= NULL;
        }

        $total = $this->data_buka($filter)->count_all_results();
		$this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data_buka($filter)->get();
		$no=(($offset-1) * $limit) +1;
        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_BUKA_MUTASI;
            $status='';
            $tgl_tutup=$row->TGL_TUTUP;
            $today= new DateTime();
            $hari_ini=$today->format('Y-m-d');
            if($tgl_tutup>=$hari_ini){
                $status="Buka";
            }else{
                $status="Tutup";
            }

            if ($this->laccess->otoritas('edit')) {
            $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-buka' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit_buka/' . $id)));
            }
            $rows[$id] = array(
                'ID_BUKA_MUTASI' => $no++,
                'STATUS'=>$status,
                'PLANT' => $row->PLANT,
                'LEVEL2' => $row->LEVEL2,
                'LEVEL1' => $row->LEVEL1,
                'NAMA_REGIONAL' => $row->NAMA_REGIONAL,
                'TGL_BUKA' => $row->TGL_BUKA,
                'TGL_TUTUP'=> $row->TGL_TUTUP,
                'BLTH'=> $row->BLTH,
                'aksi' => $aksi
            );
        }

        return array('total' => $total, 'rows' => $rows);
    }


    public function options_status_mutasi($default = 'TUTUP') {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','STATUS_MUTASI');
        $option = array();
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

    public function options_status_mutasi_buka($default = 'BUKA') {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','STATUS_MUTASI');
        $option = array();
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
        $this->db->close();
        return $option;
    }

    public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->COCODE] = $row->LEVEL1;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL2');
        $this->db->where('IS_AKTIF_LVL2','1');
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->PLANT] = $row->LEVEL2;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function options_blth($blth='', $default = '--Pilih BLTH') {
        $q = "SELECT DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH,'%Y%m') BLTH UNION
              SELECT DATE_FORMAT(CURDATE() - INTERVAL 2 MONTH,'%Y%m') BLTH UNION
              SELECT DATE_FORMAT(CURDATE() - INTERVAL 3 MONTH,'%Y%m') BLTH UNION
              SELECT DATE_FORMAT(CURDATE() - INTERVAL 4 MONTH,'%Y%m') BLTH UNION
              SELECT DATE_FORMAT(CURDATE() - INTERVAL 5 MONTH,'%Y%m') BLTH UNION
              SELECT DATE_FORMAT(CURDATE() - INTERVAL 6 MONTH,'%Y%m') BLTH";

        $list = $this->db->query($q);

        // $this->db->from('TUTUP_MUTASI');
        // $option = array();
        // $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->BLTH] = $row->BLTH;
        }

        if ($blth){
            $option[$blth] = $blth;
        }
        
        $this->db->close();
        return $option;
    }

    public function cek_periode($btlh=''){ 
        $q = "select BLTH from TUTUP_MUTASI where BLTH='$btlh'";

        $query = $this->db->query($q);
        
        if ($query->num_rows() > 0) {            
            $rest = TRUE;
        } else {
            $rest = FALSE;
        }

        $this->db->close();
        return $rest;
    }

    public function cek_buka_mutasi($btlh='',$plant='', $id='x'){ 
        $q = "select * from BUKA_MUTASI a
              left join MASTER_LEVEL2 b on b.PLANT=a.PLANT   
              where a.BLTH='$btlh' and a.PLANT='$plant' and a.ID_BUKA_MUTASI !='$id' ";

        $query = $this->db->query($q);
        
        if ($query->num_rows() > 0) {   
            foreach ($query->result() as $row) {
                $rest = $row->LEVEL2;
            }                 
            // $rest = TRUE;
        } else {
            $rest = FALSE;
        }

        $this->db->close();
        return $rest;
    }

    public function options_bulan() {
        $option = array();
        $option[''] = '--Pilih Bulan--';
        $option['01'] = 'Januari';
        $option['02'] = 'Februari';
        $option['03'] = 'Maret';
        $option['04'] = 'April';
        $option['05'] = 'Mei';
        $option['06'] = 'Juni';
        $option['07'] = 'Juli';
        $option['08'] = 'Agustus';
        $option['09'] = 'September';
        $option['10'] = 'Oktober';
        $option['11'] = 'November';
        $option['12'] = 'Desember';
        return $option;
    }

    public function options_tahun () {

        $data = array();
        for($i = 2016; $i <= date('Y');$i++) {
            $data[$i] = $i; 
        }
        return $data;
    }
	 


}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */