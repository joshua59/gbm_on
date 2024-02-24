
<?php $count = count($list); ?>
<input type="hidden" id="total" value="<?php echo $count ?>">
<table id="dataTable" width="100%">
	<thead>
		<tr>
			<th rowspan="2">Unit</th>
			<th rowspan="2">Tahun <br>(RKAP)</th>
			<th colspan="4">Target Volume Penyerapan</th>
			<th rowspan="2">Asumsi BIO</th>
			<th rowspan="2">Created By</th>
			<th rowspan="2">Created Time</th>
			<th rowspan="2">Aksi</th>
		</tr>
		<tr>
			<th>HSD <br>(L)</th>
			<th>BIO (FAME) <br>(L)</th>
			<th>IDO <br>(L)</th>
			<th>MFO <br>(L)</th>
		</tr>
	</thead>
	<tbody style="text-align: center">
		
		<?php 
		$MFO = $IDO = $BIO = $HSD = 0;
		foreach ($list as $value) : ?>
			<tr>
				<td style="text-align: left"><?php echo $value['LEVEL1']; ?></td>
				<td><?php echo $value['SKEMA_PENYERAPAN']; ?></td>
				<td style="text-align: right"><?php echo number_format($value['VOLUMEHSD'],2,',','.'); ?></td>
				<td style="text-align: right"><?php echo number_format($value['VOLUMEBIO'],2,',','.'); ?></td>
				<td style="text-align: right"><?php echo number_format($value['VOLUMEIDO'],2,',','.'); ?></td>
				<td style="text-align: right"><?php echo number_format($value['VOLUMEMFO'],2,',','.'); ?></td>
				<td><?php echo $value['PERHITUNGAN_BIO']; ?></td>
				<td><?php echo $value['CREATED_BY']; ?></td>
				<td><?php echo $value['CREATED_TIME']; ?></td>
				<td>
					<?php if($button_edit == 0) { ?>
						<button type="button" class="btn" onclick="edit(<?php echo $value['ID_PENYERAPAN']; ?>)"><i class="icon-edit"></i></button>
					<?php } else { ?>
						<button type="button" class="btn" onclick="edit_add(<?php echo $value['ID_PENYERAPAN']; ?>)"><i class="icon-edit"></i></button>
					<?php } ?>
				
				</td>	
			</tr>
		<?php
		$MFO += $value['VOLUMEMFO']; $IDO += $value['VOLUMEIDO']; $BIO += $value['VOLUMEBIO']; $HSD += $value['VOLUMEHSD'];
		endforeach;?> 
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2" style="text-align: right;font-weight: bold">Total Volume</th>
			<th style="text-align: right"><?php echo number_format($HSD,2,',','.'); ?></th>
			<th style="text-align: right"><?php echo number_format($BIO,2,',','.'); ?></th>
			<th style="text-align: right"><?php echo number_format($IDO,2,',','.'); ?></th>
			<th style="text-align: right"><?php echo number_format($MFO,2,',','.'); ?></th>

			<th colspan="4"><?php echo $button ?></th>
		</tr>
	</tfoot>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$('#dataTable').dataTable({
			"bLengthChange": false,
		    "bFilter": false,
		    "bInfo": false,
		    "bAutoWidth": false,
		    "ordering" :false
		});
	
	})


	function numberWithCommas(x) {
	    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

</script>