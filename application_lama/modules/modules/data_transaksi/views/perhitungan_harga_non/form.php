
<!-- /**
 * @module TRANSAKSI PERHITUNGAN BBM
 * @author  CF
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */ -->
<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<style type="text/css">
    .dataTables_scrollHeadInner {
      width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
      width: 100% !important;    
    }     
</style>

<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>
        
        <div>  
            <div style="float: left;width: 47%"> 
            <br><br>     
                <!-- <div>DIV KIRI</div>  -->

                <div class="row">
                    <div class="control-group">
                        <label class="control-label">Periode Perhitungan<span class="required">*</span> :</label>
                        <div class="controls">
                            <?php echo form_input('periode', !empty($default->PERIODE) ? $default->PERIODE : '', 'class="span10 cek_edit" placeholder="Pilih Periode Perhitungan" id="periode"'); ?>
                            <input type="hidden" name="tgl" id="tgl" class="form_datetime">
                            <input type="hidden" name="vidtrans" id="vidtrans">
                            <input type="hidden" name="vidtrans_edit" id="vidtrans_edit" value="<?php echo !empty($default->IDTRANS) ? $default->IDTRANS : ''; ?>">
                            <input type="hidden" name="vidkoreksi" id="vidkoreksi" value="<?php echo !empty($default->IDKOREKSI) ? $default->IDKOREKSI : ''; ?>">
                            <input type="hidden" name="stat" id="stat" value="<?php echo !empty($stat) ? $stat : 'add'; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label">Periode (Kurs & MOPS)<span class="required">*</span> : </label>
                        <div class="controls">
                            <?php echo form_input('tglawal', !empty($default->TGLAWAL) ? $default->TGLAWAL : '', 'class="form_datetime cek_edit" placeholder="Dari Tanggal" id="tglawal" style="width: 126px" '); ?>
                            <label for="">s/d</label>
                            <?php echo form_input('tglakhir', !empty($default->TGLAKHIR) ? $default->TGLAKHIR : '', 'class="form_datetime cek_edit" placeholder="Sampai Tanggal" id="tglakhir" style="width: 126px" '); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label">Pemasok<span class="required">*</span> :</label>
                        <div class="controls">
                            <?php echo form_dropdown('ID_PEMASOK', $pemasok, !empty($default->KODE_PEMASOK) ? $default->KODE_PEMASOK : '', 'class="form-control span10" id="ID_PEMASOK" onchange="ganti_form(this.value);"'); ?>
                            <?php echo form_hidden('ID_PEMASOK_IN', !empty($default->KODE_PEMASOK) ? $default->KODE_PEMASOK : '', ' id="ID_PEMASOK_IN" '); ?>
                        </div>
                    </div>
                    
                    <!-- PERTAMINA --> 
                    <div class="pertamina" style="display:none">
                        <div class="control-group">
                            <label for="password" class="control-label">HSD<span class="required">*</span> : </label>
                            <div class="controls">
                                <span style="display:inline-block">
                                    <label for="p_sulfurhsd" style="display:block">Sulfur</label>
                                    <input type="text" name="SULFURHSD" class="form-control span4 rp cek_edit" placeholder="Sulfur" style="width: 80px" id="p_sulfurhsd" step="0.1" min="0.1" required value="<?php echo !empty($default->SULFUR_HSD) ? $default->SULFUR_HSD : ''?>">%
                                </span>
                                <span style="display:inline-block">
                                    <label for="p_konversihsd" style="display:block">Konversi (L)</label>
                                    <input type="text" name="KONVERSI_HSD" class="form-control span4 des4 cek_edit" placeholder="Konversi" style="width: 80px" id="p_konversihsd" step="0.1" min="0.1" required value="<?php echo !empty($default->KONVERSI_HSD) ? $default->KONVERSI_HSD : ''?>">
                                </span>
                                <span style="display:inline-block">
                                    <label for="KONSTANTA_HSD" style="display:block">Konstanta</label>
                                    <input type="text" name="KONSTANTA_HSD" class="form-control span4" placeholder="Konversi" style="width: 80px" id="KONSTANTA_HSD" value="<?php echo !empty($KONSTANTA_HSD) ? $KONSTANTA_HSD : '0'?>" disabled>
                                </span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">MFO<span class="required">*</span> : </label>
                            <div class="controls">
                                <span style="display:inline-block">
                                    <label for="p_sulfurmfo" style="display:block">Sulfur</label>
                                    <input type="text" name="SULFURMFO" class="form-control span4 rp cek_edit" placeholder="Sulfur" style="width: 80px" id="p_sulfurmfo" required value="<?php echo !empty($default->SULFUR_MFO) ? $default->SULFUR_MFO : ''?>">%
                                </span>
                                <span style="display:inline-block">
                                    <label for="p_konversimfo" style="display:block">Konversi (L)</label>
                                    <input type="text" name="KONVERSI_MFO" class="form-control span4 des4 cek_edit" placeholder="Konversi" style="width: 80px" id="p_konversimfo" required value="<?php echo !empty($default->KONVERSI_MFO) ? $default->KONVERSI_MFO : ''?>">
                                </span>
                                <span style="display:inline-block">
                                    <label for="KONSTANTA_MFO" style="display:block">Konstanta</label>
                                    <input type="text" name="KONSTANTA_MFO" class="form-control span4" placeholder="Konversi" style="width: 80px" id="KONSTANTA_MFO" value="<?php echo !empty($KONSTANTA_MFO) ? $KONSTANTA_MFO : '0'?>" disabled>
                                </span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label"></label>
                            <div class="controls">
                                <span style="display:inline-block">
                                    <label for="VAR_HITUNG" style="display:block">Variabel Hitung</label>
                                    <input type="text" name="VAR_HITUNG" class="form-control span4 " placeholder="Var. Hitung" style="width: 80px" id="VAR_HITUNG" value="<?php echo !empty($VAR_HITUNG) ? $VAR_HITUNG : ''?>">
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- PERTAMINA -->
                    <!--  AKRKPM -->

                        <div class="akrkpm" style="display:none">
                            <div class="control-group">
                                <label for="password" class="control-label">Regional<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('ID_REGIONAL', $options_reg, !empty($default->LV_R) ? $default->LV_R : '', 'id="ID_REGIONAL" class="form-control span10"'); ?>
                                </div>                                
                            </div>

                            <div class="control-group">
                                <label  class="control-label">Level 1<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->LV_1) ? $default->LV_1 : '', 'class="span10" id="COCODE"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label  class="control-label">Level 2<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->LV_2) ? $default->LV_2 : '', 'class="span10" id="PLANT"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label  class="control-label">Level 3<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->LV_3) ? $default->LV_3 : '', 'class="span10" id="STORE_SLOC"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->ID_PEMBANGKIT) ? $default->ID_PEMBANGKIT : '', 'class="span10" id="SLOC"'); ?>
                                </div>
                            </div>

                            <br>
                            <div class="control-group">
                                <label class="control-label">HSD<span class="required">*</span> : </label>
                                <div class="controls">
                                    <span style="display:inline-block">
                                        <label for="ak_alpha" style="display:block">Alpha</label>
                                        <input type="number" name="" class="form-control" style="width: 75px" placeholder="Alpha" id="ak_alpha" value="<?php echo !empty($default->ALPHAHSD) ? $default->ALPHAHSD : ''?>"> <bil id="bil" hidden>%</bil>
                                    </span>
                                    <span style="display:inline-block">
                                        <label for="bilangan" style="display:block"></label>
                                        <select class="form-control" style="width: 50px" id="bilangan" style="display: none">
                                            <option value="1">$</option>
                                            <option value="2">%</option>
                                        </select>
                                    </span>
                                    <span style="display:inline-block">
                                        <label for="ak_sulfur" style="display:block">Sulfur</label>
                                        <input type="number" name="" class="form-control" placeholder="Sulfur" style="width: 75px" id="ak_sulfur" value="<?php echo !empty($default->SULFURHSD) ? $default->SULFURHSD : ''?>">%
                                    </span>
                                    <span style="display:inline-block">
                                        <label for="ak_konversi" style="display:block">Konversi (L)</label>
                                        <input type="number" name="" class="form-control" placeholder="Konversi" style="width: 80px" id="ak_konversi" value="<?php echo !empty($default->KONVERSI_HSD) ? $default->KONVERSI_HSD : ''?>">
                                    </span>
                                    <span style="display:inline-block">
                                        <label for="ak_oa" style="display:block">OAT</label>
                                        <input type="number" name="" class="form-control" placeholder="OAT" style="width: 70px" id="ak_oa" value="<?php echo !empty($default->OAT) ? $default->OAT : ''?>">
                                    </span>
                                </div>
                            </div>
                        </div>
                    <!-- AKRKPM -->


                    <div id="divKetKoreksi" hidden>
                        <hr>
                        <div class="control-group">
                            <label class="control-label">Keterangan Koreksi<span class="required">*</span> : </label>
                            <div class="controls">
                                <?php
                                    $data = array(
                                      'name'        => 'KET_KOREKSI',
                                      'id'          => 'KET_KOREKSI',
                                      'value'       => !empty($default->KET_KOREKSI) ? $default->KET_KOREKSI : '',
                                      'rows'        => '4',
                                      'cols'        => '10',
                                      'class'       => 'span11',
                                      'style'       => '"none" placeholder=""'
                                    );
                                  echo form_textarea($data);
                                ?>                    
                            </div>
                        </div>
                    </div>
                </div><hr>  

                <div class="control-group" id="divTable">
                    <!-- <label for="password" class="control-label"></label> -->
                    <div class="controls-label">
                        <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>

                        <?php echo anchor(null, '<i class="icon-paste"></i> Hitung Harga', array('id' => 'btn_hitung', 'class' => 'green btn')); ?>   

                        <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'btn_simpan', 'class' => 'blue btn', 'onclick' => "simpan_data()", 'hidden')); ?> 

                        <?php echo anchor(null, '<i class="icon-save"></i> Simpan Koreksi', array('id' => 'btn_simpan_koreksi', 'class' => 'blue btn', 'onclick' => "simpan_data()", 'hidden')); ?>   
                    </div>
                </div>
                <hr><br>
                <div id="tabeldata" class="table-responsive"></div> 
            </div> 
            <div style="width: 6%">
                
            </div>
            <div style="float: right;width: 47%">      
                <!-- <div>DIV KANAN</div>  -->                
                <div id="listdata" class="table-responsive"></div>
            </div>    
        </div>
    
        <?php echo form_close(); ?>
             
    </div>
