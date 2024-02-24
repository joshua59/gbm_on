Kepada Yth.,<br>
Bapak/Ibu General Manager,<br>
<?php echo $LEVEL1; ?><br><br>
Berikut rekap jumlah transaksi dengan status <b>"Belum Kirim"</b> dan <b>"Belum Approve"</b> pada Aplikasi GBM Online 
<br><br>

<table style='border-collapse: collapse;width:70%;border: 1px solid black;'>
	<tr>
		<th style='text-align:center;border: 1px solid black;'>No</th>
		<th style='text-align:center;border: 1px solid black;'>Area / Sektor</th>
		<th style='text-align:center;border: 1px solid black;'>Belum Kirim</th>
		<th style='text-align:center;border: 1px solid black;'>Belum Approve</th>		
	</tr>
    <?php $no = 1;
    foreach ($list_email_detail as $row) {	
		$blth = date("M-Y", strtotime($row->TGL));
        echo "<tr>";
        echo "<td style='text-align:center;border: 1px solid black;'>".$no++."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->LEVEL2."</td>";
        echo "<td style='text-align:right;border: 1px solid black;'>".$row->BELUM_KIRIM."&nbsp;</td>";        
        echo "<td style='text-align:right;border: 1px solid black;'>".$row->BELUM_APPROVE."&nbsp;</td>";
        echo "</tr>";
    }
    ?>
</table><br><br><br>

Berikut monitoring laporan input data transaksi pada aplikasi GBM Online<br><br>

<table style='border-collapse: collapse;width:90%;border: 1px solid black;'>
    <tr>
        <th style='text-align:center;border: 1px solid black;'>No</th>
        <th style='text-align:center;border: 1px solid black;'>Level 2</th>
        <th style='text-align:center;border: 1px solid black;'>Level 3</th>
        <th style='text-align:center;border: 1px solid black;'>Nama PLTD</th>
        <th style='text-align:center;border: 1px solid black;'>Tanggal Terakhir Input Data</th>
    </tr>
    <?php $no = 1;
    foreach ($list_email_update as $row) {  
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

Untuk Input transaksi dan stock persediaan BBM, dapat diproses pada aplikasi GBM Online.<br><br>

Terima Kasih.<br><br><br>
HELPDESK GBM Online<br>
Layanan<br>
EMAIL : <a href="mailto:helpdesk.gbmo@iconpln.co.id?Subject=INFO%20GBMO" target="_top">helpdesk.gbmo@iconpln.co.id</a>	
<br><br>