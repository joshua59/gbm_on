<?php
/**
 * @module KONTRAK TRANSPORTIR UNIT
 * @author  BAKTI DWI DHARMA WIJAYA
 * @created at 17 Februari 2019
 * @modified at 17 Maret 2017
 */
class kontrak_trans_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "TRANS_HITUNG_HARGA"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('IDTRANS' => $key);
        }
        return $key;
    }

    public function data_export($data){
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];
        $p_transportir = $data['ID_TRANSPORTIR'];   
        $p_tglawal = $data['TGL_DARI'];   
        $p_tglakhir = $data['TGL_SAMPAI'];           
        $p_cari = $data['kata_kunci'];        
        $p_unit = '';
        if($COCODE == '') {
            if($ID != '') {
               if($ID == '00') {
                    $p_unit == 'All';
               } else {
                  $p_unit = $ID;
               }
            } 
        }
        else if($PLANT == '') {
            $p_unit = $COCODE;
        } else if($STORE_SLOC == '') {
            $p_unit = $PLANT;
        } else if($SLOC == '') {
            $p_unit = $STORE_SLOC;
        } else {
            $p_unit = $SLOC;
        }

        $sql = "call lap_kontrak_trans_unit('$p_unit','$p_transportir','$p_tglawal','$p_tglakhir','$p_cari')";
        $query = $this->db->query($sql)->result();
        $this->db->close();
        return $query;
    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function get_datatables($data){
        $p_unit = $data['p_unit'];
        $p_transportir = $data['p_transportir'];   
        $p_tglawal = $data['p_tglawal'];   
        $p_tglakhir = $data['p_tglakhir'];           
        $p_cari = $data['p_cari'];        
        
        $sql = "call lap_kontrak_trans_unit('$p_unit','$p_transportir','$p_tglawal','$p_tglakhir','$p_cari')";
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
    }

    public function count_all($data){        
        $p_unit = $data['p_unit'];
        $p_transportir = $data['p_transportir'];   
        $p_tglawal = $data['p_tglawal'];   
        $p_tglakhir = $data['p_tglakhir'];           
        $p_cari = $data['p_cari']; 

        $sql = "call lap_kontrak_trans_unit('$p_unit','$p_transportir','$p_tglawal','$p_tglakhir','$p_cari')";
        $query = $this->db->query($sql);
        $this->db->close();
        $row = $query->result_array();

        return count($row);
    }    

    public function options_transportir($default = '--Pilih Transportir--') {
        $this->db->from('MASTER_TRANSPORTIR');
        // $this->db->where('IS_HARGA','1');
        $this->db->order_by('NAMA_TRANSPORTIR ASC');

        $option = array();
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_TRANSPORTIR] = $row->NAMA_TRANSPORTIR;
        }
        $this->db->close();
        return $option;    
    }

    public function get_level($lv='', $key=''){ 
        switch ($lv) {
            case "R":
                $q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_REGIONAL E
                WHERE ID_REGIONAL='$key' ";
                break;
            case "0":
                $q = "SELECT  E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_REGIONAL E
                WHERE ID_REGIONAL='$key' ";
                break;
            case "1":
                $q = "SELECT D.COCODE, D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL 
                FROM MASTER_LEVEL1 D 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE COCODE='$key' ";
                break;
            case "2":
                $q = "SELECT C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL2 C 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE PLANT='$key' ";
                break;
            case "3":
                $q = "SELECT B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL3 B
                LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE STORE_SLOC='$key' ";
                break;
            case "4":
                $q = "SELECT A.SLOC, A.LEVEL4, B.STORE_SLOC, B.LEVEL3, C.PLANT, C.LEVEL2,  D.COCODE,  D.LEVEL1, E.ID_REGIONAL, E.NAMA_REGIONAL
                FROM MASTER_LEVEL4 A
                LEFT JOIN MASTER_LEVEL3 B ON B.STORE_SLOC=A.STORE_SLOC 
                LEFT JOIN MASTER_LEVEL2 C ON C.PLANT=B.PLANT 
                LEFT JOIN MASTER_LEVEL1 D ON D.COCODE=C.COCODE 
                LEFT JOIN MASTER_REGIONAL E ON E.ID_REGIONAL=D.ID_REGIONAL
                WHERE SLOC='$key' ";
                break;
            case "5":
                $q = "SELECT a.LEVEL3, a.STORE_SLOC
                FROM MASTER_LEVEL3 a
                INNER JOIN MASTER_LEVEL2 b ON a.PLANT = b.PLANT
                INNER JOIN MASTER_LEVEL4 c ON a.STORE_SLOC = c.STORE_SLOC AND a.PLANT = c.PLANT
                WHERE c.STATUS_LVL2=1 AND a.PLANT = '$key' ";
                break;
        } 

        $query = $this->db->query($q)->result();
        $this->db->close();
        return $query;
    }

    public function options_reg_array($default = '--Pilih Regional--', $key = 'all') {
        $option = array();
        
        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }   
        $list = $this->db->get(); 

        if ($list->num_rows() > 0) 
        {
            return $list->result_array();
        } 
        else 
        {
            return array();
        }
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

    public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL3');
        $this->db->where('IS_AKTIF_LVL3','1');
        if ($key != 'all'){
            $this->db->where('PLANT',$key);
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
                $option[$row->STORE_SLOC] = $row->LEVEL3;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL4');
        $this->db->where('IS_AKTIF_LVL4','1');
        if ($key != 'all'){
            $this->db->where('STORE_SLOC',$key);
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
                $option[$row->SLOC] = $row->LEVEL4;
            }
            $rest = $option;    
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

    public function options_tahun() {
        $year = date("Y"); 
        $option = array();

        $option[''] = '--Pilih Tahun--';
        $option[$year - 1] = $year - 1;
        $option[$year] = $year;
        $option[$year + 1] = $year + 1;

        return $option;
    }

    public function options_status() {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','STATUS_APPROVE');
        $this->db->order_by("VALUE_SETTING ASC");
        
        $list = $this->db->get(); 
        $option = array();
        $option[''] = '-- Semua --';

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        $this->db->close();
        return $option;    
    }

    public function options_status_kontrak() {
        $option = array();
        $option[''] = '-- Semua --';
        $option['1'] = 'Kontrak Aktif';

        return $option;    
    }  

    public function get_datatables_adendum($p_kode,$p_adendum){
        
        $sql = "call lap_kontrak_trans_unit_detail('$p_kode','$p_adendum')";
        
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();
    }

    public function count_all_adendum($p_kode,$p_adendum){ 
        
        $sql = "call lap_kontrak_trans_unit_detail('$p_kode','$p_adendum')";
        
        $query = $this->db->query($sql)->result_array();
        $this->db->close();
        return count($query);
    }  

    public function get_datatables_adendum_export($data) {
        $p_kode    = $data['p_kode'];
        $p_adendum = $data['p_adendum'];

        $sql = "call lap_kontrak_trans_unit_detail('$p_kode','$p_adendum')";
        
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();       
    } 
 
}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */