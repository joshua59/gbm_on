<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module master_level2
 */
class rollback_harga extends MX_Controller {

    private $_title = 'Rollback Harga';
    private $_limit = 10;
    private $_module = 'data_transaksi/rollback_harga';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('rollback_harga_model','tbl_get');    
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data['button_group'] = array();
        $data['button_group'] = array(
            anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data['id'] = $id;
        $data['option_pemasok'] = $this->tbl_get->options_pemasok();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->style = "table table-striped table-bordered table-hover datatable dataTable"; 
        $table->align = array('NO' => 'center', 'IDTRANS' => 'left', 'NAMA_PEMASOK' => 'left', 'PERIODE' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 4;
        $table->header[] = array(
            "No", 1, 1,
            "Id Trans", 1, 1,
            "Nama Pemasok", 1, 1,
            "Periode", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('BLTH', 'BLTH','required');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['BLTH'] = $this->input->post('BLTH');
           
            if ($this->tbl_get->save_as_new($data)) {
                $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
            } else {
                $message = array(false, 'Proses GAGAL', 'Transaksi gagal dihapus', '');
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

    public function get_blth($key=null) {
        $message = $this->tbl_get->options_blth($default = '--Pilih BLTH--', $key, $jenis=0);
        echo json_encode($message);
    }
}

/* End of file master_level1.php */
/* Location: ./application/modules/wilayah/controllers/master_level1.php */
