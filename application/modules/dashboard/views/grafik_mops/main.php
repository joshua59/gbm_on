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
            <div class="well-content no-search">
                <?php  
                  $pastDate = date('Y', strtotime('-1 year'));
                  $past2Date = date('Y', strtotime('-2 year'));
                ?>
                <!-- Filter -->
                <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                    <div class="form_row">
                            <div class="pull-left span2">
                                <label for="password" class="control-label">Bulan : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('BULAN', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="bln" class="span11" style="width:150px"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span2">
                                <label for="password" class="control-label">Tahun : </label>
                                <div class="controls">
                                    <select class="form-control span11" id="thn" name="TAHUN" style="width:140px"> 
                                      <option value="<?php echo $past2Date ?>"><?php echo $past2Date ?></option>
                                      <option value="<?php echo $pastDate ?>"><?php echo $pastDate ?></option>
                                      <option value="<?php echo date("Y"); ?>" selected><?php echo date("Y"); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="pull-left span2">
                                <label for="password" class="control-label"></label>
                                <div class="controls">
                                    <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'btn-filter')); ?>&nbsp;
                                </div>
                            </div>
                        </div><br/>                   
                <?php echo form_close(); ?>
                <!-- Filter -->
            </div>
            <br>
            <div id="div_grafik">
                <div class="well-content no-search">
                    
                    <div id="container_grafik" style="height: 400px"></div> 
                    
                    <table id="table" style="width:100%">
                        <thead>
                            <tr>
                                <th>MOPS BBM</th>
                                <?php                                                   
                                $arr = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
                                foreach ($arr as $key) {
                                   echo "<th>".$key."</th>";
                                }
                                ?>  
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                    <table id="tablebulan" style="width:50%;">
                        <thead>
                            <tr>
                                <th>MOPS BBM</th>
                                <th id="namabulan"></th>
                            </tr>
                        </thead>
                        <tbody id="tbodybulan"></tbody>
                    </table>
                </div>
            </div>    
        </div>
    </div>

</div>    

<br/>
</div>

