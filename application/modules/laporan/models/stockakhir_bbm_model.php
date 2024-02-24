<?php

/**
 * @module DASHBOARD
 * @author  RAKHMAT WIJAYANTO
 * @created at 10 NOVEMBER 2017
 * @modified at 10 NOVEMBER 2017
 */
class stockakhir_bbm_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "DUMMY_GRAFIK"; //nama table setelah mom_
    private $_tablePersediaanBBM = "REKAP_MUTASI_PERSEDIAAN";

    public function options_reg($default = '--Pilih Regional--', $key = 'all') {
        $option = array();

        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }
        $this->db->order_by('NAMA_REGIONAL','ASC');
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
        $this->db->order_by('LEVEL1','ASC');
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

    public function exportList() {

        $sql = "call lap_stock_akhir('$vjns_bbm','$vtgl' ,'$vlevel','$vlevelid','$vcari')"; 
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL2');
        $this->db->where('IS_AKTIF_LVL2','1');
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
        }
        $this->db->order_by('LEVEL2','ASC');
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
        $this->db->order_by('LEVEL3','ASC');
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
        $this->db->order_by('LEVEL4','ASC');
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
        $y_min_satu = $year - 1;
        $y_min_dua = $y_min_satu - 1;

        $option[$y_min_dua] = $y_min_dua;
        $option[$y_min_satu] = $y_min_satu;
        $option[$year] = $year;

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
        return $query;
    }

    public function option_jenisbbm($default = '--Pilih Jenis BBM--'){
        $this->db->from('M_JNS_BHN_BKR');
        $this->db->where('ID_JNS_BHN_BKR != 003');
        $this->db->order_by('ID_JNS_BHN_BKR ASC');

        $list = $this->db->get();
        return $list->result();
    }   

    public function get_stockakhir($data) {

        $vjns_bbm = '%'.$data['vjns_bbm'];
        $vtgl = $data['vtgl'];
        $vlevel = $data['vlevel'];
        $vlevelid = $data['vlevelid'];
        $cari = $data['CARI'];
        if($cari == '') {
            $vcari = '%';
        } else {
            $vcari = '%'.$cari.'%';
        }

        $sql = "call lap_stock_akhir('$vjns_bbm','$vtgl' ,'$vlevel','$vlevelid','$vcari')";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_stockakhir_cetak($data) {

        $vjns_bbm = '%'.$data['vjns_bbm'];
        $vtgl = $data['vtgl'];
        $vlevel = $data['vlevel'];
        $vlevelid = $data['vlevelid'];
        $cari = $data['CARI'];
        if($cari == '') {
            $vcari = '%';
        } else {
            $vcari = '%'.$cari.'%';
        }

        $sql = "call lap_stock_akhir('$vjns_bbm','$vtgl' ,'$vlevel','$vlevelid','$vcari')";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function get_bulan($BULAN) {

        $sql = "SELECT * FROM REF_BULAN WHERE BULAN = $BULAN";
        $query = $this->db->query($sql)->row();
        return $query->NAMA;
        
    }



}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */
