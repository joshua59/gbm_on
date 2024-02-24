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
            <label for="password" class="control-label">Nama Transportir <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_TRANSPORTIR_VIEW', $option_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'class="span6" disabled'); ?>
            </div>
        </div>
        <div class="control-group" style="display:none">
            <label for="password" class="control-label">Pilih Transportir<span class="required">*</span> : </label>
            <div class="controls">
            <?php echo form_input('KD_KONTRAK_TRANS', !empty($default->KD_KONTRAK_TRANS) ? $default->KD_KONTRAK_TRANS : '', 'class="span6" '); ?>
            <?php echo form_dropdown('ID_TRANSPORTIR', $option_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'class="span6"'); ?>
            </div>
        </div>
        <div class="controls" style="display:none">
            <?php echo form_input('ID_KONTRAK_TRANS', !empty($default->ID_KONTRAK_TRANS) ? $default->ID_KONTRAK_TRANS : '', 'class="span6" '); ?>
        </div>

        <div class="control-group">
            <label for="password" class="control-label">No Adendum <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NO_KONTRAK', !empty($default->KD_KONTRAK_TRANS) ? $default->KD_KONTRAK_TRANS : '', 'class="span6" placeholder="Ketik No Adendum (Max 200)" id="NO_KONTRAK"'); ?>
                <span class="required" id="MaxId"></span>
            </div>
        </div>
        <div class="control-group">
        <label for="password" class="control-label">Keterangan Adendum <span class="required">*</span> : </label> 
<!--         <div class="controls">
            <?php //echo form_input('KETERANGAN', !empty($default->KET_KONTRAK_TRANS) ? $default->KET_KONTRAK_TRANS : '', 'class="span6" '); ?>
            <span class="required" id="MaxKet"></span>  
        </div> -->
        <div class="controls">
            <?php
                $data = array(
                  'name'        => 'KETERANGAN',
                  'id'          => 'KETERANGAN',
                  'value'       => !empty($default->KET_KONTRAK_TRANS) ? $default->KET_KONTRAK_TRANS : '',
                  'rows'        => '4',
                  'cols'        => '10',
                  'class'       => 'span6',
                  'style'       => '"none" placeholder="Ketik Keterangan Adendum (Max 200)"'
                );
              echo form_textarea($data);
            ?>
            <span class="required" id="MaxKet"></span>             
        </div>

        </div>

        <div class="control-group">
            <input type="hidden" name="PATH_FILE_EDIT" value="<?php echo !empty($default->PATH_KONTRAK_TRANS) ? $default->PATH_KONTRAK_TRANS : ''?>">
            <label for="password" class="control-label">Upload File (Max 10 MB) <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_upload('FILE_UPLOAD', !empty($default->PATH_KONTRAK_TRANS) ? $default->PATH_KONTRAK_TRANS : '', 'class="span6"'); ?>
            </div>
          
            <!-- dokumen -->
            <?php  
                if ($this->laccess->is_prod()){ ?>
                    <div class="controls" id="dokumen">
                        <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="KONTRAKTRANSPORTIR" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($id_dok) ? $id_dok : '';?>"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                    </div> 
            <?php } else { ?>
                    <div class="controls" id="dokumen">
                        <a href="<?php echo base_url().'assets/upload/kontrak_transportir/'.$id_dok;?>" target="_blank"><b><?php echo (empty($id_dok)) ? $id_dok : 'Lihat Dokumen'; ?></b></a>
                    </div>
            <?php } ?>
            <!-- end dokumen -->

        </div>
        <hr>

        <div class="control-group">
            <label for="password" class="control-label">Tgl Awal Kontrak <span class="required">*</span> : </label>
            <div class="controls">
            <?php echo form_input('TGL_KONTRAK_TRANS', !empty($default->TGL_KONTRAK_TRANS) ? $default->TGL_KONTRAK_TRANS : '', 'class="span3 datepicker" id="TGL_KONTRAK_TRANS"'); ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Tgl Akhir Kontrak <span class="required">*</span> : </label>
            <div class="controls">
            <?php echo form_input('TGL_KONTRAK_TRANS_AKHIR', !empty($default->TGL_KONTRAK_TRANS_AKHIR) ? $default->TGL_KONTRAK_TRANS_AKHIR : '', 'class="span3 datepicker" id="TGL_KONTRAK_TRANS_AKHIR"'); ?>
            </div>
        </div>

        <div class="control-group">
            <label for="password" class="control-label">Jumlah Pasokan <span class="required"> *</span> : </label>
            <div class="controls">
            <?php echo form_input('JML_PASOKAN', !empty($default->JML_PASOKAN) ? $default->JML_PASOKAN : '', 'class="span2", id="JML_PASOKAN", placeholder="Max 30"'); ?>
            <?php echo anchor(null, 'Generate', array('id' => 'button-jml-kirim', 'class' => 'green btn')); ?>
        </div>
        </div>
        <br>
        <div class="content_table">
            <div class="well-content clearfix">
                    <div id='TextBoxesGroup'>
                        <div id="TextBoxDiv0">
                            
                        </div>
                    </div>
                    <input type='button' value='Add Button' id='addButton'>
                    <input type='button' value='Remove Button' id='removeButton'>
                    <input type='button' value='Get TextBox Value' id='getButtonValue'>                        
            </div>
        </div>
        </br>

        <div class="control-group">
            <label  class="control-label">Mekanisme Denda <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_dropdown('ID_DENDA', $option_denda, !empty($default->ID_DENDA) ? $default->ID_DENDA : '', 'class="span6 chosen" id="ID_DENDA" '); ?>
            </div>
        </div>     
        <div class="control-group" id="divKet">
            <label for="password" class="control-label">Keterangan Denda <span class="required">*</span> :</label>
            <div class="controls">
                    <?php
                        $data = array(
                          'name'        => 'KET_DENDA',
                          'id'          => 'KET_DENDA',
                          'value'       => !empty($default->KET_DENDA) ? $default->KET_DENDA : '',
                          'rows'        => '4',
                          'cols'        => '10',
                          'class'       => 'span6',
                          'style'       => '"none" placeholder="Ketik Keterangan Mekanisme Denda (Max 200)"'
                        );
                      echo form_textarea($data);
                    ?>
                    <span class="required" id="MaxKetDenda"></span>
            </div>
        </div>   
        <div class="control-group">
            <label for="password" class="control-label">Toleransi Losses <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('LOSSES', !empty($default->LOSSES) ? $default->LOSSES : '', 'class="span3" placeholder="Ketik Toleransi Losses" id="LOSSES" '); ?>  
                <sup>%</sup>
            </div>
        </div>   

        <div class="control-group">
            <label for="password" class="control-label">Nilai Kontrak (Rp) <span class="required">*</span> : </label>
            <div class="controls">
                <?php echo form_input('NILAI_KONTRAK', !empty($default->NILAI_KONTRAK_TRANS) ? $default->NILAI_KONTRAK_TRANS : '', 'class="span3"'); ?>
                <sup>Termasuk PPN 10 %</sup>
            </div>
        </div>
        <!-- <div class="control-group">
            <label for="password" class="control-label">Keterangan<span class="required">*</span> : </label>
            <div class="controls">
                  <?php echo form_input('KETERANGAN_TRANS', !empty($default->KET_KONTRAK_TRANS) ? $default->KET_KONTRAK_TRANS : '', 'class="span6"'); ?>
            </div>
        </div> -->

    <div class="form-actions">
        <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
        <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
    </div>
    <?php echo form_close(); ?>
