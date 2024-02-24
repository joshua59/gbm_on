<?php
/**
 * User: CF
 * Date: 02/10/2018
 * Time: 09:10 AM
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * @module Laporan
 * @author CF
 */


class perolehan_harga_bbm extends MX_Controller{
    private $_title  = 'Laporan Perolehan Harga BBM';
    private $_limit  = 10;
    private $_module = 'laporan/perolehan_harga_bbm';

    public function __construct(){
        parent::__construct();

        hprotection::login();
        // $this->laccess->check();
        // $this->laccess->otoritas('view', true);
        
        $this->load->model('perolehan_harga_bbm_model', 'tbl_get');
    }    

    public function index(){
        // Load Modules
        $this->laccess->update_log();
        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));

        $data = $this->get_level_user(); 

        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');

        echo Modules::run('template/admin', $data);
    }    

    public function loadx($page = 1){
        echo $page;
    }    

    public function get_data(){        
        $data['JENIS_BBM']     = $this->input->post('JENIS_BBM');
        $data['PERIODE']       = $this->input->post('PERIODE');        
        $data['ID_REGIONAL']   = $this->input->post('ID_REGIONAL');
        $data['VLEVELID']      = $this->input->post('VLEVELID');
        $data['PEMASOK']       = $this->input->post('PEMASOK');
        $data['CARI']          = $this->input->post('CARI');

        $data                  = $this->tbl_get->get_data($data);
        echo json_encode($data);
    }    
    
    public function get_data_detail(){
        $data['JENIS_BBM']     = $this->input->post('JENIS_BBM');
        $data['TGLAWAL']       = $this->input->post('TGLAWAL');
        $data['TGLAKHIR']      = $this->input->post('TGLAKHIR');        
        $data['VLEVELID']      = $this->input->post('VLEVELID');
        $data['PEMASOK']       = $this->input->post('PEMASOK');
        $data['VTRANS']        = $this->input->post('VTRANS');
        $data['JENIS_BIO']     = $this->input->post('JENIS_BIO');              
        
        $data                  = $this->tbl_get->get_data_detail($data);
        echo json_encode($data);
    }      

    public function export_excel(){
        $data                = array(
            'ID_REGIONAL'      => $this->input->post('xlvl'),
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'),
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),

            'SLOC'             => $this->input->post('xlvl4'),
            'BBM'              => $this->input->post('xbbm'),
            'JENIS_BBM'        => $this->input->post('xbbm'),
            'VLEVELID'         => $this->input->post('xlvlid'),
            'PERIODE'          => $this->input->post('xperiode'),
            'PERIODE_NAMA'     => $this->input->post('xperiode_nama'),
            'PEMASOK'          => $this->input->post('xpemasok'),
            'PEMASOK_NAMA'     => $this->input->post('xpemasok_nama'),
            'JENIS'            => 'XLS'
        );

        $data['data'] = $this->tbl_get->get_data($data);        
        $this->load->view($this->_module . '/export_excel', $data);
    }

    public function export_pdf(){
        $data = array(
          'ID_REGIONAL' => $this->input->post('plvl'),
          'COCODE'      => $this->input->post('plvl1'),
          'PLANT'       => $this->input->post('plvl2'),
          'STORE_SLOC'  => $this->input->post('plvl3'),

          'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'),
          'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
          'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
          'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),

          'SLOC'             => $this->input->post('plvl4'),
          'BBM'              => $this->input->post('pbbm'),
          'JENIS_BBM'        => $this->input->post('pbbm'),
          'VLEVELID'         => $this->input->post('plvlid'),        
          'PERIODE'          => $this->input->post('pperiode'),
          'PERIODE_NAMA'     => $this->input->post('pperiode_nama'),
          'PEMASOK'          => $this->input->post('ppemasok'),
          'PEMASOK_NAMA'     => $this->input->post('ppemasok_nama'),
          'JENIS'            => 'PDF'
        );

        $data['data'] = $this->tbl_get->get_data($data);
        $html_source  = $this->load->view($this->_module . '/export_excel', $data, true);

        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_Perolehan_Harga_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }    
    
    public function export_excel_detail(){
        $data                = array(            
            'ID_REGIONAL'       => $this->input->post('xlvl0_detail'),
            'COCODE'            => $this->input->post('xlvl1_detail'),
            'PLANT'             => $this->input->post('xlvl2_detail'),
            'STORE_SLOC'        => $this->input->post('xlvl3_detail'),
            'SLOC'              => $this->input->post('xlvl4_detail'),

            'ID_REGIONAL_NAMA'  => $this->input->post('xlvl0_nama_detail'),
            'COCODE_NAMA'       => $this->input->post('xlvl1_nama_detail'),
            'PLANT_NAMA'        => $this->input->post('xlvl2_nama_detail'),
            'STORE_SLOC_NAMA'   => $this->input->post('xlvl3_nama_detail'),            

            'JENIS_BBM'         => $this->input->post('xbbm_detail'),            
            'TGLAWAL'           => $this->input->post('xtglawal_detail'),
            'TGLAKHIR'          => $this->input->post('xtglakhir_detail'),
            'VLEVELID'          => $this->input->post('xkodeUnit_detail'),
            'PEMASOK'           => $this->input->post('xpemasok_detail'),
            'VTRANS'            => $this->input->post('xtransportir_detail'),
            'JENIS_BIO'         => $this->input->post('xkomponen_detail'),
            'JENIS'             => 'XLS'
        );
        
        $data['data'] = $this->tbl_get->get_data_detail($data);      
        if ($data['JENIS_BBM']=='BIO'){
            $this->load->view($this->_module . '/export_excel_detail_bio', $data);
        } else {
            $this->load->view($this->_module . '/export_excel_detail', $data);  
        }
    }

    public function export_pdf_detail(){
        $data                = array(            
            'ID_REGIONAL'       => $this->input->post('plvl0_detail'),
            'COCODE'            => $this->input->post('plvl1_detail'),
            'PLANT'             => $this->input->post('plvl2_detail'),
            'STORE_SLOC'        => $this->input->post('plvl3_detail'),
            'SLOC'              => $this->input->post('plvl4_detail'),

            'ID_REGIONAL_NAMA'  => $this->input->post('plvl0_nama_detail'),
            'COCODE_NAMA'       => $this->input->post('plvl1_nama_detail'),
            'PLANT_NAMA'        => $this->input->post('plvl2_nama_detail'),
            'STORE_SLOC_NAMA'   => $this->input->post('plvl3_nama_detail'),            

            'JENIS_BBM'         => $this->input->post('pbbm_detail'),            
            'TGLAWAL'           => $this->input->post('ptglawal_detail'),
            'TGLAKHIR'          => $this->input->post('ptglakhir_detail'),
            'VLEVELID'          => $this->input->post('pkodeUnit_detail'),
            'PEMASOK'           => $this->input->post('ppemasok_detail'),
            'VTRANS'            => $this->input->post('ptransportir_detail'),
            'JENIS_BIO'         => $this->input->post('pkomponen_detail'),
            'JENIS'             => 'PDF'
        );

        // print_r($data); die;
        
        $data['data'] = $this->tbl_get->get_data_detail($data);      
        if ($data['JENIS_BBM']=='BIO'){
            $html_source  = $this->load->view($this->_module . '/export_excel_detail_bio', $data, true);
        } else {
            $html_source  = $this->load->view($this->_module . '/export_excel_detail', $data, true);  
        }    
        
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_Detail_Penerimaan_Pemasok.pdf');
        $this->lpdf->cetak('A4-L');
    }    

    public function get_level_user(){
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');        

        $data_lv = $this->tbl_get->get_level($level_user, $kode_level);

        if ($level_user==4){
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



        $data['opsi_bbm'] = $this->tbl_get->option_jenisbbm();
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();
        $data['opsi_pemasok'] = $this->tbl_get->options_pemasok('--Pilih Pemasok--', '-', 1);
        $data['opsi_transportir'] = $this->tbl_get->options_transportir();
        $data['opsi_komponen_bio'] = $this->tbl_get->option_komponen_bio('003','1');

        return $data;        
    }      
   
}