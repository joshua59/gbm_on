<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * @package Template
 */
class template extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load Modules
        $this->load->module("template/asset");

        // Load global template
        $this->load->model('template_model');

        // Set Autoload
        $this->asset->set_favicon('img/favicon.png');
        $this->asset->set_plugin(array('jquery', 'jquery.ui', 'bootstrap'));
        $this->asset->set_css(array('stylesheet', 'icon/font-awesome', 'custom'));
    }

    public function login($data = array())
    {

        $this->asset->set_plugin(array(
            'collapsible', 'mCustomScrollbar', 'mousewheel', 'uniform', 'sparkline',
            'minicolors', 'tagsinput', 'autosize', 'chosen', 'charCount',
            'flatpoint_core', 'msgbox'
        ));

        // Memanggil Javascript & CSS
        $data["favicon"] = $this->asset->get_favicon();
        $data["js_header"] = $this->asset->get_js();
        $data["css_header"] = $this->asset->get_css();

        $dparam = $this->template_model->parameter();
        $arr_setting = array();
        foreach ($dparam->result() as $row) {

            $arr_setting[$row->SETTING] = $row->VALUE;
        }
        $data['app_parameter'] = $arr_setting; //$this->template_model->parameter();
        $this->load->view("login", $data);
    }

    public function admin($data = array())
    {

        // Set autoload plugin
        $this->asset->set_plugin(array(
            'collapsible', 'mCustomScrollbar', 'mousewheel', 'uniform', 'sparkline',
            'minicolors', 'tagsinput', 'autosize', 'chosen', 'charCount',
            'flatpoint_core', 'msgbox'
        ));

        $this->asset->set_js('custom/clock');

        // Memanggil Javascript & CSS
        $data["favicon"] = $this->asset->get_favicon();
        $data["js_header"] = $this->asset->get_js();
        $data["css_header"] = $this->asset->get_css();

        $data['main_menu'] = $this->main_menu();
        $dparam = $this->template_model->parameter();
        $arr_setting = array();
        foreach ($dparam->result() as $row) {

            $arr_setting[$row->SETTING] = $row->VALUE;
        }

        $data['app_parameter'] = $arr_setting;

        $this->load->view("admin", $data);
    }

    private function main_menu()
    {
        $roles_id = $this->session->userdata('roles_id');
        $segment1 = $this->uri->segment(1);
        $segment2 = $this->uri->segment(2);

        $active_group = '';

        $record = $this->template_model->data_menu($roles_id)->get();
        $data = $record->result();

        $temp_menu = array();
        foreach ($data as $value) {
            $pos = '';

            $parent_id = $value->M_M_MENU_ID;
            $parent = !empty($parent_id) ? $parent_id : 0;

            $com_segment = $segment1 . '/' . $segment2;
            $menu_url = $value->MENU_URL;
            $explode_url = explode('/', $menu_url);
            $e1 = isset($explode_url[0]) ? $explode_url[0] : '';
            $e2 = isset($explode_url[1]) ? $explode_url[1] : '';

            if ($segment1 == $menu_url || ($segment1 == $e1 && $e1 == $e2) || $com_segment == $menu_url) {
                $active_group = $parent_id;

                //darurat untuk active menu lv 3
                if ($active_group == '043') {
                    $active_group = '001';
                }
                // print_r('$segment1 ='.$segment1.' $menu_ur='.$menu_ur.' $e1='.$e1.' $e2='.$e2.' $com_segment='.$com_segment.' $parent_id='.$parent_id); die;

                $pos = 'border-color:#0072c6';
            }

            $temp_menu[$parent][] = (object) array(
                'kd_menu' => $value->MENU_ID,
                'kd_parent' => $parent_id,
                'nama_menu' => $value->MENU_NAMA,
                'url' => $value->MENU_URL,
                'icon' => $value->MENU_ICON,
                'pos' => $pos
            );
        }

        $menu = '<ul class="main">';

        $cuk = 0;
        if (isset($temp_menu[0])) {
            foreach ($temp_menu[0] as $group) {
                $expand = '';
                $actived = '';

                if ($active_group == $group->kd_menu) {
                    $expand = ' class="expand" id="current" ';
                    $actived = 'class="active navAct"';
                }
                $menu .= '<li ' . $actived . '>';

                if (isset($temp_menu[$group->kd_menu])) {
                    $menu .= '  <a ' . $expand . ' style="cursor:pointer;"><i class="' . $group->icon . '"></i> ' . $group->nama_menu . '</a>';

                    $menu .= '  <ul class="sub_main">';
                    foreach ($temp_menu[$group->kd_menu] as $level1) {
                        if (isset($temp_menu[$level1->kd_menu])) {
                            $menu .= '<li><a style="color:#0072c6;font-weight:bold;"><i class="icon-menu"></i> ' . $level1->nama_menu . '</a></li>';

                            foreach ($temp_menu[$level1->kd_menu] as $level2) {

                                if (isset($temp_menu[$level2->kd_menu])) {
                                    $menu .= '<li><a style="padding-left:18px;font-weight:bold;"><i class="icon-menu"></i> ' . $level2->nama_menu . '</a></li>';

                                    foreach ($temp_menu[$level2->kd_menu] as $level3) {
                                        $menu .= '  <li><a href="' . $this->set_url($level3->url) . '" style="padding-left:30px;' . $level3->pos . '"><i class="icon-menu"></i> ' . $level3->nama_menu . ' </a></li>';
                                    }
                                } else {
                                    $menu .= '<li><a href="' . $this->set_url($level2->url) . '" style="padding-left:18px;font-weight:bold;' . $level2->pos . '"><i class="icon-menu"></i> ' . $level2->nama_menu . ' </a></li>';
                                }
                            }
                        } else {
                            $menu .= '<li><a href="' . $this->set_url($level1->url) . '" style="font-weight:bold;color:#0072c6;' . $level1->pos . '"><i class="icon-menu"></i> ' . $level1->nama_menu . '</a></li>';
                        }
                    }
                    $menu .= '  </ul>';
                } else {
                    $menu .= '  <a ' . $expand . ' href="' . $this->set_url($group->url) . '" style="cursor:pointer;"><i class="' . $group->icon . '"></i> ' . $group->nama_menu . '</a>';
                    // break;
                }
                $menu .= '</li>';
            }
        }
        $menu .= '</ul>';

        return $menu;
    }

    private function set_url($url)
    {

        switch ($url) {
            case 'moodle':
                $full_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $url;
                break;
            default:
                $full_url = base_url($url);
                break;
        }
        return $full_url;
    }

    public function get_notif_kirim()
    {
        $message = $this->template_model->get_notif_kirim();
        echo json_encode($message);
    }

    public function sess()
    {
        $this->session->set_userdata('in_berita', $this->input->post('in_berita'));
        echo json_encode($this->session->userdata('in_berita'));
    }

    public function get_ktbi()
    {
        // include('../simple_html_dom.php');
        include './assets/plugin/getktbi/simple_html_dom.php';

        $html = file_get_html('https://www.bi.go.id/id/moneter/informasi-kurs/transaksi-bi/Default.aspx');

        $last_update = '';
        // $date_update = $this->tanggal_indo(date("Y-m-d")); // 20 Maret 2016;
        $date_update = date("Y-m-d H:i:s"); // 20 Maret 2016;
        foreach ($html->find('span[id=ctl00_PlaceHolderMain_biWebKursTransaksiBI_lblUpdate]') as $last_) {
            $last_update = $last_->innertext;
        }
        // print("<pre>".print_r($last_update,true)."</pre>");


        foreach ($html->find('table[id=ctl00_PlaceHolderMain_biWebKursTransaksiBI_GridView1]') as $table) {
            // initialize empty array to store the data array from each row
            $theData = array();
            // loop over rows
            $first = true;
            foreach ($table->find('tr') as $row) {
                // initialize array to store the cell data from each row
                $rowData = array();
                foreach ($row->find('th') as $cell) {
                    // push the cell's text to the array
                    $rowData[] = $cell->innertext;
                }

                if ($first) {
                    $rowData[] = 'Last Update BI';
                    $rowData[] = 'Date Update';
                }

                foreach ($row->find('td') as $cell) {
                    // push the cell's text to the array
                    $rowData[] = $cell->innertext;
                }

                if (!$first) {
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

        // echo '<table border=1>';
        foreach ($theData as $row) {
            if (trim($row[0]) == 'USD') {
                $data = array();

                $data['JUAL'] = str_replace(",", "", $row[2]);
                $data['NOMINAL'] = str_replace(",", "", $row[3]);

                $data['KTBI'] = ($data['JUAL'] + $data['NOMINAL']) / 2;
                $data['KTBI'] = number_format($data['KTBI'], 2);
                $data['KTBI'] = str_replace(",", "", $data['KTBI']);

                $data['TGL_KURS'] = $row[5];
                $data['UPDATE_KTBI'] = $row[6];

                $data['CD_BY_KURS'] = 'JOB APP';
                $data['CD_DATE_KURS'] = date("Y-m-d");

                break;
            }

            // echo '<tr>';
            // echo '<td>' . $row[0] . '</td>';
            // echo '<td>' . $row[1] . '</td>';
            // echo '<td>' . $row[2] . '</td>';
            // echo '<td>' . $row[3] . '</td>';
            // echo '<td>' . $row[4] . '</td>';
            // echo '<td>' . $row[5] . '</td>';
            // echo '<td>' . $row[6] . '</td>';
            // echo '</tr>';
        }
        // echo '</table>';

        if ($this->template_model->check_tanggal_ktbi($data['TGL_KURS']) == FALSE) {
            $message = 'Gagal, Tanggal Kurs ' . $data['TGL_KURS'] . ' Sudah Ada';
        } else {
            if ($this->template_model->save_as_new_ktbi($data)) {
                $message = 'Berhasil';
            } else {
                $message = 'Gagal';
            }
        }

        if ($message != 'Berhasil') {
            $data_log = array();
            $data_log['KETERANGAN'] = $message;
            $data_log['CD_BY'] = 'JOB APP';
            $data_log['CD_DATE'] = $date_update;

            $this->template_model->save_log_ktbi($data_log);
        }

        $message = '#' . date("Y-m-d H:i:s") . '  ' . $message . ' \r\n';


        print_r($message);
    }

    public function get_ktbi_tes()
    {
        // include('../simple_html_dom.php');
        include './assets/plugin/getktbi/simple_html_dom.php';

        $html = file_get_html('https://www.bi.go.id/id/moneter/informasi-kurs/transaksi-bi/Default.aspx');

        $last_update = '';
        // $date_update = $this->tanggal_indo(date("Y-m-d")); // 20 Maret 2016;
        $date_update = date("Y-m-d H:i:s"); // 20 Maret 2016;
        foreach ($html->find('span[id=ctl00_PlaceHolderMain_biWebKursTransaksiBI_lblUpdate]') as $last_) {
            $last_update = $last_->innertext;
        }
        // print("<pre>".print_r($last_update,true)."</pre>");


        foreach ($html->find('table[id=ctl00_PlaceHolderMain_biWebKursTransaksiBI_GridView1]') as $table) {
            // initialize empty array to store the data array from each row
            $theData = array();
            // loop over rows
            $first = true;
            foreach ($table->find('tr') as $row) {
                // initialize array to store the cell data from each row
                $rowData = array();
                foreach ($row->find('th') as $cell) {
                    // push the cell's text to the array
                    $rowData[] = $cell->innertext;
                }

                if ($first) {
                    $rowData[] = 'Last Update BI';
                    $rowData[] = 'Date Update';
                }

                foreach ($row->find('td') as $cell) {
                    // push the cell's text to the array
                    $rowData[] = $cell->innertext;
                }

                if (!$first) {
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

        // echo '<table border=1>';
        foreach ($theData as $row) {
            if (trim($row[0]) == 'USD') {
                $data = array();

                $data['JUAL'] = str_replace(",", "", $row[2]);
                $data['NOMINAL'] = str_replace(",", "", $row[3]);

                $data['KTBI'] = ($data['JUAL'] + $data['NOMINAL']) / 2;
                $data['KTBI'] = number_format($data['KTBI'], 2);
                $data['KTBI'] = str_replace(",", "", $data['KTBI']);

                $data['TGL_KURS'] = $row[5];
                $data['UPDATE_KTBI'] = $row[6];

                $data['CD_BY_KURS'] = 'KTBI';
                $data['CD_DATE_KURS'] = date("Y-m-d");

                break;
            }
        }
        // echo '</table>';
        // print("<pre>".print_r($data,true)."</pre>");
        header('Content-type: application/json');
        $rest = array('status' => 'ok', 'data' => $data);

        // echo json_encode($rest);             
    }

    public function get_jisdor()
    {
        include './assets/plugin/getktbi/simple_html_dom.php';

        $html = file_get_html('https://www.bi.go.id/id/moneter/informasi-kurs/referensi-jisdor/Default.aspx');

        foreach ($html->find('table[class=table1]') as $table) {
            // initialize empty array to store the data array from each row
            $theData = array();
            $x = 0;
            // loop over rows
            foreach ($table->find('tr') as $row) {
                // initialize array to store the cell data from each row
                $rowData = array();
                foreach ($row->find('th') as $cell) {
                    // push the cell's text to the array
                    $rowData[] = $cell->innertext;
                }

                $ke = 1;
                foreach ($row->find('td') as $cell) {
                    // push the cell's text to the array trim($cell->innertext,"")
                    if ($ke == 1) {
                        $rowData[] = $this->set_tgl_db_eng(trim($cell->innertext, ' '));
                        // $rowData[] = $this->set_tgl_db_eng($cell->innertext);
                    } else {
                        $kurs = trim($cell->innertext, ' ');
                        $rowData[] = str_replace(',', '', $kurs);
                    }
                    $ke++;
                }

                // push the row's data array to the 'big' array
                if ($x == 1) {
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

            $data['CD_BY_KURS'] = 'JOB APP';
            $data['CD_DATE_KURS'] = date("Y-m-d");
        }

        if ($this->template_model->check_tanggal($data['TGL_KURS']) == FALSE) {
            $message = 'Gagal, Tanggal Kurs ' . $data['TGL_KURS'] . ' Sudah Ada';
        } else {
            if ($this->template_model->save_as_new($data)) {
                $message = 'Berhasil';
            } else {
                $message = 'Gagal insert data';
            }
        }

        if ($message != 'Berhasil') {
            $data_log = array();
            $data_log['KETERANGAN'] = $message;
            $data_log['CD_BY'] = 'JOB APP';
            $data_log['CD_DATE'] = $data['UPDATE_KTBI'];

            $this->template_model->save_log($data_log);
        }

        $message = '#' . date("Y-m-d H:i:s") . '  ' . $message . ' \r\n';

        print_r($message);
        // echo '<br><br>';
    }

    public function get_jisdor_tes()
    {
        include './assets/plugin/getktbi/simple_html_dom.php';

        // print_r('expression ok');
        $html = file_get_html('https://www.bi.go.id/id/moneter/informasi-kurs/referensi-jisdor/Default.aspx');
        // print_r($html);
        foreach ($html->find('table[class=table1]') as $table) {
            // initialize empty array to store the data array from each row
            $theData = array();
            $x = 0;
            // loop over rows
            foreach ($table->find('tr') as $row) {
                // initialize array to store the cell data from each row
                $rowData = array();
                foreach ($row->find('th') as $cell) {
                    // push the cell's text to the array
                    $rowData[] = $cell->innertext;
                }

                $ke = 1;
                foreach ($row->find('td') as $cell) {
                    // push the cell's text to the array trim($cell->innertext,"")
                    if ($ke == 1) {
                        $rowData['TANGGAL_KURS'] = $this->set_tgl_db_eng(trim($cell->innertext, ' '));
                        // $rowData[] = $this->set_tgl_db_eng($cell->innertext);
                    } else {
                        $kurs = trim($cell->innertext, ' ');
                        $rowData['KURS'] = str_replace(',', '', $kurs);
                    }
                    $ke++;
                }

                // push the row's data array to the 'big' array
                if ($x == 1) {
                    $theData[] = $rowData;
                    break;
                }
                $x++;
            }
        }

        header('Content-type: application/json');
        $rest = array('status' => 'ok', 'data' => $rowData);

        echo json_encode($rest);
        // print("<pre>".print_r($theData,true)."</pre>");
        // echo '<br><br>';

        // foreach ($theData as $row) {
        //     $data = array();

        //     $data['KTBI'] = $row[1];                
        //     $data['TGL_KURS'] = $row[0];
        //     $data['UPDATE_KTBI'] = date("Y-m-d H:i:s");

        //     $data['CD_BY_KURS'] = 'JOB APP';
        //     $data['CD_DATE_KURS'] = date("Y-m-d"); 
        // }

        // if ($this->template_model->check_tanggal($data['TGL_KURS']) == FALSE){
        //     $message = 'Gagal, Tanggal Kurs '.$data['TGL_KURS'].' Sudah Ada';
        // } else {
        //     if ($this->template_model->save_as_new($data)) {
        //         $message = 'Berhasil';
        //     } else {
        //         $message = 'Gagal insert data';
        //     }            
        // }

        // if ($message!='Berhasil'){
        //     $data_log = array();
        //     $data_log['KETERANGAN'] = $message;
        //     $data_log['CD_BY'] = 'JOB APP';
        //     $data_log['CD_DATE'] = $data['UPDATE_KTBI'];

        //     $this->template_model->save_log($data_log);            
        // }

        // print_r($message);
        // echo '<br><br>';
    }

    public function set_tgl_db($tanggal)
    {
        $bulan = array(
            '01' =>   'Januari',
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
        if ($tgl < 10) {
            $tgl = '0' . $tgl;
        }

        return (int)$split[2] . '-' . array_search($split[1], $bulan) . '-' . $tgl;
    }

    public function set_tgl_db_eng($tanggal)
    {
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
        if ($tgl < 10) {
            $tgl = '0' . $tgl;
        }

        return (int)$split[2] . '-' . array_search($split[1], $bulan) . '-' . $tgl;
    }

    public function set_aktif_komp_alpha()
    {
        $get = $this->template_model->set_aktif_komp_alpha();
        print_r('#' . date("Y-m-d H:i:s") . '  #Rest set_aktif_komp_alpha = ' . ' \r\n');
    }

    public function tes_ip()
    {
        echo $this->laccess->url_serverfile();
    }

    public function get_kirim_email()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Proses Kirim Transaksi Inventory Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_kirim();
        foreach ($record as $row) {
            $data['LEVEL1'] = $row->LEVEL1;
            $data['LEVEL4'] = $row->LEVEL4;
            $data['EMAIL_USER'] = $row->EMAIL_USER;
            $data['USER_KIRIM'] = $row->USER_KIRIM;
            $data['NAMA_USER'] = $row->NAMA_USER;
            $EMAIL_USER = $row->EMAIL_USER;
            $USER_KIRIM = $row->USER_KIRIM;

            $data['list_email_detail'] = $this->template_model->get_email_kirim_detail($USER_KIRIM);

            $isi_email_html = $this->load->view('email_kirim', $data, TRUE);
            // echo $isi_email_html.'<br><hr><br>'; 

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_kirim_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_kirim_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_approve_email()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Proses Approve Transaksi Inventory Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_approve();
        foreach ($record as $row) {
            $data['LEVEL1'] = $row->LEVEL1;
            $data['LEVEL4'] = $row->LEVEL4;
            $data['EMAIL_USER'] = $row->EMAIL_USER;
            $data['USER_KIRIM'] = $row->USERNAME;
            $data['NAMA_USER'] = $row->NAMA_USER;
            $EMAIL_USER = $row->EMAIL_USER;
            $USERNAME = $row->USERNAME;

            $data['list_email_detail'] = $this->template_model->get_email_approve_detail($USERNAME);

            $isi_email_html = $this->load->view('email_approve', $data, TRUE);
            // echo $isi_email_html.'<br><hr><br>'; 

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");


            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_approve_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_approve_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_gm_email()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Rekap Posting Transaksi Inventory Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_gm();
        foreach ($record as $row) {
            $data['LEVEL1'] = $row->LEVEL1;
            $data['EMAIL_USER'] = $row->EMAIL_USER;
            $data['USER_KIRIM'] = $row->USERNAME;
            $data['NAMA_USER'] = $row->NAMA_USER;
            $EMAIL_USER = $row->EMAIL_USER;
            $USERNAME = $row->USERNAME;

            $data['list_email_detail'] = $this->template_model->get_email_gm_detail($USERNAME);
            $data['list_email_update'] = $this->template_model->get_email_gm_update($USERNAME);

            $isi_email_html = $this->load->view('email_gm', $data, TRUE);
            // echo $isi_email_html.'<br><hr><br>'; 

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");


            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_gm_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_gm_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_update_lv3_email()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Data Update Transaksi Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_update_lv3();
        foreach ($record as $row) {
            $data['LEVEL_USER'] = $row->LEVEL3;
            $data['EMAIL_USER'] = $row->EMAIL_USER;
            $data['USER_KIRIM'] = $row->USERNAME;
            $data['NAMA_USER'] = $row->NAMA_USER;
            $EMAIL_USER = $row->EMAIL_USER;
            $USERNAME = $row->USERNAME;

            $data['list_email_detail'] = $this->template_model->get_email_update_lv3_detail($USERNAME);

            $isi_email_html = $this->load->view('email_update', $data, TRUE);
            // echo $isi_email_html.'<br><hr><br>'; 

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");


            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_update_lv3_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_update_lv3_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_update_lv2_email()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Data Update Transaksi Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_update_lv2();
        foreach ($record as $row) {
            $data['LEVEL_USER'] = $row->LEVEL2;
            $data['EMAIL_USER'] = $row->EMAIL_USER;
            $data['USER_KIRIM'] = $row->USERNAME;
            $data['NAMA_USER'] = $row->NAMA_USER;
            $EMAIL_USER = $row->EMAIL_USER;
            $USERNAME = $row->USERNAME;

            $data['list_email_detail'] = $this->template_model->get_email_update_lv2_detail($USERNAME);

            $isi_email_html = $this->load->view('email_update', $data, TRUE);
            // echo $isi_email_html.'<br><hr><br>'; 

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");


            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_update_lv2_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_update_lv2_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_update_lv1_email()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Data Update Transaksi Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_update_lv1();
        foreach ($record as $row) {
            $data['LEVEL_USER'] = $row->LEVEL1;
            $data['EMAIL_USER'] = $row->EMAIL_USER;
            $data['USER_KIRIM'] = $row->USERNAME;
            $data['NAMA_USER'] = $row->NAMA_USER;
            $EMAIL_USER = $row->EMAIL_USER;
            $USERNAME = $row->USERNAME;

            $data['list_email_detail'] = $this->template_model->get_email_update_lv1_detail($USERNAME);

            $isi_email_html = $this->load->view('email_update', $data, TRUE);
            // echo $isi_email_html.'<br><hr><br>'; 

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_update_lv1_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_update_lv1_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_kontrak_transportir_bln_email()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Masa Berlaku Kontrak Transportir Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_kontrak_transportir_bln();
        foreach ($record as $row) {
            $data['LEVEL1'] = $row->LEVEL1;
            $data['LEVEL2'] = $row->LEVEL2;
            $data['EMAIL_USER'] = $row->EMAIL_USER;
            $data['USER_KIRIM'] = $row->USER_KIRIM;
            $data['NAMA_USER'] = $row->NAMA_USER;
            $data['NOMOR_KONTRAK'] = $row->NOMOR_KONTRAK;
            $data['NAMA_TRANSPORTIR'] = $row->NAMA_TRANSPORTIR;
            $data['PEMBANGKIT'] = $row->PEMBANGKIT;
            $data['TGL_AWAL'] = $this->set_tgl_indo($row->TGL_AWAL);
            $data['TGL_AKHIR'] = $this->set_tgl_indo($row->TGL_AKHIR);

            $EMAIL_USER = $row->EMAIL_USER;
            $USER_KIRIM = $row->USER_KIRIM;

            // $data['list_email_detail'] = $this->template_model->get_email_kirim_detail($USER_KIRIM);

            $isi_email_html = $this->load->view('email_kontrak_transportir', $data, TRUE);
            // echo $isi_email_html.'<br><hr><br>'; 

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");
            $save['JENIS'] = '1';

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_kontrak_transportir_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_kontrak_transportir_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_kontrak_transportir_hari_email()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Masa Berlaku Kontrak Transportir Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_kontrak_transportir_hari();
        foreach ($record as $row) {
            $data['LEVEL1'] = $row->LEVEL1;
            $data['LEVEL2'] = $row->LEVEL2;
            $data['EMAIL_USER'] = $row->EMAIL_USER;
            $data['USER_KIRIM'] = $row->USER_KIRIM;
            $data['NAMA_USER'] = $row->NAMA_USER;
            $data['NOMOR_KONTRAK'] = $row->NOMOR_KONTRAK;
            $data['NAMA_TRANSPORTIR'] = $row->NAMA_TRANSPORTIR;
            $data['PEMBANGKIT'] = $row->PEMBANGKIT;
            $data['TGL_AWAL'] = $this->set_tgl_indo($row->TGL_AWAL);
            $data['TGL_AKHIR'] = $this->set_tgl_indo($row->TGL_AKHIR);

            $EMAIL_USER = $row->EMAIL_USER;
            $USER_KIRIM = $row->USER_KIRIM;

            // $data['list_email_detail'] = $this->template_model->get_email_kirim_detail($USER_KIRIM);

            $isi_email_html = $this->load->view('email_kontrak_transportir', $data, TRUE);
            // echo $isi_email_html.'<br><hr><br>'; 

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");
            $save['JENIS'] = '2';

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_kontrak_transportir_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_kontrak_transportir_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_kontrak_transportir_exp_email()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Update Kontrak Transportir Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_kontrak_transportir_exp();
        foreach ($record as $row) {
            $data['LEVEL1'] = $row->LEVEL1;
            $data['LEVEL2'] = $row->LEVEL2;
            $data['EMAIL_USER'] = $row->EMAIL_USER;
            $data['USER_KIRIM'] = $row->USER_KIRIM;
            $data['NAMA_USER'] = $row->NAMA_USER;
            $data['NOMOR_KONTRAK'] = $row->NOMOR_KONTRAK;
            $data['NAMA_TRANSPORTIR'] = $row->NAMA_TRANSPORTIR;
            $data['PEMBANGKIT'] = $row->PEMBANGKIT;
            $data['TGL_AWAL'] = $this->set_tgl_indo($row->TGL_AWAL);
            $data['TGL_AKHIR'] = $this->set_tgl_indo($row->TGL_AKHIR);

            $EMAIL_USER = $row->EMAIL_USER;
            $USER_KIRIM = $row->USER_KIRIM;

            $data['list_email_detail'] = $this->template_model->get_email_kontrak_transportir_exp_detail($USER_KIRIM);

            $isi_email_html = $this->load->view('email_kontrak_transportir_exp', $data, TRUE);
            // echo $isi_email_html.'<br><hr><br>'; 

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");
            $save['JENIS'] = '3';

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_kontrak_transportir_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_kontrak_transportir_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_kontrak_transportir_notentry_email()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Input Kontrak Transportir Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_kontrak_transportir_notentry();
        foreach ($record as $row) {
            $data['LEVEL1'] = $row->LEVEL1;
            $data['LEVEL2'] = $row->LEVEL2;
            $data['EMAIL_USER'] = $row->EMAIL_USER;
            $data['USER_KIRIM'] = $row->USER_KIRIM;
            $data['NAMA_USER'] = $row->NAMA_USER;
            $data['NOMOR_KONTRAK'] = $row->NOMOR_KONTRAK;
            $data['NAMA_TRANSPORTIR'] = $row->NAMA_TRANSPORTIR;
            $data['PEMBANGKIT'] = $row->PEMBANGKIT;
            $data['TGL_AWAL'] = $this->set_tgl_indo($row->TGL_AWAL);
            $data['TGL_AKHIR'] = $this->set_tgl_indo($row->TGL_AKHIR);

            $EMAIL_USER = $row->EMAIL_USER;
            $USER_KIRIM = $row->USER_KIRIM;

            // $data['list_email_detail'] = $this->template_model->get_email_kirim_detail($USER_KIRIM);

            $isi_email_html = $this->load->view('email_kontrak_transportir_notentry', $data, TRUE);
            // echo $isi_email_html.'<br><hr><br>'; 

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");
            $save['JENIS'] = '4';

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_kontrak_transportir_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_kontrak_transportir_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    // proses kirim ulang
    public function get_kirim_email_ulang()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Proses Kirim Transaksi Inventory Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_kirim_ulang();
        foreach ($record as $row) {
            $id = $row->ID_EMAIL;
            $this->template_model->delete_kirim_log_error($id);

            $EMAIL_USER = $row->EMAIL_USER;
            $isi_email_html = $row->ISI_EMAIL;

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_kirim_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_kirim_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_approve_email_ulang()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Proses Approve Transaksi Inventory Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_approve_ulang();
        foreach ($record as $row) {
            $id = $row->ID_EMAIL;
            $this->template_model->delete_approve_log_error($id);

            $EMAIL_USER = $row->EMAIL_USER;
            $isi_email_html = $row->ISI_EMAIL;

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_approve_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_approve_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_gm_email_ulang()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Rekap Posting Transaksi Inventory Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_gm_ulang();
        foreach ($record as $row) {
            $id = $row->ID_EMAIL;
            $this->template_model->delete_gm_log_error($id);

            $EMAIL_USER = $row->EMAIL_USER;
            $isi_email_html = $row->ISI_EMAIL;

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_gm_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_gm_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_update_lv3_email_ulang()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Data Update Transaksi Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_update_lv3_ulang();
        foreach ($record as $row) {
            $id = $row->ID_EMAIL;
            $this->template_model->delete_update_lv3_log_error($id);

            $EMAIL_USER = $row->EMAIL_USER;
            $isi_email_html = $row->ISI_EMAIL;

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_update_lv3_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_update_lv3_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_update_lv2_email_ulang()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Data Update Transaksi Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_update_lv2_ulang();
        foreach ($record as $row) {
            $id = $row->ID_EMAIL;
            $this->template_model->delete_update_lv2_log_error($id);

            $EMAIL_USER = $row->EMAIL_USER;
            $isi_email_html = $row->ISI_EMAIL;

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_update_lv2_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_update_lv2_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_update_lv1_email_ulang()
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);
        $this->email->subject('GBMO - Data Update Transaksi Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_update_lv1_ulang();
        foreach ($record as $row) {
            $id = $row->ID_EMAIL;
            $this->template_model->delete_update_lv1_log_error($id);

            $EMAIL_USER = $row->EMAIL_USER;
            $isi_email_html = $row->ISI_EMAIL;

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_update_lv1_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_update_lv1_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function get_kontrak_transportir_email_ulang($JENIS = 0)
    {
        $data = array();
        $save = array();
        $date_start = date("Y-m-d H:i:s");

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);

        if ($JENIS == 3) {
            $this->email->subject('GBMO - Update Kontrak Transportir Aplikasi GBM Online');
        } else if ($JENIS == 4) {
            $this->email->subject('GBMO - Input Kontrak Transportir Aplikasi GBM Online');
        } else {
            $this->email->subject('GBMO - Masa Berlaku Kontrak Transportir Aplikasi GBM Online');
        }

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_email_kontrak_transportir_ulang($JENIS);
        foreach ($record as $row) {
            $id = $row->ID_EMAIL;
            $this->template_model->delete_kontrak_transportir_log_error($id);

            $EMAIL_USER = $row->EMAIL_USER;
            $isi_email_html = $row->ISI_EMAIL;

            $this->email->to($EMAIL_USER);
            $this->email->message($isi_email_html);

            $save['EMAIL_KIRIM'] = $get->SMTP_EMAIL;
            $save['EMAIL_USER'] = $EMAIL_USER;
            $save['ISI_EMAIL'] = $isi_email_html;
            $save['CD_BY'] = 'sys';
            $save['CD_DATE'] = date("Y-m-d H:i:s");
            $save['JENIS'] = $JENIS;

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $EMAIL_USER . '<br>';
                $this->template_model->save_kontrak_transportir_log($save);
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $EMAIL_USER . '<br>';
                $gagal = $this->email->print_debugger();
                echo $gagal;
                $save['PESAN_GAGAL'] = $gagal;
                $this->template_model->save_kontrak_transportir_log_error($save);
            }
        }

        $date_end = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date_start . '<br>';
        echo 'End -> ' . $date_end . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }

    public function send_mail()
    {
        $from_email = "servicedesk.gbmo@iconpln.co.id";
        $pass = "icon+gbmo";
        // $to_email = "yudy603@gmail";
        $to_email = "fesasabil@gmail.com";

        // $config = array(
        //     'protocol' => 'smtp',
        //     // 'smtp_host' => 'messaging.iconpln.co.id', //khusus kirim ke iconers
        //     'smtp_host' => 'smtp.iconpln.co.id',  //kirim ke semua alamat email
        //     'smtp_port' => 25,
        //     'smtp_user' => $from_email,
        //     'smtp_pass' => $pass,
        //     'mailtype'  => 'html',
        //     'charset'   => 'iso-8859-1'
        // );

        $get = $this->template_model->get_setting_smtp();
        $config = array(
            // 'useragent' => 'GBMO_Mail_Server',
            'protocol'  => 'smtp',
            'mailpath'  => '/usr/sbin/sendmail',
            'smtp_host' => $get->SMTP_HOST,
            'smtp_user' => $get->SMTP_USER,
            'smtp_pass' => $get->SMTP_PASS,
            'smtp_port' => $get->SMTP_PORT,
            'smtp_keepalive' => TRUE,
            'smtp_crypto' => 'SSL',
            'wordwrap'  => TRUE,
            'wrapchars' => 80,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'validate'  => TRUE,
            'crlf'      => "\r\n",
            'newline'   => "\r\n",
        );
        
        $this->load->library('email', $config);
        // $this->email->initialize($config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);

        $this->email->subject('GBMO - Hari Operasi Pembangkit (HOP) lebih dari 15 hari pada Aplikasi GBM Online');



        // $this->load->library('email', $config);
        // $this->email->set_newline("\r\n");

        // $this->email->from($from_email, 'Nama Kamu');
        $this->email->to($to_email);
        // $this->email->subject('Test Pengiriman Email ' . date());
        $this->email->message('Coba mengirim Email.');

        //Send mail 
        if ($this->email->send()) {
            echo 'Sukses! email berhasil dikirim ke ' . $to_email;
        } else {
            echo 'Gagal! email gagal dikirim ke ' . $to_email . '<br><br>';
            echo $this->email->print_debugger();
        }
    }

    public function send_test()
    {
      
		$this->load->library('email');
        $get = $this->template_model->get_setting_smtp();
        $from = $get->SMTP_USER;
		$to = 'fesasabil@gmail.com';
		$subject = 'Test Email';
		$message = 'Coba Coba email';
		$config = array(
			'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
			'smtp_host' => $get->SMTP_HOST,
			'smtp_port' => $get->SMTP_PORT,
			'smtp_user' => $get->SMTP_USER,
			'smtp_pass' => $get->SMTP_PASS,
			'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
			'mailtype' => 'text', //plaintext 'text' mails or 'html'
			'smtp_timeout' => '4', //in seconds
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE,
			'newline' => "\r\n"
		);

		$this->email->initialize($config);

		$this->email->from($from, 'Fesa Sabil');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);		

		if ($this->email->send()) {
			echo "Berhasil";
		} else {
			echo $this->email->print_debugger();
		}
    }

    function set_tgl_indo($tanggal)
    {
        $bulan = array(
            '01' =>   'Januari',
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
        $split = explode('-', $tanggal);
        return ($split[2] . ' ' . $bulan[$split[1]] . ' ' . $split[0]);
    }

    function kirim_email_persediaan()
    {
        error_reporting(E_ALL);
        $get = $this->template_model->get_setting_smtp(0);
        // $config = array(
        //     'useragent' => 'GBMO_Mail_Server',
        //     'protocol'  => 'smtp',
        //     'mailpath'  => '/usr/sbin/sendmail',
        //     'smtp_host' => 'smtp.gmail.com',
        //     'smtp_user' => 'baktidwijaya',
        //     'smtp_pass' => 'ychqwusdipliiyij',
        //     'smtp_port' => '587',
        //     'smtp_keepalive' => TRUE,
        //     'smtp_crypto' => 'SSL',
        //     'wordwrap'  => TRUE,
        //     'wrapchars' => 80,
        //     'mailtype'  => 'html',
        //     'charset'   => 'utf-8',
        //     'validate'  => TRUE,
        //     'crlf'      => "\r\n",
        //     'newline'   => "\r\n",
        // );

        $config = array(
            'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
            'smtp_host' => 'smtp.gmail.com',
            'smtp_user' => 'baktidwijaya@gmail.com',
            'smtp_pass' => 'hsfbhbueqvideueu',
            'smtp_port' => '465',
            'smtp_crypto' => 'ssl', //can be 'ssl' or 'tls' for example
            'mailtype' => 'html', //plaintext 'text' mails or 'html'
            'smtp_timeout' => '4', //in seconds
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'newline' => "\r\n"
        );

        $this->load->library('email', $config);
        $this->email->from($get->SMTP_EMAIL, $get->SMTP_EMAIL_NAMA);

        $this->email->subject('GBMO - Hari Operasi Pembangkit (HOP) lebih dari 15 hari pada Aplikasi GBM Online');

        $no = 1;
        $x_berhasil = 0;
        $x_gagal = 0;
        $record = $this->template_model->get_level2();

        foreach ($record as $row) {
            $data = $this->template_model->kirim_email_persediaan($row->PLANT);
            $d['array'] = $data;
            $d['subject'] = 'GBMO - Hari Operasi Pembangkit (HOP) lebih dari 15 hari pada Aplikasi GBM Online';
            $d['pltd'] = $row->LEVEL4;
            $d['unit'] = $row->LEVEL2;
            $d['nama_user'] = $row->NAMA_USER;
            $from = "baktidwijaya@gmail.com";
            // $from = "gbmo.pln@pln.co.id";
            $to = $row->EMAIL_USER;
            $subject = 'Test Email';
            $message = $this->load->view('template/kirim_email_persediaan', $d, TRUE);
            $this->email->initialize($config);

            $this->email->from($from, 'GBMO PLN');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);

            if ($this->email->send()) {
                $x_berhasil++;
                echo $no++ . ' Sukses! email berhasil dikirim ke ' . $to . '<br>';
            } else {
                $x_gagal++;
                echo $no++ . ' Error! email tidak dapat dikirim ke ' . $to . '<br>';
            }
        }
        $date = date("Y-m-d H:i:s");
        echo '<br><hr>';
        echo 'Start -> ' . $date . '<br>';
        echo 'End -> ' . $date . '<br>';
        echo 'Total -> ' . ($x_berhasil + $x_gagal) . '<br>';
        echo 'Berhasil -> ' . $x_berhasil . '<br>';
        echo 'Gagal -> ' . $x_gagal . '<br>';
    }
}

/* End of file template.php */
/* Location: ./application/modules/template/controllers/template.php */
