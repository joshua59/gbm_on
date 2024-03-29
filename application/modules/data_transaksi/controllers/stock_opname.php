<?php

/**
 * @module STOCK OPNAME
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module STOCK OPNAME
 */
class stock_opname extends MX_Controller {
    private $_title = 'Stock Opname';
    private $_limit = 10;
    private $_module = 'data_transaksi/stock_opname';
	private $_urlgetfile = "";
	private $_url_movefile = '';


    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
		$this->_url_movefile = $this->laccess->url_serverfile()."move";
		$this->_urlgetfile = $this->laccess->url_serverfile()."geturl";

        /* Load Global Model */
        $this->load->model('stock_opname_model', 'tbl_get');
        $this->load->model('laporan/persediaan_bbm_model','tbl_get_combo');
        $this->load->model('pemakaian_model','tbl_get_pemakaian');
        // $this->laod->model('penerimaan_model','tbl_get_penerimaan');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");
        $this->asset->set_plugin(array('format_number'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('file-upload'));
        
        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data = $this->get_level_user(); 
        $data['parent_options_jns'] = $this->tbl_get->options_jns_bhn_bkr_main();
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();  
        $data['opsi_tahun'] = $this->tbl_get->options_tahun(); 

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
        echo Modules::run("template/admin", $data);
    }

    public function notif($id=0){
        if (($this->session->userdata('level_user') >= 2) && 
            (($this->laccess->otoritas('add')) || ($this->laccess->otoritas('approve'))) ){
            // Load Modules
            $this->laccess->update_log();
            $this->load->module("template/asset");
            $this->asset->set_plugin(array('format_number'));
            $this->asset->set_plugin(array('jquery'));
            $this->asset->set_plugin(array('file-upload'));
            
            // Memanggil plugin JS Crud
            $this->asset->set_plugin(array('crud'));

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
                      

            $data['parent_options_jns'] = $this->tbl_get->options_jns_bhn_bkr_main();
            $data['opsi_bulan'] = $this->tbl_get->options_bulan();  
            $data['opsi_tahun'] = $this->tbl_get->options_tahun(); 

            $data['page_notif'] = true;
            $data['page_notif_status'] = $id;
            $data['page_content'] = $this->_module . '/main';
            $data['data_sources'] = base_url($this->_module . '/load');
            echo Modules::run("template/admin", $data);
        } else {
            redirect('data_transaksi/stock_opname');
        }
    }

    public function update_notif_tolak() {
        $message = $this->tbl_get->update_notif_tolak();
        echo json_encode($message);
    }    

    public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data = $this->get_level_user(1); 
        $data['id'] = $id;
        $data['id_dok'] = '';
        $data["url_getfile"] = $this->_urlgetfile;

        // $level_user = $this->session->userdata('level_user');
        // $kode_level = $this->session->userdata('kode_level');
        // if ($level_user==2){
        //     $data_lv = $this->tbl_get->get_level($level_user+3,$kode_level);
        //     if ($data_lv){
        //         $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
        //         $data['lv3_options'] = $option_lv3;
        //         $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', $data_lv[0]->STORE_SLOC, 1);
        //     }
        // }  
        $data['urljnsbbm'] = base_url($this->_module) .'/load_jenisbbm';
        if ($id != '') {
            $page_title = 'Edit Stock Opname';
            $get_tbl = $this->tbl_get->dataToUpdate($id);
            $data['default'] = $get_tbl->get()->row();
            $level_user = $this->session->userdata('level_user');
            if($level_user==0){
                $data['lv1_options'] = $this->tbl_get->options_lv1_view();;
                $data['lv2_options'] = $this->tbl_get->options_lv2_view();
                $data['lv3_options'] = $this->tbl_get->options_lv3_view();
                $data['lv4_options'] = $this->tbl_get->options_lv4_view();
            }
            $data['id_dok'] = $data['default']->PATH_STOCKOPNAME; 
        }
        
