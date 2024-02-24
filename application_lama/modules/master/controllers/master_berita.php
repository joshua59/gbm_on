<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module master
 */
class master_berita extends MX_Controller {

    private $_title = 'Master Berita';
    private $_limit = 10;
    private $_module = 'master/master_berita';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);


        /* Load Global Model */
        $this->load->model('master_berita_model','tbl_get');
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
        $data['default'] = $this->tbl_get->get_max();
        $data['default']->JEDA = '&#9830;'; 

        if ($id != '') {
            $page_title = 'Edit '.$this->_title;
            $get_data = $this->tbl_get->data($id);
            $data['default'] = $get_data->get()->row();
        }
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
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
        $table->align = array('NO' => 'center', 'JEDA' => 'center', 'KETERANGAN' => 'left', 'URUTAN' => 'center', 'POSTING' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 4;
        $table->header[] = array(
            "No", 1, 1,
            // "Jeda", 1, 1,
            "Keterangan", 1, 1,
            "Urutan", 1, 1,
            "Posting", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('KETERANGAN', 'Keterangan','trim|required|max_length[2000]');
        $this->form_validation->set_rules('URUTAN', 'Urutan ', 'trim|required|is_natural|max_length[4]');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['JEDA'] = $this->input->post('JEDA');
            $data['KETERANGAN'] = $this->input->post('KETERANGAN');
            $data['URUTAN'] = $this->input->post('URUTAN');
            $data['POSTING'] = $this->input->post('POSTING');

            if ($id == '') {
                $data['CD_DATE'] = date("Y/m/d");
                $data['CD_BY'] = $this->session->userdata('user_name');
                if ($this->tbl_get->save_as_new($data)) {
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                }
            }else{
                $data['UP_DATE'] = date("Y/m/d");
                $data['UP_BY'] = $this->session->userdata('user_name');
                if ($this->tbl_get->save($data, $id)) {
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

        if ($this->tbl_get->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }
}

/* End of file master_berita.php */
/* Location: ./application/modules/wilayah/controllers/master_berita.php */
