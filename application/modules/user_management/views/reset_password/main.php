<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/library/jquery.validate.js" type="text/javascript"></script>
<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span6">
                <div id="index-content" class="well-content no-search">                    
                    <div class="well">
                        <div class="well-content clearfix">
                            <?php
                            $hidden_form = array('id' => '');
                            echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), array('id' => 'ffilter'),$hidden_form);
                            ?>
                            <div class="control-group">
                                <label for="password" class="control-label">Username <span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('USERNAME', '','class="input" autocomplete="off" id="USERNAME"'); ?>
                                    &nbsp;
                                    <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Nama : </label>
                                <div class="controls">
                                    <?php echo form_input('NAMA','','class="input" autocomplete="off" id="nama" readonly style="color:black;"'); ?>
                                </div>
                            </div> 
                            <div class="control-group">
                                <label for="password" class="control-label">Kode User : </label>
                                <div class="controls">
                                    <?php echo form_input('kduser','','class="input" autocomplete="off" id="kode_user" readonly style="color:black;"'); ?>
                                </div>
                            </div> 
                            <div class="control-group">
                                <label for="password" class="control-label">Email : </label>
                                <div class="controls">
                                    <?php echo form_input('email','','class="input" autocomplete="off" id="email" readonly style="color:black;"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Role : </label>
                                <div class="controls">
                                    <?php echo form_input('role','','class="input" autocomplete="off" id="role" readonly style="color:black;"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Regional : </label>
                                <div class="controls">
                                    <?php echo form_input('regional','','class="input" autocomplete="off" id="regional" readonly style="color:black;"'); ?>
                                </div>
                            </div>
                            <div class="control-group" id="1">
                                <label for="password" class="control-label">Level 1 : </label>
                                <div class="controls">
                                    <?php echo form_input('level1','','class="input" autocomplete="off" id="level1" readonly style="color:black;"'); ?>
                                </div>
                            </div>
                            <div class="control-group" id="2">
                                <label for="password" class="control-label">Level 2 : </label>
                                <div class="controls">
                                    <?php echo form_input('level2','','class="input" autocomplete="off" id="level2" readonly style="color:black;"'); ?>
                                </div>
                            </div>
                            <div class="control-group" id="3">
                                <label for="password" class="control-label">Level 3 : </label>
                                <div class="controls">
                                    <?php echo form_input('level3','','class="input" autocomplete="off" id="level3" readonly style="color:black;"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Nama Pemohon <span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('NAMA_PEMOHON','', 'class="input" autocomplete="off" id="nama_pemohon"'); ?>
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="password" class="control-label">Unit Pemohon <span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('UNIT_PEMOHON','','class="input" autocomplete="off" id="unit_pemohon"'); ?>
                                </div>
                            </div>
                            <div class="form-actions hide">
                                <?php echo anchor(null, ' Clear', array('id' => 'button-clear', 'class' => 'btn')); ?>
                                <?php echo anchor(null, '<i class="icon-save"></i> Reset Password', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_reset(this.id, '#finput', '#button-back')")); ?>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="widgets_area">
        <!-- <label for="" class="control-label"><span>(* NEW PASSWORD : icon123)</span></label> -->
        <h3>(* NEW PASSWORD : icon123)</h3>
    </div>

    <div class="widgets_area">
        <div id="content_table" data-source="<?php echo $data_sources; ?>" ></div>
    </div>
    <br>
    <br>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $('#button-filter').click(function(){
            find_user();
        });

        $('#button-clear').click(function(){
            $('#finput').trigger("reset");
            $('.form-actions').hide();
            $('#USERNAME').prop("readonly", false);
            $('#1').show();
            $('#2').show();
            $('#3').show();
        });
        
        load_table('#content_table', 1);
    });

    function simpan_reset(button, form, disable, content) {
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
            conf_message = 'Apakah Anda Yakin Untuk Mereset Password?';
        }

        bootbox.confirm(conf_message, "Tidak", "Ya", function(e) {
            if (e) {

                var disabled_list = disable.split('|');
                disabled_list.push('#' + button);
                disabled_html(disabled_list, true);

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
                        disabled_html(disabled_list, false);
                        bootbox.alert(message, function() {

                            if (isValidURL(content_id)) {
                                window.location = content_id;
                            } else {
                                if (typeof content_id !== 'undefined' && content_id !== '') {
                                    var patt = /^#/;

                                    if (patt.test(content_id)) {

                                        if (window.status_modal) {
                                            var form_content_id = window.form_content_modal;

                                            if (typeof content !== 'undefined')
                                                form_content_id = content;

                                            close_form_modal('', form_content_id);
                                        } else {
                                            close_form();
                                            //if (res[0]){
                                            //    window.location = source;
                                            //}
                                        }

                                        load_table(content_id, 1);
                                        $(form).trigger("reset");
                                        //untuk proses edit notif kirim
                                    } else {

                                        if (window.status_modal) {
                                            var form_content_id = window.form_content_modal;

                                            if (typeof content !== 'undefined')
                                                form_content_id = content;

                                            close_form_modal('', form_content_id);
                                        } else {
                                            close_form();
                                        }

                                        eval('(' + content_id + ')');
                                    }
                                }
                            }
                        });
                    }
                });
            }
        });
    }
}

    function find_user(){
        var cari      = $('#USERNAME').val();
        var vlink_url = '<?php echo base_url()?>user_management/reset_password/find_user/';
        $.ajax({
            url : vlink_url,
            type: 'POST',
            data: {
                p_cari : cari
            },
            beforeSend:function(response) {
                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(response) {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
            },
            success:function(response){
                var obj = JSON.parse(response);
                if (obj[0] == false) {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {
                        bootbox.hideAll();
                    });
                } 
                else if(obj[1].IS_LDAP == 1){
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Termasuk User LDAP-- </div>', function() {
                        bootbox.hideAll();
                    });
                    
                } else {
                    // console.log(obj[1].KODE_LEVEL)
                    $('#nama').val(obj[1].NAMA_USER);
                    $('#kode_user').val(obj[1].KD_USER);
                    $('#email').val(obj[1].EMAIL_USER);
                    $('#role').val(obj[1].ROLES_NAMA);

                    if(obj[1].LEVEL_USER == 'R') {
                        // console.log(obj[1].LEVEL_USER);
                        bootbox.hideAll();
                        $('#regional').val(obj[1].NAMA_REGIONAL);
                        $('#1').hide();
                        $('#2').hide();
                        $('#3').hide();
                    } else if(obj[1].LEVEL_USER == 1) {
                        // console.log(obj[1].LEVEL_USER);
                        bootbox.hideAll();
                        $('#regional').val(obj[1].NAMA_REGIONAL);
                        $('#level1').val(obj[1].LEVEL1);
                        $('#2').hide();
                        $('#3').hide();
                    } else if(obj[1].LEVEL_USER == 2) {
                        // console.log(obj[1].LEVEL_USER);
                        bootbox.hideAll();
                        $('#regional').val(obj[1].NAMA_REGIONAL);
                        $('#level1').val(obj[1].LEVEL1);
                        $('#level2').val(obj[1].LEVEL2);
                        $('#3').hide();
                    } else if(obj[1].LEVEL_USER == 3 || obj[1].LEVEL_USER == 0) {
                        // console.log(obj[1].LEVEL_USER);
                        bootbox.hideAll();
                        $('#regional').val(obj[1].NAMA_REGIONAL);
                        $('#level1').val(obj[1].LEVEL1);
                        $('#level2').val(obj[1].LEVEL2);
                        $('#level3').val(obj[1].LEVEL3);
                    }

                    $('.form-actions').show();
                    $('#USERNAME').prop("readonly", true);
                }               
            }
        });
    }
</script>