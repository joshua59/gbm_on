<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=LAPORAN_STOK_OPNAME_BBM.xls');

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
    } else if($JENIS == 'PDF'){
        echo '
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

        table.tab ,table.tab td {
        	border: 1px solid black;border-collapse: collapse;font-size: 10px;font-family:arial;
        }
        </style>

        ';
    }
?>

<?php 
	$a = $VOLUME_AWAL;
	$b = $VOLUME_TERIMA;
	$c = $TOTAL_PEMAKAIAN;
	$d = $STOK_AKHIR;
	$e = $STOK_AKHIR_BA;
	$f = $NILAI_STOK_BA;
?>
<table border="0" style="width:100%;">
    <tr>
        <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:80%;text-align:center" colspan="3">
        	<div class="box-kop">
        		LAPORAN STOCK OPNAME BBM
	        </div>
	        <br>
        	<?php echo $pembangkit; ?><br><?php echo $NAMA_BBM; ?><br><?php echo $TGL_AWAL." s/d ".$TGL_AKHIR;?>
        </td>
        <td style="width:10%;text-align:center">
        	
        </td>
    </tr>

</table>

<br>
<br>
<table class="tab">
    <tr>
        <td width="50%">Volume Stock Awal (<?php echo $BA_AWAL?>)</td>
        <td width="10%" style="text-align: center;">:</td>
        <td style="text-align: right;"><?php echo number_format($a,2,',','.');?> L</td>
    </tr>
    <tr>
        <td width="50%">Total Volume Penerimaan (Pemasok + Unit Lain)</td>
        <td width="10%" style="text-align: center;">:</td>
        <td style="text-align: right;"><?php echo number_format($b,2,',','.');?> L</td>
    </tr>
    <tr>
        <td width="50%">Total Volume Pemakaian (Sendiri)</td>
        <td width="10%" style="text-align: center;">:</td>
        <td style="text-align: right;"><?php echo number_format($c,2,',','.');?> L</td>
    </tr>
    <tr>
        <td width="50%">Stock Akhir</td>
        <td width="10%" style="text-align: center;">:</td>
        <td style="text-align: right;"><?php echo number_format($d,2,',','.'); ?> L</td>
    </tr>
    <tr>
        <td width="50%">Volume Stock Akhir Berdasarkan BA (<?php echo $BA_AKHIR?>)</td>
        <td width="10%" style="text-align: center;">:</td>
        <td style="text-align: right;"><?php echo number_format($e,2,',','.');?> L</td>
    </tr>
    <tr>
        <td width="50%">Pemakaian Total Berdasarkan Stock Opname</td>
        <td width="10%" style="text-align: center;">:</td>
        <td style="text-align: right;"><?php echo number_format($f,2,',','.');?> L</td>
    </tr>
</table>
<br>
<br>

<table class="tdetail">
	<thead>
		<tr>
			<th>Tanggal Pemakaian</th>
			<th>Volume Pemakaian<br>(L)</th>
			<th>Volume Pemakaian Harian <br>Berdasarkan Stok Opname (BA)<br>(L)</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data as $value) : ?>
			<tr>
				<td style="text-align: center;"><?php echo $value['TGL_MUTASI_PENGAKUAN']; ?></td>
				<td style="text-align: right;"><?php echo number_format($value['VOLUME_PEMAKAIAN'],2,',','.'); ?></td>
				<td style="text-align: right;"><?php echo number_format($value['VOLUME_PENYESUAIAN'],2,',','.'); ?></td>
			</tr>
		<?php endforeach;?>
		
	</tbody>
</table>

<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>