<?php

if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment; filename=MASTER_STANDAR_MUTU_VERSIONING.xls");

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
        <td style="width:80%;text-align:center" colspan="6"><h3>CERTIFICATE OF QUALITY VERSIONING</h3></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>
<table class="tdetail">
    <thead>
        <tr>
            <th>No</th>
            <th>Jenis BBM</th>
            <th>No Versioning</th>
            <th>Tanggal Versioning</th>
            <th>Ditetapkan oleh</th>
            <th>Pejabat Terkait</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;foreach ($list as $value) : ?>
        <tr>
            <td style="text-align: center"><?php echo $no ?></td>
            <td style="text-align: center"><?php echo $value['NAMA_JNS_BHN_BKR'] ?></td>
            <td style="text-align: center"><?php echo $value['NO_VERSION'] ?></td>
            <td style="text-align: center"><?php echo $value['TGL_VERSION'] ?></td>
            <td style="text-align: center"><?php echo $value['DITETAPKAN'] ?></td>
            <td style="text-align: center"><?php echo $value['PIC'] ?></td>
            <td style="text-align: center"><?php $status = ($value['STATUS'] == 1) ? 'Aktif' : 'Tidak Aktif'; echo $status ?></td>  
        </tr>  
        <?php $no++ ; endforeach; ?>
    </tbody>
</table>

<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>