
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Histo_Stok_BBM.xls');

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

// $tgl = strtotime("2018-12-25");
$tgl = strtotime($val->TGLAKHIR);
$periode = "01 s.d ".set_tgl(date("Y-m-t", strtotime("+1 month", $tgl)));
$tglawal_akhir = set_tgl($val->TGLAWAL)." s.d ".set_tgl($val->TGLAKHIR);
$blth = set_tgl(date("Y-m-t", strtotime("+1 month", $tgl)),"1");

if ($val->JNS_KURS){
    $jns_kurs = 'KTBI';
    $jns_kurs_nama = 'Kurs Transaksi Bank Indonesia';
} else {
    $jns_kurs = 'JISDOR';
    $jns_kurs_nama = 'Jakarta Interbank Spot Dollar Rate';
}
 

// HFO = MFO
// Gas Oil = HSD
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
        <td style="text-align:left">*)</td>
        <td style="text-align:left"></td>
        <td style="text-align:left">Dari</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left">EXECUTIVE VICE PRESIDENT GAS & BBM</td>
        <td style="text-align:left"></td>
    </tr>
    <tr>
        <td style="text-align:left">No. Fax</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left">-</td>
        <td style="text-align:left"></td>
        <td style="text-align:left">No. Fax</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left"><?php echo $param->NO_FAX_KANAN;?></td>
    </tr>
    <tr>
        <td style="text-align:left">No. Telp.</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left">-</td>
        <td style="text-align:left"></td>
        <td style="text-align:left">No. Telp.</td>
        <td style="text-align:center">:</td>
        <td style="text-align:left"><?php echo $param->NO_TELP_KANAN;?></td>
    </tr>
    <tr>
        <td style="text-align:left;vertical-align:top;">Perihal</td>
        <td style="text-align:center;vertical-align:top;">:</td>
        <td style="text-align:justify">Harga Jual BBM Pertamina untuk PLN Periode <?php echo $periode;?> diambil dengan Menggunakan Alat Transport Darat dan Laut.</td>
        <td style="text-align:left"></td>
        <td style="text-align:left;vertical-align:top;">Jml. Hal.</td>
        <td style="text-align:center;vertical-align:top;">:</td>
        <td style="text-align:left;vertical-align:top;">3 (tiga) lembar</td>
    </tr>
    <tr>
        <td colspan="7" class="tebal"><hr></td>
    </tr>    
</table>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:90%;text-align:justify">Mengacu Pada rata-rata MOPS Gasoil <?php echo set_tgl($val->TGLAWAL);?> - <?php echo set_tgl($val->TGLAKHIR);?> yaitu <?php echo number_format($val->MID_HSD_RATA2, 2, ',', '.');?> USD/Barrel dan MOPS HSFO <?php echo $param->FO;?> pada <?php echo number_format($val->MID_MFO_RATA2, 2, ',', '.');?> USD/MT sesuai Perjanjian Jual Beli BBM yang berlaku, dengan ini disampaikan Harga Jual BBM Pertamina untuk PLN Periode <?php echo $periode;?> yang diambil dengan Menggunakan Alat Transport Darat dan Laut sebagai berikut : </td>
    </tr>    
</table>
<br>

 <!-- <?php print_r($lv1)?> -->

