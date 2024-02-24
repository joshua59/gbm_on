 <?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");


class stockopname_pemakaian extends MX_Controller {

    private $_title = 'Stock Opname Pemakaian';
    private $_limit = 10;
    private $_module = 'laporan/stockopname_pemakaian';

    public function __construct() {
        parent::__construct();               

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        
        $this->load->model('stockopname_pemakaian_model','tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('font-awesome'));

        $data = $this->get_level_user();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        echo Modules::run("template/admin", $data);
    }

    public function get_data() {

        
        $data['periode_awal'] = $this->input->post('periode_awal');
        $data['periode_akhir'] = $this->input->post('periode_akhir');
        $data['bbm'] = $this->input->post('bbm');
        $data['VOLUME'] = $this->tbl_get->get_data($data);
        echo json_encode($data);
    }


    public function get_level_user(){
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);
        $data['options_periode'] = $this->tbl_get->options_periode('--Pilih Periode--', '-', 1);
        $data['options_bbm'] = $this->tbl_get->options_jenis_bahan_bakar('--Pilih Jenis Bahan Bakar--');
        $data['lv4_options_cari'] = $this->tbl_get->options_lv4('--Pencarian Pembangkit--', 'all', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user,$kode_level);

        if ($level_user == 4){
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
        } else if ($level_user==3){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC] = $data_lv[0]->LEVEL3;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $option_lv3;
            $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user==2){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user==1){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user==0){
            if ($kode_level==00){
                $data['reg_options'] = $this->tbl_get->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

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

    public function get_data_unit(){
        $data = $this->tbl_get->get_data_unit($this->input->post('SLOC'));
        echo json_encode($data);
    } 


    public function get_periode() {
        $key = $this->input->post('sloc');
        $key2 = $this->input->post('tgl_awal');
        $key3 = $this->input->post('tgl_akhir');
        $key4 = $this->input->post('bbm');
        $message = $this->tbl_get->options_periode('--Pilih Periode--', $key,$key2,$key3,$key4, 0);
        echo json_encode($message);
    }

    public function get_periode_akhir() {
        $data['sloc'] = $this->input->post('sloc');
        $data['tgl_awal'] = $this->input->post('tgl_awal');
        $data['tgl_akhir'] = $this->input->post('tgl_akhir');
        $data['bbm'] = $this->input->post('bbm');
        $data['id_stockopname'] = $this->input->post('id');

        $message = $this->tbl_get->get_periode_akhir($data);
        echo json_encode($message);
    }

    public function get_volume_terima(){
        $data['SLOC'] = $this->input->post('SLOC');
        $data['TGL_AWAL'] = $this->input->post('TGL_AWAL');
        $data['TGL_AKHIR'] = $this->input->post('TGL_AKHIR');
        $data['BBM'] = $this->input->post('BBM');
        $data = $this->tbl_get->get_volume_terima($data);
        echo json_encode($data);
    }

    public function get_pemakaian(){
        $data['SLOC'] = $this->input->post('SLOC');
        $data['TGL_AWAL'] = $this->input->post('TGL_AWAL');
        $data['BBM'] = $this->input->post('BBM');
        $data['TGL_AKHIR'] = $this->input->post('TGL_AKHIR');
        $data['TOTAL_PEMAKAIAN'] = $this->input->post('TOTAL_PEMAKAIAN');
        $data['NILAI_STOK_BA'] = $this->input->post('NILAI_STOK_BA');
        $data = $this->tbl_get->get_pemakaian($data);
        echo json_encode($data);
    } 

    public function get_pemakaian_total(){
        $data['SLOC'] = $this->input->post('SLOC');
        $data['TGL_AWAL'] = $this->input->post('TGL_AWAL');
        $data['TGL_AKHIR'] = $this->input->post('TGL_AKHIR');
        $data['BBM'] = $this->input->post('BBM');
        $data = $this->tbl_get->get_pemakaian_total($data);
        echo json_encode($data);
    } 

    public function export_excel() {
        $data['SLOC']      = $this->input->post('x_lvl4');
        $data['TGL_AWAL']  = $this->input->post('x_tglawal');
        $data['TGL_AKHIR'] = $this->input->post('x_tglakhir');
        $data['BBM'] = $this->input->post('x_bbm');
        $data['NAMA_BBM'] = $this->input->post('x_bbm_nama');
        $data['pembangkit'] = $this->input->post('x_lvl4_nama');
        $data['VOLUME_AWAL'] = $this->input->post('x_volume_awal');
        $data['VOLUME_TERIMA'] = $this->input->post('x_volume_terima');
        $data['TOTAL_PEMAKAIAN'] = $this->input->post('x_total_pemakaian');
        $data['STOK_AKHIR'] = $this->input->post('x_stok_akhir');
        $data['STOK_AKHIR_BA'] = $this->input->post('x_stok_akhir_ba');
        $data['NILAI_STOK_BA'] = $this->input->post('x_pemakaian_total_ba');
        $data['BA_AWAL'] = $this->input->post('x_ba_awal');
        $data['BA_AKHIR'] = $this->input->post('x_ba_akhir');
        $data['JENIS'] = 'XLS';
        $data['data']  = $this->tbl_get->get_pemakaian($data);
        $this->load->view($this->_module . '/export_excel', $data);
    }

    public function export_pdf() {
        $data['SLOC']      = $this->input->post('p_lvl4');
        $data['TGL_AWAL']  = $this->input->post('p_tglawal');
        $data['TGL_AKHIR'] = $this->input->post('p_tglakhir');
        $data['BBM'] = $this->input->post('p_bbm');
        $data['NAMA_BBM'] = $this->input->post('p_bbm_nama');
        $data['pembangkit'] = $this->input->post('p_lvl4_nama');
        $data['VOLUME_AWAL'] = $this->input->post('p_volume_awal');
        $data['VOLUME_TERIMA'] = $this->input->post('p_volume_terima');
        $data['TOTAL_PEMAKAIAN'] = $this->input->post('p_total_pemakaian');
        $data['STOK_AKHIR'] = $this->input->post('p_stok_akhir');
        $data['STOK_AKHIR_BA'] = $this->input->post('p_stok_akhir_ba');
        $data['NILAI_STOK_BA'] = $this->input->post('p_pemakaian_total_ba');
        $data['BA_AWAL'] = $this->input->post('p_ba_awal');
        $data['BA_AKHIR'] = $this->input->post('p_ba_akhir');
        $data['JENIS'] = 'PDF';
        $data['data']  = $this->tbl_get->get_pemakaian($data);

        $html_source  = $this->load->view($this->_module . '/export_excel', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('LAPORAN_STOK_OPNAME_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }

}
