
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Laporan_Perolehan_Harga_BBM.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">LAPORAN PEROLEHAN HARGA BBM</div></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table border="0" style="width:100%;">
    <?php
        $jml_lv=4;
        if ($ID_REGIONAL) {
            $jml_lv= $jml_lv - 1; //3

            if ($ID_REGIONAL!='All') {
                echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $ID_REGIONAL_NAMA . '</td></tr>';
            }
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
        if ($PEMASOK<>'-') {
            $jml_lv= $jml_lv - 1; //0
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Pemasok ' . $PEMASOK_NAMA . '</td></tr>';
        }
        if ($PERIODE) {        
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Periode '.$PERIODE_NAMA.'</td></tr>';
        } 
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th>NO</th>        
        <th>UNIT</th>                            
        <th>PEMASOK</th>        
        <th>JENIS<br>BAHAN BAKAR</th>
        <th>PERIODE</th>
        <th>HARGA PRODUK<br>(Rp/Liter)</th>
        <th>OAT 1<br>(Rp/Liter)</th>
        <th>JARAK<br>(KM/ML)</th>
        <th>TOTAL<br>PENERIMAAN</th>
        <th>TOTAL PEROLEHAN HARGA<br>((Produk&nbsp;+&nbsp;OAT)&nbsp;x&nbsp;Volume)</th>
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
          $NAMA_PEMASOK = !empty($row->NAMA_PEMASOK) ? $row->NAMA_PEMASOK : '-';
          $NAMA_JNS_BHN_BKR = !empty($row->NAMA_JNS_BHN_BKR) ? $row->NAMA_JNS_BHN_BKR : '-';          
          $HARGA = !empty($row->HARGA) ? number_format($row->HARGA, 2, ',', '.') : '0';
          $OAT1 = !empty($row->OAT1) ? number_format($row->OAT1, 2, ',', '.') : '0';
          $JARAK = !empty($row->JARAK) ? number_format($row->JARAK, 2, ',', '.') : '0';
          $TERIMA = !empty($row->TERIMA) ? number_format($row->TERIMA, 2, ',', '.') : '0';
          $TOTAL = !empty($row->TOTAL) ? number_format($row->TOTAL, 2, ',', '.') : '0';
      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <td style="text-align:left;"><?php echo $UNIT ?></td>
        <td style="text-align:left;"><?php echo $NAMA_PEMASOK ?></td>
        <td style="text-align:center;"><?php echo $NAMA_JNS_BHN_BKR ?></td>
        <td style="text-align:center;"><?php echo $PERIODE_NAMA ?></td>        
        <td style="text-align:right;"><?php echo $HARGA ?></td>
        <td style="text-align:right;"><?php echo $OAT1 ?></td>
        <td style="text-align:right;"><?php echo $JARAK ?></td>
        <td style="text-align:right;"><?php echo $TERIMA ?></td>
        <td style="text-align:right;"><?php echo $TOTAL ?></td>
    </tr>
    <?php
        endforeach;

        if ($x == 0) {
            echo '<tr><td colspan="10" align="center">Data Tidak Ditemukan</td></tr>';
        }
    ?>

    </tbody>
</table>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br><hr>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><i>(*Harga termasuk PPN 10%)</i></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><i>(*OAT - Ongkos Angkut Transportasi)</i></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><i>(*Total Perolehan Harga ((Produk + OAT) x Volume))</i></td></tr>
</table><br>
</html>
