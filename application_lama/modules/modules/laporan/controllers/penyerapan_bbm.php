<?php
/**
 * User: CF
 * Date: 02/10/2018
 * Time: 09:10 AM
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @module Laporan
 * @author CF
 */


class penyerapan_bbm extends MX_Controller{
    private $_title  = 'Penyerapan BBM Per Jenis BBM';
    private $_limit  = 10;
    private $_module = 'laporan/penyerapan_bbm';

    public function __construct(){
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        
        $this->load->model('penyerapan_bbm_model', 'tbl_get');
    }    

    public function index(){
        // Load Modules
        $this->laccess->update_log();
        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));

        $data = $this->get_level_user(); 

        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');

        echo Modules::run('template/admin', $data);
    }    

    public function loadx($page = 1){
        echo $page;
    }       

    public function get_options_lv1($key=null) {
        $message = $this->tbl_get->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }    
        
    public function export_excel(){
        $key = $this->input->post('xjenis');

        $data                = array(
            'ID_REGIONAL'      => $this->input->post('xlvl'),
            'COCODE'           => $this->input->post('xlvl1'),
            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'),
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'LEVEL'            => $this->input->post('xlvl'),
            'LEVEL_ID'         => $this->input->post('xlvlid'),
            'TGLAWAL'          => $this->input->post('xtglawal'),
            'TGLAKHIR'         => $this->input->post('xtglakhir'),
            'JENIS'            => 'XLS',
            'tipe'             => $key
        );

        $tgl_awal = $this->input->post('xtglawal');
        $tgl_akhir = $this->input->post('xtglakhir');
        $date_awal = DateTime::createFromFormat('Ymd', $tgl_awal);
        $date_akhir = DateTime::createFromFormat('Ymd', $tgl_akhir);
        if($key == '1') {
            $penerimaan = $this->tbl_get->export_penerimaan($data);
            $data['penerimaan'] = $this->get_penerimaan($penerimaan);       
            $penerimaan_total   = $this->tbl_get->export_penerimaan_total($data);
            $data['t_penerimaan'] = $this->get_total_penerimaan($penerimaan_total); 
            $data['pemakaian']  = false;
            $data['periode']    = '<br>Periode '.$date_awal->format('d-m-Y').' s/d '.$date_akhir->format('d-m-Y');
        } else {
            $data['penerimaan'] = false;
            $pemakaian  = $this->tbl_get->export_pemakaian($data);
            $data['pemakaian']  = $this->get_pemakaian($pemakaian);
            $pemakaian_total = $this->tbl_get->export_pemakaian_total($data);
            $data['pemakaian_total'] = $this->get_total_pemakaian($pemakaian_total);
            $data['periode']    = '<br>Periode '.$date_awal->format('d-m-Y').' s/d '.$date_akhir->format('d-m-Y');
        }
                
        $this->load->view($this->_module . '/export_excel', $data);
    }

    public function export_pdf(){
        $key = $this->input->post('pjenis');
        $data                = array(
            'ID_REGIONAL'      => $this->input->post('plvl'),
            'COCODE'           => $this->input->post('plvl1'),
            'JNS_BBM'          => $this->input->post('pbbm'),
            'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'),
            'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
            'JNS_BBM_NAMA'     => $this->input->post('pbbm_nama'),
            'LEVEL'            => $this->input->post('plvl'),
            'LEVEL_ID'         => $this->input->post('plvlid'),
            'TGLAWAL'          => $this->input->post('ptglawal'),
            'TGLAKHIR'         => $this->input->post('ptglakhir'),
            'tipe'             => $key,
            'JENIS'            => 'PDF'
        );        
        $tgl_awal = $this->input->post('ptglawal');
        $tgl_akhir = $this->input->post('ptglakhir');
        $date_awal = DateTime::createFromFormat('Ymd', $tgl_awal);
        $date_akhir = DateTime::createFromFormat('Ymd', $tgl_akhir);
        if($key == '1') {
            $penerimaan = $this->tbl_get->export_penerimaan($data);
            $data['penerimaan'] = $this->get_penerimaan($penerimaan);       
            $penerimaan_total   = $this->tbl_get->export_penerimaan_total($data);
            $data['t_penerimaan'] = $this->get_total_penerimaan($penerimaan_total); 
            $data['pemakaian']  = false;
            $data['periode']    = '<br>Periode '.$date_awal->format('d-m-Y').' s/d '.$date_akhir->format('d-m-Y');
        } else {
            $data['penerimaan'] = false;
            $pemakaian  = $this->tbl_get->export_pemakaian($data);
            $data['pemakaian']  = $this->get_pemakaian($pemakaian);
            $pemakaian_total = $this->tbl_get->export_pemakaian_total($data);
            $data['pemakaian_total'] = $this->get_total_pemakaian($pemakaian_total);
            $data['periode']    = '<br>Periode '.$date_awal->format('d-m-Y').' s/d '.$date_akhir->format('d-m-Y');
        }
        $html_source  = $this->load->view($this->_module . '/export_excel', $data, true);  

        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_Penyerapan_BBM.pdf');
        $this->lpdf->cetak('A4-L');

    }       

    function get_sum_persen($arr, $lv1, $cari, $is_hsd){
        $x=0;
        $target=0;

        if ($cari=='HSD' && $is_hsd!='HSD'){
            $cari='BIO';
        }

        foreach($arr as $val) {
            if ($val['COCODE'] == $lv1 && $val['GROUP_NAMA'] == $cari) {
                $x = $x+$val['REALISASI_PENERIMAAN_SPLIT'];   

                $target = $val['TARGET'];

                if ($cari=='HSD' && $val['GROUP_NAMA_BBM']=='HSD') {
                    $target_hsd = $val['TARGET'];
                }                 
            }
        }  

        if ($cari=='HSD' && $is_hsd=='HSD') {
            $target = $target_hsd;
        }  

        $x = ((float)$x/(float)$target)*100;

        return $x;                  
    }

    function get_sum_persen_d($arr, $cari, $is_hsd){
        $x=0;
        $target=0;

        if ($cari=='HSD' && $is_hsd!='HSD'){
            $cari='BIO';
        }

        foreach($arr as $val) {
            if ($val['GROUP_NAMA'] == $cari) {
                $x = $x+$val['REALISASI_PENERIMAAN_SPLIT'];   

                $target = $val['TARGET'];

                if ($cari=='HSD' && $val['GROUP_NAMA_BBM']=='HSD') {
                    $target_hsd = $val['TARGET'];
                }                 
            }
        }  

        if ($cari=='HSD' && $is_hsd=='HSD') {
            $target = $target_hsd;
        }  

        $x = ((float)$x/(float)$target)*100;

        return $x;                  
    }    

    function get_sum_lv($arr, $key, $cari){        
        $x=0;
        foreach($arr as $val) {
            if ($val[$key] == $cari) {
                $x++;                               
            }
        }  
        return $x;                  
    }

    function get_sum($arr, $lv1, $key, $cari){
        $x=0;
        foreach($arr as $val) {
            if ($val['COCODE'] == $lv1 && $val[$key] == $cari) {
                $x++;                               
            }
        }  
        return $x;                  
    }

    function to_rp($val){
        return number_format($val,2,',','.');
    }

    public function get_table_penerimaan(){
        $data['TGLAWAL']       = $this->input->post('TGLAWAL');
        $data['TGLAKHIR']      = $this->input->post('TGLAKHIR');
        $data['LEVEL']         = $this->input->post('LEVEL');
        $data['LEVEL_ID']      = $this->input->post('LEVEL_ID');
        $data['JNS_BBM']       = $this->input->post('JNS_BBM');

        $penerimaan            = $this->tbl_get->export_penerimaan($data);

        $no = 1;
        $sum_no = 0;
        $sum_reg = 0;
        $sum_lv1 = 0;
        $sum_jns_bbm = 0;
        $sum_komp_bbm = 0;
        $sum_persen = 0;
        $str = '';
        foreach($penerimaan as $val){
            $str.= "<tr>";

            if ($sum_no == 0){
                $sum_no = $this->get_sum_lv($penerimaan,'LEVEL1',$val['LEVEL1']);

                if ($sum_no>1){
                    $str.= "<td rowspan='".$sum_no."' style='text-align:center;'>".$no."</td>";
                    $sum_no--;    
                    $no++;
                } else {
                    $str.= "<td style='text-align:center;'>".$no."</td>";
                    $sum_no=0;
                }
            } else {
                $sum_no--;
            }         

            if ($sum_reg==0){
                $sum_reg = $this->get_sum_lv($penerimaan,'NAMA_REGIONAL',$val['NAMA_REGIONAL']);

                if ($sum_reg>1){
                    $str.= "<td rowspan='".$sum_reg."'>".$val['NAMA_REGIONAL']."</td>";
                    $sum_reg--;    
                } else {
                    $str.= "<td>".$val['NAMA_REGIONAL']."</td>";
                    $sum_reg=0;
                }
            } else {
                $sum_reg--;
            }

            if ($sum_lv1==0){
                $sum_lv1 = $this->get_sum_lv($penerimaan,'LEVEL1',$val['LEVEL1']);

                if ($sum_lv1>1){
                    $str.= "<td rowspan='".$sum_lv1."'>".$val['LEVEL1']."</td>";
                    $sum_lv1--;    
                } else {
                    $str.= "<td>".$val['LEVEL1']."</td>";
                    $sum_lv1=0;
                }
            } else {
                $sum_lv1--;
            }

            if ($sum_jns_bbm==0){
                $sum_jns_bbm = $this->get_sum($penerimaan,$val['COCODE'],'GROUP_NAMA_BBM',$val['GROUP_NAMA_BBM']);

                if ($sum_jns_bbm>1){
                    $str.= "<td rowspan='".$sum_jns_bbm."' style='text-align:center;'>".$val['GROUP_NAMA_BBM']."</td>";
                    $str.= "<td rowspan='".$sum_jns_bbm."' style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";
                    $sum_jns_bbm--;    
                } else {
                    $str.= "<td style='text-align:center;'>".$val['GROUP_NAMA_BBM']."</td>";
                    $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";
                    $sum_jns_bbm=0;
                }
            } else {
                $sum_jns_bbm--;
            }

            if ($sum_komp_bbm==0){
                $sum_komp_bbm = $this->get_sum($penerimaan,$val['COCODE'],'NAMA_BBM',$val['NAMA_BBM']);

                if ($sum_komp_bbm>1){
                    $str.= "<td rowspan='".$sum_komp_bbm."' style='text-align:center;'>".$val['NAMA_BBM']."</td>";
                    $str.= "<td rowspan='".$sum_komp_bbm."' style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN'])."</td>";
                    $sum_komp_bbm--;
                } else {
                    $str.= "<td style='text-align:center;'>".$val['NAMA_BBM']."</td>";
                    $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN'])."</td>";
                    $sum_komp_bbm=0;
                }
            } else {
                $sum_komp_bbm--;
            }                
                                                                                            
            $str.= "<td style='text-align:center;'>".$val['NAMA_SPLIT']."</td>";                
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN_SPLIT'])."</td>";             

            if ($sum_persen==0){
                $sum_persen = $this->get_sum($penerimaan,$val['COCODE'],'GROUP_NAMA_BBM',$val['GROUP_NAMA_BBM']);

                $persen = $this->get_sum_persen($penerimaan,$val['COCODE'],$val['GROUP_NAMA'],$val['GROUP_NAMA_BBM']);
                if ($sum_persen>1){                        
                    $str.= "<td rowspan='".$sum_persen."' style='text-align:right;'>".$this->to_rp($persen)."</td>";                        
                    $sum_persen--;    
                } else {                        
                    $str.= "<td style='text-align:right;'>".$this->to_rp($persen)."</td>";
                    $sum_persen=0;
                }
            } else {
                $sum_persen--;
            }

            $str.= "</tr>";                
        }

        echo $str;
    }

    public function get_table_penerimaan_total(){
        $data['TGLAWAL']       = $this->input->post('TGLAWAL');
        $data['TGLAKHIR']      = $this->input->post('TGLAKHIR');
        $data['LEVEL']         = $this->input->post('LEVEL');
        $data['LEVEL_ID']      = $this->input->post('LEVEL_ID');
        $data['JNS_BBM']       = $this->input->post('JNS_BBM');

        $penerimaan_total      = $this->tbl_get->export_penerimaan_total($data);

        $sum_jns_bbm_d = 0;
        $sum_jns_komponen_d = 0;
        $sum_persen_d = 0;
        $sum_reg = 0;
        $total_rkap = 0;
        $total_vol1 = 0;
        $total_vol2 = 0;
        $str = '';


        foreach($penerimaan_total as $val){
            $str.= "<tr>";
            if ($sum_reg==0){
                $sum_reg = $this->get_sum_lv($penerimaan_total,'UNIT',$val['UNIT']);
                $nama = $val['UNIT'] == '' ? 'Pusat' : $val['UNIT'];
                if ($sum_reg>1){
                    $str.= "<td rowspan='".$sum_reg."' style='text-align:left;'>".$nama."</td>";
                    $sum_reg--;    
                    $no++;
                } else {
                    $str.= "<td style='text-align:left;'>".$nama."</td>";
                    $sum_reg=0;
                }
            } else {
                $sum_reg--;
            }   
            if ($sum_jns_bbm_d==0){
                $sum_jns_bbm_d = $this->get_sum_lv($penerimaan_total,'GROUP_NAMA_BBM',$val['GROUP_NAMA_BBM']);

                if ($sum_jns_bbm_d>1){
                    $str.= "<td rowspan='".$sum_jns_bbm_d."'>TOTAL ".$val['GROUP_NAMA_BBM']."</td>";
                    $str.= "<td rowspan='".$sum_jns_bbm_d."' style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";
                    $total_rkap = $total_rkap+$val['TARGET'];
                    $sum_jns_bbm_d--;    
                } else {
                    $str.= "<td>TOTAL ".$val['GROUP_NAMA_BBM']."</td>";
                    $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";
                    $total_rkap = $total_rkap+$val['TARGET'];
                    $sum_jns_bbm_d=0;
                }
            } else {
                $sum_jns_bbm_d--;
            }

            if ($sum_jns_komponen_d==0){
                $sum_jns_komponen_d = $this->get_sum_lv($penerimaan_total,'NAMA_BBM',$val['NAMA_BBM']);

                if ($sum_jns_komponen_d>1){
                    $str.= "<td rowspan='".$sum_jns_komponen_d."' style='text-align:center;'>".$val['NAMA_BBM']."</td>";
                    $str.= "<td rowspan='".$sum_jns_komponen_d."' style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN'])."</td>";
                    $total_vol1 = $total_vol1+$val['REALISASI_PENERIMAAN'];
                    $sum_jns_komponen_d--;    
                } else {
                    $str.= "<td style='text-align:center;'>".$val['NAMA_BBM']."</td>";
                    $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN'])."</td>";
                    $total_vol1 = $total_vol1+$val['REALISASI_PENERIMAAN'];
                    $sum_jns_komponen_d=0;
                }
            } else {
                $sum_jns_komponen_d--;
            }                    
                       
                                                                                                                
            $str.= "<td style='text-align:center;'>".$val['NAMA_SPLIT']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN_SPLIT'])."</td>";
            $total_vol2 = $total_vol2+$val['REALISASI_PENERIMAAN_SPLIT'];

            if ($sum_persen_d==0){
                $sum_persen_d = $this->get_sum_lv($penerimaan_total,'GROUP_NAMA_BBM',$val['GROUP_NAMA_BBM']);
                $persen_d = $this->get_sum_persen_d($penerimaan_total,$val['GROUP_NAMA'],$val['GROUP_NAMA_BBM']);

                if ($sum_persen_d>1){
                    $str.= "<td rowspan='".$sum_persen_d."' style='text-align:right;'>".$this->to_rp($persen_d)."</td>";
                    $sum_persen_d--;    
                } else {                            
                    $str.= "<td style='text-align:right;'>".$this->to_rp($persen_d)."</td>";
                    $sum_persen_d=0;
                }
            } else {
                $sum_persen_d--;
            }                    

            $str.= "</tr>";
        }

        if ($str){
            $str.= "<tr >";
            $str.= "<th style='text-align: right' colspan='2'>TOTAL SELURUH JENIS BBM :</th>";
            $str.= "<th style='text-align: right'>".$this->to_rp($total_rkap)."</th>";
            $str.= "<th></th>";
            $str.= "<th style='text-align: right'>".$this->to_rp($total_vol1)."</th>";
            $str.= "<th></th>";
            $str.= "<th style='text-align: right'>".$this->to_rp($total_vol2)."</th>";
            $str.= "<th style='text-align: right'>".$this->to_rp(($total_vol2/$total_rkap)*100)."</th>";
            $str.= "</tr>";
        }
        echo $str;
    }

    public function get_table_pemakaian(){
        $data['TGLAWAL']       = $this->input->post('TGLAWAL');
        $data['TGLAKHIR']      = $this->input->post('TGLAKHIR');
        $data['LEVEL']         = $this->input->post('LEVEL');
        $data['LEVEL_ID']      = $this->input->post('LEVEL_ID');
        $data['JNS_BBM']       = $this->input->post('JNS_BBM');

        $pemakaian             = $this->tbl_get->export_pemakaian($data);

        $no = 1;
        $sum_no = 0;
        $sum_reg = 0;
        $sum_lv1 = 0;
        $str = '';

        foreach($pemakaian as $val){
            $str.= "<tr>";

            if ($sum_no==0){
                $sum_no = $this->get_sum_lv($pemakaian,'LEVEL1',$val['LEVEL1']);

                if ($sum_no>1){
                    $str.= "<td rowspan='".$sum_no."' style='text-align:left;'>".$no."</td>";
                    $sum_no--;    
                    $no++;
                } else {
                    $str.= "<td style='text-align:left;'>".$no."</td>";
                    $sum_no=0;
                }
            } else {
                $sum_no--;
            }         

            if ($sum_reg==0){
                $sum_reg = $this->get_sum_lv($pemakaian,'NAMA_REGIONAL',$val['NAMA_REGIONAL']);

                if ($sum_reg>1){
                    $str.= "<td rowspan='".$sum_reg."'>".$val['NAMA_REGIONAL']."</td>";
                    $sum_reg--;    
                } else {
                    $str.= "<td>".$val['NAMA_REGIONAL']."</td>";
                    $sum_reg=0;
                }
            } else {
                $sum_reg--;
            }

            if ($sum_lv1==0){
                $sum_lv1 = $this->get_sum_lv($pemakaian,'LEVEL1',$val['LEVEL1']);

                if ($sum_lv1>1){
                    $str.= "<td rowspan='".$sum_lv1."'>".$val['LEVEL1']."</td>";
                    $sum_lv1--;    
                } else {
                    $str.= "<td>".$val['LEVEL1']."</td>";
                    $sum_lv1=0;
                }
            } else {
                $sum_lv1--;
            }

            $str.= "<td style='text-align:center;'>".$val['GROUP_BBM']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";
            $str.= "<td style='text-align:center;'>".$val['GROUP_BBM_REAL']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET_REAL'])."</td>";
            $str.= "<td style='text-align:center;'>".$val['GROUP_BBM_REAL']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PEMAKAIAN'])."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['PERSEN_PAKAI'])."</td>";
            $str.= "</tr>";                
        }

        echo $str;
    }  

    public function get_table_pemakaian_total(){
        $data['TGLAWAL']       = $this->input->post('TGLAWAL');
        $data['TGLAKHIR']      = $this->input->post('TGLAKHIR');
        $data['LEVEL']         = $this->input->post('LEVEL');
        $data['LEVEL_ID']      = $this->input->post('LEVEL_ID');
        $data['JNS_BBM']       = $this->input->post('JNS_BBM');

        $pemakaian_total      = $this->tbl_get->export_pemakaian_total($data);
        $no = 0;
        $sum_jns_bbm_d = 0;
        $sum_jns_komponen_d = 0;
        $sum_persen_d = 0;
        $sum_reg = 0;
        $total_rkap = 0;
        $total_vol1 = 0;
        $total_vol2 = 0;
        $str = '';

        foreach($pemakaian_total as $val){
            $str.= "<tr>";
            if ($sum_reg==0){
                $sum_reg = $this->get_sum_lv($pemakaian_total,'UNIT',$val['UNIT']);
                $nama = $val['UNIT'];
                if ($sum_reg>1){
                    $str.= "<td rowspan='".$sum_reg."' style='text-align:left;'>".$nama."</td>";
                    $sum_reg--;    
                    $no++;
                } else {
                    $str.= "<td style='text-align:left;'>".$nama."</td>";
                    $sum_reg=0;
                }
            } else {
                $sum_reg--;
            }   
            $str.= "<td>TOTAL ".$val['GROUP_BBM']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";                    
            $str.= "<td style='text-align:center;'>".$val['GROUP_BBM_REAL']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET_REAL'])."</td>";
            $str.= "<td style='text-align:center;'>".$val['GROUP_BBM_REAL']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PEMAKAIAN'])."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['PERSEN_PAKAI'])."</td>";
                                                
            $str.= "</tr>";

            $total_rkap = $total_rkap+$val['TARGET'];
            $total_vol1 = $total_vol1+$val['TARGET_REAL'];
            $total_vol2 = $total_vol2+$val['REALISASI_PEMAKAIAN'];
        }

        if ($str){
            $str.= "<tr style='background-color: #CED8F6;'>";
            $str.= "<th style='text-align: right' colspan='2'>TOTAL SELURUH JENIS BBM :</th>";
            $str.= "<th style='text-align: right'>".$this->to_rp($total_rkap)."</th>";
            $str.= "<th></th>";
            $str.= "<th style='text-align: right'>".$this->to_rp($total_vol1)."</th>";
            $str.= "<th></th>";
            $str.= "<th style='text-align: right'>".$this->to_rp($total_vol2)."</th>";
            $str.= "<th style='text-align: right'>".$this->to_rp(($total_vol2/$total_rkap)*100)."</th>";
            $str.= "</tr>";
        }
        echo $str;
    }      


    public function get_level_user(){
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');        

        $data_lv = $this->tbl_get->get_level($level_user, $kode_level);

        if ($level_user==4){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $option_lv4;
        } else if ($level_user==3){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user==2){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user==1){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user==0){
            if ($kode_level==00){
                $data['reg_options'] = $this->tbl_get->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }



        $data['opsi_bbm'] = $this->tbl_get->option_jenisbbm();
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();
        $data['opsi_pemasok'] = $this->tbl_get->options_pemasok('--Pilih Pemasok--', '-', 1);
        $data['opsi_transportir'] = $this->tbl_get->options_transportir();
        $data['opsi_komponen_bio'] = $this->tbl_get->option_komponen_bio('003','1');

        return $data;        
    } 

    public function get_penerimaan($array) {

        $no = 1;
        $sum_no = 0;
        $sum_reg = 0;
        $sum_lv1 = 0;
        $sum_jns_bbm = 0;
        $sum_komp_bbm = 0;
        $sum_persen = 0;
        $str = '';
        foreach($array as $val){
            $str.= "<tr>";

            if ($sum_no == 0){
                $sum_no = $this->get_sum_lv($array,'LEVEL1',$val['LEVEL1']);

                if ($sum_no>1){
                    $str.= "<td rowspan='".$sum_no."' style='text-align:center;'>".$no."</td>";
                    $sum_no--;    
                    $no++;
                } else {
                    $str.= "<td style='text-align:center;'>".$no."</td>";
                    $sum_no=0;
                }
            } else {
                $sum_no--;
            }         

            if ($sum_reg==0){
                $sum_reg = $this->get_sum_lv($array,'NAMA_REGIONAL',$val['NAMA_REGIONAL']);

                if ($sum_reg>1){
                    $str.= "<td rowspan='".$sum_reg."'>".$val['NAMA_REGIONAL']."</td>";
                    $sum_reg--;    
                } else {
                    $str.= "<td>".$val['NAMA_REGIONAL']."</td>";
                    $sum_reg=0;
                }
            } else {
                $sum_reg--;
            }

            if ($sum_lv1==0){
                $sum_lv1 = $this->get_sum_lv($array,'LEVEL1',$val['LEVEL1']);

                if ($sum_lv1>1){
                    $str.= "<td rowspan='".$sum_lv1."'>".$val['LEVEL1']."</td>";
                    $sum_lv1--;    
                } else {
                    $str.= "<td>".$val['LEVEL1']."</td>";
                    $sum_lv1=0;
                }
            } else {
                $sum_lv1--;
            }

            if ($sum_jns_bbm==0){
                $sum_jns_bbm = $this->get_sum($array,$val['COCODE'],'GROUP_NAMA_BBM',$val['GROUP_NAMA_BBM']);

                if ($sum_jns_bbm>1){
                    $str.= "<td rowspan='".$sum_jns_bbm."' style='text-align:center;'>".$val['GROUP_NAMA_BBM']."</td>";
                    $str.= "<td rowspan='".$sum_jns_bbm."' style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";
                    $sum_jns_bbm--;    
                } else {
                    $str.= "<td style='text-align:center;'>".$val['GROUP_NAMA_BBM']."</td>";
                    $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";
                    $sum_jns_bbm=0;
                }
            } else {
                $sum_jns_bbm--;
            }

            if ($sum_komp_bbm==0){
                $sum_komp_bbm = $this->get_sum($array,$val['COCODE'],'NAMA_BBM',$val['NAMA_BBM']);

                if ($sum_komp_bbm>1){
                    $str.= "<td rowspan='".$sum_komp_bbm."' style='text-align:center;'>".$val['NAMA_BBM']."</td>";
                    $str.= "<td rowspan='".$sum_komp_bbm."' style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN'])."</td>";
                    $sum_komp_bbm--;
                } else {
                    $str.= "<td style='text-align:center;'>".$val['NAMA_BBM']."</td>";
                    $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN'])."</td>";
                    $sum_komp_bbm=0;
                }
            } else {
                $sum_komp_bbm--;
            }                
                                                                                            
            $str.= "<td style='text-align:center;'>".$val['NAMA_SPLIT']."</td>";                
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN_SPLIT'])."</td>";             

            if ($sum_persen==0){
                $sum_persen = $this->get_sum($array,$val['COCODE'],'GROUP_NAMA_BBM',$val['GROUP_NAMA_BBM']);

                $persen = $this->get_sum_persen($array,$val['COCODE'],$val['GROUP_NAMA'],$val['GROUP_NAMA_BBM']);
                if ($sum_persen>1){                        
                    $str.= "<td rowspan='".$sum_persen."' style='text-align:right;'>".$this->to_rp($persen)."</td>";                        
                    $sum_persen--;    
                } else {                        
                    $str.= "<td style='text-align:right;'>".$this->to_rp($persen)."</td>";
                    $sum_persen=0;
                }
            } else {
                $sum_persen--;
            }

            $str.= "</tr>";                
        }  
        return $str;
    }

    public function get_total_penerimaan($array) {
        $no = 1;
        $sum_jns_bbm_d = 0;
        $sum_jns_komponen_d = 0;
        $sum_persen_d = 0;
        $sum_reg = 0;
        $total_rkap = 0;
        $total_vol1 = 0;
        $total_vol2 = 0;
        $str = '';
        $str.= '<tbody>';
        foreach($array as $val){
            $str.= "<tr>";
            if ($sum_reg==0){
                $sum_reg = $this->get_sum_lv($array,'UNIT',$val['UNIT']);
                $nama = $val['UNIT'] == '' ? 'Pusat' : $val['UNIT'];
                if ($sum_reg>1){
                    $str.= "<td rowspan='".$sum_reg."' style='text-align:left;' colspan='3'>".$nama."</td>";
                    $sum_reg--;    
                    $no++;
                } else {
                    $str.= "<td style='text-align:left;'>".$nama."</td>";
                    $sum_reg=0;
                }
            } else {
                $sum_reg--;
            }   
            if ($sum_jns_bbm_d==0){
                $sum_jns_bbm_d = $this->get_sum_lv($array,'GROUP_NAMA_BBM',$val['GROUP_NAMA_BBM']);

                if ($sum_jns_bbm_d>1){
                    $str.= "<td rowspan='".$sum_jns_bbm_d."'>TOTAL ".$val['GROUP_NAMA_BBM']."</td>";
                    $str.= "<td rowspan='".$sum_jns_bbm_d."' style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";
                    $total_rkap = $total_rkap+$val['TARGET'];
                    $sum_jns_bbm_d--;    
                } else {
                    $str.= "<td>TOTAL ".$val['GROUP_NAMA_BBM']."</td>";
                    $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";
                    $total_rkap = $total_rkap+$val['TARGET'];
                    $sum_jns_bbm_d=0;
                }
            } else {
                $sum_jns_bbm_d--;
            }

            if ($sum_jns_komponen_d==0){
                $sum_jns_komponen_d = $this->get_sum_lv($array,'NAMA_BBM',$val['NAMA_BBM']);

                if ($sum_jns_komponen_d>1){
                    $str.= "<td rowspan='".$sum_jns_komponen_d."' style='text-align:center;'>".$val['NAMA_BBM']."</td>";
                    $str.= "<td rowspan='".$sum_jns_komponen_d."' style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN'])."</td>";
                    $total_vol1 = $total_vol1+$val['REALISASI_PENERIMAAN'];
                    $sum_jns_komponen_d--;    
                } else {
                    $str.= "<td style='text-align:center;'>".$val['NAMA_BBM']."</td>";
                    $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN'])."</td>";
                    $total_vol1 = $total_vol1+$val['REALISASI_PENERIMAAN'];
                    $sum_jns_komponen_d=0;
                }
            } else {
                $sum_jns_komponen_d--;
            }                    
                       
                                                                                                                
            $str.= "<td style='text-align:center;'>".$val['NAMA_SPLIT']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PENERIMAAN_SPLIT'])."</td>";
            $total_vol2 = $total_vol2+$val['REALISASI_PENERIMAAN_SPLIT'];

            if ($sum_persen_d==0){
                $sum_persen_d = $this->get_sum_lv($array,'GROUP_NAMA_BBM',$val['GROUP_NAMA_BBM']);
                $persen_d = $this->get_sum_persen_d($array,$val['GROUP_NAMA'],$val['GROUP_NAMA_BBM']);

                if ($sum_persen_d>1){
                    $str.= "<td rowspan='".$sum_persen_d."' style='text-align:right;'>".$this->to_rp($persen_d)."</td>";
                    $sum_persen_d--;    
                } else {                            
                    $str.= "<td style='text-align:right;'>".$this->to_rp($persen_d)."</td>";
                    $sum_persen_d=0;
                }
            } else {
                $sum_persen_d--;
            }                    

            $str.= "</tr>";
        }
        $str.= "</tbody>";
        if ($str){
            $str.= "<tfoot>";
            $str.= "<tr>";
            $str.= "<th style='text-align: right;background-color: #CED8F6;' colspan='4'>TOTAL SELURUH JENIS BBM :</th>";
            $str.= "<th style='text-align: right;background-color: #CED8F6;'>".$this->to_rp($total_rkap)."</th>";
            $str.= "<th style='background-color: #CED8F6;'></th>";
            $str.= "<th style='text-align: right;background-color: #CED8F6;'>".$this->to_rp($total_vol1)."</th>";
            $str.= "<th style='background-color: #CED8F6;'></th>";
            $str.= "<th style='text-align: right;background-color: #CED8F6;'>".$this->to_rp($total_vol2)."</th>";
            $str.= "<th style='text-align: right;background-color: #CED8F6;'>".$this->to_rp(($total_vol2/$total_rkap)*100)."</th>";
            $str.= "</tfoot>";
        }
        return $str;
    }

    public function get_pemakaian($pemakaian) {
        $no = 1;
        $sum_no = 0;
        $sum_reg = 0;
        $sum_lv1 = 0;
        $str = '';

        foreach($pemakaian as $val){
            $str.= "<tr>";

            if ($sum_no==0){
                $sum_no = $this->get_sum_lv($pemakaian,'LEVEL1',$val['LEVEL1']);

                if ($sum_no>1){
                    $str.= "<td rowspan='".$sum_no."' style='text-align:left;'>".$no."</td>";
                    $sum_no--;    
                    $no++;
                } else {
                    $str.= "<td style='text-align:left;'>".$no."</td>";
                    $sum_no=0;
                }
            } else {
                $sum_no--;
            }         

            if ($sum_reg==0){
                $sum_reg = $this->get_sum_lv($pemakaian,'NAMA_REGIONAL',$val['NAMA_REGIONAL']);

                if ($sum_reg>1){
                    $str.= "<td rowspan='".$sum_reg."'>".$val['NAMA_REGIONAL']."</td>";
                    $sum_reg--;    
                } else {
                    $str.= "<td>".$val['NAMA_REGIONAL']."</td>";
                    $sum_reg=0;
                }
            } else {
                $sum_reg--;
            }

            if ($sum_lv1==0){
                $sum_lv1 = $this->get_sum_lv($pemakaian,'LEVEL1',$val['LEVEL1']);

                if ($sum_lv1>1){
                    $str.= "<td rowspan='".$sum_lv1."'>".$val['LEVEL1']."</td>";
                    $sum_lv1--;    
                } else {
                    $str.= "<td>".$val['LEVEL1']."</td>";
                    $sum_lv1=0;
                }
            } else {
                $sum_lv1--;
            }

            $str.= "<td style='text-align:center;'>".$val['GROUP_BBM']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";
            $str.= "<td style='text-align:center;'>".$val['GROUP_BBM_REAL']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET_REAL'])."</td>";
            $str.= "<td style='text-align:center;'>".$val['GROUP_BBM_REAL']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PEMAKAIAN'])."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['PERSEN_PAKAI'])."</td>";
            $str.= "</tr>";                
        }

        return $str;
    }   

    public function get_total_pemakaian($pemakaian_total) {
        $sum_jns_bbm_d = 0;
        $sum_jns_komponen_d = 0;
        $sum_persen_d = 0;
        $sum_reg = 0;
        $total_rkap = 0;
        $total_vol1 = 0;
        $total_vol2 = 0;
        $str = '';
        $no = 0;

        foreach($pemakaian_total as $val){
            $str.= "<tr>";
            if ($sum_reg==0){
                $sum_reg = $this->get_sum_lv($pemakaian_total,'UNIT',$val['UNIT']);
                $nama = $val['UNIT'] == '' ? 'Pusat' : $val['UNIT'];
                if ($sum_reg>1){
                    $str.= "<td rowspan='".$sum_reg."' style='text-align:left;' colspan='3'>".$nama."</td>";
                    $sum_reg--;    
                    $no++;
                } else {
                    $str.= "<td style='text-align:left;'>".$nama."</td>";
                    $sum_reg=0;
                }
            } else {
                $sum_reg--;
            }   
            $str.= "<td>TOTAL ".$val['GROUP_BBM']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET'])."</td>";                    
            $str.= "<td style='text-align:center;'>".$val['GROUP_BBM_REAL']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['TARGET_REAL'])."</td>";
            $str.= "<td style='text-align:center;'>".$val['GROUP_BBM_REAL']."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['REALISASI_PEMAKAIAN'])."</td>";
            $str.= "<td style='text-align:right;'>".$this->to_rp($val['PERSEN_PAKAI'])."</td>";
                                                
            $str.= "</tr>";

            $total_rkap = $total_rkap+$val['TARGET'];
            $total_vol1 = $total_vol1+$val['TARGET_REAL'];
            $total_vol2 = $total_vol2+$val['REALISASI_PEMAKAIAN'];
        }

        if ($str){
            $str.= "<tfoot>";
            $str.= "<tr>";
            $str.= "<th style='text-align: right' colspan='4'>TOTAL SELURUH JENIS BBM :</th>";
            $str.= "<th style='text-align: right'>".$this->to_rp($total_rkap)."</th>";
            $str.= "<th></th>";
            $str.= "<th style='text-align: right'>".$this->to_rp($total_vol1)."</th>";
            $str.= "<th></th>";
            $str.= "<th style='text-align: right'>".$this->to_rp($total_vol2)."</th>";
            $str.= "<th style='text-align: right'>".$this->to_rp(($total_vol2/$total_rkap)*100)."</th>";
            $str.= "</tr>";
            $str.= "</tfoot>";
        }
        return $str;
    }
   
}