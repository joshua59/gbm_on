<div class="box-content" id="divAtas">
    <?php
$hidden_form = array('id' => !empty($id) ? $id : '');
echo form_open_multipart($form_action, array('id' => 'input', 'class' => 'form-horizontal'), $hidden_form);
?>
    <div class="control-group">
        <label for="password" class="control-label">Level 1 <span class="required">*</span> : </label>
        <div class="controls">
            <?php echo form_dropdown('COCODE', $lvl1options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6 chosen"'); ?>
        </div>
    </div>
    
    <div class="control-group">
        <label for="password" class="control-label">Tahun (RKAP) <span class="required">*</span> : </label>
        <div class="controls">
            <?php echo form_dropdown('SKEMA_PENYERAPAN', $skema_options, !empty($default->SKEMA_PENYERAPAN) ? $default->SKEMA_PENYERAPAN : '', 'class="span3" id="SKEMA_PENYERAPAN"'); ?>
        </div>
    </div>

    <div class="control-group">
        <label for="password" class="control-label">Asumsi Perhitungan BIO <span class="required">*</span> : </label>
        <div class="controls">
            <?php echo form_dropdown('PERHITUNGAN_BIO', $perhitungan_bio, !empty($default->PERHITUNGAN_BIO) ? $default->PERHITUNGAN_BIO : '', 'class="span3" id="PERHITUNGAN_BIO"'); ?>
        </div>
    </div>

    <div class="control-group">
        <label for="password" class="control-label">Volume HSD (L) <span class="required">*</span> : </label>
        <div class="controls">
            <input type="text" name="VOLUMEHSD" id="VOLUMEHSD" autocomplete="off" value="0" min="0" class='num'>
        </div>
    </div>

    <div class="control-group">
        <label for="password" class="control-label">Volume BIO (FAME) (L) <span class="required">*</span> : </label>
        <div class="controls">
            <input type="text" name="VOLUMEBIO" id="VOLUMEBIO" autocomplete="off" value="0" min="0" class='num'>
        </div>
    </div>

    <div class="control-group">
        <label for="password" class="control-label">Volume IDO (L) <span class="required">*</span> : </label>
        <div class="controls">
            <input type="text" name="VOLUMEIDO" id="VOLUMEIDO" autocomplete="off" value="0" min="0" class='num'>
        </div>
    </div>

    <div class="control-group">
        <label for="password" class="control-label">Volume MFO (L) <span class="required">*</span> : </label>
        <div class="controls">
            <input type="text" name="VOLUMEMFO" id="VOLUMEMFO" autocomplete="off" value="0" min="0" class='num'>
        </div>
    </div>

    <div class="form-actions">
        <button class="blue btn" type="submit"><i class="icon-save"></i> Simpan</button>
        <!-- <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#input', '#button-back')")); ?> -->
        <?php echo anchor(null, '<i class="icon-refresh"></i> Reset', array('id' => 'button-back', 'class' => 'green btn', 'onclick' => 'reset();')); ?>
    </div>
    <?php echo form_close(); ?>
</div>
<div class="well-content clearfix">
    <div id="divTable">

    </div>
</div>
<script type="text/javascript">

    $(document).ready(function(){   
        $('.chosen').chosen({
          placeholder_text_single: "-- Pilih Level 1 --",
          no_results_text: "Oops, nothing found!"
        });
        load_divTable();
        var d = new Date();
        var year = d.getFullYear();
        $('#SKEMA_PENYERAPAN').val(year);

        $('input[name=VOLUMEMFO]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });
        $('input[name=VOLUMEIDO]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });
        $('input[name=VOLUMEBIO]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });
        $('input[name=VOLUMEHSD]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });

    })

    function reset() {
        bootbox.confirm('Anda yakin akan mereset entrian data ?', "Tidak", "Ya", function(e) {
            if(e){
                add();
                $('html, body').animate({scrollTop: $("#divAtas").offset().top}, 1000);
            }
        });
    }

    $("#input").validate({
        ignore: ':hidden:not(select)',
        errorPlacement: function (error, element) {
            if (element.is(":hidden")) {
                element.next().parent().append(error);
            } else {
                error.insertAfter(element);
            }
        },
        rules: {
            COCODE : "required",
            PERHITUNGAN_BIO : "required",
            SKEMA_PENYERAPAN : "required"            
        },
        messages: {
            COCODE: "<b style='color:red'>Nilai tidak boleh kosong</b>",
            PERHITUNGAN_BIO: "<b style='color:red'>Nilai tidak boleh kosong</b>",
            SKEMA_PENYERAPAN : "<b style='color:red'>Nilai tidak boleh kosong</b>"
        },
        submitHandler: function(form) {
            bootbox.confirm('Anda yakin akan menambah entrian data ?', "Tidak", "Ya", function(e) {
                if(e){
                    $.ajax({
                      type: 'POST',
                      url: $("#input").attr('action'),
                      data: $("#input").serialize(),

                      beforeSend:function(data){
                            bootbox.modal('<div class="loading-progress"></div>');
                      },
                      error: function(data) {
                            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses penyimpanan data gagal-- </div>', function() {});
                      },

                      success: function(data) {
                        var obj = JSON.parse(data)
                        if(obj[0] == true) {
                            bootbox.alert('<div class="box-title" style="color:green;"><i class="icon-check"></i>&nbsp'+obj[2]+'</div>', function() {
                                add();
                                load_divTable();
                            });
                            
                        } else {
                            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses penyimpanan data gagal-- </div><div>'+obj[2]+'</div>', function() {
                                bootbox.hideAll();
                            });

                        }
                      }
                    })
                }
            });
        return false;
        }
    });

    function load_divTable() {

        $.ajax({
            url : "<?php echo base_url('master/penyerapan_bbm/load_divTable'); ?>",
            type: 'POST',
            data: '',
            beforeSend:function(response) {

                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(response) {

                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak ditemukan-- </div>', function() {});
            },
            success:function(response){
                bootbox.hideAll();
                $('#divTable').html(response);
            }
        });
    }


</script>