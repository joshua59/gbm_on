
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
                            <?php echo form_input('periode', !empty($default->PERIODE) ? $default->PERIODE : '', 'class="span10" placeholder="Pilih Periode Perhitungan" id="periode"'); ?>
                            <input type="hidden" name="tgl" id="tgl" class="form_datetime">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label">Pemasok<span class="required">*</span> :</label>
                        <div class="controls">
                            <?php echo form_dropdown('ID_PEMASOK', $pemasok, !empty($default->KODE_PEMASOK) ? $default->KODE_PEMASOK : '', 'class="form-control span10" id="ID_PEMASOK" onchange="ganti_form(this.value);"'); ?>
                            <?php echo form_hidden('ID_PEMASOK_IN', !empty($default->KODE_PEMASOK) ? $default->KODE_PEMASOK : '', ' id="ID_PEMASOK_IN" '); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label">Periode (Kurs & MOPS)<span class="required">*</span> : </label>
                        <div class="controls">
                            <?php echo form_input('tglawal_v', !empty($default->TGLAWAL) ? $default->TGLAWAL : '', 'class="form_datetime" placeholder="Dari Tanggal" id="tglawal" style="width: 126px" disabled'); ?>
                            <?php echo form_hidden('tglawal', !empty($default->TGLAWAL) ? $default->TGLAWAL : '', 'class="form_datetime" placeholder="Dari Tanggal" id="tglawal" style="width: 126px" '); ?>
                            <label for="">s/d</label>
                            <?php echo form_input('tglakhir_v', !empty($default->TGLAKHIR) ? $default->TGLAKHIR : '', 'class="form_datetime" placeholder="Sampai Tanggal" id="tglakhir" style="width: 126px" disabled'); ?>
                            <?php echo form_hidden('tglakhir', !empty($default->TGLAKHIR) ? $default->TGLAKHIR : '', 'class="form_datetime" placeholder="Sampai Tanggal" id="tglakhir" style="width: 126px" '); ?>
                        </div>
                    </div>

                    <!-- PERTAMINA --> 
                    <div class="pertamina" style="display:none">
                        <div class="control-group">
                            <label for="password" class="control-label">HSD<span class="required">*</span> : </label>
                            <div class="controls">
                                <span style="display:inline-block">
                                    <label for="p_sulfurhsd" style="display:block">Sulfur</label>
                                    <input type="text" name="SULFURHSD" class="form-control span4 rp" placeholder="Sulfur" style="width: 80px" id="p_sulfurhsd" step="0.1" min="0.1" required value="<?php echo !empty($default->SULFUR_HSD) ? $default->SULFUR_HSD : ''?>">%
                                </span>
                                <span style="display:inline-block">
                                    <label for="p_konversihsd" style="display:block">Konversi (L)</label>
                                    <input type="text" name="KONVERSI_HSD" class="form-control span4 rp" placeholder="Konversi" style="width: 80px" id="p_konversihsd" step="0.1" min="0.1" required value="<?php echo !empty($default->KONVERSI_HSD) ? $default->KONVERSI_HSD : ''?>">
                                </span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">MFO<span class="required">*</span> : </label>
                            <div class="controls">
                                <span style="display:inline-block">
                                    <label for="p_sulfurmfo" style="display:block">Sulfur</label>
                                    <input type="text" name="SULFURMFO" class="form-control span4 rp" placeholder="Sulfur" style="width: 80px" id="p_sulfurmfo" value="<?php echo !empty($default->SULFUR_MFO) ? $default->SULFUR_MFO : ''?>">%
                                </span>
                                <span style="display:inline-block">
                                    <label for="p_konversimfo" style="display:block">Konversi (L)</label>
                                    <input type="text" name="KONVERSI_MFO" class="form-control span4 rp" placeholder="Konversi" style="width: 80px" id="p_konversimfo" value="<?php echo !empty($default->KONVERSI_MFO) ? $default->KONVERSI_MFO : ''?>">
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
                </div><hr>  

                <div class="control-group" id="divTable">
                    <label for="password" class="control-label"></label>
                    <div class="controls">
                        <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>

                        <?php echo anchor(null, '<i class="icon-paste"></i> Hitung Harga', array('id' => 'btn_hitung', 'class' => 'green btn', 'onclick' => "get_hitung_harga()")); ?>   

                        <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'btn_simpan', 'class' => 'blue btn', 'onclick' => "simpan_data()")); ?>     
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

    $('#btn_simpan').hide();
    var vid = $('input[name="id"]').val();
    if (vid){
        // alert($("#ID_PEMASOK option:selected" ).val());
        var idPemasok = $("#ID_PEMASOK option:selected" ).val();
        ganti_form(idPemasok);

        // if (idPemasok=='001'){
        //     get_mops(1);
        //     formula_pertamina();    
        // } else {
        //     get_mops(2);
        //     formula_akrkpm();
        // }
        
        // $("#ID_PEMASOK").prop("disabled", true);
        // $('.btn-kpm').hide(); $('.btn-pertamina').hide();
        // $("#periode").prop("disabled", true);
        // $("#tglawal").prop("disabled", true);
        // $("#tglakhir").prop("disabled", true);
        // $("#p_alphahsd").prop("disabled", true);
        // $("#p_sulfurhsd").prop("disabled", true);
        // $("#p_konversihsd").prop("disabled", true);
        // $("#p_alphamfo").prop("disabled", true);
        // $("#p_sulfurmfo").prop("disabled", true);
        // $("#p_konversimfo").prop("disabled", true);

        // $("#ID_REGIONAL").prop("disabled", true);
        // $("#COCODE").prop("disabled", true);
        // $("#PLANT").prop("disabled", true);
        // $("#STORE_SLOC").prop("disabled", true);
        // $("#SLOC").prop("disabled", true);

        // $("#ak_alpha").prop("disabled", true);
        // $("#bilangan").prop("disabled", true);
        // $("#ak_sulfur").prop("disabled", true);
        // $("#ak_konversi").prop("disabled", true);
        // $("#ak_oa").prop("disabled", true);
        
        // var vbil = "<?php echo !empty($default->TIPE) ? $default->TIPE : '1' ?>";

        // $('#bilangan').val(vbil);   

    } else {
        // $("#ID_PEMASOK" ).val('001');
        // $('#ID_PEMASOK_IN').val('001');
        // ganti_form($("#ID_PEMASOK option:selected" ).val());
        // $('#ID_PEMASOK').attr("disabled", true);
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
        format: "MM yyyy",
        changeMonth: true,
        changeYear: true,
        autoclose: true,
        dateFormat: 'mm yyyy',
        startView: "months", 
        minViewMode: "months",
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });

    function get_mops(id){ 
        var tgl1 = $('#tglawal').val();
        var tgl2 = $('#tglakhir').val();
        var datana = 'tgl1='+tgl1+'&tgl2='+tgl2;

        if(id == 1){
            var urlna="<?=base_url()?>data_transaksi/perhitungan_harga_non/get_mid_mops/";
        } else if(id == 2) {
            var urlna="<?=base_url()?>data_transaksi/perhitungan_harga_non/get_low_mops/";
        } if(tgl1 == '' || tgl2 == '') {
            alert('Tanggal Tidak Boleh Kosong');
        } else {
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
                    $('#tabeldata').html(data);
                    bootbox.hideAll();
                }    
            })
        }
        return false;
    }

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

    function formula_akrkpm(){ 
        var tgl1 = $('#tglawal').val();
        var tgl2 = $('#tglakhir').val();
        var ID_PEMASOK = $('#ID_PEMASOK').val();
        var ak_alpha = $('#ak_alpha').val();
        var ak_sulfur = $('#ak_sulfur').val();
        var ak_konversi = $('#ak_konversi').val();
        var ak_oa = $('#ak_oa').val();

        if(ID_PEMASOK == 002){
            var bilangan = $('#bilangan').val();
        } else {
            var bilangan = "";
        }
        
        var datana = 'tgl1='+tgl1+'&tgl2='+tgl2+'&ak_alpha='+ak_alpha+'&ak_sulfur='+ak_sulfur+'&ak_konversi='+ak_konversi+'&ak_oa='+ak_oa+'&bilangan='+bilangan+'&ID_PEMASOK='+ID_PEMASOK;
        var urlna="<?=base_url()?>data_transaksi/perhitungan_harga_non/formula_akrkpm/";

        if(ID_PEMASOK == 002){
            if(ak_alpha == '' || ak_sulfur == '' || ak_konversi == '' || ak_oa == '' || bilangan == '')
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
        } else {
            if(ak_alpha == '' || ak_sulfur == '' || ak_konversi == '' || ak_oa == '')
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
        }
        return false;
    }

    function save(id){ 
        var periode = $('#periode').val();
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();
        var ID_PEMASOK = $('#ID_PEMASOK').val()
        var alphamfo = $('#p_alphamfo').val();
        var sulfurmfo = $('#p_sulfurmfo').val();
        var KONVERSI_MFO = $('#p_konversimfo').val();
        var avgmidhsd = $('#AVGMIDHSD').val();
        var avgmidmfo = $('#AVGMIDMFO').val();
        var avgkurs = $('#AVGKURS').val();
        var avglowhsd = $('#AVGLOWHSD').val();
        var OAT = $('#a_oa').val();
        var HARGATANPAOAT = $('#HARGATANPAOAT').val();
        var HARGADGNOAT = $('#HARGADGNOAT').val();
        var HARGA = $('#AVGKURS').val();
        var ID_REGIONAL = $('#ID_REGIONAL').val();
        var COCODE = $('#COCODE').val();
        var PLANT = $('#PLANT').val();
        var STORE_SLOC = $('#STORE_SLOC').val();
        var SLOC = $('#SLOC').val();
        var TANGGAL = $('#tgl').val();

        bootbox.confirm('Apakah yakin akan menyimpan data ?', "Tidak", "Ya", function(e) {
            if(e){
                if(id == 1){   
                    var alphahsd = $('#p_alphahsd').val();
                    var sulfur = $('#p_sulfurhsd').val();
                    var KONVERSI_HSD = $('#p_konversihsd').val();
                    var HSDNOPPN = $('#HSDNOPPN').val();
                    var HSDPPN = $('#HSDPPN').val();
                    var HSDTOTAL = $('#HSDTOTAL').val();
                    var MFONOPPN = $('#MFONOPPN').val();
                    var MFOPPN = $('#MFOPPN').val();
                    var MFOTOTAL = $('#MFOTOTAL').val();
                    var IDONOPPN = $('#IDONOPPN').val();
                    var IDOPPN = $('#IDOPPN').val();
                    var IDOTOTAL = $('#IDOTOTAL').val();
                    var datana = 'tglawal='+tglawal+'&tglakhir='+tglakhir+'&p_alphahsd='+alphahsd+'&p_alphamfo='+alphamfo+'&p_sulfurhsd='+sulfur+'&KONVERSI_HSD='+KONVERSI_HSD+'&KONVERSI_MFO='+KONVERSI_MFO+'&AVGMIDHSD='+avgmidhsd+'&AVGMIDMFO='+avgmidmfo+'&AVGKURS='+avgkurs+'&HSDNOPPN='+HSDNOPPN+'&HSDPPN='+HSDPPN+'&HSDTOTAL='+HSDTOTAL+'&MFONOPPN='+MFONOPPN+'&MFOPPN='+MFOPPN+'&MFOTOTAL='+MFOTOTAL+'&IDONOPPN='+IDONOPPN+'&IDOPPN='+IDOPPN+'&IDOTOTAL='+IDOTOTAL+'&ID_PEMASOK='+ID_PEMASOK+'&periode='+periode+'&sulfurmfo='+sulfurmfo+'&id='+id+'&TANGGAL='+TANGGAL;

                    var urlna="<?=base_url()?>data_transaksi/perhitungan_harga_non/save/";
                }
                // else if(id == 2)
                else
                {
                    var ALPHAHSD = $('#ak_alpha').val();
                    var SULFURHSD = $('#ak_sulfur').val();
                    var KONVERSI_HSD = $('#ak_konversi').val();
                    var TIPE = $('#bilangan').val(); 
                    var OAT = $('#ak_oa').val();

                    var datana = 
                    'tglawal='+tglawal+'&tglakhir='+tglakhir+'&ALPHAHSD='+ALPHAHSD+'&periode='+periode+'&SULFURHSD='+SULFURHSD+'&KONVERSI_HSD='+KONVERSI_HSD+'&AVGLOWHSD='+avglowhsd+'&HARGA='+HARGA+'&OAT='+OAT+'&HARGATANPAOAT='+HARGATANPAOAT+'&HARGADGNOAT='+HARGADGNOAT+'&ID_PEMASOK='+ID_PEMASOK+'&TIPE='+TIPE+'&id='+id+'&ID_REGIONAL='+ID_REGIONAL+'&COCODE='+COCODE+'&PLANT='+PLANT+'&STORE_SLOC='+STORE_SLOC+'&SLOC='+SLOC+'&TANGGAL='+TANGGAL;

                    var urlna="<?=base_url()?>data_transaksi/perhitungan_harga_non/save/";
                }
                // else if(id == 3)
                // {
                //     var ALPHAHSD = $('#a_alpha').val();
                //     var SULFURHSD = $('#a_sulfur').val();
                //     var KONVERSI_HSD = $('#a_konversi').val();


                //     var datana = 
                //     'tglawal='+tglawal+'&tglakhir='+tglakhir+'&ALPHAHSD='+ALPHAHSD+'&periode='+periode+'&SULFURHSD='+SULFURHSD+'&KONVERSI_HSD='+KONVERSI_HSD+'&AVGLOWHSD='+avglowhsd+'&HARGA='+HARGA+'&OAT='+OAT+'&HARGATANPAOAT='+HARGATANPAOAT+'&HARGADGNOAT='+HARGADGNOAT+'&ID_PEMASOK='+ID_PEMASOK+'&id='+id+'&ID_REGIONAL='+ID_REGIONAL+'&COCODE='+COCODE+'&PLANT='+PLANT+'&STORE_SLOC='+STORE_SLOC+'&SLOC='+SLOC;
                //     var urlna="<?=base_url()?>data_transaksi/perhitungan_harga_non/save/";
                // }

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
                           var obj = JSON.parse(data);
                           if(obj.status == 1)
                           {
                                // alert(obj.messege);
                              bootbox.hideAll();
                              var message = '<div class="box-title" style="color:#0072c6"><i class="icon-ok-sign"></i> Berhasil disimpan</div>';
                              bootbox.alert(message, function() {
                                location.reload();
                              });                                
                           }
                        }    
                    });
            }
        });
        return false;
    }

    function simpan_data(){ 
        bootbox.confirm('Apakah yakin akan menyimpan data ?', "Tidak", "Ya", function(e) {
            if(e){
                var data_kirim = 'vidtrans='+$('#vidtrans').val();
                var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_non/simpan_data/";
                if($('#vidtrans').val()){
                    bootbox.modal('<div class="loading-progress"></div>');
                    $.ajax({
                    type: 'POST',
                    url: urlna,
                    data: data_kirim,
                    dataType:'json',
                        error: function(data) {
                            bootbox.hideAll();
                            alert('Proses simpan data gagal '+data);
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
                    })
                }
            }
        });
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
        bootbox.confirm('Apakah yakin akan proses perhitungan harga ?', "Tidak", "Ya", function(e) {
            if(e){
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
                    sloc: $('#SLOC').val()
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
                                $('#btn_simpan').show();
                                // alert('ok');
                                // console.log(data[4]);    
                                // alert(data);
                            }
                        });
                    }    
                })
            }
        });
    }    

    $('#btn_hit_pertamina').click(function(e) {
        bootbox.confirm('Apakah yakin akan proses hitung harga ?', "Tidak", "Ya", function(e) {
            if(e){
                get_mops(1);
                formula_pertamina();
                $('#btn_save1').show();                
            }
        });
    });

    $('#btn_hit_akr').click(function(e) {
        bootbox.confirm('Apakah yakin akan proses hitung harga ?', "Tidak", "Ya", function(e) {
            if(e){
                get_mops(2);
                formula_akrkpm();
                $('#btn_save2').show();
            }
        });
    });

    $('#periode').on('change', function() {
        var stateID = $(this).val();
        var bln = 0, thn = 0;
        var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ];

        var res = stateID.split(' ');
        stateID = $.trim(res[0]);
        thn = $.trim(res[1]);

        for (i = 0; i < monthNames.length; i++) {
            if (monthNames[i]==stateID){
                bln = i; bln++;
                break;
            }
        }        

        var chrome   = navigator.userAgent.indexOf('Chrome') > -1;
        var explorer = navigator.userAgent.indexOf('MSIE') > -1;
        var firefox  = navigator.userAgent.indexOf('Firefox') > -1;
        var safari   = navigator.userAgent.indexOf("Safari") > -1;
        var camino   = navigator.userAgent.indexOf("Camino") > -1;
        var opera    = navigator.userAgent.toLowerCase().indexOf("op") > -1;
        
        if (chrome) {
            var tglAwal = new Date(thn+'-'+bln+'-27');
            var tglAkhir = new Date(thn+'-'+bln+'-26');
        } else {
            var tglAwal = new Date(thn+'-'+bln+'-26');
            var tglAkhir = new Date(thn+'-'+bln+'-25');
        }

        $('#tgl').datepicker('update', tglAwal);

        tglAwal.setMonth( tglAwal.getMonth() - 2 );
        tglAkhir.setMonth( tglAkhir.getMonth() - 1 );

        $('#tglawal').datepicker('update', tglAwal);
        $('#tglakhir').datepicker('update', tglAkhir);

        $('#tglawal_v').datepicker('update', tglAwal);
        $('#tglakhir_v').datepicker('update', tglAkhir);

        // alert('thbl = '+thn+'-'+bln);
        // alert('bln: '+bln+' '+stateID+'  awal:'+tglAwal+' akhir:'+tglAkhir );
    });

</script>


<script type="text/javascript">
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_options_lv1/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_options_lv2/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_options_lv3/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_options_lv4/'+stateID;
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
</script> 