<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class list_transaksi extends MX_Controller {

    private $_title = 'List Transaksi NPPS';
    private $_limit = 10;
    private $_module = 'user_management/list_transaksi';

    public function __construct() {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        $this->load->model('list_transaksi_model','tbl_get');
        // $this->load->model('persediaan_bbm_model', 'tbl_get_lap');

    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");
        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data['button_group'] = array();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        // $data['data_sources'] = base_url($this->_module . '/load');
        $data['jenis_transaksi'] = array('' => '--Pilih Jenis Transaksi--','1' => 'Nominasi','2' => 'Pemakaian' ,'3' => 'Penerimaan' ,'4' => 'Stockopname');
        $data['reg_options'] = $this->tbl_get->options_reg();
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);
        $data['lv4_options_cari'] = $this->tbl_get->options_lv4('--Pencarian Pembangkit--', 'all', 1);

        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();

        echo Modules::run("template/admin", $data);
    }

    public function getTransaksi()
    {
        $data = array(
            'jenis'      => $this->input->post('JENIS'),
            'idRegional' => $this->input->post('ID_REGIONAL'),
            'vlevelId'   => $this->input->post('VLEVELID'),
            'TGLAWAL'    => $this->input->post('TGLAWAL'),
            'TGLAKHIR'   => $this->input->post('TGLAKHIR'),
            'CARI'       => $this->input->post('cari')
        );

        $data = $this->tbl_get->getTransaksi($data);

        echo json_encode($data);
    }

    public function get_data_unit(){
        $data = $this->tbl_get->get_data_unit($this->input->post('SLOC'));
        echo json_encode($data);
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

    public function export_excel(){
        header('Content-Type: application/json');
        $data                = array(
            'ID_REGIONAL'      => $this->input->post('xlvl'), // 01
            'idRegional'       => $this->input->post('xlvl'), // 01
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),
            
            'SLOC'             => $this->input->post('xlvl4'),
            'vlevelId'         => $this->input->post('xlvlid'),
            'TGLAWAL'          => $this->input->post('xtglawal'),
            'TGLAKHIR'         => $this->input->post('xtglakhir'),
            'jenis'            => $this->input->post('xjenis'),
            'CARI'             => $this->input->post('xcari'),
            'JENIS'            => 'XLS'
        );

        
        $data['data'] = $this->tbl_get->getTransaksi($data);
        
        $this->load->view($this->_module . '/export_excel', $data);
    }

    public function export_pdf(){
        $data = array(
          'ID_REGIONAL'      => $this->input->post('plvl'), // 01
          'idRegional' => $this->input->post('plvl'),
          'COCODE'      => $this->input->post('plvl1'),
          'PLANT'       => $this->input->post('plvl2'),
          'STORE_SLOC'  => $this->input->post('plvl3'),

          'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'),
          'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
          'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
          'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),

          'SLOC'             => $this->input->post('plvl4'),
          'vlevelId'         => $this->input->post('plvlid'),
          'TGLAWAL'    => $this->input->post('ptglawal'),
          'TGLAKHIR'   => $this->input->post('ptglakhir'),
          'jenis'        => $this->input->post('pjenis'),
          'CARI'       => $this->input->post('pcari'),
          'JENIS'      => $this->input->post('PDF')
      );

        $data['data'] = $this->tbl_get->getTransaksi($data);

        $html_source  = $this->load->view($this->_module . '/export_excel', $data, true);

        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('List_Transaksi_NPPS.pdf');
        $this->lpdf->cetak('A4-L');
    }      
}