<?php

/**
 * @module MASTER TRANSPORTIR
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module Master Wilayah
 */
class kontrak_transportir extends MX_Controller {

    private $_title = 'KONTRAK TRANSPORTIR';
    private $_limit = 10;
    private $_module = 'laporan/kontrak_transportir';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        $this->_url_movefile = $this->laccess->url_serverfile()."move";
        $this->_urlgetfile = $this->laccess->url_serverfile()."geturl";
        /* Load Global Model */
        $this->load->model('kontrak_transportir_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");
        $this->asset->set_plugin(array('bootstrap-custom'));
        
        $data = $this->get_level_user();

        $this->asset->set_plugin(array('crud', 'format_number'));

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    // Kontrak Awal

    function loadKontrakAwal() {
        $data = $this->get_level_user();
        $data['page_title'] = '<i class="icon-laptop"></i> Laporan Kontrak Transportir ';
        $this->load->view($this->_module . '/view_kontrakawal',$data);
    }

    function loadKontrakAkhir() {
        $data = $this->get_level_user();
        $data['page_title'] = '<i class="icon-laptop"></i> Laporan Kontrak Transportir Adendum ';
        $this->load->view($this->_module . '/view_kontrakakhir',$data);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_PERHITUNGAN';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('NO' => 'center', 'NAMA_REGIONAL' => 'left', 'LEVEL1' => 'left', 'LEVEL2' => 'left', 'LEVEL3' => 'left', 'LEVEL4' => 'left', 'NAMA_TRANSPORTIR' => 'left', 'KD_KONTRAK_TRANS' => 'center', 'TGL_KONTRAK_TRANS' => 'center', 'TGL_KONTRAK_TRANS_AKHIR' => 'center', 'NAMA_DEPO' => 'left', 'NAME_SETTING' => 'center', 'JARAK_DET_KONTRAK_TRANS' => 'right', 'HARGA_KONTRAK_TRANS' => 'right');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 14;
        $table->header[] = array(
            "NO", 1, 1,
            "REGIONAL", 1, 1,
            "LEVEL1", 1, 1,
            "LEVEL2", 1, 1,
            "LEVEL3", 1, 1,
            "PEMBANGKIT", 1, 1,
            "TRANSPORTIR", 1, 1,
            "NO KONTRAK", 1, 1,
            "TGL AWAL KONTRAK", 1, 1,
            "TGL AKHIR KONTRAK", 1, 1,
            "DEPO", 1, 1,
            "JALUR", 1, 1,
            "JARAK (KM/ML)", 1, 1,
            "HARGA (RP/L)", 1, 1
        );

        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function ajax_list() {

        $value = array(
            'p_unit' => $this->input->post('p_unit'),
            'p_transportir' => $this->input->post('p_transportir'),
            'p_tglawal' => $this->input->post('p_tglawal'),
            'p_tglakhir' => $this->input->post('p_tglakhir'),
            'p_cari' => $this->input->post('p_cari'),
            'status_kontrak' => $this->input->post('status_kontrak'),
        );
        
        $list = $this->tbl_get->get_datatables($value);
        echo json_encode($list);
    }

    public function ajax_list_adendum() {

        $value = array(
            'p_unit' => $this->input->post('p_unit'),
            'p_transportir' => $this->input->post('p_transportir'),
            'p_tglawal' => $this->input->post('p_tglawal'),
            'p_tglakhir' => $this->input->post('p_tglakhir'),
            'p_cari' => $this->input->post('p_cari'),
            'status_kontrak' => $this->input->post('status_kontrak'),
        );

        $list = $this->tbl_get->get_datatables_adendum($value);
        echo json_encode($list);

    }   

    public function get_level_user(){
        $data['status_options'] = $this->tbl_get->options_status();
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);
        // $data['option_pemasok'] = $this->tbl_get->options_pemasok('--Pilih Pemasok--', '-', 1);
        $data['options_transportir'] = $this->tbl_get->options_transportir('--Pilih Transportir--', '-', 1);

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
        $data['opsi_status_kontrak'] = $this->tbl_get->options_status_kontrak(); 

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

    public function export_tes(){
        $data['data'] = $this->tbl_get->data_export();
        print_r($data); die;
    }

    public function export_excel(){
        if($this->input->post('xtglawal') == ''){
            $tgl_awal = '';
        } else {
            $tgl_awal = $this->convert_date($this->input->post('xtglawal'));
        }
        
        if($this->input->post('xtglakhir') == ''){
            $tgl_akhir = '';
        } else {
            $tgl_akhir = $this->convert_date($this->input->post('xtglakhir'));
        }
        
        $data['TGL_DARI'] = $tgl_awal;
        $data['TGL_SAMPAI'] = $tgl_akhir;

        $data['ID_REGIONAL'] = $this->input->post('xlvl0');
        $data['COCODE'] = $this->input->post('xlvl1');
        $data['PLANT'] = $this->input->post('xlvl2');
        $data['STORE_SLOC'] = $this->input->post('xlvl3');

        $data['ID_REGIONAL_NAMA'] = $this->input->post('xlvl0_nama');
        $data['COCODE_NAMA'] = $this->input->post('xlvl1_nama');
        $data['PLANT_NAMA'] = $this->input->post('xlvl2_nama');
        $data['STORE_SLOC_NAMA'] = $this->input->post('xlvl3_nama');
        $data['ID_TRANSPORTIR_NAMA'] = $this->input->post('xtrans_nama');

        $data['SLOC'] = $this->input->post('xlvl4');
        $data['ID_TRANSPORTIR'] = $this->input->post('xtrans');
        
        $data['kata_kunci'] = $this->input->post('xkata_kunci');
        $data['status_kontrak'] = $this->input->post('xstatus_kontrak');
        $data['JENIS'] = 'XLS';
        $data['data'] = $this->tbl_get->data_export($data);
        $this->load->view($this->_module . '/export_excel', $data);
    }

    public function export_pdf(){

        if($this->input->post('ptglawal') == ''){
            $tgl_awal = '';
        } else {
            $tgl_awal = $this->convert_date($this->input->post('ptglawal'));
        }
        
        if($this->input->post('ptglakhir') == ''){
            $tgl_akhir = '';
        } else {
            $tgl_akhir = $this->convert_date($this->input->post('ptglakhir'));
        }
        
        $data['TGL_DARI'] = $tgl_awal;
        $data['TGL_SAMPAI'] = $tgl_akhir;

        $data['ID_REGIONAL'] = $this->input->post('plvl0');
        $data['COCODE'] = $this->input->post('plvl1');
        $data['PLANT'] = $this->input->post('plvl2');
        $data['STORE_SLOC'] = $this->input->post('plvl3');

        $data['ID_REGIONAL_NAMA'] = $this->input->post('plvl0_nama');
        $data['COCODE_NAMA'] = $this->input->post('plvl1_nama');
        $data['PLANT_NAMA'] = $this->input->post('plvl2_nama');
        $data['STORE_SLOC_NAMA'] = $this->input->post('plvl3_nama');
        $data['ID_TRANSPORTIR_NAMA'] = $this->input->post('ptrans_nama');

        $data['SLOC'] = $this->input->post('plvl4');
        $data['ID_TRANSPORTIR'] = $this->input->post('ptrans');
        $data['kata_kunci'] = $this->input->post('pkata_kunci');
        $data['status_kontrak'] = $this->input->post('pstatus_kontrak');
        $data['JENIS'] = 'PDF'; 

        $data['data'] = $this->tbl_get->data_export($data);

        $html = $this->load->view($this->_module . '/export_excel',$data,true);
        $this->load->library('lpdf'); 
        $this->lpdf->html($html);
        $this->lpdf->nama_file('Laporan_Rekap_Kontrak_Transportir.pdf');
        $this->lpdf->cetak('A4-L'); 
    }

    public function export_excel_adendum(){
        if($this->input->post('xtglawal') == ''){
            $tgl_awal = '';
        } else {
            $tgl_awal = $this->convert_date($this->input->post('xtglawal'));
        }
        
        if($this->input->post('xtglakhir') == ''){
            $tgl_akhir = '';
        } else {
            $tgl_akhir = $this->convert_date($this->input->post('xtglakhir'));
        }
        
        $data['TGL_DARI'] = $tgl_awal;
        $data['TGL_SAMPAI'] = $tgl_akhir;

        $data['ID_REGIONAL'] = $this->input->post('xlvl0');
        $data['COCODE'] = $this->input->post('xlvl1');
        $data['PLANT'] = $this->input->post('xlvl2');
        $data['STORE_SLOC'] = $this->input->post('xlvl3');

        $data['ID_REGIONAL_NAMA'] = $this->input->post('xlvl0_nama');
        $data['COCODE_NAMA'] = $this->input->post('xlvl1_nama');
        $data['PLANT_NAMA'] = $this->input->post('xlvl2_nama');
        $data['STORE_SLOC_NAMA'] = $this->input->post('xlvl3_nama');
        $data['ID_TRANSPORTIR_NAMA'] = $this->input->post('xtrans_nama');

        $data['SLOC'] = $this->input->post('xlvl4');
        $data['ID_TRANSPORTIR'] = $this->input->post('xtrans');
        
        $data['kata_kunci'] = $this->input->post('xkata_kunci');
        $data['status_kontrak'] = $this->input->post('xstatus_kontrak');
        $data['JENIS'] = 'XLS';
        $data['data'] = $this->tbl_get->data_export_adendum($data);
        $this->load->view($this->_module . '/export_excel_adendum', $data);
    } 

    public function export_pdf_adendum(){

        if($this->input->post('ptglawal') == ''){
            $tgl_awal = '';
        } else {
            $tgl_awal = $this->convert_date($this->input->post('ptglawal'));
        }
        
        if($this->input->post('ptglakhir') == ''){
            $tgl_akhir = '';
        } else {
            $tgl_akhir = $this->convert_date($this->input->post('ptglakhir'));
        }
        
        $data['TGL_DARI'] = $tgl_awal;
        $data['TGL_SAMPAI'] = $tgl_akhir;

        $data['ID_REGIONAL'] = $this->input->post('plvl0');
        $data['COCODE'] = $this->input->post('plvl1');
        $data['PLANT'] = $this->input->post('plvl2');
        $data['STORE_SLOC'] = $this->input->post('plvl3');

        $data['ID_REGIONAL_NAMA'] = $this->input->post('plvl0_nama');
        $data['COCODE_NAMA'] = $this->input->post('plvl1_nama');
        $data['PLANT_NAMA'] = $this->input->post('plvl2_nama');
        $data['STORE_SLOC_NAMA'] = $this->input->post('plvl3_nama');
        $data['ID_TRANSPORTIR_NAMA'] = $this->input->post('ptrans_nama');

        $data['SLOC'] = $this->input->post('plvl4');
        $data['ID_TRANSPORTIR'] = $this->input->post('ptrans');
        $data['kata_kunci'] = $this->input->post('pkata_kunci');
        $data['status_kontrak'] = $this->input->post('pstatus_kontrak');
        $data['JENIS'] = 'PDF'; 

        $data['data'] = $this->tbl_get->data_export_adendum($data);

        $html = $this->load->view($this->_module . '/export_excel_adendum',$data,true);
        $this->load->library('lpdf'); 
        $this->lpdf->html($html);
        $this->lpdf->nama_file('Laporan_Rekap_Kontrak_Transportir_Adendum.pdf');
        $this->lpdf->cetak('A4-L'); 
    }    

    public function convert_date($date) {
        if($date == '') {
            return '';
        } else {
            $origDate = $date;
 
            $newDate = date("Ymd", strtotime($origDate));
            return $newDate;
        }
        
    }
}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
