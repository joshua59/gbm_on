
<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Laporan_Jumlah_Aktifitas_User.xls');

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
        <style>
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
        <td style="width:80%;text-align:center" colspan="8"><h3>LAPORAN JUMLAH AKTIFITAS USER</h3></td>
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

<table id="dataTable" class="tdetail" cellspacing="0" style="max-height:1000px;">
  <thead>
      <tr>
          <th style="width: 5%">No</th>
          <th style="max-width: 12%">Username</th>
          <th style="max-width: 8%">Level User</th> 
          <th style="max-width: 8%">Roles</th>     
          <th style="max-width: 8%">Jumlah Login</th>
          <th style="max-width: 12%">Status User</th>
      </tr>
  </thead>
  <tbody>
    <?php $no = 1;foreach ($data as $value): ?>
        <tr>
            <td><?php echo $no; ?></td>
            <td><?php echo $value['USERNAME']; ?></td>
            <td style="text-align: center"><?php echo $value['LEVEL']; ?></td>
            <td style="text-align: center"><?php echo $value['ROLES']; ?></td>
            <td style="text-align: center"><?php echo $value['LOGIN_COUNT']; ?></td>
            <td style="text-align: center"><?php echo $value['ISAKTIF_USER']; ?></td>
        </tr>
    <?php $no++;endforeach ?>           
  </tbody>
</table>

<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
