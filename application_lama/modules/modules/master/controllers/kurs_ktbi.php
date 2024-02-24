<?php

 /**
* @module KURS
* @author  RAKHMAT WIJAYANTO
* @created at 07 NOVEMBER 2017
* @modified at 07 OKTOBER 2017
*/

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @module KURS
 */
class kurs_ktbi extends MX_Controller {

    private $_title = 'KURS (KTBI)';
    private $_limit = 10;
    private $_module = 'master/kurs_ktbi';

    public function __construct() {
        parent::__construct();

        // Protection
        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);


        /* Load Global Model */
        $this->load->model('kurs_ktbi_model', 'tbl_get');
    }

    public function index() {
        // Load Modules
        $this->laccess->update_log();
        $this->load->module("template/asset");

        // Memanggil plugin JS Crud
        $this->asset->set_plugin(array('crud'));

        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array('class' => 'btn yellow', 'id' => 'button-add', 'onclick' => 'load_form_modal(this.id)', 'data-source' => base_url($this->_module . '/add'))),
                anchor(null, '<i class="icon-cloud-download"></i> Get Kurs BI (KTBI)', array('class' => 'btn green', 'id' => 'button-get-kurs'))
            );
        }

        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    public function add($id = '') {
        $page_title = 'Tambah '.$this->_title;
        $data['id'] = $id;
        if ($id != '') {
            $page_title = 'Edit '.$this->_title;
            $get_data = $this->tbl_get->data($id);
            $data['default'] = $get_data->get()->row();
        }
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $page_title;
        $data['form_action'] = base_url($this->_module . '/proses');
        $this->load->view($this->_module . '/form', $data);
    }

    public function edit($id) {
        $this->add($id);
    }

    public function proses() {

        $id = $this->input->post('id');

        $this->form_validation->set_rules('NOMINAL', 'Nominal Beli', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('TGL_KURS', 'Tanggal Kurs', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('JUAL', 'Nominal Jual', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('KTBI', 'KURS (JISDOR)', 'trim|required|max_length[50]');
        if ($this->form_validation->run($this)) {
            $message = array(false, 'Proses gagal', 'Proses penyimpanan data gagal.', '');
            
            $data = array();
            
            $data['NOMINAL'] = $this->input->post('NOMINAL');
            $data['JUAL'] = $this->input->post('JUAL');
            $data['KTBI'] = $this->input->post('KTBI');
            $data['TGL_KURS'] = $this->input->post('TGL_KURS');
            $TGL_KURS = $data['TGL_KURS'];
            if ($id == '') {
                 
                if ($this->tbl_get->check_tanggal($TGL_KURS) == FALSE)
                {
                    $message = array(false, 'Proses GAGAL', ' Tanggal Kurs '.$TGL_KURS.' Sudah Ada.', '');
                }
                else{
                    $data['CD_BY_KURS'] = $this->session->userdata('user_name');
                    $data['CD_DATE_KURS'] = date("Y-m-d"); 
                    $data['UPDATE_KTBI'] = date("Y-m-d H:i:s");

                    if ($this->tbl_get->save_as_new($data)) {
                        $message = array(true, 'Proses Berhasil', 'Proses penyimpanan data berhasil.', '#content_table');
                    }
                }
                
            } else {
                $get_data = $this->tbl_get->data($id);
                $default = $get_data->get()->row(); 

                if($TGL_KURS == $default->TGL_KURS) {
                    $data['UPDATE_KTBI'] = date("Y-m-d H:i:s");
                    if ($this->tbl_get->save($data, $id)) {
                        $message = array(true, 'Proses Berhasil', 'Proses update data berhasil.', '#content_table');
                    }
                } else  {
                    if($this->tbl_get->check_tanggal($TGL_KURS) == FALSE) {
                        $message = array(false, 'Proses GAGAL', ' Tanggal Kurs '.$TGL_KURS.' Sudah Ada.', '');
                    }
                }            
            }
            
        } else {
            $message = array(false, 'Proses gagal', validation_errors(), '');
        }
        echo json_encode($message, true);
    }

    public function load($page = 1) {
        $data_table = $this->tbl_get->data_table($this->_module, $this->_limit, $page);
        $this->load->library("ltable");
        $table = new stdClass();
        $table->id = 'ID_KURS';
        $table->style = "table table-striped table-bordered table-hover datatable dataTable";
        $table->align = array('ID_KURS' => 'center', 'TGL_KURS' => 'center', 'JUAL' => 'right', 'NOMINAL' => 'right', 'KTBI' => 'right', 'UPDATE_KTBI' => 'center', 'CD_BY_KURS' => 'center','aksi' => 'center');
        $table->page = $page;
        $table->limit = $this->_limit;
        $table->jumlah_kolom = 8;
        $table->header[] = array(
            "NO", 1, 1,
            "TANGGAL", 1, 1,
            "KURS JUAL", 1, 1,
            "KURS BELI", 1, 1,
            "KURS KTBI", 1, 1,
            "LAST_UPDATE", 1, 1,
            "TRANSAKSI_BY", 1, 1,
            "Aksi", 1, 1
            
        );
        $table->total = $data_table['total'];
        $table->content = $data_table['rows'];
        $data = $this->ltable->generate($table, 'js', true);
        echo $data;
    }

    public function get_ktbi() {
        // include('../simple_html_dom.php');
        include './assets/plugin/getktbi/simple_html_dom.php';

        $html = file_get_html('https://www.bi.go.id/id/moneter/informasi-kurs/transaksi-bi/Default.aspx');
         
        $last_update = '';
        // $date_update = $this->tanggal_indo(date("Y-m-d")); // 20 Maret 2016;
        $date_update = date("Y-m-d H:i:s"); // 20 Maret 2016;
        foreach($html->find('span[id=ctl00_PlaceHolderMain_biWebKursTransaksiBI_lblUpdate]') as $last_) {
            $last_update = $last_->innertext;
        }
        // print("<pre>".print_r($last_update,true)."</pre>");


        foreach($html->find('table[id=ctl00_PlaceHolderMain_biWebKursTransaksiBI_GridView1]') as $table) {
            // initialize empty array to store the data array from each row
            $theData = array();
            // loop over rows
            $first = true;
            foreach($table->find('tr') as $row) {
                // initialize array to store the cell data from each row
                $rowData = array();
                foreach($row->find('th') as $cell) {
                    // push the cell's text to the array
                    $rowData[] = $cell->innertext;
                }

                if ($first){
                    $rowData[] = 'Last Update BI';
                    $rowData[] = 'Date Update';
                }

                foreach($row->find('td') as $cell) {
                    // push the cell's text to the array
                    $rowData[] = $cell->innertext;
                }
          
                if (!$first){
                    $rowData[] = $this->set_tgl_db($last_update);
                    $rowData[] = $date_update;
                }
                $first = false;

                // push the row's data array to the 'big' array
                $theData[] = $rowData;
            }
        }

        // print("<pre>".print_r($theData,true)."</pre>");
        // echo '<br><br>';

        foreach ($theData as $row) {
            if (trim($row[0])=='USD'){
                $data = array();

                $data['JUAL'] = str_replace(",","",$row[2]);
                $data['NOMINAL'] = str_replace(",","",$row[3]);

                $data['KTBI'] = ($data['JUAL'] + $data['NOMINAL']) / 2;
                $data['KTBI'] = number_format($data['KTBI'],2);
                $data['KTBI'] = str_replace(",","",$data['KTBI']);

                $data['TGL_KURS'] = $row[5];
                $data['UPDATE_KTBI'] = $row[6];

                $data['CD_BY_KURS'] = $this->session->userdata('user_name');
                $data['CD_DATE_KURS'] = date("Y-m-d"); 

                break;
            }
        }        

        $rest = 'Last update Kurs BI '.$data['TGL_KURS'].', <br>';
        if ($this->tbl_get->check_tanggal($data['TGL_KURS']) == FALSE){
            $rest.= 'Tanggal Kurs KTBI '.$data['TGL_KURS'].' Sudah ada di data kurs aplikasi GBM Online';
            $message = array(false, 'Proses Gagal', $rest);
        } else {
            if ($this->tbl_get->save_as_new($data)) {
                $rest.= 'Get kurs KTBI tanggal '.$data['TGL_KURS'].' '.number_format($data['KTBI'],2,",",".").' telah ditambahkan ke data kurs aplikasi GBM Online';
                $message = array(true, 'Proses Berhasil', $rest);
            } else {
                $rest.= 'Gagal insert data';
                $message = array(false, 'Proses Gagal', $rest);
            }            
        }
        
        echo json_encode($message, true);

    }

    public function get_jisdor() {
        include './assets/plugin/getktbi/simple_html_dom.php';

        $html = file_get_html('https://www.bi.go.id/id/moneter/informasi-kurs/referensi-jisdor/Default.aspx');
        
        foreach($html->find('table[class=table1]') as $table) {
            // initialize empty array to store the data array from each row
            $theData = array();
            $x = 0;
            // loop over rows
            foreach($table->find('tr') as $row) {
                // initialize array to store the cell data from each row
                $rowData = array();
                foreach($row->find('th') as $cell) {
                    // push the cell's text to the array
                    $rowData[] = $cell->innertext;
                }

                $ke = 1;
                foreach($row->find('td') as $cell) {
                    // push the cell's text to the array trim($cell->innertext,"")
                    if ($ke==1){
                        $rowData[] = $this->set_tgl_db_eng(trim($cell->innertext,' '));
                        // $rowData[] = $this->set_tgl_db_eng($cell->innertext);
                    } else {
                        $kurs = trim($cell->innertext,' ');    
                        $rowData[] = str_replace(',','',$kurs);
                    }
                    $ke++;
                }
          
                // push the row's data array to the 'big' array
                if ($x==1){
                    $theData[] = $rowData; 
                    break;
                }
                $x++;
            }
        }

        // print("<pre>".print_r($theData,true)."</pre>");
        // echo '<br><br>';

        foreach ($theData as $row) {
            $data = array();

            $data['KTBI'] = $row[1];                
            $data['TGL_KURS'] = $row[0];
            $data['UPDATE_KTBI'] = date("Y-m-d H:i:s");

            $data['CD_BY_KURS'] = $this->session->userdata('user_name');
            $data['CD_DATE_KURS'] = date("Y-m-d"); 
        }

        // print("<pre>".print_r($data,true)."</pre>"); die;
        $rest = 'Last update Kurs BI '.$data['TGL_KURS'].', <br>';
        if ($this->tbl_get->check_tanggal($data['TGL_KURS']) == FALSE){
            $rest.= 'Tanggal Kurs '.$data['TGL_KURS'].' Sudah ada di data kurs aplikasi GBM Online';
            $message = array(false, 'Proses Gagal', $rest);
        } else {
            if ($this->tbl_get->save_as_new($data)) {
                $rest.= 'Get kurs tanggal '.$data['TGL_KURS'].' '.number_format($data['KTBI'],2,",",".").' telah ditambahkan ke data kurs aplikasi GBM Online';
                $message = array(true, 'Proses Berhasil', $rest);
            } else {
                $rest.= 'Gagal insert data';
                $message = array(false, 'Proses Gagal', $rest);
            }            
        }
        
        echo json_encode($message, true);
    }

    public function set_tgl_db($tanggal){
        $bulan = array ('01' =>   'Januari',
                        '02' =>   'Februari',
                        '03' =>   'Maret',
                        '04' =>   'April',
                        '05' =>   'Mei',
                        '06' =>   'Juni',
                        '07' =>   'Juli',
                        '08' =>   'Agustus',
                        '09' =>   'September',
                        '10' =>   'Oktober',
                        '11' =>   'November',
                        '12' =>   'Desember'
                );

        $split = explode(' ', $tanggal);
        $tgl = (int)$split[0];
        if ($tgl < 10){$tgl='0'.$tgl;}

        return (int)$split[2] . '-' . array_search($split[1],$bulan). '-' . $tgl;
    }

    public function set_tgl_db_eng($tanggal){
        $bulan = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'September',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );

        $split = explode(' ', $tanggal);
        $tgl = (int)$split[0];
        if ($tgl < 10){$tgl='0'.$tgl;}

        return (int)$split[2] . '-' . array_search($split[1],$bulan). '-' . $tgl;
    }

    public function delete($id) {
        $message = array(false, 'Proses gagal', 'Proses hapus data gagal.', '');

        if ($this->tbl_get->delete($id)) {
            $message = array(true, 'Proses Berhasil', 'Proses hapus data berhasil.', '#content_table');
        }
        echo json_encode($message);
    }

}

/* End of file wilayah.php */
/* Location: ./application/modules/wilayah/controllers/wilayah.php */
?>