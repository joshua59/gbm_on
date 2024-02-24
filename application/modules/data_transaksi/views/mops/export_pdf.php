<table border="0" style="width:100%;">
  <tr>
      <td style="width:10%;text-align:left"><img src="<?php echo base_url();?>assets/img/logo_pln.jpg" height="90" width="75"></td>
      <td style="width:40%;text-align:center"></td>
      <td style="width:10%;text-align:center"><div class="box-kop"><center>Laporan Data MOPS</center></div></td>
      <td style="width:40%;text-align:center"></td>
  </tr>
</table>

<table border="1" style="border-collapse: collapse;width:100%;font-size: 16px;font-family:arial;">
   <thead>
      <tr style="border: 1px solid black;background-color: #CED8F6;">
         <th rowspan="2">NO</th>
         <th rowspan="2">TANGGAL</th>
         <th colspan="2">HSD</th>
         <th colspan="2">MFO HSFO</th>
         <th colspan="2">MFO LSFO</th>
      </tr>
      <tr style="border: 1px solid black;background-color: #CED8F6;">
         <th>LOW</th>
         <th>MID</th>
         <th>LOW</th>
         <th>MID</th>
         <th>LOW</th>
         <th>MID</th>
      </tr>
   </thead>

   <tbody>
      <?php $no = 1; 
      foreach ($data as $value) { ?>
          <tr style="border: 1px solid black">
              <td><?php echo $no++; ?></td>
              <td><?php echo $value['TGL_MOPS'] ?></td>
              <td><?php echo $value['LOWHSD_MOPS'] ?></td>
              <td><?php echo $value['MIDHSD_MOPS'] ?></td>
              <td><?php echo $value['LOWMFO_MOPS'] ?></td>
              <td><?php echo $value['MIDMFO_MOPS'] ?></td>
              <td><?php echo $value['LOWMFOLSFO_MOPS'] ?></td>
              <td><?php echo $value['MIDMFOLSFO_MOPS'] ?></td>
          </tr>
      <?php } ?>
   </tbody>
</table>