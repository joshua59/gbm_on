
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Laporan_Rekap_Kontrak_Transportir Adendum.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">LAPORAN REKAP KONTRAK TRANSPORTIR ADENDUM</div></td>
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
        if ($status_kontrak) {
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Status Kontrak Aktif</td></tr>';
        }
        

        // if ($BULAN){
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">BLTH '.$TAHUN.''.$BULAN.'</td></tr>';
        // } else {
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun '.$TAHUN.'</td></tr>';
        // }
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th colspan="6">Level Pemasok</th>
            <th colspan="6">Level Penerima</th>
            <th rowspan="2">No Kontrak</th>
            <th rowspan="2">Jenis<br> Kontrak</th>
            <th rowspan="2">Tgl Awal Kontrak</th>
            <th rowspan="2">Tgl Akhir Kontrak</th>
            <th rowspan="2">Transportir</th>
            <th rowspan="2">Jalur</th>
            <th rowspan="2">Jarak (KM/ML)</th>
            <th rowspan="2">Harga (RP/L)</th>
            <th rowspan="2">Mekanisme Denda</th>
            <th rowspan="2">Toleransi Losses<br>(%)</th>
            <th rowspan="2">Status</th> 
        </tr>
        <tr>
            <th>Regional</th>
            <th>Level 1</th>
            <th>Level 2</th>
            <th>Level 3</th>
            <th>Pembangkit</th>
            <th>Depo Transit</th>
            <th>Regional</th>
            <th>Level 1</th>
            <th>Level 2</th>
            <th>Level 3</th>
            <th>Pembangkit</th>
            <th>Depo</th>
        </tr>
    </thead>

    <tbody>
    <?php
        $x=0;
        foreach ($data as $row):
        $x++;
    ?>
    <tr>
        <td style="text-align: center"><?php echo $x ?></td>
        <td style="text-align: left"><?php echo $row->PEMASOK_NAMA_REGIONAL; ?></td>
        <td style="text-align: left"><?php echo $row->PEMASOK_LEVEL1; ?></td>
        <td style="text-align: left"><?php echo $row->PEMASOK_LEVEL2; ?></td>
        <td style="text-align: left"><?php echo $row->PEMASOK_LEVEL3; ?></td>
        <td style="text-align: left"><?php echo $row->PEMASOK_LEVEL4; ?></td>
        <td style="text-align: left"><?php echo $row->NAMA_DEPO; ?></td>
        <td style="text-align: left"><?php echo $row->PENERIMA_NAMA_REGIONAL; ?></td>
        <td style="text-align: left"><?php echo $row->PENERIMA_LEVEL1; ?></td>
        <td style="text-align: left"><?php echo $row->PENERIMA_LEVEL2; ?></td>
        <td style="text-align: left"><?php echo $row->PENERIMA_LEVEL3; ?></td>
        <td style="text-align: left"><?php echo $row->PENERIMA_LEVEL4; ?></td>
        <td style="text-align: left"><?php echo $row->DEPO_TRANSIT; ?></td>
        <td style="text-align: center"><?php echo $row->KD_KONTRAK_TRANS; ?></td>
        <td style="text-align: center"><?php echo $row->JENIS; ?></td>
        <td style="text-align: center"><?php echo $row->TGL_KONTRAK_TRANS; ?></td>
        <td style="text-align: center"><?php echo $row->TGL_KONTRAK_TRANS_AKHIR; ?></td>
        <td style="text-align: center"><?php echo $row->NAMA_TRANSPORTIR; ?></td>
        <td style="text-align: center"><?php echo $row->NAME_SETTING; ?></td>
        <td style="text-align: center"><?php echo number_format($row->JARAK_DET_KONTRAK_TRANS,2,',','.') ?></td>
        <td style="text-align: center"><?php echo number_format($row->HARGA_KONTRAK_TRANS,2,',','.') ?></td>
        <td style="text-align: center"><?php echo $row->NAMA_DENDA; ?></td>
        <td style="text-align: center"><?php echo number_format($row->LOSSES,2,',','.') ?></td>
        <td style="text-align: center"><?php echo $row->STATUS; ?></td>
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
