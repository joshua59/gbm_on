
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=LAPORAN_STOK_AKHIR_BBM.xls');

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
<style type="text/css">
    ul.dashed{
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }

    ul.dashed > li {
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }
   
    ul.dashed > li:before {
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }   
</style>
<table border="0" style="width:100%;">
    <tr>
        <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">LAPORAN STOK AKHIR BBM<br>
            <?php echo "s/d ".$TANGGAL." ".$NAMA_BULAN." ".$TAHUN ?></div></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table border="0" style="width:100%;">
    <?php
        $jml_lv=4;
        if ($ID_REGIONAL) {
            if($ID_REGIONAL_NAMA == '--Pilih Regional--' || $ID_REGIONAL_NAMA == 'All' ) {
                $REG = 'PUSAT';
            } else {
                $REG = $ID_REGIONAL_NAMA;
            }
            $jml_lv= $jml_lv - 1;
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $REG . '</td></tr>';
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

    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

 <table class="tdetail" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th style="text-align: center" rowspan="2">NO</th>
            <th style="text-align: center" colspan="4">LEVEL</th>
            <th style="text-align: center" rowspan="2">PEMBANGKIT</th>
            <th style="text-align: center" rowspan="2">JENIS BAHAN BAKAR</th>
            <th style="text-align: center" rowspan="2">TGL STOCK TERAKHIR</th>
            <th style="text-align: center" rowspan="2">DEAD STOCK<br>(L)</th>
            <th style="text-align: center" rowspan="2">PEMAKAIAN TERTINGGI<br>(L)</th>
            <th style="text-align: center" colspan="2">STOCK</th>
            <th style="text-align: center" rowspan="2">HOP<br>(Hari)</th>
        </tr>
        <tr>
            <th style="text-align: center">0</th>
            <th style="text-align: center">1</th>
            <th style="text-align: center">2</th>
            <th style="text-align: center">3</th>
            <th style="text-align: center">AKHIR<br>(L)</th>
            <th style="text-align: center">AKHIR<br>EFEKTIF<br>(L)</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $x = 0;
            foreach ($data as $value) : 
            $x++;
        ?>
        <tr>
            <td><?php echo $x?></td>
            <td><?php echo $value['NAMA_REGIONAL'] ?></td>
            <td><?php echo $value['LEVEL1'] ?></td>
            <td><?php echo $value['LEVEL2'] ?></td>
            <td><?php echo $value['LEVEL3'] ?></td>
            <td><?php echo $value['LEVEL4'] ?></td>
            <td style="text-align: center"><?php echo $value['NAMA_JNS_BHN_BKR'] ?></td>
            <td style="text-align: center"><?php echo $value['TGL_MUTASI_PERSEDIAAN'] ?></td>
            <td style="text-align: right"><?php echo number_format($value['DEAD_STOCK'],2,',','.') ?></td>
            <td style="text-align: right"><?php echo number_format($value['MAX_PEMAKAIAN'],2,',','.') ?></td>
            <td style="text-align: right"><?php echo number_format($value['STOCK_AKHIR_REAL'],2,',','.') ?></td>
            <td style="text-align: right"><?php echo number_format($value['STOCK_AKHIR_EFEKTIF'],2,',','.') ?></td>
            <td style="text-align: right"><?php echo number_format($value['SHO'],2,',',',') ?></td>
        </tr>
        <?php endforeach; ?>

    </tbody>
</table>
<ul class="dashed">
    <li>(* HOP : Hari Operasi Pembangkit)</li>
    <li>(* Hari Operasi Pembangkit (Hari) : untuk pembangkit selain PLTU)</li>
    <li>(* Hari Operasi Pembangkit (kali start) : untuk pembangkit PLTU) </li>                
</ul>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
