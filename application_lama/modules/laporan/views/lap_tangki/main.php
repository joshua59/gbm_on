<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<style>
   #exampleModal, #modal_rekap_bio, #modal_detail_bio{
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
         <span><?php echo isset($page_title) ? $page_title : 'Laporan Tangki BBM'; ?></span>
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
         </div>
         <br/>
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
         </div>
         <br/>
         <div class="form_row">
            <div class="pull-left span3">
            </div>

            <div class="pull-left span3">
            </div>

            <div class="pull-left span3">
               <label for="password" class="control-label">Cari: </label>
               <div class="controls">
                  <input type="text" id="cariPembangkit" name="" value="" placeholder="Cari Pembangkit">
                  <?php echo anchor(null, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?>
               </div>
            </div>            
         </div>
         <br>
         <div class="form_row">
            <div class="pull-right span7">
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
                  <?php echo anchor(null, "<i class='icon-download'></i> Download All Detail", array(
                     'class' => 'btn',
                     'id'    => 'button-excel-all-detail'
                     )); ?>
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
                  <th>No</th>
                  <th>ID BBM</th>
                  <th>ID TANGKI</th>
                  <th>Kode</th>
                  <th>Pembangkit</th>
                  <th>Jumlah Tangki</th>
                  <th>Jenis Bahan Bakar</th>
                  <th>Volume (L)</th>
                  <th>Dead Stock (L)</th>
                  <th>Kapasitas Efektif (L)</th>
                  <th>AKSI</th>
               </tr>
            </thead>
            <tbody></tbody>
         </table>
         <label for="periodeawal_ket"><i>(*Dead Stock : Batas Akhir / Habis BBM di Tangki)</i></label><br><br>
         <label for="periodeakhir_ket"><i>(*Kapasitas Efektif : Kapasitas yang diperkirakan untuk digunakan)</i></label>
      </div>

      <div id="form-content" class="modal fade modal-xlarge"></div>

      <div class="modal fade modal-lg" id="modal_rekap_bio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="modal_rekap_bio_judul">Detail Tangki</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  <input type="hidden" name="id_komponen_modal" id="id_komponen_modal">
                  </button>
               </div>
               <div id="div_load2">
                  <div id="div_progress2">
                    <div id="div_bar2">0%</div>
                  </div>
               </div>                
               <div class="modal-body">
                  <div class="pull-right">
                     <input type="text" id="cariRekapBio" name="cariRekapBio" value="" placeholder="Cari Tangki" class="input-large">
                     <button type="button" class="btn" name="button" id="btnCariRekapBio">Cari</button>
                     <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                        'class' => 'btn',
                        'id'    => 'button-excel-bio'
                        )); ?>
                     <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf-bio'
                        )); ?>
                  </div>
                  <table id="dataTable_rekap_bio" class="table-striped" width="100%" cellspacing="0" style="max-height:1000px;">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th>ID BBM</th>
                           <th>ID TANGKI</th>
                           <th>Kode</th>
                           <th>Nama Tangki</th>
                           <th>Ditera Oleh</th>
                           <th>Tanggal Awal Tera</th>
                           <th>Tanggal Akhir Tera</th>
                           <th>Volume (L)</th>
                           <th>Dead Stock (L)</th>
                           <th>Kapasitas Efektif (L)</th>
                           <th>Status</th>
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

<input type="hidden" name="halaman_detail" value="1">
<input type="hidden" name="menu_detail" value="">

<form id="export_excel" action="<?php echo base_url('laporan/lap_tangki/export_excel'); ?>" method="post">
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
   <input type="hidden" name="xcari">
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/lap_tangki/export_pdf'); ?>" method="post"  target="_blank">
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
   <input type="hidden" name="pcari">
</form>

<form id="export_excel_bio" action="<?php echo base_url('laporan/lap_tangki/export_excel_bio'); ?>" method="post">
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
   <!-- <input type="hidden" name="xtglawal">
   <input type="hidden" name="xtglakhir"> -->
   <input type="hidden" name="xcari">
   <input type="hidden" name="xkode_unit">
   <input type="hidden" name="xid_tangki">
   <!-- <input type="hidden" name="xtglawal_bio">
   <input type="hidden" name="xtglakhir_bio"> -->
