
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Laporan_Penerimaan_BBM.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">LAPORAN PENERIMAAN BBM <br> REKAP KOMPONEN BIO</div></td>
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
        // if ($BULAN) {
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">BLTH ' . $TAHUN . '' . $BULAN . '</td></tr>';
        // } else {
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun ' . $TAHUN . '</td></tr>';
        // }
        if (($TGLAWAL!='-') && ($TGLAKHIR!='-')) {
            if ($TGLAWAL!='-') {
                $tAwal       = substr($TGLAWAL, 0, 2);
                $taunAwal    = substr($TGLAWAL, 4, 7);
                $blnAwal     = substr($TGLAWAL, 2, 2);
                $tglAwal     = $taunAwal . '-' . $blnAwal . '-' . $tAwal;

                $tAkhir       = substr($TGLAKHIR, 0, 2);
                $taunAkhir    = substr($TGLAKHIR, 4, 7);
                $blnAkhir     = substr($TGLAKHIR, 2, 2);
                $tglAkhir     = $taunAkhir . '-' . $blnAkhir . '-' . $tAkhir;
                // $tglAwal  = $TGLAWAL;
                // $tglAkhir = $TGLAKHIR;
                if ($TGLAWAL == '-' and $TGLAKHIR == '-') {
                    $tglAwal  = 'Awal';
                    $tglAkhir = 'Akhir';
                }
                echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Periode ' . $tglAwal . ' s/d ' . $tglAkhir . '</td></tr>';
            } else {
                echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun ' . $TGLAKHIR . '</td></tr>';
            }
        }
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">Unit</th>
        <th rowspan="2">Jenis Bahan Bakar</th>
        <th rowspan="2">Komponen</th>
        <th rowspan="2">Tgl Awal Terima</th>
        <th rowspan="2">Tgl Akhir Terima</th>
        <th colspan="4">Jenis Penerimaan</th>
        <th colspan="2">Total Volume Terima</th>
    </tr>
    <tr>
      <th>Total</th>
      <th>Unit Lain</th>
      <th>Pemasok</th>
      <th>Pengembalian</th>
      <th>Total Volume Terima DO (L)</th>
      <th>Total Volume Terima Real (L)</th>
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
              $UNIT = !empty($row->UNIT) ? $row->UNIT : '-';
              $NAMA_JNS_BHN_BKR = !empty($row->NAMA_JNS_BHN_BKR) ? $row->NAMA_JNS_BHN_BKR : '-';
              $KOMPONEN_BIO = !empty($row->KOMPONEN_BIO) ? $row->KOMPONEN_BIO : '-';
              $TGL_TERIMA_AWAL = !empty($row->TGL_TERIMA_AWAL) ? $row->TGL_TERIMA_AWAL : '-';
              $TGL_TERIMA_AKHIR = !empty($row->TGL_TERIMA_AKHIR) ? $row->TGL_TERIMA_AKHIR : '-';
              $JML_TERIMA = !empty($row->JML_TERIMA) ? number_format($row->JML_TERIMA, 0, ',', '.') : '0';
              $TERIMA_UNIT_LAIN = !empty($row->TERIMA_UNIT_LAIN) ? number_format($row->TERIMA_UNIT_LAIN, 0, ',', '.') : '0';
              $TERIMA_PEMASOK = !empty($row->TERIMA_PEMASOK) ? number_format($row->TERIMA_PEMASOK, 0, ',', '.') : '0';
              $TERIMA_PENGEMBALIAN = !empty($row->TERIMA_PENGEMBALIAN) ? number_format($row->TERIMA_PENGEMBALIAN, 0, ',', '.') : '0';
              $VOL_TERIMA = !empty($row->VOL_TERIMA) ? number_format($row->VOL_TERIMA, 0, ',', '.') : '0';
              $VOL_TERIMA_REAL = !empty($row->VOL_TERIMA_REAL) ? number_format($row->VOL_TERIMA_REAL, 0, ',', '.') : '0';
              // $DEVIASI                      = !empty($row->DEVIASI) ? number_format($row->DEVIASI, 0, ',', '.') : '0';
              // $DEVIASI_PERCENT              = !empty($row->DEVIASI_PERCENT) ? number_format($row->DEVIASI_PERCENT, 0, ',', '.') : '0';
      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <td style="text-align:left;"><?php echo $UNIT ?></td>
        <td style="text-align:center;"><?php echo $NAMA_JNS_BHN_BKR ?></td>
        <td style="text-align:center;"><?php echo $KOMPONEN_BIO ?></td>
        <td style="text-align:center;"><?php echo $TGL_TERIMA_AWAL ?></td>
        <td style="text-align:center;"><?php echo $TGL_TERIMA_AKHIR ?></td>
        <td style="text-align:right;"><?php echo $JML_TERIMA ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_UNIT_LAIN ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_PEMASOK ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_PENGEMBALIAN ?></td>
        <td style="text-align:right;"><?php echo $VOL_TERIMA ?></td>
        <td style="text-align:right;"><?php echo $VOL_TERIMA_REAL ?></td>
        <!-- <td style="text-align:right;"><?php echo $DEVIASI ?> </td>
        <td style="text-align:right;"><?php echo $DEVIASI_PERCENT ?> </td> -->
    </tr>
    <?php
        endforeach;

        if ($x == 0) {
            echo '<tr><td colspan="19" align="center">Data Tidak Ditemukan</td></tr>';
        }
    ?>

    </tbody>
</table>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
</html>
