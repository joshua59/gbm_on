
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Laporan_Rekap_Kontrak_Transportir_Adendum.xls');

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
    
    echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $p_kode . '</td></tr>';
        
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>
<table class="tdetail" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>NO</th>
            <th>PEMASOK</th>
            <th>DEPO TRANSIT</th>
            <th>PEMBANGKIT<br>PENERIMA</th>
            <th>JALUR</th>
            <th>JARAK (KM/ML)</th>
            <th>HARGA (RP/L)</th>       
        </tr>
    </thead>
  <tbody id="body_adendum">
       <?php $x = 1;foreach ($data as $row) : ?>
            <tr>
                <td style="text-align:center;"><?php echo $x++; ?></td>
                <td><?php echo $row->PEMASOK ?></td>
                <td><?php echo $row->DEPO_TRANSIT ?></td>
                <td><?php echo $row->PEMBANGKIT_PENERIMA ?></td>
                <td><?php echo $row->JALUR ?></td>
                <td style="text-align:right;"><?php echo number_format($row->JARAK,2,',','.'); ?></td>
                <td style="text-align:right;"><?php echo number_format($row->HARGA,2,',','.'); ?></td>
            </tr>
        <?php endforeach; ?>
  </tbody>
</table>

<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
