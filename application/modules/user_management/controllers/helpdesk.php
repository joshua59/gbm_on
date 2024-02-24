<?php

/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Transportir
 */
class helpdesk extends MX_Controller {

    private $_title = 'Tools Helpdesk - Rollback';
    private $_limit = 10;
    private $_module = 'user_management/helpdesk';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('helpdesk_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        $data = $this->get_level_user();
        $data['button_group'] = array();

        // if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
            anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
            );
        // }
        
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function get_level_user(){
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', 'all', 1);
        $data['lv4_options_cari'] = $this->tbl_get->options_lv4('--Pencarian Pembangkit--', 'all', 1);
        $data['options_bbm'] = $this->tbl_get->options_bbm('-- Pilih Jenis Bahan Bakar --', 'all', 1);
        $data['options_trans'] = $this->tbl_get->options_trans('-- Pilih Jenis Transaksi --', '', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user, $kode_level);

        if ($level_user == 4) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $option_lv4;
            $data['lv4_options_cari'] = $option_lv4;
        } else if ($level_user == 3) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
            $data['lv4_options_cari'] = $this->tbl_get->options_lv4('--Pencarian Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user == 0) {
            if ($kode_level == 00) {
                $data['reg_options'] = $this->tbl_get->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        return $data;
    }

    public function add($id = '') {
        $page_title = 'Tambah Data Rollback';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Rollback';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();
        }
        
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/add', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_ROLLBACK';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array(
            "LEVEL1" => 'left',
            "LEVEL2" => 'left',
            "LEVEL3" => 'left',
            "LEVEL4" => 'left',
            "JNS_TRX"   => 'center', 
            "NO_TRX"   => 'center', 
            "TGL_PENGAKUAN" => 'center',
            "ID_JNS_BHN_BKR" => 'center',
            "KETERANGAN" => 'left',
            "TU_JNS_TRX" => 'center',
            "TU_NO_TRX" => 'center',
            "TU_TGL_PENGAKUAN" => 'center',
        );

        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "LEVEL 1", 1, 1,
            "LEVEL 2", 1, 1,
            "LEVEL 3", 1, 1,
            "PEMBANGKIT", 1, 1,
            "JENIS TRANSAKSI", 1, 1,
            "NOMOR TRANSAKSI", 1, 1,
            "TANGGAL PENGAKUAN", 1, 1,
            "JENIS BBM", 1, 1,
            "ALASAN", 1, 1,
            "TRANSAKSI PROSES ULANG", 1, 1,
            "NO TRANSAKSI PROSES ULANG", 1, 1,
            "TANGGAL PENGAKUAN PROSES ULANG", 1, 1,
        );

        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {

        $this->form_validation->set_rules('SLOC', 'Pembangkit', 'required');
        $this->form_validation->set_rules('JNS_TRX', 'Jenis Transaksi', 'required');
        $this->form_validation->set_rules('NO_TRX', 'Nomor Transaksi', 'required');
        $this->form_validation->set_rules('TGL_PENGAKUAN', 'Tanggal Pengakuan', 'required');
        $this->form_validation->set_rules('ID_JNS_BHN_BKR', 'Jenis Bahan Bakar', 'required');
        $this->form_validation->set_rules('ALASAN', 'Alasan', 'required');

        $data = array();

        if ($this->form_validation->run() == FALSE) {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        } else {

            $data['SLOC'] = $this->input->post('SLOC');
            $data['JNS_TRX'] = strtoupper($this->input->post('JNS_TRX'));
            $data['NO_TRX'] = $this->input->post('NO_TRX');
            $data['TGL_PENGAKUAN'] = str_replace("-","",$this->input->post('TGL_PENGAKUAN'));
            $data['ID_JNS_BHN_BKR'] = $this->input->post('ID_JNS_BHN_BKR');
            $data['ALASAN'] = $this->input->post('ALASAN');
            $data['CREATE_MUTASI'] = $this->session->userdata('user_name');
            $data['TIME_MUTASI'] = date('Y-m-d H:i:s');
            $data['CREATE_ROLLBACK'] = $this->session->userdata('user_name');
            $data['TIME_ROLLBACK'] = date('Ymd');

            $rollback = $this->tbl_get->rollback($data);
             
            if ($rollback->RCDB == 'RC01') {
                $message = array(false, 'Proses GAGAL', $rollback->PESANDB, '');
            }
            else if($rollback->RCDB == 'RC00'){           
                $message = array(true, 'Proses Berhasil',$rollback->PESANDB, '#content_table');
            } else {
                $message = array(false, 'Proses Gagal','Terjadi kesalahan, harap hubungi Administrator', '');
            }
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

    public function options_lv4_all($key=0) {
        $message = $this->tbl_get->options_lv4_all($key);
        echo json_encode($message);
    } 

    public function get_data_unit(){
        $data = $this->tbl_get->get_data_unit($this->input->post('SLOC'));
        echo json_encode($data);
    } 


}
