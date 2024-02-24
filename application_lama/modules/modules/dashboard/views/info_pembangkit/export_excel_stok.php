
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Data_Stok_BBM.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">DATA STOK BBM</div></td>
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
        if ($SLOC) {
            $jml_lv= $jml_lv - 1; //0
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5"> ' . $SLOC_NAMA . '</td></tr>';
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
        <th>No</th>
        <th>Jenis BBM</th>
        <th>Bulan Tahun</th>
        <th>Tanggal Stock Terakhir</th>
        <th>Stock Akhir (L)</th>
        <th>Stock Efektif (L)</th>
        <th>Pemakaian Tertinggi (L)</th>
        <th>SHO (Hari)</th>        
    </tr>

    </thead>

    <tbody>
    <?php
        function set_blth($tanggal){
            $bulan = array ('01' =>   'Januari',
                            '02' =>   'Februari',
                            '03' =>   'Maret',
                            '04' =>   'April',
                            '05' =>   'Mei',
                            '06' =>   'Juni',
                            '07' =>   'Juli',
                            '08' =>   'Agustus',
                            '09' =>   'September',
                            '10' =>   'Oktober',
                            '11' =>   'November',
                            '12' =>   'Desember'
                    );            
            $split = explode('-', $tanggal);
            return ($bulan[$split[1]]. ' ' . $split[0]);
        }
            
        $x=0;
        foreach ($data as $row):
        $x++;
    ?>

    <tr>
      <?php                

        $NAMA_JNS_BHN_BKR = !empty($row->NAMA_JNS_BHN_BKR) ? $row->NAMA_JNS_BHN_BKR : '-';
        $TGL_MUTASI_PERSEDIAAN = !empty($row->TGL_MUTASI_PERSEDIAAN) ? $row->TGL_MUTASI_PERSEDIAAN : '-';
        $BTLH = set_blth($TGL_MUTASI_PERSEDIAAN);

        $STOCK_AKHIR_REAL = !empty($row->STOCK_AKHIR_REAL) ? number_format($row->STOCK_AKHIR_REAL, 2, ',', '.') : '0';
        $STOCK_AKHIR_EFEKTIF = !empty($row->STOCK_AKHIR_EFEKTIF) ? number_format($row->STOCK_AKHIR_EFEKTIF, 2, ',', '.') : '0';
        $MAX_PEMAKAIAN = !empty($row->MAX_PEMAKAIAN) ? number_format($row->MAX_PEMAKAIAN, 2, ',', '.') : '0';
        $SHO = !empty($row->SHO) ? number_format($row->SHO, 2, ',', '.') : '0';
      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <td style="text-align:center;"><?php echo $NAMA_JNS_BHN_BKR ?></td>
        <td style="text-align:center;"><?php echo $BTLH ?></td>
        <td style="text-align:center;"><?php echo $TGL_MUTASI_PERSEDIAAN ?></td>
        <td style="text-align:right;"><?php echo $STOCK_AKHIR_REAL ?></td>
        <td style="text-align:right;"><?php echo $STOCK_AKHIR_EFEKTIF ?></td>
        <td style="text-align:right;"><?php echo $MAX_PEMAKAIAN ?></td>
        <td style="text-align:right;"><?php echo $SHO ?></td>        
    </tr>
    <?php
        endforeach;

        if ($x == 0) {
            echo '<tr><td colspan="8" align="center">Data Tidak Ditemukan</td></tr>';
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
    <tr><td style="text-align:left;font-size: 10px;"><i>(*SHO : Sisa Hari Operasi)</i></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><i>(*Sisa Hari Operasi (Hari) : untuk pembangkit selain PLTU)</i></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><i>(*Sisa Hari Operasi (kali start) : untuk pembangkit PLTU)</i></td></tr>
</table><br>
</html>
