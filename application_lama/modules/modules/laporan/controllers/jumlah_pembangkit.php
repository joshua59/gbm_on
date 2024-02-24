<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * @author stelin
 */
class jumlah_pembangkit extends MX_Controller
{
    /**
     * title legend
     * @var string
     */
    private $_title  = 'Jumlah Pembangkit BBM';

    /**
     * limitation
     * @var int
     */
    private $_limit  = 10;

    /**
     * model
     * @var string
     */
    private $_module = 'laporan/jumlah_pembangkit';

    /**
     * load persediaan bbm model, jumlah_pembangkit model
     */
    public function __construct()
    {
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        $this->load->model('persediaan_bbm_model', 'tbl_get');
        $this->load->model('jumlah_pembangkit_model', 'jumlah_pembangkit');
    }

    public function index()
    {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));
        // $this->asset->set_plugin(array('bootstrap-rakhmat'));
        // $data['data_penerimaan'] = $this->tbl_get->getData_Model();
        $data['lv1_options']     = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options']     = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options']     = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options']     = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);

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
        // dd($this->tbl_penerimaan_get->option_jenisbbm());
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();

        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        // $data['data_sources'] = base_url($this->_module . '/getData');
        // $data['data_sources'] = base_url($this->_module . '/load');

        echo Modules::run('template/admin', $data);
    }

    /**
     * for testing data
     * @return object
     */
    public function testPembangkit()
    {
        // header('Content-type: application/json');
        $data = $this->jumlah_pembangkit->testPembangkit();
        echo json_encode($data);
    }

    /**
     * get result data pembangkit
     * @return string json encode
     */
    public function getDataPembangkit()
    {
      extract($_POST);
      
      $data = array(
          'regional' => $ID_REGIONAL,
          'level'    => $VLEVELID,
          'cari'     => $cari
      );
      $data = $this->jumlah_pembangkit->getDataPembangkit($data);
      echo json_encode($data);
    }

    /**
     * get Detail Pemabangkit
     * @return string json_encode
     */
    public function getDetailPembangkit()
    {

        $data = array(
          'kd_unit' => $this->input->post('detail_kode_unit')
      );
        $data = $this->jumlah_pembangkit->getDetilPembangkit($data);
        echo json_encode($data);
    }

    /**
     * get Detail Pemabangkit
     * @return string json_encode
     */
    public function getAllDetailPembangkit()
    {
      $post = $this->input->post('detail_kode_unit');

      $data = array(
        'kd_unit' => $post
      );
      $data = $this->jumlah_pembangkit->getAllDetailPembangkit($data);

      echo json_encode($data);
    }

    /**
     * export excel
     * @return mixed load into view
     */
    public function export_excel()
    {
        header('Content-Type: application/json');
        $data                = array(
            // 'LVL0'             => $this->input->post('xlvl'),
            'ID_REGIONAL'      => $this->input->post('xlvl'), // 01
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),

            'SLOC'             => $this->input->post('xlvl4'), //183130
            'BBM'              => $this->input->post('xbbm'), //001
            'regional'         => $this->input->post('xlvl'),
            'level'            => $this->input->post('xlvlid'),
            'cari'             => $this->input->post('xcari'),
            // 'BULAN'            => $this->input->post('xbln'), //1
            // 'TAHUN'            => $this->input->post('xthn'), //2017
            'JENIS'            => 'XLS'
        );

        $data['data'] = $this->jumlah_pembangkit->getDataPembangkit($data);
        $this->load->view($this->_module . '/export_excel', $data);
    }

    public function export_excel_detail()
    {   

        $data = array(
          'ID_REGIONAL'       => $this->input->post('xlvl0_detail'), // 01
          'COCODE'            => $this->input->post('xlvl1_detail'),
          'PLANT'             => $this->input->post('xlvl2_detail'),
          'STORE_SLOC'        => $this->input->post('xlvl3_detail'),
          'ID_REGIONAL_NAMA'  => $this->input->post('xlvl0_nama_detail'),
          'COCODE_NAMA'       => $this->input->post('xlvl1_nama_detail'),
          'PLANT_NAMA'        => $this->input->post('xlvl2_nama_detail'),
          'STORE_SLOC_NAMA'   => $this->input->post('xlvl3_nama_detail'),
          'kd_unit' => $this->input->post('xkodeUnit_detail'),
          'JENIS'   => 'XLS'
        );
        if($this->input->post('value') == 1){
          $data['data'] = $this->jumlah_pembangkit->getDetilPembangkit($data);
        } else {
          $data['data'] = $this->jumlah_pembangkit->getAllDetailPembangkit($data);
        }
        $this->load->view($this->_module . '/export_excel_detail', $data);
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
          'BBM'              => $this->input->post('pbbm'), //001
          'regional'         => $this->input->post('plvl'),
          'level'            => $this->input->post('plvlid'),
          'cari'             => $this->input->post('pcari'),
          'JENIS'            => 'PDF'
      );
        $data['data']   = $this->jumlah_pembangkit->getDataPembangkit($data);

        $html_source  = $this->load->view($this->_module . '/export_excel', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_JumlahPembangkit_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }

    public function export_pdf_detail()
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
          'BBM'              => $this->input->post('pbbm'), //001
          'regional'         => $this->input->post('plvl'),
          'level'            => $this->input->post('plvlid'),
          'kd_unit'          => $this->input->post('pkodeUnit_detail'),
          'JENIS'            => 'PDF'
      );


        if($this->input->post('valuepdf') == 1){
          $data['data'] = $this->jumlah_pembangkit->getDetilPembangkit($data);
        } else {
          $data['data'] = $this->jumlah_pembangkit->getAllDetailPembangkit($data);
        }

        $html_source  = $this->load->view($this->_module . '/export_excel_detail', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Detil_Laporan_JumlahPembangkit_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }
}
