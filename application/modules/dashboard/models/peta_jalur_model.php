<?php

/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */

class peta_jalur_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    private $_table1 = "DUMMY_GRAFIK"; //nama table setelah mom_

    public function report(){
        $query = $this->db->query("SELECT DATE_FORMAT(a.tanggal,'%m') bulan,DATE_FORMAT(a.tanggal,'%M %Y') blth,DATE_FORMAT(a.tanggal,'%Y%m') blth2, ROUND(AVG(a.Harga),2) avgHargaKurs, ROUND(AVG(a.hsdnoppn),2) avgHargaHsd, ROUND(AVG(a.mfonoppn),2) avgHargaMfo, ROUND(AVG(a.rmopshsd),2) avgHargaMops, DATE_FORMAT(a.tanggal,'%Y') tahun FROM DUMMY_GRAFIK a WHERE DATE_FORMAT(a.tanggal,'%Y')= YEAR(NOW()) GROUP BY a.blth;");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    } 

    public function call_peta() {
        $lv = 'Pusat';
        $lv_id = '';

            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                // $_POST['HOP'];
            } else {
                $hop = '';
            }


        if ($_POST['SLOC'] !='') {
            $lv = 'Level 4';
            $lv_id = $_POST['SLOC'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                // $_POST['HOP'];
            } else {
                $hop = '';
            }
        } else if ($_POST['STORE_SLOC'] !='') {
            $lv = 'Level 3';
            $lv_id = $_POST['STORE_SLOC'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                // $_POST['HOP'];
            } else {
                $hop = '';
            }
        } else if ($_POST['PLANT'] !='') {
            $lv = 'Level 2';
            $lv_id = $_POST['PLANT'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                $_POST['HOP'];
            } else {
                // $hop = '';
            }
        } else if ($_POST['COCODE'] !='') {
            $lv = 'Level 1';
            $lv_id = $_POST['COCODE'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
            } else {
                $hop = '';
            }
        } else if ($_POST['ID_REGIONAL'] !='') {
            if ($_POST['ID_REGIONAL'] !='00'){
                $lv = 'Regional';
                $lv_id = $_POST['ID_REGIONAL'];
                if($_POST['HOP'] !=''){
                    if ($_POST['HOP'] == '1') {
                        $hop = 'MERAH';
                    } else if ($_POST['HOP'] == '2') {
                        $hop = 'KUNING';
                    } else if ($_POST['HOP'] == '3') {
                        $hop = 'HIJAU';
                    } else if ($_POST['HOP'] == '4') {
                        $hop = 'BIRU';
                    }
                    // $_POST['HOP'];
                } else {
                    $hop = '';
                }
            } else {
                $lv = 'Pusat';
                $lv_id = '';
                if($_POST['HOP'] !=''){
                    if ($_POST['HOP'] == '1') {
                        $hop = 'MERAH';
                    } else if ($_POST['HOP'] == '2') {
                        $hop = 'KUNING';
                    } else if ($_POST['HOP'] == '3') {
                        $hop = 'HIJAU';
                    } else if ($_POST['HOP'] == '4') {
                        $hop = 'BIRU';
                    }
                    // $_POST['HOP'];
                } else {
                    $hop = '';
                }
            }            
        }

        $q="CALL dashboard_peta('$lv','$lv_id','$hop');";

        $query = $this->db->query($q);

        return $query->result();       
    }

    public function call_peta_non_depo() {
        $lv = 'Pusat';
        $lv_id = '';

            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                // $_POST['HOP'];
            } else {
                $hop = '';
            }


        if ($_POST['SLOC'] !='') {
            $lv = 'Level 4';
            $lv_id = $_POST['SLOC'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                // $_POST['HOP'];
            } else {
                $hop = '';
            }
        } else if ($_POST['STORE_SLOC'] !='') {
            $lv = 'Level 3';
            $lv_id = $_POST['STORE_SLOC'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                // $_POST['HOP'];
            } else {
                $hop = '';
            }
        } else if ($_POST['PLANT'] !='') {
            $lv = 'Level 2';
            $lv_id = $_POST['PLANT'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                $_POST['HOP'];
            } else {
                // $hop = '';
            }
        } else if ($_POST['COCODE'] !='') {
            $lv = 'Level 1';
            $lv_id = $_POST['COCODE'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
            } else {
                $hop = '';
            }
        } else if ($_POST['ID_REGIONAL'] !='') {
            if ($_POST['ID_REGIONAL'] !='00'){
                $lv = 'Regional';
                $lv_id = $_POST['ID_REGIONAL'];
                if($_POST['HOP'] !=''){
                    if ($_POST['HOP'] == '1') {
                        $hop = 'MERAH';
                    } else if ($_POST['HOP'] == '2') {
                        $hop = 'KUNING';
                    } else if ($_POST['HOP'] == '3') {
                        $hop = 'HIJAU';
                    } else if ($_POST['HOP'] == '4') {
                        $hop = 'BIRU';
                    }
                    // $_POST['HOP'];
                } else {
                    $hop = '';
                }
            } else {
                $lv = 'Pusat';
                $lv_id = '';
                if($_POST['HOP'] !=''){
                    if ($_POST['HOP'] == '1') {
                        $hop = 'MERAH';
                    } else if ($_POST['HOP'] == '2') {
                        $hop = 'KUNING';
                    } else if ($_POST['HOP'] == '3') {
                        $hop = 'HIJAU';
                    } else if ($_POST['HOP'] == '4') {
                        $hop = 'BIRU';
                    }
                    // $_POST['HOP'];
                } else {
                    $hop = '';
                }
            }            
        }

        $q="CALL dashboard_peta_test_no_depo('$lv','$lv_id','$hop');";

        $query = $this->db->query($q);

        return $query->result();       
    }

    public function call_peta_ss() {
        $lv = 'Pusat';
        $lv_id = '';

            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                // $_POST['HOP'];
            } else {
                $hop = '';
            }


        if ($_POST['SLOC'] !='') {
            $lv = 'Level 4';
            $lv_id = $_POST['SLOC'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                // $_POST['HOP'];
            } else {
                $hop = '';
            }
        } else if ($_POST['STORE_SLOC'] !='') {
            $lv = 'Level 3';
            $lv_id = $_POST['STORE_SLOC'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                // $_POST['HOP'];
            } else {
                $hop = '';
            }
        } else if ($_POST['PLANT'] !='') {
            $lv = 'Level 2';
            $lv_id = $_POST['PLANT'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
                $_POST['HOP'];
            } else {
                // $hop = '';
            }
        } else if ($_POST['COCODE'] !='') {
            $lv = 'Level 1';
            $lv_id = $_POST['COCODE'];
            if($_POST['HOP'] !=''){
                if ($_POST['HOP'] == '1') {
                    $hop = 'MERAH';
                } else if ($_POST['HOP'] == '2') {
                    $hop = 'KUNING';
                } else if ($_POST['HOP'] == '3') {
                    $hop = 'HIJAU';
                } else if ($_POST['HOP'] == '4') {
                    $hop = 'BIRU';
                }
            } else {
                $hop = '';
            }
        } else if ($_POST['ID_REGIONAL'] !='') {
            if ($_POST['ID_REGIONAL'] !='00'){
                $lv = 'Regional';
                $lv_id = $_POST['ID_REGIONAL'];
                if($_POST['HOP'] !=''){
                    if ($_POST['HOP'] == '1') {
                        $hop = 'MERAH';
                    } else if ($_POST['HOP'] == '2') {
                        $hop = 'KUNING';
                    } else if ($_POST['HOP'] == '3') {
                        $hop = 'HIJAU';
                    } else if ($_POST['HOP'] == '4') {
                        $hop = 'BIRU';
                    }
                    // $_POST['HOP'];
                } else {
                    $hop = '';
                }
            } else {
                $lv = 'Pusat';
                $lv_id = '';
                if($_POST['HOP'] !=''){
                    if ($_POST['HOP'] == '1') {
                        $hop = 'MERAH';
                    } else if ($_POST['HOP'] == '2') {
                        $hop = 'KUNING';
                    } else if ($_POST['HOP'] == '3') {
                        $hop = 'HIJAU';
                    } else if ($_POST['HOP'] == '4') {
                        $hop = 'BIRU';
                    }
                    // $_POST['HOP'];
                } else {
                    $hop = '';
                }
            }            
        }

        $q="CALL dashboard_peta_ss('$lv','$lv_id','$hop');";

        $query = $this->db->query($q);

        return $query->result();       
    }

    public function get_peta() {

        if (($_POST['ID_REGIONAL'] !='') && ($_POST['ID_REGIONAL'] !='00')) {
            $lv = " AND R.ID_REGIONAL='".$_POST['ID_REGIONAL']."' ";
        }
        if ($_POST['COCODE'] !='') {
            $lv = " AND M1.COCODE='".$_POST['COCODE']."' ";
        }
        if ($_POST['PLANT'] !='') {
            $lv = " AND M2.PLANT='".$_POST['PLANT']."' ";
        }
        if ($_POST['STORE_SLOC'] !='') {
            $lv = " AND M3.STORE_SLOC='".$_POST['STORE_SLOC']."' ";
        }
        if ($_POST['SLOC'] !='') {
            $lv = " AND M4.SLOC='".$_POST['SLOC']."' ";
        }

        $q="SELECT A.ID_DEPO, A.NAMA_DEPO, A.LAT_DEPO, A.LOT_DEPO, 
            M4.LEVEL4, M4.LAT_LVL4, M4.LOT_LVL4,
            B.HARGA_KONTRAK_TRANS, B.JARAK_DET_KONTRAK_TRANS, C.NILAI_KONTRAK_TRANS,
            P.NAMA_PEMASOK, C.KD_KONTRAK_TRANS, B.SLOC,
                CASE
                    WHEN A.ID_DEPO = '000' THEN M4P.LAT_LVL4
                    ELSE A.LAT_DEPO
                END AS LAT_DEPO_OK,
                CASE
                    WHEN A.ID_DEPO = '000' THEN M4P.LOT_LVL4
                    ELSE A.LOT_DEPO
                END AS LOT_DEPO_OK,
                CASE
                    WHEN A.ID_DEPO = '000' THEN M4P.LEVEL4
                    ELSE A.NAMA_DEPO
                END AS NAMA_DEPO_OK,
                CASE
                    WHEN A.ID_DEPO = '000' THEN M4P.SLOC
                    ELSE A.ID_DEPO
                END AS SLOC_UNIT_PLN
            FROM DET_KONTRAK_TRANS B
            INNER JOIN MASTER_DEPO A ON A.ID_DEPO=B.ID_DEPO
            INNER JOIN DATA_KONTRAK_TRANSPORTIR C ON C.KD_KONTRAK_TRANS=B.KD_KONTRAK_TRANS
            INNER JOIN MASTER_LEVEL4 M4 ON M4.SLOC=B.SLOC
            INNER JOIN MASTER_LEVEL3 M3 ON M3.STORE_SLOC=M4.STORE_SLOC 
            INNER JOIN MASTER_LEVEL2 M2 ON M2.PLANT=M3.PLANT 
            INNER JOIN MASTER_LEVEL1 M1 ON M1.COCODE=M2.COCODE 
            INNER JOIN MASTER_REGIONAL R ON R.ID_REGIONAL=M1.ID_REGIONAL
            LEFT JOIN MASTER_LEVEL4 M4P ON M4P.SLOC=B.SLOC_PEMASOK
            LEFT JOIN MASTER_PEMASOK P ON P.ID_PEMASOK=A.ID_PEMASOK
            WHERE M4.LAT_LVL4<>'' 
            ".$lv."
            GROUP BY A.ID_DEPO, M4.SLOC ";  

        // print_r($q); die;
        $query = $this->db->query($q);

        return $query->result();       
    }

    public function get_jalur($jenis, $id) {
        if ($jenis=='sloc'){
            $cari=" WHERE a.SLOC='$id' "; 
        } else {
            $cari=" WHERE a.ID_DEPO='$id' ";
        }
        
        $q="SELECT
            a.SLOC, m4.LEVEL4, m4.LAT_LVL4, m4.LOT_LVL4,
            a.SLOC_PEMASOK,
            a.ID_DEPO, md.NAMA_DEPO, md.LAT_DEPO, md.LOT_DEPO,
            CASE
                WHEN a.ID_DEPO = '000' THEN m4_pemasok.LAT_LVL4
                ELSE md.LAT_DEPO
            END AS LAT_DEPO_OK,
            CASE
                WHEN a.ID_DEPO = '000' THEN m4_pemasok.LOT_LVL4
                ELSE md.LOT_DEPO
            END AS LOT_DEPO_OK,
            CASE
                WHEN a.ID_DEPO = '000' THEN m4_pemasok.LEVEL4
                ELSE md.NAMA_DEPO
            END AS NAMA_DEPO_OK
            from DET_KONTRAK_TRANS a
            inner join MASTER_LEVEL4 m4 on m4.SLOC=a.SLOC
            left join MASTER_DEPO md on md.ID_DEPO=.a.ID_DEPO
            left join MASTER_LEVEL4 m4_pemasok on m4_pemasok.SLOC=.a.SLOC_PEMASOK ".$cari;
             
        // print_r($q); die;
        $query = $this->db->query($q);

        return $query->result_array();       
    }

    public function call_jalur($jenis='',$id='') { 
        $lv = 'Pusat';
        $lv_id = '';
        $jenis = $_POST['jenis'];
        $id = $_POST['id'];

        if ($_POST['SLOC'] !='') {
            $lv = 'Level 4';
            $lv_id = $_POST['SLOC'];
        } else if ($_POST['STORE_SLOC'] !='') {
            $lv = 'Level 3';
            $lv_id = $_POST['STORE_SLOC'];
        } else if ($_POST['PLANT'] !='') {
            $lv = 'Level 2';
            $lv_id = $_POST['PLANT'];
        } else if ($_POST['COCODE'] !='') {
            $lv = 'Level 1';
            $lv_id = $_POST['COCODE'];
        } else if ($_POST['ID_REGIONAL'] !='') {
            if ($_POST['ID_REGIONAL'] !='00'){
                $lv = 'Regional';
                $lv_id = $_POST['ID_REGIONAL'];
            } else {
                $lv = 'Pusat';
                $lv_id = '';
            }            
        }

        if ($jenis=='depo'){            
            $q="CALL detail_peta_depo('$lv','$lv_id','$id');";
        } else if ($jenis=='sloc'){
            // $q="CALL detail_peta_all('$id');";
            $q="CALL detail_peta_all('$lv','$lv_id','$id');";
        } else if ($jenis=='unit_pln'){
            $q="CALL detail_peta_unitpln('$lv','$lv_id','$id');";
        }
        
        // print_r($q); die;
        $query = $this->db->query($q);
        return $query->result_array();       
    }

    public function options_tahun($default = '--Pilih Tahun--') {
        $option = array();
        $list=$this->db->query("SELECT DISTINCT(YEAR(a.tanggal)) tahun FROM DUMMY_GRAFIK a ;");
        
        if (!empty($default)) {
            $option[''] = $default;
        }

        foreach ($list->result() as $row) {
            $option[$row->tahun] = $row->tahun;
        }
        return $option;            
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
        $this->db->close();
        return $option;
    }

    public function options_reg_ss($default = '--Pilih Regional--', $key = 'all') {
        $option = array();

        $this->db->from('T_GBMO_REGIONAL');
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

    public function options_lv1_ss($default = '--Pilih Level 1--', $key = 'all', $jenis=0) {
        $this->db->from('T_GBMO_INDUK');
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

    public function options_lv2_ss($default = '--Pilih Level 2--', $key = 'all', $jenis=0) {
        $this->db->from('T_GBMO_PELAKSANA');
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

    public function options_lv4_ss($default = '--Pilih Pembangkit--', $key = 'all', $jenis=0) {
        $this->db->from('T_GBMO_PEMBANGKIT');
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
                $option[$row->SLOC] = $row->LEVEL4;
            }
            $rest = $option;    
        }
        $this->db->close();
        return $rest;
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

    // public function options_hop($default = '--Pilih HOP--') {
    //     $option = array();

    //     $q = "SELECT VALUE_SETTING, NAME_SETTING, ID FROM DATA_SETTING
    //     ORDER BY ID DESC LIMIT 1";
    //     // AND EFFECTIVE_DATE = DATE(NOW())";

    //     $sql = $this->db->query($q);
    //     $list = $sql->row();

    //     if (!empty($default)) {
    //         $option[''] = $default;
    //     }

    //     foreach ($list->result() as $row) {
    //         $option[$row->VALUE_SETTING] = $row->NAME_SETTING;
    //     }

    //     $this->db->close();
    //     return $option;
    // }

    public function get_hop()
    {
        $q = "SELECT FROM_DAY_RED, FROM_DAY_YELLOW, FROM_DAY_GREEN, FROM_DAY_BLUE FROM MASTER_HOP
        WHERE IS_AKTIF = 1 
        AND CURDATE() >= EFFECTIVE_DATE
        ORDER BY ID DESC LIMIT 1";

        $sql = $this->db->query($q);
        $list = $sql->row();
        $this->db->close();
        return $list;
    }
}

/* End of file unit_model.php */
/* Location: ./application/modules/unit/models/unit_model.php */