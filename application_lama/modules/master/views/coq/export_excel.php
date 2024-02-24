<?php

if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=MASTER_STANDAR_MUTU.xls");

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
        <td style="width:80%;text-align:center" colspan="9"><h3>Standar dan Mutu Kualitas BBM</h3></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table>
    <?php if($p_ref_lv1 != '') { ?>
        <tr>
            <td style="text-align: left;font-weight: bold">Ditetapkan Oleh</td>
            <td style="text-align: left">: <?php echo $p_ref_lv1; ?></td>
        </tr>
    <?php } ?>

    <?php if($p_ref_lv2 != '') { ?>
        <tr>
            <td style="text-align: left;font-weight: bold">Nomor</td>
            <td style="text-align: left">: <?php echo $p_ref_lv2; ?></td>
        </tr>
    <?php } ?>
    
    <?php if($p_tgl != '') { ?>
        <tr>
            <td style="text-align: left;font-weight: bold">Tanggal Penetapan</td>
            <td style="text-align: left">: <?php $newDate = date("d-m-Y", strtotime($p_tgl)); echo $newDate; ?></td>   
        </td>
    </tr>
    <?php } ?>
    
    <?php if($p_namabbm == '-- Pilih Jenis Bahan Bakar --') { ?>
        
    <?php } else { ?>
        <tr>
            <td style="text-align: left;font-weight: bold">Jenis Bahan Bakar</td>
            <td>: <?php echo $p_namabbm ?></td>
        </tr>
    <?php } ?>
    
     
</table>
<table class="tdetail">
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">Parameter</th>
            <th rowspan="2">Satuan</th>
            <th rowspan="2">Metode Uji</th>
            <th colspan="2">Batasan SNI</th>
            <th rowspan="2" style="width: 15%">Jenis Bahan Bakar</th>
            <th rowspan="2">Referensi</th>
            <th rowspan="2">Nomor Referensi</th>
            <th rowspan="2">Tanggal Referensi</th>
        </tr>
        <tr>
            <th>Min</th>
            <th>Max</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1 ;foreach ($list as $value) : ?>
            <tr>
                <td style="text-align: center"><?php echo $no ;?></td>
                <td style="text-align: left"><?php echo $value['PARAMETER_ANALISA'] ;?></td>
                <td style="text-align: center"><?php echo $value['SATUAN'] ;?></td>
                <td style="text-align: center"><?php echo $value['METODE'] ;?></td>
                <td style="text-align: right;"><?php echo number_format($value['BATAS_MIN'],3,',','.'); ;?></td>
                <td style="text-align: right;"><?php echo number_format($value['BATAS_MAX'],3,',','.'); ;?></td>
                <td style="text-align: center;"><?php echo $value['NAMA_JNS_BHN_BKR'] ;?></td>
                <td style="text-align: center;"><?php echo $value['DITETAPKAN'] ;?></td>
                <td style="text-align: center;"><?php echo $value['NO_VERSION'] ;?></td>
                <td style="text-align: center;"><?php echo $value['TGL_VERSION'] ;?></td>
            </tr>
        <?php $no++ ;  endforeach; ?>
    </tbody>
</table>

<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>