<table border="0" style="width:100%;">    
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:80%;text-align:left">
            <table style="width:100%;" class="tdetail">
                <!-- <thead> -->
                    <tr>
                        <th colspan="3" style="text-align:center;padding: 15px;">Harga Periode <?php echo $periode;?></th>
                    </tr>
                <!-- </thead>   -->
                            
                    <tr>
                        <th style="width:30%;text-align:center">Jenis</th>
                        <th style="width:30%;text-align:center">Alpha</th>
                        <th style="width:30%;text-align:center">Harga<br>Tanpa PPN <?php echo !empty($val->PPN) ? $val->PPN : '10'?>%<br>(Rp/L)</th>                    
                    </tr>   
                <tbody>    
                    <tr>
                        <td style="text-align:center">HSD</td> 
                        <td style="text-align:center"><?php echo number_format($val->ALPHA_HSD, 2, ',', '.'); ?>%</td>
                        <td style="text-align:center"><?php echo number_format($val->HARGA_TANPA_HSD, 2, ',', '.'); ?></td>
                    </tr>  
                    <tr>
                        <td style="text-align:center">MFO HSFO</td> 
                        <td style="text-align:center"><?php echo number_format($val->ALPHA_MFO, 2, ',', '.'); ?>%</td>
                        <td style="text-align:center"><?php echo number_format($val->HARGA_TANPA_MFO, 2, ',', '.'); ?></td>
                    </tr> 
                    <tr>
                        <td style="text-align:center">MFO LSFO</td> 
                        <td style="text-align:center"><?php echo number_format($val->ALPHA_MFO_LSFO, 2, ',', '.'); ?>%</td>
                        <td style="text-align:center"><?php echo number_format($val->HARGA_TANPA_MFO_LSFO, 2, ',', '.'); ?></td>
                    </tr> 
                    <tr>
                        <td style="text-align:center">IDO</td>
                        <td style="text-align:center">-</td>
                        <td style="text-align:center"><?php echo number_format($val->HARGA_TANPA_IDO, 2, ',', '.'); ?></td>
                    </tr> 
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
        <td style="width:90%;text-align:justify"><b><i>Harga BBM diatas belum termasuk PPN <?php echo !empty($val->PPN) ? $val->PPN : '10'?>% dan biaya transport, Mohon diperhatikan.</i></b></td>
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
        <td style="width:30%;text-align:center"><b>EXECUTIVE VICE PRESIDENT GAS & BBM,</b></td>        
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

<pagebreak> 

<table border="0" style="width:100%;">
    <tr>
        <td style="width:7%;text-align:left"></td>
        <td style="width:3%;text-align:center"></td>
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
        <td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo set_tgl(date("Y-m-d"),"1"); ?></td>
    </tr>
    <tr>
        <td style="text-align:left"></td>
        <!-- <td style="text-align:center"></td> -->
        <td colspan="2" style="text-align:left">*) Kepada Yth.</td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td>
    </tr>
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td>
    </tr>
    <?php
        $TEMBUSAN_ARR = split(",", $list_tembusan); 
        $x=1;
        foreach($TEMBUSAN_ARR as $isi) {    
            echo
            '<tr>
                <td style="text-align:left"></td>
                <td style="text-align:center">'.$x++.'.</td>
                <td style="text-align:left" colspan="5">'.$isi.'</td>                
            </tr>';
        }
    ?>   

<!--     <?php
        $i=1;
        foreach ($lv1 as $row) {
            echo '<tr>
                    <td style="text-align:left"></td>
                    <td style="text-align:center">'.$i++.'.</td>
                    <td style="text-align:left">'.$row->LEVEL1.'</td>
                    <td style="text-align:left"></td>
                    <td style="text-align:left"></td>
                    <td style="text-align:center"></td>
                    <td style="text-align:left"></td>
                </tr>';           
        }
    ?> -->
</table>


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
        <td style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo set_tgl(date("Y-m-d"),"1"); ?></td>
    </tr>      
</table>
<br><br><br>

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
        <td colspan="5" style="text-align:left"><b>Harga BBM - HSD Dari PT Pertamina (Persero) Bulan <?php echo $blth;?></b></td>
        <!-- <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td> -->
    </tr>    
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:center">=</td>        
        <td style="text-align:center">(Alpha HSD) * (MOPS Gasoil <?php echo $param->MOPS_PERSEN;?> * <?php echo $param->PERSEN;?>) * (<?php echo $jns_kurs;?>)<hr style="margin:1px"><?php echo $param->KONVERSI_BARREL;?></td>
        <td style="text-align:center"></td>
        <td style="text-align:center"></td>        
        <td style="text-align:left"></td>
    </tr>
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:center">=</td>
        <td style="text-align:left">Rp. <?php echo number_format($val->HARGA_TANPA_HSD, 2, ',', '.'); ?> / Ltr</td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>        
        <td style="text-align:left"></td>
    </tr>        
</table>
<br><br><br>

