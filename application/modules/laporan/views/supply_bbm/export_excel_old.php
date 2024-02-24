<?php
if ($JENIS == 'XLS') {
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename=LAPORAN_SUPPLY_BBM.xls');
}
?>
<?php if ($JENIS == 'XLS') { ?>
    <style>
        table.tdetail{
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
            font-family: arial;
        }
    </style>
<?php } ?>
<table border="0" style="width:100%;">
  <tr>
      <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
      <td style="width:80%;text-align:center" colspan="19"><h3>Laporan Supply BBM</h3></td>
      <td style="width:10%;text-align:center"></td>
  </tr>
</table>
<table class="tdetail">
    <thead>
        <tr>
            <th rowspan="2" style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">No</th>
            <th colspan="4" style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Level</th>
            <th rowspan="2" style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Unit Pembangkit</th>
            <th colspan="4" style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Kontrak Transportir</th>
            <th colspan="5" style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Kapasitas Tangki Per Jenis Bahan Bakar (L)</th>
            <th rowspan="2" style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Total Kapasitas (L)</th>
            <th rowspan="2" style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Latitude</th>
            <th rowspan="2" style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Longtitude</th>
            <th rowspan="2" style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Status</th>
        </tr>
        <tr>
            <th style="width: 200px;background-color:#CED8F6;border-collapse: collapse;border :1px solid black;">Regional</th>
            <th style="width: 200px;background-color:#CED8F6;border-collapse: collapse;border :1px solid black;">Level 1</th>
            <th style="width: 200px;background-color:#CED8F6;border-collapse: collapse;border :1px solid black;">Level 2</th>
            <th style="width: 200px;background-color:#CED8F6;border-collapse: collapse;border :1px solid black;">Level 3</th>
            <th style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Transportir</th>
            <th style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Depo</th>
            <th style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Jalur</th>
            <th style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">Ongkos Angkut (Rp)</th>
            <th style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">HSD</th>
            <th style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">MFO</th>
            <th style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">BIO</th>
            <th style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">HSD+BIO</th>
            <th style="background-color: #CED8F6;border-collapse: collapse;border :1px solid black;">IDO</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        $cekregional = "";
        $ceklevel1 = "";
        $ceklevel2 = "";
        $ceklevel3 = "";
        $ceklevel4 = "";
        foreach ($data as $value) :
                if (isset($total[$value['NAMA_REGIONAL']]['jml'])) {
                        $total[$value['NAMA_REGIONAL']]['jml']++;
                } else {
                        $total[$value['NAMA_REGIONAL']]['jml'] = 1;
                }
                if (isset($total1[$value['LEVEL1']]['jml'])) {
                        $total1[$value['LEVEL1']]['jml']++;
                } else {
                        $total1[$value['LEVEL1']]['jml'] = 1;
                }
                if (isset($total2[$value['LEVEL2']]['jml'])) {
                        $total2[$value['LEVEL2']]['jml']++;
                } else {
                        $total2[$value['LEVEL2']]['jml'] = 1;
                }
                if (isset($total3[$value['LEVEL3']]['jml'])) {
                        $total3[$value['LEVEL3']]['jml']++;
                } else {
                        $total3[$value['LEVEL3']]['jml'] = 1;
                }
                if (isset($total4[$value['LEVEL4']]['jml'])) {
                        $total4[$value['LEVEL4']]['jml']++;
                } else {
                        $total4[$value['LEVEL4']]['jml'] = 1;
                }
        endforeach;      
                
        foreach ($data as $key => $value) : ?>
            <tr>
            
                <td style="border-collapse: collapse;border :1px solid black;"><?php echo $no++; ?></td>
                <?php
                $r0 = $total[$value['NAMA_REGIONAL']]['jml'];
                $r1 = $total1[$value['LEVEL1']]['jml'];
                $r2 = $total2[$value['LEVEL2']]['jml'];
                $r3 = $total3[$value['LEVEL3']]['jml'];
                $r4 = $total4[$value['LEVEL4']]['jml'];
                if ($cekregional != $value['NAMA_REGIONAL']) {
                        echo '<td style="border-collapse: collapse;border :1px solid black;vertical-align:middle" ' . ($r0 > 1 ? ' rowspan="' . ($r0) . '">' : '>') . $value['NAMA_REGIONAL'] . '</td>';
                        $cekregional = $value['NAMA_REGIONAL'];
                }
                if ($ceklevel1 != $value['LEVEL1']) {
                        echo '<td style="border-collapse: collapse;border :1px solid black;vertical-align:middle" ' . ($r1 > 1 ? ' rowspan="' . ($r1) . '">' : '>') . $value['LEVEL1'] . '</td>';
                        $ceklevel1 = $value['LEVEL1'];
                }
                if ($ceklevel2 != $value['LEVEL2']) {
                        echo '<td style="border-collapse: collapse;border :1px solid black;vertical-align:middle" ' . ($r2 > 1 ? ' rowspan="' . ($r2) . '">' : '>') . $value['LEVEL2'] . '</td>';
                        $ceklevel2 = $value['LEVEL2'];
                }
                if ($ceklevel3 != $value['LEVEL3']) {
                        echo '<td style="border-collapse: collapse;border :1px solid black;vertical-align:middle" ' . ($r3 > 1 ? ' rowspan="' . ($r3) . '">' : '>') . $value['LEVEL3'] . '</td>';
                        $ceklevel3 = $value['LEVEL3'];
                }
                if ($ceklevel4 != $value['LEVEL4']) {
                        echo '<td style="border-collapse: collapse;border :1px solid black;vertical-align:middle" ' . ($r4 > 1 ? ' rowspan="' . ($r4) . '">' : '>') . $value['LEVEL4'] . '</td>';
                        $ceklevel4 = $value['LEVEL4'];
                }
                ?>
                <td style="border-collapse: collapse;border :1px solid black;"><?php echo $value['NAMA_TRANSPORTIR'] ?></td>
                <td style="border-collapse: collapse;border :1px solid black;"><?php echo $value['NAMA_DEPO'] ?></td>
                <td style="border-collapse: collapse;border :1px solid black;"><?php echo $value['JALUR'] ?></td>
                <td style="text-align: right;border-collapse: collapse;border :1px solid black;"><?php echo $value['HARGA_KONTRAK_TRANS'] ?></td>
                <td style="text-align: right;border-collapse: collapse;border :1px solid black;"><?php echo number_format($value['HSD'], 0, ",", ".") ?></td>
                <td style="text-align: right;border-collapse: collapse;border :1px solid black;"><?php echo number_format($value['MFO'], 0, ",", ".") ?></td>
                <td style="text-align: right;border-collapse: collapse;border :1px solid black;"><?php echo number_format($value['BIO'], 0, ",", ".") ?></td>
                <td style="text-align: right;border-collapse: collapse;border :1px solid black;"><?php echo number_format($value['HSDBIO'], 0, ",", ".") ?></td>
                <td style="text-align: right;border-collapse: collapse;border :1px solid black;"><?php echo number_format($value['IDO'], 0, ",", ".") ?></td>
                <td style="text-align: right;border-collapse: collapse;border :1px solid black;"><?php echo number_format($value['TOTAL_KAPASITAS'], 0, ",", ".") ?></td>
                <td style="border-collapse: collapse;border :1px solid black;"><?php echo $value['LAT'] ?></td>
                <td style="border-collapse: collapse;border :1px solid black;"><?php echo $value['LOT'] ?></td>
                <td style="border-collapse: collapse;border :1px solid black;"><?php echo ($value['STATUS'] == '0') ? 'Tidak Aktif' : 'Aktif'; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>