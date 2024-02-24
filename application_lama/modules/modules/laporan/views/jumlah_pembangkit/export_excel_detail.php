
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Detail_Laporan_Jumlah_Pembangkit_BBM.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><h3>DETAIL LAPORAN JUMLAH PEMBANGKIT BBM</h3></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table border="0" style="width:100%;">
    <?php
        $jml_lv=4;
        if($ID_REGIONAL == "" && $COCODE == "" && $PLANT == "" && $STORE_SLOC == "") {
          $jml_lv = 0;
        }
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
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">AREA ' . $PLANT_NAMA . '</td></tr>';
        }
        if ($STORE_SLOC) {
            $jml_lv= $jml_lv - 1; //0
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">RAYON ' . $STORE_SLOC_NAMA . '</td></tr>';
        }
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th rowspan="2">No</th>
        <th colspan="4">Level</th>
        <!-- <?php
            if ($jml_lv > 1) {
                echo '<th colspan="' . $jml_lv . '">Level</th>';
            } elseif ($jml_lv == 1) {
                echo '<th rowspan="2">Level 3</th>';
            }
        ?> -->
        <th rowspan="2">Unit Pembangkit</th>
        <th colspan="5">Kapasitas Tangki Per Jenis Bahan Bakar (L)</th>
        <th rowspan="2" style="width: 1px;">Total Kapasitas (L)</th>
        <th rowspan="2">Latitude</th>
        <th rowspan="2">Longtitude</th>
        <th rowspan="2">Status</th>
    </tr>
    <tr>
      <!-- <?php
          if ($jml_lv == 3) {
              echo '<th>1</th>';
              echo '<th>2</th>';
              echo '<th>3</th>';
          } elseif ($jml_lv == 2) {
              echo '<th>2</th>';
              echo '<th>3</th>';
          }
      ?> -->
      <th>0</th>
      <th>1</th>
      <th>2</th>
      <th>3</th>
      <th>HSD</th>
      <th>MFO</th>
      <th>BIO</th>
      <th>HSD+BIO</th>
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
              $LEVEL0                     = !empty($row->LEVEL0) ? $row->LEVEL0 : '-';
              $LEVEL1                     = !empty($row->LEVEL1) ? $row->LEVEL1 : '-';
              $LEVEL2                     = !empty($row->LEVEL2) ? $row->LEVEL2 : '-';
              $LEVEL3                     = !empty($row->LEVEL3) ? $row->LEVEL3 : '-';
              $UNIT                       = !empty($row->UNIT) ? $row->UNIT : '-';
              // $VOL_TERIMA                   = !empty($row->VOL_TERIMA) ? number_format($row->VOL_TERIMA, 0, ',', '.') : '0';
              $HSD                        = $row->HSD == '0.00' ? '0' : number_format($row->HSD, 0, ',', '.');
              $MFO                        = $row->MFO == '0.00' ? '0' : number_format($row->MFO, 0, ',', '.');
              $BIO                        = $row->BIO == '0.00' ? '0' : number_format($row->BIO, 0, ',', '.');
              $HSD_BIO                    = $row->HSD_BIO == '0.00' ? '0' : number_format($row->HSD_BIO, 0, ',', '.');
              $IDO                        = $row->IDO == '0.00' ? '0' : number_format($row->IDO, 0, ',', '.');
              $TOTAL_KAPASITAS            = $row->KAPASITAS == '0.00' ? '0' : number_format($row->KAPASITAS, 0, ',', '.');
              $LATITUDE                   = !empty($row->LATITUDE) ? $row->LATITUDE : '-';
              $LONGITUDE                  = !empty($row->LONGITUDE) ? $row->LONGITUDE : '-';
              $AKTIF                      = !empty($row->AKTIF) ? $row->AKTIF : '-';
              if ($AKTIF == '1') {
                  $AKTIF = 'Aktif';
              } else {
                  $AKTIF = 'Tidak Aktif';
              }
      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <!-- <?php
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
        ?> -->
        <td style="text-align:left;"><?php echo $LEVEL0 ?></td>
        <td style="text-align:left;"><?php echo $LEVEL1 ?></td>
        <td style="text-align:left;"><?php echo $LEVEL2 ?></td>
        <td style="text-align:left;"><?php echo $LEVEL3 ?></td>
        <td style="text-align:left;"><?php echo $UNIT ?></td>
        <td style="text-align:right;"><?php echo $HSD ?></td>
        <td style="text-align:right;"><?php echo $MFO ?></td>
        <td style="text-align:right;"><?php echo $BIO ?></td>
        <td style="text-align:right;"><?php echo $HSD_BIO ?></td>
        <td style="text-align:right;"><?php echo $IDO ?></td>
        <td style="text-align:right;"><?php echo $TOTAL_KAPASITAS ?></td>
        <td style="text-align:right;"><?php echo $LATITUDE ?></td>
        <td style="text-align:right;"><?php echo $LONGITUDE ?></td>
        <td style="text-align:center;"><?php echo $AKTIF ?></td>
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
