Kepada Yth.,<br>
Bapak/Ibu <?php echo $NAMA_USER; ?>,<br>
<?php echo $LEVEL_USER; ?><br><br>
Berikut rekap jumlah transaksi BBM dengan status <b>"Belum Kirim"</b> dan <b>"Belum Approve"</b> 
<br>Per hari <?php echo $CD_DATE_FORMAT; ?> pada Aplikasi GBM Online
<br><br>

<table style='border-collapse: collapse;width:90%;border: 1px solid black;'>
    <tr>
        <th style='text-align:center;border: 1px solid black;'>No</th>
        <th style='text-align:center;border: 1px solid black;'>Level 2</th>
        <th style='text-align:center;border: 1px solid black;'>Level 3</th>
        <th style='text-align:center;border: 1px solid black;'>Nama Pembangkit</th>
        <th style='text-align:center;border: 1px solid black;'>Belum Kirim</th>
        <th style='text-align:center;border: 1px solid black;'>Belum Approve</th>       
    </tr>
    <?php $no = 1;
    foreach ($list_email_detail_rekap as $row) {  
        $blth = date("M-Y", strtotime($row->TGL));
        echo "<tr>";
        echo "<td style='text-align:center;border: 1px solid black;'>".$no++."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->LEVEL2."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->LEVEL3."</td>";
        echo "<td style='text-align:left;border: 1px solid black;'>".$row->LEVEL4."</td>";
        echo "<td style='text-align:right;border: 1px solid black;'>".$row->BELUM_KIRIM."&nbsp;</td>";        
        echo "<td style='text-align:right;border: 1px solid black;'>".$row->BELUM_APPROVE."&nbsp;</td>";
        echo "</tr>";
    }
    ?>
</table><br><br><br>


Berikut monitoring laporan input data transaksi pada Aplikasi GBM Online<br><br>
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