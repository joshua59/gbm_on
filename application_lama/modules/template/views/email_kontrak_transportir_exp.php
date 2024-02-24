Kepada Yth.,<br>
Bapak/Ibu <?php echo $NAMA_USER; ?>,<br>
<?php echo $LEVEL1; ?><br><br>

Masa berlaku data kontrak transportir untuk PT PLN (Persero) <?php echo $LEVEL2; ?> <b>Sudah Berakhir</b><br> 
Adapun data detil kontrak transportir yang sudah berakhir adalah sebagai berikut :
<br><br>

<table style='border-collapse: collapse;width:100%;border: 1px solid black;'>
	<tr>
		<th style='text-align:center;border: 1px solid black;'>No</th>
		<th style='text-align:center;border: 1px solid black;'>No Kontrak</th>
		<th style='text-align:center;border: 1px solid black;'>Transportir</th>
		<th style='text-align:center;border: 1px solid black;'>Tgl Awal Kontrak</th>
		<th style='text-align:center;border: 1px solid black;'>Tgl Akhir Kontrak</th>
		<th style='text-align:center;border: 1px solid black;'>Pembangkit</th>
	</tr>
    <?php $no = 1;
    foreach ($list_email_detail as $row) {	
		$blth = date("M-Y", strtotime($row->TGL));
        echo "<tr>";
        echo "<td style='text-align:center;border: 1px solid black;'>".$no++."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->NOMOR_KONTRAK."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->NAMA_TRANSPORTIR."</td>";
        echo "<td style='text-align:center;border: 1px solid black;'>".$row->TGL_AWAL."</td>";
        echo "<td style='text-align:center;border: 1px solid black;'>".$row->TGL_AKHIR."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->PEMBANGKIT."</td>";
        echo "</tr>";
    }
    ?>
</table><br><br>

Silahkan dilakukan tindak lanjut dengan menginput data kontrak transportir terbaru / amandemen kontrak transportir yang berlaku pada unit terkait.<br>

Alamat Aplikasi : <a href="https://gbmo.pln.co.id/"><b>https://gbmo.pln.co.id</b></a><br><br>
Terima Kasih.<br><br><br>
HELPDESK GBM Online<br>
Layanan<br>
EMAIL : <a href="mailto:helpdesk.gbmo@iconpln.co.id?Subject=INFO%20GBMO" target="_top">helpdesk.gbmo@iconpln.co.id</a>	
<br><br>