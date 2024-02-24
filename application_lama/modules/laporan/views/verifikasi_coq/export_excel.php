<?php if($JENIS == 'XLS') { 
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=Verifikasi_COQ.xls');
?>

<style type="text/css">
  .red_dot {
    background-color : red;
  }
  .green_dot {
    background-color : green;
  }
</style>
<?php } else { ?>

<style type="text/css">
  .red_dot {
    height: 25px;
    width: 25px;
    border-radius: 50%;
    display: inline-block;
    background-color : red;
    border : solid black 2px;
  }
  .dot {
    height: 25px;
    width: 25px;
    border-radius: 50%;
    display: inline-block;
    background-color : #bbb;
    border : solid black 2px;
  }
  .green_dot {
    height: 25px;
    width: 25px;
    border-radius: 50%;
    display: inline-block;
    background-color : green;
    border : solid black 2px;
  }
</style>
<?php } ?>
<style type="text/css">
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
<table border="0" style="width:100%;">
  <tr>
      <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
      <td style="width:80%;text-align:center" colspan="8"><h3>Data Verifikasi Hasil COQ</h3></td>
      <td style="width:10%;text-align:center"></td>
  </tr>
</table>
<table class="tdetail">
  <thead>
    <tr>
      <th rowspan="2">No</th>
      <th rowspan="2">Report Number</th>
      <th rowspan="2">Tanggal COQ</th>
      <th rowspan="2">Jenis / Komponen BBM</th>
      <th rowspan="2">Pemasok</th>
      <th rowspan="2">Depo</th>
      <th rowspan="2">Shore Tank</th>
      <th rowspan="2">Keterangan</th>
      <th rowspan="2">User<br/>Input</th>
      <th rowspan="2">Tanggal<br/>Input</th>
      <th colspan="3">Status</th>
      <th rowspan="2">Keterangan<br/>Review</th>
      <th rowspan="2">User<br/>Review</th>
      <th rowspan="2">Tanggal<br/>Review</th>
    </tr>
    <tr>
      <th>Hasil</th>
      <th>Review</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1;
    $passed_excel     = '<td style="background-color :green;display: inline-block;color:green;"></td>';
    $not_passed_excel = '<td style="background-color :red;display: inline-block;color:red;"></td>';

    $passed_pdf       = '<td><a class="green_dot"></a></td>';
    $not_passed_pdf   = '<td><a class="red_dot"></a></td>';

    $review_excel     = '&#10003;';
    $review_pdf       = '&#10003;';

    $not_review_excel = '-';
    $not_review_pdf   = '-';
   
    foreach ($list as $value) { 
      if($JENIS == 'XLS') {
        if($value['STATUS_REVIEW'] == 1) {
          $check  = $not_review_excel;
        } else if($value['STATUS_REVIEW'] == 2) {
          $check  = $not_review_excel;
        } else if($value['STATUS_REVIEW'] == 3) {
          $check  = $not_review_excel;
        } else if($value['STATUS_REVIEW'] == 4) {
          $check  = $review_excel;
        } else if($value['STATUS_REVIEW'] == 5) {
          $check  = $review_excel;
        } else if($value['STATUS_REVIEW'] == 6) {
          $check  = $review_excel;
        }
      } else {
        if($value['STATUS_REVIEW'] == 1) {
          $check  = $not_review_pdf;
        } else if($value['STATUS_REVIEW'] == 2) {
          $check  = $not_review_pdf;
        } else if($value['STATUS_REVIEW'] == 3) {
          $check  = $not_review_pdf;
        } else if($value['STATUS_REVIEW'] == 4) {
          $check  = $review_pdf;
        } else if($value['STATUS_REVIEW'] == 5) {
          $check  = $review_pdf;
        } else if($value['STATUS_REVIEW'] == 6) {
          $check  = $review_pdf;
        }
      }

    $REPORT = $value['NO_REPORT']; ?>
      <tr>
        <td style="text-align: center"><?php echo $no ?></td>
        <td style="text-align: center">
          <b><?php echo $value['NO_REPORT'] ?></b>
        </td>
        <td style="text-align: center;"><?php echo $value['TGL_COQ'] ?></td>
        <td style="text-align: center;"><?php echo $value['NAMA_BBM'] ?></td>
        <td style="text-align: center;"><?php echo $value['NAMA_PEMASOK'] ?></td>
        <td style="text-align: center;"><?php echo $value['NAMA_DEPO'] ?></td>
        <td style="text-align: center;"><?php echo $value['SHORE_TANK'] ?></td>
        <td style="text-align: center;"><?php echo $value['KET'] ?></td>
        <td style="text-align: center;"><?php echo $value['CD_BY'] ?></td>
        <td style="text-align: center;"><?php echo $value['CD_DATE'] ?></td>
        <?php if($JENIS == 'XLS') { ?>
          <?php if($value['STATUS_REVIEW'] == 1) { ?>
            <td style="background-color :green;display: inline-block;color:green;"></td>
          <?php } else if($value['STATUS_REVIEW'] == 2) { ?>
            <td style="background-color :red;display: inline-block;color:red;"></td>
          <?php } else if($value['STATUS_REVIEW'] == 3){ ?>
            <td style="background-color :red;display: inline-block;color:red;"></td>
          <?php } else if($value['STATUS_REVIEW'] == 4){ ?>
            <td style="background-color :red;display: inline-block;color:red;"></td>
          <?php } else if($value['STATUS_REVIEW'] == 5){ ?>
            <td style="background-color :green;display: inline-block;color:green;"></td>
          <?php } else if($value['STATUS_REVIEW'] == 6){ ?>
            <td style="background-color :red;display: inline-block;color:red;"></td>
          <?php } ?>
        <?php } else { ?>
          <?php if($value['STATUS_REVIEW'] == 1) { ?>
            <td style="background-color: green;"></td>
          <?php } else if($value['STATUS_REVIEW'] == 2) { ?>
            <td style="background-color: red;"></td>
          <?php } else if($value['STATUS_REVIEW'] == 3){ ?>
            <td style="background-color: red;"></td>
          <?php } else if($value['STATUS_REVIEW'] == 4){ ?>
            <td style="background-color: red;"></td>
          <?php } else if($value['STATUS_REVIEW'] == 5){ ?>
            <td style="background-color: green;"></td>
          <?php } else if($value['STATUS_REVIEW'] == 6){ ?>
            <td style="background-color: red;"></td>
          <?php } ?>
        <?php } ?>
        <td style="text-align: center"><b><?php echo $check ?></b></td>
        <td style="text-align: center;"><?php echo $value['STATS'] ?></td>
         <td style="text-align: center">
          <?php $USER_KET = ($value['USER_KET'] == '') ? '-' : $value['USER_KET']; ?>
          <?php echo $USER_KET ?>
        </td>
        <td style="text-align: center">
          <?php $USER_BY = ($value['USER_BY'] == '') ? '-' : $value['USER_BY']; ?>
          <?php echo $USER_BY ?>
        </td>
        <td style="text-align: center">
          <?php $USER_DATE = ($value['USER_DATE'] == '') ? '-' : $value['USER_DATE']; ?>
          <?php echo $USER_DATE ?>
        </td>
      </tr>
    <?php $no++;} ?>
  </tbody>
</table>
<table border="0" style="width:100%;">
  <tr><td></td></tr>
  <tr><td style="text-align:left;font-size: 10px;"><?php echo date('d M Y '); ?></td></tr>
</table><br>
