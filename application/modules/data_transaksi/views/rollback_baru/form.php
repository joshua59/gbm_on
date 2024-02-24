
<style type="text/css">
    label.error {color: red;}
</style>
<div class="box-content" id="divAtas">
    <?php
$hidden_form = array('id' => !empty($id) ? $id : '');

echo form_open_multipart($form_action, array('id' => 'finput', 'class' => 'form-horizontal'), $hidden_form);
?>
    <div class="well-content clearfix">
        <div class="form-row">
            <div class="span4">
                <h4>Detail Transaksi</h4>
                <div class="control-group">
                    <label  class="control-label">Jenis Transaksi<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_JENIS', @$jenis_transaksi, !empty($default->ID_JENIS) ? $default->ID_JENIS : '', 'class="span12 select2" id="ID_JENIS"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label  class="control-label">Pembangkit<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SLOC', @$options_pembangkit, !empty($default->SLOC) ? $default->SLOC : '', 'class="span12 select2" id="SLOC"'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label  class="control-label">Regional<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('REGIONAL', !empty($default->REGIONAL) ? $default->REGIONAL : '', 'class="span12" id="REGIONAL" readonly style="color : black"'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label  class="control-label">Level 1<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('LEVEL1', !empty($default->LEVEL1) ? $default->LEVEL1 : '', 'class="span12" id="LEVEL1" readonly style="color : black"'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label  class="control-label">Level 2<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('LEVEL2', !empty($default->LEVEL2) ? $default->LEVEL2 : '', 'class="span12" id="LEVEL2" readonly style="color : black"'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label  class="control-label">Level 3<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('LEVEL3', !empty($default->LEVEL3) ? $default->LEVEL3 : '', 'class="span12" id="LEVEL3" readonly style="color : black"'); ?>
                    </div>
                </div>

                <div class="control-group">
                    <label  class="control-label">Jenis Bahan Bakar<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_JNS_BHN_BKR', @$options_jns_bbm, !empty($default->ID_JNS_BHN_BKR) ? $default->ID_JNS_BHN_BKR : '', 'class="span12 select2" id="ID_JNS_BHN_BKR"'); ?>
                        <br>
                        <br>
                        <button type="button" class="btn btn-primary" id="btn-cari">Cari</button>
                    </div>
                </div>
                <div class="control-group">
                    <label  class="control-label">Nomor Transaksi<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_TRANS', '', !empty($default->ID_TRANS) ? $default->ID_TRANS : '', 'class="span12 select2" id="ID_TRANS"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label  class="control-label">Tanggal Pengakuan<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('TGL_BA', !empty($default->TGL_BA) ? $default->TGL_BA : '', 'class="span12" id="TGL_BA" readonly style="color : black"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label  class="control-label">Status Approve<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('STATUS', !empty($default->STATUS) ? $default->STATUS : '', 'class="span12" id="STATUS" readonly style="color : black"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label  class="control-label">Jenis Rollback<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('JNS_ROLLBACK', $jenis_rollback, !empty($default->JNS_ROLLBACK) ? $default->JNS_ROLLBACK : '', 'class="span12 select2" id="JNS_ROLLBACK"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label  class="control-label">Alasan Rollback<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_textarea('ALASAN_ROLLBACK', !empty($default->ALASAN_ROLLBACK) ? $default->ALASAN_ROLLBACK : '', 'class="span12" id="ALASAN_ROLLBACK" required style="color : black;height : 50px;"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls pull-right span2">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" id="btn-check">Check</button>
                    </div>
                </div>
            </div>
            <div class="span8" id="showtable">
                <div class="box">
                    <div class="box-body">
                        <h4>Data Transaksi</h4>
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Pembangkit</th>
                                <th>Jenis <br>Transaksi</th>
                                <th>Jenis <br>BBM</th>
                                <th>Nomor <br>Transaksi</th>
                                <th>Tanggal <br>Pengakuan</th>
                                <th>Status</th>
                                <th>Jenis <br>Rollback</th>
                            </thead>
                            <tbody id="tbody_trans">
                                
                            </tbody>
                        </table>
                        <h4>Data yang akan di rollback otomatis</h4>
                        <div id="table_pemakaian">
                           
                        </div>
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
                        <hr>
                        <div class="form-actions">
                            <div class="control-group">
                                <div class="controls pull-right span2">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-primary" id="btn-rollback">Rollback</button>
                                </div>
                            </div>
                        </div>
                        <h4>Hasil Rollback Data Sebelumnya</h4>
                        <div id="temp_rollback"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
        <?php echo anchor(null, '<i class="icon-arrow-left"></i> Kembali', array('id' => 'button-back', 'class' => 'green btn', 'onclick' => 'kembali();')); ?>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        setDefaultBBM();
        $("#showtable").hide();
        $(".form_datetime").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left",
            beforeShow: function(i) { if ($(i).attr('readonly')) { return false; } }

        });

        $('#btn-cari').click(function(){
            var v_jnsbbm = $('#ID_JNS_BHN_BKR').val();
            var v_sloc = $('#SLOC').val();
            var v_jenis = $('#ID_JENIS').val();

            get_transaksi(v_jnsbbm,v_sloc,v_jenis);
        })

        $('#btn-rollback').click(function(){
            var checked = [];
            $("input[name='ID_ROLLBACK[]']:checked").each(function ()
            {
                checked.push($(this).val());
            });
            var vlink_url = '<?php echo base_url()?>data_transaksi/rollback_baru/get_id_rollback/';
            $.ajax({
                url: vlink_url,
                type: "POST",
                data : {
                    ID_ROLLBACK : checked
                },
                error:function(data){
                    alert('error'); 
                },
                success:function(data) {
                   $('#temp_rollback').html(data);
                }
            });
        })

        $('#btn-check').click(function(){
            $('#temp_rollback').empty();
            var v_jnsbbm = $('#ID_JNS_BHN_BKR option:selected').text();
            var v_sloc = $('#SLOC option:selected').text();
            var v_jenis = $('#ID_JENIS').select2('val');
            var v_namajenis = $('#ID_JENIS option:selected').text();
            var v_nomortrans = $('#ID_TRANS').select2('val');
            var v_namatrans = $('#ID_TRANS option:selected').text();
            var v_tglba = $('#TGL_BA').val();
            var v_status = 'Disetujui';
            var v_jenisrollback = $('#JNS_ROLLBACK option:selected').text();

            var p_sloc = $('#SLOC').val();
            var p_jnsbbm = $('#ID_JNS_BHN_BKR').val();

            if(v_jenis == 3) {
                $('#showtable').hide();
            } else if(v_jenis == 1) {
                var vlink_url = '<?php echo base_url()?>data_transaksi/rollback_baru/get_transaksi_prev/';
                $('#showtable').show();
            } else if(v_jenis == 2){
                var vlink_url = '<?php echo base_url()?>data_transaksi/rollback_baru/get_transaksi_prev/';
                $('#showtable').show();
            } else if(v_jenis == 4){
                var vlink_url = '<?php echo base_url()?>data_transaksi/rollback_baru/get_transaksi_prev/';
                $('#showtable').show();
            }
            if(v_jnsbbm == '' || v_sloc == '' || v_jenis == '' || v_nomortrans == '' || v_tglba == '' || v_status == '' ||v_jenisrollback == ''){
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data tidak boleh kosong-- </div>', function() {});
            } else {

                if(v_jenis == 4) {
                    var link = '<?php echo base_url()?>data_transaksi/rollback_baru/get_transaksi_penerimaan/';
                } else if(v_jenis == 1) {
                    var link = '<?php echo base_url()?>data_transaksi/rollback_baru/get_transaksi_stockopname/'
                } else if(v_jenis == 2) {
                    var link = '<?php echo base_url()?>data_transaksi/rollback_baru/get_transaksi_pemakaian/'
                }
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
                        bootbox.hideAll();
                        $('#table_pemakaian').html(data);
                    }
                })
                
                $.ajax({
                    url: vlink_url,
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
                                var g = "<input name='ID_ROLLBACK[]' type='radio' value='"+value.ID_TRX+","+value.JNS_TRX_BACKDATE+","+value.SLOC+","+value.ID_JNS_BHN_BKR+","+value.TGL_BACKDATE+"'>";
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
                        
                        $('#tbody_trans').append(
                            '<td>'+v_sloc+'</td>'+
                            '<td>'+v_namajenis+'</td>'+
                            '<td>'+v_jnsbbm+'</td>'+
                            '<td>'+v_namatrans+'</td>'+
                            '<td>'+v_tglba+'</td>'+
                            '<td>'+v_status+'</td>'+
                            '<td>'+v_jenisrollback+'</td>'
                        )
                        bootbox.hideAll();
                    }
                });
                
            }
            
        })

        $('#ID_TRANS').change(function(){
            var jenis = $("#ID_JENIS").val();
            var id = $(this).val();
            get_detailtransaksi(id,jenis);
        })

        $('#SLOC').change(function(){
            var sloc = $(this).val();
            get_jenis_bbm(sloc);
            get_all(sloc)
        })

        $('.select2').select2()
      
    });

    function get_jenis_bbm(v_sloc){
        var vlink_url = '<?php echo base_url()?>data_transaksi/rollback_baru/load_jenisbbm/';
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
        var vlink_url = '<?php echo base_url()?>data_transaksi/rollback_baru/get_all/';
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
                $('#REGIONAL').val(obj.NAMA_REGIONAL);
                $('#LEVEL1').val(obj.LEVEL1);
                $('#LEVEL2').val(obj.LEVEL2);
                $('#LEVEL3').val(obj.LEVEL3);
                bootbox.hideAll();
            }
        }); 
    }

    function get_transaksi(v_jnsbbm,v_sloc,v_jenis) {
        var vlink_url = '<?php echo base_url()?>data_transaksi/rollback_baru/get_transaksi/';
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
                    if(v_jenis == 1) {
                        $('select[name="ID_TRANS"]').append('<option value="'+ value.ID_STOCKOPNAME +'">'+ value.NO_STOCKOPNAME +'</option>');
                    } else if(v_jenis == 3){
                        $('select[name="ID_TRANS"]').append('<option value="'+ value.ID_PERMINTAAN +'">'+ value.NO_NOMINASI +'</option>');
                    } else if(v_jenis == 2){
                        $('select[name="ID_TRANS"]').append('<option value="'+ value.ID_PEMAKAIAN +'">'+ value.NO_TUG +'</option>');
                    } else if(v_jenis == 4){
                        $('select[name="ID_TRANS"]').append('<option value="'+ value.ID_PENERIMAAN +'">'+ value.NO_MUTASI_TERIMA +'</option>');
                    }
                });
                bootbox.hideAll();
            }
        });
    }

    function get_detailtransaksi(v_idtrans,v_jenis) {

        var vlink_url = '<?php echo base_url()?>data_transaksi/rollback_baru/get_detailtransaksi/';
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

    function kembali() {
        bootbox.confirm('Anda yakin akan kembali ke halaman awal ? Data tidak akan tersimpan ?', "Tidak", "Ya", function(e) {
            if(e){
                load_filter();
                load_table();
            }
        });
    }
    

</script>