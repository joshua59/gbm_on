
<!-- /**
 * @module PERHITUNGAN HARGA
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 20 MARET 2018
 * @modified by BAKTI DWI DHARMA WIJAYA
 */ -->
 <div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span6">
                <div id ="index-content" class="well-content no-search">
                    <div class="well">
                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                                <div class="form_row">
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Tanggal Awal : </label>
                                        <div class="controls">
                                            <div class="controls">
                                            <?php echo form_input('TGL_DARI', !empty($TGL_DARI) ? $TGL_DARI : '', 'class="form_datetime" style="width: 145px;" placeholder="Tanggal awal" id="tglawal"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                   <div class="pull-left span2">
                                        <label for="password" class="control-label">Tanggal akhir : </label>
                                        <div class="controls">
                                            <div class="controls">
                                            <?php echo form_input('TGL_SAMPAI', !empty($TGL_SAMPAI) ? $TGL_SAMPAI : '', 'class="form_datetime" style="width: 145px;" placeholder="Tanggal akhir" id="tglakhir"'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Transportir :</label>
                                        <div class="controls">
                                            <?php echo form_dropdown('ID_TRANSPORTIR', $options_transportir, !empty($default->ID_TRANSPORTIR) ? $default->ID_TRANSPORTIR : '', 'id="ID_TRANSPORTIR" style="width:145px"'); ?>
                                        </div>
                                    </div>
                                </div><br/>
                                <div class="form_row">
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Regional : </label>
                                        <div class="controls">
                                             <?php echo form_dropdown('ID_REGIONAL', $reg_options, !empty($default->ID_REGIONAL) ? $default->ID_REGIONAL : '', 'id="lvl0" style="width:145px"'); ?>
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Level 1 : </label>
                                        <div class="controls">
                                             <?php echo form_dropdown('COCODE', $lv1_options, !empty($default->COCODE) ? $default->COCODE : '', 'id="lvl1" style="width:145px"'); ?>
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Level 2 : </label>
                                        <div class="controls">
                                            <?php echo form_dropdown('PLANT', $lv2_options, !empty($default->PLANT) ? $default->PLANT : '', 'id="lvl2" style="width:145px"'); ?>
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Level 3 : </label>
                                        <div class="controls">
                                            <?php echo form_dropdown('STORE_SLOC', $lv3_options, !empty($default->STORE_SLOC) ? $default->STORE_SLOC : '', 'id="lvl3" style="width:145px"'); ?>
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Pembangkit : </label>
                                        <div class="controls">
                                            <?php echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4" style="width:145px"'); ?>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="form_row">
                                   <div class="pull-left span2">
                                        <label for="password" class="control-label">Cari : </label>
                                        <div class="controls">
                                            <!-- <br> -->
                                            <input type="text" name="kata_kunci" id="kata_kunci" class="control-label">
                                        </div>
                                        
                                    </div>
                                    <div class="pull-left span7">
                                        <label for="password" class="control-label"></label>
                                        <div class="controls">
                                            <!-- <br> -->
                                            <!-- <button type="button" class="btn"><i class='icon-search'></i>Filter</button> -->
                                            <?php echo anchor(NULL, "<i class='icon-search'></i> Load", array('class' => 'btn', 'id' => 'button-filter')); ?>
                                            <?php echo anchor(null, "<i class='icon-download'></i> Download Excel", array('class' => 'btn', 'id' => 'button-excel')); ?>
                                            <?php echo anchor(null, "<i class='icon-download'></i> Download PDF", array('class' => 'btn', 'id' => 'button-pdf')); ?>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <?php echo form_close(); ?>
                         </div>    
                    </div> 
                    <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                    <div>&nbsp;</div>
                </div>
                <div id="form-content" class="well-content"></div>
            </div>
        </div>
    </div>
</div>

<form id="export_excel" action="<?php echo base_url('laporan/kontrak_transportir/export_excel'); ?>" method="post">
    <input type="hidden" name="xlvl0">
    <input type="hidden" name="xlvl1">
    <input type="hidden" name="xlvl2">
    <input type="hidden" name="xlvl3">
    <input type="hidden" name="xlvl0_nama">
    <input type="hidden" name="xlvl1_nama">
    <input type="hidden" name="xlvl2_nama">
    <input type="hidden" name="xlvl3_nama">
    <input type="hidden" name="xlvl4">
    <input type="hidden" name="xtrans">
    <input type="hidden" name="xtrans_nama">
    <input type="hidden" name="xtglawal">
    <input type="hidden" name="xtglakhir">
    <input type="hidden" name="xkata_kunci">
</form>

<form id="export_pdf" action="<?php echo base_url('laporan/kontrak_transportir/export_pdf'); ?>" method="post" target="_blank">
    <input type="hidden" name="plvl0">
    <input type="hidden" name="plvl1">
    <input type="hidden" name="plvl2">
    <input type="hidden" name="plvl3">
    <input type="hidden" name="plvl0_nama">
    <input type="hidden" name="plvl1_nama">
    <input type="hidden" name="plvl2_nama">
    <input type="hidden" name="plvl3_nama">
    <input type="hidden" name="plvl4">
    <input type="hidden" name="ptrans">
    <input type="hidden" name="ptrans_nama">
    <input type="hidden" name="ptglawal">
    <input type="hidden" name="ptglakhir">
    <input type="hidden" name="pkata_kunci">
</form>

<script type="text/javascript">
    var icon = 'icon-remove-sign';
    var color = '#ac193d;';

    jQuery(function($) {

        load_table('#content_table', 1, '#ffilter');

        $('#button-filter').click(function() {
            load_table('#content_table', 1, '#ffilter');
        });

    });

    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });

    function setKirimApprove(vid){
        alert(vid);
    }

    function getIdTrans(vid){
        var IdTrans = vid.split('-');
        return IdTrans[2];
    }

    function setKirimData(vid) {
        bootbox.confirm('Yakin data ini akan dikirimkan ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=1';
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses kirim gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            load_table('#content_table', 1, '#ffilter');
                        });
                    }
                });
            }
        });
    }

    function setKirimDataKoreksi(vid) {
        bootbox.confirm('Yakin data ini akan dikirimkan ?', "Tidak", "Ya", function(e) {
            if(e){
                bootbox.modal('<div class="loading-progress"></div>');
                var data_kirim = 'vidtrans='+getIdTrans(vid)+'&status=10';
                var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga/kirim_approve";
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data_kirim,
                    dataType:"json",
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses kirim gagal');
                    },
                    success: function (data) {
                        bootbox.hideAll();
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }
                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            load_table('#content_table', 1, '#ffilter');
                        });
                    }
                });
            }
        });
    }

    $('#button-excel').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();

        if (tglawal == '' && tglakhir != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
        }else if(tglakhir == '' && tglawal != ''){
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
        }  else {
            $('input[name="xlvl0"]').val($('#lvl0').val());
            $('input[name="xlvl1"]').val($('#lvl1').val());
            $('input[name="xlvl2"]').val($('#lvl2').val());
            $('input[name="xlvl3"]').val($('#lvl3').val());

            $('input[name="xlvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="xlvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="xlvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="xlvl3_nama"]').val($('#lvl3 option:selected').text());
            $('input[name="xtrans_nama"]').val($('#ID_TRANSPORTIR option:selected').text());

            $('input[name="xlvl4"]').val($('#lvl4').val());
            $('input[name="xtrans"]').val($('#ID_TRANSPORTIR').val());
            $('input[name="xtglawal"]').val($('#tglawal').val());
            $('input[name="xtglakhir"]').val($('#tglakhir').val());
            $('input[name="xkata_kunci"]').val($('#kata_kunci').val());

            bootbox.confirm('Apakah yakin akan export data excel ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_excel').submit();
                }
            });
        }
    });

    $('#button-pdf').click(function(e) {
        var lvl0 = $('#lvl0').val();
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();

        if (tglawal == '' && tglakhir != '') {
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal awal tidak boleh kosong-- </div>', function() {});
        }else if(tglakhir == '' && tglawal != ''){
          bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Tanggal akhir tidak boleh kosong-- </div>', function() {});
        }  else {
            $('input[name="plvl0"]').val($('#lvl0').val());
            $('input[name="plvl1"]').val($('#lvl1').val());
            $('input[name="plvl2"]').val($('#lvl2').val());
            $('input[name="plvl3"]').val($('#lvl3').val());

            $('input[name="plvl0_nama"]').val($('#lvl0 option:selected').text());
            $('input[name="plvl1_nama"]').val($('#lvl1 option:selected').text());
            $('input[name="plvl2_nama"]').val($('#lvl2 option:selected').text());
            $('input[name="plvl3_nama"]').val($('#lvl3 option:selected').text());
            $('input[name="ptrans_nama"]').val($('#ID_TRANSPORTIR option:selected').text());

            $('input[name="plvl4"]').val($('#lvl4').val());
            $('input[name="ptrans"]').val($('#ID_TRANSPORTIR').val());
            $('input[name="ptglawal"]').val($('#tglawal').val());
            $('input[name="ptglakhir"]').val($('#tglakhir').val());
            $('input[name="pkata_kunci"]').val($('#kata_kunci').val());

            bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
                if(e){
                    $('#export_pdf').submit();
                }
            });
        }
    });

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
        $('select[name="SLOC"]').append('<option value="">--Pilih Pembangkit--</option>');
    }

    $('select[name="ID_REGIONAL"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>laporan/kontrak_transportir/get_options_lv1/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>laporan/kontrak_transportir/get_options_lv2/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>laporan/kontrak_transportir/get_options_lv3/'+stateID;
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
        var vlink_url = '<?php echo base_url()?>laporan/kontrak_transportir/get_options_lv4/'+stateID;
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

</script>