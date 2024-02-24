<?php
/**
 * Created by PhpStorm.
 * User: cf
 * Date: 10/20/17
 * Time: 12:59 AM
 */
?>

<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
</div>
<div class="widgets_area" id="index-content">
    <div class="row-fluid" <?php if($page_notif) echo 'hidden'; ?>>
        <div class="span12">
            <div id="index-content1" class="well-content no-search">
                <div class="well">
                    <div class="pull-left">
                        <?php echo hgenerator::render_button_group($button_group); ?>
                    </div>
                </div>
                <div class="content_table">
                    <div class="well-content clearfix">
                        <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                        <div class="form_row">
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Regional : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Level 1 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1"'); ?>
                                </div>
                            </div>
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Level 2 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2"'); ?>
                                </div>
                            </div>
                        </div><br/>
                        <div class="form_row">
                            <div class="pull-left span3">
                                <label for="password" class="control-label">Level 3 : </label>
                                <div class="controls">
                                    <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                                </div>
                            </div>

                            <div class="pull-left span3">
                                <label for="" class="control-label">Cari : </label>
                                <div class="controls">
                                    <?php echo form_input('kata_kunci', '', 'class="input-large"'); ?>
                                </div>
                            </div>

                            <div class="pull-left span4">
                                <label for="" class="control-label"></label>
                                <div class="controls">
                                    <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                                        'class' => 'btn',
                                        'id'    => 'button-excel'
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <br>

                <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                
            </div>
            <!-- <div id="form-content" class="well-content"></div> -->
        </div>
    </div>
</div><br><br>

<div id="form-content" class="well-content"></div>


<form id="export_excel" action="<?php echo base_url('user_management/list_user/export_excel'); ?>" method="post">
   <input type="hidden" name="xlvl0">
   <input type="hidden" name="xlvl1">
   <input type="hidden" name="xlvl2">
   <input type="hidden" name="xlvl3">
   <input type="hidden" name="xlvl0_nama">
   <input type="hidden" name="xlvl1_nama">
   <input type="hidden" name="xlvl2_nama">
   <input type="hidden" name="xlvl3_nama">
   <input type="hidden" name="xlvl4">
   <input type="hidden" name="xlvlid">
   <input type="hidden" name="xlvl">
   <input type="hidden" name="xcari">
</form>

<script type="text/javascript">
    jQuery(function ($) {
        load_table('#content_table', 1, '#ffilter');

        $('#button-filter').click(function () {
            load_table('#content_table', 1, '#ffilter');
        });
    });

    function setDefaultLv1(){
        $('#lvl1').empty();
        $('#lvl1').append('<option value="">--Pilih Level 1--</option>');
    }

    function setDefaultLv2(){
        $('#lvl2').empty();
        $('#lvl2').append('<option value="">--Pilih Level 2--</option>');
    }

    function setDefaultLv3(){
        $('#lvl3').empty();
        $('#lvl3').append('<option value="">--Pilih Level 3--</option>');
    }

    function setDefaultLv4(){
        $('#lvl4').empty();
        $('#lvl4').append('<option value="">--Pilih Pembangkit--</option>');
    }

    $('#lvl0').on('change', function() {
        var stateID = $(this).val();
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
                      $('#lvl1').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                  });
                  bootbox.hideAll();
              }
          });
        }
    });

    $('#lvl1').on('change', function() {
        var stateID = $(this).val();
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
                      $('#lvl2').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                  });
                  bootbox.hideAll();
              }
          });
        }
    });

    $('#lvl2').on('change', function() {
        var stateID = $(this).val();
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
                      $('#lvl3').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                  });
                  bootbox.hideAll();
              }
          });
        }
    });

    $('#button-excel').click(function(e) {
     var lvl0 = $('#lvl0').val(); //Regional dropdown
     var lvl1 = $('#lvl1').val(); //level1 dropdown
     var lvl2 = $('#lvl2').val(); //level2 dropdown
     var lvl3 = $('#lvl3').val(); //level3 dropdown
     var cari = $('#button-filter').val(); //bahanBakar dropdown

       if (lvl0 == '') {
           bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --PILIH REGIONAL-- </div>', function() {});
       } else {
         if (lvl0 !== "") {
             lvl0 = 'Regional';
             vlevelid = $('#lvl0').val();
             if (vlevelid == "00") {
                 lvl0 = "Pusat";
             }
         }
         if (lvl1 !== "") {
             lvl0 = 'Level 1';
             vlevelid = $('#lvl1').val();
         }
         if (lvl2 !== "") {
             lvl0 = 'Level 2';
             vlevelid = $('#lvl2').val();
         }
         if (lvl3 !== ""){
             lvl0 = 'Level 3';
             vlevelid = $('#lvl3').val();
         }

         $('input[name="xlvl0"]').val($('#lvl0').val());
         $('input[name="xlvl1"]').val($('#lvl1').val());
         $('input[name="xlvl2"]').val($('#lvl2').val());
         $('input[name="xlvl3"]').val($('#lvl3').val());

         $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
         $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
         $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
         $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());

         $('input[name="xcari"]').val(cari); // 001

         $('input[name="xlvlid"]').val(vlevelid);
         $('input[name="xlvl"]').val(lvl0);
          
         bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
             if(e){
                 $('#export_excel').submit();
             }
         });
       }
    });

</script>