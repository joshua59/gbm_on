<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/cf/dataTables.fixedColumns.min.js" type="text/javascript"></script>

<style>
    tr {background-color: #CED8F6;}
    table {
        border-collapse: collapse;
        width:100%;
    }
    .cls_modal{
      width: 90%;
      height: 700px;
      left: 5%;
      margin: auto;
    }   

    .dataTables_scrollHeadInner {
     width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
     width: 100% !important;    
    }  

    #exampleModal{
      width: 100%;
      left: 0%;
      margin: 0 auto;
    }
</style>

<div class="inner_content" id="divTop">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Laporan'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="well-content no-search">
            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                <div class="form_row">
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Regional <span class="required">*</span> : </label>
                        <div class="controls">
                            <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0"'); ?>
                                <input type="hidden" name="di_cari" id="di_cari">
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
                </div>
                <br/>
                <div class="form_row">
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Level 3 : </label>
                        <div class="controls">
                            <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3"'); ?>
                        </div>
                    </div>
                    <div class="pull-left span3">
                        <label for="password" class="control-label">Level 4 : </label>
                        <div class="controls">
                            <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4"'); ?>
                        </div>
                    </div>

                    <div class="pull-left span3">
                        <label for="password" class="control-label">Cari: </label>
                        <div class="controls">
                            <input type="text" id="CARI" name="CARI" value="" placeholder="Cari Unit">
                            <?php echo anchor(null, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-load')); ?>
                        </div>
                    </div>

                </div>
                <br/>
                <div class="form_row">
                    <div class="pull-left span3">

                    </div>

                    <div class="pull-left span3">

                    </div>

                    <div class="pull-left span3">
                        <label></label>
                        <div class="controls">
                            <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                        'class' => 'btn',
                        'id'    => 'button-excel'
                    )); ?>
                                <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf'
                    )); ?>
                        </div>
                    </div>

                </div>

        </div>
        <?php echo form_close(); ?>
    </div>
    <br>
    <div class="well-content no-search" id="divTable" style="display: none">
        <div id="table_content"></div>
    </div>
</div>
</div>
<br>

<div class="modal fade modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="pull-right">
                    <input type="text" id="cariDetail" name="cariDetail" value="" placeholder="Cari Unit">
                    <button type="button" class="btn" name="button" id="btnCariDetail">Cari</button>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array(
                            'class' => 'btn',
                            'id'    => 'button-excel-detail'
                        )); ?>
                    <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array(
                        'class' => 'btn',
                        'id'    => 'button-pdf-detail'
                    )); ?>
                </div>
                <div id="table_detail">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<form id="export_excel" action="<?php echo base_url('laporan/aktifitas_user_controller/export_excel'); ?>" method="post">
    <input type="hidden" name="x_level">
    <input type="hidden" name="x_kode">
    <input type="hidden" name="x_cari">

</form>
<form id="export_pdf" action="<?php echo base_url('laporan/aktifitas_user_controller/export_pdf'); ?>" method="post" target="_blank">
    <input type="hidden" name="p_level">
    <input type="hidden" name="p_kode">
    <input type="hidden" name="p_cari">
</form>

<!-- Tombol Excel dan PDF - Modal DETAIL -->
<form id="export_excel_detail" action="<?php echo base_url('laporan/aktifitas_user_controller/export_excel_detail'); ?>" method="post" target="_blank">
    <input type="text" name="x_username">
</form>
<form id="export_pdf_detail" action="<?php echo base_url('laporan/aktifitas_user_controller/export_pdf_detail'); ?>" method="post" target="_blank">
    <input type="text" name="p_username">
