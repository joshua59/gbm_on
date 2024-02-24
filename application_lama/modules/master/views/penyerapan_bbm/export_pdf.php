<?php 
	header('Cache-Control: no-cache, no-store, must-revalidate');
?>
<style>
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
<table border="0" style="width:100%;">
    <tr>
        <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:80%;text-align:center" colspan="8"><h3>LAPORAN TARGET PENYERAPAN BBM<br>Tahun <?php echo $SKEMA_PENYERAPAN ?></h3></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
   
</table>
<br>
<br>
<table id="dataTable" width="100%" class="tdetail">
	<thead>
		<tr>
			<th rowspan="2" style="width: 30%">Unit</th>
			<th rowspan="2" style="width: 8%">Tahun (RKAP)</th>
			<th colspan="4">Target Volume Penyerapan</th>
			<th rowspan="2" style="width: 8%">Asumsi BIO</th>
		</tr>
		<tr>
			<th>HSD<br>(L)</th>
			<th>BIO (FAME)<br>(L)</th>
			<th>IDO<br>(L)</th>
			<th>MFO<br>(L)</th>
		</tr>
	</thead>
	<tbody style="text-align: center">
		<?php 
		$a = $b = $c = $d = 0;
		foreach ($list as $value) { ?>
			<tr>
				<td style="text-align: left;padding: 4px;"><?php echo $value['LEVEL1']; ?></td>
				<td style="text-align: center;padding: 4px;"><?php echo $value['SKEMA_PENYERAPAN']; ?></td>
				<td style="text-align: right;padding: 4px;"><?php echo number_format($value['VOLUMEHSD'],2,',','.')  ?></td>
				<td style="text-align: right;padding: 4px;"><?php echo number_format($value['VOLUMEBIO'],2,',','.')  ?></td>
				<td style="text-align: right;padding: 4px;"><?php echo number_format($value['VOLUMEIDO'],2,',','.')  ?></td>
				<td style="text-align: right;padding: 4px;"><?php echo number_format($value['VOLUMEMFO'],2,',','.')  ?></td>
				<td style="text-align: center;padding: 4px;"><?php echo $value['PERHITUNGAN_BIO']; ?></td>
				
			</tr>
		<?php 

		$a += $value['VOLUMEHSD'];
		$b += $value['VOLUMEBIO'];
		$c += $value['VOLUMEIDO'];
		$d += $value['VOLUMEMFO'];
		}?> 
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2" style="text-align: right;padding: 4px">Total Volume</th>
			<th style="text-align: right;padding: 4px"><?php echo number_format($a,2,',','.'); ?></th>
			<th style="text-align: right;padding: 4px"><?php echo number_format($b,2,',','.'); ?></th>
			<th style="text-align: right;padding: 4px"><?php echo number_format($c,2,',','.'); ?></th>
			<th style="text-align: right;padding: 4px"><?php echo number_format($d,2,',','.'); ?></th>
			<th></th>
		</tr>
	</tfoot>
</table>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
