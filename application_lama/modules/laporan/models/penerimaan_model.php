<?php

/**
 * penerimaan bbm model
 * @author stelin
 */
class penerimaan_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function getData_Model($data){
        $VLEVEL_REGIONAL               = $data['ID_REGIONAL'];
        $VLEVELID                      = $data['VLEVELID'];        
        $JENIS_BBM                     = $data['JENIS_BBM'];
        $TGLAWAL                       = $data['TGLAWAL'];
        $TGLAKHIR                      = $data['TGLAKHIR'];
        $cari                          = $this->laccess->ai($data['CARI']);        

        $sql = "call lap_rekap_penerimaan(
            '$JENIS_BBM',
            '$TGLAWAL' ,
            '$TGLAKHIR' ,
            '$VLEVEL_REGIONAL',
            '$VLEVELID',
            '$cari'
        )";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getData_Model_Detail($data){
        $idBBM    = $data['ID_BBM'];
        $kodeUnit = $data['KODE_UNIT'];
        $tglAwal  = $data['TGL_AWAL'];
        $tglAkhir = $data['TGL_AKHIR'];        

        $sql      = "call lap_detail_penerimaan(
            '$idBBM',
            '$tglAwal',
            '$tglAkhir',
            '$kodeUnit'
        )";        

        // print_r($sql);
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getData_Model_Detail_Bio($data){
        $idBBM    = $data['ID_BBM'];
        $kodeUnit = $data['KODE_UNIT'];
        $tglAwal  = $data['TGL_AWAL'];
        $tglAkhir = $data['TGL_AKHIR'];        

        $sql      = "call lap_detail_penerimaan_bio(
            '$idBBM',
            '$tglAwal',
            '$tglAkhir',
            '$kodeUnit'
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
        
        $sql        = "call temp_lap_detail_penerimaan(
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
            if ($row->ID_JNS_BHN_BKR == '004') {
            } else {
                $option[$row->ID_JNS_BHN_BKR] = $row->NAMA_JNS_BHN_BKR;
            }
        }

        $this->db->close();
        return $option;
    }

    public function exportList($data){
        $VLEVEL_REGIONAL               = $data['LVL0'];
        $VLEVELID                      = $data['VLEVELID'];        
        $JENIS_BBM                     = $data['JENIS_BBM'];
        $TGLAWAL                       = $data['TGLAWAL'];
        $TGLAKHIR                      = $data['TGLAKHIR'];
        $cari                          = $this->laccess->ai($data['CARI']);        

        $sql = "call lap_rekap_penerimaan(
            '$JENIS_BBM',
            '$TGLAWAL' ,
            '$TGLAKHIR' ,
            '$VLEVEL_REGIONAL',
            '$VLEVELID',
            '$cari'
        )";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
}