<script type="text/javascript">
    
    var maxBln = 0;
    var vJsonTableTahun;
    

    $(document).ready(function() {
        getBulan();
        $('#div_grafik').hide();
        $('#table').hide();
        $('#tablebulan').hide();

        $('#table').dataTable({
            "bPaginate": false,
            "searching":false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": true,
            "ordering": false,            
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
            },
            "columnDefs": [
                {"className": "dt-center","targets": 'All'},
            ]
        });  

         $('#tablebulan').dataTable({
            "bPaginate": false,
            "searching":false,
            "bLengthChange": false,
            "bFilter": false,
            "bInfo": false,
            "bAutoWidth": true,
            "ordering": false,            
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
            },
            "columnDefs": [
                {"className": "dt-center","targets": 'All'},
            ]
        });  
    

        $('#btn-filter').click(function() {
            $('#table').hide();
            $('#tablebulan').hide();
            var bln = $('#bln').val();
            var thn = $('#thn').val();
            
            if(bln !== '' && thn == '') {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tahun Tidak tidak boleh kosong -- </div>', function() {});
            } else if(thn == '' && bln == '') {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak boleh kosong -- </div>', function() {});
            } else if(bln == '' && thn !== ''){
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Bulan Tidak tidak boleh kosong -- </div>', function() {});
            }
            else {
                getDataMops(thn,bln);
            }
        })
    })

    function bulan(val){
        var bulan = [
            "01", "02", "03", "04", "05", "06", "07", "08", "09", "10",
            "11", "12"
        ];
        var bulan_obj = [];
        
        var i = 1;
        bulan.forEach(function(element){
            var parsedBulan = 'BLN'+ element; 
            if(val[parsedBulan] == null) 
            {
                bulan_obj.push(null);
            }else{
                if (maxBln < i) {
                    maxBln = i;
                }
                bulan_obj.push(val[parsedBulan]);
            }
            i++;
        });
        return bulan_obj;
    }

    function bulanVar(val, vBulan){
        var bulan = [
            "01", "02", "03", "04", "05", "06", "07", "08", "09", "10",
            "11", "12"
        ];
        var bulan_obj = [];
        
        var i=1;
        bulan.forEach(function(element){
            var parsedBulan = 'BLN'+ element; //TGL01

            if (i <= maxBln){
                if(val[parsedBulan] == null) 
                {
                    bulan_obj.push(null);
                }else{
                    bulan_obj.push(parseFloat(val[parsedBulan]));
                }    
            }
            i++;
                
        });
        return bulan_obj;
    }

    function getDataMops(thn,bln) {
        
        if(bln == '13') {
            bln = "";
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('dashboard/grafik_mops/getDataMops'); ?>",
            data: {
                "TAHUN": thn,
                "BULAN": bln,
            },
            beforeSend:function(response){
                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(response) {
                bootbox.hideAll();
                
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
            },
            success:function(response) {
                bootbox.hideAll();
                var obj = JSON.parse(response);
                if(obj == '' || obj == null) {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                    $('#tbody').html('');
                    var chart = $('#container_grafik').highcharts();
                    while(chart.series.length > 0) {
                        chart.series[0].remove(true);               
                    }
                    
                } else {

                    if(bln !== '') {
                        setGrafikBulan(response);
                        setTableBulan(response); 
                    } else {
                        setGrafik(response);
                        setTable(response); 
                    }
                    
                }
            }
        });
    }

    function set_rp_grafik(bilangan){    
        var number_string = bilangan.toString(),
            sisa    = number_string.length % 3,
            rupiah  = number_string.substr(0, sisa),
            ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                
        if (ribuan) {
            separator = sisa ? ' ' : '';
            rupiah += separator + ribuan.join(' ');
        }

        return rupiah;
    }

    function setGrafik(response) {

        var obj = JSON.parse(response);
        var bulan_obj = [];
        var dataset = [];
        var kategori = [];
        var sum_bulan = [];

        if (obj == "" || obj == null) {
            $('#div_grafik').hide();
        }else {
            $('#div_grafik').show();
            $('html, body').animate({scrollTop: $("#div_grafik").offset().top}, 1000);
            // vJsonTableTahun = response;

            $.each(obj, function(index, val){
                bulan(val);
            });

            for (i = 0; i <= 12; i++) {
                    sum_bulan[i]= 0;
            }

            $.each(obj, function(index, val){

                var series_data = {};
                
                series_data.name = val.PERIODE;
                series_data.data = bulanVar(val,maxBln);

                for (i = 0; i <= series_data.data.length; i++) {
                    if (!isNaN(series_data.data[i])){
                        sum_bulan[i]= series_data.data[i];
                    }
                }

                dataset.push(series_data);
                
            });

            $(function (){
                $('#container_grafik').highcharts({
                    chart : {
                        type: 'column'
                    },
                    title: {
                        text: 'Grafik MOPS Harga BBM'
                    },
                    subtitle: {
                        text: 'Tahun '+ $('#thn').val()
                    },
                    xAxis: {
                        categories: [
                            'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'
                        ]
                    },
                    yAxis: {
                        title: {
                            text: '<b>USD/BBL - USH/MT </b>'
                        }
                    },
                    tooltip: {
                        headerFormat: 'Bulan {point.x}<br/>',
                        
                            pointFormatter: function () {
                                return '<span style="color:'+this.color+'">\u25CF</span> '+ this.series.name +'<br>'+
                                this.y;
                                
                        }
                    },
                    plotOptions: {
                        series: {
                            pointPadding: 0,
                            dataLabels: {
                                enabled: true,
                                allowOverlap: true,
                                verticalAlign: 'top',
                                rotation: -45,
                                y: -20,
                                formatter:function() {
                                    return this.y;
                                }
                            }
                        },                           
                        area: {
                            marker: {
                                enabled: false,
                            },
                        },
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
            });
        } 
    }

    function setTable(response) {
        $('#tbody').html('');
        $('#table').show();
        var obj = JSON.parse(response)

        var dataSet = [];
        $.each(obj, function(i,d) {
            dataSet.push(d)
        });
            
        var objList = [];
        var a = 1;
        dataSet.forEach(function(item) {
            var objs = [];
            var PERIODE = item['PERIODE']
            var BLN01 = item['BLN01'];
            var BLN02 = item['BLN02'];
            var BLN03 = item['BLN03'];
            var BLN04 = item['BLN04'];
            var BLN05 = item['BLN05'];
            var BLN06 = item['BLN06'];
            var BLN07 = item['BLN07'];
            var BLN08 = item['BLN08'];
            var BLN09 = item['BLN09'];
            var BLN10 = item['BLN10'];
            var BLN11 = item['BLN11'];
            var BLN12 = item['BLN12'];
  
            $('#tbody').append('<tr style="text-align:center">'+
                '<td>'+PERIODE+'</td>'+
                '<td>'+BLN01+'</td>'+
                '<td>'+BLN02+'</td>'+
                '<td>'+BLN03+'</td>'+
                '<td>'+BLN04+'</td>'+
                '<td>'+BLN05+'</td>'+
                '<td>'+BLN06+'</td>'+
                '<td>'+BLN07+'</td>'+
                '<td>'+BLN08+'</td>'+
                '<td>'+BLN09+'</td>'+
                '<td>'+BLN10+'</td>'+
                '<td>'+BLN11+'</td>'+
                '<td>'+BLN12+'</td>'+
                '</tr>')
        });
    }

    function setGrafikBulan(response) {

        var obj = JSON.parse(response);
        var bulan_obj = [];
        var dataset = [];
        var kategori = [];

        var bln = $('#bln').val();
        if (obj == "" || obj == null) {
            $('#div_grafik').hide();
        }else {
            $('#div_grafik').show();
            $('html, body').animate({scrollTop: $("#div_grafik").offset().top}, 1000);

            var namabulan = getNamaBulan(bln);
        
            $.each(obj, function(index, val){

                var series_data = {};
                
                series_data.name = val.PERIODE;
                series_data.data = [parseFloat(val.BLN)];

                dataset.push(series_data);
            });
            $(function (){
                $('#container_grafik').highcharts({
                    chart : {
                        type: 'column'
                    },
                    title: {
                        text: 'Grafik MOPS Harga BBM'
                    },
                    subtitle: {
                        text: 'Bulan '+ namabulan +'<br>Tahun '+ $('#thn').val()
                    },
                    xAxis: {
                        categories: [namabulan]
                    },
                    yAxis: {
                        title: {
                            text: '<b>USD/BBL - USH/MT </b>'
                        }
                    },
                    tooltip: {
                        headerFormat: 'Bulan {point.x}<br/>',                        
                            pointFormatter: function () {
                                return '<span style="color:'+this.color+'">\u25CF</span> '+ this.series.name +'<br>'+
                                this.y;
                                
                        }
                    },
                    plotOptions: {
                        series: {
                            pointPadding: 0,
                            dataLabels: {
                                enabled: true,
                                formatter:function() {
                                    return this.y;
                                }
                            }
                        },                        
                        area: {
                            marker: {
                                enabled: false,
                            },
                        },
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
            });
        } 
    }

    function setTableBulan(response) {
        $('#tbodybulan').html('');
        $('#tablebulan').show();
        var bln = $('#bln').val();
        var obj = JSON.parse(response)
        var dataSet = [];

        var namabulan = getNamaBulan(bln);

        $('#namabulan').text(namabulan)

        $.each(obj, function(i,d) {
            dataSet.push(d)
        });
            
        var objList = [];
        var a = 1;
        dataSet.forEach(function(item) {
            var objs = [];
            var PERIODE = item['PERIODE']
            var BLN = item['BLN'];
  
            $('#tbodybulan').append('<tr style="text-align:center">'+
                '<td>'+PERIODE+'</td>'+
                '<td>'+BLN+'</td>'+
                '</tr>')
        });
    }

    // function getTahun() {
    //     var vlink_url = '<?php echo base_url()?>dashboard/grafik_mops/getTahun/';
    //     $.ajax({
    //         url: vlink_url,
    //         type: "GET",
    //         dataType: "json",
    //         success:function(data) {
    //             $('select[name="TAHUN"]').append('<option value="">-- Pilih Tahun --</option>');
    //             $.each(data, function(key, value) {
    //                 $('select[name="TAHUN"]').append('<option value="'+ value +'">'+ value +'</option>');
    //             });
    //             var d = new Date();
    //             var n = d.getFullYear();
    //             $("#thn option[value="+n+"]").attr('selected', 'selected');
    //         }
    //     });
    // }

    function getBulan() {
        var vlink_url = '<?php echo base_url()?>dashboard/grafik_mops/getBulan/';
        $.ajax({
            url: vlink_url,
            type: "GET",
            dataType: "json",
            success:function(data) {
                $('select[name="BULAN"]').append('<option value="">-- Pilih Bulan --</option>'+
                    '<option value="13">All</option>');
                $.each(data, function(key, value) {
                    $('select[name="BULAN"]').append('<option value="'+ value.BULAN +'">'+ value.NAMA +'</option>');
                });

                var d = new Date();
                var n = ("0" + (d.getMonth() + 1)).slice(-2);
                $("#bln option[value="+n+"]").attr('selected', 'selected');
            }
        });
    }
    
    function getNamaBulan(bln) {
        
        if(bln == '01') {
            var namabulan = "Januari";
        }
        if(bln == '02') {
            var namabulan = "Februari";
        }
        if(bln == '03') {
            var namabulan = "Maret";
        }
        if(bln == '04') {
            var namabulan = "April";
        }
        if(bln == '05') {
            var namabulan = "Mei";
        }
        if(bln == '06') {
            var namabulan = "Juni";
        }
        if(bln == '07') {
            var namabulan = "Juli";
        }
        if(bln == '08') {
            var namabulan = "Agustus";
        }
        if(bln == '09') {
            var namabulan = "September";
        }
        if(bln == '10') {
            var namabulan = "Oktober";
        }
        if(bln == '11') {
            var namabulan = "November";
        }
        if(bln == '12') {
            var namabulan = "Desember";
        }

        return namabulan;
    }
        
</script>
