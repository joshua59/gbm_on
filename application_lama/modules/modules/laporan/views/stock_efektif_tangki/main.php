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
            <span><?php echo isset($page_title) ? $page_title : 'Laporan Stock Akhir BBM & Volume Efektif Tangki'; ?></span>
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
                    <!-- <label for="password" class="control-label" style="margin-left:38px">Tanggal Akhir : </label> -->
                    <div class="controls">
                        <?php echo form_input('TGL_DARI', !empty($default->TGL_DARI) ? $default->TGL_DARI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                        <label for="">s/d</label>
                        <?php echo form_input('TGL_SAMPAI', !empty($default->TGL_SAMPAI) ? $default->TGL_SAMPAI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                  <!-- <label for="" class="control-label" style="margin-left:1px;">Tampil data</label>
                  <div class="controls">
                    <?php echo form_dropdown('tampilData', array(
                      '-Tampilkan Data-'=> 'Tampilkan Data',
                      '25'              => '25 data',
                      '50'              => '50 data',
                      '100'             => '100 data',
                      '200'             => '200 data'
                    ), '', 'style="margin-left:1px;" id="tampilData"') ?>
                  </div> -->
                </div>
                <!-- <button type="button" name="button" id="testData">TEST</button> -->
                <div class="pull-left span2">
                    <label for="password" class="control-label">Cari: </label>
                    <div class="controls">
                        <input type="text" id="cariPembangkit" name="" value="" placeholder="Cari Pembangkit">
                    </div>
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
                    <!-- <label></label>
                    <div class="controls">

                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                        'class' => 'btn',
                        'id'    => 'button-excel'
                    )); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf'
                    )); ?>
                    </div> -->
                </div>
            </div>
            <div class="form_row">
                <!-- <div class="pull-left span3">
                    <label for="password" class="control-label">Bulan <span class="required">*</span> : </label>
                    <label for="password" class="control-label" style="margin-left:95px">Tahun <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php $now = strtotime(date('Y-m-d')); $bulan = date('m', $now); ?>
                        <?php echo form_dropdown('BULAN', $opsi_bulan, $bulan, 'style="width: 137px;", id="bln"'); ?>
                        <?php echo form_dropdown('TAHUN', $opsi_tahun, '', 'style="width: 80px;", id="thn"'); ?>
                    </div>
                </div> -->
                <div class="pull-left span2">
                    <label></label>
                    <div class="controls">
                        <!-- <button type="button" class="btn btn-primary" data-toggle='modal' data-target='#exampleModal' name="button">TSest</button> -->
                    <?php echo anchor(null, "<i class='icon'></i> Detail", array(
                        'class'       => 'btn green detail-kosong',
                        'id'          => 'button-detail'
                        // 'data-toggle' => 'modal',
                        // 'data-target' => '#exampleModal'
                    )); ?>
                    </div>
                </div>
                <!-- Tampilan modal detail -->
                <div class="pull-left span3">
                    <label></label>
                    <div class="controls">
                    <!-- <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                        'class' => 'btn',
                        'id'    => 'button-excel'
                    )); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf'
                    )); ?> -->
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
        <br>
        <div class="well-content clearfix" id="divTable">
              <table id="dataTable" class="table-striped" >
                  <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th colspan="4">Level</th>
                        <th rowspan="2">Pembangkit</th>
                        <th rowspan="2">Bahan Bakar</th>
                        <th rowspan="2">Tgl Mutasi Persediaan</th>
                        <th rowspan="2">Volume Persediaan BBM (L)</th>
                        <th rowspan="2">Volume Efektif Tangki (L)</th>
                        <!-- <th colspan="2">Volume (L)</th> -->
                        <!-- <th rowspan="2"></th> -->
                    </tr>
                    <tr>
                        <th>0</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <!-- <th>Volume Persediann BBM</th> -->
                        <!-- <th>Volume Efektif Tangki</th> -->
                    </tr>
                  </thead>
                  <tbody></tbody>
              </table>
        </div>

        <div id="form-content" class="modal fade modal-xlarge"></div>

    </div>
</div>

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

    function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    }

    $('#button-load').click(function(e) {
       // $(".bdet").attr("disabled", true);
        var lvl0 = $('#lvl0').val(); //Regional dropdown
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown
        var bbm = $('#bbm').val(); //bahanBakar dropdown
        var bln = $('#bln').val(); //bulan dropdown
        var thn = $('#thn').val(); //tahun dropdown
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
                url : "<?php echo base_url('laporan/stock_efektif_tangki/getData'); ?>",          
                // url : "<?php echo base_url('laporan/penerimaan/testGetData'); ?>",
                data: {
                    "jenis_bbm": bbm,
                    // "BULAN":bln,
                    // "TAHUN": thn,
                    "tglAwal": awalParsed,
                    "tglAkhir": akhirParsed,
                    "vlevel": lvl0,
                    "vlevelid":vlevelid,
                    "cari":cari
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
                            var NAMA_JNS_BHN_BKR = value.NAMA_JNS_BHN_BKR == null ? "" : value.NAMA_JNS_BHN_BKR;
                            var LEVEL0 = value.LEVEL0 == null ? "" : value.LEVEL0;
                            var LEVEL1 = value.LEVEL1 == null ? "" : value.LEVEL1;
                            var LEVEL2 = value.LEVEL2 == null ? "" : value.LEVEL2;
                            var LEVEL3 = value.LEVEL3 == null ? "" : value.LEVEL3;
                            var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                            var TGL_MUTASI_PERSEDIAAN = value.TGL_MUTASI_PERSEDIAAN == null ? "" : value.TGL_MUTASI_PERSEDIAAN;
                            var STOCK_AKHIR_REAL = value.STOCK_AKHIR_REAL == null ? "" : value.STOCK_AKHIR_REAL;
                            var STOCKEFEKTIF_TANGKI = value.STOCKEFEKTIF_TANGKI == null ? "" : value.STOCKEFEKTIF_TANGKI;

                            t.row.add( [
                                nomer, 
                                // KODE_UNIT,
                                LEVEL0, LEVEL1, LEVEL2, LEVEL3, LEVEL4,
                                // ID_BBM,
                                NAMA_JNS_BHN_BKR, TGL_MUTASI_PERSEDIAAN,
                                convertToRupiah(STOCK_AKHIR_REAL), 
                                convertToRupiah(STOCKEFEKTIF_TANGKI)
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
                {"className": "dt-center","targets": [0,1,2,3,4,5,6,7]},
            ]
        });
    } );

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
            console.log(stateID);
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
