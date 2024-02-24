<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<style>
   .modal_max{
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
</div>

<div class="widgets_area" id="divFilter">
    <div class="row-fluid">
        <div class="span12">
            <div id="index-content1" class="well-content no-search">
                <div class="content_table">
                    <div class="well-content clearfix">
                        <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                        <div class="form_row">
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Regional : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Level 1 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Level 2 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form_row">
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Level 3 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Pembangkit : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Jenis Bahan Bakar : </label>
                                <div class="controls">
                                  <?php echo form_dropdown('BBM', $opsi_bbm, !empty($default->ID_JENIS_BHN_BKR) ? $default->ID_JENIS_BHN_BKR : '', 'id="bbm"'); ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form_row">
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Pemasok : </label>
                                <div class="controls">
                                  <?php echo form_dropdown('PEMASOK', $opsi_pemasok, !empty($default->PEMASOK) ? $default->PEMASOK : '', 'id="PEMASOK"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                                <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                                <div class="controls">
                                  <?php $now = strtotime(date('Y-m-d')); $bulan = date('m', $now); ?>
                                  <?php echo form_dropdown('BULAN', $opsi_bulan, $bulan, 'style="width: 137px;", id="bln"'); ?>
                                  <?php echo form_dropdown('TAHUN', $opsi_tahun, '', 'style="width: 80px;", id="thn"'); ?>
                                </div>

                                <!-- <label for="password" class="control-label">Periode : </label>
                                <div class="controls">
                                    <?php //echo form_input('TGL_DARI', !empty($TGL_DARI) ? $TGL_DARI : '', 'class="form_datetime" style="width: 99px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                                    <label for="">s/d</label>
                                    <?php //echo form_input('TGL_SAMPAI', !empty($TGL_SAMPAI) ? $TGL_SAMPAI : '', 'class="form_datetime" style="width: 99px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
                                </div> -->
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Cari: </label>
                                <div class="controls">
                                    <input type="text" id="CARI" name="CARI" value="" placeholder="Cari Pemasok, Jns BBM">           
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?>                     
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form_row">
                            <div class="pull-left span3"></div>
                            <div class="pull-left span3"></div>                            
                            <div class="pull-left span4">                                
                                <div class="controls">
                                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>                                
                                </div>
                            </div>
                        </div>
                        <br>
                        <?php echo form_close(); ?>
                    </div>
                </div>                
                <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter" hidden></div>
                <hr>

                <div class="well-content clearfix">
                    <table id="dataTable" class="display dt-responsive" width="100%" cellspacing="0" style="max-height:1000px;">
                      <thead>
                         <tr>
                            <th style="text-align:center;">NO</th>
                            <th style="text-align:center;">KODE UNIT</th>
                            <th style="text-align:center;">UNIT</th>                            
                            <th style="text-align:center;">PEMASOK</th>
                            <th style="text-align:center;">ID JENIS BBM</th>
                            <th style="text-align:center;">JENIS<br>BAHAN BAKAR</th>
                            <th style="text-align:center;">PERIODE</th>
                            <th style="text-align:center;">HARGA PRODUK<br>(Rp/Liter)</th>
                            <th style="text-align:center;">OAT 1<br>(Rp/Liter)</th>
                            <th style="text-align:center;">JARAK<br>(KM/ML)</th>
                            <th style="text-align:center;">TOTAL VOLUME<br>PENERIMAAN&nbsp;(L)</th>
                            <th style="text-align:center;">TOTAL PEROLEHAN HARGA</th>
                            <th style="text-align:center;">AKSI</th>
                         </tr>                         
                      </thead>
                      <tbody></tbody>
                    </table>                    
                </div>
                <br>            
                <label><i>(*Harga termasuk PPN 10%)</i></label><br> 
                <label><i>(*OAT - Ongkos Angkut Transportasi)</i></label><br> 
                <label><i>(*Total Perolehan Harga ((Produk + OAT) x Total Volume Penerimaan))</i></label><br>

                <div class="modal fade modal-lg modal_max" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                   <div class="modal-dialog" role="document">
                      <div class="modal-content">
                         <div class="modal-header">
                            <h5 class="modal-title" id="modal_detail_label">Detail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                         </div>
                         <div class="modal-body">

                            <div class="form_row pull-right">
                                <div class="pull-left">
                                    <label for="password" class="control-label">Nama Transportir : </label>
                                    <div class="controls">
                                        <?php echo form_dropdown('ID_TRANSPORTIR', $opsi_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'class="chosen" id="ID_TRANSPORTIR"'); ?>
                                        <!-- <input type="text" id="CARI" name="CARI" value="" placeholder="Cari Pemasok, Unit">    -->        
                                        <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load-detail')); ?>

                                        <label>&nbsp;&nbsp;</label>
                                        <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel-detail')); ?>
                                        <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf-detail')); ?>
                                    </div>
                                </div>
                            </div>                            
                              
                            <table id="data_table_detail" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
                               <thead>
                                  <tr>
                                     <th rowspan="2">NO</th>
                                     <th colspan="4">Level</th>
                                     <th rowspan="2" style="text-align:center;">Unit Pembangkit</th>
                                     <th rowspan="2" style="text-align:center;">Pemasok BBM</th>
                                     <th rowspan="2" style="text-align:center;">Nama Transportir</th>
                                     <th rowspan="2" style="text-align:center;">No Penerimaan</th>
                                     <th rowspan="2" style="text-align:center;">Jenis Bahan Bakar</th>
                                     <th rowspan="2" style="text-align:center;">Tanggal DO/TUG/BA</th>
                                     <th rowspan="2" style="text-align:center;">Tanggal Terima Fisik</th>
                                     <th rowspan="2" style="text-align:center;">Volume Terima DO/TUG/BA (L)</th>
                                     <th rowspan="2" style="text-align:center;">Volume Terima Real (L)</th>
                                  </tr>
                                  <tr>
                                     <th>0</th>
                                     <th>1</th>
                                     <th>2</th>
                                     <th>3</th>
                                  </tr>
                               </thead>
                               <tbody></tbody>
                            </table>
                         </div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                         </div>
                      </div>
                   </div>
                </div>                  

            </div>
        </div>
    </div>
</div>
<br><br>

<form id="export_excel" action="<?php echo base_url('laporan/perolehan_harga_bbm/export_excel'); ?>" method="post">
   <input type="hidden" name="xlvl0">
   <input type="hidden" name="xlvl1">
   <input type="hidden" name="xlvl2">
   <input type="hidden" name="xlvl3">
   <input type="hidden" name="xlvl4">
   <input type="hidden" name="xlvl0_nama">
   <input type="hidden" name="xlvl1_nama">
   <input type="hidden" name="xlvl2_nama">
   <input type="hidden" name="xlvl3_nama">
   <input type="hidden" name="xlvl4_nama">
   <input type="hidden" name="xbbm">
   <input type="hidden" name="xlvlid">
   <input type="hidden" name="xlvl">
   <input type="hidden" name="xperiode">
   <input type="hidden" name="xperiode_nama">
   <input type="hidden" name="xpemasok">
   <input type="hidden" name="xpemasok_nama">
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/perolehan_harga_bbm/export_pdf'); ?>" method="post"  target="_blank">   
   <input type="hidden" name="plvl0">
   <input type="hidden" name="plvl1">
   <input type="hidden" name="plvl2">
   <input type="hidden" name="plvl3">
   <input type="hidden" name="plvl4">
   <input type="hidden" name="plvl0_nama">
   <input type="hidden" name="plvl1_nama">
   <input type="hidden" name="plvl2_nama">
   <input type="hidden" name="plvl3_nama">
   <input type="hidden" name="plvl4_nama">
   <input type="hidden" name="pbbm">
   <input type="hidden" name="plvlid">
   <input type="hidden" name="plvl">
   <input type="hidden" name="pperiode">
   <input type="hidden" name="pperiode_nama">
   <input type="hidden" name="ppemasok">
   <input type="hidden" name="ppemasok_nama">
</form>

<form id="export_excel_detail" action="<?php echo base_url('laporan/penerimaan_pemasok/export_excel_detail'); ?>" method="post">
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
   <input type="hidden" name="xlvlid_detail">
   <input type="hidden" name="xlvl_detail">
   <input type="hidden" name="xtglawal_detail">
   <input type="hidden" name="xtglakhir_detail">
   <input type="hidden" name="xpemasok_detail">
   <input type="hidden" name="xkodeUnit_detail">
   <input type="hidden" name="xtransportir_detail">
   <input type="hidden" name="xkomponen_detail">
</form>

<form id="export_pdf_detail" action="<?php echo base_url('laporan/penerimaan_pemasok/export_pdf_detail'); ?>" method="post"  target="_blank">   
   <input type="hidden" name="plvl0_detail">
   <input type="hidden" name="plvl1_detail">
   <input type="hidden" name="plvl2_detail">
   <input type="hidden" name="plvl3_detail">
   <input type="hidden" name="plvl0_nama_detail">
   <input type="hidden" name="plvl1_nama_detail">
   <input type="hidden" name="plvl2_nama_detail">
   <input type="hidden" name="plvl3_nama_detail">
   <input type="hidden" name="plvl4_detail">
   <input type="hidden" name="pbbm_detail">
   <input type="hidden" name="plvlid_detail">
   <input type="hidden" name="plvl_detail">
   <input type="hidden" name="ptglawal_detail">
   <input type="hidden" name="ptglakhir_detail">
   <input type="hidden" name="ppemasok_detail">
   <input type="hidden" name="pkodeUnit_detail">
   <input type="hidden" name="ptransportir_detail">
   <input type="hidden" name="pkomponen_detail">
</form>

<script type="text/javascript">
    var t_utama, t_detail;
    var _id_bbm, _kode_unit, _id_pemasok, _transportir;

    var today = new Date();
    var year = today.getFullYear();

    $('select[name="TAHUN"]').val(year);    
    
    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);
    $('.chosen').chosen();

    jQuery(function ($) {
        load_table('#content_table', 1, '#ffilter');
        $('#button-filter').click(function () {
            load_table('#content_table', 1, '#ffilter');           
        });        
    });  

    function isNumeric(n) {
     return !isNaN(parseFloat(n)) && isFinite(n);
    }    

    function convertToRupiah(angka){
        var bilangan = parseFloat(Math.round(angka * 100) / 100).toFixed(2);
        bilangan = bilangan.replace(".", ",");
        var isMinus = '';

        if (bilangan.indexOf('-') > -1) {
            bilangan = bilangan.replace("-", "");
            isMinus = '-';
        }
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

        if ((rupiah=='') || (rupiah==0)) {rupiah='0,00'}
        rupiah = isMinus+''+rupiah;

        return rupiah;
    }       

    $(document).ready(function() {
       t_utama = $('#dataTable').dataTable({               
           "scrollY": "450px",
           "searching": false,
           // "scrollX": true,
           // "scrollCollapse": false,
           // "bPaginate": true,

           // "bLengthChange": true,
           // "pageLength" : 10,
           // "bFilter": false,
           // "bInfo": true,
           // "bAutoWidth": true,
           // "ordering": true,
           // "fixedHeader": true,
           "lengthMenu": [10, 25, 50, 100, 200],
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
                 "targets" : [1,4],
                 "visible" : false
             },
             {
                 "targets": -1,
                 "data": null,
                 "defaultContent": "<button class='btn btn-primary bdet'>DETAIL</button>"
             },
             {
                 // "className": "dt-left",
                 // "targets": [4]
             },               
             {
                 "className": "dt-center",
                 "targets": [0,5,6,-1]
             },               
             {
                 "className": "dt-right",
                 "targets": [7,8,9,10,11]
             },
           ]
       });

       t_detail = $('#data_table_detail').DataTable({         
         "pageLength": 10,
         "destroy" : true,
         "responsive" : true,
         "bLengthChange" : true,
         "scrollY": "450px",
         "scrollX": true,
         "scrollCollapse": false,
         // "scrollX": true,
         "bPaginate": true,
         "bFilter": true,
         "searching":true,
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
             "info": "Total Data: _TOTAL_",
             "infoFiltered": "(difilter dari _MAX_ total entri)",
             "infoEmpty": "Total Data: 0",
             "lengthMenu": "Jumlah Data _MENU_"
         },
         "columnDefs": [
           // {
             // "searchable" : false,
             // "targets": [0,8,9,10,11,12,13,14]
           // },
              {
                  "className": "dt-left",
                  "targets": [1,2,3,4,5,6,7,8]
              },
              {
                "className": "dt-center",
                "targets": [0,9,10,11]
              },
              {
                  "className": "dt-right",
                  "targets": [-1,-2]
              },
       ]
       });            
    });

    $('#dataTable tbody').on( 'click', 'button', function () {
        alert('on progress');
        

        // var t = $('#dataTable').DataTable();

        // var selected_row= t.row($(this).parents('tr')).data();

        // var kode_unit = selected_row[1];       
        // var id_bbm = selected_row[5];
        // var id_pemasok = selected_row[3];       

        // _id_bbm = id_bbm;              
        // _kode_unit = kode_unit;
        // _id_pemasok = id_pemasok;        

        // $('#modal_detail').modal('show'); 

    });

    $('#modal_detail').on('shown', function(){  
        _transportir = '';        
        $('#ID_TRANSPORTIR').val('');
        $('#ID_TRANSPORTIR').data("placeholder","Select").trigger('liszt:updated');
        set_get_detail();
    }); 

    $('#button-load-detail').click(function(e) {
        if ($('#ID_TRANSPORTIR').val()){
          _transportir = $('#ID_TRANSPORTIR option:selected').text();
        } else {
          _transportir = '';  
        }
        set_get_detail();   
    });
   

    function set_get_detail(){
       bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
       t_detail.clear().draw();                
       $.ajax({
           url : "<?php echo base_url('laporan/penerimaan_pemasok/get_data_detail'); ?>",           
           type: "POST",
           data: {
                 "JENIS_BBM": _id_bbm,
                 "TGLAWAL": _parsed_tglawal,
                 "TGLAKHIR": _parsed_tglakhir,                 
                 "VLEVELID": _kode_unit,
                 "PEMASOK": _id_pemasok,
                 "VTRANS" : _transportir,
                 "JENIS_BIO" : "",
           }
       })
       .done(function(data) {               
           var detail_parser = JSON.parse(data);
           var nomer = 1;                 

           $.each(detail_parser, function(index, el) {                     
               var REGIONAL = el.REGIONAL == null ? "" : el.REGIONAL;
               var LEVEL1 = el.LEVEL1 == null ? "" : el.LEVEL1;
               var LEVEL2 = el.LEVEL2 == null ? "" : el.LEVEL2;
               var LEVEL3 = el.LEVEL3 == null ? "" : el.LEVEL3;
               var UNIT = el.UNIT == null ? "" : el.UNIT;
               var NAMA_PEMASOK = el.NAMA_PEMASOK == null ? "" : el.NAMA_PEMASOK;
               var NAMA_TRANSPORTIR = el.NAMA_TRANSPORTIR == null ? "" : el.NAMA_TRANSPORTIR;
               var NO_PENERIMAAN = el.NO_PENERIMAAN == null ? "" : el.NO_PENERIMAAN;
               var JNS_BBM = el.JNS_BBM == null ? "" : el.JNS_BBM;               
               var TGL_DO = el.TGL_DO == null ? "" : el.TGL_DO;
               var TERIMA_FISIK = el.TERIMA_FISIK == null ? "" : el.TERIMA_FISIK;
               var VOL_TERIMA = el.VOL_TERIMA == null ? "0" : el.VOL_TERIMA;
               var VOL_TERIMA_REAL = el.VOL_TERIMA_REAL == null ? "0" : el.VOL_TERIMA_REAL;

               t_detail.row.add( [
                   nomer, REGIONAL, LEVEL1, LEVEL2, LEVEL3, UNIT, NAMA_PEMASOK, NAMA_TRANSPORTIR, NO_PENERIMAAN, 
                   JNS_BBM, TGL_DO, TERIMA_FISIK, convertToRupiah(VOL_TERIMA), convertToRupiah(VOL_TERIMA_REAL)                
               ] ).draw( false );
               nomer++;
           });

           bootbox.hideAll();
       });       
    }
             
    $('#button-load').click(function(e) {
       var lvl0 = $('#lvl0').val(); 
       var lvl1 = $('#lvl1').val(); 
       var lvl2 = $('#lvl2').val(); 
       var lvl3 = $('#lvl3').val(); 
       var lvl4 = $('#lvl4').val(); 
       var bbm = $('#bbm').val(); 
       var cari = $('#CARI').val();
       var pemasok = $('#PEMASOK').val();    
       var periode = $('#thn').val()+''+$('#bln').val();    


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
       if (pemasok == '') {
           pemasok = '-';
       }

       if (lvl0 == '') {
           lvl0 = "All";
           vlevelid = '';           
       }
       
       bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
       $.ajax({
           type: "POST",
           url : "<?php echo base_url('laporan/perolehan_harga_bbm/get_data'); ?>",
           data: {
               "JENIS_BBM": bbm,
               "PERIODE": periode,                       
               "ID_REGIONAL": lvl0,
               "VLEVELID":vlevelid,
               "PEMASOK":pemasok,
               "CARI" : cari,
               },
           error: function(data) {
              bootbox.hideAll();         
              msgGagal(data.statusText);                      
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
                       var KODE = value.KODE == null ? "" : value.KODE;
                       var UNIT = value.UNIT == null ? "" : value.UNIT;                               
                       var ID_JNS_BHN_BKR = value.ID_JNS_BHN_BKR == null ? "" : value.ID_JNS_BHN_BKR;

                       var NAMA_PEMASOK = value.NAMA_PEMASOK == null ? "" : value.NAMA_PEMASOK;
                       var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                       var PERIODE = $('#bln option:selected').text()+' '+$('#thn').val();
                       var HARGA = value.HARGA == null ? "" : value.HARGA;
                       var OAT1 = value.OAT1 == null ? "" : value.OAT1;
                       var JARAK = value.JARAK == null ? "" : value.JARAK;
                       var TERIMA = value.TERIMA == null ? "" : value.TERIMA;
                       var TOTAL = value.TOTAL == null ? "" : value.TOTAL;
                       
                       t.row.add( [
                           nomer, KODE, UNIT, NAMA_PEMASOK, ID_JNS_BHN_BKR, NAMA_JNS_BHN_BKR, PERIODE,
                           convertToRupiah(HARGA), convertToRupiah(OAT1), convertToRupiah(JARAK), convertToRupiah(TERIMA), convertToRupiah(TOTAL)
                       ] ).draw( false );
                       nomer++;
                    });
                    bootbox.hideAll();                         
                    $('html, body').animate({scrollTop: $("#dataTable").offset().top}, 1000);
               };
           }
       });       
    });    

    $('#button-excel').click(function(e) {
       var lvl0 = $('#lvl0').val(); 
       var lvl1 = $('#lvl1').val(); 
       var lvl2 = $('#lvl2').val(); 
       var lvl3 = $('#lvl3').val(); 
       var lvl4 = $('#lvl4').val(); 
       var bbm = $('#bbm').val(); 
       var cari = $('#CARI').val();
       var pemasok = $('#PEMASOK').val();    
       var periode = $('#thn').val()+''+$('#bln').val();
       var periode_nama = $('#bln option:selected').text()+' '+$('#thn').val();

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
       if (pemasok == '') {
           pemasok = '-';
       }
       if (lvl0 == '') {
           lvl0 = "All";
           vlevelid = '';           
       }
       
       $('input[name="xlvl0"]').val($('#lvl0').val());
       $('input[name="xlvl1"]').val($('#lvl1').val());
       $('input[name="xlvl2"]').val($('#lvl2').val());
       $('input[name="xlvl3"]').val($('#lvl3').val());
       $('input[name="xlvl4"]').val($('#lvl4').val());

       $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
       $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
       $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
       $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());  
       $('input[name="xlvl4_nama"]').val($('#lvl4 option:selected').text());  

       $('input[name="xbbm"]').val(bbm);           
       $('input[name="xlvlid"]').val(vlevelid);
       $('input[name="xlvl"]').val(lvl0); 
       $('input[name="xpemasok"]').val(pemasok);
       $('input[name="xpemasok_nama"]').val($('#PEMASOK option:selected').text());
       $('input[name="xperiode"]').val(periode);
       $('input[name="xperiode_nama"]').val(periode_nama);
                 
       bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_excel').submit();
         }
       });
    });         

    $('#button-pdf').click(function(e) {
       var lvl0 = $('#lvl0').val(); 
       var lvl1 = $('#lvl1').val(); 
       var lvl2 = $('#lvl2').val(); 
       var lvl3 = $('#lvl3').val(); 
       var lvl4 = $('#lvl4').val(); 
       var bbm = $('#bbm').val(); 
       var cari = $('#CARI').val();
       var pemasok = $('#PEMASOK').val();    
       var periode = $('#thn').val()+''+$('#bln').val();
       var periode_nama = $('#bln option:selected').text()+' '+$('#thn').val();

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
       if (pemasok == '') {
           pemasok = '-';
       }
       if (lvl0 == '') {
           lvl0 = "All";
           vlevelid = '';           
       }
       
       $('input[name="plvl0"]').val($('#lvl0').val());
       $('input[name="plvl1"]').val($('#lvl1').val());
       $('input[name="plvl2"]').val($('#lvl2').val());
       $('input[name="plvl3"]').val($('#lvl3').val());
       $('input[name="plvl4"]').val($('#lvl4').val());

       $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
       $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
       $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
       $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());  
       $('input[name="plvl4_nama"]').val($('#lvl4 option:selected').text());  

       $('input[name="pbbm"]').val(bbm);           
       $('input[name="plvlid"]').val(vlevelid);
       $('input[name="plvl"]').val(lvl0); 
       $('input[name="ppemasok"]').val(pemasok);
       $('input[name="ppemasok_nama"]').val($('#PEMASOK option:selected').text());
       $('input[name="pperiode"]').val(periode);
       $('input[name="pperiode_nama"]').val(periode_nama);
                 
       bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
         if(e){
             $('#export_pdf').submit();
         }
       });
    }); 

    $('#button-excel-detail').click(function(e) {
       var lvl0 = $('#lvl0').val();        

       if (lvl0=='') {
           bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});       
       } else {           
           $('input[name="xlvl0_detail"]').val($('#lvl0').val());
           $('input[name="xlvl1_detail"]').val($('#lvl1').val());
           $('input[name="xlvl2_detail"]').val($('#lvl2').val());
           $('input[name="xlvl3_detail"]').val($('#lvl3').val());
           $('input[name="xlvl4_detail"]').val($('#lvl4').val());

           $('input[name="xlvl0_nama_detail"]').val($('#lvl0 option:selected').text());
           $('input[name="xlvl1_nama_detail"]').val($('#lvl1 option:selected').text());
           $('input[name="xlvl2_nama_detail"]').val($('#lvl2 option:selected').text());
           $('input[name="xlvl3_nama_detail"]').val($('#lvl3 option:selected').text());  

           $('input[name="xbbm_detail"]').val(_id_bbm); 
           $('input[name="xkodeUnit_detail"]').val(_kode_unit);                      
           $('input[name="xpemasok_detail"]').val(_id_pemasok); 
           $('input[name="xtransportir_detail"]').val(_transportir); 
           // $('input[name="xpemasok_nama_detail"]').val($('#PEMASOK option:selected').text());
           
           $('input[name="xtglawal_detail"]').val(_parsed_tglawal);
           $('input[name="xtglakhir_detail"]').val(_parsed_tglakhir);

           $('input[name="xkomponen_detail"]').val('');

           bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
             if(e){
                 $('#export_excel_detail').submit();
             }
           });
       };
    });


    $('#button-pdf-detail').click(function(e) {
       var lvl0 = $('#lvl0').val();        

       if (lvl0=='') {
           bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});       
       } else {           
           $('input[name="plvl0_detail"]').val($('#lvl0').val());
           $('input[name="plvl1_detail"]').val($('#lvl1').val());
           $('input[name="plvl2_detail"]').val($('#lvl2').val());
           $('input[name="plvl3_detail"]').val($('#lvl3').val());
           $('input[name="plvl4_detail"]').val($('#lvl4').val());

           $('input[name="plvl0_nama_detail"]').val($('#lvl0 option:selected').text());
           $('input[name="plvl1_nama_detail"]').val($('#lvl1 option:selected').text());
           $('input[name="plvl2_nama_detail"]').val($('#lvl2 option:selected').text());
           $('input[name="plvl3_nama_detail"]').val($('#lvl3 option:selected').text());  

           $('input[name="pbbm_detail"]').val(_id_bbm); 
           $('input[name="pkodeUnit_detail"]').val(_kode_unit);                      
           $('input[name="ppemasok_detail"]').val(_id_pemasok); 
           $('input[name="ptransportir_detail"]').val(_transportir); 
           // $('input[name="xpemasok_nama_detail"]').val($('#PEMASOK option:selected').text());
           
           $('input[name="ptglawal_detail"]').val(_parsed_tglawal);
           $('input[name="ptglakhir_detail"]').val(_parsed_tglakhir);

           $('input[name="pkomponen_detail"]').val('');

           bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
             if(e){
                 $('#export_pdf_detail').submit();
             }
           });
       };
    });      

    // $('#modal_detail').on('hidden', function () {
    //     // tdetail.clear().draw();
    // })      

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
         $('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
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
           bootbox.modal('<div class="loading-progress"></div>');
           $.ajax({
               url: vlink_url,
               type: "GET",
               dataType: "json",
               success:function(data) {
                   $.each(data, function(key, value) {
                       $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                   });
                   bootbox.hideAll();
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
           bootbox.modal('<div class="loading-progress"></div>');
           $.ajax({
               url: vlink_url,
               type: "GET",
               dataType: "json",
               success:function(data) {
                   $.each(data, function(key, value) {
                       $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                   });
                   bootbox.hideAll();
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
           bootbox.modal('<div class="loading-progress"></div>');
           $.ajax({
               url: vlink_url,
               type: "GET",
               dataType: "json",
               success:function(data) {
                   $.each(data, function(key, value) {
                       $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                   });
                   bootbox.hideAll();
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
           bootbox.modal('<div class="loading-progress"></div>');
           $.ajax({
               url: vlink_url,
               type: "GET",
               dataType: "json",
               success:function(data) {
                   $.each(data, function(key, value) {
                       $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                   });
                   bootbox.hideAll();
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
      });
    });
</script>