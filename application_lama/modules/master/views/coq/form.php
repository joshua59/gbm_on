<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
            echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>  
        <div class="control-group">
            <label for="password" class="control-label">Nomor Version : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_VERSION', $VERSION, !empty($default->SATUAN) ? $default->SATUAN : '', 'id="ID_VERSION"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Ditetapkan Oleh : </label>
            <div class="controls">
                <?php echo form_input('', '', 'readonly id="ditetapkan"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Tanggal Referensi : </label>
            <div class="controls">
                <?php echo form_input('', '', 'readonly id="tgl_version"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Jenis Bahan Bakar : </label>
            <div class="controls">
                <?php echo form_input('', '', 'readonly id="bbm"'); ?>
                <input type="hidden" name="ID_JNS_BHN_BKR" id="ID_JNS_BHN_BKR">
                <input type="hidden" name="KODE_JNS_BHN_BKR" id="KODE_JNS_BHN_BKR">
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Jumlah Parameter <span class="required"> *</span> : </label>
            <div class="controls">
                <?php echo form_input('JML_PARAMETER', !empty($default->JML_PARAMETER) ? $default->JML_PARAMETER : '', 'class="span2", id="JML_PARAMETER", placeholder="Max 30"'); ?>
                <?php echo anchor(null, 'Generate', array('id' => 'button-jml-parameter', 'class' => 'green btn')); ?>
            </div>
        </div>

        <div id="div_table" hidden>
            <table class="table">
                 <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">Parameter</th>
                        <th rowspan="2">Satuan</th>
                        <th rowspan="2">Metode Uji</th>
                        <th colspan="2">Batasan SNI</th>
                    </tr>
                    <tr>
                        <th>Min</th>
                        <th>Max</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    
                </tbody>
            </table>
        </div>
        
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan(this.id, '#finput', '#button-back');")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'filter();')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
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

    function simpan(button, form, disable, content) {
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

    $("#button-jml-parameter").click(function(){
        $('#div_table').hide();
        var x = $('#JML_PARAMETER').val(); 

        if(x > 30){
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Max 30 data jumlah pengiriman yang diperbolehkan</div>';
            bootbox.alert(message, function() {});
            $('#JML_PARAMETER').val('30');
        } else {
            $('#div_table').show();
            $('#tbody').html('');
            var x = $('#JML_PARAMETER').val(); 
            for (var i = 0; i < x; i++) {

                $('#tbody').append(
                    "<tr>"+
                        "<td style='width:5%;text-align:center'>"+(i+1)+"</td>"+
                        "<td style='text-align:center;width:20%'>"+
                            "<select name='PRMETER_MCOQ[]' id='PRMETER_MCOQ"+i+"' class='form-control select2' style='width:100%' onchange='get_tipe("+i+")'>"+
                                "<option value=''> -- Pilih Parameter Analisa -- </option>"+
                                <?php foreach ($PRMETER_MCOQ as $value) : ?>
                                    "<option value='<?php echo $value['ID_PARAMETER']?>'> <?php echo $value['PARAMETER_ANALISA'] ?></option>"+

                                <?php endforeach; ?>
                            "</select>"+
                        "</td>"+
                        "<td style='text-align:center;width:10%'>"+
                            "<select name='SATUAN[]' class='form-control select2' style='width:100%'>"+
                            <?php foreach ($SATUAN as $value) : ?>
                                "<option value='<?php echo $value['VALUE_SETTING']?>'> <?php echo $value['NAME_SETTING'] ?></option>"+
                            <?php endforeach; ?>
                            "</select>"+
                        "</td>"+
                        "<td style='text-align:center;width:10%'>"+
                            "<input type='text' name='METODE[]' class='form-control' maxlength='50'>"+
                        "</td>"+
                        "<td style='width:10%;text-align:center;'>"+
                            "<input type='text' name='min"+i+"' id='min"+i+"' class='form-control'>"+
                        "</td>"+
                        "<td style='width:10%;text-align:center;'>"+
                            "<input type='text' name='max"+i+"' id='max"+i+"' class='form-control'>"+
                        "</td>"+
                    "</tr>"
                );
            }

            for (var l = 0; l < x; l++) {
                $('input[name=min'+l+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { 
                        self.Value(''); 
                    }
                });

                $('input[name=max'+l+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { 
                        self.Value(''); 
                    }
                });
            }

            $('.select2').select2({
                theme : "classic"
            });
        } 
    });

    function get_tipe(arr) {
        var id = $('#PRMETER_MCOQ'+arr).val();
    }

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