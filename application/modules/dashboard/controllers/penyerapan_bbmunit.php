<?php

/**
 * @module GRAFIK PENYERAPAN BBM UNIT
 * @author BAKTI DWI DHARMA WIJAYA
 * @created at 04 APRIL 2019
 * @modified at -
 */


if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class penyerapan_bbmunit extends MX_Controller
{
    private $_title  = 'Penyerapan BBM Per Unit';
    private $_limit  = 10;
    private $_module = 'dashboard/penyerapan_bbmunit';

    public function __construct()
    {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        
        /* Load Global Model */
        $this->load->model('penyerapan_bbmunit_model', 'tbl_get');
    }

    public function index()
    {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('highchart'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('font-awesome'));

        $data = $this->get_level_user();

        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function get_grafik_penerimaan()
    {
        $data = array(
            'tglawal'      => $this->input->post('TGLAWAL'),
            'tglakhir'    => $this->input->post('TGLAKHIR'),
            'vlevel'    => $this->input->post('LEVEL'),
            'vlevelid'   => $this->input->post('LEVEL_ID'),
        );
        $data = $this->tbl_get->get_grafik_penerimaan($data);
        echo json_encode($data);
    }

    public function get_level_user()
    {
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user, $kode_level);

        if ($level_user == 4) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC]  = $data_lv[0]->LEVEL3;
            $option_lv4[$data_lv[0]->SLOC]        = $data_lv[0]->LEVEL4;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $option_lv3;
            $data['lv4_options']                  = $option_lv4;
        } else if ($level_user == 3) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC]  = $data_lv[0]->LEVEL3;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $option_lv3;
            $data['lv4_options']                  = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user == 0) {
            if ($kode_level == 00) {
                $data['reg_options'] = $this->tbl_get->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options']                  = $option_reg;
                $data['lv1_options']                  = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();

        return $data;
    }

    function get_tabel_penerimaan() {
        $data = array(
            'tglawal'      => $this->input->post('TGLAWAL'),
            'tglakhir'    => $this->input->post('TGLAKHIR'),
            'vlevel'    => $this->input->post('LEVEL'),
            'vlevelid'   => $this->input->post('LEVEL_ID'),
        );
        $str = '';
        $sum_reg = 0;
        $t_target = 0;
        $t_penerimaan = 0;
        $penerimaan = $this->tbl_get->get_tabel_penerimaan($data);

        foreach($penerimaan as $val){
            $str.= "<tr>";

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

            $str.= "<td>".$val['LEVEL1']."</td>";
            $str.= "<td style='text-align:right'>".number_format($val['TOTAL_TARGET'],2,',','.')."</td>";
            $str.= "<td style='text-align:right'>".number_format($val['TOTAL_PENERIMAAN'],2,',','.')."</td>";
            $str.= "<td style='text-align:right'>".number_format(($val['TOTAL_PENERIMAAN'] / $val['TOTAL_TARGET']) * 100,2)."</td>";
            $str.= "</tr>";
            $t_target += $val['TOTAL_TARGET'];
            $t_penerimaan += $val['TOTAL_PENERIMAAN'];           
            $t_persen = ($t_penerimaan / $t_target) * 100; 
        }
        $str.= "<tr style='background-color:#B0C4DE'>";
        $str.= "<th style='text-align:right;background-color:#B0C4DE;font-weight:bold;' colspan='2'>TOTAL </th>";
        $str.= "<th style='text-align:right;background-color:#B0C4DE;font-weight:bold;'>".number_format($t_target,2,',','.')."</th>";
        $str.= "<th style='text-align:right;background-color:#B0C4DE;font-weight:bold;'>".number_format($t_penerimaan,2,',','.')."</th>";
        $str.= "<th style='text-align:right;background-color:#B0C4DE;font-weight:bold;'>".number_format($t_persen,2)."</th>";
        $str.= "</tr>"; 
        echo $str;
    }

    public function get_grafik_pemakaian() {
        $data = array(
            'tglawal'      => $this->input->post('TGLAWAL'),
            'tglakhir'    => $this->input->post('TGLAKHIR'),
            'vlevel'    => $this->input->post('LEVEL'),
            'vlevelid'   => $this->input->post('LEVEL_ID'),
        );
        $data = $this->tbl_get->get_grafik_pemakaian($data);
        echo json_encode($data);
    }
    function get_tabel_pemakaian() {
        $data = array(
            'tglawal'      => $this->input->post('TGLAWAL'),
            'tglakhir'    => $this->input->post('TGLAKHIR'),
            'vlevel'    => $this->input->post('LEVEL'),
            'vlevelid'   => $this->input->post('LEVEL_ID'),
        );
        $t_target = 0;
        $t_pemakaian = 0;
        $str = '';
        $sum_reg = 0;
        $pemakaian = $this->tbl_get->get_tabel_pemakaian($data);

        foreach($pemakaian as $val){
            $str.= "<tr>";

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

            $str.= "<td>".$val['LEVEL1']."</td>";
            $str.= "<td style='text-align:right'>".number_format($val['TOTAL_TARGET'],2,',','.')."</td>";
            $str.= "<td style='text-align:right'>".number_format($val['TOTAL_PEMAKAIAN'],2,',','.')."</td>";
            $str.= "<td style='text-align:right'>".number_format(($val['TOTAL_PEMAKAIAN'] / $val['TOTAL_TARGET']) * 100,2)."</td>";
            $str.= "</tr>"; 
            $t_target += $val['TOTAL_TARGET'];
            $t_pemakaian += $val['TOTAL_PEMAKAIAN'];           
            $t_persen = ($t_pemakaian / $t_target) * 100;               
        }
        $str.= "<tr style='background-color:#B0C4DE'>";
        $str.= "<th style='text-align:right;background-color:#B0C4DE;font-weight:bold;' colspan='2'>TOTAL </th>";
        $str.= "<th style='text-align:right;background-color:#B0C4DE;font-weight:bold;'>".number_format($t_target,2,',','.')."</th>";
        $str.= "<th style='text-align:right;background-color:#B0C4DE;font-weight:bold;'>".number_format($t_pemakaian,2,',','.')."</th>";
        $str.= "<th style='text-align:right;background-color:#B0C4DE;font-weight:bold;'>".number_format($t_persen,2)."</th>";
        $str.= "</tr>"; 

        echo $str;
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

    public function get_options_lv1($key = null)
    {
        $message = $this->tbl_get->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    // public function get_options_lv2($key = null)
    // {
    //     $message = $this->tbl_get->options_lv2('--Pilih Level 2--', $key, 0);
    //     echo json_encode($message);
    // }

    // public function get_options_lv3($key = null)
    // {
    //     $message = $this->tbl_get->options_lv3('--Pilih Level 3--', $key, 0);
    //     echo json_encode($message);
    // }

    // public function get_options_lv4($key = null)
    // {
    //     $message = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $key, 0);
    //     echo json_encode($message);
    // }

}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
