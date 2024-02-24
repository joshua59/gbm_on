<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

<style>
  #exampleModal{
      width: 100%;
      left: 30%;
  }

  .detail-kosong{
      display: none;
  }

  tr {
    background-color: #CED8F6;
  }
  table {
    border-collapse: collapse;
    width:100%;
  }
  .auto{
    width: 100%;
  }
</style>

<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Laporan Persediaan BBM'; ?></span>
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
                    <label for="password" class="control-label">Periode <span class="required">*</span> :  </label>
                    <div class="controls">
                        <?php echo form_input('TGL_DARI', !empty($default->TGL_DARI) ? $default->TGL_DARI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                        <label for="">s/d</label>
                        <?php echo form_input('TGL_SAMPAI', !empty($default->TGL_SAMPAI) ? $default->TGL_SAMPAI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
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
                </div>
            </div>
            <div class="form_row">
                <div class="pull-left span2">
                    <label></label>
                    <div class="controls">
                    </div>
                </div>
                <!-- Tampilan modal detail -->
                <div class="pull-left span3">
                    <label></label>
                    <div class="controls">
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <br>
        <div class="well-content no-search">
          <div id="container_grafik" style="height: 500px"></div>
        </div>
        <br>
        <div class="well-content clearfix" id="divTable">
              <table id="dataTable" class="table-striped" >
                  <thead>
                      <tr>
                          <th rowspan="2" style="text-align:center;">NO</th>
                          <!-- <th rowspan="2">Kode Unit</th> -->
                          <th rowspan="2" style="text-align:center;">UNIT</th>
                          <th rowspan="2" style="text-align:center;">PEMASOK</th>
                          <th rowspan="2" style="text-align:center;">JENIS BBM</th>
                          <th rowspan="2" style="text-align:center;">TGL AWAL TERIMA</th>
                          <th rowspan="2" style="text-align:center;">TGL AKHIR TERIMA</th>
                          <th rowspan="2" style="text-align:center;">JUMLAH TERIMA</th>
                          <th colspan="2" style="text-align:center;">TOTAL VOLUME TERIMA</th>
                      </tr>
                      <tr>
                        <th style="text-align:center;">DO (L)</th>
                        <th style="text-align:center;">REAL (L)</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
              </table>
        </div>

        <div id="form-content" class="modal fade modal-xlarge"></div>

    </div>
</div><br><br>

<script type="text/javascript">
    var vJsonTable;
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth()+1;
    var day = today.getDate();

    var dateAwal = year + '-' +
        (month<10 ? '0' : '') + month + '-01';

    var dateNow = year + '-' +
        (month<10 ? '0' : '') + month + '-' +
        (day<10 ? '0' : '') + day;

    $('select[name="TAHUN"]').val(year);

    getDataTable = function () {
        $('#divTable').show();
        setDataTable(vJsonTable);
        $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
    };
 
    var btnGetDataTable = Highcharts.getOptions().exporting.buttons.contextButton.menuItems;

    btnGetDataTable.push(
      {
        separator: true
      },{
        text: "Lihat Data Tabel",
        onclick: getDataTable
      }
    );

    function kFormatter(num) {
        // return num > 999 ? (num/1000).toFixed(1) + 'k' : num
        return (num/1000000).toFixed(2);
    }

    $(document).ready(function() {
        $(".form_datetime").datepicker({
          // format: "dd-mm-yyyy",
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

    function removeSeries_chart(){
        var chart = $('#container_grafik').highcharts();
        var seriesLength = chart.series.length;
        for(var i = seriesLength -1; i > -1; i--) {
            chart.series[i].remove();
        }
    }

    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function getNamaUnit(){
        var vUnit = '';

        if ($('#lvl0').val() && $('#lvl0').val()!='00'){
            // vUnit = 'REGIONAL '+ $('#lvl0 option:selected').text()+'<br>';
            vUnit = $('#lvl0 option:selected').text()+'<br>';
        }
        if ($('#lvl1').val() && $('#lvl1').val()!='0'){
            vUnit = vUnit + $('#lvl1 option:selected').text();
        }
        if ($('#lvl2').val() && $('#lvl2').val()!='0'){
            vUnit = vUnit +', '+ $('#lvl2 option:selected').text();
        }
        if ($('#lvl3').val() && $('#lvl3').val()!='0'){
            vUnit = vUnit +', '+ $('#lvl3 option:selected').text();
        }
        if ($('#lvl4').val() && $('#lvl4').val()!='0'){
            vUnit = vUnit +', '+ $('#lvl4 option:selected').text();
        }

        if ($('#bbm').val()){
            if (vUnit){
                vUnit = vUnit +'<br>Jenis BBM : '+ $('#bbm option:selected').text();   
            } else {
                vUnit = 'Jenis BBM : '+ $('#bbm option:selected').text();  
            }
        }

        if ($('#tglawal').val()){
            if (vUnit){
                vUnit = vUnit +'<br>'+ $('#tglawal').val()+' s/d '+$('#tglakhir').val();    
            } else {
                vUnit = vUnit + $('#tglawal').val()+' s/d '+$('#tglakhir').val();
            }
        } else {
            if (vUnit){
                vUnit = vUnit +'<br>'+ dateAwal +' s/d '+ dateNow;    
            } else {
                vUnit = vUnit + dateAwal +' s/d '+ dateNow;    
            }
        }

        return vUnit;
    }

    $('#divTable').hide();
    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);

    function setGrafikAwal(resp){
        var obj = JSON.parse(resp);
        var data_do = [];
        var data_real = [];
        var data_wilayah = [];

        // vJsonTable = resp;

        $.each(obj, function(index, value) {
            var temp_do = {};
            var temp_real = {};
            data_wilayah.push(value.UNIT);

            temp_do.name = value.NAMA_JNS_BHN_BKR+'<br>'+value.NAMA_PEMASOK;
            temp_real.name = value.NAMA_JNS_BHN_BKR+'<br>'+value.NAMA_PEMASOK;

            temp_do.y = parseInt(value.VOL_TERIMA);
            temp_real.y = parseInt(value.VOL_TERIMA_REAL);

            temp_do.color = '#2E8B57';
            temp_real.color = '#8FBC8F';

            data_do.push(temp_do);
            data_real.push(temp_real);
        }); 
                
        $(function (){
            $('#container_grafik').highcharts({
                chart : {
                    type: 'column'
                },
                title: {
                    text: 'Penerimaan BBM Per Pemasok'
                },  
                subtitle: {
                    text: getNamaUnit(),
                },           
                xAxis: {
                    categories: data_wilayah,
                    title: {
                        text: 'PEMASOK BBM',
                        style: {
                            fontWeight: 'bold'
                        }                        
                    },
                    labels: {
                        style: {
                            // fontWeight: 'bold'
                        }
                    }
                },
                plotOptions: {
                    series: {
                        pointPadding: 0,
                        dataLabels: {
                            enabled: true,
                            formatter:function() {
                                return kFormatter(this.y);
                            }
                        }
                    }
                },
                yAxis: {
                    title: {
                        text: 'Volume  X  1.000.000 (L)'
                    },
                    labels: {
                        formatter: function () {
                            return  this.value / 1000000;
                        }   
                    },
                    maxPadding: 0.05
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
                        // showInLegend: false,
                        name: 'Volume DO',
                        color: '#2E8B57',
                        data: data_do
                    },
                    {
                        name: 'Volume Real',
                        color: '#8FBC8F',
                        data: data_real
                    }
                        ],
                responsive: {
                    rules: [
                        {
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
                        }
                    ]
                }
            });

        });       
    }

    function getDetailTabel(vbbm,vawalParsed,vakhirParsed,vlvl0,vlevelid,pemasok,cari){ 
        $.ajax({
            type: "POST",
            data: {
                "jenis_bbm": vbbm,
                "tglAwal": vawalParsed,
                "tglAkhir": vakhirParsed,
                "vlevel": vlvl0,
                "vlevelid": vlevelid,
                "pemasok": pemasok,
                "cari": cari
            },
            url : "<?php echo base_url('dashboard/penerimaan_pemasok/get_data_tabel'); ?>",          
            success:function(resp) {
                vJsonTable = resp;
            }
        });
    }

    getGrafik();    
    function getGrafik() {
        var lvl0 = $('#lvl0').val(); 
        var lvl1 = $('#lvl1').val(); 
        var lvl2 = $('#lvl2').val(); 
        var lvl3 = $('#lvl3').val(); 
        var lvl4 = $('#lvl4').val(); 
        var bbm = $('#bbm').val(); 
        var bln = $('#bln').val(); 
        var thn = $('#thn').val(); 
        var pemasok = '-';
        var cari = '';
        var tglAwal= $('#tglawal').val().replace(/-/g, '');//02-11-2018
        var tglAkhir =$('#tglakhir').val().replace(/-/g, '');

        var awal_tahun = tglAwal.substring(0,4);
        var awal_bulan = tglAwal.substring(4,6);
        var awal_hari = tglAwal.substring(6,8);
        var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

        var akhir_tahun = tglAkhir.substring(0,4);
        var akhir_bulan = tglAkhir.substring(4,6);
        var akhir_hari = tglAkhir.substring(6,8);
        var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

        $('#divTable').hide();
        $('html, body').animate({scrollTop: $("#container_grafik").offset().top}, 1000);

        if (tglAwal == '' && tglAkhir != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
        }else if(tglAkhir == '' && tglAwal != ''){
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
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
            if(lvl0 == ''){
                lvl0 = 'All';
                vlevelid = '';
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

            if (awalParsed == '' && akhirParsed == '') {
              awalParsed = "-";
              akhirParsed = '-';
            }

            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            $.ajax({
                type: "POST",
                url : "<?php echo base_url('dashboard/penerimaan_pemasok/get_data'); ?>",                
                data: {
                    "jenis_bbm": bbm,
                    "tglAwal": awalParsed,
                    "tglAkhir": akhirParsed,
                    "vlevel": lvl0,
                    "vlevelid":vlevelid,
                    "pemasok": pemasok,
                    "cari": cari
                    },
                success:function(response) {

                    setGrafikAwal(response);

                    getDetailTabel(bbm,awalParsed,akhirParsed,lvl0,vlevelid,pemasok,cari);
                    
                    bootbox.hideAll();
                }
            });
        }
    };

    $('#button-load').click(function(e) {
        getGrafik();
    });

    $(document).ready(function() {
        $('#dataTable').dataTable({
            "scrollY": "370px",
            "scrollX": true,
            "scrollCollapse": false,
            "bPaginate": true,
            "searching":false,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "bAutoWidth": false,
            "ordering": false,
            
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
            },
            "columnDefs": [
                {"className": "dt-center","targets": [0,3,4,5]},
                {"className": "dt-left","targets": [1,2]},
                {"className": "dt-right","targets": [6,7,8]},
            ]
        });
    } );

    function setDataTable(vdata){
      var obj = JSON.parse(vdata);
      var t = $('#dataTable').DataTable();
      t.clear().draw();

      var nomer = 1;
      $.each(obj, function (index, value) {

        var UNIT = value.UNIT == null ? "" : value.UNIT;
        var KODE_UNIT = value.KODE == null ? "" : value.KODE;
        var NAMA_PEMASOK = value.NAMA_PEMASOK == null ? "" : value.NAMA_PEMASOK;
        var ID_BBM = value.ID_BBM == null ? "" : value.ID_BBM;
        var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
        var TGL_AWAL = value.TGL_AWAL == null ? "" : value.TGL_AWAL;
        var TGL_AKHIR = value.TGL_AKHIR == null ? "" : value.TGL_AKHIR;
        var JUMLAH_PASOKAN = value.JUMLAH_PASOKAN == null ? "" : value.JUMLAH_PASOKAN;
        var VOL_TOTAL_TERIMA = value.VOL_TERIMA == null ? "" : value.VOL_TERIMA;
        var VOL_TOTAL_TERIMA_REAL = value.VOL_TERIMA_REAL == null ? "" : value.VOL_TERIMA_REAL;

        t.row.add( [
            nomer, 
            // KODE_UNIT,
            UNIT, 
            NAMA_PEMASOK,
            NAMA_JNS_BHN_BKR, 
            TGL_AWAL,
            TGL_AKHIR, 
            convertToRupiah(JUMLAH_PASOKAN), 
            convertToRupiah(VOL_TOTAL_TERIMA),
            convertToRupiah(VOL_TOTAL_TERIMA_REAL)
        ] ).draw( false );

        nomer++;
      });

      // bootbox.hideAll();
      // };
    }

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

        function disabledDetailButton(){
            $('#button-detail').removeClass('disabled');
            $('#button-detail').addClass('disabled');
        }

        $('select[name="ID_REGIONAL"]').on('change', function() {
            var stateID = $(this).val();
            console.log(stateID);
            var vlink_url = '<?php echo base_url()?>dashboard/penerimaan_pemasok/get_options_lv1/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>dashboard/penerimaan_pemasok/get_options_lv2/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>dashboard/penerimaan_pemasok/get_options_lv3/'+stateID;
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
            var vlink_url = '<?php echo base_url()?>dashboard/penerimaan_pemasok/get_options_lv4/'+stateID;
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
