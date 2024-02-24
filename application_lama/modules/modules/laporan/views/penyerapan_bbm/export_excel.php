
<?php
    
    $filename = $tipe == '1' ? "LAPORAN_REALISASI_PENERIMAAN.xls" : "LAPORAN_REALISASI_PEMAKAIAN.xls";
    $filenames = $tipe == '1' ? "LAPORAN REALISASI PENERIMAAN BBM" : "LAPORAN REALISASI PEMAKAIAN BBM";
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
            $jml_lv= $jml_lv - 1; //3
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
   <table border="1" style="border-collapse: collapse;border: 1px solid black;font-size: 10px">
        <thead>                                                
            <tr style="background-color: #CED8F6">
              <th style="text-align:center;width: 5%" rowspan="2">NO</th>
              <th style="text-align:center;width: 13%" rowspan="2"><?php echo str_repeat("&nbsp;", 5);?>REGIONAL<?php echo str_repeat("&nbsp;", 5);?></th>
              <th style="text-align:center;width: 12%" rowspan="2"><?php echo str_repeat("&nbsp;", 5);?>LEVEL1<?php echo str_repeat("&nbsp;", 5);?></th>                
              <th style="text-align:center;" colspan="2"> TARGET RKAP </th>
              <th style="text-align:center;" colspan="5"> REALISASI PENERIMAAN </th>
            </tr> 
            <tr style="background-color: #CED8F6">
              <th style="text-align:center;width: 8%">Jenis BBM</th>
              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
              <th style="text-align:center;width: 8%">Jenis BBM Sesuai DO</th>
              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
              <th style="text-align:center;width: 10%">Jenis BBM Sesuai DO</th>
              <th style="text-align:center;width: 12%">Volume Komponen<br>Penerimaan (L)</th>
              <th style="text-align:center;width: 5%">Penyerapan<br>(%)</th>
            </tr>           
        </thead>
        <tbody>
           <?php echo $penerimaan ?>
        </tbody>   
    </table>
    <br><br>
    <pagebreak>

    <div style="text-align:left;">TOTAL SELURUH UNIT</div>
    <table border="1" style="border-collapse: collapse;border: 1px solid black;font-size: 10px;width: 100%">
        <thead>                                                
            <tr style="background-color: #CED8F6">
              <th style="text-align:center;width: 30%" rowspan="2" colspan="3"><?php echo str_repeat("&nbsp;", 5);?>UNIT<?php echo str_repeat("&nbsp;", 5);?></th>               
              <th style="text-align:center;" colspan="2"> TARGET RKAP </th>
              <th style="text-align:center;" colspan="5"> REALISASI PENERIMAAN </th>
            </tr> 
            <tr style="background-color: #CED8F6">
              <th style="text-align:center;width: 8%">Jenis BBM</th>
              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
              <th style="text-align:center;width: 8%">Jenis BBM Sesuai DO</th>
              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
              <th style="text-align:center;width: 10%">Jenis BBM Sesuai DO</th>
              <th style="text-align:center;width: 12%">Volume Komponen<br>Penerimaan (L)</th>
              <th style="text-align:center;width: 5%">Penyerapan<br>(%)</th>
            </tr>           
        </thead>
        <?php echo $t_penerimaan ?>
        
    </table>    

    <?php } else { ?>
    <table border="1" style="border-collapse: collapse;border: 1px solid black;font-size: 14px">
        <thead>                        
            <tr style="background-color: #CED8F6">
                <th style="text-align:center;width: 5%" rowspan="2">NO</th>
                <th style="text-align:center;width: 10%" rowspan="2"><?php echo str_repeat("&nbsp;", 5);?>REGIONAL<?php echo str_repeat("&nbsp;", 5);?></th>
                <th style="text-align:center;width: 15%" rowspan="2"><?php echo str_repeat("&nbsp;", 19);?>LEVEL1<?php echo str_repeat("&nbsp;", 18);?></th>                
                <th style="text-align:center;" colspan="4"> TARGET RKAP </th>
                <th style="text-align:center;" colspan="3"> REALISASI PEMAKAIAN </th>
            </tr> 
            <tr style="background-color: #CED8F6">
                <th style="text-align:center;width: 11%">Jenis BBM</th>
                <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                <th style="text-align:center;width: 9%">Jenis BBM</th>
                <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                <th style="text-align:center;width: 10%">Jenis BBM</th>
                <th style="text-align:center;width: 11%">Volume (L)</th>
                <th style="text-align:center;width: 5%">Penyerapan<br>(%)</th>
            </tr>            
        </thead>
        <tbody>
            <?php echo $pemakaian ?>
        </tbody>
    </table>
    <br><br>
    <pagebreak>

    <div style="text-align:left;font-size: 10px;">TOTAL SELURUH UNIT</div>
    <table border="1" style="border-collapse: collapse;border: 1px solid black;font-size: 14px;width: 100%">
        <thead>                        
            <tr style="background-color: #CED8F6">
                <th style="text-align:center;width: 30%" rowspan="2" colspan="3"><?php echo str_repeat("&nbsp;", 5);?>UNIT<?php echo str_repeat("&nbsp;", 5);?></th>
                <th style="text-align:center;" colspan="4"> TARGET RKAP </th>
                <th style="text-align:center;" colspan="3"> REALISASI PEMAKAIAN </th>
            </tr> 
            <tr style="background-color: #CED8F6">
                <th style="text-align:center;width: 11%">Jenis BBM</th>
                <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                <th style="text-align:center;width: 9%">Jenis BBM</th>
                <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                <th style="text-align:center;width: 10%">Jenis BBM</th>
                <th style="text-align:center;width: 11%">Volume (L)</th>
                <th style="text-align:center;width: 5%">Penyerapan<br>(%)</th>
            </tr>           
        </thead>
        <?php echo $pemakaian_total ?>
    </table>     
<?php } ?>    

    
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
