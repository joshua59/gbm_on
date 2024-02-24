<?php

/**
 * @module TRANSAKSI
 * @author  CF
 * @created at 11 FEBRUARI 2019
 * @modified at 11 FEBRUARI 2019
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module dashboard
 */
class rollback extends MX_Controller {
    private $_title = 'ROLLBACK TRANSAKSI';
    private $_limit = 10;
    private $_module = 'data_transaksi/rollback';


    public function __construct(){
        parent::__construct();

        // Protection
        hprotection::login();
        // $this->laccess->check();
        // $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('rollback_model', 'tbl_get');
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
        // if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form(this.id)', 'data-source' => base_url($this->_module . '/add')))
            );
        // }

        $data['page_notif'] = false;
        $data['page_notif_status'] = '0';
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        $data['data_sources_rekap'] = base_url($this->_module . '/load_rekap');
        echo Modules::run("template/admin", $data);
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

    public function edit($id){
        $this->add($id);
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

    public function proses() {
        $this->form_validation->set_rules('SLOC_KIRIM', 'Pembangkit', 'required');
        $this->form_validation->set_rules('JNS_TRX', 'Jenis Transaksi', 'required');
        $this->form_validation->set_rules('NO_TRX', 'No Transaksi', 'trim|required|max_length[60]');
        $this->form_validation->set_rules('TGL_PENGAKUAN', 'Tanggal', 'required');
        $this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[200]');

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            // $data = array();
            // $data['ID_PEMASOK'] = $this->input->post('ID_PEMASOK');
            // $data['NAMA_DEPO'] = $this->input->post('NAMA_DEPO');
            // $data['KD_DEPO'] = $this->input->post('KD_DEPO');
            // $data['LAT_DEPO'] = $this->input->post('LAT_DEPO');
            // $data['LOT_DEPO'] = $this->input->post('LOT_DEPO');
            // $data['ALAMAT_DEPO'] = $this->input->post('ALAMAT_DEPO');
            // $data['ISAKTIF_DEPO'] = $this->input->post('ISAKTIF_DEPO');
            // $data['CD_BY_DEPO'] = $this->session->userdata('user_name');
            
            // $kd_depo=$data['KD_DEPO']; 
            // if ($id == '') {
            //     if ($this->tbl_get->check_depo($kd_depo) == FALSE)
            //     {
            //         $message = array(false, 'Proses GAGAL', ' Kode Depo '.$kd_depo.' Sudah Ada.', '');
            //     }
            //     else{
            //         $data['CD_DEPO'] = date("Y/m/d H:i:s");           
            //         if ($this->tbl_get->save_as_new($data)) {
            //             $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
            //         }
            //     }
                
            // }else{
            //     $data_db = $this->tbl_get->data($id);
            //     $hasil=$data_db->get()->row();
            //     $kd=$hasil->KD_DEPO;
            //     $data['UD_DEPO'] = date("Y/m/d H:i:s");
            //     if($kd==$kd_depo){
            //         if ($this->tbl_get->save($data, $id)) {
            //             $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
            //         }
            //     }else{
            //         if ($this->tbl_get->check_depo($kd_depo) == FALSE)
            //         {
            //             $message = array(false, 'Proses GAGAL', ' Kode Depo '.$kd_depo.' Sudah Ada.', '');
            //         }
            //         else{           
            //             if ($this->tbl_get->save($data, $id)) {
            //                 $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
            //             }
            //         }
            //     }
                    
            // }

        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
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

        $data['options_lv4_cari'] = $this->tbl_get->options_lv4('--Pencarian Pembangkit--', 'all', 1);        
        $data['options_jns_trx'] = array('' => '--Pilih Jenis Transaksi--',
                                  'PENERIMAAN' => 'PENERIMAAN',
                                  'PEMAKAIAN' => 'PEMAKAIAN',
                                  'STOCKOPNAME' => 'STOCKOPNAME' );                         

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

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
