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
            <label for="password" class="control-label">Nama Parameter <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('PARAMETER_ANALISA', !(empty($default->PARAMETER_ANALISA)) ? $default->PARAMETER_ANALISA : '', ' id="PARAMETER_ANALISA"'); ?>
            </div>
        </div>
        
        <div class="control-group">
          <label for="password" class="control-label">Tipe <span class="required">*</span> : </label>
          <div class="controls">
              <select class="form-control" name="TIPE">
                <?php if($default->TIPE == 1) { ?>
                  <option value="1" selected>Input</option>
                  <option value="2">Pilihan</option>
                <?php } else { ?>
                  <option value="1">Input</option>
                  <option value="2" selected>Pilihan</option>
                <?php }?>                  
              </select>
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
</script>