<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/js/library/jquery.validate.js" type="text/javascript"></script>
<div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div id="index-content" class="well-content no-search">                    
                <div class="well">
                    <div class="well-content clearfix">
                        <div class="form-row">
                            <div class="span4">
                            <?php
                            $hidden_form = array('id' => '');
                            echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form'),$hidden_form);
                            ?>
                                <div class="control-group">
                                    <label  class="control-label">Jenis Transaksi<span class="required">*</span> : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_dropdown('ID_JENIS', @$jenis_transaksi, !empty($default->ID_JENIS) ? $default->ID_JENIS : '', 'class="span12 select2" id="ID_JENIS"'); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_dropdown('SLOC', @$options_pembangkit, !empty($default->SLOC) ? $default->SLOC : '', 'class="span12 select2" id="SLOC"'); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="password" class="control-label">Regional : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_input('regional','','class="span12 input" autocomplete="off" id="regional" readonly style="color:black;"'); ?>
                                    </div>
                                </div>
                                <div class="control-group" id="1">
                                    <label for="password" class="control-label">Level 1 : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_input('level1','','class="span12 input" autocomplete="off" id="level1" readonly style="color:black;"'); ?>
                                    </div>
                                </div>
                                <div class="control-group" id="2">
                                    <label for="password" class="control-label">Level 2 : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_input('level2','','class="span12 input" autocomplete="off" id="level2" readonly style="color:black;"'); ?>
                                    </div>
                                </div>
                                <div class="control-group" id="3">
                                    <label for="password" class="control-label">Level 3 : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_input('level3','','class="span12 input" autocomplete="off" id="level3" readonly style="color:black;"'); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label  class="control-label">Jenis Bahan Bakar<span class="required">*</span> : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_dropdown('ID_JNS_BHN_BKR', @$options_jns_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span12 select2" id="ID_JNS_BHN_BKR"'); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label  class="control-label">Nomor Transaksi<span class="required">*</span> : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_dropdown('ID_TRANS', '', !empty($default->ID_TRANS) ? $default->ID_TRANS : '', 'class="span12 select2" id="ID_TRANS"'); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label  class="control-label">Tanggal Pengakuan<span class="required">*</span> : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_input('TGL_BA', !empty($default->TGL_BA) ? $default->TGL_BA : '', 'class="span12" id="TGL_BA" readonly style="color : black"'); ?>
                                        <?php echo form_hidden('STATUS', !empty($default->STATUS) ? $default->STATUS : '', 'class="span12" id="STATUS" readonly style="color : black"'); ?>
                                        <?php echo form_hidden('NO_STOCKOPNAME', !empty($default->NO_STOCKOPNAME) ? $default->NO_STOCKOPNAME : '', 'class="span12" id="NO_STOCKOPNAME" readonly style="color : black"'); ?>
                                        <?php echo form_hidden('APPROVE_BY', !empty($default->APPROVE_BY) ? $default->APPROVE_BY : '', 'class="span12" id="APPROVE_BY" readonly style="color : black"'); ?>
                                        <?php echo form_hidden('APPROVE_DATE', !empty($default->APPROVE_DATE) ? $default->APPROVE_DATE : '', 'class="span12" id="APPROVE_DATE" readonly style="color : black"'); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label  class="control-label">Jenis Rollback<span class="required">*</span> : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_dropdown('JNS_ROLLBACK', $jenis_rollback, !empty($default->JNS_ROLLBACK) ? $default->JNS_ROLLBACK : '', 'class="span12 select2" id="JNS_ROLLBACK"'); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label  class="control-label">Alasan Rollback<span class="required">*</span> : </label>
                                    <label  class="control-label"><span class="required">Max : 40 Charakter</span> : </label>
                                    <br>
                                    <br>
                                    <div class="controls">
                                        <?php echo form_textarea('ALASAN_ROLLBACK', !empty($default->ALASAN_ROLLBACK) ? $default->ALASAN_ROLLBACK : '', 'class="span12" id="ALASAN_ROLLBACK" required maxlength="40" style="color : black;height : 50px;"'); ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls pull-right span2" style="margin-left: 20px;">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="blue btn" id="btn-check">Check</button>
                                    </div>
                                    <div class="controls pull-right span2">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" id="button-clear">Clear</button>
                                    </div>
                                </div>
                            <?php echo form_close(); ?>
                            </div>
                            <div class="span8" id="showtable">
                                <div class="box">
                                    <div class="box-body">
                                    <?php
                                    $hidden_form = array('id' => '');
                                    echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form'),$hidden_form);
                                    ?>
                                        <h4>Data Rollback</h4>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <th>Pembangkit</th>
                                                <th>Jenis <br>Transaksi</th>
                                                <th>Jenis <br>BBM</th>
                                                <th>Nomor <br>Transaksi</th>
                                                <th>Tanggal <br>Pengakuan</th>
                                                <th>Status</th>
                                                <th>Jenis <br>Rollback</th>
                                                <th>Alasan <br>Rollback</th>
                                                
                                            </thead>
                                            <tbody id="tbody_trans"></tbody>
                                        </table>
                                        <br>
                                        <br>
                                        <h4>Rollback Data Sebelumnya</h4>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <th>Pembangkit</th>
                                                <th>Jenis Transaksi</th>
                                                <th>Jenis BBM</th>
                                                <th>Nomor Transaksi</th>
                                                <th>Tanggal Pengakuan</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </thead>
                                            <tbody id="tbody_prev"></tbody>
                                        </table>
                                        <br>
                                        <br>
                                        <h4>Rollback Data Setelahnya</h4>
                                        <!-- <div class="pull-right">
                                            <input type="checkbox" id="checkAll"> Check All
                                        </div> -->
                                        <br>
                                        <br>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <th>Pembangkit</th>
                                                <th>Jenis Transaksi</th>
                                                <th>Jenis BBM</th>
                                                <th>Nomor Transaksi</th>
                                                <th>Tanggal Pengakuan</th>
                                                <th>Status</th>
                                                <!-- <th>Aksi</th> -->
                                            </thead>
                                            <tbody id="tbody_prev_after"></tbody>
                                            <!-- <tfoot id="tfoot_prev_after">
                                                <tr>
                                                    <th colspan="5" style="text-align: center;">TOTAL</th>
                                                    <th style="text-align: right;"><?php echo number_format($total,2,",",".") ?></th>
                                                    <th></th>
                                                </tr>
                                            </tfoot> -->
                                        </table>
                                        <div id="tbody_prev_after"></div>
                                        <!-- <div id="table_pemakaian"></div> -->

                                        <br>
                                        <hr>
                                        <div class="form-actions">
                                            <div class="control-group">
                                                <div class="controls pull-right span2 hide" id="roll">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" id="btn-rollback">Rollback</button>
                                                </div>
                                                <div class="controls pull-right span2 hide" id="del">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" id="btn-hapus">Hapus</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php echo form_close(); ?>

                                        <br>
                                        <br>
                                        <h4>Hasil Rollback Data</h4>
                                        <div class="well" id="filtr">
                                            <div class="well-content clearfix">
                                                <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                                                <table>
                                                    <tr>
                                                        <td colspan=2><label>Cari :</label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo form_input('kata_kunci', '', 'class="input-xlarge"'); ?></td>
                                                        <td> &nbsp </td>
                                                        <td><?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?></td>
                                                    </tr>
                                                </table>
                                            <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                        <div id="content_table" data-source="<?php echo $data_sources; ?>" data-filter="#ffilter"></div>
                                        <div id="temp_filter"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
</div>

<script type="text/javascript">

    $(document).ready(function() {
        load_table('#content_table', 1, '#ffilter');
        $('#button-filter').click(function() {
            load_table('#content_table', 1, '#ffilter');
            // console.log('berhasil');
        });
        setDefaultBBM();
        $(".form_datetime").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left",
            beforeShow: function(i) { if ($(i).attr('readonly')) { return false; } }
            
        });

        $('#checkAll').attr('checked', false);


        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        
        $('#button-clear').click(function(){
            $('#finput').trigger("reset");
            $('#tbody_trans').empty();
            $('#tbody_prev').empty();
            $('#tbody_prev_after').empty();
            $('#temp_filter').empty();
            $("#roll").hide();
            $("#del").hide();
            $("#content_table").show();
            load_table('#content_table', 1, '#ffilter');
            $("#filtr").show();
            setDefaultBBM();
            setDefaultTransaksi();
            setDefaultJNSRollback();
            $('#btn-check').prop('disabled', false);
        });
        
        $('#ID_JNS_BHN_BKR').change(function(){
            var v_jnsbbm = $(this).val();
            var v_sloc = $('#SLOC').val();
            var v_jenis = $('#ID_JENIS').val();

            get_transaksi(v_sloc,v_jenis,v_jnsbbm);
        })

        $('#btn-rollback').click(function(){
            var v_jnsbbm = $('#ID_JNS_BHN_BKR option:selected').val();
            var v_sloc = $('#SLOC option:selected').val();
            var v_jenis = $('#ID_JENIS').select2('val');
            var v_namajenis = $('#ID_JENIS option:selected').val();
            var v_nomortrans = $('#ID_TRANS').select2('val');
            var v_namatrans = $('#ID_TRANS option:selected').val();
            var v_tglba = $('#TGL_BA').val();
            var v_status = $('#STATUS').val();
            var v_nomutasi = $('#NO_STOCKOPNAME').val();
            var v_jenisrollback = $('#JNS_ROLLBACK option:selected').val();
            var v_alasan = $('#ALASAN_ROLLBACK').val();
            var v_rollback = $('input[name=ID_ROLLBACK]:checked', '#finput').val();
            var v_approveby = $('#APPROVE_BY').val();
            var v_approvedate = $('#APPROVE_DATE').val();
            // var v_rollbackafter = $("input:hidden[name='ID_ROLLBACK_AFTER[]']").map(function(){return $(this).val();}).get();
            var v_array = [];
            var v_rollbackafter = $('input:hidden[name=ID_ROLLBACK_AFTER]').each(function() {
                v_array.push($(this).val());
            });

            var vlink_url = '<?php echo base_url()?>rollback/rollback_stockopname/rollback/';
            $.ajax({
                url: vlink_url,
                type: "POST",
                data : {
                    bbm : v_jnsbbm,
                    sloc : v_sloc,
                    jenis : v_namajenis,
                    idtrans : v_namatrans,
                    stockopname : v_nomutasi,
                    tgl : v_tglba,
                    status : v_status,
                    jnsrollback : v_jenisrollback,
                    alasan : v_alasan,
                    id_rollback : v_rollback,
                    approve_by : v_approveby,
                    approve_date : v_approvedate,
                    id_rollbackafter : v_array,
                },
                beforeSend: function(data) {
                    bootbox.modal('<div class="loading-progress"></div>');
                },
                error:function(jqXHR, textStatus, errorThrown){
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengiriman data gagal-- </div>', function() {
                        bootbox.hideAll();
                    });
                },
                success:function(data) {
                    var obj = JSON.parse(data);
                    // console.log(obj);
                    if (obj[0] == true) {
                        bootbox.alert('<div class="box-title" style="color:#0000FF;"><i class="icon-ok-sign"></i>  -- Proses rollback data berhasil -- </div>', function() {
                            $('#finput').trigger("reset");
                            $('#tbody_trans').empty();
                            $('#tbody_prev').empty();
                            $('#tbody_prev_after').empty();
                            $("#roll").hide();
                            $("#del").hide();
                            $("#content_table").hide();
                            $("#filtr").hide();
                            get_filter(v_sloc);
                            setDefaultBBM();
                            setDefaultTransaksi();
                            setDefaultJNSRollback();
                            $('#btn-check').prop('disabled', false);
                            bootbox.hideAll();
                        });
                    } else {
                        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Proses rollback data gagal, Harap periksa kembali data yang diinput dan Rollback data sebelumnya -- </div>', function() {
                            bootbox.hideAll();
                        });
                    }
                    // bootbox.hideAll();
                }
            });
        });

        $('#btn-hapus').click(function(){
            var v_jnsbbm = $('#ID_JNS_BHN_BKR option:selected').val();
            var v_sloc = $('#SLOC option:selected').val();
            var v_jenis = $('#ID_JENIS').select2('val');
            var v_namajenis = $('#ID_JENIS option:selected').val();
            var v_nomortrans = $('#ID_TRANS').select2('val');
            var v_namatrans = $('#ID_TRANS option:selected').val();
            var v_tglba = $('#TGL_BA').val();
            var v_status = $('#STATUS').val();
            var v_nomutasi = $('#NO_STOCKOPNAME').val();
            var v_jenisrollback = $('#JNS_ROLLBACK option:selected').val();
            var v_alasan = $('#ALASAN_ROLLBACK').val();
            var v_rollback = $('input[name=ID_ROLLBACK]:checked', '#finput').val();
            var v_array = [];
            var v_rollbackafter = $('input:hidden[name=ID_ROLLBACK_AFTER]').each(function() {
                v_array.push($(this).val());
            });

            var vlink_url = '<?php echo base_url()?>rollback/rollback_stockopname/delete/';
            $.ajax({
                url: vlink_url,
                type: "POST",
                data : {
                    bbm : v_jnsbbm,
                    sloc : v_sloc,
                    jenis : v_namajenis,
                    idtrans : v_namatrans,
                    stockopname : v_nomutasi,
                    tgl : v_tglba,
                    status : v_status,
                    jnsrollback : v_jenisrollback,
                    alasan : v_alasan,
                    id_rollback : v_rollback,
                    id_rollbackafter : v_array,
                },
                beforeSend: function(data) {
                    bootbox.modal('<div class="loading-progress"></div>');
                },
                error:function(data){
                    bootbox.hideAll();
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengiriman data gagal-- </div>', function() {});
                },
                success:function(data) {
                    var obj = JSON.parse(data);

                    if (obj[0] == true) {
                        bootbox.alert('<div class="box-title" style="color:#0000FF;"><i class="icon-ok-sign"></i>  -- Proses rollback data berhasil -- </div>', function() {
                            bootbox.hideAll();
                            $('#finput').trigger("reset");
                            $('#tbody_trans').empty();
                            $('#tbody_prev').empty();
                            $('#tbody_prev_after').empty();
                            $("#roll").hide();
                            $("#del").hide();
                            $("#content_table").hide();
                            $("#filtr").hide();
                            get_filter(v_sloc);
                            setDefaultBBM();
                            setDefaultTransaksi();
                            setDefaultJNSRollback();
                            $('#btn-check').prop('disabled', false);
                        });
                    } else {
                        bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Proses rollback data gagal, Harap periksa kembali data yang diinput dan Rollback data sebelumnya -- </div>', function() {
                            bootbox.hideAll();
                        });
                    }
                    // bootbox.hideAll();
                }
            });
        })



        $('#btn-check').click(function(){
            var v_jnsbbm = $('#ID_JNS_BHN_BKR option:selected').text();
            var v_sloc = $('#SLOC option:selected').text();
            var v_slocVal = $('#SLOC option:selected').val();
            var v_jenis = $('#ID_JENIS').select2('val');
            var v_namajenis = $('#ID_JENIS option:selected').text();
            var v_nomortrans = $('#ID_TRANS').select2('val');
            var v_namatrans = $('#ID_TRANS option:selected').text();
            var v_tglba = $('#TGL_BA').val();
            var v_status = $('#STATUS').val();
            var v_jenisrollback = $('#JNS_ROLLBACK option:selected').text();
            var v_rollback = $('#JNS_ROLLBACK option:selected').val();
            var v_alasan = $('#ALASAN_ROLLBACK').val();
            var v_approveby = $('#APPROVE_BY').val();
            var v_approvedate = $('#APPROVE_DATE').val();
            
            var p_sloc = $('#SLOC').val();
            var p_jnsbbm = $('#ID_JNS_BHN_BKR').val();
            // $("#showtable").show();

            if(v_jnsbbm == '' || v_sloc == '' || v_jenis == '' || v_nomortrans == '' || v_tglba == '' || v_status == '' ||v_jenisrollback == '' || v_alasan == ''){
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data tidak boleh kosong-- </div>', function() {});
            } else {

                if (v_status == 'Belum Disetujui' || v_status == 'Belum Disetujui Closing') {
                    var g = "<input name='ID_ROLLBACK' type='hidden' value='NONE'>";
                    $('#tbody_prev').append(
                        '<tr>'+
                            '<td colspan="7" align="center">Data Tidak Ditemukan !'+g+'</td>'+
                        '</tr>'
                    )

                    $("#content_table").hide();
                    $("#filtr").hide();
                    get_filter(v_slocVal);

                    $('#tbody_trans').append(
                        '<td>'+v_sloc+'</td>'+
                        '<td>'+v_namajenis+'</td>'+
                        '<td>'+v_jnsbbm+'</td>'+
                        '<td>'+v_namatrans+'</td>'+
                        '<td>'+v_tglba+'</td>'+
                        '<td>'+v_status+'</td>'+
                        '<td>'+v_jenisrollback+'</td>'+
                        '<td>'+v_alasan+'</td>'
                    )

                    $('#btn-check').prop('disabled', true);

                    if (v_rollback == 1) {
                        $("#roll").show();
                    } else if (v_rollback == 2) {
                        $("#del").show();   
                    }
                    bootbox.hideAll();
                }

                if(v_status == 'Disetujui' || v_status == 'Disetujui Closing') {
                    var link = '<?php echo base_url()?>rollback/rollback_stockopname/get_transaksi_prev/';
                    var links = '<?php echo base_url()?>rollback/rollback_stockopname/get_transaksi_prev_after/';

                    $.ajax({
                        url: link,
                        type: "POST",
                        data : {
                            sloc : p_sloc,
                            bbm  : p_jnsbbm,
                            tgl  : v_tglba,
                            no_trans : v_nomortrans
                        },
                        beforeSend: function(data) {
                            bootbox.modal('<div class="loading-progress"></div>');
                        },
                        error:function(data){
                            bootbox.hideAll();
                            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengambilan data gagal-- </div>', function() {});
                        },
                        success:function(data) {
                            // bootbox.hideAll();
                            var obj = JSON.parse(data);
                            $('#tbody_prev').empty();
                            $("#tbody_trans").empty();
                            if(obj.length == 0){
                                var g = "<input name='ID_ROLLBACK' type='hidden' value='NONE'>";
                                $('#tbody_prev').append(
                                    '<tr>'+
                                        '<td colspan="7" align="center">Data Tidak Ditemukan !'+g+'</td>'+
                                    '</tr>'
                                )
                            } else {
                                $.each(obj, function(key, value) {
                                    var a = value.LEVEL4;
                                    var b = value.JNS_TRX_BACKDATE;
                                    var c = value.NAMA_JNS_BHN_BKR;
                                    var d = value.NO_TRX;
                                    var e = value.TGL;
                                    var f = value.STATUS;
                                    var g = "<input name='ID_ROLLBACK' type='radio' value='"+value.ID_TRX+","+value.JNS_TRX_BACKDATE+","+value.SLOC+","+value.ID_JNS_BHN_BKR+","+value.TGL_BACKDATE+","+value.NO_TRX+","+value.APPROVE_BY+","+value.APPROVE_DATE+"'>";
                                    $('#tbody_prev').append(
                                        '<tr>'+
                                            '<td>'+a+'</td>'+
                                            '<td>'+b+'</td>'+
                                            '<td>'+c+'</td>'+
                                            '<td>'+d+'</td>'+
                                            '<td>'+e+'</td>'+
                                            '<td>'+f+'</td>'+
                                            '<td align="center">'+g+'</td>'+
                                        '</tr>'
                                    )
                                });
                            }
                            
                            $("#content_table").hide();
                            $("#filtr").hide();
                            get_filter(v_slocVal);
                            
                            $('#tbody_trans').append(
                                '<td>'+v_sloc+'</td>'+
                                '<td>'+v_namajenis+'</td>'+
                                '<td>'+v_jnsbbm+'</td>'+
                                '<td>'+v_namatrans+'</td>'+
                                '<td>'+v_tglba+'</td>'+
                                '<td>'+v_status+'</td>'+
                                '<td>'+v_jenisrollback+'</td>'+
                                '<td>'+v_alasan+'</td>'
                            )

                            $('#btn-check').prop('disabled', true);

                            if (v_rollback == 1) {
                                $("#roll").show();
                            } else if (v_rollback == 2) {
                                $("#del").show();   
                            }
                            bootbox.hideAll();
                        }
                    });

                    $.ajax({
                        url: links,
                        type: "POST",
                        data : {
                            sloc : p_sloc,
                            bbm  : p_jnsbbm,
                            tgl  : v_tglba,
                            no_trans : v_nomortrans
                        },
                        beforeSend: function(data) {
                            bootbox.modal('<div class="loading-progress"></div>');
                        },
                        error:function(data){
                            bootbox.hideAll();
                            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengambilan data gagal-- </div>', function() {});
                        },
                        success:function(data) {
                            bootbox.hideAll();
                            // $('#table_pemakaian').html(data);
                            // $('#tbody_prev').empty();
                            // $("#tbody_trans").empty();
                            var obj = JSON.parse(data);
                            if(obj.length == 0){
                                $('#tbody_prev_after').append(
                                    '<tr>'+
                                        '<td colspan="7" align="center">Data Tidak Ditemukan !</td>'+
                                    '</tr>'
                                )
                            } else {
                                $.each(obj, function(key, value) {
                                    var a = value.LEVEL4;
                                    var b = value.JNS_TRX_BACKDATE;
                                    var c = value.NAMA_JNS_BHN_BKR;
                                    var d = value.NO_TRX;
                                    var e = value.TGL;
                                    var f = value.STATUS + "<input type='hidden' name='ID_ROLLBACK_AFTER' value='"+value.ID_TRX+","+value.JNS_TRX_BACKDATE+","+value.SLOC+","+value.ID_JNS_BHN_BKR+","+value.TGL+","+value.NO_TRX+","+value.APPROVE_BY+","+value.APPROVE_DATE+"'>";
                                    // var g = ;
                                    $('#tbody_prev_after').append(
                                        '<tr>'+
                                            '<td>'+a+'</td>'+
                                            '<td>'+b+'</td>'+
                                            '<td>'+c+'</td>'+
                                            '<td>'+d+'</td>'+
                                            '<td>'+e+'</td>'+
                                            '<td>'+f+'</td>'+
                                            // '<td align="center">'+g+'</td>'+
                                        '</tr>'
                                    )
                                });
                            }
                        }
                    });

                }
            }
        });
    
        $('#ID_TRANS').change(function(){
            var jenis = $("#ID_JENIS").val();
            var id = $(this).val();
            get_detailtransaksi(id,jenis);
        })

        $('#SLOC').change(function(){
            var sloc = $(this).val();
            get_jenis_bbm(sloc);
            get_all(sloc);
        })

        $('.select2').select2();
    });

    function get_filter(v_sloc){
        var vurl = '<?php echo base_url()?>rollback/rollback_stockopname/get_filter/';
        $.ajax({
            url: vurl,
            type: "POST",
            data : {
                sloc : v_sloc
            },
            beforeSend: function(data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error:function(data){
                bootbox.hideAll();
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengambilan data gagal-- </div>', function() {}); 
            },
            success:function(data) {
                $('#temp_filter').html(data);
                $("#content_table").hide();
                bootbox.hideAll();
            }
        });
    }

    function get_jenis_bbm(v_sloc){
        var vlink_url = '<?php echo base_url()?>rollback/rollback_stockopname/load_jenisbbm/';
        $.ajax({
            url: vlink_url,
            type: "POST",
            data : {
                sloc : v_sloc,
            },
            beforeSend: function(data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error:function(data){
                bootbox.hideAll();
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengambilan data gagal-- </div>', function() {});
            },
            success:function(data) {
                bootbox.hideAll();
                var obj = JSON.parse(data);
                setDefaultBBM();
                $.each(obj, function(key, value) {
                    $('select[name="ID_JNS_BHN_BKR"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
                bootbox.hideAll();
            }
        }); 
    }

    function get_all(v_sloc){
        var vlink_url = '<?php echo base_url()?>rollback/rollback_stockopname/get_all/';
        $.ajax({
            url: vlink_url,
            type: "POST",
            data : {
                sloc : v_sloc,
            },
            beforeSend: function(data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error:function(data){
                bootbox.hideAll();
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengambilan data gagal-- </div>', function() {});
            },
            success:function(data) {
                bootbox.hideAll();
                var obj = JSON.parse(data);
                $('#regional').val(obj.NAMA_REGIONAL);
                $('#level1').val(obj.LEVEL1);
                $('#level2').val(obj.LEVEL2);
                $('#level3').val(obj.LEVEL3);
                bootbox.hideAll();
            }
        }); 
    }

    function get_transaksi(v_sloc,v_jenis,v_jnsbbm) {
        var vlink_url = '<?php echo base_url()?>rollback/rollback_stockopname/get_transaksi/';
        $.ajax({
            url: vlink_url,
            type: "POST",
            data : {
                sloc : v_sloc,
                bbm  : v_jnsbbm,
                jenis  : v_jenis,
            },
            beforeSend: function(data) {
                bootbox.modal('<div class="loading-progress"></div>');
            },
            error:function(data){
                bootbox.hideAll();
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengambilan data gagal-- </div>', function() {});
            },
            success:function(data) {
                bootbox.hideAll();
                var obj = JSON.parse(data);
                setDefaultTransaksi()
                $.each(obj, function(key, value) {
                    $('select[name="ID_TRANS"]').append('<option value="'+ key +'">'+ value +'</option>');
                    // $('select[name="ID_TRANS"]').append('<option value="'+ value.ID_PERMINTAAN +'">'+ value.NO_NOMINASI +'</option>');
                });
                bootbox.hideAll();
            }
        });
    }

    function get_detailtransaksi(v_idtrans,v_jenis) {

        var vlink_url = '<?php echo base_url()?>rollback/rollback_stockopname/get_detailtransaksi/';
        $.ajax({
            url: vlink_url,
            type: "POST",
            data : {
                idtrans : v_idtrans,
                jenis : v_jenis
            },
            error:function(data){
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses pengambilan data gagal-- </div>', function() {});
            },
            success:function(data) {
                var obj = JSON.parse(data);
                $("#TGL_BA").val(obj.TGL);
                $("#STATUS").val(obj.STATUS);
                $("#NO_STOCKOPNAME").val(obj.NO_STOCKOPNAME);
                $("#APPROVE_BY").val(obj.APPROVE_BY);
                $("#APPROVE_DATE").val(obj.APPROVE_DATE);
            }
        });
    }

    function cek_tanggal(){

        var TGL_SAMPLING = $('#TGL_SAMPLING').val();
        var TGL_COQ      = $('#TGL_COQ').val();

        if(TGL_COQ < TGL_SAMPLING) {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Tanggal COQ tidak boleh lebih kecil dari Tanggal Sampling ! -- </div>', function() {});
            $('#TGL_COQ').val('');
        }
    }

    function setDefaultTransaksi() {
        $('select[name="ID_TRANS"]').empty();
        $('select[name="ID_TRANS"]').append('<option value="">--Pilih Nomor Transaksi--</option>');
        
    }

    function setDefaultBBM() {
        $('select[name="ID_JNS_BHN_BKR"]').empty();
        $('select[name="ID_JNS_BHN_BKR"]').append('<option value="">--Pilih Jenis Bahan Bakar--</option>');
    }

    // function setDefaultSLOC() {
    //     $('select[name="SLOC"]').empty();
    //     $('select[name="SLOC"]').append('<option value="<?php echo $default->SLOC; ?>"></option>');
    // }

    function setDefaultJNSRollback() {
        $('select[name="JNS_ROLLBACK"]').empty();
        $('select[name="JNS_ROLLBACK"]').append('<option value="1">Rollback Revisi</option>');
        $('select[name="JNS_ROLLBACK"]').append('<option value="2">Rollback Hapus</option>');
    }

    
</script>