<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class stock_bbm extends MX_Controller{
    private $_title = 'Persediaan BBM';
    private $_limit = 10;
    private $_module = 'dashboard/stock_bbm';

    function __construct(){
        parent::__construct();

        // Protection
        hprotection::login();

        /* Load Global Model */
        $this->load->model('stock_bbm_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('highchart'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('bootstrap-rakhmat', 'font-awesome'));

        $data = $this->get_level_user(); 

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['report'] = $this->tbl_get->report();
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function getGrafikHSD(){
        $data = array(
            'BULAN' => $this->input->post('BULAN'),
            'TAHUN' => $this->input->post('TAHUN'),
            'VLEVEL' => $this->input->post('VLEVEL'),
            'VLEVELID' => $this->input->post('VLEVELID'),
        );

        if($this->input->post('PERIODE') == 1) {
            $data = $this->tbl_get->getStockbbmHsd($data);
        } elseif($this->input->post('PERIODE') == 2) {
            $data = $this->tbl_get->getStockbbmHsdTahun($data);
        }
        echo json_encode($data);

    }

    public function getGrafikMFO(){
        $data = array(
            'BULAN' => $this->input->post('BULAN'),
            'TAHUN' => $this->input->post('TAHUN'),
            'VLEVEL' => $this->input->post('VLEVEL'),
            'VLEVELID' => $this->input->post('VLEVELID')
        );
        if($this->input->post('PERIODE') == 1) {
            $data = $this->tbl_get->getStockbbmMfo($data);
        } elseif($this->input->post('PERIODE') == 2) {
            $data = $this->tbl_get->getStockbbmMfoTahun($data);
        }
        echo json_encode($data);
    }

    public function getGrafikBIO(){
        $data = array(
            'BULAN' => $this->input->post('BULAN'),
            'TAHUN' => $this->input->post('TAHUN'),
            'VLEVEL' => $this->input->post('VLEVEL'),
            'VLEVELID' => $this->input->post('VLEVELID')
        );
        $data = $this->tbl_get->getStockbbmBio($data);
        echo json_encode($data);
    }

    public function getGrafikHSDBIO(){
        $data = array(
            'BULAN' => $this->input->post('BULAN'),
            'TAHUN' => $this->input->post('TAHUN'),
            'VLEVEL' => $this->input->post('VLEVEL'),
            'VLEVELID' => $this->input->post('VLEVELID')
        );
        if($this->input->post('PERIODE') == 1) {
            $data = $this->tbl_get->getStockbbmHSDBIO($data);
        } elseif($this->input->post('PERIODE') == 2) {
            $data = $this->tbl_get->getStockbbmHSDBIOTahun($data);
        }
        echo json_encode($data);
    }

    public function getGrafikIDO(){
        $data = array(
            'BULAN' => $this->input->post('BULAN'),
            'TAHUN' => $this->input->post('TAHUN'),
            'VLEVEL' => $this->input->post('VLEVEL'),
            'VLEVELID' => $this->input->post('VLEVELID')
        );
        if($this->input->post('PERIODE') == 1) {
            $data = $this->tbl_get->getStockbbmIDO($data);
        } elseif($this->input->post('PERIODE') == 2) {
            $data = $this->tbl_get->getStockbbmIDOTahun($data);
        }
        echo json_encode($data);
    }

    public function get_sum_stock(){
        $data['JENIS_BBM'] = $this->input->post('JENIS_BBM');
        $data['VLEVEL'] = $this->input->post('VLEVEL');
        $data['VLEVELID'] = $this->input->post('VLEVELID');
        $data['THBL'] = $this->input->post('TAHUN').$this->input->post('BULAN');

        $data = $this->tbl_get->getStockSum($data);
        echo json_encode($data);
    }

    public function get_level_user(){
        $data['lv1_options'] = $this->tbl_get->options_lv1('--Pilih Level 1--', '-', 1); 
        $data['lv2_options'] = $this->tbl_get->options_lv2('--Pilih Level 2--', '-', 1); 
        $data['lv3_options'] = $this->tbl_get->options_lv3('--Pilih Level 3--', '-', 1);  
        $data['lv4_options'] = $this->tbl_get->options_lv4('--Pilih Pembangkit--', '-', 1);  

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->tbl_get->get_level($level_user,$kode_level);

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

}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */

