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

        <!--<div class="control-group">
            <label class="control-label">No Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php //echo form_input('NO_PEMAKAIAN', !empty($default->NO_MUTASI_PEMAKAIAN) ? $default->NO_MUTASI_PEMAKAIAN : '', 'class="span6" placeholder="Nomor Pemakaian"'); ?>
            </div>
        </div>-->
        <div class="control-group">
            <label class="control-label">Jenis Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('VALUE_SETTING', $option_jenis_pemakaian, !empty($default->JENIS_PEMAKAIAN) ? $default->JENIS_PEMAKAIAN : '', 'class="span3" id="JENIS_PEMAKAIAN"'); ?>
            </div>
        </div>
        <div id="div_unit_terima" hidden>
            <div class="control-group">
                <label  class="control-label">Level 1 Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('COCODE_TERIMA', $lv1_options_all, !empty($lv1_options_all_def) ? $lv1_options_all_def : '', 'class="span6" id="COCODE_TERIMA"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 2 Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('PLANT_TERIMA', $lv2_options_all, !empty($default->PLANT_TERIMA) ? $default->PLANT_TERIMA : '', 'class="span6" id="PLANT_TERIMA"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 3 Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('STORE_SLOC_TERIMA', $lv3_options_all, !empty($default->STORE_SLOC_TERIMA) ? $default->STORE_SLOC_TERIMA : '', 'class="span6" id="STORE_SLOC_TERIMA"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Pembangkit Penerima<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('SLOC_TERIMA', $lv4_options_all, !empty($default->SLOC_KIRIM) ? $default->SLOC_KIRIM : '', 'class="span6" id="pembangkit_terima" id="SLOC_TERIMA"'); ?>
                </div>
            </div>
        </div>          
        <div class="control-group">
            <label class="control-label">No Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NO_TUG', !empty($default->NO_TUG) ? $default->NO_TUG : '', 'class="span6" id="NO_TUG" placeholder="Ketik No Pemakaian (Max 60)"'); ?>
                <span class="required" id="MaxId"></span>
            </div>
        </div>          
        <div class="control-group">
            <label class="control-label">Tanggal Catat Pemakaian<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_CATAT', !empty($default->TGL_PENCATATAN) ? $default->TGL_PENCATATAN : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal" id="TGL_CATAT"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Tanggal Pengakuan<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_MUTASI_PENGAKUAN) ? $default->TGL_MUTASI_PENGAKUAN : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal" id="TGL_PENGAKUAN"'); ?>
                </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Regional <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Level 1<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Level 2<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Level 3<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6" id="pembangkit"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis Mesin<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('KODE_MESIN', $option_jenis_mesin, !empty($default->KODE_MESIN) ? $default->KODE_MESIN : '', 'class="span3" id="jnsmesin"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" id="jnsbbm"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Vol. Pemakaian (L)<span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('VOL_PEMAKAIAN', !empty($default->VOLUME_PEMAKAIAN) ? $default->VOLUME_PEMAKAIAN : '', 'class="span3" placeholder="Ketik Volume Pemakaian"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Keterangan : </label>
            <div class="controls">
                <!-- <?php //echo form_input('KETERANGAN', !empty($default->KETERANGAN) ? $default->KETERANGAN : '', 'class="span4" placeholder="Keterangan Pemakaian"'); ?> -->
                <?php
                    $data = array(
                      'name'        => 'KETERANGAN',
                      'id'          => 'KETERANGAN',
                      'value'       => !empty($default->KET_MUTASI_PEMAKAIAN) ? $default->KET_MUTASI_PEMAKAIAN : '',
                      'rows'        => '4',
                      'cols'        => '10',
                      'class'       => 'span6',
                      'style'       => '"none" placeholder="Ketik Keterangan Pemakaian (Max 200)"'
                    );
                  echo form_textarea($data);
                ?>
                <span class="required" id="MaxKet"></span>
            </div>
        </div>

        <div class="form-actions">
            <?php 
            if ($this->laccess->otoritas('edit')) {
                echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')"));
            }?>
            <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
        </div>
        <?php echo form_close(); ?>
    </div>
    <!-- perhitungan End -->
    <?php echo form_close(); ?>
    <br><br>
</div>


<script type="text/javascript">
    $(".form_datetime").datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    $( "#pembangkit" ).change(function() {
        var sloc = $(this).val();
        load_jenis_bbm('<?php echo $urljnsbbm; ?>/' + sloc, "#jnsbbm");
        load_jenis_mesin('<?php echo $urljnsmesin; ?>/' + sloc, "#jnsmesin");
    });
    
    // start
    function formatDateDepan() {
    var date = new Date();
      var tanggal =date.getDate();
      var bulan = date.getMonth()+1;
      var tahun = date.getFullYear();

      if(tanggal<10){
         tanggal='0'+tanggal;
        } 

      if(bulan<10){
         bulan='0'+bulan;
        } 

      return tahun + "" + bulan + "" + tanggal;
    }
    function setDefaulthTanggalPengakuan(){
        var strStart = $("input[name=TGL_CATAT]").val();
        var strEnd = $("input[name=TGL_PENGAKUAN]").val();

        var dateStart = strStart.substring(0, 2);
        var monthStart = strStart.substring(3, 5);
        var yearStart = strStart.substring(6, 10);

        var dateEnd = strEnd.substring(0, 2);
        var monthEnd = strEnd.substring(3, 5);
        var yearEnd = strEnd.substring(6, 10);

        var vDateStart = yearStart + "" + monthStart + "" + dateStart;
        var vDateEnd = yearEnd + "" + monthEnd + "" + dateEnd;

       if (vDateStart){
            if (vDateStart < '20170101') {
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Pemakaian tidak boleh kurang dari tahun 2017</div>';
                bootbox.alert(message, function() {});
                $('input[name=TGL_CATAT').datepicker('update', '01-01-2017');
                $('input[name=TGL_PENGAKUAN').datepicker('update', '01-01-2017');
                
            } else {
                if (vDateEnd > vDateStart) {
                    $('input[name=TGL_PENGAKUAN').datepicker('update', strStart);
                }

                $('input[name=TGL_PENGAKUAN]').datepicker('setStartDate', '01-01-2017');
                $('input[name=TGL_PENGAKUAN]').datepicker('setEndDate', $("input[name=TGL_CATAT]").val());                 
            }            
        }         

        // if (vDateEnd > vDateStart) {
        //     $('input[name=TGL_PENGAKUAN').datepicker('update', strStart);
        // }

        // $('input[name=TGL_PENGAKUAN]').datepicker('setStartDate', '01-01-2017');
        // $('input[name=TGL_PENGAKUAN]').datepicker('setEndDate', $("input[name=TGL_CATAT]").val());    

       
    }

    function setDefaulthTanggalCatat(){
        var date = new Date();
        var tanggal = formatDateDepan();

        $('input[name=TGL_CATAT]').datepicker('setStartDate', '01-01-2017');
        $('input[name=TGL_CATAT]').datepicker('setEndDate', tanggal);
    }

    function checkDefaulthTglCatat(){
        var dateBatasan =  formatDateDepan();
        var strStart = $("input[name=TGL_CATAT]").val();
        var strEnd = $("input[name=TGL_PENGAKUAN]").val();

        var dateStart = strStart.substring(0, 2);
        var monthStart = strStart.substring(3, 5);
        var yearStart = strStart.substring(6, 10);

        var dateEnd = strEnd.substring(0, 2);
        var monthEnd = strEnd.substring(3, 5);
        var yearEnd = strEnd.substring(6, 10);

        var vDateStart = yearStart + "" + monthStart + "" + dateStart;
        var vDateEnd = yearEnd + "" + monthEnd + "" + dateEnd;


        if (vDateStart > dateBatasan) {
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Catat Pemakaian tidak boleh melebihi Tanggal Hari ini</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_CATAT').datepicker('update', date);
         
        }else if (vDateEnd > vDateStart) {
            if(strStart != "" && strEnd != ""){
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Pengakuan tidak boleh melebihi Tanggal Catat</div>';
                bootbox.alert(message, function() {});
                $('input[name=TGL_PENGAKUAN').datepicker('update', strStart);
            }
        }

        if (vDateEnd){
            if (vDateEnd < '20170101') {
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Pengakuan tidak boleh kurang dari tahun 2017</div>';
                bootbox.alert(message, function() {});
                $('input[name=TGL_PENGAKUAN').datepicker('update', '01-01-2017');          
            }
        }         

    }

    $("input[name=TGL_CATAT]").change(setDefaulthTanggalPengakuan);
    $("input[name=TGL_PENGAKUAN]").change(checkDefaulthTglCatat);
    $("input[name=button-save]").click(checkDefaulthTglCatat);
    
    $(function() {
        setDefaulthTanggalCatat();
    });
    // end

    // var vLevelUser = "<?php echo $this->session->userdata('level_user'); ?>";

    // if( vLevelUser <= 2) {
    //     $("#button-save").hide();
    // }

    $('input[name=VOL_PEMAKAIAN]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    function setDefaultLv1In(){
        $('#COCODE').empty();
        $('#COCODE').append('<option value="">--Pilih Level 1--</option>');
    }

    function setDefaultLv2In(){
        $('#PLANT').empty();
        $('#PLANT').append('<option value="">--Pilih Level 2--</option>');
    }

    function setDefaultLv3In(){
        $('#STORE_SLOC').empty();
        $('#STORE_SLOC').append('<option value="">--Pilih Level 3--</option>');
    }

    function setDefaultLv4In(){
        $('#pembangkit').empty();
        $('#pembangkit').append('<option value="">--Pilih Pembangkit--</option>');
    }

    function setDefaultLv1Terima(){
        $('select[name="COCODE_TERIMA"]').empty();
        $('select[name="COCODE_TERIMA"]').append('<option value="">--Pilih Level 1--</option>');
    }

    function setDefaultLv2Terima(){
        $('select[name="PLANT_TERIMA"]').empty();
        $('select[name="PLANT_TERIMA"]').append('<option value="">--Pilih Level 2--</option>');
    }

    function setDefaultLv3Terima(){
        $('select[name="STORE_SLOC_TERIMA"]').empty();
        $('select[name="STORE_SLOC_TERIMA"]').append('<option value="">--Pilih Level 3--</option>');
    }

    function setDefaultLv4Terima(){
        $('select[name="SLOC_TERIMA"]').empty();
        $('select[name="SLOC_TERIMA"]').append('<option value="">--Pilih Pembangkit--</option>');
    }    

    $('#ID_REGIONAL').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv1/'+stateID;
        setDefaultLv1In();
        setDefaultLv2In();
        setDefaultLv3In();
        setDefaultLv4In();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('#COCODE').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    $('#COCODE').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv2/'+stateID;
        setDefaultLv2In();
        setDefaultLv3In();
        setDefaultLv4In();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('#PLANT').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    $('#PLANT').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv3/'+stateID;
        setDefaultLv3In();
        setDefaultLv4In();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('#STORE_SLOC').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    $('#STORE_SLOC').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv4/'+stateID;
        setDefaultLv4In();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('#pembangkit').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    //terima
    $('select[name="COCODE_TERIMA"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv2/'+stateID;
        setDefaultLv2Terima();
        setDefaultLv3Terima();
        setDefaultLv4Terima();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="PLANT_TERIMA"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    $('select[name="PLANT_TERIMA"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv3/'+stateID;
        setDefaultLv3Terima();
        setDefaultLv4Terima();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="STORE_SLOC_TERIMA"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    $('select[name="STORE_SLOC_TERIMA"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/pemakaian/get_options_lv4/'+stateID;
        setDefaultLv4Terima();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="SLOC_TERIMA"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });    

    $('#JENIS_PEMAKAIAN').on('change', function() {
        var stateID = $(this).val();        

        if (stateID==2){
            $('#div_unit_terima').show();
        } else {
            $('#div_unit_terima').hide();
        }        
    });      
    $('#JENIS_PEMAKAIAN').change();

    if ($('input[name="id"]').val()){
        var sloc = $('#pembangkit').val();
        var jnsbbm = $('#jnsbbm').val();
        var jnsmesin = $('#jnsmesin').val();

        load_jenis_bbm_def('<?php echo $urljnsbbm; ?>/' + sloc, "#jnsbbm", jnsbbm);
        load_jenis_mesin_def('<?php echo $urljnsmesin; ?>/' + sloc, "#jnsmesin", jnsmesin);
    }

    setformfieldsize($('#NO_TUG'), 60, '');
    $('#NO_TUG').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 60){
            $('#MaxId').text('*Max 60');            
        } else {
            $('#MaxId').text('');
        }        
    });   

    setformfieldsize($('#KETERANGAN'), 200, '');
    $('#KETERANGAN').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 200){
            $('#MaxKet').text('*Max 200');            
        } else {
            $('#MaxKet').text('');
        }        
    });      
</script>