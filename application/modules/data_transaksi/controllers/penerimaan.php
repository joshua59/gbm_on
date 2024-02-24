<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 19:10 AM
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Transaksi
 */
class penerimaan extends MX_Controller{
    private $_title = 'Mutasi Penerimaan';
    private $_limit = 10;
    private $_module = 'data_transaksi/penerimaan';


    public function __construct(){
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('penerimaan_model', 'tbl_get');
    }

    public function index(){
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number','maxlength'));
        // Memanggil Level User
        $data = $this->get_level_user();

        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form(this.id)', 'data-source' => base_url($this->_module . '/add')))
            );
        }

        $data['page_notif'] = false;
        $data['page_notif_status'] = '0';
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        $data['data_sources_rekap'] = base_url($this->_module . '/load_rekap');
        echo Modules::run("template/admin", $data);
    }

    public function notif($id=0){
        if (($this->session->userdata('level_user') >= 2) && 
            (($this->laccess->otoritas('add')) || ($this->laccess->otoritas('approve'))) ){
            // Load Modules
            $this->laccess->update_log();
            $this->load->module("template/asset");

            // Memanggil plugin JS Crud
            $this->asset->set_plugin(array('crud', 'format_number','maxlength'));
            // Memanggil Level User
            $data = $this->get_level_user();            
            // 0 : belum kirim
            // 1 : belum disetujui
            // 3 : data tolak
            // 4 : kirim closing
            // 5 : belum disetujui closing
            // 7 : tolak closing

            if ($this->laccess->otoritas('add')){
                if ($id==0){    //belum kirim
                    $data['page_title'] = '<i class="icon-laptop"></i> Kirim ' . $this->_title;   
                } else if ($id==3){   //data tolak
                    $data['page_title'] = '<i class="icon-laptop"></i> Tolak ' . $this->_title;
                } else if ($id==4){ //kirim closing
                    $data['page_title'] = '<i class="icon-laptop"></i> Kirim Closing ' . $this->_title;
                } else if ($id==7){ //tolak closing
                    $data['page_title'] = '<i class="icon-laptop"></i> Tolak Closing ' . $this->_title;                    
                } else {
                    redirect($this->_module);    
                } 
            } else {
                if ($id==1){  //belum disetujui
                    $data['page_title'] = '<i class="icon-laptop"></i> Persetujuan ' . $this->_title;
                } else if ($id==5){  //belum disetujui closing
                    $data['page_title'] = '<i class="icon-laptop"></i> Persetujuan Closing ' . $this->_title;
                } else {
                    redirect($this->_module);    
                }
            }
            
            $data['page_notif'] = true;
            $data['page_notif_status'] = $id;
            $data['page_content'] = $this->_module . '/main';
            $data['data_sources'] = base_url($this->_module . '/load');
            $data['data_sources_rekap'] = base_url($this->_module . '/load_rekap');
            echo Modules::run("template/admin", $data);
        } else {
            redirect($this->_module);
        }
    }

    public function update_notif_tolak() {
        $message = $this->tbl_get->update_notif_tolak();
        echo json_encode($message);
    }    

    function getIdGroup(){
        $vidgroup = '';
        $characters = $this->session->userdata('user_name').'abcdefghijklmnopqrstuvwxyz0123456789';
        $characters = str_replace('.','',$characters);
        $max = strlen($characters) - 1;
        for ($i = 0; $i < 15; $i++) {
          $vidgroup .= $characters[mt_rand(0, $max)];
        }
        return $vidgroup;
    }

    public function add($id = ''){
        $page_title = 'Tambah Penerimaan';
        $form = '/form';
        $data = $this->get_level_user(1);
        $data['id'] = $id;
        $data['id_dok'] = '';
        $data['IDGROUP'] = $this->getIdGroup();
        $data['data_sources_detail'] = base_url($this->_module . '/load_input');        

        // $level_user = $this->session->userdata('level_user');
        // $kode_level = $this->session->userdata('kode_level');
		$data['option_komponen'] = array();
        // if ($level_user==2){
        //     $data_lv = $this->tbl_get->get_level($level_user+3,$kode_level);
        //     if ($data_lv){
        //         $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
        //         $data['lv3_options'] = $option_lv3;
        //         $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1); 
        //     }
        // }    
        
        $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan_byid('--Pilih Jenis Penerimaan--', $key = '0', 1);        

        if ($id != '') {
            $page_title = 'Edit Penerimaan';
            $form = '/form_edit';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();            
            $data['id_dok'] = $data['default']->PATH_FILE; 
            $data['option_komponen_bio'] = $this->tbl_get->option_komponen_bio($data['default']->ID_KOMPONEN_BBM,1);
            $data['option_pemasok'] = $this->tbl_get->options_pemasok_by_sloc('--Pilih Pemasok--', $data['default']->SLOC); 

            // if ($data['default']->SLOC){
            //     $data_lv = $this->tbl_get->get_level('4',$data['default']->SLOC);

            //     $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            //     $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            //     $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            //     $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            //     $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4; 

            //     if ($level_user==3){
            //         $data['lv4_options'] = $option_lv4;     
            //     } else if ($level_user==2){
            //         $data['lv3_options'] = $option_lv3;
            //         $data['lv4_options'] = $option_lv4;     
            //     } else if ($level_user==1){
            //         $data['lv2_options'] = $option_lv2;
            //         $data['lv3_options'] = $option_lv3;
            //         $data['lv4_options'] = $option_lv4;     
            //     } else if ($level_user==0){
            //         $data['lv1_options'] = $option_lv1;
            //         $data['lv2_options'] = $option_lv2;
            //         $data['lv3_options'] = $option_lv3;
            //         $data['lv4_options'] = $option_lv4;     
            //     } else if ($level_user=='R'){
            //         $data['reg_options'] = $option_reg;
            //         $data['lv1_options'] = $option_lv1;
            //         $data['lv2_options'] = $option_lv2;
            //         $data['lv3_options'] = $option_lv3;
            //         $data['lv4_options'] = $option_lv4;     
            //     }
            // }
			
            $tgl_catat = new DateTime($data['default']->TGL_PENERIMAAN);
            $tgl_pengakuan = new DateTime($data['default']->TGL_PENGAKUAN);

            $data['default']->TGL_PENERIMAAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_PENGAKUAN = $tgl_pengakuan->format('d-m-Y');
            $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
            $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan_byid('', $key = $data['default']->ID_PEMASOK, 1);
        } else {
            $data['option_jenis_bbm'][''] = '--Pilih Jenis BBM--';//$this->tbl_get->options_jenis_bahan_bakar();
            $data['option_pemasok'] = array('' =>'--Pilih Pemasok--');
        }
        
		$data['urlcheckjnsbbm'] = base_url($this->_module) .'/load_komponen';
		$data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';
        // $data['option_pemasok'] = $this->tbl_get->options_pemasok_non_pln();        
        $data['option_transportir'] = $this->tbl_get->options_transpotir();                   

        // $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
		if ($id != '')
			$data['option_komponen'] = $this->tbl_get->option_komponen($data['default']->ID_JNS_BHN_BKR);
        $this->load->view($this->_module . $form, $data);
    }

    public function edit_unitlain($id = ''){
        $page_title = 'Tambah Penerimaan';
        $form = '/form';
        $data = $this->get_level_user(1);
        $data['id'] = $id;
        $data['id_dok'] = '';
        $data['IDGROUP'] = $this->getIdGroup();
        $data['data_sources_detail'] = base_url($this->_module . '/load_input');        

        $data['option_komponen'] = array();
        $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan_byid('--Pilih Jenis Penerimaan--', $key = '0', 1);

        if ($id != '') {
            $page_title = 'Edit Penerimaan (Unit Lain)';
            $form = '/form_edit_unitlain';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();            
            $data['id_dok'] = $data['default']->PATH_FILE; 
            $data['option_komponen_bio'] = $this->tbl_get->option_komponen_bio($data['default']->ID_KOMPONEN_BBM,1);

            // print_r($data['default']); die; 

            if ($data['default']->SLOC_KIRIM){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->SLOC_KIRIM);

                $option_reg_pemasok[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1_pemasok[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2_pemasok[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3_pemasok[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4_pemasok[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4;
                $data['reg_options_pemasok'] = $option_reg_pemasok;
                $data['lv1_options_pemasok'] = $option_lv1_pemasok;
                $data['lv2_options_pemasok'] = $option_lv2_pemasok;
                $data['lv3_options_pemasok'] = $option_lv3_pemasok;
                $data['lv4_options_pemasok'] = $option_lv4_pemasok;  
                $get_tug = $this->tbl_get->get_tug($data['default']->ID_PENERIMAAN);
                $data['NO_TUG'] = $get_tug->NO_TUG;                        
            }

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->SLOC);

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
            }            
            
            $tgl_catat = new DateTime($data['default']->TGL_PENERIMAAN);
            $tgl_pengakuan = new DateTime($data['default']->TGL_PENGAKUAN);

            $data['default']->TGL_PENERIMAAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_PENGAKUAN = $tgl_pengakuan->format('d-m-Y');
            $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
            $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan_byid('', $key = $data['default']->ID_PEMASOK, 1);
        } else {
            $data['option_jenis_bbm'][''] = '--Pilih Jenis BBM--';//$this->tbl_get->options_jenis_bahan_bakar();
        }
        
        $data['urlcheckjnsbbm'] = base_url($this->_module) .'/load_komponen';
        $data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';
        $data['option_pemasok'] = $this->tbl_get->options_pemasok($data['default']->ID_PEMASOK,'');
        $data['option_transportir'] = $this->tbl_get->options_transpotir();
        
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        if ($id != '')
            $data['option_komponen'] = $this->tbl_get->option_komponen($data['default']->ID_JNS_BHN_BKR);
        $this->load->view($this->_module . $form, $data);
    }    

    public function edit_js($id = ''){
        $data = $this->get_level_user();
        $data['id'] = $id;
        $data['IDGROUP'] = $this->getIdGroup();
        $data['data_sources_detail'] = base_url($this->_module . '/load_input');        
        $data['option_komponen'] = array(); 
        $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan_byid('--Pilih Jenis Penerimaan--', $key = '0', 1);

        if ($id != '') {
            $page_title = 'Edit Penerimaan';
            $form = '/form_edit_js';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();            
            $data['id_dok'] = $data['default']->PATH_FILE; 
            $data['option_komponen_bio'] = $this->tbl_get->option_komponen_bio($data['default']->ID_KOMPONEN_BBM,1);

            $tgl_catat = new DateTime($data['default']->TGL_PENERIMAAN);
            $tgl_pengakuan = new DateTime($data['default']->TGL_PENGAKUAN);

            $data['default']->TGL_PENERIMAAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_PENGAKUAN = $tgl_pengakuan->format('d-m-Y');
            $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
            $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan_byid('', $key = $data['default']->ID_PEMASOK, 1);
        } else {
            $data['option_jenis_bbm'][''] = '--Pilih Jenis BBM--';//$this->tbl_get->options_jenis_bahan_bakar();
        }
        
        $data['urlcheckjnsbbm'] = base_url($this->_module) .'/load_komponen';
        $data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';
        $data['option_pemasok'] = $this->tbl_get->options_pemasok();
        $data['option_transportir'] = $this->tbl_get->options_transpotir();

        // $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        if ($id != '')
            $data['option_komponen'] = $this->tbl_get->option_komponen($data['default']->ID_JNS_BHN_BKR);
        $this->load->view($this->_module . $form, $data);
    }

    public function edit_view($id = ''){
        $data = $this->get_level_user();
        $data['id'] = $id;
        $data['id_dok'] = ''; 
        $form_view ='/form_view';
        if ($id != '') {
            $page_title = 'Detail Penerimaan';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();
            $data['id_dok'] = $data['default']->PATH_FILE; 

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->SLOC);

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
            }

            if ($data['default']->SLOC_KIRIM){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->SLOC_KIRIM);

                $option_reg_pemasok[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $option_lv1_pemasok[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
                $option_lv2_pemasok[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
                $option_lv3_pemasok[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $option_lv4_pemasok[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4;
                $data['reg_options_pemasok'] = $option_reg_pemasok;
                $data['lv1_options_pemasok'] = $option_lv1_pemasok;
                $data['lv2_options_pemasok'] = $option_lv2_pemasok;
                $data['lv3_options_pemasok'] = $option_lv3_pemasok;
                $data['lv4_options_pemasok'] = $option_lv4_pemasok;  
                $get_tug = $this->tbl_get->get_tug($data['default']->ID_PENERIMAAN);
                $data['NO_TUG'] = $get_tug->NO_TUG;   
                $form_view ='/form_view_unitlain';                     
            }

            if ($data['default']->IS_TOLAK){
                $this->tbl_get->update_notif_tolak($id);
                $data['default']->IS_TOLAK = '3';
            }            

            $data['urlcheckjnsbbm'] = base_url($this->_module) .'/load_komponen';
            $data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';           

            $tgl_catat = new DateTime($data['default']->TGL_PENERIMAAN);
            $tgl_pengakuan = new DateTime($data['default']->TGL_PENGAKUAN);
            $data['default']->STATUS_TOLAK = $data['default']->STATUS_MUTASI_TERIMA;

            $data['default']->TGL_PENERIMAAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_PENGAKUAN = $tgl_pengakuan->format('d-m-Y');
            $data['option_komponen_bio'] = $this->tbl_get->option_komponen_bio($data['default']->ID_KOMPONEN_BBM,1);
        }

        $data['option_pemasok'] = $this->tbl_get->options_pemasok();
        $data['option_transportir'] = $this->tbl_get->options_transpotir();
        $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan();
        $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        if ($id != '')
        $data['option_komponen'] = $this->tbl_get->option_komponen($data['default']->ID_JNS_BHN_BKR);
        $this->load->view($this->_module . $form_view, $data);
    }

    public function tolak_view($id = ''){
        $data = $this->get_level_user();
        $data['id'] = $id;
        $data['id_dok'] = ''; 
        if ($id != '') {
            $page_title = 'Tolak Detail Penerimaan';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();
            $data['id_dok'] = $data['default']->PATH_FILE; 

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->SLOC);

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
            }

            $data['urlcheckjnsbbm'] = base_url($this->_module) .'/load_komponen';
            $data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';  
            $tgl_catat = new DateTime($data['default']->TGL_PENERIMAAN);
            $tgl_pengakuan = new DateTime($data['default']->TGL_PENGAKUAN);

            $data['option_komponen_bio'] = $this->tbl_get->option_komponen_bio($data['default']->ID_KOMPONEN_BBM,1);
            $data['default']->TGL_PENERIMAAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_PENGAKUAN = $tgl_pengakuan->format('d-m-Y');
            $data['default']->STATUS_TOLAK = '3';
        }

        $data['button_group'] = array(
            anchor(null, '<i class="icon-remove"></i> Proses Tolak', array('id' => 'button-tolak', 'class' => 'red btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back');"))
        );
        
        $data['option_pemasok'] = $this->tbl_get->options_pemasok();
        $data['option_transportir'] = $this->tbl_get->options_transpotir();
        $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan();
        $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses_tolak');
        if ($id != '')
        $data['option_komponen'] = $this->tbl_get->option_komponen($data['default']->ID_JNS_BHN_BKR);
        $this->load->view($this->_module . '/form_view', $data);
    }

    public function tolak_view_closing($id = ''){
        $data = $this->get_level_user();
        $data['id'] = $id;
        $data['id_dok'] = ''; 
        if ($id != '') {
            $page_title = 'Tolak Detail Penerimaan (Closing)';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();
            $data['id_dok'] = $data['default']->PATH_FILE; 

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->SLOC);

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
            }

            $data['urlcheckjnsbbm'] = base_url($this->_module) .'/load_komponen';
            $data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';  
            $tgl_catat = new DateTime($data['default']->TGL_PENERIMAAN);
            $tgl_pengakuan = new DateTime($data['default']->TGL_PENGAKUAN);

            $data['option_komponen_bio'] = $this->tbl_get->option_komponen_bio($data['default']->ID_KOMPONEN_BBM,1);
            $data['default']->TGL_PENERIMAAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_PENGAKUAN = $tgl_pengakuan->format('d-m-Y');
            $data['default']->STATUS_TOLAK = '7';
        }

        $data['button_group'] = array(
            anchor(null, '<i class="icon-remove"></i> Proses Tolak', array('id' => 'button-tolak', 'class' => 'red btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back');"))
        );
        
        $data['option_pemasok'] = $this->tbl_get->options_pemasok();
        $data['option_transportir'] = $this->tbl_get->options_transpotir();
        $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan();
        $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses_tolak');
        if ($id != '')
        $data['option_komponen'] = $this->tbl_get->option_komponen($data['default']->ID_JNS_BHN_BKR);
        $this->load->view($this->_module . '/form_view', $data);
    }    

    public function edit($id){
        $this->add($id);
    }

    public function edit_notif($id = ''){
        $page_title = 'Tambah Penerimaan';
        $form = '/form';
        $data = $this->get_level_user(1);
        $data['id'] = $id;
        $data['id_dok'] = '';
        $data['IDGROUP'] = $this->getIdGroup();
        $data['data_sources_detail'] = base_url($this->_module . '/load_input');        
        $data['option_komponen'] = array();
        $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan_byid('--Pilih Jenis Penerimaan--', $key = '0', 1);        

        if ($id != '') {
            $page_title = 'Edit Penerimaan';
            $form = '/form_edit';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();            
            $data['id_dok'] = $data['default']->PATH_FILE; 
            $data['option_komponen_bio'] = $this->tbl_get->option_komponen_bio($data['default']->ID_KOMPONEN_BBM,1);
            $data['option_pemasok'] = $this->tbl_get->options_pemasok_by_sloc('--Pilih Pemasok--', $data['default']->SLOC); 

            $tgl_catat = new DateTime($data['default']->TGL_PENERIMAAN);
            $tgl_pengakuan = new DateTime($data['default']->TGL_PENGAKUAN);

            $data['default']->TGL_PENERIMAAN = $tgl_catat->format('d-m-Y');
            $data['default']->TGL_PENGAKUAN = $tgl_pengakuan->format('d-m-Y');
            $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
            $data['option_jenis_penerimaan'] = $this->tbl_get->options_jenis_penerimaan_byid('', $key = $data['default']->ID_PEMASOK, 1);
        } else {
            $data['option_jenis_bbm'][''] = '--Pilih Jenis BBM--';
            $data['option_pemasok'] = array('' =>'--Pilih Pemasok--');
        }
        
        $data['urlcheckjnsbbm'] = base_url($this->_module) .'/load_komponen';
        $data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';        
        $data['option_transportir'] = $this->tbl_get->options_transpotir();              
        
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        if ($id != '')
            $data['option_komponen'] = $this->tbl_get->option_komponen($data['default']->ID_JNS_BHN_BKR);
        $this->load->view($this->_module . $form, $data);
    }    

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'TABLE_PENERIMAAN';
        $table->style = "table table-striped table-bordered datatable dataTable";
        $table->align = array('NO' => 'center', 'BLTH' => 'center', 'LEVEL4' => 'center', 'STATUS' => 'center', 'TOTAL_VOLUME' => 'right', 'COUNT' => 'center', 'AKSI' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 7;
        $table->header[] = array(
            "NO", 1, 1,
            "BLTH", 1, 1,
            "PEMBANGKIT", 1, 1,
           // "STATUS", 1, 1,
            "TOTAL_VOLUME (L)", 1, 1,
            "COUNT", 1, 1,
            "AKSI", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function load_rekap($page = 1) {
        $data_table = $this->tbl_get->data_table_rekap($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'TABLE_PENERIMAAN_REKAP';
        $table->style = "table table-striped table-bordered datatable dataTable";
        $table->align = array('BLTH' => 'center', 'PEMBANGKIT' => 'center', 'NO PENERIMAAN' => 'center', 'TGL PENGAKUAN' => 'center', 'NAMA PEMASOK' => 'left', 'NAMA TRANSPORTIR' => 'left', 'NAMA JNS BHN BKR' => 'center', 'VOL TERIMA (L)' => 'right', 'VOL TERIMA REAL (L)' => 'right', 'CREATED BY' => 'center', 'STATUS' => 'center', 'AKSI' => 'center', 'CHECK' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 13;
        $table->header[] = array(
            'BLTH', 1, 1,
            'PEMBANGKIT', 1, 1,
            'NO PENERIMAAN', 1, 1,
            'TGL PENGAKUAN', 1, 1,
            'NAMA PEMASOK', 1, 1,
            'NAMA TRANSPORTIR', 1, 1,
            'NAMA JNS BHN BKR', 1, 1,
            'VOLUME DO/TUG/BA (L)', 1, 1,
            'VOLUME PENERIMAAN (L)', 1, 1,
            'CREATED BY', 1, 1,
            'STATUS', 1, 1,
            'AKSI', 1, 1,
            'CHECK', 1, 1

        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function load_input($page = 1) {
        $data_table = $this->tbl_get->data_table_input($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'TABLE_PENERIMAAN_INPUT';
        $table->style = "table table-striped table-bordered datatable dataTable";
        $table->align = array('NO_MUTASI_TERIMA' => 'center', 'TGL_PENGAKUAN' => 'center', 'NAMA_PEMASOK' => 'center', 'NAMA_TRANSPORTIR' => 'center', 'LEVEL4' => 'center', 'NAMA_JNS_BHN_BKR' => 'center', 'VOL_TERIMA' => 'right', 'VOL_TERIMA_REAL' => 'right', 'CD_BY_MUTASI_TERIMA' => 'center', 'CD_DATE_MUTASI_TERIMA' => 'center', 'AKSI' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 11;
        $table->header[] = array(            
            'NO PENERIMAAN', 1, 1,
            'TGL PENGAKUAN', 1, 1,
            'NAMA PEMASOK', 1, 1,
            'NAMA TRANSPORTIR', 1, 1,
            'PEMBANGKIT', 1, 1,
            'NAMA JNS BHN BKR', 1, 1,
            'VOLUME DO/TUG/BA (L)', 1, 1,
            'VOLUME PENERIMAAN (L)', 1, 1,
            'CREATED BY', 1, 1,
            'CREATED TIME', 1, 1,
            'AKSI', 1, 1,
        );

        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses(){
        $this->form_validation->set_rules('TGL_PENERIMAAN', 'Tanggal Penerimaan (DO/TUG)', 'required');
        $this->form_validation->set_rules('TGL_PENGAKUAN', 'Tanggal Pengakuan Fisik', 'required');        
        $this->form_validation->set_rules('ID_TRANSPORTIR', 'Transportir', 'required');
        $this->form_validation->set_rules('ID_REGIONAL', 'Regional', 'required');
        $this->form_validation->set_rules('COCODE', 'Level l', 'required');
        $this->form_validation->set_rules('PLANT', 'Level 2', 'required');
        $this->form_validation->set_rules('STORE_SLOC', 'Level 3', 'required');
        $this->form_validation->set_rules('SLOC', 'Pembangkit', 'required');
        $this->form_validation->set_rules('ID_PEMASOK', 'Pemasok', 'required');
        
        // ID_PEMASOK jika unit lain / pln       
        if ($this->input->post("ID_PEMASOK")=='00000000000000000010'){
            $this->form_validation->set_rules('COCODE_KIRIM', 'Level l Pengirim', 'required');
            $this->form_validation->set_rules('PLANT_KIRIM', 'Level 2 Pengirim', 'required');
            $this->form_validation->set_rules('STORE_SLOC_KIRIM', 'Level 3 Pengirim', 'required');
            $this->form_validation->set_rules('SLOC_KIRIM', 'Pembangkit Pengirim', 'required');              
        }           

        $this->form_validation->set_rules('VALUE_SETTING', 'Jenis Penerimaan', 'required');
        $this->form_validation->set_rules('NO_PENERIMAAN', 'No Penerimaan', 'required|max_length[60]');
        $this->form_validation->set_rules('ID_JNS_BHN_BKR', 'Jenis Bahan Bakar', 'required');
        $this->form_validation->set_rules('VOL_PENERIMAAN', 'Volume DO/TUG', 'required|max_length[16]');
        $this->form_validation->set_rules('VOL_PENERIMAAN_REAL', 'Volume Penerimaan', 'required|max_length[16]');
		
		$ismix = $this->input->post('ismix');
		if ($ismix == '1') {
			$this->form_validation->set_rules('KOMPONEN', 'Komponen Jenis BBM', 'required');

            //val komponen bio dari turunan komponen bbm hsd+bio
            if ($this->input->post("KOMPONEN")=='003'){
                $this->form_validation->set_rules('JNS_BIO', 'Komponen BIO', 'required');    
            }
        }

        //val komponen bio dari jenis bbm bio
        if ($this->input->post("ID_JNS_BHN_BKR")=='003'){
            $this->form_validation->set_rules('JNS_BIO', 'Komponen BIO', 'required');    
        }               

        if ($this->form_validation->run($this)) {

            $data = array();
            $data['TGL_PENERIMAAN'] = str_replace('-', '', $this->input->post('TGL_PENERIMAAN'));
            $data['TGL_MUTASI'] = date("dmY");
            $data['TGL_PENGAKUAN'] = str_replace('-', '', $this->input->post('TGL_PENGAKUAN'));
            $data['ID_PEMASOK'] = $this->input->post('ID_PEMASOK');
            $data['ID_TRANSPORTIR'] = $this->input->post('ID_TRANSPORTIR');
            $data['SLOC'] = $this->input->post('SLOC');
            $data['VALUE_SETTING'] = $this->input->post('VALUE_SETTING');
            $data['NO_PENERIMAAN'] = $this->input->post('NO_PENERIMAAN');
            $data['ID_JNS_BHN_BKR'] = $this->input->post('ID_JNS_BHN_BKR');
            $data['VOL_PENERIMAAN'] =  str_replace(".","",$this->input->post('VOL_PENERIMAAN'));
            $data['VOL_PENERIMAAN'] =  str_replace(",",".",$data['VOL_PENERIMAAN']);
            $data['VOL_PENERIMAAN_REAL'] = str_replace(".","",$this->input->post('VOL_PENERIMAAN_REAL'));
            $data['VOL_PENERIMAAN_REAL'] = str_replace(",",".",$data['VOL_PENERIMAAN_REAL']);
            $data['CREATE_BY'] = $this->session->userdata('user_name');
			$data['IS_MIX'] = $this->input->post("ismix");
			$data['ID_KOMPONEN'] = $this->input->post("KOMPONEN");
            $data['KET_MUTASI_TERIMA'] = $this->input->post("KET_MUTASI_TERIMA");   
            $data['IDGROUP'] = $this->input->post("IDGROUP");
            $data['JNS_BIO'] = $this->input->post("JNS_BIO");

            //val komponen bio dari jenis bbm bio, set idkomponen bio
            if ($this->input->post("ID_JNS_BHN_BKR")=='003'){
                $data['ID_KOMPONEN'] = '003';
            }      

            
            if ($data['ID_PEMASOK']=='00000000000000000010'){
                $data['SLOC_KIRIM'] = $this->input->post("SLOC_KIRIM");
            } else {
                $data['SLOC_KIRIM'] = '';    
            }
            // if ($this->input->post("SLOC_KIRIM")){
            //     $data['SLOC_KIRIM'] = $this->input->post("SLOC_KIRIM");    
            // } else {
            //     $data['SLOC_KIRIM'] = '';
            // }
                        
            $id = $this->input->post('id');


            $nama_file='';
            
            if (!empty($_FILES['PATH_FILE']['name'])){
                $_prod = '';

                $new_name = preg_replace("/[^a-zA-Z0-9]/", "", $data['NO_PENERIMAAN']);
                $new_name = 'PENERIMAAN_'.$new_name.'_'.date("YmdHis");
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload/kontrak_transportir/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 10; 
                // $config['encrypt_name'] = TRUE;

                if ($this->input->post('PATH_FILE_EDIT')){
                    $target='assets/upload/kontrak_transportir/'.$this->input->post('PATH_FILE_EDIT');

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
                    // if ($cek_file){
                    //     $nama_file= $cek_file['file_name'];
                        
                    //     //new move file
                    //     $_prod = $this->laccess->post_file_prod('KONTRAKTRANSPORTIR',$nama_file);
                    //     if ($_prod ==''){
                    //         //upload sukes

                    //     } else {
                    //         $message = array(false, 'Proses upload gagal', $_prod, '');
                    //         echo json_encode($message, true);
                    //         exit();
                    //     }
                    // }
                }
                $data['PATH_FILE'] = $nama_file;                 
            } else {
                $data['PATH_FILE'] = $this->input->post("PATH_FILE_EDIT");
            }          
             
            if ($id!=null || $id!="") {
                $level_user = $this->session->userdata('level_user');
                $kode_level = $this->session->userdata('kode_level');

                $data['ID_PENERIMAAN']=$id;
                $data['LEVEL_USER']=$level_user;
                $data['KODE_LEVEL']=$kode_level;
                $data['STATUS'] = $this->input->post('STATUS_MUTASI_TERIMA');
                $simpan_data = $this->tbl_get->save_edit($data);
                if ($simpan_data[0]->RCDB == 'RC00') {
                    $message = array(true, 'Proses Update Berhasil', $simpan_data[0]->PESANDB, '#content_table');
                } else {
                    $message = array(false, 'Proses Update Gagal', $simpan_data[0]->PESANDB, '');
                }
            } else {
                $simpan_data = $this->tbl_get->save($data);
                if ($simpan_data[0]->RCDB == 'RC00') {
                    $message = array(true, 'Proses Simpan Berhasil', $simpan_data[0]->PESANDB, '#content_table');
                } else {
                    $message = array(false, 'Proses Simpan Gagal', $simpan_data[0]->PESANDB, '');
                }
            }
        }else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function proses_tolak(){
        $this->form_validation->set_rules('KET_BATAL', 'Keterangan Tolak', 'required|max_length[200]');
        
        if ($this->form_validation->run($this)) {               
            $level_user = $this->session->userdata('level_user');
            $kode_level = $this->session->userdata('kode_level');
            $user_name = $this->session->userdata('user_name');
            $jumlah = '1';

            $p = $this->input->post("id");   
            $s = $this->input->post("STATUS_TOLAK");
            $ket = $this->input->post("KET_BATAL");
            
            $simpan = $this->tbl_get->saveDetailPenerimaan($p, $s, $level_user, $kode_level, $user_name, $jumlah, $ket);

            if ($simpan[0]->RCDB == 'RC00') {
                $message = array(true, 'Proses Tolak Berhasil', $simpan[0]->PESANDB, '#content_table');
            } else {
                $message = array(false, 'Proses Tolak Gagal', $simpan[0]->PESANDB, '');
            }
            
        }else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function getDataDetail(){
        echo json_encode($this->tbl_get->getTableViewDetail());
    }

    public function saveKiriman($statusKirim){
        $pilihan = $this->input->post('pilihan');
        $idPenerimaan = $this->input->post('idPenerimaan');
        $p = ""; //penampung pilihan
        $s = ""; //penamping status
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        $user_name = $this->session->userdata('user_name');
        
        $jumlah=1;
        $berhasil=0;
        $gagal=0;
        $gagal_pesan='';
        $ket = '';

        for ($i = 0; $i < count($idPenerimaan); $i++) {
            if (isset($pilihan[$i])) {
                $p = $pilihan[$i];
                if ($statusKirim == 'kirim') {
                    $s = "1";
                } else if ($statusKirim == 'approve') {
                    $s = "2";
                } else {
                    $s = "3";
                }
                
                $simpan = $this->tbl_get->saveDetailPenerimaan($p, $s, $level_user, $kode_level, $user_name, $jumlah, $ket);

                if ($simpan[0]->RCDB == "RC00") {
                    $berhasil++;
                } else {
                    $gagal++;
                    $gagal_pesan .= $simpan[0]->PESANDB.'<br>'; 
                }

            }
        }

        if (($berhasil>0) && ($gagal>0)){
            $rest = 'Total Proses : '.($berhasil+$gagal).'  
                    <br>
                    - Sukses '.$statusKirim.' : '.$berhasil.'  
                    <br>
                    - Gagal '.$statusKirim.' : '.$gagal.' 
                    <br>
                    <br> 
                    - Pesan Gagal :
                    <br> 
                    '.$gagal_pesan;

            $message = array(false, 'Proses Terkirim Sebagian', $rest, '#content_table');

        } else if ($berhasil>0) {
            $rest = '- Sukses '.$statusKirim.' : '.$berhasil.' ';

            $message = array(true, 'Proses Terkirim', $rest, '#content_table');
            
        } else if ($gagal>0) {
            $rest = '- Gagal '.$statusKirim.' : '.$gagal.' 
                    <br>
                    <br> 
                    - Pesan Gagal :
                    <br> 
                    '.$gagal_pesan;

            $message = array(false, 'Proses Gagal', $rest, '');
        }

        // if ($simpan[0]->RCDB == "RC00") {
        //     $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        // } else {
        //     $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        // }
        
        echo json_encode($message, true);
    }

    public function saveKirimanClossing($statusKirim){
        $pilihan = $this->input->post('pilihan');
        $idPenerimaan = $this->input->post('idPenerimaan');
        $p = ""; //penampung pilihan
        $s = ""; //penamping status
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        $user_name = $this->session->userdata('user_name');
        $slocPilih = $this->input->post('idSLOC'); 
        
        $jumlah=1;
        $berhasil=0;
        $gagal=0;
        $gagal_pesan='';

        for ($i = 0; $i < count($idPenerimaan); $i++) {
            if (isset($pilihan[$i])) {
                $p = $pilihan[$i];
                $sloc = $slocPilih[$i];
                if ($statusKirim == 'kirim') {
                    $s = "5";
                } else if ($statusKirim == 'approve') {
                    $s = "6";
                } else {
                    $s = "7";
                }
                
                //PROSES_CLOSSING (sloc, p_id, p_lvl_user, p_status, p_kode_lvl, p_by_user,p_totalcheck)
                $simpan = $this->tbl_get->saveDetailClossing($sloc, $p, $level_user, $s, $kode_level, $user_name, $jumlah);

                if ($simpan[0]->RCDB == "RC00") {
                    $berhasil++;
                } else {
                    $gagal++;
                    $gagal_pesan .= $simpan[0]->PESANDB.'<br>'; 
                }

            }
        }

        if (($berhasil>0) && ($gagal>0)){
            $rest = 'Total Proses : '.($berhasil+$gagal).'  
                    <br>
                    - Sukses '.$statusKirim.' : '.$berhasil.'  
                    <br>
                    - Gagal '.$statusKirim.' : '.$gagal.' 
                    <br>
                    <br> 
                    - Pesan Gagal :
                    <br> 
                    '.$gagal_pesan;

            $message = array(false, 'Proses Terkirim Sebagian', $rest, '#content_table');

        } else if ($berhasil>0) {
            $rest = '- Sukses '.$statusKirim.' : '.$berhasil.' ';

            $message = array(true, 'Proses Terkirim', $rest, '#content_table');
            
        } else if ($gagal>0) {
            $rest = '- Gagal '.$statusKirim.' : '.$gagal.' 
                    <br>
                    <br> 
                    - Pesan Gagal :
                    <br> 
                    '.$gagal_pesan;

            $message = array(false, 'Proses Gagal', $rest, '');
        }

        // if ($simpan[0]->RCDB == "RC00") {
        //     $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        // } else {
        //     $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        // }
        
        echo json_encode($message, true);
    }

    public function get_level_user($id_add=''){
        $data['options_order'] = $this->tbl_get->options_order();
        $data['options_asc'] = $this->tbl_get->options_asc();
        $data['options_order_d'] = $this->tbl_get->options_order_d();
        $data['options_asc_d'] = $this->tbl_get->options_asc();
        $data['status_options'] = $this->tbl_get->options_status();
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

        $data['lv1_options_all'] = $this->tbl_get->options_lv1('--Pilih Level 1--', 'all', 1); 
        $data['lv2_options_all'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1); 
        $data['lv3_options_all'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);  
        $data['lv4_options_all'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);                

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

        //pltd langsung
        $data['set_lv'] = $level_user;
        if (($level_user==2) && ($id_add)){
            $data_lv = $this->tbl_get->get_level($level_user+3,$kode_level);
            if ($data_lv){
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $data['lv3_options'] = $option_lv3;
                $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
                $data['set_lv'] = 3;
            } else {
                $data['lv3_options'] = array(''=>'--Pilih Level 3--');
                $data['lv4_options'] = array(''=>'--Pilih Pembangkit--');
            }
        }   

        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();        
        $data['option_komponen_bio'] = $this->tbl_get->option_komponen_bio(0,1);     

        return $data;
    }

    public function get_sum_detail() {
        $message = $this->tbl_get->get_sum_detail();
        echo json_encode($message);
    }

    public function get_sum_volume() {
        $message = $this->tbl_get->get_sum_volume();
        echo json_encode($message);
    }

    public function get_data_edit($id) {
        $message = $this->tbl_get->data_edit($id);
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

    public function get_jns_penerimaan_byid($key=null) {
        $message = $this->tbl_get->options_jenis_penerimaan_byid('--Pilih Jenis Penerimaan--', $key);
        echo json_encode($message);
    }

    public function get_pemasok_by_sloc($key=null) {
        $message = $this->tbl_get->options_pemasok_by_sloc('--Pilih Pemasok--', $key);
        echo json_encode($message);
    }    

	public function load_jenisbbm($idsloc = ''){
		$this->load->model('stock_opname_model');
		$message = $this->stock_opname_model->options_jns_bhn_bkr('--Pilih Jenis BBM--', $idsloc);
		echo json_encode($message);
	}
	
	public function load_komponen($id = ''){
		$message = $this->tbl_get->option_komponen($id);
		echo json_encode($message);
	}

    public function option_komponen_bio($id = ''){
        $message = $this->tbl_get->option_komponen_bio($id);
        echo json_encode($message);
    }

    public function saveKirimanLAMA($statusKirim){
        $pilihan = $this->input->post('pilihan');
        $idPenerimaan = $this->input->post('idPenerimaan');
        $p = ""; //penampung pilihan
        $s = ""; //penamping status
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        $user_name = $this->session->userdata('user_name');
        // for ($i = 0; $i < count($idPenerimaan); $i++) {
        //     if (isset($pilihan[$i])) {
        //         $p = $p . $pilihan[$i] . "#";
        //         if ($statusKirim == 'kirim') {
        //             $s = $s . "1" . "#";
        //         } else if ($statusKirim == 'approve') {
        //             $s = $s . "2" . "#";
        //         } else {
        //             $s = $s . "3" . "#";
        //         }
        //     }
        // }

        $jumlah=1;
        for ($i = 0; $i < count($idPenerimaan); $i++) {
            if (isset($pilihan[$i])) {
                $p = $pilihan[$i];
                if ($statusKirim == 'kirim') {
                    $s = "1";
                } else if ($statusKirim == 'approve') {
                    $s = "2";
                } else {
                    $s = "3";
                }
                
                $simpan = $this->tbl_get->saveDetailPenerimaan($p, $s, $level_user, $kode_level, $user_name, $jumlah);
            }
        }

        // print_r($simpan); die;

        // $idPenerimaan = substr($p, 0, strlen($p) - 1);
        // $statusPenerimaan = substr($s, 0, strlen($s) - 1);
        // $jumlah = count($pilihan);

        // $simpan = $this->tbl_get->saveDetailPenerimaan($idPenerimaan, $statusPenerimaan, $level_user, $kode_level, $user_name, $jumlah);

        if ($simpan[0]->RCDB == "RC00") {
            $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        } else {
            $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        }
        echo json_encode($message, true);
    }

    public function saveKirimanClossingLAMA($statusKirim){
        $pilihan = $this->input->post('pilihan');
        $idPenerimaan = $this->input->post('idPenerimaan');
        $p = ""; //penampung pilihan
        $s = ""; //penamping status
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        $user_name = $this->session->userdata('user_name');
        $sloc = $this->input->post('vSLOC'); 
        for ($i = 0; $i < count($idPenerimaan); $i++) {
            if (isset($pilihan[$i])) {
                $p = $p . $pilihan[$i] . "#";
                if ($statusKirim == 'kirim') {
                    $s = $s . "5" . "#";
                } else if ($statusKirim == 'approve') {
                    $s = $s . "6" . "#";
                } else {
                    $s = "7". "#";
                }
            }
        }

        $idPenerimaan = substr($p, 0, strlen($p) - 1);
        $statusPenerimaan = substr($s, 0, strlen($s) - 1);
        $jumlah = count($pilihan);

        // print_r('p_sloc='.$sloc.' p_id='.$idPenerimaan.' p_lvl_user='.$level_user.' p_status='.$statusPenerimaan.' p_kode_lvl='.$kode_level.' p_by_user='.$user_name.' p_totalcheck='.$jumlah); die;

        $simpan = $this->tbl_get->saveDetailClossing($sloc,$idPenerimaan,$level_user,$statusPenerimaan,$kode_level,$user_name,$jumlah);

        if ($simpan[0]->RCDB == "RC00") {
            $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        } else {
            $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        }
        echo json_encode($message, true);
    }
}