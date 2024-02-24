<?php
/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */
class kontrak_transportir_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "TRANS_HITUNG_HARGA"; //nama table setelah mom_

    private function _key($key) { //unit ID
        if (!is_array($key)) {
            $key = array('IDTRANS' => $key);
        }
        return $key;
    }

    public function data($key = '') {
        $this->db->select("r.NAMA_REGIONAL, m1.LEVEL1, m2.LEVEL2, m3.LEVEL3, m4.LEVEL4, mt.NAMA_TRANSPORTIR, 
                            a.KD_KONTRAK_TRANS, a.TGL_KONTRAK_TRANS, a.TGL_KONTRAK_TRANS_AKHIR,
                            md.NAMA_DEPO, ds.NAME_SETTING, dk.JARAK_DET_KONTRAK_TRANS, dk.HARGA_KONTRAK_TRANS"); 
        $this->db->from("DATA_KONTRAK_TRANSPORTIR a");
        $this->db->join('MASTER_LEVEL2 m2', 'm2.PLANT = a.PLANT','left');
        $this->db->join('MASTER_LEVEL1 m1', 'm1.COCODE = m2.COCODE','left');
        $this->db->join('MASTER_REGIONAL r', 'r.ID_REGIONAL = m1.ID_REGIONAL','left');
        $this->db->join('MASTER_TRANSPORTIR mt', 'mt.ID_TRANSPORTIR = a.ID_TRANSPORTIR','left');
        $this->db->join('DET_KONTRAK_TRANS dk', 'dk.KD_KONTRAK_TRANS = a.KD_KONTRAK_TRANS','left');
        $this->db->join('MASTER_DEPO md', 'md.ID_DEPO = dk.ID_DEPO','left');
        $this->db->join('DATA_SETTING ds', "ds.VALUE_SETTING = dk.TYPE_KONTRAK_TRANS AND ds.KEY_SETTING='TYPE_KONTRAK_TRANSPORTIR' ",'left');
        $this->db->join('MASTER_LEVEL4 m4', 'm4.SLOC = dk.SLOC','left');
        $this->db->join('MASTER_LEVEL3 m3', 'm3.STORE_SLOC = m4.STORE_SLOC','left');
        if (!empty($key) || is_array($key))
        $this->db->where_condition($this->_key($key));


        if ($_POST['ID_REGIONAL'] !='') {
            if ($_POST['ID_REGIONAL'] =='00') {
                $this->db->where('r.ID_REGIONAL != "" ');
            } else {
                $this->db->where('r.ID_REGIONAL',$_POST['ID_REGIONAL']);    
            }   
        }
        if ($_POST['COCODE'] !='') {
            $this->db->where("m1.COCODE",$_POST['COCODE']);
        }
        if ($_POST['PLANT'] !='') {
            $this->db->where("m2.PLANT",$_POST['PLANT']);
        }
        if ($_POST['STORE_SLOC'] !='') {
            $this->db->where("m3.STORE_SLOC",$_POST['STORE_SLOC']);
        }
        if ($_POST['SLOC'] !='') {
            $this->db->where("m4.SLOC",$_POST['SLOC']);
        }
        if ($_POST['ID_TRANSPORTIR'] !='') {
            $this->db->where("a.ID_TRANSPORTIR",$_POST['ID_TRANSPORTIR']);
        }
        if ($_POST['TGL_DARI'] !='') {
            $this->db->where("a.TGL_KONTRAK_TRANS >=",$_POST['TGL_DARI']);   
        }        
        if ($_POST['TGL_SAMPAI'] !='') {
            $this->db->where("a.TGL_KONTRAK_TRANS_AKHIR <=",$_POST['TGL_SAMPAI']);   
        }  

        $this->db->order_by('a.KD_KONTRAK_TRANS, r.NAMA_REGIONAL, m1.LEVEL1, m2.LEVEL2, m3.LEVEL3, m4.LEVEL4');

        $kata_kunci = $this->laccess->ai($this->input->post('kata_kunci'));
        if ($kata_kunci){
            $cari = "(r.NAMA_REGIONAL LIKE '%$kata_kunci%' OR m1.LEVEL1 LIKE '%$kata_kunci%' OR m2.LEVEL2 LIKE '%$kata_kunci%' OR m3.LEVEL3 LIKE '%$kata_kunci%' OR m4.LEVEL4 LIKE '%$kata_kunci%' OR mt.NAMA_TRANSPORTIR LIKE '%$kata_kunci%' OR a.KD_KONTRAK_TRANS LIKE '%$kata_kunci%' OR md.NAMA_DEPO LIKE '%$kata_kunci%')";
            $this->db->where($cari);   
        }

        $rest = $this->db;
        $this->db->close();
        return $rest;
    }

    public function data_export($data) {
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];
        $p_transportir = $data['ID_TRANSPORTIR'];   
        $p_tglawal = $data['TGL_DARI'];   
        $p_tglakhir = $data['TGL_SAMPAI'];           
        $p_cari = $data['kata_kunci']; 
        $status_kontrak = $data['status_kontrak'];  

        $p_unit = '';

        if($COCODE == '') {
            if($ID != '') {
               if($ID == '00') {
                    $p_unit == 'All';
               } else {
                  $p_unit = $ID;
               }
            } 
        }
        else if($PLANT == '') {
            $p_unit = $COCODE;
        } else if($STORE_SLOC == '') {
            $p_unit = $PLANT;
        } else if($SLOC == '') {
            $p_unit = $STORE_SLOC;
        } else {
            $p_unit = $SLOC;
        }


        $sql = "call lap_kontrak_transportir('$p_unit','$p_transportir','$p_tglawal','$p_tglakhir','$p_cari','$status_kontrak')";
       
        $query = $this->db->query($sql)->result();
        $this->db->close();
        return $query;
    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function get_datatables($data){
        $p_unit = $data['p_unit'];
        $p_transportir = $data['p_transportir'];   
        $p_tglawal = $data['p_tglawal'];   
        $p_tglakhir = $data['p_tglakhir'];           
        $p_cari = $data['p_cari'];   
        $status_kontrak = $data['status_kontrak'];    
        $sql = "call lap_kontrak_transportir('$p_unit','$p_transportir','$p_tglawal','$p_tglakhir','$p_cari','$status_kontrak')";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function count_all($data){        
        $p_unit = $data['p_unit'];
        $p_transportir = $data['p_transportir'];   
        $p_tglawal = $data['p_tglawal'];   
        $p_tglakhir = $data['p_tglakhir'];           
        $p_cari = $data['p_cari']; 
        $status_kontrak = $data['status_kontrak']; 

        $sql = "call lap_kontrak_transportir('$p_unit','$p_transportir','$p_tglawal','$p_tglakhir','$p_cari','$status_kontrak')";
        $query = $this->db->query($sql);
        $this->db->close();
        $row = $query->result_array();

        return count($row);
    }    

    public function get_datatables_adendum($data){
        $p_unit = $data['p_unit'];
        $p_transportir = $data['p_transportir'];   
        $p_tglawal = $data['p_tglawal'];   
        $p_tglakhir = $data['p_tglakhir'];           
        $p_cari = $data['p_cari'];   
        $status_kontrak = $data['status_kontrak'];    
        $sql = "call lap_kontrak_transportir_adendum('$p_unit','$p_transportir','$p_tglawal','$p_tglakhir','$p_cari','$status_kontrak')";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function data_export_adendum($data) {
        $ID = $data['ID_REGIONAL'];
        $COCODE = $data['COCODE']; 
        $PLANT = $data['PLANT'];
        $STORE_SLOC = $data['STORE_SLOC'];
        $SLOC = $data['SLOC'];
        $p_transportir = $data['ID_TRANSPORTIR'];   
        $p_tglawal = $data['TGL_DARI'];   
        $p_tglakhir = $data['TGL_SAMPAI'];           
        $p_cari = $data['kata_kunci']; 
        $status_kontrak = $data['status_kontrak'];  

        $p_unit = '';

        if($COCODE == '') {
            if($ID != '') {
               if($ID == '00') {
                    $p_unit == 'All';
               } else {
                  $p_unit = $ID;
               }
            } 
        }
        else if($PLANT == '') {
            $p_unit = $COCODE;
        } else if($STORE_SLOC == '') {
            $p_unit = $PLANT;
        } else if($SLOC == '') {
            $p_unit = $STORE_SLOC;
        } else {
            $p_unit = $SLOC;
        }


        $sql = "call lap_kontrak_transportir_adendum('$p_unit','$p_transportir','$p_tglawal','$p_tglakhir','$p_cari','$status_kontrak')";
       
        $query = $this->db->query($sql)->result();
        $this->db->close();
        return $query;
    }

   
    public function get_datatables_adendum_export($data) {
        $p_unit = $data['p_unit'];
        $p_transportir = $data['p_transportir'];   
        $p_tglawal = $data['p_tglawal'];   
        $p_tglakhir = $data['p_tglakhir'];           
        $p_cari = $data['p_cari'];   
        $status_kontrak = $data['status_kontrak'];    
        $sql = "call lap_kontrak_transportir_adendum('$p_unit','$p_transportir','$p_tglawal','$p_tglakhir','$p_cari','$status_kontrak')";
        $query = $this->db->query($sql);
        $this->db->close();
        return $query->result();       
    }   

    public function count_all_adendum($data){        
        $p_unit = $data['p_unit'];
        $p_transportir = $data['p_transportir'];   
        $p_tglawal = $data['p_tglawal'];   
        $p_tglakhir = $data['p_tglakhir'];           
        $p_cari = $data['p_cari'];   
        $status_kontrak = $data['status_kontrak'];    
        $sql = "call lap_kontrak_transportir_adendum('$p_unit','$p_transportir','$p_tglawal','$p_tglakhir','$p_cari','$status_kontrak')";
        $query = $this->db->query($sql);
        $this->db->close();
        $row = $query->result_array();

        return count($row);
    }     

    public function options_pemasok($default = '--Pilih Pemasok--') {
        $this->db->from('MASTER_PEMASOK');
        $this->db->where('IS_HARGA','1');
        $this->db->order_by('NAMA_PEMASOK DESC');

        $option = array();
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->KODE_PEMASOK] = $row->NAMA_PEMASOK;
        }
        $this->db->close();
        return $option;    
    }

    public function options_transportir($default = '--Pilih Transportir--') {
        $this->db->from('MASTER_TRANSPORTIR');
        // $this->db->where('IS_HARGA','1');
        $this->db->order_by('NAMA_TRANSPORTIR ASC');

        $option = array();
        $list = $this->db->get(); 

        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->ID_TRANSPORTIR] = $row->NAMA_TRANSPORTIR;
        }
        $this->db->close();
        return $option;    
    }

    public function options_type($default = '--Pilih Type Pemasok--') {
        $option = array();
        // $option = ['PERTAMINA', 'NON PERTAMINA'];
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
        $this->db->close();
        return $query;
    }

    public function options_reg_array($default = '--Pilih Regional--', $key = 'all') {
        $option = array();
        
        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }   
        $list = $this->db->get(); 

        if ($list->num_rows() > 0) 
        {
            return $list->result_array();
        } 
        else 
        {
            return array();
        }
    }

    public function options_reg($default = '--Pilih Regional--', $key = 'all') {
        $option = array();
        
        $this->db->from('MASTER_REGIONAL');
        $this->db->where('IS_AKTIF_REGIONAL','1');
        if ($key != 'all'){
            $this->db->where('ID_REGIONAL',$key);
        }   
        $list = $this->db->get(); 

        // if ($list->num_rows() > 0) 
        // {
        //     return $list->result_array();
        // } 
        // else 
        // {
        //     return array();
        // }
        
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
        $option = array();

        $option[''] = '--Pilih Tahun--';
        $option[$year - 1] = $year - 1;
        $option[$year] = $year;
        $option[$year + 1] = $year + 1;

        return $option;
    }

    public function options_status() {
        $this->db->from('DATA_SETTING');
        $this->db->where('KEY_SETTING','STATUS_APPROVE');
        $this->db->order_by("VALUE_SETTING ASC");
        
        $list = $this->db->get(); 
        $option = array();
        $option[''] = '-- Semua --';

        foreach ($list->result() as $row) {
            $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
        }
        $this->db->close();
        return $option;    
    }

    public function options_status_kontrak() {
        $option = array();
        $option[''] = '-- Semua --';
        $option['1'] = 'Kontrak Tidak Aktif';
        $option['2'] = 'Kontrak Aktif';

        return $option;    
    }    
}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */