<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<!-- <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.css"> -->
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>


<style>
    #exampleModal{
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
    tr {background-color: #B0C4DE;}

    table {
        border-collapse: collapse;
        width:100%;
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
            <span><?php echo isset($page_title) ? $page_title : 'List Transaksi NPPS'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <!-- <div class="well"> -->
            <div class="well-content clearfix">
                <?php echo form_open_multipart('', array('id' => 'ffilter-cari')); ?>
                <div class="form_row">
                    <div class="pull-left span4">
                        <label for="password" class="control-label">Pembangkit : </label>
                        <div class="controls">
                            <?php echo form_dropdown('SLOC_CARI', $lv4_options_cari, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4_cari" class="chosen span4"'); ?>
                        </div>                                    
                    </div>
                    <div class="pull-left span4">
                        <label></label>                                    
                        <div class="controls">
                            <?php echo anchor(NULL, "<i class='icon-zoom-in'></i> Quick Search", array('class' => 'btn yellow', 'id' => 'button-filter-cari')); ?>
                        </div>
                    </div> 
                </div>
                <div id="divData"></div>
                <?php echo form_close(); ?>
            </div>
        <!-- </div>    -->
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
                <!-- jenis transaksi -->
                <div class="pull-left span3">
                    <label for="password" class="control-label">Transaksi <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('JENIS', $jenis_transaksi, !empty($default->ID_JENIS) ? $default->ID_JENIS : '', 'id="jenis"'); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
              <div class="pull-left span3">
                  <label for="password" class="control-label">Periode <span class="required">*</span> : </label>
                  <label for="password" class="control-label" style="margin-left:38px"></label>
                  <div class="controls">
                      <?php echo form_input('TGL_DARI', !empty($default->TGL_DARI) ? $default->TGL_DARI : '', 'class="form_datetime" style="width: 115px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                      <label for="">s/d</label>
                      <?php echo form_input('TGL_SAMPAI', !empty($default->TGL_SAMPAI) ? $default->TGL_SAMPAI : '', 'class="form_datetime tglakhir" style="width: 115px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
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
                <div class="pull-left span2">
                    <label for="password" class="control-label">Cari: </label>
                    <div class="controls">
                        <input type="text" id="cariPembangkit" name="" value="" placeholder="Cari Unit">
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
                <div class="pull-left span2">

                </div>
                <div class="pull-left span2">

                </div>
                <div class="pull-left span4">
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
                        <th>Level1</th>
                        <th>Level2</th>
                        <th>Level3</th>
                        <th>Pembangkit</th>
                        <th>Nomor Transaksi</th>
                        <th>Tgl Transaksi</th>
                        <th>User Entry</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        
    </div>
</div>
<br>

<form id="export_excel" action="<?php echo base_url('user_management/list_transaksi/export_excel'); ?>" method="post">
    <input type="hidden" name="xlvl0">
    <input type="hidden" name="xlvl1">
    <input type="hidden" name="xlvl2">
    <input type="hidden" name="xlvl3">
    <input type="hidden" name="xlvl0_nama">
    <input type="hidden" name="xlvl1_nama">
    <input type="hidden" name="xlvl2_nama">
    <input type="hidden" name="xlvl3_nama">
    <input type="hidden" name="xlvl4">
    <input type="hidden" name="xbln">
    <input type="hidden" name="xthn">
    <input type="hidden" name="xlvlid">
    <input type="hidden" name="xlvl">
    <input type="hidden" name="xtglawal">
    <input type="hidden" name="xtglakhir">
    <input type="hidden" name="xjenis">
    <input type="hidden" name="xcari">
</form>

<form id="export_pdf" action="<?php echo base_url('user_management/list_transaksi/export_pdf'); ?>" method="post" target="_blank">
    <input type="hidden" name="plvl0">
    <input type="hidden" name="plvl">
    <input type="hidden" name="plvlid">
    <input type="hidden" name="plvl1">
    <input type="hidden" name="plvl2">
    <input type="hidden" name="plvl3">
    <input type="hidden" name="plvl0_nama">
    <input type="hidden" name="plvl1_nama">
    <input type="hidden" name="plvl2_nama">
    <input type="hidden" name="plvl3_nama">
    <input type="hidden" name="plvl4">
    <input type="hidden" name="pbln">
    <input type="hidden" name="pthn">
    <input type="hidden" name="ptglawal">
    <input type="hidden" name="ptglakhir">
    <input type="hidden" name="pjenis">
    <input type="hidden" name="pcari">
</form>

<script type="text/javascript">
    $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);

    $(document).ready(function() {
        // $('#button-detail').addClass('disabled');
        // $("#button-detail").attr("disabled", true);
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
            setCekTgl();
          }
      });

      $('#tglakhir').on('change', function() {
          setCekTgl();
      });
    });
    var today = new Date();
    var year = today.getFullYear();

    $('select[name="TAHUN"]').val(year);

    $(document).ready(function() {
        $('#dataTable').dataTable({
            "scrollY": "450px",
            "ordering" : true,
            "searching": false,
            "scrollX": true,
            "scrollCollapse": false,
            "bPaginate": true,
            "lengthMenu": [10, 25, 50, 100, 200],
            "bLengthChange": true,
            "bFilter": false,
            "bInfo": true,
            "bAutoWidth": true,
            // "fixedColumns": {"leftColumns": 6},
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
                    "className": "dt-center",
                    "targets": [0,1,2,3,4,5,6,7,8]
                }
            ]
        });
    } );

    $('#cariPembangkit').keyup(function(e){
      if(e.keyCode == 13)
      {
        $('#button-load').click();
      }
    });

    $('#button-filter-cari').click(function() {
        var sloc = $('#lvl4_cari').val();
        if (sloc) {            
            get_data_unit(sloc,sloc);            
        } else {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Pencarian Pembangkit harus dipilih-- </div>', function() {});
        }
    });  

    function setComboDefault(_id,_unit,_nama){
        if ($(_id+' option').size() <= 1){
            $(_id).empty();
            $(_id).append('<option value='+_unit+'>'+_nama+'</option>');
        } else {
            $(_id).val(_unit);
        }                   
        $(_id).data("placeholder","Select").trigger('liszt:updated');
    }

    function get_data_unit(sloc,sloc_cari){
        bootbox.hideAll();
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('user_management/list_transaksi/get_data_unit'); ?>",                
            data: { "SLOC": sloc},
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data_unit gagal');                
            },            
            success:function(data) {                 
                $.each(data, function () {
                    setComboDefault('#lvl0',this.ID_REGIONAL,this.LEVEL1);
                    setComboDefault('#lvl1',this.COCODE,this.LEVEL1);
                    setComboDefault('#lvl2',this.PLANT,this.LEVEL2);
                    setComboDefault('#lvl3',this.STORE_SLOC,this.LEVEL3);
                    if (sloc_cari){
                        setComboDefault('#lvl4',this.SLOC,this.LEVEL4);    
                    }
                });             
                    
                bootbox.hideAll();

                // if (sloc_cari){
                //     get_data(sloc_cari);
                // }
            }
        });    
    }

    $('#button-load').click(function(e) {
        // $(".bdet").attr("disabled", true);
        var lvl0 = $('#lvl0').val(); //Regional dropdown
        var lvl1 = $('#lvl1').val(); //level1 dropdown
        var lvl2 = $('#lvl2').val(); //level2 dropdown
        var lvl3 = $('#lvl3').val(); //level3 dropdown
        var lvl4 = $('#lvl4').val(); //pembangkit dropdown
        var jenis = $('#jenis').val(); //jenis transaksi dropdown
        var bln = $('#bln').val(); //bulan dropdown
        var thn = $('#thn').val(); //tahun dropdown
        var tglAwal= $('#tglawal').val().replace(/-/g, '');//02-11-2018
        var tglAkhir =$('#tglakhir').val().replace(/-/g, '');
        var cari = $('#cariPembangkit').val();

        var awal_tahun = tglAwal.substring(0,4);
        var awal_bulan = tglAwal.substring(4,6);
        var awal_hari = tglAwal.substring(6,8);
        var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

        var akhir_tahun = tglAkhir.substring(0,4);
        var akhir_bulan = tglAkhir.substring(4,6);
        var akhir_hari = tglAkhir.substring(6,8);
        var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

        console.log("Awalparsed:"+awalParsed+" akhrparsed:"+akhirParsed);

        //check last filled vlevlid
        if (lvl0=='') {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
        }else if (tglAwal == '' && tglAkhir != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
        }else if(tglAkhir == '' && tglAwal != ''){
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
        } else if(jenis == '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Jenis transaksi tidak boleh kosong-- </div>', function() {});
        }else {
            // lvl0 : jenis2 level -> Regional,Level 1, Level 2, Level 3
            // lvl3 : isi dari VLEVELID
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

            if (tglAwal == '' && tglAkhir == '') {
              awalParsed = "-";
              akhirParsed = '-';
            }

            // console.log("BBM: " + bbm + ' tahun: '+thn+' bulan: '+bln +' regional: '+ lvl0+' vlevlid: ' + vlevelid);
            console.log("Jenis: " +jenis+ ' Tglakhir: '+akhirParsed+' Tglawal: '+awalParsed +' regional: '+ lvl0+' vlevlid: ' + vlevelid);
            bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                $.ajax({
                    type: "POST",
                    url : "<?php echo base_url('user_management/list_transaksi/getTransaksi'); ?>",
                    data: {
                        "JENIS": jenis,
                        // "BULAN":bln,
                        // "TAHUN": thn,
                        "ID_REGIONAL": lvl0,
                        "VLEVELID":vlevelid,
                        "TGLAWAL": awalParsed,
                        "TGLAKHIR": akhirParsed,
                        "cari" :cari
                        },
                    success:function(response) {
                        var obj = JSON.parse(response);
                        var t = $('#dataTable').DataTable();

                        t.clear().draw();

                        if (obj == "" || obj == null) {
                            bootbox.hideAll();
                            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
                        } else {
                            console.log(jenis);
                            if (jenis == '1') {
                                var nomer = 1;
                                var total = obj.length;

                                $.each(obj, function (index, value) {
                                    // console.log(jenis);
                                    var LEVEL1 = value.LEVEL1 == null ? "" : value.LEVEL1;
                                    var LEVEL2 = value.LEVEL2 == null ? "" : value.LEVEL2;
                                    var LEVEL3 = value.LEVEL3 == null ? "" : value.LEVEL3;
                                    var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                                    var NO_NOMINASI = value.NO_NOMINASI == null ? "" : value.NO_NOMINASI;
                                    var TGL_MTS_NOMINASI = value.TGL_MTS_NOMINASI == null ? "" : value.TGL_MTS_NOMINASI;
                                    var CD_BY_MTS_NOMINASI = value.CD_BY_MTS_NOMINASI == null ? "" : value.CD_BY_MTS_NOMINASI;
                                    var STATUS_APPRO = value.STATUS_APPRO == null ? "" : value.STATUS_APPRO;
        
                                    t.row.add( [
                                        nomer, LEVEL1,
                                        LEVEL2, LEVEL3,
                                        LEVEL4, NO_NOMINASI,
                                        TGL_MTS_NOMINASI, CD_BY_MTS_NOMINASI, STATUS_APPRO
                                    ] ).draw( false );

                                    if (nomer==1){
                                        bootbox.hideAll();
                                        // $('#div_load').show();
                                        bootbox.dialog('<div class="loading-progress"></div>');                    
                                    }

                                    if (nomer>=total){
                                        bootbox.hideAll();
                                        // $('#div_load').hide('slow');                                       
                                    }
                                    nomer++;
                                });                      
                            } 
                            if (jenis == '2') {
                                var nomer = 1;
                                $.each(obj, function (index, value) {
                                    // console.log(jenis);
                                    var LEVEL1 = value.LEVEL1 == null ? "" : value.LEVEL1;
                                    var LEVEL2 = value.LEVEL2 == null ? "" : value.LEVEL2;
                                    var LEVEL3 = value.LEVEL3 == null ? "" : value.LEVEL3;
                                    var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                                    var NO_TUG = value.NO_TUG == null ? "" : value.NO_TUG;
                                    var TGL_MUTASI_PENGAKUAN = value.TGL_MUTASI_PENGAKUAN == null ? "" : value.TGL_MUTASI_PENGAKUAN;
                                    var CD_BY_MUTASI_PEMAKAIAN = value.CD_BY_MUTASI_PEMAKAIAN == null ? "" : value.CD_BY_MUTASI_PEMAKAIAN;
                                    var STATUS_APPRO = value.STATUS_APPRO == null ? "" : value.STATUS_APPRO;
        
                                    t.row.add( [
                                        nomer, LEVEL1,
                                        LEVEL2, LEVEL3,
                                        LEVEL4, NO_TUG,
                                        TGL_MUTASI_PENGAKUAN, CD_BY_MUTASI_PEMAKAIAN, STATUS_APPRO
                                    ] ).draw( false );
                                    nomer++;
                                });
                                bootbox.hideAll();
                                $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                            }
                            if (jenis == '3') {
                                var nomer = 1;
                                $.each(obj, function (index, value) {
                                    // console.log(jenis);
                                    var LEVEL1 = value.LEVEL1 == null ? "" : value.LEVEL1;
                                    var LEVEL2 = value.LEVEL2 == null ? "" : value.LEVEL2;
                                    var LEVEL3 = value.LEVEL3 == null ? "" : value.LEVEL3;
                                    var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                                    var NO_MUTASI_TERIMA = value.NO_MUTASI_TERIMA == null ? "" : value.NO_MUTASI_TERIMA;
                                    var TGL_PENGAKUAN = value.TGL_PENGAKUAN == null ? "" : value.TGL_PENGAKUAN;
                                    var CD_BY_MUTASI_TERIMA = value.CD_BY_MUTASI_TERIMA == null ? "" : value.CD_BY_MUTASI_TERIMA;
                                    var STATUS_APPRO = value.STATUS_APPRO == null ? "" : value.STATUS_APPRO;
        
                                    t.row.add( [
                                        nomer, LEVEL1,
                                        LEVEL2, LEVEL3,
                                        LEVEL4, NO_MUTASI_TERIMA,
                                        TGL_PENGAKUAN, CD_BY_MUTASI_TERIMA, STATUS_APPRO
                                    ] ).draw( false );
                                    nomer++;
                                });
                                bootbox.hideAll();
                                $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                            }

                            if (jenis == '4') {
                                var nomer = 1;
                                $.each(obj, function (index, value) {
                                    // console.log(jenis);
                                    var LEVEL1 = value.LEVEL1 == null ? "" : value.LEVEL1;
                                    var LEVEL2 = value.LEVEL2 == null ? "" : value.LEVEL2;
                                    var LEVEL3 = value.LEVEL3 == null ? "" : value.LEVEL3;
                                    var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                                    var NO_STOCKOPNAME = value.NO_STOCKOPNAME == null ? "" : value.NO_STOCKOPNAME;
                                    var TGL_BA_STOCKOPNAME = value.TGL_BA_STOCKOPNAME == null ? "" : value.TGL_BA_STOCKOPNAME;
                                    var CD_BY_STOKOPNAME = value.CD_BY_STOKOPNAME == null ? "" : value.CD_BY_STOKOPNAME;
                                    var STATUS_APPRO = value.STATUS_APPRO == null ? "" : value.STATUS_APPRO;

                                    t.row.add( [
                                        nomer, LEVEL1,
                                        LEVEL2, LEVEL3,
                                        LEVEL4, NO_STOCKOPNAME,
                                        TGL_BA_STOCKOPNAME, CD_BY_STOKOPNAME, STATUS_APPRO
                                    ] ).draw( false );
                                    nomer++;
                                });
                                bootbox.hideAll();
                                $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                            }
                        };
                    }
                });
        };
    });

    $('#cariPembangkit').on( 'keyup', function () {
        var table = $('#dataTable').DataTable();
        table.search( this.value ).draw();
    } );

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

    function clearDT_Detail()
    {
        var t = $('#dataTable_detail').DataTable();
        t.clear().draw();
    }

    function tampilData_default()
    {
      $('#tampilData').val('-Tampilkan Data-');
      $('#tampilData_detail').val('-Tampilkan Data-');
    }
    function clearCari()
    {
      $('#cariDetail').val('');
    }
    
    $('#button-excel').click(function(e) {
      var lvl0 = $('#lvl0').val(); //Regional dropdown
      var lvl1 = $('#lvl1').val(); //level1 dropdown
      var lvl2 = $('#lvl2').val(); //level2 dropdown
      var lvl3 = $('#lvl3').val(); //level3 dropdown
      var lvl4 = $('#lvl4').val(); //pembangkit dropdown
      var jenis = $('#jenis').val(); //bahanBakar dropdown
      var bln = $('#bln').val(); //bulan dropdown
      var thn = $('#thn').val(); //tahun dropdown

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

          $('input[name="xlvl0"]').val($('#lvl0').val()); // 01
          $('input[name="xlvl1"]').val($('#lvl1').val()); //COCODE
          $('input[name="xlvl2"]').val($('#lvl2').val());
          $('input[name="xlvl3"]').val($('#lvl3').val());

          $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text()); // SUMATERA
          $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
          $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
          $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

          $('input[name="xlvl4"]').val($('#lvl4').val());  // 183130
          $('input[name="xjenis"]').val($('#jenis').val()); // 001
          $('input[name="xbln"]').val($('#bln').val()); // 1 -> Januari
          $('input[name="xthn"]').val($('#thn').val()); // 2017
          $('input[name="xthn"]').val($('#thn').val());
          $('input[name="xcari"]').val($('#cariPembangkit').val());
          var tglAwal = $('#tglawal').val().replace(/-/g, '');
          var tglAkhir = $('#tglakhir').val().replace(/-/g, '');
          var awal_tahun = tglAwal.substring(0,4);
          var awal_bulan = tglAwal.substring(4,6);
          var awal_hari = tglAwal.substring(6,8);
          var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

          var akhir_tahun = tglAkhir.substring(0,4);
          var akhir_bulan = tglAkhir.substring(4,6);
          var akhir_hari = tglAkhir.substring(6,8);
          var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);

          if (tglAwal == '' && tglAkhir == '') {
            tglAwal = "-";
            tglAkhir = '-';
            $('input[name="xtglawal"]').val(tglAwal);
            $('input[name="xtglakhir"]').val(tglAkhir);
          }else{
            $('input[name="xtglawal"]').val(awalParsed);
            $('input[name="xtglakhir"]').val(akhirParsed);
          }
          $('input[name="xlvlid"]').val(vlevelid);
          $('input[name="xlvl"]').val(lvl0);
          console.log(vlevelid);
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
        var jenis = $('#jenis').val(); //bahanBakar dropdown
        var bln = $('#bln').val(); //bulan dropdown
        var thn = $('#thn').val(); //tahun dropdown
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

            $('input[name="plvl0"]').val($('#lvl0').val());
            $('input[name="plvl1"]').val($('#lvl1').val());
            $('input[name="plvl2"]').val($('#lvl2').val());
            $('input[name="plvl3"]').val($('#lvl3').val());

            $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

            $('input[name="plvl4"]').val($('#lvl4').val());

            $('input[name="plvlid"]').val(vlevelid);
            $('input[name="pjenis"]').val($('#jenis').val());
            $('input[name="plvl"]').val(lvl0);
            $('input[name="pcari"]').val(cari);

            var tglAwal = $('#tglawal').val().replace(/-/g, '');
            var tglAkhir = $('#tglakhir').val().replace(/-/g, '');

            var awal_tahun = tglAwal.substring(0,4);
            var awal_bulan = tglAwal.substring(4,6);
            var awal_hari = tglAwal.substring(6,8);
            var awalParsed = awal_hari.concat(awal_bulan, awal_tahun);

            var akhir_tahun = tglAkhir.substring(0,4);
            var akhir_bulan = tglAkhir.substring(4,6);
            var akhir_hari = tglAkhir.substring(6,8);
            var akhirParsed = akhir_hari.concat(akhir_bulan, akhir_tahun);
            if (tglAwal == '' && tglAkhir == '') {
              awalParsed = "-";
              akhirParsed = '-';
              $('input[name="ptglawal"]').val(awalParsed);
              $('input[name="ptglakhir"]').val(akhirParsed);
            }else{
              $('input[name="ptglawal"]').val(awalParsed);
              $('input[name="ptglakhir"]').val(akhirParsed);
            }
            console.log("PDF: tglawal "+awalParsed+ "tglakhir: "+akhirParsed+"vlevelid: "+vlevelid+"jenis: "+jenis);
            // $('input[name="pbln"]').val($('#bln').val());
            // $('input[name="pthn"]').val($('#thn').val());

            bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_pdf').submit();
                }
            });
        }
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
            $('select[name="SLOC"]').append('<option value="">--Pilih Level 4--</option>');
        }

        function disabledDetailButton()
        {
            $('#button-detail').removeClass('disabled');
            $('#button-detail').addClass('disabled');
        }


        $('select[name="ID_REGIONAL"]').on('change', function() {

            var stateID = $(this).val();
            console.log(stateID);
            var vlink_url = '<?php echo base_url()?>user_management/list_transaksi/get_options_lv1/'+stateID;
            disabledDetailButton();

            setDefaultLv1();
            setDefaultLv2();
            setDefaultLv3();
            setDefaultLv4();
            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                        });
                    }
                });
            }
        });

        $('select[name="COCODE"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>user_management/list_transaksi/get_options_lv2/'+stateID;
            disabledDetailButton();
            clearDT_Detail();
            setDefaultLv2();
            setDefaultLv3();
            setDefaultLv4();
            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                        });
                    }
                });
            }
        });

        $('select[name="PLANT"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>user_management/list_transaksi/get_options_lv3/'+stateID;
            disabledDetailButton();

            setDefaultLv3();
            setDefaultLv4();
            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                        });
                    }
                });
            }
        });

        $('select[name="STORE_SLOC"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>user_management/list_transaksi/get_options_lv4/'+stateID;
            disabledDetailButton();

            setDefaultLv4();
            if(stateID) {
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                        });
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

            console.log($(this).val());
            /* Act on the event */
        });
    });
</script>
