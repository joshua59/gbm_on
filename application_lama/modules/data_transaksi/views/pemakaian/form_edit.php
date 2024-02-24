<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 10:51 PM
 */ ?>

<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>

<!--         <div class="control-group">
            <label class="control-label">No Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NO_PEMAKAIAN', !empty($default->NO_MUTASI_PEMAKAIAN) ? $default->NO_MUTASI_PEMAKAIAN : '', 'class="span6" placeholder="Ketik Nomor Pemakaian" disabled'); ?>
            </div>
        </div> -->
        <div class="control-group">
            <label class="control-label">Jenis Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('VALUE_SETTING', $option_jenis_pemakaian, !empty($default->JENIS_PEMAKAIAN) ? $default->JENIS_PEMAKAIAN : '', 'class="span3" id="JENIS_PEMAKAIAN"  disabled'); ?>
                <?php echo form_hidden('IS_TOLAK', !empty($default->IS_TOLAK) ? $default->IS_TOLAK : '', ''); ?>
            </div>
        </div>
        <div id="div_unit_terima" hidden>
            <div class="control-group">
                <label  class="control-label">Level 1 Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('COCODE_TERIMA', $lv1_options_all, !empty($lv1_options_all_def) ? $lv1_options_all_def : '', 'class="span6" id="COCODE_TERIMA" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 2 Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('PLANT_TERIMA', $lv2_options_all, !empty($default->PLANT_TERIMA) ? $default->PLANT_TERIMA : '', 'class="span6" id="PLANT_TERIMA" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 3 Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('STORE_SLOC_TERIMA', $lv3_options_all, !empty($default->STORE_SLOC_TERIMA) ? $default->STORE_SLOC_TERIMA : '', 'class="span6" id="STORE_SLOC_TERIMA" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Pembangkit Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('SLOC_TERIMA', $lv4_options_all, !empty($default->SLOC_TERIMA) ? $default->SLOC_TERIMA : '', 'class="span6" id="pembangkit_terima" id="SLOC_TERIMA" disabled'); ?>
                </div>
            </div>
        </div>           
        <div class="control-group">
            <label class="control-label">No Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NO_TUG', !empty($default->NO_TUG) ? $default->NO_TUG : '', 'class="span6" placeholder="Ketik No Pemakaian" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Catat Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_CATAT', !empty($default->TGL_PENCATATAN) ? $default->TGL_PENCATATAN : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Pengakuan<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_MUTASI_PENGAKUAN) ? $default->TGL_MUTASI_PENGAKUAN : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Regional <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'disabled class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Level 1<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'disabled class="span6"'); ?>
            </div>
        </div>
		<div class="control-group">
            <label  class="control-label">Level 2<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'disabled class="span6"'); ?>
            </div>
        </div>
		<div class="control-group">
            <label  class="control-label">Level 3<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'disabled class="span6"'); ?>
            </div>
        </div>
		<div class="control-group">
            <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'disabled class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" disabled'); ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Vol. Pemakaian (L)<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('VOL_PEMAKAIAN', !empty($default->VOLUME_PEMAKAIAN) ? $default->VOLUME_PEMAKAIAN : '', 'class="span3" placeholder="Ketik Volume Pemakaian" disabled'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Keterangan : </label>
            <div class="controls">                
                <?php
                    $data = array(
                      'name'        => 'KET_MUTASI_PEMAKAIAN',
                      'id'          => 'KET_MUTASI_PEMAKAIAN',
                      'value'       => !empty($default->KET_MUTASI_PEMAKAIAN) ? $default->KET_MUTASI_PEMAKAIAN : ' ',
                      'rows'        => '4',
                      'cols'        => '10',
                      'class'       => 'span6',
                      'style'       => '"none" placeholder="Ketik Keterangan Pemakaian" disabled="false"'
                    );
                  echo form_textarea($data);
                ?>
            </div>
        </div>
        <div id="divTolak" hidden>
            <hr>
            <div class="control-group">
                <label class="control-label">Keterangan Tolak<span class="required">*</span> : </label>
                <div class="controls">
                    <!-- <?php //echo form_input('KET_MUTASI_PEMAKAIAN', !empty($default->KET_MUTASI_PEMAKAIAN) ? $default->KET_MUTASI_PEMAKAIAN : '', 'class="span6" placeholder="Keterangan Tolak Pemakaian" '); ?> -->
                    <?php
                        $data = array(
                          'name'        => 'KET_BATAL',
                          'id'          => 'KET_BATAL',
                          'value'       => !empty($default->KET_BATAL) ? $default->KET_BATAL : '',
                          'rows'        => '4',
                          'cols'        => '10',
                          'class'       => 'span6',
                          'style'       => '"none" placeholder="Ketik Keterangan Tolak Pemakaian (Max 200)"'
                        );
                      echo form_textarea($data);
                    ?>
                    <?php echo form_hidden('STATUS_TOLAK', !empty($default->STATUS_TOLAK) ? $default->STATUS_TOLAK : '', 'class="span1" placeholder="Status Tolak Penerimaan" '); ?>   
                    <span class="required" id="MaxKet"></span>                 
                </div>
            </div>
        </div>
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
            <?php echo hgenerator::render_button_group($button_group); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
    <!-- perhitungan End -->
    <?php echo form_close(); ?>
    <br><br>
</div>

<script type="text/javascript">

    $('input[name=VOL_PEMAKAIAN]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    if ($('#button-tolak').length){
        $('#divTolak').show();    
    } else {
        var vstatus = $('input[name=STATUS_TOLAK]').val();
        if ((vstatus=='3') || (vstatus=='7')){
                $('#KET_BATAL').attr('disabled', true);
                $('#divTolak').show();         
        }
    }

    cek_status_tolak();
    function cek_status_tolak(){
        if ($('input[name=IS_TOLAK]').val()=='3'){
            if (typeof cek_notif !== 'undefined' && $.isFunction(cek_notif)) {
                cek_notif();
                load_table('#content_table2', 1, '#ffilter2');
            }                     
        }
    }    
    
    $('#JENIS_PEMAKAIAN').on('change', function() {
        var stateID = $(this).val();      
        if (stateID==2){
            $('#div_unit_terima').show();
        } else {
            $('#div_unit_terima').hide();
        }        
    });      

    if ($('#JENIS_PEMAKAIAN').val()==2){
        $('#div_unit_terima').show();    
    } else {
        $('#div_unit_terima').hide();    
    }

    // $('#JENIS_PEMAKAIAN').val('2');
    // $('#JENIS_PEMAKAIAN').change();

    setformfieldsize($('#KET_BATAL'), 200, '');
    $('#KET_BATAL').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 200){
            $('#MaxKet').text('*Max 200');            
        } else {
            $('#MaxKet').text('');
        }        
    });      

</script>