</div><br>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        var counter = 1;

        $("#addButton").click(function () {
            if(counter>30){
                    alert("Max 30 data yang diperbolehkan");
                    return false;
            }

            var newTextBoxDiv = $(document.createElement('div'))
                 .attr("id", 'TextBoxDiv' + counter);


            var combo_depo ="<select class='form-control cls_depo' id='depo_ke"+ counter + "' name='depo_ke"+ counter + "'>"+
            "<option value='' disabled selected>--Pilih Depo--</option>"+
            <?php if ($option_depo != '')
                { foreach ($option_depo as $depo)
                     { ?>
                     "<option value='<?php echo $depo['ID_DEPO']?>'> <?php echo $depo['NAMA_DEPO'] ?></option>"+
                     <?php
                      }
                }?>
               "</select>";

            var combo_depo_transit ="<select class='form-control chosen cls_depo_transit' id='depotransit_ke"+ counter + "' name='depotransit_ke"+ counter + "'>"+
            "<option value='' selected>--Pilih Depo--</option>"+
            <?php if ($option_depo != '')
                { foreach ($option_depo as $depo)
                     { 
                        if ($depo['ID_DEPO']!='000') {
                        ?>
                            "<option value='<?php echo $depo['ID_DEPO']?>'> <?php echo $depo['NAMA_DEPO'] ?></option>"+
                     <?php
                        }
                      }
                }?>
               "</select><br><i>(*Depo/Dermaga Transit Non Pembangkit)</i>";                

            var combo_pembangkit ="<select class='form-control cls_kit_penerima' id='pembangkit_ke"+ counter + "' name='pembangkit_ke"+ counter + "' >"+
            "<option value='' selected>--Pilih KIT Penerima--</option>"+
            <?php if ($option_pembangkit != '')
                { foreach ($option_pembangkit as $pembangkit)
                     { ?>
                     "<option value='<?php echo $pembangkit['SLOC']?>'> <?php echo $pembangkit['LEVEL4'] ?></option>"+
                     <?php
                      }
                }?>
               "</select>";

            var combo_jalur ="<select class='form-control' id='jalur_ke"+ counter + "' name='jalur_ke"+ counter + "'>"+
            "<option value='' disabled selected>--Pilih Jalur--</option>"+
            <?php if ($option_jalur != '')
                { foreach ($option_jalur as $jalur)
                     { ?>
                     "<option value='<?php echo $jalur['VALUE_SETTING']?>'> <?php echo $jalur['NAME_SETTING'] ?></option>"+
                     <?php
                      }
                }?>
               "</select>";

            var text_harga_kontrak="<input type='text' id='harga_ke"+ counter + "' name='harga_ke"+ counter + "' placeholder='Harga (Rp) / L'> <sup>Termasuk PPN 10 %</sup>";
            var text_jarak="<input type='text' id='jarak_ke"+ counter + "' name='jarak_ke"+ counter + "' placeholder='Jarak (KM atau ML)' size='35'>";


            var cmb_level1 = "<select class='form-control cls_lv1' id='cmblv1_ke"+ counter + "' name='cmblv1_ke"+ counter + "' ><option value='' disabled selected>--Pilih Level 1--</option></select>";
            var cmb_level2 = "<select class='form-control cls_lv2' id='cmblv2_ke"+ counter + "' name='cmblv2_ke"+ counter + "' ><option value='' disabled selected>--Pilih Level 2--</option></select>";
            var cmb_level3 = "<select class='form-control cls_lv3' id='cmblv3_ke"+ counter + "' name='cmblv3_ke"+ counter + "' ><option value='' disabled selected>--Pilih Level 3--</option></select>";
            var cmb_level4 = "<select class='form-control' id='cmblv4_ke"+ counter + "' name='cmblv4_ke"+ counter + "' ><option value='' disabled selected>--Pilih KIT Pemasok--</option></select>";
           
            var req = '<span class="required">*</span>';

            var visi = '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Depo Pemasok ke '+req+': '+ counter + '</label>'+
            '<div class="controls">'+combo_depo+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label" id="lblv1_ke'+ counter + '">Level 1 Pemasok ke '+req+': '+ counter + '</label>'+
            '<div class="controls">'+cmb_level1+'</div></div>'+
            '</div><br>'+
            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">KIT Penerima ke '+req+': '+ counter + '</label>'+
            '<div class="controls">'+combo_pembangkit+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label" id="lblv2_ke'+ counter + '">Level 2 Pemasok ke '+req+': '+ counter + '</label>'+
            '<div class="controls">'+cmb_level2+'</div></div>'+
            '</div><br>'+

            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Depo Transit Penerima ke '+req+': '+ counter + '</label>'+
            '<div class="controls">'+combo_depo_transit+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label" id="lblv3_ke'+ counter + '">Level 3 Pemasok ke '+req+': '+ counter + '</label>'+
            '<div class="controls">'+cmb_level3+'</div></div>'+
            '</div><br>'+

            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Jalur ke '+req+': '+ counter + '</label>'+
            '<div class="controls">'+combo_jalur+'</div></div>'+
            '<div class="pull-left span1"><label for="password" class="control-label" id="lblv4_ke'+ counter + '">KIT Pemasok ke '+req+': '+ counter + '</label>'+
            '<div class="controls">'+cmb_level4+'</div></div>'+
            '</div><br>'+               

            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Jarak (KM atau ML) ke '+req+': '+ counter + '</label>'+
            '<div class="controls">'+text_jarak+'</div></div>'+
            '</div><br>'+

            '<div class="form_row">'+
            '<div class="pull-left"><label for="password" class="control-label">Harga (Rp) / L ke : '+ counter + '</label>'+
            '<div class="controls">'+text_harga_kontrak+'</div></div>'+
            '</div><hr>';

            newTextBoxDiv.after().html(visi);
            newTextBoxDiv.appendTo("#TextBoxesGroup");
            setVisibleLv('ke'+counter,false);
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
                msg += "\n Textbox #" + i + " : " + $('#jalur_ke' + i).val();
            }
            alert(msg);
        });

        $("#button-jml-kirim").click(function () {
            var x = $('#JML_PASOKAN').val(); 

            if(x>30){
                var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Max 30 data jumlah pengiriman yang diperbolehkan</div>';
                bootbox.alert(message, function() {});
                $('#JML_PASOKAN').val('30');
            }

            for (i = 1; i <= 30; i++) {
                $("#TextBoxDiv"+i).hide();
            }

            for (i = 1; i <= x; i++) {
                $("#TextBoxDiv"+i).show();

            }
        });

        for (i = 0; i < 30; i++) {
            $("#addButton").click();
        }

        for (i = 1; i <= 30; i++) {
            $("#TextBoxDiv"+i).hide();
        }

        if ($('input[name=KD_KONTRAK_TRANS]').val()){
            get_detail($('input[name=KD_KONTRAK_TRANS]').val()); 
        }

        for (i = 1; i <= 30; i++) {
            $('input[name=harga_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }

            });

            $('input[name=jarak_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
           
            });
        }

        $("#addButton").hide();
        $("#removeButton").hide();
        $("#getButtonValue").hide();
    });


    $(".datepicker").datepicker({
        format: 'yyyy-mm-dd', 
        autoclose:true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    function setCekTgl(){
        var dateStart = $('#TGL_KONTRAK_TRANS').val(); 
        var dateEnd = $('#TGL_KONTRAK_TRANS_AKHIR').val(); 

        if (dateEnd < dateStart){
            $('#TGL_KONTRAK_TRANS_AKHIR').datepicker('update', dateStart);
        }       
    }

    $('#TGL_KONTRAK_TRANS').on('change', function() {
        var dateStart = $(this).val(); 
        $('#TGL_KONTRAK_TRANS_AKHIR').datepicker('setStartDate', dateStart);
        setCekTgl();
    });

    $('#TGL_KONTRAK_TRANS_AKHIR').on('change', function() {
        setCekTgl();
    });

    $("#button-save").click(function () {
        $("#button-jml-kirim").click();
    });

    $('input[name=JML_PASOKAN]').inputmask("numeric", {radixPoint: ",",groupSeparator: "",digits: 0,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });
    $('input[name=NILAI_KONTRAK]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });
    $('input[name=LOSSES]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false, allowMinus: false,  min: 0, max: 100, oncleared: function () { self.Value(''); }
    });    

    $(".cls_depo").change(function (e) {
        var cmb_depo = e.target.id;
        var vke = cmb_depo.split('_');
        var vcek = $( "#"+cmb_depo).val();

        if (vcek=='000'){
            // $("#pembangkit_"+vke[1]).prop("disabled", false);
            setComboLevel(vke[1],false);
        } else {
            // $("#pembangkit_"+vke[1]).val('');
            // $("#pembangkit_"+vke[1]).prop("disabled", true);
            setComboLevel(vke[1],true);
        }
    });

    $(".cls_kit_penerima").change(function (e) {
        var cmb_kit = e.target.id;
        var vke = cmb_kit.split('_');
        var vcek = $( "#"+cmb_kit).val();        

        if (vcek){
            $("#depotransit_"+vke[1]).val("");            
            $("#depotransit_"+vke[1]).prop("disabled", true);            
        } else {                    
            $("#depotransit_"+vke[1]).prop("disabled", false);
        }
        $("#depotransit_"+vke[1]).data("placeholder","Select").trigger('liszt:updated');
    });

    $(".cls_depo_transit").change(function (e) {
        var cmb_depo = e.target.id;
        var vke = cmb_depo.split('_');
        var vcek = $( "#"+cmb_depo).val();     

        if (vcek){
            $("#pembangkit_"+vke[1]).val("");            
            $("#pembangkit_"+vke[1]).prop("disabled", true);            
        } else {                    
            $("#pembangkit_"+vke[1]).prop("disabled", false);
        }
        $("#pembangkit_"+vke[1]).data("placeholder","Select").trigger('liszt:updated');
    });     

    $(".cls_lv1").change(function (e) {
        var cmb_lv = e.target.id;
        var vke = cmb_lv.split('_');
        var vcek = $( "#"+cmb_lv).val();

        if (vcek==''){
            getComboLv1(vke[1],'');   
        }

        getComboLv2(vke[1],vcek);
    });

    $(".cls_lv2").change(function (e) {
        var cmb_lv = e.target.id;
        var vke = cmb_lv.split('_');
        var vcek = $( "#"+cmb_lv).val();

        getComboLv3(vke[1],vcek);
    });

    $(".cls_lv3").change(function (e) {
        var cmb_lv = e.target.id;
        var vke = cmb_lv.split('_');
        var vcek = $( "#"+cmb_lv).val();

        getComboLv4(vke[1],vcek);
    });

    function setVisibleLv(vid,vStatus){
        if (vStatus){
            $("#cmblv1_"+vid).show();
            $("#cmblv2_"+vid).show();
            $("#cmblv3_"+vid).show();
            $("#cmblv4_"+vid).show();
            $("#lblv1_"+vid).show();
            $("#lblv2_"+vid).show();
            $("#lblv3_"+vid).show();
            $("#lblv4_"+vid).show();
        } else {
            $("#cmblv1_"+vid).hide();
            $("#cmblv2_"+vid).hide();
            $("#cmblv3_"+vid).hide();
            $("#cmblv4_"+vid).hide();
            $("#lblv1_"+vid).hide();
            $("#lblv2_"+vid).hide();
            $("#lblv3_"+vid).hide();
            $("#lblv4_"+vid).hide();
        }       
    }

    function setComboLevel(vid,vbool){
        // $("#cmblv1_"+vid).prop("disabled", vbool);
        // $("#cmblv2_"+vid).prop("disabled", vbool);
        // $("#cmblv3_"+vid).prop("disabled", vbool);
        // $("#cmblv4_"+vid).prop("disabled", vbool);

        if (vbool){
            setComboHapus(vid,1); 
            setComboHapus(vid,2);
            setComboHapus(vid,3);
            setComboHapus(vid,4);
            setVisibleLv(vid,false);
        } else {
            setVisibleLv(vid,true);
            getComboLv1(vid,$('#ID_REGIONAL').val());
        }
    }

    function setComboHapus(vid,vlv){
        $("#cmblv"+vlv+"_"+vid).empty();
        if (vlv==4){
            $("#cmblv"+vlv+"_"+vid).append('<option value="">--Pilih KIT Pemasok--</option>');
        } else {
            $("#cmblv"+vlv+"_"+vid).append('<option value="">--Pilih Level '+vlv+'--</option>');    
        }
    }

    function getComboLv1(vid,val){
        var stateID = 'all';
        var vlink_url = '<?php echo base_url()?>master/kontrak_transportir/get_options_lv1/'+stateID;

        setComboHapus(vid,1);
        setComboHapus(vid,2);
        setComboHapus(vid,3);
        setComboHapus(vid,4);

        // if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $("#cmblv1_"+vid).append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                    });
                    // bootbox.hideAll();
                }
            });
            bootbox.hideAll();
        // } else {
        //     bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});    
        // }
    };

    function getComboLv2(vid,val){
        var stateID = val;
        var vlink_url = '<?php echo base_url()?>master/kontrak_transportir/get_options_lv2/'+stateID;

        setComboHapus(vid,2);
        setComboHapus(vid,3);
        setComboHapus(vid,4);

        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $("#cmblv2_"+vid).append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                        console.log("masuukkkk "+vid);
                    });
                    bootbox.hideAll();
                }
            });
        } 
    };

    function getComboLv3(vid,val){
        var stateID = val;
        var vlink_url = '<?php echo base_url()?>master/kontrak_transportir/get_options_lv3/'+stateID;

        setComboHapus(vid,3);
        setComboHapus(vid,4);

        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $("#cmblv3_"+vid).append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        } 
    };

    function getComboLv4(vid,val){
        var stateID = val;
        var vlink_url = '<?php echo base_url()?>master/kontrak_transportir/get_options_lv4/'+stateID;

        setComboHapus(vid,4);

        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $("#cmblv4_"+vid).append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        } 
    };

    function setComboEdit(vid,vlv,vrecid,vrecdata){
        $("#cmblv"+vlv+"_"+vid).empty();
        $("#cmblv"+vlv+"_"+vid).prop("disabled", false);

        if (vlv==4){
            $("#cmblv"+vlv+"_"+vid).append('<option value="">--Pilih Pembangkit--</option>');
            $("#cmblv"+vlv+"_"+vid).append('<option value="'+vrecid+'" selected>'+vrecdata+'</option>');
        } else {
            $("#cmblv"+vlv+"_"+vid).append('<option value="">--Pilih Level '+vlv+'--</option>');   
            $("#cmblv"+vlv+"_"+vid).append('<option value="'+vrecid+'" selected>'+vrecdata+'</option>'); 
        }
    }

    function get_detail(vId) {
        var data = {idx: vId};        
        bootbox.hideAll();
        bootbox.modal('<div class="loading-progress"></div>');
        $.post("<?php echo base_url()?>master/kontrak_transportir/get_detail_kirim_adendum/", data, function (data) {
            var rest = (JSON.parse(data));
            var x=0;
            for (i = 0; i < rest.length; i++) {
                x++;
                $("#depo_ke"+x).val(rest[i].ID_DEPO);                
                $("#jalur_ke"+x).val(rest[i].TYPE_KONTRAK_TRANS);
                $("#harga_ke"+x).val(rest[i].HARGA_KONTRAK_TRANS);
                $("#jarak_ke"+x).val(rest[i].JARAK_DET_KONTRAK_TRANS);

                if (rest[i].SLOC) {
                    $("#pembangkit_ke"+x).val(rest[i].SLOC);    
                } else {
                    $("#pembangkit_ke"+x).val("");    
                }
                if (rest[i].ID_DEPO_TRANSIT) {
                    $("#depotransit_ke"+x).val(rest[i].ID_DEPO_TRANSIT);    
                } else {
                    $("#depotransit_ke"+x).val("");
                }                 

                if (rest[i].SLOC_PEMASOK){
                    setVisibleLv('ke'+x,true);
                    setComboEdit('ke'+x,1,rest[i].COCODE,rest[i].LEVEL1);
                    setComboEdit('ke'+x,2,rest[i].PLANT,rest[i].LEVEL2);
                    setComboEdit('ke'+x,3,rest[i].STORE_SLOC,rest[i].LEVEL3);
                    setComboEdit('ke'+x,4,rest[i].SLOC_PEMASOK,rest[i].LEVEL4);
                }

                $("#TextBoxDiv"+x).show();
            }
            $("#JML_PASOKAN").val(x);
            bootbox.hideAll();
        });
    }

    setformfieldsize($('#NO_KONTRAK'), 200, '');
    $('#NO_KONTRAK').on('input propertychange paste', function(){        
        // var charLength = $(this).val().length;
        var str = this.value;
        str = str.replace(/\"/g,'');
        str = str.replace(/\'/g,'');
        str = str.replace(/\\/g,'');
        str = str.replace(/\[/g,'');
        str = str.replace(/\]/g,'');
        this.value = str;

        if(str.length >= 200){
            $('#MaxId').text('*Max 200');            
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

    setformfieldsize($('#KET_DENDA'), 200, '');
    $('#KET_DENDA').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 200){
            $('#MaxKetDenda').text('*Max 200');            
        } else {
            $('#MaxKetDenda').text('');
        }        
    }); 

    $('#LOSSES').on('keydown keyup change', function(){                
        var val = $(this).val();
        val = val.replace(/\./g, '');
        val = val.replace(/\,/g, '.');
        
        if(val > 100){
            $('#LOSSES').val('100');        
        }        
    });          
   
</script>