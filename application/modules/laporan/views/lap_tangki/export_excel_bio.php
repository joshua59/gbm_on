
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Detail_Laporan_Tangki_BBM.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">LAPORAN DETAIL TANGKI BBM</div></td>
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
        <th>Nama Tangki</th>
        <th>Ditera Oleh</th>
        <th>Tanggal Awal Tera</th>
        <th>Tanggal Akhir Tera</th>
        <th>Volume (L)</th>
        <th>Dead Stock (L)</th>
        <th>Kapasitas Efektif (L)</th>
        <th>Status</th>
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
              $NAMA_TANGKI = !empty($row->NAMA_TANGKI) ? $row->NAMA_TANGKI : '-';
              $DITERA_OLEH = !empty($row->DITERA_OLEH) ? $row->DITERA_OLEH : '-';
              $TGL_AWAL_TERA = !empty($row->TGL_AWAL_TERA) ? $row->TGL_AWAL_TERA : '-';
              $TGL_AKHIR_TERA = !empty($row->TGL_AKHIR_TERA) ? $row->TGL_AKHIR_TERA : '-';
              $VOLUME_TANGKI = !empty($row->VOLUME_TANGKI) ? number_format($row->VOLUME_TANGKI, 0, ',', '.') : '0';
              $DEADSTOCK_TANGKI = !empty($row->DEADSTOCK_TANGKI) ? number_format($row->DEADSTOCK_TANGKI, 0, ',', '.') : '0';
              $STOCKEFEKTIF_TANGKI = !empty($row->STOCKEFEKTIF_TANGKI) ? number_format($row->STOCKEFEKTIF_TANGKI, 0, ',', '.') : '0';
              $STATUS_AKTIF = !empty($row->STATUS_AKTIF) ? $row->STATUS_AKTIF : '-';

      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <td style="text-align:center;"><?php echo $NAMA_TANGKI ?></td>
        <td style="text-align:center;"><?php echo $DITERA_OLEH ?></td>
        <td style="text-align:center;"><?php echo $TGL_AWAL_TERA ?></td>
        <td style="text-align:center;"><?php echo $TGL_AKHIR_TERA ?></td>
        <td style="text-align:right;"><?php echo $VOLUME_TANGKI ?></td>
        <td style="text-align:right;"><?php echo $DEADSTOCK_TANGKI ?></td>
        <td style="text-align:right;"><?php echo $STOCKEFEKTIF_TANGKI ?></td>
        <td style="text-align:center;"><?php echo $STATUS_AKTIF ?></td>
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
