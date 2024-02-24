<?php
/**
 * User: CF
 * Date: 10/20/17
 * Time: 19:10 AM
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Transaksi
 */
class permintaan extends MX_Controller{
    private $_title = 'Mutasi Nominasi / Permintaan';
    private $_limit = 10;
    private $_module = 'data_transaksi/permintaan';
	private $_urlgetfile = "";
	private $_url_movefile = '';


    public function __construct(){
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
		$this->_url_movefile = $this->laccess->url_serverfile()."move";
		$this->_urlgetfile = $this->laccess->url_serverfile()."geturl";
		// $this->load->model('stock_opname_model', 'tbl_get');
        $this->load->model('laporan/persediaan_bbm_model','tbl_get_combo');

        /* Load Global Model */
        $this->load->model('permintaan_model', 'tbl_get');
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
                } else {
                    redirect($this->_module);    
                } 
            } else {
                if ($id==1){  //belum disetujui
                    $data['page_title'] = '<i class="icon-laptop"></i> Persetujuan ' . $this->_title;
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

    public function add($id = ''){
        $page_title = 'Tambah Nominasi / Permintaan';
        $data = $this->get_level_user();
        $data['id'] = $id;

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
		$data["url_getfile"] = $this->_urlgetfile;
		$data['id_dok'] = '';
        // if ($level_user==2){
        //     $data_lv = $this->tbl_get->get_level($level_user+3,$kode_level);
        //     if($data_lv){
        //         $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
        //         $data['lv3_options'] = $option_lv3;
        //         $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1); 
        //     }
        // }    

        if ($id != '') {
            $page_title = 'Edit Nominasi / Permintaan';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();

            if ($data['default']->SLOC){
                $data_lv = $this->tbl_get->get_level('4',$data['default']->SLOC);

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

            $tgl_catat = new DateTime($data['default']->TGL_MTS_NOMINASI);

            // if ($data['default']->STORE_SLOC){
            //     $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data['default']->STORE_SLOC, 1);    
            // }

            //pltd langsung
            if (($level_user==2) && ($data_lv)){
                $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
                $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
            }  

            $data['default']->TGL_MTS_NOMINASI = $tgl_catat->format('d-m-Y');
			$data['id_dok'] = $data['default']->PATH_FILE_NOMINASI; 
            $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        } else {
            $data['option_jenis_bbm'][''] = '--Pilih Jenis BBM--';//$this->tbl_get->options_jenis_bahan_bakar();
        }
		$data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';
        $data['option_pemasok'] = $this->tbl_get->options_pemasok();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit_view($id = ''){
        $data = $this->get_level_user();
        $data['id'] = $id;
		$data["url_getfile"] = $this->_urlgetfile;
		$data['id_dok'] = '';
        if ($id != '') {
            $page_title = 'Detail Nominasi / Permintaan';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();

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

            if ($data['default']->IS_TOLAK){
                $this->tbl_get->update_notif_tolak($id);
                $data['default']->IS_TOLAK = '3';
            }

            $tgl_catat = new DateTime($data['default']->TGL_MTS_NOMINASI);

            $data['default']->TGL_MTS_NOMINASI = $tgl_catat->format('d-m-Y');
			$data['id_dok'] = $data['default']->PATH_FILE_NOMINASI; 
            $data['default']->STATUS_TOLAK = $data['default']->STATUS_APPROVE;
        }

        $data['option_pemasok'] = $this->tbl_get->options_pemasok();
        $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_edit', $data);
    }

    public function tolak_view($id = ''){
        $data = $this->get_level_user();
        $data['id'] = $id;
        $data["url_getfile"] = $this->_urlgetfile;
        $data['id_dok'] = '';
        if ($id != '') {
            $page_title = 'Tolak Detail Nominasi / Permintaan';
            $get_tbl = $this->tbl_get->data_detail($id);
            $data['default'] = $get_tbl->get()->row();

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

            $tgl_catat = new DateTime($data['default']->TGL_MTS_NOMINASI);

            $data['default']->TGL_MTS_NOMINASI = $tgl_catat->format('d-m-Y');
            $data['id_dok'] = $data['default']->PATH_FILE_NOMINASI;
            $data['default']->STATUS_TOLAK = '3'; 
        }

        $data['button_group'] = array(
            anchor(null, '<i class="icon-remove"></i> Proses Tolak', array('id' => 'button-tolak', 'class' => 'red btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back');"))
        );

        $data['option_pemasok'] = $this->tbl_get->options_pemasok();
        $data['option_jenis_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses_tolak');
        $this->load->view($this->_module . '/form_edit', $data);
    }

    public function edit($id){
        $this->add($id);
    }

    public function load($page = 1){
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
            //"STATUS", 1, 1,
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
        $table->id = 'TABLE_PERMINTAAN_REKAP';
        $table->style = "table table-striped table-bordered datatable dataTable";
        $table->align = array('BLTH' => 'center', 'PEMBANGKIT' => 'center', 'NO NOMINASI' => 'center', 'TGL NOMINASI' => 'center', 'NAMA PEMASOK' => 'left', 'NAMA JNS BHN BKR' => 'center', 'VOL NOMINASI (L)' => 'right', 'CREATED BY' => 'center', 'STATUS' => 'center', 'AKSI' => 'center', 'CHECK' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 13;
        $table->header[] = array(
            'BLTH', 1, 1,
            'PEMBANGKIT', 1, 1,
            'NO NOMINASI', 1, 1,
            'TGL NOMINASI', 1, 1,
            'NAMA PEMASOK', 1, 1,
            'NAMA JNS BHN BKR', 1, 1,
            'VOL NOMINASI (L)', 1, 1,
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

    public function proses(){
        $this->form_validation->set_rules('NO_NOMINASI', 'No Nominasi / Permintaan', 'required|max_length[60]');
        $this->form_validation->set_rules('TGL_MTS_NOMINASI', 'Tanggal Nominasi', 'required');
        $this->form_validation->set_rules('ID_PEMASOK', 'Pemasok', 'required');
        $this->form_validation->set_rules('ID_REGIONAL', 'Regional', 'required');
        $this->form_validation->set_rules('COCODE', 'Level l', 'required');
        $this->form_validation->set_rules('PLANT', 'Level 2', 'required');
        $this->form_validation->set_rules('STORE_SLOC', 'Level 3', 'required');
        $this->form_validation->set_rules('SLOC', 'Pembangkit', 'required');
        $this->form_validation->set_rules('ID_JNS_BHN_BKR', 'Jenis Bahan Bakar', 'required');
        $this->form_validation->set_rules('VOLUME_NOMINASI', 'Volume Nominasi', 'required|max_length[16]');
        $this->form_validation->set_rules('JML_KIRIM', 'Jumlah Pengiriman', 'required|is_natural_no_zero');

        $id = $this->input->post('id');
        if ($id == '') {
            if (empty($_FILES['PATH_FILE_NOMINASI']['name'])){
                $this->form_validation->set_rules('PATH_FILE_NOMINASI', 'Upload File', 'required');
            }
        }       

        $x = $this->input->post('JML_KIRIM');

        if ($x>0){
            if ($x>31){
                $x=31;
            }
            for ($i=1; $i<=$x; $i++) {
                $this->form_validation->set_rules('tgl_ke'.$i, 'Tgl Kirim ke '.$i, 'required');
                $this->form_validation->set_rules('vol_ke'.$i, 'Volume Kirim ke '.$i, 'required');
            }
        }

        if ($this->form_validation->run($this)) {
            $data = array();
            $_prod = '';
            $data['TGL_MTS_NOMINASI'] = str_replace('-', '', $this->input->post('TGL_MTS_NOMINASI'));
            $data['ID_PEMASOK'] = $this->input->post('ID_PEMASOK');
            $data['SLOC'] = $this->input->post('SLOC');
            $data['NO_NOMINASI'] = $this->input->post('NO_NOMINASI');
            $data['ID_JNS_BHN_BKR'] = $this->input->post('ID_JNS_BHN_BKR');
            $data['VOLUME_NOMINASI'] =  str_replace(".","",$this->input->post('VOLUME_NOMINASI'));
            $data['VOLUME_NOMINASI'] =  str_replace(",",".",$data['VOLUME_NOMINASI']);
            $data['CREATE_BY'] = $this->session->userdata('user_name');
            $data['PATH_FILE_NOMINASI'] = $this->input->post('PATH_FILE_NOMINASI');
            $data['PATH_NAMA'] = '';

            if (!empty($_FILES['PATH_FILE_NOMINASI']['name'])){
                // $new_name = str_replace(".","",$data['NO_NOMINASI']).'_'.date("YmdHis");
                $new_name = preg_replace("/[^a-zA-Z0-9]/", "", $data['NO_NOMINASI']);
                $new_name = $new_name.'_'.date("YmdHis");
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload/permintaan';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 10; 
				$config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
                // $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
            }
            
	    // $test = $this->input->post('id');
            $data_detail = array();
            for ($i=1; $i<=$x; $i++)
            {
                $vol_ke = $this->input->post('vol_ke'.$i);
                $vol_ke = str_replace(".","",$vol_ke);
                $vol_ke = str_replace(",",".",$vol_ke);
                $data_detail[$i] = array(
                    'NO_NOMINASI' => $this->input->post('NO_NOMINASI'),
                    'TGL_KIRIM' => date('Y-m-d', strtotime($this->input->post('tgl_ke'.$i))),
                    'VOLUME_NOMINASI' => $vol_ke,
		    'SLOC'  => $this->input->post('SLOC'),
		    // 'ID_PERMINTAAN' => $this->input->post('id'.$i),

                );
            }

            if ($id!=null || $id!="") {
                $data['ID_PERMINTAAN']=$id;

                $res='1';
                if (!empty($_FILES['PATH_FILE_NOMINASI']['name'])){

                    $target='assets/upload/permintaan/'.$this->input->post('PATH_FILE_EDIT');

                    if(file_exists($target)){
                        unlink($target);
                    }

                    if (!$this->upload->do_upload('PATH_FILE_NOMINASI')){
                        $err = $this->upload->display_errors('', '');
                        $message = array(false, 'Proses gagal', $err, '');
                        $res='';
                    } else {
                        $res = $this->upload->data();
                        if ($res){
                            $data['PATH_NAMA'] = $res['file_name'];
                        }
                    }
                } else {
                    $data['PATH_NAMA'] = $this->input->post('PATH_FILE_EDIT');
                }

                if ($res){
                    $nama_file = $data['PATH_NAMA'];
                    // $_prod = $this->laccess->post_file_prod('MINTA',$nama_file);

                    // if ($_prod ==''){
                    $simpan_data = $this->tbl_get->save_edit($data);
                    if ($simpan_data[0]->RCDB == 'RC00') {
                        $simpan_data_detail = $this->tbl_get->delete_detail($data['NO_NOMINASI'], $data['SLOC']);
                        if ($x>0){
                            $simpan_data_detail = $this->tbl_get->save_detail($data_detail);    
                        }
                        $message = array(true, 'Proses Update Berhasil', $simpan_data[0]->PESANDB, '#content_table');
                    } else {
                        $message = array(false, 'Proses Update Gagal', $simpan_data[0]->PESANDB, '');
                    }
                    // } 
                    // else {
                    //     $message = array(false, 'Proses Simpan Gagal', $_prod, '');
                    // }
                } else {
                    $message = array(false, 'Proses Simpan Gagal', $res, '');
                }
            } else {

                if (!$this->upload->do_upload('PATH_FILE_NOMINASI')){
                    $err = $this->upload->display_errors('', '');
                    $message = array(false, 'Proses gagal', $err, '');
                } else {
                    $res = $this->upload->data();
                    if ($res){
                        $data['PATH_NAMA'] = $res['file_name'];

                        $nama_file = $data['PATH_NAMA'];
                        // $_prod = $this->laccess->post_file_prod('MINTA',$nama_file);

                        // if ($_prod ==''){
                        $simpan_data = $this->tbl_get->save($data);
                        if ($simpan_data[0]->RCDB == 'RC00') {
                            if ($x>0){
                                $simpan_data_detail = $this->tbl_get->save_detail($data_detail);    
                            }
                            $message = array(true, 'Proses Simpan Berhasil', $simpan_data[0]->PESANDB, '#content_table');
                        } else {
                            $message = array(false, 'Proses Simpan Gagal', $simpan_data[0]->PESANDB, '');
                        }
                        // } 
                        // else {
                        //     $message = array(false, 'Proses Simpan Gagal', $_prod, '');
                        // }
                    } else {
                        $message = array(false, 'Proses Simpan Gagal', $res, '');
                    }
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
        $idPermintaan = $this->input->post('idPermintaan');
        $p = ""; //penampung pilihan
        $s = ""; //penamping status
        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');
        $user_name = $this->session->userdata('user_name');
        for ($i = 0; $i < count($idPermintaan); $i++) {
            if (isset($pilihan[$i])) {
                $p = $p . $pilihan[$i] . "#";
                if ($statusKirim == 'kirim') {
                    $s = $s . "1" . "#";
                } else if ($statusKirim == 'approve') {
                    $s = $s . "2" . "#";
                } else {
                    $s = $s . "3" . "#";
                }
            }
        }

        $idPermintaan = substr($p, 0, strlen($p) - 1);
        $statusPermintaan = substr($s, 0, strlen($s) - 1);
        $jumlah = count($pilihan);
        $ket = '';
        // echo "call SP_NOMINASI('".$idPermintaan."','".$statusPermintaan."','".$level_user."','".$kode_level."','".$user_name."',".$jumlah.")";
        // echo "<br/>";
        // die;
        $simpan = $this->tbl_get->saveDetailPenerimaan($idPermintaan, $statusPermintaan, $level_user, $kode_level, $user_name, $jumlah, $ket);

        if ($simpan[0]->RCDB == "RC00") {
            $message = array(true, 'Proses Berhasil', $simpan[0]->PESANDB, '#content_table');
        } else {
            $message = array(false, 'Proses Gagal', $simpan[0]->PESANDB, '');
        }
        echo json_encode($message, true);
    }

    public function get_level_user(){
        $data['options_order'] = $this->tbl_get->options_order();
        $data['options_asc'] = $this->tbl_get->options_asc();
        $data['options_order_d'] = $this->tbl_get->options_order_d();
        $data['options_asc_d'] = $this->tbl_get->options_asc();
        $data['status_options'] = $this->tbl_get->options_status();    
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

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

    public function get_sum_detail() {
        $message = $this->tbl_get->get_sum_detail();
        echo json_encode($message);
    }

    public function get_detail_kirim() {
        $key = $this->input->post('idx');
	$sloc = $this->input->post('sloc');
        $message = $this->tbl_get->get_detail_kirim($key, $sloc);
        echo json_encode($message);
    }

	public function load_jenisbbm($idsloc = ''){
		$this->load->model('stock_opname_model');
		$message = $this->stock_opname_model->options_jns_bhn_bkr('--Pilih Jenis BBM--', $idsloc);
		echo json_encode($message);
	}
}