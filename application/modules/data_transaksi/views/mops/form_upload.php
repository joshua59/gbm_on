
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
            <!-- <div class="control-group">
                <label class="control-label">Download Template<span class="required">*</span> :</label>
                <div class="controls">
                    <button type="button" class="btn"><i class="icon-download"></i>Download</button>
                </div>
            </div> -->
            <br>
            <div class="control-group">
                <label class="control-label">Upload<span class="required">*</span> :</label>
                <div class="controls">
                    <input type="file" class="form-control" name="excel">
                </div>
            </div>  
            <br>
            
            <label>&nbsp;&nbsp;)* Pastikan data yang akan diupload sudah sesuai dengan template xls MOPS yang telah disediakan.</label>
            <label  id="download_xls" title="Klik untuk download template MOPS">&nbsp;&nbsp;)* Download template xls MOPS <i><u>disini.</u></i></label>
            
            <div class="form-actions">
                <?php echo anchor(null, '<i class="icon-upload"></i> Upload', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
            </div>

        <?php echo form_close(); ?>
        <hr>
    </div>
</div>

<script type="text/javascript">
    $('#download_xls').click(function() {
        bootbox.confirm('Apakah yakin akan download template xls MOPS ?', "Tidak", "Ya", function(e) {
            if(e){
                var url = "<?php echo base_url() ?>assets/upload/mops/MOPS_template_NEW.xlsx";
                window.location.href = url;
            }
        });
    });
</script> 