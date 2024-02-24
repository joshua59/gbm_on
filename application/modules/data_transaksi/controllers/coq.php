<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Certificate Of Quality
 */
class coq extends MX_Controller {

    private $_title = 'Certificate of Quality';
    private $_limit = 10;
    private $_module = 'data_transaksi/coq';
    private $_urlgetfile = "";
    private $_url_movefile = "";
    private $_message1           = array(true,'Proses Berhasil','Proses penyimpanan data berhasil.');
    private $_message2           = array(false,'Proses Gagal','Proses penyimpanan data gagal.');
    private $_message_result     = array(false,'Proses Gagal','Proses penyimpanan data gagal Result.');
    private $_message_sloc       = array(false,'Proses Gagal','Proses penyimpanan data gagal Sloc.');
    private $_message3           = array(false,'Proses Gagal','Input minimal 1 (satu) parameter !.');
    private $_message4           = array(false,'Proses Gagal','Nilai Parameter tidak boleh (-) semua !.');
    private $_message_duplicate  = array(false,'Proses Gagal','Nomor Report dan Jenis Bahan Bakar sudah terdaftar !.');

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        $this->_url_movefile = $this->laccess->url_serverfile()."move";
        $this->_urlgetfile = $this->laccess->url_serverfile()."geturl";

        /* Load Global Model */
        $this->load->model('coq_model');
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
        $data['data_sources'] = base_url($this->_module . '/load');
        $data['notif'] = '';

