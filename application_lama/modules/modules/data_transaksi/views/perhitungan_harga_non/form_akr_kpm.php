<?php
/**
 * Created by PhpStorm.
 * User: mrapry
 * Date: 10/20/17
 * Time: 10:51 PM
 */ ?>

<link href="<?php echo base_url();?>assets/css/cf/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>assets/js/cf/jquery.dataTables.min.js" type="text/javascript"></script>

<style type="text/css">
#modal_pencarian{
  width: 80%;
  left: 10%;
  margin: 0 auto;
}

</style>

<style type="text/css">
    .dataTables_scrollHeadInner {
      width: 100% !important;
    }
    .dataTables_scrollHeadInner table {
      width: 100% !important;    
    }     
</style>

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
                <label class="control-label">Tanggal B/L<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('periode', !empty($default->TGLAWAL) ? $default->TGLAWAL : '', 'class="span4 cek_edit_cmb form_datetime" placeholder="Pilih Tanggal Bill of Lading" id="periode"'); ?>
                    <?php echo form_hidden('periode_edit', !empty($default->TGLAWAL) ? $default->TGLAWAL : '', 'id="periode_edit"'); ?>
                    <?php echo form_hidden('IDGROUP', !empty($default->IDGROUP) ? $default->IDGROUP : '', 'id="IDGROUP"'); ?>
                    <?php echo form_hidden('PIDGROUP', !empty($default->PIDGROUP) ? $default->PIDGROUP : '', 'id="PIDGROUP"'); ?>
                    <input type="hidden" name="tgl" id="tgl" class="form_datetime">
                    <input type="hidden" name="stat" id="stat" value="<?php echo !empty($stat) ? $stat : 'add' ?>">                    
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Referensi Kurs<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('JENIS_KURS', $opsi_jns_kurs, !empty($default->JNS_KURS) ? $default->JNS_KURS : '', 'class="form-control span4 cek_edit_cmb" id="JENIS_KURS" '); ?>
                </div>
            </div>    

            <div class="control-group">
                <label for="control-label" class="control-label" id="up_nama">Upload File (Max 10 MB) : </label> 
                <div class="controls" id="up_file">
                        <input type="file" id="PATH_FILE_IN" name="PATH_FILE"/>
                </div>
                <input type="hidden" name="PATH_FILE_EDIT" value="<?php echo !empty($default->PATH_FILE) ? $default->PATH_FILE : ''?>">
            </div>

            <div class="control-group">
                <label for="control-label" class="control-label"> </label> 
                <!-- dokumen -->
                <?php  
                    if ($this->laccess->is_prod()){ ?>
                        <div class="controls" id="dokumen">
                            <a href="javascript:void(0);" id="lihatdoc" onclick="lihat_dokumen(this.id)" data-modul="KONTRAKPEMASOK" data-url="<?php echo $url_getfile;?>" data-filename="<?php echo !empty($default->PATH_FILE) ? $default->PATH_FILE : '';?>"><b><?php echo (empty($default->PATH_FILE)) ? $default->PATH_FILE : 'Lihat Dokumen'; ?></b></a>
                        </div> 
                <?php } else { ?>
                        <div class="controls" id="dokumen">
                            <a href="<?php echo base_url().'assets/upload/kontrak_pemasok/'.$default->PATH_FILE;?>" target="_blank"><b><?php echo (empty($default->PATH_FILE)) ? $default->PATH_FILE : 'Lihat Dokumen'; ?></b></a>
                        </div>
                <?php } ?>
                <!-- end dokumen -->
            </div>                    

            <div class="control-group">
                <label class="control-label">No PJBBBM<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('NOPJBBM_KONTRAK_PEMASOK', !empty($default->NOPJBBM) ? $default->NOPJBBM : '', 'class="span3" placeholder="No PJBBBM" id="NOPJBBM_KONTRAK_PEMASOK" readonly'); ?>
                    <?php 
                        if ($id==''){
                            echo anchor(null, '<i class="icon-zoom-in"></i> Cari  ', array('id' => 'btnCari', 'class' => 'btn green'));                        
                        } 
                     ?>   
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Pemasok<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_dropdown('ID_PEMASOK', $pemasok, !empty($default->KODE_PEMASOK) ? $default->KODE_PEMASOK : '', 'class="form-control span4" id="ID_PEMASOK" onchange="ganti_form(this.value);" disabled'); ?>
                    <?php echo form_hidden('pemasok', !empty($default->KODE_PEMASOK) ? $default->KODE_PEMASOK : '', 'id="pemasok" readonly'); ?>
                </div>
            </div>

            <div class="control-group">
                <label  class="control-label">Skema Insidentil : </label>
                <div class="controls">
                    <?php echo form_dropdown('CMB_SKEMA_ISIDENTIL', $jns_isidentil_options, !empty($default->SKEMA) ? $default->SKEMA : '', 'class="span2" id="CMB_SKEMA_ISIDENTIL" disabled'); ?>
                    <?php echo form_hidden('SKEMA_ISIDENTIL', !empty($default->SKEMA) ? $default->SKEMA : '', 'class="span2" placeholder="Skema Insidentil" id="SKEMA_ISIDENTIL"'); ?>
                </div>
            </div>

            <div id="divKetKoreksiAdd" hidden>
                <hr>
                <div class="control-group">
                    <label class="control-label">Keterangan Koreksi<span class="required">*</span> : </label>
                    <div class="controls">
                        <?php
                            $data = array(
                              'name'        => 'ket',
                              'id'          => 'ket',
                              'value'       => !empty($default->KET_KOREKSI) ? $default->KET_KOREKSI : '',
                              'rows'        => '4',
                              'cols'        => '10',
                              'class'       => 'span11',
                              'style'       => '"none" placeholder=""'
                            );
                          echo form_textarea($data);
                        ?>                    
                    </div>
                </div>
            </div>
            <br>
            <div class="control-group" hidden>
                <label class="control-label">Jumlah Pengiriman<span class="required">*</span> : </label>
                <div class="controls">
                    <?php echo form_input('JML_KIRIM', !empty($default->JML_KIRIM) ? $default->JML_KIRIM : '', 'class="span2" placeholder="Ketik Jumlah" id="JML_KIRIM" '); ?>
                </div>
            </div>
            <br>           
            <div class="content_table">
                <div class="well-content clearfix">
                        <div id='TextBoxesGroup'>
                            <div id="TextBoxDiv0">
                                <!-- <div class="form_row">
                                    <div class="pull-left">
                                        <label for="password" class="control-label">Tgl Kirim ke : 1</label>
                                        <div class="controls">
                                            <input type='text' id='textbox1' class="input-append date form_datetime">
                                        </div>
                                    </div>
                                    <div class="pull-left">
                                        <label for="password" class="control-label">Volume (L) ke : 1</label>
                                        <div class="controls">
                                            <input type='text' id='textbox1' class="input-append date form_datetime">
                                        </div>
                                    </div>
                                </div><br>  -->   
                            </div>
                        </div>
                        <?php echo anchor(null, '<i class="icon-circle-arrow-left"></i> Tutup', array('id' => 'button-back-atas', 'class' => 'btn', 'onclick' => 'close_form(this.id)')); ?>
                        <?php echo anchor(null, '<i class="icon-paste"></i> Hitung Harga', array('id' => 'btn_hitung', 'class' => 'btn green', 'style' =>'display: none;')); ?>

                        <input type='button' value='Add Button' id='addButton' style='display: none;'>
                        <input type='button' value='Remove Button' id='removeButton' style='display: none;'>
                        <input type='button' value='Get TextBox Value' id='getButtonValue' style='display: none;'>
                </div>
            </div><br>
            <hr>
            <?php
        echo form_close(); ?>
    </div>

    <div id="divLast">  
        <div style="float: left;width: 47%">      
            <div id="listdata" class="table-responsive"></div> 
        </div> 
        <div style="width: 6%">
            
        </div>
        <div style="float: right;width: 47%">      
            <div id="tabeldata" class="table-responsive"></div> 
        </div>    
    </div>

  <!-- Modal -->
  <div class="modal fade" id="modal_pencarian" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Pencarian Kontrak Pemasok</h4>
        </div>
        <div class="modal-body">
          <!-- <p>Some text in the modal.</p> -->
                <!-- <div id ="index-content" class="well-content no-search"> -->
                    <div class="well">
                        <div class="well-content clearfix">
                            <?php echo form_open_multipart('', array('id' => 'ffilter2')); ?>
                                <div class="form_row">
                                   <div class="pull-left">
                                        <label for="password" class="control-label">Kata Kunci : </label>
                                        <div class="controls">
                                            <!-- <br> -->
                                            <input type="text" name="kata_kunci" class="control-label span3">
                                        </div>
                                        
                                    </div>
                                    <div class="pull-left span2">
                                        <label for="password" class="control-label"></label>
                                        <div class="controls">
                                            <!-- <br> -->
                                            <!-- <button type="button" class="btn"><i class='icon-search'></i>Filter</button> -->
                                            <?php echo anchor(NULL, "<i class='icon-search'></i> Filter", array('class' => 'btn', 'id' => 'button-filter2')); ?>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            <?php echo form_close(); ?>
                         </div>    
                    </div> 
                    <div id="content_table2" data-source="<?php echo $data_sources_pencarian; ?>" data-filter="#ffilter2"></div>
                    <div>&nbsp;</div>
                <!-- </div> -->
                <!-- <div id="form-content2" class="well-content"></div> -->
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
      
    </div>
  </div>
    
