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
            <label for="password" class="control-label">Tanggal Awal <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('tgl_awal', !empty($default->tgl_awal) ? $default->tgl_awal : '', 'class="span6 datepicker"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Tanggal Akhir <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('tgl_akhir', !empty($default->tgl_akhir) ? $default->tgl_akhir : '', 'class="span6 datepicker"'); ?>
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
    jQuery(function($) {

        $(".datepicker").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left"
        });

        $('input[name="tgl_awal"]').change(function(){
            var dateStart = $(this).val();
            console.log(dateStart)
            $('input[name="tgl_akhir"]').datepicker('setStartDate', dateStart);
            if ($('input[name="tgl_akhir"]').val() == '') {

            } else{
               setCekTgl();
            }
        })

        function setCekTgl(){
            console.log('ok');
            var dateStart = $('input[name="tgl_awal"]').val();
            var dateEnd = $('input[name="tgl_akhir"]').val();

            if (dateEnd < dateStart){
                $('#tglakhir').datepicker('update', dateStart);
            }
        }
    });
</script>