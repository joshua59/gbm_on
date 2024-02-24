<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class parameter_analisa extends MX_Controller {

    private $_title = 'Master Parameter Analisa ';
    private $_limit = 10;
    private $_module = 'master/parameter_analisa';

    public function __construct() {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        $this->load->model('parameter_analisa_model','tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        $this->asset->set_plugin(array('crud','format_number'));
        $data['page_title']         = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content']       = $this->_module . '/main';
        $data['data_sources']       = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function filter() {

        $data['button_group'] = array();
        $data['options_parameter']    = $this->tbl_get->options_parameter();
        // if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'add()'))
            );
        // }
        
        $this->load->view($this->_module . '/filter',$data);
    }

  
    public function load() {
        extract($_POST);

        $data['p_idparam'] = $p_idparam;
        $data['p_cari']    = $p_cari;

        $list   = $this->tbl_get->data($data);
        $data['list']  = $list->result_array();

        $this->load->view($this->_module . '/table',$data);

    }

    function add() {

        $data['page_title']  = 'Tambah Data Master Parameter Analisa';
        $data['form_action'] = base_url($this->_module . '/save');
        $this->load->view($this->_module . '/form',$data);
    }

    function add_detail() {

        extract($_POST);
        $data['id'] = $id;
        $data['page_title']  = 'Tambah Data Nilai Parameter Analisa';
        $data['form_action'] = base_url($this->_module . '/save_batch');
        $this->load->view($this->_module . '/add_form',$data);
    }

    function edit() {
        extract($_POST);
        $data['id'] = $id;
        $data['page_title']     = 'Ubah Data Master Parameter Analisa';
        $data['PRMETER_MCOQ'] = $this->tbl_get->options_parameter_edit();
        $data['default']        = $this->tbl_get->data_edit($id);
        $data['form_action']    = base_url($this->_module . '/update');
        $this->load->view($this->_module . '/form_edit',$data);
    }

     function edit_detail() {
        extract($_POST);
        $data['id'] = $id;
        $data['page_title']     = 'Ubah Data Master Nilai Parameter Analisa';
        $data['default']        = $this->tbl_get->data_edit_detail($id);
        $data['form_action']    = base_url($this->_module . '/update_nilai');
        $this->load->view($this->_module . '/edit_detail',$data);
    }

    function view_detail() {
        extract($_POST);
        $data['id'] = $id;
        $data['list'] = $this->tbl_get->get_detail($id);
        $this->load->view($this->_module . '/detail',$data);
    }

    function save() {
        extract($_POST);

        $this->form_validation->set_rules('PARAMETER_ANALISA', 'Parameter Analisa', 'required');
        $this->form_validation->set_rules('TIPE', 'Tipe Parameter Analisa', 'required|max_length[50]');

        $array = array();

        $data['PARAMETER_ANALISA'] = $PARAMETER_ANALISA;
        $data['TIPE']              = $TIPE;
        $data['CD_BY']             = $this->session->userdata('user_name');
        $data['CD_DATE']           = date("Y-m-d H:i:s");

        if($TIPE == 1) {

            if ($this->form_validation->run($this)) {
                $save = $this->tbl_get->save($data,$TIPE);
                if($save) {
                    $message = array(true,'Berhasil !','Data Berhasil ditambah !');
                } else {
                    $message = array(false,'Gagal !','Data gagal ditambah !');
                }
            } else {
                $message = array(false, 'Proses gagal', validation_errors(), '');
            }
        } else {

            $this->form_validation->set_rules('NAMA_NILAI[]', 'Nama Nilai Parameter', 'required');
            $this->form_validation->set_rules('STATUS[]', 'Status Uji Parameter', 'required');

            $id = $this->tbl_get->save($data,$TIPE);
            if ($this->form_validation->run($this)) {
                $simpan  = $this->tbl_get->insert_batch($id,$NAMA_NILAI,$STATUS);
                if($simpan) {
                    $message = array(true,'Berhasil !','Data Berhasil ditambah !');
                } else {
                    $message = array(false,'Gagal !','Data gagal ditambah !');
                }
            } else {
                $message = array(false, 'Proses gagal', validation_errors(), '');
            }  
        }

        echo json_encode($message);
        
    }

    function save_batch() {
        extract($_POST);
        $this->form_validation->set_rules('NAMA_NILAI[]', 'Nama Nilai Parameter', 'required');
        $this->form_validation->set_rules('STATUS[]', 'Status Uji Parameter', 'required');

        if ($this->form_validation->run($this)) {
            $simpan  = $this->tbl_get->insert_batch($id,$NAMA_NILAI,$STATUS);
            if($simpan) {
                $message = array(true,'Berhasil !','Data Berhasil ditambah !');
            } else {
                $message = array(false,'Gagal !','Data gagal ditambah !');
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }  

        echo json_encode($message);
    }

    function update() {
        extract($_POST);

        $data['PARAMETER_ANALISA'] = $PARAMETER_ANALISA;
        $data['TIPE']              = $TIPE;
        $data['UD_BY']             = $this->session->userdata('user_name');
        $data['UD_DATE']           = date("Y-m-d H:i:s"); 
        $update = $this->tbl_get->edit($data,$id);

        if($update) {
            $message = array(true,'Berhasil !','Data Berhasil Diubah !');
        } else {
            $message = array(false,'Proses Gagal !','Data Gagal Diubah !');
        }

        echo json_encode($message);
    }

    function update_nilai() {
        extract($_POST);

        $data['NAMA_NILAI']        = $NAMA_NILAI;
        $data['STATUS']            = $STATUS;
        $data['UD_BY']             = $this->session->userdata('user_name');
        $data['UD_DATE']           = date("Y-m-d H:i:s"); 
        $update = $this->tbl_get->edit_detail($data,$id);

        if($update) {
            $message = array(true,'Berhasil !','Data Berhasil Diubah !');
        } else {
            $message = array(false,'Proses Gagal !','Data Gagal Diubah !');
        }

        echo json_encode($message);
    }

    public function export_excel() {
        extract($_POST);

        $data['p_jnsbbm']   = $x_jnsbbm;
        $data['p_ref_lv1']  = $x_ref_lv1;
        $data['p_ref_lv2']  = $x_ref_lv2;
        $data['p_tgl']      = $x_tgl;
        $data['p_tgakhir']  = $x_tglakhir;
        $data['p_cari']     = $x_cari;
        $data['p_namabbm']  = $x_namabbm;
        $data['list']       = $this->tbl_get->export_data($data);
        $data['JENIS']      = 'XLS';

        $this->load->view($this->_module . '/export_excel',$data);
    }

    public function export_pdf() {
        extract($_POST);

        $data['p_jnsbbm']   = $pdf_jnsbbm;
        $data['p_ref_lv1']  = $pdf_ref_lv1;
        $data['p_ref_lv2']  = $pdf_ref_lv2;
        $data['p_tgl']      = $pdf_tgl;
        $data['p_tgakhirl'] = $pdf_tglakhir;
        $data['p_cari']     = $pdf_cari;
        $data['p_namabbm']  = $pdf_namabbm;
        $data['list']       = $this->tbl_get->export_data($data);
        $data['JENIS']      = 'PDF';

        $html_source        = $this->load->view($this->_module . '/export_excel', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('MASTER STANDAR MUTU.pdf');
        $this->lpdf->cetak('A4-L');
    }

    public function delete() {
        extract($_POST);
        
        if ($this->tbl_get->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Data berhasil di nonaktifkan !', '#content_table');
        } else {
            $message = array(false, 'Proses gagal', 'Data gagal di nonaktifkan !', '');
        }
        echo json_encode($message);
    }

    public function delete_detail() {
        extract($_POST);
        if ($this->tbl_get->delete_detail($id)) {
            $message = array(true, 'Proses Berhasil', 'Data berhasil di nonaktifkan !', '#content_table');
        } else {
            $message = array(false, 'Proses gagal', 'Data gagal di nonaktifkan !', '');
        }
        echo json_encode($message);
    }

}
