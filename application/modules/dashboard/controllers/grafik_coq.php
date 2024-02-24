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
class grafik_coq extends MX_Controller {

    private $_title = 'Grafik Kualitas BBM';
    private $_limit = 10;
    private $_module = 'dashboard/grafik_coq';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);                

        /* Load Global Model */
        $this->load->model('grafik_coq_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        // $this->asset->set_plugin(array('highchart'));
        $this->asset->set_plugin(array('jquery'));
        $this->asset->set_plugin(array('font-awesome'));

        $data = $this->get_level_user();

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';

        echo Modules::run("template/admin", $data);
    }

    public function get_level_user(){
       
        $data['options_bbm'] = $this->tbl_get->options_jenis_bahan_bakar();
        $data['opsi_bulan']  = $this->tbl_get->options_bulan(); 
        $data['options_pemasok'] = $this->tbl_get->options_pemasok();

        return $data;
    }
    
    public function set_min_max() {
      extract($_POST);
      $satuan            = $this->tbl_get->get_satuan($id);
      $data['min_max']   = $this->tbl_get->set_min_max($id);
      $data['parameter'] = $this->tbl_get->set_parameter($id,$bln,$thn,$id_pemasok,$id_depo);
      $data['satuan']    = $satuan;

      echo json_encode($data);
    }

    public function get_table() {
        extract($_POST);

        $data['id']         = $id;
        $data['bln']        = $bln;
        $data['bbm']        = $bbm;
        $data['thn']        = $thn;
        $data['id_depo']    = $id_depo;
        $data['id_pemasok'] = $id_pemasok;
        $data['parameter']  = $parameter;
        $data['nama_bulan'] = $nama_bulan;
        $data['list'] = $this->tbl_get->set_parameter($id,$bln,$thn,$id_pemasok,$id_depo);
        $this->load->view($this->_module . '/table',$data);
    }

    public function export_excel() {
        extract($_POST);
        $message = $this->tbl_get->get_tipe_grafik($x_id);

        $data['id']         = $x_id;
        $data['bln']        = $x_bln;
        $data['thn']        = $x_thn;
        $data['nama_bbm']   = $x_bbm;
        $data['parameter']  = $x_parameter;
        $data['id_depo']    = $x_depo;
        $data['id_pemasok']    = $x_pemasok;
        $data['nama_bulan'] = $this->tbl_get->get_bulan($x_bln);
        $data['list']       = $this->tbl_get->set_parameter($x_id,$x_bln,$x_thn,$x_pemasok,$x_depo);
        $data['min_max']    = $this->tbl_get->set_min_max_export($x_id);
        $data['satuan']     = $this->tbl_get->get_satuan($x_id);
        $data['JENIS']      = 'XLS';
        $data['TIPE']       =  $message->TIPE;

        $this->load->view($this->_module . '/export_excel',$data);
    }

    public function export_pdf() {
        extract($_POST);
        $message = $this->tbl_get->get_tipe_grafik($p_id);

        $data['id']         = $p_id;
        $data['bln']        = $p_bln;
        $data['thn']        = $p_thn;
        $data['nama_bbm']   = $p_bbm;
        $data['parameter']  = $p_parameter;
        $data['p_pemasok']  = $p_pemasok;
        $data['id_depo']    = $p_depo;
        $data['list']       = $this->tbl_get->set_parameter($p_id,$p_bln,$p_thn,$p_pemasok,$p_depo);
        $data['nama_bulan'] = $this->tbl_get->get_bulan($p_bln);
        $data['satuan']     = $this->tbl_get->get_satuan($p_id);
        $data['min_max']    = $this->tbl_get->set_min_max_export($p_id);
        $data['JENIS']      = 'PDF';
        $data['TIPE']       =  $message->TIPE;


        $html_source        = $this->load->view($this->_module . '/export_excel', $data,TRUE);

        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('DATA GRAFIK KUALITAS BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }

    public function get_parameter($key=null) {
        $message = $this->tbl_get->options_coq('--Pilih Jenis Parameter--', $key, 0);
        echo json_encode($message);
    }

    public function set_nilai_parameter() {
        extract($_POST);
        $satuan            = $this->tbl_get->get_satuan($id);
        $data['parameter'] = $this->tbl_get->set_nilai_parameter($id,$bln,$thn,$id_pemasok,$id_depo);
        $data['satuan']    = $satuan;

        echo json_encode($data);
    }

    public function get_tipe_grafik() {
        extract($_POST);

        $message = $this->tbl_get->get_tipe_grafik($id);
        $data['TIPE']         = $message->TIPE;
        $data['ID_PARAMETER'] = $message->ID_PARAMETER;
        echo json_encode($data);
    }

    public function get_depo_by_pemasok($key = null) {
        $message = $this->tbl_get->get_depo_by_pemasok('--Pilih Depo--', $key, 0);
        echo json_encode($message);
    }

}
