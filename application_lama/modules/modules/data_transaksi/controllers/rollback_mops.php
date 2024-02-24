<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module master_level2
 */
class rollback_mops extends MX_Controller {

    private $_title = 'Rollback MOPS';
    private $_limit = 10;
    private $_module = 'data_transaksi/rollback_mops';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        // $this->laccess->check();
        // $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('rollback_mops_model','tbl_get');    
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
        $table->align = array('NO' => 'center', 'LOWHSD_MOPS' => 'center', 'MIDHSD_MOPS' => 'center', 'LOWMFO_MOPS' => 'center', 'MIDMFO_MOPS' => 'center', 'TGL_MOPS' => 'left');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 6;
        $table->header[] = array(
            "NO", 1, 1,
            "LOW HSD MOPS", 1, 1,
            "MID HSD MOPS", 1, 1,
            "LOW MFO MOPS", 1, 1,
            "MID MFO MOPS", 1, 1,
            "TANGGAL MOPS", 1, 1,
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('tgl_awal', 'Tanggal Awal','required');
        $this->form_validation->set_rules('tgl_akhir', 'Tanggal Akhir','required');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['tgl_awal'] = $this->input->post('tgl_awal');
            $data['tgl_akhir'] = $this->input->post('tgl_akhir');
            $simpan = $this->tbl_get->save_as_new($data);
            if ($simpan->kode == 1) {
                $message = array(true, 'Proses Berhasil', $simpan->pesan, '#content_table');
            } else {
                $message = array(false, 'Proses GAGAL', $simpan->pesan, '');
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

}

/* End of file master_level1.php */
/* Location: ./application/modules/wilayah/controllers/master_level1.php */
