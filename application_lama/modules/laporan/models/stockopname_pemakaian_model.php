<?php

class stockopname_pemakaian_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_data($data) {

        $periode_awal = $data['periode_awal'];
        $periode_akhir = $data['periode_akhir'];
        $query = "SELECT * 
                  FROM  STOCK_OPNAME 
                  WHERE ID_STOCKOPNAME IN('$periode_akhir','$periode_awal')
                  ORDER BY TGL_PENGAKUAN 
                  LIMIT 2";
        $res = $this->db->query($query)->result();
        return $res;
    }

    public function get_pemakaian($data) {
        
        $sloc  = $data['SLOC'];
        $date1 = $data['TGL_AWAL'];
        $date2 = $data['TGL_AKHIR'];
        $bbm = $data['BBM'];
        $TOTAL_PEMAKAIAN = $data['TOTAL_PEMAKAIAN'];
        $NILAI_STOK_BA = $data['NILAI_STOK_BA'];

        $query = "SELECT A.TGL_MUTASI_PENGAKUAN,A.VOLUME_PEMAKAIAN,(A.VOLUME_PEMAKAIAN / $TOTAL_PEMAKAIAN) * $NILAI_STOK_BA AS VOLUME_PENYESUAIAN
                  FROM MUTASI_PEMAKAIAN A 
                  WHERE ( A.TGL_MUTASI_PENGAKUAN BETWEEN '$date1' AND '$date2' ) 
                  AND A.SLOC = $sloc AND A.JENIS_PEMAKAIAN = 1 AND A.STATUS_MUTASI_PEMAKAIAN IN (2,6) AND ID_JNS_BHN_BKR = '$bbm'
                  ORDER BY A.TGL_MUTASI_PENGAKUAN";
        $sql = $this->db->query($query);
        return $sql->result_array();
    }

    public function get_pemakaian_excel($data) {
        
        $sloc  = $data['SLOC'];
        $date1 = $data['TGL_AWAL'];
        $date2 = $data['TGL_AKHIR'];
        $bbm = $data['BBM'];

        $query = "SELECT A.TGL_MUTASI_PENGAKUAN,A.VOLUME_PEMAKAIAN
                  FROM MUTASI_PEMAKAIAN A 
                  WHERE ( A.TGL_MUTASI_PENGAKUAN BETWEEN '$date1' AND '$date2' ) 
                  AND A.SLOC = $sloc AND A.JENIS_PEMAKAIAN = 1 AND A.STATUS_MUTASI_PEMAKAIAN IN (2,6) AND ID_JNS_BHN_BKR = '$bbm'
                  ORDER BY A.TGL_MUTASI_PENGAKUAN";
        $sql = $this->db->query($query);
        return $sql->result_array();
    }

    public function get_pemakaian_total($data) {
        
        $sloc  = $data['SLOC'];
        $date1 = $data['TGL_AWAL'];
        $date2 = $data['TGL_AKHIR'];
        $bbm = $data['BBM'];

        $query = "SELECT SUM(VOLUME_PEMAKAIAN) AS TOTAL_PEMAKAIAN
                  FROM MUTASI_PEMAKAIAN A 
                  WHERE ( A.TGL_MUTASI_PENGAKUAN BETWEEN '$date1' AND '$date2' ) 
                  AND A.SLOC = $sloc AND A.JENIS_PEMAKAIAN = 1 AND A.STATUS_MUTASI_PEMAKAIAN IN (2,6) AND ID_JNS_BHN_BKR = '$bbm'";
        $res = $this->db->query($query)->result();
        return $res;
    }

    public function get_volume_terima($data) {
        
        $sloc  = $data['SLOC'];
        $date1 = $data['TGL_AWAL'];
        $date2 = $data['TGL_AKHIR'];
        $bbm = $data['BBM'];

        $query = "SELECT SUM(VOL_TERIMA_REAL) AS VOLUME_TERIMA
                  FROM MUTASI_PENERIMAAN 
                  WHERE TGL_PENGAKUAN BETWEEN '$date1' AND '$date2'
                  AND SLOC = $sloc AND STATUS_MUTASI_TERIMA IN(2,6) AND JNS_PENERIMAAN IN (1,2) AND ID_JNS_BHN_BKR = '$bbm'";
        $sql = $this->db->query($query);
        return $sql->result_array();
    }

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

    public function options_periode($default = '--Pilih Periode--', $key = 'all', $val2 = 'all', $val3 = 'all',$val4 = 'all', $jenis=0) {
        $this->db->from('STOCK_OPNAME');
        if ($key != 'all'){
            $this->db->where('SLOC',$key);
            $this->db->where('ID_JNS_BHN_BKR',$val4);
            $this->db->where('TGL_PENGAKUAN >=', $val2);
            $this->db->where('TGL_PENGAKUAN <=', $val3);
            $this->db->where('STATUS_APPROVE_STOCKOPNAME IN(2,6)');
        }
        $this->db->order_by('SLOC','ASC');
        if ($jenis==0){
            return $this->db->get()->result();

        } else {
            $option = array();
            $list = $this->db->get();

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->SLOC] = $row->LEVEL4." - ".$row->LEVEL4;
            }
            return $option;
        }
    }

    public function get_periode_akhir($data) {

        $id = $data['id_stockopname'];
        $sloc = $data['sloc'];
        $tgl_awal = $data['tgl_awal'];
        $tgl_akhir = $data['tgl_akhir'];
        $bbm = $data['bbm'];
        // $query2 = "select * from foo where id = (select max(id) from foo where id < 4)"
        $query = "SELECT * FROM (
                        SELECT *  FROM STOCK_OPNAME 
                        WHERE 
                        -- ( TGL_PENGAKUAN BETWEEN '$tgl_awal' AND '$tgl_akhir' ) AND 
                        SLOC = '$sloc' AND ID_JNS_BHN_BKR = '$bbm'
                        ORDER BY SLOC, TGL_PENGAKUAN
                   ) B WHERE B.ID_STOCKOPNAME < '$id' ORDER BY B.ID_STOCKOPNAME DESC LIMIT 1
                    ";
        $return = $this->db->query($query);
        return $return->result();
    }

    public function options_jenis_bahan_bakar($default = '-- Pilih Jenis Bahan Bakar --'){

        $option = array();
        
        $this->db->select('*');
        $this->db->from('M_JNS_BHN_BKR');
        $query = $this->db->get();
        $option[''] = $default;
        foreach ($query->result() as $row) {
            $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }
        $rest = $option; 
        return $rest;
    }

    public function get_data_unit($sloc){
        $sql = "CALL GET_UNIT('$sloc')";
        // print_r($sql); die;
        $query = $this->db->query($sql);
        return $query->result();
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


}