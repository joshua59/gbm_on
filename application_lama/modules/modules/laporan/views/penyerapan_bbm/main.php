
<!-- /**
 * @module LAPORAN
 * @author  CF
 * @created at 29 Maret 2019
 * @modified at 29 Maret 2019
 */ -->

<!-- <link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> -->
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>

<style type="text/css">

    .dataTables_scrollHeadInner {
     width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
     width: 100% !important;
     border: 1px solid #696969;
     border-collapse:collapse;    
    }   

    th, td {
      border: 1px solid #696969;
    } 

    div.vs {
      width: 100%;
      height: 450px;
      overflow: scroll;
    } 
    ::-webkit-scrollbar {
        width: 0px;  /* remove scrollbar space */
        background: transparent;  /* optional: just make scrollbar invisible */
    }
    /* optional: show position indicator in red */
    ::-webkit-scrollbar-thumb {
        background: transparent;
    }
    ul.dashed{
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }

    ul.dashed > li {
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }
   
    ul.dashed > li:before {
      list-style-type: none;
      font-weight : bold;
      font-style: italic;
    }
</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/library/leaflet.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/library/maps/leaflet.js"></script>

<div class="inner_content" id="div_atas">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div id ="index-content" class="well-content">                                    
                    <div id="div_load">               
                        <div id="div_progress">
                          <div id="div_bar">0%</div>
                        </div>
                    </div>
                    <div class="box-title">                        
                        <button class="btn green",id="button-penerimaan" onclick="setTampil(1)" style="font-weight: normal;"><i class="icon-exchange"></i> Tabel Penerimaan</button>
                        <button class="btn green",id="button-penerimaan" onclick="setTampil(2)" style="font-weight: normal;"><i class="icon-exchange"></i> Tabel Pemakaian</button>
                        <input type="hidden" id="jenis">
                    </div>                    
                    <div class="well">
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
                            <div class="pull-left span5">
                                <label for="password" class="control-label">Periode : </label>
                                <div class="controls">
                                    <?php echo form_input('TGL_DARI', !empty($TGL_DARI) ? $TGL_DARI : '', 'class="form_datetime" style="width: 99px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                                    <label for="">s/d</label>
                                    <?php echo form_input('TGL_SAMPAI', !empty($TGL_SAMPAI) ? $TGL_SAMPAI : '', 'class="form_datetime" style="width: 99px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?> 
                                </div>
                            </div>
                        </div>                                                
                        <br>                        
                        <div class="form_row">
                            <div class="pull-left span3">                                
                            </div>
                            <div class="pull-left span3"></div>                            
                            <div class="pull-left span5">
                                <div class="controls">
                                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>                                
                                </div>
                            </div>
                        </div>
                        <div id="div_bawah"></div>
                        <br>
                        <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>   
        </div>            
        <!-- <div id="divData"></div>     -->
        <br>                
                  
        <!-- PENERIMAAN -->
        <div class="row-fluid" id="div_penerimaan" style="display: none">
          <div class="span12">
              <div id ="index-content" class="well-content no-search">
                  <div class="box-title" id="judul_pembangkit">
                      Realisasi Penerimaan
                  </div>                    

                  <div class="vs">
                    <table id="t_penerimaan" class="table table-bordered" width="100%" style="max-height:1000px;">
                      <thead>                                                
                          <tr>
                              <th style="text-align:center;width: 5%" rowspan="2">NO</th>
                              <th style="text-align:center;width: 10%" rowspan="2"><?php echo str_repeat("&nbsp;", 5);?>REGIONAL<?php echo str_repeat("&nbsp;", 5);?></th>
                              <th style="text-align:center;width: 15%" rowspan="2"><?php echo str_repeat("&nbsp;", 19);?>LEVEL1<?php echo str_repeat("&nbsp;", 18);?></th>                
                              <th style="text-align:center;" colspan="2"> TARGET RKAP </th>
                              <th style="text-align:center;" colspan="5"> REALISASI PENERIMAAN </th>
                          </tr> 
                          <tr>
                              <th style="text-align:center;width: 11%">Jenis BBM</th>
                              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                              <th style="text-align:center;width: 9%">Jenis BBM Sesuai DO</th>
                              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                              <th style="text-align:center;width: 10%">Jenis BBM Sesuai DO</th>
                              <th style="text-align:center;width: 11%">Volume Komponen<br>Penerimaan (L)</th>
                              <th style="text-align:center;width: 5%">Penyerapan<br>(%)</th>
                          </tr>           
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>

                  <hr><br>
                  <div class="box-title">
                      Total Seluruh Unit                    
                  </div>                    
                  <table id="t_penerimaan_total" class="table table-bordered" cellspacing="0" width="100%">
                      <thead>                                                
                          <tr>
                              <th style="text-align:center;width: 30%" rowspan="2"><?php echo str_repeat("&nbsp;", 5);?>UNIT<?php echo str_repeat("&nbsp;", 5);?></th>
                              <th style="text-align:center;" colspan="2"> TARGET RKAP </th>
                              <th style="text-align:center;" colspan="5"> REALISASI PENERIMAAN </th>
                          </tr> 
                          <tr>
                              <th style="text-align:center;width: 11%">Jenis BBM</th>
                              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                              <th style="text-align:center;width: 9%^">Jenis BBM Sesuai DO</th>
                              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                              <th style="text-align:center;width: 10%">Jenis BBM Sesuai DO</th>
                              <th style="text-align:center;width: 11%">Volume Komponen<br>Penerimaan (L)</th>
                              <th style="text-align:center;width: 5%">Penyerapan<br>(%)</th>
                          </tr>           
                      </thead>
                      <tbody>
                      </tbody>
                  </table>                    
                  <br><br>
              </div>
          </div>
          <div class="row-fluid">
            <div class="span12">
                <div id ="index-content" class="well-content no-search">
                  <ul class="dashed">
                    <li>- Volume Target RKAP = Volume Sesuai Target RKAP</li>
                    <li>- Volume Realisasi Penerimaan = Volume Penerimaan Sesuai Dengan Jenis Bahan Bakar atau Sesuai Komponen Jenis Bahan Bakar Pada Mutasi Penerimaan</li>
                    <li>- Volume Komponen Penerimaan  = Volume Komponen Campuran Bahan Bakar Sesuai Dengan Persentase (%) Komposisi Bahan Bakar</li>
                    <li>- Penyerapan (%) = Volume Komponen Penerimaan / Volume Target RKAP (Sesuai Dengan Jenis Bahan Bakar)</li>                    
                  </ul>                 
                </div>
            </div>
          </div>
        </div>
               
        <!-- PEMAKAIAN -->
        <div class="row-fluid" id="div_pemakaian" style="display: none">
          <div class="span12">
              <div id ="index-content" class="well-content no-search">
                  <div class="box-title" id="judul_pembangkit">
                      Realisasi Pemakaian
                  </div>                    

                  <div class="vs">
                    <table id="t_pemakaian" class="table table-bordered" width="100%" cellpadding="0">
                      <thead>                                                
                          <tr>
                              <th style="text-align:center;width: 5%" rowspan="2">NO</th>
                              <th style="text-align:center;width: 10%" rowspan="2"><?php echo str_repeat("&nbsp;", 5);?>REGIONAL<?php echo str_repeat("&nbsp;", 5);?></th>
                              <th style="text-align:center;width: 15%" rowspan="2"><?php echo str_repeat("&nbsp;", 19);?>LEVEL1<?php echo str_repeat("&nbsp;", 18);?></th>                
                              <th style="text-align:center;" colspan="4"> TARGET RKAP </th>
                              <th style="text-align:center;" colspan="3"> REALISASI PEMAKAIAN </th>
                          </tr> 
                          <tr>
                              <th style="text-align:center;width: 11%">Jenis BBM</th>
                              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                              <th style="text-align:center;width: 9%">Jenis BBM</th>
                              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                              <th style="text-align:center;width: 10%">Jenis BBM</th>
                              <th style="text-align:center;width: 11%">Volume (L)</th>
                              <th style="text-align:center;width: 5%">Penyerapan<br>(%)</th>
                          </tr>           
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>

                  <hr><br>
                  <div class="box-title">
                      Total Seluruh Unit                    
                  </div>                    
                  <table id="t_pemakaian_total" class="table table-bordered" cellspacing="0" width="100%">
                      <thead>                                                
                          <tr>
                              <th style="text-align:center;width: 30%" rowspan="2"><?php echo str_repeat("&nbsp;", 5);?>UNIT<?php echo str_repeat("&nbsp;", 5);?></th>
                              <th style="text-align:center;" colspan="4"> TARGET RKAP </th>
                              <th style="text-align:center;" colspan="3"> REALISASI PEMAKAIAN </th>
                          </tr> 
                          <tr>
                              <th style="text-align:center;width: 11%">Jenis BBM</th>
                              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                              <th style="text-align:center;width: 9%">Jenis BBM</th>
                              <th style="text-align:center;width: 12%"><?php echo str_repeat("&nbsp;", 3);?>Volume&nbsp;(L)<?php echo str_repeat("&nbsp;", 3);?></th>
                              <th style="text-align:center;width: 10%">Jenis BBM</th>
                              <th style="text-align:center;width: 11%">Volume (L)</th>
                              <th style="text-align:center;width: 5%">Penyerapan<br>(%)</th>
                          </tr>           
                      </thead>
                      <tbody>
                      </tbody>
                  </table>                    
                  <br><br>
              </div>
          </div>
          <div class="row-fluid">
            <div class="span12">
                <div id ="index-content" class="well-content no-search">
                  <ul class="dashed">
                     <li>- Volume Jenis BBM Pada Kolom Target RKAP (a) = Volume Sesuai Target RKAP</li>
                     <li>- Volume Komponen BBM Pada Kolom Target RKAP
                        <ul class="dashed">
                          <li>- BIO (FAME) (b) = (a) BIO(FAME) * 0,2 (Jika B20) atau (a) BIO(FAME) * 0,3 (Jika B30)</li>
                          <li>- HSD (c) = (a) HSD - ((b) - (a) BIO(FAME))</li>
                        </ul>
                     </li>
                     <li>- Perhitungan Formula Pada Kolom Target RKAP Diasumsikan Sesuai Dengan Jenis B20 atau B30 yang Dipilih Pada Master Penyerapan BBM
                      <ul class="dashed">
                        <li>- Jika B20 maka dikali 0,2</li>
                        <li>- Jika B20 maka dikali 0,3</li>
                      </ul>
                      </li>
                      <li>- Penyerapan (%) = (Volume Realisasi Pemakaian / Volume Komponen BBM Per Jenis BBM) / 100</li>
                  </ul>           
                </div>
            </div>
          </div>
        </div>  
        <br><br>         

    </div>
</div>

<form id="export_excel" action="<?php echo base_url('laporan/penyerapan_bbm/export_excel'); ?>" method="post">
   <input type="hidden" name="xlvl0">
   <input type="hidden" name="xlvl1">
   <input type="hidden" name="xlvl0_nama">
   <input type="hidden" name="xlvl1_nama">
   <input type="hidden" name="xbbm">
   <input type="hidden" name="xbbm_nama">
   <input type="hidden" name="xlvlid">
   <input type="hidden" name="xlvl">
   <input type="hidden" name="xtglawal">
   <input type="hidden" name="xtglakhir">
   <input type="hidden" name="xjenis">
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/penyerapan_bbm/export_pdf'); ?>" method="post"  target="_blank">   
   <input type="hidden" name="plvl0">
   <input type="hidden" name="plvl1">
   <input type="hidden" name="plvl0_nama">
   <input type="hidden" name="plvl1_nama">
   <input type="hidden" name="pbbm">
   <input type="hidden" name="pbbm_nama">
   <input type="hidden" name="plvlid">
   <input type="hidden" name="plvl">
   <input type="hidden" name="ptglawal">
   <input type="hidden" name="ptglakhir">
   <input type="hidden" name="pjenis">   
</form>



<script type="text/javascript">
    var icon = 'icon-remove-sign';
    var color = '#ac193d;';  
    var div_tampil = '1';

    var nomer = 1;
    var total = 100;
    var progres = 0;            
    var elem = document.getElementById("div_bar");

    $(document).ready(function() {

        $('#div_load').hide()

        var t_penerimaan = $('#t_penerimaan').dataTable({
          "responsive": true,
          "searching": false,
          "scrollCollapse": false,
          "bPaginate": false,
          "bLengthChange": false,
          "bFilter": false,
          "bSorting": false,
          "bInfo": false,
          "bAutoWidth": false,
          "ordering": false,
          "lengthMenu": [10, 25, 50, 100, 200],
          "language": {
             "decimal": ",",
             "thousands": ".",
             "emptyTable": "Tidak ada data untuk ditampilkan",
             "info": "Total Data: _MAX_",
             "infoEmpty": "Total Data: 0",
             "lengthMenu": "Jumlah Data _MENU_"
          },
        });      
              
        var t_penerimaan_total = $('#t_penerimaan_total').dataTable({
          // "scrollY": "450px",
          "searching": false,
          // "scrollX": false,
          "scrollCollapse": true,
          "bPaginate": false,
          "bLengthChange": false,
          "bFilter": false,
          "bSorting": false,
          "bInfo": false,
          "bAutoWidth": false,
          "ordering": false,
          "language": {
             "decimal": ",",
             "thousands": ".",
             "emptyTable": "Tidak ada data untuk ditampilkan",
             "info": "Total Data: _MAX_",
             "infoEmpty": "Total Data: 0",
             "lengthMenu": "Jumlah Data _MENU_"
          },          
        }); 

       $('#t_pemakaian').dataTable({
          "searching": false,
          "scrollCollapse": false,
          "bPaginate": false,
          "bLengthChange": false,
          "responsive": true,
          "bFilter": false,
          "bSorting": false,
          "bInfo": false,
          "bAutoWidth": false,
          "ordering": false,
          "lengthMenu": [10, 25, 50, 100, 200],
          "language": {
             "decimal": ",",
             "thousands": ".",
             "emptyTable": "Tidak ada data untuk ditampilkan",
             "info": "Total Data: _MAX_",
             "infoEmpty": "Total Data: 0",
             "lengthMenu": "Jumlah Data _MENU_"
          },
        });      

        var t_pemakaian_total = $('#t_pemakaian_total').dataTable({
          "searching": false,
          "scrollCollapse": false,
          "bPaginate": false,
          "bLengthChange": false,
          "bFilter": false,
          "bSorting": false,
          "bInfo": false,
          "bAutoWidth": false,
          "ordering": false,
          "lengthMenu": [10, 25, 50, 100, 200],
          "language": {
             "decimal": ",",
             "thousands": ".",
             "emptyTable": "Tidak ada data untuk ditampilkan",
             "info": "Total Data: _MAX_",
             "infoEmpty": "Total Data: 0",
             "lengthMenu": "Jumlah Data _MENU_"
          },
        });                                    
    });  

    $(".form_datetime").datepicker({
           format: "yyyy-mm-dd",
           autoclose: true,
           todayBtn: true,
           pickerPosition: "bottom-left"
    });

    function getRandom(min, max) {
      return Math.floor(Math.random() * (max - min)) + min;
    }

    setTglDefault();
    function setTglDefault() {
       var date = new Date();
       var tahun = date.getFullYear();
       var tglAwal = tahun + '-01-01';
       var tglAkhir = tahun + '-12-31';
       $('#tglawal').datepicker('update', tglAwal);
       $('#tglakhir').datepicker('update', tglAkhir);
    }  

    function setCekTgl() {
       var dateStart = $('#tglawal').val();
       var dateEnd = $('#tglakhir').val();
       if (dateEnd < dateStart) {
          $('#tglakhir').datepicker('update', dateStart);
       }
    }

    $('#tglawal').on('change', function() {
      var dateStart = $(this).val();
      $('#tglakhir').datepicker('setStartDate', dateStart);
      if ($('#tglakhir').val() == '') {}
      else {
         setCekTgl();
      }
    });

    $('#tglakhir').on('change', function() {
        setCekTgl();
    });        
     
    function get_data(vid) {      
       var lvl0 = $('#lvl0').val();
       var lvl1 = $('#lvl1').val();
       var tglAwal = $('#tglawal').val().replace(/-/g, ''); //02-11-2018 -> 02112018
       var tglAkhir = $('#tglakhir').val().replace(/-/g, '');
       var jns_bbm = $('#JNS_BBM').val();
       var awal_tahun = tglAwal.substring(0, 4);
       var akhir_tahun = tglAkhir.substring(0, 4);

       $('#jenis').val(2);
       $('#xkey').val(2);
       $('#xpdf').val(2);       

       if (tglAwal == '' && tglAkhir != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
       }
       else if (tglAkhir == '' && tglAwal != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
       }
       else if (awal_tahun != akhir_tahun) {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Periode Tahun harus sama-- </div>', function() {});
       }
       else {
          if (lvl0 !== "") {
             lvl0 = 'Regional';
             vlevelid = $('#lvl0').val();
             if (vlevelid == "00") {
                lvl0 = "Pusat";
             }
          }
          else {
             lvl0 = 'All';
             vlevelid = '';
          }
          if (lvl1 !== "") {
             lvl0 = 'Level 1';
             vlevelid = $('#lvl1').val();
          }
          if (tglAwal == '' && tglAkhir == '') {
             tglAwal = "-";
             tglAkhir = '-';
          }

          if (vid){
              if (vid=='1'){ //export excel
                  $('input[name="xlvl0"]').val($('#lvl0').val());
                  $('input[name="xlvl1"]').val($('#lvl1').val());
                  $('input[name="xbbm"]').val(jns_bbm);
                  $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
                  $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
                  $('input[name="xbbm_nama"]').val($('#JNS_BBM option:selected').text());
                  $('input[name="xlvlid"]').val(vlevelid);
                  $('input[name="xlvl"]').val(lvl0);
                  $('input[name="xtglawal"]').val(tglAwal);
                  $('input[name="xtglakhir"]').val(tglAkhir);
                  $('input[name="xjenis"]').val(div_tampil);                  

                  bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                    if (e) {
                       $('#export_excel').submit();
                    }
                  });                  
              } else { //export pdf
                  $('input[name="plvl0"]').val($('#lvl0').val());
                  $('input[name="plvl1"]').val($('#lvl1').val());
                  $('input[name="pbbm"]').val(jns_bbm);
                  $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
                  $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
                  $('input[name="pbbm_nama"]').val($('#JNS_BBM option:selected').text());
                  $('input[name="plvlid"]').val(vlevelid);
                  $('input[name="plvl"]').val(lvl0);
                  $('input[name="ptglawal"]').val(tglAwal);
                  $('input[name="ptglakhir"]').val(tglAkhir);
                  $('input[name="pjenis"]').val(div_tampil);               

                  bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                    if (e) {
                       $('#export_pdf').submit();
                    }
                  });
              }


          } else {
              if(div_tampil == '') {
                get_penerimaan(tglAwal,tglAkhir,lvl0,vlevelid,jns_bbm);
                get_penerimaan_total(tglAwal, tglAkhir, lvl0, vlevelid, jns_bbm);
                $('#div_penerimaan').show();
                $('#div_pemakaian').hide();
              }
              else if (div_tampil=='1'){
                get_penerimaan(tglAwal,tglAkhir,lvl0,vlevelid,jns_bbm);
                get_penerimaan_total(tglAwal, tglAkhir, lvl0, vlevelid, jns_bbm);
                $('#div_penerimaan').show();
                $('#div_pemakaian').hide();
              } else {
                get_pemakaian(tglAwal,tglAkhir,lvl0,vlevelid,jns_bbm);
                get_pemakaian_total(tglAwal, tglAkhir, lvl0, vlevelid, jns_bbm);
                $('#div_penerimaan').hide();
                $('#div_pemakaian').show();            
              }
          }

                    
       };
    }    

    function get_penerimaan(tglAwal, tglAkhir, lvl0, vlevelid, jns_bbm) {
       $.ajax({
          type: "POST",
          url: "<?php echo base_url('laporan/penyerapan_bbm/get_table_penerimaan'); ?>",
          data: {
             "TGLAWAL": tglAwal,
             "TGLAKHIR": tglAkhir,
             "LEVEL": lvl0,
             "LEVEL_ID": vlevelid,
             "JNS_BBM": jns_bbm
          },
          beforeSend: function() {
             $('#div_load').show();
             bootbox.dialog('<div class="loading-progress"></div>');

             progres = getRandom(25,50);
             nomer = progres;
             elem.style.width = progres + '%';
             elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';
          },
          error: function(data) {
             bootbox.hideAll();
             $('#div_load').hide('slow');
             msgGagal(data.statusText);
          },
          success: function(data) {
           
            var load = $("#t_penerimaan tbody").html(data);
            if(load) {                            
                progres = 100;
                nomer = progres;
                elem.style.width = progres + '%';
                elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';                  

                bootbox.hideAll();                

                setTimeout( function(){
                  $('#div_load').hide('slow');
                  $('html, body').animate({
                     scrollTop: $("#div_bawah").offset().top
                  }, 1000);      
                }, 500);
            }
          }
       });
    }    

    function get_penerimaan_total(tglAwal, tglAkhir, lvl0, vlevelid, jns_bbm) {
       $.ajax({
          type: "POST",
          url: "<?php echo base_url('laporan/penyerapan_bbm/get_table_penerimaan_total'); ?>",
          data: {
             "TGLAWAL": tglAwal,
             "TGLAKHIR": tglAkhir,
             "LEVEL": lvl0,
             "LEVEL_ID": vlevelid,
             "JNS_BBM": jns_bbm
          },
          beforeSend: function() {
             // bootbox.hideAll();
             // bootbox.dialog('<div class="loading-progress"></div>');
              setTimeout( function(){
                progres = getRandom(60,90);
                nomer = progres;
                elem.style.width = progres + '%';
                elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';                             
              }, 1000);

          },
          error: function(data) {
             bootbox.hideAll();
             $('#div_load').hide('slow');
             msgGagal(data.statusText);
          },
          success: function(data) {
            $("#t_penerimaan_total tbody").html(data);
            // bootbox.hideAll();
          }
       });
    }   

    function get_pemakaian(tglAwal, tglAkhir, lvl0, vlevelid, jns_bbm) {
       $.ajax({
          type: "POST",
          url: "<?php echo base_url('laporan/penyerapan_bbm/get_table_pemakaian'); ?>",
          data: {
             "TGLAWAL": tglAwal,
             "TGLAKHIR": tglAkhir,
             "LEVEL": lvl0,
             "LEVEL_ID": vlevelid,
             "JNS_BBM": jns_bbm
          },
          beforeSend: function() {
             $('#div_load').show();
             bootbox.dialog('<div class="loading-progress"></div>');

             progres = getRandom(25,50);
             nomer = progres;
             elem.style.width = progres + '%';
             elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';
          },
          error: function(data) {
             bootbox.hideAll();
             $('#div_load').hide('slow');
             msgGagal(data.statusText);
          },
          success: function(data) {
            var load = $("#t_pemakaian tbody").html(data);
            if(load) {
                progres = 100;
                nomer = progres;
                elem.style.width = progres + '%';
                elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';                  

                bootbox.hideAll();                

                setTimeout( function(){
                  $('#div_load').hide('slow');
                  $('html, body').animate({
                     scrollTop: $("#div_bawah").offset().top
                  }, 1000);      
                }, 500);     
            }       
          }
       });
    }

    function get_pemakaian_total(tglAwal, tglAkhir, lvl0, vlevelid, jns_bbm) {
       $.ajax({
          type: "POST",
          url: "<?php echo base_url('laporan/penyerapan_bbm/get_table_pemakaian_total'); ?>",
          data: {
             "TGLAWAL": tglAwal,
             "TGLAKHIR": tglAkhir,
             "LEVEL": lvl0,
             "LEVEL_ID": vlevelid,
             "JNS_BBM": jns_bbm
          },
          beforeSend: function() {
             // bootbox.hideAll();
             // bootbox.dialog('<div class="loading-progress"></div>');
              setTimeout( function(){
                progres = getRandom(60,90);
                nomer = progres;
                elem.style.width = progres + '%';
                elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';                             
              }, 1000);             
          },
          error: function(data) {
             bootbox.hideAll();
             $('#div_load').hide('slow');
             msgGagal(data.statusText);
          },
          success: function(data) {
            $("#t_pemakaian_total tbody").html(data);
            // bootbox.hideAll();
          }
       });
    }          

    function setTampil(vid){
      if (vid=='1'){
        div_tampil = '1';
      } else {
        div_tampil = '2';
      }  
      get_data(''); 
    }

    $('#button-load').click(function() {
        get_data('');        
    }); 

    $('#button-excel').click(function(e) {
       get_data(1);
    });    

    $('#button-pdf').click(function(e) {
       get_data(2);
    });

</script>

<script type="text/javascript">
   jQuery(function($) {
      function setDefaultLv1() {
         $('select[name="COCODE"]').empty();
         $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
      }
      $('select[name="ID_REGIONAL"]').on('change', function() {
         var stateID = $(this).val();
         var vlink_url = '<?php echo base_url()?>laporan/penyerapan_bbm/get_options_lv1/' + stateID;
         setDefaultLv1();
         if (stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
               url: vlink_url,
               type: "GET",
               dataType: "json",
               success: function(data) {
                  $.each(data, function(key, value) {
                     $('select[name="COCODE"]').append('<option value="' + value.COCODE + '">' + value.LEVEL1 + '</option>');
                  });
                  bootbox.hideAll();
               }
            });
         }
      });
   });
</script>