<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Max Pemakaian
 */
class komponen_alpha extends MX_Controller {

    private $_title = 'Master Komponen Alpha (FOB)';
    private $_limit = 10;
    private $_module = 'master/komponen_alpha';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('komponen_alpha_model');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));

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
        $page_title = 'Tambah Komponen Alpha';
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit Komponen Alpha';
            $program = $this->komponen_alpha_model->data($id);
            $data['default'] = $program->get()->row();
        }

        $data['lv4_options'] = $this->komponen_alpha_model->options();
        $data['jnsbbm_options'] = $this->komponen_alpha_model->options_jnsbbm();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function edit_view($id = '') {
        $page_title = 'View Komponen Alpha';
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'View Komponen Alpha';
            $program = $this->komponen_alpha_model->data($id);
            $data['default'] = $program->get()->row();
        }

        $data['lv4_options'] = $this->komponen_alpha_model->options();
        $data['jnsbbm_options'] = $this->komponen_alpha_model->options_jnsbbm();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form_view', $data);
    }

    public function load($page = 1) {
        $data_table = $this->komponen_alpha_model->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_TRANS';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('no' => 'center', 'NO_PERJANJIAN' => 'left', 'TGL_AWAL' => 'center', 'TGL_AKHIR' => 'center','NILAI_KONSTANTA_MFO' => 'right','NILAI_KONSTANTA_HSD' => 'right','FK_MOPS' => 'right','VARIABEL_HITUNG' => 'right', 'PERSEN_HITUNG' => 'right', 'CD_BY' => 'left', 'TGL_INSERT' => 'left', 'UP_BY' => 'left', 'UP_DATE' => 'left', 'IS_AKTIF' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 15;
        $table->header[] = array(
            "NO.", 1, 1,
            'NO. PERJANJIAN', 1,1,
            'TANGGAL AWAL', 1,1,
            'TANGGAL AKHIR', 1,1,
            'NILAI KONSTANTA MFO', 1,1,
            'NILAI KONSTANTA HSD', 1,1,
            "NILAI KALI MOPS", 1, 1,
            "VARIABEL HITUNG", 1, 1,
            "PERSENTASE HITUNG", 1, 1,
            "CREATED BY", 1, 1,
            "CREATED DATE", 1, 1,
            // "UPDATED BY", 1, 1,
            // "UPDATED DATE", 1, 1,
            "AKTIF", 1, 1,
            "AKSI", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function proses() {
        $this->form_validation->set_rules('NO_PERJANJIAN', 'No. Perjanjian', 'trim|required');
        $this->form_validation->set_rules('NILAI_KONSTANTA_MFO', 'Niali Konstanta MFO', 'trim|required');
        $this->form_validation->set_rules('NILAI_KONSTANTA_HSD', 'Nilai Konstanta HSD', 'trim|required');
        // $this->form_validation->set_rules('KOMP', 'Nilai Kali MOPS', 'trim|required');
        $this->form_validation->set_rules('FK_MOPS', 'Nilai Kali MOPS', 'trim|required');
        $this->form_validation->set_rules('VARIABEL_HITUNG', 'Variabel Hitung', 'trim|required');
        $this->form_validation->set_rules('PERSEN_HITUNG', 'Persentase Hitung', 'trim|required');
        $this->form_validation->set_rules('TGL_AWAL', 'Tanggal Awal', 'trim|required');
        $this->form_validation->set_rules('TGL_AKHIR', 'Tanggal Akhir', 'trim|required');
        
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');

            $data = array();
            $data['NO_PERJANJIAN'] = $this->input->post('NO_PERJANJIAN');
            $data['NILAI_KONSTANTA_MFO'] = $this->laccess->setRp($this->input->post('NILAI_KONSTANTA_MFO'));
            $data['NILAI_KONSTANTA_HSD'] = $this->laccess->setRp($this->input->post('NILAI_KONSTANTA_HSD'));
            // $data['KOMP'] = $this->input->post('KOMP');
            $data['FK_MOPS'] = $this->laccess->setRp($this->input->post('FK_MOPS'));
            $data['VARIABEL_HITUNG'] = $this->laccess->setRp($this->input->post('VARIABEL_HITUNG'));
            $data['PERSEN_HITUNG'] = $this->laccess->setRp($this->input->post('PERSEN_HITUNG'));
            $data['TGL_AWAL'] = $this->input->post('TGL_AWAL');
            $data['TGL_AKHIR'] = $this->input->post('TGL_AKHIR');
            $data['IS_AKTIF'] = $this->input->post('IS_AKTIF');

            if ($data['TGL_AWAL'] >= $data['TGL_AKHIR']){
                    $message = array(false, 'Proses gagal', 'Tanggal Akhir tidak boleh sama atau kurang dari Tanggal Awal', '');
            } else if ($this->komponen_alpha_model->cek_tgl_akhir($data['TGL_AWAL']) > 0){
                    $message = array(false, 'Proses gagal', 'Tanggal Awal harus lebih dari Tanggal Akhir yang ada pada sistem GBMO', '');
            } else {
                if ($id == '') {
                    $data['CD_BY'] = $this->session->userdata('user_name');
                    $data['TGL_INSERT'] = date("Y/m/d H:i:s");            
                    if ($this->komponen_alpha_model->save_as_new($data)){
                        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.' , '#content_table');
                    }                                                       
                } else {
                    $data['UP_BY'] = $this->session->userdata('user_name');
                    $data['UP_DATE'] = date("Y/m/d H:i:s");
                    if ($this->komponen_alpha_model->save($data, $id)) {
                        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                    }
                }    
            }
              
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->komponen_alpha_model->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

    public function set_aktif(){
        $get = $this->komponen_alpha_model->set_aktif();
        print_r($get); die;
        // print_r('ok'); die;
    }

    public function set_aktif_komp_alpha(){
        $get = $this->komponen_alpha_model->set_aktif_komp_alpha();
        print_r($get); die;
        // print_r('ok'); die;
    }

}

/* End of file program.php */
/* Location: ./application/modules/program/controllers/program.php */
