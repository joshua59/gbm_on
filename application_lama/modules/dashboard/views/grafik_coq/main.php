<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<style type="text/css">
    .dataTables_scrollHeadInner {
        width: 100% !important;
    }

    .dataTables_scrollHeadInner table {
        width: 100% !important;
    }
</style>


<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="well-content no-search">
                <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                <div class="form_row">
                    <div class="pull-left span2">
                        <label for="password" class="control-label">Jenis BBM : </label>
                        <div class="controls">
                            <?php echo form_dropdown('ID_JNS_BHN_BKR', @$options_bbm, !empty($default->KOMP_BBM) ? $default->KOMP_BBM : '', ' class="form-control" style="width: 100%;" id="bbm"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Paramater Kualitas BBM : </label>
                        <div class="controls">
                            <?php echo form_dropdown('ID_MCOQ', '', !empty($default->ID_MCOQ) ? $default->ID_MCOQ : '', ' class="form-control select2" id="id_mcoq" style="width: 100%"'); ?>
                        </div>
                    </div>
                </div>
                <div class="form_row">
                    <div class="pull-left span2">
                        <label for="password" class="control-label">Pemasok : </label>
                        <div class="controls">
                            <?php echo form_dropdown('ID_PEMASOK', @$options_pemasok, !empty($default->ID_PEMASOK) ? $default->NAMA_PEMASOK : '', ' class="form-control" style="width: 100%;" id="id_pemasok"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Depo : </label>
                        <div class="controls">
                            <?php echo form_dropdown('ID_DEPO', '', !empty($default->ID_DEPO) ? $default->ID_DEPO : '', ' class="form-control" id="id_depo" style="width: 100%"'); ?>
                        </div>
                    </div>

                    <div class="pull-left span5">
                        <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                        <label for="password" class="control-label" style="margin-left:95px">Tahun <span
                                    class="required">*</span> : </label>
                        <div class="controls">
                            <?php echo form_dropdown('BULAN', $opsi_bulan, '', 'style="width: 137px;", id="bln"'); ?>
                            <?php
                            $pastDate = date('Y', strtotime('-1 year'));
                            $past2Date = date('Y', strtotime('-2 year'));
                            $past3Date = date('Y', strtotime('-3 year'));
                            ?>
                            <select class="form-control col-md-3" id="thn" style="width: 80px">
                                <option value="<?php echo $past3Date ?>"><?php echo $past3Date ?></option>
                                <option value="<?php echo $past2Date ?>"><?php echo $past2Date ?></option>
                                <option value="<?php echo $pastDate ?>"><?php echo $pastDate ?></option>
                                <option value="<?php echo date("Y"); ?>" selected><?php echo date("Y"); ?></option>
                            </select>
                            <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'btn-filter')); ?>
                            &nbsp;
                        </div>

                    </div>


                </div>
                <br/>
                <?php echo form_close(); ?>

            </div>
            <br/>
            <div id="content_table">
                <div class="well-content">
                    <div id="container" style="min-width: 310px; height: 500px; margin: 0 auto"></div>
                </div>
                <div>&nbsp;</div>
            </div>
            <div id="list_table">
                <div id="table"></div>
            </div>

        </div>
    </div>

</div>

