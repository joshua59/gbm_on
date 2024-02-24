<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class coq extends MX_Controller {

    private $_title = 'Master Standar Mutu BBM ';
    private $_limit = 10;
    private $_module = 'master/coq';

    public function __construct() {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        $this->load->model('coq_model','tbl_get');
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
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'add()'))
            );
        }
        $data['options_bbm']        = $this->tbl_get->options_jenis_bahan_bakar();
        $data['options_ref_lv1']    = $this->tbl_get->options_ref_lv1();
        $data['options_ref_lv2']    = $this->tbl_get->options_ref_lv2();
        
        $this->load->view($this->_module . '/filter',$data);
    }

  
    public function load() {
        extract($_POST);
        $data['p_jnsbbm']   = $p_jnsbbm;
        $data['p_ref_lv1']  = $p_ref_lv1;
        $data['p_ref_lv2']  = $p_ref_lv2;
        $data['p_tgl']      = $p_tgl;
        $data['p_tgakhirl'] = $p_tglakhir;
        $data['p_cari']     = $p_cari;
        
        $list   = $this->tbl_get->data($data);
        $arr    = $list->result_array();
        $count  = count($arr);
        $data   = array();
        $no     = $_POST['start'];
        $aksi   = '';
        foreach ($list->result() as $table) {
            $no++;
            $id     = $table->ID_MCOQ;
            $row    = array();
            $aksi   = '';  

            $row[]  = $no;
            $row[]  = $table->PARAMETER_ANALISA;
            $row[]  = $table->SATUAN;
            $row[]  = $table->METODE;
            $row[]  = number_format($table->BATAS_MIN,3,',','.');
            $row[]  = number_format($table->BATAS_MAX,3,',','.');
            $row[]  = $table->NAMA_JNS_BHN_BKR;
            $row[]  = $table->DITETAPKAN;
            $row[]  = $table->NO_VERSION;
            $row[]  = $table->TGL_VERSION;
            if ($this->laccess->otoritas('edit')) {
                $aksi.= anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant','onclick' => 'edit('.$id.')'));
            }
            if ($this->laccess->otoritas('delete')) {
                $aksi.= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant','onclick' => 'row_delete('.$id.')'));
            }
            $row[]  = $aksi;

            $data[] = $row;
        }

        $output = array(
            "draw"              => $_POST['draw'],
            "recordsTotal"      => $list->num_rows(), //"10",  //$this->tbl_get->count_all(),
            "recordsFiltered"   => $count,  //$this->tbl_get->count_filtered(),
            "data"              => $data,
        );
        echo json_encode($output);
    }

    function add() {

        $data['page_title']  = 'Tambah Data Master Standar Mutu BBM';
        $data['PRMETER_MCOQ'] = $this->tbl_get->options_parameter();
        $data['SATUAN']      = $this->tbl_get->options_satuan();
        $data['VERSION']     = $this->tbl_get->options_version();
        $data['form_action'] = base_url($this->_module . '/save');
        $this->load->view($this->_module . '/form',$data);
    }

    function edit() {
        extract($_POST);
        $data['id'] = $id;
        $data['page_title']     = 'Ubah Data Master Standar Mutu BBM';
        $data['PRMETER_MCOQ']   = $this->tbl_get->options_parameter_edit();
        $data['options_satuan'] = $this->tbl_get->options_satuan_edit();
        $data['default']        = $this->tbl_get->data_edit($id);
        $data['form_action']    = base_url($this->_module . '/update');
        $this->load->view($this->_module . '/form_edit',$data);
    }

    function save() {
        extract($_POST);

        $array = array();
        $data  = array();
        
        $this->form_validation->set_rules('ID_VERSION', 'Nomor Version', 'required');
        $this->form_validation->set_rules('PRMETER_MCOQ[]', 'Parameter Analisa', 'required|max_length[50]');
        $this->form_validation->set_rules('SATUAN[]', 'Jenis Satuan', 'required');
        $this->form_validation->set_rules('METODE[]', 'Metode Uji', 'required');
        
        if ($this->form_validation->run($this)) {
            foreach ($PRMETER_MCOQ as $key => $value) {
                
                $MIN_V = ($BATAS_MIN[$key] == '') ? '-' : $BATAS_MIN[$key];
                $MAX_V = ($BATAS_MAX[$key] == '') ? '-' : $BATAS_MAX[$key];
                $array['PRMETER_MCOQ']     = $value;
                $array['SATUAN']           = $SATUAN[$key];
                $array['METODE']           = $METODE[$key];
                $array['BATAS_MIN']        = $MIN_V;
                $array['BATAS_MAX']        = $MAX_V;
                $array['ID_VERSION']       = $ID_VERSION;
                $array['ID_JNS_BHN_BKR']   = $ID_JNS_BHN_BKR;
                $array['ID_KOMPONEN_BBM']  = $KODE_JNS_BHN_BKR;
                $array['CD_BY']            = $this->session->userdata('user_name');
                $array['CD_DATE']          = date('Y-m-d H:i:s');
                $array['IS_AKTIF']         = 1;
                array_push($data,$array);
            }

            $save = $this->tbl_get->save($data);

            if($save) {
                $message = array(true,'Proses berhasil !','Data Berhasil ditambah !');
            } else {
                $message = array(false,'Proses gagal !','Data gagal ditambah !');
            }
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        
        echo json_encode($message);
        
    }

    function update() {
        extract($_POST);

        $MIN_V = ($BATAS_MIN == '') ? '-' : $BATAS_MIN;
        $MAX_V = ($BATAS_MAX == '') ? '-' : $BATAS_MAX;
        $array['PRMETER_MCOQ']     = $PRMETER_MCOQ;
        $array['SATUAN']           = $SATUAN;
        $array['METODE']           = $METODE;
        $array['BATAS_MIN']        = $MIN_V;
        $array['BATAS_MAX']        = $MAX_V;
        $update = $this->tbl_get->edit($array,$id);
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

    public function get_detail_version(){
        extract($_POST);

        $data = $this->tbl_get->get_detail_version($id);
        echo json_encode($data);
    }

    public function delete($id) {
        extract($_POST);
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }


}