        $data['parent_options_jns'] = $this->tbl_get->options_jns_bhn_bkr();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function loadApprove($id = '') {
        $page_title = 'Approve '.$this->_title;
        $data = $this->get_level_user(); 
        $data['id'] = $id;
		$data["url_getfile"] = $this->_urlgetfile;
        $get_tbl = $this->tbl_get->dataToUpdate($id);
        $data['default'] = $get_tbl->get()->row();
        $data['id_dok'] = $data['default']->PATH_STOCKOPNAME; 
        $data['parent_options_jns'] = $this->tbl_get->options_jns_bhn_bkr();
        $data['lv4_options'] = $this->tbl_get->options_lv4_view();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/prosesApprove');
        $this->load->view($this->_module . '/form_approve', $data);
    }

    public function loadApproveClosing($id = '') {
        $page_title = 'Approve Closing '.$this->_title;
        $data = $this->get_level_user(); 
        $data['id'] = $id;
        $data["url_getfile"] = $this->_urlgetfile;
        $get_tbl = $this->tbl_get->dataToUpdate($id);
        $data['default'] = $get_tbl->get()->row();
        $data['id_dok'] = $data['default']->PATH_STOCKOPNAME; 
        $data['parent_options_jns'] = $this->tbl_get->options_jns_bhn_bkr();
        $data['lv4_options'] = $this->tbl_get->options_lv4_view();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/prosesApproveClosing');
        $this->load->view($this->_module . '/form_approve', $data);
    }    

    public function loadView($id = '') {
        $page_title = 'View '.$this->_title;
        $data = $this->get_level_user(); 

        $data['id'] = $id;
		$data["url_getfile"] = $this->_urlgetfile;
        $get_tbl = $this->tbl_get->dataToUpdate($id);
        $data['default'] = $get_tbl->get()->row();
        $data['id_dok'] = $data['default']->PATH_STOCKOPNAME; 
        $data['parent_options_jns'] = $this->tbl_get->options_jns_bhn_bkr();

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

        if ($data['default']->IS_TOLAK){
            $this->tbl_get->update_notif_tolak($id);
            $data['default']->IS_TOLAK = '3';
        }         
        
        // $data['lv4_options'] = $this->tbl_get->options_lv4_view();
        $data['default']->STATUS_TOLAK = $data['default']->STATUS_APPROVE_STOCKOPNAME;
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/prosesApprove');
        $this->load->view($this->_module . '/form_view', $data);
    }

    public function prosesApprove(){
       $cek = $this->input->post('setuju');
       $id = $this->input->post('id');

       if($cek==2){
            $this->approveAction($id);
       }else{
            $this->form_validation->set_rules('KET_BATAL', 'Keterangan Tolak', 'trim|required|max_length[100]');
            
            if ($this->form_validation->run($this)) {               
                $this->tolakAction($id);
            }else {
                $message = array(false, 'Proses gagal', validation_errors(), '');
                echo json_encode($message, true);
            }
       }     
    }

    public function prosesApproveClosing(){
       $cek = $this->input->post('setuju');
       $id = $this->input->post('id');

       if($cek==2){
            $this->approveActionClosing($id);
       }else{
            $this->form_validation->set_rules('KET_BATAL', 'Keterangan Tolak', 'trim|required|max_length[100]');
            
            if ($this->form_validation->run($this)) {               
                $this->tolakActionClosing($id);
            }else {
                $message = array(false, 'Proses gagal', validation_errors(), '');
                echo json_encode($message, true);
            }
       }     
    }    
    
