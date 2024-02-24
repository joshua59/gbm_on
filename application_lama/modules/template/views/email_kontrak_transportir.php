Kepada Yth.,<br>
Bapak/Ibu <?php echo $NAMA_USER; ?>,<br>
<?php echo $LEVEL1; ?><br><br>

Masa berlaku data kontrak transportir untuk PT PLN (Persero) Area/Sektor <?php echo $LEVEL2; ?> dengan :<br>
Nomor Kontrak : <?php echo $NOMOR_KONTRAK; ?><br>
Nama Transportir : <?php echo $NAMA_TRANSPORTIR; ?><br>
Nama Pembangkit Terkait : <br>
<?php
    $PEMBANGKIT_ARR = split(",", $PEMBANGKIT); 
    $x=1;
    foreach($PEMBANGKIT_ARR as $isi) {    
        echo $x++." $isi<br/>";        
    }
?>


Tanggal Awal : <?php echo $TGL_AWAL; ?><br>
Tanggal Akhir : <?php echo $TGL_AKHIR; ?><br>
Akan segera berakhir .<br><br>

Silahkan dilakukan tindak lanjut dengan menginput data kontrak transportir terbaru / amandemen kontrak transportir yang berlaku pada unit terkait.<br>

Alamat Aplikasi : <a href="https://gbmo.pln.co.id/"><b>https://gbmo.pln.co.id</b></a><br><br>
Terima Kasih.<br><br><br>
HELPDESK GBM Online<br>
Layanan<br>
EMAIL : <a href="mailto:helpdesk.gbmo@iconpln.co.id?Subject=INFO%20GBMO" target="_top">helpdesk.gbmo@iconpln.co.id</a>	
<br><br>