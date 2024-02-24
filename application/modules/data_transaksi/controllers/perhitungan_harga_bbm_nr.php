<?php

/**
 * @module TRANSAKSI PERHITUNGAN HARGA
 * @author  CF
 * @created at 10 JULI 2018
 * @modified at 10 JULI 2018
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Wilayah
 */
class perhitungan_harga_bbm_nr extends MX_Controller {

    private $_title = 'HARGA BBM (Non Regular)';
    private $_limit = 10;
    private $_module = 'data_transaksi/perhitungan_harga_bbm_nr';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        $this->_url_movefile = $this->laccess->url_serverfile()."move";
        $this->_urlgetfile = $this->laccess->url_serverfile()."geturl";
        /* Load Global Model */
        $this->load->model('perhitungan_harga_bbm_nr_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");
        $this->asset->set_plugin(array('bootstrap-custom'));
        // $this->asset->set_plugin(array('jquery'));
        
        $data = $this->get_level_user();

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));

        $data['button_group'] = array();
        // if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-exchange"></i> Tabel Harga FOB', array('class' => 'btn green', 'id' => 'button-add', 'onclick' => 'load_pertamina(this.id)', 'data-source' => base_url($this->_module . '/add'))),
                anchor(null, '<i class="icon-exchange"></i> Tabel Harga CIF', array('class' => 'btn green', 'id' => 'button-add-akr-kpm', 'onclick' => 'load_akr_kpm(this.id)', 'data-source' => base_url($this->_module . '/add_akr_kpm')))
            );
        // }

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        $data['data_sources_pencarian'] = base_url($this->_module . '/load_pencarian');
        echo Modules::run("template/admin", $data);
    }

    public function load_pencarian($page = 1) {
        $data_table = $this->tbl_get->data_table_pencarian($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_KONTRAK_PEMASOK';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'PEMASOK' => 'left', 'NOPJBBM_KONTRAK_PEMASOK' => 'left', 'TGL_KONTRAK_PEMASOK' => 'center', 'JUDUL_KONTRAK_PEMASOK' => 'left', 'PERIODE_AWAL_KONTRAK_PEMASOK' => 'center', 'PERIODE_AKHIR_KONTRAK_PEMASOK' => 'center', 'aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 5;
        $table->header[] = array(
            "No", 1, 1,
            "Pemasok", 1, 1,
            "No. PJBBBM", 1, 1,
            // "TGL KONTRAK", 1, 1,
            "Judul Kontrak", 1, 1,
            "Periode Awal", 1, 1,
            "Periode Akhir", 1, 1,
            "Aksi", 1, 1
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function get_level_user(){  
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);
        $data['option_pemasok'] = $this->tbl_get->options_pemasok('--Pilih Pemasok--', '-', 1);
        $data['url_getfile'] = $this->_urlgetfile;

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user, $kode_level);

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
            $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user == 0) {
            if ($kode_level == 00) {
                $data['reg_options'] = $this->tbl_get->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();

        return $data;
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

    public function get_hitung_harga_pertamina_edit() {
        $this->form_validation->set_rules('periode', 'Periode Perhitungan', 'required');

        if ($this->form_validation->run($this)) {
            $vidtrans = $this->input->post('id');
            $periode = $this->input->post('periode');
            
            $record = $this->tbl_get->get_hitung_harga_pertamina_edit($periode);

            if ($record){
                foreach ($record as $row) {
                    $vidtrans = $row->IDTRANS;

                    $data = array('vidtrans' => $row->IDTRANS,
                                  'avg_mid_hsd' => $row->MID_HSD_RATA2,
                                  'avg_mid_mfo' => $row->MID_MFO_RATA2,
                                  'avg_ktbi' => $row->RATA2_KURS,
                                  'alfamid_hsd' => $row->ALPHA_HSD,
                                  'alfamid_mfo' => $row->ALPHA_MFO,
                                  'HargaTanpaPPN_hsd' => $row->HARGA_TANPA_HSD,
                                  'HargaTanpaPPN_mfo' => $row->HARGA_TANPA_MFO,
                                  'HargaTanpaPPN_ido' => $row->HARGA_TANPA_IDO,
                                  'PPN_hsd' => $row->PPN_HSD,
                                  'PPN_mfo' => $row->PPN_MFO,
                                  'PPN_ido' => $row->PPN_IDO,
                                  'HargaDenganPPN_hsd' => $row->HARGA_DENGAN_HSD,
                                  'HargaDenganPPN_mfo' => $row->HARGA_DENGAN_MFO,
                                  'HargaDenganPPN_ido' => $row->HARGA_DENGAN_IDO,
                                  );
                }
                
                $view_form = $this->load->view($this->_module . '/table_pertamina', $data, true);
                $message = array(true, 'Proses Berhasil', 'Proses perhitungan harga berhasil.', '#content_table',$view_form, $vidtrans);
            } else {
                $message = array(false, 'Proses Gagal', 'Data Harga FOB periode '.$periode.' tidak ditemukan', '');    
            }
        } else {
            $message = array(false, 'Proses Gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function get_hitung_harga_edit() {
        $this->form_validation->set_rules('periode', 'Periode Perhitungan', 'required');

        if ($this->form_validation->run($this)) {
            $periode = $this->input->post('periode');

            $id = $vidtrans;
            $data['id'] = $vidtrans;
            $data['list'] = $this->tbl_get->get_hitung_harga_edit($periode);
            $data['stat'] = $this->input->post('stat');          

            if ($data['list']){
                $view_form = $this->load->view($this->_module . '/table_akr_kpm_edit', $data, true);
                $message = array(true, 'Proses Berhasil', 'Proses perhitungan harga berhasil.', '#content_table',$view_form, $vidtrans);
            } else {
                $message = array(false, 'Proses Gagal', 'Data Harga CIF periode '.$periode.' tidak ditemukan', '');
            }
        } else {
            $message = array(false, 'Proses Gagal', validation_errors(), '');
        }

        echo json_encode($message, true);
    }

    public function get_mops_kurs_pertamina_edit(){
        $vidtrans = $this->input->post('vidtrans');
        $data['list'] = $this->tbl_get->get_mops_kurs_edit($vidtrans);
        
        $this->load->view($this->_module . '/list_data', $data);
    }

    public function get_mops_kurs_akr_kpm_edit(){
        $vidtrans = $this->input->post('vidtrans');
        $data['pembangkit'] = $this->input->post('pembangkit');
        $data['nopjbbbm'] = $this->input->post('nopjbbbm');
        $data['list'] = $this->tbl_get->get_mops_kurs_edit($vidtrans);
        $data['var'] = $this->tbl_get->get_akr_kpm($vidtrans);
        $this->load->view($this->_module . '/list_lowmops', $data);
    }
 
}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
