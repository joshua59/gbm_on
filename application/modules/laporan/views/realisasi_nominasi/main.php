<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script> -->


<style>
    #exampleModal{
        width: 100%;
        left: 0%;
        margin: 0 auto;
    }
    #exampleModal_jadwal{
        width: 100%;
        left: 0%;
        margin: 0 auto;
    }

    .detail-kosong{
      display: none;
    }
    .dataTables_filter{
     display: none;
    }
    .period-hide{
       display: none;
    }

    tr {
      background-color: #B0C4DE;
    }
    table {
      border-collapse: collapse;
      width:100%;
    }
    .auto{
      width: 100%;
    }

    .dataTables_scrollHeadInner {
      width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
      width: 100% !important;    
    } 
</style>

<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Laporan Penerimaan BBM'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="well-content no-search">
            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
            <div class="form_row">
                <!-- Regional -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                    </div>
                </div>

                <!-- Level 1 -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 1 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                    </div>
                </div>

                <!-- Level 2 -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 2 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
                <!-- Level 3 -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 3 <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                    </div>
                </div>

                <div class="pull-left span3">
                    <label for="password" class="control-label">Pembangkit<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                    </div>
                </div>
                <!-- jenis bahan bakar -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Jenis Bahan Bakar <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('BBM', $opsi_bbm, !empty($default->ID_JENIS_BHN_BKR) ? $default->ID_JENIS_BHN_BKR : '', 'id="bbm"'); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
                <!-- Level 3 -->
                <div class="pull-left span3">
                  <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                  <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                  <div class="controls">
                      <?php $now = strtotime(date('Y-m-d')); $bulan = date('m', $now); ?>
                      <?php echo form_dropdown('BULAN', $opsi_bulan, $bulan, 'style="width: 137px;", id="bln"'); ?>
                      <?php echo form_dropdown('TAHUN', $opsi_tahun, '', 'style="width: 80px;", id="thn"'); ?>
                  </div>

                  <!-- Solusi BUG kotak cari, jika tekan ENTER maka REFRESH -->
                  <div class="controls period-hide">
                        <?php echo form_input('TGL_DARI', !empty($default->TGL_DARI) ? $default->TGL_DARI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                        <label for="">s/d</label>
                        <?php echo form_input('TGL_SAMPAI', !empty($default->TGL_SAMPAI) ? $default->TGL_SAMPAI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                  <!-- <label for="" class="control-label" style="margin-left:1px;">Tampil data</label>
                  <div class="controls">
                    <?php echo form_dropdown('tampilData', array(
                      '-Tampilkan Data-'=> 'Tampilkan Data',
                      '25'              => '25 data',
                      '50'              => '50 data',
                      '100'             => '100 data',
                      '200'             => '200 data'
                    ), '', 'style="margin-left:1px;" id="tampilData"') ?>
                  </div> -->
                </div>
                <div class="pull-left span2">
                    <label for="password" class="control-label">Cari: </label>
                    <div class="controls">
                        <input type="text" id="cariPembangkit" name="" value="" placeholder="Cari Unit">
                    </div>
                </div>
                <div class="pull-left span1">
                    <label></label>
                    <div class="controls">
                    <?php echo anchor(null, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?>
                    </div>
                </div>
            </div>
            <div class="form_row">
              <div class="pull-left span2">

              </div>
              <div class="pull-left span2">

              </div>
              <div class="pull-left span2">

              </div>
                <div class="pull-left span4">
                    <label></label>
                    <div class="controls">
                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                        'class' => 'btn',
                        'id'    => 'button-excel'
                    )); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf'
                    )); ?>
                    </div>
                </div>
            </div>
            <div class="form_row">
                <!-- <div class="pull-left span3">
                    <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                    <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php $now = strtotime(date('Y-m-d')); $bulan = date('m', $now); ?>
                        <?php echo form_dropdown('BULAN', $opsi_bulan, $bulan, 'style="width: 137px;", id="bln"'); ?>
                        <?php echo form_dropdown('TAHUN', $opsi_tahun, '', 'style="width: 80px;", id="thn"'); ?>
                    </div>
                </div> -->
                <div class="pull-left span2">
                    <label></label>
                    <div class="controls">
                        <!-- <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#exampleModal' name="button">TSest</button> -->
                    <?php echo anchor(null, "<i class='icon'></i> Detail", array(
                        'class'       => 'btn green detail-kosong',
                        'id'          => 'button-detail'
                        // 'data-toggle' => 'modal',
                        // 'data-target' => '#exampleModal'
                    )); ?>
                    </div>
                </div>
                <!-- Tampilan modal detail -->
                <div class="pull-left span3">
                    <label></label>
                    <div class="controls">
                    <!-- <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                        'class' => 'btn',
                        'id'    => 'button-excel'
                    )); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf'
                    )); ?> -->
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <br>
        <div class="well-content no-search" id="divTable">
          <table id="dataTable" class="display dt-responsive" width="100%" cellspacing="0" style="max-height:1000px;">
              <thead>
                  <tr>
                      <th rowspan="2">No</th>
                      <th rowspan="2">KODE</th>
                      <th rowspan="2">kodetgl</th>
                      <th rowspan="2">Unit</th>
                      <th rowspan="2">Bulan / Tahun</th>
                      <th colspan="5">Nominasi (L)</th>
                      <th rowspan="2">Total Nominasi (L)</th>
                      <th colspan="4">Terima (L)</th>
                      <th rowspan="2">Total Terima (L)</th>
                      <th rowspan="2">Prosentase</th>
                      <th rowspan="2">AKSI</th>
                  </tr>
                  <tr>
                    <th>HSD</th>
                    <th>MFO</th>
                    <th>BIO</th>
                    <th>HSD+BIO</th>
                    <th>IDO</th>

                    <th>HSD</th>
                    <th>MFO</th>
                    <th>BIO</th>
                    <th>IDO</th>
                  </tr>
              </thead>
              <tbody></tbody>
          </table>
        </div>

        <div id="form-content" class="modal fade modal-xlarge"></div>
        <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div id="div_load">               
                  <div id="div_progress">
                    <div id="div_bar">0%</div>
                  </div>
              </div>              
              <div class="modal-body">
                <div class="pull-right">
                  <input type="text" id="cariDetail" name="cariDetail" value="" placeholder="Cari Unit">
                  <button type="button" class="btn" name="button" id="btnCariDetail">Cari</button>
                  <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                      'class' => 'btn',
                      'id'    => 'button-excel-detail'
                  )); ?>
                  <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                      'class' => 'btn',
                      'id'    => 'button-pdf-detail'
                  )); ?>
                  </div>
                  <!-- <?php echo form_dropdown('tampilData', array(
                    '-Tampilkan Data-'=> 'Tampilkan Data',
                    '25'              => '25 data',
                    '50'              => '50 data',
                    '100'             => '100 data',
                    '200'             => '200 data'
                  ), '', 'style="margin-left:1px;" id="tampilData_detail"') ?> -->
                  <table id="dataTable_detail" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
                    <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">KODE_SLOC</th>
                        <th rowspan="2">kodetgl</th>
                        <th colspan="4">Level</th>
                        <th rowspan="2" style="text-align:center;">Unit Pembangkit</th>
                        <th rowspan="2" style="text-align:center;">Bulan / Tahun</th>
                        <th colspan="5" style="text-align:center;">Nominasi (L)</th>
                        <th rowspan="2" style="text-align:center;">Total Nominasi (L)</th>
                        <th colspan="4" style="text-align:center;">Terima (L)</th>
                        <th rowspan="2" style="text-align:center;">Total Terima (L)</th>
                        <th rowspan="2" style="text-align:center;">Prosentase</th>
                        <th rowspan="2" style="text-align:center;">AKSI</th>
                    </tr>
                    <tr>
                      <th>0</th>
                      <th>1</th>
                      <th>2</th>
                      <th>3</th>
                      <th>HSD</th>
                      <th>MFO</th>
                      <th>BIO</th>
                      <th>HSD+BIO</th>
                      <th>IDO</th>
                      <th>HSD</th>
                      <th>MFO</th>
                      <th>BIO</th>
                      <th>IDO</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <!--  POP UP JADWAL-->
        <div id="form-content" class="modal fade modal-xlarge"></div>
        <div class="modal fade modal-lg" id="exampleModal_jadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div id="div_load2">               
                  <div id="div_progress2">
                    <div id="div_bar2">0%</div>
                  </div>
              </div>              
              <div class="modal-body">
                <div class="pull-right">
                  <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                      'class' => 'btn',
                      'id'    => 'button-excel-jadwal',
                      'style' => 'margin-bottom:25px'
                  )); ?>
                  <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                      'class' => 'btn',
                      'id'    => 'button-pdf-jadwal',
                      'style' => 'margin-bottom:25px'
                  )); ?>
                  </div>
                  <!-- <?php echo form_dropdown('tampilData', array(
                    '-Tampilkan Data-'=> 'Tampilkan Data',
                    '25'              => '25 data',
                    '50'              => '50 data',
                    '100'             => '100 data',
                    '200'             => '200 data'
                  ), '', 'style="margin-left:1px;" id="tampilData_detail"') ?> -->
                  <table id="dataTable_detail_jadwal" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
                    <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th colspan="4" style="text-align:center;">Level</th>
                        <th rowspan="2" style="text-align:center;">Unit</th>
                        <th rowspan="2" style="text-align:center;">Tanggal</th>
                        <!-- <th rowspan="2" style="text-align:center;">No Nominasi</th> -->
                        <th colspan="5" style="text-align:center;">Nominasi (L)</th>
                        <!-- <th rowspan="2" style="text-align:center;">No Mutasi Terima</th> -->
                        <th rowspan="2" style="text-align:center;">Total Nominasi (L)</th>
                        <th colspan="4" style="text-align:center;">Terima (L)</th>
                        <th rowspan="2" style="text-align:center;">Total Terima (L)</th>
                    </tr>
                    <tr>
                      <th>0</th>
                      <th>1</th>
                      <th>2</th>
                      <th>3</th>
                      <th>HSD</th>
                      <th>MFO</th>
                      <th>BIO</th>
                      <th>HSD+BIO</th>
                      <th>IDO</th>
                      <th>HSD</th>
                      <th>MFO</th>
                      <th>BIO</th>
                      <th>IDO</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
