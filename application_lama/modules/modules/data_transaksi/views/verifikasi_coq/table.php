<style type="text/css">
	#exampleModal{
    width: 100%;
    left: 0%;
    margin: 0 auto;
  }
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
<table class="display" id="dataTable">
	<thead>
		<tr>
			<th>No</th>
			<th>Report Number</th>
			<th>Tanggal COQ</th>
			<th>Jenis / Komponen BBM</th>
			<th>Pemasok</th>
			<th>Depo</th>
			<th>Shore Tank</th>
			<th>Keterangan<br/></th>
      <th>User<br/>Input</th>
      <th>Tanggal<br/>Input</th>
      <th>Status</th>
      <th>Review</th>
      <th>Keterangan<br/>Review</th>
      <th>User<br/>Review</th>
      <th>Tanggal<br/>Review</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1;
		foreach ($list as $value) { 

      if($value['STATUS_REVIEW'] == 3) {
        $color = "red_dot";
        $check = '-';
        $action = 'onclick="get_data('.$value["ID_TRANS"].',1)"';
      } else if($value['STATUS_REVIEW'] == 4){
        $color = "red_dot";
        $check = '&#10003;';
        $action = 'onclick="get_data('.$value["ID_TRANS"].',1)"';
      }

      $REPORT = $value['NO_REPORT']; ?>
			<tr>
				<td><?php echo $no ?></td>
				<td>
          <a href="#" onclick="get_data(<?php echo $value['ID_TRANS'] ?>,2)"><b><?php echo $value['NO_REPORT'] ?></b></a>
        </td>
				<td style="text-align: center"><?php echo $value['TGL_COQ'] ?></td>
				<td style="text-align: center"><?php echo $value['NAMA_BBM'] ?></td>
				<td style="text-align: center"><?php echo $value['NAMA_PEMASOK'] ?></td>
				<td style="text-align: center"><?php echo $value['NAMA_DEPO'] ?></td>
				<td style="text-align: center"><?php echo $value['SHORE_TANK'] ?></td>
				<td style="text-align: center"><?php echo $value['KET'] ?></td>
        <td style="text-align: center"><?php echo $value['CD_BY'] ?></td>
        <td style="text-align: center"><?php echo $value['CD_DATE'] ?></td>
        <td style="text-align: center">
          <a class="<?php echo $color ?>" href="#" <?php echo $action ?>></a>
        </td>
        <td style="text-align: center"><b><?php echo $check ?></b></a></td>
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
<div id="form-content" class="modal fade modal-xlarge"></div>
        <div class="modal fade modal-md" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>             
              <div class="modal-body">
              <div id="form-detail"></div>  
              </div>  
            </div>
          </div>
        </div>
<form action="<?=base_url()?>data_transaksi/coq/export_pdf" method="POST" id="form-pdf">
</form>

<form action="<?=base_url()?>data_transaksi/coq/export_excel" method="POST" id="form-excel">
</form>
<form action="<?=base_url()?>data_transaksi/coq/export_pdfresult" method="POST" id="form-pdfresult">
</form>

<form action="<?=base_url()?>data_transaksi/coq/export_excelresult" method="POST" id="form-excelresult">
</form>  

<script type="text/javascript">
	$(document).ready(function() {
		$('#dataTable').DataTable({
			bSort:false,
			searching:false
		});
	})

  function get_data(id,status) {
    var vlink_url = '<?php echo base_url()?>data_transaksi/verifikasi_coq/load_trx';
    
    $.ajax({
      url: vlink_url,
      type: "POST",
      data : {
        trx_id : id,
        tipe : status
      },
      beforeSend:function(data) {
        bootbox.modal('<div class="loading-progress"></div>');
      },
      error:function(data) {
        bootbox.hideAll();
        alert('Data Gagal Proses');
      },
      success:function(data) {
        $('#form-detail').html(data);
        $('#exampleModal').modal('show');
        bootbox.hideAll();
      }
    });
  }

</script>