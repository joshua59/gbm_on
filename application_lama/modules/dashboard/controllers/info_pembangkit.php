<?php

/**
 * @module DASHBOARD
 * @author  CF
 * @created at 17 Oktober 2018
 * @modified at 17 Oktober 2018
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module dashboard
 */
class info_pembangkit extends MX_Controller {

    private $_title = 'INFO PEMBANGKIT';
    private $_limit = 10;
    private $_module = 'dashboard/info_pembangkit';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        // $this->laccess->check();
        // $this->laccess->otoritas('view', true);
        $this->_url_movefile = $this->laccess->url_serverfile()."move";
        $this->_urlgetfile = $this->laccess->url_serverfile()."geturl";
        /* Load Global Model */
        $this->load->model('info_pembangkit_model', 'tbl_get');
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

    public function get_data(){
        $data = $this->tbl_get->get_data($this->input->post('SLOC'));
        echo json_encode($data);
    }

    public function get_data_stock(){
        $data = $this->tbl_get->get_data_stock($this->input->post('SLOC'));
        echo json_encode($data);
    }    

    public function get_data_detail(){
        $data = $this->tbl_get->get_data_detail($this->input->post('SLOC'));
        echo json_encode($data);
    }  

    public function get_data_detail_tangki(){
        $data = $this->tbl_get->get_data_detail_tangki($this->input->post('ID_TANGKI'));
        echo json_encode($data);
    }        

    public function get_data_histo(){
        $data = $this->tbl_get->get_data_histo($this->input->post('SLOC'),$this->input->post('JENIS_BBM'));
        echo json_encode($data);
    }    

    public function get_data_unit(){
        $data = $this->tbl_get->get_data_unit($this->input->post('SLOC'));
        echo json_encode($data);
    }    



    public function export_excel_stok(){
        $data = array(
            'ID_REGIONAL'      => $this->input->post('xlvl'),
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),
            'SLOC'             => $this->input->post('xlvl4'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'),
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),
            'SLOC_NAMA'        => $this->input->post('xlvl4_nama'),
            
            'JENIS'            => 'XLS'
        );