<br>

<form id="export_excel" action="<?php echo base_url('laporan/realisasi_nominasi/export_excel'); ?>" method="post">
    <input type="hidden" name="xlvl0">
    <input type="hidden" name="xlvl1">
    <input type="hidden" name="xlvl2">
    <input type="hidden" name="xlvl3">
    <input type="hidden" name="xlvl0_nama">
    <input type="hidden" name="xlvl1_nama">
    <input type="hidden" name="xlvl2_nama">
    <input type="hidden" name="xlvl3_nama">
    <input type="hidden" name="xlvl4">
    <input type="hidden" name="xbbm">
    <input type="hidden" name="xbln">
    <input type="hidden" name="xthn">
    <input type="hidden" name="xlvlid">
    <input type="hidden" name="xlvl">
    <input type="hidden" name="xtglawal">
    <input type="hidden" name="xtglakhir">
    <input type="hidden" name="xcari">

</form>
<input type="hidden" name="halaman_detail" value="1">
<input type="hidden" name="menu_detail" value="">

<form id="export_pdf" action="<?php echo base_url('laporan/realisasi_nominasi/export_pdf'); ?>" method="post"  target="_blank">
    <input type="hidden" name="plvl0">
    <input type="hidden" name="plvl1">
    <input type="hidden" name="plvl2">
    <input type="hidden" name="plvl3">
    <input type="hidden" name="plvl0_nama">
    <input type="hidden" name="plvl1_nama">
    <input type="hidden" name="plvl2_nama">
    <input type="hidden" name="plvl3_nama">
    <input type="hidden" name="plvl4">
    <input type="hidden" name="pbbm">
    <input type="hidden" name="pbln">
    <input type="hidden" name="pthn">

    <input type="hidden" name="plvlid">
    <input type="hidden" name="plvl">
    <input type="hidden" name="ptglawal">
    <input type="hidden" name="ptglakhir">
    <input type="hidden" name="pcari">
</form>

<!-- Tombol Excel dan PDF - Modal DETAIL -->
<form id="export_excel_detail" action="<?php echo base_url('laporan/realisasi_nominasi/export_excel_detail'); ?>" method="post">
    <input type="hidden" name="xlvl0_detail">
    <input type="hidden" name="xlvl1_detail">
    <input type="hidden" name="xlvl2_detail">
    <input type="hidden" name="xlvl3_detail">
    <input type="hidden" name="xlvl0_nama_detail">
    <input type="hidden" name="xlvl1_nama_detail">
    <input type="hidden" name="xlvl2_nama_detail">
    <input type="hidden" name="xlvl3_nama_detail">
    <input type="hidden" name="xlvl4_detail">
    <input type="hidden" name="xbbm_detail">
    <input type="hidden" name="xbln_detail">
    <input type="hidden" name="xthn_detail">
    <input type="hidden" name="xlvlid_detail">
    <input type="hidden" name="xlvl_detail">

    <input type="hidden" name="xtglawal_detail">
    <input type="hidden" name="xtglakhir_detail">
    <input type="hidden" name="xkodeUnit_detail">
    <input type="hidden" name="xidbbm_detail">
</form>

<form id="export_pdf_detail" action="<?php echo base_url('laporan/realisasi_nominasi/export_pdf_detail'); ?>" method="post" target="_blank">
    <input type="hidden" name="plvl0_detail">
    <input type="hidden" name="plvl1_detail">
    <input type="hidden" name="plvl2_detail">
    <input type="hidden" name="plvl3_detail">
    <input type="hidden" name="plvl0_nama_detail">
    <input type="hidden" name="plvl1_nama_detail">
    <input type="hidden" name="plvl2_nama_detail">
    <input type="hidden" name="plvl3_nama_detail">
    <input type="hidden" name="plvl4_detail">
    <input type="hidden" name="pbbm">
    <input type="hidden" name="pbln_detail">
    <input type="hidden" name="pthn">

    <input type="hidden" name="plvlid">
    <input type="hidden" name="plvl">
    <input type="hidden" name="ptglawal">
    <input type="hidden" name="ptglakhir">
    <input type="hidden" name="ptglawal_detail">
    <input type="hidden" name="ptglakhir_detail">
    <input type="hidden" name="pkodeUnit_detail">
    <input type="hidden" name="pidbbm_detail">
</form>
<form id="export_excel_jadwal" action="<?php echo base_url('laporan/realisasi_nominasi/export_excel_jadwal'); ?>" method="post">
    <input type="hidden" name="xlvl0_jadwal">
    <input type="hidden" name="xlvl1_jadwal">
    <input type="hidden" name="xlvl2_jadwal">
    <input type="hidden" name="xlvl3_jadwal">
    <input type="hidden" name="xlvl0_nama_jadwal">
    <input type="hidden" name="xlvl1_nama_jadwal">
    <input type="hidden" name="xlvl2_nama_jadwal">
    <input type="hidden" name="xlvl3_nama_jadwal">
    <input type="hidden" name="xlvl4_jadwal">
    <input type="hidden" name="xbbm_jadwal">
    <input type="hidden" name="xbln_jadwal">
    <input type="hidden" name="xthn_jadwal">
    <input type="hidden" name="xlvlid_jadwal">
    <input type="hidden" name="xlvl_jadwal">
    <input type="hidden" name="xkodeUnit_jadwal">
</form>
<form id="export_pdf_jadwal" action="<?php echo base_url('laporan/realisasi_nominasi/export_pdf_jadwal'); ?>" method="post" target="_blank">
    <input type="hidden" name="plvl0_jadwal">
    <input type="hidden" name="plvl1_jadwal">
    <input type="hidden" name="plvl2_jadwal">
    <input type="hidden" name="plvl3_jadwal">
    <input type="hidden" name="plvl0_nama_jadwal">
    <input type="hidden" name="plvl1_nama_jadwal">
    <input type="hidden" name="plvl2_nama_jadwal">
    <input type="hidden" name="plvl3_nama_jadwal">
    <input type="hidden" name="plvl4_jadwal">
    <input type="hidden" name="pbbm_jadwal">
    <input type="hidden" name="pbln_jadwal">
    <input type="hidden" name="pthn_jadwal">
    <input type="hidden" name="plvlid_jadwal">
    <input type="hidden" name="plvl_jadwal">
    <input type="hidden" name="pkodeUnit_jadwal">
