<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class coq_versioning extends MX_Controller {

    private $_title = 'Master Versioning Standar Mutu';
    private $_limit = 10;
    private $_module = 'master/coq_versioning';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        /* Load Global Model */
        $this->load->model('coq_versioning_model','tbl_get');
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
        
        $data['options_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data['id'] = $id;
        $data['options_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        if ($id != '') {
            $page_title = 'Edit '.$this->_title;
            $data['default'] = $this->tbl_get->data_edit($id);
        }
        
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        extract($_POST);
        $this->add($id);
    }

    public function load() {
        extract($_POST);
        $data['p_jnsbbm'] = $p_jnsbbm;
        $data['p_tglawal'] = $p_tglawal;
        $data['p_tglakhir'] = $p_tglakhir;
        $data['p_cari'] = $p_cari;
        
        $list = $this->tbl_get->data($data);
        $arr = $list->result_array();
        $count = count($arr);
        $data = array();
        $no = $_POST['start'];

        foreach ($list->result() as $table) {
            $no++;
            $id = $table->ID_VERSION;
            $row = array();
            $aksi = '';  
            $STATUS = ($table->STATUS == 0) ? 'Tidak Aktif' : 'Aktif';
            if ($this->laccess->otoritas('edit')) {
                $aksi .= anchor(null, '<i class="icon-edit"></i>', array('class' => 'btn transparant', 'id' => 'button-edit-' . $id, 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/edit/' . $id)));
            }
            if ($this->laccess->otoritas('delete')) {
                $aksi .= anchor(null, '<i class="icon-trash"></i>', array('class' => 'btn transparant', 'id' => 'button-delete-' . $id, 'onclick' => 'row_delete('.$id.');', 'data-source' => base_url($this->_module . '/delete/' . $id)));
            }

            $row[] = $no;
            $row[] = $table->NAMA_JNS_BHN_BKR;
            $row[] = $table->NO_VERSION;
            $row[] = $table->TGL_VERSION;
            $row[] = $table->DITETAPKAN;
            $row[] = $table->PIC;
            $row[] = $STATUS;
            $row[] = $aksi;

            $data[] = $row;
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $list->num_rows(), //"10",  //$this->tbl_get->count_all(),
                        "recordsFiltered" => $count,  //$this->tbl_get->count_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
    }

    public function proses() {
        $this->form_validation->set_rules('ID_JNS_BHN_BKR', 'Jenis Bahan Bakar','required');
        $this->form_validation->set_rules('NO_VERSION', 'Nomor Versioning','trim|required|max_length[50]');
        $this->form_validation->set_rules('TGL_VERSION', 'Tanggal Versioning', 'required');
        $this->form_validation->set_rules('DITETAPKAN', 'Ditetapkan Oleh','trim|required|max_length[50]');
        $this->form_validation->set_rules('PIC', 'Pejabat Terkait','trim|required|max_length[50]');
        
        if ($this->form_validation->run($this)) {
            if($this->input->post('ID_JNS_BHN_BKR') == 301 || $this->input->post('ID_JNS_BHN_BKR') == 302 || $this->input->post('ID_JNS_BHN_BKR') == 303 || $this->input->post('ID_JNS_BHN_BKR') == 304) {
                $JNS_BBM = '004';
                $KODE_JNS_BHN_BKR = $this->input->post('ID_JNS_BHN_BKR');
            } else {
                $JNS_BBM = $this->input->post('ID_JNS_BHN_BKR');
                $KODE_JNS_BHN_BKR = null;
            }    
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            $id = $this->input->post('id');
            $data['ID_JNS_BHN_BKR']   = $JNS_BBM;
            $data['KODE_JNS_BHN_BKR'] = $KODE_JNS_BHN_BKR;
            $data['NO_VERSION']       = $this->input->post('NO_VERSION');
            $data['TGL_VERSION']      = $this->input->post('TGL_VERSION');
            $data['DITETAPKAN']       = $this->input->post('DITETAPKAN');
            $data['PIC']              = $this->input->post('PIC');
            $data['STATUS']           = $this->input->post('STATUS');
            $data['CD_BY']            = $this->session->userdata('user_name');
            $data['CD_TIME']          = date("Y/m/d H:i:s");  

            if ($id == '') {
            
                if ($this->tbl_get->save_as_new($data)) {
                    $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                } else {
                    $message = array(false, 'Proses Gagal', 'Proses penyimpanan data gagal.', '#content_table');
                }
                
            }else if($id != ''){

                $default = $this->tbl_get->data_edit($id);

                    $data['UD_TIME'] = date("Y/m/d H:i:s");  
                    $data['UD_BY']   = $this->session->userdata('user_name');          
                    if ($this->tbl_get->save($data, $id)) {
                        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table'); 
                    }
            } else {
                $message = array(false, 'Proses Gagal', 'Proses penyimpanan data gagal.', '#content_table');
            } 
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function delete($id) {
        extract($_POST);
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

    public function export_excel() {
        extract($_POST);

        $data['p_jnsbbm']    = $x_jnsbbm;
        $data['p_tglawal']   = $x_tglawal;
        $data['p_tglakhir']  = $x_tglakhir;
        $data['p_cari']      = $x_cari;
        $data['list']        = $this->tbl_get->export_data($data);
        $data['JENIS']       = 'XLS';
        
        $this->load->view($this->_module . '/export_excel',$data);
    }

    public function export_pdf() {
        extract($_POST);

        $data['p_jnsbbm']    = $pdf_jnsbbm;
        $data['p_tglawal']   = $pdf_tglawal;
        $data['p_tglakhir']  = $pdf_tglakhir;
        $data['p_cari']      = $pdf_cari;
        $data['list']        = $this->tbl_get->export_data($data);
        $data['JENIS']       = 'PDF';

        $html_source         = $this->load->view($this->_module . '/export_excel', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('MASTER_STANDAR_MUTU_VERSIONING.pdf');
        $this->lpdf->cetak('A4-L');
    }

}

/* End of file master_level1.php */
/* Location: ./application/modules/wilayah/controllers/master_level1.php */