        $data['data'] = $this->tbl_get->get_data_stock($data['SLOC']);        
        $this->load->view($this->_module . '/export_excel_stok', $data);
    }

    public function export_pdf_stok(){
        $data = array(
          'ID_REGIONAL'      => $this->input->post('plvl'),
          'COCODE'           => $this->input->post('plvl1'),
          'PLANT'            => $this->input->post('plvl2'),
          'STORE_SLOC'       => $this->input->post('plvl3'),
          'SLOC'             => $this->input->post('plvl4'),

          'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'),
          'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
          'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
          'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),
          'SLOC_NAMA'        => $this->input->post('plvl4_nama'),
                    
          'JENIS'            => 'PDF'
        );

        $data['data'] = $this->tbl_get->get_data_stock($data['SLOC']);
        $html_source  = $this->load->view($this->_module . '/export_excel_stok', $data, true);

        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Data_Stok_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }  

    public function export_excel_histo(){
        $data = array(
            'ID_REGIONAL'      => $this->input->post('xlvl'),
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),
            'SLOC'             => $this->input->post('xlvl4'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'),
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),
            'SLOC_NAMA'        => $this->input->post('xlvl4_nama'),
            'JENIS_BBM'        => $this->input->post('xbbm'),
            
            'JENIS'            => 'XLS'
        );

        $data['data'] = $this->tbl_get->get_data_histo($data['SLOC'],$data['JENIS_BBM']);
        $this->load->view($this->_module . '/export_excel_histo', $data);
    }

    public function export_pdf_histo(){
        $data = array(
          'ID_REGIONAL'      => $this->input->post('plvl'),
          'COCODE'           => $this->input->post('plvl1'),
          'PLANT'            => $this->input->post('plvl2'),
          'STORE_SLOC'       => $this->input->post('plvl3'),
          'SLOC'             => $this->input->post('plvl4'),

          'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'),
          'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
          'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
          'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),
          'SLOC_NAMA'        => $this->input->post('plvl4_nama'),
          'JENIS_BBM'        => $this->input->post('pbbm'),
                    
          'JENIS'            => 'PDF'
        );

        $data['data'] = $this->tbl_get->get_data_histo($data['SLOC'],$data['JENIS_BBM']);
        $html_source  = $this->load->view($this->_module . '/export_excel_histo', $data, true);

        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Histo_Stok_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }      

    public function export_excel_tangki(){
        $data = array(
            'ID_REGIONAL'      => $this->input->post('xlvl'),
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),
            'SLOC'             => $this->input->post('xlvl4'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'),
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),
            'SLOC_NAMA'        => $this->input->post('xlvl4_nama'),
            
            'JENIS'            => 'XLS'
        );

        $data['data'] = $this->tbl_get->get_data_detail($data['SLOC']);        
        $this->load->view($this->_module . '/export_excel_tangki', $data);
    }

    public function export_pdf_tangki(){
        $data = array(
          'ID_REGIONAL'      => $this->input->post('plvl'),
          'COCODE'           => $this->input->post('plvl1'),
          'PLANT'            => $this->input->post('plvl2'),
          'STORE_SLOC'       => $this->input->post('plvl3'),
          'SLOC'             => $this->input->post('plvl4'),

          'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'),
          'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
          'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
          'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),
          'SLOC_NAMA'        => $this->input->post('plvl4_nama'),
                    
          'JENIS'            => 'PDF'
        );

        $data['data'] = $this->tbl_get->get_data_detail($data['SLOC']);
        $html_source  = $this->load->view($this->_module . '/export_excel_tangki', $data, true);

        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Data_Tangki_Pembangkit.pdf');
        $this->lpdf->cetak('A4-L');
    }     

    public function export_excel_tangki_detail(){
        $data = array(
            'ID_REGIONAL'      => $this->input->post('xlvl'),
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),
            'SLOC'             => $this->input->post('xlvl4'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'),
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),
            'SLOC_NAMA'        => $this->input->post('xlvl4_nama'),
            'ID_TANGKI'        => $this->input->post('xid_tangki'),
            
            'JENIS'            => 'XLS'
        );

        $data['data'] = $this->tbl_get->get_data_detail_tangki($data['ID_TANGKI']);
        $this->load->view($this->_module . '/export_excel_tangki_detail', $data);
    }

    public function export_pdf_tangki_detail(){
        $data = array(
          'ID_REGIONAL'      => $this->input->post('plvl'),
          'COCODE'           => $this->input->post('plvl1'),
          'PLANT'            => $this->input->post('plvl2'),
          'STORE_SLOC'       => $this->input->post('plvl3'),
          'SLOC'             => $this->input->post('plvl4'),

          'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'),
          'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
          'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
          'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),
          'SLOC_NAMA'        => $this->input->post('plvl4_nama'),
          'ID_TANGKI'        => $this->input->post('pid_tangki'),
                    
          'JENIS'            => 'PDF'
        );

        $data['data'] = $this->tbl_get->get_data_detail_tangki($data['ID_TANGKI']);
        $html_source  = $this->load->view($this->_module . '/export_excel_tangki_detail', $data, true);

        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Detail_Tangki_Pembangkit.pdf');
        $this->lpdf->cetak('A4-L');
    }      






    public function get_level_user(){
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', 'all', 1);
        $data['lv4_options_cari'] = $this->tbl_get->options_lv4('--Pencarian Pembangkit--', 'all', 1);
        $data['option_pemasok'] = $this->tbl_get->options_pemasok('--Pilih Pemasok--', '-', 1);

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
            $data['lv4_options_cari'] = $option_lv4;
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
            $data['lv4_options_cari'] = $this->tbl_get->options_lv4('--Pencarian Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
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

    public function options_lv4_all($key=0) {
        $message = $this->tbl_get->options_lv4_all($key);
        echo json_encode($message);
    }    

 
}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
