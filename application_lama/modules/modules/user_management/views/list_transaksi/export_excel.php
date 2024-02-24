
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=List_Transaksi_NPPS.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">LIST TRANSAKSI NPPS</div></td>
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
        // if ($BULAN) {
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">BLTH ' . $TAHUN . '' . $BULAN . '</td></tr>';
        // } else {
        //     echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">Tahun ' . $TAHUN . '</td></tr>';
        // }
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th>No</th>
        <th>Level1</th>
        <th>Level2</th>
        <th>Level3</th>
        <th>Pembangkit</th>
        <th>Nomor Transaksi</th>
        <th>Tgl Transaksi</th>
        <th>User Entry</th>
        <th>Status</th>
    </tr>

    </thead>

    <tbody>
    <?php
        if ($jenis == 1):
            $x=0;
            foreach ($data as $row):
            $x++;
    ?>
        <tr>
        <?php
            $LEVEL1                      = !empty($row->LEVEL1) ? $row->LEVEL1 : '-';
            $LEVEL2                      = !empty($row->LEVEL2) ? $row->LEVEL2 : '-';
            $LEVEL3                      = !empty($row->LEVEL3) ? $row->LEVEL3 : '-';
            $LEVEL4                      = !empty($row->LEVEL4) ? $row->LEVEL4 : '-';
            $NO_NOMINASI                 = !empty($row->NO_NOMINASI) ? $row->NO_NOMINASI : '-';
            $TGL_MTS_NOMINASI            = !empty($row->TGL_MTS_NOMINASI) ? $row->TGL_MTS_NOMINASI : '-';
            $CD_BY_MTS_NOMINASI          = !empty($row->CD_BY_MTS_NOMINASI) ? $row->CD_BY_MTS_NOMINASI : '-';
            $STATUS_APPRO                = !empty($row->STATUS_APPRO) ? $row->STATUS_APPRO : '-';
        ?>
            <td style="text-align:center;"><?php echo $x ?></td>
            <td style="text-align:center;"><?php echo $LEVEL1 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL2 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL3 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL4 ?></td>
            <td style="text-align:center;"><?php echo $NO_NOMINASI ?></td>
            <td style="text-align:center;"><?php echo $TGL_MTS_NOMINASI ?></td>
            <td style="text-align:center;"><?php echo $CD_BY_MTS_NOMINASI ?></td>
            <td style="text-align:center;"><?php echo $STATUS_APPRO ?></td>
        </tr>

    <?php
            endforeach;
        elseif ($jenis == 2):
            $x=0;
            foreach ($data as $row):
            $x++;
    ?>
    <tr>
        <?php
            $LEVEL1                      = !empty($row->LEVEL1) ? $row->LEVEL1 : '-';
            $LEVEL2                      = !empty($row->LEVEL2) ? $row->LEVEL2 : '-';
            $LEVEL3                      = !empty($row->LEVEL3) ? $row->LEVEL3 : '-';
            $LEVEL4                      = !empty($row->LEVEL4) ? $row->LEVEL4 : '-';
            $NO_TUG                      = !empty($row->NO_TUG) ? $row->NO_TUG : '-';
            $TGL_MUTASI_PENGAKUAN        = !empty($row->TGL_MUTASI_PENGAKUAN) ? $row->TGL_MUTASI_PENGAKUAN : '-';
            $CD_BY_MUTASI_PEMAKAIAN      = !empty($row->CD_BY_MUTASI_PEMAKAIAN) ? $row->CD_BY_MUTASI_PEMAKAIAN : '-';
            $STATUS_APPRO                = !empty($row->STATUS_APPRO) ? $row->STATUS_APPRO : '-';
        ?>
            <td style="text-align:center;"><?php echo $x ?></td>
            <td style="text-align:center;"><?php echo $LEVEL1 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL2 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL3 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL4 ?></td>
            <td style="text-align:center;"><?php echo $NO_TUG ?></td>
            <td style="text-align:center;"><?php echo $TGL_MUTASI_PENGAKUAN ?></td>
            <td style="text-align:center;"><?php echo $CD_BY_MUTASI_PEMAKAIAN ?></td>
            <td style="text-align:center;"><?php echo $STATUS_APPRO ?></td>
        </tr>

    <?php
            endforeach;
        elseif ($jenis == 3):
            $x=0;
            foreach ($data as $row):
            $x++;
    ?>
    <tr>
        <?php
            $LEVEL1                      = !empty($row->LEVEL1) ? $row->LEVEL1 : '-';
            $LEVEL2                      = !empty($row->LEVEL2) ? $row->LEVEL2 : '-';
            $LEVEL3                      = !empty($row->LEVEL3) ? $row->LEVEL3 : '-';
            $LEVEL4                      = !empty($row->LEVEL4) ? $row->LEVEL4 : '-';
            $NO_MUTASI_TERIMA            = !empty($row->NO_MUTASI_TERIMA) ? $row->NO_MUTASI_TERIMA : '-';
            $TGL_PENGAKUAN               = !empty($row->TGL_PENGAKUAN) ? $row->TGL_PENGAKUAN : '-';
            $CD_BY_MUTASI_TERIMA         = !empty($row->CD_BY_MUTASI_TERIMA) ? $row->CD_BY_MUTASI_TERIMA : '-';
            $STATUS_APPRO                = !empty($row->STATUS_APPRO) ? $row->STATUS_APPRO : '-';
        ?>
            <td style="text-align:center;"><?php echo $x ?></td>
            <td style="text-align:center;"><?php echo $LEVEL1 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL2 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL3 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL4 ?></td>
            <td style="text-align:center;"><?php echo $NO_MUTASI_TERIMA ?></td>
            <td style="text-align:center;"><?php echo $TGL_PENGAKUAN ?></td>
            <td style="text-align:center;"><?php echo $CD_BY_MUTASI_TERIMA ?></td>
            <td style="text-align:center;"><?php echo $STATUS_APPRO ?></td>
        </tr>

    <?php
            endforeach;
        elseif ($jenis == 4):
            $x=0;
            foreach ($data as $row):
            $x++;
    ?>
    <tr>
        <?php
            $LEVEL1                      = !empty($row->LEVEL1) ? $row->LEVEL1 : '-';
            $LEVEL2                      = !empty($row->LEVEL2) ? $row->LEVEL2 : '-';
            $LEVEL3                      = !empty($row->LEVEL3) ? $row->LEVEL3 : '-';
            $LEVEL4                      = !empty($row->LEVEL4) ? $row->LEVEL4 : '-';
            $NO_STOCKOPNAME              = !empty($row->NO_STOCKOPNAME) ? $row->NO_STOCKOPNAME : '-';
            $TGL_BA_STOCKOPNAME          = !empty($row->TGL_BA_STOCKOPNAME) ? $row->TGL_BA_STOCKOPNAME : '-';
            $CD_BY_STOKOPNAME            = !empty($row->CD_BY_STOKOPNAME) ? $row->CD_BY_STOKOPNAME : '-';
            $STATUS_APPRO                = !empty($row->STATUS_APPRO) ? $row->STATUS_APPRO : '-';
        ?>
            <td style="text-align:center;"><?php echo $x ?></td>
            <td style="text-align:center;"><?php echo $LEVEL1 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL2 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL3 ?></td>
            <td style="text-align:center;"><?php echo $LEVEL4 ?></td>
            <td style="text-align:center;"><?php echo $NO_STOCKOPNAME ?></td>
            <td style="text-align:center;"><?php echo $TGL_BA_STOCKOPNAME ?></td>
            <td style="text-align:center;"><?php echo $CD_BY_STOKOPNAME ?></td>
            <td style="text-align:center;"><?php echo $STATUS_APPRO ?></td>
        </tr>

    <?php
            endforeach;
        endif;

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