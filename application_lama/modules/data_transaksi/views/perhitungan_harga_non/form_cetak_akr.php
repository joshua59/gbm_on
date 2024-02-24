
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Cetak_Form_Harga_BBM_AKR.xls');

        echo '
        <style>

        table.tdetail {
            border-collapse: collapse;
            width:100%;                     
        }

        table.tdetail, table.tdetail td, table.tdetail th {
            border: 1px solid black;
        }

        table.tdetail thead {background-color: #CED8F6}

        </style>

        ';
    } else {
        echo '
        <!DOCTYPE html>
        <html>
        <style>
        thead { display: table-header-group }
tfoot { display: table-row-group }
tr { page-break-inside: avoid }
        table.tdetail {
            border-collapse: collapse;
            width:100%;
            background-color: #CED8F6;            
        }

        table.tdetail, table.tdetail td, table.tdetail th {
            border: 1px solid black;
            padding: 5px;
        }

        table.tfooter {
            border-collapse: collapse;        
        }        

        table.tfooter, table.tfooter td, table.tfooter th {
            border: 1px solid black;
            padding: 5px;
        }        

        table.tdetail tbody tr:nth-child(even) {background-color: #f2f2f2}
        table.tdetail tbody tr:nth-child(odd) {background-color: #FFF}

        hr{
            height:2px;
            border:none;
            color:#333;
            background-color:#333;
        }
        </style>

        ';
    }

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    }     
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }           
    return $hasil;
}    

function set_tgl($tanggal, $jns=''){
    $bulan = array ('01' =>   'Januari',
                    '02' =>   'Februari',
                    '03' =>   'Maret',
                    '04' =>   'April',
                    '05' =>   'Mei',
                    '06' =>   'Juni',
                    '07' =>   'Juli',
                    '08' =>   'Agustus',
                    '09' =>   'September',
                    '10' =>   'Oktober',
                    '11' =>   'November',
                    '12' =>   'Desember'
            );            
    $split = explode('-', $tanggal);
    if ($jns){
        $rest =  $bulan[$split[1]]. ' ' . $split[0];    
    } else {
        $rest =  ($split[2].' '.$bulan[$split[1]]. ' ' . $split[0]);    
    }
    return $rest;
}

function set_thbl($thbl){
    $bulan = array ('01' =>   'Januari',
                    '02' =>   'Februari',
                    '03' =>   'Maret',
                    '04' =>   'April',
                    '05' =>   'Mei',
                    '06' =>   'Juni',
                    '07' =>   'Juli',
                    '08' =>   'Agustus',
                    '09' =>   'September',
                    '10' =>   'Oktober',
                    '11' =>   'November',
                    '12' =>   'Desember'
            );    

    // 201807            
    $th = substr($thbl, 0,4);
    $bl = substr($thbl, 4, 2);

    $rest =  $bulan[$bl]. ' ' . $th;
    return $rest;
}

$periode = set_thbl($val->PERIODE);
$tglawal_akhir = set_tgl($val->TGLAWAL)." s.d ".set_tgl($val->TGLAKHIR);
$tgl_awal_kontrak = set_tgl($tgl_awal_kontrak);
$tgl_bl = set_tgl($val->TGLAWAL);

// set detail pltd
$sum_pltd=0;
$arr_pltd = '';
foreach ($list as $row) {
    $sum_pltd++;
    if ($arr_pltd==''){
        $arr_pltd=$row['LEVEL4'];
    } else {
        $arr_pltd.=', '.trim($row['LEVEL4'],' ');
    }
}


if ($val->JNS_KURS){
    $jns_kurs = 'KTBI';
    $jns_kurs_nama = 'Kurs Transaksi Bank Indonesia';
} else {
    $jns_kurs = 'JISDOR';
    $jns_kurs_nama = 'Jakarta Interbank Spot Dollar Rate';
}
 