<script type="text/javascript">

    var maxTgl = 0;
    var nilai_min, nilai_max;
    $('.select2').select2({
        placeholder: '-- Pilih Jenis Parameter --'
    });
    $('#content_table').hide();
    $('#list_table').hide();

    setDefaultParameter();
    setDefaultDepo();

    $('#bbm').on('change', function () {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/grafik_coq/get_parameter/' + stateID;
        setDefaultParameter();
        setDefaultDepo();
        setDefaultPemasok();
        setDefaultBulan();
        if (stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $.each(data, function (key, value) {
                        $('#id_mcoq').append('<option value="' + value.ID_MCOQ + '">' + value.PARAMETER_ANALISA + ' - '+value.NO_VERSION+'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    function getDataTable() {
        $('#list_table').fadeIn();
        $('html, body').animate({
            scrollTop: $("#list_table").offset().top
        }, 1000);
    }

    $('#btn-filter').click(function () {
        var id_mcoq = $('#id_mcoq').val();
        var v_bln = $('#bln').val();
        var v_thn = $('#thn').val();
        var v_depo = $('#id_depo').val();
        var v_pemasok = $('#id_pemasok').val();
        $('#list_table').hide();
        if (id_mcoq == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> -- Parameter Tidak Boleh Kosong ! -- </div>', function () {
            });
        } else if (v_bln == '') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> -- Bulan Tidak Boleh Kosong ! -- </div>', function () {
            });
        } else {
            set_table();
            get_tipe_grafik(id_mcoq);
        }

    })

    function setDefaultParameter() {
        $('#id_mcoq').empty();
        $('#id_mcoq').append('<option value="">-- Pilih Jenis Parameter --</option>');
    }

    function setDefaultDepo() {
        $('select[name="ID_DEPO"]').empty();
        $('select[name="ID_DEPO"]').append('<option value="">-- Pilih Depo --</option>');
        $('select[name="ID_DEPO"]').append('<option value="">-- Pilih Semua Depo --</option>');
    }

    function setDefaultPemasok() {
        $('select[name="ID_PEMASOK"]').val('');
        $('select[name="ID_PEMASOK"]').trigger('change');
    }

    function setDefaultBulan() {
        $('select[name="BULAN"]').val('');
        $('select[name="BULAN"]').trigger('change');
    }

    $('select[name="ID_PEMASOK"]').on('change', function() {
        
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/grafik_coq/get_depo_by_pemasok/'+stateID;
        setDefaultDepo();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="ID_DEPO"]').append('<option value="'+ value.ID_DEPO +'">'+ value.NAMA_DEPO +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    function set_table() {
        var id_mcoq  = $('#id_mcoq').val();
        var v_bln    = $('#bln').val();
        var v_thn    = $('#thn').val();
        var v_pemasok    = $('#id_pemasok').val();
        var v_depo    = $('#id_depo').val();
        var v_param  = $('#id_mcoq option:selected').text();
        var v_bbm  = $('#bbm option:selected').text();
        var nama_bln = $('#bln option:selected').text();

        var vlink_url = '<?php echo base_url()?>dashboard/grafik_coq/get_table';
        $.ajax({
            url: vlink_url,
            type: "POST",
            data: {
                id: id_mcoq,
                bln: v_bln,
                thn: v_thn,
                id_depo: v_depo,
                id_pemasok: v_pemasok,
                bbm: v_bbm,
                nama_bulan: nama_bln,
                parameter : v_param
            },
            success: function (data) {
                bootbox.hideAll();
                $('#table').html(data);
            }
        });
    }

    function get_tipe_grafik(id_mcoq) {
        var vlink_url = '<?php echo base_url()?>dashboard/grafik_coq/get_tipe_grafik';
        $.ajax({
            url: vlink_url,
            type: "POST",
            data: {
                id: id_mcoq
            },
            beforeSend: function (data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error: function (data) {
                bootbox.hideAll();
                alert('Data Gagal Proses');
            },
            success: function (data) {
                
                var obj = JSON.parse(data);
                bootbox.hideAll();
                set_tipe_grafik(obj,id_mcoq)

            }
        });
        
    }

    function set_tipe_grafik(nilai,id_mcoq) {
        var v_depo = $('#id_depo').val();
        var v_pemasok = $('#id_pemasok').val();
        if(nilai.TIPE == 1) {
            var vlink_url = '<?php echo base_url()?>dashboard/grafik_coq/set_min_max';
        } else if(nilai.TIPE == 2) {
            var vlink_url = '<?php echo base_url()?>dashboard/grafik_coq/set_nilai_parameter';
        }
        var v_bln = $('#bln').val();
        var v_thn = $('#thn').val();
        $.ajax({
            url: vlink_url,
            type: "POST",
            data: {
                id: id_mcoq,
                bln: v_bln,
                thn: v_thn,
                id_depo: v_depo,
                id_pemasok: v_pemasok
            },
            beforeSend: function (data) {
                // bootbox.modal('<div class="loading-progress"></div>');
            },
            error: function (data) {
                // bootbox.hideAll();
                alert('Data Gagal Proses');
            },
            success: function (data) {
                
                var obj = JSON.parse(data);
                bootbox.hideAll();

                if(nilai.TIPE == 1) {
                    set_grafik(obj);
                } else if(nilai.TIPE == 2) {
                    set_nilai_grafik(nilai,obj)
                }


            }
        });
        
    }

    function set_grafik(obj) {
        $('#content_table').fadeIn();
       
        var sum_tgl = [];
        var dataset = [];
        var min = obj.min_max[0].BATAS_MIN;
        var max = obj.min_max[0].BATAS_MAX;
        var nmin, nmax;
        var arr = [];
        var data = [];
        var category = [];
        var satuan = obj.satuan;

        if (obj == "" || obj == null) {

        } else 
            $.each(obj.parameter, function (index, val) {
                var n = val.RESULT.replace(/,/g, '.');
                data.push([val.NO_REPORT,parseFloat(n)]);
                category.push(val.NO_REPORT);
            });

            if(satuan == null || satuan == '') {
                var satuan = '';
            } else {
                var satuan = satuan;
            }

            var merged = [].concat.apply([], arr);

            var largest = Math.max.apply(Math, merged);
            var smallest = Math.min.apply(Math, merged);

            if (min != '' && max == '') {
                nmin = parseFloat(min).toFixed(2);
                nmin_text = parseFloat(min).toFixed(2); 
                nmax = parseFloat(min).toFixed(2);
                color = 'red';
                var txt = 'Min : '+convertToRupiah(nmin_text)+' '+satuan;
                
            } else if (min == '' && max != '') {
                nmin_text = '"-"';
                nmin = parseFloat(max).toFixed(2);
                nmax = parseFloat(max).toFixed(2);
                nmax_text = parseFloat(max).toFixed(2);
                color = 'red';
                var txt = 'Max : '+convertToRupiah(nmax_text)+' '+satuan;
            } else if (min != '' && max != '') {
                
                nmin = parseFloat(min).toFixed(2);
                nmax = parseFloat(max).toFixed(2);
                nmin_text = parseFloat(min).toFixed(2);
                nmax_text = parseFloat(max).toFixed(2);
                color = 'rgba(68, 170, 213, 0.1)';
                var txt = 'Min : '+convertToRupiah(nmin_text)+' '+ satuan +' - Max : '+convertToRupiah(nmax_text)+' '+satuan
            } 

            grafik(data,nmin,nmax,txt,satuan,color,min,max,category);

    }

    function removeSeries_chart() {
        var chart = $('#container').highcharts();
        var seriesLength = chart.series.length;
        for (var i = seriesLength - 1; i > -1; i--) {
          chart.series[i].remove(true);
        }
    }

    function grafik(dataset,nmin,nmax,txt,satuan,warna,min,max,category) {
        var bulan = $('#bln option:selected').text();
        var tahun = $('#thn option:selected').text();
        var bbm   = $('#bbm option:selected').text();
        Highcharts.chart('container', {
            chart: {
                type: 'scatter',
                zoomType: 'xy'
            },
            title: {
                text: 'Grafik Kualitas BBM <br><h4 style="font-size: 13px;">PT PLN (PERSERO)</h4><br>' + ' <h4 style="font-size: 14px;">' + bulan + ' ' + tahun + '</h4><br><h3 style="font-size: 12px;">' + bbm + '</h3>'
            },
            subtitle: {
                text: $('#id_mcoq option:selected').text() + '<br>' + txt
            },
            yAxis: {
                title: {
                    text: satuan
                },
                plotBands: [{ // High wind
                    from: nmin,
                    to: nmax,
                    color: 'rgba(255, 92, 92)'
                }]
            },
            legend: {
                enabled: false
            },
            xAxis: {
                title: null,
                type: 'category',
                categories : category,
                labels: {
                    rotation: -90,
                }
            },
            plotOptions: {
                scatter: {
                    marker: {
                        radius: 5,
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: 'rgb(100,100,100)'
                            }
                        }
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '',
                        pointFormatter: function() {
                            var status = '';

                            if (min != '' && max == '') {
                                status = (this.y < min) ? 'NOT PASSED' : 'PASSED';
                            } else if (min == '' && max != '') {
                                status = (this.y > max) ? 'NOT PASSED' : 'PASSED';
                            } else if (min != '' && max != '') {
                                status = (this.y < min || parseFloat(this.y).toFixed(2) > max) ? 'NOT PASSED' : 'PASSED';
                            }
                            return '<span style="color:' + this.color + '">\u25CF</span> ' + convertToRupiah(this.y) + '<br><span style="color:' + this.color + '">\u25CF</span> Status : ' + status;
                        }
                    },
                }
            },
            series: [{
                name: "data",
                data: dataset
            }],
            exporting: {
                menuItemDefinitions: {
                    // Custom definition
                    datatable: {
                        onclick: function() {
                            getDataTable();
                        },
                        text: 'Lihat Data Tabel'
                    }
                },
                buttons: {
                    contextButton: {
                        menuItems: ['downloadPNG', 'downloadSVG', 'downloadPDF', 'separator', 'datatable']
                    }
                }
            }
        });
    }

    function removeSeries_chart() {
        var chart = $('#container').highcharts();
        var seriesLength = chart.series.length;
        for (var i = seriesLength - 1; i > -1; i--) {
          chart.series[i].remove(true);
        }
      }

    function set_nilai_grafik(nilai,obj) {
        $('#content_table').show();
        var data = [];
        $.each(obj.parameter, function (index, val) {
            
            var komponen = val.NAMA_NILAI;
            var nilai = val.JUMLAH;
            data.push([komponen,parseInt(nilai)]);
        });

        var bulan = $('#bln option:selected').text();
        var tahun = $('#thn option:selected').text();
        var bbm   = $('#bbm option:selected').text();
        
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Grafik Kualitas BBM <br><h4 style="font-size: 13px;">PT PLN (PERSERO)</h4><br>' + ' <h4 style="font-size: 14px;">' + bulan + ' ' + tahun + '</h4><br><h3 style="font-size: 12px;">' + bbm + '</h3>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Jumlah Persen',
                data: data
            }],
            exporting: {
                menuItemDefinitions: {
                    // Custom definition
                    datatable: {
                        onclick: function () {
                            getDataTable();
                        },
                        text: 'Lihat Data Tabel'
                    }
                },
                buttons: {
                    contextButton: {
                        menuItems: ['downloadPNG', 'downloadSVG', 'downloadPDF','separator', 'datatable']
                    }
                }
            }
        });
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

    
</script>
