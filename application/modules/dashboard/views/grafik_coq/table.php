<br>
<div class="well">
    <div class="well-content clearfix">
    	<div class="pull-right">
	    <div class="controls">
	        <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
	        <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>
	    </div>
	</div> 
	<br>
	<table class="table table-striped" id="dataTable">
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
    </div>
</div>    


<form action="<?=base_url()?>dashboard/grafik_coq/export_excel" id="export_excel" method="POST">
    <input type="hidden" name="x_id" value="<?php echo $id; ?>">
    <input type="hidden" name="x_bln" value="<?php echo $bln; ?>">
    <input type="hidden" name="x_thn" value="<?php echo $thn; ?>">
    <input type="hidden" name="x_namabln" value="<?php echo $nama_bulan; ?>">
    <input type="hidden" name="x_parameter" value="<?php echo $parameter ?>">
    <input type="hidden" name="x_bbm" value="<?php echo $bbm ?>">
    <input type="hidden" name="x_pemasok" value="<?php echo $id_pemasok ?>">
    <input type="hidden" name="x_depo" value="<?php echo $id_depo ?>">

</form>

<form action="<?=base_url()?>dashboard/grafik_coq/export_pdf" id="export_pdf" method="POST">
    <input type="hidden" name="p_id" value="<?php echo $id; ?>">
    <input type="hidden" name="p_bln" value="<?php echo $bln; ?>">
    <input type="hidden" name="p_thn" value="<?php echo $thn; ?>">
    <input type="hidden" name="p_namabln" value="<?php echo $nama_bulan; ?>">
    <input type="hidden" name="p_parameter" value="<?php echo $parameter ?>">
    <input type="hidden" name="p_bbm" value="<?php echo $bbm ?>">
    <input type="hidden" name="p_pemasok" value="<?php echo $id_pemasok ?>">
    <input type="hidden" name="p_depo" value="<?php echo $id_depo ?>">
</form>

<script type="text/javascript">
	$('#button-excel').click(function(e) {
       bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
         if(e){
            
             $('#export_excel').submit();
         }
       });
    });

    $('#button-pdf').click(function(e) {
       bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_pdf').submit();
         }
       });
    });

    $('#dataTable').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": false,
        "bInfo": false,
        "fixedHeader": true,
        "ordering" :false,
        "bAutoWidth": true,
        "scrollY" : "450px",
        "scrollX" : false
    });
</script>