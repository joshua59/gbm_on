<table id="dataTable_detail" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
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

<script type="text/javascript">
  $(document).ready(function(){
    var tdetail = $('#dataTable_detail').DataTable({
        "ordering":false,
        "searching":false,
        "bLengthChange": true,
        "bPaginate": true,
        "bFilter": true,
        "bInfo": true,
        "autoWidth": false,
        "lengthMenu": [ 10, 25, 50, 100, 200 ],
        "language": {
            "decimal": ",",
            "thousands": ".",
            "processing": "Memuat...",
            "zeroRecords": "Tidak ada catatan yang cocok ditemukan",
            "emptyTable": "Tidak ada data untuk ditampilkan",
            "info": "Menampilkan _START_ ke _END_ dari _TOTAL_ entri",
            "infoFiltered": "(difilter dari _MAX_ total entri)",
            "infoEmpty": "Total Data: 0",
            "lengthMenu": "Jumlah Data _MENU_"
        }
      });
  })
</script>