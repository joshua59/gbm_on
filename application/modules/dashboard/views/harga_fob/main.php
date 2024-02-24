<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

<div class="inner_content" id="divTop">
  <div class="statistic clearfix">
    <div class="current_page pull-left">
      <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
    </div>
  </div>
  <div class="widgets_area">
    <div class="row-fluid">
      <div class="well-content">
        <?php  
          $pastDate = date('Y', strtotime('-1 year'));
          $past2Date = date('Y', strtotime('-2 year'));
        ?>
        <!-- Filter -->
          <input type="hidden" id="tipe">
          <button class="btn btn-default" id="btn-fob">Harga BBM (FOB)</button>
          <button class="btn btn-default" id="btn-cif">Harga BBM (CIF)</button>
          <hr>
          <div id="collapse_fob" style="display: none">
            <select class="form-control col-md-3" id="thn">
              <option value="<?php echo $past2Date ?>"><?php echo $past2Date ?></option>
              <option value="<?php echo $pastDate ?>"><?php echo $pastDate ?></option>
              <option value="<?php echo date("Y"); ?>" selected><?php echo date("Y"); ?></option>
            </select>
            <button type="button" class="btn btn-default" id="btn-filter">Filter</button>
          </div>
          <div id="collapse_cif" style="display: none">
            <div class="well">
              <div class="well-content clearfix">
                <?php echo form_open_multipart('', array('id' => 'ffilter-cari')); ?>
                <div class="form_row">
                  <div class="pull-left span4">
                    <label for="password" class="control-label">Pembangkit : </label>
                    <div class="controls">
                      <?php echo form_dropdown('SLOC_CARI', $options_lv4_cif, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4_cari" class="chosen span11"'); ?>
                    </div>
                  </div>
                  <div class="pull-left span4">
                    <label></label>
                    <div class="controls">
                      <?php echo anchor(NULL, "<i class='icon-zoom-in'></i> Quick Search", array('class' => 'btn yellow', 'id' => 'button-filter-cari')); ?>
                    </div>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
            </div>
            <hr>

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
            </div><br />
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
                <label for="password" class="control-label">Cari<span class="required">*</span> : </label>
                <div class="controls">
                  <select class="form-control" id="thncif" style="width: 115px;">
                    <option value="<?php echo $past2Date ?>"><?php echo $past2Date ?></option>
                    <option value="<?php echo $pastDate ?>"><?php echo $pastDate ?></option>
                    <option value="<?php echo date("Y"); ?>" selected><?php echo date("Y"); ?></option>
                  </select>
                  <input type="text" id="cariPembangkit" name="" value="" placeholder="Cari Unit" style="width: 115px;">
                </div>
              </div>
              <div class="pull-left span2">
                <label></label>
                <div class="controls">
                  <button type="button" class="btn btn-default" onclick="check()"><i class='icon-search'></i>Load</button>
                </div>
              </div>
            </div><br />
            <?php echo form_close(); ?>
          </div>
        
        <!-- Filter -->

        <br />
      </div>
      <br>
      <div id="div_grafik">
        <div class="well-content">
          <div id="container_grafik" style="height: 500px"></div>
          <button id="btn_label">Hide Labels</button>
          <br />
          <br />
          <table id="table" style="width:100%" class="table table-bordered">
            <thead>
              <tr>
                <th>PERIODE</th>
                  <?php $arr = array('HSD','MFO','MFO_LSFO','IDO');
                  foreach ($arr as $key) : ?>
                   <th>HARGA <?php echo $key ?></th>
                  <?php endforeach; ?>
              </tr>
            </thead>
            <tbody id="tbody"></tbody>
          </table>
          <table id="tablecif" style="width:100%" class="table table-bordered">
            <thead>
              <tr>
                <th>UNIT</th>
                <?php $bln = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                  foreach ($bln as $key) : ?>
                   <th><?php echo $key ?></th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody id="tbodycif"></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<br />
</div>
<script type="text/javascript">
  

var maxBln = 0;
getDataTable = function() {
  if ($('#tipe').val() == 1) {
    $('#tablecif').fadeOut();
    $('#table').fadeIn();
    $('html, body').animate({
      scrollTop: $("#table").offset().top
    }, 1000);
  } else if ($('#tipe').val() == 2) {
    $('#table').fadeOut();
    $('#tablecif').fadeIn();
    $('html, body').animate({
      scrollTop: $("#tablecif").offset().top
    }, 1000);
  } else {}
};

  var btnGetDataTable = Highcharts.getOptions().exporting.buttons.contextButton.menuItems;
  btnGetDataTable.push({
    separator: true
  }, {
   text: "Lihat Data Tabel",
   onclick: getDataTable
  });

  $(document).ready(function(){
    $('.chosen').chosen();
    $("#div_grafik").hide();
    $('#table').hide();
    $('#tablecif').hide();
  })

  $('#btn-fob').click(function() {
    $('#btn_label').text('Hide Labels');
    $("#collapse_fob").slideToggle("slow");
    $("#collapse_fob").show();
    $("#collapse_cif").hide();
    $("#div_grafik").hide();
    $('#tipe').val(1);
    $('#tablecif').hide();
  })

  $('#btn-cif').click(function() {
    $('#btn_label').text('Hide Labels');
    $("#collapse_cif").slideToggle("slow");
    $("#collapse_cif").show();
    $("#collapse_fob").hide();
    $("#div_grafik").hide();
    $('#tipe').val(2);
    $('#table').hide();
  })

  $('#btn-filter').click(function() {
    getDataHargaFOB();
  })

  $('#btn_label').click(function() {
    var btn_text = $('#btn_label').text();
    var chart = $('#container_grafik').highcharts();
    var opt = '';
    var total = chart.series.length;
    for (var i = 0; i < total; i++) {
      opt = chart.series[i].options;
      opt.dataLabels.enabled = !opt.dataLabels.enabled;
      chart.series[i].update(opt);
    }
    if (btn_text == 'Hide Labels') {
      $('#btn_label').text('Show Labels');
    } else {
      $('#btn_label').text('Hide Labels');
    }
  });

  $('#button-filter-cari').click(function() {
    var sloc = $('#lvl4_cari').val();
    if (sloc !== '') {
      setDefaultCombo();
      get_data_unit(sloc, sloc);
    } else {
      bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Pencarian Pembangkit harus dipilih-- </div>', function() {});
    }
  });

  function removeSeries_chart() {
    var chart = $('#container_grafik').highcharts();
    var seriesLength = chart.series.length;
    for (var i = seriesLength - 1; i > -1; i--) {
      chart.series[i].remove(true);
    }
  }

  function removeCategories_chart() {
    var chart = $('#container_grafik').highcharts();
    var categoriesLength = chart.userOptions.xAxis.categories.length;
    for (var i = categoriesLength - 1; i > -1; i--) {
      chart.userOptions.xAxis.categories = [];
    }
  }

  function toRp(angka) {
    var _angka = angka.toString();
    var bilangan = _angka.replace(".", ",");
    var isMinus = '';
    if (bilangan.indexOf('-') > -1) {
      isMinus = '-';
    }
    bilangan = bilangan.replace("-", "");
    var number_string = bilangan.toString(),
      split = number_string.split(','),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{1,3}/gi);
    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    if ((rupiah == '') || (rupiah == 0)) {
      rupiah = '0,00'
    }
    rupiah = isMinus + '' + rupiah;
    return rupiah;
  }

  function bulan(val) {
    var bulan = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10","11", "12"];
    var bulan_obj = [];
    var i = 1;
    bulan.forEach(function(element) {
      var parsedBulan = 'BLN' + element;
      if (val[parsedBulan] == null) {
        bulan_obj.push(null);
      } else {
        if (maxBln < i) {
          maxBln = i;
        }
        bulan_obj.push(val[parsedBulan]);
      }
      i++;
    });
    return bulan_obj;
  }

  function bulanVar(val, vBulan) {

    var bulan = [
      "01", "02", "03", "04", "05", "06", "07", "08", "09", "10",
      "11", "12"
    ];
    var bulan_obj = [];
    var i = 1;
    bulan.forEach(function(element) {
      var parsedBulan = 'BLN' + element; //TGL01
      if (i <= maxBln) {
        if (val[parsedBulan] == null) {
          bulan_obj.push(null);
        } else {
          bulan_obj.push(parseFloat(val[parsedBulan]));
        }
      }
      i++;
    });

    bulan_obj = $.grep(bulan_obj,function(n){ return n == 0 || n });

    return bulan_obj;
  }

  // FOB //
  function getDataHargaFOB() {
    $('#table').fadeOut();
    var thn = $('#thn').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('dashboard/harga_fob/getDataHargaFOB'); ?>",
      data: {
        "TAHUN": thn,
      },
      beforeSend: function(response) {
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
      },
      error: function(response) {
        bootbox.hideAll();
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
      },
      success: function(response) {
        bootbox.hideAll();
        var obj = JSON.parse(response);
        if (obj == '' || obj == null) {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
          $('#tbody').html('');
          var chart = $('#container_grafik').highcharts();
          while (chart.series.length > 0) {
            chart.series[0].remove(true);
          }
        } else {
          setGrafik(response, 1);
          setTable(response, 1);
        }
      }
    });
  }

  function setGrafik(response, angka) {
    var obj = JSON.parse(response);
    var bulan_obj = [];
    var kategori = [];
    var sum_bulan = [];
    var hsd = [];
    var mfo = [];
    var mfo_lsfo = [];
    var ido = [];
    if (angka == 1) {
      var nama = 'FOB';
    } else {
      var nama = 'CIF'
    }
    $('#btn_label').text('Hide Labels');
    if (obj == "" || obj == null) {
      $('#div_grafik').hide();
      removeSeries_chart();
    } else {
      $('#div_grafik').show();
      $('html, body').animate({
        scrollTop: $("#div_grafik").offset().top
      }, 1000);
      $.each(obj, function(index, val) {
        bulan(val);
      });
      for (i = 0; i <= 12; i++) {
        sum_bulan[i] = 0;
      }
      $.each(obj, function(index, val) {
        hsd.push(parseFloat(val.HARGA_HSD));
        mfo.push(parseFloat(val.HARGA_MFO));
        mfo_lsfo.push(parseFloat(val.HARGA_MFO_LSFO));
        ido.push(parseFloat(val.HARGA_IDO));
      });
      
      $(function() {
        $('#container_grafik').highcharts({
          chart: {
            type: 'line'
          },
          title: {
            text: 'Grafik Harga BBM (' + nama + ')'
          },
          subtitle: {
            text: 'Tahun ' + $('#thn').val()
          },
          xAxis: {
            categories: [
              'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ]
          },
          yAxis: {
            min: 0,
            labels: {
              formatter: function() {
                return toRp(this.value * 1);
              }
            },
            title: {
              text: 'Rp/Liter (Sudah Termasuk PPN)'
            }
          },
          tooltip: {
            headerFormat: 'Bulan {point.x}<br/>',
            pointFormatter: function() {
              return '<span style="color:' + this.color + '">\u25CF</span> ' + this.series.name + '<br>' +
                toRp(this.y);
            }
          },
          plotOptions: {
            series: {
              pointPadding: 0,
              dataLabels: {
                enabled: true,
                allowOverlap: true,
                formatter: function() {
                  return toRp(this.y);
                },
                style: {
                  fontWeight: '',
                  fontSize: '10px',
                  color: 'grey'
                }
              }
            },
            area: {
              marker: {
                enabled: false,
              },
            },
          },
          series: [{
              name: 'HARGA HSD',
              data: hsd
            },
            {
              name: 'HARGA MFO HSFO',
              data: mfo
            },
            {
              name: 'HARGA MFO LSFO',
              data: mfo_lsfo
            },
            {
              name: 'HARGA IDO',
              data: ido
            }
          ],
          responsive: {
            rules: [{
              condition: {
                maxWidth: 500
              },
              chartOptions: {
                legend: {
                  layout: 'horizontal',
                  align: 'center',
                  verticalAlign: 'bottom'
                }
              }
            }]
          }
        });
      });
    }
  }

  function setTable(response, angka) {
    $('#tbody').html('');
    var obj = JSON.parse(response)
    var dataSet = [];
    $.each(obj, function(i, d) {
      dataSet.push(d)
    });
    var objList = [];
    var a = 1;
    dataSet.forEach(function(item) {
      var objs = [];
      var PERIODE = item['NAMA'];
      var HARGA_HSD = item['HARGA_HSD'] == null ? "0.00" : toRp(item['HARGA_HSD']);
      var HARGA_MFO = item['HARGA_MFO'] == null ? "0.00" : toRp(item['HARGA_MFO']);
      var HARGA_MFO_LSFO = item['HARGA_MFO_LSFO'] == null ? "0.00" : toRp(item['HARGA_MFO_LSFO']);
      var HARGA_IDO = item['HARGA_IDO'] == null ? "0.00" : toRp(item['HARGA_IDO']);
      $('#tbody').append('<tr">' +
        '<td>' + PERIODE + '</td>' +
        '<td style="text-align:right">' + HARGA_HSD + '</td>' +
        '<td style="text-align:right">' + HARGA_MFO + '</td>' +
        '<td style="text-align:right">' + HARGA_MFO_LSFO + '</td>' +
        '<td style="text-align:right">' + HARGA_IDO + '</td>' +
        '</tr>')
    });
  }

  // FOB

  // CIF //

  function getDataHargaCIF(lvl4) {

    $('#tablecif').fadeOut();
    var thn = $('#thncif').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('dashboard/harga_fob/getDataHargaCIF'); ?>",
      data: {
        "TAHUN": thn,
        "VLEVELID": lvl4,
      },
      beforeSend: function(response) {
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
      },
      error: function(response) {
        bootbox.hideAll();
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
      },
      success: function(response) {
        bootbox.hideAll();
        var obj = JSON.parse(response);
        if (obj == '' || obj == null) {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
          $('#tbody').html('');
          var chart = $('#container_grafik').highcharts();
          while (chart.series.length > 0) {
            chart.series[0].remove(true);
          }
        } else {
          setGrafikCIF(response);
          setTableCIF(response);
        }
      }
    });
  }

  function setGrafikCIF(response) {
    var obj = JSON.parse(response);
    var bulan_obj = [];
    var dataset = [];
    var kategori = [];
    var sum_bulan = [];
    $('#btn_label').text('Hide Labels');
    if (obj == "" || obj == null) {
      $('#div_grafik').hide();
      removeSeries_chart();
    } else {
      $('#div_grafik').show();
      $('html, body').animate({
        scrollTop: $("#div_grafik").offset().top
      }, 1000);
      vJsonTableTahun = response;
      $.each(obj, function(index, val) {
        bulan(val);
      });
      for (i = 0; i <= 12; i++) {
        sum_bulan[i] = 0;
      }
      $.each(obj, function(index, val) {
        var series_data = {};
        series_data.name = val.UNIT;
        series_data.data = bulanVar(val, maxBln);
        for (i = 0; i <= series_data.data.length; i++) {
          if (!isNaN(series_data.data[i])) {
            sum_bulan[i] = series_data.data[i] + sum_bulan[i];
          }
        }
        dataset.push(series_data);
      });
      for (i = 0; i <= sum_bulan.length; i++) {
        if (!isNaN(sum_bulan[i])) {
          sum_bulan[i] = toRp(sum_bulan[i]);
        }
      }
      grafik(dataset)
    }
  }

  function grafik(dataset) {
    
    $('#container_grafik').highcharts({
      chart: {
        type: 'line'
      },
      title: {
        text: 'Harga CIF <br>PT PLN (Persero)'
      },
      subtitle: {
        text: 'Tahun ' + $('#thncif').val()
      },
      yAxis: {
        min: 0,
        labels: {
          formatter: function() {
            return toRp(this.value * 1);
          }
        },
        title: {
          text: 'Rp/Liter (Sudah Termasuk PPN)'
        }
      },
      xAxis: {
        title: {
          text: 'Bulan'
        },
        categories: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'
        ]
      },
      tooltip: {
        headerFormat: 'Bulan {point.x}<br/>',
        pointFormatter: function() {
          return '<span style="color:' + this.color +'">\u25CF</span> ' +this.series.name +': ' + toRp(this.y) +'</b><br/>'
        }
      },
      plotOptions: {
        series: {
          pointPadding: 0,
          dataLabels: {
            enabled: true,
            allowOverlap: true,
            formatter: function() {
              return toRp(this.y);
            },
            style: {
              fontWeight: '',
              fontSize: '10px',
              color: 'grey'
            }
          }
        },
        area: {
          marker: {
            enabled: false,
          },
        },
      },
      exporting: {
        buttons: {
          contextButton: {
            menuItems: btnGetDataTable
          }
        }
      },
      series: dataset,
      responsive: {
        rules: [{
          condition: {
            maxWidth: 500
          },
          chartOptions: {
            legend: {
              layout: 'horizontal',
              align: 'center',
              verticalAlign: 'bottom'
            }
          }
        }]
      }
    });
  }

  function setTableCIF(response, angka) {
    $('#tbodycif').html('');
    var obj = JSON.parse(response)
    var dataSet = [];
    $.each(obj, function(i, d) {
      dataSet.push(d)
    });
    var objList = [];
    var a = 1;
    dataSet.forEach(function(item) {
      var objs  = [];
      var UNIT  = item['UNIT'] == null ? "0.00" : item['UNIT'];
      var BLN01 = item['BLN01'] == null ? "0.00" : toRp(item['BLN01']);
      var BLN02 = item['BLN02'] == null ? "0.00" : toRp(item['BLN02']);
      var BLN03 = item['BLN03'] == null ? "0.00" : toRp(item['BLN03']);
      var BLN04 = item['BLN04'] == null ? "0.00" : toRp(item['BLN04']);
      var BLN05 = item['BLN05'] == null ? "0.00" : toRp(item['BLN05']);
      var BLN06 = item['BLN06'] == null ? "0.00" : toRp(item['BLN06']);
      var BLN07 = item['BLN07'] == null ? "0.00" : toRp(item['BLN07']);
      var BLN08 = item['BLN08'] == null ? "0.00" : toRp(item['BLN08']);
      var BLN09 = item['BLN09'] == null ? "0.00" : toRp(item['BLN09']);
      var BLN10 = item['BLN10'] == null ? "0.00" : toRp(item['BLN10']);
      var BLN11 = item['BLN11'] == null ? "0.00" : toRp(item['BLN11']);
      var BLN12 = item['BLN12'] == null ? "0.00" : toRp(item['BLN12']);
      $('#tbodycif').append('<tr>' +
        '<td style="text-align:left">' + UNIT + '</td>' +
        '<td style="text-align:right">' + BLN01 + '</td>' +
        '<td style="text-align:right">' + BLN02 + '</td>' +
        '<td style="text-align:right">' + BLN03 + '</td>' +
        '<td style="text-align:right">' + BLN04 + '</td>' +
        '<td style="text-align:right">' + BLN05 + '</td>' +
        '<td style="text-align:right">' + BLN06 + '</td>' +
        '<td style="text-align:right">' + BLN07 + '</td>' +
        '<td style="text-align:right">' + BLN08 + '</td>' +
        '<td style="text-align:right">' + BLN09 + '</td>' +
        '<td style="text-align:right">' + BLN10 + '</td>' +
        '<td style="text-align:right">' + BLN11 + '</td>' +
        '<td style="text-align:right">' + BLN12 + '</td>' +
        '</tr>')
    });
  }
  // CIF //

  function check() {
    var lvl0 = $('#lvl0').val();
    var lvl1 = $('#lvl1').val();
    var lvl2 = $('#lvl2').val();
    var lvl3 = $('#lvl3').val();
    var lvl4 = $('#lvl4').val();
    if (lvl0 == '00') {
      lvl4 = 'All';
      getDataHargaCIF(lvl4)
    } else {
      if (lvl0 == null || lvl0 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Pilih Regional -- </div>', function() {});
      } else if (lvl1 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Pilih Level 1 -- </div>', function() {});
      } else if (lvl2 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Pilih Level 2 -- </div>', function() {});
      } else if (lvl3 == '') {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Pilih Level 3 -- </div>', function() {});
      } else if (lvl4 == '' || lvl4 == null) {
        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Pilih Pembangkit -- </div>', function() {});
      } else {
        getDataHargaCIF(lvl4)
      }
    }
  }

  function setComboDefault(_id, _unit, _nama) {
    if ($(_id + ' option').size() <= 1) {
      $(_id).empty();
      $(_id).append('<option value=' + _unit + '>' + _nama + '</option>');
    } else {
      $(_id).val(_unit);
    }
    $(_id).data("placeholder", "Select").trigger('liszt:updated');
  }

  function setDefaultCombo() {
    var _level = "<?php echo $this->session->userdata('level_user');?>";
    var _kode_level = "<?php echo $this->session->userdata('kode_level');?>";
    $("select").trigger("liszt:updated");
    if (_level == 1) {
      $('#lvl3').empty();
      $('#lvl3').append('<option value="">--Pilih Level 3--</option>');
      $('#lvl3').data("placeholder", "Select").trigger('liszt:updated');
    }
    if (_level == 0) {
      if ((_kode_level == '') || (_kode_level == 0)) {
        $('#lvl0').val('');
        $('#lvl0').data("placeholder", "Select").trigger('liszt:updated');
        $('#lvl0').change();
      }
    } else {
      get_options_lv4_all($('#lvl' + _level).val());
      get_options_lv4_all_Q($('#lvl' + _level).val());
    }
  }

  function get_data_unit(sloc, sloc_cari) {
    bootbox.hideAll();
    bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
    $.ajax({
      type: "POST",
      url: "<?php echo base_url('dashboard/info_pembangkit/get_data_unit'); ?>",
      data: {
        "SLOC": sloc
      },
      dataType: 'json',
      error: function(data) {
        bootbox.hideAll();
        msgGagal('get_data_unit gagal');
      },
      success: function(data) {
        if (sloc == 'All') {
          $('#lvl0').val('00');
          check();
        } else {
          $.each(data, function() {
          setComboDefault('#lvl0', this.ID_REGIONAL, this.LEVEL1);
          setComboDefault('#lvl1', this.COCODE, this.LEVEL1);
          setComboDefault('#lvl2', this.PLANT, this.LEVEL2);
          setComboDefault('#lvl3', this.STORE_SLOC, this.LEVEL3);
          if (sloc_cari) {
            setComboDefault('#lvl4', this.SLOC, this.LEVEL4);
            check()
          }
          //set param export excel
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
          //set param export pdf
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
        });
        }
        
        bootbox.hideAll();
      }
    });
  }

  jQuery(function($) {
    function setDefaultLv1() {
      $('select[name="COCODE"]').empty();
      $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
    }

    function setDefaultLv2() {
      $('select[name="PLANT"]').empty();
      $('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
    }

    function setDefaultLv3() {
      $('select[name="STORE_SLOC"]').empty();
      $('select[name="STORE_SLOC"]').append('<option value="">--Pilih Level 3--</option>');
    }

    function setDefaultLv4() {
      $('select[name="SLOC"]').empty();
      $('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
    }

    function disabledDetailButton() {
      $('#button-detail').removeClass('disabled');
      $('#button-detail').addClass('disabled');
    }
    setDefaultLv1();
    setDefaultLv2();
    setDefaultLv3();
    setDefaultLv4();
    $('select[name="ID_REGIONAL"]').on('change', function() {
      var stateID = $(this).val();
      var vlink_url = '<?php echo base_url()?>dashboard/penerimaan_pemasok/get_options_lv1/' + stateID;
      disabledDetailButton();
      setDefaultLv1();
      setDefaultLv2();
      setDefaultLv3();
      setDefaultLv4();
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
    $('select[name="COCODE"]').on('change', function() {
      var stateID = $(this).val();
      var vlink_url = '<?php echo base_url()?>dashboard/penerimaan_pemasok/get_options_lv2/' + stateID;
      disabledDetailButton();
      setDefaultLv2();
      setDefaultLv3();
      setDefaultLv4();
      if (stateID) {
        bootbox.modal('<div class="loading-progress"></div>');
        $.ajax({
          url: vlink_url,
          type: "GET",
          dataType: "json",
          success: function(data) {
            $.each(data, function(key, value) {
              $('select[name="PLANT"]').append('<option value="' + value.PLANT + '">' + value.LEVEL2 + '</option>');
            });
            bootbox.hideAll();
          }
        });
      }
    });
    $('select[name="PLANT"]').on('change', function() {
      var stateID = $(this).val();
      var vlink_url = '<?php echo base_url()?>dashboard/penerimaan_pemasok/get_options_lv3/' + stateID;
      disabledDetailButton();
      setDefaultLv3();
      setDefaultLv4();
      if (stateID) {
        bootbox.modal('<div class="loading-progress"></div>');
        $.ajax({
          url: vlink_url,
          type: "GET",
          dataType: "json",
          success: function(data) {
            $.each(data, function(key, value) {
              $('select[name="STORE_SLOC"]').append('<option value="' + value.STORE_SLOC + '">' + value.LEVEL3 + '</option>');
            });
            bootbox.hideAll();
          }
        });
      }
    });
    $('select[name="STORE_SLOC"]').on('change', function() {
      var stateID = $(this).val();
      var vlink_url = '<?php echo base_url()?>dashboard/penerimaan_pemasok/get_options_lv4/' + stateID;
      disabledDetailButton();
      setDefaultLv4();
      if (stateID) {
        bootbox.modal('<div class="loading-progress"></div>');
        $.ajax({
          url: vlink_url,
          type: "GET",
          dataType: "json",
          success: function(data) {
            $.each(data, function(key, value) {
              $('select[name="SLOC"]').append('<option value="' + value.SLOC + '">' + value.LEVEL4 + '</option>');
            });
            bootbox.hideAll();
          }
        });
      }
    });
    $('select[name="SLOC"]').on('change', function() {
      if ($(this).val() !== '') {
        $('#button-detail').removeClass('disabled');
      } else {
        $('#button-detail').addClass('disabled');
      }
    });
  });
</script>