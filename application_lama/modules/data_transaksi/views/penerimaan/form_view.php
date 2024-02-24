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
                <label class="control-label">Tanggal Penerimaan (DO/TUG/BA)<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('TGL_PENERIMAAN', !empty($default->TGL_PENERIMAAN) ? $default->TGL_PENERIMAAN : '', 'class="span2 input-append date form_datetime" placeholder="Tanggal Penerimaan (DO/BA)" id="TGL_PENERIMAAN" disabled'); ?>
                    <input type="hidden" id="IDGROUP" name="IDGROUP" value="<?php echo !empty($default->IDGROUP) ? $default->IDGROUP : $IDGROUP ;?>" />
                    <?php echo form_hidden('IS_TOLAK', !empty($default->IS_TOLAK) ? $default->IS_TOLAK : '', ''); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Tanggal Pengakuan Fisik<span class="required">*</span> : </label>
                <div class="controls">
                     <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_PENGAKUAN) ? $default->TGL_PENGAKUAN : '', 'class="span2 input-append date form_datetime" placeholder="Tanggal Pengakuan Fisik" id="TGL_PENGAKUAN" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Transportir<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_TRANSPORTIR', $option_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label  class="control-label">Regional <span class="required">*</span> : </label>
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
                    <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'class="span6" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Pemasok<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_PEMASOK', $option_pemasok, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6" disabled'); ?>
                </div>
            </div>            
            <div class="control-group">
                <label class="control-label">Jenis Penerimaan<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('VALUE_SETTING', $option_jenis_penerimaan, !empty($default->JNS_PENERIMAAN) ? $default->JNS_PENERIMAAN : '', 'class="span3" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Nomor Penerimaan<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NO_PENERIMAAN', !empty($default->NO_MUTASI_TERIMA) ? $default->NO_MUTASI_TERIMA : '', 'class="span6" placeholder="Nomor Penerimaan" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Jenis BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_JNS_BHN_BKR', $option_jenis_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span3" id="jnsbbm" disabled'); ?>
                </div>
            </div>

            <div class="control-group" id="komponen" style="<?php echo !empty($default->IS_MIX_BBM) ? '' : 'display:none;' ;?>">
                <label class="control-label">Komponen BBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('KOMPONEN', $option_komponen, !empty($default->ID_KOMPONEN_BBM) ? $default->ID_KOMPONEN_BBM : '', 'class="span3" id="cbokomponen" disabled'); ?>
					<input type="hidden" id="ismix" name="ismix" value="<?php echo !empty($default->IS_MIX_BBM) ? $default->IS_MIX_BBM : '' ;?>" />
                </div>
            </div>

            <div class="control-group" id="komponen_bio" style="<?php echo !empty($default->JNS_BIO) ? '' : 'display:none;' ;?>">
                <label class="control-label">Komponen BIO<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('JNS_BIO', $option_komponen_bio, !empty($default->JNS_BIO) ? $default->JNS_BIO : '', 'class="span3" id="JNS_BIO" disabled'); ?>
                    <input type="hidden" id="JNS_BIO_EDIT" name="JNS_BIO_EDIT" value="<?php echo !empty($default->JNS_BIO) ? $default->JNS_BIO : '' ;?>" />
                </div>
            </div>            

            <div class="control-group">
                <label class="control-label">Volume DO/TUG/BA (L)<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('VOL_PENERIMAAN', !empty($default->VOL_TERIMA) ? $default->VOL_TERIMA : '', 'class="span3 rp" placeholder="Volume DO / BA" disabled'); ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Volume Penerimaan (L)<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('VOL_PENERIMAAN_REAL', !empty($default->VOL_TERIMA_REAL) ? $default->VOL_TERIMA_REAL : '', 'class="span3 rp" placeholder="Volume Penerimaan" disabled'); ?>
                </div>
                <div style="display:none">
                    <?php echo form_input('STATUS_MUTASI_TERIMA', !empty($default->STATUS_MUTASI_TERIMA) ? $default->STATUS_MUTASI_TERIMA : '0', 'disabled'); ?>
                </div> 
            </div>

            <div class="control-group">                
                <label for="password" class="control-label"></label>                
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

            <div class="control-group">
                <label class="control-label">Keterangan : </label>
                <div class="controls">
                    <!-- <?php //echo form_input('KET_MUTASI_TERIMA', !empty($default->KET_MUTASI_TERIMA) ? $default->KET_MUTASI_TERIMA : '', 'class="span6" placeholder="Keterangan Penerimaan" disabled'); ?> -->
                    <?php
                        $data = array(
                          'name'        => 'KET_MUTASI_TERIMA',
                          'id'          => 'KET_MUTASI_TERIMA',
                          'value'       => !empty($default->KET_MUTASI_TERIMA) ? $default->KET_MUTASI_TERIMA : ' ',
                          'rows'        => '4',
                          'cols'        => '10',
                          'class'       => 'span6',
                          'style'       => '"none" placeholder="Keterangan Penerimaan (Max 200)" disabled="false"'
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
                        <!-- <?php //echo form_input('KET_BATAL', !empty($default->KET_BATAL) ? $default->KET_BATAL : '', 'class="span6" placeholder="Keterangan Tolak Penerimaan" '); ?> -->
                        <?php
                            $data = array(
                              'name'        => 'KET_BATAL',
                              'id'          => 'KET_BATAL',
                              'value'       => !empty($default->KET_BATAL) ? $default->KET_BATAL : '',
                              'rows'        => '4',
                              'cols'        => '10',
                              'class'       => 'span6',
                              'style'       => '"none" placeholder="Ketik Keterangan Tolak Penerimaan (Max 200)"'
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
            <?php
        echo form_close(); ?>
    </div>
    <br><br>
</div>

<script type="text/javascript">
    $(".form_datetime").datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    $('.rp').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
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

    function setKomponenBIO(id, id_set){
        var v_url = '<?php echo base_url()?>data_transaksi/penerimaan/option_komponen_bio/'+id;
        $('select[name="JNS_BIO"]').empty();
        $('select[name="JNS_BIO"]').append('<option value="">--Pilih Komponen BIO--</option>');

        if (id=='003'){         
            $.ajax({
                url: v_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="JNS_BIO"]').append('<option value="'+ value.KODE_JNS_BHN_BKR +'">'+ value.NAMA_JNS_BHN_BKR +'</option>');
                    });

                    if (id_set){
                        $('#JNS_BIO').val(id_set);    
                    }
                    
                    $('select[name="JNS_BIO"]').data("placeholder","Select").trigger('liszt:updated');
                }
            });
        }

        if (id=='003'){
            $('#komponen_bio').show();    
        } else {
            $('#komponen_bio').hide();
        }     
    }; 

    if ($('input[name="id"]').val()){        
        var jnsbbm = $('#jnsbbm').val();

        if (jnsbbm=='003'){
            //val komponen bio dari jenis bbm bio
            setKomponenBIO(jnsbbm, $('#JNS_BIO_EDIT').val());
        }        
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
</script>