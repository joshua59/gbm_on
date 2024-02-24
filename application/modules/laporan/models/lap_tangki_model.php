<?php

/**
 * penerimaan bbm model
 * @author stelin
 */
class lap_tangki_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function getData_Model($data){

        $VLEVEL_REGIONAL               = $data['ID_REGIONAL'];
        $VLEVELID                      = $data['VLEVELID'];        
        $JENIS_BBM                     = $data['JENIS_BBM'];
        // $TGLAWAL                       = $data['TGLAWAL'];
        // $TGLAKHIR                      = $data['TGLAKHIR'];
        $cari                          = $this->laccess->ai($data['CARI']);        

        $sql = "call lap_rekap_tangki(
            '$JENIS_BBM',
            '$VLEVEL_REGIONAL',
            '$VLEVELID',
            '$cari'
        )";

        // print_r($sql);
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getData_Model_Detail($data){
        $idBBM    = $data['ID_BBM'];
        $idTangki = $data['ID_TANGKI'];
        $kodeUnit = $data['KODE_UNIT'];
        // $tglAwal  = $data['TGL_AWAL'];
        // $tglAkhir = $data['TGL_AKHIR'];        

        $sql      = "call lap_detail_tangki(
            '$idBBM',
            '$idTangki',
            '$kodeUnit'
        )";        

        // print_r($sql);
        $query = $this->db->query($sql);
        return $query->result();
    }  

    public function getData_All_Model_Detail($data){

        $VLEVEL_REGIONAL               = $data['ID_REGIONAL'];
        $VLEVELID                      = $data['VLEVELID'];        
        $JENIS_BBM                     = $data['JENIS_BBM'];
        // $TGLAWAL                       = $data['TGLAWAL'];
        // $TGLAKHIR                      = $data['TGLAKHIR'];
        $cari                          = $this->laccess->ai($data['CARI']);        

        $sql = "call lap_detail_all_tangki(
            '$JENIS_BBM',
            '$VLEVEL_REGIONAL',
            '$VLEVELID',
            '$cari'
        )";

        // print_r($sql);
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function tempgetData_Model_Detail($data){
        $idBBM      = $data['ID_BBM'];
        $kodeUnit   = $data['KODE_UNIT'];
        $tglAwal    = $data['TGL_AWAL'];
        $tglAkhir   = $data['TGL_AKHIR'];
        $halaman    = $data['HALAMAN'];
        $baris      = $data['BARIS'];
        
        $sql      = "call temp_lap_detail_penerimaan(
            '$idBBM',
            '$tglAwal',
            '$tglAkhir',
            '$kodeUnit',
            '$halaman',
            '$baris'
        )";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function data_option($key = ''){
        $this->db->from('M_JNS_BHN_BKR');

        if (!empty($key) || is_array($key)) {
            $this->db->where_condition($this->_key($key));
        }

        $this->db->close();
        return $this->db;
    }

    public function option_jenisbbm($default = '--Pilih Jenis BBM--'){
        $option = array();
        $list   = $this->data_option()->get();

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
        }

        $this->db->close();
        return $option;
    }
}
