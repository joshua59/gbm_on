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
            <div class="span12">
                <div class="well-content no-search">
          
                    <!-- Filter -->
                <div class="well">
                    <button type="button" id="btn-collapse" class="btn btn-primary col-md-12" style="font-weight: bold;font-size: 16px">
                      Fitur Pencarian
                    </button>
                    <br/>
                    <div id="collapse" class="well-content" style="display: none;">
                        <div class="form_row">
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Regional : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Level 1 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1" '); ?>
                                </div>
                            </div>
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Level 2 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="form_row">
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Level 3 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Pembangkit : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span4">
                                <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                                <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php $now = strtotime(date('Y-m-d')); $bulan = date('m', $now); ?>
                                    <?php echo form_dropdown('BULAN', $opsi_bulan, $bulan, 'style="width: 137px;", id="bln"'); ?>
                                    <?php echo form_dropdown('TAHUN', $opsi_tahun, '', 'style="width: 80px;", id="thn"'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form_row">
                            <div class="pull-left span5">
                            <br>
                                <div class="controls">
                                    <?php echo anchor(null, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter', 'onclick'=> 'load_grafik()')); ?></td>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filter -->
                    <div id="div_grafik">
                       <div id="container_grafik" style="height: 500px"></div>                     
                    </div>                    
                    <table>
                        <tr>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>   
                            <td><label id="lb_total">- Total Data : 0</label></td>                            
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><label id="lb_tdk_tertera">- Total Tidak Tertera : 0</label></td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <td><label id="lb_tertera">- Total Tertera : 0</label></td>                         
                        </tr>
                    </table>
                    <hr>
                    <br>
                 </div>                 
                    <div class="well-content clearfix" id="divTable">
                        <table id="dataTable" class="table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">No</th>
                                    <th style="text-align:center;">Volume Tangki</th>
                                    <th style="text-align:center;">Tertera</th>
                                    <th style="text-align:center;">Tidak Tertera</th>
                                    <th style="text-align:center;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>                        
                    </div>

         </div>
            </div>
            <div id="form-content" class="modal fade modal-xlarge">

            </div>
        </div>
        <div id="divBawah"></div>
    </div>
    <br><br>
</div>

<script>
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth();
    var strMonth;
    var vJsonTable;

    month++;

    if (month < 10) {
        strMonth = '0'+month;
    } else {
        strMonth = month;
    }

    $('select[name="TAHUN"]').val(year);
    $('select[name="BULAN"]').val(strMonth);

    getDataTable = function () {
        $('#divTable').show();
        setDataTable(vJsonTable);
        $('html, body').animate({scrollTop: $("#divBawah").offset().top}, 1000);
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

    $('#divTable').hide();
    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);

    function convertToRupiah(angka){
        var bilangan = parseFloat(Math.round(angka * 100) / 100).toFixed(2);
        bilangan = bilangan.replace(".", ",");
        var isMinus = '';

        if (bilangan.indexOf('-') > -1) {
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

    function getNamaUnit(vBBM){
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

        if (vBBM){
            if (vUnit){
                vUnit = vUnit +'<br>Jenis BBM : '+ vBBM;    
            } else {
                vUnit = 'Jenis BBM : '+ vBBM;    
            }
        }

        return vUnit;
    }

    load_grafik();
    function load_grafik(){
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var bln = $('#bln').val();
        var thn = $('#thn').val();
        var vlevelid;

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

        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
        $('#divTable').hide();

        // if (lvl0 == '') {
        //  // bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        // } else {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('laporan/tangki/get_grafik'); ?>",
                data: {
                    "VLEVEL": lvl0,
                    "VLEVELID": vlevelid
                },
                success:function(response) {
                    var obj = JSON.parse(response);
                    var tertera = [];
                    var tidakTertera = [];
                    var volume_tangki = [];
                    var sum_tertera = 0;
                    var sum_tidak_tertera = 0;
                    var sum_total = 0;

                    if (obj == "" || obj == null) {
                        $('#div_grafik').hide();
                        bootbox.hideAll();
                        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                        // removeSeries_chart();
                    }else{
                        $('#div_grafik').show();
                        $('html, body').animate({scrollTop: $("#div_grafik").offset().top}, 1000);
                        vJsonTable = response;

                        $.each(obj, function(index, value){
                            tertera.push(parseFloat(value.TERTERA));
                            tidakTertera.push(parseFloat(value.TDK_TERTERA));
                            volume_tangki.push(value.VOLUME_TANGKI);  
                            sum_tertera = parseFloat(sum_tertera)+parseFloat(value.TERTERA);
                            sum_tidak_tertera = parseFloat(sum_tidak_tertera)+parseFloat(value.TDK_TERTERA);
                        });

                        sum_total = parseFloat(sum_tertera)+parseFloat(sum_tidak_tertera);

                        $('#lb_total').html('- Total Data : '+toRp(sum_total));
                        $('#lb_tdk_tertera').html('- Total Tidak Tertera : '+toRp(sum_tidak_tertera));
                        $('#lb_tertera').html('- Total Tertera : '+toRp(sum_tertera));
                            
                        $(function (){
                            $('#container_grafik').highcharts({
                                chart : {
                                    type: 'column'
                                },
                                title: {
                                    text: 'Jumlah Tangki Per Kapasitas'
                                },
                                subtitle: {
                                    text: getNamaUnit()
                                },
                                xAxis: {
                                    categories: volume_tangki,
                                    title: {
                                        text: 'Volume Tangki (L)'
                                    },
                                    labels: {
                                        style: {
                                            fontWeight: 'bold'
                                        }
                                    }
                                },
                                yAxis: {
                                    title: {
                                        text: 'Jumlah'
                                    },
                                    maxPadding: 0.05
                                },

                                series: [{
                                    name: 'Tidak Tertera',
                                    data: tidakTertera,
                                    stack: 'male'
                                }, {
                                    name: 'Tertera',
                                    data: tertera,
                                    stack: 'male',
                                    color: '#595988',
                                    stackName: 'male'
                                }],
                                plotOptions: {
                                    column: {
                                        stacking: 'normal',
                                    }
                                },
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
                        bootbox.hideAll();
                    }
                }
            });
        // };
    }  

    function toRp(num){ 
        var number_string = num.toString(),
            sisa    = number_string.length % 3,
            rupiah  = number_string.substr(0, sisa),
            ribuan  = number_string.substr(sisa).match(/\d{3}/g);
                
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }        

        return rupiah;
    }

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
            // "fixedColumns": {"leftColumns": 2},
            
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
            },

            "columnDefs": [
                {"className": "dt-center","targets": [0,1]},
                // {"className": "dt-left","targets": [1]},
                {"className": "dt-right","targets": '_all'},
            ]
        });
    });

    function setDataTable(vdata){
      var obj = JSON.parse(vdata);
      var t = $('#dataTable').DataTable();
      t.clear().draw();

      var nomer = 1;
      $.each(obj, function (index, value) {

        // var UNIT = value.UNIT == null ? "" : value.UNIT;

        t.row.add( [
            nomer, 
            value.VOLUME_TANGKI, 
            convertToRupiah(value.TERTERA),
            convertToRupiah(value.TDK_TERTERA),
            convertToRupiah(value.JML)
        ]).draw( false );

        nomer++;
      });
    }
</script>

<script>
    jQuery(document).ready(function($)
    {  
      $("#btn-collapse").click(function()
      {

        $("#collapse").slideToggle( "slow");

          if ($("#btn-collapse").text() == "Pilih Pencarian") {
            $("#btn-collapse").text("Fitur Pencarian")
          }
          else {
            $("#btn-collapse").text("Pilih Pencarian")
          }

      });
    });

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

    $('select[name="ID_REGIONAL"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv1/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv2/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv3/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>dashboard/grafik/get_options_lv4/'+stateID;
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
</script>
