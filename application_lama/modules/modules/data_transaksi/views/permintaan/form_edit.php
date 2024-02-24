<?php
/**
 * Created by PhpStorm.
 * User: cf
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
                    <?php echo form_input('NO_NOMINASI', !empty($default->NO_NOMINASI) ? $default->NO_NOMINASI : '', 'class="span6" placeholder="Ketik Nomor Nominasi / Permintaan" disabled'); ?>
                    <?php echo form_hidden('IS_TOLAK', !empty($default->IS_TOLAK) ? $default->IS_TOLAK : '', ''); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tanggal Nominasi<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('TGL_MTS_NOMINASI', !empty($default->TGL_MTS_NOMINASI) ? $default->TGL_MTS_NOMINASI : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal" id="TGL_MTS_NOMINASI" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pemasok<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_PEMASOK', $option_pemasok, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Regional<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 1<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 2<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Level 3<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6" disabled id="sloc"'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" disabled'); ?>
                </div>
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
                    <?php echo form_input('VOLUME_NOMINASI', !empty($default->VOLUME_NOMINASI) ? $default->VOLUME_NOMINASI : '', 'class="span3" placeholder="Volume Nominasi" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jumlah Pengiriman<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('JML_KIRIM', !empty($default->JML_KIRIM) ? $default->JML_KIRIM : '', 'class="span2" placeholder="Jumlah Pengiriman" id="JML_KIRIM" disabled'); ?>
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

            <div id="divTolak" hidden>
                <hr>
                <div class="control-group">
                    <label class="control-label">Keterangan Tolak<span class="required">*</span> : </label>
                    <div class="controls">
                        <!-- <?php //echo form_input('KET_BATAL', !empty($default->KET_BATAL) ? $default->KET_BATAL : '', 'class="span6" placeholder="Keterangan Tolak Permintaan" '); ?> -->
                        <?php
                            $data = array(
                              'name'        => 'KET_BATAL',
                              'id'          => 'KET_BATAL',
                              'value'       => !empty($default->KET_BATAL) ? $default->KET_BATAL : '',
                              'rows'        => '4',
                              'cols'        => '10',
                              'class'       => 'span6',
                              'style'       => '"none" placeholder="Ketik Keterangan Tolak Permintaan (Max 200)" data-maxsize="200" '
                            );
                          echo form_textarea($data);
                        ?>
                        <?php echo form_hidden('STATUS_TOLAK', !empty($default->STATUS_TOLAK) ? $default->STATUS_TOLAK : '', 'class="span1" placeholder="Status Tolak Permintaan" '); ?>
                        <span class="required" id="MaxKet"></span>
                    </div>
                </div>
            </div>            

            <div class="form-actions">
                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
                <?php echo hgenerator::render_button_group($button_group); ?>
            </div>
            <?php
        echo form_close(); ?>
    </div>
    <br><br>
</div>


<script type="text/javascript">
    $('input[name=VOLUME_NOMINASI]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
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

    setformfieldsize($('#KET_BATAL'), 200, '');
    $('#KET_BATAL').on('input propertychange paste', function(){        
        var charLength = $(this).val().length;

        if(charLength >= 200){
            $('#MaxKet').text('*Max 200');            
        } else {
            $('#MaxKet').text('');
        }        
    });      

$(document).ready(function(){

    var counter = 1;

    $("#addButton").click(function () {
        if(counter>31){
                alert("Max 31 data yang diperbolehkan");
                return false;
        }

        var newTextBoxDiv = $(document.createElement('div'))
             .attr("id", 'TextBoxDiv' + counter);

        var visi = '<div class="form_row"><div class="pull-left"><label for="password" class="control-label">Tgl Kirim ke : '+ counter + '</label><div class="controls"><input type="text" id="tgl_ke'+ counter + '" name="tgl_ke'+ counter + '" class="input-append date form_datetime" placeholder="Tanggal Kirim" disabled></div></div><div class="pull-left"><label for="password" class="control-label">Volume (L) ke : '+ counter + '</label><div class="controls"><input type="text" id="vol_ke'+ counter + '" name="vol_ke'+ counter + '" placeholder="Volume (L)" onChange="setHitungKirim()" disabled></div></div></div><br>';     

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


    for (i = 0; i < 31; i++) {
        $("#addButton").click();
    }

    for (i = 1; i <= 31; i++) {
        $("#TextBoxDiv"+i).hide();
    }   

    for (i = 1; i <= 31; i++) {
        var val="input[name=vol_ke"+i+"]";
        $('input[name=vol_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,oncleared: function () { self.Value(''); }
        });
    }

    if ($('input[name=NO_NOMINASI]').val()){
        get_detail($('input[name=NO_NOMINASI]').val(), $('#sloc :selected').val()); 
    }

    $("#addButton").hide();
    $("#removeButton").hide();
    $("#getButtonValue").hide();
});
</script>