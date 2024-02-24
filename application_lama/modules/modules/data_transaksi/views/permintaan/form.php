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
            <div class="control-group">
                <label class="control-label">Nomor Nominasi<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NO_NOMINASI', !empty($default->NO_NOMINASI) ? $default->NO_NOMINASI : '', 'class="span6" placeholder="Ketik Nomor Nominasi / Permintaan (Max 60)" id="NO_NOMINASI" data-maxsize="6"'); ?>
                    <span class="required" id="MaxId"></span>
                </div>

            </div>
            <div class="control-group">
                <label class="control-label">Tanggal Nominasi<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('TGL_MTS_NOMINASI', !empty($default->TGL_MTS_NOMINASI) ? $default->TGL_MTS_NOMINASI : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal" id="TGL_MTS_NOMINASI"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pemasok<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_PEMASOK', $option_pemasok, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Regional<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6" id="ID_REGIONAL" '); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 1<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6" id="COCODE" '); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 2<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6" id="PLANT" '); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 3<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'class="span6" id="STORE_SLOC" '); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6" id="pembangkit"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" id="jnsbbm"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="control-label" class="control-label" id="up_nama">Upload File (Max 10 MB)<span class="required">*</span> : </label> 
                <div class="controls" id="up_file">
                        <?php echo form_upload('PATH_FILE_NOMINASI', 'class="span6"'); ?>
                </div>
                <input type="hidden" name="PATH_FILE_EDIT" value="<?php echo !empty($default->PATH_FILE_NOMINASI) ? $default->PATH_FILE_NOMINASI : ''?>">
            </div>
            <div class="control-group">
                <label for="control-label" class="control-label"> </label> 
                <!-- dokumen -->
                <?php  
                    if ($this->laccess->is_prod()){ ?>
                        <div class="controls" id="dokumen">
                            <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="MINTA" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($id_dok) ? $id_dok : '';?>"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                        </div> 
                <?php } else { ?>
                        <div class="controls" id="dokumen">
                            <a href="<?php echo base_url().'assets/upload/permintaan/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                        </div>
                <?php } ?>
                <!-- end dokumen -->
            </div>
            <div class="control-group">
                <label class="control-label">Volume (L)<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('VOLUME_NOMINASI', !empty($default->VOLUME_NOMINASI) ? $default->VOLUME_NOMINASI : '0', 'class="span3" placeholder="0" id="VOLUME_NOMINASI" readonly'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jumlah Pengiriman<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('JML_KIRIM', !empty($default->JML_KIRIM) ? $default->JML_KIRIM : '', 'class="span2" placeholder="Ketik Jumlah" id="JML_KIRIM" '); ?>
                     <?php echo anchor(null, 'Generate', array('id' => 'button-jml-kirim', 'class' => 'green btn')); ?>
                </div>
            </div>
            <br>           
            <div class="content_table">
                <div class="well-content clearfix">
                        <div id='TextBoxesGroup'>
                            <div id="TextBoxDiv0">
                                <!-- <div class="form_row">
                                    <div class="pull-left">
                                        <label for="password" class="control-label">Tgl Kirim ke : 1</label>
                                        <div class="controls">
                                            <input type='text' id='textbox1' class="input-append date form_datetime">
                                        </div>
                                    </div>
                                    <div class="pull-left">
                                        <label for="password" class="control-label">Volume (L) ke : 1</label>
                                        <div class="controls">
                                            <input type='text' id='textbox1' class="input-append date form_datetime">
                                        </div>
                                    </div>
                                </div><br>  -->   
                            </div>
                        </div>
                        <input type='button' value='Add Button' id='addButton'>
                        <input type='button' value='Remove Button' id='removeButton'>
                        <input type='button' value='Get TextBox Value' id='getButtonValue'>                        
                </div>
            </div>

            <div class="form-actions">
                <?php 
                if ($this->laccess->otoritas('edit')) {
                    echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')"));
                }?>
                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
            </div>
            <?php
        echo form_close(); ?>
    </div>
    <br><br>
</div>


<script type="text/javascript">

    $(document).ready(function(){

        var counter = 1;

        $("#addButton").click(function () {
            if(counter>31){
                    alert("Max 31 data yang diperbolehkan");
                    return false;
            }

            var newTextBoxDiv = $(document.createElement('div'))
                 .attr("id", 'TextBoxDiv' + counter);

            var visi = '<div class="form_row"><div class="pull-left"><label for="password" class="control-label">Tgl Kirim ke : '+ counter + '</label><div class="controls"><input type="text" id="tgl_ke'+ counter + '" name="tgl_ke'+ counter + '" class="input-append date form_datetime" placeholder="Tanggal Kirim"></div></div><div class="pull-left"><label for="password" class="control-label">Volume (L) ke : '+ counter + '</label><div class="controls"><input type="text" id="vol_ke'+ counter + '" name="vol_ke'+ counter + '" placeholder="Volume (L)" onChange="setHitungKirim()"></div></div></div><br>';     

            // newTextBoxDiv.after().html('<label>Textbox #'+ counter + ' : </label>' +
            //       '<input type="text" name="textbox' + counter +
            //       '" id="textbox' + counter + '" value="" >');

            newTextBoxDiv.after().html(visi);
            newTextBoxDiv.appendTo("#TextBoxesGroup");
            counter++;
        });

        $("#removeButton").click(function () {
            if(counter==1){
                //alert("No more textbox to remove");
                return false;
            }

            counter--;
            $("#TextBoxDiv" + counter).remove();
        });

        $("#getButtonValue").click(function () {
            var msg = '';
            for(i=1; i<counter; i++){
                msg += "\n Textbox #" + i + " : " + $('#tgl_ke' + i).val();
            }
            alert(msg);
        });

        $("#button-jml-kirim").click(function () {
            var x = $('#JML_KIRIM').val(); 

            if(x>31){
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Max 31 data jumlah pengiriman yang diperbolehkan</div>';
                bootbox.alert(message, function() {});
                $('#JML_KIRIM').val('31');
            }

            for (i = 1; i <= 31; i++) {
                $("#TextBoxDiv"+i).hide();
            }

            for (i = 1; i <= x; i++) {
                $("#TextBoxDiv"+i).show();

            }
            setHitungKirim();
        });

        for (i = 0; i < 31; i++) {
            $("#addButton").click();
        }

        for (i = 1; i <= 31; i++) {
            $("#TextBoxDiv"+i).hide();
        }
        
        if ($('input[name=id]').val()){
            get_detail($('input[name=NO_NOMINASI]').val(), $('#pembangkit :selected').val()); 
        }

        for (i = 1; i <= 31; i++) {
            var val="input[name=vol_ke"+i+"]";
            $('input[name=vol_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
            });
        }

        $("#addButton").hide();
        $("#removeButton").hide();
        $("#getButtonValue").hide();
    });

    function setHitungKirim(){
        var vSum=0;
        for (i = 1; i <= 31; i++) {
            if($("#TextBoxDiv"+i).is(":visible")){
                var vol = $("#vol_ke"+i).val();
                var new_vol = vol.replace(/\./g, "");
                new_vol = new_vol.replace(",", ".");
                //new_vol = Number(new_vol);
                if (new_vol==''){new_vol=0;}
                new_vol = parseFloat(new_vol);
                vSum += new_vol;     
            }
        }
        $("#VOLUME_NOMINASI").val(vSum);
    }

    $("#button-save").click(function () {
        $("#button-jml-kirim").click();
    });

    $(".form_datetime").datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
	
    $('input[name=VOLUME_NOMINASI]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    $('input[name=JML_KIRIM]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 0,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });


    $('input[name=vol_ke]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    $( "#pembangkit" ).change(function() {
        var sloc = $(this).val();
        load_jenis_bbm('<?php echo $urljnsbbm; ?>/' + sloc, "#jnsbbm");
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

    $('#ID_REGIONAL').on('change', function() {        
        bootbox.hideAll();
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/permintaan/get_options_lv1/'+stateID;        
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
                    // $('#COCODE').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    });

    $('#COCODE').on('change', function() {
        bootbox.hideAll();
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/permintaan/get_options_lv2/'+stateID;
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
                    // $('#PLANT').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    });

    $('#PLANT').on('change', function() {
        bootbox.hideAll();   
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/permintaan/get_options_lv3/'+stateID;
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
                    // $('#STORE_SLOC').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    });

    $('#STORE_SLOC').on('change', function() {
        bootbox.hideAll();     
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/permintaan/get_options_lv4/'+stateID;
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
                    // $('#pembangkit').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    });

    function get_detail(vId, v_SLOC) {
        var data = {idx: vId, sloc: v_SLOC};

        $.post("<?php echo base_url()?>data_transaksi/permintaan/get_detail_kirim/", data, function (data) {
            var rest = (JSON.parse(data));
            var i=0;
            
            $.each(data, function(key, value) {
                i = i+1;
                $("#tgl_ke"+i).val(value.TGL_KIRIM);
                $("#vol_ke"+i).val(value.VOLUME_NOMINASI);
                $("#TextBoxDiv"+i).show();
            });
        });
    }

    function get_detail(vId, v_SLOC) {
        var data = {idx: vId, sloc: v_SLOC};

        $.post("<?php echo base_url()?>data_transaksi/permintaan/get_detail_kirim/", data, function (data) {
            var rest = (JSON.parse(data));
            var x=0;
            for (i = 0; i < rest.length; i++) {
                x++;
                $("#tgl_ke"+x).val(rest[i].TGL_KIRIM);
                $("#vol_ke"+x).val(rest[i].VOLUME_NOMINASI);
                $("#TextBoxDiv"+x).show();
            }
        });
    }

    // start
    function formatDateDepan(date) {
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

    function setDefaulthTglMts(){
        var date = new Date();
        var tanggal = formatDateDepan(date);

        $('input[name=TGL_MTS_NOMINASI]').datepicker('setStartDate', '01-01-2017');
        $('input[name=TGL_MTS_NOMINASI]').datepicker('setEndDate', tanggal);
    }

    function checkDefaulthTglmTS(){
        var date = new Date();
        var dateBatasan =  formatDateDepan(date);
        var dateMts = $("input[name=TGL_MTS_NOMINASI]").val();
        var dateStart = dateMts.substring(0, 2);
        var monthStart = dateMts.substring(3, 5);
        var yearStart = dateMts.substring(6, 10);

        var vDateStart = yearStart + "" + monthStart + "" + dateStart;


        if (vDateStart > dateBatasan) {
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Nominasi tidak boleh melebihi Tanggal Hari ini</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_MTS_NOMINASI').datepicker('update', date);
         
        }

        if (vDateStart < '20170101') {
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  Tanggal Nominasi tidak boleh kurang dari tahun 2017</div>';
            bootbox.alert(message, function() {});
            $('input[name=TGL_MTS_NOMINASI').datepicker('update', '01-01-2017');
            
        }            

    }

    $("input[name=TGL_MTS_NOMINASI]").change(checkDefaulthTglmTS);
    
    $(function() {
        setDefaulthTglMts();
    });

    if ($('input[name="id"]').val()){
        var sloc = $('#pembangkit').val();
        var jnsbbm = $('#jnsbbm').val();

        load_jenis_bbm_def('<?php echo $urljnsbbm; ?>/' + sloc, "#jnsbbm", jnsbbm);
    } 

    setformfieldsize($('#NO_NOMINASI'), 60, '');
    $('#NO_NOMINASI').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 60){
            $('#MaxId').text('*Max 60');            
        } else {
            $('#MaxId').text('');
        }        
    });    

    // end

</script>