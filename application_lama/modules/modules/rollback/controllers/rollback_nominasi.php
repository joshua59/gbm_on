<?php

/**
 * @module ROLLBACK NOMINASI
 * @author  FESASABIL
 * @created at 27 AGUSTUS 2021
 * @modified at 27 AGUSTUS 2021
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module ROLLBACK NOMINASI
 */
class rollback_nominasi extends MX_Controller {
    private $_title = 'Rollback Nominasi';
    private $_limit = 10;
    private $_module = 'rollback/rollback_nominasi';
	private $_urlgetfile = "";
	private $_url_movefile = '';


    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        // $this->laccess->check();
        // $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('rollback_nominasi_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");
        
        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number','maxlength'));

        $data['page_notif'] = false;
        $data['page_notif_status'] = '0';
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['form_action'] = $this->_module.'/proses';
        $data['data_sources'] = base_url($this->_module . '/load');
        $data['options_pembangkit'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', 'all', 1);
        $data['jenis_transaksi'] = array('1' => 'Nominasi');
        $data['jenis_rollback'] = array('1' => 'Rollback Revisi','2' => 'Rollback Hapus');
        echo Modules::run("template/admin", $data);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_ROLLBACK';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'Pembangkit' => 'center', 'Jenis Transaksi' => 'center', 'Jenis BBM' => 'center', 'Nomor Transaksi' => 'center', 'Tanggal Pengakuan' => 'center', 'Status' => 'center', 'Alasan Rollback' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "No", 1, 1,
            "Pembangkit", 1, 1,
            "Jenis Transaksi", 1, 1,
            "Jenis BBM", 1, 1,
            "Nomor Transaksi", 1, 1,
            "Tanggal Pengakuan", 1, 1,
            "Status", 1, 1,
            "Alasan Rollback", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function get_filter() {
        $sloc = $_POST['sloc'];

        $send['data'] = $this->tbl_get->get_data_filter($sloc);

        $this->load->view($this->_module.'/table', $send);
    }

    public function get_all(){
        extract($_POST);
        $message = $this->tbl_get->get_all($sloc);
        echo json_encode($message);
    }

    public function load_jenisbbm(){
        extract($_POST);
        $message = $this->tbl_get->options_jns_bhn_bkr($sloc);
        echo json_encode($message);
    }

    public function get_transaksi() {

        $sloc = $_POST['sloc'];
        $bbm = $_POST['bbm'];
        $jenis = $_POST['jenis'];
        // extract($_POST);

        $message = $this->tbl_get->get_transaksi($sloc, $bbm, $jenis);
        echo json_encode($message);
    }

    public function get_detailtransaksi() {
        $jenis = $_POST['jenis'];
        $idtrans = $_POST['idtrans'];
        $message = $this->tbl_get->get_detailtransaksi($idtrans,$jenis);
        if($jenis == 1){
            $data['TGL'] = $message->TGL_MTS_NOMINASI;
            $data['STATUS'] = $message->STATUS_APPRO;
            $data['NO_NOMINASI'] = $message->NO_NOMINASI;
        }

        echo json_encode($data);
    }

    public function rollback() {
        $this->form_validation->set_rules('jenis', 'Jenis Transaksi', 'required');
        $this->form_validation->set_rules('sloc', 'Pembangkit', 'required');
        $this->form_validation->set_rules('bbm', 'Jenis Bahan Bakar', 'required');
        $this->form_validation->set_rules('idtrans', 'Nomor Transaksi', 'required');
        $this->form_validation->set_rules('tgl', 'Tanggal Pengakuan', 'required');
        $this->form_validation->set_rules('jnsrollback', 'Jenis Rollback', 'required');
        $this->form_validation->set_rules('alasan', 'Alasan Rollback', 'trim|required|max_length[40]');

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.');
            
            $sloc = $_POST['sloc'];
            $jenis = $_POST['jenis'];
            $bbm = $_POST['bbm'];
            $idtrans = $_POST['idtrans'];
            $nominasi = $_POST['nominasi'];
            $tgl = $_POST['tgl'];
            $status = $_POST['status'];
            $jnsrollback = $_POST['jnsrollback'];
            $alasan = $_POST['alasan'];

            $edit = $this->tbl_get->update_nominasi($sloc, $jenis, $bbm, $idtrans, $nominasi, $tgl, $status, $jnsrollback, $alasan);
           
            if ($edit) {
                $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.');
            }
                
        } else {
            $message = array(false, 'Proses gagal', validation_errors());
        }
        echo json_encode($message, true);
    }


    public function delete() {
        $this->form_validation->set_rules('jenis', 'Jenis Transaksi', 'required');
        $this->form_validation->set_rules('sloc', 'Pembangkit', 'required');
        $this->form_validation->set_rules('bbm', 'Jenis Bahan Bakar', 'required');
        $this->form_validation->set_rules('idtrans', 'Nomor Transaksi', 'required');
        $this->form_validation->set_rules('tgl', 'Tanggal Pengakuan', 'required');
        $this->form_validation->set_rules('jnsrollback', 'Jenis Rollback', 'required');
        $this->form_validation->set_rules('alasan', 'Alasan Rollback', 'trim|required|max_length[40]');

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            
            $sloc = $_POST['sloc'];
            $jenis = $_POST['jenis'];
            $bbm = $_POST['bbm'];
            $idtrans = $_POST['idtrans'];
            $nominasi = $_POST['nominasi'];
            $tgl = $_POST['tgl'];
            $status = $_POST['status'];
            $jnsrollback = $_POST['jnsrollback'];
            $alasan = $_POST['alasan'];

            $delete = $this->tbl_get->delete_nominasi($sloc, $jenis, $bbm, $idtrans, $nominasi, $tgl, $status, $jnsrollback, $alasan);
           
            if ($delete) {
                $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.');
            }
                
        } else {
            $message = array(false, 'Proses gagal', validation_errors());
        }
        echo json_encode($message, true);
    }

}

/* End of file stockopname.php */

