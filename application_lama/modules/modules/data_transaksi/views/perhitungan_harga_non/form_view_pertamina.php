
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
            <div style="float: left;width: 47%"> 
            <br><br>     
                <!-- <div>DIV KIRI</div>  -->
                <div class="row">
                    <div class="control-group">
                        <label class="control-label">Periode Perhitungan<span class="required">*</span> :</label>
                        <div class="controls">
                            <?php echo form_input('periode', !empty($default->PERIODE) ? $default->PERIODE : '-', 'class="span10" placeholder="Pilih Periode Perhitungan" id="periode" disabled'); ?>
                            <?php echo form_hidden('IDKOREKSI', !empty($default->IDKOREKSI) ? $default->IDKOREKSI : '-', 'id="IDKOREKSI"'); ?>
                            <input type="hidden" name="tgl" id="tgl" class="form_datetime">
                            <input type="hidden" name="stat" id="stat" value="<?php echo !empty($stat) ? $stat : 'view'; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label">Pemasok<span class="required">*</span> :</label>
                        <div class="controls">
                            <?php echo form_dropdown('ID_PEMASOK', $pemasok, !empty($default->KODE_PEMASOK) ? $default->KODE_PEMASOK : '', 'class="form-control span10" id="ID_PEMASOK" onchange="ganti_form(this.value);" disabled'); ?>
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
                    <div class="pertamina">
                        <div class="control-group">
                            <label for="password" class="control-label">HSD<span class="required">*</span> : </label>
                            <div class="controls">
                                <span style="display:inline-block">
                                    <label for="p_sulfurhsd" style="display:block">Sulfur</label>
                                    <input type="text" name="SULFURHSD" class="form-control span4 rp" placeholder="Sulfur" style="width: 80px" id="p_sulfurhsd" step="0.1" min="0.1" required value="<?php echo !empty($default->SULFUR_HSD) ? $default->SULFUR_HSD : ''?>" disabled>%
                                </span>
                                <span style="display:inline-block">
                                    <label for="p_konversihsd" style="display:block">Konversi (L)</label>
                                    <input type="text" name="KONVERSI_HSD" class="form-control span4 des4" placeholder="Konversi" style="width: 80px" id="p_konversihsd" step="0.1" min="0.1" required value="<?php echo !empty($default->KONVERSI_HSD) ? $default->KONVERSI_HSD : ''?>" disabled>
                                </span>
                                <span style="display:inline-block">
                                    <label for="KONSTANTA_HSD" style="display:block">Konstanta</label>
                                    <input type="text" name="KONSTANTA_HSD" class="form-control span4" placeholder="Konversi" style="width: 80px" id="KONSTANTA_HSD" value="<?php echo !empty($default->KONSTANTA_HSD) ? $default->KONSTANTA_HSD : '0'?>" disabled>
                                </span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label">MFO<span class="required">*</span> : </label>
                            <div class="controls">
                                <span style="display:inline-block">
                                    <label for="p_sulfurmfo" style="display:block">Sulfur</label>
                                    <input type="text" name="SULFURMFO" class="form-control span4 rp" placeholder="Sulfur" style="width: 80px" id="p_sulfurmfo" value="<?php echo !empty($default->SULFUR_MFO) ? $default->SULFUR_MFO : ''?>" disabled>%
                                </span>
                                <span style="display:inline-block">
                                    <label for="p_konversimfo" style="display:block">Konversi (L)</label>
                                    <input type="text" name="KONVERSI_MFO" class="form-control span4 des4" placeholder="Konversi" style="width: 80px" id="p_konversimfo" value="<?php echo !empty($default->KONVERSI_MFO) ? $default->KONVERSI_MFO : ''?>" disabled>
                                </span>
                                <span style="display:inline-block">
                                    <label for="KONSTANTA_MFO" style="display:block">Konstanta</label>
                                    <input type="text" name="KONSTANTA_MFO" class="form-control span4" placeholder="Konversi" style="width: 80px" id="KONSTANTA_MFO" value="<?php echo !empty($default->KONSTANTA_MFO) ? $default->KONSTANTA_MFO : '0'?>" disabled>
                                </span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="password" class="control-label"></label>
                            <div class="controls">
                                <span style="display:inline-block">
                                    <label for="VAR_HITUNG" style="display:block">Variabel Hitung</label>
                                    <input type="text" name="VAR_HITUNG" class="form-control span4 " placeholder="Var. Hitung" style="width: 80px" id="VAR_HITUNG" value="<?php echo !empty($default->VARIABEL) ? $default->VARIABEL : ''?>" disabled>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- PERTAMINA -->

                    <div id="divKetKoreksi" hidden>
                        <hr>
                        <div class="control-group">
                            <label class="control-label">Keterangan <span class="required">*</span> : </label>
                            <div class="controls">
                                <?php
                                    $data = array(
                                      'name'        => 'KET_KOREKSI',
                                      'id'          => 'KET_KOREKSI',
                                      'value'       => !empty($default->KET_KOREKSI) ? $default->KET_KOREKSI : '',
                                      'rows'        => '4',
                                      'cols'        => '10',
                                      'class'       => 'span11',
                                      'style'       => '"none" placeholder="Ketik Keterangan"'
                                    );
                                  echo form_textarea($data);
                                ?>                    
                            </div>
                        </div>
                    </div>

                </div><hr>  

                <div class="control-group">
                    <!-- <label for="password" class="control-label"></label> -->
                    <div class="controls-label">
                        <!-- <?php //echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>    -->
                        <?php echo hgenerator::render_button_group($button_group); ?>  
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
        <?php echo form_close(); ?>
    </div>
