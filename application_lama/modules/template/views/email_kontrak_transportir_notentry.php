Kepada Yth.,<br>
Bapak/Ibu <?php echo $NAMA_USER; ?>,<br>
<?php echo $LEVEL1; ?><br><br>


Berikut kami sampaikan nama unit pembangkit yang belum memiliki data kontrak transportir pada aplikasi GBM Online :
<br>
<?php
    $PEMBANGKIT_ARR = split(",", $PEMBANGKIT); 
    $x=1;
    foreach($PEMBANGKIT_ARR as $isi) {    
        echo $x++." $isi<br/>";        
    }
?>

<br><br>

Silahkan dilakukan tindak lanjut dengan menginput data kontrak transportir terbaru / amandemen kontrak transportir yang berlaku pada unit terkait.<br>

Alamat Aplikasi : <a href="https://gbmo.pln.co.id/"><b>https://gbmo.pln.co.id</b></a><br><br>
Terima Kasih.<br><br><br>
HELPDESK GBM Online<br>
Layanan<br>
EMAIL : <a href="mailto:helpdesk.gbmo@iconpln.co.id?Subject=INFO%20GBMO" target="_top">helpdesk.gbmo@iconpln.co.id</a>	
<br><br>