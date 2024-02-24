    <?php
/**
 * @module KURS
 * @author  BAKTI DWI DHARMA WIJAYA
 * @created at 03 JANUARI 2019
 * @modified at 13 MARET 2019
 */

if (!defined("BASEPATH")) exit("No direct script access allowed");
/**
 * @module
 */
class penyerapan_bbm extends MX_Controller

{
    private $_title = 'Target Penyerapan BBM';
    private $_limit = 10;
    private $_module = 'master/penyerapan_bbm';
    public

    function __construct()
    {
        parent::__construct();

        // Protection

        hprotection::login();
        $this->laccess->check();
        $this->laccess->otoritas('view', true);
        $this->load->model('penyerapan_bbm_model', 'tbl_get');
    }

    function index()
    {
        $this->load->module("template/asset");
        $this->asset->set_plugin(array(
            'crud',
            'format_number'
        ));
        $data['page_title'] = '<i class="icon-laptop"></i> ' . $this->_title;
        $data['page_content'] = $this->_module . '/main';
        $data['data_sources'] = base_url($this->_module . '/load');
        echo Modules::run("template/admin", $data);
    }

    function loadFilter()
    {
        $data['button_group'] = array();
        if ($this->laccess->otoritas('add')) {
            $data['button_group'] = array(
                anchor(null, '<i class="icon-plus"></i> Tambah Data', array(
                    'class' => 'btn yellow',
                    'id' => 'button-tambah',
                    'onclick' => 'add()'
                ))
            );
        }

        // $data = $this->get_level_user();

        $data['lvl1options'] = $this->tbl_get->lvl1options();
        $data['skema_options'] = $this->tbl_get->filter_skema_all();
        $data['sorting'] = array(
            'ASC' => 'ASC',
            'DESC' => 'DESC'
        );
        $data['sort'] = array(
            '1' => 'UNIT',
            '2' => 'JENIS BBM',
            '3' => 'SKEMA PENYERAPAN'
        );
        $data['form_action'] = base_url($this->_module . '/loadTable');
        $this->load->view('penyerapan_bbm/filter', $data);
    }

    function loadTable()
    {
        extract($_POST);
        if($SKEMA_PENYERAPAN == '') {
            $SKEMA = date('Y');
        } else {
            $SKEMA = $SKEMA_PENYERAPAN;
        }
        $value = array(
            'SKEMA_PENYERAPAN' => $SKEMA,
            'ID_REGIONAL' => $ID_REGIONAL,
            'COCODE' => $COCODE
        );
        $data['tipe'] = 1;
        $data['button'] = '';
        $data['button_edit'] = 0; 
        $data['list'] = $this->tbl_get->data($value);
        $this->load->view('penyerapan_bbm/table', $data);
    }

    function load_divTable()
    {
        $data['tipe'] = 0;
        $user = $this->session->userdata('user_name');
        $data['button_edit'] = 1; 
        $data['list'] = $this->tbl_get->temp_data($this->get_nama_group());
        $data['button'] = '<button class="btn" type="submit" onclick="save_all()"><i class="icon-arrow-left"></i> Tutup</button>';
        $this->load->view('penyerapan_bbm/table', $data);
    }

    function add()
    {
        $page_title = 'Tambah ' . $this->_title;
        $data['form_action'] = base_url($this->_module . '/save');
        $data['lvl1options'] = $this->tbl_get->lvl1options();
        $data['skema_options'] = $this->tbl_get->filter_skema();
        $data['perhitungan_bio'] = $this->tbl_get->perhitungan_bio();
        $this->load->view('penyerapan_bbm/form', $data);
    }

