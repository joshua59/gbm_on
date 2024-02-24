
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Laporan_Rekap_Kontrak_Transportir.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">LAPORAN REKAP KONTRAK TRANSPORTIR</div></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table border="0" style="width:100%;">
    <?php
        $jml_lv=4;
        if ($ID_REGIONAL) {
            $jml_lv= $jml_lv - 1;
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $ID_REGIONAL_NAMA . '</td></tr>';
        }
        if ($COCODE) {
            $jml_lv= $jml_lv - 1;
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $COCODE_NAMA . '</td></tr>';
        }
        if ($PLANT) {
            $jml_lv= $jml_lv - 1;
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $PLANT_NAMA . '</td></tr>';
        }
        if ($STORE_SLOC) {
            $jml_lv= $jml_lv - 1;
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $STORE_SLOC_NAMA . '</td></tr>';
        }
        if ($ID_TRANSPORTIR) {
            $jml_lv= $jml_lv - 1;
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Transportir ' . $ID_TRANSPORTIR_NAMA . '</td></tr>';
        }
        if ($TGL_DARI) {
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $TGL_DARI . ' s/d ' . $TGL_SAMPAI . '</td></tr>';
        }
        if ($STATUS_KONTRAK) {
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Status Kontrak Aktif</td></tr>';
        }
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th>No</th>
        <th>Regional</th>
        <th>Level 1</th>
        <th>Level 2</th>
        <th>Level 3</th>
        <th>Pembangkit</th>
        <th>Transportir</th>
        <th>No Kontrak</th>
        <th>No Adendum</th>
        <th>Tgl Awal Kontrak</th>
        <th>Tgl Akhir Kontrak</th>
        <th>Mekanisme Denda</th>
        <th>Toleransi Losses<br>(%)</th>
        <th>Nilai Kontrak</th>
    </tr>
    </thead>

    <tbody>
    <?php
        $x=0;
        foreach ($data as $row):
        $x++;
    ?>
    <tr>
        <td style="text-align:center;"><?php echo $x ?></td>
        <td><?php echo $row->NAMA_REGIONAL ?></td>
        <td><?php echo $row->LEVEL1 ?></td>
        <td><?php echo $row->LEVEL2 ?></td>
        <td><?php echo $row->LEVEL3 ?></td>
        <td><?php echo $row->LEVEL4 ?></td>
        <td><?php echo $row->NAMA_TRANSPORTIR ?></td>
        <td style="text-align:center;"><?php echo $row->KD_KONTRAK_AWAL ?></td>
        <?php if($JENIS == 'XLS') {
            echo "<td style='text-align:center;'>'".$row->KD_ADENDUM."</td>";
        } else {
            echo "<td style='text-align:center;'>".$row->KD_ADENDUM."</td>";
        } ?>
        <td style="text-align:center;"><?php echo $row->TGL_KONTRAK_TRANS ?></td>
        <td style="text-align:center;"><?php echo $row->TGL_KONTRAK_TRANS_AKHIR ?></td>
        <td style="text-align:center;"><?php echo $row->NAMA_DENDA ?></td>
        <td style="text-align:right;"><?php echo number_format($row->LOSSES, 2, ',', '.') ?></td>
        <td style="text-align:right;"><?php echo number_format($row->NILAI_KONTRAK_TRANS, 2, ',', '.') ?></td>
    </tr>
    <?php
        endforeach;

        if ($x == 0) {
            echo '<tr><td colspan="14" align="center">Data Tidak Ditemukan</td></tr>';
        }
    ?>

    </tbody>
</table>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
