<?php

class grafik_persentase extends MX_Controller{
    private $_title  = 'Grafik Jumlah Login User';
    private $_limit  = 10;
    private $_module = 'dashboard/grafik_persentase';

    public function __construct(){
        parent::__construct();

        // $this->laccess->check();
        // $this->laccess->otoritas('view', true);
        
        // $this->load->model('grafik_persentase_model', 'grafik_persentase');
    }

    public function index(){

        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));        
        $this->asset->set_plugin(array('highchart'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('bootstrap-rakhmat', 'font-awesome'));

        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';

        echo Modules::run('template/admin', $data);
    }

}