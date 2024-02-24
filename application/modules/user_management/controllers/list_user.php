<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class list_user extends MX_Controller {

    private $_title = 'Laporan User';
    private $_limit = 10;
    private $_module = 'user_management/list_user';

    public function __construct() {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        $this->load->model('list_user_model','tbl_get');
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
        $data['data_sources'] = base_url($this->_module . '/load');
        $data['form_action'] = base_url($this->_module . '/proses');
		$data['url_levegroup'] = base_url($this->_module). '/load_levelgroup/';
        $data['reg_options'] = $this->tbl_get->options_reg();
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

        echo Modules::run("template/admin", $data);
    }

    public function load($page = 1) {
		$this->laccess->check();
        $data_table = $this->tbl_get->data_table('',$this->_limit, $page);
        
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'reset_id';
        $table->style = "table table-striped table-bordered datatable dataTable";
        $table->align = array('NO' => 'center', 'NAMA_UNIT' => 'center', 'KD_USER' => 'center', 'USERNAME' => 'center', 'NAMA_USER' => 'center', 'EMAIL_USER' => 'center', 'ROLES_NAMA' => 'center', 'LEVEL_USER' => 'center', 'STATUS_USER' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 9;
        $table->header[] = array(
            "NO", 1, 1,
            "Nama Unit", 1, 1,
            "Kode User", 1, 1,
            "Username", 1, 1,
            "Nama", 1, 1,
            "Email", 1, 1,
            "Role", 1, 1,
            "Level Unit", 1, 1,
            "Status", 1, 1

        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
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
            // 'LVL0'             => $this->input->post('xlvl'),
            'ID_REGIONAL'      => $this->input->post('xlvl'), // 01
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),
            
            'regional'         => $this->input->post('xlvl'),
            'level'            => $this->input->post('xlvlid'),
            'cari'             => $this->input->post('xcari'),
            'JENIS'            => 'XLS'
        );


        $data['data'] = $this->tbl_get->getDataUser($data);
        $this->load->view($this->_module . '/export_excel', $data);
    }
}