</div><br><br>

<script type="text/javascript">
    $('.rp').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    $('.des4').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 4,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    $('#btn_simpan').hide();
    $('#btn_simpan_koreksi').hide();
    var vid = $('input[name="id"]').val();
    if (vid){
        // alert($("#ID_PEMASOK option:selected" ).val());
        var idPemasok = $("#ID_PEMASOK option:selected" ).val();
        ganti_form(idPemasok);
        $('#ID_PEMASOK').attr("disabled", true);
    } else {
        $("#ID_PEMASOK" ).val('001');
        $('#ID_PEMASOK_IN').val('001');
        ganti_form($("#ID_PEMASOK option:selected" ).val());
        $('#ID_PEMASOK').attr("disabled", true);
    }

    function ganti_form(id){
        if(id == 001){
            pertamina();
        } else if(id == 002){
            kpm();
        } else if(id == 003){
            akr();
        }

        $("#tabeldata").html("");
        $("#listdata").html("");
        $('#btn_save1').hide();
        $('#btn_save2').hide();
        $("#KONSTANTA_HSD").attr("disabled", "disabled");
        $("#KONSTANTA_MFO").attr("disabled", "disabled");
        $("#VAR_HITUNG").attr("disabled", "disabled");
    }

    function pertamina(){
        $(".pertamina *").prop('disabled',false); $('.btn-pertamina').show(); $('.pertamina').show();
        $(".akrkpm *").prop('disabled',true); $('.akrkpm').hide(); $('.btn-kpm').hide();$('.btn-akr').hide();$('.btn-akr').hide();$('#bilangan').hide();$('#bil').hide();
    }

    function kpm(){
        $(".akrkpm *").prop('disabled',false); $('.akrkpm').show(); $('.btn-kpm').show();$('#bilangan').show();
        $(".pertamina *").prop('disabled',true); $('.btn-pertamina').hide(); $('.pertamina').hide();$('#bil').hide();
    }

    function akr(){
        $(".akrkpm *").prop('disabled',false);$('.akrkpm').show();$('.btn-kpm').show();$('#bilangan').hide();
        $(".pertamina *").prop('disabled',true); $('.btn-pertamina').hide(); $('.pertamina').hide();$('#bil').show();
    }

    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    $('#periode').datepicker({
        format: "yyyymm",
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        dateFormat: 'yyyymm',
        startView: "months", 
        minViewMode: "months",
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });

    function formula_pertamina(){ 
        var tgl1 = $('#tglawal').val();
        var tgl2 = $('#tglakhir').val();
        var ID_PEMASOK = $('#ID_PEMASOK').val();
        var p_alphahsd = $('#p_alphahsd').val();
        var p_sulfurhsd = $('#p_sulfurhsd').val();
        var p_konversihsd = $('#p_konversihsd').val();
        var p_alphamfo = $('#p_alphamfo').val();
        var p_sulfurmfo = $('#p_sulfurmfo').val();
        var p_konversimfo = $('#p_konversimfo').val();
        var datana = 'tgl1='+tgl1+'&tgl2='+tgl2+'&p_alphahsd='+p_alphahsd+'&p_sulfurhsd='+p_sulfurhsd+'&p_konversihsd='+p_konversihsd+'&p_alphamfo='+p_alphamfo+'&p_sulfurmfo='+p_sulfurmfo+'&p_konversimfo='+p_konversimfo;
        var urlna="<?=base_url()?>data_transaksi/perhitungan_harga_non/formula_pertamina/";
        
        if(p_alphahsd == '' || p_sulfurhsd == '' || p_konversihsd == '' || p_alphamfo == '' || p_sulfurmfo == '' || p_konversimfo == '')
        {
            alert('Inputan Tidak Boleh Kosong !');
        } else {
            bootbox.hideAll();
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
            type: 'POST',
            url: urlna,
            data: datana,
                error: function(data) {
                    bootbox.hideAll();
                    alert('Proses data gagal');
                },
                success: function(data) {
                    $('#listdata').html(data);                    
                    bootbox.hideAll();
                    // $('html, body').animate({scrollTop: $("#divTable").offset().top}, 1000);
                }    
            })
        }
        return false;
    }

    function get_mops_kurs(id){ 
        var data_kirim = 'vidtrans='+id;
        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_mops_kurs/";
        if(id){
            bootbox.hideAll();
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
            type: 'POST',
            url: urlna,
            data: data_kirim,
                error: function(data) {
                    bootbox.hideAll();
                    alert('Proses get_mops_kurs gagal');
                },
                success: function(data) {
                    $('#tabeldata').html(data);
                    bootbox.hideAll();
                }    
            })
        }
        return false;
    }

    function get_hitung_harga(){ 
        var data_kirim = {
            periode: $('#periode').val(),
            tglawal: $('#tglawal').val(),
            tglakhir: $('#tglakhir').val(),
            alpha: $('#p_alphamfo').val(),
            sulfur_hsd: $('#p_sulfurhsd').val(),
            sulfur_mfo: $('#p_sulfurmfo').val(),
            konversi_hsd: $('#p_konversihsd').val(),
            konversi_mfo: $('#p_konversimfo').val(),
            pemasok: $('#ID_PEMASOK_IN').val(),
            oat: $('#ak_oa').val(),
            sloc: $('#SLOC').val(),
            ket: $('#KET_KOREKSI').val(),
            stat: $('#stat').val()
        };

        var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_hitung_harga/";

        bootbox.modal('<div class="loading-progress"></div>');
        $.ajax({
        type: 'POST',
        url: url,
        data: data_kirim,
        dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                alert('Proses data gagal');
            },
            success: function(data) {
                bootbox.hideAll();

                var icon = 'icon-remove-sign'; var color = '#ac193d;';
                var message = '';
                var content_id = data[3];
                if (data[0]) {
                    icon = 'icon-ok-sign';
                    color = '#0072c6;';
                }

                message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                message += data[2];

                bootbox.alert(message, function() {
                    if (content_id){
                        $('#listdata').html(data[4]);
                        get_mops_kurs(data[5]);
                        $('#vidtrans').val(data[5]);
                        // $('#btn_simpan').show();
                        if ($('#stat').val()=='tambah_koreksi'){
                            $('#btn_simpan_koreksi').show();
                        } else {
                            $('#vidtrans_edit').val('');
                            $('#btn_simpan').show();
                        }
                        // alert('ok');
                        // console.log(data[4]);    
                        // alert(data);
                    }
                });
            }    
        })
    }    

    function get_hitung_harga_ulang(){ 
        var data_kirim = {
            periode: $('#periode').val(),
            tglawal: $('#tglawal').val(),
            tglakhir: $('#tglakhir').val(),
            alpha: $('#p_alphamfo').val(),
            sulfur_hsd: $('#p_sulfurhsd').val(),
            sulfur_mfo: $('#p_sulfurmfo').val(),
            konversi_hsd: $('#p_konversihsd').val(),
            konversi_mfo: $('#p_konversimfo').val(),
            pemasok: $('#ID_PEMASOK_IN').val(),
            oat: $('#ak_oa').val(),
            sloc: $('#SLOC').val(),
            id: $('input[name="id"]').val(),
            ket: $('#KET_KOREKSI').val(),
            vidkoreksi: $('#vidkoreksi').val()
        };

        var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_hitung_harga_pertamina_ulang/";

        bootbox.modal('<div class="loading-progress"></div>');
        $.ajax({
        type: 'POST',
        url: url,
        data: data_kirim,
        dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                alert('Proses data gagal');
            },
            success: function(data) {
                bootbox.hideAll();

                var icon = 'icon-remove-sign'; var color = '#ac193d;';
                var message = '';
                var content_id = data[3];
                if (data[0]) {
                    icon = 'icon-ok-sign';
                    color = '#0072c6;';
                }

                message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                message += data[2];

                bootbox.alert(message, function() {
                    if (content_id){
                        $('#listdata').html(data[4]);
                        get_mops_kurs_ulang(data[6]);
                        $('#vidtrans').val(data[5]);
                        $('#vidtrans_edit').val(data[6]);
                        $('#btn_simpan').show();
                        // alert('ok');
                        // console.log(data[4]);    
                        // alert(data);
                    }
                });
            }    
        })
    } 

    $('#periode').on('change', function() {
        var chrome   = navigator.userAgent.indexOf('Chrome') > -1;
        var explorer = navigator.userAgent.indexOf('MSIE') > -1;
        var firefox  = navigator.userAgent.indexOf('Firefox') > -1;
        var safari   = navigator.userAgent.indexOf("Safari") > -1;
        var camino   = navigator.userAgent.indexOf("Camino") > -1;
        var opera    = navigator.userAgent.toLowerCase().indexOf("op") > -1;

        var date = $(this).datepicker('getDate');
        var bln = 0, thn = 0;

        bln = date.getMonth() + 1;
        thn = date.getFullYear();
        
        if (chrome) {
            var tglAwal = new Date(thn+'-'+bln+'-02');
            var tglAkhir = new Date(thn+'-'+bln+'-02');
        } else {
            var tglAwal = new Date(thn+'-'+bln+'-01');
            var tglAkhir = new Date(thn+'-'+bln+'-01');
        }

        $('#tgl').datepicker('update', tglAwal);

        $('#tglawal').datepicker('update', tglAwal);
        $('#tglakhir').datepicker('update', tglAkhir);

        $('#tglawal_v').datepicker('update', tglAwal);
        $('#tglakhir_v').datepicker('update', tglAkhir);
    });

    $('.cek_edit').on('keyup', function() {
        if ($('#btn_simpan').show()){
            $('#btn_simpan').hide();    
        }
        if ($('#btn_simpan_koreksi').show()){
            $('#btn_simpan_koreksi').hide();
        } 
    });

    function get_mops_kurs_edit(id){ 
        var data_kirim = 'vidtrans='+id;
        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_mops_kurs_pertamina_edit/";
        if(id){
            bootbox.hideAll();
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
            type: 'POST',
            url: urlna,
            data: data_kirim,
                error: function(data) {
                    bootbox.hideAll();
                    alert('Proses get_mops_kurs gagal');
                },
                success: function(data) {
                    $('#tabeldata').html(data);
                    bootbox.hideAll();
                }    
            })
        }
        return false;
    }

    function get_mops_kurs_ulang(id){ 
        var data_kirim = 'vidtrans='+id;
        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_mops_kurs_pertamina_ulang/";
        if(id){
            bootbox.hideAll();
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
            type: 'POST',
            url: urlna,
            data: data_kirim,
                error: function(data) {
                    bootbox.hideAll();
                    alert('Proses get_mops_kurs gagal');
                },
                success: function(data) {
                    $('#tabeldata').html(data);
                    bootbox.hideAll();
                }    
            })
        }
        return false;
    }

    function get_hitung_harga_edit(){ 
        var data_kirim = {
            periode: $('#periode').val(),
            tglawal: $('#tglawal').val(),
            tglakhir: $('#tglakhir').val(),
            alpha: $('#p_alphamfo').val(),
            sulfur_hsd: $('#p_sulfurhsd').val(),
            sulfur_mfo: $('#p_sulfurmfo').val(),
            konversi_hsd: $('#p_konversihsd').val(),
            konversi_mfo: $('#p_konversimfo').val(),
            pemasok: $('#ID_PEMASOK_IN').val(),
            oat: $('#ak_oa').val(),
            sloc: $('#SLOC').val(),
            id: $('input[name="id"]').val()
        };

        var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_hitung_harga_pertamina_edit/";

        bootbox.modal('<div class="loading-progress"></div>');
        $.ajax({
        type: 'POST',
        url: url,
        data: data_kirim,
        dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                alert('Proses data gagal');
            },
            success: function(data) {
                bootbox.hideAll();

                var icon = 'icon-remove-sign'; var color = '#ac193d;';
                var message = '';
                var content_id = data[3];
                if (data[0]) {
                    icon = 'icon-ok-sign';
                    color = '#0072c6;';
                    $('#listdata').html(data[4]);
                        get_mops_kurs_edit(data[5]);
                }
            }    
        })
    }   

    function simpan_data(){ 
        bootbox.confirm('Apakah yakin akan menyimpan data ?', "Tidak", "Ya", function(e) {
            if(e){
                var data_kirim = 'vidtrans='+$('#vidtrans').val()+'&vidtrans_edit='+$('#vidtrans_edit').val()+'&vidkoreksi='+$('#vidkoreksi').val();

                if ($('input[name="id"]').val()){ //edit
                    if ($('#stat').val()=='tambah_koreksi'){
                        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_non/simpan_data_koreksi/";
                    } else {
                        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_non/simpan_data_edit/";
                    }
                } else { //add
                    var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_non/simpan_data/";
                }

                    
                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                type: 'POST',
                url: urlna,
                data: data_kirim,
                dataType:'json',
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses simpan data gagal ');
                    },
                    success: function(data) {
                        bootbox.hideAll();

                        var icon = 'icon-remove-sign'; var color = '#ac193d;';
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }

                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            if (content_id){
                                $('#button-back').click();
                                load_table('#content_table', 1, '#ffilter');
                            }
                        });
                    }    
                });
                    
            }
        });
    }

    $("#btn_hitung").click(function () {
        bootbox.confirm('Apakah yakin akan proses perhitungan harga ?', "Tidak", "Ya", function(e) {
            if(e){
                if (($('input[name="id"]').val()) && ($('#stat').val()!='tambah_koreksi')){
                    get_hitung_harga_ulang();
                } else {
                    get_hitung_harga();
                }
                // if ($('#stat').val()=='add'){
                //     get_hitung_harga();
                // } else {
                //     // get_hitung_harga_ulang();
                //     alert('Proses hitung ulang masih dlm pengerjaan');
                // }
            }
        });
    }); 

    if ($('input[name="id"]').val()){
        get_hitung_harga_edit();

        if ($('#stat').val()=='tambah_koreksi'){
            // $('#KET_KOREKSI').attr('disabled', true);
            $('#KET_KOREKSI').attr('readonly','readonly');
            $('#divKetKoreksi').show();
        }
    }

</script>