</form>
<script type="text/javascript">
    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);

    $(document).ready(function() {
      $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

   function setCekTgl(){
        var dateStart = $('#tglawal').val();
        var dateEnd = $('#tglakhir').val();

        if (dateEnd < dateStart){
            $('#tglakhir').datepicker('update', dateStart);
        }

    }


  $('#tglawal').on('change', function() {
        var dateStart = $(this).val();
        $('#tglakhir').datepicker('setStartDate', dateStart);
        if ($('#tglakhir').val() == '') {

        }else{
          setCekTgl();
        }
    });

  $('#tglakhir').on('change', function() {
        setCekTgl();
  });

  $('#button-detail').addClass('disabled');
        // $("#button-detail").attr("disabled", true);
  });
    var today = new Date();
    var year = today.getFullYear();

    $('select[name="TAHUN"]').val(year);

    function convertToRupiah(angka){
        var bilangan = angka.replace(".", ",");

        var number_string = bilangan.toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{1,3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

        return rupiah;
    }

    // $(document).on('shown.bs.modal', function (e) {
    //     $.fn.dataTable.tables( {visible: true, api: true} ).columns.adjust();
    // });
    $(document).ready(function() {

      $('#dataTable').dataTable({
          "scrollY": "450px",
          "searching": false,
          "scrollX": true,
          "scrollCollapse": false,
          "bPaginate": true,

          // show display records datatable
          "bLengthChange": true,
          "pageLength" : 10,
          "bFilter": true,
          "bInfo": true,
          "bAutoWidth": true,
          "ordering": true,
          "fixedHeader": true,
          // "fixedColumns": {"rightColumns": 2},
          "language": {
              "decimal": ",",
              "thousands": ".",
              "emptyTable": "Tidak ada data untuk ditampilkan",
              "info": "Total Data: _MAX_",
              "infoEmpty": "Total Data: 0",
              "lengthMenu": "Jumlah Data _MENU_"
          },
          "columnDefs": [
            {
              "orderable" : false,
              "targets" : [-1]
            },
            {
                "targets" : [1,2],
                "visible" : false
            },
            {
              "className" : "dt-center",
              "targets" : ['_all']
            },
              {
                  "targets": -1,
                  "data": null,
                  "defaultContent": "<button class='btn btn-primary bdet'>DETAIL</button>"
              }
          ]
      });


    } );

    function tampilData_default()
    {
      $('#tampilData').val('-Tampilkan Data-');
      $('#tampilData_detail').val('-Tampilkan Data-');
    }

    function redraw(data)
    {
      clearDT_Detail();
      var tdetail = $('#dataTable_detail').DataTable();
      var detail_parser = JSON.parse(data);
      var nomer = 1;

      $.each(detail_parser, function(index, el) {
          var NOMOR = el.NOMOR == null ? "" : el.NOMOR;
          var level0 = el.LEVEL0 == null ? "" : el.LEVEL0;
          var level1 = el.LEVEL1 == null ? "" : el.LEVEL1;
          var level2 = el.LEVEL2 == null ? "" : el.LEVEL2;
          var level3 = el.LEVEL3 == null ? "" : el.LEVEL3;
          var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
          var BHN_BAKAR = el.NAMA_JNS_BHN_BKR == null ? "" : el.NAMA_JNS_BHN_BKR;
          // var JENIS_PENERIMAAN = el.JENIS_PENERIMAAN == null ? "" : el.JENIS_PENERIMAAN;
          var NOMER_PENERIMAAN = el.NO_PENERIMAAN == null ? "" : el.NO_PENERIMAAN;
          var NAMA_PEMASOK = el.NAMA_PEMASOK == null ? "" : el.NAMA_PEMASOK;
          var NAMA_TRANSPORTIR = el.NAMA_TRANSPORTIR == null ? "" : el.NAMA_TRANSPORTIR;
          var TGL_DO = el.TGL_DO == null ? "" : el.TGL_DO;
          var TGL_TERIMA_FISIK = el.TGL_TERIMA_FISIK == null ? "" : el.TGL_TERIMA_FISIK;
          var VOL_DO = el.VOL_DO == null ? "" : el.VOL_DO;
          var TERIMA_REAL = el.VOL_TERIMA_REAL == null ? "" : el.VOL_TERIMA_REAL;
          
          // var DEVIASI = el.DEVIASI == null ? "" : el.DEVIASI;
          // var DEVIASI_PERCENT = el.DEVIASI_PERCENT == null ? "" : el.DEVIASI_PERCENT;

          tdetail.row.add( [
              NOMOR, level0, level1, level2, level3, UNIT_PEMBANGKIT, BHN_BAKAR,
              NOMER_PENERIMAAN,
              NAMA_PEMASOK, NAMA_TRANSPORTIR, TGL_DO,
              TGL_TERIMA_FISIK, convertToRupiah(VOL_DO),
              convertToRupiah(TERIMA_REAL)
          ] ).draw( false );
          nomer++;
      });
    }


    $('select[name="dataTable_detail_length"]').on('change', function(){
      $('input[name="menu_detail"]').val(this.value);
    });

    function clearCari()
    {
      $('#cariDetail').val('');
    }

    $('#dataTable tbody').on( 'click', 'button', function () {
      tampilData_default();
      clearDT_Detail();
      clearCari();
      bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
        var t = $('#dataTable').DataTable();
        var tr = $(this).parents('tr');
        var selected_row= t.row(tr).data();
        var bln = $('#bln').val(); //bulan dropdown
        var thn = $('#thn').val(); //tahun dropdown
        var kode_unit = selected_row[1];
        var table_bulan = selected_row[2];
        var jumlah_terima = selected_row[7];
        var id_bbm = selected_row[3];
        
        $('input[name="xkodeUnit_detail"]').val(kode_unit);
        $('input[name="xbln_detail"]').val(table_bulan);
        $('input[name="xthn"]').val(table_bulan.substring(2,7));
        $('input[name="xidbbm_detail"]').val(id_bbm);
        $('input[name="pkodeUnit_detail"]').val(kode_unit);
        $('input[name="pbln_detail"]').val(table_bulan);
        $('input[name="pidbbm_detail"]').val(id_bbm);
        var tdetail = $('#dataTable_detail').DataTable({

          "pageLength": 10,
          "destroy" : true,
          "responsive": true,
          "bLengthChange": true,
          "scrollY": "450px",
          "scrollX": true,
          "scrollCollapse": false,
          "bPaginate": true,
          "bFilter": true,
          "bInfo": true,
          "autoWidth": true,
          "lengthMenu": [ 10, 25, 50, 100, 200 ],
          "ordering": true,
          "language": {
              "decimal": ",",
              "thousands": ".",
              "processing": "Memuat...",
              "zeroRecords": "Tidak ada catatan yang cocok ditemukan",
              "emptyTable": "Tidak ada data untuk ditampilkan",
              "info": "Total Data: _MAX_",
              "infoEmpty": "Total Data: 0",
              "lengthMenu": "Jumlah Data _MENU_"
          },
          "columnDefs": [
            {
                "targets" : [1,2],
                "visible" : false
            },
            {
              "searchable":false,
              "targets":[0,8,9,10,11,12,13,14,15,16],
            },
               {
                   "className": "dt-left",
                   "targets": [1,2,3,4,5]
               },
               {
                 "className": "dt-center",
                 "targets": [0,6]
               },
               {
                   "className": "dt-right",
                   "targets": [-1,-2,-3,-4,-5,-6,-7,-8,-9,-10]
               },
               {
                   "targets": -1,
                   "data": null,
                   "defaultContent": "<button class='btn btn-primary bdet'>Jadwal</button>"
               }
             ]
        });

        $.ajax({
            url : "<?php echo base_url('laporan/realisasi_nominasi/getDetilNominasi'); ?>",
            type: 'POST',
            data: {
              'kodeunit':kode_unit,
              'table_bulan':table_bulan
            },
            error:function(data) {
              bootbox.hideAll();
              bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Data tidak dapat diproses ! </div>', function() {});
            },
            success:function(data) {
              // bootbox.hideAll();
              var detail_parser = JSON.parse(data);
              var nomer = 1;
              var total = detail_parser.length;
              var progres = 0;            
              var elem = document.getElementById("div_bar");

              $.each(detail_parser, function(index, el) {
                setTimeout( function(){
                  var KODE = el.KODE == null ? "" : el.KODE;
                  var level0 = el.LEVEL0 == null ? "" : el.LEVEL0;
                  var level1 = el.LEVEL1 == null ? "" : el.LEVEL1;
                  var level2 = el.LEVEL2 == null ? "" : el.LEVEL2;
                  var level3 = el.LEVEL3 == null ? "" : el.LEVEL3;
                  var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
                  var BLTH = el.BLTH == null ? "" : el.BLTH;
                  var BLTH_asli = el.BLTH == null ? "" : el.BLTH;
                  BLTH = parseMYToString(BLTH);
                  var N_MFO = el.NOMINASI_MFO == null ? "" : el.NOMINASI_MFO;
                  var N_HSD = el.NOMINASI_HSD == null ? "" : el.NOMINASI_HSD;
                  var N_BIO = el.NOMINASI_BIO == null ? "" : el.NOMINASI_BIO;
                  var N_HSD_BIO = el.NOMINASI_HSD_BIO == null ? "" : el.NOMINASI_HSD_BIO;
                  var N_IDO = el.NOMINASI_IDO == null ? "" : el.NOMINASI_IDO;

                  var TOTAL_NOMINASI = el.TOTAL_NOMINASI == null ? "" : el.TOTAL_NOMINASI;
                  var TERIMA_MFO = el.TERIMA_MFO == null ? "" : el.TERIMA_MFO;
                  var TERIMA_IDO = el.TERIMA_IDO == null ? "" : el.TERIMA_IDO;
                  var TERIMA_BIO = el.TERIMA_BIO == null ? "" : el.TERIMA_BIO;
                  var TERIMA_HSD = el.TERIMA_HSD == null ? "" : el.TERIMA_HSD;
                  var TOTAL_TERIMA = el.TOTAL_TERIMA == null ? "" : el.TOTAL_TERIMA;
                  var persen = el.PERSENTASE == null ? "-" : el.PERSENTASE+'%';

                  tdetail.row.add( [
                      nomer, KODE, BLTH_asli, level0, level1, level2, level3, UNIT_PEMBANGKIT, BLTH,
                      convertToRupiah(N_HSD), convertToRupiah(N_MFO), convertToRupiah(N_BIO),
                      convertToRupiah(N_HSD_BIO),convertToRupiah(N_IDO),
                      convertToRupiah(TOTAL_NOMINASI),
                      convertToRupiah(TERIMA_HSD),convertToRupiah(TERIMA_MFO), convertToRupiah(TERIMA_BIO),convertToRupiah(TERIMA_IDO),
                      convertToRupiah(TOTAL_TERIMA), persen
                  ] ).draw( false );

                  if (nomer==1){
                      bootbox.hideAll();
                      $('#div_load').show();
                      bootbox.dialog('<div class="loading-progress"></div>');                    
                  }

                  progres = Math.ceil((nomer/total)*100);
                  elem.style.width = progres + '%';
                  elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';

                  if (nomer>=total){
                      bootbox.hideAll();
                      $('#div_load').hide('slow');                                       
                  }
                  nomer++;
                  
                }, 0 );   
              });

              $('#exampleModal').modal('show');
            }
        })

    });

    // DATATABLE JADWAL MODAL
    $('#dataTable_detail tbody').on( 'click', 'button', function () {
      clearDT_Jadwal();
      bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
        var tj = $('#dataTable_detail').DataTable();
        var selected_row= tj.row($(this).parents('tr')).data();
        var bln = $('#bln').val(); //bulan dropdown
        var thn = $('#thn').val(); //tahun dropdown
        var kode_sloc = selected_row[1];
        var table_bulan = selected_row[2];

        $('input[name="xbln_jadwal"]').val(table_bulan);
        $('input[name="xkodeUnit_jadwal"]').val(kode_sloc);
        $('input[name="pbln_jadwal"]').val(table_bulan);
        $('input[name="pkodeUnit_jadwal"]').val(kode_sloc);

        var tdetail_jadwal = $('#dataTable_detail_jadwal').DataTable({
          "pageLength": 30,
          "destroy" : true,
          "responsive": true,
          "bLengthChange": false,
          "scrollY": "450px",
          "scrollX": true,
          "scrollCollapse": false,
          "bPaginate": true,
          "bFilter": true,
          "bInfo": true,
          "autoWidth": true,
          "ordering": false,
          "language": {
              "decimal": ",",
              "thousands": ".",
              "processing": "Memuat...",
              "zeroRecords": "Tidak ada catatan yang cocok ditemukan",
              "emptyTable": "Tidak ada data untuk ditampilkan",
              "info": "Total Data: _MAX_",
              "infoEmpty": "Total Data: 0",
              "lengthMenu": "Jumlah Data _MENU_"
          },
          "columnDefs": [
               {
                   "className": "dt-left",
                   "targets": [1,2,3,4,5]
               },
               {
                 "className": "dt-center",
                 "targets": [0,6]
               },
               {
                   "className": "dt-right",
                   "targets": [-1,-3,-4,-5,-6,-7,-8,-9,-10,-10,-11]
               }
             ]
        });

        $.ajax({
            url : "<?php echo base_url('laporan/realisasi_nominasi/getJadwal'); ?>",
            type: 'POST',
            data: {
              'table_bulan':table_bulan,
              'kode_sloc':kode_sloc
            },
            error:function(data) {
              bootbox.hideAll();
              bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Data tidak dapat diproses ! </div>', function() {});
            },
            success:function(data) {
              // bootbox.hideAll();
              var detail_parser = JSON.parse(data);
              var nomer = 1;
              var total = detail_parser.length;
              var progres = 0;            
              var elem = document.getElementById("div_bar2");

              $.each(detail_parser, function(index, el) {
                setTimeout( function(){
                  var level0 = el.LEVEL0 == null ? "" : el.LEVEL0;
                  var level1 = el.LEVEL1 == null ? "" : el.LEVEL1;
                  var level2 = el.LEVEL2 == null ? "" : el.LEVEL2;
                  var level3 = el.LEVEL3 == null ? "" : el.LEVEL3;
                  var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
                  var TGL = el.TGL == null ? "" : el.TGL;
                  var NO_MUTASI_TERIMA = el.NO_MUTASI_TERIMA == null ? "" : el.NO_MUTASI_TERIMA;

                  var NOMINASI_HSD = el.NOMINASI_HSD == "0.00" ? "-" : el.NOMINASI_HSD;
                  var NOMINASI_MFO = el.NOMINASI_MFO == "0.00" ? "-" : el.NOMINASI_MFO;
                  var NOMINASI_BIO = el.NOMINASI_BIO == "0.00" ? "-" : el.NOMINASI_BIO;
                  var NOMINASI_HSD_BIO = el.NOMINASI_HSD_BIO == "0.00" ? "-" : el.NOMINASI_HSD_BIO;
                  var NOMINASI_IDO = el.NOMINASI_IDO == "0.00" ? "-" : el.NOMINASI_IDO;
                  var TOTAL_NOMINASI = el.TOTAL_NOMINASI == "0.00" ? "-" : el.TOTAL_NOMINASI;

                  var NO_NOMINASI = el.NO_NOMINASI == null ? "" : el.NO_NOMINASI;

                  var TERIMA_HSD = el.TERIMA_HSD == "0.00" ? "-" : el.TERIMA_HSD;
                  var TERIMA_MFO = el.TERIMA_MFO == "0.00" ? "-" : el.TERIMA_MFO;
                  var TERIMA_BIO = el.TERIMA_BIO == "0.00" ? "-" : el.TERIMA_BIO;
                  var TERIMA_IDO = el.TERIMA_IDO == "0.00" ? "-" : el.TERIMA_IDO;
                  var TOTAL_TERIMA = el.TOTAL_TERIMA == "0.00" ? "-" : el.TOTAL_TERIMA;

                  tdetail_jadwal.row.add( [
                      nomer, level0, level1, level2, level3, UNIT_PEMBANGKIT, TGL,
                      // NO_NOMINASI,
                      convertToRupiah(NOMINASI_HSD), convertToRupiah(NOMINASI_MFO), convertToRupiah(NOMINASI_BIO),
                      convertToRupiah(NOMINASI_HSD_BIO),convertToRupiah(NOMINASI_IDO),convertToRupiah(TOTAL_NOMINASI),
                      // NO_MUTASI_TERIMA,
                      convertToRupiah(TERIMA_HSD),convertToRupiah(TERIMA_MFO), convertToRupiah(TERIMA_BIO),
                      convertToRupiah(TERIMA_IDO),convertToRupiah(TOTAL_TERIMA)
                  ] ).draw( false );

                  if (nomer==1){
                      bootbox.hideAll();
                      $('#div_load2').show();
                      bootbox.dialog('<div class="loading-progress"></div>');                    
                  }

                  progres = Math.ceil((nomer/total)*100);
                  elem.style.width = progres + '%';
                  elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';

                  if (nomer>=total){
                      bootbox.hideAll();
                      $('#div_load2').hide('slow');                                       
                  }
                  nomer++;
                  
                }, 0 );   
              });
              $('#exampleModal_jadwal').modal('show');
            }
        })
    });

    $('#btnCariDetail').on('click', function () {
      var cariDetail = $('#cariDetail').val();
      var table = $('#dataTable_detail').DataTable();
      table.search( cariDetail ,false,true,true).draw();
    });
    
    $('#cariDetail').keyup(function(e){
      if(e.keyCode == 13)
      {
        $('#btnCariDetail').click();
      }
    });

    $('#cariPembangkit').keyup(function(e){
      if(e.keyCode == 13)
      {
        $('#button-load').click();
      }
    });

    $('#button-load').click(function(e) {
        // $(".bdet").attr("disabled", true);
        var lvl0 = $('#lvl0').val(); //Regional dropdown
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown
        var bbm = $('#bbm').val(); //bahanBakar dropdown
        var bln = $('#bln').val(); //bulan dropdown
        var thn = $('#thn').val(); //tahun dropdown
        var cari = $('#cariPembangkit').val();

        if (lvl0=='') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else if(bln == ''){
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH BULAN-- </div>', function() {});
        }else {
            if (lvl0 !== "") {
                lvl0 = 'Regional';
                vlevelid = $('#lvl0').val();
                if (vlevelid == "00") {
                    lvl0 = "Pusat";
                }
            }
            if (lvl1 !== "") {
                lvl0 = 'Level 1';
                vlevelid = $('#lvl1').val();
            }
            if (lvl2 !== "") {
                lvl0 = 'Level 2';
                vlevelid = $('#lvl2').val();
            }
            if (lvl3 !== ""){
                lvl0 = 'Level 3';
                vlevelid = $('#lvl3').val();
            }
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }
            if (bbm !== "") {
                bbm = $('#bbm').val();
                if (bbm =='001') {
                    bbm = 'MFO';
                }else if(bbm == '002'){
                    bbm = 'IDO';
                }else if(bbm == '003'){
                    bbm = 'BIO';
                }else if(bbm == '004'){
                    bbm = 'HSD+BIO';
                }else if(bbm == '005'){
                    bbm = 'HSD';
                }
            }
            if (bbm == '') {
                bbm = '-';
            }

            var parserTanggal = [
              "01","02","03","04","05","06","07","08","09","10","11","12"
            ];
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url : "<?php echo base_url('laporan/realisasi_nominasi/getRekap'); ?>",
                    data: {
                        "ID_REGIONAL": lvl0,
                        "VLEVELID":vlevelid,
                        "BULAN": parserTanggal[bln-1],
                        "TAHUN":thn,
                        'cari': cari

                    },
                    success:function(response) {
                      var obj = JSON.parse(response);
                      var t = $('#dataTable').DataTable();
                      t.clear().draw();

                      if (obj == "" || obj == null) {
                          bootbox.hideAll();
                          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                      } else {

                       var nomer = 1;
                       $.each(obj, function (index, value) {
                          var UNIT = value.UNIT == null ? "" : value.UNIT;
                          var KODE = value.UNIT == null ? "" : value.KODE;
                          var BLTH = value.BLTH == null ? "" : value.BLTH;
                          var BLTH_asli = value.BLTH == null ? "" : value.BLTH;
                          BLTH = parseMYToString(BLTH);
                          var NOMINASI_HSD = value.NOMINASI_HSD == null ? "" : value.NOMINASI_HSD;
                          var NOMINASI_MFO = value.NOMINASI_MFO == null ? "" : value.NOMINASI_MFO;
                          var NOMINASI_BIO = value.NOMINASI_BIO == null ? "" : value.NOMINASI_BIO;
                          var NOMINASI_HSD_BIO = value.NOMINASI_HSD_BIO == null ? "" : value.NOMINASI_HSD_BIO;
                          var NOMINASI_IDO = value.NOMINASI_IDO == null ? "" : value.NOMINASI_IDO;

                          var TOTAL_NOMINASI = value.TOTAL_NOMINASI == null ? "" : value.TOTAL_NOMINASI;
                          var TERIMA_HSD = value.TERIMA_HSD == null ? "" : value.TERIMA_HSD;
                          var TERIMA_MFO = value.TERIMA_MFO == null ? "" : value.TERIMA_MFO;
                          var TERIMA_BIO = value.TERIMA_BIO == null ? "" : value.TERIMA_BIO;
                          var TERIMA_HSD_BIO = value.TERIMA_HSD_BIO == null ? "" : value.TERIMA_HSD_BIO;
                          var TERIMA_IDO = value.TERIMA_IDO == null ? "" : value.TERIMA_IDO;
                          var persen = value.PERSENTASE == null ? "-" : value.PERSENTASE+'%';

                          var TOTAL_TERIMA = value.TOTAL_TERIMA == null ? "" : value.TOTAL_TERIMA;
                          t.row.add( [
                              nomer,  KODE,BLTH_asli,UNIT, BLTH,
                              convertToRupiah(NOMINASI_HSD), convertToRupiah(NOMINASI_MFO), convertToRupiah(NOMINASI_BIO),
                              convertToRupiah(NOMINASI_HSD_BIO), convertToRupiah(NOMINASI_IDO),
                              convertToRupiah(TOTAL_NOMINASI),
                              convertToRupiah(TERIMA_HSD), convertToRupiah(TERIMA_MFO), convertToRupiah(TERIMA_BIO),convertToRupiah(TERIMA_IDO),
                              convertToRupiah(TOTAL_TERIMA), persen
                          ] ).draw(false);
                          nomer++;
                        });
                        bootbox.hideAll();
                        $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                        };
                    }
                });
        };
    });
    /**
     * check is numeric or not
     */
    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function parseMYToString(bulantahun)
        {
          var bulan = bulantahun.substring(0,2);
          var tahun = bulantahun.substring(2,7);
          var b;
          if (bulan == "01") {
            b = "Januari";
          }
          if (bulan == "02") {
            b = "Februari";
          }
          if (bulan == "03") {
            b = "Maret";
          }
          if (bulan == "04") {
            b = "April";
          }
          if (bulan == "05") {
            b = "Mei";
          }
          if (bulan == "06") {
            b = "Juni";
          }
          if (bulan == "07") {
            b = "Juli";
          }
          if (bulan == "08") {
            b = "Agustus";
          }
          if (bulan == "09") {
            b = "September";
          }
          if (bulan == "10") {
            b = "Oktober";
          }
          if (bulan == "11") {
            b = "November";
          }
          if (bulan == "12") {
            b = "Desember";
          }
          return b+" "+tahun;
        }
    $('#cariPembangkit').on( 'keyup', function () {
      var table = $('#dataTable').DataTable();
        table.search( this.value ).draw();
    });

    //Untuk button tampilkan data
    $('#tampilData').on('change', function () {
      oTable = $('#dataTable').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = this.value;
      oTable.fnDraw();
    });

    $('#tampilData_detail').on('change', function () {
      oTable = $('#dataTable_detail').dataTable();
      var oSettings = oTable.fnSettings();
      oSettings._iDisplayLength = this.value;
      oTable.fnDraw();
    });
    //when datatable detailButton clicked
    function clearDT_Detail()
    {
        var t = $('#dataTable_detail').DataTable();
        $('#dataTable_detail').addClass('auto');
        t.clear().draw();
    }
    function clearDT_Jadwal()
    {
      var t = $('#dataTable_detail_jadwal').DataTable();
      $('#dataTable_detail_jadwal').addClass('auto');
      t.clear().draw();
    }


    $('#button-excel').click(function(e) {
      var lvl0 = $('#lvl0').val(); //Regional dropdown
      var lvl1 = $('#lvl1').val(); //level1 dropdown
      var lvl2 = $('#lvl2').val(); //level2 dropdown
      var lvl3 = $('#lvl3').val(); //level3 dropdown
      var lvl4 = $('#lvl4').val(); //pembangkit dropdown
      var bbm = $('#bbm').val(); //bahanBakar dropdown

      var bln = $('#bln').val(); //bulan dropdown
      var thn = $('#thn').val(); //tahun dropdown
      var  cari = $('#cariPembangkit').val();
      var parserTanggal = [
        "01","02","03","04","05","06","07","08","09","10","11","12"
      ];

      $('input[name="xbln"]').val(parserTanggal[bln-1]);
      $('input[name="xthn"]').val(thn); // 001
      $('input[name="xcari"]').val(cari); // 001
        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else if(bln == '')
        {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH BULAN-- </div>', function() {});
        }else {
          if (lvl0 !== "") {
              lvl0 = 'Regional';
              vlevelid = $('#lvl0').val();
              if (vlevelid == "00") {
                  lvl0 = "Pusat";
              }
          }
          if (lvl1 !== "") {
              lvl0 = 'Level 1';
              vlevelid = $('#lvl1').val();
          }
          if (lvl2 !== "") {
              lvl0 = 'Level 2';
              vlevelid = $('#lvl2').val();
          }
          if (lvl3 !== ""){
              lvl0 = 'Level 3';
              vlevelid = $('#lvl3').val();
          }
          if (lvl4 !== "") {
              lvl0 = 'Level 4';
              vlevelid = $('#lvl4').val();
          }
          if (bbm !== "") {
              bbm = $('#bbm').val();
              if (bbm =='001') {
                  bbm = 'MFO';
              }else if(bbm == '002'){
                  bbm = 'IDO';
              }else if(bbm == '003'){
                  bbm = 'BIO';
              }else if(bbm == '004'){
                  bbm = 'HSD+BIO';
              }else if(bbm == '005'){
                  bbm = 'HSD';
              }
          }
          if (bbm == '') {
              bbm = '-';
          }

          $('input[name="xlvl0"]').val($('#lvl0').val());
          $('input[name="xlvl1"]').val($('#lvl1').val());
          $('input[name="xlvl2"]').val($('#lvl2').val());
          $('input[name="xlvl3"]').val($('#lvl3').val());

          $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
          $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
          $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
          $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

          $('input[name="xlvl4"]').val($('#lvl4').val());  // 183130
          $('input[name="xbbm"]').val(bbm); // 001

          $('input[name="xlvlid"]').val(vlevelid);
          $('input[name="xlvl"]').val(lvl0);

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_excel').submit();
                }
            });
        }
    });

    $('#button-pdf').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown
        var bbm = $('#bbm').val(); //bahanBakar dropdown
        var cari = $('#cariPembangkit').val();

        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
          if (lvl0 !== "") {
              lvl0 = 'Regional';
              vlevelid = $('#lvl0').val();
              if (vlevelid == "00") {
                  lvl0 = "Pusat";
              }
          }
          if (lvl1 !== "") {
              lvl0 = 'Level 1';
              vlevelid = $('#lvl1').val();
          }
          if (lvl2 !== "") {
              lvl0 = 'Level 2';
              vlevelid = $('#lvl2').val();
          }
          if (lvl3 !== ""){
              lvl0 = 'Level 3';
              vlevelid = $('#lvl3').val();
          }
          if (lvl4 !== "") {
              lvl0 = 'Level 4';
              vlevelid = $('#lvl4').val();
          }
          if (bbm !== "") {
              bbm = $('#bbm').val();
              if (bbm =='001') {
                  bbm = 'MFO';
              }else if(bbm == '002'){
                  bbm = 'IDO';
              }else if(bbm == '003'){
                  bbm = 'BIO';
              }else if(bbm == '004'){
                  bbm = 'HSD+BIO';
              }else if(bbm == '005'){
                  bbm = 'HSD';
              }
          }
          if (bbm == '') {
              bbm = '-';
          }

            $('input[name="plvl0"]').val($('#lvl0').val());
            $('input[name="plvl1"]').val($('#lvl1').val());
            $('input[name="plvl2"]').val($('#lvl2').val());
            $('input[name="plvl3"]').val($('#lvl3').val());

            $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

            $('input[name="plvl4"]').val($('#lvl4').val());
            $('input[name="pbbm"]').val(bbm);
            $('input[name="pcari"]').val(cari);
            // $('input[name="pbln"]').val($('#bln').val());
            // $('input[name="pthn"]').val($('#thn').val());

            $('input[name="plvlid"]').val(vlevelid);
            $('input[name="plvl"]').val(lvl0);
            // var tglAwal = $('#tglawal').val().replace(/-/g, '');
            // var tglAkhir = $('#tglakhir').val().replace(/-/g, '');
            //
            // var awal_tahun = tglAwal.substring(0,4);
            // var awal_bulan = tglAwal.substring(4,6);
            // var awal_hari = tglAwal.substring(6,8);
            // var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);
            //
            // var akhir_tahun = tglAkhir.substring(0,4);
            // var akhir_bulan = tglAkhir.substring(4,6);
            // var akhir_hari = tglAkhir.substring(6,8);
            // var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);
            //
            // if (tglAwal == '' && tglAkhir == '') {
            //   awalParsed = "-";
            //   akhirParsed = '-';
            //   $('input[name="ptglawal"]').val(awalParsed);
            //   $('input[name="ptglakhir"]').val(akhirParsed);
            // }else{
            //   $('input[name="ptglawal"]').val(awalParsed);
            //   $('input[name="ptglakhir"]').val(akhirParsed);
            // }
            var bln = $('#bln').val(); //bulan dropdown
            var thn = $('#thn').val(); //tahun dropdown
            var  cari = $('#cariPembangkit').val();
            var parserTanggal = [
              "01","02","03","04","05","06","07","08","09","10","11","12"
            ];

            $('input[name="pbln"]').val(parserTanggal[bln-1]);
            $('input[name="pthn"]').val(thn); // 001
            bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_pdf').submit();
                }
            });
        }
    });

    // Button excel dan pdf di modal
    $('#button-excel-detail').click(function(e) {
      var lvl0 = $('#lvl0').val(); //Regional dropdown
      var lvl1 = $('#lvl1').val(); //level1 dropdown
      var lvl2 = $('#lvl2').val(); //level2 dropdown
      var lvl3 = $('#lvl3').val(); //level3 dropdown
      var lvl4 = $('#lvl4').val(); //pembangkit dropdown
      var bbm = $('#bbm').val(); //bahanBakar dropdown
      var bln = $('#bln').val(); //bulan dropdown
      var thn = $('#thn').val(); //tahun dropdown

        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
          if (lvl0 !== "") {
              lvl0 = 'Regional';
              vlevelid = $('#lvl0').val();
              if (vlevelid == "00") {
                  lvl0 = "Pusat";
              }
          }
          if (lvl1 !== "") {
              lvl0 = 'Level 1';
              vlevelid = $('#lvl1').val();
          }
          if (lvl2 !== "") {
              lvl0 = 'Level 2';
              vlevelid = $('#lvl2').val();
          }
          if (lvl3 !== ""){
              lvl0 = 'Level 3';
              vlevelid = $('#lvl3').val();
          }
          if (lvl4 !== "") {
              lvl0 = 'Level 4';
              vlevelid = $('#lvl4').val();
          }
          if (bbm !== "") {
              bbm = $('#bbm').val();
              if (bbm =='001') {
                  bbm = 'MFO';
              }else if(bbm == '002'){
                  bbm = 'IDO';
              }else if(bbm == '003'){
                  bbm = 'BIO';
              }else if(bbm == '004'){
                  bbm = 'HSD+BIO';
              }else if(bbm == '005'){
                  bbm = 'HSD';
              }
          }
          if (bbm == '') {
              bbm = '-';
          }

          $('input[name="xlvl0_detail"]').val($('#lvl0').val()); // 01
          $('input[name="xlvl1_detail"]').val($('#lvl1').val()); //COCODE
          $('input[name="xlvl2_detail"]').val($('#lvl2').val());
          $('input[name="xlvl3_detail"]').val($('#lvl3').val());
          $('input[name="xlvl0_nama_detail"]').val($('#lvl0 option:selected').text()); // SUMATERA
          $('input[name="xlvl1_nama_detail"]').val($('#lvl1 option:selected').text());
          $('input[name="xlvl2_nama_detail"]').val($('#lvl2 option:selected').text());
          $('input[name="xlvl3_nama_detail"]').val($('#lvl3 option:selected').text());
          $('input[name="xlvl4"]').val($('#lvl4').val());  // 183130
          $('input[name="xlvl_detail"]').val(vlevelid);

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_excel_detail').submit();
                }
            });
        }
    });
    $('#button-pdf-detail').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown
        var bbm = $('#bbm').val(); //bahanBakar dropdown

        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else {
          if (lvl0 !== "") {
              lvl0 = 'Regional';
              vlevelid = $('#lvl0').val();
              if (vlevelid == "00") {
                  lvl0 = "Pusat";
              }
          }
          if (lvl1 !== "") {
              lvl0 = 'Level 1';
              vlevelid = $('#lvl1').val();
          }
          if (lvl2 !== "") {
              lvl0 = 'Level 2';
              vlevelid = $('#lvl2').val();
          }
          if (lvl3 !== ""){
              lvl0 = 'Level 3';
              vlevelid = $('#lvl3').val();
          }
          if (lvl4 !== "") {
              lvl0 = 'Level 4';
              vlevelid = $('#lvl4').val();
          }
          if (bbm !== "") {
              bbm = $('#bbm').val();
              if (bbm =='001') {
                  bbm = 'MFO';
              }else if(bbm == '002'){
                  bbm = 'IDO';
              }else if(bbm == '003'){
                  bbm = 'BIO';
              }else if(bbm == '004'){
                  bbm = 'HSD+BIO';
              }else if(bbm == '005'){
                  bbm = 'HSD';
              }
          }
          if (bbm == '') {
              bbm = '-';
          }

            $('input[name="plvl0_detail"]').val($('#lvl0').val());
            $('input[name="plvl1_detail"]').val($('#lvl1').val());
            $('input[name="plvl2_detail"]').val($('#lvl2').val());
            $('input[name="plvl3_detail"]').val($('#lvl3').val());
            $('input[name="plvl4_detail"]').val($('#lvl4').val());
            $('input[name="plvl0_nama_detail"]').val($('#lvl0 option:selected').text());
            $('input[name="plvl1_nama_detail"]').val($('#lvl1 option:selected').text());
            $('input[name="plvl2_nama_detail"]').val($('#lvl2 option:selected').text());
            $('input[name="plvl3_nama_detail"]').val($('#lvl3 option:selected').text());
            $('input[name="plvl4_detail"]').val($('#lvl4').val());
            $('input[name="pbbm_detail"]').val(bbm);
            $('input[name="plvlid"]').val(vlevelid);
            $('input[name="plvl"]').val(lvl0);

            bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_pdf_detail').submit();
                }
            });
        }
    });

    $('#button-excel-jadwal').click(function(e) {
      var lvl0 = $('#lvl0').val(); //Regional dropdown
      var lvl1 = $('#lvl1').val(); //level1 dropdown
      var lvl2 = $('#lvl2').val(); //level2 dropdown
      var lvl3 = $('#lvl3').val(); //level3 dropdown
      var lvl4 = $('#lvl4').val(); //pembangkit dropdown

      var bln = $('#bln').val(); //bulan dropdown

        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else if(bln == '')
        {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH BULAN-- </div>', function() {});
        }else {
          if (lvl0 !== "") {
              lvl0 = 'Regional';
              vlevelid = $('#lvl0').val();
              if (vlevelid == "00") {
                  lvl0 = "Pusat";
              }
          }
          if (lvl1 !== "") {
              lvl0 = 'Level 1';
              vlevelid = $('#lvl1').val();
          }
          if (lvl2 !== "") {
              lvl0 = 'Level 2';
              vlevelid = $('#lvl2').val();
          }
          if (lvl3 !== ""){
              lvl0 = 'Level 3';
              vlevelid = $('#lvl3').val();
          }
          if (lvl4 !== "") {
              lvl0 = 'Level 4';
              vlevelid = $('#lvl4').val();
          }
          if (bbm !== "") {
              bbm = $('#bbm').val();
              if (bbm =='001') {
                  bbm = 'MFO';
              }else if(bbm == '002'){
                  bbm = 'IDO';
              }else if(bbm == '003'){
                  bbm = 'BIO';
              }else if(bbm == '004'){
                  bbm = 'HSD+BIO';
              }else if(bbm == '005'){
                  bbm = 'HSD';
              }
          }
          if (bbm == '') {
              bbm = '-';
          }

          $('input[name="xlvl0_jadwal"]').val($('#lvl0').val());
          $('input[name="xlvl1_jadwal"]').val($('#lvl1').val());
          $('input[name="xlvl2_jadwal"]').val($('#lvl2').val());
          $('input[name="xlvl3_jadwal"]').val($('#lvl3').val());

          $('input[name="xlvl0_nama_jadwal"]').val($('#lvl0 option:selected').text());
          $('input[name="xlvl1_nama_jadwal"]').val($('#lvl1 option:selected').text());
          $('input[name="xlvl2_nama_jadwal"]').val($('#lvl2 option:selected').text());
          $('input[name="xlvl3_nama_jadwal"]').val($('#lvl3 option:selected').text());

          $('input[name="xlvl4_jadwal"]').val($('#lvl4').val());  // 183130

          $('input[name="xlvlid_jadwal"]').val(vlevelid);
          $('input[name="xlvl_jadwal"]').val(lvl0);

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_excel_jadwal').submit();
                }
            });
        }
    });
    $('#button-pdf-jadwal').click(function(e) {
      var lvl0 = $('#lvl0').val(); //Regional dropdown
      var lvl1 = $('#lvl1').val(); //level1 dropdown
      var lvl2 = $('#lvl2').val(); //level2 dropdown
      var lvl3 = $('#lvl3').val(); //level3 dropdown
      var lvl4 = $('#lvl4').val(); //pembangkit dropdown

      var bln = $('#bln').val(); //bulan dropdown

        if (lvl0 == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        } else if(bln == '')
        {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH BULAN-- </div>', function() {});
        }else {
          if (lvl0 !== "") {
              lvl0 = 'Regional';
              vlevelid = $('#lvl0').val();
              if (vlevelid == "00") {
                  lvl0 = "Pusat";
              }
          }
          if (lvl1 !== "") {
              lvl0 = 'Level 1';
              vlevelid = $('#lvl1').val();
          }
          if (lvl2 !== "") {
              lvl0 = 'Level 2';
              vlevelid = $('#lvl2').val();
          }
          if (lvl3 !== ""){
              lvl0 = 'Level 3';
              vlevelid = $('#lvl3').val();
          }
          if (lvl4 !== "") {
              lvl0 = 'Level 4';
              vlevelid = $('#lvl4').val();
          }
          if (bbm !== "") {
              bbm = $('#bbm').val();
              if (bbm =='001') {
                  bbm = 'MFO';
              }else if(bbm == '002'){
                  bbm = 'IDO';
              }else if(bbm == '003'){
                  bbm = 'BIO';
              }else if(bbm == '004'){
                  bbm = 'HSD+BIO';
              }else if(bbm == '005'){
                  bbm = 'HSD';
              }
          }
          if (bbm == '') {
              bbm = '-';
          }

          $('input[name="plvl0_jadwal"]').val($('#lvl0').val());
          $('input[name="plvl1_jadwal"]').val($('#lvl1').val());
          $('input[name="plvl2_jadwal"]').val($('#lvl2').val());
          $('input[name="plvl3_jadwal"]').val($('#lvl3').val());

          $('input[name="plvl0_nama_jadwal"]').val($('#lvl0 option:selected').text());
          $('input[name="plvl1_nama_jadwal"]').val($('#lvl1 option:selected').text());
          $('input[name="plvl2_nama_jadwal"]').val($('#lvl2 option:selected').text());
          $('input[name="plvl3_nama_jadwal"]').val($('#lvl3 option:selected').text());

          $('input[name="plvl4_jadwal"]').val($('#lvl4').val());  // 183130

          $('input[name="plvlid_jadwal"]').val(vlevelid);
          $('input[name="plvl_jadwal"]').val(lvl0);

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_pdf_jadwal').submit();
                }
            });
        }
    });
