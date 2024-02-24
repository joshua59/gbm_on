
<!-- /**
 * @module TRANSAKSI PERHITUNGAN BBM
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 17 OKTOBER 2017
 */ -->
<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>
            <!--perhitungan Start -->
                
                    <div class="control-group">
                        <label class="control-label">Tanggal<span class="required">*</span> :</label>
                        <div class="controls">
                            <?php echo form_input('TGL_MOPS',!empty($default->TGL_MOPS) ? $default->TGL_MOPS : '', 'class="form_datetime span4" placeholder="Pilih Tanggal" id="tanggal"'); ?>
                        </div>
                    </div>
                   
                    <div class="control-group">
                        <label for="password" class="control-label">HSD<span class="required">*</span> : </label>
                        
                        <div class="controls">
                            <?php echo form_input('LOWHSD_MOPS', !empty($default->LOWHSD_MOPS) ? $default->LOWHSD_MOPS : '', 'class="form-control rp" style="width: 115px;" placeholder="Low" id="lowhsd"'); ?>
                            
                            <?php echo form_input('MIDHSD_MOPS', !empty($default->MIDHSD_MOPS) ? $default->MIDHSD_MOPS : '', 'class="form-control rp" style="width: 115px;" placeholder="Mid" id="midhsd"'); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="password" class="control-label">MFO HSFO<span class="required">*</span> : </label>
                        
                        <div class="controls">
                            <?php echo form_input('LOWMFO_MOPS', !empty($default->LOWMFO_MOPS) ? $default->LOWMFO_MOPS : '', 'class="form-control rp" style="width: 115px;" placeholder="Low" id="lowmfohsfo"'); ?>
                            
                            <?php echo form_input('MIDMFO_MOPS', !empty($default->MIDMFO_MOPS) ? $default->MIDMFO_MOPS : '', 'class="form-control rp" style="width: 115px;" placeholder="Mid" id="midmfohsfo"'); ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="password" class="control-label">MFO LSFO<span class="required">*</span> : </label>
                        
                        <div class="controls">
                            <?php echo form_input('LOWMFOLSFO_MOPS', !empty($default->LOWMFOLSFO_MOPS) ? $default->LOWMFOLSFO_MOPS : '', 'class="form-control rp" style="width: 115px;" placeholder="Low" id="lowmfolsfo"'); ?>
                            
                            <?php echo form_input('MIDMFOLSFO_MOPS', !empty($default->MIDMFOLSFO_MOPS) ? $default->MIDMFOLSFO_MOPS : '', 'class="form-control rp" style="width: 115px;" placeholder="Mid" id="midmfolsfo"'); ?>
                        </div>
                    </div>

                    <div class="form-actions">
                        <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
                        <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
                    </div>

    
            <!-- perhitungan End -->
        <?php echo form_close(); ?>
        <hr>
      
       
    </div>
</div>

<script type="text/javascript">
    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    $('.rp').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });
</script> 