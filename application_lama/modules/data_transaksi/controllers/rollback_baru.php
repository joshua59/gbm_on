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
class rollback_baru extends MX_Controller {
    private $_title = 'ROLLBACK TRANSAKSI';
    private $_limit = 10;
    private $_module = 'data_transaksi/rollback_baru';

    public function __construct(){
        parent::__construct();

        // Protection
        hprotection::login();
        // $this->laccess->check();
        // $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('rollback_baru_model', 'tbl_get');
    }

    public function index(){
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number','maxlength'));
        // Memanggil Level User

        $data['button_group'] = array();
        // if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'add()'))
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

    public function add($id = ''){
        $page_title = 'Tambah Rollback';
        $form = '/form';
        $data['form_action'] = $this->_module.'/proses';
        $data['options_pembangkit'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', 'all', 1);
        $data['jenis_transaksi'] = array('' => '--Pilih Jenis Transaksi--','1' => 'Stock Opname','2' => 'Pemakaian' ,'3' => 'Nominasi' ,'4' => 'Penerimaan');
        $data['jenis_rollback'] = array('' => '--Pilih Jenis Rollback--','1' => 'Rollback Revisi','2' => 'Rollback Hapus');
        $this->load->view($this->_module . $form,$data);
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
        $table->align = array('NO' => 'center', 'PEMBANGKIT' => 'center', 'NOMOR TRANSAKSI' => 'center', 'JENIS TRANSAKSI' => 'center', 'JENIS BBM' => 'right', 'TANGGAL ROLLBACK' => 'center', 'ALASAN ROLLBACK' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 7;
        $table->header[] = array(
            "NO", 1, 1,
            "PEMBANGKIT", 1, 1,
            "NOMOR TRANSAKSI", 1, 1,
            "JENIS TRANSAKSI", 1, 1,
            "JENIS BBM", 1, 1,
            "TANGGAL ROLLBACK", 1, 1,
            "ALASAN ROLLBACK", 1, 1,
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses(){
        extract($_POST);

        // NOMINASI

        if($ID_JENIS == 3){
            if($JNS_ROLLBACK == 1) {

                
                $edit = $this->tbl_get->update_nominasi($ID_TRANS);

                if($edit){
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                } else {
                    $message = array(false, 'Proses Gagal', 'Proses update data gagal.', '');
                }
            } else if($JNS_ROLLBACK == 2){
                $delete = $this->tbl_get->delete_nominasi($ID_TRANS);

                if($delete){
                    $message = array(true, 'Proses Berhasil', 'Proses delete data berhasil.', '#content_table');
                } else {
                    $message = array(false, 'Proses Gagal', 'Proses delete data gagal.', '');
                }
            }
        }

        // STOCK OPNAME

        if($ID_JENIS == 1){
            if($STATUS == 1 || $STATUS == 5) {
                
                if($JNS_ROLLBACK == 1){
                    $act = $this->tbl_get->edit_stockopname($ID_TRANS);
                } else if($JNS_ROLLBACK == 2){
                    $act = $this->tbl_get->delete_stockopname($ID_TRANS);
                }

                if($act){
                    $message = array(true, 'Proses Berhasil', 'Proses berhasil.', '#content_table');
                } else {
                    $message = array(false, 'Proses Gagal', 'Proses gagal.', '');
                }
            } else if($STATUS == 2 || $STATUS == 6) {
                $rest_data['SLOC'] = $SLOC;
                $rest_data['ID_TRANS'] = $ID_TRANS;
                $rest_data['ID_JNS_BHN_BKR'] = $ID_JNS_BHN_BKR;
                $rest_data['TGL_BA'] = $TGL_BA;
                if($ID_ROLLBACK == 'NONE') {
                    if($JNS_ROLLBACK == 2){
                        $save = $this->tbl_get->save_stockopname_satu($ID_TRX,$rest_data,'HAPUS');
                    } else if($JNS_ROLLBACK == 1){
                        $save = $this->tbl_get->save_stockopname_satu($ID_TRX,$rest_data,'REVISI');
                    }
                    
                    if($save){
                        $message = array(true, 'Proses Berhasil', 'Proses rollback data berhasil.', '#content_table');
                    } else {
                        $message = array(false, 'Proses Gagal', 'Proses rollback data gagal.', '');
                    }
                } else {
                    if ($ID_TRX == 'NONE') {
                        $value = explode(",", $ID_ROLLBACK[0]);
                        if($JNS_ROLLBACK == 2){
                            $save = $this->tbl_get->save_stockopname_dua($value,$rest_data,'HAPUS');
                        } else if($JNS_ROLLBACK == 1){
                            $save = $this->tbl_get->save_stockopname_dua($value,$rest_data,'REVISI');
                        }
                        
                        if($save) {
                            $message = array(true,'Berhasil','Data Berhasil di rollback !');
                        } else {
                            $message = array(false,'Gagal','Data Gagal di rollback !');
                        }
                    } else{
                        $value = explode(",", $ID_ROLLBACK[0]);

                        if($JNS_ROLLBACK == 2){
                            $save = $this->tbl_get->save_stockopname_tiga($ID_TRX,$value,$rest_data,'HAPUS');
                        } else if($JNS_ROLLBACK == 1){
                            $save = $this->tbl_get->save_stockopname_tiga($ID_TRX,$value,$rest_data,'REVISI');
                        }

                        if($save) {
                            $message = array(true,'Berhasil','Data Berhasil di rollback !', '#content_table');
                        } else {
                            $message = array(false,'Gagal','Data Gagal di rollback !');
                        }
                    }
                }
               
            }
        }

        //PEMAKAIAN

        if($ID_JENIS == 2){
            if($STATUS == 1 || $STATUS == 5) {
                
                if($JNS_ROLLBACK == 1){
                    $act = $this->tbl_get->edit_pemakaian($ID_TRANS);
                } else if($JNS_ROLLBACK == 2){
                    $act = $this->tbl_get->delete_pemakaian($ID_TRANS);
                }

                if($act){
                    $message = array(true, 'Proses Berhasil', 'Proses berhasil.', '', '#content_table');
                } else {
                    $message = array(false, 'Proses Gagal', 'Proses gagal.', '');
                }
            } else if($STATUS == 2 || $STATUS == 6) {
                $rest_data['SLOC'] = $SLOC;
                $rest_data['ID_TRANS'] = $ID_TRANS;
                $rest_data['ID_JNS_BHN_BKR'] = $ID_JNS_BHN_BKR;
                $rest_data['TGL_BA'] = $TGL_BA;
                if($ID_ROLLBACK == 'NONE') {
                    if($JNS_ROLLBACK == 2){
                        $save = $this->tbl_get->save_pemakaian_satu($ID_TRX,$rest_data,'HAPUS');
                    } else if($JNS_ROLLBACK == 1){
                        $save = $this->tbl_get->save_pemakaian_satu($ID_TRX,$rest_data,'REVISI');
                    }
                    
                    if($save){
                        $message = array(true, 'Proses Berhasil', 'Proses rollback data berhasil.', '', '#content_table');
                    } else {
                        $message = array(false, 'Proses Gagal', 'Proses rollback data gagal.', '');
                    }
                } else {
                    if ($ID_TRX == 'NONE') {
                        $value = explode(",", $ID_ROLLBACK[0]);
                        if($JNS_ROLLBACK == 2){
                            $save = $this->tbl_get->save_pemakaian_dua($value,$rest_data,'HAPUS');
                        } else if($JNS_ROLLBACK == 1){
                            $save = $this->tbl_get->save_pemakaian_dua($value,$rest_data,'REVISI');
                        }
                        
                        if($save) {
                            $message = array(true,'Berhasil','Data Berhasil di rollback !', '#content_table');
                        } else {
                            $message = array(false,'Gagal','Data Gagal di rollback !');
                        }
                    } else{
                        $value = explode(",", $ID_ROLLBACK[0]);

                        if($JNS_ROLLBACK == 2){
                            $save = $this->tbl_get->save_pemakaian_tiga($ID_TRX,$value,$rest_data,'HAPUS');
                        } else if($JNS_ROLLBACK == 1){
                            $save = $this->tbl_get->save_pemakaian_tiga($ID_TRX,$value,$rest_data,'REVISI');
                        }

                        if($save) {
                            $message = array(true,'Berhasil','Data Berhasil di rollback !', '#content_table');
                        } else {
                            $message = array(false,'Gagal','Data Gagal di rollback !');
                        }
                    }
                }
               
            }
        }

        // PENERIMAAN

        if($ID_JENIS == 4){
            if($STATUS == 1 || $STATUS == 5) {
                if($JNS_ROLLBACK == 1){
                    $act = $this->tbl_get->edit_penerimaan($ID_TRANS);
                } else if($JNS_ROLLBACK == 2){
                    $act = $this->tbl_get->delete_penerimaan($ID_TRANS);
                }

                if($act){
                    $message = array(true, 'Proses Berhasil', 'Proses berhasil.', '#content_table');
                } else {
                    $message = array(false, 'Proses Gagal', 'Proses gagal.', '');
                }
            } else if($STATUS == 2 || $STATUS == 6) {
                $rest_data['SLOC'] = $SLOC;
                $rest_data['ID_TRANS'] = $ID_TRANS;
                $rest_data['ID_JNS_BHN_BKR'] = $ID_JNS_BHN_BKR;
                $rest_data['TGL_BA'] = $TGL_BA;
                if($ID_ROLLBACK == 'NONE') {
                    if($JNS_ROLLBACK == 2){
                        $save = $this->tbl_get->save_penerimaan_satu($ID_TRX,$rest_data,'HAPUS');
                    } else if($JNS_ROLLBACK == 1){
                        $save = $this->tbl_get->save_penerimaan_satu($ID_TRX,$rest_data,'REVISI');
                    }
                    
                    if($save){
                        $message = array(true, 'Proses Berhasil', 'Proses rollback data berhasil.', '#content_table');
                    } else {
                        $message = array(false, 'Proses Gagal', 'Proses rollback data gagal.', '');
                    }
                } else {
                    if ($ID_TRX == 'NONE') {
                        $value = explode(",", $ID_ROLLBACK[0]);
                        if($JNS_ROLLBACK == 2){
                            $save = $this->tbl_get->save_penerimaan_dua($value,$rest_data,'HAPUS');
                        } else if($JNS_ROLLBACK == 1){
                            $save = $this->tbl_get->save_penerimaan_dua($value,$rest_data,'REVISI');
                        }
                        
                        if($save) {
                            $message = array(true,'Berhasil','Data Berhasil di rollback !', '#content_table');
                        } else {
                            $message = array(false,'Gagal','Data Gagal di rollback !');
                        }
                    } else{
                        $value = explode(",", $ID_ROLLBACK[0]);

                        if($JNS_ROLLBACK == 2){
                            $save = $this->tbl_get->save_penerimaan_tiga($ID_TRX,$value,$rest_data,'HAPUS');
                        } else if($JNS_ROLLBACK == 1){
                            $save = $this->tbl_get->save_penerimaan_tiga($ID_TRX,$value,$rest_data,'REVISI');
                        }

                        if($save) {
                            $message = array(true,'Berhasil','Data Berhasil di rollback !', '#content_table');
                        } else {
                            $message = array(false,'Gagal','Data Gagal di rollback !');
                        }
                    }
                }
               
            }
        }

        $newdata['SLOC'] = $SLOC;
        $newdata['JNS_TRX'] = $ID_JENIS;
        $newdata['ID_TRX'] = $ID_TRANS;
        $newdata['ID_JNS_BHN_BKR'] = $ID_JNS_BHN_BKR;
        $newdata['TGL_PENGAKUAN'] = $TGL_BA;
        $newdata['KETERANGAN'] = $ALASAN_ROLLBACK;
        $newdata['CD_BY'] = 'testbbm17';
        $newdata['CD_DATE'] = date('Y-m-d H:i:s');

        $this->db->insert('LOG_ROLLBACK',$newdata);
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
 

    public function load_jenisbbm(){
        extract($_POST);
        $message = $this->tbl_get->options_jns_bhn_bkr($sloc);
        echo json_encode($message);
    }

    public function get_all(){
        extract($_POST);
        $message = $this->tbl_get->get_all($sloc);
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

    public function get_transaksi() {

        $sloc = $_POST['sloc'];
        $bbm = $_POST['bbm'];
        $jenis = $_POST['jenis'];

        $message = $this->tbl_get->get_transaksi($sloc,$bbm,$jenis);
        echo json_encode($message);
    }

    public function get_detailtransaksi() {
        $jenis = $_POST['jenis'];
        $idtrans = $_POST['idtrans'];
        $message = $this->tbl_get->get_detailtransaksi($idtrans,$jenis);
        if($jenis == 1){
            $data['TGL'] = $message->TGL_BA_STOCKOPNAME;
            $data['STATUS'] = $message->STATUS_APPROVE_STOCKOPNAME;
        } else if($jenis == 3){
            $data['TGL'] = $message->TGL_MTS_NOMINASI;
            $data['STATUS'] = $message->STATUS_APPROVE;
        } else if($jenis == 2){
            $data['TGL'] = $message->TGL_MUTASI_PENGAKUAN;
            $data['STATUS'] = $message->STATUS_MUTASI_PEMAKAIAN;
        } else if($jenis == 4){
            $data['TGL'] = $message->TGL_PENGAKUAN;
            $data['STATUS'] = $message->STATUS_MUTASI_TERIMA;
        }

        echo json_encode($data);
    }

    public function get_transaksi_prev() {

        $sloc = $_POST['sloc'];
        $bbm = $_POST['bbm'];
        $tgl = $_POST['tgl'];
        $no_trans = $_POST['no_trans'];
        $message = $this->tbl_get->get_transaksi_prev($sloc,$bbm,$tgl,$no_trans);
        echo json_encode($message);
    }

    public function get_transaksi_pemakaian(){
        $sloc = $_POST['sloc'];
        $bbm = $_POST['bbm'];
        $tgl = $_POST['tgl'];
        $no_trans = $_POST['no_trans'];
        $arr['data'] = $this->tbl_get->get_transaksi_pemakaian($sloc,$bbm,$tgl,$no_trans);
        $this->load->view($this->_module.'/table_stockopname',$arr);
    }

    public function get_transaksi_penerimaan(){
        $sloc = $_POST['sloc'];
        $bbm = $_POST['bbm'];
        $tgl = $_POST['tgl'];
        $no_trans = $_POST['no_trans'];
        $arr['data'] = $this->tbl_get->get_transaksi_penerimaan($sloc,$bbm,$tgl,$no_trans);
        $this->load->view($this->_module.'/table_stockopname',$arr);
    }

    public function get_transaksi_stockopname(){
        $sloc = $_POST['sloc'];
        $bbm = $_POST['bbm'];
        $tgl = $_POST['tgl'];
        $no_trans = $_POST['no_trans'];
        $arr['data'] = $this->tbl_get->get_transaksi_stockopname($sloc,$bbm,$tgl,$no_trans);
        $this->load->view($this->_module.'/table_stockopname',$arr);
    }

    function get_id_rollback(){
        extract($_POST);

        $value = explode(",", $ID_ROLLBACK[0]);

        $send = $this->tbl_get->get_data_array($value);

        if($send) {
            $arr['data'] = $this->tbl_get->get_temp_rollback();
            $this->load->view($this->_module.'/table',$arr);
        } else {
            return false;
        }
        
    }
    
}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