?>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:5%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:85%;text-align:left"><div class="box-kop">PT PLN (Persero)<br>KANTOR PUSAT</div></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:40%;text-align:left"></td>
        <td style="width:15%;text-align:left"></td>
        <td style="width:9%;text-align:left">Nomor</td>
        <td style="width:1%;text-align:center">:</td>
        <td style="width:25%;text-align:left"></td>
    </tr>
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:left">Tanggal</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo set_tgl(date("Y-m-d"),"1"); ?></td>
    </tr>
    <tr>
        <td colspan="7"><hr></td>
    </tr>
    <tr>
        <td style="text-align:left">Kepada Yth.</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left"><?php echo $param->KEPADA1;?></td>
        <td style="text-align:left"></td>
        <td style="text-align:left">Dari</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left">Executive Vice President</td>
    </tr>
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"><?php echo $param->KEPADA2;?></td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td>
    </tr>    
    <tr>
        <td style="text-align:left">&nbsp;</td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td>
    </tr>
    <tr>
        <td style="text-align:left">No. Fax</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left"><?php echo $param->NO_FAX_KIRI;?></td>
        <td style="text-align:left"></td>
        <td style="text-align:left">No. Fax</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left"><?php echo $param->NO_FAX_KANAN;?></td>
    </tr>
    <tr>
        <td style="text-align:left">No. Telp.</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left"><?php echo $param->NO_TELP_KIRI;?></td>
        <td style="text-align:left"></td>
        <td style="text-align:left">No. Telp.</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left"><?php echo $param->NO_TELP_KANAN;?></td>
    </tr>
    <tr>
        <td style="text-align:left;vertical-align:top;">Perihal</td>
        <td style="text-align:center;vertical-align:top;">:</td>
        <td style="text-align:justify">Harga Insidential BBM (HSD) Bulan <?php echo $periode;?> untuk <?php echo $arr_pltd;?></td>
        <td style="text-align:left"></td>
        <td style="text-align:left;vertical-align:top;">Jml. Hal.</td>
        <td style="text-align:center;vertical-align:top;">:</td>
        <!-- <td style="text-align:left;vertical-align:top;"><?php $sum_pltd++; echo $sum_pltd; echo ' ('.terbilang($sum_pltd).')' ?> lembar</td> -->
        <td style="text-align:left;vertical-align:top;">1 (Satu) set</td>
    </tr>
    <tr>
        <td colspan="7" class="tebal"><hr></td>
    </tr>    
</table>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:90%;text-align:justify">Mengacu surat PT PLN (Persero) <?php echo $list_unit[0]->LEVEL1;?> No. PLN <?php echo $val->NOPJBBM;?> tanggal <?php echo $tgl_awal_kontrak;?> perihal Pasokan Insidential BBM.
        Untuk <?php echo $arr_pltd;?><br.><br>
        Dengan ini kami sampaikan Harga Insidential Pembelian BBM (HSD) untuk <?php echo $arr_pltd;?>.<br>
        Untuk Tanggal <?php echo $tgl_bl;?> dari AKR yaitu sebagai berikut :
        </td>    
    </tr>    
</table>
<br>
<!-- 
<?php 
echo '<pre>';
print_r($val);
echo '</pre>';
?>
 -->
<table border="0" style="width:100%;">    
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:80%;text-align:left">
            <table style="width:100%;" class="tdetail">
                <!-- <thead> -->
                <!-- </thead>   -->
                            
                    <tr>
                        <th style="width:7%;text-align:center">No</th>
                        <th style="width:50%;text-align:center">Pembangkit</th>
                        <th style="width:30%;text-align:center">Harga BBM<br>(Rp/Liter)</th>
                    </tr>   
                <tbody>    
                    <?php
                        $i=1;
                        foreach ($list as $row) {
                            echo '<tr>                                    
                                    <td style="text-align:center">'.$i++.'.</td>
                                    <td style="text-align:left">'.$row['LEVEL4'].'</td>
                                    <td style="text-align:right">'.number_format($row['HARGA_DENGAN_HSD'], 2, ',', '.').'</td>
                                </tr>';           
                        }
                    ?> 
                </tbody>
            </table>
        </td>
        <td style="width:10%;text-align:center"></td>
    </tr>    
</table>
<br>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:90%;text-align:justify"><i>Catatan :</i></td>
    </tr>    
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:90%;text-align:justify"><b><i>Harga BBM (HSD) diatas sudah termasuk biaya transport dan PPN 10%</i></b></td>
    </tr>  
</table>
<br><br>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:90%;text-align:justify">Demikian disampaikan, atas perhatian dan kerjasama yang baik diucapkan terimakasih.</td>
    </tr>  
