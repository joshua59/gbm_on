<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * penerimaan bbm controller
 * @author stelin
 */
class Penerimaan extends MX_Controller{
    private $_title  = 'Penerimaan BBM';
    private $_limit  = 10;
    private $_module = 'laporan/penerimaan';

    public function __construct(){
        parent::__construct();

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);

        $this->load->model('persediaan_bbm_model', 'tbl_get');
        $this->load->model('penerimaan_model', 'tbl_penerimaan_get');
    }

    public function index(){
        // Load Modules
        $this->laccess->update_log();
        $this->load->module('template/asset');

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud', 'format_number'));
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
                $data['lv1_options']                  = $this->tbl_get->options_lv1('--Pilih Level 1--', $data_lv[0]->ID_REGIONAL, 1);
            }
        }

        $data['opsi_bbm']   = $this->tbl_penerimaan_get->option_jenisbbm();
        // dd($this->tbl_penerimaan_get->option_jenisbbm());
        $data['opsi_bulan'] = $this->tbl_get->options_bulan();
        $data['opsi_tahun'] = $this->tbl_get->options_tahun();

        $data['page_title']   = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        // $data['data_sources'] = base_url($this->_module . '/getData');
        // $data['data_sources'] = base_url($this->_module . '/load');

        echo Modules::run('template/admin', $data);
    }

    public function getData(){
        // header('Content-Type: application/json');
        $data['JENIS_BBM']     = $this->input->post('JENIS_BBM');
        // $data['BULAN']         = $this->input->post('BULAN');
        // $data['TAHUN']         = $this->input->post('TAHUN');
        $data['TGLAWAL']       = $this->input->post('TGLAWAL');
        $data['TGLAKHIR']      = $this->input->post('TGLAKHIR');
        $data['ID_REGIONAL']   = $this->input->post('ID_REGIONAL');
        $data['VLEVELID']      = $this->input->post('VLEVELID');
        $data['CARI']          = $this->input->post('cari');
        $data                  = $this->tbl_penerimaan_get->getData_Model($data);

        echo json_encode($data);
    }

    public function fetchData(){
        $data = array(
          'ID_BBM'    => $this->input->post('detail_id_bbm'),
          'KODE_UNIT' => $this->input->post('detail_kode_unit'),
          'TGL_AWAL'  => $this->input->post('detail_tgl_awal'),
          'TGL_AKHIR' => $this->input->post('detail_tgl_akhir'),
          'HALAMAN'   => $this->input->post('start'),
          'BARIS'     => $this->input->post('length')
        );

        $data = $this->tbl_penerimaan_get->tempgetData_Model_Detail($data);
        $as   = array();
        $as[] = '1';
        $as[] = 'asd';
        $as[] = 'asdas';
        $asd  = $as;

        $data = array(
          'draw'            => intval($this->input->post('draw')),
          'recordsTotal'    => $this->input->post('length'),
          'recordsFiltered' => $this->input->post('detail_jumlah_terima'),
          'data'            => $asd
        );

        echo json_encode($data);
    }

    public function ambil_data(){
        /*Menagkap semua data yang dikirimkan oleh client*/

        /*Sebagai token yang yang dikrimkan oleh client, dan nantinya akan
        server kirimkan balik. Gunanya untuk memastikan bahwa user mengklik paging
        sesuai dengan urutan yang sebenarnya */
        $draw=$_REQUEST['draw'];

        /*Jumlah baris yang akan ditampilkan pada setiap page*/
        $length=$_REQUEST['length'];

        /*Offset yang akan digunakan untuk memberitahu database
        dari baris mana data yang harus ditampilkan untuk masing masing page
        */
        $start=$_REQUEST['start'];

        /*Keyword yang diketikan oleh user pada field pencarian*/
        $search=$_REQUEST['search']['value'];

        /*Menghitung total desa didalam database*/
        $total=$this->db->count_all_results('villages');

        /*Mempersiapkan array tempat kita akan menampung semua data
        yang nantinya akan server kirimkan ke client*/
        $output=array();

        /*Token yang dikrimkan client, akan dikirim balik ke client*/
        $output['draw']=$draw;

        /*
        $output['recordsTotal'] adalah total data sebelum difilter
        $output['recordsFiltered'] adalah total data ketika difilter
        Biasanya kedua duanya bernilai sama, maka kita assignment
        keduaduanya dengan nilai dari $total
        */
        $output['recordsTotal']=$output['recordsFiltered']=$total;

        /*disini nantinya akan memuat data yang akan kita tampilkan
        pada table client*/
        $output['data']=array();

        /*Jika $search mengandung nilai, berarti user sedang telah
        memasukan keyword didalam filed pencarian*/
        if ($search != '') {
            $this->db->like('name', $search);
        }

        /*Lanjutkan pencarian ke database*/
        $this->db->limit($length, $start);
        /*Urutkan dari alphabet paling terkahir*/
        $this->db->order_by('name', 'DESC');
        $query=$this->db->get('villages');

        /*Ketika dalam mode pencarian, berarti kita harus mengatur kembali nilai
        dari 'recordsTotal' dan 'recordsFiltered' sesuai dengan jumlah baris
        yang mengandung keyword tertentu
        */
        if ($search != '') {
            $this->db->like('name', $search);
            $jum                   =$this->db->get('villages');
            $output['recordsTotal']=$output['recordsFiltered']=$jum->num_rows();
        }

        $nomor_urut=$start + 1;
        foreach ($query->result_array() as $desa) {
            $output['data'][]=array($nomor_urut, $desa['name']);
            $nomor_urut++;
        }

        echo json_encode($output);
    }

    public function getDataDetail(){
        $data = array(
            'ID_BBM'    => $this->input->post('detail_id_bbm'),
            // 'BULAN'     => $this->input->post('detail_bulan'),
            // 'TAHUN'     => $this->input->post('detail_tahun'),
            'KODE_UNIT' => $this->input->post('detail_kode_unit'),
            'TGL_AWAL'  => $this->input->post('detail_tgl_awal'),
            'TGL_AKHIR' => $this->input->post('detail_tgl_akhir')
        );
        $data = $this->tbl_penerimaan_get->getData_Model_Detail($data);
        echo json_encode($data);
    }

    public function getDataDetailBIO(){
        $data = array(
            'ID_BBM'    => $this->input->post('detail_id_bbm'),            
            'KODE_UNIT' => $this->input->post('detail_kode_unit'),
            'TGL_AWAL'  => $this->input->post('detail_tgl_awal'),
            'TGL_AKHIR' => $this->input->post('detail_tgl_akhir')
        );
        $data = $this->tbl_penerimaan_get->getData_Model_Detail_Bio($data);
        echo json_encode($data);
    }    

    public function export_excel(){
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
            'JENIS_BBM'        => $this->input->post('xbbm'),
            'VLEVELID'         => $this->input->post('xlvlid'),
            // 'BULAN'            => $this->input->post('xbln'), //1
            // 'TAHUN'            => $this->input->post('xthn'), //2017
            'TGLAWAL'          => $this->input->post('xtglawal'),
            'TGLAKHIR'         => $this->input->post('xtglakhir'),
            'CARI'             => $this->input->post('xcari'),
            'JENIS'            => 'XLS'
        );

        $data['data'] = $this->tbl_penerimaan_get->getData_Model($data);
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
          // 'BULAN'      => $this->input->post('pbln'),
          // 'TAHUN'      => $this->input->post('pthn'),
          'TGLAWAL'    => $this->input->post('ptglawal'),
          'TGLAKHIR'   => $this->input->post('ptglakhir'),
          'CARI'       => $this->input->post('pcari'),
          'JENIS'      => $this->input->post('PDF')
      );

        $data['data'] = $this->tbl_penerimaan_get->getData_Model($data);
        $html_source  = $this->load->view($this->_module . '/export_excel', $data, true);

        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_Penerimaan_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }       

    public function export_excel_detail(){
        header('Content-Type: application/json');
        $data                = array(
            // 'LVL0'             => $this->input->post('xlvl'),
            'ID_REGIONAL'      => $this->input->post('xlvl_detail'), // 01
            'COCODE'           => $this->input->post('xlvl1_detail'),
            'PLANT'            => $this->input->post('xlvl2_detail'),
            'STORE_SLOC'       => $this->input->post('xlvl3_detail'),

            'ID_REGIONAL_NAMA'  => $this->input->post('xlvl0_nama_detail'), //SUMATERA
            'COCODE_NAMA'       => $this->input->post('xlvl1_nama_detail'),
            'PLANT_NAMA'        => $this->input->post('xlvl2_nama_detail'),
            'STORE_SLOC_NAMA'   => $this->input->post('xlvl3_nama_detail'),
            'SLOC'              => $this->input->post('xlvl4'), //183130

            'ID_BBM'            => $this->input->post('xidbbm_detail'),
            'KODE_UNIT'         => $this->input->post('xkodeUnit_detail'),
            'TGL_AWAL'          => $this->input->post('xtglawal_detail'),
            'TGL_AKHIR'         => $this->input->post('xtglakhir_detail'),
            'JENIS'             => 'XLS'
        );

        // print_r($data); die;

        $data['data'] = $this->tbl_penerimaan_get->getData_Model_Detail($data);
        $this->load->view($this->_module . '/export_excel_detail', $data);
    }

    public function export_pdf_detail(){
        $data = array(
          'ID_REGIONAL' => $this->input->post('plvl'),
          'COCODE'      => $this->input->post('plvl1'),
          'PLANT'       => $this->input->post('plvl2'),
          'STORE_SLOC'  => $this->input->post('plvl3'),

          'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama'),
          'COCODE_NAMA'      => $this->input->post('plvl1_nama'),
          'PLANT_NAMA'       => $this->input->post('plvl2_nama'),
          'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama'),

          'SLOC'              => $this->input->post('plvl4'),
          'ID_BBM'            => $this->input->post('pidbbm_detail'),
          'KODE_UNIT'         => $this->input->post('pkodeUnit_detail'),
          'TGL_AWAL'          => $this->input->post('ptglawal_detail'),
          'TGL_AKHIR'         => $this->input->post('ptglakhir_detail'),
          'JENIS'             => $this->input->post('PDF')
        );

        $data['data'] = $this->tbl_penerimaan_get->getData_Model_Detail($data);
        // $this->load->view($this->_module . '/export_excel_detail', $data);
        $html_source  = $this->load->view($this->_module . '/export_excel_detail', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_Detail_Penerimaan_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }    

    public function export_excel_bio(){
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
            'JENIS_BBM'        => $this->input->post('xbbm'),
            'VLEVELID'         => $this->input->post('xlvlid'),
            // 'BULAN'            => $this->input->post('xbln'), //1
            // 'TAHUN'            => $this->input->post('xthn'), //2017
            'TGLAWAL'          => $this->input->post('xtglawal_bio'), //$this->input->post('xtglawal'),
            'TGLAKHIR'         => $this->input->post('xtglakhir_bio'),//$this->input->post('xtglakhir'),
            'CARI'             => $this->input->post('xcari'),

            'ID_BBM'          => $this->input->post('xbbm'),
            'KODE_UNIT'       => $this->input->post('xkode_unit'),
            'TGL_AWAL'        => $this->input->post('xtglawal_bio'),
            'TGL_AKHIR'       => $this->input->post('xtglakhir_bio'),
            'JENIS'           => 'XLS'
        );          

        $data['data'] = $this->tbl_penerimaan_get->getData_Model_Detail($data);
        $this->load->view($this->_module . '/export_excel_bio', $data);
    }     

    public function export_pdf_bio(){
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
          // 'BULAN'      => $this->input->post('pbln'),
          // 'TAHUN'      => $this->input->post('pthn'),
          'TGLAWAL'    => $this->input->post('ptglawal_bio'), //$this->input->post('ptglawal'),
          'TGLAKHIR'   => $this->input->post('ptglakhir_bio'), //$this->input->post('ptglakhir'),
          // 'CARI'       => $this->input->post('pcari'),

          'ID_BBM'          => $this->input->post('pbbm'),
          'KODE_UNIT'       => $this->input->post('pkode_unit'),
          'TGL_AWAL'        => $this->input->post('ptglawal_bio'),
          'TGL_AKHIR'       => $this->input->post('ptglakhir_bio'),

          'JENIS'      => $this->input->post('PDF')
      );

        $data['data'] = $this->tbl_penerimaan_get->getData_Model_Detail($data);
        $html_source  = $this->load->view($this->_module . '/export_excel_bio', $data, true);

        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_Penerimaan_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }        

    public function export_excel_detail_bio(){
        header('Content-Type: application/json');
        $data                = array(
            // 'LVL0'             => $this->input->post('xlvl'),
            'ID_REGIONAL'      => $this->input->post('xlvl_detail'), // 01
            'COCODE'           => $this->input->post('xlvl1_detail'),
            'PLANT'            => $this->input->post('xlvl2_detail'),
            'STORE_SLOC'       => $this->input->post('xlvl3_detail'),

            'ID_REGIONAL_NAMA'  => $this->input->post('xlvl0_nama_detail'), //SUMATERA
            'COCODE_NAMA'       => $this->input->post('xlvl1_nama_detail'),
            'PLANT_NAMA'        => $this->input->post('xlvl2_nama_detail'),
            'STORE_SLOC_NAMA'   => $this->input->post('xlvl3_nama_detail'),
            'SLOC'              => $this->input->post('xlvl4'), //183130

            'ID_BBM'            => $this->input->post('xidbbm_detail'),
            'KODE_UNIT'         => $this->input->post('xkodeUnit_detail'),
            'TGL_AWAL'          => $this->input->post('xtglawal_detail'),
            'TGL_AKHIR'         => $this->input->post('xtglakhir_detail'),
            'JENIS'             => 'XLS'
        );

        $data['data'] = $this->tbl_penerimaan_get->getData_Model_Detail_Bio($data);
        $this->load->view($this->_module . '/export_excel_detail_bio', $data);
    }    

    public function export_pdf_detail_bio(){
        $data = array(
          'ID_REGIONAL' => $this->input->post('plvl_detail'),
          'COCODE'      => $this->input->post('plvl1_detail'),
          'PLANT'       => $this->input->post('plvl2_detail'),
          'STORE_SLOC'  => $this->input->post('plvl3_detail'),

          'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama_detail'),
          'COCODE_NAMA'      => $this->input->post('plvl1_nama_detail'),
          'PLANT_NAMA'       => $this->input->post('plvl2_nama_detail'),
          'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama_detail'),

          'SLOC'              => $this->input->post('plvl4_detail'),
          'ID_BBM'            => $this->input->post('pidbbm_detail'),
          'KODE_UNIT'         => $this->input->post('pkodeUnit_detail'),
          'TGL_AWAL'          => $this->input->post('ptglawal_detail'),
          'TGL_AKHIR'         => $this->input->post('ptglakhir_detail'),
          'JENIS'             => $this->input->post('PDF')
        );

        $data['data'] = $this->tbl_penerimaan_get->getData_Model_Detail_Bio($data);        
        $html_source  = $this->load->view($this->_module . '/export_excel_detail_bio', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_Detail_Penerimaan_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }    

    public function tempDetail(){
        $halaman = $this->input->post('halaman');
        if (!isset($halaman)) {
            $halaman = '1';
        }
        $data = array(
            'ID_BBM'    => $this->input->post('detail_id_bbm'),
            // 'BULAN'     => $this->input->post('detail_bulan'),
            // 'TAHUN'     => $this->input->post('detail_tahun'),
            'KODE_UNIT' => $this->input->post('detail_kode_unit'),
            'TGL_AWAL'  => $this->input->post('detail_tgl_awal'),
            'TGL_AKHIR' => $this->input->post('detail_tgl_akhir'),
            'HALAMAN'   => $halaman,
            'BARIS'     => '10'
        );
        $data = $this->tbl_penerimaan_get->tempgetData_Model_Detail($data);
        echo json_encode($data);
    }

    public function nextPage(){
        $halaman = $this->input->post('halaman');
        $baris   = $this->input->post('baris');
        if (!isset($halaman)) {
            $halaman = '1';
        }
        if (!isset($baris)) {
            $baris = '10';
        }
        // die(var_dump($halaman));
        $data = array(
            'ID_BBM'    => $this->input->post('detail_id_bbm'),
            // 'BULAN'     => $this->input->post('detail_bulan'),
            // 'TAHUN'     => $this->input->post('detail_tahun'),
            'KODE_UNIT' => $this->input->post('detail_kode_unit'),
            'TGL_AWAL'  => $this->input->post('detail_tgl_awal'),
            'TGL_AKHIR' => $this->input->post('detail_tgl_akhir'),
            'HALAMAN'   => $halaman,
            'BARIS'     => '10'
        );
        $data = $this->tbl_penerimaan_get->tempgetData_Model_Detail($data);
        echo json_encode($data);
    }

    public function testDetail(){
        header('Content-Type: application/json');
        $data = array(
          'ID_BBM'    => $this->input->post('detail_id_bbm'),
          // 'BULAN'     => $this->input->post('detail_bulan'),
          // 'TAHUN'     => $this->input->post('detail_tahun'),
          'KODE_UNIT' => $this->input->post('detail_kode_unit'),
          'TGL_AWAL'  => $this->input->post('detail_tgl_awal'),
          'TGL_AKHIR' => $this->input->post('detail_tgl_akhir')
      );
        $data = $this->tbl_penerimaan_get->testDetail();
        echo json_encode($data);
    }
    
    // Percobaan TCPDF 5februari
    // Percobaan mpdf 5februari
    // Percobaan fpdf 5februari
    // Percobaan wkhtmltopdf 6februari
    public function export_pdf_detail_newVersion()
    {
        $data = array(
          'ID_REGIONAL' => $this->input->post('plvl_detail'),
          'COCODE'      => $this->input->post('plvl1_detail'),
          'PLANT'       => $this->input->post('plvl2_detail'),
          'STORE_SLOC'  => $this->input->post('plvl3_detail'),

          'ID_REGIONAL_NAMA' => $this->input->post('plvl0_nama_detail'),
          'COCODE_NAMA'      => $this->input->post('plvl1_nama_detail'),
          'PLANT_NAMA'       => $this->input->post('plvl2_nama_detail'),
          'STORE_SLOC_NAMA'  => $this->input->post('plvl3_nama_detail'),

          // 'SLOC'              => $this->input->post('plvl4'),
          'ID_BBM'            => $this->input->post('pidbbm_detail'),
          'KODE_UNIT'         => $this->input->post('pkodeUnit_detail'),
          'TGL_AWAL'          => $this->input->post('ptglawal_detail'),
          'TGL_AKHIR'         => $this->input->post('ptglakhir_detail'),
          'JENIS'             => $this->input->post('PDF')
        );

        $data['data']   = $this->tbl_penerimaan_get->getData_Model_Detail($data);

        $html_source  = $this->load->view($this->_module . '/export_excel_detail', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('Laporan_Detail_Penerimaan_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }

    private function wkhtmltopdf(array $conf){
        $pdf = new Pdf($conf['html'], array(
          'commandOptions' => array(
            'useExec' => true
          )
        ));
        $pdf->setOptions(array(
          'orientation'=> $conf['orientation']
        ));

        $pdf->send($conf['fileName']);
    }

    public function generateXls() {
        
        $data                = array(
            'LVL0'             => $this->input->post('clvl'),
            'ID_REGIONAL'      => $this->input->post('clvl0'),
            'COCODE'           => $this->input->post('clvl1'),
            'PLANT'            => $this->input->post('clvl2'),
            'STORE_SLOC'       => $this->input->post('clvl3'),

            'ID_REGIONAL_NAMA' => $this->input->post('clvl0_nama'), //SUMATERA
            'COCODE_NAMA'      => $this->input->post('clvl1_nama'),
            'PLANT_NAMA'       => $this->input->post('clvl2_nama'),
            'STORE_SLOC_NAMA'  => $this->input->post('clvl3_nama'),

            'SLOC'             => $this->input->post('clvl4'), //183130
            'JENIS_BBM'        => $this->input->post('cbbm'),
            'VLEVELID'         => $this->input->post('clvlid'),
            'TGLAWAL'          => $this->input->post('ctglawal'),
            'TGLAKHIR'         => $this->input->post('ctglakhir'),
            'CARI'             => $this->input->post('ccari')
        );

        // create file name
        $fileName = 'data-'.time().'.xlsx';  
        // load excel library
        $this->load->library('excel');
        $listInfo = $this->tbl_penerimaan_get->exportList($data);

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Unit');

        $objPHPExcel->getActiveSheet()->SetCellValue('C2', 'Jenis Bahan Bakar');
        $objPHPExcel->getActiveSheet()->SetCellValue('D2', 'Tgl Awal Terima');
        $objPHPExcel->getActiveSheet()->SetCellValue('E2', 'Tgl Akhir Terima'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Jenis Penerimaan Total');  
        $objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Jenis Penerimaan Unit Lain');  
        $objPHPExcel->getActiveSheet()->SetCellValue('H2', 'Jenis Penerimaan Pemasok');  
        $objPHPExcel->getActiveSheet()->SetCellValue('I2', 'Jenis Penerimaan Pengembalian'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('J2', 'Total Volume Terima DO (L)'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('K2', 'Total Volume Terima Real (L)');

        // set Row
        $rowCount = 3;
        foreach ($listInfo as $list) {
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list['UNIT']);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list['NAMA_JNS_BHN_BKR']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list['TGL_TERIMA_AWAL']);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $list['TGL_TERIMA_AKHIR']);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $list['JML_TERIMA']);
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $list['TERIMA_UNIT_LAIN']);
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list['TERIMA_PEMASOK']);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $list['TERIMA_PENGEMBALIAN']);
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, $list['VOL_TERIMA']);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, $list['VOL_TERIMA_REAL']);

            $rowCount++;
        }
      
        $filename = "Laporan_Penerimaan". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->setDelimiter(";");
        $objWriter->save('php://output');  
    }
}
