<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class reset_password extends MX_Controller {

    private $_title = 'Reset Password Non LDAP';
    private $_limit = 10;
    private $_module = 'user_management/reset_password';

    public function __construct() {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        $this->load->model('reset_password_model','tbl_get');
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
        echo Modules::run("template/admin", $data);
    }

    public function load($page = 1) {
		$this->laccess->check();
        $data_table = $this->tbl_get->data_table('',$this->_limit, $page);
        
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'reset_id';
        $table->style = "table table-striped table-bordered datatable dataTable";
        $table->align = array('no' => 'center','username' => 'center', 'nama_user' => 'center', 'email_user' => 'center', 'nama_pemohon' => 'center', 'unit_pemohon' => 'center', 'tgl_reset' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 8;
        $table->header[] = array(
			'NO', 1,1,
            'USERNAME', 1, 1,
            'NAMA', 1, 1,
            'EMAIL', 1, 1,
            'ROLE USER', 1, 1,
            // 'UNIT', 1, 1,
            'NAMA PEMOHON', 1, 1,
            'UNIT PEMOHON', 1, 1,
            'TGL RESET', 1, 1

        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
       
        $this->form_validation->set_rules('USERNAME', 'User ID', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('NAMA_PEMOHON', 'Nama Pemohon', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('UNIT_PEMOHON', 'Unit Pemohon', 'trim|required|max_length[50]');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['USERNAME'] = $this->input->post('USERNAME');
            $data['NAMA_PEMOHON'] = $this->input->post('NAMA_PEMOHON');
            $data['UNIT_PEMOHON'] = $this->input->post('UNIT_PEMOHON');
           
            if ($this->tbl_get->save_as_new($data)) {
                $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
            }
                
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }
                
    public function find_user() {
        extract($_POST);
        // Ini di load ke model
        $data_user = $this->tbl_get->find_user($p_cari);
        if($data_user){
            $message = array(TRUE,$data_user);
        } else{
            $message = array(FALSE,'Data Tidak Ditemukan');
        }
        echo json_encode($message);
        
    }
}
