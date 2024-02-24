
<style type="text/css">
    label.error {color: red;}
</style>
<div class="box-content" id="divAtas">
    <?php
$hidden_form = array('id' => !empty($id) ? $id : '');

echo form_open_multipart($form_action, array('id' => 'input', 'class' => 'form-horizontal'), $hidden_form);
?>
    <div class="well-content clearfix">
        <div class="form-row">
            <div class="span8">
                <div class="control-group">
                    <label for="password" class="control-label">Create By <span class="required">*</span> : </label>
                    <div class="controls">
                        <input type="text" class="form-control" name="NAMA_SURVEYOR" maxlength="100"  style="width: 100%" id="NAMA_SURVEYOR" autocomplete="off" readonly value="<?php echo !empty($surveyor) ? $surveyor : $NAMA_SURVEYOR; ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label  class="control-label">Pemasok<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_PEMASOK', @$options_pemasok, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'class="span6 select2"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Depo <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_DEPO', $options_depo, !empty($default->ID_DEPO) ? $default->ID_DEPO : '', 'class="span6 select2"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Product <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('ID_JNS_BHN_BKR', @$options_bbm, !empty($default->KOMP_BBM) ? $default->KOMP_BBM : '', 'class="span6 select2" id="bbm"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Report Number <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('NO_REPORT', !empty($default->NO_REPORT) ? $default->NO_REPORT : '', 'class="form-control" maxlength="40" style="width: 70%;" placeholder="Masukan No Report..." id="NO_REPORT" autocomplete="off"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Tanggal Sampling <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('TGL_SAMPLING', !empty($default->SAMPLING_DATE) ? $default->SAMPLING_DATE : '', 'class="form-control form_datetime" style="width: 70%;" placeholder="Masukan Tanggal Sampling..." id="TGL_SAMPLING" autocomplete="off"'); ?>
                        
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Tanggal COQ <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('TGL_COQ', !empty($default->COQ_DATE) ? $default->COQ_DATE : '', 'class="form-control form_datetime" style="width: 70%;" placeholder="Masukan Tanggal COQ..." id="TGL_COQ" autocomplete="off"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Shore Tank <span class="required">*</span> : </label>
                    <div class="controls">
                         <?php echo form_input('SHORE_TANK', !empty($default->SHORE_TANK) ? $default->SHORE_TANK : '', 'class="form-control" style="width: 70%;" placeholder="Masukan Shore Tank..." id="SHORE_TANK" maxlength="50" autocomplete="off"'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Destinasi Pembangkit <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_dropdown('SLOC[]', $options_pembangkit, !empty($SLOC) ? $SLOC : '', 'class="span6 select2sloc" id="mselect" multiple style="width: 70%"'); ?>
                        <input type="hidden" id="SLOC_EDIT" value="<?php echo !empty($SLOC) ? $SLOC : '' ?>">
                        <br>
                        <br>
                        <div id="div_button">
                            <button type="button" class="btn btn-default" id="btn-unall" onclick="unselect_all()">Batal Semua</button>
                        </div>
                    </div> 
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Keterangan <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php 
                            $data = array(
                              'name'        => 'KET',
                              'id'          => 'KET',
                              'value'       => !empty($default->KET) ? $default->KET : '',
                              'rows'        => '4',
                              'style'       => 'width:70%',
                            );

                            echo form_textarea($data);
                        ?>                        
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Referensi Standar Mutu <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('ref_mutu', !empty($DITETAPKAN) ? $DITETAPKAN : '', 'class="form-control" id="ref_mutu" readonly'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Nomor Referensi <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('ref_nama', !empty($NO_VERSION) ? $NO_VERSION : '', 'class="form-control" id="ref_nama" readonly'); ?>
                    </div>
                </div>
                <div class="control-group">
                    <label for="password" class="control-label">Tanggal Referensi <span class="required">*</span> : </label>
                    <div class="controls">
                        <?php echo form_input('ref_tanggal', !empty($TGL_VERSION) ? $TGL_VERSION : '', 'class="form-control" id="ref_tanggal" readonly'); ?>
                        <input type="hidden" name="ID_VERSION" id="ID_VERSION" value="<?php echo !empty($default->ID_VERSION) ? $default->ID_VERSION : '' ?>">
                    </div>
                </div>

                <input type="hidden" name="PATH_FILE_EDIT" value="<?php echo !empty($default->PATH_DOC) ? $default->PATH_DOC : ''?>">
                <div class="control-group">
                    <label for="password" class="control-label" id="up_nama">Upload file (Max 4 MB)<span class="required">*</span>: </label> 
                    <div class="controls" id="up_file">
                    <?php echo form_upload('FILE_UPLOAD', !empty($default->PATH_DOC) ? $default->PATH_DOC : '', 'class="span6" accept="image/x-png,image/jpg,image/jpeg,application/pdf"'); ?>
                    </div>
                 
                <div class="control-group">
                    <label for="password" class="control-label"> </label>
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
                <!--  -->
                <div class="control-group">
                    <label for="password" class="control-label"></label>
                    <div class="controls">
                        <br>
                        <button type="button" class="btn btn-default" id="btn-set">Input Result</button>
                        <button type="button" class="btn btn-default" id="btn-batal">Batal</button>
                    </div>
                </div>
                
            <!-- dokumen -->
            
            <!-- end dokumen -->
        </div>  
            </div>
        </div>
    </div>
    <div class="well-content clearfix">
        <div id="divTable">

        </div>
    </div>
    <div class="form-actions">
        <button class="blue btn" type="submit"><i class="icon-save"></i> Simpan</button>
        <!-- <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn')); ?> -->
        <?php echo anchor(null, '<i class="icon-arrow-left"></i> Kembali', array('id' => 'button-back', 'class' => 'green btn', 'onclick' => 'kembali();')); ?>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $(".form_datetime").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left",
            beforeShow: function(i) { if ($(i).attr('readonly')) { return false; } }

        });

        $('#TGL_COQ').change(function(){
            cek_tanggal();
        })  

        $('#NO_REPORT').on('input propertychange paste', function(){        
            var str = this.value;
            str = str.replace(/\"/g,'');
            str = str.replace(/\'/g,'');
            str = str.replace(/\\/g,'');
            str = str.replace(/\[/g,'');
            str = str.replace(/\]/g,'');
            str = str.replace(' ','');
            this.value = str;
          
        });

        $('#KET').on('input propertychange paste', function(){        
            var str = this.value;
            str = str.replace(/\"/g,'');
            str = str.replace(/\'/g,'');
            str = str.replace(/\\/g,'');
            str = str.replace(/\[/g,'');
            str = str.replace(/\]/g,'');
            this.value = str;
          
        });
        
        $('#btn-set').click(function(){
            var str         = $('#TGL_SAMPLING').val();
            var tgl_coq     = $('#TGL_COQ').val();
            var jnsbbm      = $('#bbm').val();
            var NO_REPORT   = $('#NO_REPORT').val();
            if(str == '' && jnsbbm == '') {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Tanggal Sampling Jenis BBM tidak boleh kosong !-- </div>', function() {});
            } else {
                if(str == ''){
                
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Tanggal Sampling tidak boleh kosong !-- </div>', function() {});
                }
                else if(jnsbbm == '') {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Jenis BBM tidak boleh kosong !-- </div>', function() {});
                } else {
                    get_version(jnsbbm,str,NO_REPORT);
                }
            }
        })

        $('#btn-batal').click(function(){
            $('#TGL_SAMPLING').val('');
            $('#bbm').val('');
            $('#bbm').trigger('change');
        })

        $('#bbm').change(function(){
            content_check();
        })

        $('#TGL_SAMPLING').change(function(){
            content_check();
            var dateStart = $(this).val();
            $('#TGL_COQ').datepicker('setStartDate', dateStart);
            if ($('#TGL_COQ').val() == '') {

            } else{
               setCekTgl();
            }
        })

        $('#lvl4').select2();

        $('.select2').select2({
            theme : "classic"
        });

        $('.select2sloc').select2({
            placeholder: "-- Pilih Pembangkit --",
            allowClear: true
        });
        setDefaultDepo();

        var idt = "<?php echo $id ?>";
        if(idt == '') {
            
        } else {
            get_array_sloc();
            table_edit();
        }
        // options_jenis_bahan_bakar();    
    });

    function setCekTgl(){
        var dateStart = $('#tglawal').val();
        var dateEnd = $('#tglakhir').val();

        if (dateEnd < dateStart){
            $('#tglakhir').datepicker('update', dateStart);
        }
    }

    function get_array_sloc() {

        var str = $('#SLOC_EDIT').val();
        var temp = new Array();
        temp = str.split(",");

        $('#mselect').val(temp).trigger("change"); 

    }

    function get_version(jnsbbm,str,NO_REPORT) {
        var vlink_url = '<?php echo base_url()?>data_transaksi/coq/get_tgl_version/';
        $.ajax({
            url: vlink_url,
            type: "POST",
            data : {
                report_no : NO_REPORT,
                bbm       : jnsbbm,
                tgl       : str,
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

                if(obj == '') {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Data Tidak Ditemukan ! -- </div>', function() {});
                } else if(obj[0] == false) {
                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>'+obj[2]+'</div>', function() {});
                } else {
                    $('#ref_mutu').val(obj[0].DITETAPKAN);
                    $('#ref_nama').val(obj[0].NO_VERSION);
                    $('#ref_tanggal').val(obj[0].TGL_VERSION);
                    $('#ID_VERSION').val(obj[0].ID_VERSION);

                    get_table_by_idversion(jnsbbm,obj[0].ID_VERSION)
                }
                
            }
        });
    }

    function get_table_by_idversion(jnsbbm,idversion) {
        var vlink_url = '<?php echo base_url()?>data_transaksi/coq/get_table_by_idversion/';
        $.ajax({
            url: vlink_url,
            type: "POST",
            data : {
                id_version : idversion,
                bbm : jnsbbm,
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
                
                $('#divTable').html(data);
                                
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

    function select_all() {
        $("#mselect > option").prop("selected","selected");// Select All Options
        $("#mselect").trigger("change");// Trigger change to select 2
        $('html, body').animate({scrollTop: $("#div_button").offset().top}, 1000);
    }

    function unselect_all() {
        $('#mselect option').attr('selected', false);
        $('#mselect').trigger('change');
        $('html, body').animate({scrollTop: $("#divAtas").offset().top}, 1000);
    }

    function setDefaultDepo() {
        var id_depo = $('select[name="ID_DEPO"]').val();
        if(id_depo == '' || id_depo == null || id_depo == undefined) {
            $('select[name="ID_DEPO"]').empty();
            $('select[name="ID_DEPO"]').append('<option value="">-- Pilih Depo --</option>');
        }
        
    }

    $('select[name="ID_PEMASOK"]').on('change', function() {
        
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/coq/get_depo_by_pemasok/'+stateID;
        setDefaultDepo();
        if(stateID) {
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="ID_DEPO"]').append('<option value="'+ value.ID_DEPO +'">'+ value.NAMA_DEPO +'</option>');
                    });
                    bootbox.hideAll();
                }
            });
        }
    });

    function options_jenis_bahan_bakar() {
        var vlink_url = '<?php echo base_url()?>data_transaksi/coq/options_jenis_bahan_bakar/';
        $.ajax({
            url: vlink_url,
            type: "POST",
            success:function(data) {
                $('#bbm').html(data);
            }
        });
    } 

    function table_edit() {
        var vlink_url = '<?php echo base_url()?>data_transaksi/coq/table_edit/';
        var id = $('input[name="id"]').val();
        $.ajax({
            url: vlink_url,
            type: "POST",
            data : {
                id : id
            },
            success:function(data) {
                $('#divTable').html(data);
            }
        });
    } 

    function content_check() {

        var ref_mutu = $('#ref_mutu').val();
        var ref_nama = $('#ref_nama').val();
        var ref_tanggal = $('#ref_tanggal').val();
        var ID_VERSION = $('#ID_VERSION').val();
        var content_table = $('#divTable').html();

        if(ref_mutu != '' || ref_nama != '' || ref_tanggal != '' || ID_VERSION != '' || content_table != '') {
            $('#ref_mutu').val('');
            $('#ref_nama').val('');
            $('#ref_tanggal').val('');
            $('#ID_VERSION').val('');
            $('#divTable').html('');
        }
    }
        
    $.validator.messages.required = "Nilai tidak boleh kosong !";
    $.validator.addClassRules('select2', {
        required: true
    });

    var id = $('input[name="id"]').val();

    if(id == ''){
        var rule = {
            ID_PEMASOK     : 'required',
            ID_DEPO        : 'required',
            ID_JNS_BHN_BKR : 'required',
            NO_REPORT      : 'required',
            TGL_SAMPLING   : 'required',
            TGL_COQ        : 'required',
            FILE_UPLOAD    : 'required',
            "SLOC[]"       : 'required'
        };
    } else {
        var rule = {
            ID_PEMASOK     : 'required',
            ID_DEPO        : 'required',
            ID_JNS_BHN_BKR : 'required',
            NO_REPORT      : 'required',
            TGL_SAMPLING   : 'required',
            TGL_COQ        : 'required',
            "SLOC[]"       : 'required'
        }
    }
    

    $("#input").validate({
        ignore: ':hidden:not(select)',
        errorPlacement: function (error, element) {
            $('html, body').animate({scrollTop: $("#input").offset().top}, 1000);
            if (element.is(":hidden")) {
                element.next().parent().append(error);
            } else if(element.hasClass('select2')) {
                error.insertAfter(element.next('span'));
            }else if(element.hasClass('select2sloc')) {
                error.insertAfter(element.next('span'));
            } else {
                error.insertAfter(element);
            }
        },
        rules : rule,
        messages : {
            ID_PEMASOK     : "<b style='color:red'>Nama Pemasok tidak boleh kosong !</b>",
            ID_DEPO        : "<b style='color:red'>Nama Depo tidak boleh kosong !</b>",
            ID_JNS_BHN_BKR : "<b style='color:red'>Jenis Bahan Bakar tidak boleh kosong !</b>",
            NO_REPORT      : "<b style='color:red'>Nomor Report tidak boleh kosong !</b>",
            TGL_SAMPLING   : "<b style='color:red'>Tanggal Sampling tidak boleh kosong !</b>",
            TGL_COQ        : "<b style='color:red'>Tanggal COQ tidak boleh kosong !</b>",
            SHORE_TANK     : "<b style='color:red'>Shore Tank tidak boleh kosong !</b>",
            FILE_UPLOAD    : "<b style='color:red'>File tidak boleh kosong !</b>",
            "SLOC[]"       : "<b style='color:red'>Pembangkit Tidak Boleh kosong !</b>",
        },
        submitHandler: function(form) {

            if($('#divTable').html().length == 0) {
                bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  -- Maaf, Data CoQ belum terisi, mohon klik tombol <b>"Input Result"</b> untuk dapat menginput parameter CoQ. -- </div>', function() {});
            } else {
                bootbox.confirm('Anda yakin akan menambah entrian data ?', "Tidak", "Ya", function(e) {
                    if(e){
                        var data = new FormData(form);
                        $.ajax({
                            type: 'POST',
                            url: $("#input").attr('action'),
                            data: data,
                            contentType: false,
                            processData: false,

                            // beforeSend:function(data){
                            //     bootbox.modal('<div class="loading-progress"></div>');
                            // },
                            // error: function(data) {
                            //     bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses penyimpanan data gagal-- </div>', function() {});
                            //     bootbox.hideAll();
                            // },
                            success: function(data) {
                                var obj = JSON.parse(data)
                                if(obj[0] == true) {
                                    bootbox.alert('<div class="box-title" style="color:green;"><i class="icon-check"></i>&nbsp'+obj[2]+'</div>', function() {
                                        load_filter();
                                        if (typeof cek_notif !== 'undefined' && $.isFunction(cek_notif)) {
                                            cek_notif();
                                        }
                                    });
                                    
                                } else {
                                    bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Proses penyimpanan data gagal-- </div><div>'+obj[2]+'</div>', function() {
                                        bootbox.hideAll();
                                    });

                                }
                            }
                        })
                    }
                });
            }
            
            return false;
        }
    });

    function kembali() {
        bootbox.confirm('Anda yakin akan kembali ke halaman awal ? Data tidak akan tersimpan ?', "Tidak", "Ya", function(e) {
            if(e){
                load_filter();
                load_table();
            }
        });
    }
    

</script>