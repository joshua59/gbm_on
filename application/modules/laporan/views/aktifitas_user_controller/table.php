<table id="dataTable" class="display dt-responsive" cellspacing="0" style="max-height:1000px;">
  <thead>
      <tr>
          <th style="width: 5%">No</th>
          <th style="max-width: 12%">Username</th>
          <th style="max-width: 8%">Level User</th> 
          <th style="max-width: 8%">Roles</th>     
          <th style="max-width: 8%">Jumlah Login</th>
          <th style="max-width: 12%">Status User</th>
          <th style="max-width: 10%">Aksi</th>
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
            <td style="text-align: center"><?php echo "<button type='button' class='btn btn-detail' onclick='get_detail((\"".$value['USERNAME']."\"))'>DETAIL</button>"; ?></td>
        </tr>
    <?php $no++;endforeach ?>           
  </tbody>
</table>
<script type="text/javascript">
 $('#dataTable').dataTable({
    "scrollY": "450px",
    "searching": false,
    "scrollX": false,
    "scrollCollapse": false,
    "bPaginate": true,
    "ordering" : false,
    "bLengthChange": false,
    "pageLength" : 100,
    "bFilter": false,
    "bInfo": true,
    "bAutoWidth": false,
    "language": {
        "decimal": ",",
        "thousands": ".",
        "emptyTable": "Tidak ada data untuk ditampilkan",
        "info": "Total Data: _MAX_",
        "infoEmpty": "Total Data: 0",
        "lengthMenu": "Jumlah Data _MENU_"
    }
 });   

function get_detail(id) {
    $.ajax({
        url : "<?php echo base_url('laporan/aktifitas_user_controller/getDetailUser'); ?>",
        type: 'POST',
        data: {
            "username": id
        },
        beforeSend:function(response) {
          bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
        },
        error:function(response) {
          bootbox.hideAll();
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
        },
        success:function(response){
          bootbox.hideAll();
          $('input[name="x_username"]').val(id);
          $('input[name="p_username"]').val(id);
          $('#table_detail').html(response);
          $('#exampleModal').modal('show');
        } 
    })
}
</script>