<table border="0" style="width:100%;">  
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:31%;text-align:left"></td>
        <td style="width:1%;text-align:left"></td>
        <td style="width:48%;text-align:left"></td>        
        <td style="width:9%;text-align:left"></td>
    </tr>       
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"><b>-></b></td>        
        <td colspan="5" style="text-align:left"><b>Harga BBM - MFO HSFO Dari PT Pertamina (Persero) Bulan <?php echo $blth;?></b></td>
        <!-- <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td> -->
    </tr>    
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:center">=</td>        
        <td style="text-align:center">(Alpha MFO) * (MOPS MFO HSFO <?php echo $param->FO;?>) * (<?php echo $jns_kurs;?>)<hr style="margin:1px"><?php echo $param->KONVERSI_MT;?></td>
        <td style="text-align:center"></td>
        <td style="text-align:center"></td>        
        <td style="text-align:left"></td>
    </tr>
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:center">=</td>
        <td style="text-align:left">Rp. <?php echo number_format($val->HARGA_TANPA_MFO, 2, ',', '.'); ?> / Ltr</td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>        
        <td style="text-align:left"></td>
    </tr>        
</table>
<br><br><br>

<table border="0" style="width:100%;">  
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:31%;text-align:left"></td>
        <td style="width:1%;text-align:left"></td>
        <td style="width:48%;text-align:left"></td>        
        <td style="width:9%;text-align:left"></td>
    </tr>       
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"><b>-></b></td>        
        <td colspan="5" style="text-align:left"><b>Harga BBM - MFO LSFO Dari PT Pertamina (Persero) Bulan <?php echo $blth;?></b></td>
        <!-- <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td> -->
    </tr>    
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:center">=</td>        
        <td style="text-align:center">(Alpha MFO LSFO) * (MOPS MFO LSFO <?php echo $param->FO;?>) * (<?php echo $jns_kurs;?>)<hr style="margin:1px"><?php echo $param->KONVERSI_MT;?></td>
        <td style="text-align:center"></td>
        <td style="text-align:center"></td>        
        <td style="text-align:left"></td>
    </tr>
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:center">=</td>
        <td style="text-align:left">Rp. <?php echo number_format($val->HARGA_TANPA_MFO_LSFO, 2, ',', '.'); ?> / Ltr</td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>        
        <td style="text-align:left"></td>
    </tr>        
</table>
<br><br><br>

<table border="0" style="width:100%;">  
    <tr>
        <td style="width:9%;text-align:left"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:1%;text-align:center"></td>
        <td style="width:36%;text-align:left"></td>
        <td style="width:1%;text-align:left"></td>
        <td style="width:45%;text-align:left"></td>        
        <td style="width:7%;text-align:left"></td>
    </tr>       
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"><b>-></b></td>        
        <td colspan="5" style="text-align:left"><b>Harga BBM - IDO Dari PT Pertamina (Persero) Bulan <?php echo $blth;?></b></td>
        <!-- <td style="text-align:left"></td>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:left"></td> --> 
    </tr>    
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:center">=</td>        
        <td style="text-align:center"><?php echo $param->PERSEN_IDO_MFO;?> * (Alpha MFO) * (MOPS FO <?php echo $param->FO;?>) * (<?php echo $jns_kurs;?>)<hr style="margin:1px"><?php echo $param->KONVERSI_MT;?></td>
        <td style="text-align:center">+</td>
        <td style="text-align:center"><?php echo $param->PERSEN_IDO_HSD;?> * (Alpha HSD) * (MOPS Gasoil <?php echo $param->GASOIL;?> * 100%) * (<?php echo $jns_kurs;?>)<hr style="margin:1px"><?php echo $param->KONVERSI_BARREL;?></td>        
        <td style="text-align:left"></td>
    </tr>
    <tr>
        <td style="text-align:left"></td>
        <td style="text-align:center"></td>
        <td style="text-align:center">=</td>
        <td style="text-align:left">Rp. <?php echo number_format($val->HARGA_TANPA_IDO, 2, ',', '.'); ?> / Ltr</td>
        <td style="text-align:left"></td>
        <td style="text-align:left"></td>        
        <td style="text-align:left"></td>
    </tr>        
</table>
<br><br>

<table border="0" style="width:100%;">  
    <tr>
        <td style="width:9%;text-align:left"></td>           
        <td style="width:38%;text-align:left"></td>
        <td style="width:1%;text-align:left"></td>
        <td style="width:43%;text-align:left"></td>        
        <td style="width:9%;text-align:left"></td>
    </tr>       
    <tr>
        <td style="text-align:left"></td>        
        <td colspan="4" style="text-align:left"><b>Keterangan : Harga diatas belum termasuk PPN (<?php echo !empty($val->PPN) ? $val->PPN : '10'?>%) dan biaya transport</b></td>
    </tr>          
