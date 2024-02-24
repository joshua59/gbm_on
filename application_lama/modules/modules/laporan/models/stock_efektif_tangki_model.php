<?php

/**
 * penerimaan bbm model
 * @author stelin
 */
class stock_efektif_tangki_model extends CI_Model{
    public function __construct(){
        parent::__construct();
    }

    public function getData_Model($data)
    {
        $bbm      = $data['jenis_bbm'];
        $tglAwal  = $data['tglAwal'];
        $tglAkhir = $data['tglAkhir'];
        $vlevel   = $data['vlevel'];
        $vlevelid = $data['vlevelid'];
        $cari     = $data['cari'];

        $sql    = "CALL lap_stock_real_efektif (
          '$bbm','$tglAwal','$tglAkhir','$vlevel','$vlevelid','$cari'
        )";
        $query = $this->db->query($sql);
        // print_r($query);

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