    public function sendAction($id=''){
        if($id==''){
            $message = array(false, 'Proses gagal', 'Proses kirim data gagal.', '');
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $data['id'] = $id;
            $data = $this->tbl_get->dataToUpdate($id);
            $hasil=$data->get()->row();
            $ID_STOCKOPNAME=$hasil->ID_STOCKOPNAME;
            $SLOC=$hasil->SLOC;
            $TGL_PENGAKUAN=$hasil->TGL_PENGAKUAN;
            $ID_JNS_BHN_BKR=$hasil->ID_JNS_BHN_BKR;
            $LEVEL_USER = $this->session->userdata('level_user');
            $USER = $this->session->userdata('user_name');
            $STATUS="1";
            $ket='';
            $JUMLAH=1;

            $simpan_data =$this->tbl_get->callProsedureStockOpname($ID_STOCKOPNAME, $SLOC, $ID_JNS_BHN_BKR, $TGL_PENGAKUAN, $LEVEL_USER, $STATUS, $USER, $ket);
            
            if ($simpan_data[0]->RCDB=='RC00') {
                if ($LEVEL_USER == 2 || $LEVEL_USER == 1){
                    $tanggal_cek = date('Y-m-d', strtotime('+1 day', strtotime($TGL_PENGAKUAN)));
                    // $data_exist = 1;

                    // while($data_exist == 1) {
                        // Query untuk menghitung jumlah data di tabel REKAP_MUTASI_PERSEDIAAN berdasarkan tanggal
                        $query = "SELECT COUNT(*) AS count FROM REKAP_MUTASI_PERSEDIAAN WHERE TGL_MUTASI_PERSEDIAAN = '$tanggal_cek'";
                        $result = $this->db->query($query)->row();
                        
                        // Jika jumlah data = 0, maka set $data_exist = false untuk menghentikan looping
                        if($result->count == 0) {
                            $data_exist = 0;
                        } else {
                            // Query untuk mendapatkan data terakhir dari tabel MUTASI_PEMAKAIAN_APPROVE
                            $querymutasipemakaian = "SELECT * FROM MUTASI_PEMAKAIAN_APPROVE WHERE TGL_MUTASI_PENGAKUAN = '$tanggal_cek' AND SLOC = '$SLOC' AND ID_JNS_BHN_BKR = '$ID_JNS_BHN_BKR' AND STATUS_MUTASI_PEMAKAIAN = 2 ORDER BY ID_PEMAKAIAN DESC LIMIT 1";
                            $result_mutasi_pemakaian = $this->db->query($querymutasipemakaian)->row();

                            // $simpan_pemakaian = $this->tbl_get_pemakaian->saveDetailPenerimaan(querymutasipemakaian.ID_PEMAKAIAN, querymutasipemakaian.STATUS_MUTASI_PEMAKAIAN, $LEVEL_USER, $USER, $ket);
                            $simpan_pemakaian = $this->tbl_get_pemakaian->saveDetailPenerimaan($result_mutasi_pemakaian->ID_PEMAKAIAN, $result_mutasi_pemakaian->STATUS_MUTASI_PEMAKAIAN, $LEVEL_USER, $USER, $JUMLAH, $ket);

                            // Jika masih ada data, tambahkan 1 hari ke tanggal cek untuk looping berikutnya
                            $tanggal_cek = date('Y-m-d', strtotime('+1 day', strtotime($TGL_PENGAKUAN)));
                        }
                    // }
                    if ($simpan_pemakaian[0]->RCDB == "RC00") {
                    $message = array(true, 'Proses Nerhasil', $simpan_pemakaian[0]->PESANDB, '');
                    } else {
                        $message = array(false, 'Proses Nagal', $simpan_pemakaian[0]->PESANDB, '');
                    }
                } else {
                    $message = array(true, 'Proses Berhasil', 'Proses kirim data berhasil.', '#content_table');
                }
            }else{
                $message = array(false, 'Proses gagal', $simpan_data[0]->PESANDB, '');
            }
        }
        echo json_encode($message);
    }

    public function sendActionClosing($id=''){        
        if($id==''){
            $message = array(false, 'Proses gagal', 'Proses kirim data gagal.', '');
        }else{
            $data['id'] = $id;
            $data = $this->tbl_get->dataToUpdate($id);
            $hasil=$data->get()->row();
            $ID_STOCKOPNAME=$hasil->ID_STOCKOPNAME;
            $SLOC=$hasil->SLOC;
            $TGL_PENGAKUAN=$hasil->TGL_PENGAKUAN;
            $ID_JNS_BHN_BKR=$hasil->ID_JNS_BHN_BKR;
            $LEVEL_USER = $this->session->userdata('level_user');
            $KODE_LEVEL = $this->session->userdata('kode_level');
            $USER = $this->session->userdata('user_name');            
            $STATUS="5";
            $ket='';

            $simpan_data = $this->tbl_get->saveDetailClossing($SLOC,$ID_STOCKOPNAME,$LEVEL_USER,$STATUS,$KODE_LEVEL,$USER,1);
            if ($simpan_data[0]->RCDB=='RC00') {
                $message = array(true, 'Proses Berhasil', 'Proses kirim data berhasil.', '#content_table');
            }else{
                $message = array(false, 'Proses gagal', $simpan_data[0]->PESANDB, '');
            }
        }
        echo json_encode($message);
    }    