</table>
<br><br><br><br><br><br>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:55%;text-align:left"></td>        
        <td style="width:30%;text-align:center"><b>EXECUTIVE VICE PRESIDENT,</b></td>        
        <td style="width:5%;text-align:left"></td>
    </tr>
    <tr>
        <td style="width:9%;text-align:left;height:100px"></td>
        <td style="width:1%;text-align:center"></td>        
        <td style="width:55%;text-align:left"></td>
        <td style="width:30%;text-align:center"></td>        
        <td style="width:5%;text-align:left"></td>
    </tr>
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>        
        <td style="width:55%;text-align:left"></td>
        <td style="width:30%;text-align:center"><b><?php echo $param->KDIV;?></b></td>
        <td style="width:5%;text-align:left"></td>
    </tr>
</table>




<table border="0" style="width:100%;">
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:90%;text-align:justify">Tembusan Yth, :</td>
    </tr>  
<?php
    $TEMBUSAN_ARR = split(",", $list_tembusan); 
    $x=1;
    foreach($TEMBUSAN_ARR as $isi) {    
        if ($x==11) break;
        echo
        '<tr>
            <td style="width:9%;text-align:left"></td>
            <td style="width:1%;text-align:center"></td>
            <td style="width:90%;text-align:justify">'.$x++.'. '.$isi.'</td>
        </tr>';
    }
?>   
</table>

