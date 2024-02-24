<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module master_level4
 */
class monitoring_job extends MX_Controller {

    private $_title = 'Monitoring Job';
    private $_limit = 10;
    private $_module = 'laporan/monitoring_job';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('monitoring_job_model','tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        $this->asset->set_plugin(array('bootstrap-rakhmat', 'font-awesome'));

        $data['button_group'] = array();
        $data['options_tipe_job'] = $this->tbl_get->options_tipe_job();
        $data['options_status_job'] = $this->tbl_get->options_status_job();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['email'] = $this->tbl_get->get_data_email();
        $data['kurs_jisdor'] = $this->tbl_get->get_kurs_jisdor();
        $data['kurs_ktbi'] = $this->tbl_get->get_kurs_ktbi();
        $data['data'] = $this->tbl_get->get_data();
        echo Modules::run("template/admin", $data);
    }


    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_MONITORING';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable"; 
        $table->align = array('NO' => 'center', 'TIPE_JOB' => 'left', 'PESAN' => 'left', 'WAKTU_EKSEKUSI' => 'left', 'STATUS' => 'left');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 9;
        $table->header[] = array(
            "No", 1, 1,
            "Tipe Job", 1, 1,
            "Pesan", 1, 1,
            "Waktu Eksekusi", 1, 1,
            "Status", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

}

/* End of file master_level1.php */
/* Location: ./application/modules/wilayah/controllers/master_level1.php */