</table>
<br><br><br>


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
                        <td style="text-align:left">Alpha HSD bulan <?php echo $blth;?></td>
                        <td style="text-align:left"><?php echo number_format($val->ALPHA_HSD, 2, ',', '.'); ?>%</td>
                    </tr>
                    <tr>
                        <td style="text-align:center">2.</td>
                        <td style="text-align:left">Alpha MFO HSFO bulan <?php echo $blth;?></td>
                        <td style="text-align:left"><?php echo number_format($val->ALPHA_MFO, 2, ',', '.'); ?>%</td>
                    </tr>
                    <tr>
                        <td style="text-align:center">2.</td>
                        <td style="text-align:left">Alpha MFO LSFO bulan <?php echo $blth;?></td>
                        <td style="text-align:left"><?php echo number_format($val->ALPHA_MFO_LSFO, 2, ',', '.'); ?>%</td>
                    </tr>
                    <tr>
                        <td style="text-align:center">3.</td>
                        <td style="text-align:left">MOPS Gasoil <?php echo $param->GASOIL;?></td>
                        <td style="text-align:left"><?php echo number_format($val->MID_HSD_RATA2, 2, ',', '.');?> USD/Barrel (<?php echo $tglawal_akhir;?>)</td>
                    </tr>
                    <tr>
                        <td style="text-align:center">4.</td>
                        <td style="text-align:left">MOPS MFO HSFO <?php echo $param->FO;?></td>
                        <td style="text-align:left"><?php echo number_format($val->MID_MFO_RATA2, 2, ',', '.');?> USD/MT (<?php echo $tglawal_akhir;?>)</td>
                    </tr>
                    <tr>
                        <td style="text-align:center">4.</td>
                        <td style="text-align:left">MOPS MFO LSFO <?php echo $param->FO;?></td>
                        <td style="text-align:left"><?php echo number_format($val->MID_MFO_LSFO_RATA2, 2, ',', '.');?> USD/MT (<?php echo $tglawal_akhir;?>)</td>
                    </tr>
                    <tr>
                        <td style="text-align:center">5.</td> 
                        <td style="text-align:left"><?php echo $jns_kurs;?> = <?php echo $jns_kurs_nama;?></td>
                        <td style="text-align:left"><?php echo number_format($val->RATA2_KURS, 2, ',', '.');?> Rp/USD (<?php echo $tglawal_akhir;?>)</td>
                    </tr>
                    <tr>
                        <td style="text-align:center">6.</td>
                        <td style="text-align:left"><?php echo $param->KONVERSI_BARREL;?> = Konversi dari Barrel Ke Liter</td>
                        <td style="text-align:left"></td>
                    </tr>
                    <tr>
                        <td style="text-align:center">7.</td>
                        <td style="text-align:left"><?php echo $param->KONVERSI_MT;?> = Konversi dari MT Ke Liter</td>
                        <td style="text-align:left"></td>
                    </tr>
                </tbody>
            </table>
        </td>
        <td style="width:5%;text-align:left"></td>
    </tr>
</table>

<br><br><br><br><br><br>
<table border="0" style="width:100%;">
    <tr>
        <td style="width:9%;text-align:center"></td>
        <td style="width:6%;text-align:center"></td>
        <td style="width:80%;text-align:center">
            <table style="width:100%;" class="tfooter">
                <tr>
                    <td rowspan="2" style="text-align:center"><b>Maker</b><br>(<?php echo $param->MAKER;?>)</td>
                    <td colspan="2" style="text-align:center"><b>Checker</b></td>        
                    <td rowspan="2" style="text-align:center"><b>Approval</b><br>(<?php echo $param->APPROVAL;?>)</td>        
                </tr>
                <tr>
                    <!-- <td style="width:25%;text-align:center">Maker<br>(Rizki Panji S)</td> -->
                    <td style="text-align:center">(<?php echo $param->CHECKER1;?>)</td>
                    <td style="text-align:center">(<?php echo $param->CHECKER2;?>)</td>
                    <!-- <td style="width:25%;text-align:center">Approval (Eko Warsito)</td>         -->
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
<br><br>

</html>