</div>


<script type="text/javascript">
    var counter = 1;

    $('.rp').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    $('.des4').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 4,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });     

    $("#addButton").click(function () {
        if(counter>20){
                alert("Max 20 data yang diperbolehkan");
                return false;
        }

        var newTextBoxDiv = $(document.createElement('div'))
             .attr("id", 'TextBoxDiv' + counter);

        var cmb_regional ="<select class='form-control cls_reg' id='reg_ke"+ counter + "' name='reg_ke"+ counter + "' disabled>"+
        "<option value='' disabled selected>--Pilih Regional--</option>"+
        <?php if ($options_reg != '')
            { foreach ($options_reg as $row)
                 { ?>
                 "<option value='<?php echo $row['ID_REGIONAL']?>'> <?php echo $row['NAMA_REGIONAL'] ?></option>"+
                 <?php
                  }
            }?>
           "</select>";

        var cmb_level1 = "<select class='form-control cls_lv1' id='cmblv1_ke"+ counter + "' name='cmblv1_ke"+ counter + "' disabled><option value='' disabled selected>--Pilih Level 1--</option></select>";
        var cmb_level2 = "<select class='form-control cls_lv2' id='cmblv2_ke"+ counter + "' name='cmblv2_ke"+ counter + "' disabled><option value='' disabled selected>--Pilih Level 2--</option></select>";
        var cmb_level3 = "<select class='form-control cls_lv3' id='cmblv3_ke"+ counter + "' name='cmblv3_ke"+ counter + "' disabled><option value='' disabled selected>--Pilih Level 3--</option></select>";
        var cmb_level4 = "<select class='form-control' id='cmblv4_ke"+ counter + "' name='cmblv4_ke"+ counter + "' disabled><option value='' disabled selected>--Pilih Pembangkit--</option></select>";

        var spasi = '&nbsp;&nbsp;&nbsp;';

        var text_alpha = '<span style="display:inline-block">'+
                         '<label for="ak_alpha_ke'+counter+'" style="display:block">Alpha</label>'+
                         '<input type="text" name="ak_alpha_ke'+counter+'" class="form-control rp cek_edit" style="width: 75px" placeholder="Alpha" id="ak_alpha_ke'+counter+'" value="<?php echo !empty($default->ALPHAHSD) ? $default->ALPHAHSD : ''?>" disabled>'+ '<bil id="bil_ke'+counter+'" hidden>%</bil>'+
                         '</span>';

        var text_persen = '<span style="display:inline-block">'+
                          '<label for="bilangan_ke'+counter+'" style="display:block"></label>'+
                          '<select class="form-control" style="width: 50px" id="bilangan_ke'+counter+'" name="bilangan_ke'+counter+'" style="display: none" disabled>'+
                                '<option value="1">$</option>'+
                                '<option value="0">%</option>'+
                          '</select>'+
                          '</span>';

        var text_sulfur = '<span style="display:inline-block">'+
                          '<label for="ak_sulfur_ke'+counter+'" style="display:block">Sulfur</label>'+
                          '<input type="text" name="ak_sulfur_ke'+counter+'" class="form-control rp cek_edit" placeholder="Sulfur" style="width: 75px" id="ak_sulfur_ke'+counter+'" value="<?php echo !empty($default->SULFURHSD) ? $default->SULFURHSD : ''?>" disabled>%'+
                          '</span>';

        var text_konversi = '<span style="display:inline-block">'+
                            '<label for="ak_konversi_ke'+counter+'" style="display:block">Konversi (L)</label>'+
                            '<input type="text" name="ak_konversi_ke'+counter+'" class="form-control rp cek_edit" placeholder="Konversi" style="width: 80px" id="ak_konversi_ke'+counter+'" value="<?php echo !empty($default->KONVERSI_HSD) ? $default->KONVERSI_HSD : ''?>" disabled>'+
                            '</span>';
       
        var text_oat = '<span style="display:inline-block">'+
                       '<label for="ak_oa_ke'+counter+'" style="display:block">OAT</label>'+
                       '<input type="text" name="ak_oa_ke'+counter+'" class="form-control rp cek_edit" placeholder="OAT" style="width: 70px" id="ak_oa_ke'+counter+'" value="<?php echo !empty($default->OAT) ? $default->OAT : ''?>" disabled>'+
                       '<input type="hidden" name="id_edit_ke'+counter+'" id="id_edit_ke'+counter+'" >'+
                       '<input type="hidden" name="id_koreksi_ke'+counter+'" id="id_koreksi_ke'+counter+'" >'+
                       '</span>';

        var sloc = '<input type="hidden" name="sloc_ke'+counter+'" id="sloc_ke'+counter+'">';
        var idtrans = '<input type="hidden" name="idtrans_ke'+counter+'" id="idtrans_ke'+counter+'">';
        var check_pilih = '<input type="checkbox" name="pilih_ke'+counter+'" value="0" id="pilih_ke'+counter+'" class="set_check cek_edit_cmb"> <b>Checklist Hitung Insidentil</b>'+sloc+idtrans; 



        var visi = '<div class="form_row">'+
        '<div class="pull-left"><label for="password" class="control-label">Regional ke : '+ counter + '</label>'+
        '<div class="controls">'+cmb_regional+'</div></div>'+
        '</div><br>'+
        '<div class="form_row">'+
        '<div class="pull-left"><label for="password" class="control-label">Level 1 ke : '+ counter + '</label>'+
        '<div class="controls">'+cmb_level1+'</div></div>'+
        '<div class="pull-left span1"><label for="password" class="control-label">Level 3 ke : '+ counter + '</label>'+
        '<div class="controls">'+cmb_level3+'</div></div>'+
        '</div><br>'+
        '<div class="form_row">'+
        '<div class="pull-left"><label for="password" class="control-label">Level 2 ke : '+ counter + '</label>'+
        '<div class="controls">'+cmb_level2+'</div></div>'+
        '<div class="pull-left span1"><label for="password" class="control-label">Pembangkit ke : '+ counter + '</label>'+
        '<div class="controls">'+cmb_level4+'</div></div>'+
        '</div><br><br>'+

        '<div class="form_row">'+
        '<div class="pull-left"><label for="password" class="control-label">HSD ke : '+ counter + '</label>'+
        '<div class="controls">'+text_alpha+text_persen+spasi+text_sulfur+spasi+text_konversi+spasi+text_oat+'</div></div><br><br>'+

        '<div class="controls pull-right span3">'+check_pilih+'</div></div>'+

        '</div><hr>';

        newTextBoxDiv.after().html(visi);
        newTextBoxDiv.appendTo("#TextBoxesGroup");
        $('#JML_KIRIM').val(counter);
        // $('html, body').animate({scrollTop: $("#divLast").offset().top}, 1000);
        counter++;
    });

    $("#removeButton").click(function () {
        if(counter==1){
            //alert("No more textbox to remove");
            return false;
        }

        counter--;
        $('#JML_KIRIM').val(counter-1);
        $("#TextBoxDiv" + counter).remove();
    });

    $("#getButtonValue").click(function () {
        var msg = '';
        for(i=1; i<counter; i++){
            msg += "\n Textbox #" + i + " : " + $('#tgl_ke' + i).val();
        }
        alert(msg);
    });

    $("#button-jml-kirim").click(function () {
        var x = $('#JML_KIRIM').val(); 

        if(x>31){
            var message = '<div class="box-title" style="color:#ac193d;"><i class="icon-remove-sign"></i> Max 31 data jumlah pengiriman yang diperbolehkan</div>';
            bootbox.alert(message, function() {});
            $('#JML_KIRIM').val('31');
        }

        for (i = 1; i <= 31; i++) {
            $("#TextBoxDiv"+i).hide();
        }

        for (i = 1; i <= x; i++) {
            $("#TextBoxDiv"+i).show();

        }
        setHitungKirim();
    });

    for (i = 0; i < 20; i++) {
        $("#addButton").click();
    }

    for (i = 1; i <= 20; i++) {

        $('input[name=ak_alpha_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 5,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
        });

        $('input[name=ak_sulfur_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
        });

        $('input[name=ak_konversi_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 4,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
        });

        $('input[name=ak_oa_ke'+i+']').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 2,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
        });

        $("#TextBoxDiv"+i).hide();
    }

    counter = 1;
    $('#JML_KIRIM').val(0);

    $("#button-save").click(function () {
        $("#button-jml-kirim").click();
    });

    $(".form_datetime").datepicker({
        format: "yyyy-mm-dd",
        autoclose: true,
        todayBtn: true,
        pickerPosition: "bottom-left"
    });
    
    $('input[name=JML_KIRIM]').inputmask("numeric", {radixPoint: ",",groupSeparator: ".",digits: 0,autoGroup: true,prefix: '',rightAlign: false,allowMinus: false, oncleared: function () { self.Value(''); }
    });

    function get_mops_kurs(id){ 
        var data_kirim = 'vidtrans='+id;
        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_mops_kurs_akr_kpm/";
        if(id){
            bootbox.hideAll();
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
            type: 'POST',
            url: urlna,
            data: data_kirim,
                error: function(data) {
                    bootbox.hideAll();
                    alert('Proses get_mops_kurs gagal');
                },
                success: function(data) {
                    $('#tabeldata').html(data);
                    bootbox.hideAll();
                }    
            })
        }
    }

    function get_mops_kurs_edit(id){ 
        var data_kirim = 'vidtrans='+id;
        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_mops_kurs_akr_kpm_edit/";
        if(id){
            bootbox.hideAll();
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
            type: 'POST',
            url: urlna,
            data: data_kirim,
                error: function(data) {
                    bootbox.hideAll();
                    alert('Proses get_mops_kurs gagal');
                },
                success: function(data) {
                    $('#tabeldata').html(data);
                    bootbox.hideAll();
                }    
            })
        }
    }

    function get_mops_kurs_ulang(id){ 
        var data_kirim = 'vidtrans='+id;
        var urlna ="<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_mops_kurs_akr_kpm_ulang/";
        if(id){
            bootbox.hideAll();
            bootbox.modal('<div class="loading-progress"></div>');
            $.ajax({
            type: 'POST',
            url: urlna,
            data: data_kirim,
                error: function(data) {
                    bootbox.hideAll();
                    alert('Proses get_mops_kurs gagal');
                },
                success: function(data) {
                    $('#tabeldata').html(data);
                    bootbox.hideAll();
                }    
            })
        }
    }

    $('#PATH_FILE_IN').change(function(){
        var clone = $(this).clone();
        clone.attr('id', 'PATH_FILE');
        $('#PATH_FILE_AREA').html(clone);
    });

    function get_hitung_harga() {        
      var url = "<?php echo base_url() ?>data_transaksi/perhitungan_harga_non/get_hitung_harga_all/";
      // bootbox.confirm('Anda yakin akan upload file ?', "Tidak", "Ya", function(e) {
        // if(e){
          bootbox.modal('<div class="loading-progress"></div>');

            $('#finput').ajaxSubmit({
                url: url,
                beforeSubmit: function(a, f, o) {
                        o.dataType = 'json';
                    },
                error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                success: function(data) {
                    bootbox.hideAll();

                    var icon = 'icon-remove-sign'; var color = '#ac193d;';
                    var message = '';
                    var content_id = data[3];
                    if (data[0]) {
                        icon = 'icon-ok-sign';
                        color = '#0072c6;';
                    }

                    message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                    message += data[2];

                    bootbox.alert(message, function() {
                        if (content_id){
                            $('#button-back-atas').hide();
                            $('#listdata').html(data[4]);
                            get_mops_kurs(data[5]);

                            var clone = $('#PATH_FILE_IN').clone();
                            clone.attr('id', 'PATH_FILE');
                            $('#PATH_FILE_AREA').html(clone);

                            $('html, body').animate({scrollTop: $("#divLast").offset().top}, 1000);
                            // $('#btn_simpan').show();
                            // alert('ok');
                            // console.log(data[4]);    
                            // alert(data);
                        }
                    });
                }   
            });
        // }
      // });
    }

    function get_hitung_harga_edit(){ 
        // bootbox.confirm('Apakah yakin akan proses perhitungan harga ?', "Tidak", "Ya", function(e) {
        //     if(e){
                // $('#stat').val('view');
                var data_kirim = $("#finput").serialize();

                var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_hitung_harga_edit/";

                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                type: 'POST',
                url: url,
                data: data_kirim,
                dataType:'json',
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function(data) {
                        bootbox.hideAll();

                        var icon = 'icon-remove-sign'; var color = '#ac193d;';
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }

                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        // bootbox.alert(message, function() {
                            if (content_id){
                                $('#listdata').html(data[4]);
                                get_mops_kurs_edit(data[5]);
                                $('html, body').animate({scrollTop: $("#divLast").offset().top}, 1000);
                                // $('#btn_simpan').show();
                                // alert('ok');
                                // console.log(data[4]);    
                                // alert(data);
                            }
                        // });
                    }    
                })
        //     }
        // });
    }  

    function get_hitung_harga_ulang(){ 
        // bootbox.confirm('Apakah yakin akan proses perhitungan harga ?', "Tidak", "Ya", function(e) {
        //     if(e){
                // $('#stat').val('edit');
                var data_kirim = $("#finput").serialize();

                var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_hitung_harga_all_ulang/";

                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                type: 'POST',
                url: url,
                data: data_kirim,
                dataType:'json',
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function(data) {
                        bootbox.hideAll();

                        var icon = 'icon-remove-sign'; var color = '#ac193d;';
                        var message = '';
                        var content_id = data[3];
                        if (data[0]) {
                            icon = 'icon-ok-sign';
                            color = '#0072c6;';
                        }

                        message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> ' + data[1] + '</div>';
                        message += data[2];

                        bootbox.alert(message, function() {
                            if (content_id){
                                $('#listdata').html(data[4]);
                                get_mops_kurs_ulang(data[6]);

                                var clone = $('#PATH_FILE_IN').clone();
                                clone.attr('id', 'PATH_FILE');
                                $('#PATH_FILE_AREA').html(clone);

                                $('html, body').animate({scrollTop: $("#divLast").offset().top}, 1000);
                                // $('#btn_simpan').show();
                                // alert('ok');
                                // console.log(data[4]);    
                                // alert(data);
                            }
                        });
                    }    
                })
        //     }
        // });
    }  

    function pilih_kontrak(vid){
        $('#modal_pencarian').modal('toggle');
        // alert('kontrak dipilih = '+vid);
        get_detail(vid);
    }

    function get_detail(vid){ 
        // bootbox.confirm('Apakah yakin akan proses perhitungan harga ?', "Tidak", "Ya", function(e) {
        //     if(e){
                var data_kirim = "vid="+vid+"&TGLAWAL="+$('#periode').val();

                var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_detail/";

                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                type: 'POST',
                url: url,
                data: data_kirim,
                dataType:'json',
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function(data) {
                        bootbox.hideAll();

                    
                        if (data.length==0){
                            msgGagal('Data tidak ditemukan');
                            return;
                        }

                        for (i = 1; i <= 20; i++) {
                            $("#TextBoxDiv"+i).hide();
                        }

                        var x = 0;
                        $('#JML_KIRIM').val(x);
                        
                        $.each(data, function () {
                            $("#NOPJBBM_KONTRAK_PEMASOK").val(this.NOPJBBM_KONTRAK_PEMASOK);
                            $('#ID_PEMASOK').val(this.KODE_PEMASOK);
                            $('#pemasok').val(this.KODE_PEMASOK);

                            //detail
                            x++;
                            $("#reg_ke"+x).empty();
                            $("#reg_ke"+x).append('<option value="'+ this.ID_REGIONAL +'">'+ this.NAMA_REGIONAL +'</option>');
                            $("#cmblv1_ke"+x).empty();
                            $("#cmblv1_ke"+x).append('<option value="'+ this.COCODE +'">'+ this.LEVEL1 +'</option>'); 
                            $("#cmblv2_ke"+x).empty();
                            $("#cmblv2_ke"+x).append('<option value="'+ this.PLANT +'">'+ this.LEVEL2 +'</option>'); 
                            $("#cmblv3_ke"+x).empty();
                            $("#cmblv3_ke"+x).append('<option value="'+ this.STORE_SLOC +'">'+ this.LEVEL3 +'</option>'); 
                            $("#cmblv4_ke"+x).empty();
                            $("#cmblv4_ke"+x).append('<option value="'+ this.SLOC +'">'+ this.LEVEL4 +'</option>'); 

                            if (this.TIPE_ALPHA=='$'){
                                // alert('1');
                                $("#bilangan_ke"+x).val('1');    
                            } else {
                                // alert('0');
                                $("#bilangan_ke"+x).val('0');
                            }

                            if (this.KODE_PEMASOK=='002'){
                                $('#bilangan_ke'+x).show();
                            } else {
                                $('#bilangan_ke'+x).hide();
                            }

                            $("#ak_alpha_ke"+x).val(this.ALPHA_HSD);
                            $("#ak_sulfur_ke"+x).val(this.SULFUR_HSD);
                            $("#ak_konversi_ke"+x).val(this.KONVERSI_HSD);
                            $("#ak_oa_ke"+x).val(this.ONGKOS_ANGKUT);
                            $("#id_edit_ke"+x).val(this.IDTRANS);
                            $("#id_koreksi_ke"+x).val(this.IDKOREKSI);
                            $("#SKEMA_ISIDENTIL").val(this.SKEMA_ISIDENTIL);  
                            $("#CMB_SKEMA_ISIDENTIL").val(this.SKEMA_ISIDENTIL);
                            $("#sloc_ke"+x).val(this.SLOC);
                            $("#idtrans_ke"+x).val(this.IDTRANS);

                            $("#pilih_ke"+x).val(0);
                            $("#pilih_ke"+x).prop('checked', false);

                            $("#TextBoxDiv"+x).show();                                                        
                        });    
                        $('#button-save-hitung').hide();
                        $('#JML_KIRIM').val(x);
                        $("#btn_hitung").show();  
                        $('html, body').animate({scrollTop: $("#up_file").offset().top}, 1000);                  
                    }    
                })
        //     }
        // });
    } 

    // get_detail_edit($('#NOPJBBM_KONTRAK_PEMASOK').val());
    function get_detail_edit(vid){ 
        // bootbox.confirm('Apakah yakin akan proses perhitungan harga ?', "Tidak", "Ya", function(e) {
        //     if(e){
                var data_kirim = "vid="+vid+"&TGLAWAL="+$('#periode').val();

                var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_detail_edit/";

                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                type: 'POST',
                url: url,
                data: data_kirim,
                dataType:'json',
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function(data) {
                        bootbox.hideAll();
                        var x = 0;
                        var JNS_KURS=0;
                        $.each(data, function () {
                            $("#NOPJBBM_KONTRAK_PEMASOK").val(this.NOPJBBM_KONTRAK_PEMASOK);
                            // $('#ID_PEMASOK').val(this.KODE_PEMASOK);
                            // $('#pemasok').val(this.KODE_PEMASOK);
                            JNS_KURS = this.JNS_KURS;
                            
                            //detail
                            x++;
                            $("#reg_ke"+x).empty();
                            $("#reg_ke"+x).append('<option value="'+ this.ID_REGIONAL +'">'+ this.NAMA_REGIONAL +'</option>');
                            $("#cmblv1_ke"+x).empty();
                            $("#cmblv1_ke"+x).append('<option value="'+ this.COCODE +'">'+ this.LEVEL1 +'</option>'); 
                            $("#cmblv2_ke"+x).empty();
                            $("#cmblv2_ke"+x).append('<option value="'+ this.PLANT +'">'+ this.LEVEL2 +'</option>'); 
                            $("#cmblv3_ke"+x).empty();
                            $("#cmblv3_ke"+x).append('<option value="'+ this.STORE_SLOC +'">'+ this.LEVEL3 +'</option>'); 
                            $("#cmblv4_ke"+x).empty();
                            $("#cmblv4_ke"+x).append('<option value="'+ this.SLOC +'">'+ this.LEVEL4 +'</option>'); 

                            // $("#bilangan_ke"+x).empty();
                            // $("#bilangan_ke"+x).append('<option value="'+ this.TIPE_ALPHA +'">'+ this.TIPE_ALPHA +'</option>');
                            // alert(this.TIPE_ALPHA);
                            if (this.TIPE_ALPHA=='$'){
                                // alert('1');
                                $("#bilangan_ke"+x).val('1');    
                            } else {
                                // alert('0');
                                $("#bilangan_ke"+x).val('0');
                            }

                            if (this.KODE_PEMASOK=='002'){
                                $('#bilangan_ke'+x).show();
                            } else {
                                $('#bilangan_ke'+x).hide();
                            }

                            $("#ak_alpha_ke"+x).val(this.ALPHA_HSD);
                            $("#ak_sulfur_ke"+x).val(this.SULFUR_HSD);
                            $("#ak_konversi_ke"+x).val(this.KONVERSI_HSD);
                            $("#ak_oa_ke"+x).val(this.ONGKOS_ANGKUT);
                            $("#id_edit_ke"+x).val(this.IDTRANS);
                            $("#id_koreksi_ke"+x).val(this.IDKOREKSI);
                            $("#sloc_ke"+x).val(this.SLOC);
                            $("#pilih_ke"+x).val(1);
                            $("#pilih_ke"+x).prop('checked', true);

                            $("#TextBoxDiv"+x).show();

                        });    
                        
                        if (JNS_KURS==1){
                            $('#JENIS_KURS').val(1);
                        } else {
                            $('#JENIS_KURS').val(0);    
                        }
                        // $('#JML_KIRIM').val(x);
                        // $("#btn_hitung").show();  
                        // $('html, body').animate({scrollTop: $("#up_file").offset().top}, 1000);    

                        get_detail_edit_nr(x);

                        // get_hitung_harga();              
                    }    
                })
        //     }
        // });
    } 

    function get_detail_edit_nr(x){ 
        // bootbox.confirm('Apakah yakin akan proses perhitungan harga ?', "Tidak", "Ya", function(e) {
        //     if(e){
                var data_kirim = "IDGROUP="+$('#IDGROUP').val()+"&PIDGROUP="+$('#PIDGROUP').val()+"&TGLAWAL="+$('#periode').val();

                var url = "<?php echo base_url()?>data_transaksi/perhitungan_harga_non/get_detail_edit_nr/";

                bootbox.modal('<div class="loading-progress"></div>');
                $.ajax({
                type: 'POST',
                url: url,
                data: data_kirim,
                dataType:'json',
                    error: function(data) {
                        bootbox.hideAll();
                        alert('Proses data gagal');
                    },
                    success: function(data) {
                        bootbox.hideAll();
                        // var x = 0;
                        var JNS_KURS=0;
                        $.each(data, function () {
                            JNS_KURS = this.JNS_KURS;
                            
                            //detail
                            x++;
                            $("#reg_ke"+x).empty();
                            $("#reg_ke"+x).append('<option value="'+ this.ID_REGIONAL +'">'+ this.NAMA_REGIONAL +'</option>');
                            $("#cmblv1_ke"+x).empty();
                            $("#cmblv1_ke"+x).append('<option value="'+ this.COCODE +'">'+ this.LEVEL1 +'</option>'); 
                            $("#cmblv2_ke"+x).empty();
                            $("#cmblv2_ke"+x).append('<option value="'+ this.PLANT +'">'+ this.LEVEL2 +'</option>'); 
                            $("#cmblv3_ke"+x).empty();
                            $("#cmblv3_ke"+x).append('<option value="'+ this.STORE_SLOC +'">'+ this.LEVEL3 +'</option>'); 
                            $("#cmblv4_ke"+x).empty();
                            $("#cmblv4_ke"+x).append('<option value="'+ this.SLOC +'">'+ this.LEVEL4 +'</option>'); 

                            // $("#bilangan_ke"+x).empty();
                            // $("#bilangan_ke"+x).append('<option value="'+ this.TIPE_ALPHA +'">'+ this.TIPE_ALPHA +'</option>');
                            // alert(this.TIPE_ALPHA);
                            if (this.TIPE_ALPHA=='$'){
                                // alert('1');
                                $("#bilangan_ke"+x).val('1');    
                            } else {
                                // alert('0');
                                $("#bilangan_ke"+x).val('0');
                            }

                            if (this.KODE_PEMASOK=='002'){
                                $('#bilangan_ke'+x).show();
                            } else {
                                $('#bilangan_ke'+x).hide();
                            }

                            $("#ak_alpha_ke"+x).val(this.ALPHA_HSD);
                            $("#ak_sulfur_ke"+x).val(this.SULFUR_HSD);
                            $("#ak_konversi_ke"+x).val(this.KONVERSI_HSD);
                            $("#ak_oa_ke"+x).val(this.ONGKOS_ANGKUT);
                            $("#id_edit_ke"+x).val(this.IDTRANS);
                            $("#id_koreksi_ke"+x).val(this.IDKOREKSI);
                            $("#sloc_ke"+x).val(this.SLOC);
                            // $("#pilih_ke"+x).val(1);
                            // $("#pilih_ke"+x).prop('checked', true);

                            $("#TextBoxDiv"+x).show();                                                        
                        });    
                        
                        if (JNS_KURS==1){
                            $('#JENIS_KURS').val(1);
                        } else {
                            $('#JENIS_KURS').val(0);    
                        }
                        $('#JML_KIRIM').val(x);
                        $("#btn_hitung").show();  
                        $('html, body').animate({scrollTop: $("#up_file").offset().top}, 1000);    

                        // get_hitung_harga();              
                    }    
                })
        //     }
        // });
    } 

    $("#btn_hitung").click(function () {
        bootbox.confirm('Apakah yakin akan proses perhitungan harga ?', "Tidak", "Ya", function(e) {
            if(e){
                if (($('#stat').val()=='add')||($('#stat').val()=='tambah_koreksi')){
                    get_hitung_harga();
                } else {
                    get_hitung_harga_ulang();
                    // alert('Proses hitung ulang masih dlm pengerjaan');
                }
            }
        });
    });

    $("#btnCari").click(function () {
        if ($('#periode').val()){
            $('#modal_pencarian').modal('show');    
        } else {
            msgGagal('Silahkan pilih Tanggal B/L terlebih dulu');    
        }
    });

    // $(".cls_alfa").on('keyup paste', function(e) {
    //     var cls_alfa = e.target.id;
    //     var vke = cls_alfa.split('_');
    //     var vcek = $( "#"+cls_alfa).val();

    //     alert('cls_alfa='+cls_alfa+'  vcek='+vcek);
    // });

    // jQuery(function($) {
        load_table('#content_table2', 1, '#ffilter2');

        $('#button-filter2').click(function() {
            load_table('#content_table2', 1, '#ffilter2');
        });
    // });
    $('#modal_pencarian').show();
    $('#modal_pencarian').hide();

    // alert('id='+$('input[name="id"]').val());

    if ($('input[name="id"]').val()){
        $('#button-back-atas').hide();
        // $('#stat').val('edit');
        // get_detail_edit($('input[name="id"]').val());
        // $('#periode').datepicker('update', $('#periode_edit').val());
        get_detail_edit($('#IDGROUP').val());  
        get_hitung_harga_edit();
    } 

    $('.cek_edit').on('keyup', function() {
        if ($('#button-save-hitung').show()){
            $('#button-save-hitung').hide();    
        }
    });

    $('.cek_edit_cmb').on('change', function() {
        if ($('#button-save-hitung').show()){
            $('#button-save-hitung').hide();    
        }
    });

    $('.set_check').on('change', function(){
       this.value = this.checked ? 1 : 0;
        // alert(this.value);
    }).change();

</script>