<?php
    $i=1;
    foreach ($list as $row) {
        echo '
        <pagebreak> 

        <table border="0" style="width:100%;">
            <tr>
                <td style="width:9%;text-align:left"></td>
                <td style="width:1%;text-align:center"></td>
                <td style="width:40%;text-align:left"></td>
                <td style="width:15%;text-align:left"></td>
                <td style="width:9%;text-align:left">Lampiran</td>
                <td style="width:1%;text-align:center"></td>
                <td style="width:25%;text-align:left"></td>
            </tr>    
            <tr>
                <td style="width:9%;text-align:left"></td>
                <td style="width:1%;text-align:center"></td>
                <td style="width:40%;text-align:left"></td>
                <td style="width:15%;text-align:left"></td>
                <td style="width:9%;text-align:left">Nomor</td>
                <td style="width:1%;text-align:center">:</td>
                <td style="width:25%;text-align:left"></td>
            </tr>
            <tr>
                <td style="text-align:left"></td>
                <td style="text-align:center"></td>
                <td style="text-align:left"></td>
                <td style="text-align:left"></td>
                <td style="text-align:left">Tanggal</td>
                <td style="text-align:center">:</td>
                <td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.set_tgl(date("Y-m-d"),"1").'</td>
            </tr>      
        </table>
        <br><br><br>';

        echo '
        <table border="0" style="width:100%;">  
            <tr>
                <td style="width:8%;text-align:left"></td>
                <td style="width:3%;text-align:left"></td>
                <td style="width:1%;text-align:center"></td>
                <td style="width:38%;text-align:left"></td>
                <td style="width:1%;text-align:left"></td>
                <td style="width:40%;text-align:left"></td>        
                <td style="width:9%;text-align:left"></td>
            </tr>       
            <tr>
                <td style="text-align:left"></td>
                <td style="text-align:center"><b>-></b></td>        
                <td colspan="5" style="text-align:left"><b>Harga BBM (HSD) Dari PT Kutilang Paksi Mas ke Pembangkit '.$row['LEVEL4'].' Tanggal '.$tgl_bl.'</b></td>
            </tr>    
            <tr>
                <td style="text-align:left"></td>
                <td style="text-align:center"></td>
                <td style="text-align:center">=</td>        
                <td style="text-align:center">('.$param->ALPHA1.') * (LOPS '.$param->MOPS_PERSEN.' * '.$param->PERSEN.') * (1,1) * ('.$jns_kurs.')<hr style="margin:1px">'.$param->KONVERSI_BARREL.'</td>
                <td style="text-align:center">+</td>
                <td style="text-align:left">Rp. '.number_format($row['ONGKOS_ANGKUT'], 2, ',', '.').' / Ltr</td>        
                <td style="text-align:left"></td>
            </tr>
            <tr>
                <td style="text-align:left"></td>
                <td style="text-align:center"></td>
                <td style="text-align:center">=</td>
                <td style="text-align:left">Rp. '.number_format($row['HARGA_DENGAN_HSD'], 2, ',', '.').' / Ltr</td>
                <td style="text-align:left"></td>
                <td style="text-align:left"></td>        
                <td style="text-align:left"></td>
            </tr>        
        </table>
        <br><br><br>';  

        echo '
        <table border="0" style="width:100%;">  
            <tr>
                <td style="width:9%;text-align:left"></td>            
                <td style="width:86%;text-align:left">
                    <table style="width:100%;" class="tdetail">  
                        <tr>
                            <th style="width:10px;text-align:center"></th>        
                            <th style="width:250px;text-align:left">Dimana : </th>        
                            <th style="width:350px;text-align:left">Nilai : </th>                
                        </tr>
                        <tbody>
                            <tr>
                                <td style="text-align:center">1.</td>
                                <td style="text-align:left">Alpha</td>
                                <td style="text-align:left">'.$param->ALPHA1.'</td>
                            </tr>
                            <tr>
                                <td style="text-align:center">2.</td>
                                <td style="text-align:left">MOPS '.$param->MOPS_PERSEN.' = Rata Rata Harga Platss terendah untuk 0,25% Kandungan Sulfur (LOPS)</td>
                                <td style="text-align:left">'.number_format($row['LOW_HSD_RATA2'], 2, ',', '.').' USD / Barrel ('.$tgl_bl.')</td>
                            </tr>
                            <tr>
                                <td style="text-align:center">3.</td>
                                <td style="text-align:left">PPN = Pajak Pertambahan Nilai</td>
                                <td style="text-align:left">10%</td>
                            </tr>
                            <tr>
                                <td style="text-align:center">4.</td> 
                                <td style="text-align:left">'.$jns_kurs.' = '.$jns_kurs_nama.'</td>
                                <td style="text-align:left">'.number_format($row['RATA2_KURS'], 2, ',', '.').' Rp / USD ('. $tgl_bl.')</td>
                            </tr>
                            <tr>
                                <td style="text-align:center">5.</td>
                                <td style="text-align:left">Trans = Komponen Biaya Transport</td>
                                <td style="text-align:left">'.number_format($row['ONGKOS_ANGKUT'], 2, ',', '.').' Rp / Ltr</td> 
                            </tr>
                            <tr>
                                <td style="text-align:center">6.</td>
                                <td style="text-align:left">'.$param->KONVERSI_BARREL.'= Konversi dari Barrel Ke Liter</td>
                                <td style="text-align:left"></td>
                            </tr>                    
                        </tbody>
                    </table>
                </td>
                <td style="width:5%;text-align:left"></td>
            </tr>
        </table>
        <br><br><br><br><br><br>'; 

        echo '
        <table border="0" style="width:100%;">
            <tr>
                <td style="width:9%;text-align:center"></td>
                <td style="width:6%;text-align:center"></td>
                <td style="width:80%;text-align:center">
                    <table style="width:100%;" class="tfooter">
                        <tr>
                            <td rowspan="2" style="text-align:center"><b>Maker</b><br>('.$param->MAKER.')</td>
                            <td colspan="2" style="text-align:center"><b>Checker</b></td>        
                            <td rowspan="2" style="text-align:center"><b>Approval</b><br>('.$param->APPROVAL.')</td>        
                        </tr>
                        <tr>                    
                            <td style="text-align:center">('.$param->CHECKER1.')</td>
                            <td style="text-align:center">('.$param->CHECKER2.')</td>                    
                        </tr> 
                        <tr>
                            <td style="width:25%;text-align:center">&nbsp;<br>&nbsp;</td>
                            <td style="width:25%;text-align:center">&nbsp;<br>&nbsp;</td>
                            <td style="width:25%;text-align:center">&nbsp;<br>&nbsp;</td>
                            <td style="width:25%;text-align:center">&nbsp;<br>&nbsp;</td>
                        </tr>        
                    </table>             
                </td>
                <td style="width:5%;text-align:center"></td>        
            </tr>    
        </table>
        <br><br>';               
    }
?>

</html>
