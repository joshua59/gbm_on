<?php

/**
 * @module DASHBOARD
 * @author  RAKHMAT WIJAYANTO
 * @created at 10 NOVEMBER 2017
 * @modified at 10 NOVEMBER 2017
 */
class helpdesk_model extends CI_Model {

    private $_table1 = "LOG_ROLLBACK"; //nama table setelah mom_
    private $_key = "ID_ROLLBACK";

    public function __construct() {
        parent::__construct();
    }

    public function data($key = '') {

        $this->db->select('A.*,B.LEVEL4,C.LEVEL3,D.LEVEL2,E.LEVEL1,F.NAMA_REGIONAL,G.NAMA_JNS_BHN_BKR,H.NAME_SETTING');
        $this->db->from($this->_table1.' A');
        $this->db->join('MASTER_LEVEL4 B' ,'A.SLOC = B.SLOC','left');
        $this->db->join('MASTER_LEVEL3 C' ,'B.STORE_SLOC = C.STORE_SLOC','left');
        $this->db->join('MASTER_LEVEL2 D' ,'C.PLANT = D.PLANT','left');
        $this->db->join('MASTER_LEVEL1 E' ,'D.COCODE = E.COCODE','left');
        $this->db->join('MASTER_REGIONAL F' ,'E.ID_REGIONAL = F.ID_REGIONAL','left');
        $this->db->join('M_JNS_BHN_BKR G' ,'A.ID_JNS_BHN_BKR = G.ID_JNS_BHN_BKR','left');
        $this->db->join('DATA_SETTING H' ,'A.JNS_TRX = H.VALUE_SETTING AND H.KEY_SETTING = "JENIS_TRANSAKSI"','left');
        if ($_POST['ID_REGIONAL'] !='') {
            $this->db->where('F.ID_REGIONAL',$_POST['ID_REGIONAL']);
        }
        if ($_POST['COCODE'] !='') {
            $this->db->where("E.COCODE",$_POST['COCODE']);
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("D.PLANT",$_POST['PLANT']);
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->where("C.STORE_SLOC",$_POST['STORE_SLOC']);
        }
        if ($_POST['SLOC'] !='') {
            $this->db->where("B.SLOC",$_POST['SLOC']);
        }
        return $this->db;
    }

    public function data_table($module = '', $limit = 20, $offset = 1) {
        $filter = array();
        $filter[$this->_table1] = NULL;
        $total = $this->data($filter)->count_all_results();
        $this->db->limit($limit, ($offset * $limit) - $limit);
        $record = $this->data($filter)->get();
        $no = (($offset-1) * $limit) +1;

        $rows = array();
        foreach ($record->result() as $row) {
            $id = $row->ID_ROLLBACK;
            if ($this->laccess->otoritas('edit')) {
            $aksi = anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($module . '/edit/' . $id)));
            }

            if ($this->laccess->otoritas('delete')) {
            $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'delete_row(this.id)', 'data-source' => base_url($module . '/delete/' . $id)));
            }
            $rows[$id] = array(
                'LEVEL1' => $row->LEVEL1,
                'LEVEL2' => $row->LEVEL2,
                'LEVEL3' => $row->LEVEL3,
                'LEVEL4' => $row->LEVEL4,
                'JNS_TRX' => $row->NAME_SETTING,
                'NO_TRX' => $row->NO_TRX,
                'TGL_PENGAKUAN' => $row->TGL_PENGAKUAN,
                'ID_JNS_BHN_BKR' => $row->NAMA_JNS_BHN_BKR,
                'ALASAN' => $row->KETERANGAN,
                'TU_JNS_TRX' => $row->NAME_SETTING,
                'TU_NO_TRX' => $row->NO_TRX,
                'TU_TGL_PENGAKUAN' => $row->TGL_PENGAKUAN,  
            );
        }

        return array('total' => $total, 'rows' => $rows);
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

    public function options_lv4_all($key = 0) {
        $sql = "CALL GET_UNIT_ALL('$key')";
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

    public function get_data_unit($sloc){
        $sql = "CALL GET_UNIT('$sloc')";
        // print_r($sql); die;
        $query = $this->db->query($sql);
        return $query->result();
    } 

    public function options_bbm($default = '-- Pilih Jenis Bahan Bakar --', $key = 'all') {
        $option = array();

        $this->db->from('M_JNS_BHN_BKR');
        // $this->db->where('ID_JNS_BHN_BKR !=','003');
        if ($key != 'all'){
            $this->db->where('ID_JNS_BHN_BKR',$key);
        }
        $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }
        return $option;
    } 

    public function options_trans($default = '-- Pilih Jenis Transaksi --', $key = 'all') {
        $option = array();

        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING =','JENIS_TRANSAKSI');

        $list = $this->db->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        return $option;
    } 

    public function rollback($data) {

        $p_sloc = $data['SLOC'];
        $p_jns_trx = $data['JNS_TRX'];
        $p_no_trx = $data['NO_TRX'];
        $p_jnsbbm = $data['ID_JNS_BHN_BKR'];
        $p_tgl_pengakuan = $data['TGL_PENGAKUAN'];
        $p_create_by = $data['CREATE_ROLLBACK'];
        $p_ket = $data['ALASAN'];
        $sql = "CALL PROSES_ROLLBACK('$p_sloc', '$p_jns_trx', '$p_no_trx', '$p_jnsbbm', '$p_tgl_pengakuan', '$p_create_by','$p_ket')";
        $query = $this->db->query($sql)->row();
        return $query;
    }


}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */
