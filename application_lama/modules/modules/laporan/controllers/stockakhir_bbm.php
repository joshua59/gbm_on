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
 * @module Master Transportir
 */
class stockakhir_bbm extends MX_Controller {

    private $_title = 'Laporan Stock Akhir BBM';
    private $_limit = 10;
    private $_module = 'laporan/stockakhir_bbm';

    public function __construct() {
        parent::__construct();

        // Protection
        // hprotection::login();
        // $this->laccess->check();
        // $this->laccess->otoritas('view', true);                

        /* Load Global Model */
        $this->load->model('stockakhir_bbm_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('highchart'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('font-awesome'));

        $data = $this->get_level_user();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
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

    public function option_jenisbbm() {
        $jenis = $this->tbl_get->option_jenisbbm('-- Pilih Jenis BBM --');
        echo json_encode($jenis);
    }

    public function get_stockakhir() {

        $data['vjns_bbm'] = $this->input->post('vjns_bbm');
        $data['vtgl'] = $this->input->post('vtgl');
        $data['vlevel'] = $this->input->post('vlevel');
        $data['vlevelid'] = $this->input->post('vlevelid');
        $data['CARI'] = $this->input->post('CARI');
        
        $data = $this->tbl_get->get_stockakhir($data);

        echo json_encode($data);
    } 


    public function export_excel() {
        // header('Content-Type: application/json');
             $data             = array(
            'ID_REGIONAL'      => $this->input->post('xlvl0'), // 01
            'COCODE'           => $this->input->post('xlvl1'),
            'PLANT'            => $this->input->post('xlvl2'),
            'STORE_SLOC'       => $this->input->post('xlvl3'),
            'SLOC'             => $this->input->post('xlvl4'), //183130
            'LEVEL'            => $this->input->post('xlvlid'),
            'vjns_bbm'         => $this->input->post('xbbm'),
            'vtgl'             => $this->input->post('xtgl'),
            'vlevel'           => $this->input->post('xlvl0'),
            'vlevelid'         => $this->input->post('xlvlid'),

            'ID_REGIONAL_NAMA' => $this->input->post('xlvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('xlvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('xlvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('xlvl3_nama'),
            'SLOC_NAMA'        => $this->input->post('xlvl4_nama'), //183130

            'BBM'              => $this->input->post('xbbm'), //001
            'BULAN'            => $this->input->post('xtgl'), //1
            'TAHUN'            => $this->input->post('xthn'), //2017
            'JENIS'            => 'XLS',
            'CARI'             => $this->input->post('xCARI')
        );
        $BLN = substr($this->input->post('xtgl'),4,2);
        $data['TANGGAL'] = substr($this->input->post('xtgl'),6,2);
        $data['NAMA_BULAN'] = $this->tbl_get->get_bulan($BLN);
        $data['TAHUN'] = substr($this->input->post('xtgl'),0,4);

        $data['data'] = $this->tbl_get->get_stockakhir_cetak($data);
        $this->load->view($this->_module . '/export_excel', $data);
    }

    public function export_pdf() {
        $data              =  array(
        'ID_REGIONAL'      => $this->input->post('plvl0'), // 01
        'COCODE'           => $this->input->post('plvl1'),
        'PLANT'            => $this->input->post('plvl2'),
        'STORE_SLOC'       => $this->input->post('plvl3'),
        'SLOC'             => $this->input->post('plvl4'), //183130
        'LEVEL'            => $this->input->post('plvlid'),
        'vjns_bbm'         => $this->input->post('pbbm'),
        'vtgl'             => $this->input->post('ptgl'),
        'vlevel'           => $this->input->post('plvl0'),
        'vlevelid'         => $this->input->post('plvlid'),

        'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'), //SUMATERA
        'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
        'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
        'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),
        'SLOC_NAMA'        => $this->input->post('plvl4_nama'), //183130

        'BBM'              => $this->input->post('pbbm'), //001
        'BULAN'            => $this->input->post('ptgl'), //1
        'TAHUN'            => $this->input->post('pthn'), //2017
        'JENIS'            => 'PDF',
        'CARI'             => $this->input->post('pCARI')
        );

        $BLN = substr($this->input->post('ptgl'),4,2);
        $data['TANGGAL'] = substr($this->input->post('ptgl'),6,2);
        $data['NAMA_BULAN'] = $this->tbl_get->get_bulan($BLN);
        $data['TAHUN'] = substr($this->input->post('ptgl'),0,4);
        $data['data'] = $this->tbl_get->get_stockakhir_cetak($data);
        $html_source = $this->load->view($this->_module . '/export_excel', $data,true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_Stok_Akhir_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }

    public function generateXls() {
        
        $data              =  array(
        'ID_REGIONAL'      => $this->input->post('clvl0'), // 01
        'COCODE'           => $this->input->post('clvl1'),
        'PLANT'            => $this->input->post('clvl2'),
        'STORE_SLOC'       => $this->input->post('clvl3'),
        'SLOC'             => $this->input->post('clvl4'), //183130
        'LEVEL'            => $this->input->post('clvlid'),
        'vjns_bbm'         => $this->input->post('cbbm'),
        'vtgl'             => $this->input->post('ctgl'),
        'vlevel'           => $this->input->post('clvl0'),
        'vlevelid'         => $this->input->post('clvlid'),

        'ID_REGIONAL_NAMA' => $this->input->post('clvl0_nama'), //SUMATERA
        'COCODE_NAMA'      => $this->input->post('clvl1_nama'),
        'PLANT_NAMA'       => $this->input->post('clvl2_nama'),
        'STORE_SLOC_NAMA'  => $this->input->post('clvl3_nama'),
        'SLOC_NAMA'        => $this->input->post('clvl4_nama'), //183130

        'BBM'              => $this->input->post('cbbm'), //001
        'BULAN'            => $this->input->post('ctgl'), //1
        'TAHUN'            => $this->input->post('cthn'), //2017
        'JENIS'            => 'PDF',
        'CARI'             => $this->input->post('cCARI')
        );
        
        // create file name
        $fileName = 'data-'.time().'.xlsx';  
        // load excel library
        $this->load->library('excel');
        $listInfo = $this->tbl_get->get_stockakhir_cetak($data);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A7', 'No');
        $objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Level');
        $objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Pembangkit');
        $objPHPExcel->getActiveSheet()->SetCellValue('D7', 'Jenis Bahan Bakar');
        $objPHPExcel->getActiveSheet()->SetCellValue('E7', 'Tgl Stock Terakhir'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('F7', 'Dead Stock (L)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('G7', 'Pemakaian Tertinggi (L)');  
        $objPHPExcel->getActiveSheet()->SetCellValue('H7', 'Stock');  
        $objPHPExcel->getActiveSheet()->SetCellValue('I7', 'Stock Akhir Real'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J7', 'Stock Akhir Efektif'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('K7', 'SHO (Hari)');

        // set Row
        $rowCount = 8;
        foreach ($listInfo as $list) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list['NAMA_REGIONAL']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['LEVEL1']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['LEVEL2']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['LEVEL3']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['LEVEL4']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['NAMA_JNS_BHN_BKR']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['TGL_MUTASI_PERSEDIAAN']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, number_format($list['DEAD_STOCK'],2,',','.'));
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, number_format($list['MAX_PEMAKAIAN'],2,',','.'));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, number_format($list['STOCK_AKHIR_REAL'],2,'.',','));
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, number_format($list['STOCK_AKHIR_EFEKTIF'],2,'.',','));
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, number_format($list['SHO'],2,'.',','));

            $rowCount++;
        }
        
        $filename = "Stock_Akhir_BBM". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output');  
    }
}
/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/stockahirbbm.php */
