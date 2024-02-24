<div class="row-fluid">
    <div class="box-title">
        <?php echo (isset($page_title)) ? $page_title : 'Role Management'; ?>
    </div>
    <div class="box-content">
        <?php
        $hidden_form = array('id' => !empty($id) ? $id : '');
        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
        ?>

        <div class="control-group">
            <label  class="control-label">Pemasok<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_PEMASOK', $pemasok_options, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6 chosen" disabled'); ?>
            </div>
        </div>

        <div class="control-group">
            <div class="controls" style="display:none">
                <?php echo form_input('ID_KONTRAK_PEMASOK', !empty($default->ID_KONTRAK_PEMASOK) ? $default->ID_KONTRAK_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <label for="password" class="control-label">No Adendum<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NO_ADENDUM_PEMASOK', !empty($default->NO_ADENDUM_PEMASOK) ? $default->NO_ADENDUM_PEMASOK : '', 'class="span6" placeholder="Ketik No Adendum (Max 200)" id="NO_ADENDUM_PEMASOK" '); ?>
                <span class="required" id="MaxId"></span>
            </div>
            <br>
            <label for="password" class="control-label">Keterangan Adendum<span class="required">*</span> : </label> 
            <div class="controls">
                <!-- <?php //echo form_input('KET_ADENDUM_PEMASOK', !empty($default->KET_ADENDUM_PEMASOK) ? $default->KET_ADENDUM_PEMASOK : '', 'class="span6"'); ?> -->
                <?php
                    $data = array(
                      'name'        => 'KET_ADENDUM_PEMASOK',
                      'id'          => 'KET_ADENDUM_PEMASOK',
                      'value'       => !empty($default->KET_ADENDUM_PEMASOK) ? $default->KET_ADENDUM_PEMASOK : '',
                      'rows'        => '4',
                      'cols'        => '10',
                      'class'       => 'span6',
                      'style'       => '"none" placeholder="Ketik Keterangan Adendum (Max 200)"'
                    );
                  echo form_textarea($data);
                ?>
                <span class="required" id="MaxKet"></span>                   
            </div>
            <br>
            <input type="hidden" name="PATH_FILE_EDIT" value="<?php echo !empty($default->PATH_DOC) ? $default->PATH_DOC : ''?>">
            <label for="password" class="control-label" id="up_nama">Upload File (Max 10 MB)<span class="required">*</span> : </label> 
            <div class="controls" id="up_file">
                    <?php echo form_upload('PATH_DOC', !empty($default->PATH_DOC) ? $default->PATH_DOC : '', 'class="span6"'); ?>
            </div>
            <br>
            <label for="password" class="control-label"> </label> 
            <!-- dokumen -->
            <?php  
                if ($this->laccess->is_prod()){ ?>
                    <div class="controls" id="dokumen">
                        <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="KONTRAKPEMASOK" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($id_dok) ? $id_dok : '';?>"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                    </div> 
            <?php } else { ?>
                    <div class="controls" id="dokumen">
                        <a href="<?php echo base_url().'assets/upload/kontrak_pemasok/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                    </div>
            <?php } ?>
            <!-- end dokumen -->
            <hr>
            <label for="password" class="control-label">Tgl Kontrak<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_ADENDUM_PEMASOK', !empty($default->TGL_ADENDUM_PEMASOK) ? $default->TGL_ADENDUM_PEMASOK : '', 'class="span2 input-append date form_datetime"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Judul Kontrak<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('JUDUL_ADENDUM_PEMASOK', !empty($default->JUDUL_ADENDUM_PEMASOK) ? $default->JUDUL_ADENDUM_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Periode Awal<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('PERIODE_AWAL_ADENDUM_PEMASOK', !empty($default->PERIODE_AWAL_ADENDUM_PEMASOK) ? $default->PERIODE_AWAL_ADENDUM_PEMASOK : '', 'class="span2 input-append date form_datetime"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Periode Akhir<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('PERIODE_AKHIR_ADENMDUM_PEMASOK', !empty($default->PERIODE_AKHIR_ADENMDUM_PEMASOK) ? $default->PERIODE_AKHIR_ADENMDUM_PEMASOK : '', 'class="span2 input-append date form_datetime"'); ?>
            </div>
            <br>
            <label  class="control-label">Skema Insidentil : </label>
            <div class="controls">
                <?php echo form_dropdown('SKEMA_ISIDENTIL', $jns_isidentil_options, !empty($default->SKEMA_ISIDENTIL) ? $default->SKEMA_ISIDENTIL : '', 'class="span2 chosen"'); ?>
            </div>            
        </div>
        
        <div class="control-group">
            <label  class="control-label">Jenis Kontrak<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('JENIS_AKHIR_ADENDUM_PEMASOK', $jns_kontrak_options, !empty($default->JENIS_AKHIR_ADENDUM_PEMASOK) ? $default->JENIS_AKHIR_ADENDUM_PEMASOK : '', 'class="span2 chosen"'); ?>
            </div>
            <br>
            <div id="divPembangkit">
                <label for="a" class="control-label">Pembangkit : </label> 
                <div class="controls">
                    <select id="PEMBANGKIT" multiple="multiple" class="span6">
                        <?php
                            foreach ($lv4_options as $row) {
                                echo "<option value='$row->SLOC'>$row->LEVEL</option>";
                            }
                        ?>
                    </select>
                    <?php echo form_hidden('SLOC', '', 'id="SLOC" '); ?>
                    <?php echo form_hidden('SLOC_EDIT', !empty($default->SLOC) ? $default->SLOC : '', 'id="SLOC_EDIT" '); ?>
                </div>
            </div>
        </div>

<!--         <div class="control-group">
            <label for="password" class="control-label">Jenis BBM<span class="required">*</span> : </label>
            <div class="controls">
                <?php //echo form_dropdown('ID_JNS_BHN_BKR', $jns_bhn_bkr_options, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3 chosen "'); ?>
            </div>
        </div> -->
        
        <div class="control-group">
            <label for="password" class="control-label">Volume (L): </label> 
            <div class="controls">
                <?php echo form_input('VOL_AKHIR_ADENDUM_PEMASOK', !empty($default->VOL_AKHIR_ADENDUM_PEMASOK) ? $default->VOL_AKHIR_ADENDUM_PEMASOK : '', 'class="span3"'); ?>
            </div>
            <br>
            <!-- <label for="password" class="control-label">Alpha : </label> 
            <div class="controls">
                <?php echo form_input('ALPHA_ADENDUM_PEMASOK', !empty($default->ALPHA_ADENDUM_PEMASOK) ? $default->ALPHA_ADENDUM_PEMASOK : '', 'class="span3"'); ?>
            </div>
            <br> -->
            <label for="password" class="control-label">Nilai Kontrak (Rp): </label> 
            <div class="controls">
                <?php echo form_input('RP_ADENDUM_PEMASOK', !empty($default->RP_ADENDUM_PEMASOK) ? $default->RP_ADENDUM_PEMASOK : '', 'class="span3"'); ?>
                <sup>Termasuk PPN 10 %</sup>
            </div>
            <br>
            <label for="password" class="control-label">Bank Garansi (BG) : </label> 
            <div class="controls">
                <?php echo form_input('PENJAMIN_ADENDUM_PEMASOK', !empty($default->PENJAMIN_ADENDUM_PEMASOK) ? $default->PENJAMIN_ADENDUM_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">No Bank Garansi  : </label> 
            <div class="controls">
                <?php echo form_input('NO_PENJAMIN_ADENDUM_PEMASOK', !empty($default->NO_PENJAMIN_ADENDUM_PEMASOK) ? $default->NO_PENJAMIN_ADENDUM_PEMASOK : '', 'class="span6"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Nominal Bank Garansi (Rp) : </label> 
            <div class="controls">
                <?php echo form_input('NOMINAL_ADENDUM_PEMASOK', !empty($default->NOMINAL_ADENDUM_PEMASOK) ? $default->NOMINAL_ADENDUM_PEMASOK : '', 'class="span3"'); ?>
            </div>
            <br>
            <label for="password" class="control-label">Tgl Berakhir Bank Garansi : </label> 
            <div class="controls">
                <?php echo form_input('TGL_AKHIR_ADENDUM_PEMASOK', !empty($default->TGL_AKHIR_ADENDUM_PEMASOK) ? $default->TGL_AKHIR_ADENDUM_PEMASOK : '', 'class="span2 input-append date form_datetime"'); ?>
            </div>
            <!-- <br>
            <label for="password" class="control-label">Upload Dokumen : </label> 
            <div class="controls">
                    <?php echo form_upload('ID_DOC_PEMASOK', !empty($default->ID_DOC_PEMASOK) ? $default->ID_DOC_PEMASOK : '', 'class="span6"'); ?>
            </div> -->

        </div>
        <br>
    
        <div class="form-actions">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<br><br>

<script type="text/javascript">
    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
    $('.chosen').chosen();

    $('select[name="ID_PEMASOK"]').attr("disabled", true);

    $('input[name=VOL_AKHIR_ADENDUM_PEMASOK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
    });
    $('input[name=ALPHA_ADENDUM_PEMASOK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
    });
    $('input[name=RP_ADENDUM_PEMASOK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
    });
    $('input[name=NOMINAL_ADENDUM_PEMASOK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false, oncleared: function () { self.Value(''); }
    });

    $.extend($.fn.select2.defaults, {
        formatSelectionTooBig: function (limit) {
            return 'Max 20 pembangkit yang diperbolehkan';
        }
    });

    var s2 = $("#PEMBANGKIT").select2({
        placeholder: 'Pilih Pembangkit',
        maximumSelectionSize: 20,
    });

    $('#PEMBANGKIT').change(function() {        
        $('#SLOC').val($('#PEMBANGKIT').val());
    });

    $('#divPembangkit').hide();
    $('select[name=JENIS_AKHIR_ADENDUM_PEMASOK]').change(function() {        
        if($('select[name=JENIS_AKHIR_ADENDUM_PEMASOK]').val()==1){
            $('#divPembangkit').show();
        } else {
            $('#divPembangkit').hide();
        }
    });

    if( $('input[name=ID_KONTRAK_PEMASOK]').val() != '') {
        if($('select[name=JENIS_AKHIR_ADENDUM_PEMASOK]').val()==1){
            var str = $('#SLOC_EDIT').val();
            var temp = new Array();
            temp = str.split(",");

            // temp.forEach(function(e){
            // if(!s2.find('option:contains(' + e + ')').length) 
            //   s2.append($('<option>').text(e));
            // });

            s2.val(temp).trigger("change"); 

            // $('#PEMBANGKIT').select2().val(temp).trigger("change");
            $('#divPembangkit').show();
        } else {
            $('#divPembangkit').hide();
        }
    }

    setformfieldsize($('#NO_ADENDUM_PEMASOK'), 200, '');
    $('#NO_ADENDUM_PEMASOK').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 200){
            $('#MaxId').text('*Max 200');            
        } else {
            $('#MaxId').text('');
        }        
    });   

    setformfieldsize($('#KET_ADENDUM_PEMASOK'), 200, '');
    $('#KET_ADENDUM_PEMASOK').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 200){
            $('#MaxKet').text('*Max 200');            
        } else {
            $('#MaxKet').text('');
        }        
    });     
    
</script>            
