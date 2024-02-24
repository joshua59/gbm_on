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
 * @module Master Wilayah
 */
class perhitungan_harga_non extends MX_Controller {

    private $_title = 'PERHITUNGAN HARGA NON REGULAR';
    private $_limit = 10;
    private $_module = 'data_transaksi/perhitungan_harga_non';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        $this->_url_movefile = $this->laccess->url_serverfile()."move";
        $this->_urlgetfile = $this->laccess->url_serverfile()."geturl";
        /* Load Global Model */
        $this->load->model('perhitungan_harga_non_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");
        $this->asset->set_plugin(array('bootstrap-custom'));
        // $this->asset->set_plugin(array('jquery'));
        
        $data = $this->get_level_user();

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));

        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                // anchor(null, '<i class="icon-plus"></i> Tambah Data FOB', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form(this.id)', 'data-source' => base_url($this->_module . '/add'))),
                anchor(null, '<i class="icon-plus"></i> Tambah Data CIF', array('class' => 'btn yellow', 'id' => 'button-add-akr-kpm', 'onclick' => 'load_form(this.id)', 'data-source' => base_url($this->_module . '/add_akr_kpm')))
            );
        }

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function notif($id) {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");
        $this->asset->set_plugin(array('bootstrap-custom'));
        // $this->asset->set_plugin(array('jquery'));
        
        $data = $this->get_level_user();

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));

        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                // anchor(null, '<i class="icon-plus"></i> Tambah Data FOB', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form(this.id)', 'data-source' => base_url($this->_module . '/add'))),
                anchor(null, '<i class="icon-plus"></i> Tambah Data CIF', array('class' => 'btn yellow', 'id' => 'button-add-akr-kpm', 'onclick' => 'load_form(this.id)', 'data-source' => base_url($this->_module . '/add_akr_kpm')))
            );
        }
        
        //reset notif tolak
        if (($this->session->userdata('roles_id') == 20) && ($this->laccess->otoritas('add'))){
            $username = $this->session->userdata('user_name'); 
            if ($id==3){
                $this->tbl_get->set_notif_tolak($username);    
            }
        }

        $data['status'] = $id;
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah Perhitungan Harga Non Regular FOB';
        $data = $this->get_level_user();

        $record = $this->tbl_get->get_data_setting();
        foreach ($record as $row) {
            if ($row->NAME_SETTING=='Konstanta HSD'){
                $data['KONSTANTA_HSD'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Konstanta MFO'){
                $data['KONSTANTA_MFO'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Variabel hitung'){
                $data['VAR_HITUNG'] = $row->VALUE_SETTING;

            }
        }


        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Perhitungan Harga Non Regular FOB';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;
            $data['KONSTANTA_HSD'] = $data['default']->KONSTANTA_HSD;
            $data['KONSTANTA_MFO'] = $data['default']->KONSTANTA_MFO;
            $data['VAR_HITUNG'] = $data['default']->VARIABEL;

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }


        }

        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit_koreksi($id = '') {
        $page_title = 'Tambah Perhitungan Harga Non Regular FOB (Koreksi)';
        $data = $this->get_level_user();

        $record = $this->tbl_get->get_data_setting();
        foreach ($record as $row) {
            if ($row->NAME_SETTING=='Konstanta HSD'){
                $data['KONSTANTA_HSD'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Konstanta MFO'){
                $data['KONSTANTA_MFO'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Variabel hitung'){
                $data['VAR_HITUNG'] = $row->VALUE_SETTING;

            }
        }


        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Perhitungan Harga Non Regular FOB (Koreksi)';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;
            $data['KONSTANTA_HSD'] = $data['default']->KONSTANTA_HSD;
            $data['KONSTANTA_MFO'] = $data['default']->KONSTANTA_MFO;
            $data['VAR_HITUNG'] = $data['default']->VARIABEL;

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }


        }

        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function add_koreksi($id = '') {
        $page_title = 'Tambah Perhitungan Harga Non Regular FOB';
        $data = $this->get_level_user();

        $record = $this->tbl_get->get_data_setting();
        foreach ($record as $row) {
            if ($row->NAME_SETTING=='Konstanta HSD'){
                $data['KONSTANTA_HSD'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Konstanta MFO'){
                $data['KONSTANTA_MFO'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Variabel hitung'){
                $data['VAR_HITUNG'] = $row->VALUE_SETTING;

            }
        }


        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Koreksi Perhitungan Harga Non Regular FOB';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;
            $data['KONSTANTA_HSD'] = $data['default']->KONSTANTA_HSD;
            $data['KONSTANTA_MFO'] = $data['default']->KONSTANTA_MFO;
            $data['VAR_HITUNG'] = $data['default']->VARIABEL;

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }


        }

        $data['stat'] = 'tambah_koreksi';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function add_akr_kpm($id = '') {
        $page_title = 'Tambah Perhitungan Harga Non Regular CIF';
        $data = $this->get_level_user();
        $data['id'] = $id;
        $data['stat'] = 'add';

        if ($id != '') {
            $data['stat'] = 'edit';
            $page_title = 'Edit Perhitungan Harga Non Regular CIF';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;


            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }


        }

        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg_array();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $data['data_sources_pencarian'] = base_url($this->_module . '/load_pencarian');
        $this->load->view($this->_module . '/form_akr_kpm', $data);
    }

    public function edit_koreksi_akr_kpm($id = '') {
        $page_title = 'Tambah Perhitungan Harga CIF Non Regular (Koreksi)';
        $data = $this->get_level_user();
        $data['id'] = $id;
        $data['stat'] = 'add';

        if ($id != '') {
            $data['stat'] = 'edit_koreksi';
            $page_title = 'Edit Perhitungan Harga CIF Non Regular (Koreksi)';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;


            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }


        }

        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg_array();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $data['data_sources_pencarian'] = base_url($this->_module . '/load_pencarian');
        $this->load->view($this->_module . '/form_akr_kpm', $data);
    }

    public function add_akr_kpm_koreksi($id = '') {
        $page_title = 'Tambah Perhitungan Harga Non Regular CIF';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Koreksi Perhitungan Harga Non Regular CIF';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;


            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }


        }

        $data['stat'] = 'tambah_koreksi';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg_array();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $data['data_sources_pencarian'] = base_url($this->_module . '/load_pencarian');
        $this->load->view($this->_module . '/form_akr_kpm', $data);
    }

    public function view_akr_kpm($id = '') {
        $page_title = 'Tambah Perhitungan Harga Non Regular CIF';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'View Perhitungan Harga Non Regular CIF';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;


            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }


        }

        $data['stat'] = 'view';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg_array();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $data['data_sources_pencarian'] = base_url($this->_module . '/load_pencarian');
        $this->load->view($this->_module . '/form_akr_kpm_view', $data);
    }

    public function view_akr_kpm_lihat_koreksi($id = '') {
        $page_title = 'View Koreksi Perhitungan Harga Non Regular CIF';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'View Koreksi Perhitungan Harga Non Regular CIF';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;


            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }


        }

        $data['stat'] = 'view_koreksi';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg_array();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $data['data_sources_pencarian'] = base_url($this->_module . '/load_pencarian');
        $this->load->view($this->_module . '/form_akr_kpm_view', $data);
    }

    public function view_akr_kpm_approve($id = '') {
        $page_title = 'Approve Perhitungan Harga Non Regular CIF';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Approve Perhitungan Harga Non Regular CIF';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;


            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }


        }

        $data['stat'] = 'approve';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg_array();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $data['data_sources_pencarian'] = base_url($this->_module . '/load_pencarian');
        $this->load->view($this->_module . '/form_akr_kpm_view', $data);
    }

    public function view_akr_kpm_approve_koreksi($id = '') {
        $page_title = 'View Koreksi Perhitungan Harga Non Regular CIF';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'View Koreksi Perhitungan Harga Non Regular CIF';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }
        }

        $data['stat'] = 'approve_koreksi';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg_array();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $data['data_sources_pencarian'] = base_url($this->_module . '/load_pencarian');
        $this->load->view($this->_module . '/form_akr_kpm_view', $data);
    }

    public function view_akr_kpm_approve_koreksi_hasil($id = '') {
        $page_title = 'Approve Koreksi Perhitungan Harga Non Regular CIF';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Approve Koreksi Perhitungan Harga Non Regular CIF';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->ID_PEMBANGKIT);

                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

                if ($level_user==3){
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==2){
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==1){
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user==0){
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                } else if ($level_user=='R'){
                    $data['reg_options'] = $option_reg;
                    $data['lv1_options'] = $option_lv1;
                    $data['lv2_options'] = $option_lv2;
                    $data['lv3_options'] = $option_lv3;
                    $data['lv4_options'] = $option_lv4;     
                }
            }
        }

        $data['stat'] = 'approve_koreksi_hasil';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['options_reg'] = $this->tbl_get->options_reg_array();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $data['data_sources_pencarian'] = base_url($this->_module . '/load_pencarian');
        $this->load->view($this->_module . '/form_akr_kpm_view', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function view_pertamina($id = '') {
        $page_title = 'Tambah Perhitungan Harga Non Regular FOB';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'View Perhitungan Harga Non Regular FOB';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;

        }

        $data['button_group'] = array(
            anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('class' => 'btn', 'id' => 'button-tutup', 'onclick' => 'close_form(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );

        $record = $this->tbl_get->get_data_setting();
        foreach ($record as $row) {
            if ($row->NAME_SETTING=='Konstanta HSD'){
                $data['KONSTANTA_HSD'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Konstanta MFO'){
                $data['KONSTANTA_MFO'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Variabel hitung'){
                $data['VAR_HITUNG'] = $row->VALUE_SETTING;

            }
        }

        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_view_pertamina', $data);
    }

    public function view_pertamina_lihat_koreksi($id = '') {
        $page_title = 'View Koreksi Perhitungan Harga Non Regular FOB';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'View Koreksi Perhitungan Harga Non Regular FOB';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;

        }

        $data['button_group'] = array(
            anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('class' => 'btn', 'id' => 'button-tutup', 'onclick' => 'close_form(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );

        $record = $this->tbl_get->get_data_setting();
        foreach ($record as $row) {
            if ($row->NAME_SETTING=='Konstanta HSD'){
                $data['KONSTANTA_HSD'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Konstanta MFO'){
                $data['KONSTANTA_MFO'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Variabel hitung'){
                $data['VAR_HITUNG'] = $row->VALUE_SETTING;

            }
        }

        $data['stat'] = 'view_koreksi';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_view_pertamina', $data);
    }

    public function view_pertamina_approve($id = '') {
        $page_title = 'Approve Perhitungan Harga Non Regular FOB';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Approve Perhitungan Harga Non Regular FOB';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;

        }

        $record = $this->tbl_get->get_data_setting();
        foreach ($record as $row) {
            if ($row->NAME_SETTING=='Konstanta HSD'){
                $data['KONSTANTA_HSD'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Konstanta MFO'){
                $data['KONSTANTA_MFO'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Variabel hitung'){
                $data['VAR_HITUNG'] = $row->VALUE_SETTING;

            }
        }

        $data['button_group'] = array(
            anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('class' => 'btn', 'id' => 'button-tutup', 'onclick' => 'close_form(this.id)', 'data-source' => base_url($this->_module . '/add'))),
            anchor(null, '<i class="icon-ok"></i> Setujui', array('class' => 'btn blue', 'id' => 'button-setuju-'.$id, 'onclick' => 'approveData(this.id)', 'data-source' => base_url($this->_module . '/add'))),
            anchor(null, '<i class="icon-remove"></i> Tolak', array('class' => 'btn red', 'id' => 'button-tolak-'.$id, 'onclick' => 'tolakData(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );

        $data['stat'] = 'approve';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_view_pertamina', $data);
    }

    public function view_pertamina_approve_koreksi($id = '') {
        $page_title = 'Koreksi Perhitungan Harga Non Regular FOB';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Koreksi Perhitungan Harga Non Regular FOB';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;

        }

        $data['button_group'] = array(
            anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('class' => 'btn', 'id' => 'button-tutup', 'onclick' => 'close_form(this.id)', 'data-source' => base_url($this->_module . '/add'))),
            anchor(null, '<i class="icon-save"></i> Simpan', array('class' => 'btn blue', 'id' => 'button-simpan-'.$id, 'onclick' => 'koreksiData(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );

        $record = $this->tbl_get->get_data_setting();
        foreach ($record as $row) {
            if ($row->NAME_SETTING=='Konstanta HSD'){
                $data['KONSTANTA_HSD'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Konstanta MFO'){
                $data['KONSTANTA_MFO'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Variabel hitung'){
                $data['VAR_HITUNG'] = $row->VALUE_SETTING;

            }
        }

        $data['stat'] = 'approve_koreksi';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_view_pertamina', $data);
    }

    public function view_pertamina_approve_koreksi_hasil($id = '') {
        $page_title = 'Approve Koreksi Perhitungan Harga Non Regular FOB';
        $data = $this->get_level_user();
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Approve Koreksi Perhitungan Harga Non Regular FOB';
            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row();

            // print_r($data['default']); die;

        }

        $record = $this->tbl_get->get_data_setting();
        foreach ($record as $row) {
            if ($row->NAME_SETTING=='Konstanta HSD'){
                $data['KONSTANTA_HSD'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Konstanta MFO'){
                $data['KONSTANTA_MFO'] = $row->VALUE_SETTING;

            }
            if ($row->NAME_SETTING=='Variabel hitung'){
                $data['VAR_HITUNG'] = $row->VALUE_SETTING;

            }
        }

        $data['button_group'] = array(
            anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('class' => 'btn', 'id' => 'button-tutup', 'onclick' => 'close_form(this.id)', 'data-source' => base_url($this->_module . '/add'))),
            anchor(null, '<i class="icon-ok"></i> Setujui Koreksi', array('class' => 'btn blue', 'id' => 'button-setuju-'.$id, 'onclick' => 'approveDataKoreksi(this.id)', 'data-source' => base_url($this->_module . '/add'))),
            anchor(null, '<i class="icon-remove"></i> Tolak Koreksi', array('class' => 'btn red', 'id' => 'button-tolak-'.$id, 'onclick' => 'tolakDataKoreksi(this.id)', 'data-source' => base_url($this->_module . '/add')))
        );

        $data['stat'] = 'approve_koreksi_hasil';
        $data['pemasok'] = $this->tbl_get->options_pemasok();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_view_pertamina', $data);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_PERHITUNGAN';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'BLTH' => 'center', 'PEMASOK' => 'left', 'NOPJBBM' => 'center', 'CREATE_BY' => 'center', 'TGLINSERT' => 'center', 'APPROVE_BY' => 'center', 'APPROVE_DATE' => 'center', 'STATUS' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 10;
        $table->header[] = array(
            "NO", 1, 1,
            "TANGGAL B/L", 1, 1,
            "PEMASOK", 1, 1,
            // "Pembangkit", 1, 1,
            "NO. PJBBBM", 1, 1,
            "CREATED BY", 1, 1,
            "CREATED DATE", 1, 1,
            "UPDATED BY", 1, 1,
            "UPDATED DATE", 1, 1,
            "STATUS", 1, 1,
            "AKSI", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function load_pencarian($page = 1) {
        $data_table = $this->tbl_get->data_table_pencarian($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_KONTRAK_PEMASOK';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'PEMASOK' => 'left', 'NOPJBBM_KONTRAK_PEMASOK' => 'left', 'TGL_KONTRAK_PEMASOK' => 'center', 'JUDUL_KONTRAK_PEMASOK' => 'left', 'PERIODE' => 'center', 'PERIODE_AWAL_KONTRAK_PEMASOK' => 'center', 'PERIODE_AKHIR_KONTRAK_PEMASOK' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 8;
        $table->header[] = array(
            "No", 1, 1,
            "Pemasok", 1, 1,
            "No. PJBBBM", 1, 1,
            // "TGL KONTRAK", 1, 1,
            "Judul Kontrak", 1, 1,
            "Periode", 1, 1,
            "Periode Awal", 1, 1,
            "Periode Akhir", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        //$this->form_validation->set_rules('ID_PEMASOK', 'ID_PEMASOK', 'required');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['ID_PERHITUNGAN'] = $this->input->post('ID_PERHITUNGAN');

        
            if ($id == '') {
                if ($this->tbl_get->save_as_new($data)) {
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                }
            } else {
                if ($this->tbl_get->save($data, $id)) {
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                }
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function get_level_user(){
        $data['status_options'] = $this->tbl_get->options_status();
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);
        $data['option_pemasok'] = $this->tbl_get->options_pemasok('--Pilih Pemasok--', '-', 1);

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

        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();
        $data['opsi_jns_kurs'] = $this->tbl_get->options_jns_kurs();
        $data['jns_isidentil_options'] = $this->tbl_get->options_isidentil();

        return $data;
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

    public function get_mid_mops(){
        extract($_POST);
        $data['list'] = $this->tbl_get->generate_mops($tgl1,$tgl2);
        
        $this->load->view($this->_module . '/list_data', $data);
    }

    public function get_low_mops(){
        extract($_POST);
        $data['list'] = $this->tbl_get->generate_lowhsd($tgl1,$tgl2);
        
        $this->load->view($this->_module . '/list_lowmops', $data);
    }

    public function formula_pertamina(){
        extract($_POST);

        $data = array('tgl1' => $tgl1,
                      'tgl2' => $tgl2,
                      'avg_mid_hsd' => $this->tbl_get->avg_mid_hsd($tgl1,$tgl2),
                      'avg_mid_mfo' => $this->tbl_get->avg_mid_mfo($tgl1,$tgl2),
                      'avg_ktbi' => $this->tbl_get->avg_ktbi($tgl1,$tgl2),
                      'p_alphahsd' => $p_alphahsd,
                      'p_sulfurhsd' => $p_sulfurhsd,
                      'p_konversihsd' => $p_konversihsd,
                      'p_alphamfo' => $p_alphamfo,
                      'p_sulfurmfo' => $p_sulfurmfo,
                      'p_konversimfo' => $p_konversimfo
                      );

        $this->load->view($this->_module . '/table_pertamina', $data);
    }

    public function formula_akrkpm(){
        extract($_POST);
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;
        $data['low_hsd'] = $this->tbl_get->avg_low_hsd($tgl1,$tgl2);
        $data['avg_ktbi'] = $this->tbl_get->avg_ktbi($tgl1,$tgl2);
        $data['ak_alpha'] = $ak_alpha ;
        $data['ak_sulfur'] = $ak_sulfur ;
        $data['ak_konversi'] = $ak_konversi ;
        $data['ak_oa'] = $ak_oa ;
        if($ID_PEMASOK == 002)
        {
            $data['bilangan'] = $bilangan;
            $views = '/table_kpm';
        }
        else
        {
            $data['bilangan'] = "" ;
            $views = '/table_akr';
        }
        
        $this->load->view($this->_module .$views, $data);
    }

    function save(){
        extract($_POST);
        $create = date('Y-m-d');

        if($id == 1)
        {
            $sulfur = $p_sulfurhsd;
            $alphahsd = $p_alphahsd;
            $alphamfo = $p_alphamfo;


            $data = array(
                        'ID_PEMASOK'=> $ID_PEMASOK, 
                        'BLTH'=> $periode, 
                        'TANGGAL_AWAL'=> $tglawal, 
                        'TANGGAL_AKHR'=> $tglakhir, 
                        'ALPHAHSD'=> $alphahsd, 
                        'ALPHAMFO'=> $alphamfo, 
                        'SULFURHSD'=> $sulfur, 
                        'SULFURMFO'=> $sulfurmfo, 
                        'KONVERSI_HSD'=> $KONVERSI_HSD, 
                        'KONVERSI_MFO'=> $KONVERSI_MFO, 
                        'HSDNOPPN'=> $HSDNOPPN, 
                        'HSDPPN'=> $HSDPPN, 
                        'HSDTOTAL'=> $HSDTOTAL, 
                        'MFONOPPN'=> $MFONOPPN, 
                        'MFOPPN'=> $MFOPPN, 
                        'MFOTOTAL'=> $MFOTOTAL, 
                        'IDOPPN'=> $IDOPPN, 
                        'IDONOPPN'=> $IDONOPPN, 
                        'IDOTOTAL'=> $IDOTOTAL, 
                        'AVGMIDHSD'=> $AVGMIDHSD, 
                        'AVGMIDMFO'=> $AVGMIDMFO,
                        'HARGA'=> $AVGKURS,  

                    );
        }
        // elseif($id == 2)
        else
        {
          
            $data = array(
                        'ID_PEMASOK'=> $ID_PEMASOK, 
                        'BLTH'=> $periode, 
                        'TANGGAL_AWAL'=> $tglawal, 
                        'TANGGAL_AKHR'=> $tglakhir, 
                        'ALPHAHSD'=> $ALPHAHSD, 
                        'SULFURHSD'=> $SULFURHSD, 
                        'KONVERSI_HSD'=> $KONVERSI_HSD, 
                        'AVGLOWHSD'=> $AVGLOWHSD, 
                        'HARGA'=> $HARGA,  
                        'AVGLOWHSD' => $AVGLOWHSD ,
                        'OAT' => $OAT ,
                        'HARGATANPAOAT' => $HARGATANPAOAT ,
                        'HARGADGNOAT' => $HARGADGNOAT ,
                        'TIPE' => $TIPE,

                    );


        }
        // elseif($id == 3)
        // {
        //    $data = array(
        //                 'ID_PEMASOK'=> $ID_PEMASOK, 
        //                 'BLTH'=> $periode, 
        //                 'TANGGAL_AWAL'=> $tglawal, 
        //                 'TANGGAL_AKHR'=> $tglakhir, 
        //                 'ALPHAHSD'=> $ALPHAHSD, 
        //                 'SULFURHSD'=> $SULFURHSD, 
        //                 'KONVERSI_HSD'=> $KONVERSI_HSD, 
        //                 'AVGLOWHSD'=> $AVGLOWHSD, 
        //                 'HARGA'=> $HARGA,  
        //                 'AVGLOWHSD' => $AVGLOWHSD ,
        //                 'OAT' => $OAT ,
        //                 'HARGATANPAOAT' => $HARGATANPAOAT ,
        //                 'HARGADGNOAT' => $HARGADGNOAT ,
        //                 'TIPE' => $TIPE,

        //             );
        // }

        // echo "<pre>";
        // print_r($data);
        // echo "</pre>";
        // die();

        $data['LV_R'] = $ID_REGIONAL;
        $data['LV_1'] = $COCODE;
        $data['LV_2'] = $PLANT;
        $data['LV_3'] = $STORE_SLOC;
        $data['ID_PEMBANGKIT'] = $SLOC;
        $data['TANGGAL'] = $TANGGAL;

        $this->db->insert('PERHITUNGAN_HARGA',$data);
        $json['status'] = 1;
        $json['messege'] = "Data Berhasil Disimpan";

        echo json_encode($json);
    }

    function getIdGroup(){
        $vidgroup = '';
        $characters = $this->session->userdata('user_name').'abcdefghijklmnopqrstuvwxyz0123456789';
        $characters = str_replace('.','',$characters);
        $max = strlen($characters) - 1;
        for ($i = 0; $i < 8; $i++) {
          $vidgroup .= $characters[mt_rand(0, $max)];
        }
        return $vidgroup;
    }

    public function get_hitung_harga() {
        $this->form_validation->set_rules('periode', 'Periode Perhitungan', 'required');
        $this->form_validation->set_rules('pemasok', 'Pemasok', 'required');
        $this->form_validation->set_rules('tglawal', 'Periode Awal (Kurs & MOPS)', 'required|max_length[10]');
        $this->form_validation->set_rules('tglakhir', 'Periode Akhir (Kurs & MOPS)', 'required|max_length[10]');
        $this->form_validation->set_rules('sulfur_hsd', 'Sulfur HSD', 'required|max_length[15]');
        $this->form_validation->set_rules('konversi_hsd', 'Konversi HSD', 'required|max_length[15]');
        $this->form_validation->set_rules('sulfur_mfo', 'Sulfur MFO', 'required|max_length[15]');
        $this->form_validation->set_rules('konversi_mfo', 'Konversi MFO', 'required|max_length[15]');

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses perhitungan harga gagal.', '');
            // $id = $this->input->post('id');

            $data = array();
            $data['ID_PEMASOK'] = $this->input->post('ID_PEMASOK');
            $data['CD_BY_DEPO'] = $this->session->userdata('user_name');

            $createby = $this->session->userdata('user_name');     

            $tglawal = $this->laccess->setTgl($this->input->post('tglawal')); 
            $tglakhir = $this->laccess->setTgl($this->input->post('tglakhir')); 
            $alpha = 0; 
            $sulfur_hsd = $this->laccess->setRp($this->input->post('sulfur_hsd'));
            $sulfur_mfo = $this->laccess->setRp($this->input->post('sulfur_mfo'));
            $konversi_hsd = $this->laccess->setRp($this->input->post('konversi_hsd')); 
            $konversi_mfo = $this->laccess->setRp($this->input->post('konversi_mfo')); 
            $pemasok = $this->input->post('pemasok'); 
            $no_pjbbm = $this->input->post('NOPJBBM_KONTRAK_PEMASOK'); 
            $periode = $this->input->post('periode');
            $ket = $this->input->post('ket');

            $oat = 0; 
            $sloc = '';
            
            if ($this->input->post('stat')=='tambah_koreksi'){
                $cek_periode = '';
            } else {
                $cek_periode = $this->tbl_get->cek_periode_pertamina($periode);    
            }
            

            if ($cek_periode){
                $message = array(false, 'Proses gagal', 'Perhitungan Harga '.$cek_periode.' <br>Periode '.$periode.' sudah ada pada sistem', '');
            } else {
                $record = $this->tbl_get->call_hitung_harga($createby, $tglawal, $tglakhir, $alpha, $sulfur_hsd, $sulfur_mfo,$konversi_hsd, $konversi_mfo, $pemasok, $oat, $sloc, $no_pjbbm, $periode, $ket);

                if ($record){
                    foreach ($record as $row) {
                        $vidtrans = $row->vidtrans;

                        $data = array('vidtrans' => $row->vidtrans,
                                      'avg_mid_hsd' => $row->ratamid_hsd,
                                      'avg_mid_mfo' => $row->ratamid_mfo,
                                      'avg_ktbi' => $row->jisdor,
                                      'alfamid_hsd' => $row->alfamid_hsd,
                                      'alfamid_mfo' => $row->alfamid_mfo,
                                      'HargaTanpaPPN_hsd' => $row->HargaTanpaPPN_hsd,
                                      'HargaTanpaPPN_mfo' => $row->HargaTanpaPPN_mfo,
                                      'HargaTanpaPPN_ido' => $row->HargaTanpaPPN_ido,
                                      'PPN_hsd' => $row->PPN_hsd,
                                      'PPN_mfo' => $row->PPN_mfo,
                                      'PPN_ido' => $row->PPN_ido,
                                      'HargaDenganPPN_hsd' => $row->HargaDenganPPN_hsd,
                                      'HargaDenganPPN_mfo' => $row->HargaDenganPPN_mfo,
                                      'HargaDenganPPN_ido' => $row->HargaDenganPPN_ido,
                                      );
                    }

                    $view_form = $this->load->view($this->_module . '/table_pertamina', $data, true);
                    $message = array(true, 'Proses Berhasil', 'Proses perhitungan harga berhasil.', '#content_table',$view_form, $vidtrans);
                }                
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function get_hitung_harga_pertamina_edit() {
        $this->form_validation->set_rules('periode', 'Periode Perhitungan', 'required');
        $this->form_validation->set_rules('pemasok', 'Pemasok', 'required');
        $this->form_validation->set_rules('tglawal', 'Periode Awal (Kurs & MOPS)', 'required|max_length[10]');
        $this->form_validation->set_rules('tglakhir', 'Periode Akhir (Kurs & MOPS)', 'required|max_length[10]');
        $this->form_validation->set_rules('sulfur_hsd', 'Sulfur HSD', 'required|max_length[15]');
        $this->form_validation->set_rules('konversi_hsd', 'Konversi HSD', 'required|max_length[15]');
        $this->form_validation->set_rules('sulfur_mfo', 'Sulfur MFO', 'required|max_length[15]');
        $this->form_validation->set_rules('konversi_mfo', 'Konversi MFO', 'required|max_length[15]');

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses perhitungan harga gagal.', '');
            // $id = $this->input->post('id');

            $data = array();
            $data['ID_PEMASOK'] = $this->input->post('ID_PEMASOK');
            $data['CD_BY_DEPO'] = $this->session->userdata('user_name');

            $createby = $this->session->userdata('user_name');     

            $tglawal = $this->laccess->setTgl($this->input->post('tglawal')); 
            $tglakhir = $this->laccess->setTgl($this->input->post('tglakhir')); 
            $alpha = 0; 
            $sulfur_hsd = $this->laccess->setRp($this->input->post('sulfur_hsd'));
            $sulfur_mfo = $this->laccess->setRp($this->input->post('sulfur_mfo'));
            $konversi_hsd = $this->laccess->setRp($this->input->post('konversi_hsd')); 
            $konversi_mfo = $this->laccess->setRp($this->input->post('konversi_mfo')); 
            $pemasok = $this->input->post('pemasok'); 
            $no_pjbbm = $this->input->post('NOPJBBM_KONTRAK_PEMASOK');

            $vidtrans = $this->input->post('id');
            
            $oat = 0; 
            $sloc = '';
            
            $record = $this->tbl_get->get_hitung_harga_pertamina_edit($vidtrans);

            if ($record){
                foreach ($record as $row) {
                    $vidtrans = $row->IDTRANS;

                    $data = array('vidtrans' => $row->IDTRANS,
                                  'avg_mid_hsd' => $row->MID_HSD_RATA2,
                                  'avg_mid_mfo' => $row->MID_MFO_RATA2,
                                  'avg_ktbi' => $row->RATA2_KURS,
                                  'alfamid_hsd' => $row->ALPHA_HSD,
                                  'alfamid_mfo' => $row->ALPHA_MFO,
                                  'HargaTanpaPPN_hsd' => $row->HARGA_TANPA_HSD,
                                  'HargaTanpaPPN_mfo' => $row->HARGA_TANPA_MFO,
                                  'HargaTanpaPPN_ido' => $row->HARGA_TANPA_IDO,
                                  'PPN_hsd' => $row->PPN_HSD,
                                  'PPN_mfo' => $row->PPN_MFO,
                                  'PPN_ido' => $row->PPN_IDO,
                                  'HargaDenganPPN_hsd' => $row->HARGA_DENGAN_HSD,
                                  'HargaDenganPPN_mfo' => $row->HARGA_DENGAN_MFO,
                                  'HargaDenganPPN_ido' => $row->HARGA_DENGAN_IDO,
                                  );
                }
                // print_r($data); die;

                $view_form = $this->load->view($this->_module . '/table_pertamina', $data, true);
                $message = array(true, 'Proses Berhasil', 'Proses perhitungan harga berhasil.', '#content_table',$view_form, $vidtrans);
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function get_hitung_harga_pertamina_ulang() {
        $this->form_validation->set_rules('periode', 'Periode Perhitungan', 'required');
        $this->form_validation->set_rules('pemasok', 'Pemasok', 'required');
        $this->form_validation->set_rules('tglawal', 'Periode Awal (Kurs & MOPS)', 'required|max_length[10]');
        $this->form_validation->set_rules('tglakhir', 'Periode Akhir (Kurs & MOPS)', 'required|max_length[10]');
        $this->form_validation->set_rules('sulfur_hsd', 'Sulfur HSD', 'required|max_length[15]');
        $this->form_validation->set_rules('konversi_hsd', 'Konversi HSD', 'required|max_length[15]');
        $this->form_validation->set_rules('sulfur_mfo', 'Sulfur MFO', 'required|max_length[15]');
        $this->form_validation->set_rules('konversi_mfo', 'Konversi MFO', 'required|max_length[15]');

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses perhitungan harga gagal.', '');
            // $id = $this->input->post('id');

            $data = array();
            $data['ID_PEMASOK'] = $this->input->post('ID_PEMASOK');
            $data['CD_BY_DEPO'] = $this->session->userdata('user_name');

            $createby = $this->session->userdata('user_name');     

            $tglawal = $this->laccess->setTgl($this->input->post('tglawal')); 
            $tglakhir = $this->laccess->setTgl($this->input->post('tglakhir')); 
            $alpha = 0; 
            $sulfur_hsd = $this->laccess->setRp($this->input->post('sulfur_hsd'));
            $sulfur_mfo = $this->laccess->setRp($this->input->post('sulfur_mfo'));
            $konversi_hsd = $this->laccess->setRp($this->input->post('konversi_hsd')); 
            $konversi_mfo = $this->laccess->setRp($this->input->post('konversi_mfo')); 
            $pemasok = $this->input->post('pemasok'); 
            $no_pjbbm = $this->input->post('NOPJBBM_KONTRAK_PEMASOK'); 
            $vidtrans = $this->input->post('id');
            $periode = $this->input->post('periode');
            $vidkoreksi = $this->input->post('vidkoreksi');
            $ket = $this->input->post('ket');
            
            $oat = 0; 
            $sloc = '';

            // if ($vidkoreksi) {
            //     $cek_periode='';
            // } else {
            //     $cek_periode = $this->tbl_get->cek_periode_pertamina($periode,$vidtrans);    
            // }
            $cek_periode='';
            
            if ($cek_periode){
                $message = array(false, 'Proses gagal', 'Perhitungan Harga '.$cek_periode.' <br>Periode '.$periode.' sudah ada pada sistem', '');
            } else {
                $record = $this->tbl_get->call_hitung_harga_pertamina_ulang($createby, $tglawal, $tglakhir, $alpha, $sulfur_hsd, $sulfur_mfo,$konversi_hsd, $konversi_mfo, $pemasok, $oat, $sloc, $no_pjbbm, $vidtrans, $periode, $ket);

                if ($record){
                    foreach ($record as $row) {
                        $vidtrans = $row->vidtrans;
                        $vidtrans_edit = $row->vidtrans_edit;

                        $data = array('vidtrans' => $row->vidtrans,
                                      'vidtrans_edit' => $row->vidtrans_edit,
                                      'avg_mid_hsd' => $row->ratamid_hsd,
                                      'avg_mid_mfo' => $row->ratamid_mfo,
                                      'avg_ktbi' => $row->jisdor,
                                      'alfamid_hsd' => $row->alfamid_hsd,
                                      'alfamid_mfo' => $row->alfamid_mfo,
                                      'HargaTanpaPPN_hsd' => $row->HargaTanpaPPN_hsd,
                                      'HargaTanpaPPN_mfo' => $row->HargaTanpaPPN_mfo,
                                      'HargaTanpaPPN_ido' => $row->HargaTanpaPPN_ido,
                                      'PPN_hsd' => $row->PPN_hsd,
                                      'PPN_mfo' => $row->PPN_mfo,
                                      'PPN_ido' => $row->PPN_ido,
                                      'HargaDenganPPN_hsd' => $row->HargaDenganPPN_hsd,
                                      'HargaDenganPPN_mfo' => $row->HargaDenganPPN_mfo,
                                      'HargaDenganPPN_ido' => $row->HargaDenganPPN_ido,
                                      );
                    }

                    // print_r($record); die;

                    $view_form = $this->load->view($this->_module . '/table_pertamina', $data, true);
                    $message = array(true, 'Proses Berhasil', 'Proses perhitungan harga berhasil.', '#content_table',$view_form, $vidtrans, $vidtrans_edit);
                }
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function get_hitung_harga_all() {
        $this->form_validation->set_rules('periode', 'Tanggal Bill of Ladding', 'required');
        $this->form_validation->set_rules('NOPJBBM_KONTRAK_PEMASOK', 'NO PJBBBM', 'required');
        $this->form_validation->set_rules('SKEMA_ISIDENTIL', 'Skema insidentil', 'required');

        $this->form_validation->set_rules('JENIS_KURS', 'Referensi Kurs', 'required');

        $x = $this->input->post('JML_KIRIM');
        $ada=0;

        if ($x>0){
            if ($x>20){
                $x=20;
            }
            for ($i=1; $i<=$x; $i++) {
                if ($this->input->post('pilih_ke'.$i)){
                    $ada=1;
                    break;
                }               
            }
        }
        if ($ada==0){
            $this->form_validation->set_rules('pilih_ke'.$i, 'Checklist Hitung Insidentil ', 'required',
                        array('required' => 'Checklist Hitung Insidentil harus dipilih'));
        }

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses perhitungan harga gagal.', '');
            // $id = $this->input->post('id');
            $createby = $this->session->userdata('user_name');     
            $tglposting = $this->laccess->setTgl($this->input->post('periode')); 
            $JENIS_KURS = $this->input->post('JENIS_KURS');
            $skema = $this->input->post('SKEMA_ISIDENTIL'); 
        
            $all_data = array(); 
            $vidtrans = '';

            // if ($this->input->post('stat')=='tambah_koreksi'){
            //     $cek_periode = '';
            // } else {
            //     $cek_periode = $this->tbl_get->cek_periode_akr_kpm($periode,$no_pjbbm);
            // }

            // if ($cek_periode){
            //     $message = array(false, 'Proses gagal', 'Perhitungan Harga '.$cek_periode.' <br>Periode '.$periode.' sudah ada pada sistem', '');
            //     echo json_encode($message, true);
            //     exit();
            // }

            for ($i=1; $i<=$x; $i++) {
                $sloc = $this->input->post('sloc_ke'.$i);
                $idtrans = $this->input->post('idtrans_ke'.$i);
                $pilih = $this->input->post('pilih_ke'.$i);
                
                if ($pilih){
                    $record = $this->tbl_get->call_hitung_harga_arr($createby, $tglposting, $idtrans, $sloc, $JENIS_KURS, $skema);
                    
                    //jika mops tidak sesuai skema
                    if ($record[0]['RCDB']!='RCDB'){
                        $message = array(false, 'Proses gagal', $record[0]['PESANDB'], '');
                        echo json_encode($message, true);
                        exit();
                    }

                    if ($record){
                        $all_data[] = $record; 
                    }
                }
            }

            $data['list'] = $all_data;
            $data['id'] = $this->input->post('id'); 
            $data['stat'] = $this->input->post('stat');
            $data['IDGROUP'] = $IDGROUP;
            $data['list_idtrans'] = ''; //$this->tbl_get->get_id_trans($IDGROUP);
            // $data['ket'] = $ket;

            foreach ($all_data as $row) {
                foreach ($row as $row2) {
                    $vidtrans = $row2['idtrans'];
                    break;
                }
                break;
            }

            // print_r($data['list']); die;

            $view_form = $this->load->view($this->_module . '/table_akr_kpm', $data, true);
            $message = array(true, 'Proses Berhasil', 'Proses perhitungan harga berhasil.', '#content_table',$view_form, $vidtrans);

        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function get_hitung_harga_all_ulang() {
        $this->form_validation->set_rules('periode', 'Tanggal Bill of Ladding', 'required');
        $this->form_validation->set_rules('NOPJBBM_KONTRAK_PEMASOK', 'NO PJBBBM', 'required');
        $this->form_validation->set_rules('SKEMA_ISIDENTIL', 'Skema insidentil', 'required');

        $this->form_validation->set_rules('JENIS_KURS', 'Referensi Kurs', 'required');

        $x = $this->input->post('JML_KIRIM');
        $ada=0;

        if ($x>0){
            if ($x>20){
                $x=20;
            }
            for ($i=1; $i<=$x; $i++) {
                if ($this->input->post('pilih_ke'.$i)){
                    $ada=1;
                    break;
                }
            }
        }

        if ($ada==0){
            $this->form_validation->set_rules('pilih_ke'.$i, 'Checklist Hitung Insidentil ', 'required',
                        array('required' => 'Checklist Hitung Insidentil harus dipilih'));
        }

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses perhitungan harga gagal.', '');
            // $id = $this->input->post('id');           
            $vidtrans = $this->input->post('id');

            $createby = $this->session->userdata('user_name');     
            $tglposting = $this->laccess->setTgl($this->input->post('periode')); 
            $JENIS_KURS = $this->input->post('JENIS_KURS');
            $skema = $this->input->post('SKEMA_ISIDENTIL');
            $idgroup = $this->input->post('IDGROUP');

            // $cek_periode = $this->tbl_get->cek_periode_akr_kpm($periode,$no_pjbbm,$vidtrans);
            // if ($cek_periode){
            //     $message = array(false, 'Proses gagal', 'Perhitungan Harga '.$cek_periode.' <br>Periode '.$periode.' sudah ada pada sistem', '');
            //     echo json_encode($message, true);
            //     exit();
            // }


            $all_data = array(); 
            $all_id_koreksi = array(); 
            // $vidtrans = $this->input->post('id');

            for ($i=1; $i<=$x; $i++) {


                $sloc = $this->input->post('sloc_ke'.$i);
                // $idtrans = $this->input->post('idtrans_ke'.$i);
                $idtrans = $this->input->post('id_edit_ke'.$i);
                $pilih = $this->input->post('pilih_ke'.$i);
                
                if ($pilih){
                    // $all_id_koreksi[] = "call_hitung_harga_arr_ulang($createby, $tglposting, $idtrans, $sloc, $JENIS_KURS);";
                    $record = $this->tbl_get->call_hitung_harga_arr_ulang($createby, $tglposting, $idtrans, $sloc, $JENIS_KURS,$skema,$idgroup);

                    //jika mops tidak sesuai skema
                    if ($record[0]['RCDB']!='RCDB'){
                        $message = array(false, 'Proses gagal', $record[0]['PESANDB'], '');
                        echo json_encode($message, true);
                        exit();
                    }

                    if ($record){
                        $all_data[] = $record; 
                        $all_id_koreksi[] = $this->input->post('id_koreksi_ke'.$i); 
                    }
                }
            }

            $data['ket'] = $this->input->post('ket');
            $data['list'] = $all_data;
            $data['id'] = $vidtrans; 
            $data['list_idkoreksi'] = $all_id_koreksi;

            // print_r($data['list_idkoreksi']); die;
            // print_r($all_data); die;

            foreach ($all_data as $row) {
                foreach ($row as $row2) {
                    $vidtrans = $row2['idtrans'];
                    $vidtrans_edit = $row2['idtrans_edit'];
                    break;
                }
                break;
            }

            // print_r($data['list']); die;

            $view_form = $this->load->view($this->_module . '/table_akr_kpm', $data, true);
            $message = array(true, 'Proses Berhasil', 'Proses perhitungan harga berhasil.', '#content_table',$view_form, $vidtrans, $vidtrans_edit);

        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function get_hitung_harga_edit() {
        // $this->form_validation->set_rules('periode', 'Periode Perhitungan', 'required');
        // $this->form_validation->set_rules('pemasok', 'Pemasok', 'required');
        // $this->form_validation->set_rules('tglawal', 'Periode Awal (Kurs & MOPS)', 'required|max_length[10]');
        // $this->form_validation->set_rules('tglakhir', 'Periode Akhir (Kurs & MOPS)', 'required|max_length[10]');

        $this->form_validation->set_rules('IDGROUP', 'IDGROUP', 'required');

        $x = $this->input->post('JML_KIRIM');

        

        // if ($x>0){
        //     if ($x>20){
        //         $x=20;
        //     }
        //     for ($i=1; $i<=$x; $i++) {
        //         $this->form_validation->set_rules('reg_ke'.$i, 'Regional ke '.$i, 'required');
        //         $this->form_validation->set_rules('cmblv1_ke'.$i, 'Level 1 ke '.$i, 'required');
        //         $this->form_validation->set_rules('cmblv2_ke'.$i, 'Level 2 ke '.$i, 'required');
        //         $this->form_validation->set_rules('cmblv3_ke'.$i, 'Level 3 ke '.$i, 'required');
        //         $this->form_validation->set_rules('cmblv4_ke'.$i, 'Pembangkit ke '.$i, 'required');

        //         $this->form_validation->set_rules('ak_alpha_ke'.$i, 'Alpha ke '.$i, 'required|max_length[15]');
        //         $this->form_validation->set_rules('ak_sulfur_ke'.$i, 'Sulfur ke '.$i, 'required|max_length[15]');
        //         $this->form_validation->set_rules('ak_konversi_ke'.$i, 'Konversi ke '.$i, 'required|max_length[15]');
        //         $this->form_validation->set_rules('ak_oa_ke'.$i, 'OAT ke '.$i, 'required|max_length[15]');
        //     }
        // }

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses perhitungan harga gagal.', '');
            // $id = $this->input->post('id');

            $vidtrans = $this->input->post('id');
            $NOPJBBM = $this->input->post('NOPJBBM_KONTRAK_PEMASOK');
            $PERIODE = $this->input->post('periode_edit');

            $IDGROUP = $this->input->post('IDGROUP');

            $id = $vidtrans;
            $data['id'] = $vidtrans;
            $data['list'] = $this->tbl_get->get_hitung_harga_edit($IDGROUP);
            $data['stat'] = $this->input->post('stat');

            $get_tbl = $this->tbl_get->data($id);
            $data['default'] = $get_tbl->get()->row(); 
            
            // print_r($data['list']); die;

            if ($data['stat']=='approve'){
                $data['button_group'] = array(
                    anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('class' => 'btn', 'id' => 'button-tutup', 'onclick' => 'close_form(this.id)', 'data-source' => base_url($this->_module . '/add'))),
                    anchor(null, '<i class="icon-ok"></i> Setujui', array('class' => 'btn blue', 'id' => 'button-setuju-'.$id, 'onclick' => 'approveData(this.id)', 'data-source' => base_url($this->_module . '/add'))),
                    anchor(null, '<i class="icon-remove"></i> Tolak', array('class' => 'btn red', 'id' => 'button-tolak-'.$id, 'onclick' => 'tolakData(this.id)', 'data-source' => base_url($this->_module . '/add')))
                );  
            } else if ($data['stat']=='approve_koreksi'){
                $data['button_group'] = array(
                    anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('class' => 'btn', 'id' => 'button-tutup', 'onclick' => 'close_form(this.id)', 'data-source' => base_url($this->_module . '/add'))),
                    anchor(null, '<i class="icon-save"></i> Simpan', array('class' => 'btn blue', 'id' => 'button-simpankoreksi-'.$id, 'onclick' => 'koreksiData(this.id)', 'data-source' => base_url($this->_module . '/add')))
                );
            } else if ($data['stat']=='approve_koreksi_hasil'){
                $data['button_group'] = array(
                    anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('class' => 'btn', 'id' => 'button-tutup', 'onclick' => 'close_form(this.id)', 'data-source' => base_url($this->_module . '/add'))),
                    anchor(null, '<i class="icon-ok"></i> Setujui Koreksi', array('class' => 'btn blue', 'id' => 'button-setuju-'.$id, 'onclick' => 'approveDataKoreksi(this.id)', 'data-source' => base_url($this->_module . '/add'))),
                    anchor(null, '<i class="icon-remove"></i> Tolak Koreksi', array('class' => 'btn red', 'id' => 'button-tolak-'.$id, 'onclick' => 'tolakDataKoreksi(this.id)', 'data-source' => base_url($this->_module . '/add')))
                );
            } else {
                $data['button_group'] = array(
                    anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('class' => 'btn', 'id' => 'button-tutup', 'onclick' => 'close_form(this.id)', 'data-source' => base_url($this->_module . '/add')))
                );   
            }

            $view_form = $this->load->view($this->_module . '/table_akr_kpm_edit', $data, true);
            $message = array(true, 'Proses Berhasil', 'Proses perhitungan harga berhasil.', '#content_table',$view_form, $vidtrans);

        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function simpan_data() {
        $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
        $vidtrans = $this->input->post('vidtrans');

        $vidgroup = $this->getIdGroup();
        
        $record = $this->tbl_get->call_simpan_data($vidtrans,$vidgroup);

        // print_r('$record='.$record); die;

        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table',$record, $vidtrans);

        echo json_encode($message, true);
    }

    public function simpan_data_edit() {
        $message = array(false, 'Proses gagal', 'Proses update data gagal.', '');
        $vidtrans = $this->input->post('vidtrans');
        $vidtrans_edit = $this->input->post('vidtrans_edit'); 
        $vidkoreksi = $this->input->post('vidkoreksi');
        $vidgroup = $this->getIdGroup();
        
        $record = $this->tbl_get->call_simpan_data_edit($vidtrans,$vidtrans_edit,$vidgroup,$vidkoreksi);

        // print_r('$record='.$record); die;

        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table',$record, $vidtrans,$vidtrans_edit);

        echo json_encode($message, true);
    }

    public function simpan_data_koreksi() {
        $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
        $vidtrans = $this->input->post('vidtrans');
        $vidtrans_edit = $this->input->post('vidtrans_edit');

        $vidgroup = $this->getIdGroup();
        
        $record = $this->tbl_get->call_simpan_data($vidtrans,$vidgroup,$vidtrans_edit,'9');

        // print_r('$record='.$record); die;

        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table',$record, $vidtrans);

        echo json_encode($message, true);
    }

    public function simpan_data_all_lama() {
        $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
        
        $total = $this->input->post('vidtrans_total');
        $vidgroup = $this->getIdGroup();

        for ($i=1; $i<=$total; $i++) {
            $vidtrans = $this->input->post('vidtrans_save_ke'.$i);

            $record = $this->tbl_get->call_simpan_data($vidtrans,$vidgroup);    
        }

        // print_r('$record='.$record); die;

        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table',$record, $vidtrans);

        echo json_encode($message, true);
    }

    public function simpan_data_all(){
        $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
        $vidgroup = $this->getIdGroup();
        $nama_file = '';

        if (!empty($_FILES['PATH_FILE']['name'])){
            $_prod = '';

            $new_name = 'DOC_HARGA_NR_'.$vidgroup;
            $config['file_name'] = $new_name;
            $config['upload_path'] = 'assets/upload/kontrak_pemasok/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size'] = 1024 * 10; 
            // $config['encrypt_name'] = TRUE;

            if ($this->input->post('PATH_FILE_EDIT')){
                $target='assets/upload/kontrak_pemasok/'.$this->input->post('PATH_FILE_EDIT');

                if(file_exists($target)){
                    unlink($target);
                }                
            }
            
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('PATH_FILE')){
                $err = $this->upload->display_errors('', '');
                $message = array(false, 'Proses upload gagal', $err, '');
                echo json_encode($message, true);
                exit();
            } else {
                $cek_file = $this->upload->data();
                if ($cek_file){
                    $nama_file= $cek_file['file_name'];
                    
                    //new move file
                    $_prod = $this->laccess->post_file_prod('KONTRAKPEMASOK',$nama_file);
                    if ($_prod ==''){
                        //upload sukes
                        
                    } else {
                        $message = array(false, 'Proses upload gagal', $_prod, '');
                        echo json_encode($message, true);
                        exit();
                    }
                }
            }
        }

        $total = $this->input->post('vidtrans_total');
        
        $berhasil=0;
        $gagal=0;
        $gagal_pesan='';

        for ($i=1; $i<=$total; $i++) {

            $vidtrans = $this->input->post('vidtrans_save_ke'.$i);
            $simpan = $this->tbl_get->call_simpan_data($vidtrans,$vidgroup,'','',$nama_file); 

            if ($simpan[0]->RCDB == "RC00") {
                $berhasil++;
            } else {
                $gagal++;
                $gagal_pesan .= $simpan[0]->PESANDB.'<br>'; 
            }
        }

        if (($berhasil>0) && ($gagal>0)){
            $rest = 'Total Proses : '.($berhasil+$gagal).'  
                    <br>
                    - Tersimpan : '.$berhasil.'  
                    <br>
                    - Gagal : '.$gagal.' 
                    <br>
                    <br> 
                    - Pesan Gagal :
                    <br> 
                    '.$gagal_pesan;

            $message = array(false, 'Proses Tersimpan Sebagian', $rest, '#content_table');

        } else if ($berhasil>0) {
            $rest = '- Sukses simpan data : '.$berhasil.' PLTD';

            $message = array(true, 'Proses Tersimpan', $rest, '#content_table',$simpan, $vidtrans);
            
        } else if ($gagal>0) {
            $rest = '- Gagal simpan data : '.$gagal.' 
                    <br>
                    <br> 
                    - Pesan Gagal :
                    <br> 
                    '.$gagal_pesan;

            $message = array(false, 'Proses Gagal', $rest, '');
        }
        
        echo json_encode($message, true);
    }

    public function simpan_data_all_edit() {
        $message = array(false, 'Proses gagal', 'Proses update data gagal.', '');
        $vidgroup = $this->getIdGroup();
        $nama_file = '';

        if (!empty($_FILES['PATH_FILE']['name'])){
            $_prod = '';

            $new_name = 'DOC_PERHITUNGAN_HARGA_'.$vidgroup;
            $config['file_name'] = $new_name;
            $config['upload_path'] = 'assets/upload/kontrak_pemasok/';
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size'] = 1024 * 10; 
            // $config['encrypt_name'] = TRUE;

            if ($this->input->post('PATH_FILE_EDIT')){
                $target='assets/upload/kontrak_pemasok/'.$this->input->post('PATH_FILE_EDIT');

                if(file_exists($target)){
                    unlink($target);
                }                
            }
            
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('PATH_FILE')){
                $err = $this->upload->display_errors('', '');
                $message = array(false, 'Proses upload gagal', $err, '');
                echo json_encode($message, true);
                exit();
            } else {
                $cek_file = $this->upload->data();
                if ($cek_file){
                    $nama_file= $cek_file['file_name'];
                    
                    //new move file
                    $_prod = $this->laccess->post_file_prod('KONTRAKPEMASOK',$nama_file);
                    if ($_prod ==''){
                        //sukses

                    } else {
                        $message = array(false, 'Proses upload gagal', $_prod, '');
                        echo json_encode($message, true);
                        exit();
                    }
                }
            }
        }
        
        $total = $this->input->post('vidtrans_total');
        
        $vidkoreksi = ''; //$this->input->post('vidkoreksi');

        for ($i=1; $i<=$total; $i++) {
            $vidtrans = $this->input->post('vidtrans_save_ke'.$i);
            $vidtrans_edit = $this->input->post('vidtrans_edit_save_ke'.$i);
            $vidkoreksi = $this->input->post('vidkoreksi_ke'.$i);
            $record = $this->tbl_get->call_simpan_data_edit($vidtrans,$vidtrans_edit,$vidgroup,$vidkoreksi,$nama_file);
        }

        // print_r('$record='.$record); die;

        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table',$record, $vidtrans, $vidtrans_edit, $total);

        echo json_encode($message, true);
    }

    public function simpan_data_all_koreksi() {
        $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
        
        $total = $this->input->post('vidtrans_total');
        $vidgroup = $this->getIdGroup();

        for ($i=1; $i<=$total; $i++) {
            $vidtrans = $this->input->post('vidtrans_save_ke'.$i);
            $vidtrans_edit = $this->input->post('vidtrans_koreksi_ke'.$i);
  
            $record = $this->tbl_get->call_simpan_data($vidtrans,$vidgroup,$vidtrans_edit,'9');
        }

        // print_r('$record='.$record); die;

        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table',$record, $vidtrans);

        echo json_encode($message, true);
    }

    public function get_mops_kurs(){
        $vidtrans = $this->input->post('vidtrans');
        $data['list'] = $this->tbl_get->call_mops_kurs($vidtrans);

        // print_r($data); die;
        
        $this->load->view($this->_module . '/list_data', $data);
    }

    public function get_mops_kurs_pertamina_edit(){
        $vidtrans = $this->input->post('vidtrans');
        $data['list'] = $this->tbl_get->get_mops_kurs_edit($vidtrans);

        // print_r($data); die;
        
        $this->load->view($this->_module . '/list_data', $data);
    }

    public function get_mops_kurs_pertamina_ulang(){
        $vidtrans = $this->input->post('vidtrans');
        $data['list'] = $this->tbl_get->get_mops_kurs_ulang($vidtrans);

        // print_r($data); die;
        
        $this->load->view($this->_module . '/list_data', $data);
    }

    public function get_mops_kurs_akr_kpm(){
        $vidtrans = $this->input->post('vidtrans');
        $data['list'] = $this->tbl_get->call_mops_kurs($vidtrans);

        // print_r($data); die;
        
        $this->load->view($this->_module . '/list_lowmops', $data);
    }

    public function get_mops_kurs_akr_kpm_edit(){
        $vidtrans = $this->input->post('vidtrans');
        $data['list'] = $this->tbl_get->get_mops_kurs_edit($vidtrans);

        // print_r($data); die;
        
        $this->load->view($this->_module . '/list_lowmops', $data);
    }

    public function get_mops_kurs_akr_kpm_ulang(){
        $vidtrans = $this->input->post('vidtrans');
        $data['list'] = $this->tbl_get->get_mops_kurs_ulang($vidtrans);

        // print_r($data); die;
        
        $this->load->view($this->_module . '/list_lowmops', $data);
    }

    public function get_detail() {
        $message = $this->tbl_get->get_detail();
        echo json_encode($message);
    }

    public function get_detail_edit() {
        $message = $this->tbl_get->get_detail_edit();
        echo json_encode($message);
    }

    public function get_detail_edit_nr() {
        $message = $this->tbl_get->get_detail_edit_nr();
        echo json_encode($message);
    }

    public function kirim_data() {
        $message = array(false, 'Proses gagal', 'Proses kirim data gagal.', '');
        $vidtrans = $this->input->post('vidtrans');
        
        // $record = $this->tbl_get->call_kirim_data($vidtrans);

        // print_r('$record='.$record); die;

        $message = array(true, 'Proses Berhasil', 'Proses kirim data berhasil.', '#content_table',$record, $vidtrans);

        echo json_encode($message, true);
    }

    public function kirim_approve() {
        $this->form_validation->set_rules('vidtrans', 'vidtrans', 'trim|required');
        if (($this->input->post('status')==3) || ($this->input->post('status')==8) || ($this->input->post('status')==12)){
            $this->form_validation->set_rules('KET_KOREKSI', 'Keterangan', 'trim|required');    
        }        
        
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses kirim data gagal.', '');
            $vidtrans = $this->input->post('vidtrans');
            $status = $this->input->post('status');
            $user_name = $this->session->userdata('user_name');
            $ket_koreksi = $this->input->post('KET_KOREKSI');
            $id_koreksi = $this->input->post('IDKOREKSI');
            
            $is_akr_kpm = $this->tbl_get->cek_akr_kpm($vidtrans);

            if ($is_akr_kpm[0]->NOPJBBM <> ''){

                $record = $this->tbl_get->get_akr_kpm($is_akr_kpm[0]->IDGROUP);

                foreach ($record as $row) {
                    $simpan = $this->tbl_get->call_kirim_data($row->IDTRANS, $status, $user_name, $ket_koreksi,$row->IDKOREKSI);
                }
            } else {
                $simpan = $this->tbl_get->call_kirim_data($vidtrans, $status, $user_name, $ket_koreksi, $id_koreksi);
            }

            // print_r($is_akr_kpm); die;
            // print_r($simpan); die;

            if ($simpan[0]->RCDB == "RC00") {
                $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
            } else {
                $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function approve_pertamina() {
        $message = array(false, 'Proses gagal', 'Proses kirim data gagal.', '');
        $vidtrans = $this->input->post('vidtrans');
        $status = '2';
        $user_name = $this->session->userdata('user_name');
        
        $simpan = $this->tbl_get->call_kirim_data($vidtrans, $status, $user_name);

        // print_r($simpan); die;

        if ($simpan[0]->RCDB == "RC00") {
            $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        } else {
            $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        }

        echo json_encode($message, true);
    }
 
}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */