<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * @author stelin
 */
class supply_bbm extends MX_Controller
{
    /**
     * title legend
     * @var string
     */
    private $_title  = 'Data Supply BBM';

    /**
     * limitation
     * @var int
     */
    private $_limit  = 10;

    /**
     * model
     * @var string
     */
    private $_module = 'laporan/supply_bbm';

    public function __construct()
    {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        $this->load->model('persediaan_bbm_model', 'tbl_get');
        $this->load->model('supply_bbm_model', 'tbl_supply');
    }

    public function index()
    {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        $data['lv1_options']     = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options']     = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options']     = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options']     = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);
        $data['lv4_options_cari'] = $this->tbl_supply->options_lv4('--Pencarian Pembangkit--', 'all', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user, $kode_level);

        if ($level_user == 4) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC]  = $data_lv[0]->LEVEL3;
            $option_lv4[$data_lv[0]->SLOC]        = $data_lv[0]->LEVEL4;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $option_lv3;
            $data['lv4_options']                  = $option_lv4;
        } elseif ($level_user == 3) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $option_lv3[$data_lv[0]->STORE_SLOC]  = $data_lv[0]->LEVEL3;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $option_lv3;
            $data['lv4_options']                  = $this->tbl_get->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } elseif ($level_user == 2) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT]       = $data_lv[0]->LEVEL2;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $option_lv2;
            $data['lv3_options']                  = $this->tbl_get->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } elseif ($level_user == 1) {
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE]      = $data_lv[0]->LEVEL1;
            $data['reg_options']                  = $option_reg;
            $data['lv1_options']                  = $option_lv1;
            $data['lv2_options']                  = $this->tbl_get->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } elseif ($level_user == 0) {
            if ($kode_level == 00) {
                $data['reg_options'] = $this->tbl_get->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options']                  = $option_reg;
                $data['lv1_options']                  = $this->tbl_get->options_lv1(
                    '--Pilih Level 1--',
                    $data_lv[0]->ID_REGIONAL,
                    1
                );
            }
        }

        $data['opsi_bbm']   = $this->tbl_get->option_jenisbbm();
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();

        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';

        echo Modules::run('template/admin', $data);
    }

    /**
     * get result data pembangkit
     * @return string json encode
     */
    public function get_data()
    {
        $data['vlevel'] = $this->input->post('vlevel');
        $data['vlevelid'] = $this->input->post('vlevelid');
        $data['cari'] = $this->input->post('cari');
        $data['data'] = $this->tbl_supply->get_data($data);
        $this->load->view($this->_module . "/table", $data);
    }
    public function export_excel()
    {
        $data                = array(
            'ID_REGIONAL'      => $this->input->post('xlvl'), // 01
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),

            'SLOC'             => $this->input->post('xlvl4'), //183130
            'vlevel'           => $this->input->post('xlvl'),
            'vlevelid'         => $this->input->post('xlvlid'),
            'cari'             => $this->input->post('xcari'),
            'JENIS'            => 'XLS'
        );
    
        $data['data'] = $this->tbl_supply->get_data($data);
        $this->load->view($this->_module . '/export_excel', $data);
    }

    public function export_pdf()
    {
        $data                = array(
            // 'LVL0'             => $this->input->post('xlvl'),
            'ID_REGIONAL'      => $this->input->post('plvl'), // 01
            'COCODE'           => $this->input->post('plvl1'),
            'PLANT'            => $this->input->post('plvl2'),
            'STORE_SLOC'       => $this->input->post('plvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),

            'SLOC'             => $this->input->post('plvl4'), //183130
            'vlevel'           => $this->input->post('plvl'),
            'vlevelid'         => $this->input->post('plvlid'),
            'cari'             => $this->input->post('pcari'),
            'JENIS'            => 'PDF'
        );

        $data['data'] = $this->tbl_supply->get_data($data);
        $html_source  = $this->load->view($this->_module . '/export_excel', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('LAPORAN_STOK_OPNAME_BBM.pdf');
        $this->lpdf->cetak('A4');
    }
}
