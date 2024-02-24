
<!-- /**
 * @module PERHITUNGAN HARGA
 * @author  RAKHMAT WIJAYANTO
 * @created at 17 OKTOBER 2017
 * @modified at 20 MARET 2018
 * @modified by BAKTI DWI DHARMA WIJAYA
 */ -->
<style type="text/css">
    #modal_tembusan{
      width: 60%;
      left: 20%;
      margin: 0 auto;
    }
</style>

 <div class="inner_content">
    <div class="statistic clearfix">
        <div class="current_page pull-left">
            <span><?php echo isset($page_title) ? $page_title : 'Untitle'; ?></span>
        </div>
    </div>
    <div class="widgets_area">
        <div class="row-fluid">
            <div class="span12">
                <div id ="index-content" class="well-content no-search">

                    <div class="well">
                        <div class="pull-left">
                            <?php echo hgenerator::render_button_group($button_group); ?>
                        </div>
                    </div>
                    <div class="well">
                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter')); ?>
                                <div class="form_row">
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Bulan : </label>
                                        <div class="controls">
                                            <div class="controls">
                                            <?php echo form_dropdown('BULAN', $opsi_bulan, '','style="width: 145px;", id="bln"'); ?>
                                        </div>
                                        </div>
                                    </div>
                                   <div class="pull-left span2">
                                        <label for="password" class="control-label">Tahun : </label>
                                        <div class="controls">
                                            <div class="controls">
                                            <?php echo form_dropdown('TAHUN', $opsi_tahun, '','style="width: 145px;", id="thn"'); ?>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Pemasok :</label>
                                        <div class="controls">
                                            <?php echo form_dropdown('ID_PEMASOK', $option_pemasok, !empty($default->ID_PEMASOK) ? $default->ID_PEMASOK : '', 'style="width:145px"'); ?>
                                        </div>
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label">Filter Status :</label>
                                        <div class="controls">
                                            <?php echo form_dropdown('STATUS', $status_options, isset($status) ? $status : '', 'style="width:145px"'); ?>
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
                                    <!-- <div class="pull-left span2">
                                        <label for="password" class="control-label">Pembangkit : </label>
                                        <div class="controls">
                                            <?php //echo form_dropdown('SLOC', $lv4_options, !empty($default->SLOC) ? $default->SLOC : '', 'id="lvl4" style="width:145px"'); ?>
                                        </div>
                                    </div> -->
                                </div>
                                <br>
                                <div class="form_row">
                                   <div class="pull-left span2">
                                        <label for="password" class="control-label">Kata Kunci : </label>
                                        <div class="controls">
                                            <!-- <br> -->
                                            <input type="text" name="kata_kunci" class="control-label">
                                        </div>
                                        
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label"></label>
                                        <div class="controls">
                                            <!-- <br> -->
                                            <!-- <button type="button" class="btn"><i class='icon-search'></i>Filter</button> -->
                                            <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter')); ?>
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

