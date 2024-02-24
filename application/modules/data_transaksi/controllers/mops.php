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
class mops extends MX_Controller
{

    private $_title = 'MOPS';
    private $_limit = 10;
    private $_module = 'data_transaksi/mops';
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
        // $this->load->model('laporan/persediaan_bbm_model','tbl_get_combo');

        /* Load Global Model */
        $this->load->model('mops_model', 'tbl_get');
        $this->load->library('lexcel');
    }

    public function index(){
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));
        // Memanggil Level User
        // $data = $this->get_level_user();

        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add'))),
                anchor(null, '<i class="icon-upload"></i> Upload Data', array('class' => 'btn green', 'id' => 'button-upload', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/upload')))
            );
        }

        $data['page_notif'] = false;
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        // $data['data_sources_rekap'] = base_url($this->_module . '/load_rekap');
        echo Modules::run("template/admin", $data);
    }

    public function load($page = 1){
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_MOPS';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center','TGL_MOPS' => 'center', 'LOWHSD_MOPS' => 'center', 'MIDHSD_MOPS' => 'center', 'LOWMFO_MOPS' => 'center', 'MIDMFO_MOPS' => 'center', 'LOWMFOLSFO_MOPS' => 'center', 'MIDMFOLSFO_MOPS' => 'center', 'STATUS' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "No", 1, 1,
            "Tanggal", 1, 1,
            "LOW HSD", 1, 1,
            "MID HSD", 1, 1,
            "LOW MFO HSFO", 1, 1,
            "MID MFO HSFO", 1, 1,
            "LOW MFO LSFO", 1, 1,
            "MID MFO LSFO", 1, 1,
            "Hitung", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function add($id=""){

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $page_title = 'Tambah Data '.$this->_title;
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Data '.$this->_title;
            $mops = $this->tbl_get->data($id);
            $data['default'] = $mops->get()->row();
        }
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

    public function upload($id = ''){
        $page_title = 'Upload '.$this->_title;
        $data['id'] = $id;
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/import');
        $this->load->view($this->_module . '/form_upload', $data);
    }

    public function import(){
        // if ($this->form_validation->run($this)) {
        if (!empty($_FILES['excel']['name'])){
            $new_name = 'MOPS_'.$this->session->userdata('user_name').'_'.rand(100000,999999);
            $new_name =  str_replace(".","",$new_name);
            $new_name =  str_replace(",","",$new_name);

            $config['file_name'] = $new_name;
            $config['upload_path'] = './assets/upload/mops';
            $config['allowed_types'] = 'xls|xlsx';
            
            
            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload('excel')){
                $error = array('error' => $this->upload->display_errors());
                // print_r("error \n");
                // print_r($error);
                $message = array(false, 'Proses gagal upload', $error, '');
            } else {
                $data = $this->upload->data();
                
                error_reporting(0);
                date_default_timezone_set('Asia/Jakarta');

                include './assets/plugin/phpexcel/PHPExcel/IOFactory.php';

                $inputFileName = './assets/upload/mops/' .$data['file_name'];
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                
                $index = 0;
                $tglAwal = '';
                $tglAkhir = '';
                $berhasil = 0;
                $gagalInsert = 0;
                $gagalDobel = 0;
                $gagalTgl = 0;
                $resultData = array();
                $pesanDobel = '<br>Terdapat MOPS yang telah dipergunakan dalam proses perhitungan harga untuk tanggal :<br>'; 
                $pesanInsert = '<br>Gagal proses upload data untuk tanggal :<br>';
                $pesanError = '<br>Gagal upload data :<br>';

                foreach ($sheetData as $key => $value) {

                    // if ($key != 1) {

                    if ($index > 2){

                        // if (($value['E']=='') || ($value['F']=='') || ($value['G']=='') || ($value['H']=='')){
                        //     break;
                        // }

                        if ($value['D']==''){
                            break;
                        }

                        try {
                            $date = DateTime::createFromFormat('m-d-y', $value['D']);                        
                            $tgl = date_format($date,'Y-m-d');

                            if ($date==''){
                                $error = 'Format tanggal tidak sesuai';
                                throw new Exception($error);
                            }
                            // $tgl = $date->format('Y-m-d');
                            // $tgl = $value['D'];
                            // $tgl = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($value['D']));  

                            $resultsData['TGL_MOPS'] = $tgl;

                            $resultData['LOWHSD_MOPS'] = !empty(str_replace(",","",$value['E'])) ? str_replace(",","",$value['E']) : null;
                            $resultsData['LOWHSD_MOPS'] = !empty(str_replace(".",".",$resultData['LOWHSD_MOPS'])) ? str_replace(".",".",$resultData['LOWHSD_MOPS']) : null;
                            // $resultsDatas['LOWHSD_MOPS'] = !empty(str_replace(".","",$resultsData['LOWHSD_MOPS'])) ? str_replace(".","",$resultsData['LOWHSD_MOPS']) : null;

                            $resultData['MIDHSD_MOPS'] = !empty(str_replace(",","",$value['F'])) ? str_replace(",","",$value['F']) : null;
                            $resultsData['MIDHSD_MOPS'] = !empty(str_replace(".",".",$resultData['MIDHSD_MOPS'])) ? str_replace(".",".",$resultData['MIDHSD_MOPS']) : null;
                            // $resultsDatas['MIDHSD_MOPS'] = !empty(str_replace(".","",$resultsData['MIDHSD_MOPS'])) ? str_replace(".","",$resultsData['MIDHSD_MOPS']) : null;

                            $resultData['LOWMFO_MOPS'] = !empty(str_replace(",","",$value['G'])) ? str_replace(",","",$value['G']) : null;
                            $resultsData['LOWMFO_MOPS'] = !empty(str_replace(".",".",$resultData['LOWMFO_MOPS'])) ? str_replace(".",".",$resultData['LOWMFO_MOPS']) : null;
                            // $resultsDatas['LOWMFO_MOPS'] = !empty(str_replace(".","",$resultsData['LOWMFO_MOPS'])) ? str_replace(".","",$resultsData['LOWMFO_MOPS']) : null;

                            $resultData['MIDMFO_MOPS'] = !empty(str_replace(",","",$value['H'])) ? str_replace(",","",$value['H']) : null;
                            $resultsData['MIDMFO_MOPS'] = !empty(str_replace(".",".",$resultData['MIDMFO_MOPS'])) ? str_replace(".",".",$resultData['MIDMFO_MOPS']) : null;
                            // $resultsDatas['MIDMFO_MOPS'] = !empty(str_replace(".","",$resultsData['MIDMFO_MOPS'])) ? str_replace(".","",$resultsData['MIDMFO_MOPS']) : null;
                            
                            $resultData['LOWMFOLSFO_MOPS'] = !empty(str_replace(",","",$value['I'])) ? str_replace(",","",$value['I']) : null;
                            $resultsData['LOWMFOLSFO_MOPS'] = !empty(str_replace(".",".",$resultData['LOWMFOLSFO_MOPS'])) ? str_replace(".",".",$resultData['LOWMFOLSFO_MOPS']) : null;
                            // $resultsDatas['LOWMFOLSFO_MOPS'] = !empty(str_replace(".","",$resultsData['LOWMFOLSFO_MOPS'])) ? str_replace(".","",$resultsData['LOWMFOLSFO_MOPS']) : null;

                            $resultData['MIDMFOLSFO_MOPS'] = !empty(str_replace(",","",$value['J'])) ? str_replace(",","",$value['J']) : null;
                            $resultsData['MIDMFOLSFO_MOPS'] = !empty(str_replace(".",".",$resultData['MIDMFOLSFO_MOPS'])) ? str_replace(".",".",$resultData['MIDMFOLSFO_MOPS']) : null;
                            // $resultsDatas['MIDMFOLSFO_MOPS'] = !empty(str_replace(".","",$resultsData['MIDMFOLSFO_MOPS'])) ? str_replace(".","",$resultsData['MIDMFOLSFO_MOPS']) : null;

                            $resultsData['CD_BY_MOPS'] = $this->session->userdata('user_name'); 
                            $resultsData['CD_DATE_MOPS'] = date('Y-m-d');                         

                            if ($tglAwal==''){
                                $tglAwal = $tgl;
                            } else if ($tgl < $tglAwal){
                                $tglAwal = $tgl;
                            }     

                            if ($tglAkhir==''){
                                $tglAkhir = $tgl;
                            } else if ($tgl > $tglAkhir){
                                $tglAkhir = $tgl;
                            }                           

                            if ($this->tbl_get->check_tanggal_mops($tgl, $tgl) == 0){
                                $this->tbl_get->delete_per_tgl($tgl, $tgl);
                                // print_r($resultsData); die();
                                $result = $this->tbl_get->save_as_new($resultsData);
                                if ($result > 0) {
                                        $berhasil++;
                                } else {
                                    if ($gagalInsert>0){                
                                        $pesanInsert.= ', '.$tgl;
                                    } else {
                                        $pesanInsert.= $tgl;    
                                    }
                                    
                                    $gagalInsert++;    
                                }   
                            } else {
                                if ($gagalDobel>0){                                
                                    $pesanDobel.= ', '.$tgl;
                                } else {
                                    $pesanDobel.= $tgl;    
                                }                            
                                $gagalDobel++;
                            }
                        } catch (Exception $e) {
                            // echo 'Caught exception: ',  $e->getMessage(), "\n";
                               
                            $pesanError = '<br>Gagal upload data, '.$e->getMessage();
                            
                            $gagalTgl++;                             
                        }                        
                    }
                    $index++;
                }

                // echo "<pre>";
                // echo "TGL AWAL ".$tglAwal."<br>";
                // echo "TGL Akhir ".$tglAkhir."<br><br>";
                // print_r($resultData);
                // echo "</pre>";
                
                // die();

                unlink('./assets/upload/mops/' .$data['file_name']); 

                $rest = 'Total Proses : '.($berhasil+$gagalInsert+$gagalDobel+$gagalTgl).'  
                    <br>
                    - Sukses tersimpan : '.$berhasil.'  
                    <br>
                    - Gagal tersimpan : '.($gagalInsert+$gagalDobel+$gagalTgl).' 
                    <br>';

                if (($gagalInsert+$gagalDobel+$gagalTgl)>0){
                    $rest.= '<br>Pesan Gagal :';
                }

                if ($gagalDobel>0){
                    $rest.= $pesanDobel;
                }

                if ($gagalInsert>0){
                    $rest.= $pesanInsert;
                }

                if ($gagalTgl>0){
                    $rest.= $pesanError;
                }

                if ($berhasil>0){
                    $message = array(true, 'Proses Berhasil', $rest, '#content_table');
                } else {
                    $message = array(false, 'Proses gagal', $rest, '');
                }
            }
        } else {
            $message = array(false, 'Proses gagal', 'Upload file harus diisi', '');
        }    

        echo json_encode($message, true);
    }

    public function proses(){
        $this->form_validation->set_rules('TGL_MOPS', 'Tanggal MOPS', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('LOWHSD_MOPS', 'LOW HSD MOPS', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('MIDHSD_MOPS', 'MID HSD MOPS', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('LOWMFO_MOPS', 'LOW MFO HSFO MOPS', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('MIDMFO_MOPS', 'MID MFO HSFO MOPS', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('LOWMFOLSFO_MOPS', 'LOW MFO LSFO MOPS', 'trim|required|max_length[11]');
        $this->form_validation->set_rules('MIDMFOLSFO_MOPS', 'MID MFO LSFO MOPS', 'trim|required|max_length[11]');

        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();

            $data['TGL_MOPS'] = $this->input->post('TGL_MOPS');

            $data['LOWHSD_MOPS'] =  str_replace(".","",$this->input->post('LOWHSD_MOPS'));
            $data['LOWHSD_MOPS'] =  str_replace(",",".",$data['LOWHSD_MOPS']);

            $data['MIDHSD_MOPS'] =  str_replace(".","",$this->input->post('MIDHSD_MOPS'));
            $data['MIDHSD_MOPS'] =  str_replace(",",".",$data['MIDHSD_MOPS']);

            $data['LOWMFO_MOPS'] =  str_replace(".","",$this->input->post('LOWMFO_MOPS'));
            $data['LOWMFO_MOPS'] =  str_replace(",",".",$data['LOWMFO_MOPS']);

            $data['MIDMFO_MOPS'] =  str_replace(".","",$this->input->post('MIDMFO_MOPS'));
            $data['MIDMFO_MOPS'] =  str_replace(",",".",$data['MIDMFO_MOPS']);

            $data['LOWMFOLSFO_MOPS'] =  str_replace(".","",$this->input->post('LOWMFOLSFO_MOPS'));
            $data['LOWMFOLSFO_MOPS'] =  str_replace(",",".",$data['LOWMFOLSFO_MOPS']);

            $data['MIDMFOLSFO_MOPS'] =  str_replace(".","",$this->input->post('MIDMFOLSFO_MOPS'));
            $data['MIDMFOLSFO_MOPS'] =  str_replace(",",".",$data['MIDMFOLSFO_MOPS']);

            
            $TGL_MOPS = $data['TGL_MOPS']; 
            if ($id == '') {
                if ($this->tbl_get->check_tanggal($TGL_MOPS) == FALSE){
                    $message = array(false, 'Proses GAGAL', ' Tanggal MOPS '.$TGL_MOPS.' Sudah Ada.', '');
                } else {
                    $data['CD_BY_MOPS'] = $this->session->userdata('user_name');
                    $data['CD_DATE_MOPS'] = date('Y-m-d');

                    // print_r($data); die();

                    if ($this->tbl_get->save_as_new($data)) {
                        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                    }
                }
            } else {    
                $data['UD_BY_MOPS'] = $this->session->userdata('user_name');
                $data['UD_DATE_MOPS'] = date('Y-m-d');

                if ($this->tbl_get->save($data, $id)) {
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                }
            }  
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function import_lama(){
        // if (empty($_FILES['excel']['name'])){
        //     $this->form_validation->set_rules('excel', 'Upload File', 'required');
        // }

        // if ($this->form_validation->run($this)) {
        if (!empty($_FILES['excel']['name'])){
            $new_name = 'MOPS_'.$this->session->userdata('user_name').'_'.rand(100000,999999);
            $new_name =  str_replace(".","",$new_name);
            $new_name =  str_replace(",","",$new_name);

            $config['file_name'] = $new_name;
            $config['upload_path'] = './assets/upload/mops';
            $config['allowed_types'] = 'xls|xlsx';
            
            
            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload('excel')){
                $error = array('error' => $this->upload->display_errors());
                // print_r("error \n");
                // print_r($error);
                $message = array(false, 'Proses gagal upload', $error, '');
            } else {
                $data = $this->upload->data();
                
                error_reporting(E_ALL);
                date_default_timezone_set('Asia/Jakarta');

                include './assets/plugin/phpexcel/PHPExcel/IOFactory.php';

                $inputFileName = './assets/upload/mops/' .$data['file_name'];
                $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
                $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                
                $index = 0;
                $tglAwal = '';
                $tglAkhir = '';
                $berhasil = 0;
                $gagalInsert = 0;
                $gagalDobel = 0;
                $resultData = array();
                $pesanDobel= '<br>Terdapat MOPS yang telah dipergunakan dalam proses perhitungan harga untuk tanggal :<br>'; 
                $pesanInsert= '<br>Gagal upload data untuk tanggal :<br>'; 

                foreach ($sheetData as $key => $value) {
                    // if ($key != 1) {

                    if ($index > 2){

                        // if (($value['E']=='') || ($value['F']=='') || ($value['G']=='') || ($value['H']=='')){
                        //     break;
                        // }

                        if ($value['D']==''){
                            break;
                        }

                        $date = DateTime::createFromFormat('m-d-y', $value['D']);                        
                        $tgl = date_format($date,'Y-m-d');
                        // $tgl = $date->format('Y-m-d');
                        // $tgl = $value['D'];
                        // $tgl = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($value['D']));

                        // $resultData[$index]['TGL_MOPS'] = $tgl;
                        // $resultData[$index]['LOWHSD_MOPS'] = !empty($value['E']) ? $value['E'] : null;
                        // $resultData[$index]['MIDHSD_MOPS'] = !empty($value['F']) ? $value['F'] : null;
                        // $resultData[$index]['LOWMFO_MOPS'] = !empty($value['G']) ? $value['G'] : null;
                        // $resultData[$index]['MIDMFO_MOPS'] = !empty($value['H']) ? $value['H'] : null;
                        // $resultData[$index]['CD_BY_MOPS'] = $this->session->userdata('user_name'); 
                        // $resultData[$index]['CD_DATE_MOPS'] = date('Y-m-d');      

                        $resultData['TGL_MOPS'] = $tgl;
                        $resultData['LOWHSD_MOPS'] = !empty($value['E']) ? $value['E'] : null;
                        $resultData['MIDHSD_MOPS'] = !empty($value['F']) ? $value['F'] : null;
                        $resultData['LOWMFO_MOPS'] = !empty($value['G']) ? $value['G'] : null;
                        $resultData['MIDMFO_MOPS'] = !empty($value['H']) ? $value['H'] : null;
                        $resultData['CD_BY_MOPS'] = $this->session->userdata('user_name'); 
                        $resultData['CD_DATE_MOPS'] = date('Y-m-d');                         

                        if ($tglAwal==''){
                            $tglAwal = $tgl;
                        } else if ($tgl < $tglAwal){
                            $tglAwal = $tgl;
                        }     

                        if ($tglAkhir==''){
                            $tglAkhir = $tgl;
                        } else if ($tgl > $tglAkhir){
                            $tglAkhir = $tgl;
                        }        


                        // echo "<pre>";
                        // echo "TGL AWAL ".$tglAwal."<br>";
                        // echo "TGL Akhir ".$tglAkhir."<br><br>";
                        // print_r($resultData);
                        // echo "</pre>";
                        // die;                        

                        if ($this->tbl_get->check_tanggal_mops($tgl, $tgl) == 0){
                            $this->tbl_get->delete_per_tgl($tgl, $tgl);
                            $result = $this->tbl_get->save_as_new($resultData);
                            if ($result > 0) {
                                    $berhasil++;
                                    // $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                            } else {
                                if ($gagalInsert>0){                
                                    $pesanInsert.= ', '.$tgl;
                                } else {
                                    $pesanInsert.= $tgl;    
                                }
                                
                                $gagalInsert++;    
                            }   
                        } else {
                            if ($gagalDobel>0){                                
                                $pesanDobel.= ', '.$tgl;
                            } else {
                                $pesanDobel.= $tgl;    
                            }
                            
                            $gagalDobel++;
                        }
                    }
                    $index++;
                }

                // echo "<pre>";
                // echo "TGL AWAL ".$tglAwal."<br>";
                // echo "TGL Akhir ".$tglAkhir."<br><br>";
                // print_r($resultData);
                // echo "</pre>";
                
                // die();

                unlink('./assets/upload/mops/' .$data['file_name']); 

                // if(count($resultData) != 0)
                // if($index > 3){
                //     if ($this->tbl_get->check_tanggal_mops($tglAwal, $tglAkhir) > 0){
                //         $pesan = 'Periode tanggal MOPS import '.$tglAwal. ' s/d '.$tglAkhir.'<br>';
                //         $pesan.= 'Terdapat MOPS yang telah dipergunakan dalam proses perhitungan harga untuk periode tersebut';
                //         $message = array(false, 'Proses gagal', $pesan, '');
                //     } else {
                //         $this->tbl_get->delete_per_tgl($tglAwal, $tglAkhir);
                //         $result = $this->tbl_get->insert_batch($resultData);
                //         if ($result > 0) {
                //                 $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                //         }
                //     }

                        
                // } else {
                //     $message = array(false, 'Proses gagal', 'Tidak ada untuk diproses', '');
                // }
                $rest = 'Total Proses : '.($berhasil+$gagalInsert+$gagalDobel).'  
                    <br>
                    - Sukses tersimpan : '.$berhasil.'  
                    <br>
                    - Gagal tersimpan : '.($gagalInsert+$gagalDobel).' 
                    <br>';

                if (($gagalInsert+$gagalDobel)>0){
                    $rest.= '<br>Pesan Gagal :';
                }

                if ($gagalDobel>0){
                    $rest.= $pesanDobel;
                }

                if ($gagalInsert>0){
                    $rest.= $pesanInsert;
                }

                if ($berhasil>0){
                    $message = array(true, 'Proses Berhasil', $rest, '#content_table');
                } else {
                    $message = array(false, 'Proses gagal', $rest, '');
                }
                
            }                

        } else {
            $message = array(false, 'Proses gagal', 'Upload file harus diisi', '');
        }    

        echo json_encode($message, true);
    }    

    function export_pdf() {
        extract($_POST);
        header('Content-Type: application/json');
        $value = array(

            'STATUS' => $STATUS,
            'TGL_DARI' => $TGL_DARI,
            'TGL_SAMPAI' => $TGL_SAMPAI
        );

        $mops = $this->tbl_get->get_data($value);
        $data['data'] = $mops->get()->result_array();
        $data['JENIS'] = 'PDF';
        $html_source = $this->load->view($this->_module . '/export_pdf', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan Data MOPS.pdf');
        $this->lpdf->cetak('A4-L');
    }

    function export_excel() {
        extract($_POST);
        header('Content-Type: application/json');
        $value = array(

            'STATUS' => $STATUS,
            'TGL_DARI' => $TGL_DARI,
            'TGL_SAMPAI' => $TGL_SAMPAI
        );

        $mops = $this->tbl_get->get_data($value);
        $data['data'] = $mops->get()->result_array();
        $data['JENIS'] = 'XLS';
        $this->load->view($this->_module . '/export_excel', $data);
    }
	
}