</form>

<form id="export_pdf_bio" action="<?php echo base_url('laporan/lap_tangki/export_pdf_bio'); ?>" method="post"  target="_blank">
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
   <!-- <input type="hidden" name="ptglawal">
   <input type="hidden" name="ptglakhir"> -->
   <input type="hidden" name="pcari">
   <input type="hidden" name="pkode_unit">
   <input type="hidden" name="pid_tangki">
   <!-- <input type="hidden" name="ptglawal_bio">
   <input type="hidden" name="ptglakhir_bio">     -->
</form>

<form id="export_excel_all_detail" action="<?php echo base_url('laporan/lap_tangki/export_excel_all_detail'); ?>" method="post">
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
   <input type="hidden" name="xcari">
</form>

<script type="text/javascript">
    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);

    var today = new Date();
    var year = today.getFullYear();

    $('select[name="TAHUN"]').val(year);    

    $(document).ready(function() {
     $(".form_datetime").datepicker({
       format: "yyyy-mm-dd",
       autoclose: true,
       todayBtn: true,
       pickerPosition: "bottom-left"
    });
     
    function isNumeric(n) {
     return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function setCekTgl(){
       var dateStart = $('#tglawal').val();
       var dateEnd = $('#tglakhir').val();

       if (dateEnd < dateStart){
           $('#tglakhir').datepicker('update', dateStart);
       }
    }

    $('#button-detail').addClass('disabled');
         // $("#button-detail").attr("disabled", true);
    });  

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
           "scrollX": true,
           "scrollCollapse": false,
           "bPaginate": true,

           "bLengthChange": true,
           "pageLength" : 10,
           "bFilter": false,
           "bInfo": true,
           "bAutoWidth": true,
           "ordering": true,
           "fixedHeader": true,
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
                    "targets" : [1],
                    "visible" : false
                },
                {
                    "targets" : [2],
                    "visible" : false
                },
                {
                    "targets" : [3],
                    "visible" : false
                },
                {
                    "targets": -1,
                    "data": null,
                    "defaultContent": "<button class='btn btn-primary bdet'>DETAIL</button>"
                },
                {
                        "className": "dt-center",
                        "targets": [0,4,5,6,7,8,9,10]
                },
           ]
       });
    });

    function tampilData_default(){
     $('#tampilData').val('-Tampilkan Data-');
     $('#tampilData_detail').val('-Tampilkan Data-');
    }    

    function clearDT_Detail(){
       var t = $('#dataTable_detail').DataTable();
       $('#dataTable_detail').addClass('auto');
       t.clear().draw();       
    }    

    function clearDT_Rekap_Bio(){
       var t2 = $('#dataTable_rekap_bio').DataTable();
       $('#dataTable_rekap_bio').addClass('auto');
       t2.clear().draw();        
    }       

    function clearCari(){
     $('#cariDetail').val('');      
    }    

    function clearCariBio(){      
     $('#cariRekapBio').val('');
    }        

    $('#dataTable tbody').on( 'click', 'button', function () {
     tampilData_default();
     clearDT_Detail(); clearDT_Rekap_Bio();     
     clearCari(); clearCariBio();
     // document.body.style.zoom = "100%"?
     bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
       var t = $('#dataTable').DataTable();

       var selected_row= t.row($(this).parents('tr')).data();

       var bln = $('#bln').val(); //bulan dropdown
       var thn = $('#thn').val(); //tahun dropdown

       //    var jumlah_terima = selected_row[7];
       var id_bbm = selected_row[1];
       var id_tangki = selected_row[2];
       var kode_unit = selected_row[3];

       $('input[name="xbbm"]').val(id_bbm); // 001      
       $('input[name="xid_tangki"]').val(id_tangki);
       $('input[name="xkode_unit"]').val(kode_unit);
       $('input[name="xidbbm_detail"]').val(id_bbm);  

       $('input[name="xid_tangki_detail"]').val(id_tangki);
       $('input[name="xkode_detail"]').val(kode_unit);

            
       $('input[name="pbbm"]').val(id_bbm); // 001      
       $('input[name="pid_tangki"]').val(id_tangki);
       $('input[name="pkode_unit"]').val(kode_unit);
       $('input[name="pidbbm_detail"]').val(id_bbm);

       $('input[name="xid_tangki_detail"]').val(id_tangki);
       $('input[name="pkode_detail"]').val(kode_unit);     
                  
        var tdetail_bio = $('#dataTable_rekap_bio').DataTable({
            "pageLength": 10,
            destroy : true,
            responsive: true,
            "bLengthChange": true,
            "scrollY": "450px",
            "scrollX": true,
            "scrollCollapse": false,             
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
                {
                    "targets" : [1],
                    "visible" : false
                },
                {
                    "targets" : [2],
                    "visible" : false
                },
                {
                    "targets" : [3],
                    "visible" : false
                },
                {
                    "className": "dt-center",
                    "targets": [0,4,5,6,7,8,9,10,11]
                },                  
            ]
        });                          
        
        $.ajax({
            url : "<?php echo base_url('laporan/lap_tangki/getDataDetail'); ?>",              
            type: 'POST',
            data: {
                "detail_id_bbm": id_bbm,             
                "detail_id_tangki": id_tangki,
                "detail_kode_unit" : kode_unit,
                "halaman":'1'
            }
        })
        .done(function(data) {               
            var detail_parser = JSON.parse(data);
            var nomer = 1;
            var total = detail_parser.length;
            var progres = 0;            
            var elem = document.getElementById("div_bar2");

            $.each(detail_parser, function(index, el) {
                setTimeout( function(){

                    var ID_TANGKI = el.ID_TANGKI == null ? "" : el.ID_TANGKI;      
                    var ID_BBM = el.ID_BBM == null ? "" : el.ID_BBM;
                    var KODE = el.KODE == null ? "" : el.KODE;
                    var NAMA_TANGKI = el.NAMA_TANGKI == null ? "-" : el.NAMA_TANGKI;
                    var DITERA_OLEH = el.DITERA_OLEH == null ? "-" : el.DITERA_OLEH;
                    var TGL_AKHIR_TERA = el.TGL_AKHIR_TERA == null ? "-" : el.TGL_AKHIR_TERA;
                    var TGL_AWAL_TERA = el.TGL_AWAL_TERA == null ? "-" : el.TGL_AWAL_TERA;
                    var VOLUME_TANGKI = el.VOLUME_TANGKI == null ? "0" : el.VOLUME_TANGKI;
                    var DEADSTOCK_TANGKI = el.DEADSTOCK_TANGKI == null ? "0" : el.DEADSTOCK_TANGKI;
                    var STOCKEFEKTIF_TANGKI = el.STOCKEFEKTIF_TANGKI == null ? "0" : el.STOCKEFEKTIF_TANGKI;
                    var STATUS_AKTIF = el.STATUS_AKTIF == null ? "-" : el.STATUS_AKTIF;

                    tdetail_bio.row.add( [
                        nomer, ID_BBM, ID_TANGKI, KODE, NAMA_TANGKI, DITERA_OLEH, TGL_AWAL_TERA, TGL_AKHIR_TERA,
                        convertToRupiah(VOLUME_TANGKI), convertToRupiah(DEADSTOCK_TANGKI), convertToRupiah(STOCKEFEKTIF_TANGKI), STATUS_AKTIF                   
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

        });

        $('#modal_rekap_bio').modal('show');
       
    });

    $('#btnCariDetail').on('click', function () {
     var cariDetail = $('#cariDetail').val();
     var table = $('#dataTable_detail').DataTable();
     table.search( cariDetail ,false,true,true).draw();
    });    

    $('#btnCariRekapBio').on('click', function () {
     var cariDetail = $('#cariRekapBio').val();
     var table = $('#dataTable_rekap_bio').DataTable();
     table.search( cariDetail ,false,true,true).draw();
    });    

    $('#cariDetail').keyup(function(e){
     if(e.keyCode == 13)
     {
       $('#btnCariDetail').click();
     }
    });  

    $('#cariRekapBio').keyup(function(e){
     if(e.keyCode == 13)
     {
       $('#btnCariRekapBio').click();
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
       var cari = $('#cariPembangkit').val();

       if (lvl0=='') {
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
           
           bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
               $.ajax({
                   type: "POST",
                   url : "<?php echo base_url('laporan/lap_tangki/getData'); ?>",
                   data: {
                       "JENIS_BBM": bbm,
                       "ID_REGIONAL": lvl0,
                       "VLEVELID":vlevelid,
                       "cari" : cari,
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
                           var LEVEL1 = value.LEVEL1 == null ? "" : value.LEVEL1;
                           var LEVEL2 = value.LEVEL2 == null ? "" : value.LEVEL2;
                           var LEVEL3 = value.LEVEL3 == null ? "" : value.LEVEL3;
                           var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                           var ID_BBM = value.ID_JNS_BHN_BKR == null ? "" : value.ID_JNS_BHN_BKR;
                           var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                           var VOLUME = value.VOLUME == null ? "" : value.VOLUME;
                           var DEADSTOCK = value.DEADSTOCK == null ? "" : value.DEADSTOCK;
                           var STOCKEFEKTIF = value.STOCKEFEKTIF == null ? "" : value.STOCKEFEKTIF;
                           var ID_BBM = value.ID_JNS_BHN_BKR == null ? "" : value.ID_JNS_BHN_BKR;
                           var ID_TANGKI = value.ID_TANGKI == null ? "" : value.ID_TANGKI;
                           var KODE = value.KODE == null ? "" : value.KODE;
                           var JML_TANGKI = value.JML_TANGKI == null ? "" : value.JML_TANGKI;


                           t.row.add( [
                               nomer, ID_BBM, ID_TANGKI, KODE, LEVEL4, JML_TANGKI,
                               NAMA_JNS_BHN_BKR, convertToRupiah(VOLUME), convertToRupiah(DEADSTOCK), convertToRupiah(STOCKEFEKTIF)
                           ] ).draw( false );
                           nomer++;
                         });
                         bootbox.hideAll();
                         $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                       };
                   }
               });
       };
    });

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

    $('#button-excel').click(function(e) {
     var lvl0 = $('#lvl0').val(); //Regional dropdown
     var lvl1 = $('#lvl1').val(); //level1 dropdown
     var lvl2 = $('#lvl2').val(); //level2 dropdown
     var lvl3 = $('#lvl3').val(); //level3 dropdown
     var lvl4 = $('#lvl4').val(); //pembangkit dropdown
     var bbm = $('#bbm').val(); //bahanBakar dropdown
     var cari = $('#cariPembangkit').val(); //bahanBakar dropdown

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
         $('input[name="xbbm"]').val(bbm); // 001
         $('input[name="xcari"]').val(cari); // 001

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

           $('input[name="plvlid"]').val(vlevelid);
           $('input[name="plvl"]').val(lvl0);
           $('input[name="pcari"]').val(cari);
           
           bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
               if(e){
                   $('#export_pdf').submit();
               }
           });
       }
    });

    $('#button-excel-bio').click(function(e) {
     var lvl0 = $('#lvl0').val(); //Regional dropdown
     var lvl1 = $('#lvl1').val(); //level1 dropdown
     var lvl2 = $('#lvl2').val(); //level2 dropdown
     var lvl3 = $('#lvl3').val(); //level3 dropdown
     var lvl4 = $('#lvl4').val(); //pembangkit dropdown      
     var cari = $('#cariPembangkit').val(); //bahanBakar dropdown

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
         $('input[name="xcari"]').val(cari); // 001

         $('input[name="xlvlid"]').val(vlevelid);
         $('input[name="xlvl"]').val(lvl0);

         bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
             if(e){
                 $('#export_excel_bio').submit();
             }
         });
       }
    });

    $('#button-pdf-bio').click(function(e) {
     var lvl0 = $('#lvl0').val(); //Regional dropdown
     var lvl1 = $('#lvl1').val(); //level1 dropdown
     var lvl2 = $('#lvl2').val(); //level2 dropdown
     var lvl3 = $('#lvl3').val(); //level3 dropdown
     var lvl4 = $('#lvl4').val(); //pembangkit dropdown      
     var cari = $('#cariPembangkit').val(); //bahanBakar dropdown

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

         $('input[name="plvl0"]').val($('#lvl0').val());
         $('input[name="plvl1"]').val($('#lvl1').val());
         $('input[name="plvl2"]').val($('#lvl2').val());
         $('input[name="plvl3"]').val($('#lvl3').val());

         $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
         $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
         $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
         $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

         $('input[name="plvl4"]').val($('#lvl4').val());  // 183130
         // $('input[name="xbbm"]').val(bbm); // 001
         $('input[name="pcari"]').val(cari); // 001

         $('input[name="plvlid"]').val(vlevelid);
         $('input[name="plvl"]').val(lvl0);

         bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
             if(e){
                 $('#export_pdf_bio').submit();
             }
         });
       }
    });    

    $('#button-excel-all-detail').click(function(e) {
     var lvl0 = $('#lvl0').val(); //Regional dropdown
     var lvl1 = $('#lvl1').val(); //level1 dropdown
     var lvl2 = $('#lvl2').val(); //level2 dropdown
     var lvl3 = $('#lvl3').val(); //level3 dropdown
     var lvl4 = $('#lvl4').val(); //pembangkit dropdown
     var bbm = $('#bbm').val(); //bahanBakar dropdown
     var cari = $('#cariPembangkit').val(); //bahanBakar dropdown

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
         $('input[name="xbbm"]').val(bbm); // 001
         $('input[name="xcari"]').val(cari); // 001

         $('input[name="xlvlid"]').val(vlevelid);
         $('input[name="xlvl"]').val(lvl0);
          
         bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
             if(e){
                 $('#export_excel_all_detail').submit();
             }
         });
       }
    });


    function redraw(data){
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
         var NOMER_PENERIMAAN = el.NO_PENERIMAAN == null ? "" : el.NO_PENERIMAAN;
         var NAMA_PEMASOK = el.NAMA_PEMASOK == null ? "" : el.NAMA_PEMASOK;
         var NAMA_TRANSPORTIR = el.NAMA_TRANSPORTIR == null ? "" : el.NAMA_TRANSPORTIR;
         var TGL_DO = el.TGL_DO == null ? "" : el.TGL_DO;
         var TGL_TERIMA_FISIK = el.TGL_TERIMA_FISIK == null ? "" : el.TGL_TERIMA_FISIK;
         var VOL_DO = el.VOL_DO == null ? "" : el.VOL_DO;
         var TERIMA_REAL = el.VOL_TERIMA_REAL == null ? "" : el.VOL_TERIMA_REAL;
         var TERIMA_KEMBALI = el.TERIMA_PENGEMBALIAN == null ? "0" : el.TERIMA_PENGEMBALIAN;
         var TERIMA_KEMBALI_REAL = el.TERIMA_REAL_PENGEMBALIAN == null ? "0" : el.TERIMA_REAL_PENGEMBALIAN;

         tdetail.row.add( [
             NOMOR, level0, level1, level2, level3, UNIT_PEMBANGKIT, BHN_BAKAR,
             NOMER_PENERIMAAN,
             NAMA_PEMASOK, NAMA_TRANSPORTIR, TGL_DO,
             TGL_TERIMA_FISIK, convertToRupiah(VOL_DO),
             convertToRupiah(TERIMA_REAL),
         ] ).draw( false );
         nomer++;
     });
    }

    function getPageData(halaman, id_bbm, parsed_tglawal, parsed_tglakhir, kode_unit ){

     $.ajax({
       url: 'lap_tangki/nextPage',
       type: 'POST',
       data: {
         "detail_id_bbm": id_bbm,
         "detail_tgl_awal": parsed_tglawal,
         "detail_tgl_akhir":parsed_tglakhir,
         "detail_kode_unit": kode_unit,
         'halaman' : halaman,
       }
     })
     .done(function(response) {
       var data = JSON.parse(response);         
       redraw(response);
     });
    }

    function getCurrentPage(dataTable){
     var oSettings = $('#'+dataTable).dataTable().fnSettings();
     var currentPageIndex = Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength) + 1;
     return currentPageIndex;
    }

    function getValueLengthMenu(dataTable){
     var table = $('#'+dataTable).DataTable(); //note that you probably already have this call
     var info = table.page.len();
     return info;
    }

    function getMenuData(){
     var menu = $('select[name="dataTable_detail_length"').val();
     return menu;
    }

    $('select[name="dataTable_detail_length"]').on('change', function(){
      $('input[name="menu_detail"]').val(this.value);       
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