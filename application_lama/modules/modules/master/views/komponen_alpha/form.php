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
            <label for="password" class="control-label">No. Perjanjian <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NO_PERJANJIAN', !empty($default->NO_PERJANJIAN) ? $default->NO_PERJANJIAN : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nilai Konstanta MFO<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NILAI_KONSTANTA_MFO', !empty($default->NILAI_KONSTANTA_MFO) ? $default->NILAI_KONSTANTA_MFO : '', 'class="span6 rp"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nilai Konstanta HSD<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NILAI_KONSTANTA_HSD', !empty($default->NILAI_KONSTANTA_HSD) ? $default->NILAI_KONSTANTA_HSD : '', 'class="span6 rp"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Nilai Kali Mops <span class="required">*</span> : </label>
            <div class="controls">
                <!-- <?php //echo form_input('KOMP', !empty($default->KOMP) ? $default->KOMP : '', 'class="span1"'); ?> -->
                <?php echo form_input('FK_MOPS', !empty($default->FK_MOPS) ? $default->FK_MOPS : '', 'class="span6 rp"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Variabel Hitung <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('VARIABEL_HITUNG', !empty($default->VARIABEL_HITUNG) ? $default->VARIABEL_HITUNG : '', 'class="span6 rp"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Persentase Hitung<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('PERSEN_HITUNG', !empty($default->PERSEN_HITUNG) ? $default->PERSEN_HITUNG : '', 'class="span2 rp_nol "'); ?> %
            </div>
        </div>
         
         <div class="control-group">
            <label for="password" class="control-label">Tanggal Awal : <span class="required">*</span></label> 
            <div class="controls">
                <?php echo form_input('TGL_AWAL', !empty($default->TGL_AWAL) ? $default->TGL_AWAL : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Tanggal Akhir : <span class="required">*</span></label> 
            <div class="controls">
                <?php echo form_input('TGL_AKHIR', !empty($default->TGL_AKHIR) ? $default->TGL_AKHIR : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal"'); ?>
            </div>
        </div>
        <div class="control-group" hidden>
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

    $('.rp').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 7,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    $('.rp_nol').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 0,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });
</script>