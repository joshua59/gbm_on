<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

<style>
    tr {background-color: #CED8F6;}
    table {
        border-collapse: collapse;
        width:100%;
    }
    td.tengah {text-align: center;}
    td.kanan {text-align: right;}

    .label_ket {
    font-size: 10px;
    }

    .cls_modal{
      width: 90%;
      height: 700px;
      left: 5%;
      margin: auto;
      /*left: 0%;
      margin: 0 auto;*/
    }

 /*   .dataTables_scrollHeadInner {
      width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
      width: 100% !important;    
    }     */

</style>

<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Laporan'; ?></span>
        </div>
    </div>
    <div id="div_load" hidden>               
        <div id="div_progress">
            <div id="div_bar">0%</div>
        </div>
    </div>
    <div class="widgets_area">
        <div class="well-content no-search">
            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                        <input type="hidden" name="di_cari" id="di_cari">
                        <input type="hidden" name="kd_kontrak" id="kd_kontrak">
                        <input type="hidden" name="adendum" id="adendum">
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 1 : </label>
                    <div class="controls">
                        <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 2 : </label>
                    <div class="controls">
                        <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Level 3 : </label>
                    <div class="controls">
                        <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Pembangkit : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Transportir :</label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_TRANSPORTIR', $options_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'id="ID_TRANSPORTIR"'); ?>
                    </div>
                </div>
            </div><br/>
            <div class="form_row">
                <div class="pull-left span3">
                    <label for="password" class="control-label">Periode <span class="required">*</span> : </label>
                    <label for="password" class="control-label" style="margin-left:38px"></label>
                    <div class="controls">
                        <?php echo form_input('TGL_DARI', !empty($TGL_DARI) ? $TGL_DARI : '', 'class="form_datetime" style="width: 99px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                        <label for="">s/d</label>
                        <?php echo form_input('TGL_SAMPAI', !empty($TGL_SAMPAI) ? $TGL_SAMPAI : '', 'class="form_datetime" style="width: 99px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
                    </div>
                </div>
                <div class="pull-left span3">
                    <label for="password" class="control-label">Cari: </label>
                    <div class="controls">
                        <input type="text" id="CARI" name="CARI" value="" placeholder="Cari Unit, No Kontrak">
                        <?php echo anchor(null, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?>
                    </div>
                </div>
                
                <div class="pull-left span3">
                    <label></label>
                    <div class="controls">
                        <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                        <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>  
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
            <?php echo form_close(); ?>
        </div>
        <br>
        <div class="well-content no-search"d id="divTable" hidden>
            <table id="dataTable" class="display" style="width: 100%" cellspacing="0">
                <thead>
                <tr>
                    <th rowspan="2" style="text-align: center">NO</th>
                    <th colspan="4" style="text-align: center">LEVEL</th>
                    <th rowspan="2" style="text-align: center">PEMBANGKIT</th>
                    <th rowspan="2" style="text-align: center">TRANSPORTIR</th>
                    <th rowspan="2" style="text-align: center">NO KONTRAK</th>
                    <th rowspan="2" style="text-align: center">NO ADENDUM</th>
                    <th rowspan="2" style="text-align: center">TGL AWAL KONTRAK</th>
                    <th rowspan="2" style="text-align: center">TGL AKHIR KONTRAK</th>
                    <th rowspan="2" style="text-align: center">MEKANISME DENDA</th>
                    <th rowspan="2" style="text-align: center">TOLERANSI LOSSES<br>(%)</th>
                    <th rowspan="2" style="text-align: center">NILAI</th>
                    <th rowspan="2" style="text-align: center">AKSI</th>
                </tr>
                <tr>
                    <th>0</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                </tr>
            </thead>
                <tbody></tbody>
            </table>                        
        </div>

        <div id="form-content" class="modal fade modal-xlarge"></div>
    </div>
</div>
<br>


<form id="export_excel" action="<?php echo base_url('laporan/kontrak_trans/export_excel'); ?>" method="post">
    <input type="hidden" name="xlvl0">
    <input type="hidden" name="xlvl1">
    <input type="hidden" name="xlvl2">
    <input type="hidden" name="xlvl3">
    <input type="hidden" name="xlvl0_nama">
    <input type="hidden" name="xlvl1_nama">
    <input type="hidden" name="xlvl2_nama">
    <input type="hidden" name="xlvl3_nama">
    <input type="hidden" name="xlvl4">
    <input type="hidden" name="xtrans">
    <input type="hidden" name="xtrans_nama">
    <input type="hidden" name="xtglawal">
    <input type="hidden" name="xtglakhir">
    <input type="hidden" name="xkata_kunci">
    <input type="hidden" name="xstatus_kontrak">
</form>

<form id="export_excel_adendum" action="<?php echo base_url('laporan/kontrak_trans/export_excel_adendum'); ?>" method="post">
    <input type="hidden" name="xID" id="xID">
    <input type="hidden" name="xNO_KONTRAK" id="xNO_KONTRAK">
    <input type="hidden" name="xTIPE">   
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/kontrak_trans/export_pdf'); ?>" method="post" target="_blank">
    <input type="hidden" name="plvl0">
    <input type="hidden" name="plvl1">
    <input type="hidden" name="plvl2">
    <input type="hidden" name="plvl3">
    <input type="hidden" name="plvl0_nama">
    <input type="hidden" name="plvl1_nama">
    <input type="hidden" name="plvl2_nama">
    <input type="hidden" name="plvl3_nama">
    <input type="hidden" name="plvl4">
    <input type="hidden" name="ptrans">
    <input type="hidden" name="ptrans_nama">
    <input type="hidden" name="ptglawal">
    <input type="hidden" name="ptglakhir">
    <input type="hidden" name="pkata_kunci">
    <input type="hidden" name="pstatus_kontrak">    
</form>

<form id="export_pdf_adendum" action="<?php echo base_url('laporan/kontrak_trans/export_pdf_adendum'); ?>" method="post" target="_blank">
    <input type="hidden" name="pID">
    <input type="hidden" name="pNO_KONTRAK">
    <input type="hidden" name="pTIPE">   
</form>
<div class="modal fade modal-lg cls_modal" id="modal_adendum" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Adendum</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="pull-left">
               <label for="judul">NO KONTRAK :</label>
               <b id="no_kontrak"></b>
                
            </div>
            <div class="pull-right">
             <!--  <input type="text" id="cari_adendum" name="cari_adendum" value="" placeholder="Cari Unit, No Adendum " class="input-large">
              <button type="button" class="btn" name="button" id="btnCariAdendum">Cari</button> -->
              <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                  'class' => 'btn',
                  'id'    => 'button-excel-adendum'
              )); ?>
              <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                  'class' => 'btn',
                  'id'    => 'button-pdf-adendum'
              )); ?>
              </div>
                <table id="data_table_adendum" class="table-striped" width="100%">
                    <thead>
                        <tr>
                            <th style="text-align: center">NO</th>
                            <th style="text-align: center">PEMASOK</th>
                            <th style="text-align: center">DEPO TRANSIT</th>
                            <th style="text-align: center">PEMBANGKIT<br>PENERIMA</th>
                            <th style="text-align: center">JALUR</th>
                            <th style="text-align: center">JARAK (KM/ML)</th>
                            <th style="text-align: center">HARGA (RP/L)</th>       
                        </tr>
                    </thead>
                  <tbody id="body_adendum">
                      
                  </tbody>
                </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
    var today = new Date();
    var year = today.getFullYear();
    var table, table_adendum;

    var t = $('#dataTable').DataTable({
        "order": [],
        "scrollY": "450px",
        "scrollX": true,
        "scrollCollapse": false,
        "bPaginate": true,
        "searching":false,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "fixedColumns": {"leftColumns": 6},
        "bAutoWidth": true,
        "ordering": false,
        "language": {
            "decimal": ",",
            "thousands": ".",
            "emptyTable": "Tidak ada data untuk ditampilkan",
            "lengthMenu": "Jumlah Data _MENU_",
            "processing": "<div class='loading-progress' style='color:#ac193d;'></div>"
        },
        "columnDefs": [
            {
               "className": "dt-left",
               "targets": [1,2,3,4,5,6,11]
            },
            {
               "className": "dt-center",
               "targets": [7,8,9,10]
            },
            {
               "className": "dt-right",
               "targets": [12,13]
            },
        ]
    });

    t_adendum = $('#data_table_adendum').DataTable({
            "order": [],
            "scrollY": "350px",
            "scrollX": false,
            "scrollCollapse": false,
            "bPaginate": true,
            "searching":false,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": true,
            "bAutoWidth": true,
            "ordering": false,
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "Tidak ada data untuk ditampilkan",
                "lengthMenu": "Jumlah Data _MENU_",
                "processing": "<div class='loading-progress' style='color:#ac193d;'></div>"
            },

            "columnDefs": [
                {
                   "className": "dt-left",
                   "targets": [1,2,3,4]
                },
                {
                   "className": "dt-center",
                   "targets": [0]
                },
                {
                   "className": "dt-right",
                   "targets": [5,6]
                },
            ],
        });

    $(document).ready(function(){

        $('#modal_adendum').hide();
        $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);
        $('select[name="TAHUN"]').val(year);
        $(".form_datetime").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left"
        });
    })

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

    function get_data(){
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();

        if(lvl0 == '') {
            var p_unit = '';
        } else if(lvl1 == '') {
            if(lvl0 == '00') {
                var p_unit = '';
            } else {
                var p_unit = lvl0;    
            } 
        } else if(lvl2 == '') {
            var p_unit = lvl1;
        } else if(lvl3 == '') {
            var p_unit = lvl2;
        } else if(lvl4 == '') {
            var p_unit = lvl3;  
        } else {
            var p_unit = lvl4;
        }

        var p_transportir = $('#ID_TRANSPORTIR').val();
        var p_tglawal = $('#tglawal').val().replace(/-/g, '');//02-11-2018
        var p_tglakhir = $('#tglakhir').val().replace(/-/g, '');
        var p_cari = $('#CARI').val();

        if (tglawal == '' && tglakhir != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
        }else if(tglakhir == '' && tglawal != ''){
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
        }  else {

            $.ajax({
                url: "<?php echo site_url('laporan/kontrak_trans/ajax_list')?>",
                type: "POST",
                data: {
                     "p_unit": p_unit,
                     "p_transportir":p_transportir,
                     "p_tglawal":p_tglawal,
                     "p_tglakhir":p_tglakhir,
                     "p_cari":p_cari
                },
                beforeSend:function(data) {
                    bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
                },
                error:function(data) {
                    bootbox.hideAll();
                },
                success:function(data) {
                    var obj = JSON.parse(data);
                    if(obj == "") {
                        bootbox.hideAll();
                        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {
                            $('#dataTable tbody').html("");
                            $('#dataTable tbody').append('<tr><td colspan="13" style="text-align:center">Tidak ada data untuk ditampilkan</td></tr>');
                        });
                    } else {
                        setTable(data);
                    }
                }
            });  
        }
    };

    function setTable(data) {
        var t = $('#dataTable').DataTable();
        var nomer = 1;
        var data_detail = JSON.parse(data);
        var total = data_detail.length;
        var progres = 0;            
        var elem = document.getElementById("div_bar");

        t.clear().draw();
        
        $.each(data_detail, function(key, value) {
            setTimeout( function(){
                var NAMA_REGIONAL = value.NAMA_REGIONAL == null ? "" : value.NAMA_REGIONAL;
                var LEVEL1 = value.LEVEL1 == null ? "" : value.LEVEL1;
                var LEVEL2 = value.LEVEL2 == null ? "" : value.LEVEL2;
                var LEVEL3 = value.LEVEL3 == null ? "" : value.LEVEL3;
                var LEVEL4 = value.LEVEL4 == null ? "" : value.LEVEL4;
                var NAMA_TRANSPORTIR = value.NAMA_TRANSPORTIR == null ? "" : value.NAMA_TRANSPORTIR;
                var KD_KONTRAK_AWAL = value.KD_KONTRAK_AWAL == null ? "" : value.KD_KONTRAK_AWAL;
                var KD_ADENDUM = value.KD_ADENDUM == null ? "" : value.KD_ADENDUM;
                var TGL_KONTRAK_TRANS = value.TGL_KONTRAK_TRANS == null ? "" : value.TGL_KONTRAK_TRANS;
                var TGL_KONTRAK_TRANS_AKHIR = value.TGL_KONTRAK_TRANS_AKHIR == null ? "" : value.TGL_KONTRAK_TRANS_AKHIR;
                var NAMA_DENDA = value.NAMA_DENDA == null ? "" : value.NAMA_DENDA;
                var LOSSES = value.LOSSES == null ? "" : value.LOSSES;
                var NILAI_KONTRAK_TRANS = value.NILAI_KONTRAK_TRANS == null ? "" : value.NILAI_KONTRAK_TRANS;
                var ID_KONTRAK_TRANS = value.ID_KONTRAK_TRANS == null ? "" : value.ID_KONTRAK_TRANS;
                var KODE,ADENDUM;
                if(KD_ADENDUM == '') {
                    KODE = KD_KONTRAK_AWAL;
                    ADENDUM = '';
                } else {
                    KODE = KD_ADENDUM;
                    ADENDUM = 'ADENDUM';
                }
                t.row.add([
                    nomer,NAMA_REGIONAL,LEVEL1,LEVEL2,LEVEL3,LEVEL4,
                    NAMA_TRANSPORTIR,KD_KONTRAK_AWAL,KD_ADENDUM,TGL_KONTRAK_TRANS,TGL_KONTRAK_TRANS_AKHIR,NAMA_DENDA,convertToRupiah(LOSSES),convertToRupiah(NILAI_KONTRAK_TRANS),
                    "<button type='button' class='btn' onclick='lihat_adendum(\""+ ID_KONTRAK_TRANS + "\",\""+ KODE + "\",\""+ ADENDUM + "\")'>Detail</button>"
                ]).draw(false);

                if (nomer==1){
                      bootbox.hideAll();
                      $('#div_load').show();
                      bootbox.dialog('<div class="loading-progress"></div>');                    
                }

                progres = Math.ceil((nomer/total)*100);
                elem.style.width = progres + '%';
                elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';

                if (nomer>=total){
                    bootbox.hideAll();
                    $('#div_load').hide('slow');                                       
                }
                  nomer++;
                  
            }, 0 );
        });

        $('#divTable').show();
        $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
    }

    function get_data_adendum(id,kode,adendum) {
        $('#xTIPE').val(adendum);
        $('#pTIPE').val(adendum);    
        var cari_adendum = $('#cari_adendum').val();

        $.ajax({
            url: "<?php echo site_url('laporan/kontrak_trans/ajax_list_adendum/')?>",
            type: "POST",
            data: {"p_kode" : kode,"p_adendum" : adendum},
            beforeSend:function(data) {
                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(data) {
                bootbox.hideAll();
            },
            success:function(data) {
                var obj = JSON.parse(data);
                if(obj == "") {
                    bootbox.hideAll();
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {
                        $('#dataTable tbody').html("");
                        $('#dataTable tbody').append('<tr><td colspan="13" style="text-align:center">Tidak ada data untuk ditampilkan</td></tr>');
                    });
                } else {
                    setTableAdendum(data);
                }
            }
        });  

    };    

     function setTableAdendum(data) {
        var t_adendum = $('#data_table_adendum').DataTable();
        var nomer = 1;
        var data_detail = JSON.parse(data);
        var total = data_detail.length;
        var progres = 0;            
        var elem = document.getElementById("div_bar");

        t_adendum.clear().draw();
        
        $.each(data_detail, function(key, value) {
            setTimeout( function(){
                var PEMASOK = value.PEMASOK == null ? "" : value.PEMASOK;
                var DEPO_TRANSIT = value.DEPO_TRANSIT == null ? "" : value.DEPO_TRANSIT;
                var PEMBANGKIT_PENERIMA = value.PEMBANGKIT_PENERIMA == null ? "" : value.PEMBANGKIT_PENERIMA;
                var JALUR = value.JALUR == null ? "" : value.JALUR;
                var JARAK = value.JARAK == null ? "" : value.JARAK;
                var HARGA = value.HARGA == null ? "" : convertToRupiah(value.HARGA);
                
                t_adendum.row.add([
                    nomer,PEMASOK,DEPO_TRANSIT,PEMBANGKIT_PENERIMA,JALUR,JARAK,HARGA,
                ]).draw(false);

                if (nomer==1){
                      bootbox.hideAll();
                      $('#div_load').show();
                      bootbox.dialog('<div class="loading-progress"></div>');                    
                }

                progres = Math.ceil((nomer/total)*100);
                elem.style.width = progres + '%';
                elem.innerHTML = progres * 1  + '%   ('+nomer+' dari '+total+')';

                if (nomer>=total){
                    bootbox.hideAll();
                    $('#div_load').hide('slow');                                       
                }
                  nomer++;
                  
            }, 0 );
        });

    }

    
    $('#modal_adendum').on('shown', function(){
        get_data_adendum($('#di_cari').val(),$('#kd_kontrak').val(),$('#adendum').val());   
    });    

    $('#button-load').click(function(e) {
        get_data();
    });

    $('#button-excel').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();
        if (tglawal == '' && tglakhir != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
        }else if(tglakhir == '' && tglawal != ''){
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
        } else {
            $('input[name="xlvl0"]').val($('#lvl0').val());
            $('input[name="xlvl1"]').val($('#lvl1').val());
            $('input[name="xlvl2"]').val($('#lvl2').val());
            $('input[name="xlvl3"]').val($('#lvl3').val());

            $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

            $('input[name="xlvl4"]').val($('#lvl4').val());
            $('input[name="xbbm"]').val($('#bbm').val());
            $('input[name="xbln"]').val($('#bln').val());
            $('input[name="xthn"]').val($('#thn').val());
            $('input[name="xtglawal"]').val($('#tglawal').val());
            $('input[name="xtglakhir"]').val($('#tglakhir').val());
            $('input[name="xkata_kunci"]').val($('#CARI').val());
            $('input[name="xstatus_kontrak"]').val($('#STATUS_KONTRAK').val());            

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_excel').submit();
                }
            });
        }
    });

    $('#button-excel-adendum').click(function(e) {
        
        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#export_excel_adendum').submit();
            }
        });
    });    

    $('#button-pdf').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();

        if (tglawal == '' && tglakhir != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
        }else if(tglakhir == '' && tglawal != ''){
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
        } else {

            $('input[name="plvl0"]').val($('#lvl0').val());
            $('input[name="plvl1"]').val($('#lvl1').val());
            $('input[name="plvl2"]').val($('#lvl2').val());
            $('input[name="plvl3"]').val($('#lvl3').val());

            $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());

            $('input[name="plvl4"]').val($('#lvl4').val());
            $('input[name="pbbm"]').val($('#bbm').val());
            $('input[name="pbln"]').val($('#bln').val());
            $('input[name="pthn"]').val($('#thn').val());
            $('input[name="ptglawal"]').val($('#tglawal').val());
            $('input[name="ptglakhir"]').val($('#tglakhir').val());
            $('input[name="pkata_kunci"]').val($('#CARI').val());
            bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_pdf').submit();
                }
            });
        }
    });

    $('#button-pdf-adendum').click(function(e) {  
        bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#export_pdf_adendum').submit();
            }
        });        
    });    

    $('#btnCariAdendum').click(function(e) {
        get_data_adendum($('#di_cari').val(),$('#kd_kontrak').val(),$('#adendum').val());
    });
    
    function lihat_adendum(id,kdkontrak,adendum){

        $('#cari_adendum').val('');
        $('#no_kontrak').val(id)
        $('#di_cari').val(id);
        $('#kd_kontrak').val(kdkontrak);
        $('#adendum').val(adendum);
        $('#no_kontrak').text(kdkontrak)
        $('#modal_adendum').modal('show');
        $('input[name="xID"]').val(adendum);
        $('input[name="xNO_KONTRAK"]').val(kdkontrak); 
        $('input[name="pID"]').val(adendum);
        $('input[name="pNO_KONTRAK"]').val(kdkontrak);  

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

        $('select[name="ID_REGIONAL"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>laporan/persediaan_bbm/get_options_lv1/'+stateID;
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
    });
</script>