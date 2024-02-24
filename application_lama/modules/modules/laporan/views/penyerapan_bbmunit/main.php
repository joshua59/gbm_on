<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>
<style type="text/css">

    .dataTables_scrollHeadInner {
     width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
     width: 100% !important;
     border: 1px solid #696969;
     border-collapse:collapse;    
    }   

</style>
</style>
<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
      <div class="row-fluid">
        <div class="span12">
          <div class="well-content no-search">
              <div id="div_load">               
                  <div id="div_progress">
                    <div id="div_bar">0%</div>
                  </div>
                  <br>
              </div>            
              <button class="btn green",id="button-penerimaan" onclick="validate(1)" style="font-weight: normal;"><i class="icon-exchange"></i> Tabel Penerimaan</button>
              <button class="btn green",id="button-penerimaan" onclick="validate(2)" style="font-weight: normal;"><i class="icon-exchange"></i> Tabel Pemakaian</button>
          </div>    
        </div>
        <div class="well-content no-search">
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
                        <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-filter')); ?> 
                        <input type="hidden" id="TIPE">
                    </div>
                </div>
            </div>                        
            <div id="div_bawah"></div>
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
            <br>
          <?php echo form_close(); ?>          
        </div>        
      </div>      
    </div>    
   
    <div class="well-content no-search">
        <div id="div_table">
          <div id="tabel_penerimaan" style="display: none">
            <table class="table table-bordered table-striped" id="dataTable">
              <thead>
                <tr>
                  <th rowspan="2" width="20%">REGIONAL</th>
                  <th rowspan="2" width="20%">LEVEL 1</th>
                  <th colspan="3" width="60%">TOTAL VOLUME</th>
                </tr>
                <tr>
                  <th>TARGET RKAP<br>(L)</th>
                  <th>PENERIMAAN<br>(L)</th>
                  <th>PENYERAPAN<br>(%)</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <div id="tabel_pemakaian" style="display: none">
            <table class="table table-bordered table-striped" id="dataTables">
              <thead>
                <tr>
                  <th rowspan="2" width="20%">REGIONAL</th>
                  <th rowspan="2" width="20%">LEVEL 1</th>
                  <th colspan="3" width="60%">TOTAL VOLUME</th>
                </tr>
                <tr>
                  <th>TARGET RKAP<br>(L)</th>
                  <th>PEMAKAIAN<br>(L)</th>
                  <th>PENYERAPAN<br>(%)</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
    </div>
    <br><br>

<form id="export_excel" action="<?php echo base_url('laporan/penyerapan_bbmunit/export_excel'); ?>" method="post">
  <input type="hidden" name="xlvl0">
  <input type="hidden" name="xlvl1">
  <input type="hidden" name="xlvl0_nama">
  <input type="hidden" name="xlvl1_nama">
  <input type="hidden" name="xlvlid">
  <input type="hidden" name="xlvl">
  <input type="hidden" name="xtglawal">
  <input type="hidden" name="xtglakhir">
  <input type="hidden" name="xjenis">
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/penyerapan_bbmunit/export_pdf'); ?>" method="post"  target="_blank">   
  <input type="hidden" name="plvl0">
  <input type="hidden" name="plvl1">
  <input type="hidden" name="plvl0_nama">
  <input type="hidden" name="plvl1_nama">
  <input type="hidden" name="plvlid">
  <input type="hidden" name="plvl">
  <input type="hidden" name="ptglawal">
  <input type="hidden" name="ptglakhir">
  <input type="hidden" name="pjenis">   
</form>  
</div>   


