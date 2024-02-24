
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
            <label for="password" class="control-label">Jumlah Nilai <span class="required"> *</span> : </label>
            <div class="controls">
                <input type="number" id="JML_PARAMETER" style="width: 150px%">
                <?php echo anchor(null, 'Generate', array('id' => 'button-jml-parameter', 'class' => 'green btn')); ?>
            </div>
        </div>

        <div id="div_tbl">
            <table class="table table-bordered" id="table">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Nama Nilai</th>
                        <th rowspan="2">Status</th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
   
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan(this.id, '#finput', '#button-back');")); ?>
        </div>
    </div>
    
    <?php echo form_close(); ?>
</div> 


<script type="text/javascript">

    $('#div_tbl').hide();

    $('#JML_PARAMETER').inputmask('Regex', { regex: "^[1-9][0-9]?$|^10$"});
    
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
                                        view_detail('<?php echo $id ?>');
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
                            "<select class='form-control' name='STATUS[]' style='width:100%'>"+
                                "<option value=''> -- Pilih Status -- </option>"+
                                "<option value='1'>PASSED</option>"+
                                "<option value='2'>NOT PASSED</option>"+
                            "</select'>"+
                        "</td>"+
                    "</tr>"
                );
            }
        } 
    });
</script>