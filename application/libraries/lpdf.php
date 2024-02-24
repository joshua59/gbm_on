<?php

class lpdf {

    private $judul;
    private $content;

    public function __construct() {
        define('_MPDF_PROGRBAR_TITLE', 'Cetak PDF');
        define('_MPDF_PROGRBAR_HEADING', 'Proses cetak PDF sedang berlangsung, silahkan tunggu...');
        define('_MPDF_URI', base_url() . 'assets/plugin/mpdf/');

        require_once FCPATH . 'assets/plugin/mpdf/mpdf.php';

        $this->judul = '';
        $this->content = '';
        $this->nama_file = '';
    }

    public function init($page = 'A4') {
        return new mPDF('utf-8', $page);
    }

    public function html($html = '') {
        $this->content .= $html;
    }

    public function judul($html = '') {
        $this->judul = '<div class="box-kop">' . $html . '</div>';
    }

    public function nama_file($nama = 'Laporan.pdf') {
        $this->nama_file = $nama;
    }

    public function cek_kutip($html = '') {
        return str_replace("'", '"', $html);
    }

    public function cetak($page = 'A4') {
        $pdf = $this->init($page);
        $pdf->cacheTables = true;
        $pdf->packTableData = true;

        $nama_klient = ''; //'PT. Indonesia Comnets Plus';
        $nama_aplikasi = 'GBM Online';

        // $pdf->StartProgressBarOutput(2);
        $pdf->SetHeader($nama_klient . ' || ');
        $pdf->SetFooter($nama_aplikasi . ' || {PAGENO}');

        // Style
        $stylesheet = file_get_contents(FCPATH . 'assets/css/laporan.css');
        $pdf->WriteHTML($stylesheet, 1);

        // Content
        if (!empty($this->judul)) {
            $pdf->WriteHTML($this->cek_kutip($this->judul));
        }

        $pdf->WriteHTML($this->cek_kutip($this->content));
        $pdf->Output($this->nama_file,"I");
        exit;
    }

   public function cetak_no_header($page = 'A4') {
        $pdf = $this->init($page);
        $pdf->cacheTables = true;
        $pdf->packTableData = true;

        $nama_klient = ''; //'PT. Indonesia Comnets Plus';
        $nama_aplikasi = 'GBM Online';

        // $pdf->StartProgressBarOutput(2);
        // $pdf->SetHeader($nama_klient . ' || ');
        $pdf->SetFooter(' || {PAGENO}');

        // Style
        $stylesheet = file_get_contents(FCPATH . 'assets/css/laporan.css');
        $pdf->WriteHTML($stylesheet, 1);

        // Content
        if (!empty($this->judul)) {
            $pdf->WriteHTML($this->cek_kutip($this->judul));
        }

        $pdf->WriteHTML($this->cek_kutip($this->content));
        // $pdf->AddPage();
        // $pdf->WriteHTML($this->cek_kutip($this->content));
        $pdf->Output($this->nama_file,"I");
        exit;
    }   
}

/* End of file lpdf.php */
/* Location: ./application/libraries/lpdf.php */
