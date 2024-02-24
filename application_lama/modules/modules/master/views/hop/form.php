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
            <label for="password" class="control-label">Dasar HOP : </label>
            <div class="controls">
                <?php echo form_input('BASIC_HOP', !empty($default->BASIC_HOP) ? $default->BASIC_HOP : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Warna Logo Merah <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('FROM_DAY_RED', !empty($default->FROM_DAY_RED) ? $default->FROM_DAY_RED : '', 'class="span3"'); ?>
                <!-- <?php echo form_dropdown('PARAM_RED', $reg_param, !empty($default->PARAM_RED) ? $default->PARAM_RED : '', 'class="span3"'); ?>
                <?php echo form_input('TO_DAY_RED', !empty($default->TO_DAY_RED) ? $default->TO_DAY_RED : '', 'class="span1"'); ?> -->
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Warna Logo Kuning <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('FROM_DAY_YELLOW', !empty($default->FROM_DAY_YELLOW) ? $default->FROM_DAY_YELLOW : '', 'class="span3"'); ?>
                <!-- <?php echo form_dropdown('PARAM_YELLOW', $reg_param, !empty($default->PARAM_YELLOW) ? $default->PARAM_YELLOW : '', 'class="span3"'); ?>
                <?php echo form_input('TO_DAY_YELLOW', !empty($default->TO_DAY_YELLOW) ? $default->TO_DAY_YELLOW : '', 'class="span1"'); ?> -->
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Warna Logo Hijau <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('FROM_DAY_GREEN', !empty($default->FROM_DAY_GREEN) ? $default->FROM_DAY_GREEN : '', 'class="span3"'); ?>
                <!-- <?php echo form_dropdown('PARAM_GREEN', $reg_param, !empty($default->PARAM_GREEN) ? $default->PARAM_GREEN : '', 'class="span3"'); ?>
                <?php echo form_input('TO_DAY_GREEN', !empty($default->TO_DAY_GREEN) ? $default->TO_DAY_GREEN : '', 'class="span1"'); ?> -->
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Warna Logo Biru <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('FROM_DAY_BLUE', !empty($default->FROM_DAY_BLUE) ? $default->FROM_DAY_BLUE : '', 'class="span3"'); ?>
                <!-- <?php echo form_dropdown('PARAM_BLUE', $reg_param, !empty($default->PARAM_BLUE) ? $default->PARAM_BLUE : '', 'class="span3"'); ?>
                <?php echo form_input('TO_DAY_BLUE', !empty($default->TO_DAY_BLUE) ? $default->TO_DAY_BLUE : '', 'class="span1"'); ?> -->
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Mulai Berlaku<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('EFFECTIVE_DATE', !empty($default->EFFECTIVE_DATE) ? $default->EFFECTIVE_DATE : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal" id="EFFECTIVE_DATE"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Keterangan <span class="required">*</span> : </label>
            <div class="controls">
                <?php
                    $data = array(
                      'name'        => 'DESCRIPTION',
                      'id'          => 'DESCRIPTION',
                      'value'       => !empty($default->DESCRIPTION) ? $default->DESCRIPTION : '',
                      'rows'        => '10',
                      'cols'        => '10',
                      'class'       => 'span11',
                      'style'       => '"none" placeholder="Ketik Keterangan MAX:40 Character"',
                    );
                  echo form_textarea($data);
                ?>
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
    $(document).ready(function() {
        $('#EFFECTIVE_DATE').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>