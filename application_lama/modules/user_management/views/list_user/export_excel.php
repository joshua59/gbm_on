
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Laporan_User.xls');

        echo '
        <style>

        table.tdetail {
            border-collapse: collapse;
            width:100%;
            font-size: 10px;
            font-family:arial;
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
            font-size: 10px;
            background-color: #CED8F6;
            font-family:arial;
        }

        table.tdetail, table.tdetail td, table.tdetail th {
            border: 1px solid black;
        }

        table.tdetail tbody tr:nth-child(even) {background-color: #f2f2f2}
        table.tdetail tbody tr:nth-child(odd) {background-color: #FFF}

        </style>

        ';
    }
?>

<table border="0" style="width:100%;">
    <tr>
        <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
        <td style="width:80%;text-align:center" colspan="8"><div class="box-kop">LAPORAN  USER</div></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table border="0" style="width:100%;">
    <?php
        $jml_lv=4;
        if ($ID_REGIONAL) {
            $jml_lv= $jml_lv - 1; //3
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $ID_REGIONAL_NAMA . '</td></tr>';
        }
        if ($COCODE) {
            $jml_lv= $jml_lv - 1; //2
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $COCODE_NAMA . '</td></tr>';
        }
        if ($PLANT) {
            $jml_lv= $jml_lv - 1; //1
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $PLANT_NAMA . '</td></tr>';
        }
        if ($STORE_SLOC) {
            $jml_lv= $jml_lv - 1; //0
            echo '<tr><td style="text-align:left;font-size: 12px;" colspan="5">' . $STORE_SLOC_NAMA . '</td></tr>';
        }
    ?>
    <tr><td></td><td></td><td></td><td></td><td></td></tr>
</table>

<table class="tdetail">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama Unit</th>
        <th>Kode User</th>
        <th>Username</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Level Unit</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $x=0;
        foreach ($data as $row):
        $x++;
    ?>
    <tr>
      <?php
              $NAMA_UNIT = !empty($row->NAMA_UNIT) ? $row->NAMA_UNIT : '-';
              $KD_USER = !empty($row->KD_USER) ? $row->KD_USER : '-';
              $USERNAME = !empty($row->USERNAME) ? $row->USERNAME : '-';
              $NAMA_USER = !empty($row->NAMA_USER) ? $row->NAMA_USER : '-';
              $EMAIL_USER = !empty($row->EMAIL_USER) ? $row->EMAIL_USER : '-';
              $ROLES_NAMA = !empty($row->ROLES_NAMA) ? $row->ROLES_NAMA : '-';
              $LEVEL_USER = !empty($row->LEVEL_USER) ? $row->LEVEL_USER : '-';
              $STATUS_USER = !empty($row->STATUS_USER) ? $row->STATUS_USER : '-';
      ?>
        <td style="text-align:center;"><?php echo $x ?></td>
        <td style="text-align:center;"><?php echo $NAMA_UNIT ?></td>
        <td style="text-align:center;"><?php echo $KD_USER ?></td>
        <td style="text-align:center;"><?php echo $USERNAME ?></td>
        <td style="text-align:center;"><?php echo $NAMA_USER ?></td>
        <td style="text-align:center;"><?php echo $EMAIL_USER ?></td>
        <td style="text-align:center;"><?php echo $ROLES_NAMA ?></td>
        <td style="text-align:center;"><?php echo $LEVEL_USER ?></td>
        <td style="text-align:center;"><?php echo $STATUS_USER ?></td>
    </tr>
    <?php
        endforeach;

        if ($x == 0) {
            echo '<tr><td colspan="18" align="center">Data Tidak Ditemukan</td></tr>';
        }
    ?>

    </tbody>
</table>
<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
</html>