    public function approveAction($id){
        if($id==''){
            $message = array(false, 'Proses gagal', 'Proses Appove data gagal.', '');
        }else{
            date_default_timezone_set('Asia/Jakarta');
            $data['id'] = $id;
            $data = $this->tbl_get->dataToUpdate($id);
            $hasil=$data->get()->row();
            $ID_STOCKOPNAME=$hasil->ID_STOCKOPNAME;
            $SLOC=$hasil->SLOC;
            $TGL_PENGAKUAN=$hasil->TGL_PENGAKUAN;
            $ID_JNS_BHN_BKR=$hasil->ID_JNS_BHN_BKR;
            $LEVEL_USER = $this->session->userdata('level_user');
            $USER = $this->session->userdata('user_name');
            $STATUS="2";
            $ket='';
            $JUMLAH=1;

            $simpan_data =$this->tbl_get->callProsedureStockOpname($ID_STOCKOPNAME, $SLOC, $ID_JNS_BHN_BKR, $TGL_PENGAKUAN, $LEVEL_USER, $STATUS, $USER, $ket);

            if ($simpan_data[0]->RCDB == 'RC00') {
                $tanggal_cek = date('Y-m-d', strtotime('+1 day', strtotime($TGL_PENGAKUAN)));
                $data_exist = true;
            
                while ($data_exist) {
                    // Query untuk menghitung jumlah data di tabel REKAP_MUTASI_PERSEDIAAN berdasarkan tanggal
                    $query = "SELECT COUNT(*) AS count FROM REKAP_MUTASI_PERSEDIAAN WHERE TGL_MUTASI_PERSEDIAAN = ?";
                    $result = $this->db->query($query, array($tanggal_cek))->row();
            
                    // Jika jumlah data tidak sama dengan 0, maka lanjutkan perulangan
                    if ($result->count != 0) {
                        // Query untuk mendapatkan data terakhir dari tabel MUTASI_PEMAKAIAN_APPROVE
                        $querymutasipemakaian = "SELECT * FROM MUTASI_PEMAKAIAN_APPROVE WHERE TGL_MUTASI_PENGAKUAN = ? AND SLOC = ? AND ID_JNS_BHN_BKR = ? AND STATUS_MUTASI_PEMAKAIAN = 2 ORDER BY ID_PEMAKAIAN DESC LIMIT 1";
                        $result_mutasi_pemakaian = $this->db->query($querymutasipemakaian, array($tanggal_cek, $SLOC, $ID_JNS_BHN_BKR))->row();
            
                        // Lakukan operasi yang diperlukan dengan data yang diperoleh
                        $simpan_pemakaian = $this->tbl_get_pemakaian->saveDetailPenerimaan($result_mutasi_pemakaian->ID_PEMAKAIAN, $result_mutasi_pemakaian->STATUS_MUTASI_PEMAKAIAN, $LEVEL_USER, $USER, $JUMLAH, $ket);
            
                        // Jika berhasil, lanjutkan ke langkah berikutnya
                        if ($simpan_pemakaian[0]->RCDB == "RC00") {
                            // Update tanggal cek untuk iterasi berikutnya
                            $tanggal_cek = date('Y-m-d', strtotime('+1 day', strtotime($tanggal_cek)));
                        } else {
                            // Jika gagal, keluar dari perulangan
                            $data_exist = false;
                        }
                    } else {
                        // Jika jumlah data = 0, keluar dari perulangan
                        $data_exist = false;
                    }
                }
            
                // Set pesan berdasarkan hasil operasi
                if ($simpan_pemakaian[0]->RCDB == "RC00") {
                    $message = array(true, 'Proses Berhasil', $simpan_pemakaian[0]->PESANDB, '');
                } else {
                    $message = array(false, 'Proses Gagal', $simpan_pemakaian[0]->PESANDB, '');
                }
            } else {
                $message = array(false, 'Proses Gagal', $simpan_data[0]->PESANDB, '');
            }
            
        }
        echo json_encode($message);
    }

