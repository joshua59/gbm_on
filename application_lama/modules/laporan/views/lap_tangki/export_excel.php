
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Laporan_Tangki_BBM.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">LAPORAN TANGKI BBM</div></td>
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
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th>No</th>
        <th>Pembangkit</th>
        <th>Jumlah Tangki</th>
        <th>Jenis Bahan Bakar</th>
        <th>Volume (L)</th>
        <th>Dead Stock (L)</th>
        <th>Kapasitas Efektif (L)</th>
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
              $LEVEL4 = !empty($row->LEVEL4) ? $row->LEVEL4 : '-';
              $JML_TANGKI = !empty($row->JML_TANGKI) ? $row->JML_TANGKI : '-';
              $NAMA_JNS_BHN_BKR = !empty($row->NAMA_JNS_BHN_BKR) ? $row->NAMA_JNS_BHN_BKR : '-';
              $VOLUME = !empty($row->VOLUME) ? number_format($row->VOLUME, 0, ',', '.') : '0';
              $DEADSTOCK = !empty($row->DEADSTOCK) ? number_format($row->DEADSTOCK, 0, ',', '.') : '0';
              $STOCKEFEKTIF = !empty($row->STOCKEFEKTIF) ? number_format($row->STOCKEFEKTIF, 0, ',', '.') : '0';
      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <td style="text-align:center;"><?php echo $LEVEL4 ?></td>
        <td style="text-align:center;"><?php echo $JML_TANGKI ?></td>
        <td style="text-align:center;"><?php echo $NAMA_JNS_BHN_BKR ?></td>
        <td style="text-align:right;"><?php echo $VOLUME ?></td>
        <td style="text-align:right;"><?php echo $DEADSTOCK ?></td>
        <td style="text-align:right;"><?php echo $STOCKEFEKTIF ?></td>
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
