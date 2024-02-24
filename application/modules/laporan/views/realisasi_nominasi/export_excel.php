
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Laporan_Realisasi_Nominasi_BBM.xls');

        echo '
        <style>

        table.tdetail {
            border-collapse: collapse;
            width:100%;
            font-size: 10px;
            font-family:arial;
        }

        table.tdetail, table.tdetail td, table.tdetail th {
            border: 1px solid black;
        }

        table.tdetail thead {background-color: #CED8F6}

        </style>

        ';
    } else {
        echo '
        <!DOCTYPE html>
        <html>
        <style>
        thead { display: table-header-group }
tfoot { display: table-row-group }
tr { page-break-inside: avoid }
        table.tdetail {
            border-collapse: collapse;
            width:100%;
            font-size: 10px;
            background-color: #CED8F6;
            font-family:arial;
        }

        table.tdetail, table.tdetail td, table.tdetail th {
            border: 1px solid black;
        }

        table.tdetail tbody tr:nth-child(even) {background-color: #f2f2f2}
        table.tdetail tbody tr:nth-child(odd) {background-color: #FFF}

        </style>

        ';
    }
?>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">LAPORAN REALISASI NOMINASI BBM</div></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table border="0" style="width:100%;">
    <?php
        $jml_lv=4;
        if ($ID_REGIONAL) {
            $jml_lv= $jml_lv - 1; //3
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $ID_REGIONAL_NAMA . '</td></tr>';
        }
        if ($COCODE) {
            $jml_lv= $jml_lv - 1; //2
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $COCODE_NAMA . '</td></tr>';
        }
        if ($PLANT) {
            $jml_lv= $jml_lv - 1; //1
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $PLANT_NAMA . '</td></tr>';
        }
        if ($STORE_SLOC) {
            $jml_lv= $jml_lv - 1; //0
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $STORE_SLOC_NAMA . '</td></tr>';
        }
        if ($bulan) {
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">BLTH ' . $bulan . '' . $tahun . '</td></tr>';
        } else {
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun ' . $tahun . '</td></tr>';
        }

    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Unit</th>
        <th rowspan="2">Bulan / Tahun</th>
        <th colspan="5">Nominasi (L)</th>
        <th rowspan="2" style="width:1px;">Total Nominasi (L)</th>
        <th colspan="4">Terima (L)</th>
        <th rowspan="2">Total Terima (L)</th>
        <th rowspan="2">Prosentase</th>
    </tr>
    <tr>
      <th>HSD</th>
      <th>MFO</th>
      <th>BIO</th>
      <th>HSD+BIO</th>
      <th>IDO</th>
      <th>HSD</th>
      <th>MFO</th>
      <th>BIO</th>
      <th>IDO</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $x=0;
        foreach ($data as $row):
        $x++;
    ?>
    <tr>
      <?php
              $UNIT                         = !empty($row->UNIT) ? $row->UNIT : '-';
              $BLTH                         = !empty($row->BLTH) ? $row->BLTH : '-';
              $tahun                        = substr($BLTH, 2);
              $bulan                        = substr($BLTH, 0, 2);
              $b                            ='';
              if ($bulan == '01') {
                  $b = 'Januari';
              }
              if ($bulan == '02') {
                  $b = 'Februari';
              }
              if ($bulan == '03') {
                  $b = 'Maret';
              }
              if ($bulan == '04') {
                  $b = 'April';
              }
              if ($bulan == '05') {
                  $b = 'Mei';
              }
              if ($bulan == '06') {
                  $b = 'Juni';
              }
              if ($bulan == '07') {
                  $b = 'Juli';
              }
              if ($bulan == '08') {
                  $b = 'Agustus';
              }
              if ($bulan == '09') {
                  $b = 'September';
              }
              if ($bulan == '10') {
                  $b = 'Oktober';
              }
              if ($bulan == '11') {
                  $b = 'November';
              }
              if ($bulan == '12') {
                  $b = 'Desember';
              }
              $NOMINASI_MFO                 = !empty($row->NOMINASI_MFO) ? number_format($row->NOMINASI_MFO, 0, ',', '.') : '0';
              $NOMINASI_IDO                 = !empty($row->NOMINASI_IDO) ? number_format($row->NOMINASI_IDO, 0, ',', '.') : '0';
              $NOMINASI_BIO                 = !empty($row->NOMINASI_BIO) ? number_format($row->NOMINASI_BIO, 0, ',', '.') : '0';
              $NOMINASI_HSD_BIO             = !empty($row->NOMINASI_HSD_BIO) ? number_format($row->NOMINASI_HSD_BIO, 0, ',', '.') : '0';
              $NOMINASI_HSD                 = !empty($row->NOMINASI_HSD) ? number_format($row->NOMINASI_HSD, 0, ',', '.') : '0';
              $TOTAL_NOMINASI               = !empty($row->TOTAL_NOMINASI) ? number_format($row->TOTAL_NOMINASI, 0, ',', '.') : '0';
              $TERIMA_MFO                   = !empty($row->TERIMA_MFO) ? number_format($row->TERIMA_MFO, 0, ',', '.') : '0';
              $TERIMA_IDO                   = !empty($row->TERIMA_IDO) ? number_format($row->TERIMA_IDO, 0, ',', '.') : '0';
              $TERIMA_BIO                   = !empty($row->TERIMA_BIO) ? number_format($row->TERIMA_BIO, 0, ',', '.') : '0';
              $TERIMA_HSD_BIO               = !empty($row->TERIMA_HSD_BIO) ? number_format($row->TERIMA_HSD_BIO, 0, ',', '.') : '0';
              $TERIMA_HSD                   = !empty($row->TERIMA_HSD) ? number_format($row->TERIMA_HSD, 0, ',', '.') : '0';
              $TOTAL_TERIMA                 = !empty($row->TOTAL_TERIMA) ? number_format($row->TOTAL_TERIMA, 0, ',', '.') : '0';
              $PERSEN                       = !empty($row->PERSENTASE) ? number_format($row->PERSENTASE, 0, ',', '.') : '0';
      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <td style="text-align:left;"><?php echo $UNIT ?></td>
        <td style="text-align:center;"><?php echo $b . ' ' . $tahun ?></td>
        <td style="text-align:right;"><?php echo $NOMINASI_HSD ?></td>
        <td style="text-align:center;"><?php echo $NOMINASI_MFO ?></td>
        <td style="text-align:center;"><?php echo $NOMINASI_BIO ?></td>
        <td style="text-align:center;"><?php echo $NOMINASI_HSD_BIO ?></td>
        <td style="text-align:center;"><?php echo $NOMINASI_IDO ?></td>

        <td style="text-align:right;"><?php echo $TOTAL_NOMINASI ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_HSD ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_MFO ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_BIO ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_IDO ?></td>
        <td style="text-align:right;"><?php echo $TOTAL_TERIMA ?></td>
        <td style="text-align:right;"><?php echo $PERSEN.'%' ?></td>
    </tr>
    <?php
        endforeach;
        if ($x == 0) {
            echo '<tr><td colspan="18" align="center">Data Tidak Ditemukan</td></tr>';
        }
    ?>

    </tbody>
</table>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
</html>
