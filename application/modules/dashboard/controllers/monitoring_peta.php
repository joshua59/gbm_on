<?php

/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Dashboard Peta Jalur Pasokan
 */
class monitoring_peta extends MX_Controller {

    private $_title = 'MONITORING PETA';
    private $_limit = 10;
    private $_module = 'dashboard/monitoring_peta';

    public function __construct() {
        parent::__construct();

        // Protection
        // hprotection::login();

        /* Load Global Model */
        $this->load->model('monitoring_peta_model');
    }

    public function index() {
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS 
        $this->asset->set_plugin(array('map_osm', 'font-awesome','crud'));

        $data = $this->get_level_user();

        // $data['hop'] = $this->tbl_get->options_hop();
        $data['hop'] = array('' => '-- Pilih SHO/HOP --','1' => 'Merah', '2' => 'Kuning', '3' => 'Hijau', '4' => 'Biru');
        // $data['hop'] = array('' => '-- Pilih SHO/HOP --','2' => 'Merah', '7' => 'Kuning', '8' => 'Hijau', '9' => 'Biru');
        $data['page_title'] = '<i class="icon-map"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function get_peta() {
        $rest = $this->monitoring_peta_model->call_peta();
        // print_r($rest);die();
        echo json_encode($rest);
    }

    public function get_peta_non_depo() {
        $rest = $this->monitoring_peta_model->call_peta_non_depo();
        // print_r($rest);die();
        echo json_encode($rest);
    }

    public function get_jalur_lama() {
        $jenis = $this->input->post('jenis');
        $id = $this->input->post('id');
        $rest = $this->monitoring_peta_model->get_jalur($jenis, $id);
        echo json_encode($rest);
    }

    public function get_jalur() {        
        $rest = $this->monitoring_peta_model->call_jalur();
        echo json_encode($rest);
    }

    public function get_hop() {        
        $rest = $this->monitoring_peta_model->get_hop();
        echo json_encode($rest);
    }

    public function load($page = 1){
        $rest = $this->monitoring_peta_model->get_peta();
        echo json_encode($rest);
    }

    public function get_level_user(){   
        $data['lv1_options'] = $this->monitoring_peta_model->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->monitoring_peta_model->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->monitoring_peta_model->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->monitoring_peta_model->options_lv4('--Pilih Pembangkit--', '-', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->monitoring_peta_model->get_level($level_user, $kode_level);

        if ($level_user == 4) {
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
        } else if ($level_user == 3) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $this->monitoring_peta_model->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->monitoring_peta_model->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->monitoring_peta_model->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user == 0) {
            if ($kode_level == 00) {
                $data['reg_options'] = $this->monitoring_peta_model->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->monitoring_peta_model->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        return $data;
    }

    public function get_options_lv1($key=null) {
        $message = $this->monitoring_peta_model->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv2($key=null) {
        $message = $this->monitoring_peta_model->options_lv2('--Pilih Level 2--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv3($key=null) {
        $message = $this->monitoring_peta_model->options_lv3('--Pilih Level 3--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv4($key=null) {
        $message = $this->monitoring_peta_model->options_lv4('--Pilih Pembangkit--', $key, 0);
        echo json_encode($message);
    }

}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
