<div class="box-content" id="divAtas">
    <?php
$hidden_form = array('id' => !empty($id) ? $id : '');
echo form_open_multipart($form_action, array('id' => 'input', 'class' => 'form-horizontal'), $hidden_form);
?>

    <div class="control-group">
        <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
        <div class="controls">
            <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6 chosen" onchange="get_level1_options(this.value)" id="ID_REGIONAL" disabled'); ?>
        </div>
    </div>
    <div class="control-group">
        <label for="password" class="control-label">Level 1 <span class="required">*</span> : </label>
        <div class="controls">
            <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6 chosen" disabled'); ?>
        </div>
    </div>
   

     <div class="control-group">
        <label for="password" class="control-label">Skema Penyerapan <span class="required">*</span> : </label>
        <div class="controls">
             <?php echo form_dropdown('SKEMA_PENYERAPAN', $skema_options, !empty($default->SKEMA_PENYERAPAN) ? $default->SKEMA_PENYERAPAN : '', 'class="span3 chosen" id="SKEMA_PENYERAPAN" disabled'); ?>
        </div>
    </div>

    <?php foreach ($bbm as $value) { ?>
        <div class="control-group">
            <label for="password" class="control-label">Volume <?php echo $value['NAMA_JNS_BHN_BKR'] ?><span class="required">*</span> : </label>
            <div class="controls">
            <?php 
            if($value['NAMA_JNS_BHN_BKR'] == 'HSD+BIO') {
                $val = "VOLUMEHSDBIO";
            } else {
                $val = "VOLUME".$value['NAMA_JNS_BHN_BKR'];
            } ?>
                <input type="text" name="VOLUME<?php echo $value['ID_JNS_BHN_BKR'] ?>" id="VOLUME" autocomplete="off" value="<?php echo $default->$val ?>" disabled style="font-weight: bold">
            </div>
        </div>
    <?php } ?> 

    <?php foreach ($komp_bbm as $value) { ?>
        <div class="control-group">
            <label for="password" class="control-label">Volume <?php echo $value['NAMA_JNS_BHN_BKR'] ?><span class="required">*</span> : </label>
            <div class="controls">
                <?php $val = "VOLUME".$value['NAMA_JNS_BHN_BKR']; ?>

                <input type="text" name="VOLUME<?php echo $value['KODE_JNS_BHN_BKR'] ?>" id="VOLUME" autocomplete="off" value="<?php echo $default->$val ?>" disabled style="font-weight: bold">
            </div>
        </div>
    <?php } ?>            
         
    <div class="form-actions">
        <?php echo anchor(null, '<i class="icon-arrow-left"></i> Kembali', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'loadFilter();loadTable()')); ?>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">

    $(document).ready(function(){   

         $('input[name=VOLUME001]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });
        $('input[name=VOLUME002]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });
        $('input[name=VOLUME004]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });
        $('input[name=VOLUME005]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });
        $('input[name=VOLUME301]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });
        $('input[name=VOLUME302]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });
        $('input[name=VOLUME303]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
        });
    })

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
            ID_REGIONAL : "required",
            COCODE : "required",
            SKEMA_PENYERAPAN : "required",
            VOLUME001 : "required",
            VOLUME002 : "required",
            VOLUME004 : "required",
            VOLUME005 : "required",
            VOLUME301 : "required",
            VOLUME302 : "required",
            VOLUME303 : "required"
        },
        messages: {
            ID_REGIONAL: "*",
            COCODE: "*",
            SKEMA_PENYERAPAN : "*",
            VOLUME001 : "required",
            VOLUME002 : "required",
            VOLUME004 : "required",
            VOLUME005 : "required",
            VOLUME301 : "required",
            VOLUME302 : "required",
            VOLUME303 : "required"
        },
        submitHandler: function(form) {
            bootbox.confirm('Anda yakin akan mengubah entrian data ?', "Tidak", "Ya", function(e) {
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
                                if(<?php echo $default->FLAG ?> == 0) {
                                    add();
                                    load_divTable();
                                } else {
                                    loadTable();
                                    loadFilter();
                                }
                                
                            });
                            
                        } else {
                            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengubahan data gagal-- </div>', function() {});
                        }
                      }
                    })
                }
            });
        return false;
        }
    });

</script>