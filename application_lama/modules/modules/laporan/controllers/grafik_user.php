<?php

class grafik_user extends MX_Controller{
    private $_title  = 'Grafik Jumlah Login User';
    private $_limit  = 10;
    private $_module = 'laporan/grafik_user';

    public function __construct(){
        parent::__construct();

        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        
        $this->load->model('grafik_user_model', 'grafik_user');
    }

    public function index(){

        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));        
        $this->asset->set_plugin(array('highchart'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('bootstrap-rakhmat', 'font-awesome'));
        $data['opsi_bulan'] = $this->grafik_user->options_bulan();
        $data['opsi_tahun'] = $this->grafik_user->options_tahun();
    
        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';

        echo Modules::run('template/admin', $data);
    }

    // Change

    public function get_grafik(){
        extract($_POST);
        
        $data1 = $this->grafik_user->mget_grafik($bln,$thn);
        echo json_encode($data1);

    }

     public function get_table(){
        extract($_POST);
        $arr = array();
        $data = $this->grafik_user->get_table($bln,$thn);

        foreach ($data as $key) {
            $data2 = $this->grafik_user->get_grafik_detail($bln,$thn,strtoupper($key['LEVEL_USER']));
            $array = array(
                'LEVEL_USER' => $key['LEVEL_USER'],
                'log_count'  => $key['log_count'],
                'user' => $data2
            );
            array_push($arr,$array);
        }

        $data['obj'] = $arr;
        $this->load->view($this->_module . '/table',$data);

    }

    public function tampil($data)
    {
        echo "<pre>";

        print_r($data);

        echo "</pre>";
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
        $listInfo = $this->grafik_user->exportList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A7', 'Username');
        $objPHPExcel->getActiveSheet()->SetCellValue('B7', 'Nama Regional');
        $objPHPExcel->getActiveSheet()->SetCellValue('C7', 'Level 1');
        $objPHPExcel->getActiveSheet()->SetCellValue('D7', 'Level 2'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('E7', 'Level 3');  
        $objPHPExcel->getActiveSheet()->SetCellValue('F7', 'Level 4');  
        $objPHPExcel->getActiveSheet()->SetCellValue('G7', 'Total');  

        // set Row
        $rowCount = 8;
        foreach ($listInfo as $list) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list['USERNAME']);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['NAMA_REGIONAL']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['LEVEL1']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['LEVEL2']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['LEVEL3']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['LEVEL4']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['TOTAL']);

            $rowCount++;
        }
        
        $filename = "Grafik_Jumlah_User". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output');  
    }
}