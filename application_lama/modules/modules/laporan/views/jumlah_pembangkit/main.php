<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css"> -->
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>


<style>
    #exampleModal{
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

    .period-hide{
      display: none;
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
                    <!-- BUG kotak cari di tekan ENTER malah refresh karena form tanggal ini, solusinya saya hide dengan
                    menambah class period-hide -->
                    <!-- <label for="password" class="control-label">Periode <span class="required">*</span> :  </label> -->
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
              <table id="dataTable" class="display dt-responsive" cellspacing="0" style="max-height:1000px;">
                  <thead>
                      <tr>
                          <th style="width: 10%">No</th>
                          <th>KODE</th>                          
                          <th style="max-width: 40%">Unit</th>
                          <th style="max-width: 10%">Jumlah Pembangkit</th>
                          <th style="max-width: 10%">Pembangkit Aktif</th>
                          <th style="max-width: 10%">Pembangkit Non Aktif</th>
                          <th style="max-width: 20%">AKSI</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
                  <tfoot id="tfoot">
                    
                  </tfoot>
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
                  <?php echo form_dropdown('filterStatus', array(
                    'sad'     => '--Filter Status--',
                    'Aktif'             => 'Aktif',
                    'Tidak Aktif'       => 'Tidak Aktif'
                  ), '', 'style="margin-left:1px;" id="filterStatus_detail"') ?>
                  &nbsp
                  <div id="btn-detail1" style="display: none" class="pull-right">
                    <button type="button" class="btn" id="btn-detailexcel1"><i class="icon-download"></i>Download Excel</button>
                    <button type="button" class="btn" id="btn-detailpdf1"><i class="icon-download"></i>Download Pdf</button>
                  </div> 
                  <div id="btn-detail2" style="display: none" class="pull-right">
                    <button type="button" class="btn" id="btn-detailexcel2"><i class="icon-download"></i>Download Excel</button>
                    <button type="button" class="btn" id="btn-detailpdf2"><i class="icon-download"></i>Download Pdf</button>
                  </div>
                </div>
              <table id="dataTable_detail" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
                <thead>
                  <tr>
                    <th rowspan="2">NO</th>
                    <th colspan="4">Level</th>
                    <th rowspan="2" style="text-align:center;">Unit Pembangkit</th>
                    <th colspan="5" style="text-align:center;">Kapasitas Tangki Per Jenis Bahan Bakar (L)</th>
                    <th rowspan="2" style="text-align:center;">Total Kapasitas (L)</th>
                    <th rowspan="2">Latitude</th>
                    <th rowspan="2" style="text-align:center;">Longtitude</th>
                    <th rowspan="2" style="text-align:center;">Status</th>
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

<form id="export_excel" action="<?php echo base_url('laporan/jumlah_pembangkit/export_excel'); ?>" method="post">
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
<form id="export_pdf" action="<?php echo base_url('laporan/jumlah_pembangkit/export_pdf'); ?>" method="post" target="_blank" >
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
<form id="export_excel_detail" action="<?php echo base_url('laporan/jumlah_pembangkit/export_excel_detail'); ?>" method="post">
    <input type="hidden" name="xlvl0_detail" id="xlvl0_detail">
    <input type="hidden" name="xlvl1_detail" id="xlvl1_detail">
    <input type="hidden" name="xlvl2_detail" id="xlvl2_detail">
    <input type="hidden" name="xlvl3_detail" id="xlvl3_detail">
    <input type="hidden" name="xlvl0_nama_detail" id="xlvl0_nama_detail">
    <input type="hidden" name="xlvl1_nama_detail" id="xlvl1_nama_detail">
    <input type="hidden" name="xlvl2_nama_detail" id="xlvl2_nama_detail">
    <input type="hidden" name="xlvl3_nama_detail" id="xlvl3_nama_detail">
    <input type="hidden" name="xlvl4_detail" id="xlvl4_detail">
    <input type="hidden" name="xbbm_detail" id="xbbm_detail">
    <input type="hidden" name="xbln_detail" id="xbln_detail">
    <input type="hidden" name="xthn_detail" id="xthn_detail">
    <input type="hidden" name="xlvlid_detail" id="xlvlid_detail">
    <input type="hidden" name="xlvl_detail" id="xlvl_detail">
    <input type="hidden" name="xtglawal_detail" id="xtglawal_detail">
    <input type="hidden" name="xtglakhir_detail" id="xtglakhir_detail">
    <input type="hidden" name="xkodeUnit_detail" id="xkodeUnit_detail">
    <input type="hidden" name="xidbbm_detail" id="xidbbm_detail">
    <input type="hidden" name="value" id="value">
</form>
<form id="export_pdf_detail" action="<?php echo base_url('laporan/jumlah_pembangkit/export_pdf_detail'); ?>" method="post" target="_blank">
    <input type="hidden" name="plvl0" id="plvl0">
    <input type="hidden" name="plvl1" id="plvl1">
    <input type="hidden" name="plvl2" id="plvl2">
    <input type="hidden" name="plvl3" id="plvl3">
    <input type="hidden" name="plvl0_nama" id="plvl0_nama">
    <input type="hidden" name="plvl1_nama" id="plvl1_nama">
    <input type="hidden" name="plvl2_nama" id="plvl2_nama">
    <input type="hidden" name="plvl3_nama" id="plvl3_nama">
    <input type="hidden" name="plvl4" id="plvl4">
    <input type="hidden" name="pbbm" id="pbbm">
    <input type="hidden" name="pbln" id="pbln">
    <input type="hidden" name="pthn" id="pthn">
    <input type="hidden" name="plvlid" id="plvlid">
    <input type="hidden" name="plvl" id="plvl">
    <input type="hidden" name="ptglawal" id="ptglawal">
    <input type="hidden" name="ptglakhir" id="ptglakhir">
    <input type="hidden" name="ptglawal_detail" id="ptglawal_detail">
    <input type="hidden" name="ptglakhir_detail" id="ptglakhir_detail">
    <input type="hidden" name="pkodeUnit_detail" id="pkodeUnit_detail">
    <input type="hidden" name="pidbbm_detail" id="pidbbm_detail">
    <input type="hidden" name="valuepdf" id="valuepdf">
</form>

<script type="text/javascript">
  $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);

  $(document).ready(function() {
    getData()

    function setCekTgl(){
        var dateStart = $('#tglawal').val();
        var dateEnd = $('#tglakhir').val();

        if (dateEnd < dateStart){
            $('#tglakhir').datepicker('update', dateStart);
        }
    }

  });

  var today = new Date();
  var year = today.getFullYear();

  $('select[name="TAHUN"]').val(year);

  function nums(n, p, ts, dp) {
    var t = [];
    if (typeof p  == 'undefined') p  = 2;
    if (typeof ts == 'undefined') ts = ',';
    if (typeof dp == 'undefined') dp = '.';

    n = Number(n).toFixed(p).split('.');

    for (var iLen = n[0].length, i = iLen? iLen % 3 || 3 : 0, j = 0; i <= iLen; i+=3) {
      t.push(n[0].substring(j, i));
      j = i;
    }
    return t.join(ts) + (n[1]? dp + n[1] : '');
  }

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

  $(document).ready(function() {
      $('#dataTable').dataTable({
          "scrollY": "450px",
          "searching": false,
          "scrollX": false,
          "scrollCollapse": false,
          "bPaginate": false,
          "ordering" : true,
          // show display records datatable
          "bLengthChange": false,
          "pageLength" : 100,
          "bFilter": false,
          "bInfo": true,
          "bAutoWidth": true,
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
                "targets" : [1],
                "visible" : false
            },
            {
                "className": "dt-left",
                "targets": [2]
            },
            {
              "className" : "dt-center",
              "targets" : ['_all']
            },
              {
                  "targets": -1,
                  "data": null,
                  "defaultContent": "<button class='btn btn-primary bdet'>DETAIL</button>"
              },
          ]
      });
  });


  function filterDefault()
  {
    $('#filterStatus_detail').empty();
    $('#filterStatus_detail').append('<option value="_all">--Filter Status--</option><option value="Aktif">Aktif</option><option value="Tidak Aktif">Tidak Aktif</option>');
  }

  function clearCari() {

    $('#cariDetail').val('');
  }

  $('#dataTable tbody').on( 'click', 'button', function () {
    filterDefault();
    clearDT_Detail();
    bootbox.dialog('<div class="loading-progress"></div>');
      var t = $('#dataTable').DataTable();
      var tdetail = $('#dataTable_detail').DataTable({
        destroy : true,
        "ordering":true,
        "searching":true,
        "bLengthChange": true,
        "scrollY": "450px",
        "scrollX": true,
        "scrollCollapse": false,
        fixedHeader: {
          header: true,
          footer: true
        },
        "bPaginate": true,
        "bFilter": true,
        "bInfo": true,
        "autoWidth": true,
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
        },
        "columnDefs": [
            {
              "targets": [0,6,7,8,9,10,11,12,13],
              "searchable": false
            },
             {
                 "className": "dt-left",
                 "targets": [1,2,3,4]
             },
             {
               "className": "dt-center",
               "targets": [-1]
             },
             {
                 "className": "dt-right",
                 "targets": [-2,-3,6,7,8,9,10,11]
             }
          ]
      });

      var selected_row= t.row($(this).parents('tr')).data();
      // console.log(selected_row);

      var bln = $('#bln').val(); //bulan dropdown
      var thn = $('#thn').val(); //tahun dropdown

      var kode_unit = selected_row[1];
      var id_bbm = selected_row[3];

      $('input[name="xkodeUnit_detail"]').val(kode_unit);      
      $('input[name="xidbbm_detail"]').val(id_bbm);
      $('input[name="pkodeUnit_detail"]').val(kode_unit);
      $('input[name="pidbbm_detail"]').val(id_bbm);      
      $.ajax({
          url : "<?php echo base_url('laporan/jumlah_pembangkit/getDetailPembangkit'); ?>",
          type: 'POST',
          data: {

              "detail_kode_unit": kode_unit
          },
          beforeSend:function(response) {
            // bootbox.hideAll();
            // bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
          },
          error:function(response) {
            bootbox.hideAll();
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
          },
          success:function(response){
            var detail_parser = JSON.parse(response);
            var nomer = 1;
            var total = detail_parser.length;
            var progres = 0;            
            var elem = document.getElementById("div_bar");

            $.each(detail_parser, function(index, el) {
              setTimeout( function(){
                  var level0 = el.LEVEL0 == null ? "" : el.LEVEL0;
                  var level1 = el.LEVEL1 == null ? "" : el.LEVEL1;
                  var level2 = el.LEVEL2 == null ? "" : el.LEVEL2;
                  var level3 = el.LEVEL3 == null ? "" : el.LEVEL3;
                  var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
                  var HSD = el.HSD == "0.00" ? "-" : el.HSD;
                  var MFO = el.MFO == "0.00" ? "-" : el.MFO;
                  var BIO = el.BIO == "0.00" ? "-" : el.BIO;
                  var HSD_BIO = el.HSD_BIO == "0.00" ? "-" : el.HSD_BIO;
                  var IDO = el.IDO == "0.00" ? "-" : el.IDO;
                  var TOTAL_KAPASITAS = el.KAPASITAS == "0.00" ? "-" : el.KAPASITAS;
                  var LAT = el.LATITUDE == null || el.LATITUDE == ''? "-" : el.LATITUDE;
                  var LONG = el.LONGITUDE == null || el.LONGITUDE == ''? "-" : el.LONGITUDE;
                  var AKTIF = el.AKTIF == null ? "" : el.AKTIF;
                  if (AKTIF == "1") {
                    AKTIF = "Aktif";
                  }else{
                    AKTIF = "Tidak Aktif";
                  }

                  tdetail.row.add( [
                      nomer, level0, level1, level2, level3, UNIT_PEMBANGKIT,
                      convertToRupiah(HSD), convertToRupiah(MFO), convertToRupiah(BIO), convertToRupiah(HSD_BIO), convertToRupiah(IDO),
                      convertToRupiah(TOTAL_KAPASITAS), LAT, LONG, AKTIF
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
            $('#btn-detail1').show();
            $('#btn-detail2').hide();
            $('#exampleModal').modal('show');
            // bootbox.hideAll();
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

  function getData() {

    $('#tfoot').html('');
    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown
    var cari = $('#cariPembangkit').val();
      
    if (lvl0=='') {
        lvl0 = 'All';
        vlevelid = $('#lvl0').val();
        getDataPembangkit(lvl0,vlevelid,cari)
    }
    else {
      if (lvl0 == '') {
        lvl0 = 'All';
        vlevelid = $('#lvl0').val();
        getDataPembangkit(lvl0,vlevelid,"")
        // bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {}); 
      }
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
      bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
      getDataPembangkit(lvl0,vlevelid,cari)
    }  
  };
 

  function getDataPembangkit(lvl0,vlevelid,cari) {


    $.ajax({
      type: "POST",
      url : "<?php echo base_url('laporan/jumlah_pembangkit/getDataPembangkit'); ?>",
      data: {
        "ID_REGIONAL": lvl0,
        "VLEVELID":vlevelid,
        'cari':cari
      },
      beforeSend:function(response) {

        // bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
      },
      error:function(response) {

        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
      },
      success:function(response) {
        // bootbox.hideAll();

        var obj = JSON.parse(response);
        var t = $('#dataTable').DataTable();
        t.clear().draw();

        if (obj == "" || obj == null) {
            bootbox.hideAll();
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
        } else {

          var sumtotalpembangkit = 0;
          var sumpembangkitaktif = 0;
          var sumpembangkitnonaktif = 0;
          var nomer = 1;
          var total = obj.length;

          $.each(obj, function (index, value) {
            var UNIT = value.UNIT == null ? "" : value.UNIT;
            var TOTAL_PEMBANGKIT = value.TOTAL_PEMBANGKIT == null ? "" : value.TOTAL_PEMBANGKIT;
            var KODE_UNIT = value.KODE == null ? "" : value.KODE;
            var PEMBANGKIT_AKTIF = value.PEMBANGKIT_AKTIF == null ? "" : value.PEMBANGKIT_AKTIF;
            var PEMBANGKIT_NON_AKTIF = value.PEMBANGKIT_NON_AKTIF == null ? "" : value.PEMBANGKIT_NON_AKTIF;
            sumtotalpembangkit += parseInt(value.TOTAL_PEMBANGKIT);
            sumpembangkitaktif += parseInt(value.PEMBANGKIT_AKTIF);
            sumpembangkitnonaktif += parseInt(value.PEMBANGKIT_NON_AKTIF);

            t.row.add( [
                nomer,
                KODE_UNIT, 
                UNIT, 
                TOTAL_PEMBANGKIT,
                PEMBANGKIT_AKTIF,
                PEMBANGKIT_NON_AKTIF
            ] ).draw(false);

            if (nomer==1){
                bootbox.hideAll();
                // $('#div_load').show();
                bootbox.dialog('<div class="loading-progress"></div>');                    
            }

            if (nomer>=total){
                bootbox.hideAll();
                // $('#div_load').hide('slow');                                       
            }            

            nomer++;            
          });
          
          $('#tfoot').append(
            "<tr class='display'>"+
              "<th></th>"+
              "<th style='text-align: center'>Jumlah Total Pembangkit Seluruh Unit</th>"+
              "<th style='text-align: left'> "+nums(sumtotalpembangkit,0,'.')+" </th>"+
              "<th style='text-align: left'> "+nums(sumpembangkitaktif,0,'.')+" </th>"+
              "<th style='text-align: left'> "+nums(sumpembangkitnonaktif,0,'.')+" </th>"+
              "<th><button type='button' class='btn btn-primary bdet' id='btn-detail' style='text-align: left'>DETAIL</button></th>"+
            "</tr>")
          bootbox.hideAll();
          $('#btn-detail').click(function(){
            $('#btn-detail1').hide();
            $('#btn-detail2').show();
            getDetailPembangkit(lvl0,vlevelid);
          })
          $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
        };
      }
    });
  }

  function getDetailPembangkit(lvl0,vlevelid) {
    bootbox.dialog('<div class="loading-progress"></div>');
    // var lvl0 = $('#lvl0').val();
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown

    $('input[name="xlvl0_detail"]').val(lvl0); // 01
    $('input[name="xlvl1_detail"]').val(lvl1); //COCODE
    $('input[name="xlvl2_detail"]').val(lvl2);
    $('input[name="xlvl3_detail"]').val(lvl3);
    $('input[name="xlvl0_nama_detail"]').val($('#lvl0 option:selected').text()); // SUMATERA
    $('input[name="xlvl1_nama_detail"]').val($('#lvl1 option:selected').text());
    $('input[name="xlvl2_nama_detail"]').val($('#lvl2 option:selected').text());
    $('input[name="xlvl3_nama_detail"]').val($('#lvl3 option:selected').text());
    $('#xlvl_detail').val(vlevelid);
    $('#xlvl').val(lvl0);
    $('#xbbm').val(bbm); // 001


    if (lvl0 == 'All') {
      kode_unit = 'All';
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
      kode_unit = lvl0+"#"+vlevelid;
    }

    $('input[name="xkodeUnit_detail"]').val(kode_unit);
    $('input[name="pkodeUnit_detail"]').val(kode_unit);

    var t = $('#dataTable').DataTable();
    var tdetail = $('#dataTable_detail').DataTable({
      destroy : true,
      "ordering":true,
      "searching":true,
      "bLengthChange": true,
      "scrollY": "450px",
      "scrollX": true,
      "scrollCollapse": false,
      fixedHeader: {
        header: true,
        footer: true
      },
      "bPaginate": true,
      "bFilter": true,
      "bInfo": true,
      "autoWidth": true,
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
      },
      "columnDefs": [
          {
            "targets": [0,6,7,8,9,10,11,12,13],
            "searchable": false
          },
           {
               "className": "dt-left",
               "targets": [1,2,3,4]
           },
           {
             "className": "dt-center",
             "targets": [-1]
           },
           {
               "className": "dt-right",
               "targets": [-2,-3,6,7,8,9,10,11]
           }
        ]
    });

    tdetail.clear().draw(false);

    $.ajax({
      type: "POST",
      url : "<?php echo base_url('laporan/jumlah_pembangkit/getAllDetailPembangkit'); ?>",
      data: {
        "detail_kode_unit": kode_unit
      },
      beforeSend:function(response){

        // bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');

      },
      error:function(response){
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
      },
      success:function(response) {
          var detail_parser = JSON.parse(response);
          var nomer = 1;
          var total = detail_parser.length;
          var progres = 0;            
          var elem = document.getElementById("div_bar");          

          $.each(detail_parser, function(index, el) {
            setTimeout( function(){
              var level0 = el.LEVEL0 == null ? "" : el.LEVEL0;
              var level1 = el.LEVEL1 == null ? "" : el.LEVEL1;
              var level2 = el.LEVEL2 == null ? "" : el.LEVEL2;
              var level3 = el.LEVEL3 == null ? "" : el.LEVEL3;
              var UNIT_PEMBANGKIT = el.UNIT == null ? "" : el.UNIT;
              var HSD = el.HSD == "0.00" ? "-" : el.HSD;
              var MFO = el.MFO == "0.00" ? "-" : el.MFO;
              var BIO = el.BIO == "0.00" ? "-" : el.BIO;
              var HSD_BIO = el.HSD_BIO == "0.00" ? "-" : el.HSD_BIO;
              var IDO = el.IDO == "0.00" ? "-" : el.IDO;
              var TOTAL_KAPASITAS = el.KAPASITAS == "0.00" ? "-" : el.KAPASITAS;
              var LAT = el.LATITUDE == null || el.LATITUDE == ''? "-" : el.LATITUDE;
              var LONG = el.LONGITUDE == null || el.LONGITUDE == ''? "-" : el.LONGITUDE;
              var AKTIF = el.AKTIF == null ? "" : el.AKTIF;
              if (AKTIF == "1") {
                AKTIF = "Aktif";
              }else{
                AKTIF = "Tidak Aktif";
              }

              // tdetail.clear().draw();
              tdetail.row.add( [
                  nomer, level0, level1, level2, level3, UNIT_PEMBANGKIT,
                  convertToRupiah(HSD), convertToRupiah(MFO), convertToRupiah(BIO), convertToRupiah(HSD_BIO), convertToRupiah(IDO),
                  convertToRupiah(TOTAL_KAPASITAS), LAT, LONG, AKTIF
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
        // bootbox.hideAll();
        $('#exampleModal').modal('show');
      }
    });     
  }

  $('#button-load').click(function(e) {
      getData()
  });
  /**
   * check is numeric or not
   */
  function isNumeric(n) {

    return !isNaN(parseFloat(n)) && isFinite(n);
  }

  //Untuk button tampilkan data
  $('#tampilData').on('change', function () {
    oTable = $('#dataTable').dataTable();
    var oSettings = oTable.fnSettings();
    oSettings._iDisplayLength = this.value;
    oTable.fnDraw();
  });

  $('#filterStatus_detail').on('change', function () {
    var table = $('#dataTable_detail').DataTable();
    if($(this).val() == '_all')
    {
      table
       .search( '' )
       .columns().search( '' )
       .draw();
    }else{
      table
        .column(-1)
        .search("^" + $(this).val() + "$", true, false, true)
        .draw();
    }
  });

  $('#tampilData_detail').on('change', function () {
    oTable = $('#dataTable_detail').dataTable();
    var oSettings = oTable.fnSettings();
    oSettings._iDisplayLength = this.value;
    oTable.fnDraw();
  });

  //when datatable detailButton clicked
  function clearDT_Detail() {

    var t = $('#dataTable_detail').DataTable();
    $('#dataTable_detail').addClass('auto');
    t.clear().draw();
  }

  $('#button-excel').click(function(e) {
    var lvl0 = $('#lvl0').val(); //Regional dropdown
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

        $('input[name="xlvl0"]').val($('#lvl0').val());
        $('input[name="xlvl1"]').val($('#lvl1').val());
        $('input[name="xlvl2"]').val($('#lvl2').val());
        $('input[name="xlvl3"]').val($('#lvl3').val());

        $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
        $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl4"]').val($('#lvl4').val());  // 183130
        // $('input[name="xbbm"]').val(bbm); // 001

        $('input[name="xlvlid"]').val(vlevelid);
        $('input[name="xlvl"]').val(lvl0);
        $('input[name="xcari"]').val($('#cariPembangkit').val());

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

          $('input[name="plvlid"]').val(vlevelid);
          $('input[name="plvl"]').val(lvl0);
          $('input[name="pcari"]').val($('#cariPembangkit').val());
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
        $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text()); // SUMATERA
        $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl0_nama_detail"]').val($('#lvl0 option:selected').text()); // SUMATERA
        $('input[name="xlvl1_nama_detail"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama_detail"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama_detail"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl4"]').val($('#lvl4').val());  // 183130
        $('input[name="xbbm"]').val(bbm); // 001
        $('input[name="xbln"]').val($('#bln').val()); // 1 -> Januari
        $('input[name="xthn"]').val($('#thn').val()); // 2017
        $('input[name="xthn"]').val($('#thn').val());

        $('input[name="xlvl_detail"]').val(vlevelid);

        $('input[name="xlvl"]').val(lvl0);          
      }
  });

  $('#btn-detailexcel1').click(function(e) {
    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown
    var bln = $('#bln').val(); //bulan dropdown
    var thn = $('#thn').val(); //tahun dropdown

      if (lvl0 == 'All') {
          lvl0 == 'All';
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
        $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text()); // SUMATERA
        $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl0_nama_detail"]').val($('#lvl0 option:selected').text()); // SUMATERA
        $('input[name="xlvl1_nama_detail"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama_detail"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama_detail"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl4"]').val($('#lvl4').val());  // 183130
        $('input[name="xbbm"]').val(bbm); // 001
        $('input[name="xbln"]').val($('#bln').val()); // 1 -> Januari
        $('input[name="xthn"]').val($('#thn').val()); // 2017
        $('input[name="xthn"]').val($('#thn').val());

        $('input[name="xlvl_detail"]').val(vlevelid);

        $('input[name="xlvl"]').val(lvl0);   
        $('input[name="value"]').val(1);          
      }
      bootbox.confirm('Apakah yakin akan export data Excel ?', "Tidak", "Ya", function(e) {
        if(e){
            $('#export_excel_detail').submit();
        }
      });
  });

  $('#btn-detailexcel2').click(function(e) {
    var lvl0 = $('#lvl0').val(); //Regional dropdown
    var lvl1 = $('#lvl1').val(); //level1 dropdown
    var lvl2 = $('#lvl2').val(); //level2 dropdown
    var lvl3 = $('#lvl3').val(); //level3 dropdown
    var lvl4 = $('#lvl4').val(); //pembangkit dropdown
    var bbm = $('#bbm').val(); //bahanBakar dropdown
    var bln = $('#bln').val(); //bulan dropdown
    var thn = $('#thn').val(); //tahun dropdown

      if (lvl0 == 'All') {
         lvl0 == 'All';
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
        $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text()); // SUMATERA
        $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl0_nama_detail"]').val($('#lvl0 option:selected').text()); // SUMATERA
        $('input[name="xlvl1_nama_detail"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama_detail"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama_detail"]').val($('#lvl3 option:selected').text());

        $('input[name="xlvl4"]').val($('#lvl4').val());  // 183130
        $('input[name="xbbm"]').val(bbm); // 001
        $('input[name="xbln"]').val($('#bln').val()); // 1 -> Januari
        $('input[name="xthn"]').val($('#thn').val()); // 2017
        $('input[name="xthn"]').val($('#thn').val());

        $('input[name="xlvl_detail"]').val(vlevelid);

        $('input[name="xlvl"]').val(lvl0); 
        $('input[name="value"]').val(2);         
      }
      bootbox.confirm('Apakah yakin akan export data Excel ?', "Tidak", "Ya", function(e) {
        if(e){
            $('#export_excel_detail').submit();
        }
      });
  });
    
  // $('#button-pdf-detail').click(function(e) {
  //     var lvl0 = $('#lvl0').val();
  //     var lvl1 = $('#lvl1').val(); //level1 dropdown
  //     var lvl2 = $('#lvl2').val(); //level2 dropdown
  //     var lvl3 = $('#lvl3').val(); //level3 dropdown
  //     var lvl4 = $('#lvl4').val(); //pembangkit dropdown
  //     var bbm = $('#bbm').val(); //bahanBakar dropdown

  //     if (lvl0 == '') {
  //         bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
  //     } else {
  //       if (lvl0 !== "") {
  //           lvl0 = 'Regional';
  //           vlevelid = $('#lvl0').val();
  //           if (vlevelid == "00") {
  //               lvl0 = "Pusat";
  //           }
  //       }
  //       if (lvl1 !== "") {
  //           lvl0 = 'Level 1';
  //           vlevelid = $('#lvl1').val();
  //       }
  //       if (lvl2 !== "") {
  //           lvl0 = 'Level 2';
  //           vlevelid = $('#lvl2').val();
  //       }
  //       if (lvl3 !== ""){
  //           lvl0 = 'Level 3';
  //           vlevelid = $('#lvl3').val();
  //       }
  //       if (lvl4 !== "") {
  //           lvl0 = 'Level 4';
  //           vlevelid = $('#lvl4').val();
  //       }
  //       if (bbm !== "") {
  //           bbm = $('#bbm').val();
  //           if (bbm =='001') {
  //               bbm = 'MFO';
  //           }else if(bbm == '002'){
  //               bbm = 'IDO';
  //           }else if(bbm == '003'){
  //               bbm = 'BIO';
  //           }else if(bbm == '004'){
  //               bbm = 'HSD+BIO';
  //           }else if(bbm == '005'){
  //               bbm = 'HSD';
  //           }
  //       }
  //       if (bbm == '') {
  //           bbm = '-';
  //       }

  //         $('input[name="plvl0"]').val($('#lvl0').val());
  //         $('input[name="plvl1"]').val($('#lvl1').val());
  //         $('input[name="plvl2"]').val($('#lvl2').val());
  //         $('input[name="plvl3"]').val($('#lvl3').val());

  //         $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
  //         $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
  //         $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
  //         $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

  //         $('input[name="plvl4"]').val($('#lvl4').val());
  //         $('input[name="pbbm"]').val(bbm);
  //         // $('input[name="pbln"]').val($('#bln').val());
  //         // $('input[name="pthn"]').val($('#thn').val());

  //         $('input[name="plvlid"]').val(vlevelid);
  //         $('input[name="plvl"]').val(lvl0);
  //         bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
  //             if(e){
  //                 $('#export_pdf_detail').submit();
  //             }
  //         });
  //     }
  // });


  $('#btn-detailpdf1').click(function(e) {
      var lvl0 = $('#lvl0').val();
      var lvl1 = $('#lvl1').val(); //level1 dropdown
      var lvl2 = $('#lvl2').val(); //level2 dropdown
      var lvl3 = $('#lvl3').val(); //level3 dropdown
      var lvl4 = $('#lvl4').val(); //pembangkit dropdown
      var bbm = $('#bbm').val(); //bahanBakar dropdown

      if (lvl0 == 'All') {
          lvl0 == 'All';
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
          // $('input[name="pbln"]').val($('#bln').val());
          // $('input[name="pthn"]').val($('#thn').val());

          $('input[name="plvlid"]').val(vlevelid);
          $('input[name="plvl"]').val(lvl0);
          $('input[name="valuepdf"]').val(1);

          bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
              if(e){
                  $('#export_pdf_detail').submit();
              }
          });
      }
  });

  $('#btn-detailpdf2').click(function(e) {
      var lvl0 = $('#lvl0').val();
      var lvl1 = $('#lvl1').val(); //level1 dropdown
      var lvl2 = $('#lvl2').val(); //level2 dropdown
      var lvl3 = $('#lvl3').val(); //level3 dropdown
      var lvl4 = $('#lvl4').val(); //pembangkit dropdown
      var bbm = $('#bbm').val(); //bahanBakar dropdown

      if (lvl0 == 'All') {
          lvl0 == 'All';
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
          // $('input[name="pbln"]').val($('#bln').val());
          // $('input[name="pthn"]').val($('#thn').val());

          $('input[name="plvlid"]').val(vlevelid);
          $('input[name="plvl"]').val(lvl0);
          $('input[name="valuepdf"]').val(2);
          bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
              if(e){
                  $('#export_pdf_detail').submit();
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

    function disabledDetailButton(){
        $('#button-detail').removeClass('disabled');
        $('#button-detail').addClass('disabled');
    }

    $('select[name="ID_REGIONAL"]').on('change', function() {

        var stateID = $(this).val();
        // console.log(stateID);
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
        // console.log(typeof $(this).val());
        if ($(this).val() !== '') {
            $('#button-detail').removeClass('disabled');
        }else {
            $('#button-detail').addClass('disabled');
        }

        // console.log($(this).val());
        /* Act on the event */
    });
  });
</script>