    function edit()
    {
        extract($_POST);
        $data['id'] = $id;
        $page_title = 'Edit ' . $this->_title;
        $data['default'] = $this->tbl_get->get_data($id);
        $data['skema_options'] = $this->tbl_get->filter_skema();
        $data['lvl1options'] = $this->tbl_get->lvl1options();
        $data['button_edit'] = 0; 
        $data['button'] = anchor(null, '<i class="icon-arrow-left"></i> Kembali', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'loadFilter();loadTable()'));
        $data['perhitungan_bio'] = $this->tbl_get->perhitungan_bio();
        $data['form_action'] = base_url($this->_module . '/update');
        $this->load->view('penyerapan_bbm/formedit', $data);
    }

    function edit_add()
    {
        extract($_POST);
        $data['id'] = $id;
        $page_title = 'Edit ' . $this->_title;
        $data['default'] = $this->tbl_get->get_data($id);
        $data['skema_options'] = $this->tbl_get->filter_skema();
        $data['lvl1options'] = $this->tbl_get->lvl1options();
        $data['button_edit'] = 1; 
        $data['button'] = anchor(null, '<i class="icon-arrow-left"></i> Kembali', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'add();'));
        $data['perhitungan_bio'] = $this->tbl_get->perhitungan_bio();
        $data['form_action'] = base_url($this->_module . '/update');
        $this->load->view('penyerapan_bbm/formedit', $data);
    }

    function save()
    {
        extract($_POST);
        $CREATED_BY = $this->session->userdata('user_name');
        $CREATED_DATE = date('Y-m-d H:i:s');
        $V1 = $VOLUMEMFO == '' ? 0 : str_replace(".", "", $VOLUMEMFO);
        $V2 = $VOLUMEIDO == '' ? 0 : str_replace(".", "", $VOLUMEIDO);
        $V3 = $VOLUMEBIO == '' ? 0 : str_replace(".", "", $VOLUMEBIO);
        $V5 = $VOLUMEHSD == '' ? 0 : str_replace(".", "", $VOLUMEHSD);

        if ($PERHITUNGAN_BIO=='B20'){
            $PERSEN_BIO = '0.2';
            $PERSEN_HSD = '0.8';
            $NAMA_BIO = 'BIOSOLAR (20)';
        } else if ($PERHITUNGAN_BIO=='B30'){
            $PERSEN_BIO = '0.3';
            $PERSEN_HSD = '0.7';
            $NAMA_BIO = 'BIOSOLAR (30)';
        } else if ($PERHITUNGAN_BIO=='BIO'){
            $PERSEN_BIO = '0.2';
            $PERSEN_HSD = '0.8';
            $NAMA_BIO = 'BIOSOLAR (20)';
        }

        $data = array(
            'COCODE' => $COCODE,
            'VOLUMEMFO' => str_replace(",", ".", $V1) ,
            'VOLUMEIDO' => str_replace(",", ".", $V2) ,
            'VOLUMEHSD' => str_replace(",", ".", $V5) ,
            'VOLUMEBIO' => str_replace(",", ".", $V3) ,
            'SKEMA_PENYERAPAN' => $SKEMA_PENYERAPAN,
            'PERHITUNGAN_BIO' => $PERHITUNGAN_BIO,
            'CREATED_TIME' => $CREATED_DATE,
            'CREATED_BY' => $CREATED_BY,
            'PERSEN_BIO' => $PERSEN_BIO,
            'PERSEN_HSD' => $PERSEN_HSD,
            'NAMA_BIO' => $NAMA_BIO,
            'NAMA_GROUP' => $this->get_nama_group()
        );
        $exist = $this->tbl_get->isExists2Key('COCODE', $COCODE, 'SKEMA_PENYERAPAN', $SKEMA_PENYERAPAN);
        if ($exist) {
            $message = array(
                false,
                'Proses Gagal',
                'Data telah tersedia !.'
            );
        }
        else {
            $simpan = $this->tbl_get->save_as_new($data);
            if ($simpan) {
                $message = array(
                    true,
                    'Proses Berhasil',
                    'Proses penyimpanan data berhasil.'
                );
            }
            else {
                $message = array(
                    false,
                    'Proses Gagal',
                    'Proses penyimpanan data gagal.'
                );
            }
        }

        echo json_encode($message, true);
    }

    function update()
    {
        extract($_POST);
        $UPDATED_BY = $this->session->userdata('user_name');
        $UPDATED_DATE = date('Y-m-d H:i:s');
        $V1 = $VOLUMEMFO == '' ? 0 : str_replace(".", "", $VOLUMEMFO);
        $V2 = $VOLUMEIDO == '' ? 0 : str_replace(".", "", $VOLUMEIDO);
        $V3 = $VOLUMEBIO == '' ? 0 : str_replace(".", "", $VOLUMEBIO);
        $V5 = $VOLUMEHSD == '' ? 0 : str_replace(".", "", $VOLUMEHSD);
        $default = $this->tbl_get->get_data($id);

        if ($PERHITUNGAN_BIO=='B20'){
            $PERSEN_BIO = '0.2';
            $PERSEN_HSD = '0.8';
            $NAMA_BIO = 'BIOSOLAR (20)';
        } else if ($PERHITUNGAN_BIO=='B30'){
            $PERSEN_BIO = '0.3';
            $PERSEN_HSD = '0.7';
            $NAMA_BIO = 'BIOSOLAR (30)';
        } else if ($PERHITUNGAN_BIO=='BIO'){
            $PERSEN_BIO = '0.2';
            $PERSEN_HSD = '0.8';
            $NAMA_BIO = 'BIOSOLAR (20)';
        }        

        if ($default->COCODE == $COCODE && $default->SKEMA_PENYERAPAN == $SKEMA_PENYERAPAN) {
            $data = array(
                'VOLUMEMFO' => str_replace(",", ".", $V1) ,
                'VOLUMEIDO' => str_replace(",", ".", $V2) ,
                'VOLUMEHSD' => str_replace(",", ".", $V5) ,
                'VOLUMEBIO' => str_replace(",", ".", $V3) ,
                'PERHITUNGAN_BIO' => $PERHITUNGAN_BIO,
                'UPDATED_BY' => $UPDATED_BY,
                'PERSEN_BIO' => $PERSEN_BIO,
                'PERSEN_HSD' => $PERSEN_HSD,
                'NAMA_BIO' => $NAMA_BIO,                
                'UPDATED_DATE' => $UPDATED_DATE
            );
            $edit = $this->tbl_get->edit_data($data, $id);
            if ($edit) {
                $message = array(
                    true,
                    'Proses Berhasil',
                    'Proses pengubahan data berhasil.'
                );
            }
            else {
                $message = array(
                    false,
                    'Proses Gagal',
                    'Proses pengubahan data gagal.'
                );
            }
        }
        else {
            $exist = $this->tbl_get->isExists2Key('COCODE', $COCODE, 'SKEMA_PENYERAPAN', $SKEMA_PENYERAPAN);
            if ($exist) {
                $message = array(
                    false,
                    'Proses Gagal',
                    'Data Telah Tersedia !.'
                );
            }
            else {
                $data = array(
                    'COCODE' => $COCODE,
                    'VOLUMEMFO' => str_replace(",", ".", $V1) ,
                    'VOLUMEIDO' => str_replace(",", ".", $V2) ,
                    'VOLUMEHSD' => str_replace(",", ".", $V5) ,
                    'VOLUMEBIO' => str_replace(",", ".", $V3) ,
                    'SKEMA_PENYERAPAN' => $SKEMA_PENYERAPAN,
                    'PERHITUNGAN_BIO' => $PERHITUNGAN_BIO,
                    'UPDATED_BY' => $UPDATED_BY,
                    'UPDATED_DATE' => $UPDATED_DATE
                );
                $edit = $this->tbl_get->edit_data($data, $id, $UPDATED_BY);
                if ($edit) {
                    $message = array(
                        true,
                        'Proses Berhasil',
                        'Proses pengubahan data berhasil.'
                    );
                }
                else {
                    $message = array(
                        false,
                        'Proses Gagal',
                        'Proses pengubahan data gagal.'
                    );
                }
            }
        }

        echo json_encode($message, true);
    }

    function save_all()
    {
        $user = $this->get_nama_group();
        $data = array(
            'NAMA_GROUP' => ''
        );
        $update = $this->tbl_get->save_all($data, $user);
        if ($update) {
            $message = array(
                true,
                'Proses Berhasil',
                'Proses penyimpanan data berhasil.'
            );
        }
        else {
            $message = array(
                false,
                'Proses Gagal',
                'Proses penyimpanan data gagal.'
            );
        }

        echo json_encode($message);
    }

    function get_options_lv1($key = null)
    {
        $message = $this->tbl_get->options_lv1('--Pilih Level 1--', $key, 0);
        echo json_encode($message);
    }

    public

    function export_excel()
    {
        extract($_POST);
        $value = array(
            'SKEMA_PENYERAPAN' => $SKEMA_PENYERAPAN,
            'ID_REGIONAL' => $ID_REGIONAL,
            'COCODE' => $COCODE
        );
        if ($SKEMA_PENYERAPAN == "All") {
            $data['SKEMA_PENYERAPAN'] = (date('Y') - 1)." s/d ".(date('Y') + 1);
        }
        else {
            $data['SKEMA_PENYERAPAN'] = $SKEMA_PENYERAPAN;
        }

        $data['list'] = $this->tbl_get->data($value);
        $this->load->view($this->_module . '/export_excel', $data);
    }

    public

    function export_pdf()
    {
        extract($_POST);
        $value = array(
            'SKEMA_PENYERAPAN' => $SKEMA_PENYERAPAN,
            'ID_REGIONAL' => $ID_REGIONAL,
            'COCODE' => $COCODE
        );
        if ($SKEMA_PENYERAPAN == "All") {
            $data['SKEMA_PENYERAPAN'] = (date('Y') - 1)." s/d ".(date('Y') + 1);
        }
        else {
            $data['SKEMA_PENYERAPAN'] = $SKEMA_PENYERAPAN;
        }

        $data['ID_REGIONAL'] = $ID_REGIONAL;
        $data['COCODE'] = $COCODE;
        $data['list'] = $this->tbl_get->data($value);
        $html_source = $this->load->view($this->_module . '/export_pdf', $data, true);
        $this->load->library('lpdf');
        $this->lpdf->html($html_source);
        $this->lpdf->nama_file('LAPORAN_TARGET_PENYERAPAN_BBM.pdf');
        $this->lpdf->cetak('A4-L');
    }

    function get_nama_group() {
        $nama_group = 'abcd'.$this->session->userdata('user_name').'1234';
        return $nama_group;
    }


}

?>


 