    public function approveActionClosing($id=''){        
        if($id==''){
            $message = array(false, 'Proses gagal', 'Proses Appove Closing data gagal.', '');
        }else{
            $data['id'] = $id;
            $data = $this->tbl_get->dataToUpdate($id);
            $hasil=$data->get()->row();
            $ID_STOCKOPNAME=$hasil->ID_STOCKOPNAME;
            $SLOC=$hasil->SLOC;
            $TGL_PENGAKUAN=$hasil->TGL_PENGAKUAN;
            $ID_JNS_BHN_BKR=$hasil->ID_JNS_BHN_BKR;
            $LEVEL_USER = $this->session->userdata('level_user');
            $KODE_LEVEL = $this->session->userdata('kode_level');
            $USER = $this->session->userdata('user_name');            
            $STATUS="6";
            $ket='';

            $simpan_data = $this->tbl_get->saveDetailClossing($SLOC,$ID_STOCKOPNAME,$LEVEL_USER,$STATUS,$KODE_LEVEL,$USER,1);
            if ($simpan_data[0]->RCDB=='RC00') {
                $message = array(true, 'Proses Berhasil', $simpan_data[0]->PESANDB, '#content_table');
            }else{
                $message = array(false, 'Proses gagal', $simpan_data[0]->PESANDB, '');            
            }
        }
        echo json_encode($message);
    }     

    public function tolakAction($id){
        if($id==''){
            $message = array(false, 'Proses gagal', 'Proses tolak data gagal.', '');
        }else{
            $data['id'] = $id;
            $data = $this->tbl_get->dataToUpdate($id);
            $hasil=$data->get()->row();
            $ID_STOCKOPNAME=$hasil->ID_STOCKOPNAME;
            $SLOC=$hasil->SLOC;
            $TGL_PENGAKUAN=$hasil->TGL_PENGAKUAN;
            $ID_JNS_BHN_BKR=$hasil->ID_JNS_BHN_BKR;
            $LEVEL_USER = $this->session->userdata('level_user');
            $USER = $this->session->userdata('user_name');
            $STATUS="3";
            $ket = $this->input->post("KET_BATAL");

            $simpan_data =$this->tbl_get->callProsedureStockOpname($ID_STOCKOPNAME, $SLOC, $ID_JNS_BHN_BKR, $TGL_PENGAKUAN, $LEVEL_USER, $STATUS, $USER, $ket);
            if ($simpan_data[0]->RCDB=='RC00') {
                $message = array(true, 'Proses Berhasil', 'Proses tolak data berhasil.', '#content_table');
            }else{
                $message = array(false, 'Proses gagal', $simpan_data[0]->PESANDB, '');
            }
        }
        echo json_encode($message);
    }

