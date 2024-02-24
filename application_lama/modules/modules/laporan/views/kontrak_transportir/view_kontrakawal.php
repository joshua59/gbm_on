<div id="div_load" hidden>               
    <div id="div_progress">
        <div id="div_bar">0%</div>
    </div>
</div>
<div class="well-content no-search">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Laporan'; ?></span>
        </div>
    </div>
    <br>
    <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
    <div class="form_row">
        <div class="pull-left span3">
            <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                <input type="hidden" name="di_cari" id="di_cari">
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
                <?php echo form_input('TGL_DARI', !empty($TGL_DARI) ? $TGL_DARI : '', 'class="form_datetime" style="width: 99px;" placeholder="Tanggal awal" id="tglawal" autocomplete="off"'); ?>
                <label for="">s/d</label>
                <?php echo form_input('TGL_SAMPAI', !empty($TGL_SAMPAI) ? $TGL_SAMPAI : '', 'class="form_datetime" style="width: 99px;" placeholder="Tanggal akhir" id="tglakhir" autocomplete="off"'); ?>
            </div>
        </div>
        <div class="pull-left span3">
            <label for="password" class="control-label">Status Kontrak : </label>
            <div class="controls">
                <?php echo form_dropdown('STATUS_KONTRAK', $opsi_status_kontrak,'', 'id="STATUS_KONTRAK"'); ?>
            </div>                    
        </div>
        <div class="pull-left span2">
            <label for="password" class="control-label">Cari: </label>
            <div class="controls">
                <input type="text" id="CARI" name="CARI" value="" placeholder="Cari Unit, No Kontrak">
            </div>
        </div>
        <div class="pull-left">
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
          <label></label>
          <div class="controls">
          <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
          <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>
          </div>
      </div>
    </div>
    <?php echo form_close(); ?>
</div>

<div class="well-content no-search" id="divTable" style="display: none">
    <table id="dataTable" class="display" style="width: 100%" cellspacing="0">
        <thead>
            <tr>
                <th rowspan="2" style="text-align: center;">NO</th>
                <th colspan="6 " style="text-align: center;">LEVEL PEMASOK</th>
                <th colspan="6" style="text-align: center;">LEVEL PENERIMA</th>
                <th rowspan="2" style="text-align: center;">NO KONTRAK</th>
                <th rowspan="2" style="text-align: center;">JENIS<br>KONTRAK</th>
                <th rowspan="2" style="text-align: center;">TGL AWAL KONTRAK</th>
                <th rowspan="2" style="text-align: center;">TGL AKHIR KONTRAK</th>
                <th rowspan="2" style="text-align: center;">TRANSPORTIR</th>
                <th rowspan="2" style="text-align: center;">JALUR</th>
                <th rowspan="2" style="text-align: center;">JARAK (KM/ML)</th>
                <th rowspan="2" style="text-align: center;">HARGA (RP/L)</th>
                <th rowspan="2" style="text-align: center;">MEKANISME DENDA</th>
                <th rowspan="2" style="text-align: center;">TOLERANSI LOSSES<br>(%)</th>
                <th rowspan="2" style="text-align: center;">STATUS</th> 
            </tr>
            <tr>
                <th style="text-align: center;">0</th>
                <th style="text-align: center;">1</th>
                <th style="text-align: center;">2</th>
                <th style="text-align: center;">3</th>
                <th style="text-align: center;">PEMBANGKIT<br></th>
                <th style="text-align: center;">DEPO TRANSIT</th>
                <th style="text-align: center;">0</th>
                <th style="text-align: center;">1</th>
                <th style="text-align: center;">2</th>
                <th style="text-align: center;">3</th>
                <th style="text-align: center;">PEMBANGKIT</th>
                <th style="text-align: center;">DEPO</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>                        
</div>

<form id="export_excel" action="<?php echo base_url('laporan/kontrak_transportir/export_excel'); ?>" method="post">
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

<form id="export_pdf" action="<?php echo base_url('laporan/kontrak_transportir/export_pdf'); ?>" method="post" target="_blank">
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