<!-- Modal -->
<div class="modal fade" id="modal_tembusan" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Pilihan Tembusan</h4>
        </div>
        <div class="modal-body"> 


            <div class="row-fluid">
                <div class="box-content">
                    <div class="control-group">
                        <label  class="control-label">Pencarian : </label>
                        <div class="controls">
                            <select id="TEMBUSAN" multiple="multiple" class="span9">
                                <?php
                                    foreach ($tembusan_options as $row) {
                                        echo "<option value='$row->NAMA'>$row->NAMA</option>";
                                    }
                                ?>
                            </select>
                            &nbsp;
                            <?php echo anchor(null, '<i class="icon-refresh"></i> Reset', array('id' => 'button-reset', 'class' => 'red btn', 'onclick' => "setReset()")); ?>   
                        </div>
                    </div>
                </div>
            </div>                   
          <!-- <p>Some text in the modal.</p> -->
                <!-- <div id ="index-content" class="well-content no-search"> -->
                   <!--  <div class="well">
                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter2')); ?>
                                <div class="form_row">
                                   <div class="pull-left">
                                        <label for="password" class="control-label">Pencarian : </label>
                                        <div class="controls">
                                            <select id="TEMBUSAN" multiple="multiple" class="span7">
                                                <?php
                                                    foreach ($tembusan_options as $row) {
                                                        echo "<option value='$row->NAMA'>$row->NAMA</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>                                        
                                    </div>
                                </div>
                                <br>
                            <div class="form-actions">
                                <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-save', 'class' => 'blue btn', 'onclick' => "simpan_data(this.id, '#finput', '#button-back')")); ?>
                                <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back', 'class' => 'btn', 'onclick' => 'close_form_modal(this.id)')); ?>
                            </div>                                
                            <?php echo form_close(); ?>
                         </div>    
                    </div> 
        
                    <div>&nbsp;</div> -->
                <!-- </div> -->
                <!-- <div id="form-content2" class="well-content"></div> -->
        </div>
        <br>
        <div class="modal-footer">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-cetak-pdf', 'class' => 'blue btn', 'onclick' => "setCetakPdf()")); ?>            
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
      
    </div>
</div> 

<div class="modal fade" id="modal_upload" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload Dokumen Harga</h4>
        </div>
        <div class="modal-body"> 

            <div class="row-fluid">
                <div class="box-content">
                    <?php
                    $form_action = base_url().'data_transaksi/perhitungan_harga/proses_file';
                    $hidden_form = array('id' => !empty($id) ? $id : '');
                    echo form_open_multipart($form_action, array('id' => 'fupload', 'class' => 'form-horizontal'), $hidden_form);
                    ?>
                    <div class="control-group">
                        <label for="control-label" class="control-label">Periode Perhitungan : </label>
                        <div class="controls">
                           <input type="text" id="_periode_view"  disabled class="span3">
                           <input type="hidden" id="_periode" name="_periode" class="span3">
                           <input type="hidden" id="_id_trx_file" name="_id_trx_file">
                           <input type="hidden" id="_id_group_file" name="_id_group_file">
                           <input type="hidden" id="_jns_trx" name="_jns_trx">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="control-label" class="control-label">Pemasok : </label>
                        <div class="controls">
                            <input type="text" id="_pemaosk" disabled class="span10">
                        </div>
                    </div>
                    <div class="control-group" id="div_no_pjbbm">
                        <label for="control-label" class="control-label">No. PJBBBM : </label>
                        <div class="controls">
                            <input type="text" id="_no_pjbbbm_view" disabled class="span11">
                            <input type="hidden" id="_no_pjbbbm" name="_no_pjbbbm" class="span11">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="control-label" class="control-label">Upload File (Max 10 MB) : </label>
                        <div class="controls">
                            <input type="file" id="PATH_FILE_IN" name="PATH_FILE_IN"/>                        
                            <input type="hidden" id="PATH_FILE_EDIT_IN" name="PATH_FILE_EDIT_IN" value="<?php echo !empty($default->PATH_FILE) ? $default->PATH_FILE : ''?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="control-label" class="control-label"> </label> 
                        <!-- dokumen -->
                        <?php  
                            if ($this->laccess->is_prod()){ ?>
                                <div class="controls" id="dokumen">
                                    <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="KONTRAKPEMASOK" data-url="<?php echo $url_getfile;?>" data-filename=""><b>Lihat Dokumen</b></a>
                                </div> 
                        <?php } else { ?>
                                <div class="controls" id="dokumen">
                                    <a href="<?php echo base_url().'assets/upload/kontrak_pemasok/'.$default->PATH_FILE;?>" target="_blank" id="lihatdoc"><b>Lihat Dokumen</b></a>
                                </div>
                        <?php } ?>
                        <!-- end dokumen -->
                    </div>                                      
                    <?php echo form_close(); ?>
                </div>

            </div>                       
        </div>
        <!-- <br> -->
        <div class="modal-footer">
            <?php echo anchor(null, '<i class="icon-save"></i> Simpan', array('id' => 'button-upload-harga', 'class' => 'blue btn', 'onclick' => "setUpload()")); ?>            
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>      
    </div>
</div> 

<form id="export_pdf" action="<?php echo base_url('data_transaksi/perhitungan_harga/export_pdf_pertamina'); ?>" method="post"  target="_blank">   
   <input type="hidden" name="id_trx">
   <input type="hidden" name="id_group">
   <input type="hidden" name="id_tembusan">
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

    $('.chosen').chosen();

    $.extend($.fn.select2.defaults, {
        formatSelectionTooBig: function (limit) {
            return 'Max 100 data yang dipilih';
        }
    });

    var s2 = $("#TEMBUSAN").select2({
        placeholder: 'Pilih Tembusan',
        maximumSelectionSize: 100,
    });        

    function load_pdf(vid){  
        var _url = $('#'+vid).attr('data-source');
        var _id_group = $('#'+vid).attr('id-group');
        var _id_trx = vid.split('-');
        
        $('input[name="id_trx"]').val(_id_trx[2]);
        $('input[name="id_group"]').val(_id_group);
        $('#export_pdf').attr('action', _url);
        
        $('#modal_tembusan').modal('show');        
    }

    function load_upload(vid){    
        var _url = $('#'+vid).attr('data-source');
        var _id_group = $('#'+vid).attr('id-group');
        var _set_val = $('#'+vid).attr('val');
        var _nama_file = $('#'+vid).attr('nama-file');
        var _val = _set_val.split('~');        
        var _id_trx = vid.split('-');  
    
        reset_file_upload();

        $('#_periode').val(_val[0]);
        $('#_periode_view').val(_val[0]);
        $('#_pemaosk').val(_val[1]);
        $('#_no_pjbbbm').val(_val[2]);
        $('#_no_pjbbbm_view').val(_val[2]);
        $('#_jns_trx').val(_val[3]);
        
        $('#_id_trx_file').val(_id_trx[2]);
        $('#_id_group_file').val(_id_group);

        if ($('#_jns_trx').val()!='CIF'){
            $('#div_no_pjbbm').hide();
        } else {
            $('#div_no_pjbbm').show();
        }        
        get_detail_file(_id_group);       
    } 

    function get_detail_file(vId) {
        var data = {idx: vId};
        $('#dokumen').hide();
        bootbox.modal('<div class="loading-progress"></div>');

        $.post("<?php echo base_url()?>data_transaksi/perhitungan_harga/get_detail_file/", data, function (data) {
            var rest = (JSON.parse(data));            
                           
            if (rest.length > 0){
                var _nama_file = rest[0].PATH_FILE_UPLOAD;
                var url = "<?php echo base_url() ?>assets/upload/kontrak_pemasok/"+_nama_file;

                $("#PATH_FILE_EDIT_IN").val(_nama_file);

                // <!-- dokumen -->
                <?php  
                    if ($this->laccess->is_prod()){ ?>
                        $("#lihatdoc").attr("data-filename", _nama_file);
                <?php } else { ?>
                        $("#lihatdoc").attr("href", url);
                <?php } ?>
                // <!-- end dokumen -->

                if (_nama_file){
                    $('#dokumen').show();    
                }                   
            }      
            bootbox.hideAll();          
            $('#modal_upload').modal('show');         
        });
    }    

    function reset_file_upload(){
        var $el = $('#PATH_FILE_IN');
        $el.wrap('<form>').closest('form').get(0).reset();
        $el.unwrap(); 
    }       

    function setCetakPdf(){
       $('#modal_tembusan').modal('toggle');
       bootbox.confirm('Apakah yakin akan export data pdf ?', "Tidak", "Ya", function(e) {
         if(e){
             // var _url = $('#'+vid).attr('data-source');
             // var _id_group = $('#'+vid).attr('id-group');
             
             // var _id_trx = vid.split('-');         
             // // alert(id_trx[2]);
             // $('input[name="id_trx"]').val(_id_trx[2]);
             // $('input[name="id_group"]').val(_id_group);
             // $('#export_pdf').attr('action', _url);
             $('input[name="id_tembusan"]').val($('#TEMBUSAN').val());
             $('#export_pdf').submit();             
         }
       }); 
    }

    function setUpload(){
        if ($('#PATH_FILE_IN').val()){
            simpan_file();
        } else {
            bootbox.alert('<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i>  --Silahkan pilih file yang akan di upload-- </div>', function() {});
        }
    }

    function simpan_file() {
      var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga/proses_file";
      bootbox.confirm('Anda yakin akan upload file ?', "Tidak", "Ya", function(e) {
        if(e){
          bootbox.modal('<div class="loading-progress"></div>');

            $('#fupload').ajaxSubmit({
                beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
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
                  bootbox.hideAll();

                  bootbox.alert(message, function() {
                    if (data[0]) {                        
                        // location.reload();
                        $('#modal_upload').modal('toggle');                    
                    }                       
                  });
                }
            });
        }
      });
    }    

    function setReset(){       
       bootbox.confirm('Apakah yakin akan reset pencarian ?', "Tidak", "Ya", function(e) {
         if(e){
             s2.val("").trigger("change");           
         }
       }); 
    }    

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
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga/get_options_lv1/'+stateID;
        setDefaultLv1();
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="COCODE"]').append('<option value="'+ value.COCODE +'">'+ value.LEVEL1 +'</option>');
                    });
                }
            });
        }
    });

    $('select[name="COCODE"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga/get_options_lv2/'+stateID;
        setDefaultLv2();
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="PLANT"]').append('<option value="'+ value.PLANT +'">'+ value.LEVEL2 +'</option>');
                    });
                }
            });
        }
    });

    $('select[name="PLANT"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga/get_options_lv3/'+stateID;
        setDefaultLv3();
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="STORE_SLOC"]').append('<option value="'+ value.STORE_SLOC +'">'+ value.LEVEL3 +'</option>');
                    });
                }
            });
        }
    });

    $('select[name="STORE_SLOC"]').on('change', function() {
        var stateID = $(this).val();
        var vlink_url = '<?php echo base_url()?>data_transaksi/perhitungan_harga/get_options_lv4/'+stateID;
        setDefaultLv4();
        if(stateID) {
            $.ajax({
                url: vlink_url,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('select[name="SLOC"]').append('<option value="'+ value.SLOC +'">'+ value.LEVEL4 +'</option>');
                    });
                }
            });
        }
    });

</script>