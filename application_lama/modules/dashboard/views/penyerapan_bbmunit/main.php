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
              <button class="btn green",id="button-penerimaan" onclick="validate(1)" style="font-weight: normal;"><i class="icon-exchange"></i> Grafik Penerimaan</button>
              <button class="btn green",id="button-penerimaan" onclick="validate(2)" style="font-weight: normal;"><i class="icon-exchange"></i> Grafik Pemakaian</button>
          </div>    
        </div>
        <div class="well-content no-search">
           <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
            <div class="form_row">
                <div class="pull-left span3">
                  <br>
                    <label for="password" class="control-label">Regional : </label>
                    <div class="controls">
                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                  <br>
                    <label for="password" class="control-label">Level 1 : </label>
                    <div class="controls">
                        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                    </div>
                </div>
                <div class="pull-left span5">
                  <br>
                    <label for="password" class="control-label">Periode : </label>
                    <div class="controls">
                        <?php echo form_input('TGL_DARI', !empty($TGL_DARI) ? $TGL_DARI : '', 'class="form_datetime" style="width: 99px;" placeholder="Tanggal awal" id="tglawal" autocomplete="off"'); ?>
                        <label for="">s/d</label>
                        <?php echo form_input('TGL_SAMPAI', !empty($TGL_SAMPAI) ? $TGL_SAMPAI : '', 'class="form_datetime" style="width: 99px;" placeholder="Tanggal akhir" id="tglakhir" autocomplete="off"'); ?>
                        <label>&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-filter')); ?>
                        <input type="hidden" id="TIPE">
                    </div>
                </div>
           </div>
           <br>
           <?php echo form_close(); ?>
        </div>
      </div>
    </div>
    <div class="well-content no-search">
        <div id="container_grafik" style="height: 1000px"></div>
        <button id="btn_label">Hide Labels</button>
    </div>

    <div class="well-content no-search">
        <div id="div_table">
          <div id="tabel_penerimaan" style="display: none">
            <table class="table table-bordered" id="dataTable">
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
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div id="tabel_pemakaian" style="display: none">
            <table class="table table-bordered" id="dataTables">
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
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
    <br><br>
</div>   


