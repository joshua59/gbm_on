<html>

<head>
        <style>
                table.tbl {
                        border-collapse: collapse;
                        width: 100%;
                        table-layout: fixed;
                        font-size: 10px;
                        font-family: arial;
                        padding: 2px 2px 2px 2px;
                }

                table.tbl,
                table.tbl td,
                table.tbl th {
                        border: 1px solid black;
                        padding: 2px 2px 2px 2px;
                }

                table.tbl thead {
                        background-color: #CED8F6
                }
        </style>
</head>

<body>
        <table>
                <tr>
                        <td>Dari</td>
                        <td>:</td>
                        <td>gbmo.pln@pln.co.id</td>
                </tr>
                <tr>
                        <td>Kepada</td>
                        <td>:</td>
                        <td><?php echo $nama_user; ?></td>
                </tr>
                <tr>
                        <td>Subjek</td>
                        <td>:</td>
                        <td><?php echo $subject; ?></td>
                </tr>
        </table>
        <table>
                <tr>
                        <td>Kepada Yth.,</td>
                </tr>
                <tr>
                        <td>Bapak / Ibu <?php echo $pltd; ?></td>
                </tr>
                <tr>
                        <td>PLN <?php echo $unit; ?></td>
                </tr>
        </table>
        <p>Berikut kami sampaikan data pembangkit yang teridentifikasi pada system memiliki Hari Operasi Pembangkit (HOP) lebih dari 15 hari pada Aplikasi GBM Online </p>
        <table class="tbl" id="tbl">
                <thead>
                        <tr>
                                <th style="width: 3%;">No</th>
                                <th style="width: 20%;">Nama Regional</th>
                                <th style="width: 10%;">Level 1</th>
                                <th style="width: 10%;">Level 2</th>
                                <th style="width: 10%;">Level 3</th>
                                <th style="width: 10%;">Level 4</th>
                                <th>HSD</th>
                                <th>MFO</th>
                                <th>HSD+BIO</th>
                                <th>IDO</th>
                        </tr>
                </thead>
                <tbody>
                        <?php
                        $no = 1;

                        $cekregional = "";
                        $ceklevel1 = "";
                        $ceklevel2 = "";
                        $ceklevel3 = "";
                        $ceklevel4 = "";
                        foreach ($array as $value) :
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
                                if (isset($total4[$value['UNIT']]['jml'])) {
                                        $total4[$value['UNIT']]['jml']++;
                                } else {
                                        $total4[$value['UNIT']]['jml'] = 1;
                                }
                        endforeach;

                        foreach ($array as $key => $value) :

                                $r0 = $total[$value['NAMA_REGIONAL']]['jml'];
                                $r1 = $total1[$value['LEVEL1']]['jml'];
                                $r2 = $total2[$value['LEVEL2']]['jml'];
                                $r3 = $total3[$value['LEVEL3']]['jml'];
                                $r4 = $total4[$value['UNIT']]['jml'];
                                echo '<tr>';
                                echo "<td>" . (($no++)) . "</td>";
                                if ($cekregional != $value['NAMA_REGIONAL']) {
                                        echo '<td' . ($r0 > 1 ? ' rowspan="' . ($r0) . '">' : '>') . $value['NAMA_REGIONAL'] . '</td>';
                                        $cekregional = $value['NAMA_REGIONAL'];
                                }
                                if ($ceklevel1 != $value['LEVEL1']) {
                                        echo '<td' . ($r1 > 1 ? ' rowspan="' . ($r1) . '">' : '>') . $value['LEVEL1'] . '</td>';
                                        $ceklevel1 = $value['LEVEL1'];
                                }
                                if ($ceklevel2 != $value['LEVEL2']) {
                                        echo '<td' . ($r2 > 1 ? ' rowspan="' . ($r2) . '">' : '>') . $value['LEVEL2'] . '</td>';
                                        $ceklevel2 = $value['LEVEL2'];
                                }
                                if ($ceklevel3 != $value['LEVEL3']) {
                                        echo '<td' . ($r3 > 1 ? ' rowspan="' . ($r3) . '">' : '>') . $value['LEVEL3'] . '</td>';
                                        $ceklevel3 = $value['LEVEL3'];
                                }
                                if ($ceklevel4 != $value['UNIT']) {
                                        echo '<td' . ($r4 > 1 ? ' rowspan="' . ($r4) . '">' : '>') . $value['UNIT'] . '</td>';
                                        $ceklevel4 = $value['UNIT'];
                                }
                                $SHO_HSD = ($value['SHO_HSD'] == 0 || $value['SHO_HSD'] == "") ? "" : " (" . $value['SHO_HSD'] . " Hari)";
                                $SHO_MFO = ($value['SHO_MFO'] == 0 || $value['SHO_MFO'] == "") ? "" : " (" . $value['SHO_MFO'] . " Hari)";
                                $SHO_HSDBIO = ($value['SHO_HSDBIO'] == 0 || $value['SHO_HSDBIO'] == "") ? "" : " (" . $value['SHO_HSDBIO'] . " Hari)";
                                $SHO_IDO = ($value['SHO_IDO'] == 0 || $value['SHO_IDO'] == "") ? "" : " (" . $value['SHO_IDO'] . " Hari)";

                                echo "<td>" . number_format($value['SA_HSD'], 0, ",", ".") . "L" . $SHO_HSD . "</td>";
                                echo "<td>" . number_format($value['SA_MFO'], 0, ",", ".") . "L" . $SHO_MFO . "</td>";
                                echo "<td>" . number_format($value['SA_HSDBIO'], 0, ",", ".") . "L" . $SHO_HSDBIO . "</td>";
                                echo "<td>" . number_format($value['SA_IDO'], 0, ",", ".") . "L" . $SHO_IDO . "</td>";
                                echo "</tr>";
                        endforeach;

                        ?>


                </tbody>
        </table>
</body>

</html>