    public function tolakActionClosing($id=''){        
        if($id==''){
            $message = array(false, 'Proses gagal', 'Proses tolak closing data gagal.', '');
        }else{
            $data['id'] = $id;
            $data = $this->tbl_get->dataToUpdate($id);
            $hasil=$data->get()->row();
            $ID_STOCKOPNAME=$hasil->ID_STOCKOPNAME;
            $SLOC=$hasil->SLOC;
            $TGL_PENGAKUAN=$hasil->TGL_PENGAKUAN;
            $ID_JNS_BHN_BKR=$hasil->ID_JNS_BHN_BKR;
            $LEVEL_USER = $this->session->userdata('level_user');
            $KODE_LEVEL = $this->session->userdata('kode_level');
            $USER = $this->session->userdata('user_name');            
            $STATUS="7";
            $ket='';

            $simpan_data = $this->tbl_get->saveDetailClossing($SLOC,$ID_STOCKOPNAME,$LEVEL_USER,$STATUS,$KODE_LEVEL,$USER,1);
            if ($simpan_data[0]->RCDB=='RC00') {
                $message = array(true, 'Proses Berhasil', $simpan_data[0]->PESANDB, '#content_table');
            }else{
                $message = array(false, 'Proses gagal', $simpan_data[0]->PESANDB, '');            
            }
        }
        echo json_encode($message);
    }      

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_STOCKOPNAME';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('ID_STOCKOPNAME' => 'center', 'NO_STOCKOPNAME' => 'center', 'TGL_PENGAKUAN' => 'center', 'NAMA_JNS_BHN_BKR' => 'center', 'LEVEL4' => 'center', 'VOLUME_STOCKOPNAME' => 'right', 'CD_BY_STOKOPNAME' => 'center' , 'CD_DATE_STOKOPNAME' => 'center', 'STATUS_APPROVE_STOCKOPNAME' => 'center' , 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 10;
        $table->header[] = array(
            "No", 1, 1,
            "No Stok Opname", 1, 1,
            "Tgl Stok Opname", 1, 1,
            "Jenis Bahan Bakar", 1, 1,
            "Nama Pembangkit", 1, 1,
            "Total Volume (L)", 1, 1,
            "Created By", 1, 1,
            "Created Time", 1, 1,
            "Status", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('NO_STOCKOPNAME', 'NO STOCKOPNAME', 'trim|required|max_length[30]');
        $this->form_validation->set_rules('ID_JNS_BHN_BKR', 'JENIS BAHAN BAKAR', 'required');
        $this->form_validation->set_rules('TGL_BA_STOCKOPNAME', 'TANGGAL BA STOCKOPNAME', 'required');
        $this->form_validation->set_rules('TGL_PENGAKUAN', 'TANGGAL PENGAKUAN STOCKOPNAME', 'required');
        $this->form_validation->set_rules('SLOC', 'PEMBANGKIT', 'required');
        $this->form_validation->set_rules('VOLUME_STOCKOPNAME', 'VOLUME STOCKOPNAME', 'required');

        $id = $this->input->post('id');

        // if ($id == '') {
        //     if (empty($_FILES['FILE_UPLOAD']['name'])){
        //         $this->form_validation->set_rules('FILE_UPLOAD', 'Upload Dokumen', 'required');
        //     }
        // }

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');

            $data = array();
            $_prod = '';
            $data['NO_STOCKOPNAME'] = $this->input->post('NO_STOCKOPNAME');
            $data['ID_JNS_BHN_BKR'] = $this->input->post('ID_JNS_BHN_BKR');
            $data['TGL_BA_STOCKOPNAME'] = $this->input->post('TGL_BA_STOCKOPNAME');
            $data['TGL_PENGAKUAN'] = $this->input->post('TGL_PENGAKUAN');
            $data['SLOC'] = $this->input->post('SLOC');
            $data['VOLUME_STOCKOPNAME'] = str_replace(".","",$this->input->post('VOLUME_STOCKOPNAME'));
            $data['VOLUME_STOCKOPNAME'] = str_replace(",",".",$data['VOLUME_STOCKOPNAME']);            

            if ($id == '') {
                $data['STATUS_APPROVE_STOCKOPNAME'] = $this->input->post('0');
                $new_name = preg_replace("/[^a-zA-Z0-9]/", "", $data['NO_STOCKOPNAME']);
                $new_name = $new_name.'_'.date("YmdHis");

                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload/stockopname/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 4; 
                $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
    
                $this->load->library('upload', $config);
                // if (!$this->upload->do_upload('FILE_UPLOAD')){
                //     $err = $this->upload->display_errors('', '');
                //     $message = array(false, 'Proses gagal', $err, '');
                // } 
                // else {
                    $res = $this->upload->data();
                    if ($res){
                        $nama_file= $res['file_name'];

                        // $_prod = $this->laccess->post_file_prod('SO',$nama_file);
                        // if ($_prod ==''){
                        $data['PATH_STOCKOPNAME'] = $nama_file;
                        $data['CD_BY_STOKOPNAME'] = $this->session->userdata('user_name');
                        $data['CD_DATE_STOKOPNAME'] = date('Y-m-d');
                        if ($this->tbl_get->save_as_new($data)) {
                                $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                        }
                        // } 
                        // else {
                        //     $message = array(false, 'Proses Simpan Gagal', $_prod, '');
                        // }
                    } else {
                        $message = array(false, 'Proses Simpan Gagal', $res, '');
                    }
                // }
            } 
            else {
                if (empty($_FILES['FILE_UPLOAD']['name'])){
                    $data['UD_BY_STOKOPNAME'] = $this->session->userdata('user_name');
                    $data['UD_DATE_STOKOPNAME'] = date('Y-m-d');
                    if ($this->tbl_get->save($data, $id)) {
                        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                    }
                }
                else{
                    $dataa = $this->tbl_get->dataToUpdate($id);
                    $hasil=$dataa->get()->row();
                    $file_name=$hasil->PATH_STOCKOPNAME;
                    $target='assets/upload_stock_opname/'.$file_name;
                                    
                    if ($file_name == '') {
                        if (empty($_FILES['FILE_UPLOAD']['name'])){
                            $this->form_validation->set_rules('FILE_UPLOAD', 'Upload Dokumen', 'required');
                            }
                    }
                            
                    if($_FILES['FILE_UPLOAD']['name']!= $file_name || $_FILES['FILE_UPLOAD']['size']!= filesize($target)){
                        if(file_exists($target)){
                            unlink($target);
                            }
                    }
                            
                    $new_name = preg_replace("/[^a-zA-Z0-9]/", "", $data['NO_STOCKOPNAME']);
                    $new_name = $new_name.'_'.date("YmdHis");
                    $config['file_name'] = $new_name;
                    $config['upload_path'] = 'assets/upload/stockopname/';
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                    $config['max_size'] = 1024 * 4; 
                    $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
                
                    $this->load->library('upload', $config);
                    // if (!$this->upload->do_upload('FILE_UPLOAD')){
                    //     $err = $this->upload->display_errors('', '');
                    //     $message = array(false, 'Proses gagal', $err, '');
                    // }
                    // else{
                        $res = $this->upload->data();
                        if ($res){
                            $nama_file= $res['file_name'];

                            // $_prod = $this->laccess->post_file_prod('SO',$nama_file);
                            // if ($_prod ==''){
                            $data['PATH_STOCKOPNAME'] = $nama_file;
                            $data['UD_BY_STOKOPNAME'] = $this->session->userdata('user_name');
                            $data['UD_DATE_STOKOPNAME'] = date('Y-m-d');
                            if ($this->tbl_get->save($data, $id)) {
                                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                            }
                            // } 
                            // else {
                            //     $message = array(false, 'Proses Simpan Gagal', $_prod, '');
                            // }

                        } else {
                            $message = array(false, 'Proses Simpan Gagal', $res, '');
                        }
                    // }
                }
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
        $message = $this->tbl_get->options_lv4('--Pilih Level 4--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_bbm($key=null) {
        $message = $this->tbl_get->options_bhn_bkr('--Pilih Jenis BBM--', $key, 0);
        echo json_encode($message);
    }

    public function get_level_user($id_add=''){
        $data['status_options'] = $this->tbl_get->options_status();
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1); 
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1); 
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);  
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', '-', 1);  
        // $data['parent_options_jns'] = $this->tbl_get->options_bhn_bkr('--Jenis Bahan Bakar--', '-', 1);
        // print_r($data['parent_options_jns']); die;

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user,$kode_level);

        if ($level_user==4){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $option_lv4[$data_lv[0]->SLOC] = $data_lv[0]->LEVEL4;
            // $option_bhn_bkr[$data_lv[0]->ID_JNS_BHN_BKR] = $data_lv[0]->NAMA_JNS_BHN_BKR;
            // print_r($option_bhn_bkr[$data_lv[0]->ID_JNS_BHN_BKR]); die;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $option_lv4;
           
        } else if ($level_user==3){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Level 4--', $data_lv[0]->STORE_SLOC, 1); 
        } else if ($level_user==2){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);  
           
        } else if ($level_user==1){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user==0){
            if ($kode_level==00){
                $data['reg_options'] = $this->tbl_get->options_reg(); 
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        //pltd langsung
        if (($level_user==2) && ($id_add)){
            $data_lv = $this->tbl_get->get_level($level_user+3,$kode_level);
            if ($data_lv){
                $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
                $data['lv3_options'] = $option_lv3;
                $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
            } else {
                $data['lv3_options'] = array(''=>'--Pilih Level 3--');
                $data['lv4_options'] = array(''=>'--Pilih Pembangkit--');
            }
        }  

        return $data;
    }

    public function get_sum_detail() {
        $message = $this->tbl_get->get_sum_detail();
        echo json_encode($message);
    }
  
	public function load_jenisbbm($idsloc = ''){
		$this->load->model('stock_opname_model');
		$message = $this->stock_opname_model->options_jns_bhn_bkr('--Pilih Jenis BBM--', $idsloc);
		echo json_encode($message);
	}
}

/* End of file stockopname.php */

