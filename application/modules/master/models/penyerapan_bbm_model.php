<?php
/**
 * @module KURS
 * @author  BAKTI DWI DHARMA WIJAYA
 * @created at 03 JANUARI 2019
 * @modified at 03 JANUARI 2019
 */
class penyerapan_bbm_model extends CI_Model

{
    function __construct()
    {
        parent::__construct();
    }

    private $_primaryKey = "ID_PENYERAPAN";
    private $_table1     = "MASTER_PENYERAPANBBM";

    function data($value)
    {
        $this->db->select('*');
        $this->db->from($this->_table1 . ' as a');
        $this->db->join('MASTER_PEMASOK as d', 'a.ID_PEMASOK = d.ID_PEMASOK', 'left');
        $this->db->join('MASTER_LEVEL1 as h', 'a.COCODE = h.COCODE', 'left');
        $this->db->join('MASTER_REGIONAL as i', 'h.ID_REGIONAL = i.ID_REGIONAL', 'left');

        if ($value['ID_REGIONAL'] != '') {
            $this->db->where('i.ID_REGIONAL', $value['ID_REGIONAL']);
        }

        if ($value['COCODE'] != '') {
            $this->db->where("h.COCODE", $value['COCODE']);
        }
        
        if($value['SKEMA_PENYERAPAN'] == 'All') {
            $this->db->where("a.SKEMA_PENYERAPAN >=",  date('Y') - 1);
            $this->db->where("a.SKEMA_PENYERAPAN <=",  date('Y') + 1);
        } else {
            $this->db->where("a.SKEMA_PENYERAPAN", $value['SKEMA_PENYERAPAN']);
        }
        $this->db->where("h.IS_AKTIF_LVL1",'1');
        $this->db->order_by('a.SKEMA_PENYERAPAN DESC,h.COCODE ASC');
        $list = $this->db->get();
        if ($list !== FALSE && $list->num_rows() > 0) {
            return $list->result_array();
        }
    }

    function temp_data($key)
    {
        $this->db->select('*');
        $this->db->from($this->_table1 . ' as a');
        $this->db->join('MASTER_LEVEL1 as h', 'a.COCODE = h.COCODE', 'left');
        $this->db->join('MASTER_REGIONAL as i', 'h.ID_REGIONAL = i.ID_REGIONAL', 'left');
        $this->db->where('a.NAMA_GROUP', $key);
        $this->db->order_by('a.SKEMA_PENYERAPAN DESC,h.COCODE ASC');
        $list = $this->db->get();
        if ($list !== FALSE && $list->num_rows() > 0) {
            return $list->result_array();
        }
    }

    function get_data($id)
    {
        $this->db->from($this->_table1);
        $this->db->where($this->_primaryKey, $id);
        $list = $this->db->get();
        return $list->row();
    }

    function options_reg($default = '--Pilih Regional--', $key = 'all')
    {
        $option = array();
        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL', '1');
        if ($key != 'all') {
            $this->db->where('ID_REGIONAL', $key);
        }

        $list = $this->db->get();
        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach($list->result() as $row) {
            $option[$row->ID_REGIONAL] = $row->NAMA_REGIONAL;
        }

        return $option;
    }

    function lvl1options($default = '--Pilih Level 1--', $key = 'all')
    {
        $option = array();
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1', '1');
        $this->db->where('COCODE !=', '0');
        $this->db->order_by('LEVEL1', 'ASC');
        if ($key != 'all') {
            $this->db->where('ID_REGIONAL', $key);
        }

        $list = $this->db->get();
        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach($list->result() as $row) {
            $option[$row->COCODE] = $row->LEVEL1;
        }

        return $option;
    }

    function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis = 0)
    {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1', '1');

        if ($key != 'all') {
            $this->db->where('ID_REGIONAL', (int)$key);
        }

        if ($jenis == 0) {
            return $this->db->get()->result();
        }
        else {
            $option = array();
            $list = $this->db->get();
            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach($list->result() as $row) {
                $option[$row->COCODE] = $row->LEVEL1;
            }

            return $option;
        }
    }

    function options_pemasok($default = '--Pilih Pemasok--', $data)
    {
        $sql = "CALL GET_PEMASOK_BY_COCODE ('$data')";
        $query = $this->db->query($sql);
        return $query->result();
    }

    function option_skema()
    {
        $option = array(
            '2018' => '2018',
            '2019' => '2019',
            '2020' => '2020',
            '2021' => '2021',
            '2022' => '2022',
            '2023' => '2023'
        );
        return $option;
    }

    function get_level($lv = '', $key = '')
    {
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

    function save_as_new($data)
    {
        $this->db->trans_begin();
        $this->db->insert($this->_table1, $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }
        else {
            $this->db->trans_commit();
            return true;
        }
    }

    function edit_data($data, $id)
    {
        $this->db->trans_begin();
        $this->db->where('ID_PENYERAPAN', $id);
        $this->db->update($this->_table1, $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }
        else {
            $this->db->trans_commit();
            return true;
        }
    }

    function save_all($data,$user)
    {
        $this->db->trans_begin();
        $this->db->where('NAMA_GROUP', $user);
        $this->db->update($this->_table1, $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }
        else {
            $this->db->trans_commit();
            return true;
        }
    }

    function isExists2Key($key1, $valkey1, $key2, $valkey2)
    {
        $this->db->from($this->_table1);
        $this->db->where($key1, $valkey1);
        $this->db->where($key2, $valkey2);
        $num = $this->db->count_all_results();
        if ($num == 0) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function isExists3Key($key1, $valkey1, $key2, $valkey2, $key3, $valkey3)
    {
        $this->db->from($this->_table1);
        $this->db->where($key1, $valkey1);
        $this->db->where($key2, $valkey2);
        $this->db->where($key3, $valkey3);
        $num = $this->db->count_all_results();
        if ($num == 0) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    function all_tahun()
    {
        $q = $this->db->query("SELECT MIN(SKEMA_PENYERAPAN) AS MIN, MAX(SKEMA_PENYERAPAN) AS MAX FROM $this->_table1")->row();
        return $q;
    }

    function filter_skema()
    {
        
        $option = array();
        $date = date('Y');

        for($i = date('Y') - 1; $i <= date('Y ') + 1; $i++){
            $option[$i] = $i;
        }

        return $option;
    }

    function filter_skema_all()
    {
        
        $option = array();
        $date = date('Y');
        $option['All'] = 'All'; 
        for($i = date('Y') - 1; $i <= date('Y ') + 1; $i++){
            $option[$i] = $i;
        }

        return $option;
    }

    function perhitungan_bio($default = '--Pilih Perhitungan BIO--')
    {
        $option = array();
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING', 'PERHITUNGAN_BIO');

        $list = $this->db->get();
        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }

        return $option;
    }
}