<script type="text/javascript">
    $(document).ready(function(){
        

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
            "fixedColumns": {"leftColumns": 12},
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
                   "targets": [1,2,3,4,5,6,7,8,9,10,11,12,13]
                },
                {
                   "className": "dt-center",
                   "targets": [15,16,18,19,21,23]
                },
                {
                   "className": "dt-right",
                   "targets": [20,22]
                },
            ]
        });

        $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);

        $('select[name="TAHUN"]').val(year);

        $(".form_datetime").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left"
        });

        $('#tglawal').on('change', function() {

            var dateStart = $(this).val();

            $('#tglakhir').datepicker('setStartDate', dateStart);

            if ($('#tglakhir').val() == '') {

            } else {
                setCekTgl();
            }
        });

        $('#tglakhir').on('change', function() {
            setCekTgl();
        });

        $('#button-load').click(function(e) {
            get_data();
        });

        $('#CARI').on('input propertychange paste', function(){        
            var str = this.value;
            str = str.replace(/\"/g,'');
            str = str.replace(/\'/g,'');
            str = str.replace(/\\/g,'');
            str = str.replace(/\[/g,'');
            str = str.replace(/\]/g,'');
            this.value = str;
          
        });

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
            var status_kontrak = $('#STATUS_KONTRAK').val();

            if (tglawal == '' && tglakhir != '') {
              bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
            }else if(tglakhir == '' && tglawal != ''){
              bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
            }  else {

                $.ajax({
                    url: "<?php echo site_url('laporan/kontrak_transportir/ajax_list/')?>",
                    type: "POST",
                    data: {
                             "p_unit": p_unit,
                             "p_transportir":p_transportir,
                             "p_tglawal":p_tglawal,
                             "p_tglakhir":p_tglakhir,
                             "p_cari":p_cari,
                             "status_kontrak":status_kontrak
                    },
                    beforeSend :function(data){
                        bootbox.dialog('<div class="loading-progress"></div>');
                    },
                    error :function(data) {
                        bootbox.hideAll();
                        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Proses Gagal !-- </div>', function() {});    
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
                     
                    var PEMASOK_NAMA_REGIONAL = value.PEMASOK_NAMA_REGIONAL == null ? "" : value.PEMASOK_NAMA_REGIONAL;
                    var PEMASOK_LEVEL1 = value.PEMASOK_LEVEL1 == null ? "" : value.PEMASOK_LEVEL1;
                    var PEMASOK_LEVEL2 = value.PEMASOK_LEVEL2 == null ? "" : value.PEMASOK_LEVEL2;
                    var PEMASOK_LEVEL3 = value.PEMASOK_LEVEL3 == null ? "" : value.PEMASOK_LEVEL3;
                    var PEMASOK_LEVEL4 = value.PEMASOK_LEVEL4 == null ? "" : value.PEMASOK_LEVEL4;
                    var NAMA_DEPO = value.NAMA_DEPO == null ? "" : value.NAMA_DEPO;
                    var PENERIMA_NAMA_REGIONAL = value.PENERIMA_NAMA_REGIONAL == null ? "" : value.PENERIMA_NAMA_REGIONAL;
                    var PENERIMA_LEVEL1 = value.PENERIMA_LEVEL1 == null ? "" : value.PENERIMA_LEVEL1;
                    var PENERIMA_LEVEL2 = value.PENERIMA_LEVEL2 == null ? "" : value.PENERIMA_LEVEL2;
                    var PENERIMA_LEVEL3 = value.PENERIMA_LEVEL3 == null ? "" : value.PENERIMA_LEVEL3;
                    var PENERIMA_LEVEL4 = value.PENERIMA_LEVEL4 == null ? "" : value.PENERIMA_LEVEL4;
                    var DEPO_TRANSIT = value.DEPO_TRANSIT == null ? "" : value.DEPO_TRANSIT;
                    var KD_KONTRAK_TRANS = value.KD_KONTRAK_TRANS == null ? "" : value.KD_KONTRAK_TRANS;
                    var JENIS = value.JENIS == null ? "" : value.JENIS;
                    var TGL_KONTRAK_TRANS = value.TGL_KONTRAK_TRANS == null ? "" : value.TGL_KONTRAK_TRANS;
                    var TGL_KONTRAK_TRANS_AKHIR = value.TGL_KONTRAK_TRANS_AKHIR == null ? "" : value.TGL_KONTRAK_TRANS_AKHIR;
                    var NAMA_TRANSPORTIR = value.NAMA_TRANSPORTIR == null ? "" : value.NAMA_TRANSPORTIR;
                    var NAME_SETTING = value.NAME_SETTING == null ? "" : value.NAME_SETTING;
                    var JARAK_DET_KONTRAK_TRANS = value.JARAK_DET_KONTRAK_TRANS == null ? "" : convertToRupiah(value.JARAK_DET_KONTRAK_TRANS);
                    var HARGA_KONTRAK_TRANS = value.HARGA_KONTRAK_TRANS == null ? "" : convertToRupiah(value.HARGA_KONTRAK_TRANS);
                    var NAMA_DENDA = value.NAMA_DENDA == null ? "" : value.NAMA_DENDA;
                    var LOSSES = value.LOSSES == null ? "" : convertToRupiah(value.LOSSES);
                    var STATUS = value.STATUS == null ? "" : value.STATUS;

                    t.row.add([
                        nomer,PEMASOK_NAMA_REGIONAL,PEMASOK_LEVEL1,PEMASOK_LEVEL2,PEMASOK_LEVEL3,PEMASOK_LEVEL4,NAMA_DEPO,PENERIMA_NAMA_REGIONAL,PENERIMA_LEVEL1,PENERIMA_LEVEL2,PENERIMA_LEVEL3,PENERIMA_LEVEL4,DEPO_TRANSIT,KD_KONTRAK_TRANS,JENIS,TGL_KONTRAK_TRANS,TGL_KONTRAK_TRANS_AKHIR,NAMA_TRANSPORTIR,NAME_SETTING,JARAK_DET_KONTRAK_TRANS,HARGA_KONTRAK_TRANS,NAMA_DENDA,LOSSES,STATUS
                    ]).draw(false);

                    if (nomer == 1){
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

        $('#button-excel').click(function(e) {
            var lvl0 = $('#lvl0').val();
            var tglawal = $('#tglawal').val();
            var tglakhir = $('#tglakhir').val();

            if (tglawal == '' && tglakhir != '') {
              bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
            }else if(tglakhir == '' && tglawal != ''){
              bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
            }  else {
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
                $('input[name="xstatus_kontrak"]').val($('#STATUS_KONTRAK').val());            

                bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                    if(e){
                        $('#export_excel').submit();
                    }
                });
            }
        });

        $('#button-pdf').click(function(e) {
            var lvl0 = $('#lvl0').val();
            var tglawal = $('#tglawal').val();
            var tglakhir = $('#tglakhir').val();

            if (tglawal == '' && tglakhir != '') {
              bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
            }else if(tglakhir == '' && tglawal != ''){
              bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
            }  else {
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
                $('input[name="pstatus_kontrak"]').val($('#STATUS_KONTRAK').val());

                bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                    if(e){
                        $('#export_pdf').submit();
                    }
                });
            }
        });
    })

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
