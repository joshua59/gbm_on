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
            <label for="password" class="control-label">Jenis Bahan Bakar<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_JNS_BHN_BKR', $options_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'id="bbm"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nomor Version : </label>
            <div class="controls">
                <?php echo form_input('NO_VERSION', !empty($default->NO_VERSION) ? $default->NO_VERSION : '', 'class="span3" id="NO_VERSION" placeholder="Masukkan Nomor Version" autocomplete="off" maxlength="50"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Tgl Versioning <span class="required">*</span> : </label>
            <div class="controls">
            <?php echo form_input('TGL_VERSION', !empty($default->TGL_VERSION) ? $default->TGL_VERSION : '', 'class="span3 datepicker" id="TGL_VERSION" placeholder="Pilih Tanggal" autocomplete="off"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Ditetapkan oleh <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('DITETAPKAN', !empty($default->DITETAPKAN) ? $default->DITETAPKAN : '', 'class="span3" id="DITETAPKAN" placeholder="Masukkan Ditetapkan oleh" autocomplete="off" maxlength="50"'); ?>
            </div>
        </div> 
        <div class="control-group">
            <label for="password" class="control-label">Pejabat Terkait<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('PIC', !empty($default->PIC) ? $default->PIC : '', 'class="span3" id="PIC" placeholder="Pilih Pejabat" autocomplete="off" maxlength="50"'); ?>
            </div>
        </div> 
        <div class="control-group">
            <label for="password" class="control-label">Status Aktif  : </label>
                <div class="controls">
                    <?php echo form_checkbox('STATUS', '1',!empty($default->STATUS) ? $default->STATUS : '', 'class ="STATUS"' ); ?>  
                </div>
        </div>       
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan(this.id, '#finput', '#button-back');")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_modal();')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {

        $(".datepicker").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left",
            beforeShow: function(i) { if ($(i).attr('readonly')) { return false; } }
        });

        $('#NO_VERSION').on('input propertychange paste', function(){        
            var str = this.value;
            str = str.replace(/\"/g,'');
            str = str.replace(/\'/g,'');
            str = str.replace(/\\/g,'');
            str = str.replace(/\[/g,'');
            str = str.replace(/\]/g,'');
            this.value = str;
          
        });

        $('#DITETAPKAN').on('input propertychange paste', function(){        
            var str = this.value;
            str = str.replace(/\"/g,'');
            str = str.replace(/\'/g,'');
            str = str.replace(/\\/g,'');
            str = str.replace(/\[/g,'');
            str = str.replace(/\]/g,'');
            this.value = str;
          
        });

        $('#PIC').on('input propertychange paste', function(){        
            var str = this.value;
            str = str.replace(/\"/g,'');
            str = str.replace(/\'/g,'');
            str = str.replace(/\\/g,'');
            str = str.replace(/\[/g,'');
            str = str.replace(/\]/g,'');
            this.value = str;
          
        });
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

        $('select[name="ID_REGIONAL"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>master/master_level4/get_options_lv1/'+stateID;
            setDefaultLv1();
            setDefaultLv2();
            setDefaultLv3();
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
            var vlink_url = '<?php echo base_url()?>master/master_level4/get_options_lv2/'+stateID;
            setDefaultLv2();
            setDefaultLv3();
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
            var vlink_url = '<?php echo base_url()?>master/master_level4/get_options_lv3/'+stateID;
            setDefaultLv3();
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

        if ($('input[name="STATUS_LVL4"]:checked').serialize()) {
            $('#lv2').hide();
            $('#lv3').hide();            
        } 

        $('input[name="STATUS_LVL4"]').change(function() {
            if(this.checked) {
                $('#lv2').hide();
                $('#lv3').hide();
            } else {
                $('#lv2').show();
                $('#lv3').show();            
            }      
        });
    });

    function close_modal() {
        $('.modal').modal('hide');
    }

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
                        console.log(res[0])
                        if(res[0] == true) {
                            bootbox.alert(message, function() {
                                table_load();
                                close_modal();
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

</script>