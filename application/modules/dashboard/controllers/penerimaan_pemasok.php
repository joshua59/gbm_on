<?php

/**
 * @module Dashboard
 * @author CF
 * @created at 10 OKTOBER 2018
 * @modified at 11 OKTOBER 20178
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Dahsboard
 */

class penerimaan_pemasok extends MX_Controller{
    private $_title  = 'Penerimaan Per Pemasok';
    private $_limit  = 10;
    private $_module = 'dashboard/penerimaan_pemasok';

    public function __construct(){
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        $this->load->model('penerimaan_pemasok_model', 'tbl_get');
    }

    public function index(){
        // Load Modules
        $this->laccess->update_log();
        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        // $this->asset->set_plugin(array('crud', 'format_number'));        
        $this->asset->set_plugin(array('highchart'));

        $data = $this->get_level_user(); 

        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');

        echo Modules::run('template/admin', $data);
    }

    public function get_data(){
        $data = array(
            'jenis_bbm' => $this->input->post('jenis_bbm'),
            'tglAwal'   => $this->input->post('tglAwal'),
            'tglAkhir'  => $this->input->post('tglAkhir'),
            'vlevel'    => $this->input->post('vlevel'),
            'vlevelid'  => $this->input->post('vlevelid'),
            'pemasok'  => $this->input->post('pemasok'),
            'cari'  => $this->input->post('cari')            
        );

        $data = $this->tbl_get->get_data($data);
        echo json_encode($data);
    }

    public function get_data_tabel(){
        $data = array(
            'jenis_bbm' => $this->input->post('jenis_bbm'),
            'tglAwal'   => $this->input->post('tglAwal'),
            'tglAkhir'  => $this->input->post('tglAkhir'),
            'vlevel'    => $this->input->post('vlevel'),
            'vlevelid'  => $this->input->post('vlevelid'),
            'pemasok'  => $this->input->post('pemasok'),
            'cari'  => $this->input->post('cari')            
        );

        $data = $this->tbl_get->get_data_tabel($data);
        echo json_encode($data);
    }    

    public function get_level_user(){
        $data['lv1_options']     = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options']     = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options']     = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options']     = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

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
        } elseif ($level_user == 3) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC]  = $data_lv[0]->LEVEL3;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $option_lv3;
            $data['lv4_options']                  = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } elseif ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } elseif ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } elseif ($level_user == 0) {
            if ($kode_level == 00) {
                $data['reg_options'] = $this->tbl_get->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options']                  = $option_reg;
                $data['lv1_options']                  = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }
        
        $data['opsi_bbm']   = $this->tbl_get->option_jenisbbm();
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();

        return $data;
    }   

    public function get_options_lv1($key=null) {
        $message = $this->tbl_get->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv2($key=null) {
        $message = $this->tbl_get->options_lv2('--Pilih Level 2--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv3($key=null) {
        $message = $this->tbl_get->options_lv3('--Pilih Level 3--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv4($key=null) {
        $message = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $key, 0);
        echo json_encode($message);
    }     
}
