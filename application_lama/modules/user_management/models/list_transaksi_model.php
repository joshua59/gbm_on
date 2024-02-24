<?php

/**
 * pemakaian model
 * @author stelin
 */
class list_transaksi_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * getPemakaian by array
     * @param  array  $data passing from controller
     * @return object
     */
    public function getTransaksi($data)
    {
        $jenis      = $data['jenis'];
        $idRegional = $data['idRegional'];
        $vlevelId   = $data['vlevelId'];
        $TGLAWAL    = $data['TGLAWAL'];
        $TGLAKHIR   = $data['TGLAKHIR'];
        $cari       = $this->laccess->ai($data['CARI']);

        $sql = "call lap_rekap_transaksi(
            '$jenis',
            '$TGLAWAL' ,
            '$TGLAKHIR' ,
            '$idRegional',
            '$vlevelId',
            '$cari'
        )";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function get_data_unit($sloc){
        $sql = "CALL GET_UNIT('$sloc')";
        // print_r($sql); die;
        $query = $this->db->query($sql);
        return $query->result();
    }    

    public function options_reg($default = '--Pilih Regional--', $key = 'all') {
        $option = array();

        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        $this->db->order_by('NAMA_REGIONAL');  
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
        $this->db->close();
        return $option;
    }

    public function options_lv1($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL1');
        $this->db->where('IS_AKTIF_LVL1','1');
        $this->db->order_by('LEVEL1'); 
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->COCODE] = $row->LEVEL1;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function options_lv2($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL2');
        $this->db->where('IS_AKTIF_LVL2','1');
        $this->db->order_by('LEVEL2'); 
        if ($key != 'all'){
            $this->db->where('COCODE',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->PLANT] = $row->LEVEL2;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function options_lv3($default = '--Pilih Level 3--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL3');
        $this->db->where('IS_AKTIF_LVL3','1');
        $this->db->order_by('LEVEL3'); 
        if ($key != 'all'){
            $this->db->where('PLANT',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->STORE_SLOC] = $row->LEVEL3;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function options_lv4($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('MASTER_LEVEL4');
        $this->db->where('IS_AKTIF_LVL4','1');
        $this->db->order_by('LEVEL4'); 
        if ($key != 'all'){
            $this->db->where('STORE_SLOC',$key);
        }    
        if ($jenis==0){
            $rest = $this->db->get()->result(); 
        } else {
            $option = array();
            $list = $this->db->get(); 

            if (!empty($default)) {
                $option[''] = $default;
            }

            foreach ($list->result() as $row) {
                $option[$row->SLOC] = $row->LEVEL4;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
    }

    public function options_bulan() {
        
        $option = array();
        $option[''] = '--Pilih Bulan--';
        $option['1'] = 'Januari';
        $option['2'] = 'Februari';
        $option['3'] = 'Maret';
        $option['4'] = 'April';
        $option['5'] = 'Mei';
        $option['6'] = 'Juni';
        $option['7'] = 'Juli';
        $option['8'] = 'Agustus';
        $option['9'] = 'September';
        $option['10'] = 'Oktober';
        $option['11'] = 'November';
        $option['12'] = 'Desember';
        return $option;
    }

    public function options_tahun() {
        $year = date("Y"); 

        $option[$year - 1] = $year - 1;
        $option[$year] = $year;
        $option[$year + 1] = $year + 1;

        return $option;
    }
}