</script>

<script type="text/javascript">
    jQuery(function($) {

        function setDefaultLv1(){
            $('select[name="COCODE"]').empty();
            $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
        }

        function setDefaultLv2(){
            $('select[name="PLANT"]').empty();
            $('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
        }

        function setDefaultLv3(){
            $('select[name="STORE_SLOC"]').empty();
            $('select[name="STORE_SLOC"]').append('<option value="">--Pilih Level 3--</option>');
        }

        function setDefaultLv4(){
            $('select[name="SLOC"]').empty();
            $('select[name="SLOC"]').append('<option value="">--Pilih Level 4--</option>');
        }

        function disabledDetailButton()
        {
            $('#button-detail').removeClass('disabled');
            $('#button-detail').addClass('disabled');
        }


        $('select[name="ID_REGIONAL"]').on('change', function() {

            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv1/'+stateID;
            disabledDetailButton();

            setDefaultLv1();
            setDefaultLv2();
            setDefaultLv3();
            setDefaultLv4();
            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                        });
                    }
                });
            }
        });

        $('select[name="COCODE"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv2/'+stateID;
            disabledDetailButton();

            setDefaultLv2();
            setDefaultLv3();
            setDefaultLv4();
            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                        });
                    }
                });
            }
        });

        $('select[name="PLANT"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv3/'+stateID;
            disabledDetailButton();

            setDefaultLv3();
            setDefaultLv4();
            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                        });
                    }
                });
            }
        });

        $('select[name="STORE_SLOC"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv4/'+stateID;
            disabledDetailButton();

            setDefaultLv4();
            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                        });
                    }
                });
            }
        });

        $('select[name="SLOC"]').on('change',function() {
            if ($(this).val() !== '') {
                $('#button-detail').removeClass('disabled');
            }else {
                $('#button-detail').addClass('disabled');
            }
            /* Act on the event */
        });
    });
</script>
