<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Certificate Of Quality
 */
class verifikasi_coq extends MX_Controller {

    private $_title = 'Laporan Verifikasi Certificate of Quality';
    private $_limit = 10;
    private $_table = 'MASTER_VCOQ';
    private $_module = 'laporan/verifikasi_coq';
    private $_urlgetfile = "";
    private $_url_movefile = "";

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        $this->_url_movefile = $this->laccess->url_serverfile()."move";
        $this->_urlgetfile = $this->laccess->url_serverfile()."geturl";

        /* Load Global Model */
        $this->load->model('verifikasi_coq_model');
    }

    public function index() {
        $this->laccess->update_log();
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud','format_number'));
        
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';

        echo Modules::run("template/admin", $data);
    }

    function load_table() {

        extract($_POST);
        $data['p_jnsbbm']    = $p_jnsbbm;
        $data['p_depo']      = $p_depo;
        $data['p_cari']      = $p_cari;
        $data['p_tgl']       = $p_tgl;
        $data['p_tgl_akhir'] = $p_tgl_akhir;
        $data['p_status']    = $p_status;
        $data['p_pemasok']   = '';
        $data['list']        = $this->verifikasi_coq_model->data($data);
        $this->load->view($this->_module. '/table',$data);
    }

    function load_filter() {
        $data['options_bbm']     = $this->verifikasi_coq_model->options_jenis_bahan_bakar();
        $data['options_depo']    = $this->verifikasi_coq_model->options_depo();
        $data['options_review']  = $this->verifikasi_coq_model->options_review();
        $this->load->view($this->_module. '/filter',$data);
    }

    function load_trx() {
        extract($_POST);
        $data['id']          = $trx_id;
        $data['tipe']        = $tipe;
        $data['form_data']   = $this->verifikasi_coq_model->get_data($trx_id);
        $data['list']        = $this->verifikasi_coq_model->get_result_by_trxid($trx_id);
        $data['ref']         = $this->verifikasi_coq_model->get_one('*',$this->_table,'ID_VERSION',$data['form_data']->ID_VERSION);
        $data['NAMA_SURVEYOR'] = $this->verifikasi_coq_model->get_nama($data['form_data']->ID_LEVEL,$data['form_data']->ID_SURVEYOR);
        $data['list2']       = $this->verifikasi_coq_model->get_pembangkit_by_trxid($trx_id);
        $data['pembangkit']  = $this->verifikasi_coq_model->get_pembangkit_by_trxid($trx_id);
        $data['form_action'] = $this->_module.'/save';
        $this->load->view($this->_module. '/form',$data);
    }

    function export_excel() {
        extract($_POST);
        header('Content-Type: application/json');

        $data['p_jnsbbm']    = $x_jnsbbm;
        $data['p_pemasok']   = '';
        $data['p_status']    = $x_status;
        $data['p_cari']      = $x_cari;
        $data['p_depo']      = $x_depo;
        $data['p_tgl']       = $x_tgl;
        $data['p_tgl_akhir'] = $x_tgl_akhir;
        $data['list']        = $this->verifikasi_coq_model->data($data);
        $data['JENIS']       = 'XLS';

        $this->load->view($this->_module . '/export_excel', $data);
    }

    function export_pdf() {
        extract($_POST);

        $data['p_jnsbbm']    = $p_jnsbbm;
        $data['p_pemasok']   = '';
        $data['p_depo']      = $p_depo;
        $data['p_status']    = $p_status;
        $data['p_cari']      = $p_cari;
        $data['p_tgl']       = $p_tgl;
        $data['p_tgl_akhir'] = $p_tgl_akhir;
        $data['list']        = $this->verifikasi_coq_model->data($data);
        $data['JENIS']       = 'PDF';

        $html_source         = $this->load->view($this->_module . '/export_excel', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan Verifikasi COQ.pdf');
        $this->lpdf->cetak('A4-L');
    }

    function export_excelpembangkit() {
        extract($_POST);
        header('Content-Type: application/json');
        $data['id']          = $x_id;
        $data['form_data']   = $this->verifikasi_coq_model->get_data($x_id);
        $data['ref']         = $this->verifikasi_coq_model->get_one('*','MASTER_VCOQ','ID_VERSION',$data['form_data']->ID_VERSION);
        $surveyor            = $this->verifikasi_coq_model->get_nama($data['form_data']->ID_LEVEL,$data['form_data']->ID_SURVEYOR);
        $data['surveyor']    = $surveyor;
        $data['list']        = $this->verifikasi_coq_model->get_result_by_trxid($x_id);
        $data['list2']       = $this->verifikasi_coq_model->get_pembangkit_by_trxid($x_id);
        $data['JENIS']       = 'XLS';
        $this->load->view($this->_module . '/export_excelpembangkit', $data);
        
    }

    function export_pdfpembangkit() {
        extract($_POST);
       
        $data['id']          = $p_id;
        $data['form_data']   = $this->verifikasi_coq_model->get_data($p_id);
        $data['ref']         = $this->verifikasi_coq_model->get_one('*','MASTER_VCOQ','ID_VERSION',$data['form_data']->ID_VERSION);
        $surveyor            = $this->verifikasi_coq_model->get_nama($data['form_data']->ID_LEVEL,$data['form_data']->ID_SURVEYOR);
        $data['surveyor']    = $surveyor;
        $data['list']        = $this->verifikasi_coq_model->get_result_by_trxid($p_id);
        $data['list2']       = $this->verifikasi_coq_model->get_pembangkit_by_trxid($p_id);
        $data['JENIS']       = 'PDF';
        $html_source = $this->load->view($this->_module . '/export_excelpembangkit', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan Data Detail COQ.pdf');
        $this->lpdf->cetak('A4-L');
    }

}