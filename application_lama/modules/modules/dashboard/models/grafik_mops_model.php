<?php

/**
 * @module DASHBOARD
 * @author  BAKTI WIJAYA
 * @created at 31 DESEMBER 2018
 * @modified at 31 DESEMBER 2018
 */
class grafik_mops_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
   
   
    public function getDataMops($data) {

        $tahun = $data['TAHUN'];
        $bulan = $data['BULAN'];

        $sql ="CALL mops_perbln('$tahun','$bulan')";

        $query = $this->db->query($sql);
            
        return $query->result();
    }

    public function getTahun() {
	    
	     
        $option = array();
        $list = $this->db->query('SELECT DISTINCT(SUBSTR(TGLAWAL,1,4)) TAHUN FROM TRANS_HITUNG_HARGA');

        foreach ($list->result() as $row) {
            $option[$row->TAHUN] = $row->TAHUN;
        }
        return $option;    
    }

    public function getBulan() {
	    
        $list = $this->db->query('SELECT * FROM REF_BULAN')->result();
        return $list;    
    }
}
