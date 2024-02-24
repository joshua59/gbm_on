<?php
    
/**
* @module Master Max Pemakaian
* @author  Aditya
*/
class komponen_alpha_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    private $_table1 = "KOM_ALPHA"; 
    private $_table2 = "DATA_SETTING";
    
    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('IDTRANS' => $key);
        }
        return $key;
    }
    
    public function data($key = '') {
        // $this->db->select("a.NO_PERJANJIAN, a.TGL_AWAL, a.TGL_AKHIR, a.NILAI_KONSTANTA_MFO, a.FK_MOPS, a.VARIABEL_HITUNG, a.PERSEN_HITUNG");
        // $this->db->from($this->_table1 . " as a");

        $this->db->from($this->_table1);
        $this->db->order_by("IS_AKTIF ", "DESC");
        $this->db->order_by("TGL_INSERT", "DESC");
        
        if (!empty($key) || is_array($key))
        $this->db->where_condition($this->_key($key));
        
        return $this->db;
    }
    
    public function save_as_new($data) {
        $this->db->trans_begin();
        $this->db->insert($this->_table1, $data);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            // $this->set_aktif();
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
            // $this->set_aktif();
            return TRUE;
        }
    }

    public function set_aktif() {
        $q = "select * from KOM_ALPHA order by TGL_AKHIR desc, IDTRANS desc limit 1";
        $rest = $this->db->query($q)->result_array();
        if ($rest){
            $id = $rest[0]['IDTRANS'];
            $NILAI_KONSTANTA_MFO = $rest[0]['NILAI_KONSTANTA_MFO'];
            $NILAI_KONSTANTA_HSD = $rest[0]['NILAI_KONSTANTA_HSD'];
            $VARIABEL_HITUNG = $rest[0]['VARIABEL_HITUNG'];     

            if ($id){
                $q = "update KOM_ALPHA set IS_AKTIF=0";
                $rest = $this->db->query($q);

                $q = "update KOM_ALPHA set IS_AKTIF=1 where IDTRANS='$id' ";
                $rest = $this->db->query($q);

                // update data setting
                $q = "update DATA_SETTING set VALUE_SETTING='$VARIABEL_HITUNG' where KEY_SETTING='VARIABEL_HITUNG' AND NAME_SETTING='Variabel hitung' ";
                $rest = $this->db->query($q);

                $q = "update DATA_SETTING set VALUE_SETTING='$NILAI_KONSTANTA_HSD' where KEY_SETTING='KONSTANTA_HITUNG' AND NAME_SETTING='Konstanta HSD' ";
                $rest = $this->db->query($q);

                $q = "update DATA_SETTING set VALUE_SETTING='$NILAI_KONSTANTA_MFO' where KEY_SETTING='KONSTANTA_HITUNG' AND NAME_SETTING='Konstanta MFO' ";
                $rest = $this->db->query($q);
            }
        }
        
        $this->db->close();
        return $rest;
    }

    public function set_aktif_komp_alpha() {
        $q = "select * from KOM_ALPHA 
              where  TGL_AWAL=DATE_FORMAT(now(),'%Y-%m-%d')
              order by TGL_AKHIR desc, IDTRANS desc limit 1";

        $rest = $this->db->query($q)->result_array();
        if ($rest){
            $id = $rest[0]['IDTRANS'];
            $NILAI_KONSTANTA_MFO = $rest[0]['NILAI_KONSTANTA_MFO'];
            $NILAI_KONSTANTA_HSD = $rest[0]['NILAI_KONSTANTA_HSD'];
            $VARIABEL_HITUNG = $rest[0]['VARIABEL_HITUNG'];     

            if ($id){
                $q = "update KOM_ALPHA set IS_AKTIF=0 where IS_AKTIF=1";
                $rest = $this->db->query($q);

                $q = "update KOM_ALPHA set IS_AKTIF=1 where IDTRANS='$id' ";
                $rest = $this->db->query($q);

                // update data setting
                $q = "update DATA_SETTING set VALUE_SETTING='$VARIABEL_HITUNG' where KEY_SETTING='VARIABEL_HITUNG' AND NAME_SETTING='Variabel hitung' ";
                $rest = $this->db->query($q);

                $q = "update DATA_SETTING set VALUE_SETTING='$NILAI_KONSTANTA_HSD' where KEY_SETTING='KONSTANTA_HITUNG' AND NAME_SETTING='Konstanta HSD' ";
                $rest = $this->db->query($q);

                $q = "update DATA_SETTING set VALUE_SETTING='$NILAI_KONSTANTA_MFO' where KEY_SETTING='KONSTANTA_HITUNG' AND NAME_SETTING='Konstanta MFO' ";
                $rest = $this->db->query($q);
            }
        }
        
        $this->db->close();
        return $rest;
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

    public function cek_sudah_hitung($tgldari, $tglsampai){
        $q = "SELECT COUNT(*) JML FROM TRANS_HITUNG_HARGA 
              WHERE DATE_FORMAT(TGLINSERT,'%Y-%m-%d') BETWEEN '$tgldari' AND '$tglsampai' ";
        // print_r($set_where); die;

        $query = $this->db->query($q)->result_array();

        return $query[0]['JML'];
    }

    public function cek_tgl_akhir($tglawal){
        $q = "SELECT COUNT(*) JML FROM KOM_ALPHA 
              WHERE '$tglawal' <= TGL_AKHIR AND IS_AKTIF=1";
        // print_r($set_where); die;

        $query = $this->db->query($q)->result_array();

        return $query[0]['JML'];
    }
    
    public function data_table($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));

        if (!empty($kata_kunci))
            $filter["NO_PERJANJIAN LIKE '%{$kata_kunci}%' OR TGL_AWAL LIKE '%{$kata_kunci}%' OR TGL_AKHIR LIKE '%{$kata_kunci}%'" ] = NULL;        
        
        $total = $this->data($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
        $no=(($offset-1) * $limit) +1;
        $rows = array();
 
        if ($no>10){
            $awal = 1;
        } else {
            $awal = 0;
        }

        foreach ($record->result() as $row) {
            $aksi = '';
            $id = $row->IDTRANS;

            

            $aksi = anchor(null, '<i class="icon-zoom-in" title="Lihat Data"></i>', array('class' => 'btn transparant', 'id' => 'button-view-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit_view/' . $id)));

            if ($row->TGL_AKHIR > date("Y-m-d")){

                if ($this->cek_sudah_hitung($row->TGL_AWAL,$row->TGL_AKHIR)==0){
                    if ($this->laccess->otoritas('edit')) {
                        $aksi .= anchor(null, '<i class="icon-edit" title="Edit Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
                    }

                    if ($this->laccess->otoritas('delete')) {
                        $aksi .= anchor(null, '<i class="icon-trash" title="Hapus Data"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
                    }
                } else if ($awal == 0) {
                    $awal = 1;
                    if ($this->laccess->otoritas('edit')) {
                        $aksi .= anchor(null, '<i class="icon-edit" title="Edit Data"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
                    }

                    if ($this->laccess->otoritas('delete')) {
                        $aksi .= anchor(null, '<i class="icon-trash" title="Hapus Data"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
                    }                    
                }
            }

            

            if ($row->IS_AKTIF){
                $is_status = '<i style="color:green" class="icon-ok"></i>';   
            } else {
                $is_status = '';
            }

            $rows[$no] = array(
            'no' => $no++,
            'NO_PERJANJIAN' => $row->NO_PERJANJIAN,
            'TGL_AWAL' => $row->TGL_AWAL,
            'TGL_AKHIR' => $row->TGL_AKHIR,
            'NILAI_KONSTANTA_MFO' => number_format($row->NILAI_KONSTANTA_MFO,7,',','.'),
            'NILAI_KONSTANTA_HSD' => number_format($row->NILAI_KONSTANTA_HSD,7,',','.'),
            'FK_MOPS' => number_format($row->FK_MOPS,7,',','.'),
            'VARIABEL_HITUNG' => number_format($row->VARIABEL_HITUNG,7,',','.'),
            'PERSEN_HITUNG' => number_format($row->PERSEN_HITUNG,0,',','.'),
            'CD_BY' => $row->CD_BY,
            'TGL_INSERT' => $row->TGL_INSERT,
            // 'UP_BY' => $row->UP_BY,
            // 'UP_DATE' => $row->UP_DATE,
            'IS_AKTIF' => $is_status,
            'aksi' => $aksi
            );
        }
        
        return array('total' => $total, 'rows' => $rows);
    }
    
    public function options(){
        $lvl = $this->session->userdata('level_user');
        $kode = $this->session->userdata('kode_level');
        $option = array(""=> "Pilih Pembangkit");
        $list = $this->db->query("SELECT SLOC, LEVEL4 FROM MASTER_LEVEL4"); 

        foreach ($list->result() as $row) {
            $option[$row->SLOC] = $row->LEVEL4;
        }
        return $option;    
    }
    
    public function options_jnsbbm(){
        $option = array(""=> "Pilih Jenis Bahan Bakar");
        $list = $this->db->query("SELECT ID_JNS_BHN_BKR, NAMA_JNS_BHN_BKR FROM M_JNS_BHN_BKR"); 

        foreach ($list->result() as $row) {
            $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }
        return $option;    
    }
    
}
    
/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */