
<?php 
    $filename = $tipe == '1' ? "LAPORAN_REALISASI_PENERIMAAN_UNIT.xls" : "LAPORAN_REALISASI_PEMAKAIAN_UNIT.xls";
    $filenames = $tipe == '1' ? "LAPORAN REALISASI PENERIMAAN BBM UNIT" : "LAPORAN REALISASI PEMAKAIAN BBM UNIT";  

     if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        
        header("Content-Disposition: attachment; filename=$filename");

        echo '
        <style>

        table.tdetail {
            border-collapse: collapse;
            width:100%;
            table-layout:fixed;
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
            font-size: 10px;
            width:100%;
            background-color: #CED8F6;
            font-family:arial;
        }

        table.tdetail, table.tdetail td, table.tdetail th {
            border: 1px solid black;
        }

        // table.tdetail tbody tr:nth-child(even) {background-color: #f2f2f2}        

        table.tdetail tbody tr:nth-child(even) {background-color: #FFF}
        table.tdetail tbody tr:nth-child(odd) {background-color: #FFF}        

        </style>

        ';
    }       
?>


<table border="0" style="width:100%;">
    <tr>
        <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:80%;text-align:center;vertical-align: bottom" colspan="8"><h3><?php echo $filenames.$periode ?> </h3></td>        
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table border="0">
    <?php
        $jml_lv=4;
        if ($ID_REGIONAL) {

            if ($ID_REGIONAL=='All'){
                $ID_REGIONAL_NAMA = 'PUSAT';
            }
            $jml_lv = $jml_lv - 1; //3
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $ID_REGIONAL_NAMA . '</td></tr>';
        }
        if ($COCODE) {
            $jml_lv= $jml_lv - 1; //2
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $COCODE_NAMA . '</td></tr>';
        }
      
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<?php if($tipe == 1)  { ?>
    <table border="1" style="border-collapse: collapse;border: 1px solid black;font-size: 14px">
      <thead>
        <tr style="background-color: #CED8F6">
          <th rowspan="2" width="20%">REGIONAL</th>
          <th rowspan="2" width="20%">LEVEL 1</th>
          <th colspan="3" width="60%">TOTAL VOLUME</th>
        </tr>
        <tr style="background-color: #CED8F6">
          <th>TARGET RKAP<br>(L)</th>
          <th>PENERIMAAN<br>(L)</th>
          <th>PENYERAPAN<br>(%)</th>
        </tr>
      </thead>
      <?php echo $penerimaan ?>
    </table>
    <br><br>
    <?php } else { ?>
    <table border="1" style="border-collapse: collapse;border: 1px solid black;font-size: 14px">
      <thead>
        <tr style="background-color: #CED8F6">
          <th rowspan="2" width="20%">REGIONAL</th>
          <th rowspan="2" width="20%">LEVEL 1</th>
          <th colspan="3" width="60%">TOTAL VOLUME</th>
        </tr>
        <tr style="background-color: #CED8F6">
          <th>TARGET RKAP<br>(L)</th>
          <th>PEMAKAIAN<br>(L)</th>
          <th>PENYERAPAN<br>(%)</th>
        </tr>
      </thead>
      <?php echo $pemakaian ?>
    </table>
    <br><br>
    <pagebreak>
      
<?php } ?>    

    
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
