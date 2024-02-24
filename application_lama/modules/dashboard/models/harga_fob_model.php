<?php

/**
 * @module DASHBOARD
 * @author  BAKTI WIJAYA
 * @created at 31 DESEMBER 2018
 * @modified at 31 DESEMBER 2018
 */
class harga_fob_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
   
    public function getDataHargaFOB($data) {

        $tahun = $data['TAHUN'];

        $sql ="CALL GRAF_HRG_FOB('$tahun')";

        $query = $this->db->query($sql);
            
        return $query->result();
    }

    public function getDataHargaCIF($data) {

    	$vlevelid = $data['VLEVELID'];
        $tahun = $data['TAHUN'];

        $sql ="CALL GRAF_HRG_CIF($tahun,'$vlevelid')";
        $query = $this->db->query($sql);
            
        return $query->result();
    }

    public function options_reg($default = '--Pilih Regional--', $key = 'all')
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

        foreach ($list->result() as $row) {
            $option[$row->ID_REGIONAL] = $row->NAMA_REGIONAL;
        }
        return $option;
    }

    public function options_lv4_cif($default = 'All', $key = 'all'){
        $option = array();

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        $where = '';

        if ($level_user == 4) {
            $where = ' AND m4.SLOC='.$kode_level;
        } else if ($level_user == 3) {
            $where = ' AND m3.STORE_SLOC='.$kode_level;
        } else if ($level_user == 2) {
            $where = ' AND m2.PLANT='.$kode_level;
        } else if ($level_user == 1) {
            $where = ' AND m1.COCODE='.$kode_level;
        } else if ($level_user == 0) {
            if ($kode_level !='' && $kode_level !='0') {
                $where = ' AND r.ID_REGIONAL='.$kode_level;            
            }
        }        

        $sql ="SELECT h.SLOC, m4.LEVEL4 FROM TRANS_HITUNG_HARGA h
               INNER JOIN MASTER_LEVEL4 m4 ON m4.SLOC = h.SLOC
               INNER JOIN MASTER_LEVEL3 m3 ON m3.STORE_SLOC = m4.STORE_SLOC
               INNER JOIN MASTER_LEVEL2 m2 ON m2.PLANT = m3.PLANT
               INNER JOIN MASTER_LEVEL1 m1 ON m1.COCODE = m2.COCODE
               INNER JOIN MASTER_REGIONAL r ON r.ID_REGIONAL = m1.ID_REGIONAL
               WHERE STATUS_APPROVE ='2' ".$where." 
               AND m4.IS_AKTIF_LVL4 ='1'
               GROUP BY h.SLOC";
        $list = $this->db->query($sql);        

        if (!empty($default)) {
            $option['All'] = $default;;
        }

        foreach ($list->result() as $row) {
            $option[$row->SLOC] = $row->LEVEL4;
        }
        return $option;
    }
}
