<?php
/**
 * @module TRANSAKSI
 * @author  CF
 * @created at 11 FEBRUARI 2019
 * @modified at 11 FEBRUARI 2019
 */ 
?>

<div class="row-fluid">
    <div id="form_input"">
        <div class="box-content">

            <div class="row-fluid">
                <div class="span12">
                    <div id ="index-content" class="well-content">
                        <div class="box-title">
                            Pencarian
                        </div>
                        <div class="well">
                            <div class="well-content clearfix">
                                <?php echo form_open_multipart('', array('id' => 'ffilter-cari')); ?>
                                <div class="form_row">
                                    <div class="pull-left span4">
                                        <label for="password" class="control-label">Pembangkit : </label>
                                        <div class="controls">
                                            <?php echo form_dropdown('SLOC_CARI', $options_lv4_cari, !empty($default->SLOC) ? $default->SLOC : '', 'id="SLOC_CARI" class="chosen span11"'); ?>
                                        </div>                                    
                                    </div>
                                    <div class="pull-left span4">
                                        <label></label>                                    
                                        <div class="controls">
                                            <?php echo anchor(NULL, "<i class='icon-zoom-in'></i> Quick Search", array('class' => 'btn yellow', 'id' => 'button-filter-cari')); ?>
                                        </div>
                                    </div> 
                                </div>
                                <div id="divData"></div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>                    
                        <div class="well">
                            <div class="well-content clearfix">
                                <?php echo form_open_multipart('', array('id' => 'ffilter-input')); ?>
                                <div class="form_row">
                                    <div class="pull-left span4">
                                        <label for="password" class="control-label">Regional : </label>
                                        <div class="controls">
                                            <?php echo form_dropdown('lvl0', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0" class="chosen span11"'); ?>
                                        </div>
                                    </div>
                                    <div class="pull-left span4">
                                        <label for="password" class="control-label">Level 1 : </label>
                                        <div class="controls">
                                            <?php echo form_dropdown('lvl1', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1" class="chosen span11"'); ?>
                                        </div>
                                    </div>
                                    <div class="pull-left span4">
                                        <label for="password" class="control-label">Level 2 : </label>
                                        <div class="controls">
                                            <?php echo form_dropdown('lvl2', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2" class="chosen span11"'); ?>
                                        </div>
                                    </div>
                                </div><br/>
                                <div class="form_row">
                                    <div class="pull-left span4">
                                        <label for="password" class="control-label">Level 3 : </label>
                                        <div class="controls">
                                            <?php echo form_dropdown('lvl3', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3" class="chosen span11"'); ?>
                                        </div>
                                    </div>
                                    <div class="pull-left span4">
                                        <label for="password" class="control-label">Pembangkit : </label>
                                        <div class="controls">
                                            <?php echo form_dropdown('lvl4', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4" class="chosen span11"'); ?>
                                        </div>
                                    </div>
                                    <!-- 
                                    <div class="pull-left span4">
                                        <label></label>                                    
                                        <div class="controls">
                                            <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-filter')); ?>&nbsp;
                                            <?php echo anchor(NULL, "<i class='icon-refresh'></i> Reset", array('class' => 'btn red', 'id' => 'button-reset')); ?>
                                        </div>
                                    </div>
                                     -->
                                </div>                                
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <hr>
                        <?php
                        $hidden_form = array('id' => !empty($id) ? $id : '');
                        echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
                            ?>
                            <div class="control-group">
                                <label class="control-label">Jenis Transaksi<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('JNS_TRX', $options_jns_trx, !empty($default->JNS_TRX) ? $default->JNS_TRX : '', 'class="span3 chosen" id="JNS_TRX"'); ?>
                                    <input type="hidden" id="IDGROUP" name="IDGROUP" value="<?php echo !empty($default->IDGROUP) ? $default->IDGROUP : $IDGROUP ;?>" />
                                    <input type="hidden" id="SLOC_KIRIM" name="SLOC_KIRIM" value="<?php echo !empty($default->SLOC) ? $default->SLOC : '' ;?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">No Transaksi<span class="required">*</span> : </label>
                                <div class="controls">
                                     <?php echo form_input('NO_TRX', !empty($default->NO_TRX) ? $default->NO_TRX : '', 'class="span5" placeholder="Ketik No Transaksi" id="NO_TRX"'); ?>
                                     <span class="required" id="MaxId"></span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tanggal<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php echo form_input('TGL_PENGAKUAN', !empty($default->TGL_PENGAKUAN) ? $default->TGL_PENGAKUAN : '', 'class="span2 input-append date form_datetime" placeholder="Pilih Tanggal" id="TGL_PENGAKUAN"'); ?>
                                </div>
                            </div>   

                            <div class="control-group">
                                <label class="control-label">Keterangan<span class="required">*</span> : </label>
                                <div class="controls">
                                    <?php
                                        $data = array(
                                          'name'        => 'KETERANGAN',
                                          'id'          => 'KETERANGAN',
                                          'value'       => !empty($default->KETERANGAN) ? $default->KETERANGAN : '',
                                          'rows'        => '4',
                                          'cols'        => '10',
                                          'class'       => 'span6',
                                          'style'       => '"none" placeholder="Ketik Keterangan (Max 200)" data-maxsize="200"'
                                        );
                                      echo form_textarea($data);
                                    ?>
                                    <span class="required" id="MaxKet"></span>
                                </div>
                            </div>
                            <div class="form-actions">
                                <?php 
                                // if ($this->laccess->otoritas('add')) {
                                    // echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_file(this.id, '#finput', '#button-back');"));                                    
                                    echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')"));
                                    // echo "&nbsp";
                                // }
                                ?>
                            </div>
                            <?php
                        echo form_close(); ?>

                    </div>
                </div>            
            </div>             


        </div>
    </div>
    <br><br>

    <div id="form_data"">
        <div class="box-content">

            <div class="row-fluid">
                <div class="span12">
                    <div id ="index-content" class="well-content">
                        <div class="box-title">
                            Data Rollback Transaksi
                        </div>
                        <div class="well">
                            <!-- <div class="well-content clearfix"> -->
                                <div id="content_table_detail" data-source="<?php echo $data_sources_detail; ?>" data-filter="#ffilter_detail"></div>
        
                                <div class="form-actions">
                                    <div class="pull-left span9">
                                        <label class="control-label">Total Volume DO/TUG/BA (L) : <lb id="V_TERIMA">0</lb></label><br>
                                        <label class="control-label">Total Volume Penerimaan (L) : <lb id="V_TERIMA_REAL">0</lb></label>
                                    </div>
                                    <div class="pull-right">
                                        <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
                                    </div>
                                </div>

                            <!-- </div> -->
                        </div>    
                    </div>
                </div>            
            </div>             


        </div>
    </div>
    <br><br>    
</div>

<script type="text/javascript">
    var vLevelUser = "<?php echo $set_lv; ?>";
    var vIsAdd = "<?php echo $this->laccess->otoritas('add'); ?>";

    $('.chosen').chosen();
    load_table('#content_table_detail', 1, '#ffilter_detail');
    $('#button-filter-detail').click(function() {
        load_table('#content_table_detail', 1, '#ffilter_detail');
    });

    $(".form_datetime").datepicker({        
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });   

    // setDefaultCombo();
    function setDefaultCombo(){
        var _level = "<?php echo $this->session->userdata('level_user');?>";    
        var _kode_level = "<?php echo $this->session->userdata('kode_level');?>";

        $("select").trigger("liszt:updated");

        if (_level==1){
            $('#lvl3').empty();
            $('#lvl3').append('<option value="">--Pilih Level 3--</option>');
            $('#lvl3').data("placeholder","Select").trigger('liszt:updated');                                    
        }

        if (_level==0){            
            if ((_kode_level=='')||(_kode_level==0)){
                $('#lvl0').val('');
                $('#lvl0').data("placeholder","Select").trigger('liszt:updated');
                $('#lvl0').change(); 
            }           
        } else {
            get_options_lv4_all($('#lvl'+_level).val());  
            get_options_lv4_all_Q($('#lvl'+_level).val());  
        }     
    }    

    function setComboDefault(_id,_unit,_nama){
        if ($(_id+' option').size() <= 1){
            $(_id).empty();
            $(_id).append('<option value='+_unit+'>'+_nama+'</option>');
        } else {
            $(_id).val(_unit);
        }                   
        $(_id).data("placeholder","Select").trigger('liszt:updated');
    }    

    function get_data_unit(sloc,sloc_cari){
        bootbox.hideAll();
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('dashboard/info_pembangkit/get_data_unit'); ?>",                
            data: { "SLOC": sloc},
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data_unit gagal');                
            },            
            success:function(data) {                 
                $.each(data, function () {
                    // $("#lvl0").val(this.ID_REGIONAL);
                    // $('#lvl0').data("placeholder","Select").trigger('liszt:updated');
                    setComboDefault('#lvl0',this.ID_REGIONAL,this.LEVEL1);
                    setComboDefault('#lvl1',this.COCODE,this.LEVEL1);
                    setComboDefault('#lvl2',this.PLANT,this.LEVEL2);
                    setComboDefault('#lvl3',this.STORE_SLOC,this.LEVEL3);
                    if (sloc_cari){
                        setComboDefault('#lvl4',this.SLOC,this.LEVEL4); 
                        $('#SLOC_KIRIM').val(this.SLOC);   
                    }
                });             
                    
                bootbox.hideAll();

                if (sloc_cari){
                    // get_data(sloc_cari);
                }
            }
        });    
    }    

    $('#button-filter-cari').click(function() {
        var sloc = $('#SLOC_CARI').val();
        if (sloc) {            
            setDefaultCombo();
            get_data_unit(sloc,sloc);            
        } else {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Pencarian Pembangkit harus dipilih-- </div>', function() {});
        }
    });  

    function simpan_file() {
      var url = "<?php echo base_url() ?>data_transaksi/penerimaan/proses";
      bootbox.confirm('Anda yakin akan menyimpan data ?', "Tidak", "Ya", function(e) {
        if(e){
          bootbox.modal('<div class="loading-progress"></div>');

            $('#finput').ajaxSubmit({
                beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
                    },
                success: function (data) {
                  $(".bootbox").modal("hide");
                  var message = '';
                  var content_id = data[3];

                  if (data[0]) {
                    var icon = 'icon-ok-sign';
                    var color = '#0072c6;';
                  } else {
                    var icon = 'icon-remove-sign'; 
                    var color = '#ac193d;';
                  }

                  message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                  message += data[2];

                  bootbox.alert(message, function() {
                    if (data[0]) {
                        load_table('#content_table_detail', 1, '#ffilter_detail');
                        get_sum_volume($('#IDGROUP').val());
                        reset_file_upload();
                        set_tombol(0);
                        if (typeof cek_notif !== 'undefined' && $.isFunction(cek_notif)) {
                            cek_notif();
                        }                         
                        $('input[name="id"]').val('');
                        $('#PATH_FILE_EDIT').val('');
                        $('#divDokumen').empty();
                        $('html, body').animate({scrollTop: $("#divBawah").offset().top}, 1000);  
                    }                        
                  });
                }
            });
        }
      });
    }  

    function get_sum_volume(id) {
        var param = "IDGROUP="+id;

        $.post("<?php echo base_url()?>data_transaksi/penerimaan/get_sum_volume/", param, function (data) {
            var data_detail = (JSON.parse(data));

            for (i = 0; i < data_detail.length; i++) {
                $('#V_TERIMA').html(formatNumber(data_detail[i].V_TERIMA));
                $('#V_TERIMA_REAL').html(formatNumber(data_detail[i].V_TERIMA_REAL));                
            }
        });
    }   

    function formatNumber (num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
    }

    // filter combo
    function setDefaultLv1(){
        $('#lvl1').empty();
        $('#lvl1').append('<option value="">--Pilih Level 1--</option>');
        $('#lvl1').data("placeholder","Select").trigger('liszt:updated');
    }

    function setDefaultLv2(){
        $('#lvl2').empty();
        $('#lvl2').append('<option value="">--Pilih Level 2--</option>');
        $('#lvl2').data("placeholder","Select").trigger('liszt:updated');
    }

    function setDefaultLv3(){
        $('#lvl3').empty();
        $('#lvl3').append('<option value="">--Pilih Level 3--</option>');
        $('#lvl3').data("placeholder","Select").trigger('liszt:updated');
    }

    function setDefaultLv4(){
        $('#lvl4').empty();
        $('#lvl4').append('<option value="">--Pilih Pembangkit--</option>');
        $('#lvl4').data("placeholder","Select").trigger('liszt:updated');
    }

    $('#lvl0').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/get_options_lv1/'+stateID;
        setDefaultLv1();
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();

        if (stateID==''){
            vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/get_options_lv4/all';    
        }
        // if(stateID) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                if (stateID==''){
                  $.each(data, function(key, value) {
                      $('#lvl4').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                  });
                  $('#lvl4').data("placeholder","Select").trigger('liszt:updated');
                } else {
                  $.each(data, function(key, value) {
                      $('#lvl1').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                  });
                  $('#lvl1').data("placeholder","Select").trigger('liszt:updated');                    
                  get_options_lv4_all(stateID);
                }

                bootbox.hideAll();
              }
          });
        // }                
    });

    $('#lvl1').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/get_options_lv2/'+stateID;
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl2').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                  });
                  $('#lvl2').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
                  get_options_lv4_all(stateID);
              }
          });
        }
    });

    $('#lvl2').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/get_options_lv3/'+stateID;
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl3').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                  });
                  $('#lvl3').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
                  get_options_lv4_all(stateID);
              }
          });
        }
    });

    $('#lvl3').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/get_options_lv4/'+stateID;
        setDefaultLv4();
        if(stateID) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl4').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                  });
                  $('#lvl4').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
              }
          });
        }
    }); 

    $('#lvl4').on('change', function() {
        var stateID = $(this).val();
        $('#SLOC_KIRIM').val(stateID);
    });     

    function get_options_lv4_all(unit) {        
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/options_lv4_all/'+unit;
        setDefaultLv4();
        if(unit) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl4').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                  });
                  $('#lvl4').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
              }
          });
        }
    };    

    function get_options_lv4_all_Q(unit) {        
        var vlink_url = '<?php echo base_url()?>dashboard/info_pembangkit/options_lv4_all/'+unit;
        $('#lvl4_cari').empty();
        $('#lvl4_cari').append('<option value="">--Pilih Pembangkit--</option>');
        $('#lvl4_cari').data("placeholder","Select").trigger('liszt:updated');
        if(unit) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl4_cari').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                  });
                  $('#lvl4_cari').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
              }
          });
        }
    }; 

    function setLv1(id_up,id_set){        
        bootbox.hideAll();
        var stateID = id_up;
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv1/'+stateID;        
        setDefaultLv1();
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();        
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        if (vLevelUser >= 1) {
                            if (id_set==value.COCODE){
                                $('#COCODE').empty();
                                $('#COCODE').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');                                
                            }
                        } else {
                            $('#COCODE').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');    
                        }                        
                    });
                    $('#COCODE').val(id_set);
                    $('#COCODE').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    };

    function setLv2(id_up,id_set){        
        bootbox.hideAll();
        var stateID = id_up;
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv2/'+stateID;
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();        
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        if (vLevelUser >= 2) {
                            if (id_set==value.PLANT){
                                $('#PLANT').empty();
                                $('#PLANT').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');                                
                            }
                        } else {
                            $('#PLANT').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');    
                        }
                    });
                    $('#PLANT').val(id_set);
                    $('#PLANT').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    };    

    function setLv3(id_up,id_set){        
        bootbox.hideAll();
        var stateID = id_up;
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv3/'+stateID;        
        setDefaultLv3();
        setDefaultLv4();        
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        if (vLevelUser >= 3) {
                            if (id_set==value.STORE_SLOC){
                                $('#STORE_SLOC').empty();
                                $('#STORE_SLOC').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                            }
                        } else {
                            $('#STORE_SLOC').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');    
                        }
                    });
                    $('#STORE_SLOC').val(id_set);
                    $('#STORE_SLOC').data("placeholder","Select").trigger('liszt:updated');
                    bootbox.hideAll();
                }
            });
        }
    };  

    function setLv4(id_up,id_set){        
        bootbox.hideAll();
        var stateID = id_up;
        var vlink_url = '<?php echo base_url()?>data_transaksi/penerimaan/get_options_lv4/'+stateID;                
        setDefaultLv4();        
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        if (vLevelUser >= 4) {
                            if (id_set==value.SLOC){
                                $('#pembangkit').empty();
                                $('#pembangkit').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                            }
                        } else {
                            $('#pembangkit').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');    
                        } 
                    });   
                    $('#pembangkit').val(id_set);
                    $('#pembangkit').data("placeholder","Select").trigger('liszt:updated');
                            
                    bootbox.hideAll();
                }
            });
        }
    };  

    setformfieldsize($('#NO_TRX'), 60, '');
    $('#NO_TRX').on('input propertychange paste', function(){        
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



