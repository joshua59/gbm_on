<?php
if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        
        header("Content-Disposition: attachment; filename=Data_Detail_COQ.xls");

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
        <td style="width:80%;text-align:center" colspan="5"><h2>CERTIFICATE OF QUALITY</h2></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table>
    <tr>
        <td style="text-align: left;font-weight: bold">User Input</td>
        <td>: <?php echo $surveyor; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold">Shore Tank</td>
        <td>: <?php echo $form_data->SHORE_TANK; ?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold">Pemasok</td>
        <td>: <?php echo $form_data->NAMA_PEMASOK; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold">Keterangan</td>
        <td>: <?php echo $form_data->KET; ?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold">Depo</td>
        <td>: <?php echo $form_data->NAMA_DEPO; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold">Referensi Standar Mutu</td>
        <td>: <?php echo $ref->DITETAPKAN ?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold">Product</td>
        <td>: <?php echo $form_data->NAMA_BBM; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold">Nomor Referensi</td>
        <td>: <?php echo $ref->NO_VERSION ?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold">Report Number</td>
        <td>: <?php echo $form_data->NO_REPORT; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold">Tanggal Referensi</td>
        <td>: <?php $tgl = date('d-m-Y', strtotime($ref->TGL_VERSION));echo $tgl;?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold">Tanggal Sampling </td>
        <td>: <?php echo $form_data->TGL_SAMPLING; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold">Keterangan</td>
        <td>: <?php echo $form_data->USER_KET ?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold">Tanggal COQ</td>
        <td>: <?php echo $form_data->TGL_COQ; ?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    
</table>
<br>
<table class="tdetail" id="tbl_result" width="100%">
    <thead>
        <tr style="background-color: #CED8F6">
            <th rowspan="2" style="width:5%">No</th>
            <th rowspan="2" style="width:12%">Parameter</th>
            <th rowspan="2" style="width:8%">Satuan</th>
            <th colspan="2" style="width:15%">Batasan SNI Minyak Solar</th>
            <th rowspan="2" style="width:10%">Metode Uji (ASTM)</th>
            <th rowspan="2" style="width:7%">Result</th>
            <th rowspan="2" style="width:10%">Resume</th>
        </tr>
        <tr style="background-color: #CED8F6">
            <th>Min</th>
            <th>Max</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; $sec = 1; foreach ($list as $value) { ?>
             <tr>
                <td style="text-align: center"><?php echo $no ; ?></td>
                <td style="text-align: left"><?php echo $value['PARAMETER_ANALISA'] ?></td>
                <td style="text-align: center">
                    <?php $output = preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', $value['SATUAN']); ?>
                    <?php echo $output ?>
                </td>
                <?php if ($value['BATAS_MIN'] == null) {
                    $min = "-";
                } else {
                    $min = number_format($value['BATAS_MIN'],2,',','.');
                } 

                if ($value['BATAS_MAX'] == null) {
                    $max = "-";
                } else {
                    $max = number_format($value['BATAS_MAX'],2,',','.');
                } ?>

                <?php $result = ($value['RESULT'] == '') ? '-' : $value['RESULT']; ?>
                <td style="text-align: center"><?php echo $min; ?></td>
                <td style="text-align: center"><?php echo $max; ?></td>
                <td style="text-align: center"><?php echo $value['METODE'] ?></td>
                <td style="text-align: center"><?php echo $result ?></td>
                <td style="text-align: center">
                    <?php 
                        if($value['RESUME'] == 0)
                        {
                            $warna = 'green';
                            $status = 'PASSED';
                        } else if($value['RESUME'] == 1){
                            $warna = 'red';
                            $status = 'NOT PASSED';
                        } else {
                            $warna = '';
                            $status = '-';
                        } ?>
                        <?php if($warna == '') {
                            $button = '-';
                        } else { 
                            $button = "-";
                        } 
                        echo $status; 
                    ?>
                </td>
            </tr>
        <?php $no++; $sec++; } ?>
    </tbody>
</table>
<br>
<br>
<table class="tdetail">
	<thead>
		<tr style="background-color: #CED8F6">
			<th rowspan="2" style="border : 1px solid #696969">No</th>
			<th colspan="4" style="border : 1px solid #696969">LEVEL</th>
			<th rowspan="2" style="border : 1px solid #696969">Pembangkit</th>	
		</tr>
		<tr style="background-color: #CED8F6">
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