<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module dashboard
 */
class setting_app extends MX_Controller {

    private $_title = 'Setting App';
    private $_limit = 10;
    private $_module = 'dashboard/setting_app';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        $this->_url_movefile = $this->laccess->url_serverfile()."move";
        $this->_urlgetfile = $this->laccess->url_serverfile()."geturl";

        /* Load Global Model */
        $this->load->model('setting_app_model','tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add')))
            );
        }

        $data["url_getfile"] = $this->_urlgetfile;
        $data['default'] = $this->tbl_get->data_upload();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        $data['form_action'] = base_url($this->_module . '/proses');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah FAQ';
        $data['id'] = $id;
        $data['default'] = $this->tbl_get->get_max();

        if ($id != '') {
            $page_title = 'Edit FAQ';
            $get_data = $this->tbl_get->data($id);
            $data['default'] = $get_data->get()->row();
        }
        // $data['reg_options'] = $this->tbl_get->options_reg();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action_faq'] = base_url($this->_module . '/proses_faq');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'JUDUL' => 'left', 'KETERANGAN' => 'left', 'URUTAN' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "No", 1, 1,
            "Pertanyaan", 1, 1,
            "Jawaban", 1, 1,
            "Urutan", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $ada = false;
        $PATH_KICKOFF='';
        $PATH_PELATIHAN='';
        $PATH_MANUAL_BOOK='';
        $PATH_SOP='';

        if (!empty($_FILES['PATH_KICKOFF']['name'])){
            $ada = true;    
        } else if (!empty($_FILES['PATH_PELATIHAN']['name'])){
            $ada = true;    
        } else if (!empty($_FILES['PATH_MANUAL_BOOK']['name'])){
            $ada = true;    
        } else if (!empty($_FILES['PATH_SOP']['name'])){
            $ada = true;    
        } else if (!empty($_FILES['PATH_CUTOFF']['name'])){
            $ada = true;    
        }

        if ($ada){
            $pesan_berhasil='';
            $pesan_gagal='';
            $data = array();

            //upload PATH_KICKOFF
            if (!empty($_FILES['PATH_KICKOFF']['name'])){
                $new_name = 'Materi_Kickoff_GBMO';
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload/permintaan/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 10; 
                // $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
                // $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                $target='assets/upload/permintaan/'.$this->input->post('PATH_KICKOFF_EDIT');

                if(file_exists($target)){
                    unlink($target);
                }

                if (!$this->upload->do_upload('PATH_KICKOFF')){
                    $err = $this->upload->display_errors('', '');
                    $message = array(false, 'Proses gagal', $err, '');
                    $pesan_gagal .= '- Upload Kickoff ('.$err.')<br>'; 
                } else {
                    $res = $this->upload->data();
                    if ($res){
                        $data['PATH_KICKOFF'] = $res['file_name'];
                        $pesan_berhasil .= '- Upload Kickoff<br>'; 

                        $nama_file = $res['file_name'];
                        $_prod = $this->laccess->post_file_prod('MINTA',$nama_file);
                    }
                }
            }

            //upload PATH_PELATIHAN
            if (!empty($_FILES['PATH_PELATIHAN']['name'])){
                $new_name = 'Materi_Pelatihan_GBMO';
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload/permintaan/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 10; 
                // $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
                // $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                $target='assets/upload/permintaan/'.$this->input->post('PATH_PELATIHAN_EDIT');

                if(file_exists($target)){
                    unlink($target);
                }

                if (!$this->upload->do_upload('PATH_PELATIHAN')){
                    $err = $this->upload->display_errors('', '');
                    $message = array(false, 'Proses gagal', $err, '');
                    $pesan_gagal .= '- Upload Pelatihan ('.$err.')<br>'; 
                } else {
                    $res = $this->upload->data();
                    if ($res){
                        $data['PATH_PELATIHAN'] = $res['file_name'];
                        $pesan_berhasil .= '- Upload Pelatihan<br>'; 

                        $nama_file = $res['file_name'];
                        $_prod = $this->laccess->post_file_prod('MINTA',$nama_file);
                    }
                }
            }

            //upload PATH_MANUAL_BOOK
            if (!empty($_FILES['PATH_MANUAL_BOOK']['name'])){
                $new_name = 'Manual_Book_GBMO';
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload/permintaan/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 10; 
                // $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
                // $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                $target='assets/upload/permintaan/'.$this->input->post('PATH_MANUAL_BOOK_EDIT');

                if(file_exists($target)){
                    unlink($target);
                }

                if (!$this->upload->do_upload('PATH_MANUAL_BOOK')){
                    $err = $this->upload->display_errors('', '');
                    $message = array(false, 'Proses gagal', $err, '');
                    $pesan_gagal .= '- Upload Manual Book ('.$err.')<br>'; 
                } else {
                    $res = $this->upload->data();
                    if ($res){
                        $data['PATH_MANUAL_BOOK'] = $res['file_name'];
                        $pesan_berhasil .= '- Upload Manual Book<br>'; 

                        $nama_file = $res['file_name'];
                        $_prod = $this->laccess->post_file_prod('MINTA',$nama_file);
                    }
                }
            }

            //upload PATH_SOP
            if (!empty($_FILES['PATH_SOP']['name'])){
                $new_name = 'SOP_Aplikasi_GBMO';
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload/permintaan/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = 1024 * 10; 
                // $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
                // $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                $target='assets/upload/permintaan/'.$this->input->post('PATH_SOP_EDIT');

                if(file_exists($target)){
                    unlink($target);
                }

                if (!$this->upload->do_upload('PATH_SOP')){
                    $err = $this->upload->display_errors('', '');
                    $message = array(false, 'Proses gagal', $err, '');
                    $pesan_gagal .= '- Upload SOP ('.$err.')<br>'; 
                } else {
                    $res = $this->upload->data();
                    if ($res){
                        $data['PATH_SOP'] = $res['file_name'];
                        $pesan_berhasil .= '- Upload SOP<br>'; 

                        $nama_file = $res['file_name'];
                        $_prod = $this->laccess->post_file_prod('MINTA',$nama_file);
                    }
                }
            }

            //upload PATH_CUTOFF
            if (!empty($_FILES['PATH_CUTOFF']['name'])){
                $new_name = 'Template_Data_Cutoff';
                $config['file_name'] = $new_name;
                $config['upload_path'] = 'assets/upload/permintaan/';
                $config['allowed_types'] = 'jpg|jpeg|png|pdf|xlsx|xls';
                $config['max_size'] = 1024 * 10; 
                // $config['permitted_uri_chars'] = 'a-z 0-9~%.:&_\-'; 
                // $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                $target='assets/upload/permintaan/'.$this->input->post('PATH_CUTOFF_EDIT');

                if(file_exists($target)){
                    unlink($target);
                }

                if (!$this->upload->do_upload('PATH_CUTOFF')){
                    $err = $this->upload->display_errors('', '');
                    $message = array(false, 'Proses gagal', $err, '');
                    $pesan_gagal .= '- Upload Cutoff ('.$err.')<br>'; 
                } else {
                    $res = $this->upload->data();
                    if ($res){
                        $data['PATH_CUTOFF'] = $res['file_name'];
                        $pesan_berhasil .= '- Upload Cutoff<br>'; 

                        $nama_file = $res['file_name'];
                        $_prod = $this->laccess->post_file_prod('MINTA',$nama_file);
                    }
                }
            }
            
            $data['ID'] = '1';
            $this->tbl_get->save($data, '1');

            $pesan = '';
            if ($pesan_berhasil){
                $pesan .='Proses update file berhasil.<br>'.$pesan_berhasil; 
            }
            if ($pesan_gagal){
                $pesan .='<br>Proses update file gagal.<br>'.$pesan_gagal; 
            }

            $message = array(true, 'Proses Berhasil', $pesan, '#content_table');
        } else {
            $message = array(false, 'Proses gagal', 'Silahkan pilih file yang akan di upload', '');   
        }
        
        echo json_encode($message, true);
    }

    public function proses_faq() {
        $this->form_validation->set_rules('JUDUL', 'Pertanyaan', 'trim|required|max_length[100]');
        $this->form_validation->set_rules('KETERANGAN', 'Jawaban', 'trim|required|max_length[2000]');
        $this->form_validation->set_rules('URUTAN', 'Urutan ke', 'trim|required|numeric');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['JUDUL'] = $this->input->post('JUDUL');
            $data['KETERANGAN'] = $this->input->post('KETERANGAN');
            $data['URUTAN'] = $this->input->post('URUTAN');

            if ($id == '') {
                $data['CD_DATE'] = date("Y/m/d");
                $data['CD_BY'] = $this->session->userdata('user_name');
                if ($this->tbl_get->save_as_new_faq($data)) {
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                }
            } else {
                $data['UP_DATE'] = date("Y/m/d");
                $data['UP_BY'] = $this->session->userdata('user_name');
                if ($this->tbl_get->save_faq($data, $id)) {
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                }
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get->delete_faq($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }
}

/* End of file setting_app.php */
/* Location: ./application/modules/dashboard/controllers/setting_app.php */
