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

    :-moz-any(#content,#appcontent) browser{
     margin-right:-14px!important;
     overflow-y:scroll;
     margin-bottom:-14px!important;
     overflow-x:scroll;
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
                    <button class="btn green",id="button-penerimaan" onclick="getAllPenerimaan()" style="font-weight: normal;"><i class="icon-exchange"></i> Grafik Penerimaan</button>
                    <button class="btn green",id="button-penerimaan" onclick="getAllPemakaian()" style="font-weight: normal;"><i class="icon-exchange"></i> Grafik Pemakaian</button>
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
               <br>
               <br>
               <?php echo form_close(); ?>
            </div>
        </div>
      </div>
    </div>
    <div class="well-content no-search">
        <div id="container_grafik" style=" max-width: 100%; height: 450px; margin: 0 auto"></div>
        <button id="btn_label">Hide Labels</button>
    </div>
    <div id="divTable">
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
                              <th style="text-align:center;width: 30%" rowspan="2"><?php echo str_repeat("&nbsp;", 5);?>REGIONAL<?php echo str_repeat("&nbsp;", 5);?></th>
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
                              <th style="text-align:center;width: 30%" rowspan="2"><?php echo str_repeat("&nbsp;", 5);?>REGIONAL<?php echo str_repeat("&nbsp;", 5);?></th>
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
    </div>
    <br><br>
</div>   


<script>
    var vJsonTable;
    var btnGetDataTable = Highcharts.getOptions().exporting.buttons.contextButton.menuItems;

    getDataTable = function () {
        var tipe = $('#TIPE').val();
        if(tipe == 1) {
            $('#divTable').show();
            $('#div_pemakaian').hide();
            $('#div_penerimaan').show();
        } else if(tipe == 2) {
            $('#divTable').show();
            $('#div_penerimaan').hide();
            $('#div_pemakaian').show();
        } else {
            return false;
        }
        $('html, body').animate({scrollTop: $('#divTable').offset().top}, 1000);      
    };

    btnGetDataTable.push(
      {
        separator: true
      },{
        text: "Lihat Data Tabel",
        onclick: getDataTable
      }
    );
    
    $(document).ready(function(){

        $('#btn_label').hide();
        $('#divTable').hide();
        $('#tglawal').val(getToday);

        $('#tglakhir').val(getLastYear);

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

        $(".form_datetime").datepicker({
          format: "yyyy-mm-dd",
          autoclose: true,
          todayBtn: true,
          pickerPosition: "bottom-left"
        });

        $('#tglawal').change(function(){
            var awal = $(this).val();

            $('#tglakhir').val(formatDate(awal));
        })

        $('#button-filter').click(function(){
            var tglAwal = $('#tglawal').val();
            var tglAkhir =$('#tglakhir').val();

            var awalthn = getYear(tglAwal);
            var akhirthn = getYear(tglAkhir);
            validate(tglAwal,tglAkhir,awalthn,akhirthn);
        })

        $('select[name="ID_REGIONAL"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>dashboard/penyerapan_bbm/get_options_lv1/'+stateID;
            setDefaultLv1();
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

        $('#btn_label').click(function() {
            var btn_text = $('#btn_label').text();   

            if (btn_text=='Hide Labels'){
                $('.svg').fadeOut();
                $('#btn_label').text('Show Labels');
            } else {
                $('.svg').fadeIn();
                $('#btn_label').text('Hide Labels');
            }
        }); 
    })

    function validate(tglAwal,tglAkhir,awalthn,akhirthn) {

        if(akhirthn > awalthn ) {
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
                if($('#TIPE').val() !== '') {
                     if($('#TIPE').val() == 1) {
                        getAllPenerimaan();
                    } else if($('#TIPE').val() == 2){
                        getAllPemakaian();
                    }
                } else {
                  getAllPenerimaan();
                } 
                
            }
        }
    }

    function getAllPenerimaan() {

        $('#divTable').hide();
        $('#TIPE').val(1)
        var lvl0        = $('#lvl0').val();
        var lvl1        = $('#lvl1').val();
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

        getDataTarget(awal_tahun,lvl0,vlevelid,tglAwal,tglAkhir);
        getDataTabelPenerimaan(tglAwal,tglAkhir,lvl0,vlevelid);
        getPenerimaanTotal(tglAwal, tglAkhir, lvl0, vlevelid)        
    }

    function getDataTarget(awal_tahun,lvl0,vlevelid,tglAwal,tglAkhir) {
        var vlink_url   = '<?php echo base_url() ?>dashboard/penyerapan_bbm/get_target_penerimaan';
        $.ajax({
            data : {
                "tglawal"  : tglAwal,
                "tglakhir" : tglAkhir,
                "vlevel"   : lvl0,
                "vlevelid" : vlevelid
            },
            url: vlink_url,
            type: "POST",
            beforeSend:function(res){
                bootbox.modal('<div class="loading-progress"></div>');
            },
            success:function(res) {
                getDataPenerimaan(tglAwal,tglAkhir,lvl0,vlevelid,res,awal_tahun);
            }
        });
    }

    function getDataPenerimaan(tglAwal,tglAkhir,lvl0,vlevelid,res,awal_tahun) {

        var vlink_urls  = '<?php echo base_url() ?>dashboard/penyerapan_bbm/get_penerimaan';
        $.ajax({
            data : {
                tglawal  : tglAwal,
                tglakhir : tglAkhir,
                vlevel   : lvl0,
                vlevelid : vlevelid
            },
            url: vlink_urls,
            type: "POST",
            success:function(data) {
                setGrafik(res,data,awal_tahun);
                $('#btn_label').show();
            }

        });
    }

    function getDataTabelPenerimaan(tglAwal,tglAkhir,lvl0,vlevelid) {

        var vlink_urlss = '<?php echo base_url() ?>dashboard/penyerapan_bbm/get_tabel_penerimaan';
        $.ajax({
            data: {                       
               "TGLAWAL": tglAwal,
               "TGLAKHIR": tglAkhir,
               "LEVEL": lvl0,
               "LEVEL_ID":vlevelid,
               "JNS_BBM": ''
           },
            url: vlink_urlss,
            type: "POST",
            success:function(data) {
                $("#t_penerimaan tbody").html(data);
            }
        });
    }

    function getPenerimaanTotal(tglAwal, tglAkhir, lvl0, vlevelid, jns_bbm) {
      var nama_regional = $('#lvl0 option:selected').html()

      if(nama_regional == '--Pilih Regional--') {
        var reg = 'Pusat'
      } else {
        var reg = nama_regional;
      }
       $.ajax({
          type: "POST",
          url: "<?php echo base_url('dashboard/penyerapan_bbm/get_tabel_penerimaan_total'); ?>",
          data: {
             "TGLAWAL": tglAwal,
             "TGLAKHIR": tglAkhir,
             "LEVEL": lvl0,
             "LEVEL_ID": vlevelid,
             "JNS_BBM": jns_bbm,
             "NAMA_REGIONAL" : reg
          },
          beforeSend: function() {
             bootbox.hideAll();
             bootbox.dialog('<div class="loading-progress"></div>');
          },
          error: function(data) {
             bootbox.hideAll();
             msgGagal(data.statusText);
          },
          success: function(data) {
            $("#t_penerimaan_total tbody").html(data);
          }
       });
    }

    function getAllPemakaian() {

        $('#divTable').hide();
        $('#TIPE').val(2);
        var lvl0        = $('#lvl0').val();
        var lvl1        = $('#lvl1').val();
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

        getDataTargetPemakaian(lvl0,vlevelid,tglAwal,tglAkhir);
        getDataTabelPemakaian(tglAwal,tglAkhir,lvl0,vlevelid);
        getPemakaianTotal(tglAwal, tglAkhir, lvl0, vlevelid);    
    }

    function getDataTargetPemakaian(lvl0,vlevelid,tglAwal,tglAkhir) {
        var vlink_url   = '<?php echo base_url() ?>dashboard/penyerapan_bbm/get_target_pemakaian';
        $.ajax({
            data : {
                "tglawal"  : tglAwal,
                "tglakhir" : tglAkhir,
                "vlevel"   : lvl0,
                "vlevelid" : vlevelid
            },
            url: vlink_url,
            type: "POST",
            beforeSend:function(res){
                bootbox.modal('<div class="loading-progress"></div>');
            },
            success:function(res) {
                getDataPemakaian(tglAwal,tglAkhir,lvl0,vlevelid,res);
            }
        });
    }

    function getDataPemakaian(tglAwal,tglAkhir,lvl0,vlevelid,res) {

        var vlink_urls  = '<?php echo base_url() ?>dashboard/penyerapan_bbm/get_pemakaian';
        $.ajax({
            data : {
                tglawal  : tglAwal,
                tglakhir : tglAkhir,
                vlevel   : lvl0,
                vlevelid : vlevelid
            },
            url: vlink_urls,
            type: "POST",
            success:function(data) {
                setGrafikPemakaian(res,data);
                $('#btn_label').show();

            }
        });
    }

    function getDataTabelPemakaian(tglAwal,tglAkhir,lvl0,vlevelid) {

        var vlink_urlss = '<?php echo base_url() ?>dashboard/penyerapan_bbm/get_tabel_pemakaian';
        $.ajax({
            data: {                       
               "TGLAWAL": tglAwal,
               "TGLAKHIR": tglAkhir,
               "LEVEL": lvl0,
               "LEVEL_ID":vlevelid,
               "JNS_BBM": ''
           },
            url: vlink_urlss,
            type: "POST",
            success:function(data) {
                $("#t_pemakaian tbody").html(data);
            }
        });
    }

    function getPemakaianTotal(tglAwal, tglAkhir, lvl0, vlevelid, jns_bbm) {
      var nama_regional = $('#select_2 option:selected').html()

      if(nama_regional == '--Pilih Regional--') {
        var reg = 'Pusat'
      } else {
        var reg = nama_regional;
      }
      $.ajax({
        type: "POST",
        url: "<?php echo base_url('dashboard/penyerapan_bbm/get_tabel_pemakaian_total'); ?>",
        data: {
           "TGLAWAL": tglAwal,
           "TGLAKHIR": tglAkhir,
           "LEVEL": lvl0,
           "LEVEL_ID": vlevelid,
           "JNS_BBM": jns_bbm,
           "NAMA_REGIONAL" : nama_regional
        },
        success: function(data) {
          $("#t_pemakaian_total tbody").html(data);
        }
       });
    }

    function setGrafik(res,data,tahun) {
        var tglawal  = $('#tglawal').val();
        var tglakhir  = $('#tglakhir').val();
        var awal = dateFormat(tglawal);
        var akhir = dateFormat(tglakhir);
        var obj = JSON.parse(res);var objs = JSON.parse(data);
        var VOLUMEMFO = [];var VOLUMEIDO = [];var VOLUMEHSD = [];
        var VOLUMEBIO = [];var result = [];
        var PENYERAPANHSD = PENYERAPANBIO = PENYERAPANMFO = PENYERAPANIDO = [];
        var MFO = [];var IDO = [];var HSD = [];
        var BIO = [];
        $.each(obj, function(index, value) {
            var GROUP_NAMA_BBM = value.GROUP_NAMA_BBM == null ? "-" : value.GROUP_NAMA_BBM;
            var TARGET = value.TARGET == null ? "0.00" : value.TARGET;
            var NAMA = GROUP_NAMA_BBM.substr(0,3);
            if(NAMA == 'HSD') {
              if(TARGET == null) {
                VOLUMEHSD.push(0);
              } else {
                VOLUMEHSD.push(parseFloat(TARGET));
              }
            } else if(NAMA == 'BIO') {
              if(TARGET == null) {
                VOLUMEBIO.push(0);
              } else {
                VOLUMEBIO.push(parseFloat(TARGET));
              }
                
            } else if(NAMA == 'MFO') {
              if(TARGET == null) {
                VOLUMEMFO.push(0);
              } else {
                VOLUMEMFO.push(parseFloat(TARGET));
              }
            } else if(NAMA == 'IDO') {
              if(TARGET == null) {
                VOLUMEIDO.push(0);
              } else {
                VOLUMEIDO.push(parseFloat(TARGET));
              }
            }
        });

        if(VOLUMEHSD == "") {
          VOLUMEHSD = [0];
        }
        if(VOLUMEBIO == "") {
          VOLUMEBIO = [0];
        }
        if(VOLUMEMFO == "") {
          VOLUMEMFO = [0];
        }
        if(VOLUMEIDO == "") {
          VOLUMEIDO = [0];
        } 

        $.each(objs, function(i, v) {

            var NAMA_SPLIT = v.NAMA_SPLIT == null ? "-" : v.NAMA_SPLIT;
            var GROUP_NAMA_BBM = v.GROUP_NAMA_BBM == null ? "-" : v.GROUP_NAMA_BBM;
            var REALISASI_PENERIMAAN_SPLIT = v.REALISASI_PENERIMAAN_SPLIT == null ? "0.00" : v.REALISASI_PENERIMAAN_SPLIT;
            var NAMA = NAMA_SPLIT.substr(0,3);
            if(NAMA == 'HSD') {
                HSD.push(parseFloat(REALISASI_PENERIMAAN_SPLIT));
            } else if(NAMA == 'BIO') {
                BIO.push(parseFloat(REALISASI_PENERIMAAN_SPLIT));
            } else if(NAMA == 'MFO') {
                MFO.push(parseFloat(REALISASI_PENERIMAAN_SPLIT));
            } else if(NAMA == 'IDO'){
                IDO.push(parseFloat(REALISASI_PENERIMAAN_SPLIT));
            }
        }); 
        if(HSD == "") {
          HSD = [0];
        }
        if(BIO == "") {
          BIO = [0];
        }
        if(MFO == "") {
          MFO = [0];
        }
        if(IDO == "") {
          IDO = [0];
        }
        var TOTAL_MFO = MFO.reduce(getSum);
        var TOTAL_IDO = IDO.reduce(getSum);
        var TOTAL_HSD = HSD.reduce(getSum);
        var TOTAL_BIO = BIO.reduce(getSum);
        var target = VOLUMEHSD.concat(VOLUMEBIO,VOLUMEIDO,VOLUMEMFO);
        var realisasi = [parseFloat(TOTAL_HSD.toFixed(2)),parseFloat(TOTAL_BIO.toFixed(2)),parseFloat(TOTAL_IDO.toFixed(2)),parseFloat(TOTAL_MFO.toFixed(2))];
        for(i = 0; i < target.length; i++) {
            var divide = parseFloat(realisasi[i] / target[i]) * 100;
            if(isNaN(divide) || divide == Number.POSITIVE_INFINITY || divide == Number.NEGATIVE_INFINITY) {
              result.push(0)
            } else {
              result.push(divide);
            }   
        }

        if(getNamaUnit() == '') {
            var unit = 'PUSAT';
        } else {
            var unit = getNamaUnit();
        }

        $('#btn_label').text('Hide Labels');
        
        $(function () {
            
          $('#container_grafik').highcharts({
            chart: {
                type: 'column',
                events: {
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
                      x = xAxis.toPixels(point.x) - 20;
                      y = yAxis.toPixels(point.y) - 15;
                      series_s_y.push(y);
                      series_x.push(x);
                    });
                  }

                  if (chart.series[1].visible) {
                    chart.series[1].points.forEach((point, i) => {
                      x = xAxis.toPixels(point.x) - 20;
                      y = yAxis.toPixels(point.y) - 15;
                      series_d_y.push(y);
                      series_x.push(x);
                    });
                  }  

                  for (i = 0; i < chart.series[0].points.length; i++) {
                    if (series_s_y.length && series_d_y.length) {
                      if (series_s_y[i] > series_d_y[i]) {
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
                      `${result[i].toFixed(2)} %`, 
                      series_x[i], 
                      p[i]
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
                text: 'Penyerapan BBM Per Jenis BBM<br>(Penerimaan)'
            },
            subtitle: {
                text:  unit +'<br>'+'Periode ' + awal + ' s/d '+ akhir
            },
            xAxis: {
                categories: ['HSD','BIO','IDO','MFO'],
                crosshair: true
            },
            yAxis: {
                min: 0,
                labels: {
                    formatter: function () {
                    return toRp(this.value / 1000);
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
                    '<td style="border-style:none">:</td>'+
                    '<td style="padding:0;font-weight:bold;border-style:none">'+ toRp(num) +'</td>'+
                    '</tr>';
                }); 
                s +=  '</table>';        
                return s;
              },
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
                animation: {
                  complete: function(){
                      bootbox.hideAll()
                  }
                },
                events : {
                  legendItemClick: function () {
                    $('#btn_label').text('Hide Labels');
                  }
                },
              }
            },
            exporting: {
              buttons: {
                  contextButton: {
                      menuItems: btnGetDataTable
                  }
              }
            },
            series: [{
                name: 'Target Penyerapan (L)',
                color :' #009933',
                data: target,
                dataLabels: {
                    enabled: false
                  }
                },
                {
                  name: 'Realisasi Penyerapan (L)',
                  color : '#00ff00',
                  data: realisasi,
                  dataLabels: {
                    enabled: false
                  }
                }]
          })
                
        });
    }

    function setGrafikPemakaian(res,data,tahun) {
        var obj = JSON.parse(res);var objs = JSON.parse(data);
        var tglawal  = $('#tglawal').val();
        var tglakhir  = $('#tglakhir').val();
        var awal = dateFormat(tglawal);
        var akhir = dateFormat(tglakhir);

        var VOLUMEMFO = [];var VOLUMEIDO = [];var VOLUMEHSD = [];
        var VOLUMEBIO = [];var result = [];
        var PENYERAPANHSD = []; var PENYERAPANBIO = []; var PENYERAPANMFO = []; var PENYERAPANIDO = [];
        var MFO = [];var IDO = [];var HSD = []; var BIO = [];


        $.each(objs, function(index, value) {
            var GROUP_BBM_REAL = value.GROUP_BBM_REAL == null ? "-" : value.GROUP_BBM_REAL;
            var TARGET_REAL = value.TARGET_REAL == null ? "0.00" : value.TARGET_REAL;
            var NAMA = GROUP_BBM_REAL.substr(0,3);
            if(NAMA == 'HSD') {
                VOLUMEHSD.push(parseFloat(TARGET_REAL));
            } else if(NAMA == 'BIO') {
                VOLUMEBIO.push(parseFloat(TARGET_REAL));
            } else if(NAMA == 'MFO') {
                VOLUMEMFO.push(parseFloat(TARGET_REAL));
            } else if(NAMA == 'IDO') {
                VOLUMEIDO.push(parseFloat(TARGET_REAL));
            }
        });

        $.each(obj, function(index, value) {
          var GROUP_BBM = value.GROUP_BBM == null ? "-" : value.GROUP_BBM;
          var TARGET = value.TARGET == null ? "0.00" : value.TARGET;
          var PENYERAPAN = value.PERSEN_PAKAI == null ? "0.00" : value.PERSEN_PAKAI;
          var NAMA = GROUP_BBM.substr(0,3);
          console.log(PENYERAPAN);
          if(NAMA == 'HSD') {
              PENYERAPANHSD.push(parseFloat(PENYERAPAN));
          } else if(NAMA == 'BIO') {
              PENYERAPANBIO.push(parseFloat(PENYERAPAN));
          } else if(NAMA == 'MFO') {
              PENYERAPANMFO.push(parseFloat(PENYERAPAN));
          } else if(NAMA == 'IDO') {
              PENYERAPANIDO.push(parseFloat(PENYERAPAN));
          }
        });

        if(VOLUMEHSD == "") {
          VOLUMEHSD = [0];
        }
        if(VOLUMEBIO == "") {
          VOLUMEBIO = [0];
        }
        if(VOLUMEMFO == "") {
          VOLUMEMFO = [0];
        }
        if(VOLUMEIDO == "") {
          VOLUMEIDO = [0];
        }
        if(PENYERAPANHSD == "") {
          PENYERAPANHSD = [0];
        }
        if(PENYERAPANBIO == "") {
          PENYERAPANBIO = [0];
        }
        if(PENYERAPANMFO == "") {
          PENYERAPANMFO = [0];
        }
        if(PENYERAPANIDO == "") {
          PENYERAPANIDO = [0];
        }

        $.each(objs, function(i, v) {

            var GROUP_BBM = v.GROUP_BBM == null ? "-" : v.GROUP_BBM;
            var REALISASI_PEMAKAIAN = v.REALISASI_PEMAKAIAN == null ? "0.00" : v.REALISASI_PEMAKAIAN;
            var NAMA = GROUP_BBM.substr(0,3);
            if(NAMA == 'HSD') {
                HSD.push(parseFloat(REALISASI_PEMAKAIAN));
            } else if(NAMA == 'BIO') {
                BIO.push(parseFloat(REALISASI_PEMAKAIAN));
            } else if(NAMA == 'MFO') {
                MFO.push(parseFloat(REALISASI_PEMAKAIAN));
            } else if(NAMA == 'IDO') {
                IDO.push(parseFloat(REALISASI_PEMAKAIAN));
            }
        }); 

        if(HSD == "") {
          HSD = [0];
        }
        if(BIO == "") {
          BIO = [0];
        }
        if(MFO == "") {
          MFO = [0];
        }
        if(IDO == "") {
          IDO = [0];
        }

        var target = VOLUMEHSD.concat(VOLUMEBIO,VOLUMEIDO,VOLUMEMFO);
        var realisasi = HSD.concat(BIO,IDO,MFO);
        var result = PENYERAPANHSD.concat(PENYERAPANBIO,PENYERAPANIDO,PENYERAPANMFO);

        if(getNamaUnit() == '') {
            var unit = 'PUSAT';
        } else {
            var unit = getNamaUnit();
        }

        $('#btn_label').text('Hide Labels');
        
        $(function () {
            
          $('#container_grafik').highcharts({
            chart: {
                type: 'column',
                events: {
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
                      x = xAxis.toPixels(point.x) - 20;
                      y = yAxis.toPixels(point.y) - 15;
                      series_s_y.push(y);
                      series_x.push(x);
                    });
                  }

                  if (chart.series[1].visible) {
                    chart.series[1].points.forEach((point, i) => {
                      x = xAxis.toPixels(point.x) - 20;
                      y = yAxis.toPixels(point.y) - 15;
                      series_d_y.push(y);
                      series_x.push(x);
                    });
                  }  

                  for (i = 0; i < chart.series[0].points.length; i++) {
                    if (series_s_y.length && series_d_y.length) {
                      if (series_s_y[i] > series_d_y[i]) {
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
                      `${result[i].toFixed(2)} %`, 
                      series_x[i], 
                      p[i]
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
                text: 'Penyerapan BBM Per Jenis BBM<br>(Pemakaian)'
            },
            subtitle: {
                text:  unit +'<br>'+'Periode ' + awal + ' s/d '+ akhir
            },
            xAxis: {
                categories: ['HSD','BIO','IDO','MFO'],
                crosshair: true
            },
            yAxis: {
                min: 0,
                labels: {
                    formatter: function () {
                    return toRp(this.value / 1000);
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
                    '<td style="border-style:none">:</td>'+
                    '<td style="padding:0;font-weight:bold;border-style:none">'+ toRp(num) +'</td>'+
                    '</tr>';
                }); 
                s +=  '</table>';        
                return s;
              },
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
                animation: {
                  complete: function(){
                      bootbox.hideAll()
                  }
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
            series: [{
                name: 'Target Penyerapan (L)',
                color :' #009933',
                data: target,
                dataLabels: {
                    enabled: false
                  }
                },
                {
                  name: 'Realisasi Penyerapan (L)',
                  color : '#00ff00',
                  data: realisasi,
                  dataLabels: {
                    enabled: false
                  }
                },
                {
                  name: 'Penyerapan',
                  data: result,
                  showInLegend: false,
                  visible :false
            }]
          })
                
        });
    }

    function toRp(angka){
        var _angka = angka.toString();
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

    function formatDate(date) {
        var d = new Date(date),
        month = '' + (12),
        day = '' + 31,
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [year, month, day].join('-');
    }

    function dateFormat(date) {
        var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        return [day, month , year].join('-');
    }

    function getYear(date) {
        var d = new Date(date),
        year = d.getFullYear();

        return year;
    }

    function getToday() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        return yyyy + '-' + '01' + '-' + '01';
    }

    function getLastYear() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        return yyyy + '-' + '12' + '-' + '31';
    }

    function kFormatter(num) {

        return (num/1000).toFixed(2);
    }

    function getSum(total, num) {

        return total + num;
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
    
    function setDefaultLv1(){
        $('select[name="COCODE"]').empty();
        $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
    }

    function numberWithCommas(x) {

        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    } 

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

</script>