Kepada Yth.,<br>
Bapak/Ibu <?php echo $NAMA_USER; ?>,<br>
<?php echo $LEVEL_USER; ?><br><br>
Berikut monitoring laporan update data transaksi pada aplikasi GBM Online<br><br>

<table style='border-collapse: collapse;width:90%;border: 1px solid black;'>
	<tr>
		<th style='text-align:center;border: 1px solid black;'>No</th>
		<th style='text-align:center;border: 1px solid black;'>Level 2</th>
		<th style='text-align:center;border: 1px solid black;'>Level 3</th>
		<th style='text-align:center;border: 1px solid black;'>Nama Pembangkit</th>
		<th style='text-align:center;border: 1px solid black;'>Tanggal Terakhir Input Data</th>
	</tr>
    <?php $no = 1;
    foreach ($list_email_detail as $row) {	
        $tgl = date("Y-m-d", strtotime($row->TGL_AKHIR));		
        echo "<tr>";
        echo "<td style='text-align:center;border: 1px solid black;'>".$no++."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->LEVEL2."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->LEVEL3."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->LEVEL4."</td>";
        echo "<td style='text-align:center;border: 1px solid black;'>".$tgl."</td>";
        echo "</tr>";
    }
    ?>
</table><br><br>

Silahkan dilakukan input terhadap transaksi tersebut melalui aplikasi GBM Online, kemudian dilanjutkan proses kirim data transaksi kepada role approver.<br>

Alamat Aplikasi : <a href="https://gbmo.pln.co.id/"><b>https://gbmo.pln.co.id</b></a><br><br>
Terima Kasih.<br><br><br>
HELPDESK GBM Online<br>
Layanan<br>
EMAIL : <a href="mailto:helpdesk.gbmo@iconpln.co.id?Subject=INFO%20GBMO" target="_top">helpdesk.gbmo@iconpln.co.id</a>	
<br><br>