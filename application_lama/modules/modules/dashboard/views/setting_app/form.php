<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action_faq, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>  
        <div class="control-group">
            <label for="password" class="control-label">Pertanyaan <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('JUDUL', !empty($default->JUDUL) ? $default->JUDUL : '', 'class="span10" placeholder="Isi Pertanyaan"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Jawaban <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_textarea('KETERANGAN', !empty($default->KETERANGAN) ? $default->KETERANGAN : '', 'class="span10" placeholder="Isi Jawaban"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Urutan ke <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('URUTAN', !empty($default->URUTAN) ? $default->URUTAN : '1', 'class="span1"'); ?>
            </div>
        </div>    
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>