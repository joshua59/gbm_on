<?php

/**
 * @module DASHBOARD
 * @author  RAKHMAT WIJAYANTO
 * @created at 10 NOVEMBER 2017
 * @modified at 10 NOVEMBER 2017
 */
class grafik_coq_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "DUMMY_GRAFIK"; //nama table setelah mom_
 
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
        return $option;
    }

    public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }
        if ($jenis==0){
            return $this->db->get()->result();
        } else {
            $option = array();
            $list = $this->db->get();

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->COCODE] = $row->LEVEL1;
            }
            return $option;
        }
    }

    public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL2');
        $this->db->where('IS_AKTIF_LVL2','1');
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
        }
        if ($jenis==0){
            return $this->db->get()->result();
        } else {
            $option = array();
            $list = $this->db->get();

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->PLANT] = $row->LEVEL2;
            }
            return $option;
        }
    }

    public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL3');
        $this->db->where('IS_AKTIF_LVL3','1');
        if ($key != 'all'){
            $this->db->where('PLANT',$key);
        }
        if ($jenis==0){
            return $this->db->get()->result();
        } else {
            $option = array();
            $list = $this->db->get();

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->STORE_SLOC] = $row->LEVEL3;
            }
            return $option;
        }
    }

    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL4');
        $this->db->where('IS_AKTIF_LVL4','1');
        if ($key != 'all'){
            $this->db->where('STORE_SLOC',$key);
        }
        if ($jenis==0){
            return $this->db->get()->result();
        } else {
            $option = array();
            $list = $this->db->get();

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->SLOC] = $row->LEVEL4;
            }
            return $option;
        }
    }

    public function options_jenis_bahan_bakar($default = '-- Pilih Jenis Bahan Bakar --'){

        $option = array();
        
        $query = $this->db->query("
            SELECT * FROM (
                SELECT ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR FROM M_JNS_BHN_BKR
                WHERE ID_JNS_BHN_BKR NOT IN (004,005,003)
                UNION ALL
                SELECT KODE_JNS_BHN_BKR AS ID_JNS_BHN_BKR,NAMA_JNS_BHN_BKR FROM M_GROUP_JNS_BBM
            ) A 
            ORDER BY A.NAMA_JNS_BHN_BKR ASC
            
        ")->result();
        $option[''] = $default;
        foreach ($query as $row) {
                $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }
        $rest = $option; 
        return $rest;
    }

    public function get_bulan($BULAN) {

        $sql = "SELECT * FROM REF_BULAN WHERE BULAN = $BULAN";
        $query = $this->db->query($sql)->row();
        return $query->NAMA;
        
    }

    public function options_coq($default = '--Pilih Jenis Parameter--', $key = 'all') {
        $option = array();
        $query = "SELECT A.ID_MCOQ ,A.PRMETER_MCOQ,B.NO_VERSION ,C.PARAMETER_ANALISA FROM MASTER_COQ A LEFT JOIN MASTER_VCOQ B ON A.ID_VERSION = B.ID_VERSION LEFT JOIN MASTER_PARAMETER C ON A.PRMETER_MCOQ = C.ID_PARAMETER "; 

        if($key == 301 || $key == 302 || $key == 303 || $key == 304) {
            $query.= "WHERE A.ID_KOMPONEN_BBM = $key";
        } else {
            $query.= "WHERE A.ID_JNS_BHN_BKR = $key";
        }
        $query.= " AND A.ID_MCOQ IN (SELECT DISTINCT(C.ID_MCOQ) FROM TRANS_COQ_RESULT C) ";
        $list = $this->db->query($query)->result();

        return $list;
    }

    public function set_min_max($id) {

        $sql = "
                SELECT 
                CASE WHEN BATAS_MIN IS NULL THEN '' ELSE BATAS_MIN END AS BATAS_MIN,
                CASE WHEN BATAS_MAX IS NULL THEN '' ELSE BATAS_MAX END AS BATAS_MAX
                FROM MASTER_COQ
                WHERE ID_MCOQ = $id";
        $res = $this->db->query($sql);  
        return $res->result();
    }

    public function set_min_max_export($id) {
        
        $this->db->select('*');
        $this->db->from('MASTER_COQ');
        $this->db->where('ID_MCOQ',$id);
        $res = $this->db->get();
        return $res->row();
    }

    function set_parameter($id,$bln,$thn,$id_pemasok,$id_depo) {
        $sql = "CALL GRAFIK_COQ('$id','$bln','$thn','$id_pemasok','$id_depo')";
        $res = $this->db->query($sql);  
        $this->db->close();
        return $res->result_array();
    }

    function set_nilai_parameter($id,$bln,$thn,$id_pemasok,$id_depo) {
        $sql = "CALL GRAF_COQ_COUNT('$id','$bln','$thn','$id_pemasok','$id_depo')";
        $res = $this->db->query($sql);
        return $res->result_array();
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

    public function get_satuan($id) {
        $query = "SELECT SATUAN FROM MASTER_COQ WHERE ID_MCOQ = $id";
        $res = $this->db->query($query)->row();
        return $res->SATUAN;
    }

    function next_result() {
        if (is_object($this->conn_id)) {
            return mysqli_next_result($this->conn_id);
        }
    }

    public function get_tipe_grafik($id) {

        $sql = "SELECT A.TIPE,A.ID_PARAMETER FROM MASTER_PARAMETER A LEFT JOIN MASTER_COQ B ON A.ID_PARAMETER = B.PRMETER_MCOQ
                WHERE B.ID_MCOQ = $id";
        $query = $this->db->query($sql)->row();
        return $query;
    }

    public function options_pemasok($default = '--Pilih Pemasok--') {
        $this->db->from('MASTER_PEMASOK');
        $this->db->where('ISAKTIF_PEMASOK','1');
        $this->db->order_by('NAMA_PEMASOK','ASC');

        $option = array();
        $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_PEMASOK] = $row->NAMA_PEMASOK;
        }
        $this->db->close();
        return $option;
    }

    public function get_depo_by_pemasok($default = '--Pilih Depo--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_DEPO');
        $this->db->where('ISAKTIF_DEPO','1');
        
        if ($key != 'all'){
            $this->db->where('ID_PEMASOK',$key);
        }    
        $this->db->order_by('NAMA_DEPO','ASC');

        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->ID_DEPO] = $row->NAMA_DEPO;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }
    
}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */
