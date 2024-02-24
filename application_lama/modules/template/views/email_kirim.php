Kepada Yth.,<br>
Bapak/Ibu <?php echo $NAMA_USER; ?>,<br>
<?php echo $LEVEL1; ?><br><br>
Berikut rekap jumlah transaksi dengan status <b>"Belum Kirim"</b> pada 
Aplikasi GBM Online<br><br>

<table style='border-collapse: collapse;width:90%;border: 1px solid black;'>
	<tr>
		<th style='text-align:center;border: 1px solid black;'>No</th>
		<th style='text-align:center;border: 1px solid black;'>Pembangkit</th>
		<th style='text-align:center;border: 1px solid black;'>Jenis Transaksi</th>
		<th style='text-align:center;border: 1px solid black;'>Bulan/Tahun</th>
		<th style='text-align:center;border: 1px solid black;'>Jumlah</th>
	</tr>
    <?php $no = 1;
    foreach ($list_email_detail as $row) {	
		$blth = date("M-Y", strtotime($row->TGL));
        echo "<tr>";
        echo "<td style='text-align:center;border: 1px solid black;'>".$no++."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->LEVEL4."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->TRX."</td>";
        echo "<td style='text-align:center;border: 1px solid black;'>".$blth."</td>";
        echo "<td style='text-align:right;border: 1px solid black;'>".$row->JML."</td>";
        echo "</tr>";
    }
    ?>
</table><br><br>

Silahkan dilakukan tindak lanjut pengiriman atas transaksi tersebut melalui aplikasi GBM Online 
dengan pengiriman data transaksi kepada role approver.<br>

Alamat Aplikasi : <a href="https://gbmo.pln.co.id/"><b>https://gbmo.pln.co.id</b></a><br><br>
Terima Kasih.<br><br><br>
HELPDESK GBM Online<br>
Layanan<br>
EMAIL : <a href="mailto:helpdesk.gbmo@iconpln.co.id?Subject=INFO%20GBMO" target="_top">helpdesk.gbmo@iconpln.co.id</a>	
<br><br>