        echo Modules::run("template/admin", $data);
    }

    function load_table() {

        extract($_POST);
        $data['p_cari']      = $p_cari;
        $data['p_depo']      = $p_depo;
        $data['p_pemasok']   = $p_pemasok;
        $data['p_status']    = $p_status;
        $data['p_user']      = $this->session->userdata('user_name');
        $data['form_action'] = base_url($this->_module . '/proses_kirim');
        $data['list']        = $this->coq_model->data($data);
        $data['url_getfile'] = $this->_urlgetfile;
        $this->load->view($this->_module. '/table',$data);
    }

    function load_filter() {
        // $data = $this->get_level_user(); 
        $data['options_pemasok'] = $this->coq_model->options_pemasok();
        $data['options_depo']    = $this->coq_model->options_depo();
        $data['options_status']  = $this->coq_model->options_status();
        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add'))
            );
        }
        $this->load->view($this->_module. '/filter',$data);
    }

    public function add($id = '') {

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');


        // $data = $this->get_level_user();
        $page_title     = 'Tambah Sertifikat';
        $data['id']     = $id;
        $data['id_dok'] = '';
        $data["url_getfile"] = $this->_urlgetfile;
        $data['form_action']        = base_url($this->_module . '/proses');
        if ($id != '') {
            $page_title           = 'Edit Sertifikat';
            $data['default']      = $this->coq_model->data_edit($id);
            $data['options_depo'] = $this->coq_model->depo_options('',$data['default']->ID_PEMASOK);
            $version              = $this->coq_model->get_tgl_version_by_id($data['default']->ID_VERSION);
            $data['id_dok']       = $data['default']->PATH_DOC;
            $data['DITETAPKAN']   = $version->DITETAPKAN;
            $data['NO_VERSION']   = $version->NO_VERSION;
            $data['TGL_VERSION']  = $version->TGL_VERSION;
            $surveyor             = $this->coq_model->get_nama($data['default']->ID_LEVEL,$data['default']->ID_SURVEYOR);
            $sloc                 = $this->coq_model->get_array_sloc($id);
            $data['SLOC']         = implode(",", $sloc);
            $data['form_action']  = base_url($this->_module . '/proses_edit');
        }

        $data['NAMA_SURVEYOR']      = $this->coq_model->get_namalevel($this->session->userdata('level_user'),$this->session->userdata('kode_level'));
        $data['ID_SURVEYOR']        = $this->coq_model->get_idlevel();
        $data['options_pemasok']    = $this->coq_model->options_pemasok();
        $data['options_pembangkit'] = $this->coq_model->options_pembangkit();
        $data['options_bbm']        = $this->coq_model->options_jenis_bahan_bakar();
        $data['page_title']         = '<i class="icon-laptop"></i> ' . $page_title;
        
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit() {
        extract($_POST);
        $this->add($id);
    }

    public function get_level_user(){
        $data['lv1_options'] = $this->coq_model->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->coq_model->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->coq_model->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->coq_model->options_lv4('--Pilih Pembangkit--', '-', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->coq_model->get_level($level_user, $kode_level);

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
            $data['lv4_options'] = $this->coq_model->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->coq_model->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->coq_model->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user == 0) {
            if ($kode_level == 00) {
                $data['reg_options'] = $this->coq_model->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->coq_model->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        return $data;
    }

    public function proses() {
        extract($_POST);

        $array1 = array();
        $array2 = array();
        $array3 = array();
        $array4 = array();

        $_prod = '';

        if($ID_JNS_BHN_BKR == 301 || $ID_JNS_BHN_BKR == 302 || $ID_JNS_BHN_BKR == 303 || $ID_JNS_BHN_BKR == 304) {
            $data['ID_JNS_BHN_BKR']  = '004';
            $data['ID_KOMPONEN_BBM'] = $ID_JNS_BHN_BKR;
        } else {
            $data['ID_JNS_BHN_BKR']  = $ID_JNS_BHN_BKR;
            $data['ID_KOMPONEN_BBM'] = NULL;
        }

        $data['ID_PEMASOK']     = $ID_PEMASOK;
        $data['ID_DEPO']        = $ID_DEPO;
        $data['NO_REPORT']      = $NO_REPORT;
        $data['TGL_SAMPLING']   = $TGL_SAMPLING;
        $data['TGL_COQ']        = $TGL_COQ;
        $data['SHORE_TANK']     = $SHORE_TANK;
        $data['KET']            = $this->input->post('KET');
        $data['ID_LEVEL']       = $this->session->userdata('level_user');
        $data['ID_SURVEYOR']    = $this->session->userdata('kode_level');
        $data['ID_VERSION']     = $this->input->post('ID_VERSION');
        $data['CD_BY']          = $this->session->userdata('user_name');
        $data['CD_DATE']        = date('Y-m-d h:i:s');

        if (!empty($_FILES['FILE_UPLOAD']['name'])){
            $new_name = preg_replace("/[^a-zA-Z0-9]/", "",$data['NO_REPORT']);
            $new_name = $new_name.'_'.date("YmdHis");
            $config['file_name'] = $new_name;
            $config['upload_path'] = 'assets/upload/kontrak_transportir/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
            $config['max_size'] = 1024 * 4; 

            $this->load->library('upload', $config);
        }

        if (!$this->upload->do_upload('FILE_UPLOAD')){
            $err = $this->upload->display_errors('', '');
            $message = array(false, 'Proses gagal', $err, '');
        } else {
            $res = $this->upload->data();
            if ($res){
                $nama_file = $res['file_name'];
                $data_file['PATH_DOC'] = $nama_file;
            }
            $duplicate = $this->coq_model->isExists2Key($ID_JNS_BHN_BKR,$NO_REPORT);
            if($duplicate) {
                $message = $this->_message_duplicate;
            } else {
                foreach ($result_save as $key => $value) {
                    if(!empty($value)) {
                        array_push($array4,$value);
                    } else {
                        array_push($array4,'-');
                    }
                }          
                $arr = in_array('-',$array4);
                if($arr) {
                    $nilai_kosong = array_count_values($array4);
                    $nilai_total  = count($array4);
                    if($nilai_kosong['-'] == $nilai_total) {
                        $message = $this->_message3;
                   } else {
                        $simpan1 = $this->coq_model->save_as_new($data);
                        if($simpan1) {
                            $lastid = $this->coq_model->get_last_id($this->session->userdata('user_name'));
                            $data_file['ID_TRANS']   = $lastid;
                            $data_file['PATH_DOC']   = $nama_file;
                            $data_file['CD_BY']      = $this->session->userdata('user_name');
                            $data_file['CD_DATE']    = date('Y-m-d h:i:s');
                            $simpan_gambar = $this->coq_model->save_as_new_file($data_file);

                            if($simpan_gambar){
                                $save_sloc   = $this->coq_model->insert_batch_sloc($lastid,$SLOC);
                                $save_result = $this->coq_model->insert_batch_result($lastid,$array4,$resume,$id_mcoq);
                                $_prod = $this->laccess->post_file_prod('KONTRAKTRANSPORTIR',$nama_file);

                                if($_prod == '')  {
                                    if($save_result) {
                                        if($save_sloc) {
                                            $get_result = $this->coq_model->get_result($lastid);
                                            if($get_result) {
                                                $review['STATUS_REVIEW'] = 2;
                                            } else {
                                                $review['STATUS_REVIEW'] = 1;
                                            }
                                            $update_review = $this->coq_model->update_review($review,$lastid);
                                            if($update_review) {
                                                $message = $this->_message1;
                                            } else {
                                                $message = $this->_message_result;
                                            }
                                        }else {
                                            $message = $this->_message_result;
                                        }
                                    } else {
                                        $message = $this->_message_sloc;
                                    }
                                } else {
                                    $message = $this->_message2;
                                }
                            } else {
                                $message = $this->_message2;
                            }
                        } else {
                            $message = $this->_message2;
                        }                       
                   }
                } else {
                    $simpan1 = $this->coq_model->save_as_new($data);
                    if($simpan1) {
                        $lastid = $this->coq_model->get_last_id($this->session->userdata('user_name'));
                        $data_file['ID_TRANS']   = $lastid;
                        $data_file['PATH_DOC']   = $nama_file;
                        $data_file['CD_BY']      = $this->session->userdata('user_name');
                        $data_file['CD_DATE']    = date('Y-m-d h:i:s');
                        $simpan_gambar = $this->coq_model->save_as_new_file($data_file);

                        if($simpan_gambar){
                            $save_sloc   = $this->coq_model->insert_batch_sloc($lastid,$SLOC);
                            $save_result = $this->coq_model->insert_batch_result($lastid,$array4,$resume,$id_mcoq);
                            $_prod = $this->laccess->post_file_prod('KONTRAKTRANSPORTIR',$nama_file);

                            if($_prod == '')  {
                                if($save_result) {
                                    if($save_sloc) {
                                        $get_result = $this->coq_model->get_result($lastid);
                                        if($get_result) {
                                            $review['STATUS_REVIEW'] = 2;
                                        } else {
                                            $review['STATUS_REVIEW'] = 1;
                                        }
                                        $update_review = $this->coq_model->update_review($review,$lastid);
                                        if($update_review) {
                                            $message = $this->_message1;
                                        } else {
                                            $message = $this->_message_result;
                                        }
                                    }else {
                                        $message = $this->_message_result;
                                    }
                                } else {
                                    $message = $this->_message_sloc;
                                }
                            } else {
                                $message = $this->_message2;
                            }
                        } else {
                            $message = $this->_message2;
                        }
                    } else {
                        $message = $this->_message2;
                    }
                }               
            }
        }
        
        echo json_encode($message);
    }

    function proses_edit() {
        extract($_POST);
        $array4 = array();
        $nama_file = '';
        $_prod = '';

        if($ID_JNS_BHN_BKR == 301 || $ID_JNS_BHN_BKR == 302 || $ID_JNS_BHN_BKR == 303 || $ID_JNS_BHN_BKR == 304) {
            $data['ID_JNS_BHN_BKR']  = '004';
            $data['ID_KOMPONEN_BBM'] = $ID_JNS_BHN_BKR;
        } else {
            $data['ID_JNS_BHN_BKR']  = $ID_JNS_BHN_BKR;
            $data['ID_KOMPONEN_BBM'] = NULL;
        }

        $data['ID_PEMASOK']     = $ID_PEMASOK;
        $data['ID_DEPO']        = $ID_DEPO;
        $data['NO_REPORT']      = $NO_REPORT;
        $data['TGL_SAMPLING']   = $TGL_SAMPLING;
        $data['TGL_COQ']        = $TGL_COQ;
        $data['SHORE_TANK']     = $SHORE_TANK;
        $data['KET']            = $this->input->post('KET');
        $data['ID_LEVEL']       = $this->session->userdata('level_user');
        $data['ID_SURVEYOR']    = $this->session->userdata('kode_level');
        $data['ID_VERSION']     = $this->input->post('ID_VERSION');
        $data['UD_DATE'] = date('Y-m-d H:i:s');
        $data['UD_BY']   = $this->session->userdata('user_name');

        $update = $this->coq_model->save($data,$id);
        $default = $this->coq_model->data_edit($id);
        $duplicate = $this->coq_model->isExists2Key($ID_JNS_BHN_BKR,$NO_REPORT);

        if($default->NO_REPORT == $NO_REPORT && ($default->ID_JNS_BHN_BKR == $ID_JNS_BHN_BKR || $default->KOMP_BBM == $ID_JNS_BHN_BKR)) {
            foreach ($result_save as $key => $value) {
                if(!empty($value)) {
                    array_push($array4,$value);
                } else {
                    array_push($array4,'-');
                }
            }
            $arr = in_array('-',$array4);
            if($arr) {
                $nilai_kosong = array_count_values($array4);
                $nilai_total  = count($array4);

                if($nilai_kosong['-'] == $nilai_total) {
                    $message = $this->_message3;
                } else {
                    $delete_all = $this->coq_model->delete_all($id);

                    if($delete_all) {
                        $save_result = $this->coq_model->insert_batch_result($id,$array4,$resume,$id_mcoq);
                        if($save_result) {
                            $save_sloc   = $this->coq_model->insert_batch_sloc($id,$SLOC);
                            if($save_sloc) {
                                $get_result = $this->coq_model->get_result($id);
                                if($get_result) {
                                    $review['STATUS_REVIEW'] = 2;
                                } else {
                                    $review['STATUS_REVIEW'] = 1;
                                }
                                $update_review = $this->coq_model->update_review($review,$id);
                                if($update_review) {
                                    
                                    if (!empty($_FILES['FILE_UPLOAD']['name'])){
                                        $new_name = preg_replace("/[^a-zA-Z0-9]/", "",$data['NO_REPORT']);
                                        $new_name = $new_name.'_'.date("YmdHis");
                                        $config['file_name'] = $new_name;
                                        $config['upload_path'] = 'assets/upload/kontrak_transportir/';
                                        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                                        $config['max_size'] = 1024 * 4; 

                                        $this->load->library('upload', $config);

                                        if (!$this->upload->do_upload('FILE_UPLOAD')){
                                            $err = $this->upload->display_errors('', '');
                                            $message = array(false, 'Proses gagal', $err, '');
                                        } else {
                                            $res = $this->upload->data();
                                            $nama_file = $res['file_name'];
                                            $data_file['PATH_DOC'] = $nama_file;
                                            if($res) {
                                                $_prod = $this->laccess->post_file_prod('KONTRAKTRANSPORTIR',$nama_file);
                                                if($_prod = '') {
                                                    if($nama_file) {
                                                        $data_file['CD_BY']      = $this->session->userdata('user_name');
                                                        $data_file['CD_DATE']    = date('Y-m-d h:i:s');
                                                        $update_file = $this->coq_model->update_file($data_file,$id);

                                                        if($update_file) {
                                                            $message = $this->_message1;
                                                        } else {
                                                            $message = $this->_message2;
                                                        }
                                                    }
                                                } else {
                                                    if($nama_file) {
                                                        $data_file['CD_BY']      = $this->session->userdata('user_name');
                                                        $data_file['CD_DATE']    = date('Y-m-d h:i:s');
                                                        $update_file = $this->coq_model->update_file($data_file,$id);

                                                        if($update_file) {
                                                            $message = $this->_message1;
                                                        } else {
                                                            $message = $this->_message2;
                                                        }
                                                    }
                                                }

                                            }
                                        }
                                    } else {
                                        $message = $this->_message1;
                                    }

                                } else {
                                    $message = $this->_message2;
                                }
                            } else {
                                $message = $this->_message2;
                            }
                        } else {
                            $message = $this->_message2;
                        }
                    } else {
                        $message = $this->_message2;
                    }
                }
            } else {
                $delete_all = $this->coq_model->delete_all($id);
                if($delete_all) {
                    $save_result = $this->coq_model->insert_batch_result($id,$array4,$resume,$id_mcoq);
                    if($save_result) {
                        $save_sloc   = $this->coq_model->insert_batch_sloc($id,$SLOC);
                        if($save_sloc) {
                            $get_result = $this->coq_model->get_result($id);
                            if($get_result) {
                                $review['STATUS_REVIEW'] = 2;
                            } else {
                                $review['STATUS_REVIEW'] = 1;
                            }
                            $update_review = $this->coq_model->update_review($review,$id);
                            if($update_review) {
                                
                                if (!empty($_FILES['FILE_UPLOAD']['name'])){
                                    $new_name = preg_replace("/[^a-zA-Z0-9]/", "",$data['NO_REPORT']);
                                    $new_name = $new_name.'_'.date("YmdHis");
                                    $config['file_name'] = $new_name;
                                    $config['upload_path'] = 'assets/upload/kontrak_transportir/';
                                    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                                    $config['max_size'] = 1024 * 4; 

                                    $this->load->library('upload', $config);

                                    if (!$this->upload->do_upload('FILE_UPLOAD')){
                                        $err = $this->upload->display_errors('', '');
                                        $message = array(false, 'Proses gagal', $err, '');
                                    } else {
                                        $res = $this->upload->data();
                                        $nama_file = $res['file_name'];
                                        $data_file['PATH_DOC'] = $nama_file;
                                        if($res) {
                                            $_prod = $this->laccess->post_file_prod('KONTRAKTRANSPORTIR',$nama_file);
                                            if($_prod = '') {
                                                if($nama_file) {
                                                    $data_file['CD_BY']      = $this->session->userdata('user_name');
                                                    $data_file['CD_DATE']    = date('Y-m-d h:i:s');
                                                    $update_file = $this->coq_model->update_file($data_file,$id);

                                                    if($update_file) {
                                                        $message = $this->_message1;
                                                    } else {
                                                        $message = $this->_message2;
                                                    }
                                                }
                                            } else {
                                                if($nama_file) {
                                                    $data_file['CD_BY']      = $this->session->userdata('user_name');
                                                    $data_file['CD_DATE']    = date('Y-m-d h:i:s');
                                                    $update_file = $this->coq_model->update_file($data_file,$id);

                                                    if($update_file) {
                                                        $message = $this->_message1;
                                                    } else {
                                                        $message = $this->_message2;
                                                    }
                                                }
                                            }

                                        }
                                    }
                                } else {
                                    $message = $this->_message1;
                                }

                            } else {
                                $message = $this->_message2;
                            }
                        } else {
                            $message = $this->_message2;
                        }
                    } else {
                        $message = $this->_message2;
                    }
                } else {
                    $message = $this->_message2;
                }
            }
        } else {
            if($duplicate) {
                $message = $this->_message_duplicate;
            } else {
                foreach ($result_save as $key => $value) {
                    if(!empty($value)) {
                        array_push($array4,$value);
                    } else {
                        array_push($array4,'-');
                    }
                }
                $arr = in_array('-',$array4);
                if($arr) {
                    $nilai_kosong = array_count_values($array4);
                    $nilai_total  = count($array4);

                    if($nilai_kosong['-'] == $nilai_total) {
                        $message = $this->_message3;
                    } else {
                        $delete_all = $this->coq_model->delete_all($id);

                        if($delete_all) {
                            $save_result = $this->coq_model->insert_batch_result($id,$array4,$resume,$id_mcoq);
                            if($save_result) {
                                $save_sloc   = $this->coq_model->insert_batch_sloc($id,$SLOC);
                                if($save_sloc) {
                                    $get_result = $this->coq_model->get_result($id);
                                    if($get_result) {
                                        $review['STATUS_REVIEW'] = 2;
                                    } else {
                                        $review['STATUS_REVIEW'] = 1;
                                    }
                                    $update_review = $this->coq_model->update_review($review,$id);
                                    if($update_review) {
                                        
                                        if (!empty($_FILES['FILE_UPLOAD']['name'])){
                                            $new_name = preg_replace("/[^a-zA-Z0-9]/", "",$data['NO_REPORT']);
                                            $new_name = $new_name.'_'.date("YmdHis");
                                            $config['file_name'] = $new_name;
                                            $config['upload_path'] = 'assets/upload/kontrak_transportir/';
                                            $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                                            $config['max_size'] = 1024 * 4; 

                                            $this->load->library('upload', $config);

                                            if (!$this->upload->do_upload('FILE_UPLOAD')){
                                                $err = $this->upload->display_errors('', '');
                                                $message = array(false, 'Proses gagal', $err, '');
                                            } else {
                                                $res = $this->upload->data();
                                                $nama_file = $res['file_name'];
                                                $data_file['PATH_DOC'] = $nama_file;
                                                if($res) {
                                                    $_prod = $this->laccess->post_file_prod('KONTRAKTRANSPORTIR',$nama_file);
                                                    if($_prod = '') {
                                                        if($nama_file) {
                                                            $data_file['CD_BY']      = $this->session->userdata('user_name');
                                                            $data_file['CD_DATE']    = date('Y-m-d h:i:s');
                                                            $update_file = $this->coq_model->update_file($data_file,$id);

                                                            if($update_file) {
                                                                $message = $this->_message1;
                                                            } else {
                                                                $message = $this->_message2;
                                                            }
                                                        }
                                                    } else {
                                                        if($nama_file) {
                                                            $data_file['CD_BY']      = $this->session->userdata('user_name');
                                                            $data_file['CD_DATE']    = date('Y-m-d h:i:s');
                                                            $update_file = $this->coq_model->update_file($data_file,$id);

                                                            if($update_file) {
                                                                $message = $this->_message1;
                                                            } else {
                                                                $message = $this->_message2;
                                                            }
                                                        }
                                                    }

                                                }
                                            }
                                        } else {
                                            $message = $this->_message1;
                                        }

                                    } else {
                                        $message = $this->_message2;
                                    }
                                } else {
                                    $message = $this->_message2;
                                }
                            } else {
                                $message = $this->_message2;
                            }
                        } else {
                            $message = $this->_message2;
                        }
                    }
                } else {
                    $delete_all = $this->coq_model->delete_all($id);
                    if($delete_all) {
                        $save_result = $this->coq_model->insert_batch_result($id,$array4,$resume,$id_mcoq);
                        if($save_result) {
                            $save_sloc   = $this->coq_model->insert_batch_sloc($id,$SLOC);
                            if($save_sloc) {
                                $get_result = $this->coq_model->get_result($id);
                                if($get_result) {
                                    $review['STATUS_REVIEW'] = 2;
                                } else {
                                    $review['STATUS_REVIEW'] = 1;
                                }
                                $update_review = $this->coq_model->update_review($review,$id);
                                if($update_review) {
                                    
                                    if (!empty($_FILES['FILE_UPLOAD']['name'])){
                                        $new_name = preg_replace("/[^a-zA-Z0-9]/", "",$data['NO_REPORT']);
                                        $new_name = $new_name.'_'.date("YmdHis");
                                        $config['file_name'] = $new_name;
                                        $config['upload_path'] = 'assets/upload/kontrak_transportir/';
                                        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                                        $config['max_size'] = 1024 * 4; 

                                        $this->load->library('upload', $config);

                                        if (!$this->upload->do_upload('FILE_UPLOAD')){
                                            $err = $this->upload->display_errors('', '');
                                            $message = array(false, 'Proses gagal', $err, '');
                                        } else {
                                            $res = $this->upload->data();
                                            $nama_file = $res['file_name'];
                                            $data_file['PATH_DOC'] = $nama_file;
                                            if($res) {
                                                $_prod = $this->laccess->post_file_prod('KONTRAKTRANSPORTIR',$nama_file);
                                                if($_prod = '') {
                                                    if($nama_file) {
                                                        $data_file['CD_BY']      = $this->session->userdata('user_name');
                                                        $data_file['CD_DATE']    = date('Y-m-d h:i:s');
                                                        $update_file = $this->coq_model->update_file($data_file,$id);

                                                        if($update_file) {
                                                            $message = $this->_message1;
                                                        } else {
                                                            $message = $this->_message2;
                                                        }
                                                    }
                                                } else {
                                                    if($nama_file) {
                                                        $data_file['CD_BY']      = $this->session->userdata('user_name');
                                                        $data_file['CD_DATE']    = date('Y-m-d h:i:s');
                                                        $update_file = $this->coq_model->update_file($data_file,$id);

                                                        if($update_file) {
                                                            $message = $this->_message1;
                                                        } else {
                                                            $message = $this->_message2;
                                                        }
                                                    }
                                                }

                                            }
                                        }
                                    } else {
                                        $message = $this->_message1;
                                    }

                                } else {
                                    $message = $this->_message2;
                                }
                            } else {
                                $message = $this->_message2;
                            }
                        } else {
                            $message = $this->_message2;
                        }
                    } else {
                        $message = $this->_message2;
                    }
                }
            }
        }

        echo json_encode($message);
                              
    }

    public function get_options_lv1($key = null) {
        $message = $this->coq_model->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv2($key = null) {
        $message = $this->coq_model->options_lv2('--Pilih Level 2--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv3($key = null) {
        $message = $this->coq_model->options_lv3('--Pilih Level 3--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv4($key = null) {
        $message = $this->coq_model->options_lv4('--Pilih Pembangkit--', $key, 0);
        echo json_encode($message);
    }

    public function get_depo_by_pemasok($key = null) {
        $message = $this->coq_model->get_depo_by_pemasok('--Pilih Depo--', $key, 0);
        echo json_encode($message);
    }

    function get_table_by_idversion() {
        extract($_POST);
        $data['trx_id'] = '';
        $list         = $this->coq_model->get_table_by_idversion($bbm,$id_version);
        $result       = (count($list) > 0) ? $list : '';
        $data['list'] = $result;
        $this->load->view($this->_module. '/sertifikat',$data);
    }

    function options_jenis_bahan_bakar() {
        $data = $this->coq_model->options_jenis_bahan_bakar();
        echo json_encode($data);
    }

    function get_pembangkit_by_trxid() {
        extract($_POST);
        $data['id'] = $id;
        $data['form_data']   = $this->verifikasi_coq_model->get_data($id);
        $data['ref']         = $this->verifikasi_coq_model->get_one('*','MASTER_VCOQ','ID_VERSION',$data['form_data']->ID_VERSION);
        $data['NAMA_SURVEYOR'] = $this->coq_model->get_nama($data['form_data']->ID_LEVEL,$data['form_data']->ID_SURVEYOR);
        $data['list'] = $this->coq_model->get_pembangkit_by_trxid($data);
        $data['list2'] = $this->coq_model->get_result_by_trxid($id);
        $this->load->view($this->_module . '/detail_pembangkit', $data);
    }

    function export_excel() {
        header('Content-Type: application/json');
        extract($_POST);
    
        $data['p_cari']    = $xcari;
        $data['p_depo']    = $xdepo;
        $data['p_pemasok'] = $xpemasok;
        $data['p_status']  = $xstatus;
        $data['p_user']    = $this->session->userdata('user_name');
        $data['list']      = $this->coq_model->data($data);
        $data['JENIS']     = 'XLS';
        $this->load->view($this->_module . '/export_excel', $data);
    }

    function export_pdf() {
        extract($_POST);

        $data['p_cari']    = $pcari;
        $data['p_depo']    = $pdepo;
        $data['p_pemasok'] = $ppemasok;
        $data['p_status']  = $pstatus;
        $data['p_user']    = $this->session->userdata('user_name');
        $data['list'] = $this->coq_model->data($data);
        $data['JENIS'] = 'PDF';
        $html_source = $this->load->view($this->_module . '/export_excel', $data, TRUE);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan COQ.pdf');
        $this->lpdf->cetak('A4-L');
    }

    function export_excelpembangkit() {
        extract($_POST);
        header('Content-Type: application/json');
        $data['id'] = $x_id;
        $data['form_data']   = $this->verifikasi_coq_model->get_data($x_id);
        $data['ref']         = $this->verifikasi_coq_model->get_one('*','MASTER_VCOQ','ID_VERSION',$data['form_data']->ID_VERSION);
        $surveyor = $this->coq_model->get_nama($data['form_data']->ID_LEVEL,$data['form_data']->ID_SURVEYOR);
        $data['surveyor']    = $surveyor;
        $data['list'] = $this->coq_model->get_result_by_trxid($x_id);
        $data['list2'] = $this->coq_model->get_pembangkit_by_trxid($data);
        $data['JENIS'] = 'XLS';
        $this->load->view($this->_module . '/export_excelpembangkit', $data);
        
    }

    function export_pdfpembangkit() {
        extract($_POST);
       
        $data['id']          = $p_id;
        $data['form_data']   = $this->verifikasi_coq_model->get_data($p_id);
        $data['ref']         = $this->verifikasi_coq_model->get_one('*','MASTER_VCOQ','ID_VERSION',$data['form_data']->ID_VERSION);
        $surveyor = $this->coq_model->get_nama($data['form_data']->ID_LEVEL,$data['form_data']->ID_SURVEYOR);
        $data['surveyor']    = $surveyor;
        $data['list']        = $this->coq_model->get_result_by_trxid($p_id);
        $data['list2']       = $this->coq_model->get_pembangkit_by_trxid($data);
        $data['JENIS']       = 'PDF';
        $html_source = $this->load->view($this->_module . '/export_excelpembangkit', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan Data Detail COQ.pdf');
        $this->lpdf->cetak('A4-L');
    }

    function export_excelresult() {
        extract($_POST);
        header('Content-Type: application/json');
        $data['list'] = $this->coq_model->get_result_by_trxid($idexcel_result);
        $data['JENIS'] = 'XLS';
        $this->load->view($this->_module . '/export_excelresult', $data);
    }

    function export_pdfresult() {
        extract($_POST);

        $data['list'] = $this->coq_model->get_result_by_trxid($idpdf_result);
        $data['JENIS'] = 'PDF';
        $html_source = $this->load->view($this->_module . '/export_excelresult', $data, TRUE);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan Data Result COQ.pdf');
        $this->lpdf->cetak('A4-L');
    }

    function get_tgl_version() {
        extract($_POST);

        $duplicate = $this->coq_model->isExists2Key($bbm,$report_no);

        if($duplicate) {
            $message = array(FALSE,'Proses Gagal !',"Jenis BBM dan Nomor Referensi sudah terdaftar !");
        } else {
            $list = $this->coq_model->get_tgl_version($tgl,$bbm,$report_no);
            if(empty($list)) {
                $message = array(FALSE,'Proses Gagal !',"Data Tidak Ditemukan !");
            } else {
                $message = $list;
            }
        }

        echo json_encode($message);
    }

    public function delete() {
        
        extract($_POST);
        $delete = $this->coq_model->delete($id);
        if ($delete) {
            $message = array(1, 'Proses Berhasil', 'Proses hapus data berhasil.', '');
        } else {
            $message = array(2, 'Proses gagal', 'Proses hapus data gagal.', '');
        }
        echo json_encode($message);
    }

    public function get_array_sloc() {
        extract($_POST);
        
        $array = $this->coq_model->get_array_sloc($id);
        echo json_encode($array);
    }

    function table_edit() {
        extract($_POST);
        $data['trx_id']          = $id;
        $data['list']            = $this->coq_model->get_result_by_trxid($id);
        $this->load->view($this->_module . '/sertifikat_edit', $data);
    }

    public function proses_kirim() {
        
        extract($_POST);
        $total = count($checkbox);

        $array = array();
        foreach ($checkbox as $key => $value) {
            $nilai = $this->coq_model->get_status_kirim($checkbox[$key]);

            $status = $nilai;
            $data['ID_TRANS'] = $checkbox[$key];
            if($status == 1) {
                $data['STATUS_REVIEW'] = 5;    
            } else {
                $data['STATUS_REVIEW'] = 3;
            }

            $data['TGL_KIRIM']     = date('Y-m-d H:i:s');
            array_push($array,$data);
            
        }

        if($total == 0) {
            $message = array(2, 'Proses gagal', 'Data tidak ada data yang dikirim !.', '');
        } else {
            $update = $this->coq_model->update_batch($array);

            if ($update) {
                $message = array(1, 'Proses Berhasil', 'Data berhasil dikirim.', '');
            } else {
                $message = array(2, 'Proses gagal', 'Data gagal dikirim.', '');
            }
        }
            
        
        echo json_encode($message);
    }

    public function get_options_depo($key=null) {
        $message = $this->coq_model->options_depo('--Pilih Depo--', $key, 0);
        echo json_encode($message);
    }

    public function get_status(){
        extract($_POST);

        $data = $this->coq_model->get_status($p_id);
        echo json_encode((int)$data);
    }

    public function notif() {
        $this->laccess->update_log();
        // Load Modules
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud','format_number'));
        
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        $data['notif'] = 7;

        echo Modules::run("template/admin", $data);
    }

}

