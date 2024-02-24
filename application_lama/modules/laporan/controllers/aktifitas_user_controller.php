 <?php

/**
 * @module laporaj aktifitas user
 * @author NIA SAFITRI
 * @created at 09 OKTOBER 2019
 * @modified at 09 OKTOBER 2019
 */

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module laporan aktifitas user
 */
class aktifitas_user_controller extends MX_Controller {

    private $_title = 'Aktifitas Penggunaan Aplikasi';
    private $_limit = 10;
    private $_module = 'laporan/aktifitas_user_controller';

    public function __construct() {
        parent::__construct();               

        /* Load Global Model */

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        
        $this->load->model('aktivitas_user_model');
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
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function getDataUser() {
        $p_level = $this->input->post('p_level');
        $p_kode = $this->input->post('p_kode');
        $data['data'] = $this->aktivitas_user_model->getDataUser($p_level, $p_kode);
        $this->load->view($this->_module . '/table',$data);
    }

    public function getDetailUser() {
        $username = $this->input->post('username');
        $data['data'] = $this->aktivitas_user_model->getDetailUser($username);
        $this->load->view($this->_module . '/table_detail',$data);
    }


    public function get_level_user(){
        $data['lv1_options'] = $this->aktivitas_user_model->options_lv1('--Pilih Level 1--', '-', 1);
        $data['lv2_options'] = $this->aktivitas_user_model->options_lv2('--Pilih Level 2--', '-', 1);
        $data['lv3_options'] = $this->aktivitas_user_model->options_lv3('--Pilih Level 3--', '-', 1);
        $data['lv4_options'] = $this->aktivitas_user_model->options_lv4('--Pilih Pembangkit--', '-', 1);

        $level_user = $this->session->userdata('level_user');
        $kode_level = $this->session->userdata('kode_level');

        $data_lv = $this->aktivitas_user_model->get_level($level_user,$kode_level);

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
            $data['lv4_options'] = $this->aktivitas_user_model->options_lv4('--Pilih Pembangkit--', $data_lv[0]->STORE_SLOC, 1);
        } else if ($level_user==2){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $option_lv2[$data_lv[0]->PLANT] = $data_lv[0]->LEVEL2;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $option_lv2;
            $data['lv3_options'] = $this->aktivitas_user_model->options_lv3('--Pilih Level 3--', $data_lv[0]->PLANT, 1);
        } else if ($level_user==1){
            $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
            $option_lv1[$data_lv[0]->COCODE] = $data_lv[0]->LEVEL1;
            $data['reg_options'] = $option_reg;
            $data['lv1_options'] = $option_lv1;
            $data['lv2_options'] = $this->aktivitas_user_model->options_lv2('--Pilih Level 2--', $data_lv[0]->COCODE, 1);
        } else if ($level_user==0){
            if ($kode_level==00){
                $data['reg_options'] = $this->aktivitas_user_model->options_reg();
            } else {
                $option_reg[$data_lv[0]->ID_REGIONAL] = $data_lv[0]->NAMA_REGIONAL;
                $data['reg_options'] = $option_reg;
                $data['lv1_options'] = $this->aktivitas_user_model->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        return $data;
    }

    public function get_options_lv1($key=null) {
        $message = $this->aktivitas_user_model->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv2($key=null) {
        $message = $this->aktivitas_user_model->options_lv2('--Pilih Level 2--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv3($key=null) {
        $message = $this->aktivitas_user_model->options_lv3('--Pilih Level 3--', $key, 0);
        echo json_encode($message);
    }

    public function get_options_lv4($key=null) {
        $message = $this->aktivitas_user_model->options_lv4('--Pilih Pembangkit--', $key, 0);
        echo json_encode($message);
    }

    public function export_excel() {
        header('Content-Type: application/json');
        $p_level = $this->input->post('x_level');
        $p_kode =  $this->input->post('x_kode');
    
        $data['JENIS'] = 'XLS';
        $data['data'] = $this->aktivitas_user_model->getDataUser($p_level, $p_kode);
        $this->load->view($this->_module . '/export_excel', $data);
    }

     public function export_pdf() {
        $p_level = $this->input->post('p_level');
        $p_kode =  $this->input->post('p_kode');
    
        $data['JENIS'] = 'PDF';
        $data['data'] = $this->aktivitas_user_model->getDataUser($p_level, $p_kode);

        $html_source  = $this->load->view($this->_module . '/export_excel', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_Jumlah_Aktifitas_User.pdf');
        $this->lpdf->cetak('A4-L');
    }

    public function export_excel_detail() {  
        $username =  $this->input->post('x_username');
    
        $data['JENIS'] = 'XLS';
        $data['data'] = $this->aktivitas_user_model->getDetailUser($username);
        $this->load->view($this->_module . '/export_excel_detail', $data);
    }

    public function export_pdf_detail() {
        $username =  $this->input->post('p_username');
        $data['JENIS'] = 'PDF';
        
        $data['data'] = $this->aktivitas_user_model->getDetailUser($username);

        $html_source =  $this->load->view($this->_module . '/export_excel_detail', $data, TRUE);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Detil_Laporan_Jumlah_Aktifitas_User.pdf');
        $this->lpdf->cetak('A4-L');
    }

}




