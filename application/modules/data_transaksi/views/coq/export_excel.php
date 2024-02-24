<?php if($JENIS == 'XLS') { ?>
	<?php
	    header('Cache-Control: no-cache, no-store, must-revalidate');
	    header('Content-Type: application/vnd.ms-excel');
	    header('Content-Disposition: attachment; filename=Laporan COQ.xls');
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
        <td style="width:80%;text-align:center" colspan="6"><h3>CERTIFICATE OF QUALITY</h3></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>
<table class="tdetail" style="width: 100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Report Number</th>
			<th>Tanggal COQ</th>
			<th>Jenis / Komponen <br>BBM</th>
			<th>Pemasok</th>
			<th>Depo</th>
			<th>Shore Tank</th>
			<th>Jumlah Pembangkit</th>
			<th>Created By</th>
			<th>Created Date</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1; foreach ($list as $value) : ?>
			<tr>
				<td style="text-align: center;padding:10px"><?php echo $no ?></td>
				<td style="text-align: center;padding:10px"><?php echo $value['NO_REPORT'] ?></td>
				<td style="text-align: center;padding:10px"><?php echo $value['TGL_COQ'] ?></td>
				<td style="text-align: center;padding:10px"><?php echo $value['NAMA_BBM'] ?></td>
				<td style="text-align: center;padding:10px"><?php echo $value['NAMA_PEMASOK'] ?></td>
				<td style="text-align: center;padding:10px"><?php echo $value['NAMA_DEPO'] ?></td>
				<td style="text-align: center;padding:10px">'<?php echo $value['SHORE_TANK'] ?>'</td>
				<td style="text-align: center;padding:10px"><?php echo $value['TOTAL']." Pembangkit"?></a></td>
				<td style="text-align: center;padding:10px"><?php echo $value['CD_BY'] ?></td>
				<td style="text-align: center;padding:10px"><?php echo $value['CD_DATE'] ?></td>
				<td style="text-align: center;padding:10px"><?php echo $value['STATS'] ?></td>
			</tr>
		<?php $no++; endforeach; ?>
	</tbody>
</table>

<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>