<script>

  var nomer = 1;
  var total = 100;
  var progres = 0;            
  var elem = document.getElementById("div_bar");  

  function getRandom(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
  }  
  
  function setDefaultLv1() {

      $('select[name="COCODE"]').empty();
      $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
  }

  var btnGetDataTable = Highcharts.getOptions().exporting.buttons.contextButton.menuItems;

  $(document).ready(function() {

    $('#div_load').hide();
    $('#tglawal').val(getDateStart());
    $('#tglakhir').val(getDateEnd());
    
    $('select[name="ID_REGIONAL"]').on('change', function() {
      setDefaultLv1();
      var stateID = $(this).val();
      var vlink_url = '<?php echo base_url()?>laporan/penyerapan_bbmunit/get_options_lv1/'+stateID;
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

    $('#button-filter').click(function() {
      var tipe = $('#TIPE').val();
      if(tipe == 1) {
        validate(1);
      } else if (tipe == 2){
        validate(2);
      } else {
        validate(1);
      }
    })

    $('#button-excel').click(function() {
      var tipe = $('#TIPE').val();
      if(tipe == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;">'+
          '<i class="icon-remove-sign"></i>-- Pilih Jenis Grafik ! --</div>', function() {});
      } else {
        export_excel();
      }
    })

    $('#button-pdf').click(function() {
      var tipe = $('#TIPE').val();
      if(tipe == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;">'+
          '<i class="icon-remove-sign"></i>-- Pilih Jenis Grafik ! --</div>', function() {});
      } else {
        export_pdf();
      }
    })

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
        $('#tglakhir').val(setDateEnd(dateStart));
        setCekTgl();
      }
    });

    $('#tglakhir').on('change', function() {

      var tanggal_awal = $('#tglawal').val().replace(/-/g, '');
      var tahun_awal = tanggal_awal.substring(0,4);
      var tanggal_akhir = $(this).val().replace(/-/g, '');
      var tahun_akhir = tanggal_akhir.substring(0,4);

      if(tahun_akhir != tahun_awal) {
        bootbox.alert('<div class="box-title" style="color:#ac193d;">'+
        '<i class="icon-remove-sign"></i>-- Periode harus di tahun yang sama ! --</div>', function() {
          $('#tglakhir').val('');
        });
      } else {
        setCekTgl();
      }
      
    });

  })

  function validate(tipe) {
    $('#tabel_penerimaan').hide();
    $('#tabel_pemakaian').hide();
    var lvl0        = $('#lvl0').val();
    var lvl1        = $('#lvl1').val();
    var tglAkhir    = $('#tglakhir').val().replace(/-/g, '');
    var tglAwal     = $('#tglawal').val().replace(/-/g, '');//02-11-2018
    var tglAkhir    = $('#tglakhir').val().replace(/-/g, '');
    var awal_tahun  = tglAwal.substring(0,4); 
    var awal_bulan  = tglAwal.substring(4,6);
    var awal_hari   = tglAwal.substring(6,8); 
    var awalParsed  = awal_hari.concat(awal_bulan, awal_tahun);
    var akhir_tahun = tglAkhir.substring(0,4);
    var akhir_bulan = tglAkhir.substring(4,6);
    var akhir_hari  = tglAkhir.substring(6,8);
    var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

    if(akhir_tahun > awal_tahun ) {
      bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> -- Tidak boleh lintas Tahun ! --</div>', function() {});
    }else if(tglAwal == '' && tglAkhir == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> -- Tanggal Awal dan Tanggal Akhir tidak boleh kosong ! --</div>', function() {});
    } else if(tglAwal == '') {
         bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>-- Tanggal Awal tidak boleh kosong ! --</div>', function() {});
    } else if(tglAkhir == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> -- Tanggal Akhir tidak boleh kosong ! --</div>', function() {});
    } else {
        var tglAwal= $('#tglawal').val().replace(/-/g, '');//02-11-2018
        var tglAkhir =$('#tglakhir').val().replace(/-/g, '');
        if(tglAkhir < tglAwal) {
             bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> -- Tanggal Akhir tidak boleh lebih kecil dari Tanggal Awal ! --</div>', function() {
                    $('#tglakhir').val('');
             });
        } else {
            
            if(tipe == '') {
              getAllPenerimaan(tglAwal,tglAkhir,lvl0,lvl1);
              $('#TIPE').val(1);
            } else {
              if(tipe == 1) {
                getAllPenerimaan(tglAwal,tglAkhir,lvl0,lvl1);
                $('#TIPE').val(1);
              } else if(tipe == 2) {
                getAllPemakaian(tglAwal,tglAkhir,lvl0,lvl1);
                $('#TIPE').val(2);
              }
            }
        }
    }
  }

  function getAllPenerimaan(tglAwal,tglAkhir,lvl0,lvl1) {

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

    if (lvl0 == "") {
        lvl0 = 'All';
        vlevelid = '';
    }

    getTablePenerimaan(tglAwal,tglAkhir,lvl0,vlevelid);
    
  }

  function getTablePenerimaan(tglAwal,tglAkhir,lvl0,vlevelid) {
    var link_url = '<?php echo base_url() ?>laporan/penyerapan_bbmunit/get_tabel_penerimaan';
    $.ajax({
      data: {                       
         "TGLAWAL": tglAwal,
         "TGLAKHIR": tglAkhir,
         "LEVEL": lvl0,
         "LEVEL_ID":vlevelid,
         "JNS_BBM": ''
      },
      url: link_url,
      type: "POST",
      beforeSend: function() {
         $('#div_load').show();
         bootbox.dialog('<div class="loading-progress"></div>');

         progres = getRandom(25,70);
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
        var load = $("#dataTable tbody").html(data); 
        $('#tabel_pemakaian').hide();
        $('#tabel_penerimaan').show();
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

  function getAllPemakaian(tglAwal,tglAkhir,lvl0,lvl1) {

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

    if (lvl0 == "") {
        lvl0 = 'All';
        vlevelid = '';
    }

    getTablePemakaian(tglAwal,tglAkhir,lvl0,vlevelid);
    
  }

  function getTablePemakaian(tglAwal,tglAkhir,lvl0,vlevelid) {
  
    var link_url = '<?php echo base_url() ?>laporan/penyerapan_bbmunit/get_tabel_pemakaian';
    $.ajax({
      data: {                       
         "TGLAWAL": tglAwal,
         "TGLAKHIR": tglAkhir,
         "LEVEL": lvl0,
         "LEVEL_ID":vlevelid,
         "JNS_BBM": ''
      },
      url: link_url,
      type: "POST",
      beforeSend: function() {
         $('#div_load').show();
         bootbox.dialog('<div class="loading-progress"></div>');

         progres = getRandom(25,70);
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
        $('#tabel_penerimaan').hide();
        $('#tabel_pemakaian').show();

        var load = $("#dataTables tbody").html(data); 
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

  // FORMATTER //

  function getDateStart() {
    var d = new Date(),
    month = '01';
    day = '01';
    year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month , day].join('-');
  }

  function getDateEnd() {
    var d = new Date(),
    month = '12';
    day = '31';
    year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month , day].join('-');
  }

  function setDateEnd(date) {
    var d = new Date(date),
    month = '12';
    day = '31';
    year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month , day].join('-');
  }

  // EXPORT

  function export_excel() {
    var lvl0        = $('#lvl0').val();
    var lvl1        = $('#lvl1').val();
    var tglAwal     = $('#tglawal').val().replace(/-/g, '');//02-11-2018
    var tglAkhir    = $('#tglakhir').val().replace(/-/g, '');

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

    if (lvl0 == "") {
        lvl0 = 'All';
        vlevelid = '';
    }
    
    $('input[name="xlvl0"]').val($('#lvl0').val());
    $('input[name="xlvl1"]').val($('#lvl1').val());
    $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
    $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
    $('input[name="xlvl"]').val(lvl0);
    $('input[name="xlvlid"]').val(vlevelid);
    $('input[name="xtglawal"]').val(tglAwal);
    $('input[name="xtglakhir"]').val(tglAkhir);
    $('input[name="xjenis"]').val($('#TIPE').val());  

    bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
      if (e) {
         $('#export_excel').submit();
      }
    });
  }

  function export_pdf() {
    var lvl0        = $('#lvl0').val();
    var lvl1        = $('#lvl1').val();
    var tglAwal     = $('#tglawal').val().replace(/-/g, '');//02-11-2018
    var tglAkhir    = $('#tglakhir').val().replace(/-/g, '');

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

    if (lvl0 == "") {
        lvl0 = 'All';
        vlevelid = '';
    }
    
    $('input[name="plvl0"]').val($('#lvl0').val());
    $('input[name="plvl1"]').val($('#lvl1').val());
    $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
    $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
    $('input[name="plvl"]').val(lvl0);
    $('input[name="plvlid"]').val(vlevelid);
    $('input[name="ptglawal"]').val(tglAwal);
    $('input[name="ptglakhir"]').val(tglAkhir);
    $('input[name="pjenis"]').val($('#TIPE').val());  

    bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
      if (e) {
         $('#export_pdf').submit();
      }
    });
  }
</script>