</div>
<br><br>

<script type="text/javascript">
    var icon = 'icon-remove-sign';
    var color = '#ac193d;';
    
    $('.rp').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    $('.des4').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 4,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

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

    function get_mops_kurs(id){ 
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
                        get_mops_kurs(data[5]);
                }
            }    
        })
    }

    function getIdTrans(vid){
        var IdTrans = vid.split('-');
        return IdTrans[2];
    }

    function approveData(vid) {
        bootbox.confirm('Yakin data ini akan disetujui ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=2';
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga_non/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            load_table('#content_table', 1, '#ffilter');
                            close_form(vid);
                        });
                    }
                });
            }
        });
    }

    function approveDataKoreksi(vid) {
        bootbox.confirm('Yakin data ini akan disetujui ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=11&IDKOREKSI='+$('#IDKOREKSI').val();
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga_non/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            load_table('#content_table', 1, '#ffilter');
                            close_form(vid);
                        });
                    }
                });
            }
        });
    }

    function tolakData(vid) {
        bootbox.confirm('Yakin data ini akan ditolak ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=3&KET_KOREKSI='+$('#KET_KOREKSI').val();
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga_non/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            if (data[0]) {
                                load_table('#content_table', 1, '#ffilter');
                                close_form(vid);
                            }
                        });
                    }
                });
            }
        });
    }

    function tolakDataKoreksi(vid) {
        bootbox.confirm('Yakin data ini akan ditolak ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=12&IDKOREKSI='+$('#IDKOREKSI').val()+'&KET_KOREKSI='+$('#KET_KOREKSI').val();
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga_non/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            if (data[0]) {
                                load_table('#content_table', 1, '#ffilter');
                                close_form(vid);
                            }
                        });
                    }
                });
            }
        });
    }

    function koreksiData(vid) {
        bootbox.confirm('Yakin data ini akan disimpan ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=8&KET_KOREKSI='+$('#KET_KOREKSI').val();
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga_non/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            load_table('#content_table', 1, '#ffilter');
                            close_form(vid);
                        });
                    }
                });
            }
        });
    }

    if ($('input[name="id"]').val()){
        get_hitung_harga();

        if (($('#stat').val()=='approve_koreksi') || ($('#stat').val()=='approve')){
            $('#divKetKoreksi').show();
        } else if ($('#stat').val()=='view_koreksi'){
            $('#KET_KOREKSI').attr('disabled', true);
            $('#divKetKoreksi').show();
        } else if ($('#stat').val()=='approve_koreksi_hasil'){
            // $('#KET_KOREKSI').attr('disabled', true);
            $('#divKetKoreksi').show();
        } else if ($('#KET_KOREKSI').val()!=''){
            $('#KET_KOREKSI').attr('disabled', true);
            $('#divKetKoreksi').show();            
        }
    }
</script>
