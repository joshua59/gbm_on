
<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>

    <div class="box-content">
        <?php
            $hidden_form = array('id' => !empty($id) ? $id : '');
                echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?> 
        <div class="form_row">
            <div class="span5">
                <div class="control-group">
                    <label for="password" class="control-label">Nama Parameter : </label>
                    <div class="controls">
                        <?php echo form_input('PARAMETER_ANALISA', !(empty($default->PARAMETER_ANALISA)) ? $default->PARAMETER_ANALISA : '', ' id="PARAMETER_ANALISA"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Tipe : </label>
                    <div class="controls">
                        <select name="TIPE" class="form-control" id="tipe" onchange="change_value(this.value)" style="width: 170px">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="1">Input</option>
                            <option value="2">Pilihan</option>
                        </select>
                    </div>
                </div>
                
                <div id="param" hidden>
                    <div class="control-group">
                        <label for="password" class="control-label">Jumlah Nilai <span class="required"> *</span> : </label>
                        <div class="controls">
                            <input type="text" id="JML_PARAMETER" style="width: 150px%">
                            <?php echo anchor(null, 'Generate', array('id' => 'button-jml-parameter', 'class' => 'green btn')); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="span7">
                <div id="div_tbl" style="display: none">
                    <table class="table table-bordered" id="table">
                         <thead>
                            <tr>
                                <th rowspan="2">NO</th>
                                <th rowspan="2">Nama Nilai</th>
                                <th rowspan="2">Status</th>
                                <th rowspan="2">Urutan</th>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan(this.id, '#finput', '#button-back');")); ?>
        <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'filter();')); ?>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    jQuery(function($) {

        $('#JML_PARAMETER').inputmask('Regex', { regex: "^[1-9][0-9]?$|^10$"});

        $(".datepicker").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left",
            beforeShow: function(i) { if ($(i).attr('readonly')) { return false; } }
        });

    })

    function change_value(id) {
        if(id == 2) {
            $('#param').show();
        } else {
            $('#param').hide();
            $('#div_tbl').hide();
        }
    }

    function simpan(button, form, disable, content) {
        var tipe =  $('#tipe').val();
        if (typeof $('#' + button).attr('disabled') === 'undefined') {

            bootbox.setBtnClasses({
                CANCEL: '',
                CONFIRM: 'blue'
            });

            var source = $(form).attr('data-source');
            var conf = $(form).attr('data-confirm');
            var conf_message = conf;
            var conf_tinymce = $(form).attr('data-tinymce');

            if (typeof conf === 'undefined') {
                conf_message = 'Anda yakin akan menyimpan data?';
            }

            if(tipe == 2) {
                if($('#div_tbl').is(':hidden')) {
                    message = '<div class="box-title" style="color: red;"><i class="icon-remove-sign"></i>  -- Maaf, Data Parameter Analisa belum terisi, mohon klik tombol <b>"Generate"</b> untuk dapat menginput parameter Analisa . --</div>';
                    bootbox.alert(message, function() {$(".bootbox").modal("hide");});
                } else {
                    bootbox.confirm(conf_message, "Tidak", "Ya", function(e) {
                        if (e) {               

                            bootbox.modal('<div class="loading-progress"></div>');

                            if (typeof conf_tinymce !== 'undefined' && conf_tinymce === 'true') {
                                tinyMCE.triggerSave();
                            }

                            $(form).ajaxSubmit({
                                beforeSubmit: function(a, f, o) {
                                    o.dataType = 'json';
                                },
                                success: function(res) {                        
                                    var message = '';
                                    var icon = 'icon-remove-sign';
                                    var color = '#ac193d;';
                                    var content_id = res[3];

                                    if (res[0]) {
                                        icon = 'icon-ok-sign';
                                        color = '#0072c6;';
                                        if ("#login")
                                            $("#closeforgot").click();
                                    }

                                    message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + res[1] + '</div>';
                                    message += res[2];

                                    $(".bootbox").modal("hide");
                                    if(res[0] == true) {
                                        bootbox.alert(message, function() {
                                            filter();
                                        });
                                    } else {
                                        bootbox.alert(message, function() {
                                           
                                        });
                                    }
                                    
                                },                    
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    $(".bootbox").modal("hide");
                                    msgGagal('Proses gagal, '+errorThrown);
                                }                    
                            });    
                        }
                    });
                }
            } else {
                bootbox.confirm(conf_message, "Tidak", "Ya", function(e) {
                        if (e) {               

                            bootbox.modal('<div class="loading-progress"></div>');

                            if (typeof conf_tinymce !== 'undefined' && conf_tinymce === 'true') {
                                tinyMCE.triggerSave();
                            }

                            $(form).ajaxSubmit({
                                beforeSubmit: function(a, f, o) {
                                    o.dataType = 'json';
                                },
                                success: function(res) {                        
                                    var message = '';
                                    var icon = 'icon-remove-sign';
                                    var color = '#ac193d;';
                                    var content_id = res[3];

                                    if (res[0]) {
                                        icon = 'icon-ok-sign';
                                        color = '#0072c6;';
                                        if ("#login")
                                            $("#closeforgot").click();
                                    }

                                    message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + res[1] + '</div>';
                                    message += res[2];

                                    $(".bootbox").modal("hide");
                                    if(res[0] == true) {
                                        bootbox.alert(message, function() {
                                            filter();
                                        });
                                    } else {
                                        bootbox.alert(message, function() {
                                           
                                        });
                                    }
                                    
                                },                    
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    $(".bootbox").modal("hide");
                                    msgGagal('Proses gagal, '+errorThrown);
                                }                    
                            });    
                        }
                    });
            }

        }
    }

    $("#button-jml-parameter").click(function(){
        $('#div_tbl').hide();
        var x = $('#JML_PARAMETER').val(); 

        if(x > 10){
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Max 10 data jumlah pengiriman yang diperbolehkan</div>';
            bootbox.alert(message, function() {});
            $('#JML_PARAMETER').val('10');
        } else {
            $('#div_tbl').show();
            $('#tbody').html('');
            var x = $('#JML_PARAMETER').val(); 
            for (var i = 0; i < x; i++) {

                $('#tbody').append(
                    "<tr>"+
                        "<td style='width:10%;text-align:center'>"+(i+1)+"</td>"+
                        "<td>"+
                            "<input type='text' name='NAMA_NILAI[]' class='form-control' style='width:100%'>"+
                        "</td>"+
                        "<td>"+
                            "<select class='form-control' name='STATUS[]'>"+
                                "<option value=''> -- Pilih Status -- </option>"+
                                "<option value='1'>PASSED</option>"+
                                "<option value='2'>NOT PASSED</option>"+
                            "</select'>"+
                        "</td>"+
                        "<td style='text-align:center;width:10%'>"+(i+1)+"</td>"+
                    "</tr>"
                );
            }
        } 
    });

    $('#ID_VERSION').change(function(){
        var ID_VERSION = $('#ID_VERSION').val();

        if(ID_VERSION == '') {
            $('#bbm').val('');
            $('#ditetapkan').val('');
            $('#tgl_version').val('');
        } else {
            var vlink_url = '<?php echo base_url()?>master/coq/get_detail_version/';
            $.ajax({
                url: vlink_url,
                type: "POST",
                data : {
                    id : ID_VERSION,
                },
                beforeSend: function(data) {
                    bootbox.modal('<div class="loading-progress"></div>');
                },
                error:function(data){
                    bootbox.hideAll();
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengambilan data gagal-- </div>', function() {});
                },
                success:function(data) {
                    bootbox.hideAll();
                    var obj = JSON.parse(data);
                    $('#bbm').val(obj[0].NAMA_BBM);
                    $('#ditetapkan').val(obj[0].DITETAPKAN);
                    $('#tgl_version').val(obj[0].TGL_VERSION);
                    $('#ID_JNS_BHN_BKR').val(obj[0].ID_JNS_BHN_BKR);
                    $('#KODE_JNS_BHN_BKR').val(obj[0].KODE_JNS_BHN_BKR);
                    
                }
            });
        }
        

    })


</script>