<?php
    if ($JENIS == 'XLS') {
        header('Cache-Control: no-cache, no-store, must-revalidate');
        // header('Content-Type: text/html');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename=Detail_Laporan_Jumlah_Aktifitas_User.xls');

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
        <td style="width:80%;text-align:center" colspan="8"><h3>DETAIL LAPORAN JUMLAH AKTIFITAS USER</h3></td>
        <td style="width:10%;text-align:center"></td>
    </tr>
</table>

<table id="dataTable_detail" class="tdetail" width="100%" cellspacing="0" style="max-height:1000px;">
  <thead>
    <tr>
      <th>NO</th>
      <th style="text-align:center;">Username</th>
      <th style="text-align:center;">Log date</th>
      <th style="text-align:center;">Log Date Last</th>
      <th style="text-align:center;">Keterangan</th>
    </tr>
    </thead>
  <tbody>
    <?php $no = 1;foreach ($data as $value) : ?>
      <tr>
        <td style="text-align:center;"><?php echo $no; ?></td>
        <td><?php echo $value['USERNAME']; ?></td>
        <td style="text-align:center;"><?php echo $value['LOG_DATE']; ?></td>
        <td style="text-align:center;"><?php echo $value['LOG_DATE_LAST']; ?></td>
        <td style="text-align:center;"><?php echo $value['KET']; ?></td>
      </tr>
    <?php $no++; endforeach; ?>
  </tbody>
</table> 

<table border="0" style="width:100%;">
    <tr><td></td></tr>
    <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
