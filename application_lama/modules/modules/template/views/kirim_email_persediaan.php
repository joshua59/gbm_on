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
                        <td>Kepada Yth.,</td>
                </tr>
                <tr>
                        <td>Bapak / Ibu <?php echo $pltd; ?></td>
                </tr>
                <!-- <tr>
                        <td>PLN <?php echo $unit; ?></td>
                </tr> -->
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
                                <th>Jenis BBM</th>
                                <th>Volume (L)</th>
                                <th>HOP (Hari)</th>
                                <th>Tanggal Persediaan</th>
                        </tr>
                </thead>
                <tbody>
                        <?php
                        $no = 1;

                        foreach ($array as $key => $value) :

                                echo '<tr>';

                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $value['NAMA_REGIONAL'] . "</td>";
                                echo "<td>" . $value['LEVEL1'] . "</td>";
                                echo "<td>" . $value['LEVEL2'] . "</td>";
                                echo "<td>" . $value['LEVEL3'] . "</td>";
                                echo "<td>" . $value['UNIT'] . "</td>";
                                echo "<td>" . $value['NAMA_JNS_BHN_BKR'] . "</td>";
                                echo "<td>" . number_format($value['STOCK_AKHIR_REAL'], 2, ",", ".") . "</td>";
                                echo "<td>" . number_format($value['SHO'], 2, ",", "." ) . "</td>";
                                echo "<td>" . $value['TGL_MUTASI_PERSEDIAAN'] . "</td>";

                                echo "</tr>";
                        endforeach;

                        ?>


                </tbody>
        </table>

        <p>Silahkan melakukan  tindak lanjut pengecekan data pada aplikasi GBM Online dan melakukan proses transaksi pemakaian jika terdapat data transaksi pemakaian yang belum dientry pada system.
        <br>
        Alamat Aplikasi : https://gbmo.pln.co.id
        <br>
        <br>
        Terima Kasih.
        <br>
        <br>

        HELPDESK GBM Online
        <br>
        Layanan
        <br> 
        EMAIL : servicedesk@pln.co.id</p>
</body>

</html>