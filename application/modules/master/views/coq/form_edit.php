<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
            echo form_open_multipart($form_action, array('id' => 'input', 'class' => 'form-horizontal'), $hidden_form);
        ?>  
        <div class="control-group">
            <label for="password" class="control-label">Parameter COQ <span class="required">*</span> : </label>
            <div class="controls">
                 <?php echo form_dropdown('PRMETER_MCOQ', $PRMETER_MCOQ, !empty($default->PRMETER_MCOQ) ? $default->PRMETER_MCOQ : '', 'id="PRMETER_MCOQ" style="width: 30%"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Satuan <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('SATUAN', $options_satuan, !empty($default->SATUAN) ? $default->SATUAN : ''); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Metode Uji <span class="required">*</span> : </label>
            <div class="controls">
                 <?php echo form_input('METODE', !empty($default->METODE) ? $default->METODE : '', 'class="form-control" id="METODE" maxlength="50"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Batas Min <span class="required">*</span> : </label>
            <div class="controls">
                 <?php echo form_input('MIN', !empty(number_format($default->BATAS_MIN)) ? number_format($default->BATAS_MIN,3,',','.') : '', 'class="form-control" id="MIN" maxlength="50" onchange="change_valuemin(this.value)"'); ?>
                 <input type="hidden" name="BATAS_MIN" id="BATAS_MIN" value="<?php echo !empty($default->BATAS_MIN) ? $default->BATAS_MIN : '' ?>">
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Batas Max <span class="required">*</span> : </label>
            <div class="controls">
                 <?php echo form_input('MAX', !empty($default->BATAS_MAX) ? number_format($default->BATAS_MAX,3,',','.') : '', 'class="form-control" id="MAX" maxlength="50" onchange="change_valuemax(this.value)"'); ?>
                 <br>
                 <input type="hidden" name="BATAS_MAX" id="BATAS_MAX" value="<?php echo !empty($default->BATAS_MAX) ? $default->BATAS_MAX : '' ?>">
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="blue btn"><i class="icon-save"></i> Simpan</button>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'filter();')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">
$("#input").validate({
  ignore: ':hidden:not(select)',
  errorPlacement: function(error, element) {
    if (element.is(":hidden")) {
      element.next().parent().append(error);
    }
    else {
      error.insertAfter(element);
    }
  },
  submitHandler: function(form) {
    bootbox.confirm('Anda yakin akan mengubah entrian data ?', "Tidak", "Ya", function(e) {
      if (e) {
        $.ajax({
          type: 'POST',
          url: $("#input").attr('action'),
          data: $("#input").serialize(),
          beforeSend: function(data) {
            bootbox.modal('<div class="loading-progress"></div>');
          },
          error: function(data) {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses penyimpanan data gagal-- </div>', function() {});
          },
          success: function(data) {
            var obj = JSON.parse(data)
            if (obj[0] == true) {
              bootbox.alert('<div class="box-title" style="color:green;"><i class="icon-check"></i>&nbsp' + obj[2] + '</div>', function() {
                  filter();
              });
            }
            else {
              bootbox.hideAll();
              bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengubahan data gagal-- </div><br>' + obj[2], function() {});
            }
          }
        })
      }
    });
    return false;
  }
});

$('input[name=MIN]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 3,autoGroup: true,prefix: '',rightAlign: false, allowMinus: true, oncleared: function () { 
    self.Value(''); 
  }
});

$('input[name=MAX]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 3,autoGroup: true,prefix: '',rightAlign: false, allowMinus: true, oncleared: function () { 
    self.Value(''); 
  }
});

function replace2(value) {
  
  var newStr = value.replace('.', '');
  return newStr;
}

function replace(value) {
  var str1 = replace2(value);
  var newStr = str1.replace(/,/g, '.');
  return newStr;
}

function change_valuemin(nilai) {
    var n = replace(nilai);
    $('#BATAS_MIN').val(n);
}

function change_valuemax(nilai) {
    var n = replace(nilai);
    $('#BATAS_MAX').val(n);
}
</script>