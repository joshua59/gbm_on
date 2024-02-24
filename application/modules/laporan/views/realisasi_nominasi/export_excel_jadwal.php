
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Jadwal_Laporan_Realisaasi_Nominasi_BBM.xls');

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
        <style>
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
        <td style="width:80%;text-align:center" colspan="8"><h3>JADWAL LAPORAN REALISASI NOMINASI BBM</h3></td>
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
        <!-- <th colspan="4">Level</th> -->
        <?php
            if ($jml_lv > 1) {
                echo '<th colspan="' . $jml_lv . '">Level</th>';
            } elseif ($jml_lv == 1) {
                echo '<th rowspan="2">Level 3</th>';
            }
        ?>
        <th rowspan="2">Unit Pembangkit</th>
        <th rowspan="2">Tanggal</th>
        <th colspan="5">Nominasi (L)</th>
        <th rowspan="2" style="width:1px;">Total Nominasi (L)</th>
        <th colspan="4">Terima (L)</th>
        <th rowspan="2" style="width:1px;">Total Terima (L)</th>
    </tr>
    <tr>
      <?php
          if ($jml_lv == 3) {
              echo '<th>1</th>';
              echo '<th>2</th>';
              echo '<th>3</th>';
          } elseif ($jml_lv == 2) {
              echo '<th>2</th>';
              echo '<th>3</th>';
          }
      ?>
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
              $UNIT                                = !empty($row->UNIT) ? $row->UNIT : '-';
              $TGL = !empty($row->TGL) ? $row->TGL : '-';
              $NOMINASI_HSD                            = $row->NOMINASI_HSD == '0.00' ? '0' : number_format($row->NOMINASI_HSD, 0, ',', '.');
              $NOMINASI_MFO                            = $row->NOMINASI_MFO == '0.00' ? '0' : number_format($row->NOMINASI_MFO, 0, ',', '.');
              $NOMINASI_BIO                            = $row->NOMINASI_BIO == '0.00' ? '0' : number_format($row->NOMINASI_BIO, 0, ',', '.');
              $NOMINASI_HSD_BIO                            = $row->NOMINASI_HSD_BIO == '0.00' ? '0' : number_format($row->NOMINASI_HSD_BIO, 0, ',', '.');
              $NOMINASI_IDO                            = $row->NOMINASI_IDO == '0.00' ? '0' : number_format($row->NOMINASI_IDO, 0, ',', '.');
              $TOTAL_NOMINASI                          = $row->TOTAL_NOMINASI == '0.00' ? '0' : number_format($row->TOTAL_NOMINASI, 0, ',', '.');
              $TERIMA_HSD                          = $row->TERIMA_HSD == '0.00' ? '0' : number_format($row->TERIMA_HSD, 0, ',', '.');
              $TERIMA_MFO                          = $row->TERIMA_MFO == '0.00' ? '0' : number_format($row->TERIMA_MFO, 0, ',', '.');
              $TERIMA_BIO                          = $row->TERIMA_BIO == '0.00' ? '0' : number_format($row->TERIMA_BIO, 0, ',', '.');
              $TERIMA_IDO                          = $row->TERIMA_IDO == '0.00' ? '0' : number_format($row->TERIMA_IDO, 0, ',', '.');
              $TOTAL_TERIMA                        = $row->TOTAL_TERIMA == '0.00' ? '0' : number_format($row->TOTAL_TERIMA, 0, ',', '.');
      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <?php
            if ($jml_lv == 3) {
                echo '<td>' . $row->LEVEL1 . '</td>';
                echo '<td>' . $row->LEVEL2 . '</td>';
                echo '<td>' . $row->LEVEL3 . '</td>';
            } elseif ($jml_lv == 2) {
                echo '<td>' . $row->LEVEL2 . '</td>';
                echo '<td>' . $row->LEVEL3 . '</td>';
            } elseif ($jml_lv == 1) {
                echo '<td>' . $row->LEVEL3 . '</td>';
            }
        ?>

        <td style="text-align:left;"><?php echo $UNIT ?></td>
        <td style="text-align:right;"><?php echo $TGL ?></td>
        <td style="text-align:right;"><?php echo $NOMINASI_HSD ?></td>
        <td style="text-align:right;"><?php echo $NOMINASI_MFO ?></td>
        <td style="text-align:right;"><?php echo $NOMINASI_BIO ?></td>
        <td style="text-align:right;"><?php echo $NOMINASI_HSD_BIO ?></td>
        <td style="text-align:right;"><?php echo $NOMINASI_IDO ?></td>
        <td style="text-align:right;"><?php echo $TOTAL_NOMINASI ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_HSD ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_MFO ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_BIO ?></td>
        <td style="text-align:right;"><?php echo $TERIMA_IDO ?></td>
        <td style="text-align:right;"><?php echo $TOTAL_TERIMA ?></td>
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