<script>
  
  function setDefaultLv1() {

      $('select[name="COCODE"]').empty();
      $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
  }

  var btnGetDataTable = Highcharts.getOptions().exporting.buttons.contextButton.menuItems;

  $(document).ready(function() {

    $('#tglawal').val(getDateStart());
    $('#tglakhir').val(getDateEnd());
    $('#btn_label').hide();
    getDataTable = function () {
      var tipe = $('#TIPE').val();
      if(tipe == 1) {
          $('#tabel_pemakaian').hide();
          $('#tabel_penerimaan').show();
      } else if(tipe == 2) {
          $('#tabel_penerimaan').hide();
          $('#tabel_pemakaian').show();
      } else {
          return false;
      }
      $('html, body').animate({scrollTop: $('#div_table').offset().top}, 1000);      
    };

    btnGetDataTable.push(
      {
        separator: true
      },{
        text: "Lihat Data Tabel",
        onclick: getDataTable
      }
    );
    
    $('select[name="ID_REGIONAL"]').on('change', function() {
      setDefaultLv1();
      var stateID = $(this).val();
      var vlink_url = '<?php echo base_url()?>dashboard/penyerapan_bbmunit/get_options_lv1/'+stateID;
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
        validate(1);   }
    })

    $('#btn_label').click(function() {
      var btn_text = $('#btn_label').text();
      var chart = $('#container_grafik').highcharts();
      var opt = '';
      var total = chart.series.length;      
     

      if (btn_text=='Hide Labels'){
          $('.svg').fadeOut();
          $('#btn_label').text('Show Labels');
      } else {
          $('.svg').fadeIn();
          $('#btn_label').text('Hide Labels');
      }
    });

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

  function getNamaUnit(){
    var vUnit = '';

    if ($('#lvl0').val() && $('#lvl0').val()!='00'){
        vUnit = $('#lvl0 option:selected').text()+'<br>';
    }
    if ($('#lvl1').val() && $('#lvl1').val() !='0'){
        vUnit = vUnit + $('#lvl1 option:selected').text();
    }

    return vUnit;
  }

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
    $('#btn_label').show();
    getGrafikPenerimaan(tglAwal,tglAkhir,lvl0,vlevelid);
    getTablePenerimaan(tglAwal,tglAkhir,lvl0,vlevelid);
    
  }

  function getTablePenerimaan(tglAwal,tglAkhir,lvl0,vlevelid) {

    var link_url = '<?php echo base_url() ?>dashboard/penyerapan_bbmunit/get_tabel_penerimaan';
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
      success:function(data) {
        $("#dataTable tbody").html(data);

      }
    });
  }

  function getGrafikPenerimaan(tglAwal,tglAkhir,lvl0,vlevelid) {

    var link_url = '<?php echo base_url() ?>dashboard/penyerapan_bbmunit/get_grafik_penerimaan';
    $.ajax({
      data: {                       
         "TGLAWAL": tglAwal,
         "TGLAKHIR": tglAkhir,
         "LEVEL": lvl0,
         "LEVEL_ID":vlevelid
      },
      url: link_url,
      type: "POST",
      beforeSend: function() {
         bootbox.modal('<div class="loading-progress"></div>');
      },
      success:function(data) {
          setGrafikPenerimaan(data);
      }
    });
  }

  function setGrafikPenerimaan(data) {

    var obj = JSON.parse(data);
    var t_awal      = $('#tglawal').val();//02-11-2018
    var t_akhir     = $('#tglakhir').val();//02-11-2018
    var awal = dateFormat(t_awal);
    var akhir = dateFormat(t_akhir);
    var UNIT = [];
    var TARGET = [];
    var REALISASI = [];
    var PERSEN = [];

    $.each(obj, function(index, value) {

      var TOTAL_TARGET = value.TOTAL_TARGET == null ? "0.00" : value.TOTAL_TARGET;
      var TOTAL_PENERIMAAN = value.TOTAL_PENERIMAAN == null ? "0.00" : value.TOTAL_PENERIMAAN;

      UNIT.push(value.LEVEL1);
      TOTAL_TARGET == [] || TOTAL_TARGET == "0.00" ? TARGET.push(0) : TARGET.push(parseFloat(value.TOTAL_TARGET));
      TOTAL_PENERIMAAN == [] || TOTAL_PENERIMAAN  == "0.00" ? REALISASI.push(0) : REALISASI.push(parseFloat(value.TOTAL_PENERIMAAN));
    });

    for(i = 0; i < TARGET.length; i++) {

      var divide = (REALISASI[i] / TARGET[i]) * 100;
      if (divide == Number.POSITIVE_INFINITY || divide == Number.NEGATIVE_INFINITY || isNaN(divide))
      {
        PERSEN.push(0);
      } else {
        PERSEN.push(divide);
      }
    }


    if(getNamaUnit() == '') {
        var unit = 'PUSAT';
    } else {
        var unit = getNamaUnit();
    }

    $('#container_grafik').highcharts({
        chart: {
          type: 'bar',
          events: {
            load: function(event) {
              bootbox.hideAll();
            },
            render: function() {
              const chart = this,
                xAxis = chart.xAxis[0],
                yAxis = chart.yAxis[0],
                offsetX = 5;

              let customElems = chart.customElems || [],
                y,
                x,
                element;

              if (customElems.length) {
                customElems.forEach(elem => {
                  elem.destroy();
                });

                customElems.length = 0;
              }

              var series_s_y = [];
              var series_d_y = [];
              var series_x   = [];
              var p          = [];
              if (chart.series[0].visible) {
                chart.series[0].points.forEach((point, i) => {
                    x = yAxis.toPixels(point.y) + 10;
                    y = xAxis.toPixels(point.x);
                    series_s_y.push(x);
                    series_x.push(y);
                });
              }

              if (chart.series[1].visible) {
                chart.series[1].points.forEach((point, i) => {
                    x = yAxis.toPixels(point.y) + 10;
                    y = xAxis.toPixels(point.x);
                    series_d_y.push(x);

                    if (!chart.series[0].visible) {
                        series_x.push(y);
                    }
                });
              }
              for (i = 0; i < chart.series[0].points.length; i++) {

                if (series_d_y.length && series_s_y.length) {
                    if (series_d_y[i] > series_s_y[i]) {
                        p.push(series_d_y[i]);
                    } else {
                        p.push(series_s_y[i]);
                    }
                } else if (series_d_y.length) {
                    p.push(series_d_y[i]);
                } else if (series_s_y.length) {
                    p.push(series_s_y[i]);
                }

                element = chart.renderer.text(
                    `${PERSEN[i].toFixed(2)} %`,
                    p[i],
                    series_x[i]
                ).attr({
                    "fill": '#000',
                    "font-weight": "bold",
                    "class": "svg"
                }).add().toFront();

                customElems.push(element);
              }
              chart.customElems = customElems;
            }
          }
        },
        title: {
          text: 'Penyerapan BBM Per Unit<br>(Penerimaan)'
        },
        subtitle: {
          text:  unit +'<br>'+'Periode ' + awal + ' s/d '+ akhir
        },
        xAxis: {
          categories: UNIT,
          crosshair: true
        },
        yAxis: {
          min: 0,
          reversedStacks: false,
          labels: {
              formatter: function () {
              return  toRp(this.value / 1000);
            }   
        },
        title: {
          text: 'Volume x 1000 (L)'
        }
        },
        tooltip: {
          formatter: function() {
            var s = '<table>';
            s += '<tr><td style="padding:0;font-weight:bold;border-style:none">'+ this.x +'</td></tr>';
            var chart = this.points[0].series.chart; //get the chart object
            var categories = chart.xAxis[0].categories; //get the categories array
            var index = 0;

            while(this.x !== categories[index]){index++;} //compute the index of corr y value in each data arrays           
            $.each(chart.series, function(i, series) { //loop through series array
                if(series.name == 'Penyerapan') {
                    var col = '#7cb5ec';
                    var nama = 'Penyerapan (%)';
                    var num = (series.data[index].y).toFixed(2);
                } else {
                    var col = series.color;
                    var nama = series.name;
                    var num = series.data[index].y;
                }
                s += '<tr>'+
                '<td style="color:'+col+';padding:0;font-weight:bold;border-style:none">'+ nama +'</td>'+
                '<td>:</td>'+
                '<td style="padding:0;font-weight:bold;border-style:none">'+ toRp(num) +'</td>'+
                '</tr>';
            }); 
            s +=  '</table>';        
            return s;
          },
          footerFormat: '</table>',
          shared: true,
          useHTML: true
        },
        plotOptions: {
          column: {
            pointPadding: 0,
            borderWidth: 0
          },
          series: {
            pointPadding: 0,
            dataLabels: {
              enabled: true,
              allowOverlap: true                      
            },
            events : {
              legendItemClick: function () {
                $('#btn_label').text('Hide Labels');
              }
            }
          }
        },
        exporting: {
          buttons: {
              contextButton: {
                  menuItems: btnGetDataTable
              }
          }
        },
        series: [
        {
          name: 'Target Penyerapan (L)',
          color :' #009933',
          data: TARGET,
          dataLabels: {
            enabled: false
          }
        },
        {
          name: 'Realisasi Penyerapan (L)',
          color : '#00ff00',
          data: REALISASI,
          dataLabels: {
            enabled: false
          }
        },
        {
          name: 'Penyerapan',
          data: PERSEN,
          pointWidth: 1,
          showInLegend: false,
          visible :false
        },
        ]
    })

       
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
    $('#btn_label').show();
    getGrafikPemakaian(tglAwal,tglAkhir,lvl0,vlevelid);
    getTablePemakaian(tglAwal,tglAkhir,lvl0,vlevelid);
    
  }

  function getTablePemakaian(tglAwal,tglAkhir,lvl0,vlevelid) {

    var link_url = '<?php echo base_url() ?>dashboard/penyerapan_bbmunit/get_tabel_pemakaian';
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
         bootbox.modal('<div class="loading-progress"></div>');
      },
      success:function(data) {
        $("#dataTables tbody").html(data);
      }
    });
  }

  function getGrafikPemakaian(tglAwal,tglAkhir,lvl0,vlevelid) {

    var link_url = '<?php echo base_url() ?>dashboard/penyerapan_bbmunit/get_grafik_pemakaian';
    $.ajax({
      data: {                       
         "TGLAWAL": tglAwal,
         "TGLAKHIR": tglAkhir,
         "LEVEL": lvl0,
         "LEVEL_ID":vlevelid
      },
      url: link_url,
      type: "POST",
      success:function(data) {
          setGrafikPemakaian(data);
      }
    });
  }

  function setGrafikPemakaian(data) {

    var obj = JSON.parse(data);
  
    var t_awal      = $('#tglawal').val();//02-11-2018
    var t_akhir     = $('#tglakhir').val();//02-11-2018
    var awal = dateFormat(t_awal);
    var akhir = dateFormat(t_akhir);
    var UNIT = [];
    var TARGET = [];
    var REALISASI = [];
    var PERSEN = [];

    $.each(obj, function(index, value) {

      var TOTAL_TARGET = value.TOTAL_TARGET == null ? "0.00" : value.TOTAL_TARGET;
      var TOTAL_PEMAKAIAN = value.TOTAL_PEMAKAIAN == null ? "0.00" : value.TOTAL_PEMAKAIAN;

      UNIT.push(value.LEVEL1);
      TOTAL_TARGET == [] || TOTAL_TARGET == "0.00" ? TARGET.push(0) : TARGET.push(parseFloat(value.TOTAL_TARGET));
      TOTAL_PEMAKAIAN == [] || TOTAL_PEMAKAIAN == "0.00" ? REALISASI.push(0) : REALISASI.push(parseFloat(value.TOTAL_PEMAKAIAN));
    });

    for(i = 0; i < TARGET.length; i++) {

      var divide = (REALISASI[i] / TARGET[i]) * 100;
      if (divide == Number.POSITIVE_INFINITY || divide == Number.NEGATIVE_INFINITY || isNaN(divide))
      {
        PERSEN.push(0);
      } else {
        PERSEN.push(divide);
      }
    }
    if(getNamaUnit() == '') {
        var unit = 'PUSAT';
    } else {
        var unit = getNamaUnit();
    }

    $('#container_grafik').highcharts({
        chart: {
          type: 'bar',
          events: {
            load: function(event) {
              bootbox.hideAll();
            },
            render: function() {
              const chart = this,
                xAxis = chart.xAxis[0],
                yAxis = chart.yAxis[0],
                offsetX = 5;

              let customElems = chart.customElems || [],
                y,
                x,
                element;

              if (customElems.length) {
                customElems.forEach(elem => {
                  elem.destroy();
                });

                customElems.length = 0;
              }

              var series_s_y = [];
              var series_d_y = [];
              var series_x   = [];
              var p          = [];
            
              if (chart.series[0].visible) {
                chart.series[0].points.forEach((point, i) => {
                    x = yAxis.toPixels(point.y) + 10;
                    y = xAxis.toPixels(point.x);
                    series_s_y.push(x);
                    series_x.push(y);
                });
              }

              if (chart.series[1].visible) {
                chart.series[1].points.forEach((point, i) => {
                    x = yAxis.toPixels(point.y) + 10;
                    y = xAxis.toPixels(point.x);
                    series_d_y.push(x);

                    if (!chart.series[0].visible) {
                        series_x.push(y);
                    }
                });
              }
              for (i = 0; i < chart.series[0].points.length; i++) {

                if (series_d_y.length && series_s_y.length) {
                    if (series_d_y[i] > series_s_y[i]) {
                        p.push(series_d_y[i]);
                    } else {
                        p.push(series_s_y[i]);
                    }
                } else if (series_d_y.length) {
                    p.push(series_d_y[i]);
                } else if (series_s_y.length) {
                    p.push(series_s_y[i]);
                }

                element = chart.renderer.text(
                    `${PERSEN[i].toFixed(2)} %`,
                    p[i],
                    series_x[i]
                ).attr({
                    "fill": '#000',
                    "font-weight": "bold",
                    "class": "svg"
                }).add().toFront();

                customElems.push(element);
              }
              chart.customElems = customElems;
            }
          }
        },
        title: {
          text: 'Penyerapan BBM Per Unit<br>(Pemakaian)'
        },
        subtitle: {
          text:  unit +'<br>'+'Periode ' + awal + ' s/d '+ akhir
        },
        xAxis: {
          categories: UNIT,
          crosshair: true
        },
        yAxis: {
          min: 0,
          reversedStacks: false,
          labels: {
              formatter: function () {
              return  toRp(this.value / 1000);
            }   
        },
        title: {
          text: 'Volume x 1000 (L)'
        }
        },
        tooltip: {
          formatter: function() {
            var s = '<table>';
            s += '<tr><td style="padding:0;font-weight:bold;border-style:none">'+ this.x +'</td></tr>';
            var chart = this.points[0].series.chart; //get the chart object
            var categories = chart.xAxis[0].categories; //get the categories array
            var index = 0;

            while(this.x !== categories[index]){index++;} //compute the index of corr y value in each data arrays           
            $.each(chart.series, function(i, series) { //loop through series array
                if(series.name == 'Penyerapan') {
                    var col = '#7cb5ec';
                    var nama = 'Penyerapan (%)';
                    var num = (series.data[index].y).toFixed(2);
                } else {
                    var col = series.color;
                    var nama = series.name;
                    var num = series.data[index].y;
                }
                s += '<tr>'+
                '<td style="color:'+col+';padding:0;font-weight:bold;border-style:none">'+ nama +'</td>'+
                '<td>:</td>'+
                '<td style="padding:0;font-weight:bold;border-style:none">'+ toRp(num) +'</td>'+
                '</tr>';
            }); 
            s +=  '</table>';        
            return s;
          },
          footerFormat: '</table>',
          shared: true,
          useHTML: true
        },
        plotOptions: {
          column: {
            pointPadding: 0,
            borderWidth: 0
          },
          series: {
            pointPadding: 0,
            dataLabels: {
              enabled: true,
              allowOverlap: true                      
            },
            events : {
              legendItemClick: function () {
                $('#btn_label').text('Hide Labels');
              }
            }
          }
        },
        exporting: {
          buttons: {
              contextButton: {
                  menuItems: btnGetDataTable
              }
          }
        },
        series: [
        {
          name: 'Target Penyerapan (L)',
          color :' #009933',
          data: TARGET,
          dataLabels: {
            enabled: false
          }
        },
        {
          name: 'Realisasi Penyerapan (L)',
          color : '#00ff00',
          data: REALISASI,
          dataLabels: {
            enabled: false
          }
        },
        {
          name: 'Penyerapan',
          data: PERSEN,
          pointWidth: 1,
          showInLegend: false,
          visible :false
        },
        ]
    })
              
  }


  // FORMATTER //

  function dateFormat(date) {
    var d = new Date(date),
    month = '' + (d.getMonth() + 1),
    day = '' + d.getDate(),
    year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day, month , year].join('-');
  }

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

  function toRp(angka){
    if(isNaN(angka)) {
      var _angka = '0.00';
    } else {
      var _angka = angka.toString();
    }
    
    var bilangan = _angka.replace(".", ",");
    var isMinus = '';

    if (bilangan.indexOf('-') > -1) {
        isMinus = '-';
    }

    bilangan = bilangan.replace("-", "");

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

  function getSum(total, num) {

    return total + num;
  }
    

</script>