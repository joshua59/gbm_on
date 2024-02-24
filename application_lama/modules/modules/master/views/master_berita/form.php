<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>   
        <div class="control-group" hidden>
            <label for="password" class="control-label">Jeda : </label>
            <div class="controls">
                <?php echo form_input('JEDA', !empty($default->JEDA) ? $default->JEDA : '', 'class="span2"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Keterangan <span class="required">*</span> : </label>
            <div class="controls">
                <?php
                    $data = array(
                      'name'        => 'KETERANGAN',
                      'id'          => 'KETERANGAN',
                      'value'       => !empty($default->KETERANGAN) ? $default->KETERANGAN : '',
                      'rows'        => '10',
                      'cols'        => '10',
                      'class'       => 'span11',
                      'style'       => '"none" placeholder="Ketik Keterangan"'
                    );
                  echo form_textarea($data);
                ?>
            </div>

        </div> 
        <div class="control-group">
            <label for="password" class="control-label">Urutan ke <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('URUTAN', !empty($default->URUTAN) ? $default->URUTAN : '1', 'class="span1"'); ?>
            </div>
        </div> 
        <div class="control-group">
            <label for="password" class="control-label">Posting : </label>
            <div class="controls">
            <?php echo form_checkbox('POSTING', '1', !empty($default->POSTING) ? $default->POSTING : '' ); ?>
            </div>
        </div>    
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>