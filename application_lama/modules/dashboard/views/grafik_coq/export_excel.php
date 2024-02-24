<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=DATA_GRAFIK_KUALITAS_BBM.xls');

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
<?php 
    if($TIPE == 1) {
        if($min_max->BATAS_MIN ==  NULL) {
            $text = 'Batas Max : '. number_format($min_max->BATAS_MAX,2,',', '.')." ".$satuan;
        } else if($min_max->BATAS_MAX == NULL) { 
            $text = 'Batas Min : '. number_format($min_max->BATAS_MIN,2,',', '.')." ".$satuan;
        } else {
            $text = 'Batas Min : '. number_format($min_max->BATAS_MIN,2,',', '.')." ".$satuan." - ".'Batas Max : '. number_format($min_max->BATAS_MAX,2,',','.')." ".$satuan;
        }
    } else {
        $text = '';
    }
   
?>
<table border="0" style="width:100%;">
    <tr>
        <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:80%;text-align:center" colspan="5">
            <div class="box-kop">
                Data Grafik Kualitas BBM<br>PT PLN (PERSERO)
                <br><?php echo $nama_bulan." ".$thn."<br>".$nama_bbm."<br>".$parameter."<br>".$text ?>
            </div>
        </td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table class="tdetail">
    <thead>
            <tr>
                <th style="width: 5%;text-align: center">NO</th>
                <th style="width: 10%;text-align: center">NO REPORT</th>
                <th style="width: 15%;text-align: center">NAMA DEPO</th>
                <th style="width: 15%;text-align: center">TGL SAMPLING</th>
                <th style="width: 15%;text-align: center">RESULT</th>
                <th style="width: 15%;text-align: center">STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;foreach ($list as $data) : ?>
            <?php if($data['RESUME'] == 0) {
                $status = 'PASSED';
            } else if($data['RESUME'] == 1) {
                $status = 'NOT PASSED';
            } else {
                $status = '-';
            } ?>
            <?php $date = date_create($data['TGL_SAMPLING']); ?>
                <tr>
                    <td style="text-align: center"><?php echo $no; ?></td>
                    <td style="text-align: left"><?php echo $data['NO_REPORT'] ?></td>
                    <td style="text-align: left"><?php echo $data['NAMA_DEPO'] ?></td>
                    <td style="text-align: center"><?php echo date_format($date,"Y-m-d") ?></td>
                    <td style="text-align: center;">
                        <?php 
                            if(is_numeric($data['RESULT'])) {
                                echo number_format($data['RESULT'],2,',','.');
                            } else {
                                echo $data['RESULT'];
                            }
                        ?>     
                    </td>
                    <td style="text-align: center"><?php echo $status ?></td>
                </tr>   
            <?php $no++;endforeach; ?>
        </tbody>
</table>

<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><hr>