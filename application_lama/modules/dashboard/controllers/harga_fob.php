<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class harga_fob extends MX_Controller{
    private $_title = 'Grafik Harga BBM';
    private $_limit = 10;
    private $_module = 'dashboard/harga_fob';

    function __construct(){
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);        

        $this->load->model('harga_fob_model', 'tbl_get');
    }

    public function index() {
        $this->laccess->update_log();
        $this->load->module("template/asset");

        $this->asset->set_plugin(array('highchart'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('crud', 'format_number'));

        $data['reg_options'] = $this->tbl_get->options_reg();
        $data['options_lv4_cif'] = $this->tbl_get->options_lv4_cif();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        echo Modules::run("template/admin", $data);
    }

    function getDataHargaFOB() {

        $data = array(
            'TAHUN' => $this->input->post('TAHUN'),
        );

        $data = $this->tbl_get->getDataHargaFOB($data);
        echo json_encode($data);
    }

    function getDataHargaCIF() {
        extract($_POST);
        $data = array(
            'TAHUN' => $this->input->post('TAHUN'),
            'LEVEL' => $this->input->post('LEVEL'),
            'VLEVELID' => $this->input->post('VLEVELID'),
        );

        $data = $this->tbl_get->getDataHargaCIF($data);
        echo json_encode($data);
    }
   
}

