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
            <label for="password" class="control-label">Nama Versi <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NAMA_VERSI', !empty($default->NAMA_VERSI) ? $default->NAMA_VERSI : '', 'class="span6"'); ?>
            </div>
        </div> 
        <div class="control-group">
            <label for="password" class="control-label">Deskripsi<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('KET', !empty($default->KET) ? $default->KET : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">PIC <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('PIC', !empty($default->PIC) ? $default->PIC : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">TANGGAL <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TANGGAL', !empty($default->TANGGAL) ? $default->TANGGAL : '', 'class="span6 form_datetime"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Aktif : </label>
            <div class="controls">
            <?php echo form_checkbox('IS_AKTIF', '1', !empty($default->IS_AKTIF) ? $default->IS_AKTIF : '' ); ?>
            </div>
        </div>    
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>

<script type="text/javascript">

    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
</script>