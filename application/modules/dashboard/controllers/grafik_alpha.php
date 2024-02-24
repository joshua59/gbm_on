<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class grafik_alpha extends MX_Controller{
    private $_title = 'Grafik ALPHA';
    private $_limit = 10;
    private $_module = 'dashboard/grafik_alpha';

    function __construct(){
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        // Ini Hak Aksesnya ada      

        /* Load Global Model */
        $this->load->model('grafik_alpha_model', 'tbl_get');
    }
    

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('highchart'));
        $this->asset->set_plugin(array('jquery'));

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        echo Modules::run("template/admin", $data);
    }

    function getDataAlpha() {

        $data = array(
            'TAHUN' => $this->input->post('TAHUN'),
            'BULAN' => $this->input->post('BULAN'),
        );

        $data = $this->tbl_get->getDataAlpha($data);
        // print_r($data);
        echo json_encode($data);
    }

    function getTahun(){
        $message = $this->tbl_get->getTahun();
        echo json_encode($message);
    }

    function getBulan(){
        $message = $this->tbl_get->getBulan();
        echo json_encode($message);
    } 
   
}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */

