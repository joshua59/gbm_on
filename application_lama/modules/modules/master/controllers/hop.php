<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module master HOP
 */
class hop extends MX_Controller {

    private $_title = 'Master HOP';
    private $_limit = 10;
    private $_module = 'master/hop';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);


        /* Load Global Model */
        $this->load->model('hop_model','tbl_get');
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

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data['id'] = $id;
        $data['id_dok'] = $id;

        if ($id != '') {
            $page_title = 'Edit '.$this->_title;
            $get_data = $this->tbl_get->data($id);
            $data['default'] = $get_data->get()->row();
        }

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function add_view($id = '') {
        $page_title = 'View '.$this->_title;
        $data['id'] = $id;
        $data['id_dok'] = $id;
        $get_data = $this->tbl_get->data($id);
        $data['default'] = $get_data->get()->row();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_view', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_REGIONAL';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'DASAR_HOP' => 'center', 'MERAH' => 'center', 'KUNING' => 'center', 'HIJAU' => 'center', 'BIRU' => 'center', 'TGL_BERLAKU' => 'center', 'KETERANGAN' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 7;
        $table->header[] = array(
            "No", 1, 1,
            "Dasar HOP", 1, 1,
            "Merah", 1, 1,
            "Kuning", 1, 1,
            "Hijau", 1, 1,
            "Biru", 1, 1,
            "Tanggal Mulai Berlaku", 1, 1,
            "Keterangan", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('BASIC_HOP', 'Dasar HOP','trim|required|max_length[30]');
        $this->form_validation->set_rules('FROM_DAY_RED', 'Hari Logo Merah','trim|required|max_length[3]');
        $this->form_validation->set_rules('FROM_DAY_YELLOW', 'Hari Logo Kuning','trim|required|max_length[3]');
        $this->form_validation->set_rules('FROM_DAY_GREEN', 'Hari Logo Hijau','trim|required|max_length[3]');
        $this->form_validation->set_rules('FROM_DAY_BLUE', 'Hari Logo Biru','trim|required|max_length[3]');
        $this->form_validation->set_rules('EFFECTIVE_DATE', 'Tanggal Berlaku','required');
        $this->form_validation->set_rules('DESCRIPTION', 'Keterangan','trim|required|max_length[40]');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['BASIC_HOP'] = $this->input->post('BASIC_HOP');
            $data['FROM_DAY_RED'] = $this->input->post('FROM_DAY_RED');
            $data['FROM_DAY_YELLOW'] = $this->input->post('FROM_DAY_YELLOW');
            $data['FROM_DAY_GREEN'] = $this->input->post('FROM_DAY_GREEN');
            $data['FROM_DAY_BLUE'] = $this->input->post('FROM_DAY_BLUE');
            $data['EFFECTIVE_DATE'] = $this->input->post('EFFECTIVE_DATE');
            $data['DESCRIPTION'] = $this->input->post('DESCRIPTION');
            $data['IS_AKTIF'] = '1';

            // print_r($data); die();

            if ($id == '') {
                $data['CD_HOP'] = date("Y/m/d");
                $data['CD_BY_HOP'] = $this->session->userdata('user_name');
                if ($this->tbl_get->save_as_new($data)) {
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                }
            }else{
                $data['UD_HOP'] = date("Y/m/d");
                $data['UD_BY_HOP'] = $this->session->userdata('user_name');
                if ($this->tbl_get->save($data, $id)) {
                    $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                }
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    // public function delete($id) {
    //     $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

    //     if ($this->tbl_get->delete($id)) {
    //         $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
    //     }
    //     echo json_encode($message);
    // }
}

