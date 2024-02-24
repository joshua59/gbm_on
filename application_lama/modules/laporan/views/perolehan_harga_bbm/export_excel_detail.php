
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Detail_Laporan_Penerimaan_Pemasok.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">DETAIL LAPORAN PENERIMAAN PER PEMASOK</div></td>
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
        if ($VTRANS) {
            // $jml_lv= $jml_lv - 1; //0
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Transportir ' . $VTRANS . '</td></tr>';
        }

        if ($TGLAWAL) {
            $tAwal       = substr($TGLAWAL, 0, 2);
            $taunAwal    = substr($TGLAWAL, 4, 7);
            $blnAwal     = substr($TGLAWAL, 2, 2);
            $tglAwal     = $taunAwal . '-' . $blnAwal . '-' . $tAwal;

            $tAkhir       = substr($TGLAKHIR, 0, 2);
            $taunAkhir    = substr($TGLAKHIR, 4, 7);
            $blnAkhir     = substr($TGLAKHIR, 2, 2);
            $tglAkhir     = $taunAkhir . '-' . $blnAkhir . '-' . $tAkhir;
            if ($TGLAWAL == '-' and $TGLAKHIR == '-') {
                $tglAwal  = 'Awal';
                $tglAkhir = 'Akhir';
            }
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Periode ' . $tglAwal . ' s/d ' . $tglAkhir . '</td></tr>';
        } else {
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun ' . $TGLAKHIR . '</td></tr>';
        }
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
      <?php
          $row_tambah = '';
          if ($jml_lv > 1) {
              echo '<th rowspan="2">NO</th>';
              echo '<th colspan="' . $jml_lv . '">Level</th>';
              $row_tambah = 'rowspan="2"';
          } elseif ($jml_lv == 1) {
              echo '<th>NO</th>';
              echo '<th>Level 3</th>';
          } else {
            echo '<th>NO</th>';
          }
      ?>
      <th <?php echo $row_tambah; ?> width="100px;">Unit Pembangkit</th>
      <th <?php echo $row_tambah; ?> >Pemasok BBM</th>
      <th <?php echo $row_tambah; ?> >Nama Transportir</th>
      <th <?php echo $row_tambah; ?> >No Penerimaan</th>
      <th <?php echo $row_tambah; ?> >Jenis Bahan Bakar</th>
      <th <?php echo $row_tambah; ?> width="100px;">Tanggal DO/TUG/BA</th>
      <th <?php echo $row_tambah; ?> >Tanggal Terima Fisik</th>
      <th <?php echo $row_tambah; ?> >Volume Terima DO/TUG/BA (L)</th>
      <th <?php echo $row_tambah; ?> >Volume Terima Real (L)</th>
      <?php
          if ($jml_lv == 3) {
              echo '<tr>';
              echo '<th>1</th>';
              echo '<th>2</th>';
              echo '<th>3</th>';
              echo '</tr>';
          } elseif ($jml_lv == 2) {
              echo '<tr>';
              echo '<th>2</th>';
              echo '<th>3</th>';
              echo '</tr>';
          }
      ?>
    </thead>

    <tbody>
    <?php
        $x=0;
        foreach ($data as $row):
        $x++;
    ?>
    <tr>
      <?php
              $LEVEL0                             = !empty($row->REGIONAL) ? $row->REGIONAL : '-';
              $LEVEL1                             = !empty($row->LEVEL1) ? $row->LEVEL1 : '-';
              $LEVEL2                             = !empty($row->LEVEL2) ? $row->LEVEL2 : '-';
              $LEVEL3                             = !empty($row->LEVEL3) ? $row->LEVEL3 : '-';
              $UNIT                               = !empty($row->UNIT) ? $row->UNIT : '-';
              $NAMA_PEMASOK                       = !empty($row->NAMA_PEMASOK) ? $row->NAMA_PEMASOK : '-';
              $NAMA_TRANSPORTIR                   = !empty($row->NAMA_TRANSPORTIR) ? $row->NAMA_TRANSPORTIR : '-';
              $NO_PENERIMAAN                      = !empty($row->NO_PENERIMAAN) ? $row->NO_PENERIMAAN : '-';
              $JNS_BBM                            = !empty($row->JNS_BBM) ? $row->JNS_BBM : '-';
              $TGL_DO                             = !empty($row->TGL_DO) ? $row->TGL_DO : '-';
              $TERIMA_FISIK                       = !empty($row->TERIMA_FISIK) ? $row->TERIMA_FISIK : '-';

              $VOL_TERIMA                   = !empty($row->VOL_TERIMA) ? number_format($row->VOL_TERIMA, 0, ',', '.') : '0';
              $VOL_TERIMA_REAL                    = !empty($row->VOL_TERIMA_REAL) ? number_format($row->VOL_TERIMA_REAL, 0, ',', '.') : '0';             
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
        <td style="text-align:left;"><?php echo $NAMA_PEMASOK ?></td>
        <td style="text-align:left;"><?php echo $NAMA_TRANSPORTIR ?></td>
        <td style="text-align:center;"><?php echo $NO_PENERIMAAN ?></td>        
        <td style="text-align:center;"><?php echo $JNS_BBM ?></td>
        
        
        <td style="text-align:center;"><?php echo $TGL_DO ?></td>
        <td style="text-align:center;"><?php echo $TERIMA_FISIK ?></td>

        <td style="text-align:right;"><?php echo $VOL_TERIMA ?></td>
        <td style="text-align:right;"><?php echo $VOL_TERIMA_REAL ?></td>
    </tr>
    <?php
        endforeach;

        if ($x == 0) {
            echo '<tr><td colspan="13" align="center">Data Tidak Ditemukan</td></tr>';
        }
    ?>

    </tbody>
</table>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
</html>
