<form action="<?php echo base_url()?>data_transaksi/coq/export_excelpembangkit" method="POST" id="form-excelpembangkit">
	<input type="hidden" name="x_id" value="<?php echo $id ?>">
</form>
<form action="<?php echo base_url()?>data_transaksi/coq/export_pdfpembangkit" method="POST" id="form-pdfpembangkit">
	<input type="hidden" name="p_id" value="<?php echo $id ?>">
</form> 
<div class="pull-right">
    <button type="button" class="btn" id="btn-excelpembangkit"><i class="icon-download"></i>Download Excel</button>
    <button type="button" class="btn" id="btn-pdfpembangkit"><i class="icon-download"></i>Download PDF</button>
</div>
<table cellpadding="5">
    <tr>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">User Input</td>
        <td>: <?php echo $NAMA_SURVEYOR; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Shore Tank</td>
        <td>: <?php echo $form_data->SHORE_TANK; ?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Pemasok</td>
        <td>: <?php echo $form_data->NAMA_PEMASOK; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Keterangan</td>
        <td>: <?php echo $form_data->KET; ?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Depo</td>
        <td>: <?php echo $form_data->NAMA_DEPO; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Referensi Standar Mutu</td>
        <td>: <?php echo $ref->DITETAPKAN ?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Product</td>
        <td>: <?php echo $form_data->NAMA_BBM; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Nomor Referensi</td>
        <td>: <?php echo $ref->NO_VERSION ?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Report Number</td>
        <td>: <?php echo $form_data->NO_REPORT; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Tanggal Referensi</td>
        <td>: <?php $tgl = date('d-m-Y', strtotime($ref->TGL_VERSION));echo $tgl;?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Tanggal Sampling </td>
        <td>: <?php echo $form_data->TGL_SAMPLING; ?></td>
        <td></td>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Keterangan</td>
        <td>: <?php echo $form_data->USER_KET ?></td>
    </tr>
    <tr>
        <td style="text-align: left;font-weight: bold;font-size: 14px;">Tanggal COQ</td>
        <td>: <?php echo $form_data->TGL_COQ; ?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    
</table>
<br>
<table class="display" id="tbl_result" width="100%">
    <thead>
        <tr>
            <th rowspan="2" style="border : 1px solid #696969">No</th>
            <th rowspan="2" style="border : 1px solid #696969">Parameter</th>
            <th rowspan="2" style="border : 1px solid #696969">Satuan</th>
            <th colspan="2" style="border : 1px solid #696969">Batasan SNI Minyak Solar</th>
            <th rowspan="2" style="border : 1px solid #696969">Metode Uji (ASTM)</th>
            <th rowspan="2" style="border : 1px solid #696969">Result</th>
            <th rowspan="2" style="border : 1px solid #696969">Resume</th>
        </tr>
        <tr>
            <th>Min</th>
            <th>Max</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; $sec = 1; foreach ($list2 as $value) { ?>
             <tr>
                <td style="text-align: center;border : 1px solid #696969"><?php echo $no ; ?></td>
                <td style="text-align: left;border : 1px solid #696969"><?php echo $value['PARAMETER_ANALISA'] ?></td>
                <td style="text-align: center;border : 1px solid #696969"><?php echo $value['SATUAN'] ?></td>
                <?php if ($value['BATAS_MIN'] == null) {
                    $min = "-";
                } else {
                    $min = number_format($value['BATAS_MIN'],3,',','.');
                } 

                if ($value['BATAS_MAX'] == null) {
                    $max = "-";
                } else {
                    $max = number_format($value['BATAS_MAX'],3,',','.');
                } ?>

                <?php $result = ($value['RESULT'] == '' || $value['RESULT'] == null) ? '-' : number_format($value['RESULT'],3,',','.'); ?>
                <td style="text-align: center;border : 1px solid #696969"><?php echo $min; ?></td>
                <td style="text-align: center;border : 1px solid #696969"><?php echo $max; ?></td>
                <td style="text-align: center;border : 1px solid #696969"><?php echo $value['METODE'] ?></td>
                <td style="text-align: center;border : 1px solid #696969"><?php echo $result ?></td>
                <td style="text-align: center;border : 1px solid #696969">
                    <?php 
	                    if($value['RESUME'] == 0)
	                    {
	                        $warna = 'green';
	                        $status = 'PASSED';
	                    } else if($value['RESUME'] == 1){
	                        $warna = 'red';
	                        $status = 'NOT PASSED';
	                    } else if($value['RESUME'] == 2){
	                    	$warna = '';
	                        $status = '-';
	                    } ?>
	                    <?php if($warna == '') {
	                    	$button = '-';
	                    } else { 
	                    	$button = "<button type='button' class='btn' style='background-color: ".$warna.";color:white'>".$status."</button>";
	                    } 
	                    echo $button; 
                    ?>
                </td>
            </tr>
        <?php $no++; $sec++; } ?>
    </tbody>
</table>

<hr>

<table class="display" id="tbl_pembangkit" style="width: 100%;border: 1px solid #696969;border-collapse:collapse;">
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
		<?php $no = 1;foreach($list as $data) : ?>
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

<script type="text/javascript">
	$(document).ready(function(){
		$('#tbl_pembangkit').DataTable({
			bSort:false,
			searching:false
		});

		$('#tbl_result').DataTable({
	        bSort:false,
	        searching:false
	    })

	    $('#btn-excelresult').click(function(){
	    	bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            	if(e) {
                	$('#form-excelresult').submit();
            	}
        	});
	    })

		$('#btn-pdfresult').click(function(){
			bootbox.confirm('Apakah yakin akan export data PDF ?', "Tidak", "Ya", function(e) {
            	if(e) {
                	$('#form-pdfresult').submit();
            	}
        	});
		})

		$('#btn-excelpembangkit').click(function(){
			bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            	if(e) {
                	$('#form-excelpembangkit').submit();
            	}
        	});
		})

		$('#btn-pdfpembangkit').click(function(){
			bootbox.confirm('Apakah yakin akan export data PDF ?', "Tidak", "Ya", function(e) {
            	if(e) {
                	$('#form-pdfpembangkit').submit();
            	}
        	});
		})

	})
</script>