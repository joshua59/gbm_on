<?php if($JENIS == 'XLS') { ?>
    <?php
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Laporan Result COQ.xls');
    ?>
<?php } ?>
<style type="text/css">
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
<table border="0" style="width:100%;">
    <tr>
        <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:80%;text-align:center" colspan="8"><h3>CERTIFICATE OF QUALITY</h3></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<br>
<table class="tdetail">
    <thead>
        <tr>
            <th rowspan="2" style="border : 1px solid #696969">No</th>
            <th colspan="4" style="border : 1px solid #696969">LEVEL</th>
            <th rowspan="2" style="border : 1px solid #696969">Pembangkit</th>  
        </tr>
        <tr>
            <th style="border : 1px solid #696969">Regional</th>
            <th style="border : 1px solid #696969">1</th>   
            <th style="border : 1px solid #696969">2</th>
            <th style="border : 1px solid #696969">3</th>   
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;foreach($list2 as $data) : ?>
            <tr>
                <td style="text-align: left;border : 1px solid #696969;"><?php echo $no++ ?></td>
                <td style="text-align: left;border : 1px solid #696969;"><?php echo $data['NAMA_REGIONAL'] ?></td>
                <td style="text-align: left;border : 1px solid #696969;"><?php echo $data['LEVEL1'] ?></td>
                <td style="text-align: left;border : 1px solid #696969;"><?php echo $data['LEVEL2'] ?></td>
                <td style="text-align: left;border : 1px solid #696969;"><?php echo $data['LEVEL3'] ?></td>
                <td style="text-align: left;border : 1px solid #696969;"><?php echo $data['LEVEL4'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>