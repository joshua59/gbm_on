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
            <label for="password" class="control-label">TANGGAL KURS <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_KURS', !empty($default->TGL_KURS) ? $default->TGL_KURS : date('Y-m-d'), "class='span6' id='TGL_KURS'"); ?>
            </div>
        </div> 
        <div class="control-group">
            <label for="password" class="control-label">NOMINAL BELI <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NOMINAL', !empty($default->NOMINAL) ? $default->NOMINAL :'', 'class="span6"'); ?>
            </div>
        </div> 

        <div class="control-group">
            <label for="password" class="control-label">NOMINAL JUAL <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('JUAL', !empty($default->JUAL) ? $default->JUAL : '', 'class="span6"'); ?>
            </div>
        </div>   
        <div class="control-group">
            <label for="password" class="control-label">KURS <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('KTBI', !empty($default->KTBI) ? $default->KTBI : '', 'class="span6"'); ?>
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
    $(document).ready(function(){
        $('#TGL_KURS').datepicker({
            format: 'yyyy-mm-dd',
            autoclose : true
        })
    })
</script>