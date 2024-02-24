<!-- /**
 * @module HELPDESK ROLLBACK
 * @author  BAKTI DWI DHARMA WIJAYA
 * @created at 24 APRIL 2019
 * @modified at 25 APRIL 2019
 */ -->
 <div class="row-fluid">
   <div id ="index-content" class="well-content">
        <div class="box-title">
            <?php echo (isset($page_title)) ? $page_title : 'Untitle'; ?>
        </div>
        <div class="box_content">
            <div class="well">
                <div class="well-content clearfix">
                    <?php echo form_open_multipart('', array('id' => 'ffilter-cari')); ?>
                    <div class="form_row">
                        <div class="pull-left span4">
                            <label for="password" class="control-label">Pembangkit : </label>
                            <div class="controls">
                                <?php echo form_dropdown('SLOC_CARI', $lv4_options_cari, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4_cari" class="chosen span11"'); ?>
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
        <?php echo form_open_multipart($form_action, array('id' => 'f-input','class="form-horizontal"')); ?>
            <div class="well-content clearfix">
                <div class="form_row">
                    <div class="pull-left span4">
                        <label for="password" class="control-label">Regional : </label>
                        <div class="controls">
                            <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0_form" class="span11"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span4">
                        <label for="password" class="control-label">Level 1 : </label>
                        <div class="controls">
                            <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1_form" class="span11"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span4">
                        <label for="password" class="control-label">Level 2 : </label>
                        <div class="controls">
                            <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2_form" class="span11"'); ?>
                        </div>
                    </div>
                </div>
                <br/>
                <div class="form_row">
                    <div class="pull-left span4">
                        <label for="password" class="control-label">Level 3 : </label>
                        <div class="controls">
                            <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3_form" class="span11"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span4">
                        <label for="password" class="control-label">Pembangkit : </label>
                        <div class="controls">
                            <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4_form" class="span11"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span4">
                        <label></label>                                    
                        <div class="controls">
                            <?php echo anchor(NULL, "<i class='icon-refresh'></i> Reset", array('class' => 'btn red', 'id' => 'button-reset')); ?>
                        </div>
                    </div>                                
                </div>
            </div>    
            <div class="well-content clearfix"> 
                <div class="control-group">
                    <label for="password" class="control-label">Jenis Transaksi <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('JNS_TRX', $options_trans, !empty($default->JNS_TRX) ? $default->JNS_TRX : '', 'class="span6"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">No Transaksi <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php 
                        $attr = array('name' => 'NO_TRX','id' => 'NO_TRX','value' => !empty($default->NO_TRX) ? $default->NO_TRX : '','class' => 'form-control');
                        echo form_input($attr); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Tanggal Pengakuan <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php 
                        $attr = array('name' => 'TGL_PENGAKUAN','id' => 'TGL_PENGAKUAN','value' => !empty($default->TGL_PENGAKUAN) ? $default->TGL_PENGAKUAN : '','class' => 'form-control datepicker');
                        echo form_input($attr); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Jenis BBM <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_JNS_BHN_BKR', $options_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span6" id="bbm"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Alasan Rollback <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php 
                        $attr = array('name' => 'ALASAN','id' => 'ALASAN','value' => !empty($default->ALASAN) ? $default->ALASAN : '','rows' => '3','cols' => '50','class' => 'form-control');
                        echo form_textarea($attr); ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#f-input', '#button-back')")); ?>
                    <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
                </div>
            </div>
        <?php echo form_close(); ?>   
                
            
            
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        $('.chosen').chosen();
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left"
        });

        setDefaultCombo();

        $('#button-filter-cari').click(function() {
            var sloc = $('#lvl4_cari').val();
            if (sloc) {            
                setDefaultCombo();
                get_data_unit(sloc,sloc);            
            } else {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Pencarian Pembangkit harus dipilih-- </div>', function() {});
            }
        }); 

        $('#button-reset').click(function(){
            bootbox.confirm('Anda yakin akan Reset Pencarian ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#ffilter-cari')[0].reset();                
                    setDefaultCombo();
                }
            });
        });

        $('#lvl0_form').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>user_management/helpdesk/get_options_lv1/'+stateID;
            setDefaultLv1();
            setDefaultLv2();
            setDefaultLv3();
            setDefaultLv4();

            if (stateID==''){
                vlink_url = '<?php echo base_url()?>user_management/helpdesk/get_options_lv4/all';    
            }
                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if (stateID==''){
                            $.each(data, function(key, value) {
                                $('#lvl4_form').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                            });
                            $('#lvl4_form').data("placeholder","Select").trigger('liszt:updated');
                        } else {
                            $.each(data, function(key, value) {
                                $('#lvl1_form').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                            });
                            $('#lvl1_form').data("placeholder","Select").trigger('liszt:updated');                    
                            get_options_lv4_all(stateID);
                        }

                        bootbox.hideAll();
                    }
                });
        });

        $('#lvl1_form').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>user_management/helpdesk/get_options_lv2/'+stateID;
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
                          $('#lvl2_form').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                      });
                      $('#lvl2_form').data("placeholder","Select").trigger('liszt:updated');
                      bootbox.hideAll();
                      get_options_lv4_all(stateID);
                  }
              });
            }
        });

        $('#lvl2_form').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>user_management/helpdesk/get_options_lv3/'+stateID;
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
                          $('#lvl3_form').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                      });
                      $('#lvl3_form').data("placeholder","Select").trigger('liszt:updated');
                      bootbox.hideAll();
                      get_options_lv4_all(stateID);
                  }
              });
            }
        });

        $('#lvl3_form').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>user_management/helpdesk/get_options_lv4/'+stateID;
            setDefaultLv4();
            if(stateID) {
              bootbox.modal('<div class="loading-progress"></div>');
              $.ajax({
                  url: vlink_url,
                  type: "GET",
                  dataType: "json",
                  success:function(data) {
                      $.each(data, function(key, value) {
                          $('#lvl4_form').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                      });
                      $('#lvl4_form').data("placeholder","Select").trigger('liszt:updated');
                      bootbox.hideAll();
                  }
              });
            }
        }); 

    })

    function setDefaultCombo(){
        var _level = "<?php echo $this->session->userdata('level_user');?>";    
        var _kode_level = "<?php echo $this->session->userdata('kode_level');?>";

        $("select").trigger("liszt:updated");

        if (_level==1){
            $('#lvl3_form').empty();
            $('#lvl3_form').append('<option value="">--Pilih Level 3--</option>');
            $('#lvl3_form').data("placeholder","Select").trigger('liszt:updated');                                    
        }

        if (_level==0){            
            if ((_kode_level=='')||(_kode_level==0)){
                $('#lvl0_form').val('');
                $('#lvl0_form').data("placeholder","Select").trigger('liszt:updated');
                $('#lvl0_form').change(); 
            }           
        } else {
            get_options_lv4_all($('#lvl'+_level+'_form').val());  
            get_options_lv4_all_Q($('#lvl'+_level+'_form').val());  
        }     
    }

    function setComboDefault(_id,_unit,_nama){
        console.log(_id);
        console.log(_unit);
        console.log(_nama);
        if ($(_id+' option').size() <= 1){
            $(_id).empty();
            $(_id).append('<option value='+_unit+'>'+_nama+'</option>');
        } else {
            $(_id).val(_unit);
        }                   
        $(_id).data("placeholder","Select").trigger('liszt:updated');
    }

    function setDefaultLv1(){
        $('select[name="COCODE"]').empty();
        $('select[name="COCODE"]').append('<option value="">--Pilih Level 1--</option>');
    }

    function setDefaultLv2(){
        $('select[name="PLANT"]').empty();
        $('select[name="PLANT"]').append('<option value="">--Pilih Level 2--</option>');
    }

    function setDefaultLv3(){
        $('select[name="STORE_SLOC"]').empty();
        $('select[name="STORE_SLOC"]').append('<option value="">--Pilih Level 3--</option>');
    }

    function setDefaultLv4(){
        $('select[name="SLOC"]').empty();
        $('select[name="SLOC"]').append('<option value="">--Pilih Level 4--</option>');
    }

    function get_data_unit(sloc,sloc_cari){
        bootbox.hideAll();
        bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');                
        $.ajax({
            type: "POST",
            url : "<?php echo base_url('user_management/helpdesk/get_data_unit'); ?>",                
            data: { "SLOC": sloc},
            dataType:'json',
            error: function(data) {
                bootbox.hideAll();
                msgGagal('get_data_unit gagal');                
            },            
            success:function(data) {                 
                $.each(data, function () {
                    setComboDefault('#lvl0_form',this.ID_REGIONAL,this.LEVEL1);
                    setComboDefault('#lvl1_form',this.COCODE,this.LEVEL1);
                    setComboDefault('#lvl2_form',this.PLANT,this.LEVEL2);
                    setComboDefault('#lvl3_form',this.STORE_SLOC,this.LEVEL3);
                    if (sloc_cari){
                        setComboDefault('#lvl4_form',this.SLOC,this.LEVEL4);    
                    }     
                });             
                    
                bootbox.hideAll();
            }
        });    
    }

    function get_options_lv4_all(unit) {        
        var vlink_url = '<?php echo base_url()?>user_management/helpdesk/options_lv4_all/'+unit;
        setDefaultLv4();
        if(unit) {
          bootbox.modal('<div class="loading-progress"></div>');
          $.ajax({
              url: vlink_url,
              type: "GET",
              dataType: "json",
              success:function(data) {
                  $.each(data, function(key, value) {
                      $('#lvl4_form').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                  });
                  $('#lvl4_form').data("placeholder","Select").trigger('liszt:updated');
                  bootbox.hideAll();
              }
          });
        }
    };

    function get_options_lv4_all_Q(unit) {        
        var vlink_url = '<?php echo base_url()?>user_management/helpdesk/options_lv4_all/'+unit;
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
 
</script>