</form>
<script type="text/javascript">

    var table;
    $(document).ready(function(){
      $('html, body').animate({scrollTop: $("#divTop").offset().top}, 1000);
      get_data();
    })
    
    function get_data() {

        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var CARI = $('#CARI').val();


        if (lvl0 == '') {
            lvl0 = 'All';
            vlevelid = $('#lvl0').val();
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
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }
        }
        

        var vlink_url = "<?php echo base_url('laporan/aktifitas_user_controller/getDataUser'); ?>";
        $.ajax({
            url: vlink_url,
            type: "POST",
            data: {
              p_level: lvl0, 
              p_kode: vlevelid
            },
            beforeSend:function(data) {
                bootbox.dialog('<div class="loading-progress" style="color:#ac193d;"></div>');
            },
            error:function(data) {
                bootbox.hideAll();
            },
            success:function(data) {
                $('#divTable').show();
                bootbox.hideAll();
                $('#table_content').html(data);
            }
        });         
    }

    $('#button-load').click(function(e) {
        get_data();
    });

    $('#button-excel').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var CARI = $('#CARI').val();
        if (lvl0 == '') {
            lvl0 = 'All';
            vlevelid = $('#lvl0').val();
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
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }
        }
        
        $('input[name="x_level"]').val(lvl0);
        $('input[name="x_kode"]').val(lvl1);

        $('input[name="xlvl0"]').val(lvl0);
        $('input[name="xlvl1"]').val(lvl1);
        $('input[name="xlvl2"]').val(lvl2);
        $('input[name="xlvl3"]').val(lvl3);
        $('input[name="xlvl4"]').val(lvl4);
        $('input[name="xlvlid"]').val(vlevelid);
        
        $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
        $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());
        $('input[name="xlvl4_nama"]').val($('#lvl4 option:selected').text());
        $('input[name="xCARI"]').val(CARI);

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#export_excel').submit();
            }
        });
    });

    $('#button-pdf').click(function(e) {

        var lvl0 = $('#lvl0').val();
        var lvl1 = $('#lvl1').val();
        var lvl2 = $('#lvl2').val();
        var lvl3 = $('#lvl3').val();
        var lvl4 = $('#lvl4').val();
        var CARI = $('#CARI').val();


        if (lvl0 == '') {
            lvl0 = 'All';
            vlevelid = $('#lvl0').val();
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
            if (lvl4 !== "") {
                lvl0 = 'Level 4';
                vlevelid = $('#lvl4').val();
            }
        }
        
      
        $('input[name="p_level"]').val(lvl0);
        $('input[name="p_kode"]').val(lvl1);

        $('input[name="plvl0"]').val(lvl0);
        $('input[name="plvl1"]').val(lvl1);
        $('input[name="plvl2"]').val(lvl2);
        $('input[name="plvl3"]').val(lvl3);
        $('input[name="plvl4"]').val(lvl4);
        $('input[name="plvlid"]').val(vlevelid);

        $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
        $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
        $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
        $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());
        $('input[name="plvl4_nama"]').val($('#lvl4 option:selected').text());

        $('input[name="pCARI"]').val(CARI);

        bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#export_pdf').submit();
            }
        });
    });

    $('#button-excel-detail').click(function(e) {

        bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#export_excel_detail').submit();
            }
        });
    });

    $('#button-pdf-detail').click(function(e) {

        bootbox.confirm('Apakah yakin akan export data PDF ?', "Tidak", "Ya", function(e) {
            if(e){
                $('#export_pdf_detail').submit();
            }
        });
    });
</script>

<script type="text/javascript">
    jQuery(function($) {

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

        $('select[name="ID_REGIONAL"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>laporan/aktifitas_user_controller/get_options_lv1/'+stateID;
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
                            $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                        });
                        bootbox.hideAll();
                    }
                });
            }
        });

        $('select[name="COCODE"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>laporan/aktifitas_user_controller/get_options_lv2/'+stateID;
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
                            $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                        });
                        bootbox.hideAll();
                    }
                });
            }
        });

        $('select[name="PLANT"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>laporan/aktifitas_user_controller/get_options_lv3/'+stateID;
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
                            $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                        });
                        bootbox.hideAll();
                    }
                });
            }
        });

        $('select[name="STORE_SLOC"]').on('change', function() {
            var stateID = $(this).val();
            var vlink_url = '<?php echo base_url()?>laporan/aktifitas_user_controller/get_options_lv4/'+stateID;
            setDefaultLv4();
            if(stateID) {
                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                    url: vlink_url,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $.each(data, function(key, value) {
                            $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                        });
                        bootbox.hideAll();
                    }
                });
            }
        });

    });


</script>